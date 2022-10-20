<?php

namespace App\Controller\Task;

use App\Controller\Controller;

class Task extends Controller
{

    public function index()
    {
        $this->appendCss('tasks/style');
        $this->appendJs('tasks/taskDelete');
        $this->nameTemplate = 'tasks/listing';
        $this->render();
    }
}
