<?php
ini_set("display_errors","On");
error_reporting(E_ALL);

$debug_acctoken = "AAAA-BBBB-CCCC-DDDD";
$debug_uname = "test@test.com";
$debug_passwd = "testpasswd";

$mysql_server = "192.168.1.7";
$mysql_port = 3306;
$mysql_user = "minecraftauth";
$mysql_passwd = "Platium!Calacidunma?";
$mysql_db = "minecraft";


$encypt_privkey = "";//加密所需私钥
$encypt_publkey = "";//加密所需公钥

spl_autoload_register("_autoload");

function _autoload($classname){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/" . strtolower($classname) . ".php";
}

$db = new DataBase();
?>