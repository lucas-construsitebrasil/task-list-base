<?php

namespace App\Lib;

class HeaderAndFooter
{

    private static $instance;
    private $title, $pureTitle;
    private $scripts = array('header' => array(), 'footer' => array());
    private $h1, $additionalInfo;

    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new HeaderAndFooter();
        }
        return self::$instance;
    }

    public function setTitle($title)
    {
        $this->pureTitle = $title;
        $this->title = $title . ' | ' . NAME_APP;
    }

    public function appendTitle($append)
    {
        $this->setTitle($this->getPureTitle() . $append);
    }

    function getPureTitle()
    {
        return $this->pureTitle;
    }

    public function getTitle()
    {
        return $this->title != '' ? $this->title : NAME_APP;
    }


    private function validateLocalScript($local)
    {
        if (!in_array($local, array('header', 'footer'))) {
            throw new \Exception('param @local deve ser header OU footer apenas');
        }
    }

    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
    }

    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    public function addScript($src, $local = 'footer', $type = 'text/javascript')
    {
        $this->validateLocalScript($local);
        $this->scripts[$local][] = array(
            'src' =>  BASE . 'view/assets/js/' . $src,
            'type' => $type
        );
    }

    public function addScriptExternal($src, $local = 'footer', $type = 'text/javascript')
    {
        $this->validateLocalScript($local);
        $this->scripts[$local][] = array(
            'src' => $src,
            'type' => $type
        );
    }

 
    public function getScripts($local = 'header')
    {
        $out = '';
        $this->validateLocalScript($local);
        if ($local == 'header') {
            $out .= '  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>';
            $out .= '<script type="text/javascript">WebFont.load({  google: {    families: ["Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic","Roboto:300,regular,500,700,900"]  }});</script>';
            $out .= '<script type="text/javascript" src="' . BASE . 'view/assets/js/plugins/jquery-1.9.1.min.js"></script>';
            $out .= '<script type="text/javascript" src="' . BASE . 'view/assets/js/plugins/jquery.validate.js"></script>';
            $out .= '<script type="text/javascript" src="' . BASE . 'view/assets/js/plugins/jquery.validate.additional-methods.js"></script>';
            $out .= '<script type="text/javascript" src="' . BASE . 'view/assets/js/plugins/sweetAlert2.js"></script>';
        }
        if ($local == 'footer') {
            $out .=  '<script type="text/javascript" src="' . BASE . 'view/assets/js/plugins/fontAwensome-5.1.js"></script>';
        }
        foreach ($this->scripts[$local] as $value) {
            $out .= '<script src="' . $value['src'] . '.js"' . '" type="' . $value['type'] . '"></script>';
        }


        return $out;
    }
}
