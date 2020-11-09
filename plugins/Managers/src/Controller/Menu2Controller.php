<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;

use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Auth\DefaultPasswordHasher;

class Menu2Controller extends BaseController
{
    public function initialize()
    {
        
        parent::initialize();
        $this->userData = "";
        $this->elementData =[];
        $this->buyLicence = [];
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("TUser");
        $this->loadModel("TElement");
        $this->loadModel("outputpdf");
        $this->loadModel("buyLicense");
        $this->loadModel("pdf_exam_master");
        $this->loadModel("exam_master");
        $this->loadModel("exam_group_use");
        $exam_master = $this->exam_group_use->find()
            ->contain(['ExamMaster'])
            ->matching(
                'ExamMaster', function($q) {
                    return $q->where([
                        'del' => 0
                    ]);
                });
        $exam_master = $exam_master->group(['exam_group_id']);
        $exam_master = $exam_master->toArray();

        $this->set("pan",__('menu2'));
        $this->set("title",$this->Auth->user('name'));
        $this->set("prefecture",Configure::read("prefecture"));
        $this->set("D_ELEMENT",Configure::read("D_ELEMENT"));
        //$this->set("D_EXAM_BASE",Configure::read("D_EXAM_BASE"));
        $this->set("D_EXAM_BASE",$exam_master);
        //PDFのマスタデータ取得
        $d_exam_pdf = $this->pdf_exam_master->find()->where(['del !='=>1])->toArray();
        $this->set("D_EXAM_PDF",$d_exam_pdf);
        $this->set("D_prefecture",Configure::read("D_prefecture"));
        $this->set("valiable","");
        $this->set("editid","");
    }
    public function index(){
        
        $this->ss= $this->request->session();
        $this->___setElementName();
        $this->__setPartnerData();
        
    }
    public function edit($id=""){
        
        //登録ユーザデータ取得
        $this->userData = $this->TUser->get($id);
        //DBの名前とフォームの名前の統一を行う
        $this->userData->element_status = $this->userData[ 'element_flg' ];

        //要素名データ取得
        $this->elementData = $this->TElement->find()
            ->where([
                'uid' => $id
                ,'element_status' => 1
                ])
            ->first();

        //会員自動登録の際に出力されるPDF
        $outputPdf = $this->outputpdf->find()
            ->where([
                'uid' => $id
                ,'status' => 1
                ])
            ->toArray();
        $outputpdfList = [];
        foreach($outputPdf as $key=>$val){
            $outputpdfList[$val[ 'pdf_id' ]] = "on";
        }
        

        //購入ライセンスデータ
        $this->buyLicence = $this->buyLicense->find()
            ->where([
                'uid'=>$id
            ])->toArray();


        $this->log("[".$this->Auth->user("login_id")."]パートナーデータ更新");
        $this->___setElementName();
        $this->__setPartnerData($id);

        $this->set("outputpdfList",$outputpdfList);
        $this->set("valiable",$id);
        $this->set("editid",$id);
        
        $this -> render ( "index" );
        
    }
    //要素名指定
    public function ___setElementName(){
        $elem = $this->request->getData('elementText');
        $elemEdit=[];
        if(empty($elem)&& !empty($this->elementData)){
            //データ更新時に登録済みのelementを表示
            $elemEdit[0] = $this->elementData[ 'e_feel' ];
            $elemEdit[1] = $this->elementData[ 'e_cus' ];
            $elemEdit[2] = $this->elementData[ 'e_aff' ];
            $elemEdit[3] = $this->elementData[ 'e_cntl' ];
            $elemEdit[4] = $this->elementData[ 'e_vi' ];
            $elemEdit[5] = $this->elementData[ 'e_pos' ];
            $elemEdit[6] = $this->elementData[ 'e_symp' ];
            $elemEdit[7] = $this->elementData[ 'e_situ' ];
            $elemEdit[8] = $this->elementData[ 'e_hosp' ];
            $elemEdit[9] = $this->elementData[ 'e_lead' ];
            $elemEdit[10] = $this->elementData[ 'e_ass' ];
            $elemEdit[11] = $this->elementData[ 'e_adap' ];
        }
        for($i=0;$i<=11;$i++){
            if(count($elemEdit) > 0 ){
                $elems = $elemEdit[$i];
            }else{
                $elems = Configure::read("D_ELEMENT.".$i);
            }
            if(isset($elem[$i])) $elems = $elem[$i];
            $this->set("elementText".$i,$elems);
        }
 
    }


