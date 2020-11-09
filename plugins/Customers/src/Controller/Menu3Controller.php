<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure; 
use Exception;
use Cake\Auth\DefaultPasswordHasher;

class Menu3Controller extends BaseController
{

    public function initialize()
    {

        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("TUser");
        $this->loadModel("uploadfile");
        $this->D_STATUS = Configure::read("D_STATUS");
        $this->user = $this->Auth->user();
        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();

        $this->partner = $this->TUser->find()->where(['login_id'=>$this->Auth->user("partner_loginid")])->first();
        if(empty($this->partner)) return false;

       
        $this->set("title",$this->Auth->user('name'));
        $this->set("pan",__("customerlist"));
        $this->set("panlink","/partners/app/".$this->partner->id);
        $this->set("pan2",__('examlist'));
        $this->set("pan3",__d('custom','cmenu3'));
        $this->set("panlink2","/customers/app/");
        $this->set("base_logintype",$this->data[ 'type' ]);
        $this->set("pid",$this->user->partner_id);
        $this->set("d_status",$this->D_STATUS);

    }
    public function index(){
        self::__getData();


    }
    public function __getData(){
        //2週間後
        $twoweek = date("Y-m-d H:i:s",strtotime("-2 week"));
        $filedata = $this->uploadfile->find()
            ->where([
                    'partner_id'=>$this->user->id
                    ,'regist_date >='=>$twoweek
                    ])->toArray();
        $this->set("data",$filedata);
    }
    /********************
     * ファイルダウンロード
     */
    public function download($id=""){
        if($id > 0 ){
            $this->autoRender = false;
            $this->log("[".$id."]添付ファイルダウンロード");
            $query = $this->uploadfile->find();
            $query = $query->where([
                'id'=>$id,
                'partner_id'=>$this->user['id']
            ])->first();
            //添付ファイルステータスの切替
            $this->uploadfile->query()
                ->update()
                ->set(['status'=>1])
                ->where([
                    'id'=>$id,
                    'partner_id'=>$this->user['id']
                    ])->execute();

            $download_file = WWW_ROOT."tmp/".$query[ 'dir_id' ]."/".$query[ 'filename' ];
            $response = $this->response->file($download_file, ['download' => true, 'name' => $query['filename']]);
            return $response;
        }
    }
   
}
