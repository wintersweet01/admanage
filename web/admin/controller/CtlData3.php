<?php

/**
 * Created by PhpStorm.
 * User: qinsh
 * Date: 2018/6/12 0012
 * Time: 10:37
 */
class CtlData3 extends Controller
{
    private $srv;
    private $day = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 35, 40, 45, 50, 55, 60, 70, 80, 90);

    public function __construct()
    {
        $this->srv = new SrvData();
    }

    /**
     * 后续综合数据
     */
    public function payRetainAll()
    {
        SrvAuth::checkOpen('data3', 'payRetainAll');
        $this->outType = 'smarty';

        $page = $this->R('page', 'int', 1);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $channel_id = $this->R('channel_id');
        $parent_id = $this->R('parent_id');
        $game_id = $this->R('game_id');
        $device_type = $this->R('device_type');
        $package_name = $this->R('package_name');
        $has_cost = $this->R('has_cost', 'int', 0);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->getPayRetain($page, $parent_id, $game_id, $channel_id, $device_type, $package_name, $sdate, $edate, $this->day, $has_cost);
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
                ''
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_day'] = $this->day;
        $this->out['__on_menu__'] = 'data3';
        $this->out['__on_sub_menu__'] = 'payRetainAll';
        $this->out['__title__'] = '渠道综合';
        $this->tpl = 'data/payRetainAll.tpl';
    }

    /**
     * 后续数据
     */
    public function payRetain()
    {
        $type = $this->R('type');
        $menu = 'payRetain&type=' . $type;
        $title = '';
        switch ($type) {
            case 'pay':
                $title = '渠道充值';
                break;
            case 'roi':
                $title = '渠道ROI';
                break;
            case 'ltv':
                $title = '渠道LTV';
                break;
        }

        SrvAuth::checkOpen('data3', $menu);
        $this->outType = 'smarty';

        $page = $this->R('page', 'int', 1);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $channel_id = $this->R('channel_id');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id');
        $device_type = $this->R('device_type');
        $package_name = $this->R('package_name');
        $has_cost = $this->R('has_cost', 'int', 0);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->getPayRetain($page, $parent_id, $game_id, $channel_id, $device_type, $package_name, $sdate, $edate, $this->day, $has_cost);
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
        $this->out['_day'] = $this->day;
        $this->out['_type'] = $type;
        $this->out['__on_menu__'] = 'data3';
        $this->out['__on_sub_menu__'] = $menu;
        $this->out['__title__'] = $title;
        $this->tpl = 'data/payRetain.tpl';
    }
}