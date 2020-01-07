<?php

class CtlExtend extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvExtend();
    }

    public function linkList()
    {
        SrvAuth::checkOpen('extend', 'linkList');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $channel_id = $this->R('channel_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $create_user = $this->R('create_user');
        $keyword = $this->R('keyword');
        $status = $this->R('status', 'int', 0);

        $srvAdmin = new SrvAdmin();
        $data = $this->srv->getLinkList(0, $page, $parent_id, $game_id, $package_name, $channel_id, $keyword, $user_id, $create_user, $status);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'label' => '选择游戏',
                'type' => 'game',
                'data' => $data['_games'],
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $data['_games']['list'];
        $this->out['_channels'] = $data['_channels'];
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'linkList';
        $this->out['__title__'] = '广告链管理';
        $this->tpl = 'extend/linkList.tpl';
    }

    public function linkListExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $channel_id = $this->R('channel_id', 'int', 0);
        $keyword = $this->R('keyword');
        $user_id = $this->R('user_id', 'int', 0);
        $create_user = $this->R('create_user');
        $this->out['data'] = $this->srv->getLinkList(1, 0, $parent_id, $game_id, $package_name, $channel_id, $keyword, $user_id, $create_user);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function linkCostExcel()
    {
        SrvAuth::checkOpen('extend', 'linkList');
        $this->outType = 'string';

        $game_id = $this->R('game_id', 'int', 0);
        $parent_id = $this->R('parent_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $create_user = $this->R('create_user');

        $data = $this->srv->linkCostExcel($parent_id, $game_id, $channel_id, $create_user);
        SrvPHPExcel::downloadExcel('成本录入', $data['header'], $data['data']);
    }

    public function channelLog()
    {
        SrvAuth::checkOpen('extend', 'linkList');

        $this->outType = 'smarty';

        $keyword = $this->R('keyword');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $type = $this->R('type');
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $page = $this->R('page', 'int', 1);

        $this->out['data'] = $this->srv->getChannelLog($page, $monitor_id, $type, $sdate, $edate, $keyword);
        $this->out['monitor_id'] = $monitor_id;
        $this->out['_type'] = LibUtil::config('user_log_type');
        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'channelLog';
        $this->out['__title__'] = '回调日志';
        $this->tpl = 'extend/channelLog.tpl';
    }

    public function channelLogExcel()
    {
        SrvAuth::checkOpen('extend', 'linkList');

        $keyword = $this->R('keyword');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $type = $this->R('type');
        $monitor_id = $this->R('monitor_id', 'int', 0);

        $this->out['data'] = $this->srv->getChannelLog(0, $monitor_id, $type, $sdate, $edate, $keyword, 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function addLink()
    {
        SrvAuth::checkOpen('extend', 'linkList');

        $this->outType = 'smarty';

        $data = [];
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $gameId = '';
        $parentId = '';
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        if ($monitor_id) {
            SrvAuth::checkPublicAuth('edit');

            $data = $this->srv->getLinkInfo($monitor_id);
            $gameId = $data['game_id'];
            $gameP = LibUtil::fetchChildrenGame($games['parent']);
            $parentId = $gameP[$gameId]['pid'];
        } else {
            SrvAuth::checkPublicAuth('add');

            $data['create_user'] = $_SESSION['username'];
            $data['page_info']['auto_jump'] = 0;
        }


        $srvAd = new SrvAd();
        $srvAdmin = new SrvAdmin();

        /*$widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '选择游戏',
                'disabled' => false,
                'parent' => false,
                'attr' => 'style="width: 150px;"'
            ),
        );*/
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$parentId,
                'default_text' => '选择母游戏',
                'parent' => true,
                'disabled' => false,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_text' => '选择子游戏',
                'children_default_value' => $gameId,
                'attr' => ''
            )
        );

        $this->out['data']['info'] = $data;
        $this->out['data']['monitor_id'] = $monitor_id;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        //$this->out['_pages'] = $this->srv->getAllPage();
        $this->out['_companys'] = $this->srv->getAllCompany();
        //$this->out['_models'] = $this->srv->getAllModel();
        $this->out['_packagename'] = json_encode($this->srv->getLinkPackageName());
        $this->out['widgets'] = $widgets;

        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'linkList';
        $this->out['__title__'] = '添加/修改广告链';
        $this->tpl = 'extend/addLink.tpl';
    }

    public function addLinkAction()
    {
        SrvAuth::checkOpen('extend', 'linkList');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $monitor_id = $this->post('monitor_id', 'int', 0);
        $type = $this->post('type', 'int', 0);

        if ($monitor_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $result = [];
        if ($type == 1 && trim($this->post('jump_url')) == '') {
            //create land page
            $land_data = array(
                'model_id' => $this->post('model_id', 'int', 0),
                'game_id' => $this->post('game_id', 'int', 0),
                'package_name' => $this->post('package_name'),
                'company_id' => $this->post('company_id'),
                'page_name' => $this->post('name'),
                'auto_jump' => $this->post('auto_jump', 'int', 0),
                'click_body' => $this->post('click_body', 'int', 0),
                'display_foot' => $this->post('display_foot', 'int', 0),
                'auto_header' => $this->post('auto_header', 'int', 0),
                'header_title' => $this->post('header_title'),
                'header_sub_title' => $this->post('header_sub_title'),
                'header_button' => $this->post('header_button'),
                'code' => trim($this->post('code')),
                'jump_model' => $this->post('jump_model', 'int', 0),
            );
            $result = $this->srv->addLandPageAction($this->post('page_id'), $this->post('new_land', 'int', 0), $land_data);
        }

        if ($result && $result['state'] == false) {
            $this->out = $result;
        } else {
            $data = array(
                'game_id' => $this->post('game_id', 'int', 0),
                'package_name' => $this->post('package_name'),
                'channel_id' => $this->post('channel_id', 'int', 0),
                'user_id' => $this->post('user_id', 'int', 0),
                'name' => $this->post('name'),
                'number' => $this->post('number', 'int', 1),
                'page_id' => (int)$result['page_id'],
                'jump_url' => $result['url'] ? CDN_URL . $result['url'] . '/index.html' : trim($this->post('jump_url')),
                //'status' => $this->post('status', 'int', 0),
                'create_user' => $this->post('create_user'),
                'type' => $type,
            );
            $this->out = $this->srv->addLinkAction($monitor_id, $data);
        }
    }

    /**
     * 删除推广链接
     */
    public function delLink()
    {
        SrvAuth::checkOpen('extend', 'linkList');
        SrvAuth::checkPublicAuth('del');
        $this->outType = 'json';
        $monitor_id = $this->R('monitor_id');
        $this->out = $this->srv->delLink($monitor_id);
    }

    /**
     * 停用推广链接
     */
    public function stopLink()
    {
        SrvAuth::checkOpen('extend', 'linkList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $monitor_id = $this->R('monitor_id');
        $this->out = $this->srv->stopLink($monitor_id);
    }

    /**
     * 停用推广链接批量
     */
    public function stopLinkBatch()
    {
        SrvAuth::checkOpen('extend', 'linkList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $monitor_ids = $this->R('monitor_ids');
        $this->out = $this->srv->stopLinkBatch($monitor_ids);
    }

    public function landPage()
    {
        SrvAuth::checkOpen('extend', 'landPage');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $model_id = $this->R('model_id', 'int', 0);
        $company_id = $this->R('company_id', 'int', 0);
        $name = $this->R('name');

        $this->out['data'] = $this->srv->getLandPageList($page, $game_id, $model_id, $company_id, $name);

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $this->out['_models'] = $this->srv->getAllModel();
        $this->out['_companys'] = $this->srv->getAllCompany();

        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'landPage';
        $this->out['__title__'] = '落地页管理';
        $this->tpl = 'extend/landPageList.tpl';
    }

    public function landCount()
    {
        SrvAuth::checkOpen('extend', 'landPage');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $page_id = $this->R('page_id', 'int', 0);

        $this->out['data'] = $this->srv->getLandCountList($page, $page_id);

        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'landPage';
        $this->out['__title__'] = '落地页数据统计';
        $this->tpl = 'extend/landCount.tpl';
    }

    public function landHourCount()
    {
        SrvAuth::checkOpen('extend', 'landPage');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $code = $this->R('code');

        $this->out['data'] = $this->srv->getLandHourCountList($page, $code);
        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'landPage';
        $this->out['__title__'] = '落地页数据统计';
        $this->tpl = 'extend/landHourCount.tpl';
    }

    public function addLandPage()
    {
        SrvAuth::checkOpen('extend', 'landPage');

        $this->outType = 'smarty';
        $page_id = $this->R('page_id', 'int', 0);
        if ($page_id) {
            SrvAuth::checkPublicAuth('edit');
            $this->out['data']['info'] = $this->srv->getLandPageInfo($page_id);
            $srvPlatform = new SrvPlatform();
            $this->out['data']['_packages'] = $srvPlatform->getPackageByGame($this->out['data']['info']['game_id']);
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();

        $this->out['data']['page_id'] = $page_id;
        $this->out['_companys'] = $this->srv->getAllCompany();
        $this->out['_models'] = $this->srv->getAllModel();

        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'landPage';
        $this->out['__title__'] = '添加/修改落地页';
        $this->tpl = 'extend/addLandPage.tpl';
    }

    public function addLandPageAction()
    {
        SrvAuth::checkOpen('extend', 'landPage');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $page_id = $this->post('page_id', 'int', 0);
        if ($page_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        $data = array(
            'model_id' => $this->post('model_id', 'int', 0),
            'game_id' => $this->post('game_id', 'int', 0),
            'package_name' => $this->post('package_name'),
            'company_id' => $this->post('company_id'),
            'page_name' => $this->post('page_name'),
            'auto_jump' => $this->post('auto_jump', 'int', 0),
            'click_body' => $this->post('click_body', 'int', 0),
            'display_foot' => $this->post('display_foot', 'int', 0),
            'auto_header' => $this->post('auto_header', 'int', 0),
            'header_title' => $this->post('header_title'),
            'header_sub_title' => $this->post('header_sub_title'),
            'header_button' => $this->post('header_button'),
        );
        $this->out = $this->srv->addLandPageAction($page_id, 0, $data);
    }

    public function delLandPage()
    {
        SrvAuth::checkOpen('extend', 'landPage');
        SrvAuth::checkPublicAuth('del');
        $this->outType = 'json';
        $page_id = $this->R('page_id');
        $this->out = $this->srv->delLandPageAction($page_id);
    }

    public function updateMonitorData()
    {
        SrvAuth::checkOpen('extend', 'linkList');
        $this->outType = 'json';
        $cookie = $this->R('cookie');
        $user_id = $this->R('user_id');
        $cookie_id = $this->R('cookie_id');
        $this->out = $this->srv->updateMonitorData($cookie, $user_id, $cookie_id);
    }

    public function landModel()
    {
        SrvAuth::checkOpen('extend', 'landModel');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $sort = $this->R('sort');

        $srvPlatform = new SrvPlatform();
        $data = $this->srv->getLandModelList($game_id, $page, $sort);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$game_id,
                'default_text' => '全部',
                'disabled' => false,
                'parent' => false,
                'attr' => ''
            ),
        );

        $this->out['sort'] = $sort;
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_show_toggle'] = $_COOKIE['show_toggle'] ? $_COOKIE['show_toggle'] : 'th';
        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'landModel';
        $this->out['__title__'] = '落地页模板管理';
        $this->tpl = 'extend/modelList.tpl';
    }

    public function landHeatMap()
    {
        SrvAuth::checkOpen('extend', 'landModel');

        $this->outType = 'smarty';
        $model_id = $this->R('model_id', 'int', 0);
        $this->out['data'] = $this->srv->landHeatMap($model_id);
        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'landModel';
        $this->out['__title__'] = '落点图';
        $this->tpl = 'extend/landHeatMap.tpl';

    }

    public function addLandModel()
    {
        SrvAuth::checkOpen('extend', 'landModel');
        $model_id = $this->R('model_id', 'int', 0);
        if ($model_id > 0) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        if ($_POST) {
            $this->outType = 'json';
            $data = array(
                'game_id' => $this->post('game_id', 'int', 0),
                'model_name' => $this->post('model_name'),
                'zip' => $this->post('upload_file'),
                'thumb' => $this->post('upload_thumb')
            );
            $this->out = $this->srv->addLandModel($model_id, $data);
        } else {
            $this->outType = 'smarty';
            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $data = [];
            $gameId = '';
            $parantId = '';

            if ($model_id) {
                $data = $this->srv->getLandModelInfo($model_id);
                $gameId = $data['game_id'];
                $gameP = LibUtil::fetchChildrenGame($games['parent']);
                $parantId = $gameP[$gameId]['pid'];
            }

            /*$widgets = array(
                'game' => array(
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => (int)$data['game_id'],
                    'default_text' => '选择游戏',
                    'disabled' => false,
                    'parent' => false,
                    'attr' => 'style="width: 150px;"'
                ),
            );*/

            $widgets = array(
                'game' => array(
                    'type' => 'game',
                    'id' => 'parent_id',
                    'data' => $games,
                    'default_value' => $parantId,
                    'default_text' => '选择母游戏',
                    'disable' => false,
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_text' => '选择子游戏',
                    'children_default_value' => $gameId,
                    'attr' => ''
                )
            );

            $this->out['model_id'] = $model_id;
            $this->out['data'] = $data;
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'landModel';
            $this->out['__title__'] = '添加/修改落地页模板';
            $this->tpl = 'extend/addModel.tpl';
        }
    }

    public function editLandModel()
    {
        SrvAuth::checkOpen('extend', 'landModel');

        $this->outType = 'smarty';
        $model_id = $this->R('model_id', 'int', 0);
        SrvAuth::checkPublicAuth('edit');

        $this->out['data']['element'] = $this->srv->editLandModelInfo($model_id);
        $this->out['data']['model_id'] = $model_id;

        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'landModel';
        $this->out['__title__'] = '添加/修改落地页模板';
        $this->tpl = 'extend/editModel.tpl';
    }

    public function editModelAction()
    {
        SrvAuth::checkOpen('extend', 'landModel');
        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $param = array();
        foreach ($_POST as $k => $v) {
            $param[$k] = $this->post($k);
        }
        SrvAuth::checkPublicAuth('edit');
        $this->out = $this->srv->editModelAction($param);
    }

    public function insertUpload()
    {
        $this->outType = 'json';
        $file = $this->get('name', 'string', 'file');
        $model_id = $this->R('model_id', 'int', 0);
        $this->out = $this->srv->insertUpload($model_id, $file);
    }

    public function delLandModel()
    {
        SrvAuth::checkOpen('extend', 'landModel');
        SrvAuth::checkPublicAuth('del');
        $this->outType = 'json';
        $model_id = $this->R('model_id');
        $this->out = $this->srv->delLandModel($model_id);
    }

    public function modifyLandPageAll()
    {
        SrvAuth::checkOpen('extend', 'linkList');
        $this->outType = 'smarty';
        $monitor_id = $this->R('monitor_id');
        LibUtil::clean_xss($monitor_id);

        if ($monitor_id) {
            SrvAuth::checkPublicAuth('edit');
        }

        $srvAdmin = new SrvAdmin();

        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['monitor_id'] = $monitor_id;
        $this->out['_pages'] = $this->srv->getAllPage();
        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'linkList';
        $this->out['__title__'] = '批量修改广告链';
        $this->tpl = 'extend/modifyLandPageAll.tpl';
    }

    public function modifyLandPageAllAction()
    {
        SrvAuth::checkOpen('extend', 'linkList');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $monitor_id = $this->post('monitor_id');
        if ($monitor_id) {
            SrvAuth::checkPublicAuth('edit');
        }
        $data = array(
            'jump_url' => $this->post('jump_url'),
            'page_id' => $this->post('page_id', 'int', 0),
            'create_user' => $this->post('create_user')
        );
        $this->out = $this->srv->modifyLandPageAllAction($monitor_id, $data);
    }

    public function getUserByChannel()
    {
        SrvAuth::checkOpen('extend', 'linkList');

        $this->outType = 'json';
        $channel_id = $this->R('channel_id');
        $this->out = $this->srv->getUserByChannel($channel_id);
    }

    public function costUpload()
    {
        SrvAuth::checkOpen('extend', 'costUploadList');
        $this->outType = 'smarty';

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdmin = new SrvAdmin();

        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '游戏',
                'type' => 'game',
                'data' => $games,
                'default_value' => 0,
                'default_text' => '选择游戏',
                'disabled' => false,
                'parent' => false,
                'attr' => 'style="width: 150px;"'
            ),
        );

        $this->out['create_user'] = SrvAuth::$name;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $srvAdmin->getAllAdmin();

        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'costUploadList';
        $this->out['__title__'] = '广告成本录入';
        $this->tpl = 'extend/costUpload.tpl';
    }

    /**
     * 上传成本列表
     */
    public function costUploadList()
    {
        SrvAuth::checkOpen('extend', 'costUploadList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $upload = $this->R('upload', 'int', 0);
            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->costUploadList($param, $page, $limit, $upload);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $srvAd = new SrvAd();
            $srvAdmin = new SrvAdmin();

            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id',
                    'label' => '选择游戏',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => 0,
                    'default_text' => '选择母游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => 0,
                    'children_default_text' => '选择子游戏',
                    'attr' => 'style="width: 100px;"'
                ),
            );

            $this->out['widgets'] = $widgets;
            $this->out['create_user'] = SrvAuth::$name;
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'costUploadList';
            $this->out['__title__'] = '广告成本管理';
            $this->tpl = 'extend/costUploadList.tpl';
        }
    }

    /**
     * 成本管理单元格编辑
     */
    public function costUploadEdit()
    {
        SrvAuth::checkOpen('extend', 'costUploadList');
        $this->outType = 'json';

        $field = $this->R('field');
        $value = $this->R('value', 'float', 0);
        $data = $this->R('data');
        $this->out = $this->srv->costUploadEdit($field, $value, $data);
    }

    public function costUploadAction()
    {
        SrvAuth::checkOpen('extend', 'costUploadList');
        $this->outType = 'json';
        $file = $this->R('file');
        $this->out = $this->srv->costUploadAction($file);
    }

    /**
     * 删除上传的成本
     */
    public function costUploadDel()
    {
        $this->outType = 'json';
        $id = $this->R('id');
        $this->out = $this->srv->costUploadDel($id);
    }

    public function userExcel1()
    {
        $this->outType = 'string';
        $mod = new ModExtend();

        $this->out['data'] = $mod->userExcel(0);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function userExcel2()
    {
        $this->outType = 'string';
        $mod = new ModExtend();

        $this->out['data'] = $mod->userExcel(1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function userExcel3()
    {
        $this->outType = 'string';
        $mod = new ModExtend();

        $this->out['data'] = $mod->userExcel(2);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function getModelByGame()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $this->out = array_values($this->srv->getModelByGame($game_id));
    }

    /**
     * 更新推广链接缓存
     */
    public function clearCacheLink()
    {
        SrvAuth::checkOpen('extend', 'linkList');
        $this->outType = 'json';
        $this->out = $this->srv->clearCacheLink();
    }

    /**
     * 推广链扣量列表
     */
    public function linkDiscount()
    {
        SrvAuth::checkOpen('extend', 'linkDiscount');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->linkDiscountList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $srvAd = new SrvAd();
            $srvAdmin = new SrvAdmin();

            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id',
                    'label' => '选择游戏',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => 0,
                    'default_text' => '选择母游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => 0,
                    'children_default_text' => '选择子游戏',
                    'attr' => 'style="width: 100px;"'
                ),
            );

            $this->out['widgets'] = $widgets;
            $this->out['create_user'] = SrvAuth::$name;
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'linkDiscount';
            $this->out['__title__'] = '推广链扣量管理';
            $this->tpl = 'extend/linkDiscount.tpl';
        }
    }

    /**
     * 添加推广链扣量
     */
    public function linkDiscountAdd()
    {
        SrvAuth::checkOpen('extend', 'linkDiscount');

        if ($_POST) {
            $this->outType = 'json';

            $data = $this->R('data');
            parse_str($data, $param);

            $this->out = $this->srv->linkDiscountAdd($param);
        } else {
            $this->outType = 'smarty';

            $data = array(
                'is_open' => 1,
                'is_discount' => 0
            );
            $monitor_id = $this->R('monitor_id', 'int', 0);
            if ($monitor_id) {
                $arr = $this->srv->getAdDiscount($monitor_id);
                $update_text = json_decode($arr['update_text'], true);
                $data = array_merge($arr, $update_text);
            }

            $srvPlatform = new SrvPlatform();
            $srvAd = new SrvAd();
            $srvAdmin = new SrvAdmin();

            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => 0,
                    'default_text' => '选择游戏',
                    'disabled' => false,
                    'parent' => false,
                    'attr' => 'style="width: 100px;"'
                ),
            );

            $this->out['data'] = $data;
            $this->out['widgets'] = $widgets;
            $this->out['create_user'] = SrvAuth::$name;
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'linkDiscount';
            $this->out['__title__'] = '推广链扣量管理';
            $this->tpl = 'extend/linkDiscountAdd.tpl';
        }
    }

    /**
     * 删除推广链扣量数据
     */
    public function linkDiscountDel()
    {
        $this->outType = 'json';
        $id = $this->R('id');
        $this->out = $this->srv->linkDiscountDel($id);
    }

    /**
     * 分成管理
     */
    public function splitManage()
    {
        SrvAuth::checkOpen('extend', 'splitManage');

        $json = $this->R('json', 'int', 0);
        $this->outType = 'smarty';
        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        if ($json) {
            $this->outType = 'json';
            $upload = $this->R('upload', 'int', 0);
            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);
            $rows = $this->srv->getSplitManage($param, $page, $limit, $upload);
            $this->out = array(
                'code' => 0,
                'count' => $rows['total'],
                'data' => $rows['list'],
                'msg' => ''
            );
        } else {
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => 0,
                    'default_text' => '选择母游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => 0,
                    'children_default_text' => '选择子游戏',
                    'attr' => 'style="width:150px;"',
                )
            );
            $this->out['create_user'] = SrvAuth::$name;
            $this->out['widgets'] = $widgets;
            $this->out['_games'] = $games['list'];
            $this->out['_channels'] = $srvAd->getAllChannel();

            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'splitManage';
            $this->out['__title__'] = '分成管理';
            $this->tpl = 'extend/splitManage.tpl';
        }

    }

    public function splitUpload()
    {
        SrvAuth::checkOpen('extend', 'splitManage');
        $this->outType = 'smarty';

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdmin = new SrvAdmin();

        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => "游戏：",
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => 0,
                'default_text' => '全部母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => 0,
                'children_default_text' => '全部子游戏',
                'attr' => 'style="width:150px;"',
            )
        );

        $this->out['create_user'] = SrvAuth::$name;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $srvAdmin->getAllAdmin();

        $this->out['__on_menu__'] = 'extend';
        $this->out['__on_sub_menu__'] = 'splitManage';
        $this->out['__title__'] = '分成录入';
        $this->tpl = 'extend/splitUpload.tpl';
    }

    public function splitManageExcel()
    {
        SrvAuth::checkOpen('extend', 'splitManage');
        $this->outType = 'string';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $create_user = $this->R('create_user');
        $data = $this->srv->splitManageExcel($parent_id, $game_id, $channel_id, $create_user);
        SrvPHPExcel::downloadExcel('分成录入', $data['header'], $data['data']);
    }

    public function splitUploadAction()
    {
        SrvAuth::checkOpen('extend', 'splitManage');
        $this->outType = 'json';
        $file = $this->R('file');
        $this->out = $this->srv->splitUploadAction($file);
    }

    /**
     * 成本管理单元格编辑
     */
    public function splitUploadEdit()
    {
        SrvAuth::checkOpen('extend', 'splitManage');
        $this->outType = 'json';
        $field = $this->R('field');
        $value = $this->R('value', 'float', 0);
        $data = $this->R('data');
        $this->out = $this->srv->splitUploadEdit($field, $value, $data);
    }

    /**
     * 删除成本
     */
    public function splitDel()
    {
        SrvAuth::checkOpen('extend', 'splitManage');
        $this->outType = 'json';
        $id = $this->post('id', 'array', []);
        $this->out = $this->srv->splitDel($id);
    }

    /**
     * ASO联运扣量管理
     */
    public function asoDiscount()
    {
        SrvAuth::checkOpen('extend', 'asoDiscount');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->asoDiscountList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $srvAd = new SrvAd();
            $srvAdmin = new SrvAdmin();

            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id',
                    'label' => '选择游戏',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => 0,
                    'default_text' => '选择母游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => 0,
                    'children_default_text' => '选择子游戏',
                    'attr' => 'style="width: 100px;"'
                ),
            );

            $this->out['widgets'] = $widgets;
            $this->out['create_user'] = SrvAuth::$name;
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'asoDiscount';
            $this->out['__title__'] = 'ASO联运扣量管理';
            $this->tpl = 'extend/asoDiscount.tpl';
        }
    }

    /**
     * 添加ASO推广扣量
     */
    public function asoDiscountAdd()
    {
        SrvAuth::checkOpen('extend', 'asoDiscount');

        if ($_POST) {
            $this->outType = 'json';
            $data = $this->R('data');
            parse_str($data, $param);
            $ret = $this->srv->asoDiscountAdd($param);
            $this->out = $ret;
        } else {
            $this->outType = 'smarty';
            $data = array(
                'is_open' => 1,
                'is_discount' => 0
            );
            $game_id = $this->R('game_id', 'int', 0);
            if ($game_id) {
                $arr = $this->srv->getAsoDiscount($game_id);
                $update_text = json_decode($arr['update_text'], true);
                is_null($update_text) && $update_text = array();
                $data = array_merge($arr, $update_text);
            }
            $srvPlatform = new SrvPlatform();
            $srvAd = new SrvAd();
            $srvAdmin = new SrvAdmin();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => !empty($data['parent_id']) ? (int)$data['parent_id'] : 0,
                    'default_text' => '选择母游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => !empty($data['game_id']) ? (int)$data['game_id'] : 0,
                    'children_default_text' => '选择子游戏',
                    'attr' => 'style="width: 100px;"'
                ),
            );

            $this->out['data'] = $data;
            $this->out['widgets'] = $widgets;
            $this->out['create_user'] = SrvAuth::$name;
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'asoDiscount';
            $this->out['__title__'] = 'ASO联运扣量管理';
            $this->tpl = 'extend/asoDiscountAdd.tpl';
        }
    }

    public function asoDiscountDel()
    {
        $this->outType = 'json';
        $id = $this->R('id');
        $this->out = $this->srv->asoDiscountDel($id);
    }

    /**
     * 根据推广链ID获取点击广告信息
     */
    public function clickAd()
    {
        SrvAuth::checkOpen('extend', 'clickAd');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $keyword = trim($this->R('keyword'));

            $row = $this->srv->clickAd($keyword, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';
            $this->out['__on_menu__'] = 'extend';
            $this->out['__on_sub_menu__'] = 'clickAd';
            $this->out['__title__'] = '广告点击日志';
            $this->tpl = 'extend/clickAd.tpl';
        }
    }

    /**
     * 手动上报广告回调
     */
    public function clickAdUpload()
    {
        SrvAuth::checkOpen('extend', 'clickAd');
        $this->outType = 'json';

        $type = $this->R('type');
        $id = $this->post('id', 'int', 0);
        $this->out = $this->srv->clickAdUpload($type, $id);
    }
}