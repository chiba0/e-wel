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

class Menu8Controller extends BaseController
{


    public function initialize()
    {
        parent::initialize();
        I18n::setLocale('ja_JP');
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("exam_master");
        $this->loadModel("t_testpaper");
        $this->loadModel("buy_license");
        $this->set("pan",__('menu8'));
        $this->set("title",$this->Auth->user('name'));

        $this->session = $this->getRequest()->getSession();
    }
    //ライセンス一覧
    public function index(){
        $this->log("[".$this->Auth->user("login_id")."]ライセンス一覧ページ表示");
        //ライセンスデータ
        $exam_master = $this->exam_master->find()
            ->where([
                "del"=>0
            ])->toArray();
        //受検者数
        $count = $this->___getLicenseCount();
        //購入ライセンス数
        $buy = $this->___getBuyCount();
        //処理数
        $syori = $this->___getSyoriCount();
        $this->set("exam_master",$exam_master);
        $this->set("count",$count);
        $this->set("buy",$buy);
        $this->set("syori",$syori);

    }
    /******************
     * 処理数
     */
    public function ___getSyoriCount(){
        $query = $this->t_testpaper->find();
        $testcount = $query->select([
            'type'=>'type',
            'count'=>$query->func()->count('id')
        ])
        ->where([
            'exam_state IN '=>[1,2]

        ])
        ->group(['type'])
        ->toArray();
        $list = [];
        foreach($testcount as $value){
            $list[$value['type']]=$value[ 'count' ];
        }
        return $list;
    }

    /**********************
     * 購入ライセンス数
     */
    public function ___getBuyCount(){
        $query = $this->buy_license->find();
        $licenseCount = $query->select([
            'exam_key'=>'exam_key',
            'sum'=>$query->func()->sum('buyNumber')
        ])
        ->group(['exam_key'])->toArray();
        
        $list = [];
        foreach($licenseCount as $value){
            $list[$value['exam_key']]=$value[ 'sum' ];
        }
        return $list;

    }
    /***************
     * ライセンスカウント
     */
    public function ___getLicenseCount(){
        $query = $this->t_testpaper->find();
        $testcount = $query->select([
            'type'=>'type',
            'count'=>$query->func()->count('id')
        ])
        ->group(['type'])->toArray();
        $list = [];
        foreach($testcount as $value){
            $list[$value['type']]=$value[ 'count' ];
        }
        return $list;
    }
    
}
