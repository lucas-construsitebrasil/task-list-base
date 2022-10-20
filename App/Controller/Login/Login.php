<?php

namespace App\Controller\Login;

use App\Controller\Controller;

class Login extends Controller
{

    public function index(){
       $this->appendCss('login/style');
       if(!empty($_POST)){
        die("Implemente o Login");
       }
       $this->nameTemplate = 'login/index';
       $this->render();
    }
}
