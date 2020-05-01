<?php
class UUID{
    static function getProfileUuid($name) {//有"-"隔开
    $data = hex2bin(md5("OfflinePlayer:" . $name));
    //set the version to 3 -> Name based md5 hash
    $data[6] = chr(ord($data[6]) & 0x0f | 0x30);
    //IETF variant
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return createJavaUuid(bin2hex($data));
    }

    static function getUserUuid($name) {//无符号
        $data = hex2bin(md5("OfflinePlayer:" . $name));
        //set the version to 3 -> Name based md5 hash
        $data[6] = chr(ord($data[6]) & 0x0f | 0x30);
        //IETF variant
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return bin2hex($data);
    }
    
    static function createJavaUuid($striped) {
        //example: 069a79f4-44e9-4726-a5be-fca90e38aaf5
        $components = array(
            substr($striped, 0, 8),
            substr($striped, 8, 4),
            substr($striped, 12, 4),
            substr($striped, 16, 4),
            substr($striped, 20),
         );
        return implode('-', $components);
    }
}
?>