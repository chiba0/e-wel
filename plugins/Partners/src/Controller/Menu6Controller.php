<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Exception;


class Menu6Controller extends BaseController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->user = $this->Auth->user();
        $this->loadModel("TUser");
        $this->loadModel("t_change_test");
        $this->loadModel("exam_master");
        $this->loadModel("exam_group");
        $exam_master = $this->exam_group->find()->contain(['ExamMaster'])->toArray();

        $this->set("pan",__('partnerlist'));
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->set("base_logintype",$this->data[ 'type' ]);

        $this->set("pan",__('customerlist'));
        $this->set("panlink","/partners/app/");
        $this->set("pan2",__("pmenu6"));
        $this->set("title",$this->Auth->user('name'));
        
        $this->set("D_EXAM_BASE",$exam_master);

        $this->set("D_EXAM_PRICE",Configure::read("D_EXAM_PRICE"));
    }

    public function index(){
        
        $this->log("[".$this->Auth->user("id")."]検査申込料金設定画面");
        $data = self::__changeTypeKey();
        
        
        $this->set("data",$data);
    }
    /*********************
     * typeをキーに変更
     */
    public function __changeTypeKey(){
        $list = $this->t_change_test->find()
        ->where(['pid'=>$this->user['id']])
        ->order(['type'=>'asc'])
        ->toArray();
        $data = [];
        foreach($list as $val){
            $data[$val[ 'type' ]] = $val;
        }
        return $data;
    }
    /******************************
     * データの登録及び更新
     * 
     *******************************/
    public function sets(){

        $this->autoRender = false;
        if($this->request->getData("regist")){
            $exam_master = $this->exam_master->find()->toArray();

            $this->connection->begin();
            foreach($exam_master as $val){
                $key = $val[ 'key' ];
                $data = $this->t_change_test->find()
                    ->select(['id'])
                    ->where([
                        'pid'=>$this->user['id']
                        ,'type'=>$key
                        ])
                    ->first();
                if($data[ 'id' ] > 0){
                    self::__dataset($key,$data['id']);
                }else{
                    self::__dataset($key);
                }
                
            }
            $this->log("[".$this->Auth->user("id")."]検査申込料金更新成功");
            $this->Flash->success(__("pmenu6_registOK"));
            $this->connection->commit();
            return $this->redirect(['action' => '../menu6/']); 
        }
    }
    public function __dataset($key,$id=""){
        
        $entity = $this->t_change_test->newEntity();
        $entity->pid=$this->user['id'];
        $entity->type=$key;
        if($entity->dispname=$this->request->getData("dispname.".$key) != "" ){
            $entity->dispname=$this->request->getData("dispname.".$key);
            $entity->dispmoney=$this->request->getData("dispmoney.".$key);
            $entity->status= ($this->request->getData("status.".$key) == "on")?1:0;
            $entity->update_ts = date("Y-m-d H:i:s");
        
            if($id > 0){
                $entity->id = $id;
            }else{
                $entity->regist_ts = date("Y-m-d H:i:s");
            }
            
            if($this->t_change_test->save($entity)){

            }else{
                $this->connection->rollback();
                $this->log("[".$this->Auth->user("id")."]検査申込料金更新失敗[type=>".$key."]");
                $this->Flash->error(__("pmenu6_registNG"));
                return $this->redirect(['action' => '../menu6/']); 
            }
        }
        
    }
    

}
