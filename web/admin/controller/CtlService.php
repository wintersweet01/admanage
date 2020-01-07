<?php

/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/1/18
 * Time: 16:51
 */

class CtlService extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvService();
    }

    /**
     * 用户管理
     */
    public function userList()
    {
        SrvAuth::checkOpen('service', 'userList');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $keyword = trim($this->R('keyword'));
        $device_type = $this->R('device_type', 'int', 0);
        $has_phone = $this->R('has_phone', 'int', 0);
        $banned = $this->R('banned', 'int', 0);

        $SrvPlatform = new SrvPlatform();
        $data = $this->srv->getUserList($page, $game_id, $keyword, $device_type, $has_phone, $banned);
        $games = $SrvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '全部',
                'disabled' => false,
                'parent' => false,
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'service';
        $this->out['__on_sub_menu__'] = 'userList';
        $this->out['__title__'] = '用户管理';
        $this->tpl = 'service/user_list.tpl';
    }

    /**
     * 重置用户密码
     */
    public function userResetPwd()
    {
        SrvAuth::checkOpen('service', 'userList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $uid = $this->post('uid');

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->resetPwd($uid);
    }

    /**
     * 解绑手机
     */
    public function unbindPhone()
    {
        SrvAuth::checkOpen('service', 'userList');
        $this->outType = 'json';
        $uid = $this->post('uid', 'int', 0);

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->saveUserInfo($uid, array('phone' => ''));
    }

    /**
     * 解封禁用户
     */
    public function userBand()
    {
        SrvAuth::checkOpen('service', 'userList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $uid = $this->post('uid', 'int', 0);
        $status = $this->post('status', 'int', 0);
        $text = $this->post('text');

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->bandUser($uid, $status, $text);
    }

    /**
     * 踢用户下线
     */
    public function userKick()
    {
        SrvAuth::checkOpen('service', 'userList');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $uid = $this->post('uid');

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->kickUser($uid);
    }

    /**
     * 订单管理
     */
    public function orderList()
    {
        SrvAuth::checkOpen('service', 'orderList');
        $this->outType = 'smarty';

        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $server_id = $this->R('server_id', 'int', 0);
        $level1 = $this->R('level1', 'int', 0);
        $level2 = $this->R('level2', 'int', 0);
        $pay_type = $this->R('pay_type', 'int', 0);
        $order_num = $this->R('pt_order_num');
        $username = $this->R('username');
        $role_name = $this->R('role_name');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $is_pay = $this->R('is_pay', 'int', 0);
        $is_notify = $this->R('is_notify', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $pay_channel = $this->R('pay_channel');

        $SrvPlatform = new SrvPlatform();
        $data = $this->srv->getOrderList($page, $sdate, $edate, $game_id, $server_id, $level1, $level2, $username, $role_name, $pay_type, $order_num, $is_pay, $is_notify, $device_type, $pay_channel);
        $games = $SrvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '全部',
                'disabled' => false,
                'parent' => false,
                'attr' => 'style="width: 100px;"'
            ),
        );
        $data['total']['total_fee'] = number_format($data['total']['total_fee'] / 100, 2);
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_pay_types'] = LibUtil::config('ConfPayType');
        $this->out['_pay_channel_types'] = LibUtil::config('ConfUnionChannel');
        $this->out['__on_menu__'] = 'service';
        $this->out['__on_sub_menu__'] = 'orderList';
        $this->out['__title__'] = '订单管理';
        $this->tpl = 'service/order_list.tpl';
    }

    /**
     * 订单日志
     */
    public function orderNumLog()
    {
        SrvAuth::checkOpen('service', 'orderList');
        $this->outType = 'string';
        $pt_order_num = $this->R('pt_order_num');

        $SrvPlatform = new SrvPlatform();
        echo $SrvPlatform->orderLog($pt_order_num);
    }

    /**
     * 订单检查
     */
    public function orderNumCheck()
    {
        SrvAuth::checkOpen('service', 'orderList');
        $this->outType = 'json';
        $pt_order_num = $this->R('pt_order_num');

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->orderCheck($pt_order_num);
    }

    /**
     * 手动发货
     */
    public function handSendNotify()
    {
        SrvAuth::checkOpen('service', 'orderList');
        SrvAuth::checkPublicAuth('audit');
        $this->outType = 'json';
        $order_num = $this->R('order_num');

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->handSendNotify($order_num);
    }

    /**
     * 角色管理
     */
    public function roleList()
    {
        SrvAuth::checkOpen('service', 'roleList');
        $this->outType = 'smarty';

        $page = $this->R('page', 'int', 1);
        $username = $this->R('username');
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $server_id = $this->R('server_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $has_pay = $this->R('has_pay', 'int', 0);
        $role_name = $this->R('role_name');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $has_phone = $this->R('has_phone', 'int', 0);

        $SrvPlatform = new SrvPlatform();
        $data = $this->srv->getRoleList($page, $username, $parent_id, $game_id, $role_name, $has_pay, $server_id, $device_type, $sdate, $edate, $has_phone);
        $games = $SrvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '全部',
                'disabled' => false,
                'parent' => false,
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'service';
        $this->out['__on_sub_menu__'] = 'roleList';
        $this->out['__title__'] = '角色管理';
        $this->tpl = 'service/role_list.tpl';
    }

    /**
     * 激活日志
     */
    public function activeLog()
    {
        SrvAuth::checkOpen('service', 'activeLog');
        $this->outType = 'smarty';

        $page = $this->R('page', 'int', 1);
        $game_id = $this->R('game_id', 'int', 0);
        $date = $this->R('date');
        $device_id = $this->R('device_id');

        $SrvPlatform = new SrvPlatform();
        $data = $this->srv->activeLog($page, $date, $device_id, $game_id);
        $games = $SrvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['game_id'],
                'default_text' => '全部',
                'disabled' => false,
                'parent' => false,
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'service';
        $this->out['__on_sub_menu__'] = 'activeLog';
        $this->out['__title__'] = '激活日志';
        $this->tpl = 'service/active_log.tpl';
    }
}