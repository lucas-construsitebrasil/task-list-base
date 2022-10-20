<?php  
require_once 'config/config.php';

require __DIR__ . "/vendor/autoload.php";

\App\Lib\WebSite::run($map,$mapLoggedIn, $mapAjaxLoggedIn, $routesWhenSavingDoesNotClearTheCache);
