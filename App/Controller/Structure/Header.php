<?php

namespace App\Controller\Structure;

use App\Controller\Controller;

class Header extends Controller
{
    public function index()
    {
        $this->nameTemplate = 'structure/header';
        $this->render();
    }

}
