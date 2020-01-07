<?php

class CtlData2 extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvData();
    }

    public function channelHourPay()
    {
        SrvAuth::checkOpen('data2', 'channelHourPay');
        $this->outType = 'smarty';
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $channel_id = $this->R('channel_id');
        $parent_id = $this->R('parent_id');
        $game_id = $this->R('game_id');
        $device_type = $this->R('device_type');
        $user_type = $this->R('user_type');

        $data = $this->srv->channelHourPay($parent_id, $game_id, $channel_id, $device_type, $user_type, $sdate, $edate);
        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

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
        $this->out['__on_menu__'] = 'data2';
        $this->out['__on_sub_menu__'] = 'channelHourPay';
        $this->out['__title__'] = '每小时新增付费';
        $this->tpl = 'data/channelHourPay.tpl';
    }

    public function payArea()
    {
        SrvAuth::checkOpen('data2', 'payArea');
        $this->outType = 'smarty';
        $sdate = $this->R('sdate');
        $sort = $this->R('sort');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id');

        $data = $this->srv->payArea($sdate, $sort, $game_id, $parent_id);
        $srvPlatform = new SrvPlatform();
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
        $this->out['__on_menu__'] = 'data2';
        $this->out['__on_sub_menu__'] = 'payArea';
        $this->out['__title__'] = '地区付费数据统计';
        $this->tpl = 'data/payArea.tpl';
    }

    public function payHabitDate()
    {
        SrvAuth::checkOpen('data2', 'payHabitDate');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $level_money = $this->R('level_money', 'int', 0);
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $device_type = $this->R('device_type');

        $srvPlatform = new SrvPlatform();
        $data = $this->srv->payHabitDate($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all);
        $data['game_id'] = $game_id;
        $data['level_money'] = $level_money;

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
        if ($game_id) {
            $this->out['_level'] = $this->srv->getMoneyLevel($game_id);
        }

        $this->out['__on_menu__'] = 'data2';
        $this->out['__on_sub_menu__'] = 'payHabitDate';
        $this->out['__title__'] = '日期付费数据统计';
        $this->tpl = 'data/payHabitDate.tpl';
    }

    public function payHabitChannel()
    {
        SrvAuth::checkOpen('data2', 'payHabitChannel');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $level_money = $this->R('level_money', 'int', 0);

        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $device_type = $this->R('device_type');

        $data = $this->srv->payHabitChannel($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all);
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['level_money'] = $level_money;

        $srvPlatform = new SrvPlatform();
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
        if ($game_id) {
            $this->out['_level'] = $this->srv->getMoneyLevel($game_id);
        }

        $this->out['__on_menu__'] = 'data2';
        $this->out['__on_sub_menu__'] = 'payHabitChannel';
        $this->out['__title__'] = '渠道付费数据统计';
        $this->tpl = 'data/payHabitChannel.tpl';
    }

    public function payHabitServer()
    {
        SrvAuth::checkOpen('data2', 'payHabitServer');

        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $level_money = $this->R('level_money', 'int', 0);
        $device_type = $this->R('device_type');
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $data = $this->srv->payHabitServer($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all);
        $data['game_id'] = $game_id;
        $data['level_money'] = $level_money;

        $srvPlatform = new SrvPlatform();
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
                'attr' => 'style="width: 150px"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        if ($game_id) {
            $this->out['_level'] = $this->srv->getMoneyLevel($game_id);
        }

        $this->out['__on_menu__'] = 'data2';
        $this->out['__on_sub_menu__'] = 'payHabitServer';
        $this->out['__title__'] = '区服付费数据统计';
        $this->tpl = 'data/payHabitServer.tpl';
    }

    public function payHabitDateExcel()
    {

        SrvAuth::checkOpen('data2', 'payHabitDate');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $level_money = $this->R('level_money', 'int', 0);
        $device_type = $this->R('device_type');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->payHabitDate($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function payHabitChannelExcel()
    {

        SrvAuth::checkOpen('data2', 'payHabitChannel');

        $device_type = $this->R('device_type');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $level_money = $this->R('level_money', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);

        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->payHabitChannel($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function payHabitServerExcel()
    {
        SrvAuth::checkOpen('data2', 'payHabitServer');
        $device_type = $this->R('device_type');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $page = $this->R('page', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $level_money = $this->R('level_money', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $this->out['data'] = $this->srv->payHabitServer($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

}