<?php
header("Content-Type: text/html; charset=UTF-8");
require_once 'configMapping.php';
define('DASH', false);
define('TRANSACTION_SUMMARY', false); 

if (\ConstrusiteDefault\ConstrusiteConfig::isLocalServer()) {
    $servBase = explode('/', $_SERVER['REQUEST_URI']);
    define('AMBIENTE', 'development');
    error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING ^ E_STRICT);
    ini_set("display_errors", 1);

} else {
    $servBase = explode('/', $_SERVER['REQUEST_URI']);
    define('AMBIENTE', 'production');
}
 

require_once 'configConstants.php';
session_start();
ob_start();

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    //$prefix = 'App\\Bar\\';
    $prefix = 'App';
 
    // base directory for the namespace prefix
    $base_dir = DIR_APP;

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    // get the relative class name
    $relative_class = '\\' . $class; //substr($class, $len);
    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    } else {
        return;
    }
});
