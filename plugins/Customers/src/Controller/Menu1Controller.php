<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure;
use Exception;
use Cake\Mailer\Email;

class Menu1Controller extends BaseController
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
        $this->loadModel("t_test_explain");
        $this->loadModel("pdf_group");
        $this->loadModel("pdf_exam_master");
        
        $this->loadModel("exam_master");
        $this->loadModel("exam_group_use");
        $this->loadModel("t_weight_master");
        $this->loadModel("t_element");
        $this->loadModel("t_test_pdf");


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
        


        $this->D_EXAM_BASE = $exam_master;



        $this->user = $this->Auth->user();
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();

        $this->partner = $this->TUser->find()->where(['login_id'=>$this->Auth->user("partner_loginid")])->first();
        if(empty($this->partner)) return false;

        $this->pdf_group_data = $this->pdf_group->find()
            ->contain(['PdfExamMaster'=> function ($q) {
                return $q->where(['PdfExamMaster.del' => 0]);
             }
            ])->where(['del'=>0])
            ->toArray();

        $this->weight_master = $this->t_weight_master->find()
            ->where([
                    'uid'=>$this->user->id,
                    'pid'=>$this->user->partner_id
                    ])->toArray();


        $element = $this->t_element->find()->where(['uid'=>$this->user->partner_id])->first();
        //エレメントが指定されていないときは
        //初期値を指定
        if(!$element){
            $D_ELEMENT = Configure::read("D_ELEMENT");
            $element = new \stdClass();
            $element->e_feel= $D_ELEMENT[0];
            $element->e_cus= $D_ELEMENT[1];
            $element->e_aff= $D_ELEMENT[2];
            $element->e_cntl= $D_ELEMENT[3];
            $element->e_vi= $D_ELEMENT[4];
            $element->e_pos= $D_ELEMENT[5];
            $element->e_symp= $D_ELEMENT[6];
            $element->e_situ= $D_ELEMENT[7];
            $element->e_hosp= $D_ELEMENT[8];
            $element->e_lead= $D_ELEMENT[9];
            $element->e_ass= $D_ELEMENT[10];
            $element->e_adap= $D_ELEMENT[11];


        }
        $this->element = $element;
       
        $this->D_SYSTEM_TYPE = Configure::read("D_SYSTEM_TYPE");
        $this->D_LANGUAGE_TYPE = Configure::read("D_LANGUAGE_TYPE");
        $this->D_EXAM_TIME = Configure::read("D_EXAM_TIME");
        $this->D_EXAM_TYPE = Configure::read("D_EXAM_TYPE");
        
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("pan3",__d('custom','cmenu1'));
        $this->set("panlink2","/customers/app/");
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("D_SYSTEM_TYPE",$this->D_SYSTEM_TYPE);
        $this->set("D_LANGUAGE_TYPE",$this->D_LANGUAGE_TYPE);
        $this->set("pdf_group_data",$this->pdf_group_data);
        $this->set("weight_master",$this->weight_master);
        $this->set("element",$this->element);
        $this->set("D_EXAM_TIME",$this->D_EXAM_TIME);
        $this->set("D_EXAM_TYPE",$this->D_EXAM_TYPE);
    }
    public function index($id=""){
        if($this->request->getData("id")) $id = $this->request->getData("id");
        //販売可能ライセンス
        $this->license = $this->__getRemainLicense();
        //所持している検査に属しているグループのみ取得用配列の作成
        $examGroup = $this->__checkGroup();
        
        

        //登録処理
        $this->__regist();

        //フォームに変数を登録
        $this->__setForm($id);

        $this->set("partner",$this->partner);
        $this->set("user",$this->user);
        $this->set("license",$this->license);
        $this->set("D_EXAM_BASE",$this->D_EXAM_BASE);
        $this->set("examGroup",$examGroup);
        $this->set("id",$id);


    }
    /*********************************
     * idがあるときは初期値を表示
     */
    public function __defaultData($id){
        
        //子データ取得
        $sql = "
            SELECT 
                a.* ,
                GROUP_CONCAT(pdf.pdf_id SEPARATOR ',') as pdfid
            FROM (
            SELECT 
                t.*,
                GROUP_CONCAT(t.type SEPARATOR ',') as typegroup,
                ex.explain_text as explain_text
            FROM
                t_test as t 
                LEFT JOIN t_test_explain as ex ON t.test_id=ex.test_id 

            WHERE
                t.test_id=? AND 
                t.partner_id=? AND 
                t.customer_id=?
            group by  t.test_id
            ) as a 
            LEFT JOIN t_test_pdf as pdf ON pdf.test_id = a.test_id
        ";

        $param = [];
        $param[] = $id;
        $param[] = $this->partner->id;
        $param[] = $this->user->id;
        $result = $this->connection->execute($sql,$param)->fetch('assoc');
        //親データ
        $parent = $this->t_test->find()->select([
            'rest_mail_count',
            'fin_disp',
            'judge_login',
            'enq_status',
            'pdf_slice',
            'recommen',
            'pdf_output_limit',
            'pdf_output_limit_from',
            'pdf_output_limit_to',
            'pdf_output_limit_count',
            'pdf_output_count'
        ])
        ->where([
            'id'=>$id,
            'customer_id'=>$this->user->id
        ])->first();
        $result[ 'rest_mail_count' ] = $parent->rest_mail_count;
        $result[ 'fin_disp' ] = $parent->fin_disp;
        $result[ 'judge_login' ] = $parent->judge_login;
        $result[ 'enq_status' ] = $parent->enq_status;
        $result[ 'pdf_slice' ] = $parent->pdf_slice;
        $result[ 'recommen' ] = $parent->recommen;
        $result[ 'pdf_output_limit' ] = $parent->pdf_output_limit;
        $result[ 'pdf_output_limit_from' ] = $parent->pdf_output_limit_from;
        $result[ 'pdf_output_limit_to' ] = $parent->pdf_output_limit_to;
        $result[ 'pdf_output_limit_count' ] = $parent->pdf_output_limit_count;
        $result[ 'pdf_output_count' ] = $parent->pdf_output_count;

        //ログイン説明文
        

        return $result;

    }
    /******************************
     * 所持している検査に属しているグループのみ取得用配列の作成
     */
    public function __checkGroup(){
        $licensecheck = [];
        foreach($this->license['lists'] as $values){
            $licensecheck[$values['type']] = $values['remain'];
        }
        $examGroup = [];
        foreach($this->D_EXAM_BASE as $values){
            foreach($values['exam_master'] as $val){
                if(
                    isset($licensecheck[$val['key']]) && 
                    $licensecheck[$val['key']] > 0 ){
                    
                    $examGroup[$values[ 'group_id' ]] = $values[ 'name' ];
                }
            }
        }
        return $examGroup;
    }

    
    /********************************
     * フォームに変数を登録
     */
    public function __setForm($id = ""){

        //idがあるときは初期値を表示
        $default = [];
        if($id > 0 && !$this->request->is('post')){
            $default = $this->__defaultData($id);
        }
        //受検登録数 / 未受検者数の取得
        $examcount = [];
        if($id > 0){
            $examcount['examcount'] = $this->t_testpaper->find()
            ->select(['id'])
            ->where([
                'testgrp_id'=>$id,
                'customer_id'=>$this->user->id
            ])
            ->group(['number'])
            ->count();
        
            $examcount['notexamcount'] = $examcount['examcount'] - $this->t_testpaper->find()
            ->select(['id'])
            ->where([
                'testgrp_id'=>$id,
                'customer_id'=>$this->user->id,
                'exam_state '=>1
            ])
            ->group(['number'])
            ->count();

        }

        
        $name = $this->request->getData("name");
        if( empty($name) && isset($default[ 'name' ]) ) $name = $default[ 'name' ];
        $number = $this->request->getData("number");

        $rest_mail_count = $this->request->getData("rest_mail_count");
        if(isset($default[ 'rest_mail_count' ]) && empty($rest_mail_count)) $rest_mail_count = $default[ 'rest_mail_count' ];
        
        $this->set("name",$name);
        $this->set("number",$number);
        $this->set("rest_mail_count",$rest_mail_count);
        $this->set("examcount",$examcount);

        //検査実施期間
        $period_from = $this->request->getData("period_from");
        if(empty($period_from) && isset($default[ 'period_from' ]) ) $period_from = $default[ 'period_from' ];

        $period_to = $this->request->getData("period_to");
        if(empty($period_to) && isset($default[ 'period_to' ]) ) $period_to = $default[ 'period_to' ];
        
        $this->set("period_from",$period_from);
        $this->set("period_to",$period_to);
        
        //検査結果画面
        $disp_fin = 1;
        if(
            !$this->request->is("post") && 
            isset($default[ 'fin_disp' ])){
            $disp_fin = $default[ 'fin_disp' ];
        }
        $disp_fin = (!empty($this->request->getData("disp_fin")))?$this->request->getData("disp_fin"):$disp_fin;
        $this->set("disp_fin",$disp_fin);

        //事前環境チェックの有無
        $judge_login = 0;
        if(
            !$this->request->is("post") && 
            isset($default[ 'judge_login' ])){
            $judge_login = $default[ 'judge_login' ];
        }
        $judge_login = (!empty($this->request->getData("judge_login")))?$this->request->getData("judge_login"):$judge_login;
        $this->set("judge_login",$judge_login);

        //強みアンケート利用
        $enq_status = 0;
        if(
            !$this->request->is("post") && 
            isset($default[ 'enq_status' ])){
            $enq_status = $default[ 'enq_status' ];
        }
        $enq_status = (!empty($this->request->getData("enq_status")))?$this->request->getData("enq_status"):$enq_status;

        $this->set("enq_status",$enq_status);
        
        //一括ダウンロード設定
        $pdf_slice = 0;
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdf_slice' ])){
            $pdf_slice = $default[ 'pdf_slice' ];
        }
        $pdf_slice = (!empty($this->request->getData("pdf_slice")))?$this->request->getData("pdf_slice"):$pdf_slice;
        $this->set("pdf_slice",$pdf_slice);
        

        //推奨ブラウザ説明文
        $recommen = 1;
        if(
            !$this->request->is("post") && 
            isset($default[ 'recommen' ])){
            $recommen = $default[ 'recommen' ];
        }
        $recommen = (!empty($this->request->getData("recommen")))?$this->request->getData("recommen"):$recommen;
        $this->set("recommen",$recommen);
        
        
        //ログイン説明文
        $explain = "";
        if(
            !$this->request->is("post") && 
            isset($default[ 'explain_text' ])){
            $explain = $default[ 'explain_text' ];
        }
        $explain = (!empty($this->request->getData("explain")))?$this->request->getData("explain"):$explain;
        $this->set("explain",$explain);
        $loginDisp = 0;
        if(isset($explain) > 0 ) $loginDisp = 1;
        $this->set("loginDisp",$loginDisp);


        //PDF出力期間を設定する
        $pdf_output_limit = 0;
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdf_output_limit' ])){
            $pdf_output_limit = $default[ 'pdf_output_limit' ];
        }
        $pdf_output_limit = (!empty($this->request->getData("pdf_output_limit")))?$this->request->getData("pdf_output_limit"):$pdf_output_limit;
        $this->set("pdf_output_limit",$pdf_output_limit);


        $pdf_output_limit_from = $this->request->getData("pdf_output_limit_from");
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdf_output_limit_from' ]) && 
            $default[ 'pdf_output_limit_from' ] != "0000-00-00"){
            $pdf_output_limit_from = $default[ 'pdf_output_limit_from' ];
        }
        
        $pdf_output_limit_to = $this->request->getData("pdf_output_limit_to");
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdf_output_limit_to' ]) && 
            $default[ 'pdf_output_limit_to' ] != "0000-00-00"){
            $pdf_output_limit_to = $default[ 'pdf_output_limit_to' ];
        }
        
        $this->set("pdf_output_limit_from",$pdf_output_limit_from);
        $this->set("pdf_output_limit_to",$pdf_output_limit_to);


        //PDF出力人数を設定する
        $pdf_output_limit_count = 0;
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdf_output_limit_count' ])){
            $pdf_output_limit_count = $default[ 'pdf_output_limit_count' ];
        }


        $pdf_output_limit_count = (!empty($this->request->getData("pdf_output_limit_count")))?$this->request->getData("pdf_output_limit_count"):$pdf_output_limit_count;
        $this->set("pdf_output_limit_count",$pdf_output_limit_count);
        
        $pdf_output_count = 0;
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdf_output_count' ])){
            $pdf_output_count = $default[ 'pdf_output_count' ];
        }

        $pdf_output_count = (!empty($this->request->getData("pdf_output_count")))?$this->request->getData("pdf_output_count"):$pdf_output_count;
        $this->set("pdf_output_count",$pdf_output_count);

        //検査情報詳細設定
        
        $typegroup = [];
        if(!$this->request->is("post") ){
            if(isset($default[ 'typegroup' ])){
                $typegroup = explode(",",$default[ 'typegroup' ]);
            }
        }
        $this->set("typegroup",$typegroup);

        //受検者数
        $jyukensyasu = "-";
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdf_output_limit_count' ])){
            $jyukensyasu = $default[ 'number' ];
        }

        $this->set("jyukensasu",$jyukensyasu);
        $childtest = [];
        //テスト子データの取得
        foreach($typegroup as $value){
            $childtest[$value] = $this->__getChildTest($value,$default);
        }
        $this->set("childtest",$childtest);
        /**************
         * BA(行動価値検査)
         */
        
        //検査情報詳細設定
        $selectType = $this->request->getData("selectType");
        $this->set("selectType",$selectType);
        //重みマスタからデータ取得
        $masters = $this->request->getData("masters");
        $this->set("masters",$masters);
        //重みマスタからデータ取得
        $weight = $this->request->getData("weight");
        $this->set("weight",$weight);
        //３要素を用いるストレス共生力算出
        $stress = $this->request->getData("stress");
        
        $this->set("stress",$stress);
        //重み付け利用
        $weightchecked = $this->request->getData("weightchecked");
        $this->set("weightchecked",$weightchecked);


        /**************
         * NL(ＮＬ検査)
         */
        //受検時間設定
        $minute_rest = $this->request->getData("minute_rest");
        $this->set("minute_rest",$minute_rest);

        /*************************
         * VF(ＶＦ検査)
         */
        //検査対象者入力
        $vf4_object = $this->request->getData("vf4_object");
        $this->set("vf4_object",$vf4_object);

        /************************
         * PDF出力形式選択
         */

        $pdf = [];
        if(
            !$this->request->is("post") && 
            isset($default[ 'pdfid' ])){
            $ex = explode(",",$default[ 'pdfid' ]);
            foreach($ex as $value){
                $pdf[$value] = "on"; 
            }
        }

        $pdf = (!empty($this->request->getData("pdf")))?$this->request->getData("pdf"):$pdf;
        $this->set("pdf",$pdf);



    }
    /************************
     * 子供データの取得
     */
    public function __getChildTest($type,$default){
 
        $testdata = $this->t_test->find()->where([
            'customer_id'=>$default[ 'customer_id' ],
            'test_id'=>$default[ 'test_id' ],
            'type'=>$type
        ])->first();
        return $testdata;
    }
    /**********************************
     * 登録処理
     */
    
    public function __regist(){

        if($this->request->is('post')){
            
            
            $testpaper = $this->t_testpaper->newEntity();
            $testpaper = $this->t_testpaper->patchEntity($testpaper,$this->request->data);
            
            $test = $this->t_test->newEntity();
            $this->t_test->setLicense($this->license);
            $this->t_test->setRequest($this->request->getData());
            if($this->request->getData("id") > 0 ){
                $test = $this->t_test->patchEntity($test,$this->request->data,['validate'=>'edit']);
            }else{
                $test = $this->t_test->patchEntity($test,$this->request->data);
            }

            if(
                count($test->errors())
            ){
                if($test->errors('name._empty')) $this->Flash->error($test->errors('name._empty'));
                if($test->errors('number._empty')) $this->Flash->error($test->errors('number._empty'));
                if($test->errors('number.numeric')) $this->Flash->error($test->errors('number.numeric'));
                if($test->errors('number.message')) $this->Flash->error($test->errors('number.message'));

                if($test->errors('RegNumber.numeric')) $this->Flash->error($test->errors('RegNumber.numeric'));

                if($test->errors('number.rest_mail_count')) $this->Flash->error($test->errors('number.rest_mail_count'));
                if($test->errors('period_from._empty')) $this->Flash->error($test->errors('period_from._empty'));
                if($test->errors('period_to._empty')) $this->Flash->error($test->errors('period_to._empty'));
                if($test->errors('selectType.message')) $this->Flash->error($test->errors('selectType.message'));
            }else{

                //ユニークID
                $this->uniq = uniqid();

                //t_testテーブルに登録
                if($this->request->getData("id")){
                    $this->log("[ID : ".$this->user->id."]検査更新");
                }else{
                    $this->log("[ID : ".$this->user->id."]検査登録");
                }

                
                $this->connection->begin();

                try{
                    
                    //親テーブル登録
                    $parentid = $this->__setParentTest();
                    
                    if($parentid > 0){
                        
                        //PDFダウンロード
                        $this->__setPDFdownload($parentid);
                     
                        //ログイン説明文登録
                        $this->__setExplain($parentid);
                    
                        //子テーブル登録
                        $this->__setChildTest($parentid);
                    
                        
                        //登録用メール配信
                        $this->component->uniq = $this->uniq;

                        
                        
                    }

                }catch(Exception $e){
                    // ロールバック
                    $this->connection->rollback();
                }
                
                // コミット
                $this->connection->commit();

                //メール配信
                if($this->request->getData("id")){
                    //更新用メール
                    //顧客にメール配信
                    $this->component->___sendEditMail($this->user,1);
                    //パートナーにメール配信
                    $this->component->___sendEditMail($this->user,2);
                }else{
                    //新規登録用メール
                    $this->component->___sendRegistMail($this->user,$this->partner,1);
                    $this->component->___sendRegistMail($this->user,$this->partner,2);
                }

                
                $this->Flash->success(__d("custom","vf_success"));

                if($this->request->getData("id")){
                    return $this->redirect(['action' => '/'.$this->request->getData("id")]);
                }else{
                    return $this->redirect(['action' => 'index']);
                }
            }
        }

    }

    
    /**************************
     * PDFダウンロード
     */
    public function __setPDFdownload($parentid){
        $pdf = $this->request->getData("pdf");
        if($this->request->getData("id") ){
            //登録前に削除
            $param = array('test_id' => $this->request->getData('id'));
            $this->t_test_pdf->deleteAll($param);
        }
        if(count($pdf)){
            foreach($pdf as $key=>$value){
                
                $t_test_pdf = $this->t_test_pdf->newEntity();
                $t_test_pdf->test_id=$parentid;
                $t_test_pdf->pdf_id=$key;
                $t_test_pdf->regist_ts = date("Y-m-d H:i:s");
                $this->t_test_pdf->save($t_test_pdf);

            }
        }
        return true;
    }
    /******************
     * ログイン説明文
     */
    public function __setExplain($parentid){
        
        if($this->request->getData("id") ){
            //登録前に削除
            $param = [];
            $param = array('test_id' => $this->request->getData('id'));
            $this->t_test_explain->deleteAll($param);
        }

        $t_test_explain = $this->t_test_explain->newEntity();
        $t_test_explain->test_id=$parentid;
        $t_test_explain->loginDisp=$this->request->getData("loginDisp");
        $t_test_explain->explain_text=$this->request->getData("explain");
        $t_test_explain->regist_ts=date("Y-m-d H:i:s");
        $this->t_test_explain->save($t_test_explain);

        return true;
    }
    /*********************
     * 子テーブル登録
     */
    public function __setChildTest($parentid){

        if($this->request->getData("id") ){
            //登録前に削除
            $param = [];
            $param['test_id'] = $this->request->getData('id');
            $param['partner_id'] = $this->user->partner_id;
            $this->t_test->deleteAll($param);
        }

        $selectType = $this->request->getData("selectType");
        $stress = $this->request->getData("stress");
        $weightchecked = $this->request->getData("weightchecked");
        $weight = $this->request->getData("weight");
        $minute_rest = $this->request->getData("minute_rest");
        $vf4_object = $this->request->getData("vf4_object");
        foreach($selectType as $values){
            if($values > 0 ){
                $test = $this->t_test->newEntity();
                $test->eir_id = 1;
                $test->partner_id  = $this->user->partner_id;
                $test->customer_id = $this->user->id;
                $test->test_id = $parentid;
                $test->name = $this->request->getData("name");
                $test->period_from = $this->request->getData("period_from");
                $test->period_to = $this->request->getData("period_to");
                $test->number = $this->request->getData("number");

                if($this->request->getData("id") > 0 ){
                    //追加
                    if($this->request->getData('exam_type') == 1 && $this->request->getData("RegNumber")){
                        $test->number = (int)$this->request->getData("number")+(int)$this->request->getData("RegNumber");
                    }
                    //削除
                    if($this->request->getData('exam_type') == 2 && $this->request->getData("RegNumber")){
                        $test->number = (int)$this->request->getData("number")-(int)$this->request->getData("RegNumber");
                    }
                }else{
                    $test->dir = $this->uniq;
                }
                
                $test->fin_disp = $this->request->getData("disp_fin");
                $test->rest_mail_count = $this->request->getData("rest_mail_count");
                $test->type = $values;
                //３要素を用いるストレス共生力算出
                if(isset($stress[$values]) && strlen($stress[$values]) > 0 ){
                    $test->stress_flg = $stress[$values];
                }   
                //重み付け利用
                if(isset($weightchecked[$values]) && strlen($weightchecked[$values]) > 0 ){
                    $test->weight = $weightchecked[$values];
                }
                
                if(isset($weight[$values]['w1']) && strlen($weight[$values]['w1']) > 0 ) $test->w1 = $weight[$values]['w1'];
                if(isset($weight[$values]['w2']) && strlen($weight[$values]['w2']) > 0 ) $test->w2 = $weight[$values]['w2'];
                if(isset($weight[$values]['w3']) && strlen($weight[$values]['w3']) > 0 ) $test->w3 = $weight[$values]['w3'];
                if(isset($weight[$values]['w4']) && strlen($weight[$values]['w4']) > 0 ) $test->w4 = $weight[$values]['w4'];
                if(isset($weight[$values]['w5']) && strlen($weight[$values]['w5']) > 0 ) $test->w5 = $weight[$values]['w5'];
                if(isset($weight[$values]['w6']) && strlen($weight[$values]['w6']) > 0 ) $test->w6 = $weight[$values]['w6'];
                if(isset($weight[$values]['w7']) && strlen($weight[$values]['w7']) > 0 ) $test->w7 = $weight[$values]['w7'];
                if(isset($weight[$values]['w8']) && strlen($weight[$values]['w8']) > 0 ) $test->w8 = $weight[$values]['w8'];
                if(isset($weight[$values]['w9']) && strlen($weight[$values]['w9']) > 0 ) $test->w9 = $weight[$values]['w9'];
                if(isset($weight[$values]['w10']) && strlen($weight[$values]['w10']) > 0 ) $test->w10 = $weight[$values]['w10'];
                if(isset($weight[$values]['w11']) && strlen($weight[$values]['w11']) > 0 ) $test->w11 = $weight[$values]['w11'];
                if(isset($weight[$values]['w12']) && strlen($weight[$values]['w12']) > 0 ) $test->w12 = $weight[$values]['w12'];
                if(isset($weight[$values]['ave']) && strlen($weight[$values]['ave']) > 0 ) $test->ave = $weight[$values]['ave'];
                if(isset($weight[$values]['sd']) && strlen($weight[$values]['sd']) > 0 ) $test->sd = $weight[$values]['sd'];

                //受検時間設定
                if(isset($minute_rest[$values]) && strlen($minute_rest[$values]) > 0 ){
                    $test->minute_rest = $minute_rest[$values];
                }
                //検査対象者入力
                if(isset($vf4_object[$values]) && strlen($vf4_object[$values]) > 0 ){
                    $test->vf4_object = $vf4_object[$values];
                }


                $test->enabled = 1;
                $test->del = 0;
                $test->registtime = date("Y-m-d H:i:s");

                $this->t_test->save($test);
                $last_insert_id = $test->id;
                //テスト詳細登録
                //編集の時はテストの追加か削除
                $id = sprintf("%d",$this->request->getData("id"));
                if($id > 0 ){
                    if($this->request->getData('exam_type') == 1){
                        //追加
                        $this->__setTTestPaper($parentid,$parentid,$values);
                    }
                }else{
                    $this->__setTTestPaper($last_insert_id,$parentid,$values);
                }
            }
        }

        if($this->request->getData("id") && $this->request->getData('exam_type') == 2){
            //テーブル詳細削除
            $this->__setTTestPaperdel($parentid);
        }

    }
    /**************************
     * テスト詳細削除
     */
    public function __setTTestPaperdel($test_id){
        //削除用データ取得
        $RegNumber =sprintf("%d", $this->request->getData("RegNumber"));
        $delete = $this->t_testpaper->find()->where([
            'customer_id'=>$this->user->id,
            'partner_id'=>$this->user->partner_id,
            'testgrp_id'=>$test_id,
        ])
        ->select(['number'])
        ->group(['number'])
        ->order(['number'=>'DESC'])
        ->limit($RegNumber)
        ->toArray();

        //削除処理
        foreach($delete as $value){
            $param['testgrp_id'] = $test_id;
            $param['number'] = $value['number'];
            $this->t_testpaper->deleteAll($param);
        }
    }
    /**************************
     * テスト詳細登録
     */
    public function __setTTestPaper($test_id,$group_id,$type){
                
        $RegNumber =sprintf("%d", $this->request->getData("RegNumber"));
        if($RegNumber){
            //開始番号
            $rlt = $this->t_testpaper->find()->where([
                'customer_id'=>$this->user->id,
                'partner_id'=>$this->user->partner_id,
                'testgrp_id'=>$group_id,
                'type'=>$type
            ])
            ->select(['number'])
            ->max('number')
            ->toArray();
            //追加
            $start = $rlt['number']+1;
            $loop = $RegNumber+$rlt[ 'number' ];
        }else{
            if($this->request->getData("id")){
                //更新時にテスト詳細の追加更新がなかった時
                return 0;
            }else{
                //新規登録時
                $loop = sprintf("%d",$this->request->getData("number"));
                $start = 1;
            }
        }
        for($i=$start;$i<=$loop;$i++){
            $t_testpaper = $this->t_testpaper->newEntity();
            $t_testpaper->number=$i;
            $t_testpaper->partner_id=$this->user->partner_id;
            $t_testpaper->customer_id=$this->user->id;
            $t_testpaper->test_id=$test_id;
            $t_testpaper->testgrp_id=$group_id;
            //ランダムな3桁取得
            $t_testpaper->exam_id = $this->__getRandomExamid($group_id,$i);
            $t_testpaper->type = $type;
            $this->t_testpaper->save($t_testpaper);
        }

    }

    /*************************
     * 親テーブル登録
     */
    public function __setParentTest(){
        $test = $this->t_test->newEntity();
        //編集
        if($this->request->getData("id") > 0 ){
            $test = $this->t_test->get($this->request->getData("id"));
        }

        $test->eir_id = 1;
        $test->partner_id  = $this->user->partner_id;
        $test->customer_id = $this->user->id;
        $test->test_id = 0;
        $test->name = $this->request->getData("name");
        $test->period_from = $this->request->getData("period_from");
        $test->period_to = $this->request->getData("period_to");

        $test->number = $this->request->getData("number");
        if($this->request->getData("id") > 0 ){
            //追加
            if($this->request->getData('exam_type') == 1){
                $test->number = (int)$this->request->getData("number")+(int)$this->request->getData("RegNumber");
            }
            //削除
            if($this->request->getData('exam_type') == 2){
                $test->number = (int)$this->request->getData("number")-(int)$this->request->getData("RegNumber");
            }
        }else{
            $test->dir = $this->uniq;
        }

        $test->fin_disp = $this->request->getData("disp_fin");
        $test->type = 0;
        $test->weight = 0;
        $test->enabled = 1;
        $test->del = 0;
        if(!$this->request->getData("id")){
            $test->registtime = date("Y-m-d H:i:s");
        }
        $test->judge_login = $this->request->getData("judge_login");
        $test->rest_mail_count = sprintf("%d",$this->request->getData("rest_mail_count"));
        $test->enq_status = $this->request->getData("enq_status");
        $test->pdf_slice = $this->request->getData("pdf_slice");
        $test->recommen = $this->request->getData("recommen");
        $test->pdf_output_limit = $this->request->getData("pdf_output_limit");
        $test->pdf_output_limit_from = $this->request->getData("pdf_output_limit_from");
        $test->pdf_output_limit_to = $this->request->getData("pdf_output_limit_to");
        $test->pdf_output_limit_count = $this->request->getData("pdf_output_limit_count");
        $test->pdf_output_count = sprintf("%d",$this->request->getData("pdf_output_count"));
        
        $this->t_test->save($test);

        $last_insert_id = $test->id;

        return $last_insert_id;
        
    }
    /***************************
     * ランダムな3桁取得
     */
    public function __getRandomExamid($gid,$number){
        $length=3;
        $return = "";

        //既に同じ番号で検査IDが指定されていたらそのまま利用する
        $row = $this->t_testpaper->find()->where([
            'testgrp_id'=>$gid,
            'number'=>$number
        ])->first();
        if(count($row) > 0 ){
            return $row[ 'exam_id' ];
        }
        do{
            $rand = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
            $row = $this->t_testpaper->find()->where([
                'exam_id'=>$rand,
                'testgrp_id'=>$gid
            ])->count();
            $flg = "";
            if($row > 0){
                $flg = true;
                $return = "";
            }else{
                $flg = false;
                $return = $rand;
            }
        }while($flg);
        return $return;
    }
    /*********************************
     * 重み付け取得
     */
    public function getWeightMaster($id=""){
        $this->autoRender = false;
        //var_dump($id,$this->user->partner_id);
        if(
          //  true || 
            $this->request->is("ajax")){
            $data = $this->t_weight_master->find()
            ->where([
                "id"=>$id,
                "pid"=>$this->user->partner_id
            ])->first();
            
            $this->log("[".$this->user->id."]重み付け取得データ(".$id.")入れ替え顧客画面");
            if(count($data) < 1){
                return false;
            }else{
                return $this->getResponse()->withType('json')->withStringBody(json_encode($data));
            }
        }

    }
    /************************
     * 販売可能ライセンス
     */
    public function __getRemainLicense(){
        $sql = "
        SELECT 
            type,
            b.buyNumber-count(*) as remain
        FROM 
            t_testpaper as tt 
            LEFT JOIN buy_license as b ON b.uid=tt.partner_id AND b.exam_key = tt.type
            LEFT JOIN exam_master as ex ON ex.key=tt.type
        where 
            tt.partner_id=? AND 
            b.uid = ? AND 
            ex.del = 0
        group by tt.type
        ORDER BY tt.type
        ";
        $param = [];
        $param[] = $this->partner->id;
        $param[] = $this->partner->id;
        $result = $this->connection->execute($sql,$param)->fetchAll('assoc');

        //検査用配列の変更
        $exam = [];
        foreach($this->D_EXAM_BASE as $value){
            foreach($value[ 'exam_master' ] as $v){
                $k = $v['key'];
                $exam[$k] = $v[ 'name' ];
            }
        }
        //合計数
        $sum = 0;
        foreach($result as $key=>$val){
            $result[$key][ 'typename' ] = $exam[$val[ 'type' ]];
            $sum += $val[ 'remain' ];
        }

        $results[ 'lists' ] = $result;
        $results[ 'total' ] = $sum;
        return $results;
    }

    /*********************
     * 重みテンプレート
     */
    public function temp(){
        $this->autoRender = false;
        $this->component->weightTemplateCSV();
    }
}
