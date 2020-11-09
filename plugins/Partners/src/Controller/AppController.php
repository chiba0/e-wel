<?php

namespace Partners\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

class AppController extends BaseController
{

    public function initialize()
    {
        
        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("TUser");
        $this->loadModel("buyLicense");
        $this->loadModel("view_partner_license");
        $this->loadModel("view_customer_list");
        $this->set("pan",__('partnerlist'));
        $this->loadModel("exam_master");
        $this->loadModel("exam_group");
        
        
        $data = $this->TUser->find()->where(['login_id'=>$this->Auth->user("base_loginid")])->first();
        $this->set("base_logintype",$data[ 'type' ]);
        $this->set("pan","");
        $this->set("panlink","");
        $this->set("pan2","");

    }

    public function index($id=""){
        //初回
        self::__baseCheck($id);
        //ライセンスデータ取得
        $license = self::__getLicenseData();
        //顧客一覧データ取得
        $customer = self::___getCustomerData();
        
       $this->set("pan",__("customerlist"));
       $this->set("title",$this->Auth->user('name'));
       $this->set("license",$license);
       $this->set("customer",$customer);
       $this->set("ceil",$this->ceil);

    }
    /**
     * idがあるときは管理者画面から移動してきているので、
     * authデータを入れ替えるその後再度読込
     * 
     */
    public function __baseCheck($id = 0){
        if($id > 0 ){
            
            $baseloginid = $this->Auth->user("base_loginid");

            //検査一覧から移動
            if($this->Auth->user('type') == 3){
                $id = $this->Auth->user("id");
                $u = $this->TUser->find()->select(["partner_id"])->where(['id'=>$id])->first();
                if(empty($u)){
                    throw new NotFoundException(__('User not found'));
                    
                }
                $id = $u->partner_id;
                
            }

            $user = $this->TUser->find()->where(['id'=>$id])->first();
            if(empty($user)){
                throw new NotFoundException(__('User not found'));
                
            }
            
            $user[ 'base_loginid' ] = $baseloginid;
            
            $this->Auth->setUser($user);
            $this->log("[".$this->Auth->user("login_id")."]authデータ入れ替えパートナー画面");
            
            return $this->redirect(['controller' => '../partners', 'action' => 'app']);
        }
    }
    /**
     * ライセンスデータ取得
     */
    public function __getLicenseData(){
        //ライセンスデータ取得
        
        $sql = "
        SELECT 
            bl.uid ,
            bl.buyNumber,
            bl.exam_key,
            (bl.buyNumber-count(tt.id)) as sale,
            bl.buyNumber-( bl.buyNumber-count(tt.id) ) as examCount,
            SUM(CASE WHEN tt.exam_state = 2 THEN 1 ELSE 0 END ) as syori,
            ( (bl.buyNumber-( bl.buyNumber-count(tt.id) )) - SUM(CASE WHEN tt.exam_state = 2 THEN 1 ELSE 0 END ) ) as zan 
            FROM buy_license as bl
            LEFT JOIN t_testpaper  as tt ON tt.partner_id = bl.uid AND tt.type = bl.exam_key
            WHERE 
            bl.uid = ? AND 
            bl.buyNumber != 0
            group by bl.exam_key ,bl.uid 
            ";
        $param[] = $this->Auth->user("id");
        $query = $this->connection->execute($sql,$param)->fetchAll('assoc');
        
        //検査名取得
        $license = self::__setExamName($query);
        return $license;
    }
    /******** 
    //検査名取得
    ********/
    public function __setExamName($results){
        //検査名取得
        $exam_master = $this->exam_master->find()->toArray();
        $examname = [];
        foreach($exam_master as $key=>$val){
            $examname[$val[ 'key' ]] = $val[ 'jp' ];
        }

        foreach($results as $key=>$val){
            $k = $val['exam_key'];
            $results[$key]['examname'] = $examname[$k];
        }
        return $results;
    }
    //顧客一覧取得
    //viewテーブルについても検討したが、処理が重くなってしまったため
    //sqlの直接実行を行う
    public function ___getCustomerData(){
        
        $sql = "
        SELECT 
            u.id,u.partner_id, 
            tt.customer_id, 
            count(tt.id) as cnt, 
            count(tt.id)-SUM(CASE WHEN exam_state >= 1 THEN 1 ELSE 0 END) as zan, 
            SUM(CASE WHEN exam_state = 2 THEN 1 ELSE 0 END) as syori, 
            u.name as name, 
            max(u.registtime) as registtime 
        FROM t_user as u 
            LEFT JOIN t_testpaper as tt  ON u.id = tt.customer_id AND tt.disabled = 0 AND tt.del=0 AND tt.temp_flg = 0 
        WHERE 
            u.partner_id=? AND 
            u.del=0 
        ";

        if($this->request->getdata('username')){
            $sql .= " AND u.name LIKE '%".$this->request->getdata('username')."%'";
        }
        $sql .= "
            GROUP BY u.id 
            ORDER BY u.registtime desc
            ";
        $param[] = $this->Auth->user("id");
        $count = $this->connection->execute($sql,$param)->count();
        $ceil = sprintf("%d",ceil($count/D_LIMIT)-1);
        $this->ceil = $ceil;
        $p = sprintf("%d",$this->request->getQuery("p"));
        if($p >= $ceil) $p=$ceil;
        $offset = D_LIMIT * $p;
        $offset = ($p <= 0 && $offset < 0)?0:$offset; 
        
        $sql .= " LIMIT ".$offset.",".D_LIMIT;
        $query = $this->connection->execute($sql,$param)->fetchAll('assoc');

        return $query;
    }
}
