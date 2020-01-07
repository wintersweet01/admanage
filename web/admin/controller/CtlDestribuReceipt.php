<?php

class CtlDestribuReceipt extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvDestribuReceipt();
    }

    public function destribuReceiptDate()
    {
        SrvAuth::checkOpen('destribuReceipt', 'destribuReceiptDate');
        $this->outType = 'smarty';

        $game_id = $this->R('game_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $data = $this->srv->destribuReceiptDate($game_id, $sdate, $edate);
        $srvPlatform = new SrvPlatform();
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
        $this->out['__on_menu__'] = 'destribuReceipt';
        $this->out['__on_sub_menu__'] = 'destribuReceiptDate';
        $this->out['__title__'] = '分成后收入（按日期）';
        $this->tpl = 'finance/destribuReceiptDate.tpl';
    }

    public function destribuReceiptGame()
    {
        SrvAuth::checkOpen('destribuReceipt', 'destribuReceiptGame');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $data = $this->srv->destribuReceiptGame($game_id, $sdate, $edate);
        $srvPlatform = new SrvPlatform();
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
        $this->out['__on_menu__'] = 'destribuReceipt';
        $this->out['__on_sub_menu__'] = 'destribuReceiptGame';
        $this->out['__title__'] = '分成后收入（按游戏）';
        $this->tpl = 'finance/destribuReceiptGame.tpl';
    }

    public function destribuConfig()
    {
        SrvAuth::checkOpen('destribuReceipt', 'destribuConfList');
        $this->outType = 'smarty';
        $game_id = $this->R('game_id', 'int', 0);
        $is_edit = $this->R('is_edit', 'int', 0);
        $data = [];

        if ($game_id) {
            $channel = $this->R('channel');
            $area = $this->R('area');
            $prop = $this->R('prop');
            $data = $this->srv->destribuConfig($game_id, $channel, $area, $prop);
        }

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '选择游戏',
                'disabled' => $game_id ? true : false,
                'parent' => false,
                'attr' => 'style="width: 150px;"'
            ),
        );

        $channel = LibUtil::config(dirname(dirname(dirname(__FILE__))) . '/analysis_data/config/ConfPayType.php');
        $channel = array_merge(array('default' => '默认'), $channel);

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['is_edit'] = $is_edit;
        $this->out['_channels'] = $channel;
        $this->out['__on_menu__'] = 'destribuReceipt';
        $this->out['__on_sub_menu__'] = 'destribuConfig';
        $this->out['__title__'] = '分成配置';
        $this->tpl = 'finance/destribuConfig.tpl';
    }

    public function destribuConfList()
    {
        SrvAuth::checkOpen('destribuReceipt', 'destribuConfList');
        $this->outType = 'smarty';

        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $channel = LibUtil::config(dirname(dirname(dirname(__FILE__))) . '/analysis_data/config/ConfPayType.php');
        $channel = array_merge(array('default' => '默认'), $channel);


        $this->out['_channels'] = $channel;
        $DestribuConf = LibUtil::config('ConfDestribu');
        if ($DestribuConf) {
            $this->out['data'] = $DestribuConf;
        }


        $this->out['__on_menu__'] = 'destribuReceipt';
        $this->out['__on_sub_menu__'] = 'destribuConfList';
        $this->out['__title__'] = '分成配置列表';
        $this->tpl = 'finance/destribuConfList.tpl';
    }

    public function destribuConfigAction()
    {
        $this->outType = 'json';
        $data = $this->post('data');

        parse_str($data, $_POST);
        $is_edit = $this->post('is_edit', 'int', 0);
        if ($is_edit) {
            $money1 = $this->post('old_money1');
            $money2 = $this->post('old_money2');
        }
        $data = array(
            'game_id' => $this->post('game_id', 'int', 0),
            'channel_id' => $this->post('channel_id'),
            'money1' => $this->post('money1', 'int', 0),
            'money2' => $this->post('money2', 'int', 0),
            'prop' => $this->post('prop', 'float', 0),

        );


        $this->out = $this->srv->destribuConfigAction($data, $is_edit, $money1, $money2);

    }

}