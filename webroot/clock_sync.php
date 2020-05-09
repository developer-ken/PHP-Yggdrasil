<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";
header("100 OK");
var_dump($db->updateAllTokenState());
var_dump($db->updateAllSessionState());