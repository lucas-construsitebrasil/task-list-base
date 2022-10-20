<?php

include_once 'configDatabase.php';
$dir = explode('/', __DIR__);
define('URL_BASE', "http://{$_SERVER['SERVER_NAME']}:9000/{$servBase[1]}/{$servBase[2]}/");
define('BASE_REQUIRE', "http://{$_SERVER['SERVER_NAME']}:9000/{$servBase[1]}/{$servBase[2]}/");
define('DIR_APP', "/var/www/html/produtos/task-list/");
define('BASE', "http://{$_SERVER['SERVER_NAME']}:9000/{$servBase[1]}/{$servBase[2]}/");
define('BASE_CMS', "http://{$_SERVER['SERVER_NAME']}:9000/{$servBase[1]}/{$servBase[2]}/");
define('EMAIL_LOGIN', 'noreply@enviarformularios.com.br');
define('EMAIL_PASSWORD', 'nd73n7329dn');
define('EMAIL_HOST', 'mail.enviarformularios.com.br');
define('CAMINHO_LOGO', "view/assets/images/logo.png");
define('CAMINHO_IMAGENS', BASE . "view/assets/images/");
define('NAME_APP', 'Lista de tarefas');
