<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure; 
use Cake\Error\Debugger;

class Menu4Controller extends BaseController
{
    public $paginate = [
        'limit' => D_LIMIT50,
        'order' => [
            'view_log_license.id' => 'desc' 
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
        $this->loadModel("view_log_license");
        $this->loadModel("exam_master");
        $this->loadModel("exam_group");
        $exam_master = $this->exam_group->find()->contain(['ExamMaster'])->toArray();

        $this->set("pan",__('menu4'));
        $this->set("title",$this->Auth->user('name'));
        $this->set("company_name","");
        $this->set("registdate","");
        //$this->session = $this->getRequest()->getSession();
        $this->exam = [];
        foreach($exam_master as $value){
            foreach($value[ 'exam_master' ] as $val){
                $k = $val[ 'key' ];
                $this->exam[$k] = $val[ 'name' ];
            }
        }

    }
    public function index(){

        $query = $this->view_log_license->find();
        $registdate = preg_replace("/\//","-",$this->request->getData('registdate'));
        $query = $query->where([
            'name LIKE '=>'%'.$this->request->getData('company_name').'%',
            'regist_ts LIKE '=>$registdate.'%'
            
            ]);
        $list = $this->paginate($query);
        //テスト型のセット
        $data = self::____setTestType($list);
        
        
        
        $this->set("company_name",$this->request->getData('company_name'));
        $this->set("registdate",$this->request->getData('registdate'));
        $this->set("data",$data);
    }
    public function ____setTestType($list){
        $data = [];
        foreach($list as $key=>$val){
            $exam_key = $val[ 'exam_key' ];
            $data[$key]=$val;
            $data[$key]['exam_name'] = $this->exam[$exam_key];
            $sts = __("kensakujyo");
            if($val['note'] > 0 ){
                $sts = __("kentuika");
            }
            $abs = abs($val[ 'note' ]);
            $data[$key]['status'] = $abs.$sts;
        }
        return $data;
    }
    
}
