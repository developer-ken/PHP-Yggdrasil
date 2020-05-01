<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";

$must_contain = array(
    "accessToken"
);
$json = json_decode(file_get_contents('php://input'),true,10);
if($json == null) Exceptions::doErr(400,"IllegalArgumentException","Not a json string.");
foreach($must_contain as $v){
    if(!isset($json[$v])) Exceptions::doErr(400,"IllegalArgumentException","Request did not include required data.");
}
//参数检测结束
header("Content-Type: application/json; charset=utf-8");

if(!isset($json["clientToken"])) $cli_token = UUID::getUserUuid(uniqid);
else $cli_token = $json["clientToken"];
if(!isset($json["requestUser"])) $req_user = false;
else $req_user = $json["requestUser"];


if(!$db->tokenExistsByAccid($json["accessToken"]))//accessToken错误
    Exceptions::doErr(403,"ForbiddenOperationException","Invalid token.");
if(!(isset($json["clientToken"])&&$db->checkToken($json["accessToken"],$json["clientToken"])))//clitoken错误
    Exceptions::doErr(403,"ForbiddenOperationException","Invalid token.");
if($db->getTokenState($json["accessToken"])<0)//令牌失效
    Exceptions::doErr(403,"ForbiddenOperationException","Invalid token.");

$owner_name = $db->getTokenOwnername($json["accessToken"]);
$uuid_u = $db->getUserUUID($owner_name);
$profile = $db->getProfileByOwner($uuid_u);
$db->setTokenState($json["accessToken"],-1);//旧Token失效
$acctoken = $db->presentToken($cli_token,$owner_name);
$db->profileBindToken($acctoken,$profile->UUID);
$dataarr = array(
        "accessToken" => $acctoken,
        "clientToken" => $cli_token,
        "availableProfiles"=>array( // 用户的属性（数组，每一元素为一个属性）
            $profile->getArrayFormated()
        ),
        "selectedProfile"=>$profile->getArrayFormated()
        );

        if($req_user) $dataarr["user"] = (new User($owner_name,"",$uuid_u,"zh_CN"))->getArrayFormated();
        /*
        {
            "accessToken":"令牌的 accessToken",
            "clientToken":"令牌的 clientToken",
            "availableProfiles":[ // 用户可用角色列表
                // ,... 每一项为一个角色（格式见 §角色信息的序列化）
            ],
            "selectedProfile":{
                // ... 绑定的角色，若为空，则不需要包含（格式见 §角色信息的序列化）
            },
            "user":{
                // ... 用户信息（仅当请求中 requestUser 为 true 时包含，格式见 §用户信息的序列化）
            }
        }
        */
echo json_encode($dataarr);
?>