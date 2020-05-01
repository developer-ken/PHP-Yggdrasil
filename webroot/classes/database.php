<?php
class Database{
    public $mysqli;
    function __construct(){
        global $mysql_server,$mysql_port,$mysql_user,$mysql_passwd,$mysql_db;
        $this->mysqli = new mysqli($mysql_server.":".$mysql_port, $mysql_user, $mysql_passwd, $mysql_db);
    }

    function query($cmd,$var){
        $stmt = $this->mysqli->prepare($cmd);
        $i=1;
        if($stmt==false){
            return false;
        }
        $typev = "";
        foreach ($var as $value){
            if(is_int($value))$typev.="i";
            else if(is_float($value))$typev.="f";
            else $typev.="s";
        }

        $tmp = array($typev);
        $var = array_merge($tmp,$var);

        call_user_func_array(array($stmt, 'bind_param'), $this->arr2refer($var)); 
        $stmt->execute();
        $r = $stmt->get_result();
        return $r->fetch_all();
    }

    function query_rolls($cmd,$var){
        $stmt = $this->mysqli->prepare($cmd);
        $i=1;
        if($stmt==false){
            echo $this->mysqli->error;
            return -1;
        }
        $typev = "";
        foreach ($var as $value){
            if(is_int($value))$typev.="i";
            else if(is_float($value))$typev.="f";
            else $typev.="s";
        }

        $tmp = array($typev);
        $var = array_merge($tmp,$var);

        call_user_func_array(array($stmt, 'bind_param'), $this->arr2refer($var)); 
        $stmt->execute();
        $r = $stmt->get_result();
        return $this->mysqli->affected_rows;
    }

    private function arr2refer($value) {
        $refs = array();
        foreach ($value as $k => $v) {
             $refs[$k] = &$value[$k];
        }
        return $refs;
   }

    function checkuserpasswd($username,$passwd){
        $encoded = sha1($username.$passwd."THIS IS SAULT");
        $ret = $this->query("SELECT * from Users where username = ? limit 1;",array($username));
        if(count($ret)!=1) return false;
        $correct_encoded = $ret[0][2];
        $succeed = ($encoded==$correct_encoded);
        if($succeed) $this->reguserlogin($username);
        return $succeed;
    }

    function getUserUUID($username){//约定：有效为1，暂时无效为0，失效为-1
        $ret = $this->query("SELECT * from Users where username = ? limit 1;",array($username));
        if(count($ret)!=1) return -1;
        //var_dump($ret);
        return $ret[0]["1"];
    }

    function reguserlogin($username){
        return $this->query_rolls("UPDATE Users SET lastlogin = NOW() WHERE username = ?;",array($username))>-1;
    }

    function checkTokenandPfid($access_token,$cli_token,$profile_id){
        $ret = $this->query("SELECT * from Tokens where accessToken = ? limit 1;",array($access_token));
        if(count($ret)!=1) return false;
        return ($cli_token == $ret[0][1] && $profile_id == $ret[0]["2"]);
    }

    function checkToken($access_token,$cli_token){
        $ret = $this->query("SELECT * from Tokens where accessToken = ? limit 1;",array($access_token));
        if(count($ret)!=1) return false;
        return ($cli_token == $ret[0][1]);
    }

    function checkTokenProfile($access_token,$profileuuid){
        $ret = $this->query("SELECT * from Tokens where accessToken = ? limit 1;",array($access_token));
        if(count($ret)!=1) return false;
        //var_dump($ret[0]);
        return ($profileuuid == $ret[0][2]);
    }

    function tokenExistsByAccid($access_token){
        $ret = $this->query("SELECT * from Tokens where accessToken = ? limit 1;",array($access_token));
        return (count($ret)==1);
    }

    function presentToken($cli_token,$username){
        $access_token = UUID::getUserUuid(uniqid().$username);
        return ($this->query_rolls("INSERT INTO Tokens (accessToken, clientToken, owner, ptimestamp) VALUES (?, ?, ?, NOW());",array($access_token,$cli_token,$username))>-1)?$access_token:false;
    }

    function profileBindToken($access_token,$profile_id){
        return $this->query_rolls("UPDATE Tokens SET profile = ? WHERE accessToken = ?;",array($profile_id,$access_token))>-1;
    }

