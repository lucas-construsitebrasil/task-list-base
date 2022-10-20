<?php

namespace App\Lib;


class WebSite
{

    public function __construct()
    {
        $this->model = new CategoriaModel();
    }
    static function getPagesJustLoggedIn()
    {
        return self::$pagesJustLoggedIn;
    }
    private static $mapUrl,
        $paginaMap,
        $ctlPage,
        $map, $pagesJustLoggedIn, $mapAjaxLoggedIn, $routesNotClearTheCache;

    static function getClassIdentifiers()
    {
        return self::$mapClassIdentifiers;
    }

    static function getMapUrl()
    {
        return self::$mapUrl;
    }

    static function run($map, $pagesJustLoggedIn, $mapAjaxLoggedIn, $routesNotClearTheCache)
    {
        self::$map = $map;
        self::$pagesJustLoggedIn = $pagesJustLoggedIn;
        self::$mapAjaxLoggedIn = $mapAjaxLoggedIn;
        self::$routesNotClearTheCache = $routesNotClearTheCache['nameRouteInConfigMapping'];
        $content = self::getContent($map);
        echo $content;
    }

    static function isLoggedIn(){
        return !empty($_SESSION['login']);
    }

    static function getContent($map)
    {
        if (self::isLoggedIn()) {
            $map = array_merge($map, self::$pagesJustLoggedIn);
            $map = array_merge($map, self::$mapAjaxLoggedIn);
        }
        $pagina = FriendlyUrl::getInstance()->getParameter(0);
        self::$paginaMap = isset($map[$pagina]) ? $map[$pagina] : '';
        $additionalParam = null;
        if (array_key_exists($pagina, $map)) {
            $nameClass = $map[$pagina]['0'];
            $nameMethod = $map[$pagina][1];
            $additionalParam = isset($map[$pagina][2]) ? $map[$pagina][2] : null;
        } else {
            if (array_key_exists($pagina, self::$pagesJustLoggedIn)) {
                Url::redirect('login/restrito');
            }
            die('Página não encontrada!');
        }

        $nameClass = '\App\Controller\\' . $nameClass;
        $controller = new $nameClass();
        $mapUrl = self::$mapUrl;
        self::$ctlPage = $controller;


        if ($additionalParam == null) {
            $controller->$nameMethod();
        } else {
            $controller->$nameMethod($additionalParam);
        }

        $content = self::$ctlPage->getOutput();

        if (!array_key_exists($pagina, self::$mapAjaxLoggedIn)) {
            if (!$controller->getJustMiddle()) {
                $controller = new \App\Controller\Structure\Header;
                $controller->index();
                $content = $controller->getOutput() . $content;
                $controllerFooter = new \App\Controller\Structure\Footer;
                $controllerFooter->index();
                $content .= $controllerFooter->getOutput();
            }
        }
        return $content;
    }

    static function getCtlPage()
    {
        return self::$ctlPage;
    }
}
