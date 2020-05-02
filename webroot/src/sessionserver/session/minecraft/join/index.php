<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";
/*
{
	"accessToken":"令牌的 accessToken",
	"selectedProfile":"该令牌绑定的角色的 UUID（无符号）",
	"serverId":"服务端发送给客户端的 serverId"
}
*/

$must_contain = array(
    "accessToken","selectedProfile","serverId"
);
$json = json_decode(file_get_contents('php://input'),true,10);
if($json == null) Exceptions::doErr(400,"IllegalArgumentException","Not a json string.");
foreach($must_contain as $v){
    if(!isset($json[$v])) Exceptions::doErr(400,"IllegalArgumentException","Request did not include required data.");
}
//参数检测结束
header("Content-Type: application/json; charset=utf-8");

if(!$db->tokenExistsByAccid($json["accessToken"]))//accessToken错误
    Exceptions::doErr(403,"ForbiddenOperationException","Invalid token.","Token_Not_Exist");
if(!(isset($json["selectedProfile"])&&$db->checkTokenProfile($json["accessToken"],$json["selectedProfile"])))//profile绑定检查
    Exceptions::doErr(403,"ForbiddenOperationException","Invalid token.","Wrong_Profile_UUID");
if($db->getTokenState($json["accessToken"])<1)//令牌失效
    Exceptions::doErr(403,"ForbiddenOperationException","Invalid token.","Token_Not_Ready");

$db->putSession($json["serverId"],$json["accessToken"],$_SERVER['REMOTE_ADDR']);
header(Exceptions::$codes[204]);