<?php

namespace TestManager\Controller;

use App\Controller\AppController as BaseController;

class App2Controller extends BaseController
{
    public function index(){
        

        $this->set("add","app2");
        $this -> render ( "/App/index");
    }
}
