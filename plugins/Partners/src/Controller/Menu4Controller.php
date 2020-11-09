<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Exception;

class Menu4Controller extends BaseController
{
   
    public function initialize()
    {
        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->user = $this->Auth->user();
        $this->loadModel("TUser");
        $this->loadModel("pdflogo");
        $this->set("pan",__('partnerlist'));
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->set("base_logintype",$this->data[ 'type' ]);

        $this->set("pan",__('customerlist'));
        $this->set("panlink","/partners/app/");
        $this->set("pan2",__("pmenu4"));

        $this->set("title",$this->Auth->user('name'));
        $this->uploaddir = WWW_ROOT."img/pdflogo/";
       
    }

    public function index($id=""){
        
        $this->url = "/img/pdflogo/";
        $this->log("[".$this->Auth->user("id")."]PDFロゴ画像登録ページ");
        //ロゴ画像表示
        self::__setLogo();

    }
    public function __setLogo(){
        $data = $this->pdflogo->find()
            ->where([
                'user_id'=>$this->user[ 'id' ]
                ,'status'=>1
                
                ])
            ->first();
        $this->set("logoImage","");
        if($data){
            $this->set("logoImage",$data[ 'filename' ]);
            $this->set("url",$this->url);
        }
    }
    public function type(){
        $this->autoRender = false;
        //画像アップロード
        self::__imageUpload();
        //画像削除
        self::__editUpload();
    }
    /***
     * 画像削除
     */
    public function __editUpload(){
        if($this->request->getData('pdflogodelete')){
            if($id = self::__checkID()){
                $entity = $this->pdflogo->newEntity();
                $entity->id = $id;
                $entity->status = 0;
                if($this->pdflogo->save($entity)){
                    $this->Flash->error(__("pdflogoDeleteOK"));
                }
            }
            return $this->redirect(['action' => '../menu4/']);
        }
    }
    //画像アップロード
    public function __imageUpload(){
        if($this->request->getData('regist')){
            $this->log("[".$this->user[ 'id' ]."]PDFロゴ画像登録実施");
            
            if(self::__imageUploadCheck()){
                //拡張子取得
                $exp = pathinfo($this->request->getData('file.name'));
                $extension = $exp[ 'extension' ];
                $filename = $this->user[ 'login_id' ].".".$extension;
                //アップロードファイル登録
                $entity = $this->pdflogo->newEntity();
                $entity->user_id = $this->user[ 'id' ];
                //IDの確認IDがあればeditを行う
                if($id = self::__checkID()){
                    $entity->id = $id;
                }else{
                    $entity->regist_ts = date('Y-m-d H:i:s');
                }
                $entity->filename = $filename;
                $entity->status = 1;

                $this->connection->begin();
                if($this->pdflogo->save($entity)){
                    //画像アップロード
                    if(self::__setFileUpload($this->uploaddir,$filename)){
                        $this->connection->commit();
                        $this->Flash->error(__("pdflogoRegistOK"));
                    }else{
                        $this->Flash->error(__("pdflogoRegistNG"));
                        $this->connection->rollback();
                    }
                }else{
                    $this->Flash->error(__("pdflogoRegistNG"));
                    $this->connection->rollback();
                }
               

            }
            return $this->redirect(['action' => '../menu4/']);
        }
    }
    /**
     * IDの確認IDがあれば返す
     */
    public function __checkID(){
        $data = $this->pdflogo->find()->select([ 'id' ])->where(['user_id'=>$this->user[ 'id' ]])->first();
        return $data[ 'id' ];
    }
    /********************************
     * 画像アップロード
     */
    public function __setFileUpload($uploaddir,$filename){
        $uploadfile = $uploaddir.$filename;
        if (move_uploaded_file($this->request->getData('file.tmp_name'), $uploadfile)){
            return true;
        }else{
            return false;
        }
    }
    //画像アップロードエラーチェック
    public function __imageUploadCheck(){
   
        $info = @getimagesize($this->request->getData("file.tmp_name"));
        if (!in_array($info[2], [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
            $this->Flash->error(__("pdflogoError2"));
            $this->log("[".$this->user[ 'id' ]."]PDFロゴ画像未画像エラー");
            return false;  
        }

        if(strlen($this->request->getData("file.name")) < 1 ){
            $this->Flash->error(__("pdflogoError1"));
            $this->log("[".$this->user[ 'id' ]."]PDFロゴ画像未選択エラー");
            return false;
        }
       
        
        $error = $this->request->getData("file.error");
        if($error > 0 ){
            $this->Flash->error(__("pdflogoRegistNG"));
            $this->log("[".$this->user[ 'id' ]."]PDFロゴ画像登録失敗エラー");
            return false;
        }
        return true;

    }

}
