<?php
ini_set("display_errors","On");
error_reporting(E_ALL);
include_once "../../includes.php";

$must_contain = array(
    "username","password"
);
$json = json_decode(file_get_contents('php://input'),true,10);
if($json == null) Exceptions::doErr(400,"IllegalArgumentException","Not a json string.",json_last_error());
foreach($must_contain as $v){
    if(!isset($json[$v])) Exceptions::doErr(400,"IllegalArgumentException","Request did not include required data.");
}

//参数检测结束
header("Content-Type: application/json; charset=utf-8");
if(!isset($json["clientToken"])) $cli_token = UUID::getUserUuid(uniqid());
else $cli_token = $json["clientToken"];
if(!isset($json["requestUser"])) $req_user = false;
else $req_user = $json["requestUser"];

$uuid_u = $db->getUserUUID($json["username"]);
$profile = $db->getProfileByOwner($uuid_u);
if(!$db->checkuserpasswd($json["username"],$json["password"])) Exceptions::doErr(403,"ForbiddenOperationException","Invalid credentials. Invalid username or password.");
$dataarr = array(
        "accessToken" => $db->presentToken($cli_token,$json["username"]),
        "clientToken" => $cli_token,
        "availableProfiles"=>array( // 用户的属性（数组，每一元素为一个属性）
            $profile->getArrayFormated()
        ),
        "selectedProfile"=>$profile->getArrayFormated()
        );

        if($req_user) $dataarr["user"] = (new User($json["username"],"",$uuid_u,"zh_CN"))->getArrayFormated();
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