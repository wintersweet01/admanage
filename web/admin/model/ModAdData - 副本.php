<?php

class ModAdData extends Model
{

    public function __construct()
    {
        parent::__construct('default');
    }

    public function userCycle($game_id, $user_id, $sdate, $edate)
    {
        if ($user_id) {
            $sql_package_name = "select `package_name` from " . LibTable::$ad_project . " where user_id = :user_id ";
            $package_name = $this->query($sql_package_name, array('user_id' => $user_id));
            $package = '';
            foreach ($package_name as $key => $val) {
                $package .= '\'' . $val['package_name'] . '\',';
            }
            $package = rtrim($package, ',');

        }
        $sql = "select `date`,sum(`reg`) as `reg`,sum(`retain2`) as `retain1`,`package_name` from `" . LibTable::$data_retain . "` where 1  and `device_type` = " . PLATFORM['android'];

        $sql_upload = "select `date`,sum(`cost`) as `cost`,sum(`display`) as `display`,sum(`click`) as `click`,`package_name` from `" . LibTable::$data_upload . "` where 1 and `device_type` = " . PLATFORM['android'];
        $sql_all_pay = "select sum(`money`) as `pay_money`,`date`,`package_name`  from " . LibTable::$data_pay . " as p left join " . LibTable::$user_ext . " as e on e.uid = p.uid where 1  and `device_type` = " . PLATFORM['android'];

        $sql_new_pay = "select sum(`new_pay`) as `new_pay` ,sum(`new_pay_money`) as `new_pay_money`,date(`date`) as `date`,`package_name` from " . LibTable::$data_pay_new . " where 1  and `device_type` = " . PLATFORM['android'];

        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id`=:game_id ";

            $sql_upload .= " and `game_id`=:game_id ";
            $sql_all_pay .= " and p.`game_id`=:game_id ";
            $sql_new_pay .= " and `game_id`=:game_id ";
        }
        if ($user_id) {
            $sql .= " and `package_name` in ($package) ";

            $sql_upload .= " and `package_name` in ($package) ";
            $sql_all_pay .= " and `package_name` in ($package) ";
            $sql_new_pay .= " and `package_name` in ($package) ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and  `date` >= :sdate ";

            $sql_upload .= " and  `date` >= :sdate ";
            $sql_all_pay .= " and  p.`date` >= :sdate ";
            $sql_new_pay .= " and date(`date`) >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and `date` <= :edate ";

            $sql_upload .= " and `date` <= :edate ";
            $sql_all_pay .= " and p.`date` <= :edate ";
            $sql_new_pay .= " and date(`date`) <= :edate ";
        }

        $sql .= " group by `date`,`package_name` order by `date` desc ";

        $sql_upload .= " group by `date`,`package_name` ";
        $sql_all_pay .= " group by `date`,p.`uid`,`package_name` ";
        $sql_new_pay .= " group by date(`date`),`package_name` ";

        $retain = $this->query($sql, $param);

        foreach ($retain as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $retain[$key]['user_id'] = (int)$monitor_temp['user_id'];

        }
        $retain_temp = array();
        foreach ($retain as $key => $val) {
            $retain_temp[$val['date']][$val['user_id']][] = $val;
        }
        $retain_data = array();
        foreach ($retain_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $retain_data[$key][$k]['reg'] += $vv['reg'];
                    $retain_data[$key][$k]['retain1'] += $vv['retain1'];
                }
            }
        }

        $new_pay = $this->query($sql_new_pay, $param);

        foreach ($new_pay as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $new_pay[$key]['user_id'] = (int)$monitor_temp['user_id'];

        }
        $new_pay_temp = array();
        foreach ($new_pay as $key => $val) {
            $new_pay_temp[$val['date']][$val['user_id']][] = $val;
        }
        $new_pay_data = array();
        foreach ($new_pay_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $new_pay_data[$key][$k]['new_pay'] += $vv['new_pay'];
                    $new_pay_data[$key][$k]['new_pay_money'] += $vv['new_pay_money'];
                }
            }
        }

        $upload = $this->query($sql_upload, $param);

        foreach ($upload as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $upload[$key]['user_id'] = (int)$monitor_temp['user_id'];

        }
        $upload_temp = array();
        foreach ($upload as $key => $val) {
            $upload_temp[$val['date']][$val['user_id']][] = $val;
        }
        $upload_data = array();
        foreach ($upload_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $upload_data[$key][$k]['cost'] += $vv['cost'];
                    $upload_data[$key][$k]['display'] += $vv['display'];
                    $upload_data[$key][$k]['click'] += $vv['click'];
                }
            }
        }

        $all_pay = $this->query($sql_all_pay, $param);

        foreach ($all_pay as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $all_pay[$key]['user_id'] = (int)$monitor_temp['user_id'];

        }
        $all_pay_temp = array();
        foreach ($all_pay as $key => $val) {
            $all_pay_temp[$val['date']][$val['user_id']][] = $val;
        }
        $all_pay_data = array();
        foreach ($all_pay_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $all_pay_data[$key][$k]['pay_money'] += $vv['pay_money'];
                    $all_pay_data[$key][$k]['pay'] += 1;
                }
            }
        }

        $sql = 'select `user_id` from ' . LibTable::$channel_user . " where 1 ";
        $user_list = $this->query($sql);
        array_push($user_list, array('user_id' => 0));
        sort($user_list);

        $info_data = array();
        foreach ($retain_data as $key => $val) {
            foreach ($user_list as $k => $v) {
                $info_data[$key][$v['user_id']]['date'] = $key;
                $info_data[$key][$v['user_id']]['user_id'] = $k;
                $info_data[$key][$v['user_id']]['reg'] = (int)$val[$v['user_id']]['reg'];
                $info_data[$key][$v['user_id']]['retain1'] = (int)$val[$v['user_id']]['retain1'];
                $info_data[$key][$v['user_id']]['pay_money'] = (int)$all_pay_data[$key][$v['user_id']]['pay_money'];
                $info_data[$key][$v['user_id']]['pay'] = (int)$all_pay_data[$key][$v['user_id']]['pay'];
                $info_data[$key][$v['user_id']]['cost'] = (int)$upload_data[$key][$v['user_id']]['cost'];
                $info_data[$key][$v['user_id']]['display'] = (int)$upload_data[$key][$v['user_id']]['display'];
                $info_data[$key][$v['user_id']]['click'] = (int)$upload_data[$key][$v['user_id']]['click'];
                $info_data[$key][$v['user_id']]['new_pay'] = (int)$new_pay_data[$key][$v['user_id']]['new_pay'];
                $info_data[$key][$v['user_id']]['new_pay_money'] = (int)$new_pay_data[$key][$v['user_id']]['new_pay_money'];
            }
        }
        return $info_data;

    }

    public function dayUserEffect($game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id)
    {

        if ($user_id) {
            $sql_package_name = "select `package_name` from " . LibTable::$ad_project . " where user_id = :user_id ";
            $package_name = $this->query($sql_package_name, array('user_id' => $user_id));
            $package = '';
            foreach ($package_name as $key => $val) {
                $package .= '\'' . $val['package_name'] . '\',';
            }
            $package = rtrim($package, ',');

        }

        $sql = "select `date`,`package_name`,sum(`reg`) as `reg`,sum(`retain2`) as `retain1`,sum(`retain3`) as `retain3`,sum(`retain7`) as `retain7`,sum(`retain15`) as `retain15` ,sum(`retain30`) as `retain30`  from `" . LibTable::$data_retain . "` where 1 ";
        $sql_reg = "select `date`,`package_name`,group_concat(`reg_uid`) as `uid` from `" . LibTable::$data_reg . "` where `reg`>0  and `device_type` = " . PLATFORM['android'];
        $sql_upload = "select `date`,`package_name`,sum(`cost`) as `cost`,sum(`display`) as `display`,sum(`click`) as `click` from `" . LibTable::$data_upload . "` where 1 and `device_type` = " . PLATFORM['android'];

        $sql_new_pay = "select sum(`new_pay`) as `new_pay` ,sum(`new_pay_money`) as `new_pay_money`,date(`date`) as `date`,`package_name` from " . LibTable::$data_pay_new . " where 1  and `device_type` = " . PLATFORM['android'];
        $sql_ltv = "select sum(`money7`) as `money7` , sum(`money30`) as `money30`,sum(`money45`) as `money45`,sum(`money60`) as `money60`,`date`,`package_name` from " . LibTable::$data_ltv . " where 1  and `device_type` = " . PLATFORM['android'];
        $sql_dau = "select sum(`DAU`) as `DAU`,`date`,`package_name` from " . LibTable::$data_dau . " where 1  and `device_type` =  " . PLATFORM['android'];
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id`=:game_id ";
            $sql_reg .= " and `game_id`=:game_id ";
            $sql_upload .= " and `game_id`=:game_id ";
            $sql_ltv .= " and `game_id`=:game_id ";
            //$sql_all_pay .= " and p.`game_id`=:game_id ";
            $sql_new_pay .= " and `game_id`=:game_id ";
            $sql_dau .= " and `game_id`=:game_id ";
        }
        if ($user_id) {
            $sql .= " and `package_name` in ($package) ";
            $sql_reg .= " and `package_name` in ($package) ";
            $sql_upload .= " and `package_name` in ($package) ";
            $sql_ltv .= " and `package_name` in ($package) ";
            $sql_new_pay .= " and `package_name` in ($package) ";
            $sql_dau .= " and `package_name` in ($package) ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and  `date` >= :sdate ";
            $sql_reg .= " and  `date` >= :sdate ";
            $sql_upload .= " and  `date` >= :sdate ";
            $sql_ltv .= " and  `date` >= :sdate ";
            //$sql_all_pay .= " and  p.`date` >= :sdate ";
            $sql_new_pay .= " and date(`date`) >= :sdate ";
            $sql_dau .= " and `date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and `date` <= :edate ";
            $sql_reg .= " and `date` <= :edate ";
            $sql_upload .= " and `date` <= :edate ";
            $sql_ltv .= " and `date` <= :edate ";
            //$sql_all_pay .= " and p.`date` <= :edate ";
            $sql_new_pay .= " and date(`date`) <= :edate ";
            $sql_dau .= " and `date` <= :edate ";
        }
        if ($monitor_id) {
            $param['monitor_id'] = $monitor_id;
            $sql .= " and `monitor_id` = :monitor_id ";
            $sql_reg .= " and `monitor_id` = :monitor_id ";
            $sql_upload .= " and `monitor_id` = :monitor_id ";
            $sql_ltv .= " and `monitor_id` = :monitor_id ";
            $sql_new_pay .= " and `monitor_id` = :monitor_id ";
            $sql_dau .= " and `monitor_id` = :monitor_id ";
        }

        $sql .= " group by `date`,`package_name` order by `date` desc ";
        $sql_reg .= " group by `date`,`package_name` ";
        $sql_upload .= " group by `date`,`package_name` ";
        $sql_ltv .= " group by `date`,`package_name` ";
        $sql_dau .= " group by `date`,`package_name` ";
        $sql_new_pay .= " group by date(`date`),`package_name` ";

        $dau = $this->query($sql_dau, $param);

