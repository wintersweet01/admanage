<?php

class CtlAdData extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvAdData();
    }

    public function userCycle()
    {
        SrvAuth::checkOpen('adData', 'userCycle');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');

        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->userCycle($game_id, $user_id, $sdate, $edate);
        $this->out['data']['game_id'] = $game_id;
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $this->out['_user_list'] = $this->srv->getUserList();
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'userCycle';
        $this->out['__title__'] = '分账号回收';
        $this->tpl = 'adData/userCycle.tpl';
    }

    public function userCycleExcel()
    {

        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');

        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->userCycle($game_id, $user_id, $sdate, $edate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function dayUserEffect()
    {
        SrvAuth::checkOpen('adData', 'dayUserEffect');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $this->out['data'] = $this->srv->dayUserEffect($game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 0);
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();
        $this->out['_user_list'] = $this->srv->getUserList();
        $this->out['_monitors'] = $srvAd->getAllMonitor();
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'dayUserEffect';
        $this->out['__title__'] = '分日分账号效果表';
        $this->tpl = 'adData/dayUserEffect.tpl';
    }

    public function dayUserEffectExcel()
    {

        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $this->out['data'] = $this->srv->dayUserEffect($game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function userEffect()
    {
        SrvAuth::checkOpen('adData', 'userEffect');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');

        $srvPlatform = new SrvPlatform();

        $data = $this->srv->userEffect($parent_id, $game_id, $user_id, $rsdate, $redate, $psdate, $pedate);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_user_list'] = $this->srv->getUserList();
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'userEffect';
        $this->out['__title__'] = '分账号效果表';
        $this->tpl = 'adData/userEffect.tpl';
    }

    public function userEffectExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->userEffect($parent_id, $game_id, $user_id, $rsdate, $redate, $psdate, $pedate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function channelCycleT()
    {
        SrvAuth::checkOpen('adData', 'channelCycleT');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $page = $this->R('page', 'int', 0);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);

        $data = $this->srv->channelCycleT($page, $parent_id, $game_id, $channel_id, $sdate, $edate);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $allChannel;
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'channelCycleT';
        $this->out['__title__'] = '分渠道回收周期';
        $this->tpl = 'adData/channelCycleT.tpl';
    }

    public function channelCycle()
    {
        SrvAuth::checkOpen('adData', 'channelCycle');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);

        $data = $this->srv->channelCycle($parent_id, $game_id, $channel_id, $sdate, $edate);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $allChannel;
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'channelCycle';
        $this->out['__title__'] = '分渠道回收';
        $this->tpl = 'adData/channelCycle.tpl';
    }

    public function channelCycleExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->channelCycle($parent_id, $game_id, $channel_id, $sdate, $edate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function channelEffect()
    {
        SrvAuth::checkOpen('adData', 'channelEffect');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $device_type = $this->R('device_type');
        $page = $this->R('page', 'int', 0);
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->channelEffect($device_type, $page, $parent_id, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate);
        $data['game_id'] = $game_id;
        $data['channel_id'] = $channel_id;

        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);

        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $allChannel;
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'channelEffect';
        $this->out['__title__'] = '分渠道效果表';
        $this->tpl = 'adData/channelEffect.tpl';
    }

    public function channelEffectExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $rsdate = $this->R('rsdate');
        $device_type = $this->R('device_type');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->channelEffect($device_type, '', $parent_id, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function activityEffect()
    {
        SrvAuth::checkOpen('adData', 'activityEffect');

        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        //$page = $this->R('page','int',0);
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->activityEffect($game_id, $channel_id, $rsdate, $redate, $psdate, $pedate);

        $this->out['data']['game_id'] = $game_id;
        $this->out['data']['channel_id'] = $channel_id;

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);
        $this->out['_channels'] = $allChannel;


        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'activityEffect';
        $this->out['__title__'] = '分推广活动效果表';
        $this->tpl = 'adData/activityEffect.tpl';

    }

    public function activityEffectExcel()
    {
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->activityEffect($game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function dayChannelEffect()
    {
        SrvAuth::checkOpen('adData', 'dayChannelEffect');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->dayChannelEffect($channel_id, $parent_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 0);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitors'] = $srvAd->getAllMonitor();
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'dayChannelEffect';
        $this->out['__title__'] = '分日分渠道效果表';
        $this->tpl = 'adData/dayChannelEffect.tpl';
    }

    public function dayChannelEffectExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);

        $this->out['data'] = $this->srv->dayChannelEffect($channel_id, $parent_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function hourLand()
    {
        SrvAuth::checkOpen('adData', 'hourLand');

        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $package_name = $this->R('package_name');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->hourLand($page, $package_name, $game_id, $channel_id, $sdate, $edate, $all);
        $this->out['data']['game_id'] = $game_id;
        $this->out['data']['channel_id'] = $channel_id;
        $this->out['data']['package_name'] = $package_name;
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();

        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);
        $this->out['_channels'] = $allChannel;


        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'hourLand';
        $this->out['__title__'] = '分时段落地页转化表';
        $this->tpl = 'adData/hourLand.tpl';
    }

    public function hourLandExcel()
    {
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->hourLand('', $package_name, $game_id, $channel_id, $sdate, $edate, '', 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    /**
     * 推广数据总表
     * 2018-12-26
     */
    public function channelOverview_bak()
    {
        SrvAuth::checkOpen('adData', 'channelOverview');

        $this->outType = 'smarty';

        $parent_id = $this->R('parent_id');
        $children_id = $this->R('children_id');
        $device_type = $this->R('device_type', 'int', 0);
        $channel_id = $this->R('channel_id');
        $user_id = $this->R('user_id');
        $monitor_id = $this->R('monitor_id');
        $group_id = $this->R('group_id');
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $type = $this->R('type', 'int', 0);

        $data = $this->srv->channelOverview_bak($rsdate, $redate, $psdate, $pedate, $type, $parent_id, $children_id, $device_type, $channel_id, $user_id, $monitor_id, $group_id);
        $widgets = array(
            'game' => array(
                'label' => '母游戏',
                'id' => 'parent_id[]', //自定义ID
                'type' => 'game', //插件类型
                'data' => $data['games'], //游戏数据树
                'default_value' => empty($data) ? 0 : $data['parent_id'], //默认值
                //'default_text' => '选择父游戏', //默认显示内容
                'multiple' => true, //是否多选
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_id' => 'children_id[]', //子游戏ID
                'children_label' => '子游戏', //子游戏标签
                'children_default_value' => $children_id, //子游戏默认值
                //'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
                'children_multiple' => true, //是否多选
                'attr' => '', //标签属性参数
            ),
//            'channel' => array(
//                'label' => '渠道',
//                'type' => 'channel', //插件类型
//                'data' => $data['_channels'], //数据
//                'default_value' => '', //默认值
//                'default_text' => '选择渠道', //默认显示内容
//                'channel_user' => true, //是否开启渠道账号选项
//                'monitor' => true, //是否开启推广活动选项
//            ),
        );

        $this->out['widgets'] = $widgets;
        $this->out['data'] = $data;
        $this->out['day'] = $data['day'];
        $this->out['__on_menu__'] = 'adData';
        $this->out['__on_sub_menu__'] = 'channelOverview';
        $this->out['__title__'] = '推广数据总表';
        $this->tpl = 'adData/channelOverview_bak.tpl';
    }

    /**
     * 推广数据总表
     * 2018-12-26
     */
    public function channelOverview()
    {
        SrvAuth::checkOpen('adData', 'channelOverview');

        $data = $this->post('data');
        parse_str($data, $param);
        $data = $this->srv->channelOverview($param);

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
            $this->out['day_ltv'] = json_encode($data['day_ltv']);
            $this->out['__on_menu__'] = 'adData';
            $this->out['__on_sub_menu__'] = 'channelOverview';
            $this->out['__title__'] = '推广数据总表';
            $this->tpl = 'adData/channelOverview.tpl';
        }
    }

    public function getUserByChannel()
    {
        SrvAuth::checkOpen('adData', ['channelOverview', 'channelOverviewSp']);
        $this->outType = 'json';
        $channel_id = $this->R('channel_id');
        $this->out = $this->srv->getUserByChannel($channel_id);
    }

    /**
     * 查询注册用户信息
     */
    public function queryUser()
    {
        SrvAuth::checkOpen('adData', array('channelOverview', 'channelOverviewSp', 'hourOverview'));

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->queryUser($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => (int)$row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';
            $this->out['query'] = urlencode(http_build_query($_REQUEST));
            $this->out['__on_menu__'] = 'adData';
            $this->out['__on_sub_menu__'] = 'channelOverview';
            $this->out['__title__'] = '注册用户信息列表 - 推广数据总表';
            $this->tpl = 'adData/queryUser.tpl';
        }
    }

    /**
     * 查询充值用户信息
     */
    public function queryPay()
    {
        SrvAuth::checkOpen('adData', array('channelOverview', 'channelOverviewSp', 'hourOverview'));

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->queryPay($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => (int)$row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';
            $this->out['query'] = urlencode(http_build_query($_REQUEST));
            $this->out['__on_menu__'] = 'adData';
            $this->out['__on_sub_menu__'] = 'channelOverview';
            $this->out['__title__'] = '充值用户信息列表 - 推广数据总表';
            $this->tpl = 'adData/queryPay.tpl';
        }
    }

    /**
     * 查询活跃用户信息
     */
    public function queryActive()
    {
        SrvAuth::checkOpen('adData', array('channelOverview', 'channelOverviewSp', 'hourOverview'));

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->queryActive($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => (int)$row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';
            $this->out['query'] = urlencode(http_build_query($_REQUEST));
            $this->out['__on_menu__'] = 'adData';
            $this->out['__on_sub_menu__'] = 'channelOverview';
            $this->out['__title__'] = '活跃用户信息列表 - 推广数据总表';
            $this->tpl = 'adData/queryActive.tpl';
        }
    }

    /**
     * 累计付费列表
     */
    public function queryTotalPay()
    {
        SrvAuth::checkOpen('adData', array('channelOverview', 'channelOverviewSp', 'hourOverview'));

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $page = $this->R('page', 'int', 1);
            $limit = $this->R('limit', 'int', 15);
            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->queryTotalPay($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => (int)$row['total'],
                'data' => $row['list'],
                'msg' => ''
            );
        } else {
            $this->outType = 'smarty';
            $this->out['query'] = urlencode(http_build_query($_REQUEST));
            $this->out['__on_menu__'] = 'adData';
            $this->out['__on_sub_menu__'] = 'channelOverview';
            $this->out['__title__'] = '累计付费列表 - 推广数据总表';
            $this->tpl = 'adData/queryTotalPay.tpl';
        }
    }

    /**
     * 推广数据总表 分成版本
     * 2018-12-26
     */
    public function channelOverviewSp()
    {
        SrvAuth::checkOpen('adData', 'channelOverviewSp');

        $data = $this->post('data');
        parse_str($data, $param);
        $data = $this->srv->channelOverviewSp($param);

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
            $this->out['day_ltv'] = json_encode($data['day_ltv']);
            $this->out['__on_menu__'] = 'adData';
            $this->out['__on_sub_menu__'] = 'channelOverviewSp';
            $this->out['__title__'] = '分成推广数据总表';
            $this->tpl = 'adData/channelOverviewSp.tpl';
        }
    }

    //分时推广数据表
    public function hourOverview()
    {
        SrvAuth::checkOpen('adData', 'hourOverview');

        $data = $this->post('data');
        parse_str($data, $param);
        $data = $this->srv->hourOverview($param);
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
                    'multiple' => true, //是否多选
                    'disabled' => false, //是否不可选
                    'parent' => true, //是否开启只可选择父游戏
                    'attr' => 'style="width: 50px;"', //标签属性参数
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'children_id[]', //子游戏ID
                    'children_label' => '子游戏', //子游戏标签
                    'children_default_value' => $data['children_id'], //子游戏默认值
                    'children_inherit' => false, //过滤继承的游戏
                    'children_multiple' => true, //是否多选
                    'children_attr' => 'style="width: 120px;"', //标签属性参数
                )
            );

            $this->out['widgets'] = $widgets;
            $this->out['data'] = $data;
            $this->out['day'] = json_encode($data['day']);
            $this->out['day_ltv'] = json_encode($data['day_ltv']);
            $this->out['__on_menu__'] = 'adData';
            $this->out['__on_sub_menu__'] = 'hourOverview';
            $this->out['__title__'] = '分时推广数据总表';
            $this->tpl = 'adData/hourOverview.tpl';
        }
    }
}