    //要素データ登録
    //引数：t_userに登録したデータ
    public function ___setElementData($tuser,$editid=""){
        
        $entity_element = $this->TElement->newEntity();
        $entity_element= $this->TElement->patchEntity($entity_element, $this->request->getData());
        $entity_element->uid = $tuser['id'];
        $elementText = $this->request->getData('elementText');
        $entity_element->e_feel = $elementText[0];
        $entity_element->e_cus = $elementText[1];
        $entity_element->e_aff = $elementText[2];
        $entity_element->e_cntl = $elementText[3];
        $entity_element->e_vi = $elementText[4];
        $entity_element->e_pos = $elementText[5];
        $entity_element->e_symp = $elementText[6];
        $entity_element->e_situ = $elementText[7];
        $entity_element->e_hosp = $elementText[8];
        $entity_element->e_lead = $elementText[9];
        $entity_element->e_ass = $elementText[10];
        $entity_element->e_adap = $elementText[11];
        
        $entity_element->element_flg = ($this->request->getData('element_status')?1:0);
        
        //更新用データ取得
        if($editid){
            $elemdataOne = $this->TElement->find()->select([ 'id' ])->where(['uid' => $editid])->first();
            $entity_element->id = $elemdataOne[ 'id' ];
        }

        if($this->TElement->save($entity_element)){
            return true;
        }else{
            return false;
        }
    }
    //要素データ登録
    //引数：t_outputPDFに登録したデータ
    //editidがあるときは指定値のデータを削除する
    public function ___setOutPutPDFData($tuser,$editid=""){
        if($editid){
            $result = $this->outputpdf->deleteAll(['uid' => $editid]);
            if($result){
                $this->log("[uid=>".$editid."]会員自動登録の際に出力されるPDFデータ削除実行。");
            }
        }
        $outputPDF_hidden = $this->request->getData("outputPDF_hidden");
        $outputPDF = $this->request->getData("outPutPDF");
        $insert = [];
        foreach($outputPDF_hidden as $key=>$val){
            $status = 0;
            if(isset($outputPDF[$key]) && $outputPDF[$key] == 1) $status = 1;

            if($status == 1){
                $insert[] = 
                [
                    "uid"=>$tuser['id'],
                    "pdf_id"=>$key,
                    "status"=>$status,
                    "regist_ts"=>date("Y-m-d H:i:s")   
                ];
            }
        }
        $entities =  $this->outputpdf->newEntities($insert);
        
        $errflg = 0;
        foreach ($entities as $entity) {
            $this->outputpdf->save($entity);
        }
        return true;

    }
    //ライセンスデータ登録

