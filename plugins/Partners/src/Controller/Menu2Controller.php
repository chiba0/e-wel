<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
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
        $this->user = $this->Auth->user();
        $this->loadModel("TUser");
        $this->loadModel("t_element");
        
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pan",__('customerlist'));
        $this->set("panlink","/partners/app/");
        $this->set("pan2",__("pmenu2"));
        $this->set("title",$this->Auth->user('name'));
        $this->set("D_prefecture",Configure::read("D_prefecture"));
        $this->set("param","add");
        $this->set("logoname","");
        $this->editdata = "";
    }

    public function index($id=""){
        $this->log("[".$this->Auth->user("base_loginid")."]新規顧客登録。");
        self::__setTextArea();
    }

    /********************************
     * データ更新
     *******************************/
    public function edit($id=""){
        $this->set("pan2",__("pmenu2Edit"));
        //action先
        $this->set("param","editSet/".$id);
        $this->set("editid",$id);
        $this->log("[".$this->Auth->user("id")."]顧客データ更新。");
        $data = $this->TUser->find()
        ->where([
            'id'=>$id
            ,'partner_id'=>$this->user->id
            ,'type'=>3
        ])->first();
        self::__setTextArea($data);
        self::__setLogoImage($data);

        $this->render('index');
    }
    /*****************************
     * ロゴ画像削除
     ***************************/
    public function __deleteLogoImage($id){
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

    /**********************************
     * ロゴ画像
     **********************************/
    public function __setLogoImage($data){

        $path = "logo/".$data->login_id.".*";
        $glob = glob(WWW_ROOT.$path);
        $logoname = "";
        if(isset($glob[0]) ) $logoname = basename($glob[0]);

        $this->set("logoname",$logoname);
    }
    /********************************
     * データ更新実行
     *******************************/
    public function editSet($id=""){
        $this->set("param","editSet/".$id);
        $this->set("editid",$id);
        $this->autoRender = false;
        if(!$id){
            echo "error";
            exit();
        }
        $this->editdata = $this->TUser->find()
        ->where([
            'id'=>$id
            ,'partner_id'=>$this->user->id
            ,'type'=>3
        ])->first();
        //self::__setLogoImage($this->editdata);
        self::add($id);

    }
    /*******************
     * 新規登録
     */
    public function add($id = ""){
        $this->autoRender = false;
        $auth_login_id = $this->Auth->user("id");
        if($this->request->is("post")){
            $entity = $this->TUser->newEntity();
            $entity= $this->TUser->patchEntity($entity, $this->request->getData());
            //テキストエリアに変数の登録
            self::__setTextArea($this->editdata);
            //var_dump($entity->errors());
            if(count($entity->errors()) > 0 ){
                $this->autoRender = true;
                $this->log("[".$auth_login_id."]データ登録失敗。");
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
                

                return $this->render('/menu2/index');
            }else{
                $this->connection->begin();
                try{
                    //データ登録
                    $entity->password = (new DefaultPasswordHasher)->hash($this->request->getData("login_pw"));
                    $entity->regist_ts = date("Y-m-d H:i:s");
                    $entity->type = 3;
                    $entity->partner_id = $auth_login_id;
                    //更新
                    if($id > 0 ) $entity->id = $id;
                    if($this->TUser->save($entity)){
                        //画像アップロード
                        if(!$this->component->__setImage($this->editdata)){
                            throw new Exception(Configure::read("M.ERROR.INVALID"));
                        }
                        //画像削除
                        self::__deleteLogoImage($id);
                        
                        //登録完了メール
                        //担当者1
                        $this->component->___customerRegistsendMail($this->request->getData('rep_email'),1);
                        //担当者2
                        if( $this->request->getData( 'rep_email2' )){
                            $this->component->___customerRegistsendMail($this->request->getData('rep_email2'),2);
                        }
                        
                        $this->connection->commit();
                        if($id > 0 ){
                            $this->Flash->success(__("customerEditOK"));
                            return $this->redirect(['action' => '../menu2/edit/'.$id]);
                        }else{
                            $this->Flash->success(__("customerRegistOK"));
                            return $this->redirect(['action' => '../app']);
                        }
                    }else{
                        $this->Flash->success(__("customerRegistNG"));
                        throw new Exception(Configure::read("M.ERROR.INVALID"));
                    }
                } catch(Exception $e){
                    $this->log("[".$auth_login_id."]新規顧客登録失敗。ロールバック");
                    $this->Flash->error($e);
                    $this->connection->rollback(); //ロールバック
                }

            }

        }
    }
    
    /****************************
     *　更新用データを引数とする
     */
    public function __setTextArea($data = ""){
        
        $name = $this->request->getData( 'name' );
        if(!$name && isset($data->name)) $name = $data->name;
        $this->set("name",$name);

        $login_id = $this->request->getData( 'login_id' );
        if(!$login_id && isset($data->login_id)) $login_id = $data->login_id;
        $this->set("login_id",$login_id);

        $login_pw = $this->request->getData( 'login_pw' );
        if(!$login_pw && isset($data->login_pw)) $login_pw = $data->login_pw;
        $this->set("login_pw",$login_pw);
        
        $post1 = $this->request->getData( 'post1' );
        if(!$post1 && isset($data->post1)) $post1 = $data->post1;
        $this->set("post1",$post1);

        $post2 = $this->request->getData( 'post2' );
        if(!$post2 && isset($data->post2)) $post2 = $data->post2;
        $this->set("post2",$post2);

        $prefecture = $this->request->getData( 'prefecture' );
        if(!$prefecture && isset($data->prefecture)) $prefecture = $data->prefecture;
        $this->set("prefecture",$prefecture);

        $address1 = $this->request->getData( 'address1' );
        if(!$address1 && isset($data->address1)) $address1 = $data->address1;
        $this->set("address1",$address1);

        $address2 = $this->request->getData( 'address2' );
        if(!$address2 && isset($data->address2)) $address2 = $data->address2;
        $this->set("address2",$address2);

        $tel = $this->request->getData( 'tel' );
        if(!$tel && isset($data->tel)) $tel = $data->tel;
        $this->set("tel",$tel);

        $fax = $this->request->getData( 'fax' );
        if(!$fax && isset($data->fax)) $fax = $data->fax;
        $this->set("fax",$fax);

        $exam_pattern = $this->request->getData( 'exam_pattern' );
        if(!$exam_pattern && isset($data->exam_pattern)) $exam_pattern = $data->exam_pattern;
        $this->set("exam_pattern",$exam_pattern);
        
        $csvupload = $this->request->getData( 'csvupload' );
        if(!$csvupload && isset($data->csvupload)) $csvupload = $data->csvupload;
        $this->set("csvupload",$csvupload);
        
        $pdf_button = $this->request->getData( 'pdf_button' );
        if(!$pdf_button && isset($data->pdf_button)) $pdf_button = $data->pdf_button;
        $this->set("pdf_button",$pdf_button);

        $pdf_master_status = $this->request->getData( 'pdf_master_status' );
        if(!$pdf_master_status && isset($data->pdf_master_status)) $pdf_master_status = $data->pdf_master_status;
        $this->set("pdf_master_status",$pdf_master_status);

        $excel_master_status = $this->request->getData( 'excel_master_status' );
        if(!$excel_master_status && isset($data->excel_master_status)) $excel_master_status = $data->excel_master_status;
        $this->set("excel_master_status",$excel_master_status);

        $csTestBtn = $this->request->getData( 'csTestBtn' );
        if(!$csTestBtn && isset($data->csTestBtn)) $csTestBtn = $data->csTestBtn;
        $this->set("csTestBtn",$csTestBtn);

        $ssltype = $this->request->getData( 'ssltype' );
        if(!$ssltype && isset($data->ssltype)) $ssltype = $data->ssltype;
        $this->set("ssltype",$ssltype);

        $privacy_flg = $this->request->getData( 'privacy_flg' );
        if(!$privacy_flg && isset($data->privacy_flg)) $privacy_flg = $data->privacy_flg;
        $this->set("privacy_flg",$privacy_flg);

        $rep_name = $this->request->getData( 'rep_name' );
        if(!$rep_name && isset($data->rep_name)) $rep_name = $data->rep_name;
        $this->set("rep_name",$rep_name);

        $rep_email = $this->request->getData( 'rep_email' );
        if(!$rep_email && isset($data->rep_email)) $rep_email = $data->rep_email;
        $this->set("rep_email",$rep_email);
        

        $rep_busyo = $this->request->getData( 'rep_busyo' );
        if(!$rep_busyo && isset($data->rep_busyo)) $rep_busyo = $data->rep_busyo;
        $this->set("rep_busyo",$rep_busyo);

        $rep_tel1 = $this->request->getData( 'rep_tel1' );
        if(!$rep_tel1 && isset($data->rep_tel1)) $rep_tel1 = $data->rep_tel1;
        $this->set("rep_tel1",$rep_tel1);
        
        $rep_tel2 = $this->request->getData( 'rep_tel2' );
        if(!$rep_tel2 && isset($data->rep_tel2)) $rep_tel2 = $data->rep_tel2;
        $this->set("rep_tel2",$rep_tel2);

        $rep_name2 = $this->request->getData( 'rep_name2' );
        if(!$rep_name2 && isset($data->rep_name2)) $rep_name2 = $data->rep_name2;
        $this->set("rep_name2",$rep_name2);

        $rep_email2 = $this->request->getData( 'rep_email2' );
        if(!$rep_email2 && isset($data->rep_email2)) $rep_email2 = $data->rep_email2;
        $this->set("rep_email2",$rep_email2);

    }
    
}
