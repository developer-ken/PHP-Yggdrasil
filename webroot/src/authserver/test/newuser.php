<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";
$uname = $_GET["name"];
$passwd = $_GET["passwd"];
var_dump($db->adduser($uname,$passwd));
echo "name=".$uname.";passwd=".$passwd;
?>