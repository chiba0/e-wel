<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;

class EditController extends BaseController
{

    public function initialize()
    {
        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->user = $this->Auth->user();
        $this->loadModel("TUser");
        $this->loadModel("t_element");
        $this->set("pan",__('partnerlist'));
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app");
        $this->set("pan2",__("pmenu1"));
        $this->set("title",$this->Auth->user('name'));
        $this->set("D_prefecture",Configure::read("D_prefecture"));
    }

    public function index($id=""){
        //ユーザデータ取得
        self::__setUserData();
        //エレメントデータ取得
        self::__getElementData();
    }
    //データ更新作業
    public function edit(){
        //データ更新
        self::__editUserData();
    }
    /**********************
     *　データ更新
     */
    public function __editUserData(){
        $this->autoRender = false;
        if($this->request->is("post")){
            $entity_element = $this->TUser->newEntity();
            $entity_element= $this->TUser->patchEntity($entity_element, $this->request->getData());
            
            if(count($entity_element->errors()) > 0){
                $this->log("[".$this->Auth->user("id")."]ユーザ更新失敗。エラーあり");
                self::index();
                 
                if($entity_element->errors("login_pw._empty")){
                    $this->Flash->error(__($entity_element->errors("login_pw._empty")));
                }else
                if($entity_element->errors("login_pw.length")){
                    $this->Flash->error(__("password").":".__($entity_element->errors("login_pw.length")));
                }else
                if($entity_element->errors("login_pw.alphaNumeric")){
                    $this->Flash->error(__("password").":".__($entity_element->errors("login_pw.alphaNumeric")));
                } 

                
                if($entity_element->errors("tel.tel")) $this->Flash->error(__($entity_element->errors("tel.tel")));
                if($entity_element->errors("fax.fax")) $this->Flash->error(__($entity_element->errors("fax.fax")));
                if($entity_element->errors("rep_name._empty")) $this->Flash->error(__($entity_element->errors("rep_name._empty")));
                if($entity_element->errors("rep_email._empty")) $this->Flash->error(__($entity_element->errors("rep_email._empty")));
                if($entity_element->errors("rep_email.email")) $this->Flash->error(__($entity_element->errors("rep_email.email")));
                if($entity_element->errors("rep_email2.email")) $this->Flash->error(__($entity_element->errors("rep_email2.email")));
                if($entity_element->errors("rep_tel1.rep_tel1")) $this->Flash->error(__($entity_element->errors("rep_tel1.rep_tel1")));

                $this->render('index');
            }else{
                $entity_element->id = $this->Auth->user("id");
                $entity_element->password = (new DefaultPasswordHasher)->hash($this->request->getData("login_pw"));
                if($this->TUser->save($entity_element)){
                    $this->log("[".$this->Auth->user("id")."]ユーザ更新成功。");
                    //登録メール配信
                    $loginid = $this->Auth->user("login_id");
                    $user = $this->TUser->find()->where(['login_id'=>$loginid])->first();
                    $to = $user[ 'rep_email' ];
                    $rep_name = $user[ 'rep_name' ];
                    $this->component->___partnerEditsendMail($user,$to,$rep_name);

                    //担当者2に送信
                    $to = $user[ 'rep_email2' ];     
                    $rep_name = $user[ 'rep_name2' ];
                    if($to && $rep_name){
                        $this->component->___partnerEditsendMail($user,$to,$rep_name);
                    }

                    $this->Flash->success(__("partnerEditOK"));
                    return $this->redirect(['action' => '../edit']);
                    
                }else{
                    $this->log("[".$this->Auth->user("id")."]ユーザ更新失敗。");
                }
            }

        }
    }


    /****************************
     * エレメントデータ取得
     */
    public function __getElementData(){
        $element = $this->t_element->find()
            ->select([
                'e_feel',
                'e_cus',
                'e_aff',
                'e_cntl',
                'e_vi',
                'e_pos',
                'e_symp',
                'e_situ',
                'e_hosp',
                'e_lead',
                'e_ass',
                'e_adap'
            ])
            ->where([ 'uid'=>$this->Auth->user('id'),'element_status'=>1 ])
            ->first();
        if($element) $element = $element->toArray();
        //エレメントデータが存在しない際は初期値を指定する
        if(empty($element)){
            $element = Configure::read("D_ELEMENT");
        }
        $this->set("element",$element);
    }
    /***** 
    ユーザデータ取得
    *****/
    public function __setUserData(){
        $loginid = $this->Auth->user("login_id");
        $user = $this->TUser->find()->where(['login_id'=>$loginid])->first();
        $this->set("user",$user);
        $login_pw = $user['login_pw'];
        if($this->request->is('post')) $login_pw = $this->request->getData('login_pw');
        $this->set("login_pw",$login_pw);
        
        $post1 = $user['post1'];
        if($this->request->is('post')) $post1 = $this->request->getData('post1');
        $this->set("post1",$post1);

        $post2 = $user['post2'];
        if($this->request->is('post')) $post2 = $this->request->getData('post2');
        $this->set("post2",$post2);
        
        $prefecture = $user['prefecture'];
        if($this->request->is('post')) $prefecture = $this->request->getData('prefecture');
        $this->set("prefecture",$prefecture);

        $address1 = $user['address1'];
        if($this->request->is('post')) $address1 = $this->request->getData('address1');
        $this->set("address1",$address1);

        $address2 = $user['address2'];
        if($this->request->is('post')) $address2 = $this->request->getData('address2');
        $this->set("address2",$address2);
        
        $tel = $user['tel'];
        if($this->request->is('post')) $tel = $this->request->getData('tel');
        $this->set("tel",$tel);

        $fax = $user['fax'];
        if($this->request->is('post')) $fax = $this->request->getData('fax');
        $this->set("fax",$fax);

        $rep_name = $user['rep_name'];
        if($this->request->is('post')) $rep_name = $this->request->getData('rep_name');
        $this->set("rep_name",$rep_name);
        
        $rep_email = $user['rep_email'];
        if($this->request->is('post')) $rep_email = $this->request->getData('rep_email');
        $this->set("rep_email",$rep_email);

        $rep_name2 = $user['rep_name2'];
        if($this->request->is('post')) $rep_name2 = $this->request->getData('rep_name2');
        $this->set("rep_name2",$rep_name2);

        $rep_email2 = $user['rep_email2'];
        if($this->request->is('post')) $rep_email2 = $this->request->getData('rep_email2');
        $this->set("rep_email2",$rep_email2);

        $rep_tel1 = $user['rep_tel1'];
        if($this->request->is('post')) $rep_tel1 = $this->request->getData('rep_tel1');
        $this->set("rep_tel1",$rep_tel1);
    }
    
}
