<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\Http\Cookie\Cookie;
use App\Controller\AppController as BaseController;
use Cake\Mailer\Email;
use Cake\Routing\Router;

/**
 * Common component
 */
class CommonComponent extends Component
{
    public function Initialize(array $config)
    {
        $this->_user = $this->request->Session()->read('Auth');
    }

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $components = array('Cookie');


    /*******************************
     * ストレスレベル
     */
	//ストレスデータ取得
	public function __getStress2($dev1, $dev2,$dev3) {

		$dev1 = sprintf("%s",($dev1 >= 70 )?60:$dev1);
		$dev2 = sprintf("%s",($dev2 >= 70 )?60:$dev2);
		$dev3 = sprintf("%s",($dev3 >= 70 )?60:$dev3);

		$dev1 = sprintf("%s",($dev1 <= 35.21  )?20:$dev1);
		$dev2 = sprintf("%s",($dev2 <= 35.21  )?20:$dev2);
		$dev3 = sprintf("%s",($dev3 <= 35.21  )?20:$dev3);
		
		//ポジティブ思考力スコア反転
		$dev3 = 100-$dev3;
		
		$ave = ($dev1+$dev2+$dev3)/3;
		$st_score = round($ave,1);
		if($ave >= 64.79 ){
			$st_level = 5;
		}elseif( $ave >= 54.49){
			$st_level = 4;
		}elseif( $ave >= 45.3 ){
			$st_level = 3;
		}elseif( $ave >= 35 ){
			$st_level = 2;
		}else{
			$st_level = 1;
		}
		
		return array($st_level, $st_score);
	}

    /*******************************
     * ストレスレベル
     */
    public function __getStress($dev1, $dev2){
        if(!$dev1 && !$dev2){
            return array("", "");
        }
        $ave = ($dev1 + $dev2) / 2;
        $roundedAve = round($ave, 1);
        if ($ave < 30) {
            $st_level = 1;
            $st_score = $roundedAve;
        } else if ($ave < 35) {
            if ($dev1 < 40 && $dev2 < 40) {
                $st_level = 1;
                $st_score = $roundedAve;
            } else {
                $st_level = 2;
                $st_score = 35;
            }
        } else if ($ave < 40) {
            if ($dev1 < 40 && $dev2 < 40) {
                $st_level = 1;
                $st_score = 34.9;
            } else if ($dev1 < 30 || $dev2 < 30) {
                $st_level = 2;
                $st_score = $roundedAve;
            } else {
                $st_level = 3;
                $st_score = 45;
            }
        } else if ($ave < 45) {
            if ($dev1 < 30 || $dev2 < 30) {
                $st_level = 2;
                $st_score = $roundedAve;
            } else if ($dev1 < 50 && $dev2 < 50) {
                $st_level = 3;
                $st_score = 45;
            } else {
                $st_level = 4;
                $st_score = 55;
            }
        } else if ($ave < 50) {
            if ($dev1 < 30 || $dev2 < 30) {
                $st_level = 2;
                $st_score = 44.9;
            } else if ($dev1 < 50 && $dev2 < 50) {
                $st_level = 3;
                $st_score = $roundedAve;
            } else {
                $st_level = 4;
                $st_score = 55;
            }
        } else if ($ave < 55) {
            if ($dev1 < 30 || $dev2 < 30) {
                $st_level = 2;
                $st_score = 44.9;
            } else {
                $st_level = 4;
                $st_score = 55;
            }
        } else if ($ave < 60) {
            if ($dev1 < 50 || $dev2 < 50) {
                $st_level = 4;
                $st_score = $roundedAve;
            } else if ($dev1 < 60 && $dev2 < 60) {
                $st_level = 4;
                $st_score = $roundedAve;
            } else {
                $st_level = 5;
                $st_score = 65;
            }
        } else if ($ave < 65) {
            if ($dev1 < 50 || $dev2 < 50) {
                $st_level = 4;
                $st_score = $roundedAve;
            } else {
                $st_level = 5;
                $st_score = 65;
            }
        } else {
            $st_level = 5;
            $st_score = $roundedAve;
        }
        return array($st_level, $st_score);
      
    }
    /********************************
     * 年齢取得
     */
    public function __getBirthAge($date,$now=""){
        if(!$date){
            return 0;
        }
        if(!$now) $now = date("Ymd");

        $birthday = str_replace("-", "", $date);//ハイフンを除去しています。
        $birthday = str_replace("/", "", $birthday);
        $birthday = (int)$birthday;
        $now = str_replace("-", "", $now);//ハイフンを除去しています。
        $now = str_replace("/", "", $now);
        $now = (int)$now;
        return floor(($now-$birthday)/10000);
    }
    /************************
     * 重みテンプレート
     */
    public function weightTemplateCSV(){
        // 出力情報の設定
        $date = date("ymdhis");
        $D_ELEMENT = Configure::read("D_ELEMENT");
        
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=weight_".$date.".csv");
        header("Content-Transfer-Encoding: binary");
        // 1行目のラベルを作成
        $csv = implode(",",$D_ELEMENT);
        $csv = $csv.",平均点,標準偏差値" . "\n";
        
        $csv = mb_convert_encoding($csv, "SJIS", "utf-8");
        echo $csv;
        
        return;
    }
    public function setLangage($base){
        //言語設定
        $this->base = $base;
        self::___editLanguage();
        self::___setLanguage();
        
    }
    public function ___setLanguage(){
        $cookieData = $this->request->getCookie("language");
        if($cookieData == "jp"){
            I18n::locale( Configure::read('App.defaultLocaleJP'));
        }
        if($cookieData == "en"){
            I18n::locale( Configure::read('App.defaultLocaleEN'));
        }
    }
    public function ___editLanguage(){
        if(filter_input(INPUT_GET,"lang")){
            $this->response = $this->response->withCookie(new Cookie("language",filter_input(INPUT_GET,"lang")));
            $this->base->redirect("/managers/app/");
        }
    }
   
