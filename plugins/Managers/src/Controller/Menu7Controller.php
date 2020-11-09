<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;
use Cake\Core\Configure; 
use Cake\Error\Debugger;
use TCPDF;
use Cake\Routing\Router;

class Menu7Controller extends BaseController
{
    public $paginate = [
        'limit' => D_LIMIT50,
        'order' => [
            'TBill.id' => 'desc' 
        ]
    ];
    public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates']
    ];

    public function initialize()
    {
        parent::initialize();
        I18n::setLocale('ja_JP');
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("TBill");
        $this->loadModel("TBillList");
        $this->set("pan",__('menu7'));
        $this->set("title",$this->Auth->user('name'));
        $this->set("billNumber","");
        $this->set("company_name","");
        $this->set("senddate","");
        $this->set("kenmei","");
        $this->set("download_status","");
        $this->set("pdf_status",Configure::read("D_PDF_STATUS"));
        $this->set("tax",D_TAX);
        $this->session = $this->getRequest()->getSession();
    }
    //請求書一覧
    public function index(){
        $this->log("[".$this->Auth->user("login_id")."]請求書一覧ページ表示");
        $query = $this->TBill->find();
        if($this->request->getData("billNumber")) $query = $query->where(["bill_num LIKE "=>"%".$this->request->getData("billNumber")."%" ]);
        if($this->request->getData("company_name")) $query = $query->where(["name LIKE "=>"%".$this->request->getData("company_name")."%" ]);
        if($this->request->getData("kenmei")) $query = $query->where(["title LIKE "=>"%".$this->request->getData("kenmei")."%" ]);
        if(strlen($this->request->getData("download_status")) > 0  ) $query = $query->where(["download_status"=>$this->request->getData("download_status") ]);
        $senddate = preg_replace("/\//","-",$this->request->getData("senddate"));
        if($this->request->getData("senddate")) $query = $query->where(["update_ts LIKE "=>"%".$senddate."%" ]);

        $query = $query->order(['update_ts'=>'DESC']);
        $bill = $this->paginate($query);
        $this->set("bill",$bill);
        $this->set("billNumber",$this->request->getData("billNumber"));
        $this->set("company_name",$this->request->getData("company_name"));
        $this->set("senddate",$this->request->getData("senddate"));
        $this->set("kenmei",$this->request->getData("kenmei"));
        $this->set("download_status",$this->request->getData("download_status"));
    }
    //請求書ダウンロード
    public function recipe(){
        
        //請求書登録
        $entity = $this->TBill->newEntity();
        
        if($this->request->is('post')){
            $entity= $this->TBill->patchEntity($entity, $this->request->getData());
            if(count($entity->errors()) == 0){
                //請求書番号の重複チェック
                //重複していればupdateを行う
                $data = self::__getBillData($this->request->getData('bill_num'));
                if(!empty($data)){
                    $entity->id = $data['id'];
                }

                //登録を行う
                $entity->pay_date=sprintf("%04d-%02d-%02d"
                        ,$this->request->getData("pay_date_year")
                        ,$this->request->getData("pay_date_month")
                        ,$this->request->getData("pay_date_day")
                    );
                $entity->registdate=sprintf("%04d-%02d-%02d"
                        ,$this->request->getData("registdate_year")
                        ,$this->request->getData("registdate_month")
                        ,$this->request->getData("registdate_day")
                    );
                $connection = ConnectionManager::get('default');
                $connection->begin();
                try{
                    if($this->TBill->save($entity)){
                        $billid = $entity->id;
                        //請求書詳細登録
                        $bill = $this->request->getData("bill");
                        //保存の前に既に登録しているt_bill_idがある場合は削除を行う
                        self::__deleteBillDetail($billid);
                        foreach($bill as $key=>$val){
                            if($val[ "article" ]){
                                $entitylist = $this->TBillList->newEntity();
                                $entitylist->t_bill_id = $billid;
                                $entitylist->number=$key;
                                $entitylist->name=$val["article"];
                                $entitylist->brand=$val["brand"];
                                $entitylist->kikaku=$val["standard"];
                                $entitylist->count=(int)$val["number"];
                                $entitylist->unit=$val["unit"];
                                $entitylist->money=(int)$val["unitprice"];
                                $entitylist->price=(int)$val["price"];
                                $entitylist->regist_ts=date("Y-m-d H:i:s");
                                $this->TBillList->save($entitylist);
                            }

                        }
                        $connection->commit();
                        $this->log("[".$this->Auth->user("login_id")."]請求書データ保存");
                    }
                }catch(Exception $e){
                    $this->log("[".$this->Auth->user("login_id")."]請求書データ保存失敗");
                    $connection->rollback();
                }

                //請求書ダウンロード
                $this->log("[".$this->Auth->user("login_id")."]請求書ダウンロード"); 
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');
                $pdf->SetFont('ipagp');
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetMargins(5.5, 5.5,5.5 );
                $pdf->SetAutoPageBreak(false);
                $pdf->AddPage();
                //社判画出力
                if($this->request->getData("syahan_sts")){
                    $pdf->Image(Router::url("/", true)."/webroot/img/innovation.gif",175,75,20,20);
                }
                $html = file_get_contents(WWW_ROOT."pdf/billTemp.ctp");

                //請求書置き換え
                $html = self::__replaceHtml($html);                

                $pdf->writeHTML($html, false);
                $pdfName = $this->request->getData("bill_num");
                echo $pdf->Output($pdfName.".pdf", 'D');
                exit();
            }else{
                
                if($entity->errors('title._empty')) $this->Flash->error($entity->errors('title._empty'));
                if($entity->errors('bill_num._empty')) $this->Flash->error($entity->errors('bill_num._empty'));
            }
            self::___setBillInfo();
            $this -> render ( "write" );
        }else{
            return $this->redirect(['action' => 'write']);
        }
    }
    //請求書詳細削除
    public function __deleteBillDetail($billid){
        try{
            $this->TBillList->deleteAll(['t_bill_id'=>$billid]);
            
        }catch(Exception $e){
            $this->log("[".$this->Auth->user("login_id")."]請求書詳細データ削除失敗");
            $this->rollback();
        }
        $this->log("[".$this->Auth->user("login_id")."]請求書詳細データ削除成功");
    }
    //内容置き換え
    public function __replaceHtml($html){
        

        $html = preg_replace("/##post1##/",$this->request->getData("post1"),$html);
        $html = preg_replace("/##post2##/",$this->request->getData("post2"),$html);
        $html = preg_replace("/##address##/",$this->request->getData("address"),$html);
        $html = preg_replace("/##address2##/",$this->request->getData("address2"),$html);
        $html = preg_replace("/##name##/",$this->request->getData("name"),$html);
        $html = preg_replace("/##busyo##/",$this->request->getData("busyo"),$html);
        $html = preg_replace("/##yakusyoku##/",$this->request->getData("yakusyoku"),$html);
        $html = preg_replace("/##atena##/",$this->request->getData("atena"),$html);
        $html = preg_replace("/##money_total##/",number_format((int)$this->request->getData("money_total")),$html);
        $html = preg_replace("/##title##/",$this->request->getData("title"),$html);
        $html = preg_replace("/##pay_date_year##/",$this->request->getData("pay_date_year"),$html);
        $html = preg_replace("/##pay_date_month##/",$this->request->getData("pay_date_month"),$html);
        $html = preg_replace("/##pay_date_day##/",$this->request->getData("pay_date_day"),$html);
        $html = preg_replace("/##pay_bank##/",$this->request->getData("pay_bank"),$html);
        $html = preg_replace("/##pay_num##/",$this->request->getData("pay_num"),$html);
        $html = preg_replace("/##pay_name##/",$this->request->getData("pay_name"),$html);
        $html = preg_replace("/##bill_num##/",$this->request->getData("bill_num"),$html);
        $html = preg_replace("/##registdate_year##/",$this->request->getData("registdate_year"),$html);
        $html = preg_replace("/##registdate_month##/",$this->request->getData("registdate_month"),$html);
        $html = preg_replace("/##registdate_day##/",$this->request->getData("registdate_day"),$html);
        $html = preg_replace("/##company_post1##/",$this->request->getData("company_post1"),$html);
        $html = preg_replace("/##company_post2##/",$this->request->getData("company_post2"),$html);
        $html = preg_replace("/##company_address##/",$this->request->getData("company_address"),$html);
        $html = preg_replace("/##company_address2##/",$this->request->getData("company_address2"),$html);
        $html = preg_replace("/##company_name##/",$this->request->getData("company_name"),$html);
        $html = preg_replace("/##company_telnum##/",$this->request->getData("company_telnum"),$html);
        
        //担当者画像
        if($this->request->getData("tantohan_sts")){
            $html = preg_replace("/##tanto_image##/","<img src=\"/webroot/img/sasaki.gif\" class=\"img\" />",$html);
        }else{
            $html = preg_replace("/##tanto_image##/","",$html);
        }
        //請求書一覧
        $billtable = "";
        for($i=0;$i<15;$i++){
            $num = $i+1;
            $bill = $this->request->getData("bill");

            $billtable .= "<tr>";
            $billtable .= "<td>".$num."</td>";
            $billtable .= "<td class=\"l\">".htmlspecialchars($bill[$num]['article'])."</td>";
            $billtable .= "<td class=\"l\">".htmlspecialchars($bill[$num]['brand'])."</td>";
            $billtable .= "<td class=\"l\">".htmlspecialchars($bill[$num]['standard'])."</td>";
            $billtable .= "<td>".htmlspecialchars($bill[$num]['number'])."</td>";
            $billtable .= "<td class=\"l\">".htmlspecialchars($bill[$num]['unit'])."</td>";
            $yen = "";
            $unitprice = "";
            if($bill[$num]['unitprice']){
                $yen = "円";
                $unitprice = number_format((int)$bill[$num]['unitprice']);
            }
            $billtable .= "<td >".$unitprice.$yen."</td>";
            $yen = "";
            $price = "";
            if($bill[$num]['price']){
                $yen = "円";
                $price = number_format((int)$bill[$num]['price']);
            }
            $billtable .= "<td>".$price.$yen."</td>";
            $billtable .= "</tr>";
        }
        $html = preg_replace("/##billtable##/",$billtable,$html);
        $other = $this->request->getData("other");
        $html = preg_replace("/##other##/",$other,$html);

        return $html;
    }
    //請求書作成
    //bill_numがあるときはデータ更新
    public function write($bill_num = ""){
        self::___setBillInfo($bill_num);
    }

    //請求書Noを元にデータ取得
    public function __getBillData($bill_num){
        $data = $this->TBill
            ->find()
            ->where(['bill_num ' => $bill_num])
            ->first();
            ;
        if(isset($data->id)){
            $detail = $this->TBillList
                    ->find()
                    ->select([
                        'article'=>'name'
                        ,'brand'=>'brand'
                        ,'standard'=>'kikaku'
                        ,'number'=>'count'
                        ,'unit'=>'unit'
                        ,'money'=>'money'
                        ,'unitprice'=>'price'
                        ])
                    ->where(['t_bill_id'=>$data->id])
                    ->toArray()
                    ;
            $data['detail'] = $detail;
        }
        return $data;
    }
    
    //請求書情報表示
    public function ___setBillInfo($bill_num = ""){
        $this->set("languageArea","false");

        //請求書No取得
        //bill_numが引数にない時は新たに作成
        if($bill_num == ""){
            $bill_num = self::___getBillNum();
        }
        $billData = [];
        if($bill_num){
            //請求書Noを元にデータ取得
            $billData = self::__getBillData($bill_num);
        }

        //発行日取得
        $regdate = "";
        if(isset($billData['registdate'])){
            $regdate = $billData['registdate'];
        }
        $registdate = self::__getRegistDate($regdate);
        
        $this->log("[".$this->Auth->user("login_id")."]請求書記載");
        $this->set("pan",__('menu7'));
        $this->set("panlink","/managers/menu7");
        $this->set("pan2",__('menu7sub3'));
        

        //郵便番号1
        self::__setVariable("post1",$billData);
        //郵便番号2
        self::__setVariable("post2",$billData);
        //住所
        self::__setVariable("address",$billData);
        //住所2
        self::__setVariable("address2",$billData);
        //発行先名
        self::__setVariable("name",$billData);
        //部署
        self::__setVariable("busyo",$billData);
        //役職
        self::__setVariable("yakusyoku",$billData);
        //宛名
        self::__setVariable("atena",$billData);
        //請求金額
        self::__setVariable("money_total",$billData);
        //件名
        self::__setVariable("title",$billData);

        //御支払日
        $pd = "";
        if(isset($billData[ 'pay_date' ])){
            $pddate = get_object_vars($billData[ 'pay_date' ]);
            $pd = $pddate[ 'date' ];
        }
        $pay_date = self::__getPayDate($pd);
        $pay_date_year = ($this->request->getData('pay_date_year'))?$this->request->getData('pay_date_year'):$pay_date[0];
        $pay_date_month = ($this->request->getData('pay_date_month'))?$this->request->getData('pay_date_month'):$pay_date[1];
        $pay_date_day = ($this->request->getData('pay_date_day'))?$this->request->getData('pay_date_day'):$pay_date[2];
        $this->set("pay_date_year",$pay_date_year);
        $this->set("pay_date_month",$pay_date_month);
        $this->set("pay_date_day",$pay_date_day);

        //御振込先
        self::__setVariable("pay_bank",$billData,Configure::read("D_COMPANY_PAY_BANK"));
        //口座番号
        self::__setVariable("pay_num",$billData,Configure::read("D_COMPANY_PAY_NUM"));
        //口座名義
        self::__setVariable("pay_name",$billData,Configure::read("D_COMPANY_PAY_NAME"));

        //請求書NO
        $this->set("bill_num",$bill_num);
        //発行日
        $this->set("registdate",$registdate);
        
        //発行元郵便番号
        self::__setVariable("company_post1",$billData,Configure::read("D_COMPANY_POST1"));
        //発行元郵便番号2
        self::__setVariable("company_post2",$billData,Configure::read("D_COMPANY_POST2"));
        //発行元住所
        self::__setVariable("company_address",$billData,Configure::read("D_COMPANY_ADDRESS"));
        //発行元住所2
        self::__setVariable("company_address2",$billData,Configure::read("D_COMPANY_ADDRESS2"));
        //発行元名
        self::__setVariable("company_name",$billData,Configure::read("D_COMPANY_NAME"));
        //発行元連絡先
        self::__setVariable("company_telnum",$billData,Configure::read("D_COMPANY_TELNUM"));
        //備考
        self::__setVariable("other",$billData);
        //詳細
        $billDetail = [];
        $bill = $this->request->getData('bill');
        for($i=1;$i<=15;$i++){
            if($bill){
                $billDetail[$i] = $bill[$i];
            }else{
                $k=$i-1;
                if(isset($billData['detail'][$k]['article'])){
                    $billDetail[$i]['article'] = $billData['detail'][$k]['article'];
                }else{ $billDetail[$i]['article'] = ""; }
                
                if(isset($billData['detail'][$k]['brand'])){
                    $billDetail[$i]['brand'] = $billData['detail'][$k]['brand'];
                }else{ $billDetail[$i]['brand'] = ""; }

                if(isset($billData['detail'][$k]['standard'])){
                    $billDetail[$i]['standard'] = $billData['detail'][$k]['standard'];
                }else{ $billDetail[$i]['standard'] = ""; }

                if(isset($billData['detail'][$k]['number'])){
                    $billDetail[$i]['number'] = $billData['detail'][$k]['number'];
                }else{ $billDetail[$i]['number'] = ""; }

                if(isset($billData['detail'][$k]['unit'])){
                    $billDetail[$i]['unit'] = $billData['detail'][$k]['unit'];
                }else{ $billDetail[$i]['unit'] = ""; }

                if(isset($billData['detail'][$k]['money'])){
                    $billDetail[$i]['money'] = $billData['detail'][$k]['money'];
                }else{ $billDetail[$i]['money'] = ""; }

                if(isset($billData['detail'][$k]['unitprice'])){
                    $billDetail[$i]['unitprice'] = $billData['detail'][$k]['unitprice'];
                }else{ $billDetail[$i]['unitprice'] = ""; }
                $n = (isset($billData['detail'][$k]['number']))?(int)$billData['detail'][$k]['number']:0;
                $p = (isset($billData['detail'][$k]['unitprice']))?(int)$billData['detail'][$k]['unitprice']:0;
                $price = (($n*$p) == 0 )?"":$n*$p;
                $billDetail[$i]['price'] = $price;
            }
        }
       // var_dump($billDetail);
        $this->set("bill",$billDetail);

        //社ハン
        self::__setVariable("syahan_sts",$billData);
        self::__setVariable("tantohan_sts",$billData);

    }
    /**************** 
     * 変数代入
     *1:変数名のキー
     * 2:登録済み請求書データ
     *  3:初期値
    *******************/
    public function __setVariable($key,$billData,$default=""){
        $value = $default;
        if($this->request->getData($key)){
            $value = $this->request->getData($key); 
        }elseif(isset($billData[$key])){
            $value = $billData[$key]; 
        }
        $this->set($key,$value);
    }

    //お支払日
    public function __getPayDate($paydate){
        if($paydate){
            $ex = explode("-",date('Y-m-d',strtotime($paydate)));
            return $ex;
        }
        //翌月末日
        return explode("-",date('Y-m-d', mktime(0, 0, 0, date('m') + 2, 0, date('Y'))));
    }
    //発行日取得
    public function __getRegistDate($regdate = ""){
        
        //当月の最終日
        $ex = explode("-",$regdate);
        if($this->request->getData('registdate_year')){
            $registdate_year = $this->request->getData('registdate_year');
        }elseif($regdate){
            $registdate_year = $ex[0];
        }else{
            $registdate_year=date('Y');
        }
        $registdate['y'] = $registdate_year;
        
        
        if($this->request->getData('registdate_month')){
            $registdate_month = $this->request->getData('registdate_month');
        }elseif($regdate){
            $registdate_month = $ex[1];
        }else{
            $registdate_month=date('m');
        }
        $registdate['m'] = $registdate_month;


        if($this->request->getData('registdate_day')){
            $registdate_day = $this->request->getData('registdate_day');
        }elseif($regdate){
            $registdate_day = $ex[2];
        }else{
            $registdate_day=date('t');
        }
        $registdate['t'] = $registdate_day;

        return $registdate;
    }
    //請求書No取得
    public function ___getBillNum(){
        
        if($this->request->getData('bill_num')) return $this->request->getData('bill_num');

        $query = $this->TBill->find();
        $ret = $query->select(['max_id' => $query->func()->max('id')])->first();
        $bill_num = sprintf("s%s%d"
            ,date("ym")
            ,$ret[ 'max_id' ]+1);
        return $bill_num;
    }
    //請求書作成
    public function create(){
        $this->log("[".$this->Auth->user("login_id")."]請求書作成"); 
    }

    //-----------------------------------
    //以下請求書作成時のajaxでデータ取得を行う関数
    //-----------------------------------
    //パートナーデータ一覧取得
    public function getPartner(){
        $this->autoRender = false;
        $this->loadModel("TUser");
 
        if($this->request->getData("type") == "partner"){
            $query = $this->TUser->find();
            $query = $query->select(['id','name']);
            $query = $query->where(["type"=>2,"del"=>0]);
            if( $this->request->getData("name")){
                $query = $query->where(["name LIKE"=>"%".$this->request->getData("name")."%"]);
            }
            $result = $query->toArray();
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        exit();
    }
    //顧客データ一覧取得
    public function getCustomer(){
        $this->autoRender = false;
        $this->loadModel("TUser");
 
        if($this->request->getData("type") == "customer"){
            $partnerid = $this->request->getData("partnerid");
            $query = $this->TUser->find();
            $query = $query->select(['id','name']);
            $query = $query->where(["type"=>3,"del"=>0,"partner_id"=>$partnerid]);
            if( $this->request->getData("name")){
                $query = $query->where(["name LIKE"=>"%".$this->request->getData("name")."%"]);
            }
            $result = $query->toArray();
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        exit();
    }
    //テストデータ一覧取得
    public function getTest(){
        $this->autoRender = false;
        $this->loadModel("TTest");

        if($this->request->getData("type") == "test"){
            $partnerid = $this->request->getData("partnerid");
            $customerid = $this->request->getData("customerid");

            $query = $this->TTest->find();
            $query = $query->select(['id','name']);
            $query = $query->where(["enabled"=>1,"del"=>0,'test_id'=>0]);
            $query = $query->where(["customer_id"=>$customerid]);
            $query = $query->where(["partner_id"=>$partnerid]);
            if( $this->request->getData("name")){
                $query = $query->where(["name LIKE"=>"%".$this->request->getData("name")."%"]);
            }
            $result = $query->toArray();
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        exit();
    }
}
