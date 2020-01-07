<?php

require_once LIB . '/library/GatewayClient/Gateway.php';

use GatewayClient\Gateway;

class SrvData
{

    private $mod;

    public function __construct()
    {
        $this->mod = new ModData();
    }

    public function channelHourPay($parent_id, $game_id, $channel_id, $device_type, $user_type, $sdate, $edate)
    {
        if ($sdate == '') {
            //$sdate = date('Y-m-d 00:00:00');
            $sdate = date('Y-m-d 00:00:00', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d H:00:00');
        }
        $srvAd = new SrvAd();
        $_channel_id = $srvAd->getAllChannel();

        if ($channel_id) {
            $channel_id = implode(',', $channel_id);
        } else {


            foreach ($_channel_id as $key => $val) {
                $channel_id .= $key . ',';
            }
            $channel_id = rtrim($channel_id, ',');
        }
        $info = $this->mod->channelHourPay($parent_id, $game_id, $channel_id, $device_type, $user_type, $sdate, $edate);

        if ($info['list']) {

            foreach ($info['list'] as $key => $val) {
                $info['list'][$key]['old_money'] = number_format($val['old_money'] / 100, '0', '.', '');
                $info['list'][$key]['new_money'] = number_format($val['new_money'] / 100, '0', '.', '');
                $info['list'][$key]['total_money'] = number_format(($val['new_money'] + $val['old_money']) / 100, '0', '.', '');
                $info['list'][$key]['channel_name'] = $_channel_id[$val['channel_id']];
            }
            $temps = array();
            foreach ($info['list'] as $key => $val) {
                $info['lists'][$val['date']]['data'][$val['channel_id']] = $val;
                $temps[$val['date']] = $val['date'];
            }
            $temp_channel_id = explode(',', $channel_id);

            foreach ($info['lists'] as $k => $v) {
                foreach ($temp_channel_id as $key => $val) {
                    if (!$v['data'][$val]) {
                        $info['lists'][$k]['data'][$val]['old_money'] = '0';
                        $info['lists'][$k]['data'][$val]['new_money'] = '0';
                        $info['lists'][$k]['data'][$val]['date'] = $k;
                        $info['lists'][$k]['data'][$val]['channel_id'] = $val;
                        $info['lists'][$k]['data'][$val]['total_money'] = '0';
                        $info['lists'][$k]['data'][$val]['channel_name'] = $_channel_id[$val];

                    }
                }
            }
            $count = count($temp_channel_id);
            foreach ($info['lists'] as $key => $val) {
                foreach ($val['data'] as $k => $v) {
                    $info['lists'][$key]['total']['total_old_money'] += $v['old_money'];
                    $info['lists'][$key]['total']['total_new_money'] += $v['new_money'];
                    $info['lists'][$key]['total']['all_money'] += $v['total_money'];
                }
            }
            foreach ($info['lists'] as $key => $val) {
                foreach ($val['total'] as $k => $v) {
                    $info['lists'][$key]['avg'][$k] = number_format($v / $count, 2, '.', '');
                    $info['lists'][$key]['total'][$k] = number_format($v, 0, '.', '');
                }
            }
            foreach ($info['list'] as $key => $val) {
                $info['sheet'][$val['channel_id']][$val['date']] = $val;
            }
            foreach ($info['sheet'] as $key => $val) {
                foreach ($temp_channel_id as $k => $v) {
                    if (!$info['sheet'][$v]) {
                        $info['sheet'][$v] = array();
                    }
                }
            }
            foreach ($info['sheet'] as $key => $val) {
                foreach ($temps as $k => $v) {
                    if (!$info['sheet'][$key][$v]) {
                        $info['sheet'][$key][$v]['old_money'] = '0';
                        $info['sheet'][$key][$v]['new_money'] = '0';
                        $info['sheet'][$key][$v]['date'] = $v;
                        $info['sheet'][$key][$v]['channel_id'] = $key;
                        $info['sheet'][$key][$v]['total_money'] = '0';
                        $info['sheet'][$key][$v]['channel_name'] = $_channel_id[$key];
                    }
                }

            }

            foreach ($info['lists'] as $key => $val) {
                $info['t']['total_old_money']['all'] += $val['total']['total_old_money'];
                $info['t']['total_new_money']['all'] += $val['total']['total_new_money'];
                $info['t']['all_money']['all'] += $val['total']['all_money'];
            }
            foreach ($info['sheet'] as $key => $val) {
                foreach ($val as $k => $v) {
                    $info['t']['total_old_money'][$v['channel_name']] += $v['old_money'];
                    $info['t']['total_new_money'][$v['channel_name']] += $v['new_money'];
                    $info['t']['all_money'][$v['channel_name']] += $v['total_money'];
                }
            }
            foreach ($info['lists'] as $key => $val) {
                ksort($info['lists'][$key]['data']);
            }
        }
        $info['game_id'] = $game_id;
        $info['channel_id'] = explode(',', $channel_id);
        $info['user_type'] = $user_type;
        $info['device_type'] = $device_type;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    public function payArea($sdate, $sort, $game_id, $parent_id)
    {
        if ($sdate == '') {
            $sdate = date('Y-m-01');
        } else {
            $sdate = date('Y-m-01', strtotime($sdate));
        }


        $info = $this->mod->payArea($sdate, $game_id, $parent_id);
        //print_R($info);die;
        if ($info['total']['c']) {
            foreach ($info['list'] as $key => $val) {
                $info['list'][$key]['pay_money'] = number_format($val['pay_money'] / 100, 0, '.', '');
                if ($val['pay']) {
                    $info['list'][$key]['ARPPU'] = number_format($val['pay_money'] / 100 / $val['pay'], 2, '.', '');
                } else {
                    $info['list'][$key]['ARPPU'] = 0;
                }
                if ($val['reg']) {
                    $info['list'][$key]['pay_rate'] = number_format($val['pay'] / $val['reg'] * 100, 2, '.', '');
                } else {
                    $info['list'][$key]['pay_rate'] = 0;
                }

            }
        }
        if ($sort) {
            foreach ($info['list'] as $key => $row) {
                $num[$key] = $row [$sort];
            }
        }

        array_multisort($num, SORT_DESC, $info['list']);

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($sort);
        $info['sdate'] = date('Y-m', strtotime($sdate));
        $info['sort'] = $sort;
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        return $info;
    }

    public function getOverview($parent_id, $device_type, $sdate, $edate, $is_excel = 0)
    {
        if ($sdate == '') {
            //$sdate = date('Y-m-01');
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $total = [];
        $info = $this->mod->getOverview($parent_id, $device_type, $sdate, $edate);
        $count = count($info);
        foreach ($info as &$row) {
            $row['cost'] = $row['cost'] / 100; //当日消耗
            $row['new_pay_money'] = $row['new_pay_money'] / 100; //新增付费金额
            $row['pay_money'] = $row['pay_money'] / 100; //总充值

            $row['old_user_active'] = $row['login_user'] - $row['reg_user']; //老用户活跃
            if ($row['display']) {
                $row['click_rate'] = bcdiv($row['click'] * 100, $row['display'], 2) . '%'; //点击率
            }
            if ($row['click']) {
                $row['active_rate'] = bcdiv($row['active'] * 100, $row['click'], 2) . '%'; //点击激活率
                $row['reg_rate'] = bcdiv($row['reg_user'] * 100, $row['click'], 2) . '%'; //点击注册率
            }
            if ($row['active']) {
                $row['active_cost'] = bcdiv($row['cost'], $row['active'], 2); //激活成本
                $row['active_reg_rate'] = bcdiv($row['reg_user'] * 100, $row['active'], 2) . '%'; //激活注册率
            }
            if ($row['cost'] > 0) {
                $row['roi'] = bcdiv($row['pay_money'] * 100, $row['cost'], 2) . '%'; //ROI
                $row['new_roi'] = bcdiv($row['new_pay_money'] * 100, $row['cost'], 2) . '%'; //新增ROI
            }
            if ($row['reg_user'] > 0) {
                $row['retain2_rate'] = bcdiv($row['retain2'] * 100, $row['reg_user'], 2) . '%'; //2次留存
                $row['retain3_rate'] = bcdiv($row['retain3'] * 100, $row['reg_user'], 2) . '%'; //3次留存
                $row['retain7_rate'] = bcdiv($row['retain7'] * 100, $row['reg_user'], 2) . '%'; //7次留存
                $row['retain15_rate'] = bcdiv($row['retain15'] * 100, $row['reg_user'], 2) . '%'; //15次留存
                $row['retain30_rate'] = bcdiv($row['retain30'] * 100, $row['reg_user'], 2) . '%'; //30次留存
                $row['retain60_rate'] = bcdiv($row['retain60'] * 100, $row['reg_user'], 2) . '%'; //60次留存
                $row['retain90_rate'] = bcdiv($row['retain90'] * 100, $row['reg_user'], 2) . '%'; //90次留存
                $row['new_arpu'] = bcdiv($row['new_pay_money'], $row['reg_user'], 2); //新增ARPU
                $row['new_pay_rate'] = bcdiv($row['new_pay_user'] * 100, $row['reg_user'], 2) . '%'; //新增付费率
                $row['new_role_rate'] = bcdiv($row['new_role'] * 100, $row['reg_user'], 2) . '%'; //创建率
                $row['reg_cost'] = bcdiv($row['cost'], $row['reg_user'], 2); //注册成本
            }
            if ($row['new_pay_user'] > 0) {
                $row['new_arppu'] = bcdiv($row['new_pay_money'], $row['new_pay_user'], 2); //新增ARPPU
                $row['new_pay_cost'] = bcdiv($row['cost'], $row['new_pay_user'], 2); //新增付费成本
            }
            if ($row['login_user'] > 0) {
                $row['pay_rate'] = bcdiv($row['pay_user'] * 100, $row['login_user'], 2) . '%'; //付费率
                $row['arpu'] = bcdiv($row['pay_money'], $row['login_user'], 2); //ARPU
            }
            if ($row['pay_user'] > 0) {
                $row['arppu'] = bcdiv($row['pay_money'], $row['pay_user'], 2); //ARPPU
            }
            if ($row['new_role'] > 0) {
                $row['new_role_cost'] = bcdiv($row['cost'], $row['new_role'], 2); //新增创角成本
            }

            $total['total_user'] += $row['total_user'];
            $total['reg_user'] += $row['reg_user'];
            $total['login_user'] += $row['login_user'];
            $total['reg_device'] += $row['reg_device'];
            $total['new_pay_user'] += $row['new_pay_user'];
            $total['new_pay_money'] += $row['new_pay_money'];
            $total['pay_user'] += $row['pay_user'];
            $total['pay_money'] += $row['pay_money'];
            $total['retain1'] += $row['retain1'];
            $total['retain2'] += $row['retain2'];
            $total['retain3'] += $row['retain3'];
            $total['retain7'] += $row['retain7'];
            $total['retain15'] += $row['retain15'];
            $total['retain30'] += $row['retain30'];
            $total['retain60'] += $row['retain60'];
            $total['retain90'] += $row['retain90'];
            $total['cost'] += $row['cost'];
            $total['display'] += $row['display'];
            $total['click'] += $row['click'];
            $total['new_role'] += $row['new_role'];
            $total['active'] += $row['active'];
        }

        $total['old_user_active'] = $total['login_user'] - $total['reg_user'];
        $total['avg_login_user'] = bcdiv($total['login_user'], $count);
        $total['avg_new_pay_user'] = bcdiv($total['new_pay_user'], $count);
        $total['avg_pay_user'] = bcdiv($total['pay_user'], $count);
        $total['avg_retain2'] = bcdiv($total['retain2'], $count);
        $total['avg_retain3'] = bcdiv($total['retain3'], $count);
        $total['avg_retain7'] = bcdiv($total['retain7'], $count);
        $total['avg_retain15'] = bcdiv($total['retain15'], $count);
        $total['avg_retain30'] = bcdiv($total['retain30'], $count);
        $total['avg_retain60'] = bcdiv($total['retain60'], $count);
        $total['avg_retain90'] = bcdiv($total['retain90'], $count);

        if ($total['display']) {
            $total['click_rate'] = bcdiv($total['click'] * 100, $total['display'], 2) . '%'; //点击率
        }
        if ($total['click']) {
            $total['active_rate'] = bcdiv($total['active'] * 100, $total['click'], 2) . '%'; //点击激活率
            $total['reg_rate'] = bcdiv($total['reg_user'] * 100, $total['click'], 2) . '%'; //点击注册率
        }
        if ($total['active']) {
            $total['active_cost'] = bcdiv($total['cost'], $total['active'], 2); //激活成本
            $total['active_reg_rate'] = bcdiv($total['reg_user'] * 100, $total['active'], 2) . '%'; //激活注册率
        }
        if ($total['cost'] > 0) {
            $total['roi'] = bcdiv($total['pay_money'] * 100, $total['cost'], 2) . '%'; //ROI
            $total['new_roi'] = bcdiv($total['new_pay_money'] * 100, $total['cost'], 2) . '%'; //新增ROI
        }
        if ($total['reg_user'] > 0) {
            $total['retain2_rate'] = bcdiv($total['retain2'] * 100, $total['reg_user'], 2) . '%'; //2次留存
            $total['retain3_rate'] = bcdiv($total['retain3'] * 100, $total['reg_user'], 2) . '%'; //3次留存
            $total['retain7_rate'] = bcdiv($total['retain7'] * 100, $total['reg_user'], 2) . '%'; //7次留存
            $total['retain15_rate'] = bcdiv($total['retain15'] * 100, $total['reg_user'], 2) . '%'; //15次留存
            $total['retain30_rate'] = bcdiv($total['retain30'] * 100, $total['reg_user'], 2) . '%'; //30次留存
            $total['retain60_rate'] = bcdiv($total['retain60'] * 100, $total['reg_user'], 2) . '%'; //60次留存
            $total['retain90_rate'] = bcdiv($total['retain90'] * 100, $total['reg_user'], 2) . '%'; //90次留存
            $total['new_arpu'] = bcdiv($total['new_pay_money'], $total['reg_user'], 2); //新增ARPU
            $total['new_pay_rate'] = bcdiv($total['new_pay_user'] * 100, $total['reg_user'], 2) . '%'; //新增付费率
            $total['new_role_rate'] = bcdiv($total['new_role'] * 100, $total['reg_user'], 2) . '%'; //创建率
            $total['reg_cost'] = bcdiv($total['cost'], $total['reg_user'], 2); //注册成本
        }
        if ($total['new_pay_user'] > 0) {
            $total['new_arppu'] = bcdiv($total['new_pay_money'], $total['new_pay_user'], 2); //新增ARPPU
            $total['new_pay_cost'] = bcdiv($total['cost'], $total['new_pay_user'], 2); //新增付费成本
        }
        if ($total['login_user'] > 0) {
            $total['pay_rate'] = bcdiv($total['pay_user'] * 100, $total['login_user'], 2) . '%'; //付费率
            $total['arpu'] = bcdiv($total['pay_money'], $total['login_user'], 2); //ARPU
        }
        if ($total['pay_user'] > 0) {
            $total['arppu'] = bcdiv($total['pay_money'], $total['pay_user'], 2); //ARPPU
        }
        if ($total['new_role'] > 0) {
            $total['new_role_cost'] = bcdiv($total['cost'], $total['new_role'], 2); //新增创角成本
        }

        if ($is_excel > 0) {
            $headerArray = array(
                '日期', '总新增', '消耗', '展示', '点击', '点击率', '激活数', '点击激活率', '激活成本', '当天新增', '新增设备', '点击注册率', '激活注册率', '注册成本', '新增创角', '创建率', '创角成本', '新增付费人数', '新增付费率', '新增付费成本', '新增付费金额', '新增ROI', '新增ARPU', '新增ARPPU', '付费人数', '付费率', '总充值', 'ROI', 'ARPU', 'ARPPU', 'DAU', '老用户活跃', '次日留存', '3日留存', '7日留存', '15日留存', '30日留存', '60日留存', '90日留存'
            );

            $excel_data = array();
            $excel_data[] = array(
                '合计',
                '-',
                '¥' . $total['cost'],
                $total['display'],
                $total['click'],
                $total['click_rate'],
                $total['active'],
                $total['active_rate'],
                '¥' . $total['active_cost'],
                $total['reg_user'],
                $total['reg_device'],
                $total['reg_rate'],
                $total['active_reg_rate'],
                '¥' . $total['reg_cost'],
                $total['new_role'],
                $total['new_role_rate'],
                '¥' . $total['new_role_cost'],
                $total['new_pay_user'],
                $total['new_pay_rate'],
                '¥' . $total['new_pay_cost'],
                '¥' . $total['new_pay_money'],
                $total['new_roi'],
                '¥' . $total['new_arpu'],
                '¥' . $total['new_arppu'],
                $total['pay_user'],
                $total['pay_rate'],
                '¥' . $total['pay_money'],
                $total['roi'],
                '¥' . $total['arpu'],
                '¥' . $total['arppu'],
                $total['avg_login_user'],
                $total['old_user_active'],
                $total['avg_retain2'] . '/' . $total['retain2_rate'],
                $total['avg_retain3'] . '/' . $total['retain3_rate'],
                $total['avg_retain7'] . '/' . $total['retain7_rate'],
                $total['avg_retain15'] . '/' . $total['retain15_rate'],
                $total['avg_retain30'] . '/' . $total['retain30_rate'],
                $total['avg_retain60'] . '/' . $total['retain60_rate'],
                $total['avg_retain90'] . '/' . $total['retain90_rate'],
            );
            foreach ($info as $u) {
                $excel_data[] = array(
                    $u['date'],
                    $u['total_user'],
                    '¥' . $u['cost'],
                    $u['display'],
                    $u['click'],
                    $u['click_rate'],
                    $u['active'],
                    $u['active_rate'],
                    '¥' . $u['active_cost'],
                    $u['reg_user'],
                    $u['reg_device'],
                    $u['reg_rate'],
                    $u['active_reg_rate'],
                    '¥' . $u['reg_cost'],
                    $u['new_role'],
                    $u['new_role_rate'],
                    '¥' . $u['new_role_cost'],
                    $u['new_pay_user'],
                    $u['new_pay_rate'],
                    '¥' . $u['new_pay_cost'],
                    '¥' . $u['new_pay_money'],
                    $u['new_roi'],
                    '¥' . $u['new_arpu'],
                    '¥' . $u['new_arppu'],
                    $u['pay_user'],
                    $u['pay_rate'],
                    '¥' . $u['pay_money'],
                    $u['roi'],
                    '¥' . $u['arpu'],
                    '¥' . $u['arppu'],
                    $u['login_user'],
                    $u['old_user_active'],
                    $u['retain2'] . ' / ' . $u['retain2_rate'],
                    $u['retain3'] . ' / ' . $u['retain3_rate'],
                    $u['retain7'] . ' / ' . $u['retain7_rate'],
                    $u['retain15'] . ' / ' . $u['retain15_rate'],
                    $u['retain30'] . ' / ' . $u['retain30_rate'],
                    $u['retain60'] . ' / ' . $u['retain60_rate'],
                    $u['retain90'] . ' / ' . $u['retain90_rate'],
                );
            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($parent_id > 0) {
                $game_name = $allGame[$parent_id];
            }

            $filename = $sdate . '-' . $edate . '-' . $game_name . '-游戏总览';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        $param = [];
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $param['parent_id'] = $parent_id;
        $param['device_type'] = $device_type;
        $param['sdate'] = $sdate;
        $param['edate'] = $edate;

        return array('list' => $info, 'total' => $total, 'param' => $param);
    }

    public function getOverview2($param = [], $day = [], $ltvDay = [])
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = trim($param['sdate']);
        $edate = trim($param['edate']);
        $type = (int)$param['type'];

        if ($sdate == '') {
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        if ($type <= 0) {
            $type = 7;
        }

        $games_data = (new SrvPlatform())->getAllGame(true);
        $games = $games_data['list'];

        $date = date('Y-m-d');
        $total = [];
        $info = $this->mod->getOverview2($parent_id, $game_id, $device_type, $sdate, $edate, $day, $ltvDay, $type);
        $count = count($info);
        foreach ($info as &$row) {

            foreach ($ltvDay as $d) {
                $row['ltv_reg' . $d] = $row['reg_user'];
                $row['ltv' . $d] = $row['reg_user'] > 0 && $row['ltv_money' . $d] > 0 ? round($row['ltv_money' . $d] / 100 / $row['reg_user'], 2) : '';

                $total['ltv_money' . $d] += $row['ltv_money' . $d];
                $total['ltv_reg' . $d] += $row['reg_user'];
            }

            $row['cost'] = $row['cost'] / 100; //当日消耗
            $row['new_pay_money'] = round($row['new_pay_money'] / 100, 2); //新增付费金额
            $row['pay_money'] = $row['pay_money'] / 100; //总充值
            $row['new_charge_money'] = $row['new_charge_money'] / 100; //新增充值

            $old_user_active = $row['login_user'] - $row['reg_user'];
            $row['old_user_active'] = $old_user_active > 0 ? $old_user_active : 0; //老用户活跃 登录人数-注册人数
            if ($row['display']) {
                $row['click_rate'] = bcdiv($row['click'] * 100, $row['display'], 2) . '%'; //点击率
            }
            if ($row['click']) {
                $row['active_rate'] = bcdiv($row['active'] * 100, $row['click'], 2) . '%'; //点击激活率
                $row['reg_rate'] = bcdiv($row['reg_user'] * 100, $row['click'], 2) . '%'; //点击注册率
            }
            if ($row['active']) {
                $row['active_cost'] = bcdiv($row['cost'], $row['active'], 2); //激活成本
                $row['active_reg_rate'] = bcdiv($row['reg_user'] * 100, $row['active'], 2) . '%'; //激活注册率
            }
            if ($row['cost'] > 0) {
                $row['roi'] = bcdiv($row['pay_money'] * 100, $row['cost'], 2) . '%'; //ROI
                $row['new_roi'] = bcdiv($row['new_pay_money'] * 100, $row['cost'], 2) . '%'; //新增ROI
            }
            if ($row['reg_user'] > 0) {
                foreach ($day as $d) {
                    //留存数据
                    if (!empty($row['retain' . $d])) {
                        $row['retain_rate' . $d] = sprintf('%05.2f', $row['retain' . $d] / $row['reg_user'] * 100) . '%';
                    }
                    if ($type == 7 || $type == 9) {
                        $queDay = $type == 7 ? $row['group_name'] : date('Y-m-01', strtotime($row['group_name']));
                        $arr = LibUtil::getDateFormat($queDay, $date);
                        $row['retain_reg' . $d] = $row['reg_user'];
                        if ($d > $arr['d']) {
                            $row['retain_reg' . $d] = 0;
                        }
                    }

                    $total['retain' . $d] += $row['retain' . $d];
                    $total['retain_reg' . $d] += $row['retain_reg' . $d];
                }

                $row['new_arpu'] = bcdiv($row['new_pay_money'], $row['reg_user'], 2); //新增ARPU
                $row['new_pay_rate'] = bcdiv($row['new_pay_user'] * 100, $row['reg_user'], 2) . '%'; //新增付费率
                $row['new_role_rate'] = bcdiv($row['new_role'] * 100, $row['reg_user'], 2) . '%'; //创建率
                $row['reg_cost'] = bcdiv($row['cost'], $row['reg_user'], 2); //注册成本
            }
            if ($row['new_pay_user'] > 0) {
                $row['new_arppu'] = bcdiv($row['new_pay_money'], $row['new_pay_user'], 2); //新增ARPPU
                $row['new_pay_cost'] = bcdiv($row['cost'], $row['new_pay_user'], 2); //新增付费成本
                $row['new_pay_cost'] = bcdiv($row['cost'], $row['new_pay_user'], 2); //新增付费成本
            }
            if ($row['login_user'] > 0) {
                $row['pay_rate'] = bcdiv($row['pay_user'] * 100, $row['login_user'], 2) . '%'; //付费率
                $row['arpu'] = bcdiv($row['pay_money'], $row['login_user'], 2); //ARPU
            }
            if ($row['pay_user'] > 0) {
                $row['arppu'] = bcdiv($row['pay_money'], $row['pay_user'], 2); //ARPPU
            }
            if ($row['new_role'] > 0) {
                $row['new_role_cost'] = bcdiv($row['cost'], $row['new_role'], 2); //新增创角成本
            }
            //付费人数
            $old_pay_user = $row['pay_user'] - $row['new_pay_user'];
            $row['old_pay_user'] = $old_pay_user > 0 ? $old_pay_user : 0;
            //老用户充值
            $old_pay_money = $row['pay_money'] - $row['new_pay_money'];
            $row['old_pay_money'] = $old_pay_money < 0 ? 0 : round($old_pay_money, 2);
            if ($row['old_user_active'] > 0) {
                /*-----老用户相关------*/
                //付费率
                $row['old_pay_rate'] = bcdiv($row['old_pay_user'] * 100, $row['old_user_active'], 2) . "%";
                //ARPU
                $row['old_arpu'] = bcdiv($row['old_pay_money'], $row['old_user_active'], 2);
            }
            if ($row['old_pay_user'] > 0) {
                //ARPPU
                $row['old_arppu'] = bcdiv($row['old_pay_money'], $row['old_pay_user'], 2);
            }

            ///分组条件显示
            switch ($type) {
                case 1:
                case 8:
                    $row['group_name'] = $games[$row['group_name']];
                    break;
                case 2:
                    $row['group_name'] = $row['group_name'] == 1 ? 'IOS' : ($row['group_name'] == 2 ? 'ANDROID' : '-');
                    break;
                case 10:
                    $yearWeek = explode('-', $row['group_name']);
                    $weekDay = LibUtil::weekStartEnd($yearWeek[0], $yearWeek[1]);
                    $row['group_name'] = date('Y-m-d', $weekDay['start']) . " - " . date('Y-m-d', $weekDay['end']);
                    break;
                default:
                    break;
            }

            if (empty($row['group_name'])) {
                $row['group_name'] = '-';
            }

            $total['total_user'] += $row['total_user'];
            $total['reg_user'] += $row['reg_user'];
            $total['login_user'] += $row['login_user'];
            $total['reg_device'] += $row['reg_device'];
            $total['new_pay_user'] += $row['new_pay_user'];
            $total['new_pay_money'] += $row['new_pay_money'];
            $total['pay_user'] += $row['pay_user'];
            $total['pay_money'] += $row['pay_money'];
            $total['cost'] += $row['cost'];
            $total['display'] += $row['display'];
            $total['click'] += $row['click'];
            $total['new_role'] += $row['new_role'];
            $total['active'] += $row['active'];
        }

        $total['old_user_active'] = $total['login_user'] - $total['reg_user'];
        $total['avg_login_user'] = bcdiv($total['login_user'], $count);
        $total['avg_new_pay_user'] = bcdiv($total['new_pay_user'], $count);
        $total['avg_pay_user'] = bcdiv($total['pay_user'], $count);
        $total['old_pay_money'] = round($total['pay_money'] - $total['new_pay_money'], 2);
        $total['old_pay_user'] = $total['pay_user'] - $total['new_pay_user'];
        foreach ($day as $d) {
            if ($total['retain' . $d]) {
                $total['avg_retain' . $d] = bcdiv($total['retain' . $d], $count);
            }
            if ($total['retain_reg' . $d] > 0) {
                $total['retain_rate' . $d] = bcdiv($total['retain' . $d] * 100, $total['retain_reg' . $d], 2) . '%';
            }
        }

        foreach ($ltvDay as $d) {
            if (!empty($total['ltv_money' . $d])) {
                //LTV数据
                $total['ltv' . $d] = bcdiv($total['ltv_money' . $d] / 100, $total['ltv_reg' . $d], 2);
            }
            $total['ltv' . $d] > 0 || $total['ltv' . $d] = '';
        }

        if ($total['display']) {
            $total['click_rate'] = bcdiv($total['click'] * 100, $total['display'], 2) . '%'; //点击率
        }
        if ($total['click']) {
            $total['active_rate'] = bcdiv($total['active'] * 100, $total['click'], 2) . '%'; //点击激活率
            $total['reg_rate'] = bcdiv($total['reg_user'] * 100, $total['click'], 2) . '%'; //点击注册率
        }
        if ($total['active']) {
            $total['active_cost'] = bcdiv($total['cost'], $total['active'], 2); //激活成本
            $total['active_reg_rate'] = bcdiv($total['reg_user'] * 100, $total['active'], 2) . '%'; //激活注册率
        }
        if ($total['cost'] > 0) {
            $total['roi'] = bcdiv($total['pay_money'] * 100, $total['cost'], 2) . '%'; //ROI
            $total['new_roi'] = bcdiv($total['new_pay_money'] * 100, $total['cost'], 2) . '%'; //新增ROI
        }
        if ($total['reg_user'] > 0) {
            $total['new_arpu'] = bcdiv($total['new_pay_money'], $total['reg_user'], 2); //新增ARPU
            $total['new_pay_rate'] = bcdiv($total['new_pay_user'] * 100, $total['reg_user'], 2) . '%'; //新增付费率
            $total['new_role_rate'] = bcdiv($total['new_role'] * 100, $total['reg_user'], 2) . '%'; //创建率
            $total['reg_cost'] = bcdiv($total['cost'], $total['reg_user'], 2); //注册成本
        }
        if ($total['new_pay_user'] > 0) {
            $total['new_arppu'] = bcdiv($total['new_pay_money'], $total['new_pay_user'], 2); //新增ARPPU
            $total['new_pay_cost'] = bcdiv($total['cost'], $total['new_pay_user'], 2); //新增付费成本
        }
        if ($total['login_user'] > 0) {
            $total['pay_rate'] = bcdiv($total['pay_user'] * 100, $total['login_user'], 2) . '%'; //付费率
            $total['arpu'] = bcdiv($total['pay_money'], $total['login_user'], 2); //ARPU
        }
        if ($total['pay_user'] > 0) {
            $total['arppu'] = bcdiv($total['pay_money'], $total['pay_user'], 2); //ARPPU
        }
        if ($total['new_role'] > 0) {
            $total['new_role_cost'] = bcdiv($total['cost'], $total['new_role'], 2); //新增创角成本
        }

        if ($total['old_user_active'] > 0) {
            $total['old_pay_rate'] = bcdiv($total['old_pay_user'] * 100, $total['old_user_active'], 2) . "%";
            $total['old_arpu'] = bcdiv($total['old_pay_money'], $total['old_user_active'], 2);
        }
        if ($total['old_pay_user'] > 0) {
            $total['old_arppu'] = bcdiv($total['old_pay_money'], $total['old_pay_user'], 2);
        }
        $total['new_pay_money'] = round($total['new_pay_money'], 2);
        $total['pay_money'] = round($total['pay_money'], 2);
        $query = array(
            'sdate' => $sdate,
            'edate' => $edate
        );

        return array('list' => $info, 'total' => $total, 'query' => $query);
    }

    public function getOverviewMonth($page, $parent_id, $game_id, $device_type, $month, $all, $is_excel = 0, $plus_)
    {
        $page = $page < 1 ? 1 : $page;


        //print_r($month);die;
        if ($month == '') {
            $month = date('Y-m');
        }
        $sdate = date('Y-m-01', strtotime($month));
        $edate = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($month)), date('t', strtotime($month)), date('Y', strtotime($month))));
        $info = $this->mod->getOverviewMonth($page, $parent_id, $game_id, $device_type, $month, $all, $plus_);

        if (!$device_type) {
            foreach ($info['list'] as $key => $val) {
                $data[$val['date']][] = $val;
            }
            $i = 0;
            $temp = array();
            foreach ($data as $key => $val) {
                foreach ($val as $k => $v) {
                    $temp[$i]['total_user'] += $v['total_user'];
                    $temp[$i]['reg_user'] += $v['reg_user'];
                    $temp[$i]['date'] = $v['date'];
                    $temp[$i]['login_user'] += $v['login_user'];
                    $temp[$i]['reg_device'] += $v['reg_device'];
                    $temp[$i]['new_pay_user'] += $v['new_pay_user'];
                    $temp[$i]['new_pay_money'] += $v['new_pay_money'];
                    $temp[$i]['pay_user'] += $v['pay_user'];
                    $temp[$i]['pay_money'] += $v['pay_money'];
                    $temp[$i]['retain2'] += $v['retain2'];
                    $temp[$i]['retain3'] += $v['retain3'];
                    $temp[$i]['retain7'] += $v['retain7'];
                    $temp[$i]['retain15'] += $v['retain15'];
                    $temp[$i]['retain30'] += $v['retain30'];
                    $temp[$i]['retain60'] += $v['retain60'];
                    $temp[$i]['retain90'] += $v['retain90'];
                    $temp[$i]['old_user_active'] += $v['old_user_active'];
                }
                $i++;
            }

            $info['list'] = $temp;
            $total['avg_login_user'] = $info['total']['all_login_user'] / count($info['list']);
            unset($temp);
        }
        if ($info['total']['c'] > 0) {
            $info['list'] = array_reverse($info['list']);
            $temp_total_cost = 0;
            $temp_total_pay_money = 0;
            foreach ($info['list'] as $key => $val) {


                $info['list'][$key]['old_user_active'] = $val['login_user'] - $val['reg_user'];

                $cost = $this->mod->dayCost($game_id, $val['date'], $device_type);
                $info['list'][$key]['cost'] = $cost;
                $dates = explode('-', $val['date']);
                unset($dates[2]);
                $temp_date = implode('-', $dates);
                if (($temp_date != $month)) {
                    $temp_total_cost += 0;
                } else {
                    $temp_total_cost += $cost;
                }

                $temp_total_pay_money += $val['pay_money'];
                if ($temp_total_cost) {
                    $info['list'][$key]['total_acROI'] = number_format($temp_total_pay_money / $temp_total_cost, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['total_acROI'] = '0%';
                }


                if ($cost > 0) {
                    $info['list'][$key]['ROI'] = number_format($val['pay_money'] / $cost, 2, '.', '') . '%';
                    $info['list'][$key]['new_ROI'] = number_format($val['new_pay_money'] / $cost, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ROI'] = '0%';
                    $info['list'][$key]['new_ROI'] = '0%';
                }

                if ($val['reg_user'] > 0) {
                    $info['list'][$key]['2retain_rate'] = number_format($val['retain2'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['3retain_rate'] = number_format($val['retain3'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['7retain_rate'] = number_format($val['retain7'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['15retain_rate'] = number_format($val['retain15'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['30retain_rate'] = number_format($val['retain30'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['60retain_rate'] = number_format($val['retain60'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['90retain_rate'] = number_format($val['retain90'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['new_ARPU'] = number_format($val['new_pay_money'] / 100 / $val['reg_user'], 2, '.', '');
                    $info['list'][$key]['new_pay_rate'] = number_format($val['new_pay_user'] / $val['reg_user'] * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['new_ARPU'] = 0;
                    $info['list'][$key]['new_pay_rate'] = '0%';
                }
                if ($val['new_pay_user'] > 0) {
                    $info['list'][$key]['new_ARPPU'] = number_format($val['new_pay_money'] / 100 / $val['new_pay_user'], 2, '.', '');
                    $info['list'][$key]['new_pay_cost'] = number_format($cost / $val['new_pay_user'], 2, '.', '');
                } else {
                    $info['list'][$key]['new_ARPPU'] = 0;
                    $info['list'][$key]['new_pay_cost'] = 0;
                }
                if ($val['login_user'] > 0) {
                    $info['list'][$key]['pay_rate'] = number_format($val['pay_user'] / $val['login_user'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['ARPU'] = number_format($val['pay_money'] / 100 / $val['login_user'], 2, '.', '');
                } else {
                    $info['list'][$key]['ARPU'] = 0;
                    $info['list'][$key]['pay_rate'] = '0%';
                }
                if ($val['pay_user'] > 0) {
                    $info['list'][$key]['ARPPU'] = number_format($info['list'][$key]['pay_money'] / 100 / $info['list'][$key]['pay_user'], 2, '.', '');
                } else {
                    $info['list'][$key]['ARPPU'] = 0;
                }
                $info['list'][$key]['pay_money'] = number_format($val['pay_money'] / 100, 0, '.', '');
                $info['list'][$key]['new_pay_money'] = number_format($val['new_pay_money'] / 100, 0, '.', '');
            }

            $total_cost = $this->mod->totalCost($game_id, $sdate, $edate, $device_type);
            $info['total']['total_cost'] = $total_cost;
            if ($total_cost) {
                $info['total']['all_ROI'] = number_format($info['total']['all_pay_money'] / $total_cost, 2, '.', '') . '%';
                $info['total']['all_new_ROI'] = number_format($info['total']['all_new_pay_money'] / $total_cost, 2, '.', '') . '%';
            } else {
                $info['total']['all_ROI'] = '0%';
                $info['total']['all_new_ROI'] = '0%';
            }


            if ($info['total']['all_login_user'] > 0) {
                $info['total']['all_pay_rate'] = number_format($info['total']['all_pay_user'] / $info['total']['all_login_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_ARPU'] = number_format($info['total']['all_pay_money'] / 100 / $info['total']['all_login_user'], 2, '.', '');
            } else {
                $info['total']['all_ARPU'] = 0;
                $info['total']['all_pay_rate'] = '0%';
            }
            if ($info['total']['all_pay_user'] > 0) {
                $info['total']['all_ARPPU'] = number_format($info['total']['all_pay_money'] / 100 / $info['total']['all_pay_user'], 2, '.', '');
            } else {
                $info['total']['all_ARPPU'] = 0;
            }
            if ($info['total']['all_reg_user'] > 0) {
                $info['total']['all_2retain_rate'] = number_format($info['total']['sum_retain2'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_3retain_rate'] = number_format($info['total']['sum_retain3'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_7retain_rate'] = number_format($info['total']['sum_retain7'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_15retain_rate'] = number_format($info['total']['sum_retain15'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_30retain_rate'] = number_format($info['total']['sum_retain30'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_60retain_rate'] = number_format($info['total']['sum_retain60'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_90retain_rate'] = number_format($info['total']['sum_retain90'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
                $info['total']['all_new_ARPU'] = number_format($info['total']['all_new_pay_money'] / 100 / $info['total']['all_reg_user'], 0, '.', '');
                $info['total']['all_new_pay_rate'] = number_format($info['total']['all_new_pay_user'] / $info['total']['all_reg_user'] * 100, 2, '.', '') . '%';
            } else {
                $info['total']['all_new_ARPU'] = 0;
                $info['total']['all_new_pay_rate'] = '0%';
            }
            if ($info['total']['all_new_pay_user'] > 0) {
                $info['total']['all_new_ARPPU'] = number_format($info['total']['all_new_pay_money'] / 100 / $info['total']['all_new_pay_user'], 2, '.', '');
                $info['total']['all_new_pay_cost'] = number_format($total_cost / $info['total']['all_new_pay_user'], 2, '.', '');
            } else {
                $info['total']['all_new_ARPPU'] = 0;
            }

            $info['total']['all_pay_money'] = number_format($info['total']['all_pay_money'] / 100, 0, '.', '');
            $info['total']['all_new_pay_money'] = number_format($info['total']['all_new_pay_money'] / 100, 0, '.', '');
            $info['total']['avg_new_pay_user'] = number_format($info['total']['avg_new_pay_user'], 0, '.', '');
            $info['total']['avg_retain2'] = number_format($info['total']['avg_retain2'], 0, '.', '');
            $info['total']['avg_retain3'] = number_format($info['total']['avg_retain3'], 0, '.', '');
            $info['total']['avg_retain7'] = number_format($info['total']['avg_retain7'], 0, '.', '');
            $info['total']['avg_retain15'] = number_format($info['total']['avg_retain15'], 0, '.', '');
            $info['total']['avg_retain30'] = number_format($info['total']['avg_retain30'], 0, '.', '');
            $info['total']['avg_retain60'] = number_format($info['total']['avg_retain60'], 0, '.', '');
            $info['total']['avg_retain90'] = number_format($info['total']['avg_retain90'], 0, '.', '');
            $info['total']['avg_login_user'] = number_format($info['total']['avg_login_user'], 0, '.', '');
            $info['total']['avg_pay_user'] = number_format($info['total']['avg_pay_user'], 0, '.', '');
            $info['total']['all_old_user_active'] = $info['total']['all_login_user'] - $info['total']['all_reg_user'];
            if ($info['total']['total_cost']) {
                $info['total']['total_acROI'] = number_format($info['total']['all_pay_money'] * 100 / $info['total']['total_cost'], 2, '.', '') . '%';
            }

        }
        foreach ($info['list'] as $key => $val) {
            $Ym = explode('-', $val['date']);
            $Ym = $Ym[0] . '-' . $Ym[1];
            if ($month != $Ym) {
                $info['list'][$key]['nothismonth'] = 1;
                $info['list'][$key]['total_user'] = '-';
                $info['list'][$key]['reg_user'] = '-';
                $info['list'][$key]['reg_device'] = '-';
                $info['list'][$key]['new_pay_user'] = '-';
                $info['list'][$key]['new_pay_money'] = '-';
                $info['list'][$key]['retain2'] = '-';
                $info['list'][$key]['retain3'] = '-';
                $info['list'][$key]['retain7'] = '-';
                $info['list'][$key]['retain15'] = '-';
                $info['list'][$key]['retain30'] = '-';
                $info['list'][$key]['retain60'] = '-';
                $info['list'][$key]['retain90'] = '-';
                $info['list'][$key]['cost'] = '-';
                $info['list'][$key]['ROI'] = '-';
                $info['list'][$key]['new_ROI'] = '-';
                $info['list'][$key]['new_ARPU'] = '-';
                $info['list'][$key]['new_pay_rate'] = '-';
                $info['list'][$key]['new_ARPPU'] = '-';
            }
        }

        $info['list'] = array_reverse($info['list']);
        if ($is_excel > 0) {
            $headerArray = array(
                '日期', '总新增', '当天新增', 'DAU', '老用户活跃', '新增付费用户成本', '新增设备', '新增付费人数', '新增付费率', '新增arpu', '新增arppu', '新增付费金额', '付费人数', '付费率', 'arpu', 'arppu', '总充值', '消耗', 'ROI', '新增ROI', '次日留存', '3日留存', '7日留存', '15日留存'
            );

            $excel_data = array();
            $excel_data[] = array(
                '合计',
                '',
                $info['total']['all_reg_user'],
                $info['total']['avg_login_user'],
                $info['total']['all_old_user_active'],
                $info['total']['all_new_pay_cost'],
                $info['total']['all_reg_device'],
                $info['total']['avg_new_pay_user'],
                $info['total']['all_new_pay_rate'],
                '¥' . $info['total']['all_new_ARPU'],
                '¥' . $info['total']['all_new_ARPPU'],
                '¥' . $info['total']['all_new_pay_money'],
                $info['total']['avg_pay_user'],
                $info['total']['all_pay_rate'],
                '¥' . $info['total']['all_ARPU'],
                '¥' . $info['total']['all_ARPPU'],
                '¥' . $info['total']['all_pay_money'],
                '¥' . $info['total']['total_cost'],
                $info['total']['all_ROI'],
                $info['total']['all_new_ROI'],
                $info['total']['avg_retain2'] . '/' . $info['total']['all_2retain_rate'],
                $info['total']['avg_retain3'] . '/' . $info['total']['all_3retain_rate'],
                $info['total']['avg_retain7'] . '/' . $info['total']['all_7retain_rate'],
                $info['total']['avg_retain15'] . '/' . $info['total']['all_15retain_rate'],
                $info['total']['avg_retain15'] . '/' . $info['total']['all_30retain_rate'],
                $info['total']['avg_retain15'] . '/' . $info['total']['all_60retain_rate'],
                $info['total']['avg_retain15'] . '/' . $info['total']['all_90retain_rate'],
            );
            foreach ($info['list'] as $key => $u) {
                $excel_data[] = array(
                    $u['date'],
                    $u['total_user'],
                    $u['reg_user'],
                    $u['login_user'],
                    $u['old_user_active'],
                    $u['new_pay_cost'],
                    $u['reg_device'],
                    $u['new_pay_user'],
                    $u['new_pay_rate'],
                    '¥' . $u['new_ARPU'],
                    '¥' . $u['new_ARPPU'],
                    '¥' . $u['new_pay_money'],
                    $u['pay_user'],
                    $u['pay_rate'],
                    '¥' . $u['ARPU'],
                    '¥' . $u['ARPPU'],
                    '¥' . $u['pay_money'],
                    '¥' . $u['cost'],
                    $u['ROI'],
                    $u['new_ROI'],
                    $u['retain2'] . ' / ' . $u['2retain_rate'],
                    $u['retain3'] . ' / ' . $u['3retain_rate'],
                    $u['retain7'] . ' / ' . $u['7retain_rate'],
                    $u['retain15'] . ' / ' . $u['15retain_rate'],
                    $u['retain15'] . ' / ' . $u['30retain_rate'],
                    $u['retain15'] . ' / ' . $u['60retain_rate'],
                    $u['retain15'] . ' / ' . $u['90retain_rate'],
                );

            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' 分月游戏总览';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        //print_r($info);die;
        //$info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(),$info['total']['c'],$page,DEFAULT_ADMIN_PAGE_NUM);
        //$info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['game_id'] = $game_id;
        $info['parent_id'] = $parent_id;
        $info['device_type'] = $device_type;
        $info['plus_'] = $plus_;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;
        $info['month'] = $month;
        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id']);
        }

        return $info;
    }

    /**
     * 每小时新增注册（渠道版）
     * @param $param
     * @return array
     */
    public function regHour($param)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $platform = (int)$param['platform'];
        $date = $param['date'];
        $date || $date = date('Y-m-d');

        $day = [];
        for ($i = 0; $i < 24; $i++) {
            $day[] = str_pad($i, 2, 0, STR_PAD_LEFT);
        }

        $info = $this->mod->regHour($parent_id, $game_id, $platform, $date);
        $list = $data = $series = $channels = [];
        foreach ($info as $row) {
            $data[$row['hour']][$row['channel_id']] = (int)$row['reg'];
            $channels[$row['channel_id']] = $row['channel_name'];
        }

        //图形数据
        foreach ($channels as $channel_id => $channel_name) {
            $tmp = [];
            foreach ($day as $hour) {
                $tmp[] = (int)$data[$hour][$channel_id];
            }

            $series[] = array(
                'id' => (int)$channel_id,
                'name' => $channel_name,
                'data' => $tmp
            );
        }

        //表格数据
        if (!empty($data)) {
            foreach ($day as $hour) {
                $tmp = [];
                $tmp['hour'] = $hour . '时';
                foreach ($channels as $channel_id => $channel_name) {
                    $tmp['channel_' . $channel_id] = $data[$hour][$channel_id] ? (int)$data[$hour][$channel_id] : '';
                    $tmp['total'] += (int)$data[$hour][$channel_id];
                }
                $tmp['total'] = $tmp['total'] ? $tmp['total'] : '';

                $list[] = $tmp;
            }
        }

        return array(
            'data' => $list,
            'channels' => $channels,
            'day' => $day,
            'date' => $date,
            'series' => $series
        );
    }

    /**
     * 每小时新增注册（简化版）
     * @param $param
     * @param $day
     * @return array
     */
    public function regHour2($param, $day)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $platform = (int)$param['platform'];
        $sdate = $param['sdate'];
        $edate = $param['edate'];
        $now = date('Y-m-d');

        $sdate || $sdate = date('Y-m-d', strtotime('-7 days'));
        $edate || $edate = $now;


        $info = $this->mod->regHour2($parent_id, $game_id, $platform, $sdate, $edate);
        $list = $data = $series = [];
        foreach ($info as $row) {
            $data[$row['day']][$row['hour']] = (int)$row['reg'];
        }

        if (!empty($data)) {
            foreach ($data as $d => $row) {
                $tmp1 = $tmp2 = [];

                $tmp2['date'] = $d;
                foreach ($day as $hour) {
                    $reg = (int)$row[$hour];

                    $tmp1[] = $reg;

                    $tmp2[$hour] = $reg > 0 ? $reg : '';
                    $tmp2['total'] += $reg;
                }

                $tmp2['total'] = $tmp2['total'] > 0 ? $tmp2['total'] : '';
                $list[] = $tmp2;

                $series[] = array(
                    'id' => $d,
                    'name' => $d,
                    'data' => $tmp1
                );
            }
        }

        return array(
            'data' => $list,
            'sdate' => $sdate,
            'edate' => $edate,
            'series' => $series
        );
    }

    public function payHabitDate($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, $is_excel = 0)
    {
        $page = $page < 1 ? 1 : $page;
        if ($sdate == '') {
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $info = $this->mod->payHabit($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, 0, 0, $is_excel);

        if ($info['total'] > 0) {
            foreach ($info['list'] as $key => $val) {
                $info['list'][$key]['level_money'] = '¥' . $info['list'][$key]['level_money'] / 100;
                $info['list'][$key]['total_money'] = '¥' . $val['order_num'] * $val['level_money'] / 100;
                $info['list'][$key]['all_order_number'] = $this->mod->dateAllOrder($val['date']);
            }
        }
        if ($is_excel > 0) {
            $headerArray = array(
                '日期', '充值总额', '该档次订单数', '所有档次总订单数'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['date'],
                    ' ' . $v['total_money'],
                    $v['order_num'],
                    $v['all_order_number']
                );

            }
            $allLevel = $this->getMoneyLevel($game_id);
            $level_name = '';
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($level_money) {
                $level_name = $allLevel[$level_money];
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' 充值档次 ' . $level_name . ' 日期付款数据统计';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['device_type'] = $device_type;
        $info['all'] = $all;
        return $info;
    }

    public function payHabitChannel($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, $is_excel = 0)
    {
        $page = $page < 1 ? 1 : $page;
        if ($sdate == '') {
            $sdate = date('Y-m-01');
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info = $this->mod->payHabit($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, 1);

        if ($info['total'] > 0) {
            $srvAd = new SrvAd();
            $allChannel = $srvAd->getAllChannel();
            foreach ($info['list'] as $key => $val) {
                $info['list'][$key]['level_money'] = '¥' . $info['list'][$key]['level_money'] / 100;
                $info['list'][$key]['channel_name'] = $allChannel[$val['channel_id']];
                $info['list'][$key]['total_money'] = '¥' . $val['order_num'] * $val['level_money'] / 100;
                $info['list'][$key]['all_order_number'] = $this->mod->channelAllOrder($val['channel_id'], $sdate, $edate);
            }

        }
        if ($is_excel > 0) {
            $headerArray = array(
                '渠道', '充值总额', '该档次订单数', '所有档次总订单数'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['channel_name'],
                    ' ' . $v['total_money'],
                    $v['order_num'],
                    $v['all_order_number']
                );

            }
            $allLevel = $this->getMoneyLevel($game_id);
            $level_name = '';
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($level_money) {
                $level_name = $allLevel[$level_money];
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' 充值档次 ' . $level_name . ' 渠道付款数据统计';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['device_type'] = $device_type;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;
        return $info;
    }

    public function payHabitServer($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, $is_excel = 0)
    {
        $page = $page < 1 ? 1 : $page;
        if ($sdate == '') {
            //$sdate = date('Y-m-01');
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info = $this->mod->payHabit($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, 0, 1);

        if ($info['total'] > 0) {
            $allServer = $this->getGameServer($game_id);

            foreach ($info['list'] as $key => $val) {
                $info['list'][$key]['level_money'] = '¥' . $info['list'][$key]['level_money'] / 100;
                $info['list'][$key]['server_name'] = $allServer[$val['server_id']];
                $info['list'][$key]['total_money'] = '¥' . $val['order_num'] * $val['level_money'] / 100;
                $info['list'][$key]['all_order_number'] = $this->mod->serverAllOrder($val['server_id'], $sdate, $edate);
            }

        }
        if ($is_excel > 0) {
            $headerArray = array(
                '区服', '充值总额', '该档次订单数', '所有档次总订单数'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['server_name'],
                    ' ' . $v['total_money'],
                    $v['order_num'],
                    $v['all_order_number']
                );

            }
            $allLevel = $this->getMoneyLevel($game_id);
            $level_name = '';
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($level_money) {
                $level_name = $allLevel[$level_money];
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' 充值档次 ' . $level_name . ' 区服付款数据统计';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['device_type'] = $device_type;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;
        return $info;
    }

    public function newViewData($game_id, $device_type, $sdate, $edate, $all, $is_excel = 0)
    {

        if ($sdate == '') {
            //$sdate = date('Y-m-01');
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info['lists'] = array();
        $info = $this->mod->newViewData($game_id, $device_type, $sdate, $edate, $all);

        $info['param']['reg'] = '注册人数';
        $info['param']['new_equipment'] = '新增设备';
        $info['param']['active_login'] = '活跃登录';
        $info['param']['payer_num'] = '付费人数';
        $info['param']['new_payer_num'] = '新增付费人数';
        $info['param']['total_deposit_money'] = '总充值';
        $info['param']['new_deposit_money'] = '新增玩家充值';
        $info['param']['payrate'] = '付费率';
        $info['param']['payARPU'] = '付费ARPU';
        $info['param']['actARPU'] = '活跃ARPU';
        $info['param']['newpayARPU'] = '新玩家付费ARPU';
        $info['param']['newpayrate'] = '新增付费率';

        if ($info['total']['c'] > 0) {
            foreach ($info['list'] as $key => $val) {
                $info['lists'][$key]['id'] = $val['id'];
                $info['lists'][$key]['date'] = $val['date'];
                $info['lists'][$key]['reg'] = $val['reg'];
                $info['lists'][$key]['new_equipment'] = $val['new_equipment'];
                $info['lists'][$key]['active_login'] = $val['active_login'];
                $info['lists'][$key]['payer_num'] = $val['payer_num'];
                $info['lists'][$key]['new_payer_num'] = $val['new_payer_num'];
                $info['lists'][$key]['total_deposit_money'] = $val['total_deposit_money'] / 100;
                $info['lists'][$key]['new_deposit_money'] = $val['new_deposit_money'] / 100;
                if ($val['active_login']) {
                    $info['lists'][$key]['payrate'] = number_format($val['payer_num'] / $val['active_login'], 2, '.', '');//付费率：充值人数/总活跃
                    $info['lists'][$key]['actARPU'] = number_format(($val['total_deposit_money'] / 100) / $val['active_login'], 2, '.', '');//活跃arpu：公式=总充值/总活跃
                } else {
                    $info['lists'][$key]['payrate'] = 0;
                    $info['lists'][$key]['actARPU'] = 0;
                }
                if ($val['payer_num']) {
                    $info['lists'][$key]['payARPU'] = number_format(($val['total_deposit_money'] / 100) / $val['payer_num'], 2, '.', '');//付费arpu：公式=总充值/充值人数
                } else {
                    $info['lists'][$key]['payARPU'] = 0;
                }
                if ($val['new_payer_num']) {
                    $info['lists'][$key]['newpayARPU'] = number_format(($val['new_deposit_money'] / 100) / $val['new_payer_num'], 2, '.', '');//新增arpu=新增充值/新增充值人数
                } else {
                    $info['lists'][$key]['newpayARPU'] = 0;
                }
                if ($val['new_equipment']) {
                    $info['lists'][$key]['newpayrate'] = number_format($val['new_payer_num'] / $val['new_equipment'], 2, '.', '');//新增付费率=新增充值人数/新增用户数
                } else {
                    $info['lists'][$key]['newpayrate'] = 0;
                }


            }
        }
        if ($is_excel > 0) {
            $headerArray = array(
                '日期'
            );
            $headerArray[] = '注册人数';
            $headerArray[] = '新增设备';
            $headerArray[] = '活跃登录';
            $headerArray[] = '付费人数';
            $headerArray[] = '新增付费人数';
            $headerArray[] = '总充值';
            $headerArray[] = '新增玩家充值';
            $headerArray[] = '付费率';
            $headerArray[] = '付费ARPU';
            $headerArray[] = '活跃ARPU';
            $headerArray[] = '新玩家付费ARPU';
            $headerArray[] = '新增付费率';
            $excel_data = array();
            foreach ($info['lists'] as $key => $v) {
                $excel_data[$key]['date'] = $v['date'];
                $excel_data[$key]['reg'] = $v['reg'];
                $excel_data[$key]['new_equipment'] = $v['new_equipment'];
                $excel_data[$key]['active_login'] = $v['active_login'];
                $excel_data[$key]['payer_num'] = $v['payer_num'];
                $excel_data[$key]['new_payer_num'] = $v['new_payer_num'];
                $excel_data[$key]['total_deposit_money'] = '￥' . $v['total_deposit_money'];
                $excel_data[$key]['new_deposit_money'] = '￥' . $v['new_deposit_money'];
                $excel_data[$key]['payrate'] = ($v['payrate'] * 100) . '%';
                $excel_data[$key]['payARPU'] = '￥' . $v['payARPU'];
                $excel_data[$key]['actARPU'] = '￥' . $v['actARPU'];
                $excel_data[$key]['newpayARPU'] = '￥' . $v['newpayARPU'];
                $excel_data[$key]['newpayrate'] = ($v['newpayrate'] * 100) . '%';
            }

            $filename = $sdate . '—' . $edate . ' 新增数据查看';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        //按参数分类，制成折线图参数需要格式
        foreach ($info['lists'] as $val) {
            foreach ($val as $k => $v) {
                $info['temp'][$k][] = $v;
            }
        }

        $info['list'] = $info['lists'];
        $info['lists'] = $info['temp'];
        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        unset($info['temp']);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;
        return $info;
    }

    public function serverCondition($page, $parent_id, $game_id, $server_id, $sdate, $edate, $all, $is_excel = 0)
    {
        $page = $page < 1 ? 1 : $page;

        if ($sdate == '') {
            //$sdate = date('Y-m-01');
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info['sopenDay'] = '';
        $info = $this->mod->serverCondition($page, $parent_id, $game_id, $server_id, $sdate, $edate, $all, $is_excel);
        if ($server_id) {
            $server_open = $this->mod->getOpenServer($server_id);

            $srvAdData = new SrvAdData();
            $info['sopenDay'] = (int)($srvAdData->diffBetweenTwoDays(date('Y-m-d'), $server_open) + 1);

        }

        if ($info['total']['c'] > 0) {
            $data = array();
            if (!$server_id) {
                foreach ($info['list'] as $key => $val) {
                    $data[$val['date']][] = $val;
                }
                $i = 0;
                $temp = array();
                foreach ($data as $key => $val) {
                    foreach ($val as $k => $v) {
                        $temp[$i]['new_role'] += $v['new_role'];
                        $temp[$i]['dau_role'] += $v['dau_role'];
                        $temp[$i]['date'] = $v['date'];
                        $temp[$i]['new_pay_role'] += $v['new_pay_role'];
                        $temp[$i]['new_pay_money_role'] += $v['new_pay_money_role'];
                        $temp[$i]['pay_role'] += $v['pay_role'];
                        $temp[$i]['pay_money_role'] += $v['pay_money_role'];
                    }
                    $i++;
                }

                $info['list'] = $temp;

                unset($temp);
            }
            $total_cost = 0;
            foreach ($info['list'] as $key => $v) {

                $info['list'][$key]['new_pay_money_role'] = $v['new_pay_money_role'] / 100;
                $info['list'][$key]['pay_money_role'] = $v['pay_money_role'] / 100;
                $info['list'][$key]['old_user_active'] = $v['dau_role'] - $v['new_role'];

                if ($v['new_pay_role']) {
                    $info['list'][$key]['new_ARPPU'] = number_format(($v['new_pay_money_role'] / 100 / $v['new_pay_role']), 2, '.', '');
                } else {
                    $info['list'][$key]['new_ARPPU'] = 0;
                }
                if ($v['new_role']) {
                    $info['list'][$key]['new_pay_rate'] = number_format(($v['new_pay_role'] / $v['new_role']) * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['new_pay_rate'] = '0%';
                }
                if ($v['dau_role']) {
                    $info['list'][$key]['ARPU'] = number_format(($v['pay_money_role'] / 100) / $v['dau_role'], 2, '.', '');
                    $info['list'][$key]['pay_rate'] = number_format(($v['pay_role'] / $v['dau_role']) * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ARPU'] = 0;
                    $info['list'][$key]['pay_rate'] = '0%';
                }
                if ($v['pay_role']) {

                    $info['list'][$key]['ARPPU'] = number_format(($v['pay_money_role'] / 100) / $v['pay_role'], 2, '.', '');
                } else {

                    $info['list'][$key]['ARPPU'] = 0;
                }
            }
            if (!$server_id) {
                $count = count($info['list']);
                if ($count) {
                    $info['total']['avg_dau_role'] = number_format((int)$info['total']['all_dau_role'] / $count, 0, '.', '');
                    $info['total']['avg_pay_role'] = number_format((int)$info['total']['all_pay_role'] / $count, 2, '.', '');
                    $info['total']['avg_pay_money_role'] = number_format($info['total']['all_pay_money_role'] / $count, 2, '.', '');
                } else {
                    $info['total']['avg_dau_role'] = 0;
                    $info['total']['avg_pay_role'] = 0;
                    $info['total']['avg_pay_money_role'] = 0;
                }

            } else {
                $info['total']['avg_dau_role'] = number_format((int)$info['total']['avg_dau_role'], 0, '.', '');
            }

            $info['total']['all_new_pay_money_role'] = $info['total']['all_new_pay_money_role'] / 100;
            $info['total']['all_pay_money_role'] = $info['total']['all_pay_money_role'] / 100;
            $info['total']['all_old_user_active'] = $info['total']['all_dau_role'] - $info['total']['all_new_role'];

            if ($info['total']['avg_new_role']) {
                $info['total']['avg_new_pay_rate'] = number_format($info['total']['avg_new_pay_role'] / $info['total']['avg_new_role'] * 100, 2, '.', '') . '%';
            } else {
                $info['total']['avg_new_pay_rate'] = '0%';
            }
            if ($info['total']['avg_new_pay_role']) {
                $info['total']['avg_new_ARPPU'] = number_format($info['total']['avg_new_pay_money_role'] / 100 / $info['total']['avg_new_pay_role'], 2, '.', '');
            } else {
                $info['total']['avg_new_ARPPU'] = 0;
            }

            if ($info['total']['avg_dau_role']) {
                $info['total']['avg_pay_rate'] = number_format($info['total']['all_pay_role'] / $info['total']['all_dau_role'] * 100, 2, '.', '') . '%';
                $info['total']['avg_ARPU'] = number_format($info['total']['all_pay_money_role'] / $info['total']['all_dau_role'], 2, '.', '');
            } else {
                $info['total']['avg_pay_rate'] = '0%';
                $info['total']['avg_ARPU'] = 0;
            }
            if ($info['total']['avg_pay_role']) {
                $info['total']['avg_ARPPU'] = number_format($info['total']['all_pay_money_role'] / $info['total']['all_pay_role'], 2, '.', '');
            } else {
                $info['total']['avg_ARPPU'] = 0;
            }

        }
        // print_r($info);die;
        if ($is_excel > 0) {
            $headerArray = array(
                '时间', '游戏创角数', '老用户活跃', 'DAR', '新增付费角色数', '新增角色付费率', '新增ARPPR', '新增角色付费', '付费角色数', '角色付费率', 'ARPR', 'ARPPR', '总充值'
            );
            $excel_data = array();
            $excel_data[] = array('合计', $info['total']['all_new_role'], $info['total']['all_old_user_active'], $info['total']['avg_dau_role'], $info['total']['all_new_pay_role'], $info['total']['avg_new_pay_rate'], $info['total']['avg_new_ARPPU'], $info['total']['all_new_pay_money_role'], $info['total']['all_pay_role'], $info['total']['avg_pay_rate'], $info['total']['avg_ARPU'], $info['total']['avg_ARPPU'], $info['total']['all_pay_money_role']);
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['date'],
                    ' ' . $v['new_role'],
                    $v['old_user_active'],
                    $v['dau_role'],
                    $v['new_pay_role'],
                    $v['new_pay_rate'],
                    $v['new_ARPPU'],
                    $v['new_pay_money_role'],
                    $v['pay_role'],
                    $v['pay_rate'],
                    $v['ARPU'],
                    $v['ARPPU'],
                    $v['pay_money_role'],
                );
            }


            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            $server_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }

            if ($server_id) {
                $server = $this->getGameServer($game_id);
                $server_name = $server[$server_id];
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' ' . $server_name . ' ' . '分服总况';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excel_data
            );
        }
        if ($server_id) {
            $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
            $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        }


        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);

        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['server_id'] = $server_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;

        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id']);
        }

        return $info;
    }

    public function getMoneyLevel($game_id)
    {
        $info = $this->mod->getMoneyLevel($game_id);
        if ($game_id) {
            $money_level = array();
            foreach ($info as $r) {
                $money_level[$r['level_money']] = $r['level_money'] / 100;
            }
            return $money_level;
        }
        $money_level = array();
        if ($info['total'] > 0) {
            foreach ($info['list'] as $v) {
                $money_level[$v['level_money']] = $v['level_money'] / 100;
            }
        }
        return $money_level;
    }

    public function getGameServer($game_id)
    {
        if (!$game_id) {
            return array();
        }
        $info = $this->mod->getGameServer($game_id);
        $game_server = array();
        foreach ($info as $r) {
            $game_server[$r['server_id']] = $r['server_name'];
        }
        //get merge server
        $modPlatform = new ModPlatform();
        $merge_server = $modPlatform->gameServerMerge($game_id);
        $new_server = array();
        foreach ($game_server as $server_id => $server_name) {
            $new_server[$server_id] = $server_name;
            if ($merge_server[$server_id]) {
                if ($merge_server[$server_id] == $server_id) {
                    $new_server[$server_id] .= '(合)';
                } else {
                    $new_server[$server_id] .= '(合→' . $game_server[$merge_server[$server_id]] . ')';
                }
            }
        }
        return $new_server;
    }

    //批量获取服务器
    public function getGameServerBatch($game_id)
    {
        if (!$game_id) {
            return array();
        }
        $info = $this->mod->getGameServerBatch($game_id);
        $game_server = array();
        foreach ($info as $r) {
            $game_server[$r['server_id']] = $r['server_name'];
        }
        //get merge server
        $modPlatform = new ModPlatform();
        $merge_server = $modPlatform->gameServerMergeBatch($game_id);
        $new_server = array();
        foreach ($game_server as $server_id => $server_name) {
            $new_server[$server_id] = $server_name;
            if ($merge_server[$server_id]) {
                if ($merge_server[$server_id] == $server_id) {
                    $new_server[$server_id] .= '(合)';
                } else {
                    $new_server[$server_id] .= '(合→' . $game_server[$merge_server[$server_id]] . ')';
                }
            }
        }
        return $new_server;
    }

    public function overviewDay($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all, $sort_by, $sort_type, $user_id)
    {
        $page = $page < 1 ? 1 : $page;

        if ($sdate == '') {
            $sdate = date('Y-m-d');
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        if ($sort_by == '') {
            $sort_by = 'date';
        }
        if ($sort_type == '') {
            $sort_type = 'desc';
        }

        $info = $this->mod->overviewDay($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all, $sort_by, $sort_type, $user_id);

        if ($info['total']['c'] > 0) {
            $modExtend = new ModExtend();
            $modAd = new ModAd();
            foreach ($info['list'] as &$v) {
                $modExtend->getPages('', '', $v['package_name']);

                /*$monitor = $modExtend->getLinkInfo($v['monitor_id']);
                $v['code'] = $monitor['monitor_url'];
                if($v['code']){
                    $action = $modAd->getLandCodeToday($monitor['monitor_url'],$v['date']);
                    $v['_click'] = $action['click'] ? $action['click'] : 0;
                    $v['_visit'] = $action['visit'] ? $action['visit'] : 0;
                }*/
            }

            $ids = array();
            foreach ($info['lists'] as $v2) {
                $_a = $modExtend->getLinkInfo($v2['monitor_id']);
                $ids[] = $_a['monitor_url'];
            }
            $total = $modAd->getLandCodeTodayAll($ids, $sdate, $edate);
            $info['total']['_click'] = $total['_click'];
            $info['total']['_visit'] = $total['_visit'];

        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($package_name);
        $info['game_id'] = $game_id;
        $info['package_name'] = $package_name;
        $info['channel_id'] = $channel_id;
        $info['monitor_id'] = $monitor_id;
        $info['user_id'] = $user_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;
        $info['sort_by'] = $sort_by;
        $info['sort_type'] = $sort_type;
        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id']);
        }

        return $info;
    }

    public function overviewHour($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all)
    {
        $page = $page < 1 ? 1 : $page;

        if ($sdate == '') {
            $sdate = date('Y-m-d');
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $info = $this->mod->overviewHour($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($package_name);
        $info['game_id'] = $game_id;
        $info['package_name'] = $package_name;
        $info['channel_id'] = $channel_id;
        $info['monitor_id'] = $monitor_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;

        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id']);
        }

        return $info;
    }

    public function ltv($parent_id = 0, $game_id = 0, $device_type = 0, $sdate = '', $edate = '', $all = 0)
    {
        if ($sdate == '') {
            //$sdate = date('Y-m-01');
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $date = date('Y-m-d');
        $data = $total = [];
        $day = array(1, 2, 3, 4, 5, 6, 7, 15, 21, 30, 45, 60, 90);
        $info = $this->mod->ltv($day, $parent_id, $game_id, $device_type, $sdate, $edate, $all);
        foreach ($info as &$row) {
            $row['pay_rate'] = $row['pay_rate'] > 0 ? $row['pay_rate'] . '%' : '';

            foreach ($day as $d) {
                $row['ltv_reg' . $d] = $row['reg'];
                $arr = LibUtil::getDateFormat($row['date'], $date);
                if ($d > $arr['d']) {
                    $row['ltv' . $d] = 0;
                    $row['money' . $d] = 0;
                    $row['ltv_reg' . $d] = 0;
                }

                $total['ltv_reg' . $d] += $row['ltv_reg' . $d];
                $total['money' . $d] += $row['money' . $d];

                $row['ltv' . $d] = $row['ltv' . $d] > 0 ? $row['ltv' . $d] : '';
                $row['money' . $d] = $row['money' . $d] > 0 ? round($row['money' . $d] / 100, 2) : '';
            }

            $total['reg'] += $row['reg'];
            $total['pay_count'] += $row['pay_count'];
        }

        $total['pay_rate'] = round($total['pay_count'] / $total['reg'] * 100, 2) . '%';
        foreach ($day as $d) {
            $total['ltv' . $d] = round($total['money' . $d] / 100 / $total['ltv_reg' . $d], 2);
            $total['money' . $d] = round($total['money' . $d] / 100, 2);
        }

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($package_name);
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['package_name'] = $package_name;
        $data['device_type'] = $device_type;
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['all'] = $all;
        $data['day'] = $day;

        $data['list'] = $info;
        $data['total'] = $total;

        return $data;
    }

    public function retain($page, $game_id, $device_type, $sdate, $edate, $all, $is_excel = 0)
    {
        $page = $page < 1 ? 1 : $page;
        $default_date = date('Y-m-d', time() - 86400);
        if ($sdate == '') {
            $sdate = date('Y-m-01', time() - 86400);
        }
        if ($edate == '') {
            $edate = $default_date;
        }
        $srvPlatform = new SrvPlatform();
        $_games = $srvPlatform->getAllGame();
        $info = $this->mod->retain($page, $game_id, $device_type, $sdate, $edate, $all);

        if ($info['total']['c'] > 0) {
            foreach ($info['list'] as &$v) {
                $v['not_now_2'] = strtotime($v['date']) + 86400 * 1 > time() ? 1 : 0;
                $v['not_now_3'] = strtotime($v['date']) + 86400 * 2 > time() ? 1 : 0;
                $v['not_now_4'] = strtotime($v['date']) + 86400 * 3 > time() ? 1 : 0;
                $v['not_now_5'] = strtotime($v['date']) + 86400 * 4 > time() ? 1 : 0;
                $v['not_now_6'] = strtotime($v['date']) + 86400 * 5 > time() ? 1 : 0;
                $v['not_now_7'] = strtotime($v['date']) + 86400 * 6 > time() ? 1 : 0;
                $v['not_now_15'] = strtotime($v['date']) + 86400 * 14 > time() ? 1 : 0;
                $v['not_now_21'] = strtotime($v['date']) + 86400 * 20 > time() ? 1 : 0;
                $v['not_now_30'] = strtotime($v['date']) + 86400 * 29 > time() ? 1 : 0;
                $v['not_now_60'] = strtotime($v['date']) + 86400 * 59 > time() ? 1 : 0;
                $v['not_now_90'] = strtotime($v['date']) + 86400 * 89 > time() ? 1 : 0;
            }
        }
        //$info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(),$info['total']['c'],$page,DEFAULT_ADMIN_PAGE_NUM);
        //$info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        if ($is_excel > 0) {
            $headerArray = array(
                '日期', '游戏名称', '注册量', '次日留存', '3日留存', '4日留存', '5日留存', '6日留存', '7日留存', '15日留存', '21日留存', '30日留存', '60日留存', '90日留存'
            );
            $excel_data = array();
            $excel_data[] = array('合计', '', $info['total']['reg'], number_format($info['total']['retain2'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain3'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain4'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain5'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain6'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain7'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain15'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain21'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain30'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain60'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain90'] * 100 / $info['total']['reg'], 2, '.', '') . '%');

            foreach ($info['list'] as $val) {
                $excel_data[] = array(
                    ' ' . $val['date'],
                    ' ' . $_games[$val['game_id']],
                    $val['reg'],
                    !empty($val['not_now_2']) ? '-' : number_format($val['retain2'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_3']) ? '-' : number_format($val['retain3'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_4']) ? '-' : number_format($val['retain4'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_5']) ? '-' : number_format($val['retain5'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_6']) ? '-' : number_format($val['retain6'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_7']) ? '-' : number_format($val['retain7'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_15']) ? '-' : number_format($val['retain15'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_21']) ? '-' : number_format($val['retain21'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_30']) ? '-' : number_format($val['retain30'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_60']) ? '-' : number_format($val['retain60'] * 100 / $val['reg'], 2, '.', '') . '%', !empty($val['not_now_90']) ? '-' : number_format($val['retain90'] * 100 / $val['reg'], 2, '.', '') . '%'
                );
            }

            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            $server_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }


            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' ' . $server_name . ' ' . '留存数  ';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excel_data
            );
        }

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($package_name);
        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        //$info['package_name'] = $package_name;
        //$info['channel_id'] = $channel_id;
        //$info['monitor_id'] = $monitor_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;

        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id']);
        }

        return $info;
    }


    public function payHall($page = 0, $param = array())
    {
        $page = $page < 1 ? 1 : $page;

        $info = $this->mod->payHall($page, $param);
        $i = 1;
        foreach ($info['list'] as &$row) {
            $row['money'] = number_format($row['money'] / 100);
            $row['rank'] = $i + ($page - 1) * DEFAULT_ADMIN_PAGE_NUM;
            $i++;
        }
        $func = function($v){
            return (int)$v;
        };
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['query'] = $param;
        $info['game_id'] = array_map($func,$param['game_id']);
        $info['parent_id'] = array_map($func,$param['parent_id']);
        if ($info['game_id']) {
            $info['_servers'] = $this->getGameServerBatch($param['game_id']);
        }

        return $info;
    }

    /**
     * @return
     */
    public function payHallDownload($param = array())
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $data = array();
        $data[] = array(
            '排名', '金额', 'UID', '账号', '注册时间', '最后登录时间', '最后充值时间'
        );

        $info = $this->mod->payHall(0, $param);
        $i = 1;
        foreach ($info['list'] as &$row) {
            $data[] = array(
                $i,
                number_format($row['money'] / 100),
                $row['uid'],
                "\t" . $row['username'],
                $row['reg_time'],
                $row['last_login_time'],
                $row['last_pay_time']
            );

            $i++;
        }

        $file_path = '/uploads/' . date("ym") . '/download/' . LibUtil::token('download') . '/充值排行榜_' . date('Ymd') . '.csv';
        $url = APP_ALL_URL . $file_path;
        $file_dir = dirname(APP_ROOT . $file_path);
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0755, true);
        }

        $ret = LibUtil::write_to_csv(APP_ROOT . $file_path, $data, 'gbk');
        if (!$ret) {
            LibUtil::response('导出数据出错');
        }

        LibUtil::response('导出成功，请下载保存', 1, array('url' => $url));
    }

    public function payHallRole($data, $page)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->payHallRole($data, $page);
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $i = 1;
        if (is_array($info) && !empty($info['list'])) {
            foreach ($info['list'] as &$row) {
                $row['money'] = number_format($row['money'] / 100);
                $row['rank'] = $i + ($page - 1) * DEFAULT_ADMIN_PAGE_NUM;
                $row['reg_date'] = date('Y-m-d H:i:s', $row['reg_time']);
                $i++;
            }
        }
        $func = function($v){
            return (int)$v;
        };
        $info['game_id'] = array_map($func,$data['game_id']);
        $info['parent_id'] = array_map($func,$data['parent_id']);
        return $info;
    }

    public function getPutinByDay($page = 0, $parent_id = 0, $game_id = 0, $channel_id = 0, $sdate = '', $edate = '', $psdate = '', $pedate = '', $username = '')
    {
        $page = $page < 1 ? 1 : $page;
        $beforeday = date('Y-m-d', strtotime('-1 day'));
        $edate == '' && $edate = $beforeday;
        $sdate == '' && $sdate = $edate;
        $pedate == '' && $pedate = $beforeday;
        $psdate == '' && $psdate = $pedate;

        $info = [];
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['psdate'] = $psdate;
        $info['pedate'] = $pedate;
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['channel_id'] = $channel_id;

        return $info;
    }

    public function dataDay($sdate, $edate, $parent_id, $game_id, $channel_id, $user_id, $create_user)
    {
        $today = date('Y-m-d', strtotime('-1 day'));
        $sdate || $sdate = $today;
        $edate || $edate = $today;

        $total = [];
        $info = $this->mod->dataDay($sdate, $edate, $parent_id, $game_id, $channel_id, $user_id, $create_user);
        foreach ($info['list'] as &$row) {
            if ($sdate == $edate) {
                $row['date'] = $sdate;
            } else {
                $row['date'] = "$sdate - $edate";
            }
            $row['date'] = str_replace('-', '/', $row['date']);

            $row['cost'] = $row['cost'] / 100;
            $row['money'] = $row['money'] / 100;

            if ($row['display']) {
                //点击率
                $row['click_rate'] = bcdiv($row['click'] * 100, $row['display'], 2) . '%';
                //eCPM
                $row['ecpm_cost'] = '¥' . bcdiv($row['cost'], $row['display'] / 1000, 2);
                //每CPM激活数
                $row['active_cpm'] = '¥' . bcdiv($row['active'], $row['display'] / 1000, 2);
            }
            if ($row['click']) {
                //点击激活率
                $row['active_rate'] = bcdiv($row['active'] * 100, $row['click'], 2) . '%';
                //点击注册率
                $row['reg_rate'] = bcdiv($row['reg'] * 100, $row['click'], 2) . '%';
            }
            if ($row['active']) {
                //激活成本
                $row['active_cost'] = '¥' . bcdiv($row['cost'], $row['active'], 2);
                //激活注册率
                $row['active_reg_rate'] = bcdiv($row['reg'] * 100, $row['active'], 2) . '%';
            }
            if ($row['reg']) {
                //注册成本
                $row['reg_cost'] = '¥' . bcdiv($row['cost'], $row['reg'], 2);
                //创建率
                $row['new_role_rate'] = bcdiv($row['new_role'] * 100, $row['reg'], 2) . '%';
                //新增付费率
                $row['new_pay_rate'] = bcdiv($row['count_pay'] * 100, $row['reg'], 2) . '%';
                //首日LTV
                $row['new_ltv'] = '¥' . bcdiv($row['money'], $row['reg'], 2);
                //次日留存率
                $row['retain_rate'] = bcdiv($row['retain'] * 100, $row['reg'], 2) . '%';
            }
            if ($row['new_role']) {
                //创角成本
                $row['new_role_cost'] = '¥' . bcdiv($row['cost'], $row['new_role'], 2);
            }
            if ($row['cost']) {
                //新增ROI
                $row['new_roi_rate'] = bcdiv($row['money'] * 100, $row['cost'], 2) . '%';
            }
            if ($row['count_pay']) {
                //新增付费成本
                $row['pay_cost'] = '¥' . bcdiv($row['cost'], $row['count_pay'], 2);
            }
            if ($row['retain']) {
                //留存成本
                $row['retain_cost'] = '¥' . bcdiv($row['cost'], $row['retain'], 2);
            }

            $total['cost'] += $row['cost'];
            $total['display'] += $row['display'];
            $total['click'] += $row['click'];
            $total['active'] += $row['active'];
            $total['reg'] += $row['reg'];
            $total['retain'] += $row['retain'];
            $total['new_role'] += $row['new_role'];
            $total['money'] += $row['money'];
            $total['sum_pay'] += $row['sum_pay'];
            $total['count_pay'] += $row['count_pay'];
        }

        if ($total['display']) {
            //点击率
            $total['click_rate'] = bcdiv($total['click'] * 100, $total['display'], 2) . '%';
            //eCPM
            $total['ecpm_cost'] = '¥' . bcdiv($total['cost'], $total['display'] / 1000, 2);
            //每CPM激活数
            $total['active_cpm'] = '¥' . bcdiv($total['active'], $total['display'] / 1000, 2);
        }
        if ($total['click']) {
            //点击激活率
            $total['active_rate'] = bcdiv($total['active'] * 100, $total['click'], 2) . '%';
            //点击注册率
            $total['reg_rate'] = bcdiv($total['reg'] * 100, $total['click'], 2) . '%';
        }
        if ($total['active']) {
            //激活成本
            $total['active_cost'] = '¥' . bcdiv($total['cost'], $total['active'], 2);
            //激活注册率
            $total['active_reg_rate'] = bcdiv($total['reg'] * 100, $total['active'], 2) . '%';
        }
        if ($total['reg']) {
            //注册成本
            $total['reg_cost'] = '¥' . bcdiv($total['cost'], $total['reg'], 2);
            //创建率
            $total['new_role_rate'] = bcdiv($total['new_role'] * 100, $total['reg'], 2) . '%';
            //新增付费率
            $total['new_pay_rate'] = bcdiv($total['count_pay'] * 100, $total['reg'], 2) . '%';
            //首日LTV
            $total['new_ltv'] = '¥' . bcdiv($total['money'], $total['reg'], 2);
            //次日留存率
            $total['retain_rate'] = bcdiv($total['retain'] * 100, $total['reg'], 2) . '%';
        }
        if ($total['new_role']) {
            //创角成本
            $total['new_role_cost'] = '¥' . bcdiv($total['cost'], $total['new_role'], 2);
        }
        if ($total['cost']) {
            //新增ROI
            $total['new_roi_rate'] = bcdiv($total['money'] * 100, $total['cost'], 2) . '%';
        }
        if ($total['count_pay']) {
            //新增付费成本
            $total['pay_cost'] = '¥' . bcdiv($total['cost'], $total['count_pay'], 2);
        }
        if ($total['retain']) {
            //留存成本
            $total['retain_cost'] = '¥' . bcdiv($total['cost'], $total['retain'], 2);
        }

        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['game_id'] = $game_id;
        $info['channel_id'] = $channel_id;
        $info['user_id'] = $user_id;
        $info['create_user'] = $create_user;
        $info['users'] = $this->getUserByChannel($channel_id);
        $info['total'] = $total;

        return $info;
    }

    public function getUserByChannel($channel_id)
    {
        $SrvExtend = new SrvExtend();
        return $SrvExtend->getUserByChannel($channel_id);
    }

    public function getPayRetain($page, $paretn_id, $game_id, $channel_id, $device_type, $package_name, $sdate, $edate, $day, $has_cost)
    {
        $yesterday = date('Y-m-d', strtotime('yesterday'));
        if (!$sdate || !$edate) {
            $sdate = $edate = $yesterday;
        }
        if (!$device_type) {
            $device_type = 2;
        }

        $info = $this->mod->getPayRetain($page, $paretn_id, $game_id, $channel_id, $device_type, $package_name, $sdate, $edate, $has_cost);
        foreach ($info['list'] as &$row) {
            $_d = LibUtil::getDateFormat($row['date'], $yesterday);

            $row['cost'] = $row['cost'] / 100; //当日消耗
            $row['total_money'] = $row['total_money'] / 100; //累计至昨天充值金额
            foreach ($day as $d) {
                $row['money' . $d] = $row['money' . $d] / 100; //当日累计至$d日的充值金额

                if ($row['money' . $d] && $row['cost']) {
                    $row['roi' . $d] = bcdiv($row['money' . $d] * 100, $row['cost'], 2) . '%'; //当日累计至$d日的ROI
                } else {
                    $row['roi' . $d] = 0;
                }

                if ($row['money' . $d] && $row['reg']) {
                    $row['ltv' . $d] = bcdiv($row['money' . $d], $row['reg'], 2); //当日累计至$d日的LTV
                } else {
                    $row['ltv' . $d] = 0;
                }
            }

            $row['num_day'] = $_d['d']; //当日只昨天天数
            if ($row['reg']) {
                $row['reg_cost'] = bcdiv($row['cost'], $row['reg'], 2); //当日注册成本
            } else {
                $row['reg_cost'] = 0;
            }
            if ($row['total_money'] && $row['cost']) {
                $row['total_roi'] = bcdiv($row['total_money'] * 100, $row['cost'], 2) . '%'; //当日累计至昨天的ROI
            } else {
                $row['total_roi'] = 0;
            }
            if ($row['total_money'] && $row['reg']) {
                $row['total_ltv'] = bcdiv($row['total_money'], $row['reg'], 2); //当日累计至昨天的LTV
            } else {
                $row['total_ltv'] = 0;
            }
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['parent_id'] = $paretn_id;
        $info['game_id'] = $game_id;
        $info['channel_id'] = $channel_id;
        $info['device_type'] = $device_type;
        $info['package_name'] = $package_name;
        $info['has_cost'] = $has_cost;
        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id'], $info['channel_id'], $info['device_type']);
        }

        return $info;
    }

    public function channelHour($date, $parent_id, $game_id, $channel_id, $package_name, $user_id, $create_user)
    {
        $data = $total = [];
        $info = $this->mod->channelHour($date, $parent_id, $game_id, $channel_id, $package_name, $user_id, $create_user);
        foreach ($info as &$row) {
            $row['date'] = $date;
            $row['login'] = (int)$row['login'];
            $row['click'] = (int)$row['click'];
            $row['active'] = (int)$row['active'];
            $row['reg'] = (int)$row['reg'];
            $row['new_role'] = (int)$row['new_role'];
            $row['ney_pay'] = (int)$row['ney_pay'];
            $row['new_money'] /= 100;

            //点击激活率
            $row['active_rate'] = $row['click'] > 0 ? bcdiv($row['active'] * 100, $row['click'], 2) : 0;
            //点击注册率
            $row['reg_rate'] = $row['click'] > 0 ? bcdiv($row['reg'] * 100, $row['click'], 2) : 0;
            //激活注册率
            $row['active_reg_rate'] = $row['active'] > 0 ? bcdiv($row['reg'] * 100, $row['active'], 2) : 0;
            //创建率
            $row['new_role_rate'] = $row['reg'] > 0 ? bcdiv($row['new_role'] * 100, $row['reg'], 2) : 0;
            //新增付费率
            $row['new_pay_rate'] = $row['reg'] > 0 ? bcdiv($row['ney_pay'] * 100, $row['reg'], 2) : 0;
            //新增ARPU
            $row['new_arpu'] = $row['reg'] > 0 ? bcdiv($row['new_money'], $row['reg'], 2) : 0;
            //新增ARPPU
            $row['new_arppu'] = $row['ney_pay'] > 0 ? bcdiv($row['new_money'], $row['ney_pay'], 2) : 0;

            $total['login'] += $row['login'];
            $total['click'] += $row['click'];
            $total['active'] += $row['active'];
            $total['reg'] += $row['reg'];
            $total['new_role'] += $row['new_role'];
            $total['ney_pay'] += $row['ney_pay'];
            $total['new_money'] += $row['new_money'];
        }

        //点击激活率
        $total['active_rate'] = $total['click'] > 0 ? bcdiv($total['active'] * 100, $total['click'], 2) : 0;
        //点击注册率
        $total['reg_rate'] = $total['click'] > 0 ? bcdiv($total['reg'] * 100, $total['click'], 2) : 0;
        //激活注册率
        $total['active_reg_rate'] = $total['active'] > 0 ? bcdiv($total['reg'] * 100, $total['active'], 2) : 0;
        //创建率
        $total['new_role_rate'] = $total['reg'] > 0 ? bcdiv($total['new_role'] * 100, $total['reg'], 2) : 0;
        //新增付费率
        $total['new_pay_rate'] = $total['reg'] > 0 ? bcdiv($total['ney_pay'] * 100, $total['reg'], 2) : 0;
        //新增ARPU
        $total['new_arpu'] = $total['reg'] > 0 ? bcdiv($total['new_money'], $total['reg'], 2) : 0;
        //新增ARPPU
        $total['new_arppu'] = $total['ney_pay'] > 0 ? bcdiv($total['new_money'], $total['ney_pay'], 2) : 0;

        $data['list'] = $info;
        $data['total'] = $total;
        $data['date'] = $date;
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['channel_id'] = $channel_id;
        $data['package_name'] = $package_name;
        $data['user_id'] = $user_id;
        $data['create_user'] = $create_user;
        if ($game_id > 0) {
            $modPlatform = new ModPlatform();
            $data['_packages'] = $modPlatform->getPackageByGame($game_id, $channel_id);
        }
        if ($channel_id > 0) {
            $data['users'] = $this->getUserByChannel($channel_id);
        }

        return $data;
    }

    public function channelDay($date, $parent_id, $game_id, $channel_id, $package_name, $user_id, $create_user)
    {
        $data = $total = [];
        $info = $this->mod->channelDay($date, $parent_id, $game_id, $channel_id, $package_name, $user_id, $create_user);
        foreach ($info as &$row) {
            $row['date'] = $date;
            $row['login'] = (int)$row['login'];
            $row['click'] = (int)$row['click'];
            $row['active'] = (int)$row['active'];
            $row['reg'] = (int)$row['reg'];
            $row['new_role'] = (int)$row['new_role'];
            //总充值
            $row['total_pay'] = $row['interval_pay'] + $row['ney_pay'];
            $row['total_money'] = ($row['interval_money'] + $row['new_money']) / 100;
            //区间充值
            $row['interval_pay'] = $row['interval_pay'] - $row['old_pay'];
            $row['interval_money'] = ($row['interval_money'] - $row['old_money']) / 100;
            //老用户新增
            $row['old_pay'] = (int)$row['old_pay'];
            $row['old_money'] /= 100;
            //新增充值
            $row['ney_pay'] = (int)$row['ney_pay'];
            $row['new_money'] /= 100;

            //点击激活率
            $row['active_rate'] = $row['click'] > 0 ? bcdiv($row['active'] * 100, $row['click'], 2) : 0;
            //点击注册率
            $row['reg_rate'] = $row['click'] > 0 ? bcdiv($row['reg'] * 100, $row['click'], 2) : 0;
            //激活注册率
            $row['active_reg_rate'] = $row['active'] > 0 ? bcdiv($row['reg'] * 100, $row['active'], 2) : 0;
            //创建率
            $row['new_role_rate'] = $row['reg'] > 0 ? bcdiv($row['new_role'] * 100, $row['reg'], 2) : 0;
            //新增付费率
            $row['new_pay_rate'] = $row['reg'] > 0 ? bcdiv($row['ney_pay'] * 100, $row['reg'], 2) : 0;
            //新增ARPU
            $row['new_arpu'] = $row['reg'] > 0 ? bcdiv($row['new_money'], $row['reg'], 2) : 0;
            //新增ARPPU
            $row['new_arppu'] = $row['ney_pay'] > 0 ? bcdiv($row['new_money'], $row['ney_pay'], 2) : 0;
            //区间付费率
            $row['interval_pay_rate'] = ($row['login'] - $row['reg']) > 0 ? bcdiv($row['interval_pay'] * 100, $row['login'] - $row['reg'], 2) : 0;

            $total['login'] += $row['login'];
            $total['click'] += $row['click'];
            $total['active'] += $row['active'];
            $total['reg'] += $row['reg'];
            $total['new_role'] += $row['new_role'];
            $total['ney_pay'] += $row['ney_pay'];
            $total['new_money'] += $row['new_money'];
            $total['total_pay'] += $row['total_pay'];
            $total['total_money'] += $row['total_money'];
            $total['interval_pay'] += $row['interval_pay'];
            $total['interval_money'] += $row['interval_money'];
            $total['old_pay'] += $row['old_pay'];
            $total['old_money'] += $row['old_money'];
        }

        //点击激活率
        $total['active_rate'] = $total['click'] > 0 ? bcdiv($total['active'] * 100, $total['click'], 2) : 0;
        //点击注册率
        $total['reg_rate'] = $total['click'] > 0 ? bcdiv($total['reg'] * 100, $total['click'], 2) : 0;
        //激活注册率
        $total['active_reg_rate'] = $total['active'] > 0 ? bcdiv($total['reg'] * 100, $total['active'], 2) : 0;
        //创建率
        $total['new_role_rate'] = $total['reg'] > 0 ? bcdiv($total['new_role'] * 100, $total['reg'], 2) : 0;
        //新增付费率
        $total['new_pay_rate'] = $total['reg'] > 0 ? bcdiv($total['ney_pay'] * 100, $total['reg'], 2) : 0;
        //新增ARPU
        $total['new_arpu'] = $total['reg'] > 0 ? bcdiv($total['new_money'], $total['reg'], 2) : 0;
        //新增ARPPU
        $total['new_arppu'] = $total['ney_pay'] > 0 ? bcdiv($total['new_money'], $total['ney_pay'], 2) : 0;
        //区间付费率
        $total['interval_pay_rate'] = ($total['login'] - $total['reg']) > 0 ? bcdiv($total['interval_pay'] * 100, $total['login'] - $total['reg'], 2) : 0;

        $data['list'] = $info;
        $data['total'] = $total;
        $data['date'] = $date;
        $data['game_id'] = $game_id;
        $data['channel_id'] = $channel_id;
        $data['package_name'] = $package_name;
        $data['user_id'] = $user_id;
        $data['create_user'] = $create_user;
        if ($game_id > 0) {
            $modPlatform = new ModPlatform();
            $data['_packages'] = $modPlatform->getPackageByGame($game_id, $channel_id);
        }
        if ($channel_id > 0) {
            $data['users'] = $this->getUserByChannel($channel_id);
        }

        return $data;
    }

    /**
     * 更新用户总充值
     * @return array
     */
    public function updateUserPayTotal()
    {
        $c = 0;
        $t = 0;
        $info = $this->mod->getUserPayTotal();
        foreach ($info as $row) {
            $data = array(
                'uid' => $row['uid'],
                'total_pay_money' => $row['total_pay_money'],
                'total_pay_num' => $row['total_pay_num'],
            );
            $ret = $this->mod->updateUserPayTotal($data);
            if ($ret) {
                $cache_key = LibRedis::$prefix_sdk_user . $row['uid'];
                $user = LibRedis::get($cache_key);
                if (empty($user)) {
                    $user = [];
                }

                $user['total_pay_money'] = $row['total_pay_money'];
                $user['total_pay_num'] = $row['total_pay_num'];
                LibRedis::set($cache_key, $user);

                $c++;
            }
            $t++;
        }

        return array('state' => true, 'msg' => "更新成功，共更新{$t}条，成功{$c}条");
    }

    /**
     * 实时在线
     * @return array
     */
    public function online()
    {
        $ip = LibUtil::getIp();
        $online = 0;
        $data = $games = $channels = [];

        //连接创玩SDK注册端口
        if ($ip != '127.0.0.1') {
            Gateway::$registerAddress = '127.0.0.1:1238';
            $data = Gateway::getAllClientSessions();
        }

        foreach ($data as $row) {
            $arr = $row['data'];
            if (empty($arr) || empty($arr['game_id'])) {
                continue;
            }

            $games[$arr['game_id']] += 1;
            $channels[$arr['channel_id']] += 1;

            $online += 1;
        }

        return array(
            'online' => $online,
            'games' => $games,
            'channels' => $channels
        );
    }

    /**
     * LTV
     * @param array $param
     * @param bool $is_cost
     * @return array
     */
    public function ltvNew($param = [], $is_cost = false)
    {
        $rsdate = trim($param['rsdate']);
        $redate = trim($param['redate']);
        $type = (int)$param['type'];
        $parent_id = $param['parent_id'];
        $children_id = $param['children_id'];
        $device_type = (int)$param['device_type'];
        $channel_id = $param['channel_id'];
        $user_id = $param['user_id'];
        $monitor_id = $param['monitor_id'];
        $group_id = $param['group_id'];
        $type > 0 || $type = 7;

        $is_post = true;
        $date = date('Y-m-d');
        if (!$rsdate && !$redate) {
            $redate = $date;
            $rsdate = date('Y-m-d', strtotime('-1 month'));
            $is_post = false;
        }

        $d = LibUtil::getDateFormat($rsdate, $redate);
        $rsdate = $d['s'];
        $redate = $d['e'];

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $srvAdData = new SrvAdData();

        $allChannel = $srvAd->getAllChannel();
        ksort($allChannel);

        $games_data = $srvPlatform->getAllGame(true);
        $games = $games_data['list'];

        $groups = [];
        $tmp = $srvAd->getAllDeliveryGroup();
        foreach ($tmp as $v) {
            $groups[$v['group_id']] = $v['group_name'];
        }

        $day = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 75, 90, 105, 120, 135, 150, 165, 180);
        $data = $total = [];
        $data['day'] = $day;
        $data['games'] = $games_data;
        $data['_channels'] = $allChannel;
        $data['_groups'] = $groups;
        $data['rsdate'] = $rsdate;
        $data['redate'] = $redate;
        $data['type'] = $type;
        $data['parent_id'] = $parent_id;
        $data['children_id'] = $children_id;
        $data['device_type'] = $device_type;
        $data['channel_id'] = $channel_id;
        $data['user_id'] = $user_id;
        $data['monitor_id'] = $monitor_id;
        $data['group_id'] = $group_id;

        if (!$is_post) {
            return $data;
        }

        $monitor = $srvAd->getAllMonitor($children_id, $channel_id);
        $userlist = $srvAdData->getAllChannelUser($channel_id);

        $data['_monitors'] = $monitor;
        $data['_users'] = $userlist;

        if ($is_cost) {
            $info = $this->mod->ltvNew2($day, $rsdate, $redate, $type, $parent_id, $children_id, $device_type);
        } else {
            $info = $this->mod->ltvNew1($day, $rsdate, $redate, $type, $parent_id, $children_id, $device_type, $channel_id, $user_id, $monitor_id, $group_id);
        }

        foreach ($info as &$row) {
            $row['cost'] /= 100;
            $row['reg_cost'] = ($row['cost'] > 0 && $row['reg'] > 0) ? round($row['cost'] / $row['reg'], 2) : '';
            foreach ($day as $d) {
                $row['ltv_reg' . $d] = $row['reg'];
                $row['ltv' . $d] = $row['reg'] > 0 && $row['ltv_money' . $d] > 0 ? round($row['ltv_money' . $d] / 100 / $row['reg'], 2) : '';

                //按注册日期归类
                if ($type == 7) {
                    $arr = LibUtil::getDateFormat($row['group_name'], $date);
                    if ($d > $arr['d']) {
                        $row['ltv' . $d] = 0;
                        $row['ltv_money' . $d] = 0;
                        $row['ltv_reg' . $d] = 0;
                    }
                }

                $row['ltv' . $d] || $row['ltv' . $d] = '';
            }

            //合计
            foreach ($row as $key => $val) {
                if ($key == 'group_name') {
                    continue;
                }
                $total[$key] += (float)$val;
            }

            $row['field'] = $row['group_name'];
            switch ($type) {
                case 1:
                case 8:
                    $row['group_name'] = $games[$row['group_name']];
                    break;
                case 2:
                    $row['group_name'] = $row['group_name'] == 1 ? 'IOS' : ($row['group_name'] == 2 ? 'ANDROID' : '-');
                    break;
                case 3:
                    $row['group_name'] = $allChannel[$row['group_name']];
                    break;
                case 4:
                    $row['group_name'] = $userlist[$row['group_name']];
                    break;
                case 5:
                    $row['group_name'] = $monitor[$row['group_name']];
                    break;
                case 6:
                    $row['group_name'] = $groups[$row['group_name']];
                    break;
                case 10:
                    $yearWeek = explode('-', $row['group_name']);
                    $weekDay = LibUtil::weekStartEnd($yearWeek[0], $yearWeek[1]);
                    $row['group_name'] = date('Y-m-d', $weekDay['start']) . " - " . date('Y-m-d', $weekDay['end']);
                    break;
            }

            if (empty($row['group_name'])) {
                $row['group_name'] = '-';
            }
        }

        $total['reg_cost'] = ($total['cost'] > 0 && $total['reg'] > 0) ? round($total['cost'] / $total['reg'], 2) : '';
        foreach ($day as $d) {
            $total['ltv' . $d] = $total['ltv_reg' . $d] > 0 && $total['ltv_money' . $d] > 0 ? round($total['ltv_money' . $d] / 100 / $total['ltv_reg' . $d], 2) : '';
            $total['ltv' . $d] || $total['ltv' . $d] = '';
        }

        $data['list'] = $info;
        $data['total'] = $total;

        return $data;
    }

    public function roi($param = [], $day = [])
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = trim($param['sdate']);
        $edate = trim($param['edate']);
        $type = empty($param['type']) ? '7' : (int)$param['type'];
        if ($sdate == '') {
            //$sdate = date('Y-m-01');
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $total = [];
        $date = date('Y-m-d');
        $info = $this->mod->roi($parent_id, $game_id, $device_type, $sdate, $edate, $day, $type);
        $games = (new SrvPlatform())->getAllGame(false);
        foreach ($info as &$row) {
            foreach ($day as $d) {
                $row['roi_cost' . $d] = $row['cost'];
                $roi = $row['cost'] > 0 ? round($row['roi_money' . $d] / $row['cost'] * 100, 2) : '';
                $row['roi' . $d] = !empty($roi) ? $roi . '%' : '';
                if ($type == 7 || $type == 9 || $type == 10) {
                    //$queDay = $type == 7 ? $row['group_name'] : date('Y-m-01', strtotime($row['group_name']));
                    $queDay = LibUtil::nearDate($type, $row['group_name']);
                    $arr = LibUtil::getDateFormat($queDay, $date);
                    if (isset($arr) && $d > $arr['d']) {
                        $row['roi_money' . $d] = 0;
                        $row['roi_cost' . $d] = 0;
                        $row['roi' . $d] = '';
                    }
                }

            }
            //合计
            foreach ($row as $key => $val) {
                if ($key == 'group_name' || $key == 'reg_date') {
                    continue;
                }
                $total[$key] += (float)$val;
            }

            switch ($type) {
                case 1:
                case 8:
                    $row['group_name'] = $games[$row['group_name']];
                    break;
                case 2:
                    $row['group_name'] = $row['group_name'] == 1 ? 'IOS' : ($row['group_name'] == 2 ? 'ANDROID' : '-');
                    break;
                case 10:
                    $yearWeek = explode('-', $row['group_name']);
                    $weekDay = LibUtil::weekStartEnd($yearWeek[0], $yearWeek[1]);
                    $row['group_name'] = date('Y-m-d', $weekDay['start']) . " - " . date('Y-m-d', $weekDay['end']);
                    break;
                default:
                    break;
            }

            $row['money'] = $row['money'] / 100;
            $cost = $row['cost'] / 100;
            $money = $row['money'];
            $row['cost'] = number_format($row['cost'] / 100, 2);
            $row['reg_cost'] = ($cost > 0 && $row['reg'] > 0) ? round($cost / $row['reg'], 2) : '';
            $ky = $cost == 0 ? 0 : ($money - $cost);
            $reRoi = $cost > 0 ? round($row['money'] / $cost * 100, 2) : 0;
            $row['re_roi_sort'] = $reRoi;
            $row['re_roi'] = $reRoi > 0 ? $reRoi . "%" : 0;
            $row['ky'] = $ky;
            $revenue = number_format($ky);
            $revenue = $ky > 0 ? $revenue : ($ky == 0 ? '0' : $revenue);
            $row['revenue'] = $revenue;
            $row['money'] = number_format($row['money']);
        }

        foreach ($day as $d) {
            $total['roi' . $d] = $total['roi_cost' . $d] > 0 ? round($total['roi_money' . $d] / $total['roi_cost' . $d] * 100, 2) . '%' : '';
        }
        $total['reg_cost'] = $total['reg'] > 0 ? round(($total['cost'] / 100) / $total['reg'], 2) : '';
        $total['ky'] = $total['money'] - $total['cost'];
        $total['revenue'] = $total['ky'] > 0 ? number_format($total['ky'] / 100, 2) :
            number_format($total['ky'] / 100, 2);
        $total['re_roi'] = $total['cost'] > 0 ? number_format($total['money'] / $total['cost'] * 100, 2) . "%" : 0;
        $total['cost'] = number_format($total['cost'] / 100, 2);
        $total['money'] = number_format($total['money'] / 100, 2);

        if ($type <= 0) {
            $info['type'] = 7;
        }
        $query = array(
            'sdate' => $sdate,
            'edate' => $edate
        );
        return array('list' => $info, 'total' => $total, 'query' => $query);
    }

    /**
     * 按天每小时充值
     * @param $param
     * @param $day
     * @return array
     */
    public function payHour($param, $day)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = $param['sdate'];
        $edate = $param['edate'];
        $now = date('Y-m-d');

        $sdate || $sdate = date('Y-m-d', strtotime('-7 days'));
        $edate || $edate = $now;

        $info = $this->mod->payHour($parent_id, $game_id, $device_type, $sdate, $edate);
        $list = $data = $series = $total = [];
        foreach ($info as $row) {
            $data[$row['day']][$row['hour']] = round($row['money'] / 100);
        }

        if (!empty($data)) {
            foreach ($data as $d => $row) {
                $tmp1 = $tmp2 = [];

                $tmp2['date'] = $d;
                foreach ($day as $hour) {
                    $val = (int)$row[$hour];

                    $tmp1[] = $val;

                    $tmp2[$hour] = $val > 0 ? number_format($val) : '';
                    $tmp2['total'] += $val;

                    $total[$hour] += $val;
                }

                $total['total'] += $tmp2['total'];
                $tmp2['total'] = $tmp2['total'] > 0 ? number_format($tmp2['total']) : '';
                $list[] = $tmp2;

                $series[] = array(
                    'id' => $d,
                    'name' => $d,
                    'data' => $tmp1
                );
            }

            foreach ($total as &$val) {
                $val = $val > 0 ? number_format($val) : '';
            }
        }

        return array(
            'data' => $list,
            'total' => $total,
            'sdate' => $sdate,
            'edate' => $edate,
            'series' => $series
        );
    }

    public function onlineHour($param = [])
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '1G');

        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $interval = (int)$param['interval'];
        $sdate = trim($param['sdate']);
        $edate = trim($param['edate']);

        $now = date('Y-m-d');
        $sdate || $sdate = $now;
        $edate || $edate = $now;
        $interval > 0 || $interval = 5;

        $games = LibUtil::config('games');
        $info = $this->mod->onlineHour($parent_id, $game_id, $device_type, $interval, $sdate, $edate);
        $data = $total = $temp1 = $temp2 = [];
        foreach ($info as $row) {
            $online = (int)$row['online'];
            //$time = $row['date'] . ' ' . $row['minute'];
            $time = $row['dataStartTime'];
            $data[$row['game_id']][] = array('name' => $time, 'value' => array($time, $online));
            $temp1[$time] += $online;
            $temp2[$row['game_id']] += $online;
        }

        //排序
        arsort($temp2);
        $sort_games = array_keys($temp2);

        foreach ($temp1 as $key => $value) {
            $total[] = array('name' => $key, 'value' => array($key, $value));
        }

        return array(
            'data' => $data,
            'total' => $total,
            'games' => $games,
            'sort' => $sort_games,
            'query' => array(
                'parent_id' => $parent_id,
                'game_id' => $game_id,
                'device_type' => $device_type,
                'interval' => $interval,
                'sdate' => $sdate,
                'edate' => $edate
            )
        );
    }

    public function external($parent_id, $game_id, $device_type, $sdate, $edate, $type)
    {
        $data = [];
        $today = date('Y-m-d');
        $srvExtend = new SrvExtend();
        $discount = $srvExtend->getAdDiscountAll();

        if (!$sdate) {
            $sdate = $today;
        }
        if (!$edate) {
            $edate = $today;
        }

        if ($edate >= $today) {
            $todayData = $this->mod->getDiscountToday($parent_id, $game_id, $device_type);
            foreach ($todayData as $row) {
                $monitor_id = (int)$row['monitor_id'];
                if ($monitor_id <= 0) {
                    continue;
                }

                $config = (array)$discount[$monitor_id];

                //扣量开关，而且在扣量日期范围内
                if ((int)$config['is_discount'] && $row['date'] >= $config['discount_sdate'] && $row['date'] <= $config['discount_edate']) {
                    //注册扣量配置存在
                    if ($config['discount_reg'] > 0) {
                        //激活设备数扣量
                        if ((int)$row['active_device'] > 1) {
                            $row['active_device'] = ceil($row['active_device'] * $config['discount_reg'] / 100);
                        }
                        //注册设备数扣量
                        if ((int)$row['reg_device'] > 1) {
                            $row['reg_device'] = ceil($row['reg_device'] * $config['discount_reg'] / 100);
                        }
                    }

                    //充值扣量配置存在，而且充值大于1笔才扣量充值，最小金额大于6元
                    if ($config['discount_pay'] > 0 && (int)$row['pay_sum'] > 1 && $row['money'] > 600) {
                        $row['money'] = ceil($row['money'] * $config['discount_pay'] / 100);
                    }
                }

                $data[] = array(
                    'date' => $row['date'],
                    'monitor_id' => $monitor_id,
                    'monitor_name' => $row['monitor_name'],
                    'active_device' => $row['active_device'],
                    'reg_device' => $row['reg_device'],
                    'money' => $row['money']
                );
            }
        }

        $info = [];
        if ($sdate < $today) {
            $info = $this->mod->external($parent_id, $game_id, $device_type, $sdate, $edate);
        }

        $result = $total = [];
        $tmp = array_merge($data, $info);
        foreach ($tmp as $row) {
            $monitor_id = (int)$row['monitor_id'];
            $config = (array)$discount[$monitor_id];

            //不在投放范围内
            if (!empty($config) && (!(int)$config['is_open'] || $row['date'] < $config['open_sdate'] || $row['date'] > $config['open_edate'])) {
                continue;
            }

            $row['money'] /= 100; //元
            if ($type == 1) { //按日期显示
                $result[$row['date']]['group_name'] = $row['date'];
                $result[$row['date']]['active_device'] += $row['active_device'];
                $result[$row['date']]['reg_device'] += $row['reg_device'];
                $result[$row['date']]['money'] += $row['money'];
            } else { //按推广链显示
                $result[$row['monitor_id']]['group_name'] = $row['monitor_name'];
                $result[$row['monitor_id']]['active_device'] += $row['active_device'];
                $result[$row['monitor_id']]['reg_device'] += $row['reg_device'];
                $result[$row['monitor_id']]['money'] += $row['money'];
            }

            $total['active_device'] += $row['active_device'];
            $total['reg_device'] += $row['reg_device'];
            $total['money'] += $row['money'];
        }
        return array(
            'list' => $result,
            'total' => $total,
            'parent_id' => $parent_id,
            'game_id' => $game_id,
            'device_type' => $device_type,
            'sdate' => $sdate,
            'edate' => $edate,
            'type' => $type
        );
    }

    /**
     * @param array $data
     * @return array
     */
    public function payHallRoleDownload($param)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');
        $info = $this->mod->payHallRole($param, 0);
        $games = (new SrvPlatform())->getAllGame(false);
        $data = array();
        $data[] = array(
            '排名', 'UID', '账号', '母游戏', '子游戏', '平台', '服务器ID', '角色名称', '角色ID', '角色等级', '充值金额'
        );

        $i = 1;

        foreach ($info['list'] as &$row) {
            $device_name = $row['device_type'] == 1 ? 'IOS' : ($row['device_type'] == 2 ? '安卓' : '其他');
            $data[] = array(
                $i,
                $row['uid'],
                "\t" . $row['username'],
                $games[$row['parent_id']],
                $games[$row['game_id']],
                $device_name,
                $row['server_id'],
                $row['role_name'],
                $row['role_id'],
                $row['role_level'],
                number_format($row['money'] / 100)
            );
            $i++;
        }
        $file_path = '/uploads/' . date("ym") . '/download/' . LibUtil::token('download') . '/角色充值排行榜_' . date('Ymd') . '.csv';
        $url = APP_ALL_URL . $file_path;
        $file_dir = dirname(APP_ROOT . $file_path);
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0755, true);
        }

        $ret = LibUtil::write_to_csv(APP_ROOT . $file_path, $data, 'gbk');
        if (!$ret) {
            LibUtil::response('导出数据出错');
        }

        LibUtil::response('导出成功，请下载保存', 1, array('url' => $url));
    }

    /**
     * ASO联运数据
     * @param int $parent_id
     * @param int $game_id
     * @param int $device_type
     * @param string $sdate
     * @param string $edate
     * @param int $type
     * @return array
     */
    public function externalAso($parent_id, $game_id, $device_type, $sdate, $edate, $type)
    {
        $data = [];
        $today = date('Y-m-d');
        $srvExtend = new SrvExtend();
        $discount = $srvExtend->getAsoDiscountAll();

        if (!$sdate) {
            $sdate = $today;
        }
        if (!$edate) {
            $edate = $today;
        }

        if ($edate >= $today) {
            $todayData = $this->mod->getAsoDiscountToday($parent_id, $game_id, $device_type);
            foreach ($todayData as $row) {
                $gameId = (int)$row['game_id'];
                if ($gameId <= 0) {
                    continue;
                }

                $config = (array)$discount[$gameId];

                //扣量开关，而且在扣量日期范围内
                if ((int)$config['is_discount'] && $row['date'] >= $config['discount_sdate'] && $row['date'] <= $config['discount_edate']) {
                    //注册扣量配置存在
                    if ($config['discount_reg'] > 0) {
                        //激活设备数扣量
                        if ((int)$row['active_device'] > 1) {
                            $row['active_device'] = ceil($row['active_device'] * $config['discount_reg'] / 100);
                        }
                        //注册设备数扣量
                        if ((int)$row['reg_device'] > 1) {
                            $row['reg_device'] = ceil($row['reg_device'] * $config['discount_reg'] / 100);
                        }
                    }

                    //充值扣量配置存在，而且充值大于1笔才扣量充值，最小金额大于6元
                    if ($config['discount_pay'] > 0 && (int)$row['pay_sum'] > 1 && $row['money'] > 600) {
                        $row['money'] = ceil($row['money'] * $config['discount_pay'] / 100);
                    }
                }

                $data[] = array(
                    'date' => $row['date'],
                    'game_id' => $gameId,
                    'game_name' => $row['game_name'],
                    'active_device' => $row['active_device'],
                    'reg_device' => $row['reg_device'],
                    'money' => $row['money']
                );
            }
        }
        unset($gameId);
        $info = [];
        if ($sdate < $today) {
            $info = $this->mod->externalAso($parent_id, $game_id, $device_type, $sdate, $edate);
        }
        $result = $total = [];
        $tmp = array_merge($data, $info);
        foreach ($tmp as $row) {
            $gameId = (int)$row['game_id'];
            $config = (array)$discount[$gameId];

            //不在投放范围内
            if (!empty($config) && (!(int)$config['is_open'] || $row['date'] < $config['open_sdate'] || $row['date'] > $config['open_edate'])) {
                continue;
            }

            $row['money'] /= 100; //元
            if ($type == 1) { //按日期显示
                $result[$row['date']]['group_name'] = $row['date'];
                $result[$row['date']]['active_device'] += $row['active_device'];
                $result[$row['date']]['reg_device'] += $row['reg_device'];
                $result[$row['date']]['money'] += $row['money'];
            } else { //按推广链显示
                $result[$row['game_id']]['group_name'] = $row['game_name'];
                $result[$row['game_id']]['active_device'] += $row['active_device'];
                $result[$row['game_id']]['reg_device'] += $row['reg_device'];
                $result[$row['game_id']]['money'] += $row['money'];
            }
            krsort($result);
            $total['active_device'] += $row['active_device'];
            $total['reg_device'] += $row['reg_device'];
            $total['money'] += $row['money'];
        }
        return array(
            'list' => $result,
            'total' => $total,
            'parent_id' => $parent_id,
            'game_id' => $game_id,
            'device_type' => $device_type,
            'sdate' => $sdate,
            'edate' => $edate,
            'type' => $type
        );
    }

    /**
     * 获取分服充值数据
     * @param array $parent_id
     * @param array $game_id
     * @param int $device_type
     * @param int $server_start
     * @param int $server_end
     * @param string $sdate
     * @param string $edate
     * @param int $page
     * @return array
     */
    public function getServerView($parent_id, $game_id, $device_type, $type, $server_start, $server_end, $sdate, $edate, $page)
    {
        $page = $page < 0 ? 1 : $page;

        ///获取最新的七个服务器
        if (empty($server_start) && empty($server_end)) {
            $serverList = $this->mod->fetchServer($server_start, $server_end);
            $serverList = array_keys($serverList);

            $server_start = array_pop($serverList);
            $server_end = array_shift($serverList);
        }

        if (!$sdate) {
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if (!$edate) {
            $edate = date('Y-m-d');
        }

        $info = $this->mod->fetchServerView($parent_id, $game_id, $device_type, $type, $server_start, $server_end, $sdate, $edate, $page);
        $list = $serverList = $total = array();
        foreach ($info['data'] as $row) {
            $temp = [];
            $temp['pay_num'] = $row['pay_num'];
            $temp['pay_money'] = $row['pay_money'];
            $list[$row['pay_date']][$row['server_id']][$row['user_type']] = $temp;
            array_push($serverList, $row['server_id']);
        }

        foreach ($list as &$dateRow) {
            foreach ($dateRow as $server_id => &$serverRow) {
                $totalInfo = [];
                $newPay = isset($serverRow[1]) ? $serverRow[1] : [];
                $newPayNum = empty($newPay) ? 0 : (int)$newPay['pay_num'];
                $newPayMoney = empty($newPay) ? 0 : (int)$newPay['pay_money'];
                !empty($newPayMoney) && $serverRow[1]['pay_money'] = number_format($serverRow[1]['pay_money'] / 100, 2);

                $oldPay = isset($serverRow[2]) ? $serverRow[2] : [];
                $oldPayNum = empty($oldPay) ? 0 : (int)$oldPay['pay_num'];
                $oldPayMoney = empty($oldPay) ? 0 : (int)$oldPay['pay_money'];
                !empty($oldPayMoney) && $serverRow[2]['pay_money'] = number_format($serverRow[2]['pay_money'] / 100, 2);
                $totalInfo['total_pay_num'] = $oldPayNum + $newPayNum;
                $totalPayMoney = ($oldPayMoney + $newPayMoney) / 100;
                $totalInfo['total_pay_money'] = number_format($totalPayMoney, 2);
                $serverRow[3] = $totalInfo;
            }
        }
        /* foreach ($info['data'] as $value) {
             if (empty($value['pay_date']) || empty($value['server_id'])) continue;
             if ($type === 1) {
                 $temp = array();
                 $temp['pay'] = isset($value['pay_money']) ? $value['pay_money'] / 100 : 0;
                 $temp['count'] = isset($value['pay_count']) ? (int)$value['pay_count'] : 0;
                 $list[$value['pay_date']][$value['server_id']] = $temp;
             }
             $total[$value['server_id']]['pay'] += isset($value['pay_money']) ? $value['pay_money'] / 100 : 0;
             $total[$value['server_id']]['count'] += isset($value['pay_count']) ? (int)$value['pay_count'] : 0;
         }*/

        $data['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $data['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $data['data'] = $list;
        $data['total_row'] = $total;
        $data['server_list'] = array_unique($serverList);
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['device_type'] = $device_type;
        $data['server_start'] = $server_start;
        $data['server_end'] = $server_end;
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;

        return $data;
    }

    /**
     * 分时基础数据
     * @param array $param
     * @param array $hourRetain
     * @param array $hourLtv
     * @retrun array
     */
    public function getOverview2ByHour($param, $hourRetain, $hourLtv)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = trim($param['sdate']);
        $edate = trim($param['edate']);

        if ($sdate == '') {
            $sdate = date('Y-m-d', strtotime('-1 days'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $date = date('Y-m-d');
        $total = [];
        $info = $this->mod->getOverview2ByHour($parent_id, $game_id, $device_type, $sdate, $edate, $hourRetain, $hourLtv);
        $count = count($info['list']);
        $cost = $info['cost'];
        $cost = array_column($cost, null, 'date');
        foreach ($info['list'] as $key => &$row) {

            /*foreach ($hourLtv as $d) {
                $row['ltv_reg' . $d] = $row['reg_user'];
                $row['ltv' . $d] = $row['reg_user'] > 0 && $row['ltv_money' . $d] > 0 ? round($row['ltv_money' . $d] / 100 / $row['reg_user'], 2) : '';

                $total['ltv_money' . $d] += $row['ltv_money' . $d];
                $total['ltv_reg' . $d] += $row['reg_user'];
            }*/

            $queDay = substr($row['re_date'], 0, 10);
            $row['cost'] = isset($cost[$queDay]) ? $cost[$queDay]['cost'] / 100 : 0; //当日消耗
            $row['new_pay_money'] = round($row['new_pay_money'] / 100, 2); //新增付费金额
            $row['pay_money'] = $row['pay_money'] / 100; //总充值
            $row['new_charge_money'] = $row['new_charge_money'] / 100; //新增充值

            $old_user_active = $row['login_user'] - $row['reg_user'];
            $row['old_user_active'] = $old_user_active > 0 ? $old_user_active : 0; //老用户活跃 登录人数-注册人数
            if ($row['display']) {
                $row['click_rate'] = bcdiv($row['click'] * 100, $row['display'], 2) . '%'; //点击率
            }
            if ($row['click']) {
                $row['active_rate'] = bcdiv($row['active'] * 100, $row['click'], 2) . '%'; //点击激活率
                $row['reg_rate'] = bcdiv($row['reg_user'] * 100, $row['click'], 2) . '%'; //点击注册率
            }
            if ($row['active']) {
                $row['active_cost'] = bcdiv($row['cost'], $row['active'], 2); //激活成本
                $row['active_reg_rate'] = bcdiv($row['reg_user'] * 100, $row['active'], 2) . '%'; //激活注册率
            }
            if ($row['cost'] > 0) {
                $row['roi'] = bcdiv($row['pay_money'] * 100, $row['cost'], 2) . '%'; //ROI
                $row['new_roi'] = bcdiv($row['new_pay_money'] * 100, $row['cost'], 2) . '%'; //新增ROI
            }
            if ($row['reg_user'] > 0) {
                /*foreach ($hourRetain as $d) {
                    //留存数据
                    if (!empty($row['retain' . $d])) {
                        $row['retain_rate' . $d] = sprintf('%05.2f', $row['retain' . $d] / $row['reg_user'] * 100) . '%';
                    }

                    $row['retain_reg' . $d] = $row['reg_user'];
                    $arr = LibUtil::getDateFormat($row['date'], $date);
                    if ($d > $arr['d']) {
                        $row['retain_reg' . $d] = 0;
                    }

                    $total['retain' . $d] += $row['retain' . $d];
                    $total['retain_reg' . $d] += $row['retain_reg' . $d];
                }*/

                $row['new_arpu'] = bcdiv($row['new_pay_money'], $row['reg_user'], 2); //新增ARPU
                //$row['new_pay_rate'] = bcdiv($row['new_pay_user'] * 100, $row['reg_user'], 2) . '%'; //新增付费率
                $row['new_pay_rate'] = bcdiv($row['new_charge_user'] * 100, $row['reg_user'], 2) . '%'; //新增付费率
                $row['new_role_rate'] = bcdiv($row['new_role'] * 100, $row['reg_user'], 2) . '%'; //创建率
                $row['reg_cost'] = bcdiv($row['cost'], $row['reg_user'], 2); //注册成本
            }
            if ($row['new_pay_user'] > 0) {
                $row['new_arppu'] = bcdiv($row['new_pay_money'], $row['new_pay_user'], 2); //新增ARPPU
                $row['new_pay_cost'] = bcdiv($row['cost'], $row['new_pay_user'], 2); //新增付费成本
            }
            if ($row['login_user'] > 0) {
                $row['pay_rate'] = bcdiv($row['pay_user'] * 100, $row['login_user'], 2) . '%'; //付费率
                $row['arpu'] = bcdiv($row['pay_money'], $row['login_user'], 2); //ARPU
            }
            if ($row['pay_user'] > 0) {
                $row['arppu'] = bcdiv($row['pay_money'], $row['pay_user'], 2); //ARPPU
            }
            if ($row['new_role'] > 0) {
                $row['new_role_cost'] = bcdiv($row['cost'], $row['new_role'], 2); //新增创角成本
            }
            //付费人数
            $old_pay_user = $row['pay_user'] - $row['new_pay_user'];
            $row['old_pay_user'] = $old_pay_user > 0 ? $old_pay_user : 0;
            //老用户充值
            $old_pay_money = $row['pay_money'] - $row['new_pay_money'];
            $row['old_pay_money'] = $old_pay_money < 0 ? 0 : round($old_pay_money, 2);
            if ($row['old_user_active'] > 0) {
                /*-----老用户相关------*/
                //付费率
                $row['old_pay_rate'] = bcdiv($row['old_pay_user'] * 100, $row['old_user_active'], 2) . "%";
                //ARPU
                $row['old_arpu'] = bcdiv($row['old_pay_money'], $row['old_user_active'], 2);
            }
            if ($row['old_pay_user'] > 0) {
                //ARPPU
                $row['old_arppu'] = bcdiv($row['old_pay_money'], $row['old_pay_user'], 2);
            }

            $total['total_user'] += $row['total_user'];
            $total['reg_user'] += $row['reg_user'];
            $total['login_user'] += $row['login_user'];
            $total['reg_device'] += $row['reg_device'];
            //$total['new_pay_user'] += $row['new_pay_user'];
            $total['new_pay_user'] += $row['new_charge_user'];
            $total['new_pay_money'] += $row['new_pay_money'];
            $total['pay_user'] += $row['pay_user'];
            $total['pay_money'] += $row['pay_money'];
            //$total['cost'] += $row['cost'];
            $total['display'] += $row['display'];
            $total['click'] += $row['click'];
            $total['new_role'] += $row['new_role'];
            $total['active'] += $row['active'];
            $row['re_date'] = $row['re_date'] . " 时";
        }
        foreach ($cost as $ttCost) {
            $total['cost'] = (int)$ttCost['cost'];
        }
        $total['old_user_active'] = $total['login_user'] - $total['reg_user'];
        $total['avg_login_user'] = bcdiv($total['login_user'], $count);
        $total['avg_new_pay_user'] = bcdiv($total['new_pay_user'], $count);
        $total['avg_pay_user'] = bcdiv($total['pay_user'], $count);
        $total['old_pay_money'] = round($total['pay_money'] - $total['new_pay_money'], 2);
        $total['old_pay_user'] = $total['pay_user'] - $total['new_pay_user'];
        /*foreach ($hourRetain as $d) {
            if ($total['retain' . $d]) {
                $total['avg_retain' . $d] = bcdiv($total['retain' . $d], $count);
            }
            if ($total['retain_reg' . $d] > 0) {
                $total['retain_rate' . $d] = bcdiv($total['retain' . $d] * 100, $total['retain_reg' . $d], 2) . '%';
            }
        }*/

        /*foreach ($hourLtv as $d) {
            if (!empty($total['ltv_money' . $d])) {
                //LTV数据
                $total['ltv' . $d] = bcdiv($total['ltv_money' . $d] / 100, $total['ltv_reg' . $d], 2);
            }
            $total['ltv' . $d] > 0 || $total['ltv' . $d] = '';
        }*/

        if ($total['display']) {
            $total['click_rate'] = bcdiv($total['click'] * 100, $total['display'], 2) . '%'; //点击率
        }
        if ($total['click']) {
            $total['active_rate'] = bcdiv($total['active'] * 100, $total['click'], 2) . '%'; //点击激活率
            $total['reg_rate'] = bcdiv($total['reg_user'] * 100, $total['click'], 2) . '%'; //点击注册率
        }
        if ($total['active']) {
            $total['active_cost'] = bcdiv($total['cost'], $total['active'], 2); //激活成本
            $total['active_reg_rate'] = bcdiv($total['reg_user'] * 100, $total['active'], 2) . '%'; //激活注册率
        }
        if ($total['cost'] > 0) {
            $total['roi'] = bcdiv($total['pay_money'] * 100, $total['cost'], 2) . '%'; //ROI
            $total['new_roi'] = bcdiv($total['new_pay_money'] * 100, $total['cost'], 2) . '%'; //新增ROI
        }
        if ($total['reg_user'] > 0) {
            $total['new_arpu'] = bcdiv($total['new_pay_money'], $total['reg_user'], 2); //新增ARPU
            $total['new_pay_rate'] = bcdiv($total['new_pay_user'] * 100, $total['reg_user'], 2) . '%'; //新增付费率
            $total['new_role_rate'] = bcdiv($total['new_role'] * 100, $total['reg_user'], 2) . '%'; //创建率
            $total['reg_cost'] = bcdiv($total['cost'], $total['reg_user'], 2); //注册成本
        }
        if ($total['new_pay_user'] > 0) {
            $total['new_arppu'] = bcdiv($total['new_pay_money'], $total['new_pay_user'], 2); //新增ARPPU
            $total['new_pay_cost'] = bcdiv($total['cost'], $total['new_pay_user'], 2); //新增付费成本
        }
        if ($total['login_user'] > 0) {
            $total['pay_rate'] = bcdiv($total['pay_user'] * 100, $total['login_user'], 2) . '%'; //付费率
            $total['arpu'] = bcdiv($total['pay_money'], $total['login_user'], 2); //ARPU
        }
        if ($total['pay_user'] > 0) {
            $total['arppu'] = bcdiv($total['pay_money'], $total['pay_user'], 2); //ARPPU
        }
        if ($total['new_role'] > 0) {
            $total['new_role_cost'] = bcdiv($total['cost'], $total['new_role'], 2); //新增创角成本
        }

        if ($total['old_user_active'] > 0) {
            $total['old_pay_rate'] = bcdiv($total['old_pay_user'] * 100, $total['old_user_active'], 2) . "%";
            $total['old_arpu'] = bcdiv($total['old_pay_money'], $total['old_user_active'], 2);
        }
        if ($total['old_pay_user'] > 0) {
            $total['old_arppu'] = bcdiv($total['old_pay_money'], $total['old_pay_user'], 2);
        }

        $total['new_pay_money'] = round($total['new_pay_money'], 2);
        $total['pay_money'] = round($total['pay_money'], 2);
        $query = array(
            'sdate' => $sdate,
            'edate' => $edate
        );
        return array('list' => $info['list'], 'total' => $total, 'query' => $query);
    }

    public function getNewUserData($param, $page = 0, $limit = 0)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $sdate = empty($param['sdate']) ? date('Y-m-d', strtotime('-1 month')) : $param['sdate'];
        $edate = empty($param['edate']) ? date('Y-m-d', strtotime('+1 month', strtotime($sdate))) : $param['edate'];
        $type = empty($param['type']) ? 7 : $param['type'];
        $device_type = $param['device_type'];
        $data = $this->mod->getNewUserData($parent_id, $game_id, $device_type, $sdate, $edate, $type, $page, $limit);
        $data['list'] = array_column($data['list'], null, 'group_name');
        $totalPay = $data['total_pay'] / 100;
        $games = (new SrvPlatform())->getAllGame(false);
        $total = array();
        foreach ($data['list'] as $groupType => &$row) {
            $row['dau'] = $row['login_user'];
            $row['arpu'] = 0;
            $row['arppu'] = 0;
            $row['pay_money'] /= 100;
            $row['pay_money_str'] = number_format($row['pay_money']);
            $row['total_pay_money'] /= 100;
            $row['total_pay_money'] = number_format($row['total_pay_money'], 2);
            foreach ($row as $key => $res) {
                if ($key == 'group_name') continue;
                $total[$key] += $res;
            }
            if (!empty($row['login_user'])) {
                $row['arpu'] = bcdiv($row['pay_money'], $row['login_user'], 2);
            }
            if (!empty($row['pay_user'])) {
                $row['arppu'] = bcdiv($row['pay_money'], $row['pay_user'], 2);
            }
            $row['pay_rate'] = !empty($row['pay_user']) && !empty($row['login_user']) ? bcdiv($row['pay_user'] * 100, $row['login_user'], 2) : 0;
            $row['pay_rate_str'] = !empty($row['pay_rate']) ? $row['pay_rate'] . "%" : 0;
            $row['pay_per'] = !empty($row['pay_money']) && !empty($totalPay) ? bcdiv($row['pay_money'] * 100, $totalPay, 2) : 0;
            $row['pay_per_str'] = !empty($row['pay_per']) ? $row['pay_per'] . "%" : 0;

            if (in_array($type, array(7, 9, 10))) {
                //日期类型计算环比
                $lastKey = 0;
                if ($type == 7) {
                    $lastKey = date('Y-m-d', strtotime('-1 days', strtotime($groupType)));
                } elseif ($type == 9) {
                    $lastKey = date('Y-m', strtotime('-1 month', strtotime($groupType)));
                } elseif ($type == 10) {
                    $weekArr = explode('-', $groupType);
                    $lastWeek = $weekArr[1] - 1;
                    if ($lastWeek > 0) {
                        $lastKey = $weekArr[0] . '-' . $lastWeek;
                    } else {
                        $lastKey = ($weekArr[0] - 1) . '-52';
                    }
                }
                if (isset($data['list'][$lastKey])) {
                    $lasDateInfo = $data['list'][$lastKey];
                    if (!empty($lasDateInfo['pay_money'])) {
                        $lasDateInfo['pay_money'] /= 100;
                        $row['roll_comp'] = round(($row['pay_money'] - $lasDateInfo['pay_money']) * 100 / $lasDateInfo['pay_money'], 2);
                    } else {
                        $row['roll_comp'] = 0;
                    }
                } else {
                    $row['roll_comp'] = 0;
                }
                $row['roll_comp_str'] = !empty($row['roll_comp']) ? $row['roll_comp'] . "%" : 0;
            } else {
                $row['roll_comp_str'] = '--';
            }
            switch ($type) {
                case 1:
                case 8:
                    $row['group_name'] = $games[$row['group_name']];
                    break;
                case 10:
                    $yearWeek = explode('-', $row['group_name']);
                    $weekDay = LibUtil::weekStartEnd($yearWeek[0], $yearWeek[1]);
                    $row['group_name'] = date('Y-m-d', $weekDay['start']) . " -- " . date('Y-m-d', $weekDay['end']);
                    break;
                default:
                    break;
            }
        }
        $total['pay_money_str'] = number_format($total['pay_money'], 2);
        $total['total_pay_money'] = number_format($total['total_pay_money'], 2);
        $total['arpu'] = bcdiv($total['pay_money'], $total['login_user'], 2);
        $total['arppu'] = bcdiv($total['pay_money'], $total['pay_user'], 2);
        $total['pay_per'] = !empty($total['pay_money']) && !empty($totalPay) ? bcdiv($total['pay_money'] * 100, $totalPay, 2) : 0;
        $total['pay_per_str'] = !empty($total['pay_per']) ? $total['pay_per'] . "%" : 0;
        $total['pay_rate'] = !empty($total['pay_user']) && !empty($total['login_user']) ? bcdiv($total['pay_user'] * 100, $total['login_user'], 2) : 0;
        $total['pay_rate_str'] = !empty($total['pay_rate']) ? $total['pay_rate'] . "%" : 0;
        $query['sdate'] = $sdate;
        $query['edate'] = $edate;
        $query['type'] = $type;
        $data['query'] = $query;
        $data['total'] = $total;
        $data['list'] = array_values($data['list']);
        return $data;
    }

    //新增充值贡献
    public function getNewPayDevote($param, $day, $page = 0, $limit = 0)
    {
        empty($day) && $day = array(1, 7, 14, 30, 45, 90);
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = !empty($param) ? $param['sdate'] : date('Y-m-d', strtotime('-1 month'));
        $edate = !empty($param['edate']) ? $param['edate'] : date('Y-m-d', time());
        $type = (int)$param['type'];
        $pay_type = (int)$param['pay_type'];
        empty($type) && $type = 7;
        $date = date('Y-m-d', time());
        $games = (new SrvPlatform())->getAllGame(false);
        $data = $this->mod->getNewPayDevote($parent_id, $game_id, $device_type, $sdate, $edate, $day, $type, $pay_type, $page, $limit);
        $total = array();
        foreach ($data['list'] as &$row) {
            $row['consume'] /= 100;
            foreach ($day as $d) {
                $row['new_reg'] = $row['reg'];
                $row['day_pay' . $d] = $row['ltv_money' . $d] ? ($row['ltv_money' . $d] / 100) : 0;
                $row['day_pic' . $d] = !empty($row['day_pay' . $d]) && !empty($row['consume']) ? round($row['day_pay' . $d] * 100 / $row['consume'], 2) : 0;
                $row['day_pic_str' . $d] = !empty($row['day_pic' . $d]) ? $row['day_pic' . $d] . "%" : 0;
                $total['day_pay' . $d] += $row['day_pay' . $d];
            }
            $total['consume'] += $row['consume'];
            $total['reg'] += $row['reg'];
            switch ($type) {
                case 1:
                case 8:
                    $row['group_name'] = $games[$row['group_name']];
                    break;
                case 10:
                    $yearWeek = explode('-', $row['group_name']);
                    $weekDay = LibUtil::weekStartEnd($yearWeek[0], $yearWeek[1]);
                    $row['group_name'] = date('Y-m-d', $weekDay['start']) . " -- " . date('Y-m-d', $weekDay['end']);
                    break;
                default:
                    break;
            }

            if (empty($row['group_name'])) {
                $row['group_name'] = '-';
            }
        }
        foreach ($day as $d) {
            if (!empty($total['day_pay' . $d]) && !empty($total['consume'])) {
                $total['day_pic' . $d] = round($total['day_pay' . $d] * 100 / $total['consume'], 2);
                $total['day_pic_str' . $d] = $total['day_pic' . $d] . '%';
            } else {
                $total['day_pic' . $d] = $total['day_pic_str' . $d] = 0;
            }
        }
        $query['sdate'] = $sdate;
        $query['edate'] = $edate;

        return array(
            'count' => $data['total'],
            'list' => $data['list'],
            'total' => $total,
            'query' => $query,
        );
    }

    //新增付费渗透率
    public function getNewPayPermeability($param, $day, $page, $limit)
    {
        empty($day) && $day = array(1, 7, 14, 30, 45, 90);
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = !empty($param['sdate']) ? $param['sdate'] : date('Y-m-d', strtotime('-1 month'));
        $edate = !empty($param['edate']) ? $param['edate'] : date('Y-m-d', time());
        $type = (int)$param['type'];
        empty($type) && $type = 7;
        $date = date('Y-m-d', time());
        $games = (new SrvPlatform())->getAllGame(false);
        $data = $this->mod->getNewPayPermeability($parent_id, $game_id, $device_type, $sdate, $edate, $day, $type, $page, $limit);
        $total = array();
        $series = array();
        foreach ($data['list'] as &$row) {
            $seriesTmp = array();
            $seriesData = array();
            foreach ($day as $d) {
                $row['new_reg' . $d] = $row['reg'];
                if ($type == 7 || $type == 9 || $type == 10) {
                    //$queDay = $type == 7 ? $row['group_name'] : date('Y-m-01', strtotime($row['group_name']));
                    $queDay = LibUtil::nearDate($type, $row['group_name']);
                    $arr = LibUtil::getDateFormat($queDay, $date);
                    if (isset($arr) && $d > $arr['d']) {
                        $row['day_pay' . $d] = 0;
                        $row['new_reg' . $d] = 0;
                    }
                }
                $seriesData[$d] = (int)$row['day_pay' . $d];
                $total['day_pay' . $d] += (int)$row['day_pay' . $d];
                $row['pay_permy' . $d] = !empty($row['day_pay' . $d]) && !empty($row['reg']) ? round($row['day_pay' . $d] * 100 / $row['reg'], 2) : 0;
                $row['pay_permy_str' . $d] = !empty($row['pay_permy' . $d]) ? $row['pay_permy' . $d] . "%" : 0;
            }
            $row['permy_tt'] = !empty($row['pay_user']) && !empty($row['reg']) ? round($row['pay_user'] * 100 / $row['reg'], 2) : 0;
            $row['permy_tt_str'] = !empty($row['permy_tt']) ? $row['permy_tt'] . "%" : 0;
            switch ($type) {
                case 1:
                case 8:
                    $row['group_name'] = $games[$row['group_name']];
                    break;
                case 10:
                    $yearWeek = explode('-', $row['group_name']);
                    $weekDay = LibUtil::weekStartEnd($yearWeek[0], $yearWeek[1]);
                    $row['group_name'] = date('Y-m-d', $weekDay['start']) . " -- " . date('Y-m-d', $weekDay['end']);
                    break;
                default:
                    break;
            }
            $total['reg'] += (int)$row['reg'];
            $total['pay_user'] += (int)$row['pay_user'];
            $seriesTmp['name'] = $row['group_name'];
            $seriesTmp['data'] = array_values($seriesData);
            array_push($series, $seriesTmp);
        }

        foreach ($day as $d) {
            if (!empty($total['reg']) && !empty($total['day_pay' . $d])) {
                $total['pay_permy' . $d] = round($total['day_pay' . $d] * 100 / $total['reg'], 2);
                $total['pay_permy_str' . $d] = $total['pay_permy' . $d] . "%";
            } else {
                $total['pay_permy' . $d] = 0;
                $total['pay_permy_str' . $d] = 0;
            }
        }
        $total['permy_tt'] = !empty($total['pay_user']) && !empty($total['reg']) ? round($total['pay_user'] * 100 / $total['reg'], 2) : 0;
        $total['permy_tt_str'] = !empty($total['permy_tt']) ? $total['permy_tt'] . "%" : 0;

        $query['sdate'] = $sdate;
        $query['edate'] = $edate;
        return array(
            'count' => $data['count'],
            'data' => $data['list'],
            'total' => $total,
            'query' => $query,
            'series' => $series
        );
    }

    //每日充值统计
    public function getDayChargeData($param, $day, $page, $limit, $export)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = !empty($param['sdate']) ? trim($param['sdate']) : date('Y-m-d', strtotime('-1 month'));
        $edate = !empty($param['edate']) ? trim($param['edate']) : date('Y-m-d', time());
        $type = !empty($param['type']) ? (int)$param['type'] : 7;
        $show_type = (int)$param['show_type'];

        if ($export) {
            $page = 0;
        } else {
            $page = $page <= 0 ? 1 : (int)$page;
        }
        $data = $this->mod->getDayChargeData($parent_id, $game_id, $day, $sdate, $edate, $type, $show_type, $page, $limit);
        $total = array();
        $games = (new SrvPlatform())->getAllGame(false);
        foreach ($data['list'] as &$row) {
            $row['pay_money'] /= 100;
            $row['pay_money_str'] = number_format($row['pay_money'], 2);
            $row['adr_pay_money'] /= 100;
            $row['adr_pay_money_str'] = number_format($row['adr_pay_money'], 2);
            $row['ios_pay_money'] /= 100;
            $row['ios_pay_money_str'] = number_format($row['ios_pay_money'], 2);

            foreach ($day as $d) {
                $row['pay_money' . $d] /= 100;
                $row['pay_money_str' . $d] = number_format($row['pay_money' . $d], 2);
            }
            //合计
            foreach ($row as $key => $val) {
                if ($key == 'group_name') {
                    continue;
                }
                $total[$key] += (float)$val;
            }
            switch ($type) {
                case 1:
                case 8:
                    $row['group_name'] = $games[$row['group_name']];
                    break;
                case 10:
                    //计算周开始与周结束
                    $yearWeek = explode('-', $row['group_name']);
                    $weekDay = LibUtil::weekStartEnd($yearWeek[0], $yearWeek[1]);
                    $row['group_name'] = date('Y-m-d', $weekDay['start']) . " -- " . date('Y-m-d', $weekDay['end']);
                    break;
                default:
                    break;
            }
        }
        if ($export > 0) {
            //导出excel
            $headerArray = $header1 = $header2 = $header3 = $excelData = array();
            $header1 = array(
                array('value' => '名称', 'col' => 1, 'row' => 2, 'width' => 30),
                array('value' => 'DAU', 'col' => 1, 'row' => 2, 'width' => 15)
            );
            switch ($show_type) {
                case 0:
                    $header2 = array(
                        array('value' => '总充值金额', 'col' => 1, 'row' => 2, 'width' => 15),
                        array('value' => '总付费人数', 'col' => 1, 'row' => 2, 'width' => 15),
                    );
                    break;
                case 1:
                    $header2 = array(
                        array('value' => 'IOS充值金额', 'col' => 1, 'row' => 2, 'width' => 15),
                        array('value' => 'IOS付费人数', 'col' => 1, 'row' => 2, 'width' => 15),
                    );
                    break;
                case 2:
                    $header2 = array(
                        array('value' => 'IOS充值金额', 'col' => 1, 'row' => 2, 'width' => 15),
                        array('value' => 'IOS付费人数', 'col' => 1, 'row' => 2, 'width' => 15),
                    );
            }
            foreach ($day as $d) {
                $temp = array();
                $d = preg_replace('/\d+\_$/', '大于' . (int)$d, $d);
                $temp['value'] = '注册' . $d . '天';
                $temp['col'] = 3;
                $temp['row'] = 1;
                $temp['width'] = 20;
                $temp['children'] = array(
                    array('value' => '充值金额', 'width' => 15),
                    array('value' => '充值人数', 'width' => 15),
                    array('value' => '充值次数', 'width' => 15),
                );
                array_push($header3, $temp);
            }
            $headerArray = array_merge($header1, $header2, $header3);
            //$data['list']已经被格式化
            foreach ($data['list'] as $rows) {
                $dataTmp = array();
                $dataTmp['group_name'] = $rows['group_name'];
                $dataTmp['dau'] = $rows['login_user'];
                if ($show_type == 0) {
                    $dataTmp['pay_money'] = $rows['pay_money'];
                    $dataTmp['pay_user'] = $rows['pay_user'];
                } elseif ($show_type == 1) {
                    $dataTmp['pay_money'] = $rows['ios_pay_money'];
                    $dataTmp['pay_user'] = $rows['ios_pay_user'];
                } elseif ($show_type == 2) {
                    $dataTmp['pay_money'] = $rows['adr_pay_money'];
                    $dataTmp['pay_user'] = $rows['adr_pay_user'];
                }
                foreach ($day as $d) {
                    $dataTmp['pay_money' . $d] = $rows['pay_money' . $d];
                    $dataTmp['pay_user' . $d] = $rows['pay_user' . $d];
                    $dataTmp['pay_count' . $d] = $rows['pay_count' . $d];
                }
                array_push($excelData, array_values($dataTmp));
            }
            $typeName = $show_type == 0 ? '总数据' : ($show_type == 1 ? 'IOS' : '安卓');
            $filename = $sdate . '—' . $edate . ' ' . $typeName . ' ' . '每日充值统计';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excelData
            );
        }
        $query = array();
        $query['parent_id'] = $parent_id;
        $query['game_id'] = $game_id;
        $query['device_type'] = $device_type;
        $query['sdate'] = $sdate;
        $query['edate'] = $edate;
        $query['type'] = $type;
        $data['total'] = $total;
        $data['show_type'] = $show_type;
        $data['query'] = $query;
        return $data;
    }
}