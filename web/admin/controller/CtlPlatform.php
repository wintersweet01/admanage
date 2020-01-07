<?php

class CtlPlatform extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvPlatform();
    }

    public function gameList()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);
            $this->out = $this->srv->getGameList_page($page, $limit, $param);//分页版本
        } else {
            $this->outType = 'smarty';

            $this->out['__domain__'] = ROOT_DOMAIN;
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'gameList';
            $this->out['__title__'] = '游戏管理';
            $this->tpl = 'platform/game_list.tpl';
        }
    }

    public function addGame()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $this->outType = 'smarty';
        $game_id = (int)$this->R('game_id', 'int', 0);
        $parent_id = (int)$this->R('parent_id', 'int', 0);
        $children_id = 0;
        if ($game_id) {
            SrvAuth::checkPublicAuth('edit');
            $data = $this->srv->getGameInfo($game_id);
            $data['config'] = unserialize($data['config']);
            $data['config']['combine']['ratio'] || $data['config']['combine']['ratio'] = 10;

            $children_id = (int)$data['config']['inherit'];
        } else {
            SrvAuth::checkPublicAuth('add');

            $data['parent_id'] = $parent_id;
            $data['game_id'] = $game_id;
            $data['type'] = 1;
            $data['device_type'] = 2;
            $data['ratio'] = 100;
            $data['unit'] = 0;
            $data['status'] = 0;
            $data['is_login'] = 1;
            $data['is_reg'] = 1;
            $data['is_pay'] = 1;
            $data['config']['pay_mode']['ios'] = array(1);
            $data['config']['pay_mode']['android'] = array(7, 8);
            $data['config']['pay_mode']['usa'] = 1;
            $data['config']['status']['ios'] = 1;
            $data['config']['status']['android'] = 1;
            $data['config']['is_adult'] = 1;
            $data['config']['combine']['ratio'] = 10;
        }

        $widgets = array(
            'game' => array(
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $this->srv->getAllGame(true), //游戏数据树
                'default_value' => empty($data) ? 0 : (int)$data['parent_id'], //默认值
                'default_text' => '选择母游戏', //默认显示内容
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_default_value' => $children_id, //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => true, //过滤继承的游戏
                'children_attr' => 'style="width: 200px"',
                'attr' => 'style="width: 150px"' //标签属性参数
            ),
        );

        $pay_types = LibUtil::config('ConfPayType');
        foreach ($pay_types as $key => $val) {
            if (!in_array($key, array(1, 2, 4, 7, 8, 9, 10, 11))) {
                unset($pay_types[$key]);
            }
        }

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_signature'] = SIGNATURE_APK;
        $this->out['_pay_types'] = $pay_types;
        $this->out['_pay_channel_types'] = LibUtil::config('ConfUnionChannel');
        $this->out['__domain__'] = ROOT_DOMAIN;
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'gameList';
        $this->out['__title__'] = '添加/修改游戏';
        $this->tpl = 'platform/game_add.tpl';
        //$this->tpl = 'platform/add.tpl';
    }

    public function addGameAction()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $param);
        $game_id = (int)$param['game_id'];
        if ($game_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        $this->out = $this->srv->addGameAction($game_id, $param);
    }

    public function packageList()
    {
        SrvAuth::checkOpen('platform', 'packageList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->getPackageList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $games = $this->srv->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id', //自定义ID
                    'label' => '选择游戏',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => 0,
                    'default_text' => '选择母游戏',
                    'disabled' => false,
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'game_id',
                    'children_default_value' => 0, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                    'attr' => '' //标签属性参数
                ),
            );

            $srvAd = new SrvAd();
            $this->out['widgets'] = $widgets;
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_games'] = $games['list'];
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'packageList';
            $this->out['__title__'] = '游戏包管理';
            $this->tpl = 'platform/package_list.tpl';
        }
    }

    /**
     * 添加分包页面
     */
    public function addPackage()
    {
        SrvAuth::checkOpen('platform', 'packageList');
        $this->outType = 'smarty';

        $package_id = $this->R('package_id', 'int', 0);
        $parent_id = 0;
        $game_id = 0;
        $data = array();
        $games = $this->srv->getAllGame(true);

        if ($package_id) {
            SrvAuth::checkPublicAuth('edit');

            $data = $this->srv->getPackageInfo($package_id);
            $game_id = $data['game_id'];
            $childGame = LibUtil::fetchChildrenGame($games['parent']);
            $parent_id = $childGame[$game_id]['pid'];
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $widgets = array(
            'game' => array(
                'id' => 'parent_id', //自定义ID
                'type' => 'game',
                'data' => $games,
                'default_value' => $parent_id,
                'default_text' => '选择母游戏',
                'disabled' => $package_id > 0 ? true : false,
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_id' => 'game_id',
                'children_default_value' => $game_id, //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_attr' => 'style="width: 200px"',
                'attr' => '' //标签属性参数
            ),
        );

        $srvAd = new SrvAd();
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['data']['info'] = $data;
        $this->out['data']['package_id'] = $package_id;
        $this->out['widgets'] = $widgets;
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'packageList';
        $this->out['__title__'] = '添加/修改游戏包';
        $this->tpl = 'platform/addPackage.tpl';
    }

    /**
     * 执行添加分包
     */
    public function addPackageAction()
    {
        SrvAuth::checkOpen('platform', 'packageList');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $package_id = $this->post('package_id', 'int', 0);
        if ($package_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        $data = array(
            'game_id' => $this->post('game_id', 'int', 0),
            'down_url' => $this->post('down_url'),
            'package_num' => $this->post('package_num', 'int', 0),
            'platform' => $this->post('platform'),
            'channel_id' => $this->post('channel_id'),
            'user_id' => $this->post('user_id'),
            'spec_name' => $this->post('spec_name'),
            'spec_icon' => $this->post('spec_icon'),
        );
        $this->out = $this->srv->addPackageAction($package_id, $data);
    }

    /**
     * 删除分包
     */
    public function delPackage()
    {
        SrvAuth::checkOpen('platform', 'packageList');
        SrvAuth::checkPublicAuth('del');
        $this->outType = 'json';
        $id = (int)$this->R('id');
        $this->out = $this->srv->delPackage($id);
    }

    /**
     * 删除全部已经关闭游戏的分包
     */
    public function delPackageAll()
    {
        SrvAuth::checkOpen('platform', 'packageList');
        SrvAuth::checkPublicAuth('del');
        $this->outType = 'json';
        $this->out = $this->srv->delPackageAll();
    }

    public function userList()
    {
        SrvAuth::checkOpen('platform', 'userList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->getUserList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $srvAd = new SrvAd();
            $games = $this->srv->getAllGame(true);
            $channels = $srvAd->getAllChannel();
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
                    'attr' => 'style="width: 100px"'
                )
            );

            $this->out['is_admin'] = SrvAuth::$id;
            $this->out['widgets'] = $widgets;
            $this->out['_channels'] = $channels;
            $this->out['_union_channel'] = LibUtil::config('ConfUnionChannel');
            $this->out['_device_types'] = PLATFORM;
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'userList';
            $this->out['__title__'] = '用户管理';
            $this->tpl = 'platform/user_list.tpl';
        }
    }

    /**
     * 重置用户密码
     */
    public function resetPwd()
    {
        SrvAuth::checkOpen('platform', 'userList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $uid = $this->post('uid');
        $this->out = $this->srv->resetPwd($uid);
    }

    /**
     * 解封禁用户
     */
    public function bandUser()
    {
        SrvAuth::checkOpen('platform', 'userList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $uid = $this->post('uid', 'int', 0);
        $status = $this->post('status', 'int', 0);
        $text = $this->post('text');

        $this->out = $this->srv->bandUser($uid, $status, $text);
    }

    /**
     * 踢用户下线
     */
    public function kickUser()
    {
        SrvAuth::checkOpen('platform', 'userList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $uid = $this->post('uid');
        $this->out = $this->srv->kickUser($uid);
    }

    /**
     * 解绑手机
     */
    public function unbindPhone()
    {
        SrvAuth::checkOpen('platform', 'userList');
        $this->outType = 'json';
        $uid = $this->post('uid', 'int', 0);
        $this->out = $this->srv->saveUserInfo($uid, array('phone' => ''));
    }

    /**
     * 删除用户
     */
    public function delUser()
    {
        SrvAuth::checkOpen('platform', 'userList');
        SrvAuth::checkPublicAuth('del');
        $this->outType = 'json';
        $uid = (int)$this->post('uid', 'int', 0);
        $this->out = $this->srv->delUser($uid);
    }

    /**
     * 订单列表
     */
    public function orderList()
    {
        SrvAuth::checkOpen('platform', 'orderList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->getOrderList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => (int)$row['count'],
                'data' => $row['data'],
                'query' => $row['query'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $is_pay = $this->R('is_pay', 'int', 0);
            $uid = $this->R('uid', 'int', 0);
            $parent_id = $this->R('parent_id', 'int', 0);
            $game_id = $this->R('game_id', 'int', 0);
            $server_id = $this->R('server_id', 'int', 0);
            $device_type = $this->R('device_type', 'int', 0);

            $query = "is_pay=$is_pay&uid=$uid&parent_id=$parent_id&game_id=$game_id&server_id=$server_id&device_type=$device_type";

            $srvAd = new SrvAd();
            $games = $this->srv->getAllGame(true);
            $channels = $srvAd->getAllChannel();
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

            $this->out['query'] = urlencode($query);
            $this->out['widgets'] = $widgets;
            $this->out['_channels'] = $channels;
            $this->out['_pay_types'] = LibUtil::config('ConfPayType');
            $this->out['_pay_channel_types'] = LibUtil::config('ConfUnionChannel');
            $this->out['_device_types'] = PLATFORM;
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'orderList';
            $this->out['__title__'] = '订单管理';
            $this->tpl = 'platform/order_list.tpl';
        }
    }

    /**
     * 订单导出下载
     */
    public function orderDownload()
    {
        SrvAuth::checkOpen('platform', 'orderList');

        $this->outType = 'json';
        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $server_id = $this->R('server_id', 'int', 0);
        $level1 = $this->R('level1', 'int', 0);
        $level2 = $this->R('level2', 'int', 0);
        $package_name = $this->R('package_name');
        $pay_type = $this->R('pay_type', 'int', 0);
        $pay_channel = $this->R('pay_channel');
        $order_num = $this->R('pt_order_num');
        $username = $this->R('username');
        $role_name = $this->R('role_name');
        $uid = $this->R('uid', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $is_pay = $this->R('is_pay', 'int', 0);
        $is_notify = $this->R('is_notify', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);

        $this->out = $this->srv->getOrderDownloadUrl($sdate, $edate, $game_id, $server_id, $level1, $level2, $package_name, $username, $uid, $role_name, $pay_type, $pay_channel, $order_num, $is_pay, $is_notify, $device_type, $channel_id);
    }

    public function getGameServers()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id', 'int', 0);
        $srvData = new SrvData();
        if (!$game_id) {
            $this->out = array();
        } else {
            $this->out = $srvData->getGameServer($game_id);
        }
    }

    public function getGameLevels()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id', 'int', 0);
        $srvData = new SrvData();
        $this->out = $srvData->getMoneyLevel($game_id);
    }

    /**
     * 角色管理
     */
    public function roleList()
    {
        SrvAuth::checkOpen('platform', 'roleList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->getRoleList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $srvAd = new SrvAd();
            $games = $this->srv->getAllGame(true);
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
                    'attr' => 'style="width: 100px"'
                )
            );

            $this->out['is_admin'] = SrvAuth::$id;
            $this->out['widgets'] = $widgets;
            $this->out['_games'] = $games['list'];
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'roleList';
            $this->out['__title__'] = '角色管理';
            $this->tpl = 'platform/role_list.tpl';
        }
    }

    public function roleDownload()
    {
        SrvAuth::checkOpen('platform', 'roleList');

        $this->outType = 'json';
        $username = $this->R('username');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $server_id = $this->R('server_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $has_pay = $this->R('has_pay', 'int', 0);
        $role_name = $this->R('role_name');
        $channel_id = $this->R('channel_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $has_phone = $this->R('has_phone', 'int', 0);
        $package_name = $this->R('package_name');

        $this->srv->getRoleDownloadUrl($parent_id, $game_id, $channel_id, $device_type, $package_name, $server_id, $role_name, $username, $sdate, $edate, $has_pay, $has_phone);
    }

    public function monitorRoleList()
    {
        SrvAuth::checkOpen('platform', 'roleList');

        $this->outType = 'smarty';
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $this->out['_games'] = $this->srv->getAllGame();
        $this->out['data'] = $this->srv->getMonitorRoleList($monitor_id, $sdate, $edate);
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'roleList';
        $this->out['__title__'] = '角色管理';
        $this->tpl = 'platform/monitor_role_list.tpl';
    }

    public function logList()
    {
        SrvAuth::checkOpen('platform', 'logList');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $username = $this->R('username');
        $type = $this->R('type');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $this->out['data'] = $this->srv->logList($page, $username, $type, $sdate, $edate);
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'logList';
        $this->out['__title__'] = '用户日志';
        $this->tpl = 'platform/log_list.tpl';
    }

    public function handSendNotify()
    {
        SrvAuth::checkOpen('platform', 'orderList');
        SrvAuth::checkPublicAuth('audit');
        $this->outType = 'json';
        $order_num = $this->R('order_num');
        $this->out = $this->srv->handSendNotify($order_num);
    }

    public function getPackageByGame()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $channel_id = $this->R('channel_id');
        $device_type = $this->R('device_type');
        $this->out = $this->srv->getPackageByGame($game_id, $channel_id, $device_type);
    }

    public function getMonitorByGame()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $this->out = $this->srv->getMonitorByGame($game_id);
    }

    public function getMonitorByGamePlat()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $device_type = $this->R('device_type');
        $this->out = $this->srv->getMonitorByGamePlat($game_id, $device_type);
    }

    public function getPackageIcon()
    {
        $this->outType = 'json';
        $package_name = $this->R('package_name');
        $this->out = $this->srv->getPackageIcon($package_name);
    }

    public function packagePay()
    {
        SrvAuth::checkOpen('platform', 'packageList');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $platform = $this->R('platform');
        $games = LibUtil::config('games');
        $G = $games[$game_id];

        $pay_types = LibUtil::config('ConfPayType');
        foreach ($pay_types as $key => $val) {
            if (!in_array($key, array(1, 2, 4))) {
                unset($pay_types[$key]);
            }
        }

        $this->out['data'] = $this->srv->packagePay($game_id, $package_name);
        $this->out['game_id'] = $game_id;
        LibUtil::clean_xss($package_name);
        $this->out['platform'] = $platform;
        $this->out['package_name'] = $package_name;
        $this->out['package_version'] = $G['package_version'];
        $this->out['_pay_types'] = $pay_types;
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'packageList';
        $this->out['__title__'] = '支付设置';
        $this->tpl = 'platform/package_pay.tpl';
    }

    public function packagePayAction()
    {
        SrvAuth::checkOpen('platform', 'packageList');

        $this->outType = 'json';
        $data = $this->R('data');
        parse_str($data, $_POST);
        $game_id = $this->post('game_id', 'int', 0);
        $package_name = $this->post('package_name');
        $status = $this->post('status');
        $pay_type = $this->post('pay_type');
        $config = $this->post('config');
        $this->out = $this->srv->packagePayAction($game_id, $package_name, $status, $pay_type, $config);
    }

    /**
     * 下载对接信息
     */
    public function gameParams()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $this->outType = 'string';
        $game_id = $this->R('game_id');
        $this->srv->gameParams($game_id);
    }

    /**
     * 升级包版本
     */
    public function gameLevel()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $this->out = $this->srv->gameLevel($game_id);
    }

    /**
     * 上传母包
     */
    public function uploadApk()
    {
        SrvAuth::checkOpen('platform', 'gameList');
        $this->outType = 'json';

        $total = $this->post('chunks', 'int', 0); //WebUploader，分割上传文件总数，0不分割
        $now = $this->post('chunk', 'int', 0); //WebUploader，当前上传分割数
        $nowSize = $this->post('chunkSize'); //WebUploader，当前分片大小，单位：字节
        $size = $this->post('size', 'int', 0); //WebUploader，上传文件大小，单位：字节
        $guid = $this->post('guid'); //WebUploader，页面唯一GUID
        $name = $this->post('name'); //WebUploader，文件名
        $fileMd5 = $this->post('fileMd5'); //WebUploader，上传文件MD5

        $this->out = $this->srv->uploadApk($fileMd5, $total, $now, $size, $nowSize, $guid, $name);
    }

    public function orderNumLog()
    {
        SrvAuth::checkOpen('platform', 'orderList');
        $this->outType = 'string';
        $pt_order_num = $this->R('pt_order_num');
        echo $this->srv->orderLog($pt_order_num);
    }

    public function orderNumCheck()
    {
        SrvAuth::checkOpen('platform', 'orderList');
        $this->outType = 'json';
        $pt_order_num = $this->R('pt_order_num');
        $this->out = $this->srv->orderCheck($pt_order_num);
    }

    public function subApkAction()
    {
        SrvAuth::checkOpen('platform', 'packageList');

        $this->outType = 'json';
        $key = $this->R('key');
        $this->out = $this->srv->subApkAction($key);
    }

    public function refreshPackage()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $this->outType = 'json';
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $this->out = $this->srv->refreshPackage($game_id, $package_name);
    }

    /**
     * 安卓分包进度列表
     */
    public function refreshProgress()
    {
        SrvAuth::checkOpen('platform', 'packageList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $game_id = $this->R('game_id', 'int', 0);
            $state = $this->R('state', 'int', 0);
            $package_name = $this->R('package_name');

            $row = $this->srv->refreshProgress($game_id, $state, $package_name, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $game_id = $this->R('game_id', 'int', 0);
            $state = $this->R('state', 'int', 0);
            $package_name = $this->R('package_name');

            $games = $this->srv->getAllGame(false);

            $this->out['game_id'] = $game_id;
            $this->out['package_name'] = $package_name;
            $this->out['state'] = $state;
            $this->out['_games'] = $games;
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'packageList';
            $this->out['__title__'] = '游戏分包进度';
            $this->tpl = 'platform/refresh_progress.tpl';
        }
    }

    public function refreshStatus()
    {
        SrvAuth::checkOpen('platform', 'packageList');

        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $this->outType = 'json';
        $this->out = $this->srv->refreshStatus($game_id, $package_name);
    }

    /**
     * 对单个包重新分包
     */
    public function refreshRepeat()
    {
        SrvAuth::checkOpen('platform', 'packageList');
        $this->outType = 'json';

        $id = $this->R('id', 'int', 0);

        $this->out = $this->srv->refreshRepeat($id);
    }

    /**
     * 礼包管理
     */
    public function packageGift()
    {
        SrvAuth::checkOpen('platform', 'packageGift');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);

        $games = $this->srv->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '母游戏',
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => (int)$parent_id, //默认值
                'default_text' => '选择母游戏', //默认显示内容
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_id' => 'game_id',
                'children_label' => '子游戏', //子游戏标签
                'children_default_value' => (int)$game_id, //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
            ),
        );

        $this->out['data'] = $this->srv->getPackageGift($parent_id, $game_id);
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'packageGift';
        $this->out['__title__'] = '礼包管理';
        $this->tpl = 'platform/package_gift.tpl';
    }

    /**
     * 导入游戏礼包
     */
    public function importGift()
    {
        SrvAuth::checkOpen('platform', 'packageGift');

        if ($_POST) {
            $this->outType = 'json';
            $type_id = $this->post('type_id', 'int', 0);
            $upload_file = $this->post('upload_file');
            $this->out = $this->srv->importGift($type_id, $upload_file);
        } else {
            $this->outType = 'smarty';
            $parent_id = $this->R('parent_id', 'int', 0);
            $game_id = $this->R('game_id', 'int', 0);
            $type_id = $this->R('type_id', 'int', 0);

            $games = $this->srv->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $games, //游戏数据树
                    'default_value' => (int)$parent_id, //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'disabled' => false, //是否不可选
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'game_id',
                    'children_default_value' => (int)$game_id, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                    'children_inherit' => false, //过滤继承的游戏
                ),
            );

            $this->out['data']['type_id'] = $type_id;
            $this->out['widgets'] = $widgets;
            $this->out['_games'] = $games['list'];
            $this->out['_types'] = $this->srv->getGiftTypeList($parent_id, $game_id);
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'packageGift';
            $this->out['__title__'] = '导入游戏礼包';
            $this->tpl = 'platform/gift_import.tpl';
        }
    }

    public function getGiftTypeList()
    {
        $this->outType = 'json';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $this->out = $this->srv->getGiftTypeList($parent_id, $game_id);
    }

    /**
     * 添加礼包类别
     */
    public function addGiftType()
    {
        SrvAuth::checkOpen('platform', 'packageGift');

        $this->outType = 'smarty';

        $data = [];
        $id = $this->R('id', 'int', 0);
        if ($id > 0) {
            $data = $this->srv->getGiftTypeInfo($id);
        } else {
            $data['id'] = $id;
            $data['status'] = 1;
        }

        $games = $this->srv->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => (int)$data['parent_id'], //默认值
                'default_text' => '选择母游戏', //默认显示内容
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'], //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
                'attr' => '' //标签属性参数
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_types'] = LibUtil::config('ConfGiftType');
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'packageGift';
        $this->out['__title__'] = '添加礼包类别';
        $this->tpl = 'platform/gift_type.tpl';
    }

    /**
     * 保存礼包类别[sync]
     */
    public function addGiftTypeAction()
    {
        SrvAuth::checkOpen('platform', 'packageGift');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $id = $this->post('id', 'int', 0);
        $data = array(
            'parent_id' => $this->post('parent_id', 'int', 0),
            'game_id' => $this->post('game_id', 'int', 0),
            'type' => $this->post('type', 'int', 0),
            'name' => $this->post('name'),
            'status' => (int)$this->post('status'),
            'explain' => $this->post('explain'),
            'amount' => 0,
            'used' => 0
        );
        $this->out = $this->srv->addGiftTypeAction($id, $data);
    }

    /**
     * 删除礼包
     */
    public function delGiftType()
    {
        $this->outType = 'json';
        $id = $this->R('id');
        $this->out = $this->srv->delGiftType($id);
    }

    /**
     * 上传游戏母包
     */
    public function gameUpdate()
    {
        SrvAuth::checkOpen('platform', 'gameList');
        SrvAuth::checkPublicAuth('add');

        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);

        $data = $this->srv->getGameInfo($game_id);
        $data['type'] = 3;
        $this->out['data'] = $data;
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'gameList';
        $this->out['__title__'] = '上传母包';
        $this->tpl = 'platform/update.tpl';
    }

    public function gameUpdateAction()
    {
        $this->outType = 'json';
        $data = array(
            'game_id' => $this->post('game_id', 'int', 0),
            'upload_file' => $this->post('upload_file'),
            'description' => $this->post('description'),
            'type' => $this->post('type', 'int', 0),
        );

        $this->out = $this->srv->gameUpdateAction($data);
    }

    public function clearCache()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $parent_id = $this->R('parent_id');
        $this->out = $this->srv->clearCache($parent_id, $game_id);
    }

    /**
     * 更新所有游戏文件缓存
     */
    public function clearCacheAll()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $this->outType = 'json';
        $this->out = $this->srv->clearCacheAll();
    }

    /**
     * 激活日志
     */
    public function activeLog()
    {
        SrvAuth::checkOpen('platform', 'activeLog');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->activeLog($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'query' => $row['query'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $srvAd = new SrvAd();
            $games = $this->srv->getAllGame(true);
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
                    'attr' => 'style="width: 100px"'
                )
            );

            $this->out['is_admin'] = SrvAuth::$id;
            $this->out['widgets'] = $widgets;
            $this->out['_games'] = $games['list'];
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'activeLog';
            $this->out['__title__'] = '激活日志';
            $this->tpl = 'platform/active_log.tpl';
        }
    }

    /**
     * 手动激活回调测试
     */
    public function activeCallback()
    {
        SrvAuth::checkOpen('platform', 'activeLog');

        $this->outType = 'json';
        $id = $this->post('id', 'int', 0);
        $this->out = $this->srv->activeCallback($id);
    }

    /**
     * 根据包名获取包信息
     */
    public function getPackageInfoByPackageName()
    {
        $this->outType = 'json';
        $package_name = $this->R('package_name');
        $this->out = $this->srv->getPackageInfoByPackageName($package_name);
    }

    /**
     * 直充补单
     */
    public function orderReplacementList()
    {
        SrvAuth::checkOpen('platform', 'orderReplacementList');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $package_name = $this->R('package_name');
        $pay_type = $this->R('pay_type', 'int', 0);
        $order_num = $this->R('pt_order_num');
        $username = $this->R('username');
        $role_name = $this->R('role_name');

        $data = [];
        if ($order_num) {
            $data = $this->srv->getOrderReplacementList($page, $parent_id, $game_id, $device_type, $package_name, $pay_type, $order_num, $username, $role_name);
        }

        $games = $this->srv->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 100px"'
            )
        );
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_pay_types'] = LibUtil::config('ConfPayType');
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'orderReplacementList';
        $this->out['__title__'] = '直充补单';
        $this->tpl = 'platform/orderReplacementList.tpl';
    }

    /**
     * 订单直充
     */
    public function orderDirect()
    {
        SrvAuth::checkOpen('platform', 'orderReplacementList');
        $this->outType = 'json';
        $pt_order_num = $this->R('pt_order_num');
        $this->out = $this->srv->orderDirect($pt_order_num);
    }

    /**
     * 系统配置
     */
    public function config()
    {
        SrvAuth::checkOpen('platform', 'config');

        if ($_POST) {
            $this->outType = 'json';

            $data = $this->post('data');
            parse_str($data, $param);
            $this->out = $this->srv->configAction($param);
        } else {
            $this->outType = 'smarty';

            $this->out['data'] = $this->srv->config();
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'config';
            $this->out['__title__'] = '系统配置';
            $this->tpl = 'platform/config.tpl';
        }
    }

    /**
     * 封禁管理列表
     */
    public function forbidden()
    {
        SrvAuth::checkOpen('platform', 'forbidden');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 17);
            $type = $this->R('type', 'int', 1);
            $keyword = $this->R('keyword');

            $row = $this->srv->getForbidden($type, $keyword, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';

            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'forbidden';
            $this->out['__title__'] = '封禁管理';
            $this->tpl = 'platform/forbidden.tpl';
        }
    }

    /**
     * 添加封禁
     */
    public function forbiddenAdd()
    {
        SrvAuth::checkOpen('platform', 'forbidden');

        if ($_POST) {
            $this->outType = 'none';
            $data = $this->post('data');
            parse_str($data, $param);
            $this->srv->forbiddenAdd($param);
            exit();
        }

        $this->outType = 'smarty';
        $this->out['__title__'] = '添加封禁';
        $this->tpl = 'platform/forbiddenAdd.tpl';
    }

    /**
     * 封禁解封
     */
    public function forbiddenUpdate()
    {
        SrvAuth::checkOpen('platform', 'forbidden');
        $this->outType = 'json';

        $type = $this->post('type', 'int', 0);
        $key = $this->post('key');
        $checked = (int)$this->post('checked', 'int', 0);
        $value = $this->post('value');

        $this->out = $this->srv->forbiddenUpdate($type, $value, $key, $checked);
    }

    /**
     * 解封
     */
    public function forbiddenDel()
    {
        SrvAuth::checkOpen('platform', 'forbidden');
        $this->outType = 'json';

        $type = $this->post('type', 'int', 0);
        $key = $this->post('key');
        $this->out = $this->srv->forbiddenDel($type, $key);
    }

    /**
     * 刷新安卓分包升级缓存
     */
    public function clearPackageCacheAll()
    {
        SrvAuth::checkOpen('platform', 'packageList');

        $this->outType = 'json';
        $this->out = $this->srv->clearPackageCacheAll();
    }

    /**
     * 复制继承游戏客服信息
     */
    public function copyKefuInfo()
    {
        SrvAuth::checkOpen('platform', 'gameList');
        $this->outType = 'json';
        $game_id = $this->post('game_id', 'int', 0);
        $this->out = $this->srv->copyKefuInfo($game_id);
    }

    /**
     * 联运分发平台管理
     */
    public function platformList()
    {
        SrvAuth::checkOpen('platform', 'platformList');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);
            $this->out = $this->srv->getPlatformList($page, $limit, $param);//分页版本
        } else {
            $this->outType = 'smarty';

            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'platformList';
            $this->out['__title__'] = '联运管理';
            $this->tpl = 'platform/platformList.tpl';
        }
    }

    /**
     * 添加/编辑平台
     */
    public function platformAdd()
    {
        SrvAuth::checkOpen('platform', 'platformList');

        if ($_POST) {
            $this->outType = 'json';

            $data = $this->post('data');
            parse_str($data, $param);

            $this->out = $this->srv->platformAdd($param);
        } else {
            $this->outType = 'smarty';
            $platform_id = $this->R('platform_id', 'int', 0);

            if ($platform_id) {
                $data = $this->srv->getPlatformInfo($platform_id);
                $data['config'] = unserialize($data['config']);
            } else {
                $data['platform_id'] = $platform_id;
                $data['is_login'] = 1;
                $data['is_pay'] = 1;
                $data['lock'] = 0;
            }

            $this->out['data'] = $data;
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'platformList';
            $this->out['__title__'] = '添加/修改平台';
            $this->tpl = 'platform/platformAdd.tpl';
        }
    }

    /**
     * 添加/编辑平台游戏
     */
    public function platformAddGame()
    {
        SrvAuth::checkOpen('platform', 'platformList');

        if ($_POST) {
            $this->outType = 'json';

            $data = $this->post('data');
            parse_str($data, $param);

            $this->out = $this->srv->platformAddGame($param);
        } else {
            $this->outType = 'smarty';
            $platform_id = (int)$this->R('platform_id', 'int', 0);
            $game_id = (int)$this->R('game_id', 'int', 0);
            $type = $this->R('type');
            $platform = $this->srv->getAllPlatform();
            $exclude_game = array();

            if ($type == 'edit') {
                $data = $this->srv->getPlatformGameInfo($platform_id, $game_id);
                $data['config'] = unserialize($data['config']);
            } else {
                $data['game_id'] = $game_id;
                $data['platform_id'] = $platform_id;
                $data['is_login'] = 1;
                $data['is_pay'] = 1;
                $data['lock'] = 0;

                //排除已添加的平台
                if ($game_id > 0) {
                    $info = $this->srv->getPlatformGameList(0, $game_id, 0);
                    foreach ($info['platform'] as $pid => $row) {
                        if (isset($platform[$pid])) {
                            unset($platform[$pid]);
                        }
                    }
                }

                //排除已添加的游戏
                if ($platform_id > 0) {
                    $info = $this->srv->getPlatformGameList(0, 0, $platform_id);
                    $exclude_game = array_keys($info['game']);
                }
            }
            $data['type'] = $type;

            $widgets = array(
                'game' => array(
                    'type' => 'game', //插件类型
                    'data' => $this->srv->getAllGame(true, true, 2, $exclude_game), //游戏数据树
                    'default_value' => (int)$game_id, //默认值
                    'default_text' => '选择游戏',
                    'disabled' => $game_id > 0 ? true : false, //是否不可选
                    'parent' => false, //是否开启只可选择父游戏
                    'children_inherit' => true, //过滤继承的游戏
                    'attr' => 'style="width: 150px"' //标签属性参数
                ),
            );

            $this->out['data'] = $data;
            $this->out['widgets'] = $widgets;
            $this->out['_platform'] = $platform;
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'platformList';
            $this->out['__title__'] = '添加/修改游戏';
            $this->tpl = 'platform/platformAddGame.tpl';
        }
    }

    /**
     * 下载平台对应游戏参数
     */
    public function downloadPlatformGameParam()
    {
        SrvAuth::checkOpen('platform', 'platformList');

        $this->outType = 'string';
        $platform_id = $this->R('platform_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $this->srv->downloadPlatformGameParam($platform_id, $game_id);
    }

    /**
     * 设置平台对应游戏缓存
     */
    public function setPlatformGameCache()
    {
        SrvAuth::checkOpen('platform', 'platformList');

        $this->outType = 'json';
        $this->out = $this->srv->setPlatformGameCache();
    }

    //玩家日志
    public function playerLog()
    {
        SrvAuth::checkOpen('platform', 'playerLog');
        $this->outType = 'smarty';

        $param = array();

        $param['parent_id'] = $this->R('parent_id', 'int', 0);
        $param['game_id'] = $this->R('game_id', 'int', 0);
        $param['server_id'] = $this->R('server_id', 'int', 0);
        $param['device_type'] = $this->R('device_type', 'int', 0);
        $param['channel_id'] = $this->R('channel_id', 'int', 0);
        $param['role_name'] = $this->R('role_name', 'string', '');
        $param['account'] = $this->R('account', 'string', '');
        $param['opp'] = $this->R('opp', 'string', '');
        $param['ip'] = $this->R('ip', 'string', '');
        $param['sdate'] = $this->R('sdate', 'string', '');
        $param['edate'] = $this->R('edate', 'string', '');

        $page = $this->R('page', 'int', 0);
        $h_type = LibUtil::config('ConfLogType');
        unset($h_type[0]);
        $data = $this->srv->getPlayerLog($param, $page, 0);
        $widgets = array(
            'game' => array(
                'title' => '游戏',
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $data['_games'],
                'default_value' => $data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => $data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width:150px;"'
            )
        );
        $this->out['_games'] = $data['_games'];
        $this->out['_channels'] = $data['_channels'];
        $this->out['h_type'] = $h_type;
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['__title__'] = '玩家日志';
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'playerLog';
        $this->tpl = 'platform/player_log.tpl';
    }

    public function playerLogExcel()
    {
        SrvAuth::checkOpen('platform', 'playerLog');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');
        $this->outType = 'string';
        $param = array();
        $param['parent_id'] = $this->R('parent_id', 'int', 0);
        $param['game_id'] = $this->R('game_id', 'int', 0);
        $param['server_id'] = $this->R('server_id', 'int', 0);
        $param['device_type'] = $this->R('device_type', 'int', 0);
        $param['channel_id'] = $this->R('channel_id', 'int', 0);
        $param['role_name'] = $this->R('role_name', 'string', '');
        $param['account'] = $this->R('account', 'string', '');
        $param['opp'] = $this->R('opp', 'string', '');
        $param['ip'] = $this->R('ip', 'string', '');
        $param['sdate'] = $this->R('sdate', 'string', '');
        $param['edate'] = $this->R('edate', 'string', '');

        $data = $this->srv->getPlayerLog($param, 0, 1);
        $date = substr($param['sdate'], 0, 10);
        SrvPHPExcel::downloadExcel('玩家日志' . $date, $data['header'], $data['data']);
    }

    /**
     * 测试验收
     */
    public function acceptTest()
    {
        SrvAuth::checkOpen('platform', 'acceptTest');
        $this->outType = 'smarty';

        $keyword = trim($this->R('keyword'));
        $data = $this->srv->acceptTest($keyword);
        $srvAd = new SrvAd();

        $types = $alias = array();
        $all_type = LibUtil::config('user_log_type');
        foreach ($all_type as $key => $row) {
            $types[$row['id']] = $row['name'];
            $alias[$key] = $row['name'];
        }

        $this->out['data'] = $data;
        $this->out['keyword'] = $keyword;
        $this->out['_logType'] = $types;
        $this->out['_logAlias'] = $alias;
        $this->out['_payType'] = LibUtil::config('ConfPayType');
        $this->out['_union'] = LibUtil::config('ConfUnionChannel');
        $this->out['_games'] = $this->srv->getAllGame(2);
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitor'] = $srvAd->getAllMonitor();
        $this->out['__on_menu__'] = 'platform';
        $this->out['__on_sub_menu__'] = 'acceptTest';
        $this->out['__title__'] = '测试验收';
        $this->tpl = 'platform/accept_test.tpl';

    }

    /**
     * IOS技术支持管理
     */
    public function iosSupport()
    {
        SrvAuth::checkOpen('platform', 'gameList');

        $game_id = (int)$this->R('game_id', 'int', 0);
        if ($_POST) {
            $this->outType = 'json';

            $name = trim($this->R('name'));
            $contacts = trim($this->R('contacts'));
            $copyright = trim($this->R('copyright'));
            $agreement = trim($this->R('agreement'));
            $introduction = trim($this->R('introduction'));

            $this->out = $this->srv->setSupport($game_id, $name, $contacts, $copyright, $agreement, $introduction);
        } else {
            $this->outType = 'smarty';

            $data = $this->srv->getSupport($game_id);
            $data['name'] || $data['name'] = $data['game_name'];

            $this->out['game_id'] = $game_id;
            $this->out['data'] = $data;
            $this->out['__domain__'] = ROOT_DOMAIN;
            $this->out['_static_url_'] = str_ireplace('https://', 'http://', CDN_STATIC_URL);
            $this->out['__on_menu__'] = 'platform';
            $this->out['__on_sub_menu__'] = 'iosSupport';
            $this->out['__title__'] = 'IOS技术支持管理';
            $this->tpl = 'platform/iosSupport.tpl';
        }
    }
}