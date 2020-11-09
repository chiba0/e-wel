<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;

class Menu3Controller extends BaseController
{
    //使用カラム
    const COLUMNS = [
        'test_name',        //検査名
        'exam_id',          //ID
        'customer_name',    //顧客企業名
        'partner_name',     //パートナー会社
        'exam_name',        //氏名
        'exam_date'         //受検日
    ];
    //ページネーション設定
    public $paginate = [
        'fields' => self::COLUMNS,
        'limit' => D_LIMIT50
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
        $this->set("pan",__('menu3'));
        $this->set("title",$this->Auth->user('name'));
    }

    public function index()
    {
        $this->loadModel("ViewUserexam");
        $this->set('data', $this->___getData());   //データ取得
    }
    
    //データ取得
    public function ___getData()
    {
        $query = $this->ViewUserexam->find();
        
        // ******検索*******
        //ID(id)
        $id = "";
        if ($this->request->getQuery("id")) {
            $id = $this->request->getQuery("id");
            $query = $query->where(["exam_id LIKE "=>"%".$id."%" ]);
        }
        //顧客企業名(company_name)
        $companyName = "";
        if ($this->request->getQuery("companyName")) {
            $companyName = $this->request->getQuery("companyName");
            $query = $query->where(["customer_name LIKE "=>"%".$companyName."%" ]);
        }
        //氏名(name)
        $name = "";
        if ($this->request->getQuery("name")) {
            $name = $this->request->getQuery("name");
            $query = $query->where(["exam_name LIKE "=>"%".$name."%" ]);
        }
        //受検日(senddate)
        $senddate = "";
        if ($this->request->getQuery("senddate")) {
            $senddate = $this->request->getQuery("senddate");
            $query = $query->where(["exam_date LIKE "=>"%".$senddate."%" ]);
        }
        //表示
        $this->set(compact('id', 'companyName', 'name', 'senddate'));
        
        $data = $this->paginate($query);
        return $data;
    }
}