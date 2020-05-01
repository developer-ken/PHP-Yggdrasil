<?php
include_once "../../includes.php";

$json = json_decode(file_get_contents('php://input'),true,10);
if($json == null) Exceptions::doErr(400,"IllegalArgumentException","Not a json string.",json_last_error());
if(count($json)>10)Exceptions::doErr(400,"IllegalArgumentException","Json array too big.","Only 10 profiles can be checked at a time.");
$retarr=array();
foreach($json as $pname){
    $retarr[]=$db->getProfileByName($pname)->getArrayFormated();
}
header("Content-Type: application/json; charset=utf-8");
echo json_encode($retarr);
?>