        $dau_temp = array();
        foreach ($dau as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $dau[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }
        foreach ($dau as $key => $val) {
            $dau_temp[$val['date']][$val['user_id']][] = $val;
        }
        $dau_data = array();
        foreach ($dau_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $dau_data[$key][$k]['DAU'] += $vv['DAU'];
                }
            }
        }
        $info3 = $this->query($sql_upload, $param);


        foreach ($info3 as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $info3[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }
        $upload_temp = array();
        foreach ($info3 as $key => $val) {
            $upload_temp[$val['date']][$val['user_id']][] = $val;
        }
        $upload = array();
        foreach ($upload_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $upload[$key][$k]['cost'] += $vv['cost'];
                    $upload[$key][$k]['display'] += $vv['display'];
                    $upload[$key][$k]['click'] += $vv['click'];
                }
            }
        }
        $info2 = $this->query($sql_new_pay, $param);

        foreach ($info2 as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $info2[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }
        $np_temp = array();
        foreach ($info2 as $key => $val) {
            $np_temp[$val['date']][$val['user_id']][] = $val;
        }
        $np_data = array();
        foreach ($np_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $np_data[$key][$k]['new_pay'] += $vv['new_pay'];
                    $np_data[$key][$k]['new_pay_money'] += $vv['new_pay_money'];
                }
            }
        }
        $info = $this->query($sql, $param);
        foreach ($info as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $info[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }
        $retain_temp = array();
        foreach ($info as $key => $val) {
            $retain_temp[$val['date']][$val['user_id']][] = $val;
        }
        $retain_data = array();
        foreach ($retain_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $retain_data[$key][$k]['reg'] += $vv['reg'];
                    $retain_data[$key][$k]['retain1'] += $vv['retain1'];
                    $retain_data[$key][$k]['retain3'] += $vv['retain3'];
                    $retain_data[$key][$k]['retain7'] += $vv['retain7'];
                    $retain_data[$key][$k]['retain15'] += $vv['retain15'];
                    $retain_data[$key][$k]['retain30'] += $vv['retain30'];
                }

            }
        }

        $reg_uid = $this->query($sql_reg, $param);
        foreach ($reg_uid as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $reg_uid[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }
        $pay_rage_money = $pay_rage = array();
        foreach ($reg_uid as $key => $val) {

            if ($val['uid']) {
                $sql_pay_money = "select sum(`money`)  `pay_money` from " . LibTable::$data_pay . " where `uid` in ( " . $val['uid'] . " ) ";
                $sql_payer = "select count(*) as `pay` from " . LibTable::$data_pay . " where `uid` in (" . $val['uid'] . ")";
                if ($game_id) {
                    $sql_pay_money .= " and `game_id` = $game_id ";
                    $sql_payer .= " and `game_id` = $game_id ";
                }
                if ($pay_sdate) {
                    $sql_pay_money .= " and  `date` >= '$pay_sdate' ";
                    $sql_payer .= " and  `date` >= '$pay_sdate' ";
                }
                if ($pay_edate) {
                    $sql_pay_money .= " and `date` <= '$pay_edate' ";
                    $sql_payer .= " and `date` <= '$pay_edate' ";
                }

                $pay_m = $this->getOne($sql_pay_money);

                $pay_n = $this->getOne($sql_payer);
                $pay_rage_money[$val['date']][$val['user_id']] += (int)$pay_m['pay_money'];
                $pay_rage[$val['date']][$val['user_id']] += (int)$pay_n['pay'];
            }
        }
        $ltv = $this->query($sql_ltv, $param);
        foreach ($ltv as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
            $ltv[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }
        $ltv_temp = array();
        foreach ($ltv as $l) {
            $ltv_temp[$l['date']][$l['user_id']][] = $l;
        }
        $ltv_data = array();
        foreach ($ltv_temp as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $ltv_data[$key][$k]['money7'] += $vv['money7'];
                    $ltv_data[$key][$k]['money30'] += $vv['money30'];
                    $ltv_data[$key][$k]['money45'] += $vv['money45'];
                    $ltv_data[$key][$k]['money60'] += $vv['money60'];
                    $ltv_data[$key][$k]['money60'] += $vv['money60'];
                }
            }
        }

        $sql = 'select `user_id` from ' . LibTable::$channel_user . " where 1 ";
        $user_list = $this->query($sql);
        array_push($user_list, array('user_id' => 0));
        sort($user_list);
        $info_data = array();
        foreach ($retain_data as $key => $val) {
            foreach ($user_list as $k => $v) {
                $info_data[$key][$v['user_id']]['date'] = $key;
                $info_data[$key][$v['user_id']]['reg'] = (int)$val[$v['user_id']]['reg'];
                $info_data[$key][$v['user_id']]['retain1'] = (int)$val[$v['user_id']]['retain1'];
                $info_data[$key][$v['user_id']]['retain3'] = (int)$val[$v['user_id']]['retain3'];
                $info_data[$key][$v['user_id']]['retain7'] = (int)$val[$v['user_id']]['retain7'];
                $info_data[$key][$v['user_id']]['retain15'] = (int)$val[$v['user_id']]['retain15'];
                $info_data[$key][$v['user_id']]['retain30'] = (int)$val[$v['user_id']]['retain30'];
                $info_data[$key][$v['user_id']]['money7'] = (int)$ltv_data[$key][$v['user_id']]['money7'];
                $info_data[$key][$v['user_id']]['money30'] = (int)$ltv_data[$key][$v['user_id']]['money30'];
                $info_data[$key][$v['user_id']]['money45'] = (int)$ltv_data[$key][$v['user_id']]['money45'];
                $info_data[$key][$v['user_id']]['money60'] = (int)$ltv_data[$key][$v['user_id']]['money60'];
                $info_data[$key][$v['user_id']]['pay_money'] = (int)$pay_rage_money[$key][$v['user_id']];
                $info_data[$key][$v['user_id']]['pay'] = (int)$pay_rage[$key][$v['user_id']];
                $info_data[$key][$v['user_id']]['new_pay'] = (int)$np_data[$key][$v['user_id']]['new_pay'];
                $info_data[$key][$v['user_id']]['new_pay_money'] = (int)$np_data[$key][$v['user_id']]['new_pay_money'];
                $info_data[$key][$v['user_id']]['cost'] = (int)$upload[$key][$v['user_id']]['cost'];
                $info_data[$key][$v['user_id']]['display'] = (int)$upload[$key][$v['user_id']]['display'];
                $info_data[$key][$v['user_id']]['click'] = (int)$upload[$key][$v['user_id']]['click'];
                $info_data[$key][$v['user_id']]['dau'] = (int)$dau_data[$key][$v['user_id']]['DAU'];
                $info_data[$key][$v['user_id']]['user_id'] = $k;
            }
        }
        return $info_data;

    }

    public function userEffect($game_id, $user_id, $rsdate, $redate, $psdate, $pedate)
    {
        //$user_id = 4;
        if ($user_id) {
            $sql_package_name = "select `package_name` from " . LibTable::$ad_project . " where user_id = :user_id ";
            $package_name = $this->query($sql_package_name, array('user_id' => $user_id));
            $package = '';

            foreach ($package_name as $key => $val) {
                $package .= '\'' . $val['package_name'] . '\',';
            }
            $package = rtrim($package, ',');
        }
        $sql_retain = "select sum(`reg`) as reg, sum(`retain2`) as retain,`package_name`,`monitor_id`  from " . LibTable::$data_retain . " where 1";//注册数和次日留存数
        $sql_reg = "select `reg_uid`,`package_name`,`monitor_id` from " . LibTable::$data_reg . " where 1   ";//注册uid
        $sql_upload = "select sum(`cost`) as `cost`,sum(`display`) as `display`,sum(`click`) as `click` ,`package_name`,`monitor_id` from " . LibTable::$data_upload . " where 1  ";
        if ($user_id) {
            $sql_retain .= " and `package_name` in ($package)  ";
            $sql_reg .= " and `package_name` in ($package)  ";
            $sql_upload .= " and `package_name` in ($package)  ";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql_reg .= " and `game_id`=:game_id ";
            $sql_retain .= " and `game_id`=:game_id ";
            $sql_upload .= " and `game_id`=:game_id ";
        }
        if ($rsdate) {
            $param['rsdate'] = $rsdate;
            $sql_reg .= " and `date` >= :rsdate ";
            $sql_retain .= " and  `date` >= :rsdate ";
            $sql_upload .= " and  `date` >= :rsdate ";
        }
        if ($redate) {
            $param['redate'] = $redate;
            $sql_reg .= " and `date` <= :redate ";
            $sql_retain .= " and `date` <= :redate ";
            $sql_upload .= " and `date` <= :redate ";
        }
        $sql_retain .= " group by `package_name`,`monitor_id` ";
        //$sql_reg .= " group by `package_name` ";
        $sql_upload .= " group by `package_name`,`monitor_id` ";
        $upload = $this->query($sql_upload, $param);
        $retain = $this->query($sql_retain, $param);
        $reg = $this->query($sql_reg, $param);


        foreach ($upload as $key => $val) {
            if (strstr($val['package_name'], 'ios')) {
                $monitor_temp = $this->getUserIdI($val['monitor_id']);
            } elseif (strstr($val['package_name'], 'android')) {
                $monitor_temp = $this->getUserIdA($val['package_name']);
            }

            $upload[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }
        $upload_temps = array();
        foreach ($upload as $key => $val) {
            $upload_temps[$val['user_id']][] = $val;
        }
        $u_temp = array();
        foreach ($upload_temps as $key => $val) {
            foreach ($val as $k => $v) {
                $u_temp[$key]['cost'] += $v['cost'] / 100;
                $u_temp[$key]['display'] += $v['display'];
                $u_temp[$key]['click'] += $v['click'];
                $u_temp[$key]['user_id'] = $v['user_id'];

            }
        }

        $upload = $u_temp;
        unset($u_temp);
        unset($upload_temps);

        foreach ($retain as $key => $val) {
            if (strstr($val['package_name'], 'ios')) {
                $monitor_temp = $this->getUserIdI($val['monitor_id']);
            } elseif (strstr($val['package_name'], 'android')) {
                $monitor_temp = $this->getUserIdA($val['package_name']);
            }
            $retain[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }

        $retain_temps = array();
        foreach ($retain as $key => $val) {
            $retain_temps[$val['user_id']][] = $val;
        }
        $r_temp = array();
        foreach ($retain_temps as $key => $val) {
            foreach ($val as $k => $v) {
                $r_temp[$key]['reg'] += $v['reg'];
                $r_temp[$key]['retain'] += $v['retain'];
                $r_temp[$key]['user_id'] = $v['user_id'];
            }
        }
        $retain = $r_temp;
        unset($r_temp);
        unset($retain_temps);

        foreach ($reg as $key => $val) {
            if (strstr($val['package_name'], 'ios')) {
                $monitor_temp = $this->getUserIdI($val['monitor_id']);
            } elseif (strstr($val['package_name'], 'android')) {
                $monitor_temp = $this->getUserIdA($val['package_name']);
            }
            $reg[$key]['user_id'] = (int)$monitor_temp['user_id'];
        }

        $reg_temps = array();
        foreach ($reg as $key => $val) {
            $reg_temps[$val['user_id']][] = $val;
        }

        $pay_temp = array();
        foreach ($reg_temps as $key => $val) {
            foreach ($val as $k => $v) {
                $sql_pay = "select  IFNULL(sum(money),0) as pay_money,IFNULL(count(DISTINCT (uid)),0) as payer_num from " . LibTable::$data_pay . " where 1 and uid in (" . $v['reg_uid'] . ") ";
                if ($psdate) {
                    $param['psdate'] = $psdate;
                    $sql_pay .= " and `date` >= :psdate ";
                }
                if ($pedate) {
                    $param['pedate'] = $pedate;
                    $sql_pay .= " and `date` <= :pedate ";
                }
                //$sql_pay .= " and `package_name` = '{$v['package_name']}' ";
                $pay = $this->getOne($sql_pay, $param);

                $pay_temp[$v['user_id']]['pay_money'] += $pay['pay_money'];
                $pay_temp[$v['user_id']]['payer_num'] += $pay['payer_num'];
                $pay_temp[$v['user_id']]['user_id'] = $v['user_id'];
            }

        }
        //print_r($pay_temp);die;
        $sql = 'select `user_id` from ' . LibTable::$channel_user . " where 1 ";
        $user_list = $this->query($sql);
        array_unshift($user_list, array('user_id' => 0));
        $info = array();
        foreach ($user_list as $key => $val) {
            $info['list'][$val['user_id']]['user_id'] = (int)$val['user_id'];
            $info['list'][$val['user_id']]['reg'] = (int)$retain[$val['user_id']]['reg'];
            $info['list'][$val['user_id']]['retain'] = (int)$retain[$val['user_id']]['retain'];
            $info['list'][$val['user_id']]['cost'] = empty($upload[$val['user_id']]['cost']) ? 0 : $upload[$val['user_id']]['cost'];
            $info['list'][$val['user_id']]['display'] = (int)$upload[$val['user_id']]['display'];
            $info['list'][$val['user_id']]['click'] = (int)$upload[$val['user_id']]['click'];
            $info['list'][$val['user_id']]['pay_money'] = (int)$pay_temp[$val['user_id']]['pay_money'];
            $info['list'][$val['user_id']]['payer_num'] = (int)$pay_temp[$val['user_id']]['payer_num'];
        }


        return $info;
    }

    public function channelCycleT($page, $channel_id, $game_id, $sdate, $edate)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql_reg = "select sum(`reg`) as reg,channel_id,game_id from " . LibTable::$data_reg . " where 1 ";
        $sql_pay = "select sum(p.`money`) as `money` ,e.channel_id,p.game_id from " . LibTable::$data_pay . " as p left join " . LibTable::$user_ext . " as e on e.uid=p.uid where 1 ";
        $sql_upload = "select sum(`cost`) as `cost`,`game_id`,`channel_id` from " . LibTable::$data_upload . " where 1 ";
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql_reg .= " and `game_id`=:game_id ";
            $sql_pay .= " and p.`game_id`=:game_id ";
            $sql_upload .= " and `game_id`=:game_id ";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql_reg .= " and `channel_id` in ($channel_id) ";
            $sql_pay .= " and `channel_id` in ($channel_id) ";
            $sql_upload .= " and `channel_id` in ($channel_id) ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql_reg .= " and `date` >= :sdate ";
            $sql_pay .= " and p.`date` >= :sdate ";
            $sql_upload .= " and `date` >= :sdate ";
        }
        if ($edate) {
            $edate = date('Y-m-d', strtotime($edate) + 3600 * 24);
            $param['edate'] = $edate;
            $sql_reg .= " and `date` <= :edate ";
            $sql_pay .= " and p.`date` <= :edate ";
            $sql_upload .= " and `date` <= :edate ";
        }
        $sql_reg .= " group by `channel_id`,`game_id` ";
        $sql_pay .= " group by `channel_id`,`game_id` ";
        $sql_upload .= " group by `channel_id`,`game_id` ";
        $reg = $this->query($sql_reg, $param);
        $pay = $this->query($sql_pay, $param);
        $upload = $this->query($sql_upload, $param);

        $temp = array();
        foreach ($upload as $val) {
            $temp[$val['game_id']][$val['channel_id']]['cost'] += $val['cost'];
        }
        foreach ($pay as $val) {
            $temp[$val['game_id']][$val['channel_id']]['pay_money'] += $val['money'];
        }
        foreach ($reg as $val) {
            $temp[$val['game_id']][$val['channel_id']]['reg'] += $val['reg'];
        }
        foreach ($temp as $key => $val) {
            foreach ($val as $k => $v) {
                if (!$v['reg']) {
                    $temp[$key][$k]['reg'] = 0;
                }
                if (!$v['pay_money']) {
                    $temp[$key][$k]['pay_money'] = 0;
                }
                if (!$v['cost']) {
                    $temp[$key][$k]['cost'] = 0;
                }
                $temp[$key][$k]['game_id'] = $key;
                $temp[$key][$k]['channel_id'] = $k;
            }
        }
        $info = array();
        foreach ($temp as $key => $val) {
            foreach ($val as $k => $v) {
                $info['list'][] = $v;
            }
        }
        unset($temp);
        return $info;
    }

    public function hourLand($page, $package_name, $game_id, $channel_id, $sdate, $edate, $all, $is_excel = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        if ($is_excel > 0) {
            $limit = '';
        }

        $sql = "select h.* from " . LibTable::$data_hour_land . " as h left join " . LibTable::$sy_game_package . " as p on p.`package_name`=h.`package_name` where 1 and `platform` =  " . PLATFORM['android'];

        $sql_count = "select count(*) as c from `" . LibTable::$data_hour_land . "` as h left join `" . LibTable::$sy_game_package . "` as p on p.`package_name`=h.`package_name`  where 1 and `platform`= " . PLATFORM['android'];
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and h.`game_id`=:game_id ";
            $sql_count .= " and h.`game_id` = :game_id ";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and h.`channel_id` in ($channel_id) ";
            $sql_count .= " and h.`channel_id` in ($channel_id) ";
        }
        if ($package_name) {
            $param['package_name'] = $package_name;
            $sql .= " and h.`package_name` = :package_name ";
            $sql_count .= " and h.`package_name` = :package_name ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and h.`date` >= '$sdate' ";
            $sql_count .= " and h.`date` >= '$sdate' ";
        }
        if ($edate) {
            $edate = date('Y-m-d', strtotime($edate) + 3600 * 24);
            $param['edate'] = $edate;
            $sql .= " and h.`date` < '$edate' ";
            $sql_count .= " and h.`date` < '$edate' ";
        }
        if ($all == 0) {
            $sql .= " and (h.`download`>0 or h.`complete_load`>0 or h.`active_num`>0 or h.`reg`>0 or h.`click` >0) ";
            $sql_count .= " and (h.`download`>0 or h.`complete_load`>0 or h.`active_num`>0 or h.`reg`>0 or h.`click` >0) ";
        }
        $sql .= " order by h.`date` desc {$limit}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count
        );
    }

    public function channelCycle($channel_id, $game_id, $sdate, $edate)
    {
        $sql = "select `date`,sum(`reg`) as `reg`,sum(`retain2`) as `retain1` from `" . LibTable::$data_retain . "` where 1 ";

        $sql_upload = "select `date`,sum(`cost`) as `cost`,sum(`display`) as `display`,sum(`click`) as `click` from `" . LibTable::$data_upload . "` where 1";
        $sql_all_pay = "select sum(`money`) as `pay_money`,`date`  from " . LibTable::$data_pay . " as p left join " . LibTable::$user_ext . " as e on e.uid = p.uid where 1 ";

        $sql_new_pay = "select sum(`new_pay`) as `new_pay` ,sum(`new_pay_money`) as `new_pay_money`,date(`date`) as `date` from " . LibTable::$data_pay_new . " where 1 ";

        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id`=:game_id ";

            $sql_upload .= " and `game_id`=:game_id ";
            $sql_all_pay .= " and p.`game_id`=:game_id ";
            $sql_new_pay .= " and `game_id`=:game_id ";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and `channel_id` in ($channel_id) ";

            $sql_upload .= " and `channel_id` in ($channel_id) ";
            $sql_all_pay .= " and e.`channel_id` in ($channel_id)";
            $sql_new_pay .= " and `channel_id` in ($channel_id) ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and  `date` >= :sdate ";

            $sql_upload .= " and  `date` >= :sdate ";
            $sql_all_pay .= " and  p.`date` >= :sdate ";
            $sql_new_pay .= " and date(`date`) >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and `date` <= :edate ";

            $sql_upload .= " and `date` <= :edate ";
            $sql_all_pay .= " and p.`date` <= :edate ";
            $sql_new_pay .= " and date(`date`) <= :edate ";
        }

        $sql .= " group by `date` order by `date` desc ";

        $sql_upload .= " group by `date` ";
        $sql_all_pay .= " group by `date`,p.`uid` ";
        $sql_new_pay .= " group by date(`date`) ";

        $all_pay = $this->query($sql_all_pay, $param);

        $info_ap = array();
        foreach ($all_pay as $key => $val) {
            $info_ap[$val['date']]['pay'] += 1;
            $info_ap[$val['date']]['pay_money'] += (int)$val['pay_money'];
        }
        $info = $this->query($sql, $param);
        if (empty($info)) {
            return $info;
        }
        $pay = $pay_money = array();
        $info2 = $this->query($sql_new_pay, $param);
        foreach ($info2 as $key => $val) {
            $pay[$val['date']] = $val['new_pay'];
            $pay_money[$val['date']] = $val['new_pay_money'];
        }
        //get pay

        //get upload
        $info3 = $this->query($sql_upload, $param);
        $upload = array();
        foreach ($info3 as $date_upload) {
            $upload[$date_upload['date']] = $date_upload;
        }
        foreach ($info as &$re) {
            $re['pay'] = (int)$info_ap[$re['date']]['pay'];
            $re['pay_money'] = (int)$info_ap[$re['date']]['pay_money'];
            $re['new_pay'] = (int)$pay[$re['date']];
            $re['new_pay_money'] = (int)$pay_money[$re['date']];
            $re['cost'] = (int)$upload[$re['date']]['cost'];
            $re['display'] = (int)$upload[$re['date']]['display'];
            $re['click'] = (int)$upload[$re['date']]['click'];
        }
        return $info;
    }


    public function dayChannelEffect($channel_id, $game_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id, $is_excel = 0)
    {
        // echo $sdate;echo '<br>';echo $edate;echo '<br>';echo $pay_sdate;echo '<br>';echo $pay_edate;die;
        //get reg
        $sql = "select `date`,sum(`reg`) as `reg`,sum(`retain2`) as `retain1`,sum(`retain3`) as `retain3`,sum(`retain7`) as `retain7`,sum(`retain15`) as `retain15` ,sum(`retain30`) as `retain30`  from `" . LibTable::$data_retain . "` where 1 ";
        $sql_reg = "select `date`,group_concat(`reg_uid`) as `uid` from `" . LibTable::$data_reg . "` where `reg`>0 ";
        $sql_upload = "select `date`,sum(`cost`) as `cost`,sum(`display`) as `display`,sum(`click`) as `click` from `" . LibTable::$data_upload . "` where 1";

        $sql_new_pay = "select sum(`new_pay`) as `new_pay` ,sum(`new_pay_money`) as `new_pay_money`,date(`date`) as `date` from " . LibTable::$data_pay_new . " where 1 ";
        $sql_ltv = "select sum(`money7`) as `money7` , sum(`money30`) as `money30`,sum(`money45`) as `money45`,sum(`money60`) as `money60`,`date` from " . LibTable::$data_ltv . " where 1 ";
        $sql_dau = "select sum(`DAU`) as `DAU`,`date` from " . LibTable::$data_dau . " where 1 ";


        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id`=:game_id ";
            $sql_reg .= " and `game_id`=:game_id ";
            $sql_upload .= " and `game_id`=:game_id ";
            $sql_ltv .= " and `game_id`=:game_id ";
            //$sql_all_pay .= " and p.`game_id`=:game_id ";
            $sql_new_pay .= " and `game_id`=:game_id ";
            $sql_dau .= " and `game_id`=:game_id ";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and `channel_id` in ($channel_id) ";
            $sql_reg .= " and `channel_id` in ($channel_id) ";
            $sql_upload .= " and `channel_id` in ($channel_id) ";
            $sql_ltv .= " and `channel_id` in ($channel_id) ";
            //$sql_all_pay .= " and e.`channel_id` in ($channel_id)";
            $sql_new_pay .= " and `channel_id` in ($channel_id) ";
            $sql_dau .= " and `channel_id` in ($channel_id) ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and  `date` >= :sdate ";
            $sql_reg .= " and  `date` >= :sdate ";
            $sql_upload .= " and  `date` >= :sdate ";
            $sql_ltv .= " and  `date` >= :sdate ";
            //$sql_all_pay .= " and  p.`date` >= :sdate ";
            $sql_new_pay .= " and date(`date`) >= :sdate ";
            $sql_dau .= " and `date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and `date` <= :edate ";
            $sql_reg .= " and `date` <= :edate ";
            $sql_upload .= " and `date` <= :edate ";
            $sql_ltv .= " and `date` <= :edate ";
            //$sql_all_pay .= " and p.`date` <= :edate ";
            $sql_new_pay .= " and date(`date`) <= :edate ";
            $sql_dau .= " and `date` <= :edate ";
        }
        if ($monitor_id) {
            $param['monitor_id'] = $monitor_id;

            $sql_marks = "select `package_name` from " . LibTable::$ad_project . " where `monitor_id` = $monitor_id ";
            $marks = $this->getOne($sql_marks);
            if (strstr($marks['package_name'], 'ios')) {
                $sql .= " and `monitor_id` = :monitor_id ";
                $sql_reg .= " and `monitor_id` = :monitor_id ";
                $sql_upload .= " and `monitor_id` = :monitor_id ";
                $sql_ltv .= " and `monitor_id` = :monitor_id ";
                $sql_new_pay .= " and `monitor_id` = :monitor_id ";
                $sql_dau .= " and `monitor_id` = :monitor_id ";
            } else {
                $sql .= " and `package_name` = '{$marks['package_name']}' ";
                $sql_reg .= " and `package_name` = '{$marks['package_name']}' ";
                $sql_upload .= " and `package_name` = '{$marks['package_name']}' ";
                $sql_ltv .= " and `package_name` = '{$marks['package_name']}' ";
                $sql_new_pay .= " and `package_name` = '{$marks['package_name']}' ";
                $sql_dau .= " and `package_name` = '{$marks['package_name']}' ";
            }


        }

        $sql .= " group by `date` order by `date` desc ";
        $sql_reg .= " group by `date` ";
        $sql_upload .= " group by `date` ";
        $sql_ltv .= " group by `date` ";
        //$sql_dau .= " group by `date` ";
        $sql_new_pay .= " group by date(`date`) ";

        $reg_uid = $this->query($sql_reg, $param);
        $ltv = $this->query($sql_ltv, $param);
        $pay_rage_money = $pay_rage = array();
        foreach ($reg_uid as $key => $val) {
            if ($val['uid']) {
                $sql_pay_money = "select sum(`money`)  `pay_money` from " . LibTable::$data_pay . " where `uid` in ( " . $val['uid'] . " ) ";
                $sql_payer = "select count(*) as `pay` from " . LibTable::$data_pay . " where `uid` in (" . $val['uid'] . ")";
                if ($game_id) {
                    $sql_pay_money .= " and `game_id` = $game_id ";
                    $sql_payer .= " and `game_id` = $game_id ";
                }
                if ($pay_sdate) {
                    $sql_pay_money .= " and  `date` >= '$pay_sdate' ";
                    $sql_payer .= " and  `date` >= '$pay_sdate' ";
                }
                if ($pay_edate) {
                    $sql_pay_money .= " and `date` <= '$pay_edate' ";
                    $sql_payer .= " and `date` <= '$pay_edate' ";
                }

                $pay_m = $this->getOne($sql_pay_money);
                $pay_n = $this->getOne($sql_payer);
                $pay_rage_money[$val['date']] = (int)$pay_m['pay_money'];
                $pay_rage[$val['date']] = (int)$pay_n['pay'];
            }
        }

        //$_pay_today = $this->query($sql_all_pay,$param);
