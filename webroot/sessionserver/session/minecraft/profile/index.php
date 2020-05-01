<?php
include_once "../../../../includes.php";

header("Content-Type: application/json; charset=utf-8");
$uri = explode('/',$_SERVER["REQUEST_URI"]);
$uuid = $uri[count($uri)-1];
$unsigned = (isset($_GET["unsigned"])) ? ($_GET["unsigned"]=="true"):true;
$profile = $db->getProfile($uuid);
if($profile == false)header(Exceptions::$codes[204]);
else echo $profile;