<?php
include_once "../../includes.php";
$uname = rand(1000,5000);
$passwd = rand(20000,40000);
var_dump($db->adduser($uname,$passwd));
echo "name=".$uname.";passwd=".$passwd;
?>