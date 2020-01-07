<?php

class ModAdDataAndorid extends Model
{

    public function __construct()
    {
        parent::__construct('default');
    }

    public function userCycle($parent_id, $game_id, $user_id, $sdate, $edate)
    {
        if ($user_id) {
            $sql_package_name = "select `package_name` from " . LibTable::$ad_project . " where user_id = :user_id ";
            //权限
            $authorSqlForUserId = SrvAuth::getAuthSql('','','','');
            $sql_package_name .= $authorSqlForUserId;
            $package_name = $this->query($sql_package_name, array('user_id' => $user_id));
            $package = '';
            foreach ($package_name as $key => $val) {
                $package .= '\'' . $val['package_name'] . '\',';
            }
            $package = rtrim($package, ',');

        }
        $sql = "select a.`date`,sum(a.`reg`) as `reg`,sum(a.`retain2`) as `retain1`,a.`package_name`
          from `" . LibTable::$data_retain . "` as a 
           left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
           where 1  and a.`device_type` = " . PLATFORM['android'];

        $sql_upload = "select a.`date`,sum(a.`cost`) as `cost`,sum(a.`display`) as `display`,sum(a.`click`) as `click`,a.`package_name` 
          from `" . LibTable::$data_upload . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
           where 1 and a.`device_type` = " . PLATFORM['android'];
        $sql_all_pay = "select sum(`money`) as `pay_money`,`date`,p.`package_name`  from " . LibTable::$data_pay . " as p 
        left join " . LibTable::$user_ext . " as e on e.uid = p.uid 
        left join " . LibTable::$sy_game . " as g on p.`game_id`=g.`game_id`
        where 1  and p.`device_type` = " . PLATFORM['android'];

        $sql_new_pay = "select sum(a.`new_pay`) as `new_pay` ,sum(a.`new_pay_money`) as `new_pay_money`,date(a.`date`) as `date`,a.`package_name` 
            from " . LibTable::$data_pay_new . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
            where 1  and a.`device_type` = " . PLATFORM['android'];
        $authorSql1 = SrvAuth::getAuthSql('b.`parent_id`','a.`game_id`','a.`channel_id`','');
        $authorSql2 = SrvAuth::getAuthSql('g.`parent_id`','p.`game_id`','e.`channel_id`','');

        $param = array();
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id`=:parent_Id";

            $sql_upload .= " and b.`parent_id`=:parent_id";
            $sql_all_pay .=" and g.`parent_id`=:parent_id";
            $sql_new_pay .= " and b.`parent_id`=:parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id`=:game_id ";

            $sql_upload .= " and a.`game_id`=:game_id ";
            $sql_all_pay .= " and p.`game_id`=:game_id ";
            $sql_new_pay .= " and a.`game_id`=:game_id ";
        }
        if ($user_id) {
            $sql .= " and a.`package_name` in ($package) ";

            $sql_upload .= " and a.`package_name` in ($package) ";
            $sql_all_pay .= " and p.`package_name` in ($package) ";
            $sql_new_pay .= " and a.`package_name` in ($package) ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and  a.`date` >= :sdate ";

            $sql_upload .= " and  a.`date` >= :sdate ";
            $sql_all_pay .= " and  p.`date` >= :sdate ";
            $sql_new_pay .= " and date(a.`date`) >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and a.`date` <= :edate ";

            $sql_upload .= " and a.`date` <= :edate ";
            $sql_all_pay .= " and p.`date` <= :edate ";
            $sql_new_pay .= " and date(a.`date`) <= :edate ";
        }

        //权限
        $sql .= $authorSql1;
        $sql_upload .= $authorSql1;
        $sql_all_pay .= $authorSql2;
        $sql_new_pay .= $authorSql1;

        $sql .= " group by a.`date`,a.`package_name` order by a.`date` desc ";

        $sql_upload .= " group by a.`date`,a.`package_name` ";
        $sql_all_pay .= " group by `date`,p.`uid`,`package_name` ";
        $sql_new_pay .= " group by date(a.`date`),a.`package_name` ";

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

