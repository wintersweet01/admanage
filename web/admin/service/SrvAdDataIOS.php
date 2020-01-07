<?php

class SrvAdDataIOS
{

    public $mod;

    public function __construct()
    {
        $this->mod = new ModAdDataIOS();
    }


    public function packageEffect($page, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        $page = $page < 1 ? 1 : $page;
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
        $info = $this->mod->packageEffect($page, $channel_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel);

        if ($info['all']['c'] > 0) {


            if ($info['all']['reg'] > 0) {
                $info['all']['ARPU'] = number_format($info['all']['pay_money'] / $info['all']['reg'] / 100, 2, '.', '');
                $info['all']['pay_rate'] = number_format($info['all']['payer_num'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
                //$info['all']['reg_cost'] = number_format($info['all']['cost']/$info['all']['reg'],2,'.','');
                $info['all']['retain_rate'] = number_format($info['all']['retain'] / $info['all']['reg'] * 100, 2, '.', '') . '%';
            } else {
                $info['all']['ARPU'] = 0;
                $info['all']['pay_rate'] = '0%';
                //$info['all']['reg_cost'] = 0;
                $info['all']['retain_rate'] = '0%';
            }
            if ($info['all']['payer_num'] > 0) {
                // $info['all']['pay_cost'] = number_format($info['all']['cost']/$info['all']['payer_num'],2,'.','');
                $info['all']['ARPPU'] = number_format($info['all']['pay_money'] / $info['all']['payer_num'] / 100, 2, '.', '');
            } else {
                // $info['all']['pay_cost'] = 0;
                $info['all']['ARPPU'] = 0;
            }
            if ($info['all']['pay_money'] > 0) {
                $info['all']['pay_money'] = $info['all']['pay_money'] / 100;
            } else {
                $info['all']['pay_money'] = 0;
            }
            foreach ($info['list'] as $key => $val) {

                if ($val['reg'] > 0) {
                    $info['list'][$key]['ARPU'] = number_format($val['pay_money'] / $val['reg'] / 100, 2, '.', '');
                    $info['list'][$key]['pay_rate'] = number_format($val['payer_num'] / $val['reg'] * 100, 2, '.', '') . '%';
                    //$info['list'][$key]['reg_cost'] = number_format($val['cost']/$val['reg'],2,'.','');
                    $info['list'][$key]['retain_rate'] = number_format($val['retain'] / $val['reg'] * 100, 2, '.', '') . '%';
                } else {
                    $info['list'][$key]['ARPU'] = 0;
                    $info['list'][$key]['pay_rate'] = '0%';
                    //$info['list'][$key]['reg_cost'] = 0;
                    $info['list'][$key]['retain_rate'] = '0%';
                }
                if ($val['payer_num'] > 0) {
//                    $info['list'][$key]['pay_cost'] = number_format($val['cost']/$val['payer_num'],2,'.','');
                    $info['list'][$key]['ARPPU'] = number_format($val['pay_money'] / $val['payer_num'] / 100, 2, '.', '');
                } else {
//                    $info['list'][$key]['pay_cost'] = 0;
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
                '包标识', '注册', '次日留存数', '留存率', '付费人数', '付费率', '付费金额', 'ARPU', 'ARPPU'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(

                    ' ' . $v['package_name'],


                    $v['reg'],

                    $v['retain'],
                    $v['retain_rate'],

                    $v['payer_num'],
                    $v['pay_rate'],

                    '¥' . $v['pay_money'],
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
            $filename = '在' . $rsdate . '—' . $redate . '时间段内注册  ' . $psdate . '—' . $pedate . ' 时间段内充值用户 ' . $game_name . ' 分包标识效果表';

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

    public function userCycle($parent_id, $game_id, $user_id, $sdate, $edate, $is_excel = 0)
    {
        $sdate = $sdate ? $sdate : date('Y-m-d', time() - 2 * 86400);
        $edate = $edate ? $edate : date('Y-m-d', time() - 86400);

        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['user_id'] = $user_id;

        $info['list'] = $this->mod->userCycle($parent_id,$game_id, $user_id, $sdate, $edate);
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

    public function dayUserEffect($parent_id, $game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, $is_excel = 0)
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
        $info['user_id'] = $user_id;
        $info['list'] = $this->mod->dayUserEffect($parent_id, $game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id);

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
                    ' ' . $v['user_name'],
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

    public function channelCycleT($page, $game_id, $channel_id, $sdate, $edate)
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
        $info = $this->mod->channelCycleT($page, $channel_id, $game_id, $sdate, $edate);

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

    public function channelCycle($game_id, $channel_id, $sdate, $edate, $excel = 0)
    {
        $sdate = $sdate ? $sdate : date('Y-m-01', time() - 86400);
        $edate = $edate ? $edate : date('Y-m-d', time() - 86400);

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
        $info['list'] = $this->mod->channelCycle($channel_id, $game_id, $sdate, $edate);
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

    public function channelEffect($page, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
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


        $info = $this->mod->channelEffect($page, $channel_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel);
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

            $filename = '在' . $rsdate . '—' . $redate . '时间段内注册  ' . $psdate . '—' . $pedate . ' 时间段内充值用户 ' . $game_name . ' 分渠道效果表';
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

    public function activityEffect($parent_id, $game_id, $channel_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        //$page = $page < 1 ? 1 : $page;
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
        $info = $this->mod->activityEffect($parent_id, $channel_id, $game_id, $rsdate, $redate, $psdate, $pedate);

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
                '推广活动', '包标识', '消耗', '展示', '点击', '注册', '注册成本', '次日留存数', '留存率', '留存成本', '付费人数', '付费率', '付费成本', '付费金额', 'ROI', 'ARPU', 'ARPPU'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $v['name'],
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
//        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(),$info['total']['c'],$page,DEFAULT_ADMIN_PAGE_NUM);
//        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return $info;
    }

    public function dayChannelEffect($channel_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, $is_excel = 0)
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
        $info['list'] = $this->mod->dayChannelEffect($channel_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, 1);
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

    public function hourLand($page, $monitor_id, $parent_id, $game_id, $channel_id, $sdate, $edate, $all, $is_excel = 0)
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
        $info = $this->mod->hourLand($page, $monitor_id, $parent_id, $game_id, $channel_id, $sdate, $edate, $all, $is_excel);
        foreach ($info['list'] as $key => $val) {
            $info['list'][$key]['name'] = $this->mod->getMonitorName($val['monitor_id']);
        }
        if ($info['total']['c'] > 0) {
            foreach ($info['list'] as $key => $val) {

                if ($val['click']) {
                    $info['list'][$key]['complete_rate'] = number_format($val['complete_load'] / $val['click'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['download_rate'] = number_format($val['download'] / $val['click'] * 100, 2, '.', '') . '%';
                    $info['list'][$key]['active_rate'] = number_format($val['active_num'] / $val['click'] * 100, 2, '.', '') . '%';
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
        $info['monitor_id'] = $monitor_id;
        if ($game_id) {
            $modPlatform = new ModPlatform();
            $info['_Monitor'] = $modPlatform->getMonitorByGame($game_id);

        }
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return $info;
    }

    function diffBetweenTwoDays($day1, $day2)
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

    function getUserList()
    {
        return $this->mod->getUserList();
    }
}