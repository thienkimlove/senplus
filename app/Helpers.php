<?php
/**
 * Created by PhpStorm.
 * User: tieungao
 * Date: 2020-08-26
 * Time: 11:08
 */

namespace App;

use Illuminate\Support\Facades\Cookie;

class Helpers
{
    public const COOKIE_MINUTES = 100;
    public const COOKIE_NAME = "send_plus";
    public const DOMAIN_SYSTEM = "bosana.vn";


    public static function setCookieLogin($email)
    {
        Cookie::queue(Cookie::make(self::COOKIE_NAME, $email, self::COOKIE_MINUTES, '/', '.'.self::DOMAIN_SYSTEM));
    }


    public static function deleteCookieLogin()
    {
        Cookie::queue(Cookie::make(self::COOKIE_NAME, '', self::COOKIE_MINUTES, '/',  '.'.self::DOMAIN_SYSTEM));
    }

    public static function getCookieLogin()
    {
        return Cookie::get(self::COOKIE_NAME);
    }

    public static function log($msg)
    {
        if (is_array($msg)) {
            $message = json_encode($msg, true);
        } else {
            $message = $msg;
        }
        @file_put_contents(storage_path('logs/debug.log'), $message . "\n", FILE_APPEND);
    }
}