//        foreach($_pay_today as $pt){
//            $pay_today[$pt['date']]['pay_money'] = $pt['pay_money'];
//            $pay_today[$pt['date']]['pay'] = $pt['pay'];
//        }


        $info = $this->query($sql, $param);
        if (empty($info)) {
            return $info;
        }
        $pay = $pay_money = array();
        $info2 = $this->query($sql_new_pay, $param);
        foreach ($info2 as $key => $val) {
            $pay[$val['date']] = $val['new_pay'];
            $pay_money[$val['date']] = $val['new_pay_money'];
        }
        //get pay

        //get upload
        $info3 = $this->query($sql_upload, $param);
        $upload = array();
        foreach ($info3 as $date_upload) {
            $upload[$date_upload['date']] = $date_upload;
        }
        $ltv_data = array();
        foreach ($ltv as $l) {
            $ltv_data[$l['date']] = $l;
        }
        $dau_data = array();
        $sql_dau .= ' group by `date` ';
        $dau = $this->query($sql_dau, $param);

        foreach ($dau as $key => $val) {

            $dau_data[$val['date']] = $val['DAU'];

        }
        foreach ($info as &$re) {
            $re['pay'] = (int)$pay_rage[$re['date']];
            $re['pay_money'] = (int)$pay_rage_money[$re['date']];
            $re['new_pay'] = (int)$pay[$re['date']];
            $re['new_pay_money'] = (int)$pay_money[$re['date']];
            $re['dau'] = (int)$dau_data[$re['date']];
            $re['cost'] = (int)$upload[$re['date']]['cost'];
            $re['display'] = (int)$upload[$re['date']]['display'];
            $re['click'] = (int)$upload[$re['date']]['click'];
            $re['money7'] = (int)$ltv_data[$re['date']]['money7'];
            $re['money30'] = (int)$ltv_data[$re['date']]['money30'];
            $re['money45'] = (int)$ltv_data[$re['date']]['money45'];
            $re['money60'] = (int)$ltv_data[$re['date']]['money60'];
        }
        return $info;
    }

    public function channelEffect($device_type, $page, $channel_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        if ($is_excel > 0) {
            $limit = '';
        }
        $sql = "select * from " . LibTable::$channel . " where 1  ";
        $sql_count = "select count(*) as c from " . LibTable::$channel . " where 1 ";
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and `channel_id` in ($channel_id) ";
            $sql_count .= " and `channel_id` in ($channel_id) ";
        }
        $sql_all = $sql;
        $sql .= " {$limit} ";
        $all_channel['list'] = $this->query($sql);
        $all_channel['total'] = $this->getOne($sql_count);
        $all = $this->query($sql_all, $param);

        if ($all_channel['total']['c'] > 0) {
            $info = array();
            foreach ($all as $key => $val) {
                $sql_retain = "select sum(`reg`) as reg, sum(`retain2`) as retain  from " . LibTable::$data_retain . " where 1 and `channel_id` = '" . $val['channel_id'] . "'";//注册数和次日留存数

                $sql_reg = "select `reg_uid` from " . LibTable::$data_reg . " where 1  and `channel_id` = '" . $val['channel_id'] . "'";//注册uid
                $sql_upload = "select `cost`,`display`,`click` from " . LibTable::$data_upload . " where 1  and `channel_id` = '" . $val['channel_id'] . "'";

                if ($game_id) {
                    $param['game_id'] = $game_id;
                    $sql_reg .= " and `game_id`=:game_id ";
                    $sql_retain .= " and `game_id`=:game_id ";
                    $sql_upload .= " and `game_id`=:game_id ";
                }
                if ($device_type) {
                    $param['device_type'] = $device_type;
                    $sql_reg .= " and `device_type`=:device_type ";
                    $sql_retain .= " and `device_type`=:device_type ";
                    $sql_upload .= " and `device_type`=:device_type ";
                }
                if ($rsdate) {
                    $param['rsdate'] = $rsdate;
                    $sql_reg .= " and `date` >= :rsdate ";
                    $sql_retain .= " and  `date` >= :rsdate ";
                    $sql_upload .= " and  `date` >= :rsdate ";
                }
                if ($redate) {
                    $param['redate'] = $redate;
                    $sql_reg .= " and `date` <= :redate ";
                    $sql_retain .= " and `date` <= :redate ";
                    $sql_upload .= " and `date` <= :redate ";
                }

                $upload = $this->query($sql_upload, $param);
                $retain = $this->getOne($sql_retain, $param);
                $reg = $this->query($sql_reg, $param);
                $sum = 0;
                foreach ($reg as $key => $val) {
                    $t = count(explode(',', $val['reg_uid']));
                    $sum += $t;
                }

                $info['retain'] += (int)$retain['retain'];
                $info['reg'] += (int)$retain['reg'];

                foreach ($upload as $k => $v) {
                    $info['cost'] += $v['cost'] / 100;
                    $info['display'] += $v['display'];
                    $info['click'] += $v['click'];
                }


                $reg_uid = '';
                foreach ($reg as $k => $v) {
                    $reg_uid .= $v['reg_uid'] . ',';
                }


                if (!empty($reg_uid)) {
                    $reg_uid = rtrim($reg_uid, ',');
                    $reg_uid = explode(',', $reg_uid);
                    $count = ceil(count($reg_uid) / 100);
                    $pay_money = 0;
                    $pay_num = 0;
                    for ($i = 0; $i < $count; $i++) {
                        $_reg_uid = join(',', array_slice($reg_uid, $i * 100, 100));
                        $sql_pay = "select  IFNULL(sum(money),0) as pay_money,IFNULL(count(DISTINCT (uid)),0) as payer_num from " . LibTable::$data_pay . " where 1 and uid in (" . $_reg_uid . ") ";
                        if ($psdate) {
                            $param['psdate'] = $psdate;
                            $sql_pay .= " and `date` >= :psdate ";
                        }
                        if ($pedate) {
                            $param['pedate'] = $pedate;
                            $sql_pay .= " and `date` <= :pedate ";
                        }
                        $pay = $this->getOne($sql_pay, $param);
                        $pay_money += $pay['pay_money'];
                        $pay_num += $pay['payer_num'];
                    }
                } else {
                    $pay_money = 0;
                    $pay_num = 0;
                }
                $info['pay_money'] += $pay_money;
                $info['payer_num'] += $pay_num;

            }
        }
        $all_channel['all'] = $info;
        if ($all_channel['total'] > 0) {
            foreach ($all_channel['list'] as $key => $val) {
                $sql_retain = "select sum(`reg`) as reg, sum(`retain2`) as retain  from " . LibTable::$data_retain . " where 1 and `channel_id` = " . $val['channel_id'];

                $sql_reg = "select `reg_uid` from " . LibTable::$data_reg . " where 1  and `channel_id` = " . $val['channel_id'];
                $sql_upload = "select `cost`,`display`,`click` from " . LibTable::$data_upload . " where 1  and `channel_id` = " . $val['channel_id'];

                if ($game_id) {
                    $param['game_id'] = $game_id;
                    $sql_reg .= " and `game_id`=:game_id ";
                    $sql_retain .= " and `game_id`=:game_id ";
                    $sql_upload .= " and `game_id`=:game_id ";
                }
                if ($rsdate) {
                    $param['rsdate'] = $rsdate;
                    $sql_reg .= " and `date` >= :rsdate ";
                    $sql_retain .= " and  `date` >= :rsdate ";
                    $sql_upload .= " and  `date` >= :rsdate ";
                }
                if ($redate) {
                    $param['redate'] = $redate;
                    $sql_reg .= " and `date` <= :redate ";
                    $sql_retain .= " and `date` <= :redate ";
                    $sql_upload .= " and `date` <= :redate ";
                }
                if ($device_type) {
                    $param['device_type'] = $device_type;
                    $sql_reg .= " and `device_type`=:device_type ";
                    $sql_retain .= " and `device_type`=:device_type ";
                    $sql_upload .= " and `device_type`=:device_type ";
                }
                $upload = $this->query($sql_upload, $param);
                $retain = $this->getOne($sql_retain, $param);
                $reg = $this->query($sql_reg, $param);


                $all_channel['list'] [$key]['retain'] = (int)$retain['retain'];
                $all_channel['list'] [$key]['reg'] = (int)$retain['reg'];

                foreach ($upload as $k => $v) {
                    $all_channel['list'] [$key]['cost'] += $v['cost'] / 100;
                    $all_channel['list'] [$key]['display'] += (int)$v['display'];
                    $all_channel['list'] [$key]['click'] += (int)$v['click'];
                }
                if (empty($all_channel['list'][$key]['cost'])) {
                    $all_channel['list'] [$key]['cost'] = 0;
                };
                if (empty($all_channel['list'][$key]['display'])) {
                    $all_channel['list'] [$key]['display'] = 0;
                };
                if (empty($all_channel['list'][$key]['click'])) {
                    $all_channel['list'] [$key]['click'] = 0;
                };
                $reg_uid = '';
                foreach ($reg as $k => $v) {
                    $reg_uid .= $v['reg_uid'] . ',';
                }
                if (!empty($reg_uid)) {
                    $reg_uid = rtrim($reg_uid, ',');
                    $reg_uid = explode(',', $reg_uid);
                    $count = ceil(count($reg_uid) / 100);
                    $pay_money = 0;
                    $pay_num = 0;
                    for ($i = 0; $i < $count; $i++) {
                        $_reg_uid = join(',', array_slice($reg_uid, $i * 100, 100));
                        $sql_pay = "select  IFNULL(sum(money),0) as pay_money,IFNULL(count(DISTINCT (uid)),0) as payer_num from " . LibTable::$data_pay . " where 1 and uid in (" . $_reg_uid . ") ";
                        if ($psdate) {
                            $param['psdate'] = $psdate;
                            $sql_pay .= " and `date` >= :psdate ";
                        }
                        if ($pedate) {
                            $param['pedate'] = $pedate;
                            $sql_pay .= " and `date` <= :pedate ";
                        }
                        $pay = $this->getOne($sql_pay, $param);
                        $pay_money += $pay['pay_money'];
                        $pay_num += $pay['payer_num'];
                    }


                } else {
                    $pay_money = 0;
                    $pay_num = 0;
                }
                $all_channel['list'][$key]['pay_money'] = (int)$pay_money;
                $all_channel['list'][$key]['payer_num'] = (int)$pay_num;
            }
        }


        return $all_channel;

    }

    public function activityEffect($channel_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        $conn = $this->connDb($this->conn);
        //$limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        //if($is_excel>0){
        //    $limit='';
        //}
        $sql = "select `package_name` from " . LibTable::$sy_game_package . " where `platform` = " . PLATFORM['android'];
        $sql_count = "select count(*) as c from " . LibTable::$sy_game_package . " where `platform` = " . PLATFORM['android'];
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and `channel_id` in ($channel_id) ";
            $sql_count .= " and `channel_id` in ($channel_id) ";
        }
        if ($game_id) {
            $param['channel_id'] = $game_id;
            $sql .= " and `game_id` = :game_id ";
            $sql_count .= " and `game_id` = :game_id ";
        }
        $sql_all = $sql;
        //$sql .= "{$limit} ";


        $all_package['list'] = $this->query($sql, $param);
        $all_package['total'] = $this->getOne($sql_count, $param);
        $all = $this->query($sql_all, $param);
        if ($all_package['total']['c'] > 0) {
            $info = array();
            foreach ($all as $key => $val) {
                $sql_retain = "select sum(`reg`) as reg, sum(`retain2`) as retain  from " . LibTable::$data_retain . " where 1 and `package_name` = '" . $val['package_name'] . "'";

                $sql_reg = "select `reg_uid` from " . LibTable::$data_reg . " where 1  and `package_name` = '" . $val['package_name'] . "'";
                $sql_upload = "select `cost`,`display`,`click` from " . LibTable::$data_upload . " where 1  and `package_name` = '" . $val['package_name'] . "'";

                if ($game_id) {
                    $param['game_id'] = $game_id;
                    $sql_reg .= " and `game_id`=:game_id ";
                    $sql_retain .= " and `game_id`=:game_id ";
                    $sql_upload .= " and `game_id`=:game_id ";
                }
                if ($rsdate) {
                    $param['rsdate'] = $rsdate;
                    $sql_reg .= " and `date` >= :rsdate ";
                    $sql_retain .= " and  `date` >= :rsdate ";
                    $sql_upload .= " and  `date` >= :rsdate ";
                }
                if ($redate) {
                    $param['redate'] = $redate;
                    $sql_reg .= " and `date` <= :redate ";
                    $sql_retain .= " and `date` <= :redate ";
                    $sql_upload .= " and `date` <= :redate ";
                }

                $upload = $this->query($sql_upload, $param);
                $retain = $this->getOne($sql_retain, $param);
                $reg = $this->query($sql_reg, $param);
                $info['retain'] += (int)$retain['retain'];
                $info['reg'] += (int)$retain['reg'];

                foreach ($upload as $k => $v) {
                    $info['cost'] += $v['cost'] / 100;
                    $info['display'] += $v['display'];
                    $info['click'] += $v['click'];
                }


                $reg_uid = '';
                foreach ($reg as $k => $v) {
                    $reg_uid .= $v['reg_uid'] . ',';
                }
                if (!empty($reg_uid)) {
                    $reg_uid = rtrim($reg_uid, ',');
                    $sql_pay = "select  IFNULL(sum(money),0) as pay_money,IFNULL(count(*),0) as payer_num from " . LibTable::$data_pay . " where 1 and uid in (" . $reg_uid . ") ";

                    if ($psdate) {
                        $param['psdate'] = $psdate;
                        $sql_pay .= " and `date` >= :psdate ";
                    }
                    if ($pedate) {
                        $param['pedate'] = $pedate;
                        $sql_pay .= " and `date` <= :pedate ";
                    }
                    $pay = $this->getOne($sql_pay, $param);
                } else {
                    $pay = array('pay_money' => 0, 'payer_num' => 0);
                }
                $info['pay_money'] += $pay['pay_money'];
                $info['payer_num'] += $pay['payer_num'];

            }
        }
        $all_package['all'] = $info;
        if ($all_package['total']['c'] > 0) {
            foreach ($all_package['list'] as $key => $val) {
                $sql_retain = "select sum(`reg`) as reg, sum(`retain2`) as retain  from " . LibTable::$data_retain . " where 1 and `package_name` = '" . $val['package_name'] . "'";

                $sql_reg = "select `reg_uid` from " . LibTable::$data_reg . " where 1  and `package_name` = '" . $val['package_name'] . "'";
                $sql_upload = "select `cost`,`display`,`click` from " . LibTable::$data_upload . " where 1  and `package_name` = '" . $val['package_name'] . "'";

                if ($game_id) {
                    $param['game_id'] = $game_id;
                    $sql_reg .= " and `game_id`=:game_id ";
                    $sql_retain .= " and `game_id`=:game_id ";
                    $sql_upload .= " and `game_id`=:game_id ";
                }
                if ($rsdate) {
                    $param['rsdate'] = $rsdate;
                    $sql_reg .= " and `date` >= :rsdate ";
                    $sql_retain .= " and  `date` >= :rsdate ";
                    $sql_upload .= " and  `date` >= :rsdate ";
                }
                if ($redate) {
                    $param['redate'] = $redate;
                    $sql_reg .= " and `date` <= :redate ";
                    $sql_retain .= " and `date` <= :redate ";
                    $sql_upload .= " and `date` <= :redate ";
                }

                $upload = $this->query($sql_upload, $param);
                $retain = $this->getOne($sql_retain, $param);
                $reg = $this->query($sql_reg, $param);
                $all_package['list'] [$key]['retain'] = (int)$retain['retain'];
                $all_package['list'] [$key]['reg'] = (int)$retain['reg'];

                foreach ($upload as $k => $v) {
                    $all_package['list'] [$key]['cost'] += (int)$v['cost'] / 100;
                    $all_package['list'] [$key]['display'] += (int)$v['display'];
                    $all_package['list'] [$key]['click'] += (int)$v['click'];
                }

                if (empty($all_package['list'][$key]['cost'])) {
                    $all_package['list'] [$key]['cost'] = 0;
                };
                if (empty($all_package['list'][$key]['display'])) {
                    $all_package['list'] [$key]['display'] = 0;
                };
                if (empty($all_package['list'][$key]['click'])) {
                    $all_package['list'] [$key]['click'] = 0;
                };
                $reg_uid = '';
                foreach ($reg as $k => $v) {
                    $reg_uid .= $v['reg_uid'] . ',';
                }
                if (!empty($reg_uid)) {
                    $reg_uid = rtrim($reg_uid, ',');
                    $sql_pay = "select  IFNULL(sum(money),0) as pay_money,IFNULL(count(*),0) as payer_num from " . LibTable::$data_pay . " where 1 and uid in (" . $reg_uid . ") ";

                    if ($psdate) {
                        $param['psdate'] = $psdate;
                        $sql_pay .= " and `date` >= :psdate ";
                    }
                    if ($pedate) {
                        $param['pedate'] = $pedate;
                        $sql_pay .= " and `date` <= :pedate ";
                    }
                    $pay = $this->getOne($sql_pay, $param);
                } else {
                    $pay = array('pay_money' => 0, 'payer_num' => 0);
                }
                $all_package['list'][$key]['pay_money'] = (int)$pay['pay_money'];
                $all_package['list'][$key]['payer_num'] = (int)$pay['payer_num'];
            }
        }
        return $all_package;
    }

    public function getUserIdA($package_name)
    {
        $sql = "select user_id from " . LibTable::$ad_project . " where `package_name` = :package_name ";
        return $this->getOne($sql, array('package_name' => $package_name));
    }

    public function getUserIdI($monitor_id)
    {
        $sql = "select user_id from " . LibTable::$ad_project . " where `monitor_id` = :monitor_id ";
        return $this->getOne($sql, array('monitor_id' => $monitor_id));
    }

    public function getUserName($user_id)
    {
        $sql = "select `user_name` from " . LibTable::$channel_user . " where `user_id` = :user_id ";
        $user_name = $this->getOne($sql, array('user_id' => $user_id));
        return $user_name['user_name'];
    }

    public function getUserList()
    {
        $sql = 'select `user_id`,`user_name` from ' . LibTable::$channel_user . " where 1 ";
        $user_list = $this->query($sql);
        $srvAd = new SrvAd();
        foreach ($user_list as $key => $val) {
            $channel_id = $this->userGetChannel($val['user_id']);
            $channel = $srvAd->getChannelInfo($channel_id);
            $user_list[$key]['user_name'] = $val['user_name'] . '(' . $channel['channel_name'] . ')';
        }

        return $user_list;
    }

    public function getAllChannelUser($channel_id = 0)
    {
        $condition = '';
        if ($channel_id) {
            if (is_array($channel_id)) {
                $condition .= " AND `channel_id` IN(" . implode(',', (array)$channel_id) . ")";
            } else {
                $condition .= " AND `channel_id` = " . (int)$channel_id;
            }
        }

        //权限
        $condition .= SrvAuth::getAuthSql(false, false, 'channel_id', 'user_id');

        $sql = "SELECT * FROM `" . LibTable::$channel_user . "` where 1 {$condition} ORDER BY `channel_id`, `user_id` DESC";
        return $this->query($sql);
    }

    public function userGetChannel($user_id)
    {
        $sql = 'select `channel_id` from ' . LibTable::$channel_user . " where `user_id`=$user_id ";
        $channel_id = $this->getOne($sql);
        return $channel_id['channel_id'];
    }

    /**
     * 推广数据总表
     * @param array $day
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
    public function channelOverview($day = [], $rsdate = '', $redate = '', $psdate = '', $pedate = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0, $channel_id = 0, $user_id = 0, $monitor_id = 0, $group_id = 0)
    {
        $param = [];
        $condition1 = $condition2 = $condition3 = $condition4 = $condition5 = $condition6 = $condition7 = $condition8 = $condition9 = '';

        if ($parent_id) {
            $condition1 .= " AND b.`parent_id` IN(" . implode(',', (array)$parent_id) . ")";
            $condition3 .= " AND c.`parent_id` IN(" . implode(',', (array)$parent_id) . ")";
            $condition8 .= " AND c.`parent_id` IN(" . implode(',', (array)$parent_id) . ")";
            $condition9 .= " AND d.`parent_id` IN(" . implode(',', (array)$parent_id) . ")";
        }
        if ($children_id) {
            $condition1 .= " AND a.`game_id` IN(" . implode(',', (array)$children_id) . ")";
            $condition3 .= " AND a.`game_id` IN(" . implode(',', (array)$children_id) . ")";
            $condition8 .= " AND b.`game_id` IN(" . implode(',', (array)$children_id) . ")";
            $condition9 .= " AND b.`game_id` IN(" . implode(',', (array)$children_id) . ")";
        }
        if ($device_type > 0) {
            $condition1 .= " AND a.`device_type` = :device_type";
            $condition3 .= " AND a.`device_type` = :device_type";
            $condition8 .= " AND b.`device_type` = :device_type";
            $condition9 .= " AND c.`platform` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($channel_id) {
            $condition1 .= " AND a.`channel_id` IN(" . implode(',', (array)$channel_id) . ")";
            $condition3 .= " AND b.`channel_id` IN(" . implode(',', (array)$channel_id) . ")";
            $condition8 .= " AND b.`channel_id` IN(" . implode(',', (array)$channel_id) . ")";
            $condition9 .= " AND b.`channel_id` IN(" . implode(',', (array)$channel_id) . ")";
        }
        if ($user_id) {
            $condition1 .= " AND c.`user_id` IN(" . implode(',', (array)$user_id) . ")";
            $condition3 .= " AND d.`user_id` IN(" . implode(',', (array)$user_id) . ")";
            $condition8 .= " AND d.`user_id` IN(" . implode(',', (array)$user_id) . ")";
            $condition9 .= " AND b.`user_id` IN(" . implode(',', (array)$user_id) . ")";
        }
        if ($monitor_id) {
            $condition1 .= " AND a.`monitor_id` IN(" . implode(',', (array)$monitor_id) . ")";
            $condition3 .= " AND b.`monitor_id` IN(" . implode(',', (array)$monitor_id) . ")";
            $condition8 .= " AND b.`monitor_id` IN(" . implode(',', (array)$monitor_id) . ")";
            $condition9 .= " AND a.`monitor_id` IN(" . implode(',', (array)$monitor_id) . ")";
        }
        if ($group_id) {
            $condition1 .= " AND d.`group_id` IN(" . implode(',', (array)$group_id) . ")";
            $condition3 .= " AND e.`group_id` IN(" . implode(',', (array)$group_id) . ")";
            $condition8 .= " AND e.`group_id` IN(" . implode(',', (array)$group_id) . ")";
            $condition9 .= " AND e.`group_id` IN(" . implode(',', (array)$group_id) . ")";
        }
        if ($rsdate && $redate) {
            $condition2 = $condition1;
            $condition2 .= " AND a.`date` BETWEEN :rsdate AND :redate";

            $condition6 = $condition5 = $condition4 = $condition3;
            $condition4 .= " AND FROM_UNIXTIME(b.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $condition5 .= " AND FROM_UNIXTIME(b.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $condition6 .= " AND a.`date` BETWEEN :rsdate AND :redate";

            $condition3 .= " AND FROM_UNIXTIME(a.`pay_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $condition8 .= " AND FROM_UNIXTIME(b.reg_time, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $condition9 .= " AND a.`date` BETWEEN :rsdate AND :redate";

            $condition1 .= " AND FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $param['rsdate'] = $rsdate;
            $param['redate'] = $redate;
        }
        if ($psdate && $pedate) {
            $condition4 .= " AND a.date BETWEEN :psdate AND :pedate";
            $param['psdate'] = $psdate;
            $param['pedate'] = $pedate;
        }

        //权限
        $auth1 = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'c.`user_id`');
        $auth2 = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'b.`channel_id`', 'd.`user_id`');
        $condition1 .= $auth1;
        $condition2 .= $auth1;
        $condition3 .= $auth2;
        $condition4 .= $auth2;
        $condition5 .= $auth2;
        $condition6 .= $auth2;
        $condition8 .= SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', 'b.`channel_id`', 'd.`user_id`');
        $condition9 .= SrvAuth::getAuthSql('d.`parent_id`', 'b.`game_id`', 'b.`channel_id`', 'b.`user_id`');
        $condition7 = $condition8;

        $retain_field = $retain_total_field = $ltv_field = $ltv_total_field = $ltv_field_sql = [];
        foreach ($day as $d) {
            //留存
            if ($d > 1) {
                $retain_field[] = "0 `retain{$d}`";
                $retain_total_field[] = "SUM(`retain{$d}`) `retain{$d}`";
            }
            //LTV
            $ltv_field[] = "0 `ltv_money{$d}`";
            $ltv_total_field[] = "SUM(`ltv_money{$d}`) `ltv_money{$d}`";
            $ltv_field_sql[] = "SUM(IF(DATEDIFF(e.`date`, FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d')) < {$d}, e.`money`, 0)) ltv_money{$d}";
        }

        $retain_field = implode(', ', $retain_field);
        $retain_total_field = implode(', ', $retain_total_field);

        $ltv_field = implode(', ', $ltv_field);
        $ltv_total_field = implode(', ', $ltv_total_field);
        $ltv_field_sql = implode(', ', $ltv_field_sql);

        //注册和LTV信息
        $group = self::getGroupField(array('a', 'a', 'a', 'd', 'a', 'd', 'FROM_UNIXTIME(a.`reg_time`, "%Y-%m-%d")', 'b'));
        $sql[] = "SELECT {$group[$type]} `group_name`, COUNT(DISTINCT a.`uid`) reg, COUNT(DISTINCT a.device_id) device, 0 consume, 
                      0 new_pay_money, 0 new_pay_count, 0 period_pay_money, 0 period_pay_count, 0 total_pay_money, 
                      0 total_pay_count, 0 active_pay_money, 0 active_pay_count, {$retain_field}, {$ltv_field_sql}, 
                      0 `load`, 0 `ip`, 0 `click`, 0 `active`, 0 `active_device` 
                  FROM `" . LibTable::$user_ext . "` a 
                      LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                      LEFT JOIN `" . LibTable::$ad_project . "` c ON c.`monitor_id` = a.`monitor_id` 
                      LEFT JOIN `" . LibTable::$channel_user . "` d ON d.`user_id` = c.`user_id` 
                      LEFT JOIN `" . LibTable::$data_pay . "` e ON e.`uid` = a.`uid`
                  WHERE 1 {$condition1} GROUP BY `group_name`";

        //消耗信息
        $group = self::getGroupField(array('a', 'a', 'a', 'd', 'a', 'd', 'a.`date`', 'b'));
        $sql[] = "SELECT {$group[$type]} `group_name`, 0 reg, 0 device, SUM(a.`cost`) consume, 0 new_pay_money, 0 new_pay_count, 
                      0 period_pay_money, 0 period_pay_count, 0 total_pay_money, 0 total_pay_count, 0 active_pay_money, 0 active_pay_count, 
                      {$retain_field}, {$ltv_field}, 0 `load`, 0 `ip`, 0 `click`, 0 `active`, 0 `active_device` 
                  FROM `" . LibTable::$data_upload . "` a 
                      LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                      LEFT JOIN `" . LibTable::$ad_project . "` c ON c.`monitor_id` = a.`monitor_id` 
                      LEFT JOIN `" . LibTable::$channel_user . "` d ON d.`user_id` = c.`user_id` 
                  WHERE 1 {$condition2} GROUP BY `group_name`";

        //新增付费信息
        $group = self::getGroupField(array('a', 'a', 'b', 'e', 'b', 'e', 'FROM_UNIXTIME(b.`reg_time`, "%Y-%m-%d")', 'c'));
        $sql[] = "SELECT `group_name`, 0 reg, 0 device, 0 consume, SUM(m) AS new_pay_money, COUNT(*) AS new_pay_count, 
                      0 period_pay_money, 0 period_pay_count, 0 total_pay_money, 0 total_pay_count, 0 active_pay_money, 0 active_pay_count, 
                      {$retain_field}, {$ltv_field}, 0 `load`, 0 `ip`, 0 `click`, 0 `active`, 0 `active_device` 
                  FROM (
                      SELECT {$group[$type]} `group_name`, SUM(a.total_fee) AS m, MAX(a.pay_time) AS last_time, a.uid
                      FROM `" . LibTable::$sy_order . "` a
                          INNER JOIN `" . LibTable::$user_ext . "` b ON b.uid = a.uid
                          LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                          LEFT JOIN `" . LibTable::$ad_project . "` d ON d.`monitor_id` = b.`monitor_id` 
                          LEFT JOIN `" . LibTable::$channel_user . "` e ON e.`user_id` = d.`user_id` 
                      WHERE a.is_pay = " . PAY_STATUS['已支付'] . " AND FROM_UNIXTIME(a.pay_time, '%Y-%m-%d') = FROM_UNIXTIME(b.reg_time, '%Y-%m-%d') {$condition3} 
                      GROUP BY `group_name`, a.uid
                  ) tmp GROUP BY `group_name`";

        //周期付费信息
        $group = self::getGroupField(array('a', 'a', 'b', 'e', 'b', 'e', 'FROM_UNIXTIME(b.`reg_time`, "%Y-%m-%d")', 'c'));
        $sql[] = "SELECT `group_name`, 0 reg, 0 device, 0 consume, 0 new_pay_money, 0 new_pay_count, SUM(m) period_pay_money, COUNT(*) period_pay_count, 
                      0 total_pay_money, 0 total_pay_count, 0 active_pay_money, 0 active_pay_count, {$retain_field}, {$ltv_field}, 
                      0 `load`, 0 `ip`, 0 `click`, 0 `active`, 0 `active_device` 
                  FROM (
                      SELECT {$group[$type]} `group_name`, SUM(a.money) m, a.uid 
                      FROM `" . LibTable::$data_pay . "` a 
                          INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                          LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                          LEFT JOIN `" . LibTable::$ad_project . "` d ON d.`monitor_id` = b.`monitor_id` 
                          LEFT JOIN `" . LibTable::$channel_user . "` e ON e.`user_id` = d.`user_id` 
                      WHERE 1 {$condition4} GROUP BY `group_name`, a.uid
                  ) tmp GROUP BY `group_name`";

        //累计付费信息
        $group = self::getGroupField(array('a', 'a', 'b', 'e', 'b', 'e', 'FROM_UNIXTIME(b.`reg_time`, "%Y-%m-%d")', 'c'));
        $sql[] = "SELECT `group_name`, 0 reg, 0 device, 0 consume, 0 new_pay_money, 0 new_pay_count, 0 period_pay_money, 0 period_pay_count, 
                      SUM(m) AS total_pay_money, COUNT(*) AS total_pay_count, 0 active_pay_money, 0 active_pay_count, 
                      {$retain_field}, {$ltv_field}, 0 `load`, 0 `ip`, 0 `click`, 0 `active`, 0 `active_device` 
                  FROM (
                      SELECT {$group[$type]} `group_name`, SUM(a.money) AS m, a.uid 
                      FROM `" . LibTable::$data_pay . "` a 
                          INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                          LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                          LEFT JOIN `" . LibTable::$ad_project . "` d ON d.`monitor_id` = b.`monitor_id` 
                          LEFT JOIN `" . LibTable::$channel_user . "` e ON e.`user_id` = d.`user_id` 
                      WHERE 1 {$condition5} GROUP BY `group_name`, a.uid
                  ) tmp GROUP BY `group_name`";

        //活跃付费信息
        $group = self::getGroupField(array('a', 'a', 'b', 'e', 'b', 'e', 'a.`date`', 'c'));
        $sql[] = "SELECT `group_name`, 0 reg, 0 device, 0 consume, 0 new_pay_money, 0 new_pay_count, 0 period_pay_money, 0 period_pay_count, 
                      0 total_pay_money, 0 total_pay_count, SUM(m) AS active_pay_money, COUNT(*) AS active_pay_count, 
                      {$retain_field}, {$ltv_field}, 0 `load`, 0 `ip`, 0 `click`, 0 `active`, 0 `active_device` 
                  FROM (
                      SELECT {$group[$type]} `group_name`, SUM(a.money) AS m, a.uid 
                      FROM `" . LibTable::$data_pay . "` a 
                          INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid
                          LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                          LEFT JOIN `" . LibTable::$ad_project . "` d ON d.`monitor_id` = b.`monitor_id` 
                          LEFT JOIN `" . LibTable::$channel_user . "` e ON e.`user_id` = d.`user_id` 
                      WHERE 1 {$condition6} GROUP BY `group_name`, a.uid
                ) tmp GROUP BY `group_name`";

        //留存数据
        $group = self::getGroupField(array('b', 'b', 'b', 'd', 'b', 'e', 'FROM_UNIXTIME(b.`reg_time`, "%Y-%m-%d")', 'c'));
        $sql[] = "SELECT {$group[$type]} `group_name`, 0 reg, 0 device, 0 consume, 0 new_pay_money, 0 new_pay_count, 
                      0 period_pay_money, 0 period_pay_count, 0 total_pay_money, 0 total_pay_count, 0 active_pay_money, 0 active_pay_count, 
                      {$retain_total_field}, {$ltv_field}, 0 `load`, 0 `ip`, 0 `click`, 0 `active`, 0 `active_device` 
                  FROM `" . LibTable::$sy_user_config . "` a 
                      INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                      LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id` = c.`game_id` 
                      LEFT JOIN `" . LibTable::$ad_project . "` d ON b.`monitor_id` = d.`monitor_id` 
                      LEFT JOIN `" . LibTable::$channel_user . "` e ON d.`user_id` = e.`user_id` 
                  WHERE 1 {$condition7} GROUP BY `group_name`";

        //点击数据
        $group = self::getGroupField(array('b', 'c.`platform`', 'b', 'b', 'a', 'e', 'a.`date`', 'd'));
        $sql[] = "SELECT {$group[$type]} `group_name`, 0 reg, 0 device, 0 consume, 0 new_pay_money, 0 new_pay_count, 
                      0 period_pay_money, 0 period_pay_count, 0 total_pay_money, 0 total_pay_count, 0 active_pay_money, 0 active_pay_count, 
                      {$retain_field}, {$ltv_field}, SUM(a.`load`) `load`, SUM(a.`ip`) `ip`, SUM(a.`click`) `click`, SUM(a.`active`) `active`, SUM(a.`active_device`) `active_device` 
                  FROM `" . LibTable::$data_log_day . "` a 
                      LEFT JOIN `" . LibTable::$ad_project . "` b ON b.`monitor_id` = a.`monitor_id` 
                      LEFT JOIN `" . LibTable::$sy_game_package . "` c ON c.`package_name` = b.`package_name` 
                      LEFT JOIN `" . LibTable::$sy_game . "` d ON d.`game_id` = b.`game_id` 
                      LEFT JOIN `" . LibTable::$channel_user . "` e ON e.`user_id` = b.`user_id` 
                  WHERE 1 {$condition9} GROUP BY `group_name`";

        $union = '(' . implode(') UNION ALL (', $sql) . ')';

        $_sql = "SELECT `group_name`, SUM(`reg`) `reg`, SUM(`device`) `device`, SUM(`consume`) `consume`, 
                    SUM(`new_pay_money`) `new_pay_money`, SUM(`new_pay_count`) `new_pay_count`, SUM(`period_pay_money`) `period_pay_money`, 
                    SUM(`period_pay_count`) `period_pay_count`, SUM(`total_pay_money`) `total_pay_money`, 
                    SUM(`total_pay_count`) `total_pay_count`, SUM(`active_pay_money`) `active_pay_money`, SUM(`active_pay_count`) `active_pay_count`, 
                    {$retain_total_field}, {$ltv_total_field}, SUM(`load`) `load`, SUM(`ip`) `ip`, SUM(`click`) `click`, SUM(`active`) `active`, SUM(`active_device`) `active_device` 
                 FROM ({$union}) tmp GROUP BY `group_name` ORDER BY `group_name` DESC, `reg` DESC";
        return $this->query($_sql, $param);
    }

    /**
     * 格式化GROUP BY字段
     * @param array $prefix
     * @return array
     */
    public static function getGroupField($prefix = [])
    {
        $group = array(
            1 => 'game_id',     //按子游戏
            2 => 'device_type', //按手机系统
            3 => 'channel_id',  //按渠道
            4 => 'user_id',     //按投放账号
            5 => 'monitor_id',  //按推广活动
            6 => 'group_id',    //按投放组
            7 => 'reg_date',    //按注册日期
            8 => 'parent_id',   //按母游戏
        );

        $i = 0;
        foreach ($group as $k => $v) {
            $p = &$prefix[$i];
            if ($p && preg_match('/[\.`]/', $p)) {//自定义字段
                $group[$k] = $p;
            } else {
                $group[$k] = $p ? "{$p}.`{$v}`" : "`{$v}`";
            }

            $i++;
        }

        return $group;
    }

    /**
     * 获取用户列表
     * @param int $page
     * @param string $rsdate
     * @param string $redate
     * @param string $field
     * @param int $type
     * @param int $parent_id
     * @param int $children_id
     * @param int $device_type
     * @param int $channel_id
     * @param int $user_id
     * @param int $monitor_id
     * @param int $group_id
     * @return array
     */
    public function queryUser($page = 1, $rsdate = '', $redate = '', $field = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0, $channel_id = 0, $user_id = 0, $monitor_id = 0, $group_id = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);

        $param = [];
        $condition = '';
        $group = self::getGroupField(array('a', 'a', 'a', 'c', 'a', 'd', 'FROM_UNIXTIME(a.`reg_time`, "%Y-%m-%d")', 'b'));
        if ($parent_id) {
            is_array($parent_id) && $parent_id = implode(',', (array)$parent_id);
            $condition .= " AND b.`parent_id` IN({$parent_id})";
        }
        if ($children_id) {
            is_array($children_id) && $children_id = implode(',', (array)$children_id);
            $condition .= " AND a.`game_id` IN({$children_id})";
        }
        if ($channel_id) {
            is_array($channel_id) && $channel_id = implode(',', (array)$channel_id);
            $condition .= " AND a.`channel_id` IN({$channel_id})";
        }
        if ($user_id) {
            is_array($user_id) && $user_id = implode(',', (array)$user_id);
            $condition .= " AND c.`user_id` IN({$user_id})";
        }
        if ($monitor_id) {
            is_array($monitor_id) && $monitor_id = implode(',', (array)$monitor_id);
            $condition .= " AND a.`monitor_id` IN({$monitor_id})";
        }
        if ($group_id) {
            is_array($group_id) && $group_id = implode(',', (array)$group_id);
            $condition .= " AND d.`group_id` IN({$group_id})";
        }
        if ($device_type > 0) {
            $condition .= " AND a.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($rsdate && $redate) {
            $condition .= " AND FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $param['rsdate'] = $rsdate;
            $param['redate'] = $redate;
        }
        if ($field) {
            $condition .= " AND {$group[$type]} = :field";
            $param['field'] = $field;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'c.`user_id`');

        $sql = "SELECT COUNT(*) AS c 
                FROM `" . LibTable::$user_ext . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` c ON c.`monitor_id` = a.`monitor_id` 
                    LEFT JOIN `" . LibTable::$channel_user . "` d ON d.`user_id` = c.`user_id` 
                WHERE 1 {$condition}";
        $row = $this->getOne($sql, $param);
        $count = (int)$row['c'];
        $data = [];
        if ($count > 0) {
            $sql = "SELECT a.*, b.`parent_id`, c.`name` monitor_name, e.`username` 
                    FROM `" . LibTable::$user_ext . "` a 
                        INNER JOIN `" . LibTable::$sy_user . "` e ON e.`uid` = a.`uid` 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                        LEFT JOIN `" . LibTable::$ad_project . "` c ON c.`monitor_id` = a.`monitor_id` 
                        LEFT JOIN `" . LibTable::$channel_user . "` d ON d.`user_id` = c.`user_id` 
                    WHERE 1 {$condition} ORDER BY a.`uid` DESC {$limit}";
            $data = $this->query($sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取用户充值列表
     * @param int $page
     * @param string $rsdate
     * @param string $redate
     * @param string $field
     * @param int $type
     * @param int $parent_id
     * @param int $children_id
     * @param int $device_type
     * @param int $channel_id
     * @param int $user_id
     * @param int $monitor_id
     * @param int $group_id
     * @return array
     */
    public function queryPay($page = 1, $rsdate = '', $redate = '', $field = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0, $channel_id = 0, $user_id = 0, $monitor_id = 0, $group_id = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);

        $param = [];
        $condition = '';
        $group = self::getGroupField(array('a', 'a', 'b', 'd', 'b', 'e', 'FROM_UNIXTIME(a.`pay_time`, "%Y-%m-%d")', 'c'));
        if ($parent_id) {
            is_array($parent_id) && $parent_id = implode(',', (array)$parent_id);
            $condition .= " AND c.`parent_id` IN({$parent_id})";
        }
        if ($children_id) {
            is_array($children_id) && $children_id = implode(',', (array)$children_id);
            $condition .= " AND a.`game_id` IN({$children_id})";
        }
        if ($channel_id) {
            is_array($channel_id) && $channel_id = implode(',', (array)$channel_id);
            $condition .= " AND b.`channel_id` IN({$channel_id})";
        }
        if ($user_id) {
            is_array($user_id) && $user_id = implode(',', (array)$user_id);
            $condition .= " AND d.`user_id` IN({$user_id})";
        }
        if ($monitor_id) {
            is_array($monitor_id) && $monitor_id = implode(',', (array)$monitor_id);
            $condition .= " AND b.`monitor_id` IN({$monitor_id})";
        }
        if ($group_id) {
            is_array($group_id) && $group_id = implode(',', (array)$group_id);
            $condition .= " AND e.`group_id` IN({$group_id})";
        }
        if ($device_type > 0) {
            $condition .= " AND a.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($rsdate && $redate) {
            $condition .= " AND FROM_UNIXTIME(b.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $param['rsdate'] = $rsdate;
            $param['redate'] = $redate;
        }
        if ($field) {
            $condition .= " AND {$group[$type]} = :field";
            $param['field'] = $field;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'b.`channel_id`', 'd.`user_id`');

        $sql = "SELECT b.*, c.`parent_id`, d.`name` monitor_name, f.`username`, COUNT(*) `new_pay_sum`, SUM(a.`total_fee`) AS `new_pay_money`, MAX(a.`pay_time`) AS `last_pay_time` 
                FROM `" . LibTable::$sy_order . "` a 
                    INNER JOIN `" . LibTable::$user_ext . "` b ON b.uid = a.uid 
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` d ON d.`monitor_id` = b.`monitor_id` 
                    LEFT JOIN `" . LibTable::$channel_user . "` e ON e.`user_id` = d.`user_id` 
                    LEFT JOIN `" . LibTable::$sy_user . "` f ON f.`uid` = a.`uid` 
                WHERE a.is_pay = " . PAY_STATUS['已支付'] . " AND FROM_UNIXTIME(a.pay_time, '%Y-%m-%d') = FROM_UNIXTIME(b.reg_time, '%Y-%m-%d') {$condition} 
                GROUP BY a.uid";
        $_sql = "SELECT COUNT(*) AS c FROM ({$sql}) tmp";
        $row = $this->getOne($_sql, $param);
        $count = (int)$row['c'];
        $data = [];
        if ($count > 0) {
            $_sql = $sql . " ORDER BY a.`uid` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取活跃用户列表
     * @param int $page
     * @param string $rsdate
     * @param string $redate
     * @param string $field
     * @param int $type
     * @param int $parent_id
     * @param int $children_id
     * @param int $device_type
     * @param int $channel_id
     * @param int $user_id
     * @param int $monitor_id
     * @param int $group_id
     * @return array
     */
    public function queryActive($page = 1, $rsdate = '', $redate = '', $field = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0, $channel_id = 0, $user_id = 0, $monitor_id = 0, $group_id = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);

        $param = [];
        $condition = '';
        $group = self::getGroupField(array('a', 'a', 'b', 'd', 'b', 'e', 'a.`date`', 'c'));
        if ($parent_id) {
            is_array($parent_id) && $parent_id = implode(',', (array)$parent_id);
            $condition .= " AND c.`parent_id` IN({$parent_id})";
        }
        if ($children_id) {
            is_array($children_id) && $children_id = implode(',', (array)$children_id);
            $condition .= " AND a.`game_id` IN({$children_id})";
        }
        if ($channel_id) {
            is_array($channel_id) && $channel_id = implode(',', (array)$channel_id);
            $condition .= " AND b.`channel_id` IN({$channel_id})";
        }
        if ($user_id) {
            is_array($user_id) && $user_id = implode(',', (array)$user_id);
            $condition .= " AND d.`user_id` IN({$user_id})";
        }
        if ($monitor_id) {
            is_array($monitor_id) && $monitor_id = implode(',', (array)$monitor_id);
            $condition .= " AND b.`monitor_id` IN({$monitor_id})";
        }
        if ($group_id) {
            is_array($group_id) && $group_id = implode(',', (array)$group_id);
            $condition .= " AND e.`group_id` IN({$group_id})";
        }
        if ($device_type > 0) {
            $condition .= " AND a.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($rsdate && $redate) {
            $condition .= " AND a.`date` BETWEEN :rsdate AND :redate";
            $param['rsdate'] = $rsdate;
            $param['redate'] = $redate;
        }
        if ($field) {
            $condition .= " AND {$group[$type]} = :field";
            $param['field'] = $field;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'b.`channel_id`', 'd.`user_id`');

        $sql = "SELECT a.`date`, b.*, c.`parent_id`, d.`name` monitor_name, f.`username`, COUNT(*) `active_pay_sum`, SUM(a.money) AS active_pay_money 
                FROM `" . LibTable::$data_pay . "` a 
                    INNER JOIN `" . LibTable::$user_ext . "` b ON b.uid = a.uid 
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` d ON d.`monitor_id` = b.`monitor_id` 
                    LEFT JOIN `" . LibTable::$channel_user . "` e ON e.`user_id` = d.`user_id` 
                    LEFT JOIN `" . LibTable::$sy_user . "` f ON f.`uid` = a.`uid` 
                WHERE 1 {$condition} 
                GROUP BY a.uid";
        $_sql = "SELECT COUNT(*) AS c FROM ({$sql}) tmp";
        $row = $this->getOne($_sql, $param);
        $count = (int)$row['c'];
        $data = [];
        if ($count > 0) {
            $_sql = $sql . " ORDER BY a.`date` DESC, a.`uid` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取用户充值列表
     * @param int $page
     * @param string $rsdate
     * @param string $redate
     * @param string $field
     * @param int $type
     * @param int $parent_id
     * @param int $children_id
     * @param int $device_type
     * @param int $channel_id
     * @param int $user_id
     * @param int $monitor_id
     * @param int $group_id
     * @return array
     */
    public function queryTotalPay($page = 1, $rsdate = '', $redate = '', $field = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0, $channel_id = 0, $user_id = 0, $monitor_id = 0, $group_id = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);

        $param = [];
        $condition = '';
        $group = self::getGroupField(array('dp', 'ue', 'ue', 'ap', 'ue', 'cu', 'FROM_UNIXTIME(ue.`reg_time`, "%Y-%m-%d")', 'g'));
        if ($parent_id) {
            is_array($parent_id) && $parent_id = implode(',', (array)$parent_id);
            $condition .= " AND g.`parent_id` IN({$parent_id})";
        }
        if ($children_id) {
            is_array($children_id) && $children_id = implode(',', (array)$children_id);
            $condition .= " AND dp.`game_id` IN({$children_id})";
        }
        if ($channel_id) {
            is_array($channel_id) && $channel_id = implode(',', (array)$channel_id);
            $condition .= " AND ue.`channel_id` IN({$channel_id})";
        }
        if ($user_id) {
            is_array($user_id) && $user_id = implode(',', (array)$user_id);
            $condition .= " AND ap.`user_id` IN({$user_id})";
        }
        if ($monitor_id) {
            is_array($monitor_id) && $monitor_id = implode(',', (array)$monitor_id);
            $condition .= " AND ap.`monitor_id` IN({$monitor_id})";
        }
        if ($group_id) {
            is_array($group_id) && $group_id = implode(',', (array)$group_id);
            $condition .= " AND cu.`group_id` IN({$group_id})";
        }
        if ($device_type > 0) {
            $condition .= " AND ue.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($rsdate && $redate) {
            $condition .= " AND FROM_UNIXTIME(ue.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $param['rsdate'] = $rsdate;
            $param['redate'] = $redate;
        }
        if ($field) {
            $condition .= " AND {$group[$type]} = :field";
            $param['field'] = $field;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('g.`parent_id`', 'dp.`game_id`', 'ue.`channel_id`', 'ap.`user_id`');

        $sql = "SELECT ue.*, g.`parent_id`, ap.`name` monitor_name, u.`username`, COUNT(*) `total_pay_num`, SUM(dp.`money`) AS `total_pay_money` 
                  FROM `" . LibTable::$data_pay . "` dp 
                      INNER JOIN `" . LibTable::$user_ext . "` ue ON ue.uid = dp.uid 
                      LEFT JOIN `" . LibTable::$sy_game . "` g ON g.`game_id` = dp.`game_id` 
                      LEFT JOIN `" . LibTable::$ad_project . "` ap ON ap.`monitor_id` = ue.`monitor_id` 
                      LEFT JOIN `" . LibTable::$channel_user . "` cu ON cu.`user_id` = ap.`user_id` 
                      LEFT JOIN `" . LibTable::$sy_user . "` u ON u.`uid` = dp.`uid` 
                  WHERE 1 {$condition} GROUP BY dp.uid";
        $_sql = "SELECT COUNT(*) AS c FROM ({$sql}) tmp";
        $row = $this->getOne($_sql, $param);
        $count = (int)$row['c'];
        $data = [];
        if ($count > 0) {
            $_sql = $sql . " ORDER BY dp.`uid` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }
}