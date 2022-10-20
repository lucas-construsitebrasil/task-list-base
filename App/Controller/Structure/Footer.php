<?php

namespace App\Controller\Structure;

use App\Controller\Controller;

class Footer extends Controller
{
    public function index()
    {
        $this->nameTemplate = 'structure/footer';
        $this->render();
    }

}
