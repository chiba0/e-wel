<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure; 
use Exception;
use Cake\Auth\DefaultPasswordHasher;

class IdlistController extends BaseController
{
    public $paginate = [
        'limit' => D_LIMIT50,
        'order' => [
            't_testpaper.exam_date' => 'DESC',
        ]
    ];
    public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates']
    ];
    public function initialize()
    {

        parent::initialize();

        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
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

        
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("panlink2","/customers/app/");
        $this->set("pan3",__d('custom','customerreg11'));
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);

    
        

    }
    public function index($id=""){
       
        //テストデータの取得
        $test = $this->t_test->find()
            ->where([
                'id'=>$id
                ,'del'=>0
                ])
            ->first();

        //受検者一覧
        $query = $this->t_testpaper->find()
                ->where([
                    'testgrp_id'=>$id
                ])->group('number');
        

        $list = $this->paginate($query);
        $list = $list->toArray();
        $this->set("id",$id);
        $this->set("test",$test);
        $this->set("list",$list);
    }
    
}
