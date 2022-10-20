<?php

namespace App\Lib;

class FriendlyUrl
{

    private $parametrosUrl, $parametrosGet;
    private static $instance;

    const MAX_QTD_POR_PARAM = 40;

    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new FriendlyUrl();
        }
        return self::$instance;
    }

    public function __construct($urlPage = false)
    {
        if ($urlPage == false) {
            $explode = (isset($_GET['pag'])) ? $_GET['pag'] : 'home';
            if (substr_count($explode, '/') > 0) {
                $explode_url = explode('/', $explode);
            } else {
                $explode_url['0'] = $explode;
            }
        } else {
            $explode_url = explode('/', $urlPage);
        }
        if (isset($explode_url['2']) && $explode_url['2'] == 'get') {
            $get = $explode_url['3'];
            $get = str_replace('|', '&', $get);
            parse_str($get, $getArray);
            $this->parametrosGet = $getArray;
        }
        $this->parametrosUrl = $explode_url;
    }

    public function getPage()
    {
        return $this->parametrosUrl['0'];
    }

    public static function transformString($palavra, $max = true)
    {
        $palavra = trim($palavra);
        $palavra = str_replace('/', '-', $palavra);
        $palavra = str_replace(' ', '-', $palavra);
        $palavra = str_replace('"', '', $palavra);
        $palavra = str_replace('&quot;', '', $palavra);


        $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüçÇ #$|?&';
        $to = 'AAAAEEIOOOUUCaaaaeeiooouucC-----e';
        $palavra = strtr($palavra, $from, $to);
        $palavra = preg_replace("/[^a-zA-Z0-9-]/", '', $palavra);
        $palavra = preg_replace("/\-\-+/", '-', $palavra);
        if ($max) {
            $palavra = substr($palavra, 0, self::MAX_QTD_POR_PARAM);
        }
        return strtolower($palavra);
    }

    function setParameter($indice, $val)
    {
        return $this->parametrosUrl[$indice] = $val;
    }

    function getParametersGet()
    {
        return $this->parametrosGet;
    }

    function getParameterGet($indice)
    {
        return isset($this->parametrosGet[$indice]) ? $this->parametrosGet[$indice] : '';
    }

    function getParameter($indice)
    {
        return isset($this->parametrosUrl[$indice]) ? $this->parametrosUrl[$indice] : '';
    }

    function getParameters()
    {
        return $this->parametrosUrl;
    }

    public function getParametersUntil($indice, $completar = '', $union = false)
    {
        $new = array_slice($this->parametrosUrl, 0, $indice);
        $diff = count($new) < $indice;
        if ($completar != '' & $diff > 0) {
            for ($i = 0; $i < $diff; $i++) {
                array_push($new, $completar);
            }
        }
        if ($union) {
            return self::transformToUrl($new);
        }
        return $new;
    }

    function getCompleteUrl()
    {
        return self::transformToUrl($this->parametrosUrl);
    }

    static function transformToUrl($arr, $valueInCaseOfEmpty = '', $max = true)
    {
        $url = array();
        foreach ($arr as $value) {
            if ($value != '') {
                $url[] = self::transformString($value, $max);
            } else {
                $url[] = $valueInCaseOfEmpty;
            }
        }
        return implode('/', $url);
    }

}
