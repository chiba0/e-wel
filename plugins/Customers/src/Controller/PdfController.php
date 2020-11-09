<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure; 
use Exception;
use Cake\Auth\DefaultPasswordHasher;
use setasign\Fpdi;
use TCPDF_FONTS;
class PdfController extends BaseController
{

    public function initialize()
    {

        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->pdf2component = $this->loadComponent('Pdf2');
        $this->component->setLangage($this);
        $this->loadModel("TUser");
        $this->loadModel("t_test");
        $this->loadModel("t_test_pdf");
        $this->loadModel("t_testpaper");
        $this->loadModel("pdflogo");
        $this->loadModel("t_element");
        $this->D_STATUS = Configure::read("D_STATUS");
        $this->user = $this->Auth->user();
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();

        $this->partner = $this->TUser->find()->where(['login_id'=>$this->Auth->user("partner_loginid")])->first();
        if(empty($this->partner)) return false;

        

       /*
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("pan3",__d('custom','cmenu3'));
        $this->set("panlink2","/customers/app/");
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("d_status",$this->D_STATUS);
        */
        

    }
    public function index($id=""){
        set_time_limit(120);
        $this->autoRender = false;
        //対象者データ
        $ttest = $this->t_testpaper->find()
            ->where([
                'id'=>$id,
                'partner_id'=>$this->user->partner_id
            ])->first();
        //年齢
        $age = $this->component->__getBirthAge($ttest['birth'],$ttest[ 'exam_date' ]);
        //テスト名取得
        $testname = $this->TUser->find()
                ->select([
                    'name'
                ])
                ->where([
                    'id'=>$ttest['customer_id']
                ])->first();
        

        //出力するPDFデータの選択
        $select = $this->t_test_pdf->find()
            ->where([
                'test_id'=>$ttest[ 'testgrp_id' ]
            ])->toArray();
        
        //PDFロゴ画像の取得
        $logo = $this->pdflogo->find()
                ->where([
                    'user_id'=>$this->partner[ 'id' ]
                ])->first();
                    
        //受検データ
        $data=[];
        $data['logo'] = $logo['filename'];
        $data['id'] = $ttest['id'];
        $data['exam_id'] = $ttest['exam_id'];
        $data['exam_date'] = $ttest['exam_date'];
        $data['name'] = $ttest['name'];
        $data['kana'] = $ttest['kana'];
        $data['age'] = $age;
        $data['testname'] = $testname[ 'name' ];
        $data['ttest'] = $ttest;
        $this->pdf = new Fpdi\TcpdfFpdi();
        $font = new TCPDF_FONTS();
       // $myFont = $font->addTTFfont(WWW_ROOT.'fonts/ki_kokumin/ipaexfont/ipaexg.ttf');
        $myFont = $font->addTTFfont(WWW_ROOT.'fonts/ipag00303/ipag.ttf');
        
        foreach($select as $key=>$values){
            if($values[ 'pdf_id' ] == 2 ){
                $this->pdf->SetAutoPageBreak(true,0);
                $this->pdf2component->__setHtml2($this,$this->pdf,$data,$myFont);
            }
        }
  


        //$pdf->Output();
        $this->pdf->Output('sample.pdf', 'D');

        exit();
    }
    
}
