<?php

class CtlData1 extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvData();
    }

    public function overviewDay()
    {
        SrvAuth::checkOpen('data1', 'overviewDay');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $package_name = $this->R('package_name');
        $channel_id = $this->R('channel_id', 'int', 0);
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $sort_by = $this->R('sort_by');
        $sort_type = $this->R('sort_type');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdData = new SrvAdData();

        $data = $this->srv->overviewDay($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all, $sort_by, $sort_type, $user_id);
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
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitors'] = $srvAd->getAllMonitor();
        $this->out['_user_list'] = $srvAdData->getUserList();
        $this->out['__on_menu__'] = 'data1';
        $this->out['__on_sub_menu__'] = 'overviewDay';
        $this->out['__title__'] = '渠道数据日表';
        $this->tpl = 'data/overviewDay.tpl';
    }

    public function overviewHour()
    {
        exit();
        SrvAuth::checkOpen('data1', 'overviewDay');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $all = $this->R('all', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $this->out['data'] = $this->srv->overviewHour($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all);

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();

        $srvAd = new SrvAd();
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitors'] = $srvAd->getAllMonitor();

        $this->out['__on_menu__'] = 'data1';
        $this->out['__on_sub_menu__'] = 'overviewHour';
        $this->out['__title__'] = '渠道数据时表';
        $this->tpl = 'data/overviewHour.tpl';
    }

    /**
     * 每小时新增注册
     */
    public function regHour()
    {
        SrvAuth::checkOpen('data1', 'regHour');

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $data = $this->R('data');
            parse_str($data, $param);

            $this->out = $this->srv->regHour($param);
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $srvPlatform->getAllGame(true), //游戏数据树
                    'default_value' => 0, //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'disabled' => false, //是否不可选
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'game_id',
                    'children_default_value' => 0, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                    'attr' => '' //标签属性参数
                ),
            );

            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data1';
            $this->out['__on_sub_menu__'] = 'regHour';
            $this->out['__title__'] = '按渠道每小时新增注册';
            $this->tpl = 'data/regHour.tpl';
        }
    }

    public function regHourExcel()
    {
        SrvAuth::checkOpen('data1', 'regHour');

        $platform = $this->R('platform', 'tinyint', 0);
        $channel_id = $this->R('channel_id');

        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->regHour($page, $channel_id, $platform, $sdate, $edate, $all, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    /**
     * 渠道数据时表
     * 2018-07-04
     */
    public function channelHour()
    {
        SrvAuth::checkOpen('data1', 'channelHour');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $package_name = $this->R('package_name');
        $create_user = $this->R('create_user');
        $date = $this->R('date');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdmin = new SrvAdmin();

        if (!$date) {
            $date = date('Y-m-d');
        }
        if (!$create_user) {
            $create_user = $_SESSION['username'];
        }
        if ($create_user == 'all') {
            $create_user = '';
        }

        $data = $this->srv->channelHour($date, $parent_id, $game_id, $channel_id, $package_name, $user_id, $create_user);
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
        $this->out['__on_menu__'] = 'data1';
        $this->out['__on_sub_menu__'] = 'channelHour';
        $this->out['__title__'] = '渠道数据时表(新)';
        $this->tpl = 'data/channelHour.tpl';
    }

    /**
     * 渠道数据日表
     * 2018-07-06
     */
    public function channelDay()
    {
        SrvAuth::checkOpen('data1', 'channelDay');

        $this->outType = 'smarty';

        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $package_name = $this->R('package_name');
        $create_user = $this->R('create_user');
        $date = $this->R('date');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdmin = new SrvAdmin();

        if (!$date) {
            $date = date('Y-m-d');
        }
        if (!$create_user) {
            $create_user = $_SESSION['username'];
        }
        if ($create_user == 'all') {
            $create_user = '';
        }

        $data = $this->srv->channelDay($date, $parent_id, $game_id, $channel_id, $package_name, $user_id, $create_user);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id', //自定义ID
                'type' => 'game',
                'data' => $games,
                'default_value' => $parent_id,
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => $game_id,
                'children_default_text' => '选择子游戏'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['__on_menu__'] = 'data1';
        $this->out['__on_sub_menu__'] = 'channelDay';
        $this->out['__title__'] = '渠道数据日表(新)';
        $this->tpl = 'data/channelDay.tpl';
    }

    /**
     * 投放LTV表
     */
    public function ltvNew()
    {
        SrvAuth::checkOpen('data1', 'ltvNew');

        $data = $this->post('data');
        parse_str($data, $param);
        $data = $this->srv->ltvNew($param);

        if ($_POST) {
            $this->outType = 'json';
            $this->out = $data;
        } else {
            $this->outType = 'smarty';

            $widgets = array(
                'game' => array(
                    'label' => '母游戏',
                    'id' => 'parent_id[]', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $data['games'], //游戏数据树
                    'default_value' => $data['parent_id'], //默认值
                    //'default_text' => '选择父游戏', //默认显示内容
                    'multiple' => true, //是否多选
                    'disabled' => false, //是否不可选
                    'parent' => true, //是否开启只可选择父游戏
                    'attr' => 'style="width: 50px;"', //标签属性参数
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'children_id[]', //子游戏ID
                    'children_label' => '子游戏', //子游戏标签
                    'children_default_value' => $data['children_id'], //子游戏默认值
                    //'children_default_text' => '选择子游戏', //子游戏默认显示内容
                    'children_inherit' => false, //过滤继承的游戏
                    'children_multiple' => true, //是否多选
                    'children_attr' => 'style="width: 120px;"', //标签属性参数
                )
            );

            $this->out['widgets'] = $widgets;
            $this->out['data'] = $data;
            $this->out['day'] = json_encode($data['day']);
            $this->out['__on_menu__'] = 'data1';
            $this->out['__on_sub_menu__'] = 'ltvNew';
            $this->out['__title__'] = 'LTV';
            $this->tpl = 'data/ltvNew.tpl';
        }
    }

    public function getUserByChannel()
    {
        SrvAuth::checkOpen('data1', 'ltvNew');
        $this->outType = 'json';
        $channel_id = $this->R('channel_id');

        $SrvExtend = new SrvExtend();
        $this->out = $SrvExtend->getUserByChannel($channel_id);
    }
}