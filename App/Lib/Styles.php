<?php

namespace App\Lib;

class Styles
{
    private $styles = array(), $addStylesWithMethod = array(), $addExternalStylesWithMethod = array();

    private static $instance;

    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Styles();
        }
        return self::$instance;
    }


    private function addExternalStyles($link)
    {
        $this->addExternalStylesWithMethod[] = $link;
    }

    public function addStyle($link, $externalStyle = false)
    {
        if ($externalStyle) {
            return $this->addExternalStyles($link);
        }
        $this->addStylesWithMethod[] = 'view/assets/css/' . $link . '.css';
    }

    public function getStyles()
    {
        $this->styles[] = 'view/assets/css/plugins/bootstrap.min.css';
        $this->styles[] = 'view/assets/css/plugins/font-awesome.css';
        $content = '';
        foreach ($this->styles as $name) {
            $content .= file_get_contents($name);
        }

        foreach ($this->addStylesWithMethod as $name) {
            $content .= file_get_contents($name);
        }

        foreach ($this->addStylesWithMethod as $name) {
            $content .= file_get_contents($name);
        }

        return  $this->getExernalCss() . '<style>' . $content . '</style>';
    }

    private function getExernalCss()
    {
        $content = '';
        foreach ($this->addExternalStylesWithMethod as $externalCss) {
            $content .= '<link rel="stylesheet" href="' . $externalCss . '">';
        }
        return $content;
    }
}
