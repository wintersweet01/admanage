<?php

class CtlAdDataIOS extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvAdDataIOS();
    }

    public function packageEffect()
    {
        SrvAuth::checkOpen('adDataIOS', 'packageEffect');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $page = $this->R('page', 'int', 0);
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->packageEffect($page, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate);

        $this->out['data']['game_id'] = $game_id;
        $this->out['data']['channel_id'] = $channel_id;

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);
        $this->out['_channels'] = $allChannel;

        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'packageEffect';
        $this->out['__title__'] = '分包标识效果表(苹果)';
        $this->tpl = 'adDataIOS/packageEffect.tpl';
    }

    public function packageEffectExcel()
    {
        SrvAuth::checkOpen('adDataIOS', 'packageEffect');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->packageEffect('', $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function userCycle()
    {
        SrvAuth::checkOpen('adDataIOS', 'userCycle');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id','int',0);
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();

        $data = $this->srv->userCycle($parent_id,$game_id, $user_id, $sdate, $edate,0);
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
        $this->out['_user_list'] = $this->srv->getUserList();
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'userCycle';
        $this->out['__title__'] = '分账号回收';
        $this->tpl = 'adDataIOS/userCycle.tpl';
    }

    public function userCycleExcel()
    {
        $parent_id = $this->R('parent_id','int',0);
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');

        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->userCycle($parent_id,$game_id, $user_id, $sdate, $edate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function dayUserEffect()
    {
        SrvAuth::checkOpen('adDataIOS', 'dayUserEffect');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->dayUserEffect($parent_id, $game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 0);
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
        $this->out['_user_list'] = $this->srv->getUserList();
        $this->out['_monitors'] = $srvAd->getAllMonitor();
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'dayUserEffect';
        $this->out['__title__'] = '分日分账号效果表';
        $this->tpl = 'adDataIOS/dayUserEffect.tpl';
    }

    public function dayUserEffectExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $this->out['data'] = $this->srv->dayUserEffect($parent_id, $game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function userEffect()
    {
        SrvAuth::checkOpen('adDataIOS', 'userEffect');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');

        $srvPlatform = new SrvPlatform();

        $data = $this->srv->userEffect($parent_id, $game_id, $user_id, $rsdate, $redate, $psdate, $pedate, 0);
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
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'userEffect';
        $this->out['__title__'] = '分账号效果表';
        $this->tpl = 'adDataIOS/userEffect.tpl';
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
        SrvAuth::checkOpen('adDataIOS', 'channelCycleT');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $page = $this->R('page', 'int', 0);
        $this->out['data'] = $this->srv->channelCycleT($page, $game_id, $channel_id, $sdate, $edate);
        $this->out['data']['game_id'] = $game_id;
        $this->out['data']['channel_id'] = $channel_id;
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);
        $this->out['_channels'] = $allChannel;
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'channelCycleT';
        $this->out['__title__'] = '分渠道回收周期';
        $this->tpl = 'adDataIOS/channelCycleT.tpl';
    }

    public function channelCycle()
    {
        SrvAuth::checkOpen('adDataIOS', 'channelCycle');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');

        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->channelCycle($game_id, $channel_id, $sdate, $edate);
        $this->out['data']['game_id'] = $game_id;
        $this->out['data']['channel_id'] = $channel_id;
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);
        $this->out['_channels'] = $allChannel;
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'channelCycle';
        $this->out['__title__'] = '分渠道回收';
        $this->tpl = 'adDataIOS/channelCycle.tpl';
    }

    public function channelCycleExcel()
    {
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->channelCycle($game_id, $channel_id, $sdate, $edate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function channelEffect()
    {
        SrvAuth::checkOpen('adDataIOS', 'channelEffect');

        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $page = $this->R('page', 'int', 0);
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->channelEffect($page, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate);

        $this->out['data']['game_id'] = $game_id;
        $this->out['data']['channel_id'] = $channel_id;

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);
        $this->out['_channels'] = $allChannel;


        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'channelEffect';
        $this->out['__title__'] = '分渠道效果表';
        $this->tpl = 'adDataIOS/channelEffect.tpl';
    }

    public function channelEffectExcel()
    {
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->channelEffect('', $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function activityEffect()
    {
        SrvAuth::checkOpen('adDataIOS', 'activityEffect');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        //$page = $this->R('page','int',0);
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);

        $data = $this->srv->activityEffect($parent_id, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate);
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['channel_id'] = $channel_id;

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
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'activityEffect';
        $this->out['__title__'] = '分推广活动效果表';
        $this->tpl = 'adDataIOS/activityEffect.tpl';
    }

    public function activityEffectExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $rsdate = $this->R('rsdate');
        $redate = $this->R('redate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->activityEffect($parent_id, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function dayChannelEffect()
    {
        SrvAuth::checkOpen('adDataIOS', 'dayChannelEffect');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);
        $this->out['data'] = $this->srv->dayChannelEffect($channel_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 0);

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();

        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitors'] = $srvAd->getAllMonitor();
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'dayChannelEffect';
        $this->out['__title__'] = '分日分渠道效果表';
        $this->tpl = 'adDataIOS/dayChannelEffect.tpl';
    }

    public function dayChannelEffectExcel()
    {
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $pay_sdate = $this->R('psdate');
        $pay_edate = $this->R('pedate');
        $monitor_id = $this->R('monitor_id', 'int', 0);

        $this->out['data'] = $this->srv->dayChannelEffect($channel_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function hourLand()
    {
        SrvAuth::checkOpen('adDataIOS', 'hourLand');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id');
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $monitor_id = $this->R('monitor_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);

        $data = $this->srv->hourLand($page, $monitor_id, $parent_id, $game_id, $channel_id, $sdate, $edate, $all, 0);
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['channel_id'] = $channel_id;
        $data['monitor_id'] = $monitor_id;

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
        $this->out['__on_menu__'] = 'adDataIOS';
        $this->out['__on_sub_menu__'] = 'hourLand';
        $this->out['__title__'] = '分时段落地页转化表';
        $this->tpl = 'adDataIOS/hourLand.tpl';
    }

    public function hourLandExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $channel_id = $this->R('channel_id');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->hourLand('', $package_name, $parent_id, $game_id, $channel_id, $sdate, $edate, '', 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }


}