<?php

namespace TestManager\Controller;
use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;

class AppController extends BaseController
{
    public function initialize()
    {
        
        I18n::setLocale('ja_JP');
        parent::initialize();
        
    }
    public function index(){
        //print "testtest";
        
        $add = AppUtility::add(1,2);
        $this->set("add",$add);
    }
    public function isAuthorized($user)
    {

        exit();
    }
}
