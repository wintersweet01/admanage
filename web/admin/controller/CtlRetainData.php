<?php

class CtlRetainData extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvRetainData();
    }

    public function channelRetain()
    {
        SrvAuth::checkOpen('retainData', 'channelRetain');
        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $package_name = $this->R('package_name');
        $channel_id = $this->R('channel_id', 'int', 0);
        $device_type = $this->R('platform', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->channelRetain($page, $parent_id, $game_id, $device_type, $channel_id, $package_name, $all, $sdate, $edate);
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
        $this->out['__on_menu__'] = 'retainData';
        $this->out['__on_sub_menu__'] = 'channelRetain';
        $this->out['__title__'] = '渠道留存数据';
        $this->tpl = 'retain/channelRetain.tpl';
    }

    public function channelRetainExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $all = $this->R('all', 'int', 0);
        $package_name = $this->R('package_name');
        $channel_id = $this->R('channel_id', 'int', 0);
        $this->out['data'] = $this->srv->channelRetain('', $parent_id, $game_id, $device_type, $channel_id, $package_name, $all, $sdate, $edate, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }


    public function retainExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $group_child = $this->R('group_child', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $this->out['data'] = $this->srv->retain('', $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function retain()
    {
        SrvAuth::checkOpen('retainData', 'retain');
        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        //$package_name = $this->R('package_name');
        //$channel_id = $this->R('channel_id','int',0);
        //$monitor_id = $this->R('monitor_id','int',0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $group_child = $this->R('group_child', 'int', 0);
        $all = $this->R('all', 'int', 0);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->retain($page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => 'true',
                'children' => false,
            )
        );
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitors'] = $srvAd->getAllMonitor();
        $this->out['__on_menu__'] = 'retainData';
        $this->out['__on_sub_menu__'] = 'retain';
        $this->out['__title__'] = '账号留存数据';
        $this->tpl = 'retain/retain.tpl';
    }

    /**
     * 账号留存 新
     * 2019-07-11
     */
    public function retainNew()
    {
        SrvAuth::checkOpen('retainData', 'retainNew');
        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $group_child = $this->R('group_child', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $day = array(2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150, 180);
        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $data = $this->srv->retainNew($day, $page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => 'true',
                'children' => false,
            )
        );
        $this->out['data'] = $data;
        $this->out['day'] = $day;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_monitors'] = $srvAd->getAllMonitor();
        $this->out['__on_menu__'] = 'retainData';
        $this->out['__on_sub_menu__'] = 'retainNew';
        $this->out['__title__'] = '实时留存统计';
        $this->tpl = 'retain/retain_new.tpl';
    }

    public function retainNewExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('platform', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $group_child = $this->R('group_child', 'int', 0);
        $all = $this->R('all', 'int', 0);
        $day = array(2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150, 180);
        $this->out['data'] = $this->srv->retainNew($day,'', $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child, 1);

        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    /**
     * 付费留存
     * 2019-04-12
     */
    public function payRetain()
    {
        SrvAuth::checkOpen('retainData', 'payRetain');

        $day = array(2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150, 180);
        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $data = $this->R('data');
            parse_str($data, $param);

            $row = $this->srv->payRetain($param, $day);
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
            $this->out['__on_menu__'] = 'retainData';
            $this->out['__on_sub_menu__'] = 'payRetain';
            $this->out['__title__'] = '付费留存';
            $this->tpl = 'retain/payRetain.tpl';
        }
    }
}