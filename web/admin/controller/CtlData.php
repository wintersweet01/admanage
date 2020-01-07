<?php

class CtlData extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvData();
    }

    public function newViewData()
    {
        SrvAuth::checkOpen('data', 'newViewData');

        $this->outType = 'smarty';

        //$page = $this->R('page','int',0);
        $all = $this->R('all', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', '0');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();
        $data = $this->srv->newViewData($game_id, $device_type, $sdate, $edate, $all);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '选择游戏',
                'disabled' => false,
                'parent' => false,
                'attr' => 'style="width: 150px;"'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__param__'] = $this->out['data']['param'];
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'newViewData';
        $this->out['__title__'] = '新增数据查看';
        $this->tpl = 'data/newViewData.tpl';
    }

    public function serverCondition()
    {
        SrvAuth::checkOpen('data', 'serverCondition');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $server_id = $this->R('server_id', 'int', 0);
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();

        $data = $this->srv->serverCondition($page, $parent_id, $game_id, $server_id, $sdate, $edate, $all);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width:150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        if ($game_id) {
            $this->out['_game_server'] = $this->srv->getGameServer($game_id);
        }

        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'serverCondition';
        $this->out['__title__'] = '分服状况';
        $this->tpl = 'data/serverCondition.tpl';
    }

    public function serverConditionExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $server_id = $this->R('server_id', 'int', 0);

        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $this->out['data'] = $this->srv->serverCondition($page, $parent_id, $game_id, $server_id, $sdate, $edate, $all, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function newViewDataExcel()
    {
        $all = $this->R('all', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', '0');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $is_reg = $this->R('reg', 'int', 1);
        $is_equipment = $this->R('new_equipment', 'int', 1);
        $is_newplayer = $this->R('new_players', 'int', 1);
        $is_activelogin = $this->R('active_login', 'int', 1);
        $is_newactive = $this->R('new_active_login', 'int', 1);
        $is_payernum = $this->R('payer_num', 'int', 1);
        $is_newpayernum = $this->R('new_payer_num', 'int', 1);
        $is_tdepostimon = $this->R('total_deposit_money', 'int', 1);
        $is_ndepositmon = $this->R('new_deposit_money', 'int', 1);
        $is_payrate = $this->R('payrate', 'int', 1);
        $is_payARPU = $this->R('payARPU', 'int', 1);
        $is_actARPU = $this->R('actARPU', 'int', 1);
        $is_newpayARPU = $this->R('newpayARPU', 'int', 1);
        $is_newpayrate = $this->R('newpayrate', 'int', 1);
        $this->out['data'] = $this->srv->newViewData($game_id, $device_type, $sdate, $edate, $all, 1, $is_reg, $is_equipment, $is_newplayer, $is_activelogin, $is_newactive, $is_payernum, $is_newpayernum, $is_tdepostimon, $is_ndepositmon, $is_payrate, $is_payARPU, $is_actARPU, $is_newpayARPU, $is_newpayrate);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function overview()
    {
        SrvAuth::checkOpen('data', 'overview');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        //$device_type = $this->R('device_type', 'int', 0);//1:IOS,2:Android
        $device_type = 0;
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $data = $this->srv->getOverview($parent_id, $device_type, $sdate, $edate);
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => $parent_id, //默认值
                'default_text' => '全部', //默认显示内容
                'parent' => true, //是否开启只可选择父游戏
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'overview';
        $this->out['__title__'] = '游戏总览';
        $this->tpl = 'data/overview.tpl';
    }

    public function overviewMonth()
    {
        SrvAuth::checkOpen('data', 'overviewMonth');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $device_type = $this->R('device_type', 'int', '0');//1:IOS,2:Android
        $month = $this->R('month');
        $plus_ = $this->R('plus_', 'int', 0);
        if (!$month) {
            $plus_ = 1;
        }

        $srvPlatform = new SrvPlatform();

        $data = $this->srv->getOverviewMonth($page, $parent_id, $game_id, $device_type, $month, $all, 0, $plus_);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width:150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'overviewMonth';
        $this->out['__title__'] = '分月数据效果表';
        $this->tpl = 'data/overviewMonth.tpl';
    }

    public function overviewExcel()
    {
        $game_id = $this->R('parent_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);//1:IOS,2:Android
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $this->out['data'] = $this->srv->getOverview($game_id, $device_type, $sdate, $edate, 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function overviewMonthExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $device_type = $this->R('device_type', 'int', '0');//1:IOS,2:Android
        $month = $this->R('month');
        $plus_ = $this->R('plus_', 'int', 0);
        $this->out['data'] = $this->srv->getOverviewMonth('', $parent_id, $game_id, $device_type, $month, $all, 1, $plus_);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function ltv()
    {
        SrvAuth::checkOpen('data', 'ltv');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $all = $this->R('all', 'int', 0);
        $only_view = $this->R('only_view');

        $srvPlatform = new SrvPlatform();

        $data = $this->srv->ltv($parent_id, $game_id, $device_type, $sdate, $edate, $all);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => $parent_id,
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true, //是否开启子游戏选择
                'children_id' => 'game_id', //是否开启子游戏选择
                'children_default_value' => $game_id, //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'attr' => 'style="width: 150px;"'
            ),
        );
        $this->out['only_view'] = $only_view;
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'ltv';
        $this->out['__title__'] = 'LTV';
        $this->tpl = 'data/ltv.tpl';
    }

    public function retain()
    {
        SrvAuth::checkOpen('data', 'retain');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        //$package_name = $this->R('package_name');
        //$channel_id = $this->R('channel_id','int',0);
        //$monitor_id = $this->R('monitor_id','int',0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $all = $this->R('all', 'int', 0);

        $this->out['data'] = $this->srv->retain($page, $game_id, $device_type, $sdate, $edate, $all);

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();

        $srvAd = new SrvAd();
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitors'] = $srvAd->getAllMonitor();

        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'retain';
        $this->out['__title__'] = '留存数据';
        $this->tpl = 'data/retain.tpl';
    }

    public function retainExcel()
    {
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $all = $this->R('all', 'int', 0);

        $this->out['data'] = $this->srv->retain('', $game_id, $device_type, $sdate, $edate, $all, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    /**
     * 充值排行榜
     */
    public function payHall()
    {
        SrvAuth::checkOpen('data', 'payHall');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id');
        $game_id = $this->R('children_id');

        !$parent_id && $parent_id = array();
        !$game_id && $game_id = array();

        $param = array(
            'parent_id' => $parent_id,
            'game_id' => $game_id,
            'server_id' => $this->R('server_id', 'int', 0),
            'device_type' => $this->R('device_type', 'int', 0),
            's_charge' => $this->R('s_charge', 'int', 0),
            'e_charge' => $this->R('e_charge', 'int', 0),
            'psdate' => $this->R('pay_date_start', 'string', ''),
            'pedate' => $this->R('pay_date_end', 'string', ''),
            'rsdate' => $this->R('reg_date_start', 'string', ''),
            'redate' => $this->R('red_date_end', 'string', '')
        );

        $srvPlatform = new SrvPlatform();
        $data = $this->srv->payHall($page, $param);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '母游戏',
                'id' => 'parent_id[]', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => $data['parent_id'], //默认值
                //'default_text' => '选择父游戏', //默认显示内容
                'multiple' => true, //是否多选
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'attr' => 'style="width: 50px;"', //标签属性参数
                'children' => true, //是否开启子游戏选择
                'children_id' => 'children_id[]', //子游戏ID
                'children_label' => '子游戏', //子游戏标签
                'children_default_value' => $data['game_id'], //子游戏默认值
                //'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
                'children_multiple' => true, //是否多选
                'children_attr' => 'style="width: 120px;"', //标签属性参数
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'payHall';
        $this->out['__title__'] = '充值排行榜';
        $this->tpl = 'data/payHall.tpl';
    }

    /**
     * 充值排行榜导出
     */
    public function payHallDownload()
    {
        SrvAuth::checkOpen('data', 'payHall');

        $this->outType = 'json';
        $parent_id = $this->R('parent_id');
        $game_id = $this->R('children_id');
        !$parent_id && $parent_id = array();
        !$game_id && $game_id = array();
        $param = array(
            'parent_id' => $parent_id,
            'game_id' => $game_id,
            'server_id' => $this->R('server_id', 'int', 0),
            'device_type' => $this->R('device_type', 'int', 0),
            's_charge' => $this->R('s_charge', 'int', 0),
            'e_charge' => $this->R('e_charge', 'int', 0),
            'psdate' => $this->R('pay_date_start', 'string', ''),
            'pedate' => $this->R('pay_date_end', 'string', ''),
            'rsdate' => $this->R('reg_date_start', 'string', ''),
            'redate' => $this->R('red_date_end', 'string', '')
        );
        $this->out = $this->srv->payHallDownload($param);
    }

    /**
     * 角色充值排行导出
     */
    public function payHallRoleDownload()
    {
        SrvAuth::checkOpen('data', 'payHallRole');
        $this->outType = 'json';
        $parent_id = $this->R('parent_id');
        $game_id = $this->R('children_id');
        $server_id = $this->R('server_id', 'int', 0);
        $pay_date_start = $this->R('pay_date_start', 'string', date('Y-m-d'));
        $pay_date_end = $this->R('pay_date_end', 'string', date('Y-m-d'));
        $pay_date = $this->R('pay_date', 'string', date('Y-m-d'));
        $platform = $this->R('device_type');
        $reg_date_start = $this->R('reg_date_start', 'string', date('Y-m-d', strtotime('-1 month')));
        $reg_date_end = $this->R('reg_date_end', 'string', date('Y-m-d'));
        $role_name = $this->R('role_name');
        $s_charge = $this->R('s_charge', 'int', 0);
        $e_charge = $this->R('e_charge', 'int', 0);

        if (!$pay_date) {
            $pay_date = date('Y-m-d', time());
        }
        $data = array(
            'parent_id' => $parent_id,
            'game_id' => $game_id,
            'server_id' => $server_id,
            'pay_st' => strtotime($pay_date_start . " 00:00:00"),
            'pay_et' => strtotime($pay_date_end . " 23:59:59"),
            'pay_date' => $pay_date,
            'pay_date_start' => $pay_date_start,
            'pay_date_end' => $pay_date_end,
            'device_type' => $platform,
            's_charge' => $s_charge,
            'e_charge' => $e_charge,
            'role_name' => $role_name,
            'reg_date_start' => $reg_date_start,
            'reg_date_end' => $reg_date_end,
        );
        $this->out = $this->srv->payHallRoleDownload($data);
    }

    /**
     * 更新用户总充值
     */
    public function updateUserPayTotal()
    {
        SrvAuth::checkOpen('data', 'payHall');
        $this->outType = 'json';
        $this->out = $this->srv->updateUserPayTotal();
    }

    public function getGameServer()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $this->out = $this->srv->getGameServer($game_id);
    }

    ///多选游戏 组合服务器
    public function getGameServerBatch()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $game_id = json_decode($game_id, true);
        $this->out = $this->srv->getGameServerBatch($game_id);
    }

    public function getMoneyLevel()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id');
        $this->out = $this->srv->getMoneyLevel($game_id);
    }

    /**
     * 充值角色排行榜
     */
    public function payHallRole()
    {
        SrvAuth::checkOpen('data', 'payHallRole');

        $this->outType = 'smarty';
        $data = array(
            'server_id' => $this->get('server_id', 'int', 0),
            'role_name' => $this->get('role_name')
        );

        $page = $this->get('page', 'int', 1);
        $parent_id = $this->get('parent_id');
        $game_id = $this->get('children_id');
        $pay_date = $this->get('pay_date', 'string', date('Y-m-d'));
        $pay_date_start = $this->get('pay_date_start', 'string', date('Y-m-d', strtotime('-1 month')));
        $pay_date_end = $this->get('pay_date_end', 'string', date('Y-m-d'));
        $device_type = $this->get('device_type', 'int', 0);
        $reg_date_start = $this->get('reg_date_start', 'string', date('Y-m-d', strtotime('-1 month')));
        $reg_date_end = $this->get('reg_date_end', 'string', date('Y-m-d'));
        $s_charge = $this->get('s_charge');
        $e_charge = $this->get('e_charge');

        /*if ($game_id <= 0) {
            $game_id = 2;
        }*/
        if (!$pay_date) {
            $pay_date = date('Y-m-d');
        }
        $data['pay_st'] = strtotime($pay_date_start . " 00:00:00");
        $data['pay_et'] = strtotime($pay_date_end . " 23:59:59");
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['pay_date'] = $pay_date;
        $data['pay_date_start'] = $pay_date_start;
        $data['pay_date_end'] = $pay_date_end;
        $data['device_type'] = $device_type;
        $data['servers'] = $this->srv->getGameServerBatch($game_id);
        $data['s_charge'] = isset($s_charge) ? (float)$s_charge : 0;
        $data['e_charge'] = isset($e_charge) ? (float)$e_charge : 0;
        $data['reg_date_start'] = $reg_date_start;
        $data['reg_date_end'] = $reg_date_end;
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $row = $this->srv->payHallRole($data, $page);
        $widgets = array(
            'game' => array(
                'label' => '母游戏',
                'id' => 'parent_id[]', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => $row['parent_id'], //默认值
                //'default_text' => '选择父游戏', //默认显示内容
                'multiple' => true, //是否多选
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'attr' => 'style="width: 50px;"', //标签属性参数
                'children' => true, //是否开启子游戏选择
                'children_id' => 'children_id[]', //子游戏ID
                'children_label' => '子游戏', //子游戏标签
                'children_default_value' => $row['game_id'], //子游戏默认值
                //'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
                'children_multiple' => true, //是否多选
                'children_attr' => 'style="width: 120px;"', //标签属性参数
            )
        );

        $this->out['query'] = $data;
        $this->out['_servers'] = (new SrvPlatform())->getAllServer();
        $this->out['data'] = $row;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'payHallRole';
        $this->out['__title__'] = '充值角色排行榜';
        $this->tpl = 'data/payHallRole.tpl';
    }

    /**
     * 按日投放效果报表
     * 2018-5-4
     */
    public function putinByDay()
    {
        SrvAuth::checkOpen('data', 'putinByDay');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $username = $this->R('username');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');

        $data = $this->srv->getPutinByDay($page, $parent_id, $game_id, $channel_id, $sdate, $edate, $psdate, $pedate, $username);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdmin = new SrvAdmin();

        $games = $srvPlatform->getAllGame(true);

        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width:150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'putinByDay';
        $this->out['__title__'] = '按日投放效果报表';
        $this->tpl = 'data/putinByDay.tpl';
    }

    /**
     * 游戏实时在线
     */
    public function online()
    {
        SrvAuth::checkOpen('data', 'online');

        $josn = $this->R('json', 'int', 0);
        if ($josn) {
            $this->outType = 'json';

            $this->out = $this->srv->online();
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $srvAd = new SrvAd();
            $this->out['_games'] = json_encode($srvPlatform->getAllGame());
            $this->out['_channel'] = json_encode($srvAd->getAllChannel());

            $this->out['__on_menu__'] = 'data';
            $this->out['__on_sub_menu__'] = 'online';
            $this->out['__title__'] = '游戏实时在线';
            $this->tpl = 'data/online.tpl';
        }
    }

    /**
     * 数据日报
     */
    public function dataDay()
    {
        SrvAuth::checkOpen('data', 'dataDay');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $create_user = $this->R('create_user');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdmin = new SrvAdmin();

        $data = $this->srv->dataDay($sdate, $edate, $parent_id, $game_id, $channel_id, $user_id, $create_user);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => $game_id,
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width:150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['__on_menu__'] = 'data';
        $this->out['__on_sub_menu__'] = 'dataDay';
        $this->out['__title__'] = '数据日报';
        $this->tpl = 'data/dataDay.tpl';
    }

    public function getUserByChannel()
    {
        SrvAuth::checkOpen('extend', 'dataDay');
        $this->outType = 'json';
        $channel_id = $this->R('channel_id');
        $this->out = $this->srv->getUserByChannel($channel_id);
    }

    public function roi()
    {
        SrvAuth::checkOpen('data', 'roi');

        $day = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 45, 60, 90, 120, 150, 180);
        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->roi($param, $day);
            $this->out = array(
                'code' => 0,
                'count' => count($row['list']),
                'data' => $row['list'],
                'totalData' => $row['total'],
                'msg' => '',
                'query' => $row['query']
            );
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $games, //游戏数据树
                    'default_value' => 0, //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'game_id',
                    'children_default_value' => 0, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                ),
            );

            $this->out['day'] = json_encode($day);
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data';
            $this->out['__on_sub_menu__'] = 'roi';
            $this->out['__title__'] = 'ROI';
            $this->tpl = 'data/roi.tpl';
        }
    }
}