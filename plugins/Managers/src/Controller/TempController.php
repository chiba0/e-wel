<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;
use Cake\Core\Configure;
use Cake\Error\Debugger;

class TempController extends BaseController
{
    public $paginate = [
        'limit' => D_LIMIT50,
        'order' => [
            'id' => 'desc' 
        ]
    ];
    public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates']
    ];

    public function initialize()
    {
        parent::initialize();
        I18n::setLocale('ja_JP');
        $this->loadModel("TUser");
        $this->loadModel("uploadfile");
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->set("pan",__('tempfilelist'));
        $this->set("title",$this->Auth->user('name'));
        
    }
    public function lists($id=""){
        //添付ファイル一括削除
        self::__deleteTempAll($id);

        $status = $this->request->getData('status');
        
        $query = $this->uploadfile->find();
        $query = $query->where([
            'partner_id'=>$id
            ,'filename like '=>'%'.$this->request->getData('filename').'%'
            ,'regist_ts like '=>preg_replace("/\//","-",$this->request->getData('registdate')).'%'
            ]);

        if(strlen($status) > 0 ) $query = $query->where([ 'status'=>$status ]);
        $query = $query->order(['regist_ts'=>'DESC']);
        $list = $this->paginate($query);
        //データ変換
        $list = self::__changeData($list);
        $this->set("id",$id);
        $this->set("list",$list);
        $this->set("D_STATUS",Configure::read("D_STATUS"));
    }
    //添付ファイル登録
    public function setTemp($id){
        self::setTempFile($id);

        $this->set("id",$id);
    }   
    //添付ファイルダウンロード
    public function download($id){
        $this->autoRender = false;
        $entity = $this->uploadfile->newEntity();
        $entity->id = $id;
        $entity->status = 1;
        if($this->uploadfile->save($entity)){
            $this->log("[".$this->Auth->user("login_id")."]添付ファイルステータス更新");
        }
        $filedata = $this->uploadfile->find()->where(['id'=>$id])->first();
        $this->response->file(
            WWW_ROOT."tmp/".$filedata->dir_id."/".$filedata->filename,
            [
                'name'=>$filedata->filename,
                'download'=>true
            ]
        );
    }

    public function setTempFile($id){
       // var_dump($_FILES,D_TEMP_PATH);
        if ($this->request->is('post')) {
            $user = $this->TUser->find()->select(['id','login_id'])->where(['id'=>$id])->first();
            
            $this->log("[".$this->Auth->user("login_id")."]添付ファイル登録");
            $file = $this->request->getData('upfile');
            //添付ファイルアップロード用ディレクトリの作成
            $filePath = self::___createTempDir($user);
            $filePath = $filePath.$file[ 'name' ];
            if(move_uploaded_file($file['tmp_name'], $filePath)){
                $this->log("[".$this->Auth->user("login_id")."]添付ファイルアップロード成功(".$filePath.")");

                $entity = $this->uploadfile->newEntity();
                $entity->dir_id      = $user->login_id;
                $entity->partner_id  = $user->id;
                $entity->filename    = $file[ 'name' ];
                $entity->size        = $file[ 'size' ];
                $entity->regist_date = date('Y-m-d H:i:s');
                if($this->uploadfile->save($entity)){
                    $this->log("[".$this->Auth->user("login_id")."]添付ファイル登録成功");
                    $this->Flash->success(__("tempfileuploadOK"));
                    $this->redirect("/managers/temp/lists/".$id);
                }else{
                    $this->log("[".$this->Auth->user("login_id")."]添付ファイル登録失敗");
                    $this->Flash->error(__("tempfileuploadNG"));
                }

            }else{
                $this->log("[".$this->Auth->user("login_id")."]添付ファイルアップロード失敗(".$filePath.")");
            }
        }
    }
    //添付ファイルアップロード用ディレクトリの作成
    public function ___createTempDir($user){
        $filePath = WWW_ROOT.D_TEMP_PATH.$user->login_id."/";
        if(!file_exists($filePath)){
            mkdir($filePath);
        }
        return $filePath;
    }
    //添付ファイル一括削除
    public function __deleteTempAll($id){
        
        if($this->request->getData('checkDelete')){
            $delete = $this->request->getData("delete");
            foreach($delete as $key=>$val){
                $entity = $this->uploadfile->get($key);
                $result = $this->uploadfile->delete($entity);
                if($result){
                    $this->log("[".$this->Auth->user("login_id")."]添付ファイル一括削除成功(".$key.")");
                }else{
                    $this->log("[".$this->Auth->user("login_id")."]添付ファイル一括削除失敗(".$key.")");
                }
            }
            $this->Flash->success(__("tempFileOK"));
            $this->redirect("/managers/temp/lists/".$id);
        }
    }
    public function __changeData($data){
        $list=[];
        $sts = Configure::read("D_STATUS");
        foreach($data as $key=>$value){
            $list[$key]=$value;
            $list[$key][ 'statusDisp' ] = $sts[$value[ 'status' ]];
        }
        return $list;
    }
    //添付ファイル削除
    public function delete($id,$sec){
        $this->log("[".$this->Auth->user("login_id")."]添付ファイル削除(".$id.")");

        $entity = $this->uploadfile->get($id);
        $result = $this->uploadfile->delete($entity);
        if($result){
            $this->log("[".$this->Auth->user("login_id")."]添付ファイル削除成功(".$id.")");
            $this->Flash->success(__("tempFileOK"));
        }else{
            $this->log("[".$this->Auth->user("login_id")."]添付ファイル削除失敗(".$id.")");
            $this->Flash->error(__("tempFileNG"));
        }
        $this->redirect("/managers/temp/lists/".$sec);
        
    }
    
}
