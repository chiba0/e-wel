<?php
namespace App\Shell;
 
use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;

class copyUseShell extends Shell
{
    public function main()
    {
        $this->out("シェルの実行を行います");
        //カンマ区切りになっているライセンスデータを登録用の別テーブルに保存する
       self::__moveUserLicenseData();
    }

    //会員自動登録の際に出力されるＰＤＦのデータ移行
    public function outputPdf()
    {
        $connection = ConnectionManager::get('default');
        $sql = "
            SELECT 
                u.id,
                u.outputPdf
            FROM
                t_user as u 
                LEFT JOIN outputpdf as opp ON u.id = opp.uid
            WHERE
                opp.id IS NULL AND
                (
                u.outputPdf != '' AND
                u.outputPdf != ':' 
                )
        ";
        $data = $connection->execute($sql)->fetchAll('assoc');
        foreach($data as $value){
            $ex = explode(":",$value[ 'outputPdf' ]);
            foreach($ex as $key=>$val){
                if($val){
                    echo "(".$value[ 'id' ].",".$val.",1,'".date('Y-m-d H:i:s')."'),";
                }
            }
        }

    }

    //会員登録用パスワードデータの変更
    public function editUsePassword()
    {
        $this->out("パスワード更新");
        $this->loadModel("TUser");
        $query = $this->TUser->find()->select(['id','password','login_pw'])
           // ->where(['password'=>''])
            ;
        $connection = ConnectionManager::get('default');
//         $pwd = (new DefaultPasswordHasher)->hash("9021INg");
  //       var_dump($pwd);
  //       exit();
        $pwdobj = new DefaultPasswordHasher();
        foreach($query as $value){
            $pwd = (new DefaultPasswordHasher)->hash($value->login_pw);
            
            echo "ID=>".$value->id."(".$value->login_pw.")=>".$pwd."::CHANGE!\n";
            $sql = "UPDATE t_user SET 
                        password = ?
                    WHERE 
                        id=?
                    ";
            $data = [$pwd,$value->id];
            $flg = $connection->execute($sql,$data);
            if($flg){
                echo "SUCCESS";
            }else{
                echo "FAILD";
            }
            echo "\n";
        }
        $this->out("パスワード更新終了");
    }

    private function __moveUserLicenseData(){

        $connection = ConnectionManager::get('default');
        $sql = " SELECT 
                    u.id,
                    u.license_parts
                FROM 
                    t_user as u 
                   
                WHERE 
                    u.license_parts != ''
                    ";

        $data = $connection->execute($sql)->fetchAll('assoc');
        
        foreach($data as $value){
            //$this->out($val[ 'license_parts' ]);
            $license_parts = explode(":",$value['license_parts']);
            $num = 0;
            foreach($license_parts as $k=>$val){
                $num = $k+1;
                echo "(".$value['id'].",".$num.",".(int)$val."),";
            }

            

        }
    }
}


?>