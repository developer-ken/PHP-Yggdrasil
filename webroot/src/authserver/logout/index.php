<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";

$must_contain = array(
    "username","password"
);
$json = json_decode(file_get_contents('php://input'),true,10);
if($json == null) Exceptions::doErr(400,"IllegalArgumentException","Not a json string.");
foreach($must_contain as $v){
    if(!isset($json[$v])) Exceptions::doErr(400,"IllegalArgumentException","Request did not include required data.");
}
//参数检测结束
header("Content-Type: application/json; charset=utf-8");
if(!$db->checkuserpasswd($json["username"],$json["password"])) Exceptions::doErr(403,"ForbiddenOperationException","Invalid credentials. Invalid username or password.");
$db->killAllTokenByOwner($json["username"]);//该用户所有Token失效
header(Exceptions::$codes[204]);//校验通过，根据协议规定应当返回204
?>