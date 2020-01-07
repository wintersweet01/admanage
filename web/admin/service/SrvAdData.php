<?php

class SrvAdData
{

    public $mod;

    public function __construct()
    {
        $this->mod = new ModAdData();
    }

    public function userCycle($game_id, $user_id, $sdate, $edate, $is_excel = 0)
    {
        $sdate = $sdate ? $sdate : date('Y-m-d', time() - 2 * 86400);
        $edate = $edate ? $edate : date('Y-m-d', time() - 86400);

        $info['game_id'] = $game_id;
        $info['user_id'] = $user_id;

        $info['list'] = $this->mod->userCycle($game_id, $user_id, $sdate, $edate);
        if ($user_id) {
            foreach ($info['list'] as $key => $val) {

                $tempss[$user_id] = $val[$user_id];

                $info['list'][$key] = $tempss;
            }
        }
        $srvAd = new SrvAd();
        foreach ($info['list'] as $k => $v) {
            foreach ($v as $key => $val) {

                $temp = $this->mod->userGetChannel($val['user_id']);
                $temp = $srvAd->getChannelInfo($temp);

                $info['list'][$k][$key]['channel'] = $temp['channel_name'];

                if ($val['user_id']) {
                    $info['list'][$k][$key]['user_name'] = $this->mod->getUserName($val['user_id']);
                } else {
                    $info['list'][$k][$key]['user_name'] = '未知';
                }

                $info['total']['total_cost'] += $val['cost'] / 100;
                $info['total']['total_display'] += $val['display'];
                $info['total']['total_click'] += $val['click'];
                $info['total']['total_reg'] += $val['reg'];
                $info['total']['total_retain'] += $val['retain1'];
                $info['total']['total_new_pay'] += $val['new_pay'];
                $info['total']['total_new_pay_money'] += $val['new_pay_money'] / 100;
                $info['total']['total_pay'] += $val['pay'];
                $info['total']['total_pay_money'] += $val['pay_money'] / 100;
            }

        }

        if ($info['total']['total_display'] > 0) {
            $info['total']['total_click_rate'] = number_format($info['total']['total_click'] * 100 / $info['total']['total_display'], 2, '.', '') . '%';
        } else {
            $info['total']['total_click_rate'] = '0%';
        }
        if ($info['total']['total_click'] > 0) {
            $info['total']['total_avg_cprice'] = number_format($info['total']['total_cost'] / $info['total']['total_click'], 2, '.', '');
            $info['total']['total_click_reg_rate'] = number_format($info['total']['total_reg'] * 100 / $info['total']['total_click'], 2, '.', '');
        } else {
            $info['total']['total_avg_cprice'] = 0;
            $info['total']['total_click_reg_rate'] = 0;
        }

        if ($info['total']['total_reg'] > 0) {
            $info['total']['reg_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['new_pay_rate'] = number_format($info['total']['total_new_pay'] / $info['total']['total_reg'] * 100, 2, '.', '') . '%';
            $info['total']['new_ARPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['reg_ARPU'] = number_format($info['total']['total_pay_money'] / $info['total']['total_reg'], 2, '.', '');

        } else {
            $info['total']['reg_cost'] = 0;
            $info['total']['new_pay_rate'] = '0%';
            $info['total']['new_ARPU'] = 0;
            $info['total']['reg_ARPU'] = 0;

        }
        if ($info['total']['total_retain'] > 0) {
            $info['total']['retain_rate'] = number_format($info['total']['total_retain'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
            $info['total']['retain_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_retain'], 2, '.', '');
        } else {
            $info['total']['retain_rate'] = '0%';
            $info['total']['retain_cost'] = 0;
        }
        if ($info['total']['total_new_pay'] > 0) {
            $info['total']['new_pay_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_new_pay'], 2, '.', '');
            $info['total']['new_ARPPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_new_pay'], 2, '.', '');
        } else {
            $info['total']['new_pay_cost'] = 0;
            $info['total']['new_ARPPU'] = 0;
        }
        if ($info['total']['total_cost'] > 0) {
            $info['total']['new_ROI'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
            $info['total']['ROI'] = number_format($info['total']['total_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
        } else {
            $info['total']['new_ROI'] = '0%';
            $info['total']['ROI'] = '0%';
        }
        $info['total']['total_new_pay_money'] = number_format($info['total']['total_new_pay_money'], 0, '.', '');
        $info['total']['total_pay_money'] = number_format($info['total']['total_pay_money'], 0, '.', '');

        if ($is_excel > 0) {
            $headerArray = array(
                '时间', '账号', '消耗', '展示', '点击', '点击率', '点击均价', '点击注册率', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '新增付费人数', '新增付费率', '新增付款成本', '新增付费金额', '新增ROI', '新增ARPU', '新增ARPPU', '注册ARPU', '付费人数', '总充值', 'ROI'
            );
            $excel_data[] = array(
                '汇总',
                '',
                '¥' . $info['total']['total_cost'],
                $info['total']['total_display'],
                $info['total']['total_click'],
                $info['total']['total_click_rate'],
                '¥' . $info['total']['total_avg_cprice'],
                $info['total']['total_click_reg_rate'],
                $info['total']['total_reg'],
                '¥' . $info['total']['reg_cost'],
                $info['total']['total_retain'],
                $info['total']['retain_rate'],
                $info['total']['retain_cost'],
                $info['total']['total_new_pay'],
                $info['total']['new_pay_rate'],
                '¥' . $info['total']['new_pay_cost'],
                '¥' . $info['total']['total_new_pay_money'],
                $info['total']['new_ROI'],
                '¥' . $info['total']['new_ARPU'],
                '¥' . $info['total']['new_ARPPU'],
                '¥' . $info['total']['reg_ARPU'],
                $info['total']['total_pay'],
                '¥' . $info['total']['total_pay_money'],
                $info['total']['ROI'],
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $val) {
                foreach ($val as $k => $v) {

                    $excel_data[] = array(
                        $v['date'],
                        $v['user_name'] . '(' . $v['channel'] . ')',
                        '¥' . ($v['cost'] / 100),
                        $v['display'],
                        $v['click'],
                        (!empty($v['display']) ? ($v['click'] * 100 / $v['display']) : 0) . '%',
                        '¥' . (!empty($v['click']) ? ($v['cost'] / 100 / $v['click']) : 0),
                        (!empty($v['click']) ? ($v['reg'] * 100 / $v['click']) : 0) . '%',
                        $v['reg'],
                        '¥' . (!empty($v['reg']) ? ($v['cost'] / 100 / $v['reg']) : 0),
                        $v['retain1'],
                        (!empty($v['reg']) ? ($v['retain1'] * 100 / $v['reg']) : 0) . '%',
                        '¥' . ($v['cost'] / 100 / $v['retain1']),
                        $v['new_pay'],
                        (!empty($v['reg']) ? ($v['new_pay'] * 100 / $v['reg']) : 0) . '%',
                        '¥' . (!empty($v['new_pay']) ? ($v['cost'] / 100 / $v['new_pay']) : 0),
                        '¥' . ($v['new_pay_money'] / 100),
                        (!empty($v['cost']) ? ($v['new_pay_money'] * 100 / $v['cost']) : 0) . '%',
                        '¥' . (!empty($v['reg']) ? ($v['new_pay_money'] / 100 / $v['reg']) : 0),
                        '¥' . (!empty($v['new_pay']) ? ($v['new_pay_money'] / 100 / $v['new_pay']) : 0),
                        '¥' . (!empty($v['reg']) ? ($v['pay_money'] / 100 / $v['reg']) : 0),
                        $v['pay'],
                        '¥' . ($v['pay_money'] / 100),
                        (!empty($v['cost']) ? ($v['pay_money'] * 100 / $v['cost']) : 0) . '%',
                    );

                }
            }

            return array(
                'filename' => '分账号回收',
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    public function dayUserEffect($game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, $is_excel = 0)
    {
        $sdate = $sdate ? $sdate : date('Y-m-d', time() - 86400);
        //$edate = $edate ? $edate : date('Y-m-d',time()-86400);
        $edate = $edate ? $edate : date('Y-m-d', time());
        $default_time = date('Y-m-d', time() - 86400);
        $today = date('Y-m-d', time());
        if ($pay_sdate == '') {
            $pay_sdate = $default_time;
        }
        if ($pay_edate == '') {
            $pay_edate = $today;
        }
        $info['game_id'] = $game_id;
        $info['user_id'] = $user_id;
        $info['list'] = $this->mod->dayUserEffect($game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id);

        $srvAd = new SrvAd();
        if ($info['list']) {

            if ($user_id) {
                foreach ($info['list'] as $key => $val) {

                    $tempss[$user_id] = $val[$user_id];

                    $info['list'][$key] = $tempss;
                }
            }

            foreach ($info['list'] as $key => $val) {
                foreach ($val as $k => $v) {

                    $temp = $this->mod->userGetChannel($v['user_id']);
                    $temp = $srvAd->getChannelInfo($temp);
                    $info['list'][$key][$k]['channel'] = $temp['channel_name'];

                    if ($v['user_id']) {
                        $info['list'][$key][$k]['user_name'] = $this->mod->getUserName($v['user_id']);
                    } else {
                        $info['list'][$key][$k]['user_name'] = '未知';
                    }

                    $info['total']['total_cost'] += $v['cost'] / 100;
                    $info['total']['total_display'] += $v['display'];
                    $info['total']['total_click'] += $v['click'];
                    $info['total']['total_reg'] += $v['reg'];
                    $info['total']['total_retain'] += $v['retain1'];
                    $info['total']['total_retain3'] += $v['retain3'];
                    $info['total']['total_retain7'] += $v['retain7'];
                    $info['total']['total_retain15'] += $v['retain15'];
                    $info['total']['total_retain30'] += $v['retain30'];
                    $info['total']['total_new_pay'] += $v['new_pay'];
                    $info['total']['total_new_pay_money'] += $v['new_pay_money'] / 100;
                    $info['total']['total_pay'] += $v['pay'];
                    $info['total']['total_dau'] += $v['dau'];
                    $info['total']['total_pay_money'] += $v['pay_money'] / 100;
                    $info['total']['total_money7'] += $v['money7'] / 100;
                    $info['total']['total_money30'] += $v['money30'] / 100;
                    $info['total']['total_money45'] += $v['money45'] / 100;
                    $info['total']['total_money60'] += $v['money60'] / 100;
                }

            }
            if ($info['total']['total_reg'] > 0) {
                $info['total']['reg_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_reg'], 2, '.', '');
                $info['total']['new_pay_rate'] = number_format($info['total']['total_new_pay'] / $info['total']['total_reg'] * 100, 2, '.', '') . '%';
                $info['total']['new_ARPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_reg'], 2, '.', '');
                $info['total']['total_ltv0'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_reg'], 2, '.', '');
                $info['total']['total_ltv7'] = number_format($info['total']['total_money7'] / $info['total']['total_reg'], 2, '.', '');
                $info['total']['total_ltv30'] = number_format($info['total']['total_money30'] / $info['total']['total_reg'], 2, '.', '');
                $info['total']['total_ltv45'] = number_format($info['total']['total_money45'] / $info['total']['total_reg'], 2, '.', '');
                $info['total']['total_ltv60'] = number_format($info['total']['total_money60'] / $info['total']['total_reg'], 2, '.', '');
                $info['total']['retain_rate'] = number_format($info['total']['total_retain'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
                $info['total']['retain_rate3'] = number_format($info['total']['total_retain3'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
                $info['total']['retain_rate7'] = number_format($info['total']['total_retain7'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
                $info['total']['retain_rate15'] = number_format($info['total']['total_retain15'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
                $info['total']['retain_rate30'] = number_format($info['total']['total_retain30'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
            } else {
                $info['total']['reg_cost'] = 0;
                $info['total']['new_pay_rate'] = '0%';
                $info['total']['new_ARPU'] = 0;
                $info['total']['total_ltv0'] = 0;
                $info['total']['total_ltv7'] = 0;
                $info['total']['total_ltv30'] = 0;
                $info['total']['retain_rate'] = '0%';
                $info['total']['retain_rate3'] = '0%';
                $info['total']['retain_rate7'] = '0%';
                $info['total']['retain_rate15'] = '0%';
                $info['total']['retain_rate30'] = '0%';
            }
            if ($info['total']['total_retain'] > 0) {

                $info['total']['retain_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_retain'], 2, '.', '');
            } else {

                $info['total']['retain_cost'] = 0;
            }
            if ($info['total']['total_new_pay'] > 0) {
                $info['total']['new_pay_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_new_pay'], 2, '.', '');
                $info['total']['new_ARPPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_new_pay'], 2, '.', '');
            } else {
                $info['total']['new_pay_cost'] = 0;
                $info['total']['new_ARPPU'] = 0;
            }
            if ($info['total']['total_cost'] > 0) {
                $info['total']['new_ROI'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
                $info['total']['ROI'] = number_format($info['total']['total_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
            } else {
                $info['total']['new_ROI'] = '0%';
                $info['total']['ROI'] = '0%';
            }
            $info['total']['total_new_pay_money'] = number_format($info['total']['total_new_pay_money'], 0, '.', '');
            $info['total']['total_pay_money'] = number_format($info['total']['total_pay_money'], 0, '.', '');
        }

        if ($is_excel) {
            $headerArray = array(
                '时间', '账号', '消耗', '展示', '点击', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '新增付费人数', '新增付费率', '新增付费成本', '新增付费金额', '新增ROI', '新增ARPU', '新增ARPPU', '付费人数', '总充值', '总ROI'
            );
            $excel_data = array();
            $excel_data[] = array(
                '汇总',
                '',
                '¥' . $info['total']['total_cost'],
                $info['total']['total_display'],
                $info['total']['total_click'],
                $info['total']['total_reg'],
                '¥' . $info['total']['reg_cost'],
                $info['total']['total_retain'],
                $info['total']['retain_rate'],
                '¥' . $info['total']['retain_cost'],
                $info['total']['total_new_pay'],
                $info['total']['new_pay_rate'],
                '¥' . $info['total']['new_pay_cost'],
                '¥' . $info['total']['total_new_pay_money'],
                $info['total']['new_ROI'],
                '¥' . $info['total']['new_ARPU'],
                '¥' . $info['total']['new_ARPPU'],
                $info['total']['total_pay'],
                '¥' . $info['total']['total_pay_money'],
                $info['total']['ROI'],
            );
            foreach ($info['list'] as $key => $val) {
                foreach ($val as $k => $v) {
                    $excel_data[] = array(
                        ' ' . $v['date'],
                        $v['user_name'],
                        '¥' . number_format($v['cost'] / 100, 2, '.', ''),
                        $v['display'],
                        $v['click'],
                        $v['reg'],
                        '¥' . (($v['reg'] > 0) ? (number_format($v['cost'] / 100 / $v['reg'], 2, '.', '')) : 0),
                        $v['retain1'],
                        ($v['reg'] > 0) ? (number_format($v['retain1'] * 100 / $v['reg'], 2, '.', '') . '%') : '0%',
                        '¥' . (($v['retain1'] > 0) ? (number_format($v['cost'] / 100 / $v['retain1'], 2, '.', '')) : 0),
                        $v['new_pay'],
                        ($v['reg'] > 0) ? (number_format($v['new_pay'] * 100 / $v['reg'], 2, '.', '') . '%') : '0%',
                        '¥' . (($v['new_pay'] > 0) ? (number_format($v['cost'] / 100 / $v['new_pay'], 2, '.', '')) : 0),
                        '¥' . number_format($v['new_pay_money'] / 100, 2, '.', ''),
                        ($v['cost'] > 0) ? (number_format($v['new_pay_money'] * 100 / $v['cost'], 2, '.', '') . '%') : '0%',
                        '¥' . (($v['reg'] > 0) ? (number_format($v['new_pay_money'] / 100 / $v['reg'], 2, '.', '')) : 0),
                        '¥' . (($v['new_pay'] > 0) ? (number_format($v['new_pay_money'] / 100 / $v['new_pay'], 2, '.', '')) : 0),
                        $v['pay'],
                        '¥' . number_format($v['pay_money'] / 100, 2, '.', ''),
                        ($v['cost'] > 0) ? (number_format($v['pay_money'] * 100 / $v['cost'], 2, '.', '') . '%') : '0%',
                    );
                }
            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($user_id) {
                $user_name = '账号：' . $this->mod->getUserName($user_id);
            }
            $filename = '在' . $sdate . '—' . $edate . '时间段内注册  ' . $pay_sdate . '—' . $pay_edate . ' 时间段内充值用户 ' . $game_name . ' ' . $user_name . ' 分日分账号效果表';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }


        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($pay_sdate);
        LibUtil::clean_xss($pay_edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['psdate'] = $pay_sdate;
        $info['pedate'] = $pay_edate;

        $info['monitor_id'] = $monitor_id;
        if ($game_id) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($game_id);
        }
        return $info;
    }

    public function userEffect($parent_id, $game_id, $user_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        $default_time = date('Y-m-d', time() - 86400);
        $today = date('Y-m-d', time());
        if ($rsdate == '') {
            $rsdate = $default_time;
        }
        if ($redate == '') {
            $redate = $default_time;
        }
        if ($psdate == '') {
            $psdate = $default_time;
        }
        if ($pedate == '') {
            $pedate = $today;
        }


        $info = $this->mod->userEffect($parent_id, $game_id, $user_id, $rsdate, $redate, $psdate, $pedate);

        if ($info['list']) {

            if ($user_id) {
                $tempss[$user_id] = $info['list'][$user_id];
                $info['list'] = $tempss;
            }
            foreach ($info['list'] as $key => $val) {
                $info['all']['reg'] += $val['reg'];
                $info['all']['cost'] += $val['cost'];
                $info['all']['display'] += $val['display'];
                $info['all']['click'] += $val['click'];
                $info['all']['retain'] += $val['retain'];
                $info['all']['pay_money'] += $val['pay_money'];
                $info['all']['payer_num'] += $val['payer_num'];
            }


            if ($info['all']['retain'] > 0) {
                $info['all']['retain_cost'] = number_format($info['all']['cost'] / $info['all']['retain'], 2, '.', '');
            } else {
                $info['all']['retain_cost'] = 0;
            }
            if ($info['all']['cost'] > 0) {
                $info['all']['ROI'] = number_format($info['all']['pay_money'] / $info['all']['cost'], 2, '.', '') . '%';
            } else {
                $info['all']['ROI'] = '0%';
            }
            if ($info['all']['reg'] > 0) {
                $info['all']['ARPU'] = number_format($info['all']['pay_money'] / $info['all']['reg'] / 100, 2, '.', '');
                $info['all']['pay_rate'] = number_format($info['all']['payer_num'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
                $info['all']['reg_cost'] = number_format($info['all']['cost'] / $info['all']['reg'], 2, '.', '');
                $info['all']['retain_rate'] = number_format($info['all']['retain'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
            } else {
                $info['all']['ARPU'] = 0;
                $info['all']['pay_rate'] = '0%';
                $info['all']['reg_cost'] = 0;
                $info['all']['retain_rate'] = '0%';
            }
            if ($info['all']['payer_num'] > 0) {
                $info['all']['pay_cost'] = number_format($info['all']['cost'] / $info['all']['payer_num'], 2, '.', '');
                $info['all']['ARPPU'] = number_format($info['all']['pay_money'] / $info['all']['payer_num'] / 100, 2, '.', '');
            } else {
                $info['all']['pay_cost'] = 0;
                $info['all']['ARPPU'] = 0;
            }
            if ($info['all']['pay_money'] > 0) {
                $info['all']['pay_money'] = $info['all']['pay_money'] / 100;
            } else {
                $info['all']['pay_money'] = 0;
            }
            $srvAd = new SrvAd();
            foreach ($info['list'] as $key => $val) {

                if (!$val['user_id']) {
                    $info['list'][$key]['user_name'] = '未知账号';
                    $info['list'][$key]['channel'] = '未知';
                } else {
                    $info['list'][$key]['user_name'] = $this->mod->getUserName($val['user_id']);
                    $temp = $this->mod->userGetChannel($val['user_id']);
                    $temp = $srvAd->getChannelInfo($temp);
                    $info['list'][$key]['channel'] = $temp['channel_name'];
                }

                if ($val['retain'] > 0) {
                    $info['list'][$key]['retain_cost'] = number_format($val['cost'] / $val['retain'], 2, '.', '');
                } else {
                    $info['list'][$key]['retain_cost'] = 0;
                }
                if ($val['cost'] > 0) {
                    $info['list'][$key]['ROI'] = number_format($val['pay_money'] / $val['cost'], 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ROI'] = '0%';
                }
                if ($val['reg'] > 0) {
                    $info['list'][$key]['ARPU'] = number_format($val['pay_money'] / $val['reg'] / 100, 2, '.', '');
                    $info['list'][$key]['pay_rate'] = number_format($val['payer_num'] / $val['reg'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['reg_cost'] = number_format($val['cost'] / $val['reg'], 2, '.', '');
                    $info['list'][$key]['retain_rate'] = number_format($val['retain'] / $val['reg'] * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ARPU'] = 0;
                    $info['list'][$key]['pay_rate'] = '0%';
                    $info['list'][$key]['reg_cost'] = 0;
                    $info['list'][$key]['retain_rate'] = '0%';
                }
                if ($val['payer_num'] > 0) {
                    $info['list'][$key]['pay_cost'] = number_format($val['cost'] / $val['payer_num'], 2, '.', '');
                    $info['list'][$key]['ARPPU'] = number_format($val['pay_money'] / $val['payer_num'] / 100, 2, '.', '');
                } else {
                    $info['list'][$key]['pay_cost'] = 0;
                    $info['list'][$key]['ARPPU'] = 0;
                }
                if ($val['pay_money'] > 0) {
                    $info['list'][$key]['pay_money'] = $val['pay_money'] / 100;
                } else {
                    $info['list'][$key]['pay_money'] = 0;
                }

            }

        }

        if ($is_excel > 0) {
            $headerArray = array(
                '账号', '消耗', '展示', '点击', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '付费人数', '付费率', '付费成本', '付费金额', 'ROI', 'ARPU', 'ARPPU'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['user_name'] . '(' . $v['channel'] . ')',
                    '¥' . $v['cost'],
                    $v['display'],
                    $v['click'],
                    $v['reg'],
                    '¥' . $v['reg_cost'],
                    $v['retain'],
                    $v['retain_rate'],
                    '¥' . $v['retain_cost'],
                    $v['payer_num'],
                    $v['pay_rate'],
                    '¥' . $v['pay_cost'],
                    '¥' . $v['pay_money'],
                    $v['ROI'],
                    '¥' . $v['ARPU'],
                    '¥' . $v['ARPPU'],
                );

            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }

            $filename = '在' . $rsdate . '—' . $redate . '时间段内注册  ' . $psdate . '—' . $pedate . ' 时间段内充值用户 ' . $game_name . ' 分账号效果表';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }
        LibUtil::clean_xss($rsdate);
        LibUtil::clean_xss($redate);
        LibUtil::clean_xss($psdate);
        LibUtil::clean_xss($pedate);
        $info['user_id'] = $user_id;
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['reg_sdate'] = $rsdate;
        $info['reg_edate'] = $redate;
        $info['pay_sdate'] = $psdate;
        $info['pay_edate'] = $pedate;
        return $info;
    }

    public function channelCycleT($page, $parent_id, $game_id, $channel_id, $sdate, $edate)
    {
        $sdate = $sdate ? $sdate : date('Y-m-d', time());
        $edate = $edate ? $edate : date('Y-m-d', time());

        $date_arr = explode('-', $sdate);
        if ($date_arr['0'] == '2017' && $date_arr['1'] == '07' && (int)$date_arr['2'] < 25) {
            $sdate = '2017-07-25';
        }

        $daysub = $this->diffBetweenTwoDays($sdate, $edate) + 1;//推广日期
        $srvAd = new SrvAd();
        $_channel_id = $srvAd->getAllChannel();
        $page = $page < 1 ? 1 : $page;
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['channel_id'] = $channel_id;
        if ($channel_id) {
            $channel_id = implode(',', $channel_id);
        } else {
            foreach ($_channel_id as $key => $val) {
                $channel_id .= $key . ',';
            }
            $channel_id = rtrim($channel_id, ',');
        }

        $info['list'] = $this->mod->channelCycleT($page, $channel_id, $parent_id, $game_id, $sdate, $edate);
        if ($info['list']) {
            foreach ($info['list'] as $key => $val) {
                if ($val['reg']) {
                    $info['list'][$key]['single_price'] = number_format($val['cost'] / 100 / $val['reg'], 2, '.', '');
                    $info['list'][$key]['reg_ARPU'] = number_format($val['pay_money'] / 100 / $val['reg'], 2, '.', '');
                } else {
                    $info['list'][$key]['single_price'] = 0;
                    $info['list'][$key]['reg_ARPU'] = 0;
                }


                $info['list'][$key]['daysub'] = $daysub;
                if ($val['cost']) {
                    $info['list'][$key]['ROI'] = number_format($val['pay_money'] / $val['cost'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['back_time'] = number_format(1 / ($val['pay_money'] / $val['cost'] / $daysub), 2, '.', '');
                } else {
                    $info['list'][$key]['ROI'] = '0%';
                    $info['list'][$key]['back_time'] = 0;
                }

                $info['list'][$key]['cost'] = number_format($val['cost'] / 100, 2, '.', '');
                $info['list'][$key]['channel'] = $_channel_id[$val['channel_id']];
                $info['list'][$key]['sdate'] = $sdate;
                $info['list'][$key]['edate'] = $edate;
                $info['list'][$key]['pay_money'] = number_format($val['pay_money'] / 100, 0, '.', '');

                $info['total']['all_cost'] += $val['cost'] / 100;
                $info['total']['all_reg'] += $val['reg'];
                $info['total']['all_pay_money'] += $val['pay_money'] / 100;

            }

            if ($info['total']['all_reg']) {
                $info['total']['reg_ARPU'] = number_format($info['total']['all_pay_money'] / $info['total']['all_reg'], 0, '.', '');
                $info['total']['single_price'] = number_format($info['total']['all_cost'] / $info['total']['all_reg'], 2, '.', '');
            } else {
                $info['total']['reg_ARPU'] = 0;
                $info['total']['single_price'] = 0;
            }
            if ($info['total']['all_cost']) {
                $info['total']['back_time'] = number_format(1 / ($info['total']['all_pay_money'] / $info['total']['all_cost'] / $daysub), 2, '.', '');
                $info['total']['ROI'] = number_format($info['total']['all_pay_money'] / $info['total']['all_cost'] * 100, 2, '.', '') . '%';
            } else {
                $info['total']['back_time'] = 0;
                $info['total']['ROI'] = '0%';
            }
            $info['total']['all_pay_money'] = number_format($info['total']['all_pay_money'], 0, '.', '');
            $info['total']['all_cost'] = number_format($info['total']['all_cost'], 2, '.', '');
            $info['total']['daysub'] = $daysub;
        }
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return $info;
    }

    public function channelCycle($parent_id, $game_id, $channel_id, $sdate, $edate, $excel = 0)
    {
        $sdate = $sdate ? $sdate : date('Y-m-01', time() - 86400);
        $edate = $edate ? $edate : date('Y-m-d', time() - 86400);
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['channel_id'] = $channel_id;
        if ($channel_id) {
            $channel_id = implode(',', $channel_id);
        } else {
            $srvAd = new SrvAd();
            $_channel_id = $srvAd->getAllChannel();
            foreach ($_channel_id as $key => $val) {
                $channel_id .= $key . ',';
            }
            $channel_id = rtrim($channel_id, ',');
        }
        $info['list'] = $this->mod->channelCycle($parent_id, $channel_id, $game_id, $sdate, $edate);
        foreach ($info['list'] as $key => $val) {
            $info['total']['total_cost'] += $val['cost'] / 100;
            $info['total']['total_display'] += $val['display'];
            $info['total']['total_click'] += $val['click'];
            $info['total']['total_reg'] += $val['reg'];
            $info['total']['total_retain'] += $val['retain1'];
            $info['total']['total_new_pay'] += $val['new_pay'];
            $info['total']['total_new_pay_money'] += $val['new_pay_money'] / 100;
            $info['total']['total_pay'] += $val['pay'];
            $info['total']['total_pay_money'] += $val['pay_money'] / 100;
        }

        if ($info['total']['total_display'] > 0) {
            $info['total']['total_click_rate'] = number_format($info['total']['total_click'] * 100 / $info['total']['total_display'], 2, '.', '') . '%';
        } else {
            $info['total']['total_click_rate'] = '0%';
        }
        if ($info['total']['total_click'] > 0) {
            $info['total']['total_avg_cprice'] = number_format($info['total']['total_cost'] / $info['total']['total_click'], 2, '.', '');
            $info['total']['total_click_reg_rate'] = number_format($info['total']['total_reg'] * 100 / $info['total']['total_click'], 2, '.', '');
        } else {
            $info['total']['total_avg_cprice'] = 0;
            $info['total']['total_click_reg_rate'] = 0;
        }

        if ($info['total']['total_reg'] > 0) {
            $info['total']['reg_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['new_pay_rate'] = number_format($info['total']['total_new_pay'] / $info['total']['total_reg'] * 100, 2, '.', '') . '%';
            $info['total']['new_ARPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['reg_ARPU'] = number_format($info['total']['total_pay_money'] / $info['total']['total_reg'], 2, '.', '');

        } else {
            $info['total']['reg_cost'] = 0;
            $info['total']['new_pay_rate'] = '0%';
            $info['total']['new_ARPU'] = 0;
            $info['total']['reg_ARPU'] = 0;

        }
        if ($info['total']['total_retain'] > 0) {
            $info['total']['retain_rate'] = number_format($info['total']['total_retain'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
            $info['total']['retain_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_retain'], 2, '.', '');
        } else {
            $info['total']['retain_rate'] = '0%';
            $info['total']['retain_cost'] = 0;
        }
        if ($info['total']['total_new_pay'] > 0) {
            $info['total']['new_pay_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_new_pay'], 2, '.', '');
            $info['total']['new_ARPPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_new_pay'], 2, '.', '');
        } else {
            $info['total']['new_pay_cost'] = 0;
            $info['total']['new_ARPPU'] = 0;
        }
        if ($info['total']['total_cost'] > 0) {
            $info['total']['new_ROI'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
            $info['total']['ROI'] = number_format($info['total']['total_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
        } else {
            $info['total']['new_ROI'] = '0%';
            $info['total']['ROI'] = '0%';
        }
        $info['total']['total_new_pay_money'] = number_format($info['total']['total_new_pay_money'], 0, '.', '');
        $info['total']['total_pay_money'] = number_format($info['total']['total_pay_money'], 0, '.', '');

        if ($excel > 0) {
            $headerArray = array(
                '时间', '消耗', '展示', '点击', '点击率', '点击均价', '点击注册率', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '新增付费人数', '新增付费率', '新增付款成本', '新增付费金额', '新增ROI', '新增ARPU', '新增ARPPU', '注册ARPU', '付费人数', '总充值', 'ROI'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    $v['date'],
                    '¥' . ($v['cost'] / 100),
                    $v['display'],
                    $v['click'],
                    ($v['click'] * 100 / $v['display']) . '%',
                    '¥' . ($v['cost'] / 100 / $v['click']),
                    ($v['reg'] * 100 / $v['click']) . '%',
                    $v['reg'],
                    '¥' . ($v['cost'] / 100 / $v['reg']),
                    $v['retain1'],
                    ($v['retain1'] * 100 / $v['reg']) . '%',
                    '¥' . ($v['cost'] / 100 / $v['retain1']),
                    $v['new_pay'],
                    ($v['new_pay'] * 100 / $v['reg']) . '%',
                    '¥' . ($v['cost'] / 100 / $v['new_pay']),
                    '¥' . ($v['new_pay_money'] / 100),
                    ($v['new_pay_money'] * 100 / $v['cost']) . '%',
                    '¥' . ($v['new_pay_money'] / 100 / $v['reg']),
                    '¥' . ($v['new_pay_money'] / 100 / $v['new_pay']),
                    '¥' . ($v['pay_money'] / 100 / $v['reg']),
                    $v['pay'],
                    '¥' . ($v['pay_money'] / 100),
                    ($v['pay_money'] * 100 / $v['cost']) . '%',
                );
            }

            return array(
                'filename' => '分渠道回收',
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;

        return $info;
    }

    public function channelEffect($device_type, $page, $parent_id, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        $default_time = date('Y-m-d', time() - 86400);
        $today = date('Y-m-d', time());
        $page = $page < 1 ? 1 : $page;
        if ($rsdate == '') {
            $rsdate = $default_time;
        }
        if ($redate == '') {
            $redate = $default_time;
        }
        if ($psdate == '') {
            $psdate = $default_time;
        }
        if ($pedate == '') {
            $pedate = $today;
        }
        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        if ($channel_id) {
            $channel_id = implode(',', $channel_id);
        }


        $info = $this->mod->channelEffect($device_type, $page, $channel_id, $parent_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel);

        $is_unknown = 0;
        foreach ($info['list'] as $v) {
            $info['temp'][$v['date']][] = $v;
            if (!$v['channel_id']) {
                $is_unknown = 1;
            }
        }
        unset($info['temp']);
        if ($is_unknown) {
            $allChannel['0'] = '未知';
            ksort($allChannel);
        }
        if ($info['total']['c'] > 0) {
            if ($info['all']['retain'] > 0) {
                $info['all']['retain_cost'] = number_format($info['all']['cost'] / $info['all']['retain'], 2, '.', '');
            } else {
                $info['all']['retain_cost'] = 0;
            }
            if ($info['all']['cost'] > 0) {
                $info['all']['ROI'] = number_format($info['all']['pay_money'] / $info['all']['cost'], 2, '.', '') . '%';
            } else {
                $info['all']['ROI'] = 0;
            }
            if ($info['all']['reg'] > 0) {
                $info['all']['ARPU'] = number_format($info['all']['pay_money'] / $info['all']['reg'] / 100, 2, '.', '');
                $info['all']['pay_rate'] = number_format($info['all']['payer_num'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
                $info['all']['reg_cost'] = number_format($info['all']['cost'] / $info['all']['reg'], 2, '.', '');
                $info['all']['retain_rate'] = number_format($info['all']['retain'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
            } else {
                $info['all']['ARPU'] = 0;
                $info['all']['pay_rate'] = 0;
                $info['all']['reg_cost'] = 0;
                $info['all']['retain_rate'] = 0;
            }
            if ($info['all']['payer_num'] > 0) {
                $info['all']['pay_cost'] = number_format($info['all']['cost'] / $info['all']['payer_num'], 2, '.', '');
                $info['all']['ARPPU'] = number_format($info['all']['pay_money'] / $info['all']['payer_num'] / 100, 2, '.', '');
            } else {
                $info['all']['pay_cost'] = 0;
                $info['all']['ARPPU'] = 0;
            }
            if ($info['all']['pay_money'] > 0) {
                $info['all']['pay_money'] = $info['all']['pay_money'] / 100;
            } else {
                $info['all']['pay_money'] = 0;
            }

            foreach ($info['list'] as $key => $val) {
                $info['list'][$key]['channel_name'] = $allChannel[$val['channel_id']];

                if ($val['retain'] > 0) {
                    $info['list'][$key]['retain_cost'] = number_format($val['cost'] / $val['retain'], 2, '.', '');
                } else {
                    $info['list'][$key]['retain_cost'] = 0;
                }
                if ($val['cost'] > 0) {
                    $info['list'][$key]['ROI'] = number_format($val['pay_money'] / $val['cost'], 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ROI'] = 0;
                }
                if ($val['reg'] > 0) {
                    $info['list'][$key]['ARPU'] = number_format($val['pay_money'] / $val['reg'] / 100, 2, '.', '');
                    $info['list'][$key]['pay_rate'] = number_format($val['payer_num'] / $val['reg'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['reg_cost'] = number_format($val['cost'] / $val['reg'], 2, '.', '');
                    $info['list'][$key]['retain_rate'] = number_format($val['retain'] / $val['reg'] * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ARPU'] = 0;
                    $info['list'][$key]['pay_rate'] = 0;
                    $info['list'][$key]['reg_cost'] = 0;
                    $info['list'][$key]['retain_rate'] = 0;
                }
                if ($val['payer_num'] > 0) {
                    $info['list'][$key]['pay_cost'] = number_format($val['cost'] / $val['payer_num'], 2, '.', '');
                    $info['list'][$key]['ARPPU'] = number_format($val['pay_money'] / $val['payer_num'] / 100, 2, '.', '');
                } else {
                    $info['list'][$key]['pay_cost'] = 0;
                    $info['list'][$key]['ARPPU'] = 0;
                }
                if ($val['pay_money'] > 0) {
                    $info['list'][$key]['pay_money'] = $val['pay_money'] / 100;
                } else {
                    $info['list'][$key]['pay_money'] = 0;
                }


            }

        }
        if ($is_excel > 0) {
            $headerArray = array(
                '渠道', '消耗', '展示', '点击', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '付费人数', '付费率', '付费成本', '付费金额', 'ROI', 'ARPU', 'ARPPU'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['channel_name'],
                    '¥' . $v['cost'],
                    $v['display'],
                    $v['click'],
                    $v['reg'],
                    '¥' . $v['reg_cost'],
                    $v['retain'],
                    $v['retain_rate'],
                    '¥' . $v['retain_cost'],
                    $v['payer_num'],
                    $v['pay_rate'],
                    '¥' . $v['pay_cost'],
                    '¥' . $v['pay_money'],
                    $v['ROI'],
                    '¥' . $v['ARPU'],
                    '¥' . $v['ARPPU'],
                );

            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($device_type == PLATFORM['ios']) {
                $platform = 'IOS';
            } else if ($device_type == PLATFORM['android']) {
                $platform = 'Android';
            } else {
                $platform = '';
            }

            $filename = '在' . $rsdate . '—' . $redate . '时间段内注册  ' . $psdate . '—' . $pedate . ' 时间段内充值用户 ' . $game_name . $platform . ' 分渠道效果表';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        LibUtil::clean_xss($rsdate);
        LibUtil::clean_xss($redate);
        LibUtil::clean_xss($psdate);
        LibUtil::clean_xss($pedate);
        $info['reg_sdate'] = $rsdate;
        $info['reg_edate'] = $redate;
        $info['pay_sdate'] = $psdate;
        $info['pay_edate'] = $pedate;
        $info['device_type'] = $device_type;
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return $info;
    }

    public function activityEffect($game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        //$page = $page < 1 ? 1 : $page;
        $page = 1;
        $default_time = date('Y-m-d', time() - 86400);
        $today = date('Y-m-d', time());
        if ($rsdate == '') {
            $rsdate = $default_time;
        }
        if ($redate == '') {
            $redate = $default_time;
        }
        if ($psdate == '') {
            $psdate = $default_time;
        }
        if ($pedate == '') {
            $pedate = $today;
        }
        if ($channel_id) {
            $channel_id = implode(',', $channel_id);
        }
        $info = $this->mod->activityEffect($channel_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel);

        if ($info['total']['c'] > 0) {
            if ($info['all']['retain'] > 0) {
                $info['all']['retain_cost'] = number_format($info['all']['cost'] / $info['all']['retain'], 2, '.', '');
            } else {
                $info['all']['retain_cost'] = 0;
            }
            if ($info['all']['cost'] > 0) {
                $info['all']['ROI'] = number_format($info['all']['pay_money'] / $info['all']['cost'], 2, '.', '') . '%';
            } else {
                $info['all']['ROI'] = 0;
            }
            if ($info['all']['reg'] > 0) {
                $info['all']['ARPU'] = number_format($info['all']['pay_money'] / $info['all']['reg'] / 100, 2, '.', '');
                $info['all']['pay_rate'] = number_format($info['all']['payer_num'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
                $info['all']['reg_cost'] = number_format($info['all']['cost'] / $info['all']['reg'], 2, '.', '');
                $info['all']['retain_rate'] = number_format($info['all']['retain'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
            } else {
                $info['all']['ARPU'] = 0;
                $info['all']['pay_rate'] = 0;
                $info['all']['reg_cost'] = 0;
                $info['all']['retain_rate'] = 0;
            }
            if ($info['all']['payer_num'] > 0) {
                $info['all']['pay_cost'] = number_format($info['all']['cost'] / $info['all']['payer_num'], 2, '.', '');
                $info['all']['ARPPU'] = number_format($info['all']['pay_money'] / $info['all']['payer_num'] / 100, 2, '.', '');
            } else {
                $info['all']['pay_cost'] = 0;
                $info['all']['ARPPU'] = 0;
            }
            if ($info['all']['pay_money'] > 0) {
                $info['all']['pay_money'] = $info['all']['pay_money'] / 100;
            } else {
                $info['all']['pay_money'] = 0;
            }
            foreach ($info['list'] as $key => $val) {

                if ($val['retain'] > 0) {
                    $info['list'][$key]['retain_cost'] = number_format($val['cost'] / $val['retain'], 2, '.', '');
                } else {
                    $info['list'][$key]['retain_cost'] = 0;
                }
                if ($val['cost'] > 0) {
                    $info['list'][$key]['ROI'] = number_format($val['pay_money'] / $val['cost'], 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ROI'] = 0;
                }
                if ($val['reg'] > 0) {
                    $info['list'][$key]['ARPU'] = number_format($val['pay_money'] / $val['reg'] / 100, 2, '.', '');
                    $info['list'][$key]['pay_rate'] = number_format($val['payer_num'] / $val['reg'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['reg_cost'] = number_format($val['cost'] / $val['reg'], 2, '.', '');
                    $info['list'][$key]['retain_rate'] = number_format($val['retain'] / $val['reg'] * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ARPU'] = 0;
                    $info['list'][$key]['pay_rate'] = 0;
                    $info['list'][$key]['reg_cost'] = 0;
                    $info['list'][$key]['retain_rate'] = 0;
                }
                if ($val['payer_num'] > 0) {
                    $info['list'][$key]['pay_cost'] = number_format($val['cost'] / $val['payer_num'], 2, '.', '');
                    $info['list'][$key]['ARPPU'] = number_format($val['pay_money'] / $val['payer_num'] / 100, 2, '.', '');
                } else {
                    $info['list'][$key]['pay_cost'] = 0;
                    $info['list'][$key]['ARPPU'] = 0;
                }
                if ($val['pay_money'] > 0) {
                    $info['list'][$key]['pay_money'] = $val['pay_money'] / 100;
                } else {
                    $info['list'][$key]['pay_money'] = 0;
                }
            }

        }

        if ($is_excel > 0) {
            $headerArray = array(
                '包标识', '消耗', '展示', '点击', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '付费人数', '付费率', '付费成本', '付费金额', 'ROI', 'ARPU', 'ARPPU'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['package_name'],
                    '¥' . $v['cost'],
                    $v['display'],
                    $v['click'],
                    $v['reg'],
                    '¥' . $v['reg_cost'],
                    $v['retain'],
                    $v['retain_rate'],
                    '¥' . $v['retain_cost'],
                    $v['payer_num'],
                    $v['pay_rate'],
                    '¥' . $v['pay_cost'],
                    '¥' . $v['pay_money'],
                    $v['ROI'],
                    '¥' . $v['ARPU'],
                    '¥' . $v['ARPPU'],
                );

            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            $filename = '在' . $rsdate . '—' . $redate . '时间段内注册  ' . $psdate . '—' . $pedate . ' 时间段内充值用户 ' . $game_name . ' 分推广活动效果表';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }
        LibUtil::clean_xss($rsdate);
        LibUtil::clean_xss($redate);
        LibUtil::clean_xss($psdate);
        LibUtil::clean_xss($pedate);
        $info['reg_sdate'] = $rsdate;
        $info['reg_edate'] = $redate;
        $info['pay_sdate'] = $psdate;
        $info['pay_edate'] = $pedate;
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return $info;
    }

    public function dayChannelEffect($channel_id, $parent_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, $is_excel)
    {

        $sdate = $sdate ? $sdate : date('Y-m-d', time() - 86400);
        //$edate = $edate ? $edate : date('Y-m-d',time()-86400);
        $edate = $edate ? $edate : date('Y-m-d', time());
        $default_time = date('Y-m-d', time() - 86400);
        $today = date('Y-m-d', time());
        if ($pay_sdate == '') {
            $pay_sdate = $default_time;
        }
        if ($pay_edate == '') {
            $pay_edate = $today;
        }
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['channel_id'] = $channel_id;
        if ($channel_id) {
            $channel_id = implode(',', $channel_id);
        } else {
            $srvAd = new SrvAd();
            $_channel_id = $srvAd->getAllChannel();
            foreach ($_channel_id as $key => $val) {
                $channel_id .= $key . ',';
            }
            $channel_id = rtrim($channel_id, ',');
        }
        $info['list'] = $this->mod->dayChannelEffect($channel_id, $parent_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 1);
        foreach ($info['list'] as $key => $val) {
            $info['total']['total_cost'] += $val['cost'] / 100;
            $info['total']['total_display'] += $val['display'];
            $info['total']['total_click'] += $val['click'];
            $info['total']['total_reg'] += $val['reg'];
            $info['total']['total_retain'] += $val['retain1'];
            $info['total']['total_retain3'] += $val['retain3'];
            $info['total']['total_retain7'] += $val['retain7'];
            $info['total']['total_retain15'] += $val['retain15'];
            $info['total']['total_retain30'] += $val['retain30'];
            $info['total']['total_new_pay'] += $val['new_pay'];
            $info['total']['total_new_pay_money'] += $val['new_pay_money'] / 100;
            $info['total']['total_pay'] += $val['pay'];
            $info['total']['total_dau'] += $val['dau'];
            $info['total']['total_pay_money'] += $val['pay_money'] / 100;
            $info['total']['total_money7'] += $val['money7'] / 100;
            $info['total']['total_money30'] += $val['money30'] / 100;
            $info['total']['total_money45'] += $val['money45'] / 100;
            $info['total']['total_money60'] += $val['money60'] / 100;
        }

        if ($info['total']['total_reg'] > 0) {
            $info['total']['reg_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['new_pay_rate'] = number_format($info['total']['total_new_pay'] / $info['total']['total_reg'] * 100, 2, '.', '') . '%';
            $info['total']['new_ARPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['total_ltv0'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['total_ltv7'] = number_format($info['total']['total_money7'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['total_ltv30'] = number_format($info['total']['total_money30'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['total_ltv45'] = number_format($info['total']['total_money45'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['total_ltv60'] = number_format($info['total']['total_money60'] / $info['total']['total_reg'], 2, '.', '');
            $info['total']['retain_rate'] = number_format($info['total']['total_retain'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
            $info['total']['retain_rate3'] = number_format($info['total']['total_retain3'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
            $info['total']['retain_rate7'] = number_format($info['total']['total_retain7'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
            $info['total']['retain_rate15'] = number_format($info['total']['total_retain15'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
            $info['total']['retain_rate30'] = number_format($info['total']['total_retain30'] * 100 / $info['total']['total_reg'], 2, '.', '') . '%';
        } else {
            $info['total']['reg_cost'] = 0;
            $info['total']['new_pay_rate'] = '0%';
            $info['total']['new_ARPU'] = 0;
            $info['total']['total_ltv0'] = 0;
            $info['total']['total_ltv7'] = 0;
            $info['total']['total_ltv30'] = 0;
            $info['total']['retain_rate'] = '0%';
            $info['total']['retain_rate3'] = '0%';
            $info['total']['retain_rate7'] = '0%';
            $info['total']['retain_rate15'] = '0%';
            $info['total']['retain_rate30'] = '0%';
        }
        if ($info['total']['total_retain'] > 0) {

            $info['total']['retain_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_retain'], 2, '.', '');
        } else {

            $info['total']['retain_cost'] = 0;
        }
        if ($info['total']['total_new_pay'] > 0) {
            $info['total']['new_pay_cost'] = number_format($info['total']['total_cost'] / $info['total']['total_new_pay'], 2, '.', '');
            $info['total']['new_ARPPU'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_new_pay'], 2, '.', '');
        } else {
            $info['total']['new_pay_cost'] = 0;
            $info['total']['new_ARPPU'] = 0;
        }
        if ($info['total']['total_cost'] > 0) {
            $info['total']['new_ROI'] = number_format($info['total']['total_new_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
            $info['total']['ROI'] = number_format($info['total']['total_pay_money'] / $info['total']['total_cost'] * 100, 2, '.', '') . '%';
        } else {
            $info['total']['new_ROI'] = '0%';
            $info['total']['ROI'] = '0%';
        }
        $info['total']['total_new_pay_money'] = number_format($info['total']['total_new_pay_money'], 0, '.', '');
        $info['total']['total_pay_money'] = number_format($info['total']['total_pay_money'], 0, '.', '');
        if ($is_excel) {
            $headerArray = array(
                '时间', '消耗', '展示', '点击', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '新增付费人数', '新增付费率', '新增付费成本', '新增付费金额', '新增ROI', '新增ARPU', '新增ARPPU', '付费人数', '总充值', '总ROI'
            );
            $excel_data = array();
            $excel_data[] = array(
                '汇总',
                '¥' . $info['total']['total_cost'],
                $info['total']['total_display'],
                $info['total']['total_click'],
                $info['total']['total_reg'],
                '¥' . $info['total']['reg_cost'],
                $info['total']['total_retain'],
                $info['total']['retain_rate'],
                '¥' . $info['total']['retain_cost'],
                $info['total']['total_new_pay'],
                $info['total']['new_pay_rate'],
                '¥' . $info['total']['new_pay_cost'],
                '¥' . $info['total']['total_new_pay_money'],
                $info['total']['new_ROI'],
                '¥' . $info['total']['new_ARPU'],
                '¥' . $info['total']['new_ARPPU'],
                $info['total']['total_pay'],
                '¥' . $info['total']['total_pay_money'],
                $info['total']['ROI'],
            );
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['date'],
                    '¥' . number_format($v['cost'] / 100, 2, '.', ''),
                    $v['display'],
                    $v['click'],
                    $v['reg'],
                    '¥' . (($v['reg'] > 0) ? (number_format($v['cost'] / 100 / $v['reg'], 2, '.', '')) : 0),
                    $v['retain1'],
                    ($v['reg'] > 0) ? (number_format($v['retain1'] * 100 / $v['reg'], 2, '.', '') . '%') : '0%',
                    '¥' . (($v['retain1'] > 0) ? (number_format($v['cost'] / 100 / $v['retain1'], 2, '.', '')) : 0),
                    $v['new_pay'],
                    ($v['reg'] > 0) ? (number_format($v['new_pay'] * 100 / $v['reg'], 2, '.', '') . '%') : '0%',
                    '¥' . (($v['new_pay'] > 0) ? (number_format($v['cost'] / 100 / $v['new_pay'], 2, '.', '')) : 0),
                    '¥' . number_format($v['new_pay_money'] / 100, 2, '.', ''),
                    ($v['cost'] > 0) ? (number_format($v['new_pay_money'] * 100 / $v['cost'], 2, '.', '') . '%') : '0%',
                    '¥' . (($v['reg'] > 0) ? (number_format($v['new_pay_money'] / 100 / $v['reg'], 2, '.', '')) : 0),
                    '¥' . (($v['new_pay'] > 0) ? (number_format($v['new_pay_money'] / 100 / $v['new_pay'], 2, '.', '')) : 0),
                    $v['pay'],
                    '¥' . number_format($v['pay_money'] / 100, 2, '.', ''),
                    ($v['cost'] > 0) ? (number_format($v['pay_money'] * 100 / $v['cost'], 2, '.', '') . '%') : '0%',
                );

            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            $filename = '在' . $sdate . '—' . $edate . '时间段内注册  ' . $pay_sdate . '—' . $pay_edate . ' 时间段内充值用户 ' . $game_name . ' 分日分渠道效果表';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }


        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($pay_sdate);
        LibUtil::clean_xss($pay_edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['psdate'] = $pay_sdate;
        $info['pedate'] = $pay_edate;

        $info['monitor_id'] = $monitor_id;
        if ($game_id) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($game_id);
        }

        //print_r($info);die;
        return $info;
    }

    public function hourLand($page, $package_name, $game_id, $channel_id, $sdate, $edate, $all, $is_excel = 0)
    {
        $page = $page < 1 ? 1 : $page;
        if ($sdate == '') {
            $sdate = date('Y-m-d');
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        if ($channel_id) {
            $channel_id = implode(',', $channel_id);
        }
        $info = $this->mod->hourLand($page, $package_name, $game_id, $channel_id, $sdate, $edate, $all, $is_excel);
        if ($info['total']['c'] > 0) {
            foreach ($info['list'] as $key => $val) {
                if ($val['click']) {
                    $info['list'][$key]['complete_rate'] = number_format($val['complete_load'] / $val['click'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['download_rate'] = number_format($val['download'] / $val['complete_load'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['active_rate'] = number_format($val['active_num'] / $val['complete_load'] * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['complete_rate'] = '0%';
                    $info['list'][$key]['download_rate'] = '0%';
                    $info['list'][$key]['active_rate'] = '0%';
                }


            }

        }
        if ($is_excel > 0) {
            $headerArray = array(
                '时间段', '包标识', '链接', '落地页模板', '点击数', '加载完成数', '加载完成率', '下载数', '下载率', '激活数', '激活率', '注册数'
            );

            $excel_data = array();
            foreach ($info['list'] as $key => $u) {
                $excel_data[] = array(
                    $u['date'],
                    $u['package_name'],
                    CDN_URL . $u['page_url'] . '/index.html',
                    $u['page_name'],
                    $u['click'],
                    $u['complete_load'],
                    $u['complete_rate'],
                    $u['download'],
                    $u['download_rate'],
                    $u['active_num'],
                    $u['active_rate'],
                    $u['reg'],
                );
            }
            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' 分时段落地页转化表（安卓）';
            return array(
                'filename' => $filename,
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['package_name'] = $package_name;
        if ($game_id) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($game_id);
        }
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return $info;
    }

    public function diffBetweenTwoDays($day1, $day2)
    {

        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }

    public function getUserList()
    {
        return $this->mod->getUserList();
    }

    /**
     * 推广数据总表
     * @param string $rsdate
     * @param string $redate
     * @param string $psdate
     * @param string $pedate
     * @param int $type
     * @param int $parent_id
     * @param int $children_id
     * @param int $device_type
     * @param int $channel_id
     * @param int $user_id
     * @param int $monitor_id
     * @param int $group_id
     * @return array|bool|resource|string
     */
    public function channelOverview_bak($rsdate = '', $redate = '', $psdate = '', $pedate = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0, $channel_id = 0, $user_id = 0, $monitor_id = 0, $group_id = 0)
    {
        $day = array(1, 2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150);
        $total = [];

        $date = date('Y-m-d');
        if (!$rsdate && !$redate) {
            $rsdate = $redate = $date;
        }
        if (!$psdate && !$pedate) {
            $psdate = $pedate = $date;
        }

        $d = LibUtil::getDateFormat($rsdate, $redate);
        $rsdate = $d['s'];
        $redate = $d['e'];

        $d = LibUtil::getDateFormat($psdate, $pedate);
        $psdate = $d['s'];
        $pedate = $d['e'];

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        ksort($allChannel);

        $games_data = $srvPlatform->getAllGame(true);
        $games = $games_data['list'];

        $groups = [];
        $tmp = $srvAd->getAllDeliveryGroup();
        foreach ($tmp as $v) {
            $groups[$v['group_id']] = $v['group_name'];
        }

        $data['day'] = $day;
        $data['games'] = $games_data;
        $data['_channels'] = $allChannel;
        $data['_groups'] = $groups;
        $data['rsdate'] = $rsdate;
        $data['redate'] = $redate;
        $data['psdate'] = $psdate;
        $data['pedate'] = $pedate;
        $data['type'] = $type;
        $data['parent_id'] = $parent_id;
        $data['children_id'] = $children_id;
        $data['device_type'] = $device_type;
        $data['channel_id'] = $channel_id;
        $data['user_id'] = $user_id;
        $data['monitor_id'] = $monitor_id;
        $data['group_id'] = $group_id;

        if ($type <= 0) {
            $data['type'] = 7;

            return $data;
        }

        $monitor = $srvAd->getAllMonitor($children_id, $channel_id);
        $userlist = $this->getAllChannelUser($channel_id);

        $data['_monitors'] = $monitor;
        $data['_users'] = $userlist;

        $info = $this->mod->channelOverview($day, $rsdate, $redate, $psdate, $pedate, $type, $parent_id, $children_id, $device_type, $channel_id, $user_id, $monitor_id, $group_id);
        foreach ($info as &$row) {
            //合计
            foreach ($row as $key => $val) {
                if ($key == 'group_name') {
                    continue;
                }
                $total[$key] += $val;
            }

            $row['consume'] = bcdiv($row['consume'], 100, 2);
            $row['new_pay_money'] = bcdiv($row['new_pay_money'], 100, 2);
            $row['period_pay_money'] = bcdiv($row['period_pay_money'], 100, 2);
            $row['total_pay_money'] = bcdiv($row['total_pay_money'], 100, 2);
            $row['active_pay_money'] = bcdiv($row['active_pay_money'], 100, 2);
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
            }

            if ($row['reg'] > 0) {
                //注册单价
                $row['reg_cost'] = bcdiv($row['consume'], $row['reg'], 2);
                //新增付费率
                $row['new_pay_rate'] = bcdiv($row['new_pay_count'] * 100, $row['reg'], 2) . '%';
                //新增ARPU
                $row['new_pay_arpu'] = bcdiv($row['new_pay_money'], $row['reg'], 2);
                //周期付费率
                $row['period_pay_rate'] = bcdiv($row['period_pay_count'] * 100, $row['reg'], 2) . '%';
                //累计付费率
                $row['total_pay_rate'] = bcdiv($row['total_pay_count'] * 100, $row['reg'], 2) . '%';

                foreach ($day as $d) {
                    //留存数据
                    if (!empty($row['retain' . $d])) {
                        $row['retain_rate' . $d] = bcdiv($row['retain' . $d] * 100, $row['reg'], 2) . '%';
                    }
                }
            }
            if ($row['new_pay_count'] > 0) {
                //新增ARPPU
                $row['new_pay_arppu'] = bcdiv($row['new_pay_money'], $row['new_pay_count'], 2);
            }
            if ($row['consume'] > 0) {
                //新增回本率
                $row['new_pay_back_rate'] = bcdiv($row['new_pay_money'] * 100, $row['consume'], 2) . '%';
                //周期回本率
                $row['period_pay_back_rate'] = bcdiv($row['period_pay_money'] * 100, $row['consume'], 2) . '%';
                //累计回本率
                $row['total_pay_back_rate'] = bcdiv($row['total_pay_money'] * 100, $row['consume'], 2) . '%';
            }
            if ($row['click'] > 0) {
                //点击激活率
                $row['click_active_rate'] = bcdiv($row['active'] * 100, $row['click'], 2) . '%';
                //点击注册率
                $row['click_reg_rate'] = bcdiv($row['reg'] * 100, $row['click'], 2) . '%';
            }
            if ($row['active'] > 0) {
                //激活注册率
                $row['active_reg_rate'] = bcdiv($row['reg'] * 100, $row['active'], 2) . '%';
            }
        }

        $total['consume'] = bcdiv($total['consume'], 100, 2);
        $total['new_pay_money'] = bcdiv($total['new_pay_money'], 100, 2);
        $total['period_pay_money'] = bcdiv($total['period_pay_money'], 100, 2);
        $total['total_pay_money'] = bcdiv($total['total_pay_money'], 100, 2);
        $total['active_pay_money'] = bcdiv($total['active_pay_money'], 100, 2);

        if ($total['reg'] > 0) {
            //注册单价
            $total['reg_cost'] = bcdiv($total['consume'], $total['reg'], 2);
            //新增付费率
            $total['new_pay_rate'] = bcdiv($total['new_pay_count'] * 100, $total['reg'], 2) . '%';
            //新增ARPU
            $total['new_pay_arpu'] = bcdiv($total['new_pay_money'], $total['reg'], 2);
            //周期付费率
            $total['period_pay_rate'] = bcdiv($total['period_pay_count'] * 100, $total['reg'], 2) . '%';
            //累计付费率
            $total['total_pay_rate'] = bcdiv($total['total_pay_count'] * 100, $total['reg'], 2) . '%';

            foreach ($day as $d) {
                //留存数据
                if (!empty($total['retain' . $d])) {
                    $total['retain_rate' . $d] = bcdiv($total['retain' . $d] * 100, $total['reg'], 2) . '%';
                }
                //LTV数据
                if (!empty($total['ltv_money' . $d])) {
                    $total['ltv' . $d] = bcdiv($total['ltv_money' . $d] / 100, $total['reg'], 2);
                }
            }
        }
        if ($total['new_pay_count'] > 0) {
            //新增ARPPU
            $total['new_pay_arppu'] = bcdiv($total['new_pay_money'], $total['new_pay_count'], 2);
        }
        if ($total['consume'] > 0) {
            //新增回本率
            $total['new_pay_back_rate'] = bcdiv($total['new_pay_money'] * 100, $total['consume'], 2) . '%';
            //周期回本率
            $total['period_pay_back_rate'] = bcdiv($total['period_pay_money'] * 100, $total['consume'], 2) . '%';
            //累计回本率
            $total['total_pay_back_rate'] = bcdiv($total['total_pay_money'] * 100, $total['consume'], 2) . '%';
        }
        if ($total['click'] > 0) {
            //点击激活率
            $total['click_active_rate'] = bcdiv($total['active'] * 100, $total['click'], 2) . '%';
            //点击注册率
            $total['click_reg_rate'] = bcdiv($total['reg'] * 100, $total['click'], 2) . '%';
        }
        if ($total['active'] > 0) {
            //激活注册率
            $total['active_reg_rate'] = bcdiv($total['reg'] * 100, $total['active'], 2) . '%';
        }

        $data['list'] = $info;
        $data['total'] = $total;

        return $data;
    }

    public function channelOverview($param = [])
    {
        $rsdate = trim($param['rsdate']);
        $redate = trim($param['redate']);
        $psdate = trim($param['psdate']);
        $pedate = trim($param['pedate']);
        $type = (int)$param['type'];
        $parent_id = $param['parent_id'];
        $children_id = $param['children_id'];
        $device_type = (int)$param['device_type'];
        $channel_id = $param['channel_id'];
        $user_id = $param['user_id'];
        $monitor_id = $param['monitor_id'];
        $group_id = $param['group_id'];

        $day = array(1, 2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150);
        $day_ltv = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 45, 60, 90, 120, 150);
        $total = $key_data = [];

        $date = date('Y-m-d');
        if (!$rsdate && !$redate) {
            $rsdate = $redate = $date;
        }
        if (!$psdate && !$pedate) {
            $psdate = $pedate = $date;
        }

        $d = LibUtil::getDateFormat($rsdate, $redate);
        $rsdate = $d['s'];
        $redate = $d['e'];

        $d = LibUtil::getDateFormat($psdate, $pedate);
        $psdate = $d['s'];
        $pedate = $d['e'];

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        ksort($allChannel);

        $games_data = $srvPlatform->getAllGame(true);
        $games = $games_data['list'];

        $groups = [];
        $tmp = $srvAd->getAllDeliveryGroup();
        foreach ($tmp as $v) {
            $groups[$v['group_id']] = $v['group_name'];
        }

        $data['day'] = $day;
        $data['day_ltv'] = $day_ltv;
        $data['games'] = $games_data;
        $data['_channels'] = $allChannel;
        $data['_groups'] = $groups;
        $data['rsdate'] = $rsdate;
        $data['redate'] = $redate;
        $data['psdate'] = $psdate;
        $data['pedate'] = $pedate;
        $data['type'] = $type;
        $data['parent_id'] = $parent_id;
        $data['children_id'] = $children_id;
        $data['device_type'] = $device_type;
        $data['channel_id'] = $channel_id;
        $data['user_id'] = $user_id;
        $data['monitor_id'] = $monitor_id;
        $data['group_id'] = $group_id;

        if ($type <= 0) {
            $data['type'] = 7;

            return $data;
        }

        $monitor = $srvAd->getAllMonitor($children_id, $channel_id);
        $userlist = $this->getAllChannelUser($channel_id);

        $data['_monitors'] = $monitor;
        $data['_users'] = $userlist;

        $info = $this->mod->channelOverview($day, $rsdate, $redate, $psdate, $pedate, $type, $parent_id, $children_id, $device_type, $channel_id, $user_id, $monitor_id, $group_id);
        foreach ($info as &$row) {
            foreach ($day as $d) {
                $row['roi_cost' . $d] = $row['consume'];
                $row['retain_reg' . $d] = $row['reg'];
                $row['ltv_reg' . $d] = $row['reg'];

                //LTV
                $row['ltv' . $d] = $row['reg'] > 0 && $row['ltv_money' . $d] > 0 ? round($row['ltv_money' . $d] / 100 / $row['reg'], 2) : '';
                //ROI
                $row['roi' . $d] = $row['consume'] > 0 && $row['ltv_money' . $d] > 0 ? round($row['ltv_money' . $d] / $row['consume'] * 100, 2) . '%' : '';

                //按注册日期归类
                if ($type == 7) {
                    $arr = LibUtil::getDateFormat($row['group_name'], $date);
                    if ($d > $arr['d']) {
                        $row['ltv' . $d] = 0;
                        $row['ltv_money' . $d] = 0;
                        $row['ltv_reg' . $d] = 0;
                        $row['roi' . $d] = 0;
                        $row['roi_cost' . $d] = 0;
                        $row['retain_reg' . $d] = 0;
                    }
                }
                $row['ltv' . $d] > 0 || $row['ltv' . $d] = '';

                $row['ltv_roi_sort' . $d] = (float)$row['ltv' . $d];
                $row['ltv_roi' . $d] = ($row['ltv' . $d] || $row['roi' . $d]) ? '<span style="color: #a94442;">' . $row['ltv' . $d] . '</span> / <span style="color: #3d9970;">' . $row['roi' . $d] . '</span>' : '';
            }

            //合计
            foreach ($row as $key => $val) {
                if ($key == 'group_name') {
                    continue;
                }
                $total[$key] += (float)$val;
            }
            //消耗
            $row['consume'] = $row['consume'] / 100;
            $row['consume_str'] = number_format($row['consume'], 2);
            //新增付费额
            $row['new_pay_money'] = $row['new_pay_money'] / 100;
            $row['new_pay_money_str'] = number_format($row['new_pay_money'], 2);
            //周期付费额
            $row['period_pay_money'] = $row['period_pay_money'] / 100;
            $row['period_pay_money_str'] = number_format($row['period_pay_money'], 2);
            //累计付费额
            $row['total_pay_money'] = $row['total_pay_money'] / 100;
            $row['total_pay_money_str'] = number_format($row['total_pay_money'], 2);
            //活跃付费金额
            $row['active_pay_money'] = $row['active_pay_money'] / 100;
            $row['active_pay_money_str'] = number_format($row['active_pay_money'], 2);
            $row['new_game_money'] = $row['new_game_money'] / 100;
            $row['new_game_money_str'] = number_format($row['new_game_money'], 2);

            $row['field'] = $row['group_name'];

            $key_data[] = $row['group_name'];

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
            }

            if (empty($row['group_name'])) {
                $row['group_name'] = '-';
            }

            if ($row['reg'] > 0) {
                //注册单价
                $row['reg_cost'] = bcdiv($row['consume'], $row['reg'], 2);
                //新增付费率
                $row['new_pay_rate'] = sprintf('%05.2f', $row['new_pay_count'] / $row['reg'] * 100, $row['reg']) . '%';

                //新增ARPU
                $row['new_pay_arpu'] = bcdiv($row['new_pay_money'], $row['reg'], 2);
                //周期付费率
                $row['period_pay_rate'] = sprintf('%05.2f', $row['period_pay_count'] / $row['reg'] * 100) . '%';
                //累计付费率
                $row['total_pay_rate'] = sprintf('%05.2f', $row['total_pay_count'] / $row['reg'] * 100) . '%';

                foreach ($day as $d) {
                    //留存数据
                    if (!empty($row['retain' . $d])) {
                        $row['retain_rate' . $d] = sprintf('%05.2f', $row['retain' . $d] / $row['reg'] * 100) . '%';
                        $row['retain_str' . $d] = $row['retain' . $d] . ' / <span style="color: #3d9970;">' . $row['retain_rate' . $d] . '</span>';
                        $row['retain_rate_sort' . $d] = $row['retain_rate' . $d];
                    }
                }
            }
            if ($row['new_pay_count'] > 0) {
                //新增ARPPU
                $row['new_pay_arppu'] = bcdiv($row['new_pay_money'], $row['new_pay_count'], 2);
            }
            if ($row['consume'] > 0) {
                //新增回本率
                $row['new_pay_back_rate'] = sprintf('%05.2f', $row['new_pay_money'] / $row['consume'] * 100) . '%';
                //周期回本率
                $row['period_pay_back_rate'] = sprintf('%05.2f', $row['period_pay_money'] / $row['consume'] * 100) . '%';
                //累计回本率
                $row['total_pay_back_rate'] = sprintf('%05.2f', $row['total_pay_money'] / $row['consume'] * 100) . '%';
            }
            if ($row['click'] > 0) {
                //点击激活率
                $row['click_active_rate'] = sprintf('%05.2f', $row['active'] / $row['click'] * 100) . '%';
                //点击注册率
                $row['click_reg_rate'] = sprintf('%05.2f', $row['reg'] / $row['click'] * 100) . '%';
            }
            if ($row['active'] > 0) {
                //激活注册率
                $row['active_reg_rate'] = sprintf('%05.2f', $row['reg'] / $row['active'] * 100) . '%';
            }
            //注册用户查询
            if ($row['reg'] > 0) {
                $row['reg_sort'] = $row['reg'];
                $row['reg'] = $row['reg'] . ' <a href="/?ct=adData&ac=queryUser&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
            //新增用户查询
            if ($row['new_pay_count'] > 0) {
                $row['new_pay_count_sort'] = $row['new_pay_count'];
                $row['new_pay_count'] = $row['new_pay_count'] . ' <a href="/?ct=adData&ac=queryPay&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
            //累计付费用户查询
            if ($row['total_pay_count'] > 0) {
                $row['total_pay_count_sort'] = $row['total_pay_count'];
                $row['total_pay_count'] = $row['total_pay_count'] . ' <a href="/?ct=adData&ac=queryTotalPay&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
            //活跃付费用户查询
            if ($row['active_pay_count'] > 0) {
                $row['active_pay_count_sort'] = $row['active_pay_count'];
                $row['active_pay_count'] = $row['active_pay_count'] . ' <a href="/?ct=adData&ac=queryActive&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
        }

        //消耗
        $total['consume'] = $total['consume'] / 100;
        $total['consume_str'] = number_format($total['consume'], 2);
        //新增付费额
        $total['new_pay_money'] = $total['new_pay_money'] / 100;
        $total['new_pay_money_str'] = number_format($total['new_pay_money'], 2);
        //周期付费额
        $total['period_pay_money'] = $total['period_pay_money'] / 100;
        $total['period_pay_money_str'] = number_format($total['period_pay_money'], 2);
        //累计付费额
        $total['total_pay_money'] = $total['total_pay_money'] / 100;
        $total['total_pay_money_str'] = number_format($total['total_pay_money'], 2);
        //活跃付费金额
        $total['active_pay_money'] = $total['active_pay_money'] / 100;
        $total['active_pay_money_str'] = number_format($total['active_pay_money'], 2);
        //新游戏 新增付费额-老用户
        $total['new_game_money_str'] = $total['new_game_money'] / 100;

        foreach ($day as $d) {
            if (!empty($total['ltv_money' . $d])) {
                //LTV数据
                $total['ltv' . $d] = bcdiv($total['ltv_money' . $d] / 100, $total['ltv_reg' . $d], 2);
                //ROI数据
                $total['roi' . $d] = $total['roi_cost' . $d] > 0 ? round($total['ltv_money' . $d] / $total['roi_cost' . $d] * 100, 2) . '%' : '';
            }
            $total['ltv' . $d] > 0 || $total['ltv' . $d] = '';
            $total['ltv_roi' . $d] = ($total['ltv' . $d] || $total['roi' . $d]) ? '<span style="color: #a94442;">' . $total['ltv' . $d] . '</span> / <span style="color: #3d9970;">' . $total['roi' . $d] . '</span>' : '';

            //留存数据
            if (!empty($total['retain' . $d])) {
                $total['retain_rate' . $d] = sprintf('%05.2f', $total['retain' . $d] / $total['retain_reg' . $d] * 100) . '%';
                $total['retain_str' . $d] = $total['retain' . $d] . ' / <span style="color: #3d9970;">' . $total['retain_rate' . $d] . '</span>';
            }
        }

        if ($total['reg'] > 0) {
            //注册单价
            $total['reg_cost'] = bcdiv($total['consume'], $total['reg'], 2);
            //新增付费率
            $total['new_pay_rate'] = sprintf('%05.2f', $total['new_pay_count'] / $total['reg'] * 100) . '%';
            //新增ARPU
            $total['new_pay_arpu'] = bcdiv($total['new_pay_money'], $total['reg'], 2);
            //周期付费率
            $total['period_pay_rate'] = sprintf('%05.2f', $total['period_pay_count'] / $total['reg'] * 100) . '%';
            //累计付费率
            $total['total_pay_rate'] = sprintf('%05.2f', $total['total_pay_count'] / $total['reg'] * 100) . '%';
        }
        if ($total['new_pay_count'] > 0) {
            //新增ARPPU
            $total['new_pay_arppu'] = bcdiv($total['new_pay_money'], $total['new_pay_count'], 2);
        }
        if ($total['consume'] > 0) {
            //新增回本率
            $total['new_pay_back_rate'] = sprintf('%05.2f', $total['new_pay_money'] / $total['consume'] * 100) . '%';
            //周期回本率
            $total['period_pay_back_rate'] = sprintf('%05.2f', $total['period_pay_money'] / $total['consume'] * 100) . '%';
            //累计回本率
            $total['total_pay_back_rate'] = sprintf('%05.2f', $total['total_pay_money'] / $total['consume'] * 100) . '%';
        }
        if ($total['click'] > 0) {
            //点击激活率
            $total['click_active_rate'] = sprintf('%05.2f', $total['active'] / $total['click'] * 100) . '%';
            //点击注册率
            $total['click_reg_rate'] = sprintf('%05.2f', $total['reg'] / $total['click'] * 100) . '%';
        }
        if ($total['active'] > 0) {
            //激活注册率
            $total['active_reg_rate'] = sprintf('%05.2f', $total['reg'] / $total['active'] * 100) . '%';
        }
        //注册用户查询
        if ($total['reg'] > 0) {
            $total['reg'] = $total['reg'] . ' <a href="/?ct=adData&ac=queryUser&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }
        //新增用户查询
        if ($total['new_pay_count'] > 0) {
            $total['new_pay_count'] = $total['new_pay_count'] . ' <a href="/?ct=adData&ac=queryPay&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }
        //累计付费用户查询
        if ($total['total_pay_count'] > 0) {
            $total['total_pay_count'] = $total['total_pay_count'] . ' <a href="/?ct=adData&ac=queryTotalPay&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }
        //活跃付费用户查询
        if ($total['active_pay_count'] > 0) {
            $total['active_pay_count'] = $total['active_pay_count'] . ' <a href="/?ct=adData&ac=queryActive&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }

        $data['list'] = $info;
        $data['total'] = $total;

        return $data;
    }

    /**
     * 获取用户组
     * @param int $channel_id
     * @return array|bool|resource|string
     */
    public function getUserByChannel($channel_id = 0)
    {
        $SrvExtend = new SrvExtend();
        return $SrvExtend->getUserByChannel($channel_id);
    }

    /**
     * 获取投放账号
     * @param int $channel_id
     * @return array
     */
    public function getAllChannelUser($channel_id = 0)
    {
        $list = [];
        $tmp = $this->mod->getAllChannelUser($channel_id);
        foreach ($tmp as $v) {
            $list[$v['user_id']] = $v['user_name'];
        }
        return $list;
    }

    /**
     * 获取用户列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function queryUser($param = [], $page = 1, $limit = 15)
    {
        $srvAd = new SrvAd();
        $channel = $srvAd->getAllChannel();
        $games = LibUtil::config('games');
        $info = $this->mod->queryUser($param, $page, $limit);
        foreach ($info['list'] as &$row) {
            $date = $row['reg_time'] > 0 ? date('Ymd', $row['reg_time']) : 0;

            $row['parent_name'] = $games[$row['parent_id']]['name'];
            $row['game_name'] = $games[$row['game_id']]['name'];
            $row['channel_name'] = $channel[$row['channel_id']];
            $row['reg_time'] = $row['reg_time'] > 0 ? date('Y-m-d H:i:s', $row['reg_time']) : '';
            $row['active_time'] = $row['active_time'] > 0 ? date('Y-m-d H:i:s', $row['active_time']) : '';
            $row['last_login_time'] = $row['last_login_time'] > 0 ? date('Y-m-d H:i:s', $row['last_login_time']) : '';

            //注册当天最高等级
            $arr = $this->mod->getRegMaxlevel($row['uid'], $row['game_id'], $date);
            $row['reg_maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';

            //最高等级
            $arr = $this->mod->getMaxlevel($row['uid'], $row['game_id']);
            $row['maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';
        }

        return $info;
    }

    /**
     * 获取充值用户列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function queryPay($param = [], $page = 1, $limit = 15)
    {
        $srvAd = new SrvAd();
        $channel = $srvAd->getAllChannel();
        $games = LibUtil::config('games');
        $info = $this->mod->queryPay($param, $page, $limit);
        foreach ($info['list'] as &$row) {
            $date = $row['reg_time'] > 0 ? date('Ymd', $row['reg_time']) : 0;

            $row['new_pay_money'] /= 100;
            $row['arppu'] = round($row['new_pay_money'] / $row['new_pay_sum'], 2);
            $row['last_pay_time'] = $row['last_pay_time'] > 0 ? date('Y-m-d H:i:s', $row['last_pay_time']) : '';
            $row['parent_name'] = $games[$row['parent_id']]['name'];
            $row['game_name'] = $games[$row['game_id']]['name'];
            $row['pay_game_name'] = $games[$row['pay_game_id']]['name'];
            $row['channel_name'] = $channel[$row['channel_id']];
            $row['reg_time'] = $row['reg_time'] > 0 ? date('Y-m-d H:i:s', $row['reg_time']) : '';
            $row['active_time'] = $row['active_time'] > 0 ? date('Y-m-d H:i:s', $row['active_time']) : '';
            $row['last_login_time'] = $row['last_login_time'] > 0 ? date('Y-m-d H:i:s', $row['last_login_time']) : '';

            //注册当天最高等级
            $arr = $this->mod->getRegMaxlevel($row['uid'], $row['game_id'], $date);
            $row['reg_maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';

            //最高等级
            $arr = $this->mod->getMaxlevel($row['uid'], $row['game_id']);
            $row['maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';
        }

        return $info;
    }

    /**
     * 获取活跃用户列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function queryActive($param = [], $page = 1, $limit = 15)
    {
        $srvAd = new SrvAd();
        $channel = $srvAd->getAllChannel();
        $games = LibUtil::config('games');
        $info = $this->mod->queryActive($param, $page, $limit);
        foreach ($info['list'] as &$row) {
            $date = $row['reg_time'] > 0 ? date('Ymd', $row['reg_time']) : 0;

            $row['active_pay_money'] /= 100;
            $row['arppu'] = round($row['active_pay_money'] / $row['active_pay_sum'], 2);
            $row['parent_name'] = $games[$games[$row['game_id']]['parent_id']]['name'];
            $row['game_name'] = $games[$row['game_id']]['name'];
            $row['pay_game_name'] = $games[$row['pay_game_id']]['name'];
            $row['channel_name'] = $channel[$row['channel_id']];
            $row['reg_time'] = $row['reg_time'] > 0 ? date('Y-m-d H:i:s', $row['reg_time']) : '';
            $row['active_time'] = $row['active_time'] > 0 ? date('Y-m-d H:i:s', $row['active_time']) : '';
            $row['last_login_time'] = $row['last_login_time'] > 0 ? date('Y-m-d H:i:s', $row['last_login_time']) : '';

            //注册当天最高等级
            $arr = $this->mod->getRegMaxlevel($row['uid'], $row['game_id'], $date);
            $row['reg_maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';

            //最高等级
            $arr = $this->mod->getMaxlevel($row['uid'], $row['game_id']);
            $row['maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';
        }

        return $info;
    }

    /**
     * 累计付费列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function queryTotalPay($param = [], $page = 1, $limit = 15)
    {
        $srvAd = new SrvAd();
        $channel = $srvAd->getAllChannel();
        $games = LibUtil::config('games');
        $info = $this->mod->queryTotalPay($param, $page, $limit);
        foreach ($info['list'] as &$row) {
            $date = $row['reg_time'] > 0 ? date('Ymd', $row['reg_time']) : 0;

            $row['total_pay_money'] /= 100;
            $row['arppu'] = round($row['total_pay_money'] / $row['total_pay_num'], 2);
            $row['parent_name'] = $games[$games[$row['game_id']]['parent_id']]['name'];
            $row['game_name'] = $games[$row['game_id']]['name'];
            $row['pay_game_name'] = $games[$row['pay_game_id']]['name'];
            $row['channel_name'] = $channel[$row['channel_id']];
            $row['reg_time'] = $row['reg_time'] > 0 ? date('Y-m-d H:i:s', $row['reg_time']) : '';
            $row['active_time'] = $row['active_time'] > 0 ? date('Y-m-d H:i:s', $row['active_time']) : '';
            $row['last_login_time'] = $row['last_login_time'] > 0 ? date('Y-m-d H:i:s', $row['last_login_time']) : '';

            //注册当天最高等级
            $arr = $this->mod->getRegMaxlevel($row['uid'], $row['game_id'], $date);
            $row['reg_maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';

            //最高等级
            $arr = $this->mod->getMaxlevel($row['uid'], $row['game_id']);
            $row['maxlevel'] = $arr['maxlevel'] ? (int)$arr['maxlevel'] : '';
        }

        return $info;
    }

    public function channelOverviewSp($param = [])
    {
        $rsdate = trim($param['rsdate']);
        $redate = trim($param['redate']);
        $psdate = trim($param['psdate']);
        $pedate = trim($param['pedate']);
        $type = (int)$param['type'];
        $parent_id = $param['parent_id'];
        $children_id = $param['children_id'];
        $device_type = (int)$param['device_type'];
        $channel_id = $param['channel_id'];
        $user_id = $param['user_id'];
        $monitor_id = $param['monitor_id'];
        $group_id = $param['group_id'];

        $day = array(1, 2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150);
        $day_ltv = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 45, 60, 90, 120, 150);
        $total = $key_data = [];

        $date = date('Y-m-d');
        if (!$rsdate && !$redate) {
            $rsdate = $redate = $date;
        }
        if (!$psdate && !$pedate) {
            $psdate = $pedate = $date;
        }

        $d = LibUtil::getDateFormat($rsdate, $redate);
        $rsdate = $d['s'];
        $redate = $d['e'];

        $d = LibUtil::getDateFormat($psdate, $pedate);
        $psdate = $d['s'];
        $pedate = $d['e'];

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        ksort($allChannel);

        $games_data = $srvPlatform->getAllGame(true);
        $games = $games_data['list'];

        $groups = [];
        $tmp = $srvAd->getAllDeliveryGroup();
        foreach ($tmp as $v) {
            $groups[$v['group_id']] = $v['group_name'];
        }

        $data['day'] = $day;
        $data['day_ltv'] = $day_ltv;
        $data['games'] = $games_data;
        $data['_channels'] = $allChannel;
        $data['_groups'] = $groups;
        $data['rsdate'] = $rsdate;
        $data['redate'] = $redate;
        $data['psdate'] = $psdate;
        $data['pedate'] = $pedate;
        $data['type'] = $type;
        $data['parent_id'] = $parent_id;
        $data['children_id'] = $children_id;
        $data['device_type'] = $device_type;
        $data['channel_id'] = $channel_id;
        $data['user_id'] = $user_id;
        $data['monitor_id'] = $monitor_id;
        $data['group_id'] = $group_id;

        if ($type <= 0) {
            $data['type'] = 7;

            return $data;
        }

        $monitor = $srvAd->getAllMonitor($children_id, $channel_id);
        $userlist = $this->getAllChannelUser($channel_id);

        $data['_monitors'] = $monitor;
        $data['_users'] = $userlist;
        $info = $this->mod->channelOverviewSp($day, $rsdate, $redate, $psdate, $pedate, $type, $parent_id, $children_id, $device_type, $channel_id, $user_id, $monitor_id, $group_id);
        foreach ($info['data'] as $tKey => &$row) {

            foreach ($day as $d) {
                $row['roi_cost' . $d] = $row['consume'];
                $row['retain_reg' . $d] = $row['reg'];
                $row['ltv_reg' . $d] = $row['reg'];

                //LTV
                $row['ltv' . $d] = $row['reg'] > 0 && $row['ltv_money' . $d] > 0 ? round($row['ltv_money' . $d] / 100 / $row['reg'], 2) : '';
                //ROI
                $row['roi' . $d] = $row['consume'] > 0 && $row['ltv_money_split' . $d] > 0 ? round($row['ltv_money_split' . $d] / $row['consume'] * 100, 2) . '%' : '';

                //按注册日期归类
                if ($type == 7) {
                    $arr = LibUtil::getDateFormat($row['group_name'], $date);
                    if ($d > $arr['d']) {
                        $row['ltv' . $d] = 0;
                        $row['ltv_money' . $d] = 0;
                        $row['ltv_reg' . $d] = 0;
                        $row['roi' . $d] = 0;
                        $row['roi_cost' . $d] = 0;
                        $row['retain_reg' . $d] = 0;
                    }
                }
                $row['ltv' . $d] > 0 || $row['ltv' . $d] = '';

                $row['ltv_roi_sort' . $d] = (float)$row['ltv' . $d];
                $row['ltv_roi' . $d] = ($row['ltv' . $d] || $row['roi' . $d]) ? '<span style="color: #a94442;">' . $row['ltv' . $d] . '</span> / <span style="color: #3d9970;">' . $row['roi' . $d] . '</span>' : '';
            }

            //合计
            foreach ($row as $key => $val) {
                if ($key == 'group_name') {
                    continue;
                }
                $total[$key] += (float)$val;
            }

            //消耗
            $row['consume'] = $row['consume'] / 100;
            $row['consume_str'] = number_format($row['consume'], 2);
            //新增付费额
            $row['new_pay_money'] = $row['new_pay_money'] / 100;
            //新增付费额-分成
            $row['new_pay_money_split'] = $row['new_pay_money_split'] / 100;

            $row['new_pay_money_str'] = number_format($row['new_pay_money'], 2);
            $row['new_pay_money_split_str'] = number_format($row['new_pay_money_split'], 2);

            //周期付费额
            $row['period_pay_money'] = $row['period_pay_money'] / 100;
            $row['period_pay_money_split'] = $row['period_pay_money_split'] / 100;
            $row['period_pay_money_str'] = number_format($row['period_pay_money'], 2);
            //周期付费额-分成
            $row['period_pay_money_str_split'] = number_format($row['period_pay_money_split'], 2);

            //累计付费额
            $row['total_pay_money'] = $row['total_pay_money'] / 100;
            $row['total_pay_money_split'] = $row['total_pay_money_split'] / 100;
            $row['total_pay_money_str'] = number_format($row['total_pay_money'], 2);
            //累计付费额-分成
            $row['total_pay_money_str_split'] = number_format($row['total_pay_money_split'], 2);

            //新增付费成本
            $row['period_cost'] /= 100;
            $row['total_cost'] /= 100;
            $row['new_pay_cost'] = ($row['new_pay_count'] > 0 && $row['consume'] > 0) ? $row['consume'] / $row['new_pay_count'] : 0;
            $row['period_pay_cost'] = ($row['period_cost'] > 0 && $row['period_pay_count'] > 0) ? $row['period_cost'] / $row['period_pay_count'] : 0;
            $row['total_pay_cost'] = ($row['total_cost'] > 0 && $row['total_pay_count'] > 0) ? $row['total_cost'] / $row['total_pay_count'] : 0;

            //活跃付费金额
            $row['active_pay_money'] = $row['active_pay_money'] / 100;
            $row['active_pay_money_split'] = $row['active_pay_money_split'] / 100;
            $row['active_pay_money_str'] = number_format($row['active_pay_money'], 2);
            //活跃付费金额-分成
            $row['active_pay_money_str_split'] = number_format($row['active_pay_money_split'], 2);
            $row['new_game_money'] = $row['new_game_money'] / 100;
            $row['new_game_money_str'] = number_format($row['new_game_money'], 2);

            $row['field'] = $row['group_name'];

            $key_data[] = $row['group_name'];

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
            }

            if (empty($row['group_name'])) {
                $row['group_name'] = '-';
            }

            if ($row['reg'] > 0) {
                //注册单价
                $row['reg_cost'] = bcdiv($row['consume'], $row['reg'], 2);
                //新增付费率
                $row['new_pay_rate'] = sprintf('%05.2f', $row['new_pay_count'] / $row['reg'] * 100, $row['reg']) . '%';

                //新增ARPU
                $row['new_pay_arpu'] = bcdiv($row['new_pay_money'], $row['reg'], 2);
                //周期付费率
                $row['period_pay_rate'] = sprintf('%05.2f', $row['period_pay_count'] / $row['reg'] * 100) . '%';
                //累计付费率
                $row['total_pay_rate'] = sprintf('%05.2f', $row['total_pay_count'] / $row['reg'] * 100) . '%';

                foreach ($day as $d) {
                    //留存数据
                    if (!empty($row['retain' . $d])) {
                        $row['retain_rate' . $d] = sprintf('%05.2f', $row['retain' . $d] / $row['reg'] * 100) . '%';
                        $row['retain_str' . $d] = $row['retain' . $d] . ' / <span style="color: #3d9970;">' . $row['retain_rate' . $d] . '</span>';
                        $row['retain_rate_sort' . $d] = $row['retain_rate' . $d];
                    }
                }
            }
            if ($row['new_pay_count'] > 0) {
                //新增ARPPU
                $row['new_pay_arppu'] = bcdiv($row['new_pay_money'], $row['new_pay_count'], 2);
            }
            if ($row['consume'] > 0) {
                //新增回本率
                $row['new_pay_back_rate'] = sprintf('%05.2f', $row['new_pay_money'] / $row['consume'] * 100) . '%';
                //新增回本率-分成
                $row['new_pay_back_rate_split'] = sprintf('%05.2f', $row['new_pay_money_split'] / $row['consume'] * 100) . '%';
                //周期回本率
                $row['period_pay_back_rate'] = sprintf('%05.2f', $row['period_pay_money'] / $row['consume'] * 100) . '%';
                //周期回本率-分成
                $row['period_pay_back_rate_split'] = sprintf('%05.2f', $row['period_pay_money_split'] / $row['consume'] * 100) . '%';
                //累计回本率
                $row['total_pay_back_rate'] = sprintf('%05.2f', $row['total_pay_money'] / $row['consume'] * 100) . '%';
                //累计回本率-分成
                $row['total_pay_back_rate_split'] = sprintf('%05.2f', $row['total_pay_money_split'] / $row['consume'] * 100) . '%';
            }
            if ($row['click'] > 0) {
                //点击激活率
                $row['click_active_rate'] = sprintf('%05.2f', $row['active'] / $row['click'] * 100) . '%';
                //点击注册率
                $row['click_reg_rate'] = sprintf('%05.2f', $row['reg'] / $row['click'] * 100) . '%';
            }
            if ($row['active'] > 0) {
                //激活注册率
                $row['active_reg_rate'] = sprintf('%05.2f', $row['reg'] / $row['active'] * 100) . '%';
            }
            //注册用户查询
            if ($row['reg'] > 0) {
                $row['reg_sort'] = $row['reg'];
                $row['reg'] = $row['reg'] . ' <a href="/?ct=adData&ac=queryUser&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
            //新增用户查询
            if ($row['new_pay_count'] > 0) {
                $row['new_pay_count_sort'] = $row['new_pay_count'];
                $row['new_pay_count'] = $row['new_pay_count'] . ' <a href="/?ct=adData&ac=queryPay&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
            //累计付费用户查询
            if ($row['total_pay_count'] > 0) {
                $row['total_pay_count_sort'] = $row['total_pay_count'];
                $row['total_pay_count'] = $row['total_pay_count'] . ' <a href="/?ct=adData&ac=queryTotalPay&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
            //活跃付费用户查询
            if ($row['active_pay_count'] > 0) {
                $row['active_pay_count_sort'] = $row['active_pay_count'];
                $row['active_pay_count'] = $row['active_pay_count'] . ' <a href="/?ct=adData&ac=queryActive&field=' . $row['field'] . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
        }

        //消耗
        $total['consume'] = $total['consume'] / 100;
        $total['consume_str'] = number_format($total['consume'], 2);
        //新增付费额
        $total['new_pay_money'] = $total['new_pay_money'] / 100;
        $total['new_pay_money_str'] = number_format($total['new_pay_money'], 2);
        //周期付费额
        $total['period_pay_money'] = $total['period_pay_money'] / 100;
        $total['period_pay_money_str'] = number_format($total['period_pay_money'], 2);
        //累计付费额
        $total['total_pay_money'] = $total['total_pay_money'] / 100;
        $total['total_pay_money_str'] = number_format($total['total_pay_money'], 2);
        //活跃付费金额
        $total['active_pay_money'] = $total['active_pay_money'] / 100;
        $total['active_pay_money_str'] = number_format($total['active_pay_money'], 2);

        //新增付费额-分成后
        $total['new_pay_money_split'] = $total['new_pay_money_split'] / 100;
        $total['new_pay_money_split_str'] = number_format($total['new_pay_money_split'], 2);

        //周期付费额-分成后
        $total['period_pay_money_split'] = $total['period_pay_money_split'] / 100;
        $total['period_pay_money_str_split'] = number_format($total['period_pay_money_split'], 2);

        //累计付费额-分成后
        $total['total_pay_money_split'] = $total['total_pay_money_split'] / 100;
        $total['total_pay_money_str_split'] = number_format($total['total_pay_money_split'], 2);

        //活跃付费额-分成后
        $total['active_pay_money_split'] = $total['active_pay_money_split'] / 100;
        $total['active_pay_money_str_split'] = number_format($total['active_pay_money_split'], 2);

        //新游戏 新增付费额-老用户
        $total['new_game_money_str'] = $total['new_game_money'] / 100;

        foreach ($day as $d) {
            if (!empty($total['ltv_money' . $d])) {
                //LTV数据
                $total['ltv' . $d] = bcdiv($total['ltv_money' . $d] / 100, $total['ltv_reg' . $d], 2);
                //$total['roi' . $d] = $total['roi_cost' . $d] > 0 ? round($total['ltv_money' . $d] / $total['roi_cost' . $d] * 100, 2) . '%' : '';
            }
            if (!empty($total['ltv_money_split' . $d])) {
                //ROI数据
                $total['roi' . $d] = $total['roi_cost' . $d] > 0 ? round($total['ltv_money_split' . $d] / $total['roi_cost' . $d] * 100, 2) . '%' : '';
            }
            $total['ltv' . $d] > 0 || $total['ltv' . $d] = '';
            $total['ltv_roi' . $d] = ($total['ltv' . $d] || $total['roi' . $d]) ? '<span style="color: #a94442;">' . $total['ltv' . $d] . '</span> / <span style="color: #3d9970;">' . $total['roi' . $d] . '</span>' : '';

            //留存数据
            if (!empty($total['retain' . $d])) {
                $total['retain_rate' . $d] = sprintf('%05.2f', $total['retain' . $d] / $total['retain_reg' . $d] * 100) . '%';
                $total['retain_str' . $d] = $total['retain' . $d] . ' / <span style="color: #3d9970;">' . $total['retain_rate' . $d] . '</span>';
            }
        }

        if ($total['reg'] > 0) {
            //注册单价
            $total['reg_cost'] = bcdiv($total['consume'], $total['reg'], 2);
            //新增付费率
            $total['new_pay_rate'] = sprintf('%05.2f', $total['new_pay_count'] / $total['reg'] * 100) . '%';
            //新增ARPU
            $total['new_pay_arpu'] = bcdiv($total['new_pay_money'], $total['reg'], 2);
            //周期付费率
            $total['period_pay_rate'] = sprintf('%05.2f', $total['period_pay_count'] / $total['reg'] * 100) . '%';
            //累计付费率
            $total['total_pay_rate'] = sprintf('%05.2f', $total['total_pay_count'] / $total['reg'] * 100) . '%';
        }
        if ($total['new_pay_count'] > 0) {
            //新增ARPPU
            $total['new_pay_arppu'] = bcdiv($total['new_pay_money'], $total['new_pay_count'], 2);
        }
        if ($total['consume'] > 0) {
            //新增回本率
            $total['new_pay_back_rate'] = sprintf('%05.2f', $total['new_pay_money'] / $total['consume'] * 100) . '%';
            //新增回本率-分成
            $total['new_pay_back_rate_split'] = sprintf('%05.2f', $total['new_pay_money_split'] / $total['consume'] * 100) . "%";
            //周期回本率
            $total['period_pay_back_rate'] = sprintf('%05.2f', $total['period_pay_money'] / $total['consume'] * 100) . '%';
            //周期回本率-分成
            $total['period_pay_back_rate_split'] = sprintf('%05.2f', $total['period_pay_money_split'] / $total['consume'] * 100) . '%';
            //累计回本率
            $total['total_pay_back_rate'] = sprintf('%05.2f', $total['total_pay_money'] / $total['consume'] * 100) . '%';
            //累计回本率-分成
            $total['total_pay_back_rate_split'] = sprintf('%05.2f', $total['total_pay_money_split'] / $total['consume'] * 100) . "%";
        }
        if ($total['click'] > 0) {
            //点击激活率
            $total['click_active_rate'] = sprintf('%05.2f', $total['active'] / $total['click'] * 100) . '%';
            //点击注册率
            $total['click_reg_rate'] = sprintf('%05.2f', $total['reg'] / $total['click'] * 100) . '%';
        }
        if ($total['active'] > 0) {
            //激活注册率
            $total['active_reg_rate'] = sprintf('%05.2f', $total['reg'] / $total['active'] * 100) . '%';
        }
        //注册用户查询
        if ($total['reg'] > 0) {
            $total['reg'] = $total['reg'] . ' <a href="/?ct=adData&ac=queryUser&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }
        //新增用户查询
        if ($total['new_pay_count'] > 0) {
            $total['new_pay_count'] = $total['new_pay_count'] . ' <a href="/?ct=adData&ac=queryPay&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }
        //累计付费用户查询
        if ($total['total_pay_count'] > 0) {
            $total['total_pay_count'] = $total['total_pay_count'] . ' <a href="/?ct=adData&ac=queryTotalPay&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }
        //活跃付费用户查询
        if ($total['active_pay_count'] > 0) {
            $total['active_pay_count'] = $total['active_pay_count'] . ' <a href="/?ct=adData&ac=queryActive&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }

        $data['list'] = array_values($info['data']);
        $data['total'] = $total;

        return $data;
    }

    /**
     * 分时推广数据
     * @param array $param
     * @return array
     */
    public function hourOverview($param)
    {
        $rsdate = trim($param['rsdate']);
        $redate = trim($param['redate']);
        $psdate = trim($param['psdate']);
        $pedate = trim($param['pedate']);
        $parent_id = $param['parent_id'];
        $children_id = $param['children_id'];
        $channel_id = $param['channel_id'];
        $user_id = $param['user_id'];
        $group_id = $param['group_id'];
        $monitor_id = $param['monitor_id'];
        $device_type = (int)$param['device_type'];

        $total = $key_data = [];
        if (!$rsdate) {
            $rsdate = date('Y-m-d', time());
        }
        if (!$redate) {
            $redate = date('Y-m-d', time());
        }
        if (!$psdate) {
            $psdate = date('Y-m-d', time());
        }
        if (!$pedate) {
            $pedate = date('Y-m-d', time());
        }

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $allChannel = $srvAd->getAllChannel();
        ksort($allChannel);
        $games_data = $srvPlatform->getAllGame(true);

        $groups = [];
        $tmp = $srvAd->getAllDeliveryGroup();
        foreach ($tmp as $v) {
            $groups[$v['group_id']] = $v['group_name'];
        }
        $data['games'] = $games_data;
        $data['_channels'] = $allChannel;
        $data['_groups'] = $groups;
        $data['rsdate'] = $rsdate;
        $data['redate'] = $redate;
        $data['psdate'] = $psdate;
        $data['pedate'] = $pedate;
        $data['parent_id'] = $parent_id;
        $data['children_id'] = $children_id;
        $data['device_type'] = $device_type;
        $data['channel_id'] = $channel_id;
        $data['user_id'] = $user_id;
        $data['monitor_id'] = $monitor_id;

        $monitor = $srvAd->getAllMonitor($children_id, $channel_id);
        $userlist = $this->getAllChannelUser($channel_id);

        $data['_monitors'] = $monitor;
        $data['_users'] = $userlist;
        $hours = range(0, 23);
        $info = $this->mod->channelOverviewByHour($rsdate, $redate, $psdate, $pedate, $parent_id, $children_id, $device_type, $channel_id, $user_id, $monitor_id, $group_id);

        foreach ($hours as $h) {
            if (!isset($info['data'][$h])) {
                $info['data'][$h] = array(
                    'group_name' => $h,
                    'reg' => 0,
                    'device' => 0,
                    'consume' => 0,
                    'new_pay_money' => 0,
                    'new_pay_count' => 0,
                    'period_pay_money' => 0,
                    'period_pay_count' => 0,
                    'total_pay_money' => 0,
                    'total_pay_count' => 0,
                    'load' => 0,
                    'ip' => 0,
                    'click' => 0,
                    'active' => 0,
                    'active_device' => 0
                );
            }
        }
        foreach ($info['data'] as $tKey => &$row) {
            //合计
            if (is_null($tKey) || (empty($tKey) && $tKey !== 0)) unset($info['data'][$tKey]);
            foreach ($row as $key => $val) {
                if ($key == 'group_name') {
                    continue;
                }
                $total[$key] += (float)$val;
            }
            //消耗
            $row['consume'] = $row['consume'] / 100;
            $row['consume_str'] = number_format($row['consume'], 2);
            //新增付费额
            $row['new_pay_money'] = $row['new_pay_money'] / 100;
            $row['new_pay_money_str'] = number_format($row['new_pay_money'], 2);

            //周期付费额
            $row['period_pay_money'] = $row['period_pay_money'] / 100;
            $row['period_pay_money_str'] = number_format($row['period_pay_money'], 2);
            //累计付费额
            $row['total_pay_money'] = $row['total_pay_money'] / 100;
            $row['total_pay_money_str'] = number_format($row['total_pay_money'], 2);

            //$row['field'] = null;
            $key_data[] = $row['group_name'];

            if (empty($row['group_name']) && $row['group_name'] !== 0) {
                $row['group_name'] = '-';
            }

            if ($row['reg'] > 0) {
                //新增ARPU
                $row['new_pay_arpu'] = bcdiv($row['new_pay_money'], $row['reg'], 2);
                //新增付费率
                $row['new_pay_rate'] = sprintf('%05.2f', $row['new_pay_count'] / $row['reg'] * 100, $row['reg']) . '%';
            }
            if ($row['new_pay_count'] > 0) {
                //新增ARPPU
                $row['new_pay_arppu'] = bcdiv($row['new_pay_money'], $row['new_pay_count'], 2);
            }

            if ($row['click'] > 0) {
                //点击激活率
                $row['click_active_rate'] = sprintf('%05.2f', $row['active'] / $row['click'] * 100) . '%';
                //点击注册率
                $row['click_reg_rate'] = sprintf('%05.2f', $row['reg'] / $row['click'] * 100) . '%';
            }
            if ($row['active'] > 0) {
                //激活注册率
                $row['active_reg_rate'] = sprintf('%05.2f', $row['reg'] / $row['active'] * 100) . '%';
            }
            //注册用户查询
            if ($row['reg'] > 0) {
                $row['reg_sort'] = $row['reg'];
                $row['reg'] = $row['reg'] . ' <a href="/?ct=adData&ac=queryUser&hour=' . $tKey . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
            //新增用户查询
            if ($row['new_pay_count'] > 0) {
                $row['new_pay_count_sort'] = $row['new_pay_count'];
                $row['new_pay_count'] = $row['new_pay_count'] . ' <a href="/?ct=adData&ac=queryPay&hour=' . $tKey . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }

            //累计付费用户查询
            if ($row['total_pay_count'] > 0) {
                $row['total_pay_count_sort'] = $row['total_pay_count'];
                $row['total_pay_count'] = $row['total_pay_count'] . ' <a href="/?ct=adData&ac=queryTotalPay&hour=' . $tKey . '&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
            }
        }
        //消耗
        $total['consume'] = $total['consume'] / 100;
        $total['consume_str'] = number_format($total['consume'], 2);
        //新增付费额
        $total['new_pay_money'] = $total['new_pay_money'] / 100;
        $total['new_pay_money_str'] = number_format($total['new_pay_money'], 2);

        //周期付费额
        $total['period_pay_money'] = $total['period_pay_money'] / 100;
        $total['period_pay_money_str'] = number_format($total['period_pay_money'], 2);

        //累计付费额
        $total['total_pay_money'] = $total['total_pay_money'] / 100;
        $total['total_pay_money_str'] = number_format($total['total_pay_money'], 2);

        if ($total['reg'] > 0) {
            //新增付费率
            $total['new_pay_rate'] = sprintf('%05.2f', $total['new_pay_count'] / $total['reg'] * 100) . '%';
            //新增ARPU
            $total['new_pay_arpu'] = bcdiv($total['new_pay_money'], $total['reg'], 2);
        }
        if ($total['new_pay_count'] > 0) {
            //新增ARPPU
            $total['new_pay_arppu'] = bcdiv($total['new_pay_money'], $total['new_pay_count'], 2);
        }
        if ($total['click'] > 0) {
            //点击激活率
            $total['click_active_rate'] = sprintf('%05.2f', $total['active'] / $total['click'] * 100) . '%';
            //点击注册率
            $total['click_reg_rate'] = sprintf('%05.2f', $total['reg'] / $total['click'] * 100) . '%';
        }
        if ($total['active'] > 0) {
            //激活注册率
            $total['active_reg_rate'] = sprintf('%05.2f', $total['reg'] / $total['active'] * 100) . '%';
        }
        //注册用户查询
        if ($total['reg'] > 0) {
            $total['reg'] = $total['reg'] . ' <a href="/?ct=adData&ac=queryUser&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }
        //新增用户查询
        if ($total['new_pay_count'] > 0) {
            $total['new_pay_count'] = $total['new_pay_count'] . ' <a href="/?ct=adData&ac=queryPay&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }

        //累计付费用户查询
        if ($total['total_pay_count'] > 0) {
            $total['total_pay_count'] = $total['total_pay_count'] . ' <a href="/?ct=adData&ac=queryTotalPay&' . http_build_query($param) . '" target="_blank" style="color: #0e9aef;">查</a>';
        }

        ksort($info['data']);
        $data['list'] = array_values($info['data']);
        $data['total'] = $total;
        return $data;
    }
}