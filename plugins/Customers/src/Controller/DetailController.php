<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class DetailController extends BaseController
{
    public $components = [];
    public $paginate = [
        'limit' => D_LIMIT50,

        'order' => [
            "number"
        ]
    ];
    public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates']
    ];
    public $width = 100;
    public $offset = 0;
    public $pg = 0;
    public function initialize($id="")
    {
        $this->array_status = [];
        $this->array_status[0] = __d("custom","fin");
        $this->array_status[1] = __d("custom","enable");

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
        $this->loadModel("exam_master");
        $this->loadModel("exam_group");
        $this->loadModel("t_test_pdf");
        $this->loadModel("log_pdf");
        $exam_master = $this->exam_group->find()->contain(['ExamMaster'])->toArray();
        $this->D_EXAM_BASE = $exam_master;
        $this->d_exam_state = Configure::read("D_EXAM_STATE");
        $this->D_BAJ1_RESULT = Configure::read("D_BAJ1_RESULT");
        $this->D_GENDER = Configure::read("D_GENDER");
        $this->D_PASS = Configure::read("D_PASS");
        $this->D_COLSPAN = Configure::read("D_COLSPAN");
        $this->D_PDF_OUTPUT = Configure::read("D_PDF_OUTPUT");
//var_dump($this->D_BAJ1_RESULT);
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("panlink2","/customers/app/");
        $this->set("pan3",__d('custom','customerreg10'));
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("array_status",$this->array_status);
        $this->set("ceil",0);
        $this->set("D_PDF_OUTPUT",$this->D_PDF_OUTPUT);
    }
    public function index($id=""){
        if(!$id || $id <= 0){ 
            return $this->redirect(['controller' => 'app']);
        }
        //重み付け確認
        $wt = $this->___checkWeight($id);
        $this->stress_flg = $wt[ 'stress_flg' ];
        //現在選択しているテストデータ
        $this->___getTestData($id);
        //現在選択しているテストのグループを取得
        $this->__getExamGroup($id);

        $lists = $this->___getList($id);
        //PDFの出力ログ
        $log_pdf = $this->__getLogPdf($id);
        //現在選択しているPDFの数
        $this->___getTestPdf($id);
        
        $this->set("id",$id);
        $this->set("lists",$lists);
        $this->set("log_pdf",$log_pdf);
        $this->set("d_exam_state",$this->d_exam_state);
        $this->set("D_COLSPAN",$this->D_COLSPAN);
        $this->set("pg",$this->pg);
        $this->set("ceil",$this->ceil);
        $this->set("wt",$wt);
    }

    /*******************
     * 重み付け
     */
    public function ___checkWeight($id){
        $wtdata = $this->t_test->find()
            ->select([
                'id',
                'type',
                'weight',
                'stress_flg'
            ])
            ->where([
                'test_id'=>$id,
                'type IN '=>[1,2,12,72,73]
            ])->first();
        return $wtdata;
    }
    /****************************
     *PDFのログ出力
     */
    public function __getLogPdf($id){
        $log = $this->log_pdf->find()
            ->select([
                'id',
                'exam_id',
            ])
            ->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'test_id'=>$id
            ])->toArray();
        $lists = [];
        foreach($log as $value){
            $lists[ $value[ 'exam_id' ] ] = "on";
        }
        return $lists;
    }
    /******************************
     * テストデータ
     */
    public function ___getTestData($id){
        $testdata = $this->t_test->find()
            ->select([
                'id',
                'pdf_log_use'
            ])
            ->where([
                'id'=>$id
            ])->first();
        $this->set("testdata",$testdata);
    }


    /***********************
     * 現在選択しているPDFの数
     */
    public function ___getTestPdf($id){
        $checkPdf = $this->t_test_pdf->find()
            ->where([
                'test_id'=>$id
            ])->count();
        $this->set("checkPdf",$checkPdf);
    }
    /*****************************
     * 現在選択しているテストのグループを取得
     */
    public function __getExamGroup($id){
        $examGroup = $this->t_test->find()
            ->join([
                'table'=>'exam_master',
                'alias'=>'em',
                'type'=>'LEFT',
                'conditions'=>'em.key=t_test.type',
            ])
            ->join([
                'table'=>'exam_group',
                'alias'=>'eg',
                'type'=>'LEFT',
                'conditions'=>'eg.group_id=em.exam_group_id',
            ])
            ->select([
                "t_test.type",
                "em.exam_group_id",
                "em.name",
                "eg.name"
            ])
            ->where([
                "t_test.test_id"=>$id
            ])
            ->toArray()
        ;
        //テーブルの横幅を指定
        //受検の数
        $count = count($examGroup);
        $this->set("width",$this->width+16*$count);
        $this->set("examGroup",$examGroup);
    }

    /*****************************
     * 受検者sql
     */
    public function ___getSQL($id,$flg=0){
        
        $sql = "
            SELECT 
                *
            FROM 
                t_testpaper as tt 
            WHERE
                tt.partner_id=".$this->user->partner_id."
                AND tt.customer_id=".$this->user->id."
                AND tt.testgrp_id=".$id."
            ";
        if($flg != 0){
            if($this->request->getData("id")){
                $sql .= " AND tt.exam_id like '%".$this->request->getData('id')."%'";
            }
            if($this->request->getData("name")){
                $sql .= " AND tt.name like '%".$this->request->getData('name')."%'";
            }
            if($this->request->getData("kana")){
                $sql .= " AND tt.kana like '%".$this->request->getData('kana')."%'";
            }
            if($this->request->getData("exam_state")){
                $sql .= " AND tt.exam_state >= '".$this->request->getData('exam_state')."'";
            }
            if($this->request->getData("end_search")){
                $sql .= " AND tt.exam_state <= '".$this->request->getData('end_search')."'";
            }
            
            if($this->request->getData("memo")){
                $sql .= " AND tt.memo1 like '%".$this->request->getData('memo')."%'";
            }

        }

        $sql .= "
            group by tt.number
        ";
        
        if($flg != 0){
            $sql .= " LIMIT ".$this->offset.",".D_LIMIT;
        }
        return $sql;

    }
    /**********************
     * 受検者一覧
     */
    public function ___getList($id){
        $connection = ConnectionManager::get('default');
        $sql = $this->___getSQL($id);
        $count = $connection->execute($sql)->count();

        $ceil = sprintf("%d",ceil($count/D_LIMIT)-1);
        $this->ceil = $ceil;
        
        $p = sprintf("%d",$this->request->getQuery("p"));
        if($p >= $ceil) $p=$ceil;
        $this->pg = $p;
        $offset = D_LIMIT * $p;
        $this->offset = ($p <= 0 && $offset < 0)?0:$offset;
        
        $sql = $this->___getSQL($id,1);
        $list = $connection->execute($sql)->fetchAll('assoc');



        //行動価値検査用データ取得ba
        $mv = $this->__getBajData($id);
        //mea
        $mea = $this->___getMEAData($id);
        //EABJ
        $eabj = $this->___getEABJData($id);
        //vf
        $vf = $this->___getVFData($id);
        //esa
        $esa = $this->___getEsaData($id);
        //fs
        $fs = $this->___getFsData($id);
        //sa
        $sa = $this->___getSaData($id);
        //iq
        $iq = $this->___getIQData($id);
        //ocs
        $ocs = $this->___getOCSData($id);
        //nl
        $nl = $this->___getNLData($id);
        //PA
        $pa = $this->___getPaData($id);
        //bms
        $bms = $this->___getBmsData($id);
        //met
        $met = $this->___getMETData($id);
        //bav
        $bav = $this->___getBAVData($id);
        //sp
        $sp = $this->___getSPData($id);

        $lists = [];
       foreach($list as $value){
           $k = $value[ 'number' ];
           $lists[$k] = $value;
            $examdate = preg_replace("/\//","",$value[ 'exam_date' ]);
            $lists[$k][ 'age' ] = $this->component->__getBirthAge($value[ 'birth' ],$examdate);
            //受検状態
            $lists[$k]['exam_state_jp'] = $this->d_exam_state[$value['exam_state']];
            //ストレスレベル
            if(isset($mv[$k]) && count($mv[$k])){
                $lists[$k]['st_lv'    ] = $mv[$k][ 'st_lv' ];
                $lists[$k]['st_score' ] = $mv[$k][ 'st_score' ];
                $lists[$k]['level'    ] = $mv[$k][ 'level' ];
                $lists[$k]['mv_id'    ] = $mv[$k][ 'mv_id' ];
                $lists[$k]['mv_exam_date'   ] = $mv[$k][ 'mv_exam_date' ];
            }
            //mea
            if(isset($mea[$k]) && $mea[$k]){
                $lists[$k]['mea_exam_date'] = $mea[$k]['exam_date'];
            }
            //eabj
            if(isset($eabj[$k]) && $eabj[$k]){
                $lists[$k]['ea_exam_date'] = $eabj[$k]['exam_date'];
            }
            //vf
            if(isset($vf[$k]) && $vf[$k]){
                $lists[$k]['vf_exam_date'] = $vf[$k]['exam_date'];
            }
            //esa
            if(isset($esa[$k]) && $esa[$k]){
                $lists[$k]['esa_exam_date'] = $esa[$k]['exam_date'];
            }
            //fs
            if(isset($fs[$k]) && $fs[$k]){
                $lists[$k]['fs_exam_date'] = $fs[$k]['exam_date'];
            }
            //sa
            if(isset($sa[$k]) && $sa[$k]){
                $lists[$k]['sa_exam_date'] = $sa[$k]['exam_date'];
            }
            //iq
            if(isset($iq[$k]) && $iq[$k]){
                $lists[$k]['iq_exam_date'] = $iq[$k]['exam_date'];
            }
            //ocs
            if(isset($ocs[$k]) && $ocs[$k]){
                $lists[$k]['ocs_exam_date'] = $ocs[$k]['exam_date'];
            }
            //nl
            if(isset($nl[$k]) && $nl[$k]){
                $lists[$k]['nl_exam_date'] = $nl[$k]['exam_date'];
            }
            //pa
            if(isset($pa[$k]) && $pa[$k]){
                $lists[$k]['pa_exam_date'] = $pa[$k]['exam_date'];
            }
            //bms
            if(isset($bms[$k]) && $bms[$k]){
                $lists[$k]['bms_exam_date'] = $bms[$k]['exam_date'];
            }
            //met
            if(isset($met[$k]) && $met[$k]){
                $lists[$k]['met_exam_date'] = $met[$k]['exam_date'];
            }
            //bav
            if(isset($bav[$k]) && $bav[$k]){
                $lists[$k]['bav_exam_date'] = $bav[$k]['exam_date'];
                $lists[$k]['st_lv'    ] = $bav[$k][ 'st_lv' ];
                $lists[$k]['bav_id'    ] = $bav[$k][ 'id' ];
                $lists[$k]['exam_state'    ] = $bav[$k][ 'exam_state' ];
            }
            //sp
            if(isset($sp[$k]) && $sp[$k]){
                $lists[$k]['sp_exam_date'] = $sp[$k]['exam_date'];
            }
       }
       return $lists;
    }
    /***********************
     * bav
     */
    public function ___getBAVData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'id',
                'number',
                'exam_date',
                'exam_state',
                'dev1',
                'dev2'
                ]);
            
        $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[41]
            ])->group('number');
        $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }
            $list[$values['number']]['exam_state']= $values['exam_state'];

            $list[$values['number']]['st_lv']="";

            if($this->stress_flg == 1){
                list($lv,$score) = $this->component->__getStress2($values['dev1'],$values['dev2'],$values['dev6']);
            }else{
                list($lv,$score) = $this->component->__getStress($values['dev1'],$values['dev2']);
                $list[$values['number']]['st_lv']= $lv;
            }

            $list[$values['number']]['id']= $values['id'];


        }

        return $list;
    }
    /***********************
     * sp
     */
    public function ___getSPData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[39]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /***********************
     * met
     */
    public function ___getMETData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[40]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /***********************
     * bms
     */
    public function ___getBmsData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[13,35,42]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /***********************
     * PA
     */
    public function ___getPaData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[38]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /***********************
     * NL
     */
    public function ___getNLData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[34,36,61]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /***********************
     * IQ
     */
    public function ___getIQData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[11]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /***********************
     * OCS
     */
    public function ___getOCSData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[32]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /***********************
     * sa
     */
    public function ___getSaData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[6,37]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }

    /***********************
     * fs
     */
    public function ___getFsData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[3]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /*********************
     * ESA
     */
    public function ___getEsaData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[45]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /*********************
     * VF
     */
    public function ___getVFData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[4,33]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;
    }
    /*******************
     * EABJデータ取得
     */
    public function ___getEABJData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[5,7,31,47,66,74]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;

        
    }
    /*******************
     * MEAデータ取得
     */
    public function ___getMEAData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'number',
                'exam_date',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[50]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']]['exam_date']= $values['exam_date'];
            }

        }
        return $list;

        
    }
    /*******************
     * 行動価値検査用データ取得
     */
    public function __getBajData($id){
        $query = $this->t_testpaper->find()
            ->select([
                'id',
                'number',
                'exam_date',
                'level',
                'dev1',
                'dev2',
                'dev6',
                'exam_state'
                ]);
            
            $query = $query->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'testgrp_id'=>$id
                ,'type IN '=>[1,2,12,72,73]
            ])->group('number');
            $query = $query->toArray();
        $list = [];
        foreach($query as $values){

            //ストレスレベル
            $lv = "";
            $score = "";
            
            if($this->stress_flg == 1){
                list($lv,$score) = $this->component->__getStress2($values['dev1'],$values['dev2'],$values['dev6']);
            }else{
                list($lv,$score) = $this->component->__getStress($values['dev1'],$values['dev2']);
            }
            $list[$values['number']][ 'mv_id' ] = $values[ 'id' ];
            if($values[ 'exam_state' ] <= 1){
                $list[$values['number']]['mv_exam_date']= $this->d_exam_state[$values[ 'exam_state' ]];
            }else{
                $list[$values['number']][ 'mv_exam_date' ] = $values[ 'exam_date' ];

            }

            $list[$values['number']][ 'st_lv' ] = $lv;
            $list[$values['number']][ 'st_score' ] = $score;
            $list[$values['number']][ 'level' ] = $values['level'];
            //$list[$values['number']] = $values[ 'exam_date' ];

        }
        return $list;

    }

    /****************************
     * 行動価値結果詳細取得ajax
     */
    public function eabj($id=0){
        $this->autoRender = false;
        if($this->request->is("ajax")){
            if($id > 0){
                $data = $this->t_testpaper->find('all')
                    ->where([
                        'partner_id'=>$this->user->partner_id
                        ,'customer_id'=>$this->user->id
                        ,'id'=>$id
                    ])->first();
                //$level = $data[ 'level' ];
                $soyo = $data[ 'soyo' ];
                $data['text0'] = $this->D_BAJ1_RESULT[$soyo][0];
                $data['text1'] = $this->D_BAJ1_RESULT[$soyo][1];
                $data['text2'] = $this->D_BAJ1_RESULT[$soyo][2];
                $data['text3'] = $this->D_BAJ1_RESULT[$soyo][3];
                $data['text4'] = $this->D_BAJ1_RESULT[$soyo][4];
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($data);
            }
        }else{
            echo "not";
        }
    }

    /****************************
     * 更新画面
     */
    public function edit($id=""){
        //更新用のデータ取得
        $data = $this->t_testpaper->find('all')
            ->select([
                'exam_id',
                'name',
                'kana',
                'birth',
                'sex',
                'pass',
                'memo1',
                'memo2',
                'number',
                'test_id',
                'testgrp_id',
                'exam_id'])
            ->where([
                'partner_id'=>$this->user->partner_id
                ,'customer_id'=>$this->user->id
                ,'id'=>$id
            ])->first();
        if(!$data){
            $this->log("[パートナーID : ".$this->partner->id."]受検情報更新画面データ取得失敗");
            return $this->redirect(['action' => '../app']);
        }
        //登録処理
        if($this->request->getData("edit") == "on"){
            //更新用データ取得
            $edit = [];
            $edit = $this->t_testpaper->find('all')
                    ->select(['id'])
                    ->where([
                        'test_id'=>$data[ 'test_id' ],
                        'testgrp_id'=>$data[ 'testgrp_id' ],
                        'number'=>$data[ 'number' ],
                        'exam_id'=>$data[ 'exam_id' ]
                    ])->toArray();
            
            $this->connection->begin();
            $errorflag=0;
            foreach($edit as $values){
                $t_testpaper = $this->t_testpaper->get($values->id);
                $post_data = $this->request->getData();
                $post_data['birth'] = sprintf("%04d/%02d/%02d"
                        ,$this->request->getData('year')
                        ,$this->request->getData('month')
                        ,$this->request->getData('day')
                    );

                $t_testpaper = $this->t_testpaper->patchEntity($t_testpaper, $post_data,['validate'=>'edit']);
                
                if(count( $t_testpaper->errors() )){
                    if($t_testpaper->errors('sei._empty')) $this->Flash->error($t_testpaper->errors('sei._empty'));
                    if($t_testpaper->errors('mei._empty')) $this->Flash->error($t_testpaper->errors('mei._empty'));
                    if($t_testpaper->errors('kana_sei._empty')) $this->Flash->error($t_testpaper->errors('kana_sei._empty'));
                    if($t_testpaper->errors('kana_mei._empty')) $this->Flash->error($t_testpaper->errors('kana_mei._empty'));
                    if($t_testpaper->errors('birth.birth')) $this->Flash->error($t_testpaper->errors('birth.birth'));
                    if($t_testpaper->errors('gender._required')) $this->Flash->error($t_testpaper->errors('gender._required'));
                    
                    if($t_testpaper->errors('pass._empty')) $this->Flash->error($t_testpaper->errors('pass._empty'));
                    //エラーが存在したためロールバック
                    $this->connection->rollback();
                    break;
                    $errorflag++;
                }else{
                    $t_testpaper->name = $this->request->getData("sei")."　".$this->request->getData("mei");
                    $t_testpaper->kana = $this->request->getData("kana_sei")."　".$this->request->getData("kana_mei");
                    $t_testpaper->birth = sprintf("%04d/%02d/%02d"
                        ,$this->request->getData('year')
                        ,$this->request->getData('month')
                        ,$this->request->getData('day')
                    );

                    
                    $t_testpaper->sex = $this->request->getData("gender");
                    $t_testpaper->pass = $this->request->getData("pass");
                    $t_testpaper->memo1 = $this->request->getData("memo1");
                    $t_testpaper->memo2 = $this->request->getData("memo2");
                    $this->t_testpaper->save($t_testpaper);


                }                
            }//foreach終わり

            if($errorflag == 0){
                $this->connection->commit();


                $this->Flash->success(__d("custom","detailEditErrorSuccess"));
    
                $this->log("[パートナーID : ".$this->partner->id."]受検情報更新成功");
                return $this->redirect(['action'=>'../detail/edit/'.$id]);

            }
            

        }


        //表示用のデータ1番目のデータのみ取得

        $this->set("id",$id);
        $this->set("disp",$data);
        $this->set("D_GENDER",$this->D_GENDER);
        $this->set("D_PASS",$this->D_PASS);
        $this->set("edittext",__d("custom","edittext"));

        $this->set("panlink3","/customers/detail/index/".$data[ 'testgrp_id' ]);
        $this->set("pan4",__d('custom','examupdate').__('gamen'));
    }
}
