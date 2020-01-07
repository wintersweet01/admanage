<?php

/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/1/18
 * Time: 16:53
 */

class SrvService
{

    public $mod;

    public function __construct()
    {
        $this->mod = new ModService();
    }

    /**
     * 获取用户信息列表
     * @param int $page
     * @param int $game_id
     * @param string $keyword
     * @param int $device_type
     * @param int $has_phone
     * @param int $banned
     * @return array
     */
    public function getUserList($page = 0, $game_id = 0, $keyword = '', $device_type = 0, $has_phone = 0, $banned = 0)
    {
        $data = [];
        $page = $page < 1 ? 1 : $page;
        $param = array(
            'keyword' => $keyword,
            'game_id' => $game_id,
            'device_type' => $device_type,
            'has_phone' => $has_phone,
            'banned' => $banned,
        );

        $ModPlatform = new ModPlatform();
        $info = $ModPlatform->getUserList($param, $page);
        foreach ($info['list'] as $v) {
            $v['pay_money'] = 0;
            $v['last_pay_time'] = 0;
            $v['pay_money'] = '-';
            $v['last_pay_time'] = '-';
            $v['active_time'] = $v['active_time'] > 0 ? date('Y-m-d H:i:s', $v['active_time']) : '-';
            $v['reg_time'] = $v['reg_time'] > 0 ? date('Y-m-d H:i:s', $v['reg_time']) : '-';
            $v['last_login_time'] = $v['last_login_time'] > 0 ? date('Y-m-d H:i:s', $v['last_login_time']) : '-';

            $data[$v['uid']] = $v;
        }

        if (!empty($data)) {
            $pay = $ModPlatform->getUserPayList(implode(',', array_keys($data)));
            foreach ($pay as $row) {
                $data[$row['uid']]['pay_money'] = round($row['pay_money'] / 100, 2);
                $data[$row['uid']]['last_pay_time'] = $row['last_pay_time'] ? date('Y-m-d H:i:s', $row['last_pay_time']) : '-';
            }
        }

        $info['list'] = $data;
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        LibUtil::clean_xss($username);
        LibUtil::clean_xss($reg_ip);
        $info['keyword'] = $keyword;
        $info['reg_ip'] = $reg_ip;
        $info['has_phone'] = $has_phone;
        $info['banned'] = $banned;

        return $info;
    }

    /**
     * 获取订单列表
     * @param $page
     * @param $sdate
     * @param $edate
     * @param $game_id
     * @param $server_id
     * @param $level1
     * @param $level2
     * @param $username
     * @param $role_name
     * @param $pay_type
     * @param $order_num
     * @param $is_pay
     * @param $is_notify
     * @param $device_type
     * @param string $pay_channel
     * @return array
     */
    public function getOrderList($page, $sdate, $edate, $game_id, $server_id, $level1, $level2, $username, $role_name, $pay_type, $order_num, $is_pay, $is_notify, $device_type, $pay_channel = '')
    {
        $page = $page < 1 ? 1 : $page;
        $param = array(
            'sdate' => $sdate,
            'edate' => $edate,
            'level1' => $level1,
            'level2' => $level2,
            'username' => $username,
            'role_name' => $role_name,
            'pay_type' => $pay_type,
            'order_num' => $order_num,
            'is_pay' => $is_pay,
            'is_notify' => $is_notify,
            'device_type' => $device_type,
            'pay_channel' => $pay_channel
        );

        $ModPlatform = new ModPlatform();
        $info = $ModPlatform->getOrderList($param, $page, 0);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $info['game_id'] = $game_id;
        $info['server_id'] = $server_id;
        $info['level1'] = $level1;
        $info['level2'] = $level2;
        $info['pay_type'] = $pay_type;
        $info['is_pay'] = $is_pay;
        $info['is_notify'] = $is_notify;
        $info['device_type'] = $device_type;
        $info['pay_channel'] = $pay_channel;

        LibUtil::clean_xss($order_num);
        $info['pt_order_num'] = $order_num;
        LibUtil::clean_xss($username);
        $info['username'] = $username;
        LibUtil::clean_xss($role_name);
        $info['role_name'] = $role_name;
        LibUtil::clean_xss($sdate);
        $info['sdate'] = $sdate;
        LibUtil::clean_xss($edate);
        $info['edate'] = $edate;

        if ($info['game_id']) {
            $srvData = new SrvData();
            $info['_servers'] = $srvData->getGameServer($game_id);
        }

        return $info;
    }

    /**
     * 获取角色列表
     * @param int $page
     * @param string $username
     * @param int $parent_id
     * @param int $game_id
     * @param string $role_name
     * @param int $has_pay
     * @param int $server_id
     * @param int $device_type
     * @param string $sdate
     * @param string $edate
     * @param int $has_phone
     * @return array
     */
    public function getRoleList($page = 0, $username = '', $parent_id = 0, $game_id = 0, $role_name = '', $has_pay = 0, $server_id = 0, $device_type = 0, $sdate = '', $edate = '', $has_phone = 0)
    {
        $page = $page < 1 ? 1 : $page;

        $ModPlatform = new ModPlatform();
        $info = $ModPlatform->getrolelist($page, 0, $parent_id, $game_id, 0, $device_type, '', $server_id, $role_name, $username, $sdate, $edate, $has_pay, $has_phone);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($username);
        $info['username'] = $username;
        $info['game_id'] = $game_id;
        $info['has_pay'] = $has_pay;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['has_phone'] = $has_phone;
        LibUtil::clean_xss($role_name);
        $info['role_name'] = $role_name;
        $info['server_id'] = $server_id;
        $info['device_type'] = $device_type;

        if ($info['game_id']) {
            $srvData = new SrvData();
            $info['_servers'] = $srvData->getGameServer($game_id);
        }

        return $info;
    }

    /**
     * 激活日志
     * @param int $page
     * @param string $date
     * @param string $device_id
     * @param int $game_id
     * @return array
     */
    public function activeLog($page = 1, $date = '', $device_id = '', $game_id = 0)
    {
        $page = $page < 1 ? 1 : $page;
        if (!$date) {
            $date = date('Ymd');
        }

        $date = str_replace('-', '', $date);

        $ModPlatform = new ModPlatform();
        $info = $ModPlatform->activeLog($page, 0, $date, $device_id, 0, $game_id, 0);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($device_id);
        $info['device_id'] = $device_id;
        LibUtil::clean_xss($date);
        $info['date'] = date('Y-m-d', strtotime($date));
        $info['game_id'] = $game_id;

        return $info;
    }
}