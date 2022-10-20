<?php

/* Mapa de rotas para páginas logadas */

$mapLoggedIn = array(
    'home' => array('Home/Home', 'index'),
);

/* Mapa de rotas para páginas logadas via AJAX */

$mapAjaxLoggedIn = array(
);

/* Mapa de rotas para páginas NAO logadas */
$map = array(
    'login' => array('Login\Login', 'index'),
    'listagem-tarefas' => array('Task\Task', 'index'),

);
 