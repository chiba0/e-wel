<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Symfony\Component\Debug\Debug;

class AppController extends BaseController
{
    const MARK_ASC = "-asc";
    const MARK_DESC = "-desc";

    public function initialize()
    {
        parent::initialize();
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->set("pan",__('partnerlist'));
        $this->loadModel("TUser");
        //ソートマーク
        $this->sortMarks = [
            "username" => "",      //企業名
            "userlicense" => "",   //購入ライセンス数
            "hanbaikano" => "",    //販売可能ライセンス数
            "jyukensya" => "",     //受検者数
            "syori" => "",         //処理数
            "zan" => ""            //残数
        ];

        //base_loginidと今のauthに登録されているIDが異なるときは
        //base_loginidのデータに上書きする
        self::___checkLoginid();


    }
    //base_loginidと今のauthに登録されているIDが異なるときは
    //base_loginidのデータに上書きする
    public function ___checkLoginid(){
        if($this->Auth->user("login_id") != $this->Auth->user("base_loginid")){
            $user = $this->Auth->user();
            $busers = $this->TUser->find()
                ->where([ 'login_id'=>$this->Auth->user('base_loginid') ])
                ->first()->toArray();
            foreach($busers as $key=>$val){
                $user[$key]=$val;
            }
            
            $user[ 'login_id' ] =  $this->Auth->user("base_loginid");
            $this->Auth->setUser($user);
        }

    }
    public function index(){
        //ユーザーデータ取得
        $partner = self::___getUserData();
        $this->set("title",$this->Auth->user('name'));
        $this->set("partner",$partner);
        $this->set("ceil",$this->ceil);
        //$add = AppUtility::add(1,2);
        //$this->set("add",$add);
        $this->set("sortMarks",$this->sortMarks);
    }
    
    /*
        ソート用SQL文の生成
        引数：なし
        戻り値：SQL文（" ORDER BY カラム名 ソートタイプ"）
    */
    public function ___orderby(){
        $order = "";
        $sortCol = $this->request->getQuery('sort');

        if($sortCol){
            $sortCol = $sortCol;
            $plus = "";
            if($sortCol != "username") $plus = "+0";
            $order .= ' ORDER BY '.$sortCol.$plus;
            $order .= ' '.self::___orderType($sortCol);
        }else{
            $order .= ' ORDER BY registtime DESC';
        }
        return $order;
    }

    /*
        昇順・降順切り替え
        引数：ソートするカラム名
        戻り値："ASC" or "DESC"
    */
    public function ___orderType($col){
        $this->sortMarks[$col] = self::MARK_ASC;

    }

    //ユーザデータ取得
    public function ___getUserData(){
        //販売可能ライセンス数
        //購入ライセンス数 - (未受検ステータス検査数 + 受検中ステータス検査数 + 受検済み検査数)
        $param = [];
        $sql = "SELECT 
                    * 
                FROM 
                    view_partner 
                ";
        if($this->request->getQuery('username')){
            $sql .= " WHERE ";
            $sql .= " username LIKE ? ";
            $param[] = "%".$this->request->getQuery('username')."%";
        }
        //全体の合計数
        $results = $this->connection->execute($sql,$param)->fetchAll('assoc');
        $count = count($results);
        $ceil = sprintf("%d",ceil($count/D_LIMIT)-1);
        $this->ceil = $ceil;
        $p = sprintf("%d",$this->request->getQuery("p"));
        if($p >= $ceil) $p=$ceil;

        $offset = D_LIMIT * $p;
        $offset = ($p <= 0 && $offset < 0)?0:$offset; 
        
        $results = [];
        $sql .= self::___orderby();
        $sql .= " LIMIT ".$offset.",".D_LIMIT;
        $results = $this->connection->execute($sql,$param)->fetchAll('assoc');
        return $results;
    }

    
}
