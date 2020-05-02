<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";
$pfname = $_GET["username"];
$serverid = $_GET["serverId"];
if(isset($_GET["ip"]))$ip = $_GET["ip"];
else $ip = "NONE";
header("Content-Type: application/json; charset=utf-8");
if($db->checkSession($serverid,$pfname,$ip)){
    echo $db->getProfileByName($pfname);
    $db->closeSession($serverid);
}else if($ConsultMojangSessionServer){
	$opts = array(   
	  'http'=>array(   
		'method'=>"GET",   
		'timeout'=>10,
	   )   
	);    
    $officialresponse = file_get_contents("https://sessionserver.mojang.com/session/minecraft/hasJoined?username=".$pfname."&serverId=".$serverid.(($ip==null)?"":"&ip=".$ip),false,stream_context_create($opts));
    if(strlen($officialresponse)>2){
        echo $officialresponse;
    }else if($officialresponse == false){
		header(Exceptions::$codes[500]);//查询出错
	}else
    	header(Exceptions::$codes[204]);//无角色信息
}else
	header(Exceptions::$codes[204]);//无角色信息