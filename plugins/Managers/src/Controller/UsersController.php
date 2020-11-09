<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;

class UsersController extends BaseController
{    
    public function initialize()
    {
        parent::initialize();
    }
    public function index(){
        //print "testtest";
        $this->loadModel("ManagersMl");
        var_dump($this->ManagersMl);
        $this->loadModel("TUser");
        var_dump($this->TUser);
        echo "testes";
        $email = new Email('default');
        $email->setFrom(["from@example.com"=>"送信元名"])
                ->setTo("to@example.com")
                ->setCc("cc@example.com")
                ->setBcc("bcc@example.com")
                ->setSubject("お問合せありがとうございます。")
                ->send("お問い合わせの本文です");
        exit();
      //  $add = Utility::add(1,2);
       // $this->set("add",$add);
    }
    public function login(){
        return $this->redirect('/users/login');
    }
}