    /************************************
     * ロゴ画像アップロード
     */
    public function __setImage($data = ""){
        $loginid = $this->request->getData("login_id");
        if(!$loginid && count($data)) $loginid = $data->login_id;
        if($this->request->getData("logoImage.name")){
            //拡張子取得
            $exp = pathinfo($_FILES['logoImage']['name']);
            $extension = $exp[ 'extension' ];
  
            $a = WWW_ROOT.'/logo/' .$loginid.".".$extension;
            if(move_uploaded_file($_FILES['logoImage']['tmp_name'], $a)){
                $this->log("[".$loginid."]画像アップロード成功", "debug");     
                return true;
            }else{
                $this->log("[".$loginid."]画像アップロード失敗", "debug");
                return false;
            }
        }
        return true;

    }

    //-------------------------------
    //ユーザ登録用メール配信
    //-------------------------------
    public function ___usersendMail($user,$to,$rep_name){
        $this->log("[".$to."]ユーザ登録用メール配信", "debug");

        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
		->template('usermail')
		->viewVars(
            [
                'name'=>$user[ 'name' ],
                'rep_name'=>$rep_name,
                'logo_name'=>$user[ 'logo_name' ],
                'url'=>D_BASE_URL,
                'login_id'=>$user[ 'login_id' ],
                'license'=>$user[ 'license' ],
                'foot'=>D_MAIL_FOOT,
            ])
		->to($to)
		->subject(D_MAIL_NEW_SUBJECT)
		->send();

        return true;
    }
    /**
     * 顧客更新用メール
     */
    public function ___partnerEditsendMail($user,$to,$rep_name){
        $this->log("[".$to."]パートナ更新用メール配信", "debug");

        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
		->template('partnereditmail')
		->viewVars(
            [
                'name'=>$user[ 'name' ],
                'rep_name'=>$rep_name,
                'logo_name'=>$user[ 'logo_name' ],
                'url'=>D_BASE_URL,
                'login_id'=>$user[ 'login_id' ],
                'foot'=>D_MAIL_FOOT,
            ])
		->to($to)
		->subject(D_MAIL_EDIT_SUBJECT)
		->send();

        return true;
    }
    /*************
     * 新規顧客登録メール
     * $type = 1 or 2 
     * 1:担当者1 2:担当者2
     */
    public function ___customerRegistsendMail($to,$type){
        
        $logo_name = $this->_user[ 'User' ][ 'logo_name' ];
        $login_id = $this->request->getData("login_id");
        $name = $this->request->getData("name");
        if($type == 1) $rep_name = $this->request->getData("rep_name");
        if($type == 2) $rep_name = $this->request->getData("rep_name2");
        $this->log("[".$to."]パートナ登録用メール配信", "debug");

        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
		->template('customerregistmail')
		->viewVars(
            [
                'name'=>$name,
                'rep_name'=>$rep_name,
                'logo_name'=>$logo_name,
                'url'=>D_BASE_URL,
                'login_id'=>$login_id,
                'foot'=>D_MAIL_FOOT,
            ])
		->to($to)
		->subject(D_MAIL_EDIT_SUBJECT)
		->send();
    }
    /***************************
     * 検査登録用メール配信
     * $req 1:担当者1 2:担当者2
     */
    public function ___sendEditMail($user,$req=1){


        $testname = $this->request->getData("name");
        $to = "";
        $rep_name = "";
        if($req == 1){
            $to = $user->rep_email;
            if(!$to) return false;
            $rep_name = $user->rep_name;
        }
        if($req == 2){ 
            $to = $user->rep_email2;
            if(!$to) return false;
            $rep_name = $user->rep_name2;
        }
        $this->log("[".$to."]検査登録用メール配信", "debug");
        $name = $user->name;
        $subject = "[".$testname."]検査受検更新のお知らせ";
        
        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
		->template('editTestSendMail')
		->viewVars(
            [
                'name'=>$name,
                'rep_name'=>$rep_name,
                'testname'=>$testname,
                'd_url_test'=>D_TEST_URL."?k=".$this->uniq,

            ])
		->to($to)
		->subject($subject)
        ->send();

        $this->log("題名:".$subject, "debug");
        $this->log("本文:".$subject, "debug");

        return true;
    }
    /***************************
     * 検査登録用メール配信
     * $req 1:担当者1 2:担当者2
     */
    public function ___sendRegistMail($user,$partner,$req=1){
        $partnername = $partner->name;
        $testname = $this->request->getData("name");
        $to = "";
        $rep_name = "";
        if($req == 1){
            $to = $user->rep_email;
            if(!$to) return false;
            $rep_name = $user->rep_name;
        }
        if($req == 2){ 
            $to = $user->rep_email2; 
            if(!$to) return false;
            $rep_name = $user->rep_name2;
        }
        $this->log("[".$to."]検査登録用メール配信", "debug");
        $name = $user->name;
        $subject = "[".$testname."]検査受検更新のお知らせ";
        

        $count = $this->request->getData("number");
        $term = $this->request->getData("period_from")."～".$this->request->getData("period_to");
        $partner_rep_name = $partner->rep_name;
        $partner_rep_email = $partner->rep_email;

        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
		->template('registTestSendMail')
		->viewVars(
            [
                'name'=>$name,
                'rep_name'=>$rep_name,
                'testname'=>$testname,
                'partnername'=>$partnername,
                'customername'=>$name,
                'count'=>$count,
                'term'=>$term,
                'partner_rep_name'=>$partner_rep_name,
                'partner_rep_email'=>$partner_rep_email,
            ])
		->to($to)
		->subject($subject)
        ->send();

        return true;
    }
    /**********************
     * ファイル添付用メール配信
     */
    public function ___tempSendMail($user,$filename,$mode=1){

        if($mode == 1){
            $to = $user->rep_email;
            $rep_name = $user->rep_name;
        }else{
            $to = $user->rep_email2;
            $rep_name = $user->rep_name2;
        }
        $name = $user->name;
        

        $this->log("[".$to."]添付ファイル配信", "debug");

        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
		->template('tmpSendMail')
		->viewVars(
            [
                'name'=>$name,
                'rep_name'=>$rep_name,
                'filename'=>$filename,
                'foot'=>D_MAIL_FOOT,
            ])
		->to($to)
		->subject(D_MAIL_TEMP_SUBJECT)
		->send();
    }
}
