<?php

namespace Witty\LaravelDbBackup\Commands\Helpers;

use Illuminate\Support\Facades\Config;

/**
 * Class Encrypt
 * @package Witty\LaravelDbBackup\Commands\Helpers
 */
class Encrypt
{
    /**
     * @param $file
     * @return bool|string
     */
    public static function encryptFile($file)
    {

        if (!is_file($file)) {
            return false;
        }

        $content = file_get_contents($file);

        $encrypted = encrypt($content, Config::get('db-backup.encrypt.key'));

        file_put_contents($file, $encrypted);

        return true;
    }

    /**
     * @param $file
     * @return bool|mixed
     */
    public static function decryptFile($file)
    {

        if (!is_file($file)) {
            return false;
        }

        $content = file_get_contents($file);


        $decrypted = self::decryptContent($content);

        file_put_contents($file, $decrypted);

        return true;

    }

    /**
     * @param $content
     * @return mixed
     */
    public static function decryptContent($content)
    {

        return decrypt($content, Config::get('db-backup.encrypt.key'));

    }

    /**
     * @param $decrypted
     * @param $key
     * @return bool|string
     */
    function encrypt($decrypted, $key)
    {
        $ekey = hash('SHA256', $key, true);
        srand();
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
        if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $ekey, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
        return $iv_base64 . $encrypted;
    }

    /**
     * @param $encrypted
     * @param $key
     * @return bool|string
     */
    function decrypt($encrypted, $key)
    {
        $ekey = hash('SHA256', $key, true);
        $iv = base64_decode(substr($encrypted, 0, 22) . '==');
        $encrypted = substr($encrypted, 22);
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $ekey, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
        $hash = substr($decrypted, -32);
        $decrypted = substr($decrypted, 0, -32);
        if (md5($decrypted) != $hash) return false;
        return $decrypted;
    }
}