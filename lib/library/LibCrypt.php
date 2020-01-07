<?php

class LibCrypt
{
    public static function encode($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(16);
        return $iv . urlencode(openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
    }

    public static function decode($string, $key)
    {
        $iv = substr($string, 0, 16);
        $string = substr($string, 16);
        return openssl_decrypt(urldecode($string), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }
}