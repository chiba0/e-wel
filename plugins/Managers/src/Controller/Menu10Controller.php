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

class Menu10Controller extends BaseController
{
    public $paginate = [
        'limit' => D_LIMIT50,
        'order' => [
            'InformationTbl.id' => 'desc' 
        ]
    ];
    public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates']
    ];

    public function initialize()
    {
        parent::initialize();
        I18n::setLocale('ja_JP');
        $this->connection = ConnectionManager::get('default');
        $this->component = $this->loadComponent('Common');
        $this->component->setLangage($this);
        $this->loadModel("InformationTbl");
        $this->set("pan",__('menu10'));
        $this->set("title",$this->Auth->user('name'));
        // $this->session = $this->getRequest()->getSession();
        $this->p_list = self::__getPartnerList();
    }

    public function index()
    {
        $query = $this->InformationTbl->find();
        $infos = $this->paginate($query);
        $this->set(compact('infos'));
    }

    public function edit($id = "")
    {
        if (empty($id)) {
            $info = $this->InformationTbl->newEntity();
        } else {
            $info = $this->InformationTbl->get($id);
        }

        if ($this->request->is('post')) {
            $input = $this->request->getData();
            if (!empty($input['id'])) {
                $info = $this->InformationTbl->get($input['id']);
            }
            $info = $this->InformationTbl->patchEntity($info, $input);

            if ($input['info_upfile']['size'] > D_FILESIZE_LIMIT){
                $info->errors(['size' => __('errmsg_temp_file_size')]);
            }
            if ($info->errors()) {
                foreach ($info->errors() as $err) {
                    foreach ($err as $msg) {
                        $this->Flash->error($msg);
                    }
                }
            } else {
                $info['temp_file'] = self::__uploadFile($info['temp_file']);
                if ($this->InformationTbl->save($info)) {
                    $this->Flash->success(__('msg_info_regist_OK'));
                    $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('msg_info_regist_NG'));
                }
            }
        }
        
        $info = self::__addInfoData($info);
        $p_reg = [];
        $p_not_reg = $this->p_list;
        if ($info['disp_area'] == 1) {
            $p_reg = $this->p_list;
            $p_not_reg = [];
        } else {
            $p_reg = $info['p_list'];
            foreach ($info['p_list'] as $partner) {
                unset($p_not_reg[$partner['index']]);
            }
        }
        $p_count = count($this->p_list);
        $this->set(compact('info', 'p_reg', 'p_not_reg', 'p_count'));
    }

    public function view($id = "")
    {
        if (empty($id)) {
            $this->redirect(['action' => 'index']);
        } else {
            $info = $this->InformationTbl->get($id);
            $info = self::__addInfoData($info);
            $p_reg = $this->p_list;
            if ($info['disp_area'] == 2) {
                $p_reg = $info['p_list'];
            }
            $this->set(compact('info', 'p_reg'));
            $this->set("panlink", "/managers/menu10");
            $this->set("pan2",__('menu10sub4'));
        }
    }

    public function delete($id = "")
    {
        if (!empty($id)) {
            try {
                $info = $this->InformationTbl->get($id);
                $fname = $info['temp_file'];
                $this->InformationTbl->delete($info);
                if (!empty($fname)) {
                    if (!unlink(D_INFO_FILE_PATH . $fname)) {
                        $this->log('[' .  D_INFO_FILE_PATH . $fname . ']' . 'お知らせ情報添付ファイル削除失敗');
                    }
                }
                $this->Flash->success(__('msg_delete_OK'));
            } catch (Exception $e) {
                $this->log('[' . $id . '] ' . 'お知らせ情報データ削除失敗。');
                $this->Flash->error(__('msg_delete_NG'));
            }
        }
        $this->redirect(['action' => 'index']);
    }

    /**
     * ファイルアップロード
     *
     * @return string
     */
    private function __uploadFile(string $old_fname = "")
    {
        $fname = $old_fname;
        if (!empty($_FILES['info_upfile']['name'])) {
            $date = date('YmdHi');
            $fname = $date . '_' . $_FILES['info_upfile']["name"];
            if (!move_uploaded_file($_FILES['info_upfile']["tmp_name"],  D_INFO_FILE_PATH . $fname)) {
                $this->log('[' . $fname . ']' . 'お知らせ情報添付ファイルアップロード失敗');
            }
            if (!empty($old_fname)) {
                if (!unlink(D_INFO_FILE_PATH . $old_fname)) {
                    $this->log('[' .  D_INFO_FILE_PATH . $old_fname . ']' . 'お知らせ情報添付ファイル削除失敗');
                }
            }
        }
        return $fname;
    }

    /**
     * お知らせ情報にパートナー名を追加する
     *
     * @param Query|array $info
     * @return array
     */
    private function __addInfoData($info)
    {
        if (empty($info['disp_id_list'])) {
            $info['disp_area_detaile'] = '';
            $info['p_list'] = [];
        } else {
            $ids = explode(':', $info['disp_id_list']);
            $info['disp_area_detaile'] = count($ids);
            $p_id_list = array_column($this->p_list, 'id');
            foreach ($ids as $id) {
                $no = array_search($id, $p_id_list);
                $reg_p_list[] = $this->p_list[$no];
            }
            $info['p_list'] = $reg_p_list;
        }
        return $info;
    }

    /**
     * t_userテーブルからtype:2, del:0のユーザー情報を取得し、配列で返す
     *
     * @return array
     */
    private function __getPartnerList()
    {
        $partners = self::getPartners(['type' => 2, 'del' => 0], ['name' => 'ASC']);
        foreach ($partners as $key=>$partner) {
            $p_list[] = [
                'index' => $key,
                'id' => $partner['id'],
                'name' => $partner['name']
            ];
        }
        return $p_list;
    }

    /**
     * パートナーのID及び企業名の一覧を取得
     * 取得できなかった場合falseを返す
     *
     * @return QueryObject
     */
    public function getPartners(array $where = [], array $sort = [])
    {
        $this->loadModel("TUser");
        $query = $this->TUser
            ->find()
            ->select(['id','name'])
            ->where($where)
            ->order($sort);
        
        return $query->toArray();
    }
}
