<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Exception;

class Menu5Controller extends BaseController
{
    public static $manualFile1 = "system-manual.pdf";
    public static $manualFile2 = "output-manual.pdf";
    public static $manualtype1 = "manual-system";
    public static $manualtype2 = "manual-result";
    public static $HTTPS = "https";
    public function initialize()
    {
        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->user = $this->Auth->user();
        $this->loadModel("TUser");
        $this->loadModel("manual_pdf");
        $this->loadModel("t_user_weight");
        $this->set("pan",__('partnerlist'));
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pan",__('customerlist'));
        $this->set("panlink","/partners/app/");
        $this->set("pan2",__("pmenu5"));
        $this->set("title",$this->Auth->user('name'));
       
    }

    public function index(){
        $this->log("[".$this->Auth->user("id")."]企業登録フォーム画面");
        //要素名指定
        self::___setElementName();
        //form_codeの指定
        self::__setFormCode();
        $user = $this->TUser->find()->where(['id'=>$this->user['id']])->first();
        $this->set("user",$user);
        //マニュアルURL
        $manual1 = Router::url('/', true)."manual/".self::$manualFile1;
        $manual2 = Router::url('/', true)."manual/".self::$manualFile2;
        //データがあるときはマニュアルの上書き
        if(self::__existsManual(1)) $manual1 = Router::url('/', true)."manual/".self::$manualFile1;
        if(self::__existsManual(2)) $manual2 = Router::url('/', true)."manual/".self::$manualFile2;

        $this->set("manualurl1",$manual1);
        $this->set("manualurl2",$manual2);

        //重み付けデータの取得
        $weights = self::__getWeight();
        $this->set("weights",$weights);

        //重み付けフォームURLの取得
        $formUrl = self::__getFormURL();
        $this->set("formUrl",$formUrl);
        $this->set("url",Router::url('/', true));

    }
    /*********************************
     * 重み付けフォームURLの取得
     ********************************/
    public function __getFormURL(){
        $data = $this->TUser->find()
            ->select(['id','form_code'])
            ->where(['id'=>$this->user['id']])
            ->first();
        $domain = preg_replace("/^http\:/",self::$HTTPS,Router::url('/', true));
        return $domain."ams/index/".$data[ 'form_code' ];
    }
    /******************
     * 重み付けの取得
     *************/
    public function __getWeight(){
        $weights = $this->t_user_weight->find()
            ->where(['uid'=>$this->user['id']])
            ->first();
        return $weights;
    }
    /*********************
     * 重み付けの登録
     ****************/
    public function weight(){
       
        $this->autoRender = false;
        $data = $this->t_user_weight->find()
            ->select([ 'id','uid' ])
            ->where(['uid'=>$this->user['id']])
            ->first();
        $entity = $this->t_user_weight->newEntity();
        $entities = $this->t_user_weight->patchEntity($entity, $this->request->getData());
        $entities->uid=$this->user['id'];
        if($data[ 'id' ] > 0){
            $entities->id = $data[ 'id' ];
        }else{
            $entities->regist_ts = date('Y-m-d H:i:s');
        }
        if($this->t_user_weight->save($entities)){
            $this->Flash->success(__("weight_registOK"));
            $this->log("[".$this->Auth->user("id")."]重み付けの登録成功");
        }else{
            $this->Flash->error(__("weight_registNG"));
            $this->log("[".$this->Auth->user("id")."]重み付けの登録失敗");
        }
        return $this->redirect(['action' => '../menu5/']); 
    }
    /*********************
     * データの削除
     * 
     ****************/
    public function delete($type=""){
        $this->autoRender = false;
        $id= $this->manual_pdf->find()->select(['id'])
                ->where([
                    'uid'=>$this->Auth->user("id"),
                    'type'=>$type
                    ])
                ->first();
        $entity = $this->manual_pdf->newEntity();
        $entity->id = $id[ 'id' ];
        $entity->status = 0;
        if($this->manual_pdf->save($entity)){
            $this->log("[".$this->Auth->user("id")."]検査結果マニュアル初期化成功[".$type."]");
            $this->Flash->success(__("manual_initialOK"));
        }else{
            $this->log("[".$this->Auth->user("id")."]検査結果マニュアル初期化失敗[".$type."]");
            $this->Flash->error(__("manual_initialNG"));
        }
        return $this->redirect(['action' => '../menu5/']); 
    }


