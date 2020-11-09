<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure; 
use Exception;
use Cake\Auth\DefaultPasswordHasher;

class Menu6Controller extends BaseController
{

    public $paginate = [
        'limit' => D_LIMIT50
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
        $this->loadModel("t_testpaper");
        $this->user = $this->Auth->user();
        $this->D_GENDER = Configure::read("D_GENDER");
        //利用チェック
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->partner = $this->TUser->find()->where(['login_id'=>$this->Auth->user("partner_loginid")])->first();
        if(empty($this->partner)) return false;

       
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("pan3",__d('custom','cmenu6'));
        $this->set("panlink2","/customers/app/");
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("d_gender",$this->D_GENDER);
    }
    public function index(){
        
        $query = $this->t_testpaper->find()
        ->select([
            't_testpaper.id',
            't_testpaper.inspection',
            't_testpaper.exam_date',
            't_test.name',
            't_testpaper.exam_id',
            't_testpaper.name',
            't_testpaper.kana',
            't_testpaper.birth',
            't_testpaper.sex',
            't_testpaper.memo1',
            't_testpaper.memo2',
            't_testpaper.evaluation',
            't_testpaper.adopt',
            't_testpaper.enterdate',
            't_testpaper.retiredate',
            't_testpaper.retirereason',
        ])
        ->where([
            't_testpaper.partner_id'=>$this->user->partner_id,
            't_testpaper.customer_id'=>$this->user->id,
            't_testpaper.complete_flg'=>1,
        ]);
        $query->join([
            'table' => 't_test',
            'conditions' => 't_test.test_id = t_testpaper.testgrp_id'
        ]);
        $query->group(['t_testpaper.id']);
        $data = $this->paginate($query);

        $this->set('data', $data);
    }
    public function edit($id){
        if($this->request->getData("edit")){
            $this->editData($id);
        }
        
        $data = $this->t_testpaper->find()
        ->where([
            't_testpaper.partner_id'=>$this->user->partner_id,
            't_testpaper.customer_id'=>$this->user->id,
            't_testpaper.complete_flg'=>1,
            't_testpaper.id'=>$id,
        ])->first();

        $this->set("panlink3","/customers/menu6");
        $this->set("edittext",__d("custom","edittext"));
        $this->set("pan4",__d('custom','cmenu6edit'));
        $this->set("id",$id);
        $this->set("data",$data);
    }
    public function editData($id){
        if($id > 0 ){
            $data = $this->t_testpaper->get($id);
            $post_data = $this->request->getData();
            $data = $this->t_testpaper->patchEntity($data, $post_data);
            $this->t_testpaper->save($data);

            $this->Flash->success(__d("custom","cmenu6edittext"));
        }
    }   
}
