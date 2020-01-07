<?php
/**
 * Created by PhpStorm.
 * User: phper
 * Date: 2019/4/23
 * Time: 21:06
 */

class CtlData5 extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvData();
    }

    public function external1()
    {
        SrvAuth::checkOpen('data5', 'external1');
        $this->outType = 'smarty';

        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type');
        $type = $this->R('type', 'int', 1);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->external($parent_id, $game_id, $device_type, $sdate, $edate, $type);
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
                'children_default_value' => $game_id,
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width:150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['__on_menu__'] = 'data5';
        $this->out['__on_sub_menu__'] = 'external1';
        $this->out['__title__'] = 'cps';
        $this->tpl = 'data/external1.tpl';
    }

    public function external2()
    {
        SrvAuth::checkOpen('data5', 'external2');
        $this->outType = 'smarty';

        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id','int',0);
        $device_type = $this->R('device_type');
        $type = $this->R('type', 'int', 1);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $data = $this->srv->external($parent_id, $game_id, $device_type, $sdate, $edate, $type);
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
        $this->out['__on_menu__'] = 'data5';
        $this->out['__on_sub_menu__'] = 'external2';
        $this->out['__title__'] = 'cpa';
        $this->tpl = 'data/external2.tpl';
    }

    //ASO联运
    public function external3()
    {
        SrvAuth::checkOpen('data5', 'external3');
        $this->outType = 'smarty';

        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id','int',0);
        $device_type = $this->R('device_type');
        $type = $this->R('type', 'int', 1);

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $data = $this->srv->externalAso($parent_id, $game_id, $device_type, $sdate, $edate, $type);
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
        $this->out['__on_menu__'] = 'data5';
        $this->out['__on_sub_menu__'] = 'external3';
        $this->out['__title__'] = 'ASO联运';
        $this->tpl = 'data/external3.tpl';
    }
}