    public function dayUserEffect($parent_id, $game_id, $user_id, $sdate, $edate, $pay_sdate, $pay_edate, $monitor_id)
    {

        if ($user_id) {
            $sql_package_name = "select `package_name` from " . LibTable::$ad_project . " where user_id = :user_id ";

            //权限
            $authorSqlForUserId = SrvAuth::getAuthSql('','','','user_id');
            $sql_package_name .= $authorSqlForUserId;

            $package_name = $this->query($sql_package_name, array('user_id' => $user_id));
            $package = '';
            foreach ($package_name as $key => $val) {
                $package .= '\'' . $val['package_name'] . '\',';
            }
            $package = rtrim($package, ',');

        }

        $sql = "select a.`date`,a.`package_name`,sum(a.`reg`) as `reg`,sum(a.`retain2`) as `retain1`,sum(a.`retain3`) as `retain3`,sum(a.`retain7`) as `retain7`,sum(a.`retain15`) as `retain15` ,sum(a.`retain30`) as `retain30` 
                  from `" . LibTable::$data_retain . "` as a 
                  left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
                   where 1 and a.`device_type` = " . PLATFORM['android'];
        $sql_reg = "select a.`date`,a.`package_name`,group_concat(a.`reg_uid`) as `uid` 
            from `" . LibTable::$data_reg . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
                where a.`reg`>0  and a.`device_type` = " . PLATFORM['android'];
        $sql_upload = "select a.`date`,a.`package_name`,sum(a.`cost`) as `cost`,sum(a.`display`) as `display`,sum(a.`click`) as `click` 
          from `" . LibTable::$data_upload . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
           where 1 and a.`device_type` = " . PLATFORM['android'];

        $sql_new_pay = "select sum(a.`new_pay`) as `new_pay` ,sum(a.`new_pay_money`) as `new_pay_money`,date(a.`date`) as `date`,a.`package_name` from " . LibTable::$data_pay_new . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` where 1  and a.`device_type` = " . PLATFORM['android'];
        $sql_ltv = "select sum(a.`money1`) as `money1`, sum(a.`money7`) as `money7` , sum(a.`money30`) as `money30`,sum(a.`money45`) as `money45`,sum(a.`money60`) as `money60`,a.`date`,a.`package_name` from " . LibTable::$data_ltv . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` where 1  and a.`device_type` = " . PLATFORM['android'];
        $sql_dau = "select sum(a.`DAU`) as `DAU`,a.`date`,a.`package_name`,a.`monitor_id` from " . LibTable::$data_dau . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` where 1  and a.`device_type` =  " . PLATFORM['android'];
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`','a.`game_id`','a.`channel_id`','');

        $param = array();
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id`=:parent_id ";
            $sql_reg .= " and b.`parent_id`=:parent_id ";
            $sql_upload .= " and b.`parent_id`=:parent_id ";
            $sql_ltv .= " and b.`parent_id`=:parent_id ";
            $sql_new_pay .= " and b.`parent_id`=:parent_id ";
            $sql_dau .= " and a.`parent_id`=:parent_id ";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id`=:game_id ";
            $sql_reg .= " and a.`game_id`=:game_id ";
            $sql_upload .= " and a.`game_id`=:game_id ";
            $sql_ltv .= " and a.`game_id`=:game_id ";
            //$sql_all_pay .= " and p.`game_id`=:game_id ";
            $sql_new_pay .= " and a.`game_id`=:game_id ";
            $sql_dau .= " and a.`game_id`=:game_id ";
        }
        if ($user_id) {
            $sql .= " and a.`package_name` in ($package) ";
            $sql_reg .= " and a.`package_name` in ($package) ";
            $sql_upload .= " and a.`package_name` in ($package) ";
            $sql_ltv .= " and a.`package_name` in ($package) ";
            $sql_new_pay .= " and a.`package_name` in ($package) ";
            $sql_dau .= " and a.`package_name` in ($package) ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and  a.`date` >= :sdate ";
            $sql_reg .= " and  a.`date` >= :sdate ";
            $sql_upload .= " and  a.`date` >= :sdate ";
            $sql_ltv .= " and  a.`date` >= :sdate ";
            //$sql_all_pay .= " and  p.`date` >= :sdate ";
            $sql_new_pay .= " and date(a.`date`) >= :sdate ";
            $sql_dau .= " and a.`date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and a.`date` <= :edate ";
            $sql_reg .= " and a.`date` <= :edate ";
            $sql_upload .= " and a.`date` <= :edate ";
            $sql_ltv .= " and a.`date` <= :edate ";
            //$sql_all_pay .= " and p.`date` <= :edate ";
            $sql_new_pay .= " and date(a.`date`) <= :edate ";
            $sql_dau .= " and a.`date` <= :edate ";
        }
        if ($monitor_id) {
            $sql_p = "select `package_name` from " . LibTable::$ad_project . " where `monitor_id` = :monitor_id ";
            $package_name = $this->getOne($sql_p, array('monitor_id' => $monitor_id));


            $sql .= " and a.`package_name` = '{$package_name['package_name']}' ";
            $sql_reg .= " and a.`package_name` = '{$package_name['package_name']}' ";
            $sql_upload .= " and a.`package_name` = '{$package_name['package_name']}' ";
            $sql_ltv .= " and a.`package_name` = '{$package_name['package_name']}' ";
            $sql_new_pay .= " and a.`package_name` = '{$package_name['package_name']}' ";
            $sql_dau .= " and a.`package_name` = '{$package_name['package_name']}' ";
        }

