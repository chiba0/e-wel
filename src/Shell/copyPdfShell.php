<?php
namespace App\Shell;
 
use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;


class copyPdfShell extends Shell
{
    public function main()
    {
        $this->out("シェルの実行を行います");
        //コロン区切りになっているPDFデータを登録用の別テーブルに保存する
       self::__movePdfData();
    }
    static function __movePdfData(){
        echo "PDF START";
        $connection = ConnectionManager::get('default');
        $sql = "SELECT 
                id,
                pdfdownload 
            from 
                t_test 
            where 
                test_id=0 
                and 
                pdfdownload != ''";
         $data = $connection->execute($sql)->fetchAll('assoc');
         $i=0;
         foreach($data as $value){

            $ex = [];
            $ex  = explode(":",$value[ 'pdfdownload' ]);
            $now = date('Y-m-d H:i:s');
            foreach($ex as $key=>$val){
                //INSERT文生成
                $sql = "
                    INSERT INTO t_test_pdf (
                        test_id,
                        pdf_id,        
                        regist_ts
                    )VALUES(
                        '".$value[ 'id' ]."',
                        '".$val."',
                        '".$now."'
                    )
                    ";
                    echo $sql."\n";
                    $connection->execute($sql);


            }
            
            
            $i++;
           
            
        }

    }

    
}


?>