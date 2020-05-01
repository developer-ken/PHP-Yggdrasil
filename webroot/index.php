<?php
include_once "includes.php";

header("Content-Type: application/json; charset=utf-8");

$retarr=array(
    "meta"=>$_meta,
    "skinDomains"=>$_skin_domains,
    "signaturePublickey"=>$encypt_publkey
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
?>