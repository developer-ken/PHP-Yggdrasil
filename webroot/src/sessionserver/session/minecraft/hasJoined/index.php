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
}else{
    header(Exceptions::$codes[204]);//无角色信息
}