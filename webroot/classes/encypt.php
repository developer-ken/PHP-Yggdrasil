<?php
class Encypt{
    //生成 sha1WithRSA 签名
    static function genSigniture($toSign){
        global $encypt_privkey;
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($encypt_privkey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        $key = openssl_get_privatekey($privateKey);
        openssl_sign($toSign, $signature, $key);
        openssl_free_key($key);
        $sign = base64_encode($signature);
        return $sign;
    }

    //校验 sha1WithRSA 签名
    static function verifySigniture($data, $sign){
        global $encypt_publkey;
        $sign = base64_decode($sign);
        $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
                    wordwrap($encypt_publkey, 64, "\n", true) .
                    "\n-----END PUBLIC KEY-----";
        $key = openssl_pkey_get_public($pubKey);
        $result = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1) === 1;
        return $result;
    }
}