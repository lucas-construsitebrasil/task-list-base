<?php

namespace App;

class Factory {

    private static $classes = array(
        'Header' =>  '\App\Lib\HeaderAndFooter',
        'Styles' =>  '\App\Lib\Styles',
        'FriendlyUrl'=>  '\App\Lib\FriendlyUrl',
    );

    public static function create($class)
    {
        if (array_key_exists($class, self::$classes)) {
            $class = self::getNameClass($class);
            return new $class();
        }
        throw new \Exception($class . ' inexistente');
    }

    private static function getNameClass($class)
    {
        return self::$classes[$class];
    }
    
    
    public static function getInstance($class)
    {       
        if (array_key_exists($class, self::$classes)) {
            $class = self::getNameClass($class);
            return $class::getInstance();
        }
        throw new \Exception($class . ' inexistente');
    }


}
