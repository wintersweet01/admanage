<?php

class SrvRetainData
{

    private $mod;

    public function __construct()
    {
        $this->mod = new ModRetainData();
    }

    public function channelRetain($page, $parent_id, $game_id, $device_type, $channel_id, $package_name, $all, $sdate, $edate, $is_excel = 0)
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
        $allGame = $_games;
        $srvAd = new SrvAd();
        $allChannel = $srvAd->getAllChannel();
        $allChannel['0'] = '未知';
        ksort($allChannel);
        $info = $this->mod->channelRetain($page, $parent_id, $game_id, $device_type, $channel_id, $package_name, $all, $sdate, $edate, $is_excel);

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

        if ($is_excel > 0) {
            $headerArray = array(
                '游戏名称', '渠道', '游戏包', '注册量', '次日留存', '3日留存', '4日留存', '5日留存', '6日留存', '7日留存', '15日留存', '21日留存', '30日留存', '60日留存', '90日留存'
            );
            $excel_data = array();
            $excel_data[] = array('合计', '', '', $info['total']['reg'], number_format($info['total']['retain2'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain3'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain4'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain5'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain6'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain7'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain15'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain21'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain30'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain60'] * 100 / $info['total']['reg'], 2, '.', '') . '%', number_format($info['total']['retain90'] * 100 / $info['total']['reg'], 2, '.', '') . '%');

            foreach ($info['list'] as $val) {
                $excel_data[] = array(
                    ' ' . $_games[$val['game_id']],
                    ' ' . $allChannel[$val['channel_id']],
                    ' ' . $val['package_name'],
                    $val['reg'],
                    empty($val['reg']) ? '0.00%' : number_format($val['retain2'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain3'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain4'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain5'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain6'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain7'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain15'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain21'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain30'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain60'] * 100 / $val['reg'], 2, '.', '') . '%',
                    empty($val['reg']) ? '0.00%' : number_format($val['retain90'] * 100 / $val['reg'], 2, '.', '') . '%'
                );
            }

            $game_name = '';
            $device_type = '';
            $package_name = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($device_type) {
                if ($device_type == 1) {
                    $platform = 'IOS';
                } else {
                    $platform = 'Andorid';
                }
            } else {
                $platform = '全平台';
            }

            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' ' . $platform . ' ' . $package_name . ' ' . '渠道留存数  ';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excel_data
            );
        }

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($package_name);
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        $info['package_name'] = $package_name;
        $info['channel_id'] = $channel_id;
        $info['all'] = $all;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id'], 0, $info['device_type']);
        }

        return $info;
    }

    public function retain($page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child = 0, $is_excel = 0)
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
        $info = $this->mod->retain($page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child);
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
            $device_type = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($device_type) {
                if ($device_type == 1) {
                    $platform = 'IOS';
                } else {
                    $platform = 'Andorid';
                }
            } else {
                $platform = '全平台';
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' ' . $platform . ' ' . '账号留存数  ';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excel_data
            );
        }

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($package_name);
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        $info['group_child'] = $group_child;
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

    public function retainNew($day, $page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child = 0, $is_excel = 0)
    {
        empty($day) && $day = array(2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150, 180);
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
        $info = $this->mod->retainNew($day, $page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child);
        if ($info['total']['c'] > 0) {
            foreach ($info['list'] as &$v) {
                foreach ($day as $d) {
                    $queDay = intval($d - 1);
                    $v['not_now_' . $d] = strtotime($v['re_date']) + 86400 * $queDay > time() ? 1 : 0;
                }
            }
        }
        if ($is_excel > 0) {
            $headerList = $dataTotal = $excel_data = array();
            foreach ($day as $d) {
                $data = 0;
                if (!empty($info['total']['reg']) && !empty($info['total']['retain' . $d])) {
                    $data = number_format($info['total']['retain' . $d] * 100 / $info['total']['reg'], 2, '.', '') . "%";
                }
                $d == 2 && $d = '次';
                $str = $d . '日留存';
                array_push($headerList, $str);
                array_push($dataTotal, $data);
            }
            $headerFirst = array('日期', '游戏名称', '注册量');
            $headerArray = array_merge($headerFirst, $headerList);
            $excel_data[] = array_merge(array('合计', '', $info['total']['reg']), $dataTotal);

            foreach ($info['list'] as $val) {
                $excel_data1 = array(' ' . $val['re_date'], ' ' . $_games[$val['game_id']], $val['reg']);
                $excel_data2 = array();
                foreach ($day as $d) {
                    $data = !empty($val['not_now_' . $d]) ? '-' : number_format($val['retain' . $d] * 100 / $val['reg'], 2, '.', '') . '%';
                    array_push($excel_data2, $data);
                }
                $excel_data[] = array_merge($excel_data1, $excel_data2);//组合成数据
            }

            $srvPlatform = new SrvPlatform();
            $allGame = $srvPlatform->getAllGame();
            $game_name = '';
            $device_type = '';
            if ($game_id) {
                $game_name = $allGame[$game_id];
            }
            if ($device_type) {
                if ($device_type == 1) {
                    $platform = 'IOS';
                } else {
                    $platform = 'Andorid';
                }
            } else {
                $platform = '全平台';
            }
            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' ' . $platform . ' ' . '账号留存数  ';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excel_data
            );
        }

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($package_name);
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        $info['group_child'] = $group_child;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['all'] = $all;

        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id']);
        }
        return $info;
    }

    public function payRetain($param = [], $day = [])
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $device_type = (int)$param['device_type'];
        $sdate = trim($param['sdate']);
        $edate = trim($param['edate']);

        if ($sdate == '') {
            //$sdate = date('Y-m-01');
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $total = [];
        $date = date('Y-m-d');
        $info = $this->mod->payRetain($parent_id, $game_id, $device_type, $sdate, $edate, $day);
        foreach ($info as &$row) {
            foreach ($day as $d) {
                //留存数据
                if (!empty($row['retain' . $d])) {
                    $row['retain_rate' . $d] = sprintf('%05.2f', $row['retain' . $d] / $row['pay_count'] * 100) . '%';
                }

                $row['retain_reg' . $d] = $row['pay_count'];
                $arr = LibUtil::getDateFormat($row['date'], $date);
                if ($d > $arr['d']) {
                    $row['retain_reg' . $d] = 0;
                }

                $total['retain' . $d] += $row['retain' . $d];
                $total['retain_reg' . $d] += $row['retain_reg' . $d];
            }

            $total['reg_count'] += $row['reg_count'];
            $total['pay_count'] += $row['pay_count'];
        }

        foreach ($day as $d) {
            if ($total['retain_reg' . $d] > 0) {
                $total['retain_rate' . $d] = round($total['retain' . $d] / $total['retain_reg' . $d] * 100, 2) . '%';
            }
        }

        $query = array(
            'sdate' => $sdate,
            'edate' => $edate
        );

        return array('list' => $info, 'total' => $total, 'query' => $query);
    }
}