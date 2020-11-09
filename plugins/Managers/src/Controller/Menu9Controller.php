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

class Menu9Controller extends BaseController
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
        $this->loadModel("view_log_trial");
        $this->set("pan",__('menu9'));
        $this->set("title",$this->Auth->user('name'));

        $this->session = $this->getRequest()->getSession();
    }
    //トライアル一覧
    public function index(){
        $this->log("[".$this->Auth->user("login_id")."]トライアル一覧ページ表示");
        //ライセンスデータ
        $query = $this->view_log_trial->find()
            ->where([

            ]);
        $query = $query->order(['registtime'=>'DESC']);
        $trial = $this->paginate($query);
        $this->set("trial",$trial);
    }
    
    
}