    /*****************************
     * データがあるときはマニュアルの上書き
     * 
     ***************************/
    public function __existsManual($type){
        $data= $this->manual_pdf->find()->select(['id','uid','name'])
                ->where([
                    'uid'=>$this->Auth->user("id"),
                    'type'=>$type,
                    'status'=>1
                    ])
                ->first();
        if($data){
            if($type == 1) self::$manualFile1 = $data['uid']."/".$data[ 'name' ];
            if($type == 2) self::$manualFile2 = $data['uid']."/".$data[ 'name' ];
            return true;
        }else{
            return false;
        }
    }
    /******************************
     * 検査結果マニュアルの設定登録
     * 
     ***************************/
    public function manual(){
        $this->autoRender = false;
        if($this->request->getData("manual_regist")){
            //ファイルのアップロード
            //アップロードデータの登録/更新
            $this->connection->begin();
            if(!self::__fileUpload(1,self::$manualtype1)){
                $this->connection->rollback();
                $this->log("[".$this->Auth->user("id")."]検査結果マニュアルのアップロード失敗1");
                $this->Flash->error(__("manual_uploadNG"));
            }
            if(!self::__fileUpload(2,self::$manualtype2)){
                $this->connection->rollback();
                $this->log("[".$this->Auth->user("id")."]検査結果マニュアルのアップロード失敗2");
                $this->Flash->error(__("manual_uploadNG"));
            }


            //検査結果の説明用マニュアル送信日指定
            $entity = $this->TUser->newEntity();
            $entity->id = $this->user->id;
            $entity->sendDayStatus = $this->request->getData("sendDayStatus");
            if($this->TUser->save($entity)){
                $this->Flash->success(__("manual_registOK"));
                $this->log("[".$this->Auth->user("id")."]検査結果マニュアルの設定登録成功");
            }else{
                $this->Flash->error(__("manual_registNG"));
                $this->log("[".$this->Auth->user("id")."]検査結果マニュアルの設定登録エラー");
            }
            $this->connection->commit();
            return $this->redirect(['action' => '../menu5/']); 
        }
    }
    /************************
     * ファイルのアップロード
     * type = 1 : 検査システムの説明用マニュアル
     * type = 2 : 検査結果の説明用マニュアル
     ********/
    public function __fileUpload($type = '',$code = ""){
        
        $uploadfile = WWW_ROOT."manual/".$this->user[ 'id' ]."/";
        if(!file_exists($uploadfile)) mkdir($uploadfile);
        $filename = $this->request->getData($code.".name");
        $info = pathinfo( $filename, PATHINFO_EXTENSION);
        $err = $this->request->getData($code.".error");
        if(!$filename) return true;
        if($err != 0){
            $this->log("[".$this->Auth->user("id")."]検査結果マニュアルアップロードでエラー[".$type."]");
            return false;
        }
        if($info != "pdf"){
            $this->log("[".$this->Auth->user("id")."]検査結果マニュアルがPDF以外[".$type."]");
            return false;
        }

        if (move_uploaded_file($this->request->getData($code.'.tmp_name'), $uploadfile.$filename)){
            //すでに同じUIDで登録している時は更新を行う
            $id= $this->manual_pdf->find()->select(['id'])
                ->where([
                    'uid'=>$this->Auth->user("id"),
                    'type'=>$type
                    ])
                ->first();
            $entity = $this->manual_pdf->newEntity();
            //更新
            if($id[ 'id' ] > 0 ){
                $entity->id = $id[ 'id' ];
            }else{
                $entity->regist_ts = date('Y-m-d H:i:s');
                $entity->uid = $this->Auth->user("id");
            }
            $entity->name = $filename;
            $entity->type = $type;
            

            if($this->manual_pdf->save($entity)){
                $this->log("[".$this->Auth->user("id")."]検査結果マニュアルアップロードDB成功[".$type."]");
                return true;
            }else{
                $this->log("[".$this->Auth->user("id")."]検査結果マニュアルアップロードDB失敗[".$type."]");

                return false;
            }
        }else{
            $this->log("[".$this->Auth->user("id")."]検査結果マニュアルアップロード失敗[".$type."]");
            return false;
        }

    }
     /*******************
     * 企業登録フォームの利用可否
     * 
     *******************/
    public function formStatus(){
        $this->autoRender = false;
        $entity = $this->TUser->newEntity();
        $entity->id = $this->user->id;
        $entity->form_status = $this->request->getData("use");
        
        if($this->TUser->save($entity)){
            $this->log("[".$this->Auth->user("id")."]企業登録フォームの利用可否成功");
        }else{
            $this->log("[".$this->Auth->user("id")."]企業登録フォームの利用可否エラー");
        }
        exit();
    }
    /*******************************
     * form_codeの指定
     * 空欄の際登録
     * 指定済みは何もしない
     *************************/
    public function __setFormCode(){
        if(!$this->user['form_code'] ){
            $form_code = md5(uniqid(rand(),1));
            $this->log("[".$this->Auth->user("id")."]formcode設定");
            $entity = $this->TUser->newEntity();
            $entity->id = $this->user->id;
            $entity->form_code = $form_code;
            if($this->TUser->save($entity)){
                //authデータの変更
                $set = $this->user;
                $set[ 'form_code' ] = $form_code;
                $this->Auth->setUser($set);
                return $this->redirect(['action' => '../menu5/']); 
            }else{
                echo "ERROR";
                $this->log("[".$this->Auth->user("id")."]formcode設定エラー");
                exit();
            }
        }
        return true;
    }


    //要素名指定
    public function ___setElementName(){
        $elemEdit=[];
        for($i=0;$i<=11;$i++){
            if(count($elemEdit) > 0 ){
                $elems = $elemEdit[$i];
            }else{
                $elems = Configure::read("D_ELEMENT.".$i);
            }
          //  if(isset($elem[$i])) $elems = $elem[$i];

            $this->set("elementText".$i,$elems);
        }
    
    }
}
