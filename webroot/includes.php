<?php
$debug_acctoken = "AAAA-BBBB-CCCC-DDDD";
$debug_uname = "test@test.com";
$debug_passwd = "testpasswd";
function __autoload($classname){
    require_once "/classes/" + strtolower($classname) + ".php";
}
?>