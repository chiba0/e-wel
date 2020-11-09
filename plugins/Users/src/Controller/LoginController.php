<?php

namespace Users\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use App\Controller\AuthComponent;
use Cake\Auth\DefaultPasswordHasher;

class LoginController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->Auth->allow();
    }    
    public function index()
    {
        //ログインチェック
        if($this->request->getSession()->read('Auth.User.id')){
            return $this->redirect($this->Auth->redirectUrl());
        }
      //  $pwd = (new DefaultPasswordHasher)->hash("tests");
        //var_dump($pwd);
        //exit();
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                //ログインした人のユーザIDを保存
                $user['base_loginid'] = $user[ 'login_id' ];
                $this->Auth->setUser($user);
                $this->log("[".$this->Auth->user("login_id")."]ログイン成功。");
                //管理者の時
                if($user['type'] == 1){
                    $this->redirect(['controller' => '../managers', 'action' => 'app']);
                }
                //パートナーの時
                if($user['type'] == 2){
                    $this->redirect(['controller' => '../partners', 'action' => 'app']);
                }
                //return $this->redirect($this->Auth->redirectUrl());
            }else{
                $this->Flash->error('ユーザー名またはパスワードが不正です。',['key'=>'login']);
            }
        }

        $this -> render ( "login" ,"login");
    }
    // ログアウト
    public function logout()
    {
        $this->log("[".$this->Auth->user("login_id")."]ログアウト。");
        // $this->Auth->logout(): ユーザー認証を解除し、ログアウト後のリダイレクト先URLを返す(logoutRedirect)
        return $this->redirect($this->Auth->logout());
    }
    public function login(){
echo "test";
exit();
        return true;
        /*
//        $pwd = (new DefaultPasswordHasher)->hash("9021INg");
//var_dump($pwd);
        var_dump($_POST);
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            var_dump($user);
            
            $this->Flash->error('ユーザー名またはパスワードが不正です。',['key'=>'login']);
        }
        $this -> render ( "login" ,"login");
        */
    }

}