        //权限
        $sql .= $authorSql;
        $sql_reg .= $authorSql;
        $sql_upload .= $authorSql;
        $sql_ltv .= $authorSql;
        $sql_dau .= $authorSql;
        $sql_new_pay .= $authorSql;

        $sql .= " group by a.`date`,a.`package_name` order by a.`date` desc ";
        $sql_reg .= " group by a.`date`,a.`package_name` ";
        $sql_upload .= " group by a.`date`,a.`package_name` ";
        $sql_ltv .= " group by a.`date`,a.`package_name` ";
        $sql_dau .= " group by a.`date`,a.`package_name` ";
        $sql_new_pay .= " group by date(a.`date`),a.`package_name` ";

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
                    $ltv_data[$key][$k]['money1'] += $vv['money1'];
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
                $info_data[$key][$v['user_id']]['money1'] = (int)$ltv_data[$key][$v['user_id']]['money1'];
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

    public function userEffect($parent_id, $game_id, $user_id, $rsdate, $redate, $psdate, $pedate)
    {
        //$user_id = 4;
        if ($user_id) {
            $authorSqlForUserId = SrvAuth::getAuthSql('','','','user_id');
            $sql_package_name = "select `package_name` from " . LibTable::$ad_project . " where user_id = :user_id ";
            //权限
            $sql_package_name .= $authorSqlForUserId;
            $package_name = $this->query($sql_package_name, array('user_id' => $user_id));
            $package = '';
            foreach ($package_name as $key => $val) {
                $package .= '\'' . $val['package_name'] . '\',';
            }
            $package = rtrim($package, ',');
        }
        $sql_retain = "select sum(a.`reg`) as reg, sum(a.`retain2`) as retain,a.`package_name` 
                        from " . LibTable::$data_retain . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
                        where 1 and a.`device_type` = " . PLATFORM['android'];//注册数和次日留存数
        $sql_reg = "select a.`reg_uid`,a.`package_name` 
              from " . LibTable::$data_reg . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
              where 1  and a.`device_type` = " . PLATFORM['android'];//注册uid
        $sql_upload = "select sum(a.`cost`) as `cost`,sum(a.`display`) as `display`,sum(a.`click`) as `click` ,a.`package_name`
          from " . LibTable::$data_upload . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
            where 1  and a.`device_type` = " . PLATFORM['android'];

        $authorSql = SrvAuth::getAuthSql('b.`parent_id`','a.`game_id`','a.`channel_id`','');
        if ($parent_id) {
            $sql_retain .= " and b.`parent_id`=:parent_id";
            $sql_reg .= " and b.`parent_id`=:parent_id";
            $sql_upload .= " and b.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($user_id) {
            $sql_retain .= " and a.`package_name` in ($package) ";
            $sql_reg .= " and a.`package_name` in ($package) ";
            $sql_upload .= " and a.`package_name` in ($package) ";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql_reg .= " and a.`game_id`=:game_id ";
            $sql_retain .= " and a.`game_id`=:game_id ";
            $sql_upload .= " and a.`game_id`=:game_id ";
        }
        if ($rsdate) {
            $param['rsdate'] = $rsdate;
            $sql_reg .= " and a.`date` >= :rsdate ";
            $sql_retain .= " and  a.`date` >= :rsdate ";
            $sql_upload .= " and  a.`date` >= :rsdate ";
        }
        if ($redate) {
            $param['redate'] = $redate;
            $sql_reg .= " and a.`date` <= :redate ";
            $sql_retain .= " and a.`date` <= :redate ";
            $sql_upload .= " and a.`date` <= :redate ";
        }

        //权限
        $sql_retain .= $authorSql;
        $sql_reg .= $authorSql;
        $sql_upload .= $authorSql;

        $sql_retain .= " group by a.`package_name` ";
        //$sql_reg .= " group by `package_name` ";
        $sql_upload .= " group by a.`package_name` ";
        $upload = $this->query($sql_upload, $param);
        $retain = $this->query($sql_retain, $param);
        $reg = $this->query($sql_reg, $param);


        foreach ($upload as $key => $val) {
            $monitor_temp = $this->getUserId($val['package_name']);
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
            $monitor_temp = $this->getUserId($val['package_name']);
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
            $monitor_temp = $this->getUserId($val['package_name']);
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

    public function hourLand($page, $package_name, $parent_id, $game_id, $channel_id, $sdate, $edate, $all, $is_excel = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        if ($is_excel > 0) {
            $limit = '';
        }

        $sql = "select h.* from " . LibTable::$data_hour_land . " as h 
                    left join " . LibTable::$sy_game_package . " as p on p.`package_name`=h.`package_name` 
                    left join `" . LibTable::$sy_game . "` as g on p.`game_id`=g.`game_id` 
                     where 1 and `platform` =  " . PLATFORM['android'];

        $sql_count = "select count(*) as c from `" . LibTable::$data_hour_land . "` as h 
                    left join `" . LibTable::$sy_game_package . "` as p on p.`package_name`=h.`package_name` 
                    left join `" . LibTable::$sy_game . "` as g on p.`game_id`=g.`game_id` 
                        where 1 and `platform`= " . PLATFORM['android'];
        $param = array();
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and g.`parent_id`=:parent_id";
            $sql_count .= " and g.`parent_id`=:parent_id";
        }
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
        //权限
        $authorSql = SrvAuth::getAuthSql('g.`parent_id`','h.game_id','h.channel_id','');
        $sql .= $authorSql;
        $sql_count .= $authorSql;

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
            $sql .= " and `monitor_id` = :monitor_id ";
            $sql_reg .= " and `monitor_id` = :monitor_id ";
            $sql_upload .= " and `monitor_id` = :monitor_id ";
            $sql_ltv .= " and `monitor_id` = :monitor_id ";
            $sql_new_pay .= " and `monitor_id` = :monitor_id ";
            $sql_dau .= " and `monitor_id` = :monitor_id ";
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
            $re['dau'] = $dau_data[$re['date']];
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

    public function channelEffect($page, $channel_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
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

    public function activityEffect($parent_id, $channel_id, $game_id, $rsdate, $redate, $psdate, $pedate, $is_excel = 0)
    {
        $param = [];
        $condition = "";

        $param['rsdate'] = $rsdate;
        $param['redate'] = $redate;
        $param['psdate'] = $psdate;
        $param['pedate'] = $pedate;

        if (!empty($channel_id)) {
            $condition .= " AND a.channel_id IN(:channel_id)";
            $param['channel_id'] = $channel_id;
        }
        if ($parent_id) {
            $condition .= " AND yg.`parent_id`= :parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id > 0) {
            $condition .= " AND a.game_id = :game_id";
            $param['game_id'] = $game_id;
        }

        //权限
        $authorSql = SrvAuth::getAuthSql('yg.`parent_id`','a.`game_id`','a.`channel_id`','');

        $sql = "SELECT f.`name` monitor_name, f.`create_user`, g.`user_name`, a.`game_id`, a.`channel_id`, a.package_name, b.reg, b.retain, c.cost, c.display, c.click, d.total_money, e.pay_money, e.pay_count 
                FROM `" . LibTable::$sy_game_package . "` a 
                LEFT JOIN (
                    SELECT package_name, SUM(reg) reg, SUM(retain2) retain 
                    FROM `" . LibTable::$data_retain . "` a 
                    LEFT JOIN `".LibTable::$sy_game."` yg ON a.`game_id`=yg.`game_id`
                    WHERE a.`date` BETWEEN :rsdate AND :redate {$condition} {$authorSql} GROUP BY package_name
                ) b ON a.package_name = b.package_name 
                LEFT JOIN (
                    SELECT package_name, SUM(cost) cost, SUM(display) display, SUM(click) click 
                    FROM `" . LibTable::$data_upload . "` a 
                    LEFT JOIN `".LibTable::$sy_game."` yg ON a.`game_id`=yg.`game_id`
                    WHERE a.`date` BETWEEN :rsdate AND :redate {$condition} {$authorSql} GROUP BY package_name
                ) c ON a.package_name = c.package_name
                LEFT JOIN (
                    SELECT b.package_name, SUM(b.money) total_money 
                    FROM `" . LibTable::$data_pay . "` b 
                    LEFT JOIN `" . LibTable::$sy_game_package . "` a ON a.package_name = b.package_name 
                    LEFT JOIN `".LibTable::$sy_game."` yg ON a.`game_id`=yg.`game_id`
                    WHERE b.`date` BETWEEN :rsdate AND :redate {$condition} {$authorSql} GROUP BY b.package_name
                ) d ON a.package_name = d.package_name
                LEFT JOIN (
                    SELECT package_name, SUM(m) pay_money, COUNT(*) pay_count 
                    FROM (
                        SELECT a.package_name, SUM(b.money) m, b.uid 
                        FROM `" . LibTable::$data_pay . "` b 
                        LEFT JOIN `" . LibTable::$user_ext . "` a ON a.uid = b.uid 
                        LEFT JOIN `".LibTable::$sy_game."` yg ON a.`game_id`=yg.`game_id` 
                        WHERE b.`date` BETWEEN :psdate AND :pedate AND FROM_UNIXTIME(a.reg_time,'%Y-%m-%d') BETWEEN :rsdate AND :redate 
                        {$condition} {$authorSql} GROUP BY a.package_name, b.uid
                    ) tmp GROUP BY package_name
                ) e ON a.package_name = e.package_name 
                LEFT JOIN `" . LibTable::$ad_project . "` f ON a.package_name = f.package_name 
                LEFT JOIN `" . LibTable::$channel_user . "` g ON f.user_id = g.user_id 
                LEFT JOIN `" . LibTable::$sy_game . "` as yg ON a.`game_id`= yg.`game_id`
                WHERE a.`platform` = " . PLATFORM['android'] . " AND (b.reg > 0 OR c.cost > 0 OR d.total_money > 0 OR e.pay_money > 0) 
                {$condition} {$authorSql} 
                ORDER BY d.total_money DESC, c.cost DESC, b.reg DESC, a.package_name";
        return $this->query($sql, $param);
    }

    public function getUserId($package_name)
    {
        $sql = "select user_id from " . LibTable::$ad_project . " where `package_name` = :package_name ";
        return $this->getOne($sql, array('package_name' => $package_name));
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

    public function userGetChannel($user_id)
    {
        $sql = 'select `channel_id` from ' . LibTable::$channel_user . " where `user_id`=$user_id ";
        $channel_id = $this->getOne($sql);
        return $channel_id['channel_id'];
    }

}