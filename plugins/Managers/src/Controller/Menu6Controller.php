<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure; 
use Cake\Error\Debugger;

class Menu6Controller extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        I18n::setLocale('ja_JP');
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("TUser");
        $this->loadModel("exam_master");
        $this->loadModel("exam_group");
        $this->set("pan",__('menu6'));
        $this->set("title",$this->Auth->user('name'));
        $this->set("company_name","");
        $this->set("registdate","");
        $this->session = $this->getRequest()->getSession();
        Configure::load("constRowCsvBaj1");
    }
    public function index(){
        $exam = $this->exam_group->find()->contain(['ExamMaster'])->toArray();
        $this->set("exam",$exam);
    }
    public function export($key){
        $header = Configure::read("D_HEADER_ba_j1");
        $file = WWW_ROOT.'/csv/' . date('YmdHis') . '.csv';
        $f = fopen($file, 'w');
        if($f){
            // ヘッダーの出力
            fputcsv($f, $header);

            fclose($f);
        }
        $data = $this->TUser->find()->where(['type'=>$key])->toArray();

        exit();
    }
    
    
}
