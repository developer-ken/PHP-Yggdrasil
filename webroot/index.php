<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/src/includes.php";

if($_SERVER["REQUEST_URI"]!="/"){
    $requri = explode("?",$_SERVER["REQUEST_URI"])[0];
    include("src".$requri."/index.php");
}else{
    header("Content-Type: application/json; charset=utf-8");

    $retarr=array(
        "meta"=>$_meta,
        "skinDomains"=>$_skin_domains,
        "signaturePublickey"=>"-----BEGIN PUBLIC KEY-----\n".$encypt_publkey."\n-----END PUBLIC KEY-----"
    );

    echo json_encode($retarr);
    /*
    {
        "meta":{
            // 服务端的元数据，内容任意
        },
        "skinDomains":[ // 加入皮肤白名单的域名后缀
            "皮肤域名后缀 1"
            // ,...（可以有更多）
        ],
        "signaturePublickey":"用于验证数字签名的公钥"
    }
    */
}
?>