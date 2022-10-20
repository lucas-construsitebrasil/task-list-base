<?php

namespace App\Lib;


class Url
{

    static function redirect($url, $is301 = false, $outside = false)
    {
        if ($is301) {
            header("HTTP/1.1 301 Moved Permanently");
        }
        if ($outside) {
            header("location:" . $url);
        } else {
            header("location:" . URL_BASE . $url);
        }
        exit();
    }

    static function redirectOldCms($url, $isBaseCMS = false){
        $urlBase = URL_BASE_OLD;
        if($isBaseCMS){
            $urlBase = BASE_CMS;
        }
        self::redirect($urlBase . $url, false, true);
    }
    static function redirectNotSafeWithTime($url, $timeRedirect, $outside = false)
    {
        if ($outside) {
            header('Refresh: '.  $timeRedirect. '; URL=' . $url);
        } else {
            header('Refresh: '.  $timeRedirect. '; URL=' . URL_BASE . $url);
        }
    }


    public static function addFile($page, $data)
    {
        ob_start();
        require($page.'.php');
        return ob_get_clean();
    }

}
