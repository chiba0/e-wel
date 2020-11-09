<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Utils\AppUtility;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        //今のurl
        $url = Router::url(NULL, true);
        /*
        if(preg_match("/local\-exam/",$url)){
            //テストページにリダイレクト
            header("Location:/exam/");
            exit();
        }
        */
        /*
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        */
        $this->loadComponent('Flash');
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        $this->loadComponent('Auth', [
            'authorize' => array('Controller'),
            'authenticate' => [
                // ユーザー認証に使用するカラム(email, password)
                'Form' => [
                    'userModel' => 't_user',
                    'fields' => [
                        'username' => 'login_id',
                        'password' => 'password'
                    ]
                ]
            ],
            // ログインを扱うコントローラーとアクション(デフォルト:/users/login)
            'loginAction' => [
                'controller' => '../Users',
                'action' => 'login',
            ],

            
            
            // ログイン後のリダイレクト先(コントローラーとアクション)
            // 'loginRedirect' => [
            //     'controller' => '../managers/app/',
            //     'action' => 'index'
            // ],
            // ログアウト後のリダイレクト先(コントローラーとアクション)
            'logoutRedirect' => [
                'controller' => 'login',
                'action' => 'index'
            ],
            // 未ログイン時にログイン必須ページを閲覧した際のMSG
            'authError' => false
            
        ]);
    }

    public function isAuthorized($user)
    {
        
        $this->loadModel("TUser");
        //今のurl
        $url = Router::url();
        //ログインした際のログインIDのtyepによってアクセスの有無を判定
        $base_loginid = $user[ 'base_loginid' ];
        $data = $this->TUser->find()->where(['login_id'=>$base_loginid])->first();
       
        if($data[ 'type' ] == 2  ){
            //typeが2の時はパートナー権限なので、managersディレクトリにはアクセスできない
            //パートナートップページに移動
            if(preg_match("/^\/managers/",$url)){
                $this->redirect("/partners/app");
            }
        }
        if($data[ 'type' ] == 3 ){
            //typeが3の時は顧客権限なので、managersディレクトリにはアクセスできない
            //typeが3の時は顧客権限なので、partnersディレクトリにはアクセスできない
            //パートナートップページに移動
            if(preg_match("/^\/managers/",$url)){
                $this->redirect("/customers/app");
            }
            if(preg_match("/^\/partners/",$url)){
                $this->redirect("/customers/app");
            }
        }

        return true;
        //var_dump($user);
        //echo "AUTH";
    }
    
}
