<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure; 
use Exception;
use Cake\Auth\DefaultPasswordHasher;

class Menu5Controller extends BaseController
{

    public function initialize()
    {

        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("TUser");
        $this->loadModel("t_weight_master");
        $this->loadModel("t_element");
        $this->D_STATUS = Configure::read("D_STATUS");
        $this->user = $this->Auth->user();
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();

        $this->partner = $this->TUser->find()->where(['login_id'=>$this->Auth->user("partner_loginid")])->first();
        if(empty($this->partner)) return false;

       
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("pan3",__d('custom','cmenu5'));
        $this->set("panlink2","/customers/app/");
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("d_status",$this->D_STATUS);
        $this->set("id","");
        $this->set("data","");
    }
    public function index(){
        //重み付けマスタデータ取得
        $data = $this->getWeightMaster();
        $this->set("data",$data);
        
    }
    /************************
     * 重み付けマスタデータ取得
     */
    public function getWeightMaster($id=""){
        $data = $this->t_weight_master->find()->where([
            'pid'=>$this->user->partner_id,
            'uid'=>$this->user->id,
        ]);
        
        if($id) $data = $data->where([ 'id'=>$id ]);
        if($this->request->getData('search_text')) $data = $data->where([ 'master_name like '=>'%'.$this->request->getData('search_text').'%' ]);
        $data = $data->toArray();
        $data[0]['ave'] = $data[0][ 'avg' ]; 
        $data[0]['sd'] = $data[0][ 'hensa' ]; 
        return $data;
    }


    /*******************
     * データ削除
     */
    public function delete($id){
        if(!$id){
            header("Location:/customers/menu5");
            exit();
        }
        $delete = $this->t_weight_master->get($id);
        $this->t_weight_master->delete($delete);

        $this->Flash->error(__d("custom","wt_delete"));
        header("Location:/customers/menu5");
        exit();

    }
    /*****************
     * データ登録
     */
    public function regist($id=""){
        
        //エレメントデータ取得
        $element = $this->t_element->find()->where(['uid'=>$this->user->partner_id])->first();
        $data[0] = self::___setDefault($element);
        //重み付けマスタデータ取得
        if($id > 0){
            $data = [];
            $data = $this->getWeightMaster($id);
        }
        //重み付け登録処理
        $this->setWeightMaster();

        $this->set("element",$element);
        $this->set("id",$id);
        $this->set("data",$data[0]);
    }
    /****************
     * 初期データ
     */
    static function ___setDefault($element){
        $return = [];
        foreach($element->toArray() as $key=>$value){
            $return[ $key ] = 0;
        }
        $return[ 'master_name' ] = "";
        $return[ 'ave' ] = "";
        $return[ 'sd' ] = "";
        return $return;
    }
    /**************************
     * 重み付け登録
     */
    public function setWeightMaster(){
        
        if($this->request->getData('regist')){
            
            $entity = $this->t_weight_master->newEntity();
            $entity= $this->t_weight_master->patchEntity($entity, $this->request->getData());
            if($entity->errors()){ 
                $this->log("[ID : ".$this->user->id."]重み付けマスタ登録失敗");
                if($entity->errors("master_name._empty")) $this->Flash->error(__($entity->errors("master_name._empty")));
            }else{
                if($this->request->getData('id')) $entity->id=$this->request->getData('id');
                $entity->uid = $this->user->id;
                $entity->pid = $this->user->partner_id;
                $entity->avg = $this->request->getData('ave');
                $entity->hensa = $this->request->getData('sd');
                $entity->regist_ts = date("Y-m-d H:i:s");
                
                if($this->t_weight_master->save($entity)){
                    $this->Flash->error(__d("custom","wt_success"));
                    if($this->request->getData('id')){
                        header("Location:/customers/menu5/regist/".$this->request->getData('id'));
                    }else{
                        header("Location:/customers/menu5/regist");
                    }
                    exit();
                }else{
                    $this->Flash->error(__d("custom","wt_error"));
                }

            }
        }
       
        
        
    }
    /***************
     * 重み付けテンプレートファイルダウンロード
     */
    public function weight(){
        $this->autoRender = false;
        $filepath = WWW_ROOT."/download/weight.csv";
        $filename = "weight.csv";
        header('Content-Type: application/csv');
        header('Content-Length: '.filesize($filepath));
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        readfile($filepath);
    }
}