    function getTokenState($access_token){//约定：有效为1，暂时无效为0，失效为-1
        $ret = $this->query("SELECT * from Tokens where accessToken = ? limit 1;",array($access_token));
        if(count($ret)!=1) return -1;
        return $ret[0][4];
    }

    function getTokenOwnername($access_token){
        $ret = $this->query("SELECT * from Tokens where accessToken = ? limit 1;",array($access_token));
        if(count($ret)!=1) return -1;
        return $ret[0][5];
    }

    function killAllTokenByOwner($owner){
        return $this->query_rolls("UPDATE Tokens SET state = -1 WHERE owner = ?;",array($owner));
    }
    
    function setTokenState($access_token,$state){
        return $this->query_rolls("UPDATE Tokens SET state = ? WHERE accessToken = ?;",array($state,$access_token))>-1;
    }

    function updateAllTokenState(){
        //30分前的token暂时失效，60分前的token永久失效；永久失效的Token被删除。
        $this->query_rolls("UPDATE Tokens SET state = ? WHERE DATE(ptimestamp) >= DATE_SUB(NOW(),INTERVAL 30 MINUTE);",array(0));
        $this->query_rolls("UPDATE Tokens SET state = ? WHERE DATE(ptimestamp) >= DATE_SUB(NOW(),INTERVAL 1 HOUR);",array(-1));
        return $this->query_rolls("delete from Tokens where state = ?;",array(-1))>-1;
    }

    function getProfile($cuuid){
        $ret = $this->query("SELECT * from Profiles where cuuid = ? limit 1;",array($cuuid));
        if(count($ret)!=1) return false;
        return new Profile($ret[0][2],$ret[0][0],$ret[0][3]);
    }

    function getProfileByName($pname){
        $ret = $this->query("SELECT * from Profiles where name = ? limit 1;",array($pname));
        if(count($ret)!=1) return false;
        return new Profile($ret[0][2],$ret[0][0],$ret[0][3]);
    }

    function getProfileByOwner($owner_uuid){
        $ret = $this->query("SELECT * from Profiles where owner = ? limit 1;",array($owner_uuid));
        if(count($ret)!=1) return false;
        return new Profile($ret[0][2],$ret[0][0],$ret[0][3]);
    }


    //会话相关//
    function putSession($serverid,$acctoken,$ipaddr){
        return ($this->query_rolls("INSERT INTO Sessions (serverID, accessToken, cli_ipaddr, opentime) VALUES (?, ?, ?, NOW());",array($serverid,$acctoken,$ipaddr))>-1);
    }

    function checkSession($serverid,$username,$ipaddr="NONE"){
        $ret = $this->query("SELECT * from Sessions where serverID = ? limit 1;",array($serverid));
        if(count($ret)!=1) return false;
        $owner_name = $this->getTokenOwnername($ret[0][1]);
        $owner_uuid = $this->getUserUUID($owner_name);
        $cuname = $this->getProfileByOwner($owner_uuid)->name;//效率低下的三次查询 >_<
        return (
            ($cuname == $username) &&
            ($ipaddr == "NONE" || $ipaddr == $ret[0][2])
        );
    }

    function updateAllSessionState(){
        //清除创建超过30S的会话
        return $this->query_rolls("delete from Tokens WHERE DATE(opentime) >= DATE_SUB(NOW(),INTERVAL 30 SECOND);",array());
    }

    function closeSession($sid){
        return $this->query_rolls("delete from Tokens WHERE serverID = ?;",array($sid));
    }

    //无用的//

    function setuserpasswd($username,$passwd){
        $encoded = sha1($username.$passwd."THIS IS SAULT");
        return $this->query_rolls("UPDATE Users SET passwd = ? WHERE username = ?;",array($encoded,$username))>-1;
    }

    function adduser($username,$passwd){
        $encoded = sha1($username.$passwd."THIS IS SAULT");
        $uuid = UUID::getUserUuid($username);
        return $this->query_rolls("INSERT INTO Users (userid, username, passwd, regtime) VALUES (?, ?, ?, NOW());",array($uuid,$username,$encoded))>-1;
    }

}