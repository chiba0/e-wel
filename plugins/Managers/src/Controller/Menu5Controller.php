<?php

namespace Managers\Controller;

use App\Utils\AppUtility;
use App\Controller\AppController as BaseController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;

use Cake\Error\Debugger;

class Menu5Controller extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        I18n::setLocale('ja_JP');
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->set("pan",__('menu5'));
        $this->set("title",$this->Auth->user('name'));
        $this->set("company_name","");
        $this->set("registdate","");
        $this->session = $this->getRequest()->getSession();
    }
    public function index(){
        
        
    }
    
    
}
