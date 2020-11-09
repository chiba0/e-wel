<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Exception;
use Cake\Auth\DefaultPasswordHasher;

class Menu3Controller extends BaseController
{
    //ページネーション設定
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
        $this->user = $this->Auth->user();
        $this->loadModel("TUser");
        $this->loadModel("uploadfile");

        $this->data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->set("base_logintype",$this->data[ 'type' ]);

        $this->set("pan",__('customerlist'));
        $this->set("panlink","/partners/app/");
        $this->set("pan2",__("pmenu3"));

        $this->set("title",$this->Auth->user('name'));
        $this->set("D_STATUS",Configure::read("D_STATUS"));
    }

    public function index($id=""){
        $this->log("[".$this->Auth->user("id")."]顧客添付ファイルダウンロード");
        //チェックしたファイルの一括削除
        self::___checkDeleteAll();

        $query = $this->uploadfile->find();
        $query = $query->where([
            'partner_id '=>$this->user[ 'id' ],
            'filename LIKE '=>"%".$this->request->getData( 'filename' )."%",
            'regist_ts LIKE '=>"%".preg_replace("/\//","-",$this->request->getData( 'registdate' ))."%"
            ]);
        if(strlen($this->request->getData( 'status' )) > 0 ){
            $query = $query->where(['status '=>$this->request->getData( 'status' )]);
        }
        $query = $query->order(['regist_ts' => 'desc']);
        $list = $this->paginate($query);
        //日付
        $list = self::__editRegistDate($list);
        $this->set("list",$list);

    }
    //チェックした項目の一括削除
    public function ___checkDeleteAll(){
        
        if($this->request->getData("checkDelete")){
            $delcheck = $this->request->getData("delcheck");
            foreach($delcheck as $key=>$val){
                $id = $key;
                $this->log("[".$id."]添付ファイル一括削除");
                //IDをデータベースから取得する
                $baseid = $this->uploadfile->find()
                    ->select([ 'id' ])
                    ->where([
                    'id'=>$id,
                    'partner_id'=>$this->user['id']
                ])->first();
                $entity = $this->uploadfile->get($baseid[ 'id' ]);
                $this->uploadfile->delete($entity);
            }
            return $this->redirect(['action' => '../menu3/']);

        }
    }
    //日付フォーマット変更
    public function __editRegistDate($list){
        $lists = [];
        foreach($list as $key=>$val){
            $lists[$key]=$val;
            $lists[$key]['regist_ts'] = date('Y/m/d',strtotime($val[ 'regist_ts' ]));
        }
        return $lists;
    }
    //添付ファイルダウンロード
    public function tmp($id=""){
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
    //添付ファイル削除
    public function delete($id){
        $this->autoRender = false;
        if($id > 0){
            $this->log("[".$id."]添付ファイル削除");
            //IDをデータベースから取得する
            $baseid = $this->uploadfile->find()
                ->select([ 'id' ])
                ->where([
                'id'=>$id,
                'partner_id'=>$this->user['id']
            ])->first();
            if($baseid[ 'id' ] == $id){
                $this->log("[".$id."]添付ファイル削除実施");
                $entity = $this->uploadfile->get($id);
                if($this->uploadfile->delete($entity)){
                    $this->Flash->success(__("tempFileOK"));
                }else{
                    $this->Flash->success(__("tempFileNG"));
                }
                
            }else{
                $this->log("[".$id."]添付ファイル削除失敗");
                $this->Flash->success(__("tempFileNG"));
            }
            return $this->redirect(['action' => '../menu3/']);
        }
    }

}
