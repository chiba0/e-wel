<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;


class DeleteController extends BaseController
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
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        
    }

    public function index($id=""){
        $this->autoRender = false;
        if($id > 0 ){
            $this->log("[".$this->Auth->user("id")."]顧客削除[ID : ".$id."]。");
            $entity = $this->TUser->newEntity();
            $entity->id = $id;
            $entity->del = 1;
            if($this->TUser->save($entity)){
                $this->log("[".$this->Auth->user("id")."]顧客削除[ID : ".$id."]成功。");
                $this->Flash->success(__("partnerDeleteOK"));
            }else{
                $this->log("[".$this->Auth->user("id")."]顧客削除[ID : ".$id."]失敗。");
                $this->Flash->success(__("partnerDeleteNG"));
            }
            return $this->redirect(['action' => '../app']);
        }
    }
    
}