    public function ___setLicenseData($tuser,$editid){
        $editData = [];
        if($editid){
            //更新用ID取得
            $editDatas = $this->buyLicense->find()->select(['id',"exam_key"])->where(['uid'=>$editid])->toArray();
            foreach($editDatas as $key=>$val){
                $editData[$val['exam_key']] = $val['id'];

            }
        }
        
        $uid = $tuser['id'];
        $elem = $this->request->getData("elem");
        
        $i=0;
        foreach($elem as $key=>$val){

            $data[$i] = 
            [
                'uid' => $uid,
                'exam_key' => $key,
                'buyNumber' => (int)$val
            ];
            if(isset($editData[$key]) && $editData[$key]){
                $data[$i]['id'] = $editData[$key];
            }
            $i++;
            
        }

        $entities =  $this->buyLicense->newEntities($data);
        foreach ($entities as $entity) {
            
            $this->buyLicense->save($entity);
        }
        
        return true;

    }
    //データ登録
    public function __setPartnerData($editid = ""){

        $auth_login_id = $this->Auth->user("login_id");
        $auth_rep_email = $this->Auth->user('rep_email');
        $auth_rep_name = $this->Auth->user('rep_name');
        
        $entity = $this->TUser->newEntity();
        
        if ($this->request->is('post')) {
            $this->log("[".$auth_login_id."]会員データ登録実行。");
            $entity= $this->TUser->patchEntity($entity, $this->request->getData());
            $this->connection->begin();
            
            if(count($entity->errors()) == 0){
                try{
                    //ユーザ情報登録
                    if($editid) $entity->id = $editid;
                   
                    $entity->type = 2;
                    $entity->eirid = 1;
                    $entity->license = (int)array_sum($this->request->getData("elem"));
                  //  $entity->form_code = md5(uniqid(rand(),1));
                    $entity->password = (new DefaultPasswordHasher)->hash($this->request->getData("login_pw"));
                    $entity->element_flg = $this->request->getData('element_status');
                    if(!($tuser = $this->TUser->save($entity))){
                        $this->log("[".$auth_login_id."]ユーザ登録失敗。");
                        throw new Exception(Configure::read("M.ERROR.INVALID"));
                    }

                    //ライセンスデータ登録
                    if(!$this->___setLicenseData($tuser,$editid)){
                        $this->log("[".$auth_login_id."]ライセンス登録失敗。");
                        $this->connection->rollback();
                        throw new Exception(Configure::read("M.ERROR.INVALID"));
                    }
                    
                    //要素データ登録
                    if(!$this->___setElementData($tuser,$editid)){
                        $this->log("[".$auth_login_id."]要素登録失敗。");
                        $this->connection->rollback();
                        throw new Exception(Configure::read("M.ERROR.INVALID"));
                    }
                    
                    //会員自動登録の際に出力されるPDF
                    if(!$this->___setOutPutPDFData($tuser,$editid)){
                        $this->log("[".$auth_login_id."]PDF登録失敗。");
                        $this->connection->rollback();
                        throw new Exception(Configure::read("M.ERROR.INVALID"));
                    }
                    


                    
                    //パートナー登録成功メール配信
                    //担当者1
                    $this->component->___usersendMail($tuser,$tuser['rep_email'],$tuser['rep_name']);
                    //担当者2
                    if($tuser['rep_email2']){
                        $this->component->___usersendMail($tuser,$tuser['rep_email2'],$tuser['rep_name2']);
                    }
                    //管理者
                    $this->component->___usersendMail($tuser,$auth_rep_email,"[管理者]".$auth_rep_name);
                   
                    $this->connection->commit();
                    if($editid > 0 ){
                        $this->log("[".$auth_login_id."]データ更新成功。");
                        $this->Flash->success(__("partnerEditOK"));
                        
                        //return $this->redirect(['action' => '../../managers/menu2/edit/'.$editid]);
                        
                        
                    }else{
                        $this->log("[".$auth_login_id."]データ登録成功。");
                        $this->Flash->success(__("partnerRegistOK"));
                        
                    //    return $this->render('/managers/menu2/');
                    }
                    return $this->redirect(['action' => '../../managers/app']);
                    
                }catch(Exception $e){
                    $this->Flash->error("ERROR ROLL BACK");
                    $this->log("[".$tuser[ 'login_id' ]."]データ登録失敗ロールバック。");
                    $this->connection->rollback();
                }
                
            }else{
                //----------------------------
                //エラーメッセージ表示の指定
                //---------------------------
                $this->log("[".$auth_login_id."]データ登録失敗。");
                if($entity->errors("name._empty")) $this->Flash->error(__($entity->errors("name._empty")));
                if($entity->errors("login_id._empty")) $this->Flash->error(__($entity->errors("login_id._empty")));
                if($entity->errors("login_id.length")) $this->Flash->error(__($entity->errors("login_id.length")));
                if($entity->errors("login_id.alphaNumeric")) $this->Flash->error(__($entity->errors("login_id.alphaNumeric")));
                if($entity->errors("login_id.custom")) $this->Flash->error(__($entity->errors("login_id.custom")));
                if($entity->errors("login_pw._empty")) $this->Flash->error(__("password").__($entity->errors("login_pw._empty")));
                if($entity->errors("login_pw.length")) $this->Flash->error(__("password").__($entity->errors("login_pw.length")));
                if($entity->errors("login_pw.alphaNumeric")) $this->Flash->error(__("password").__($entity->errors("login_pw.alphaNumeric")));
                if($entity->errors("login_pw.custom")) $this->Flash->error(__("password").__($entity->errors("login_pw.custom")));
                if($entity->errors("rep_name._empty")) $this->Flash->error(__($entity->errors("rep_name._empty")));
                if($entity->errors("rep_email._empty")) $this->Flash->error(__($entity->errors("rep_email._empty")));
                if($entity->errors("rep_email.email")) $this->Flash->error(__($entity->errors("rep_email.email")));
                if($entity->errors("tel.tel")) $this->Flash->error(__($entity->errors("tel.tel")));
                if($entity->errors("fax.fax")) $this->Flash->error(__($entity->errors("fax.fax")));
                if($entity->errors("rep_email2.email")) $this->Flash->error(__($entity->errors("rep_email2.email")));
                if($entity->errors("rep_tel1.rep_tel1")) $this->Flash->error(__($entity->errors("rep_tel1.rep_tel1")));

                $this->log("[".$auth_login_id."]データ登録失敗。");
            }
        }


        $this->__setValiabled('name'      );
        $this->__setValiabled('login_id'  );
        $this->__setValiabled('login_pw'  );
        $this->__setValiabled('post1'     );
        $this->__setValiabled('post2'     );
        $this->__setValiabled('prefecture');
        $this->__setValiabled('address1'  );
        $this->__setValiabled('address2');
        $this->__setValiabled('tel');
        $this->__setValiabled('fax');
        $this->__setValiabled('ptTestBtn');
        $this->__setValiabled('rep_name');
        $this->__setValiabled('rep_email');
        $this->__setValiabled('rep_name2');
        $this->__setValiabled('rep_email2');
        $this->__setValiabled('rep_tel1');
        $this->__setValiabled('logo_name');
        $this->__setValiabled('element_status');


        //ライセンス登録数
        $elem = [];
        if($this->request->getData('elem')){
            $elem = $this->request->getData('elem');
        }else{
            foreach($this->buyLicence as $key=>$val){
                $elem[$val['exam_key']] = $val[ 'buyNumber' ];
            }
        }
        $this->set("elem",$elem);

    }
    public function __setValiabled($key){
        $value="";
        if($this->request->getData($key)){
            $value=$this->request->getData($key);
        }elseif(isset($this->userData[$key])){
            $value = $this->userData[$key];
        }
        $this->set($key,$value);
    }    
}
