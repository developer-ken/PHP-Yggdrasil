<?php
ini_set("display_errors","On");
error_reporting(E_ALL);

//mysql配置//
$mysql_server = "192.168.1.7";
$mysql_port = 3306;
$mysql_user = "minecraftauth";
$mysql_passwd = "Platium!Calacidunma?";
$mysql_db = "minecraft";

//站点配置//
$_meta = array(
    "serverName"=>"Yggdrasil的一个实现",//这里可以改成你希望的名字
    "implementationName"=>"mcpc-authserver",//不要修改
    "implementationVersion"=>"1.1"//不要修改
);

$_skin_domains = array(
    ".mcserver.fun"//这里改成你皮肤链接所用的域名
);

//加密配置//
$encypt_privkey = "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";//加密所需私钥
$encypt_publkey = "MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAxulQKd8aLySR9LUlSl54DpqV3NP8ZvpHGcDRCq0CcDSBpfZlVswvcfbHW6UlstlPN9/9rqqP7ft8/HIJVkosWgBZ2P+4jl7RzTvDGl3tl5PubLCrnBIXHplK+O1jQhy42ww9+4hwhruLmfOr6I4VLP5deyX6euKWikvs3p95QW7gVw0Tar2ArEi0n6o+pNJcYRBbKSjOK8LZ4UfiD1jKelDD0fyP8utk2Q/yZFEpkZaQVVuNyRZThOkhkcp46HHXGxE+wlJGDNiKVj2RlbdsBCNDk7EtpCXFBlV/HoPrCog2nVQGpWuiIxoDG2rHOZ8kc7aZvEcJucQhtUiSL6CSdIQANUuq6jhvQ5nRLxpeS2QnemZt7J18fVymTIaV/AAiDx3uROtfd3PWQKaSF5oCA5TzvQcgBeAmX1A/SBfxAj/i7BvfxGhfS3GysJnXwzdDG0pt8LP0gjvhCy8R9fCAk+/pMN49VLfM7hRjA4SR6jKkgOm0yEDlFhLrH1bnglYktcPiH00UxwHbx0bzewoqHBTyBhQpBIo3aNn4vvUxKriv6iSuY2NEgumZ3WrthoYCrkhDqWi+cGvPlEZiXWY6JVIHp3oN+Bu0YxofwEmYHuTw0Ph2N+6Ld3cMml84oDWphW+US005Yuq4QqfFpPRU0CVG+4SYrXYjbH0O059bBdUCAwEAAQ==";//加密所需公钥

//!! 不要修改下面的代码!! //
spl_autoload_register("_autoload");

function _autoload($classname){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/" . strtolower($classname) . ".php";
}

$db = new DataBase();
?>