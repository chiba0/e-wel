<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure; 
use Exception;
use Cake\Auth\DefaultPasswordHasher;

class Menu2Controller extends BaseController
{

    public function initialize()
    {

        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("TUser");
        $this->loadModel("t_testpaper");
        $this->loadModel("t_test");
        
        $this->user = $this->Auth->user();
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();

        $this->partner = $this->TUser->find()->where(['login_id'=>$this->Auth->user("partner_loginid")])->first();
        if(empty($this->partner)) return false;

       
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("pan3",__d('custom','cmenu2'));
        $this->set("panlink2","/customers/app/");
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("D_prefecture",Configure::read("D_prefecture"));
        $this->set("editid",$this->user->id);
    }
    public function index(){
        
        self::__getParameter();



    }
    /***************************
     * 更新処理
     */
    public function edit(){
        $this->autoRender = false;
        if($this->request->is("post")){
            $entity = $this->TUser->newEntity();
            $entity= $this->TUser->patchEntity($entity, $this->request->getData());
            
            if(count($entity->errors()) > 0 ){
                self::__getParameter();
                $this->log("[".$this->user->id."]顧客画面データ更新失敗。");
                self::__setErrorMessage($entity);
                
                
                return $this->render('/menu2/index');
            }else{
                self::____editSet($entity);
            }

        }
    }
    public function ____editSet($entity){
        $this->connection->begin();
        $customer = $this->TUser->find()->where(['id'=>$this->user->id])->first();
        try{
            //データ更新
            $entity->password = (new DefaultPasswordHasher)->hash($this->request->getData("login_pw"));
            $entity->regist_ts = date("Y-m-d H:i:s");
            $entity->type = 3;
            $entity->partner_id = $this->user->partner_id;
            $entity->login_id = $customer->login_id;
            //更新
            $entity->id = $this->request->getData("editid");
            if($this->TUser->save($entity)){
                //画像アップロード
                if(!$this->component->__setImage()){
                    throw new Exception(Configure::read("M.ERROR.INVALID"));
                }
                //画像削除
                self::__deleteLogoImage();
                
                //登録完了メール
                //担当者1
                $this->component->___customerRegistsendMail($this->request->getData('rep_email'),1);
                //担当者2
                if( $this->request->getData( 'rep_email2' )){
                    $this->component->___customerRegistsendMail($this->request->getData('rep_email2'),2);
                }
                
                $this->connection->commit();
                
                $this->Flash->success(__("customerEditOK"));
                return $this->redirect(['action' => '../menu2/']);

            }else{
                $this->Flash->success(__("customerEditNG"));
                throw new Exception(Configure::read("M.ERROR.INVALID"));
            }
        } catch(Exception $e){
            $this->log("顧客更新情報失敗。ロールバック");
            $this->Flash->error($e);
            $this->connection->rollback(); //ロールバック
        }

    }
    /*****************************
    * ロゴ画像削除
    ***************************/
    public function __deleteLogoImage(){
        $id = $this->request->getData("editid");
        if($this->request->getData("logodelete")){
            $data = $this->TUser->find()
            ->where([
                'id'=>$id
                ,'partner_id'=>$this->user->id
                ,'type'=>3
            ])->first();
            $path = "logo/".$data->login_id.".*";
            $glob = glob(WWW_ROOT.$path);
            unlink($glob[0]);
            $this->log("[".$id."]ロゴ画像削除");
        }
    }
    /*******************************
     * エラーメッセージ設定
     */
    public function __setErrorMessage($entity){
        if($entity->errors("name._empty")) $this->Flash->error(__($entity->errors("name._empty")));
        if($entity->errors("login_id._empty")) $this->Flash->error(__($entity->errors("login_id._empty")));
        if($entity->errors("login_id.length")) $this->Flash->error(__("login_id").":".__($entity->errors("login_id.length")));
        if($entity->errors("login_id.custom")) $this->Flash->error(__("login_id").":".__($entity->errors("login_id.custom")));
        if($entity->errors("login_id.alphaNumeric")) $this->Flash->error(__("login_id").":".__($entity->errors("login_id.alphaNumeric")));
        if($entity->errors("login_pw._empty")){
            $this->Flash->error(__($entity->errors("login_pw._empty")));
        }else
        if($entity->errors("login_pw.length")){
            $this->Flash->error(__("password").":".__($entity->errors("login_pw.length")));
        }else
        if($entity->errors("login_pw.alphaNumeric")){
            $this->Flash->error(__("password").":".__($entity->errors("login_pw.alphaNumeric")));
        } 
        if($entity->errors("tel.tel")) $this->Flash->error(__($entity->errors("tel.tel")));
        if($entity->errors("fax.fax")) $this->Flash->error(__($entity->errors("fax.fax")));
        if($entity->errors("rep_name._empty")) $this->Flash->error(__($entity->errors("rep_name._empty")));
        if($entity->errors("rep_email._empty")) $this->Flash->error(__($entity->errors("rep_email._empty")));
        if($entity->errors("rep_email.email")) $this->Flash->error(__($entity->errors("rep_email.email")));
        if($entity->errors("rep_email.email2")) $this->Flash->error(__($entity->errors("rep_email.email2")));
        if($entity->errors("rep_email2.email")) $this->Flash->error(__($entity->errors("rep_email2.email")));
        if($entity->errors("rep_tel1.rep_tel1")) $this->Flash->error(__($entity->errors("rep_tel1.rep_tel1")));


    }
    /**************************
     * 変数指定
     */
    public function __getParameter(){
        $customer = $this->TUser->find()->where(['id'=>$this->user->id])->first();
        self::___setParameter($customer,"name");
        self::___setParameter($customer,"login_id");
        self::___setParameter($customer,"login_pw");
        self::___setParameter($customer,"post1");
        self::___setParameter($customer,"post2");
        self::___setParameter($customer,"prefecture");
        self::___setParameter($customer,"address1");
        self::___setParameter($customer,"address2");
        self::___setParameter($customer,"tel");
        self::___setParameter($customer,"fax");
        self::___setParameter($customer,"exam_pattern");
        self::___setParameter($customer,"csvupload");
        self::___setParameter($customer,"pdf_button");
        self::___setParameter($customer,"pdf_master_status");
        self::___setParameter($customer,"excel_master_status");
        self::___setParameter($customer,"csTestBtn");
        self::___setParameter($customer,"ssltype");
        self::___setParameter($customer,"logoname");
        self::___setParameter($customer,"privacy_flg");
        self::___setParameter($customer,"rep_name");
        self::___setParameter($customer,"rep_email");
        self::___setParameter($customer,"rep_busyo");
        self::___setParameter($customer,"rep_tel1");
        self::___setParameter($customer,"rep_tel2");
        self::___setParameter($customer,"rep_name2");
        self::___setParameter($customer,"rep_email2");
        self::__setLogoImage($customer);
    }

    public function __setLogoImage($data){

        $path = "logo/".$data->login_id.".*";
        $glob = glob(WWW_ROOT.$path);
        $logoname = "";
        if(isset($glob[0]) ) $logoname = basename($glob[0]);

        $this->set("logoname",$logoname);
    }

    /**********************
     * 変数のセット
     */
    public function ___setParameter($data,$key=""){
        $param = $data->$key;
        if($this->request->is("post")){
            $param = $this->request->data($key);
        }
        $this->set($key,$param);
    }
   
}
