<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure; 


class AppController extends BaseController
{
    public $paginate = [
        'limit' => D_LIMIT50,
        
        'order' => [
            't_testpaper.exam_date' => 'DESC',
            't_testpaper.partner_id' => 'ASC',
            't_testpaper.customer_id' => 'ASC',
            't_testpaper.number' => 'ASC'
        ]
    ];
    public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates']
    ];
    public function initialize()
    {
        parent::initialize();
        $this->array_status = [];
        $this->array_status[0] = __d("custom","fin");
        $this->array_status[1] = __d("custom","enable");

        
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
        $exam_master = $this->exam_group->find()->contain(['ExamMaster'])->toArray();
        $this->D_EXAM_BASE = $exam_master;
        
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("array_status",$this->array_status);
        $this->set("ceil",0);
    }
    public function index($id=""){
        //初回
        $this->__baseCheck($id);
        $list = $this->___getList();
        $this->set("list",$list);
        $this->set("user",$this->user);

    }
    /*********************************
     * メールお知らせ機能ステータス更新
     * 非同期通信用
     */
    public function sendmailstatus(){
        $this->log("[パートナーID : ".$this->partner->id."]お知らせ機能ステータス更新");
        
        if(
            $this->request->is('post')
            && $this->request->is('ajax')
        ){ 
            //ステータス更新
            //親データ更新
            $this->t_test->connection()->begin();
            if($this->___editSendMailStatus() === false ){
                $this->log("[パートナーID : ".$this->partner->id."]お知らせ機能ステータス更新失敗");
                $this->t_test->connection()->rollback();
            }else{
                $this->log("[パートナーID : ".$this->partner->id."]お知らせ機能ステータス更新成功");
                $this->t_test->connection()->commit();
            }

        }
        exit();
    }

    /*********************************
     * PDFログステータス更新
     * 非同期通信用
     */
    public function pdflogstatus(){
        $this->log("[パートナーID : ".$this->partner->id."]PDFログステータス更新");
        if($this->request->is('post')
            && $this->request->is('ajax')
        ){ 
            
            //ステータス更新
            //親データ更新
            $this->t_test->connection()->begin();
            if($this->___editPDFLogStatus() === false ){
                $this->log("[パートナーID : ".$this->partner->id."]PDFログステータス更新失敗");
                $this->t_test->connection()->rollback();
            }else{
                $this->log("[パートナーID : ".$this->partner->id."]PDFログステータス更新成功");
                $this->t_test->connection()->commit();
            }

        }
        exit();
    }


    /*****************************
     * お知らせ機能ステータス更新成功
     */
    public function ___editPDFLogStatus(){
        //更新用データの取得(子供)
        $t_test = $this->t_test->find();
        $test_id = $this->request->getData('id');
        $pdf_log_use_status = $this->request->getData('status');
        $child = $t_test->select(['id'])->where([
            'test_id'=>$test_id,
            'partner_id'=>$this->partner->id
            ])->toArray();
        foreach($child as $value){
            $query = $this->t_test->get($value[ 'id' ]);
            $query->pdf_log_use=$pdf_log_use_status;
            $result = $this->t_test->save($query);
            if(!$result){
                return false;
            }
        }
        
        //更新用データの取得(親)
        $t_test = $this->t_test->find();
        $parent = $t_test->select(['id'])->where([
            'id'=>$test_id,
            'partner_id'=>$this->partner->id
            ])->first();
        $query = $this->t_test->get($parent->id);
        $query->pdf_log_use=$pdf_log_use_status;
        $result = $this->t_test->save($query);
        if(!$result){
            return false;
        }
        return true;

    }

    /*****************************
     * お知らせ機能ステータス更新成功
     */
    public function ___editSendMailStatus(){
        //更新用データの取得(子供)
        $t_test = $this->t_test->find();
        $test_id = $this->request->getData('id');
        $sendmail_status = $this->request->getData('status');
        $child = $t_test->select(['id'])->where([
            'test_id'=>$test_id,
            'partner_id'=>$this->partner->id
            ])->toArray();
        foreach($child as $value){
            $query = $this->t_test->get($value[ 'id' ]);
            $query->send_mail=$sendmail_status;
            $result = $this->t_test->save($query);
            if(!$result){
                return false;
            }
        }
        //更新用データの取得(親)
        $t_test = $this->t_test->find();
        $parent = $t_test->select(['id'])->where([
            'id'=>$test_id,
            'partner_id'=>$this->partner->id
            ])->first();
        $query = $this->t_test->get($parent->id);
        $query->send_mail=$sendmail_status;
        $result = $this->t_test->save($query);
        if(!$result){
            return false;
        }
        return true;

    }






    /**********************
     * 受検者一覧
     */
    public function lists(){
        //var_dump($this->user);
        //var_dump($this->partner);
        
        $query = $this->t_testpaper->find()
            ->select([
                't_testpaper.exam_id'
                ,'t_testpaper.type'
                ,'t_testpaper.number'
                ,'t_testpaper.name'
                ,'t_testpaper.kana'
                ,'t_testpaper.birth'
                ,'t_testpaper.exam_date'
                ,'testname'=>'t_test.name '
            ])
            ->where([
                "t_testpaper.partner_id"=>$this->user->partner_id
                ,"t_testpaper.customer_id"=>$this->user->id
            ]);
            if( $this->request->getData('exam_id') ){
                $query = $query->where(["t_testpaper.exam_id"=>$this->request->getData('exam_id')]);
            }
            
            if( $this->request->getData('name') ){
                $query = $query->where(["OR"=>
                    ["t_testpaper.name LIKE "=>"%".$this->request->getData('name')."%"]
                    ,["t_testpaper.kana LIKE "=>"%".$this->request->getData('name')."%"]]
                );
            }
            if( $this->request->getData('examdate_st') ){
                $query = $query->where(["t_testpaper.exam_date >= "=>$this->request->getData('examdate_st')]);
            }
            if( $this->request->getData('examdate_ed') ){
                $query = $query->where(["t_testpaper.exam_date <= "=>$this->request->getData('examdate_ed')]);
            }

            $query->join([
                'table' => 't_test',
                'conditions' => 't_test.test_id = t_testpaper.testgrp_id'
            ]);
        $list = $this->paginate($query);
        $list = $list->toArray();
        $list = $this->__getExamType($list);
        
        $this->set("list",$list);
    }

    /**
     * データ取得
     */
    public function ___getList(){

        if(isset($this->user->id) && isset($this->partner->id)){

            $sql = "
           
                SELECT 
                    TRUNCATE(a.examcount/a.typeCount,0) as examcount,
                    TRUNCATE(a.syori/a.typeCount,0) as syori,
                    TRUNCATE(a.zan/a.typeCount,0) as zan,
                    a.tid as id,
                    a.name,
                    a.send_mail,
                    a.pdf_log_use,
                    a.test_id,
                    CONCAT(a.period_from,'～',a.period_to) as term,
                    a.types,
                    CASE WHEN 
                        period_to >= date_format(now(),'%Y/%m/%d') THEN 1
                        ELSE 0 
                        END as status 
                FROM 
                    (
                SELECT 
                    count(distinct tt.type) as typeCount,
                    count(tt.id) as examcount,
                    tt.testgrp_id as tid, 
                    t.name,
                    t.period_from,
                    t.period_to,
                    t.send_mail,
                    t.pdf_log_use,
                    GROUP_CONCAT(DISTINCT(tt.type)) as types,
                    SUM(
                        CASE WHEN tt.complete_flg = 1 THEN 1 ELSE 0 END
                        ) as syori,
                    SUM(
                        CASE WHEN tt.exam_state = 0 THEN 1 ELSE 0 END
                    ) as zan,
                    max(t.test_id) as test_id
                FROM 
                    t_testpaper as tt
                    LEFT JOIN t_test as t ON tt.testgrp_id = t.id AND t.test_id=0
                where 
                    tt.customer_id=? and
                    tt.partner_id=? and 
                    t.del = 0 AND
                    t.name LIKE ?
                    
                group by tt.testgrp_id
                order by t.period_to desc
                ) as a
               
            ";
            $param = [];
            
            $param[] = $this->user->id;
            $param[] = $this->partner->id;
            $param[] = '%'.$this->request->getdata('username').'%';
            
            $rows  = $this->connection->execute($sql,$param)->rowCount();
            $p = sprintf("%d",$this->request->getQuery("p"));
            $ceil = sprintf("%d",ceil($rows/D_LIMIT)-1);
            $this->ceil = $ceil;
            if($p >= $ceil) $p=$ceil;
            $offset = D_LIMIT * $p;
            $offset = ($p <= 0 && $offset < 0)?0:$offset; 
            $sql .= " LIMIT ".$offset.",".D_LIMIT;
            $results = $this->connection->execute($sql,$param)->fetchAll('assoc');
            //検査名保持
            $result = $this->__setExamName($results);
            $this->set("ceil",$this->ceil);

            return $result;
        }else{
            return false;
        }


    }
    /*************************************
     * 検査名取得
     */
    public function __getExamType($rlt){
        $list = [];
        $exam = [];
        foreach($this->D_EXAM_BASE as $value){
            foreach($value[ 'exam_master' ] as $k=>$v){
                $k = $v['key'];
                $exam[$k] = $v[ 'name' ];
            }
        }
        foreach($rlt as $key=>$val){
            $list[$key] = $val;
            
            
            $list[$key]['typename'] = $exam[$val[ 'type' ]];
            
        }

        return $list;
    }
    /**************************************
     * 検査名保持
     */
    public function __setExamName($rlt){
        $list = [];
        $exam = [];
        foreach($this->D_EXAM_BASE as $key=>$value){
            foreach($value['exam_master'] as $v){
                $k = $v['key'];
                $exam[$k] = $v[ 'name' ];
            }
        }
        foreach($rlt as $key=>$val){
            $list[$key] = $val;
            $ex = explode(",",$val[ 'types' ]);
            $types = [];
            foreach($ex as $k=>$v){
                if(!empty($exam[$v])){
                    $types[] = $exam[$v];
                }
            }
            
            $list[$key]['typename'] = implode(" / ",$types);
            
        }

        return $list;
    }
    /**
     * idがあるときは管理者画面から移動してきているので、
     * authデータを入れ替えるその後再度読込
     * 
     */
    public function __baseCheck($id = 0){
        if($id > 0 ){

            $baseloginid = $this->Auth->user("base_loginid");

            $user = $this->TUser->find()
                ->where([
                    'id'=>$id
                  //  ,'partner_id'=>$this->user['partner_id']
                    
                    ])
                ->first();

            if(empty($user)){
                throw new NotFoundException(__('User not found'));
                
            }

            $user[ 'base_loginid' ] = $baseloginid;
            $user[ 'partner_loginid' ] = $this->user['login_id'];
            $this->Auth->setUser($user);
            $this->log("[".$this->Auth->user("login_id")."]authデータ入れ替え顧客画面");
          //  return $this->redirect(['controller' => '../customers', 'action' => 'app']);
            return $this->redirect("/customers/app");;
            exit();
        }
    }

}
