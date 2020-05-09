<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";
//https://sessionserver.mojang.com/session/minecraft/profile/
header("Content-Type: application/json; charset=utf-8");
$uri = explode('/',$_SERVER["REQUEST_URI"]);
$uuid = $uri[count($uri)-1];
$unsigned = (isset($_GET["unsigned"])) ? ($_GET["unsigned"]=="true"):true;
$profile = $db->getProfile($uuid);
if($profile == false && $ConsultMojangSessionServer){
	$opts = array(   
	  'http'=>array(   
		'method'=>"GET",   
		'timeout'=>15,
	   )   
	);    
    $officialresponse = file_get_contents("https://sessionserver.mojang.com/session/minecraft/profile/".$uuid,false,stream_context_create($opts));
    if(strlen($officialresponse)>2){
        echo $officialresponse;
    }else if($officialresponse == false){
		header(Exceptions::$codes[500]);//查询出错
	}else
    	header(Exceptions::$codes[204]);//无角色信息
}
else echo $profile;