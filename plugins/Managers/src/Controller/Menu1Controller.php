<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;

use Cake\Error\Debugger;

class Menu1Controller extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        I18n::setLocale('ja_JP');
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->set("pan",__('menu1'));
        $this->set("title",$this->Auth->user('name'));
        
    }
    public function index(){
        $this->loadModel("TUser");
        
        self::___updateUserData();  //データ更新
        $this->set('su_data', self::___setSuperUserData());  //スーパーユーザーデータ取得
        $this->set('gu_data', self::___setGeneralUserData());   //一般ユーザーデータ取得
    }

    //スーパーユーザーデータ取得
    public function ___setSuperUserData(){
        $data = $this->TUser->find()
            ->select(['id','login_id','login_pw','rep_name','rep_email'])
            ->where(['type'=>1,'super'=>1])
            ->toArray();
        return $data[0];
    }
    //一般ユーザー取得
    public function ___setGeneralUserData(){
        $data = $this->TUser->find()
            ->select(['id','login_id','login_pw','rep_name'])
            ->where(['type'=>1,'super'=>0])
            ->order(['id'=>'ASC'])
            ->toArray();
        return $data;
    }

    //データ更新
    public function ___updateUserData(){
        if($this->request->is('post')){
            
            //POSTデータ取得
            $maxCount = 5;  //登録できる一般ユーザーの上限数
            for($i=0; $i<$maxCount+1; $i++){
                if($i == 0){    //スーパーユーザー
                    $data[$i]['id'] = $this->request->getData('su_id');                     //id
                    $data[$i]['rep_name'] = $this->request->getData('su_rep_name');         //rep_name
                    $data[$i]['rep_email'] = $this->request->getData('su_rep_email');       //email
                    $login_id[$i] = $this->request->getData('su_login_id');                 //login_id
                }else{          //一般ユーザー
                    $data[$i]['id'] = $this->request->getData("gu_id_$i");                  //id
                    $data[$i]['rep_name'] = $this->request->getData("gu_rep_name_$i");      //rep_name
                    $login_id[$i] = $this->request->getData("gu_login_id_$i");              //login_id
                }
            }
            
            //データ更新
            for($i=0; $i<$maxCount+1; $i++){
                $entity = $this->TUser->get($data[$i]['id']);
                if($i == 0){
                    $this->TUser->patchEntity($entity, $data[$i], ['filedList' => ['rep_name','rep_email']]);
                }else{
                    $this->TUser->patchEntity($entity, $data[$i], ['fieldList' => 'rep_name']);
                }
                if($entity->errors()){  //バリデーション
                    foreach ($entity->errors() as $field){
                        foreach($field as $errMsg){
                            $this->Flash->error("[ ID : ".$login_id[$i]." ] " . __($errMsg));
                        }
                    }
                }else{  //更新
                    if($this->TUser->save($entity, false)){
                        $this->Flash->success("[ ID : ".$login_id[$i]." ] " . __d('other', 'userUpdateOK'));
                    }else{
                        $this->Flash->error("[ ID : ".$login_id[$i]." ] " . __d('other', 'userUpdateNG'));
                    }
                }
            }
        }
    }

}
