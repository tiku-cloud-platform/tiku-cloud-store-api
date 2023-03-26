<?php
declare(strict_types = 1);

namespace App\Library\Encrypt;

class AesEncrypt
{
    /**
     * 加密方式
     * @var string
     */
    private static $cipher = "AES-128-CBC";

    /**
     * 加密key
     * @var string
     */
    private static $key = "";

    /**
     * 加解密向量
     * @var string
     */
    private static $iv = "";

    public static $aes;

    private function __construct()
    {
        self::$iv  = env("AES_IV", "");
        self::$key = env("AES_KEY", "");
    }

    public static function getInstance(): AesEncrypt
    {
        if (!self::$aes instanceof self) {
            self::$aes = new self();
        }
        return self::$aes;
    }

    /**
     * 加密数据
     * @param string $data 待加密字符
     * @return string 加密后的字符
     */
    public function aesEncrypt(string $data): string
    {
        return base64_encode(openssl_encrypt($data, self::$cipher, self::$key, 1, self::$iv));
    }

    /**
     * 解密数据
     * @param string $data 待解密字符
     * @return string 解密后的字符
     */
    public function aesDecrypt(string $data): string
    {
        $baseDecode = base64_decode($data);
        if ($baseDecode) {
            $decrypt = openssl_decrypt($baseDecode, self::$cipher, self::$key, 1, self::$iv);
            if ($decrypt) {
                return $decrypt;
            }
        }
        return "";
    }

    private function __sleep()
    {

    }

    private function __wakeup()
    {

    }

    private function __destruct()
    {

    }
}