<?php

class ModData extends Model
{

    public function __construct()
    {
        $this->conn = 'default';
    }

    public function channelHourPay($parent_id, $game_id, $channel_id, $device_type, $user_type, $sdate, $edate)
    {
        $sql = "select sum(a.`old_money`) as `old_money` ,sum(a.`new_money`) as `new_money`,a.`date`,a.`channel_id` 
                  from " . LibTable::$data_channel_hour_pay . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
                  where 1 ";
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and a.`date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and a.`date` <= :edate ";
        }
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id`=:parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id` = :game_id ";
        }

        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " and a.`device_type` = :device_type ";
        }

        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and a.`channel_id` in ( " . $channel_id . " ) ";
        }
        //权限
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', '');
        $sql .= $authorSql;

        $sql .= ' group by a.`date`,a.`channel_id` ';
        $info['list'] = $this->query($sql, $param);

        return $info;
    }

    /*public function updateExtendCost($date,$monitor_id,$cost){
        return $this->update(array(
            'cost' => $cost,
        ),array(
            'date' => $date,
            'monitor_id' => $monitor_id,
        ),LibTable::$data_overview_day);
    }*/
    public function payArea($sdate, $game_id, $parent_id)
    {
        $sql = "select sum(a.`pay`) as `pay`,sum(a.`pay_money`) as `pay_money`,sum(a.`reg`) as `reg`,a.`area` 
              from `" . LibTable::$data_pay_area . "`as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
              where 1 ";

        $sql_count = "select count(*) as c 
                        from `" . LibTable::$data_pay_area . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`      
                        where 1 ";
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and a.`date` = :sdate ";
            $sql_count .= " and a.`date` = :sdate ";
        }
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id`=:parent_id";
            $sql_count .= " and b.`parent_id`=:parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id` = :game_id ";
            $sql_count .= " and a.`game_id` = :game_id ";
        }

        //权限部分
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');
        $sql .= $authorSql;
        $sql_count .= $authorSql;

        $sql .= ' group by a.`area` ';
        $sql_count .= ' group by a.`area` ';
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count,
        );
    }

    public function uploadData($date, $monitor_id, $package_name, $cost, $display, $click, $game_id, $channel_id)
    {
        $insert = $update = array(
            'cost' => $cost,
            'display' => $display,
            'click' => $click,
        );
        $insert['date'] = $date;
        $insert['monitor_id'] = $monitor_id;
        $insert['game_id'] = $game_id;
        $insert['package_name'] = $package_name;
        $package = explode('_', $package_name);
        $insert['device_type'] = PLATFORM[$package[1]];
        $insert['channel_id'] = $channel_id;
        $this->insertOrUpdate($insert, $update, LibTable::$data_upload);
    }

    public function uploadSplitData($game_id, $channel_id, $date, $cp_split, $channel_split)
    {
        $insert = $update = array(
            'cp_split' => $cp_split,
            'channel_split' => $channel_split,
            'month' => $date
        );
        $insert['game_id'] = $game_id;
        $insert['channel_id'] = $channel_id;
        $this->insertOrUpdate($insert, $update, LibTable::$data_split_upload);
    }

    public function getOverview($parent_id, $device_type, $sdate, $edate)
    {
        $param = [];
        $condition1 = $condition2 = $condition3 = "";
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= " AND b.`parent_id` = :parent_id";
            $condition2 .= " AND c.`parent_id` = :parent_id";
            $condition3 .= " AND c.`parent_id` = :parent_id";
        }
        if ($device_type > 0) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND a.`device_type` = :device_type";
            $condition2 .= " AND b.`platform` = :device_type";
            $condition3 .= " AND a.`device_type` = :device_type";
        }
        if ($sdate && $edate) {
            $param['sdate'] = $sdate;
            $param['edate'] = $edate;
            $condition3 .= " AND a.`date` = FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') AND a.`date` BETWEEN :sdate AND :edate AND FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') BETWEEN :sdate AND :edate";

            $condition1 .= " AND a.`date` BETWEEN :sdate AND :edate";
            $condition2 .= " AND a.`date` BETWEEN :sdate AND :edate";
        }

        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', '', '', '');
        $authorSql2 = SrvAuth::getAuthSql('c.`parent_id`', '', '', '');

        $sql = "SELECT a.*, b.cost, b.display, b.click, c.new_role, d.new_pay_money, d.new_pay_user, e.active 
                FROM (
                    SELECT `date`, SUM(total_user) total_user, SUM(reg_user) reg_user, SUM(login_user) login_user, SUM(reg_device) reg_device, SUM(pay_user) pay_user, SUM(pay_money) pay_money, 
                    SUM(retain1) retain1, SUM(retain2) retain2, SUM(retain3) retain3, SUM(retain7) retain7, SUM(retain15) retain15, SUM(retain30) retain30, SUM(retain60) retain60, SUM(retain90) retain90 
                    FROM `" . LibTable::$data_new_overview . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                    WHERE 1 {$condition1} {$authorSql} GROUP BY `date`
                ) a 
                LEFT JOIN (
                    SELECT `date`, SUM(cost) cost, SUM(display) display, SUM(click) click 
                    FROM `" . LibTable::$data_upload . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                    WHERE 1 {$condition1} {$authorSql} GROUP BY `date`
                ) b ON a.`date` = b.`date` 
                LEFT JOIN (
                    SELECT a.`date`, SUM(a.new_role) new_role 
                    FROM `" . LibTable::$data_new_role . "` a 
                        LEFT JOIN `" . LibTable::$sy_game_package . "` b ON a.package_name = b.package_name 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = b.`game_id` 
                    WHERE 1 {$condition2} {$authorSql2} GROUP BY a.`date`
                ) c ON a.`date` = c.`date` 
                LEFT JOIN (
                    SELECT reg_date, SUM(m) new_pay_money, COUNT(*) new_pay_user 
                    FROM (
                            SELECT FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') reg_date, SUM(a.money) m 
                            FROM `" . LibTable::$data_pay . "` a 
                                INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                                LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                            WHERE 1 {$condition3} {$authorSql2} GROUP BY reg_date, a.uid
                    ) tmp GROUP BY reg_date
                ) d ON a.`date` = d.`reg_date` 
                LEFT JOIN (
                    SELECT a.`date`, SUM(a.active) active 
                    FROM `" . LibTable::$data_overview_day . "` a 
                        LEFT JOIN `" . LibTable::$sy_game_package . "` b ON a.package_name = b.package_name 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                    WHERE a.active > 0 {$condition2} {$authorSql2} GROUP BY a.`date`
                ) e ON a.`date` = e.`date` 
                ORDER BY a.`date` DESC";
        return $this->query($sql, $param);
    }

    public function getOverview2($parent_id, $game_id, $device_type, $sdate, $edate, $day, $ltvDay, $type)
    {
        $param = [];

        $condition1 = $condition2 = $condition3 = $condition4 = $condition5 = "";
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= " AND b.`parent_id` = :parent_id";
            $condition2 .= " AND c.`parent_id` = :parent_id";
            $condition3 .= " AND c.`parent_id` = :parent_id";
            $condition4 .= " AND c.`parent_id` = :parent_id";
            $condition5 .= " AND b.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND a.`game_id` = :game_id";
            $condition2 .= " AND c.`game_id` = :game_id";
            $condition3 .= " AND a.`game_id` = :game_id";
            $condition4 .= " AND b.`game_id` = :game_id";
            $condition5 .= " AND a.`game_id` = :game_id";
        }
        if ($device_type > 0) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND a.`device_type` = :device_type";
            $condition2 .= " AND b.`platform` = :device_type";
            $condition3 .= " AND a.`device_type` = :device_type";
            $condition4 .= " AND b.`device_type` = :device_type";
            $condition5 .= " AND a.`device_type` = :device_type";
        }
        if ($sdate && $edate) {
            $param['sdate'] = $sdate;
            $param['edate'] = $edate;
            $condition3 .= " AND a.`date` = FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') AND a.`date` BETWEEN :sdate AND :edate AND FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') BETWEEN :sdate AND :edate";
            $condition4 .= " AND FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') BETWEEN :sdate AND :edate";

            $condition1 .= " AND a.`date` BETWEEN :sdate AND :edate";
            $condition2 .= " AND a.`date` BETWEEN :sdate AND :edate";
            $condition5 .= " AND a.`active_date` BETWEEN :sdate AND :edate";
        }

        $retain_field = $retain_total_field = $ltv_field = $ltvFieldList = [];
        foreach ($day as $d) {
            //留存
            $retain_field[] = "f.retain{$d}";
            $retain_total_field[] = "SUM(`retain{$d}`) `retain{$d}`";
        }
        foreach ($ltvDay as $day) {
            $ltv_field[] = " SUM(a.`money{$day}`) AS `ltv_money{$day}`";
            $ltvFieldList[] = "g.`ltv_money{$day}`";
        }

        $retain_field = implode(', ', $retain_field);
        $ltvFieldList = join(' , ', $ltvFieldList);
        $retain_total_field = implode(', ', $retain_total_field);

        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');
        $authorSql2 = SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', '', '');
        $authorSql3 = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');

        /*$group1 = self::getGroupField(array('a', 'a', 'b', 'a', 'DATE_FORMAT(a.`date`,"%Y-%m")'));
        $group2 = self::getGroupField(array('c', 'b.`platform`', 'c', 'a', 'DATE_FORMAT(a.`date`,"%Y-%m")'));
        $group3 = self::getGroupField(array('a', 'b', 'c', 'FROM_UNIXTIME(b.`reg_time`,"%Y-%m-%d")', 'FROM_UNIXTIME(b.`reg_time`,"%Y-%m")'));
        $group4 = self::getGroupField(array('a', 'a', 'b', 'a.`active_date`', 'DATE_FORMAT(a.`active_date`,"%Y-%m")'));
        $group5 = self::getGroupField(array('b', 'b', 'c', 'FROM_UNIXTIME(b.`reg_time`,"%Y-%m-%d")', 'FROM_UNIXTIME(b.`reg_time`,"%Y-%m")'));
        $group6 = self::getGroupField(array('a', 'a', 'c', 'a', 'DATE_FORMAT(a.`date`,"%Y-%m")'));*/

        $group1 = ModAdData::getGroupField(array('a','a','','','','','a.`date`','b','DATE_FORMAT(a.`date`,"%Y-%m")','DATE_FORMAT(a.`date`,"%Y-%u")'));
        $group2 = ModAdData::getGroupField(array('c','b.`platform`','','','','','a.date','c','DATE_FORMAT(a.`date`,"%Y-%m")','DATE_FORMAT(a.`date`,"%Y-%u")'));
        $group3 = ModAdData::getGroupField(array('a','b','','','','','FROM_UNIXTIME(b.`reg_time`,"%Y-%m-%d")','c','FROM_UNIXTIME(b.`reg_time`,"%Y-%m")','FROM_UNIXTIME(b.`reg_time`,"%Y-%u")'));
        $group4 = ModAdData::getGroupField(array('a','a','','','','','a.`active_date`','b','DATE_FORMAT(a.`active_date`,"%Y-%m")','DATE_FORMAT(a.`active_date`,"%Y-%u")'));
        $group5 = ModAdData::getGroupField(array('b','b','','','','','FROM_UNIXTIME(b.`reg_time`,"%Y-%m-%d")','c','FROM_UNIXTIME(b.`reg_time`,"%Y-%m")','FROM_UNIXTIME(b.`reg_time`,"%Y-%u")'));
        $group6 = ModAdData::getGroupField(array('a','a','','','','','a.date','c','DATE_FORMAT(a.`date`,"%Y-%m")','DATE_FORMAT(a.`date`,"%Y-%u")'));

        $sql = "SELECT a.*, b.cost, b.display, b.click, c.new_role, d.new_pay_money, d.new_pay_user, e.active, e.active_device, {$retain_field} , {$ltvFieldList}
                FROM (
                    SELECT {$group1[$type]} `group_name`, SUM(total_user) total_user,  SUM(reg_user) reg_user, SUM(login_user) login_user, SUM(reg_device) reg_device, SUM(pay_user) pay_user, 
                    SUM(pay_money) pay_money ,SUM(`new_pay_user`) as new_charge_user,SUM(`new_pay_money`) as new_charge_money
                    FROM `" . LibTable::$data_new_overview . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                    WHERE 1 {$condition1} {$authorSql} GROUP BY `group_name`
                ) a LEFT JOIN ( SELECT {$group1[$type]} `group_name`, SUM(cost) cost, SUM(display) display, SUM(click) click 
                        FROM `" . LibTable::$data_upload . "` a FORCE INDEX(channel_name)
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` WHERE 1 {$condition1} {$authorSql} GROUP BY `group_name`
                ) b ON a.`group_name` = b.`group_name` 
                LEFT JOIN ( SELECT {$group2[$type]} `group_name`, SUM(a.new_role) new_role 
                    FROM `" . LibTable::$data_new_role . "` a 
                        LEFT JOIN `" . LibTable::$sy_game_package . "` b ON a.package_name = b.package_name 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = b.`game_id` 
                    WHERE 1 {$condition2} {$authorSql2} GROUP BY `group_name`
                ) c ON a.`group_name` = c.`group_name` 
                LEFT JOIN (
                    SELECT  `group_name`, SUM(m) new_pay_money, COUNT(*) new_pay_user 
                    FROM (
                        SELECT {$group3[$type]} `group_name`, SUM(a.money) m 
                        FROM `" . LibTable::$data_pay . "` a 
                            FORCE INDEX(`uid`)
							FORCE INDEX(`date`)
                            INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                        WHERE 1 {$condition3} {$authorSql3} GROUP BY `group_name`, a.uid
                    ) tmp GROUP BY `group_name`
                ) d ON a.`group_name` = d.`group_name` 
                LEFT JOIN (
                    SELECT {$group4[$type]} `group_name`, COUNT(*) `active`, COUNT(DISTINCT a.device_id) active_device 
                    FROM `" . LibTable::$active . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                    WHERE 1 {$condition5} {$authorSql} GROUP BY `group_name`
                ) e ON a.`group_name` = e.`group_name` 
                LEFT JOIN (
                    SELECT {$group5[$type]} `group_name`, {$retain_total_field} 
                    FROM `" . LibTable::$sy_user_config . "` a 
                        INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id` = c.`game_id` 
                    WHERE 1 {$condition4} {$authorSql2} GROUP BY `group_name`
                ) f ON a.`group_name` = f.`group_name` 
                -- ltv
                LEFT JOIN (
                    SELECT {$group6[$type]} `group_name`," . join(",", $ltv_field) . " 
                    FROM `" . LibTable::$data_ltv . "` as a
                        LEFT JOIN `" . LibTable::$sy_game . "` as c ON a.`game_id`=c.`game_id`
                        LEFT JOIN `" . LibTable::$sy_game_package . "` as b ON a.`package_name`=b.`package_name`
                    WHERE 1 {$condition2} {$authorSql2} GROUP BY `group_name`    
                ) g ON a.`group_name`=g.`group_name`
                ORDER BY a.`group_name` DESC";
        return $this->query($sql, $param);
    }

    public function getOverviewMonth($page, $parent_id, $game_id, $device_type, $month, $all, $plus_)
    {
        $conn = $this->connDb($this->conn);
        //$limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        $date_arr = explode('-', $month);
        $thisMonth = date('Y-m');
        $month_arr = explode('-', $thisMonth);

        if ($plus_ > 0) {
            if ($month_arr[0] == $date_arr[0]) {
                if ((int)$month_arr[1] > (int)$date_arr[1]) {
                    $sql_plus = "select * from " . LibTable::$data_new_overview_months . " as a 
                    left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
                    where `reg_date` = '$month" . '-01' . "' and `date`<='" . date('Y-m-d') . "'";
                }
            } else {
                $sql_plus = "select * from " . LibTable::$data_new_overview_months . " as a 
                 left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
                  where `reg_date` = '$month" . '-01' . "' and `date`<='" . date('Y-m-d') . "'";
            }
        }

        $sql = "select * from `" . LibTable::$data_new_overview_month . "` as a 
                    left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
                        where 1 ";
        $sql_count = "select count(*) as c,
                    sum(a.`reg_user`) as `all_reg_user`,
                    avg(a.`login_user`) as `avg_login_user`,
                    sum(a.`login_user`) as `all_login_user`,
                    sum(a.`reg_device`) as `all_reg_device`,
                    sum(a.`new_pay_user`) as `all_new_pay_user`,
                    avg(a.`new_pay_user`) as `avg_new_pay_user`,
                    sum(a.`new_pay_money`) as `all_new_pay_money`,
                    sum(a.`pay_user`) as `all_pay_user`,
                    avg(a.`pay_user`) as `avg_pay_user`,
                    sum(a.`pay_money`) as `all_pay_money`,
                    avg(a.`retain2`) as `avg_retain2`,
                    avg(a.`retain3`) as `avg_retain3`,
                    avg(a.`retain7`) as `avg_retain7`,
                    avg(a.`retain15`) as `avg_retain15`,
                    avg(a.`retain30`) as `avg_retain30`,
                    avg(a.`retain60`) as `avg_retain60`,
                    avg(a.`retain90`) as `avg_retain90`,
                    sum(a.`retain2`) as `sum_retain2`,
                    sum(a.`retain3`) as `sum_retain3`,
                    sum(a.`retain7`) as `sum_retain7`,
                    sum(a.`retain15`) as `sum_retain15`,
                    sum(a.`retain30`) as `sum_retain30`,
                    sum(a.`retain60`) as `sum_retain60`,
                    sum(a.`retain90`) from `" . LibTable::$data_new_overview_month . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
                    where 1 ";

        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id` = :game_id ";
            $sql_count .= " and a.`game_id` = :game_id ";
            if ($sql_plus) {
                $sql_plus .= " and a.`game_id` = :game_id ";
            }
        }
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id`=:parent_id";
            $sql_count .= " and b.`parent_id`=:parent_id";
            if ($sql_plus) {
                $sql_plus .= " and b.`parent_id`=:parent_id";
            }
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " and a.`device_type` = :device_type ";
            $sql_count .= " and a.`device_type` = :device_type ";
            if ($sql_plus) {
                $sql_plus .= " and a.`device_type` = :device_type ";
            }
        }
        if ($month) {
            $param['month'] = $date_arr[1];
            $param['year'] = $date_arr[0];
            $sql .= " and year(a.`date`) = :year and month(`date`) =:month ";
            $sql_count .= " and year(a.`date`) = :year and month(`date`) = :month ";
        }

        if ($all == 0) {
            $sql .= " and (a.`total_user`>0 or a.`reg_user`>0 or a.`login_user`>0 or a.`reg_device`>0 or a.`new_pay_user` >0 or a.`new_pay_money`>0 or a.`pay_user`>0 or a.`pay_money`>0 or a.`retain1`>0 or a.`retain3`>0 or a.`retain7`>0 or a.`retain15`>0 or a.`retain30`>0 or a.`retain60`>0 or a.`retain90`>0) ";
            $sql_count .= " and (a.`total_user`>0 or a.`reg_user`>0 or a.`login_user`>0 or a.`reg_device`>0 or a.`new_pay_user` >0 or a.`new_pay_money`>0 or a.`pay_user`>0 or a.`pay_money`>0 or a.`retain1`>0 or a.`retain3`>0 or a.`retain7`>0 or a.`retain15`>0 or a.`retain30`>0 or a.`retain60`>0 or a.`retain90`>0) ";
        }

        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');

        $sql .= $authorSql;
        $sql_count .= $authorSql;
        $sql_plus && $sql_plus .= $authorSql;

        $sql .= " order by a.`date` desc ";
        $count = $this->getOne($sql_count, $param);
        if ($sql_plus) {
            $plus = $this->query($sql_plus . ' group by a.`date` desc ', $param);
        }
        $info = $this->query($sql, $param);
        if ($plus) {
            $info = array_merge($plus, $info);
            foreach ($plus as $key => $val) {
                $count['all_login_user'] += $val['login_user'];
                $count['all_pay_user'] += $val['pay_user'];
                $count['all_pay_money'] += $val['pay_money'];
                $count['c'] += 1;
            }
            $count['avg_pay_user'] = number_format($count['all_pay_user'] / $count['c'], 2, '.', '');
        }

        if (!$count['c']) return array();
        return array(
            'list' => $info,
            'total' => $count,
        );
    }

    public function overviewDay($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all, $sort_by, $sort_type, $user_id)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select *,(`reg`/`click`) as `click_reg` from `" . LibTable::$data_overview_day . "` where 1 ";
        $sql2 = "select `monitor_id` from `" . LibTable::$data_overview_day . "` where 1 ";
        $sql_count = "select count(*) as c,sum(`new_reg_device`) as `new_reg_device`, sum(`reg`) as `reg`,sum(`active`) as `active`,sum(`click`) as `click`,sum(`new_pay`) as `new_pay`,sum(`new_money`) as `new_money`,sum(`old_pay`) as `old_pay`,sum(`old_money`) as `old_money`,sum(`cost`) as `cost` from `" . LibTable::$data_overview_day . "` where 1 ";
        $param = array();
        if ($user_id) {
            $tmp = $this->query("select `monitor_id`, `package_name` from " . LibTable::$ad_project . " where user_id = :user_id ", array('user_id' => $user_id));
            $_sql = $package = $mid = '';
            foreach ($tmp as $key => $val) {
                if (strstr($val['package_name'], 'ios')) {
                    $mid .= $val['monitor_id'] . ',';
                } elseif (strstr($val['package_name'], 'android')) {
                    $package .= '\'' . $val['package_name'] . '\',';
                }
            }
            if ($package) {
                $package = rtrim($package, ',');
                $_sql .= "`package_name` in ($package) ";
            }
            if ($mid) {
                $mid = rtrim($mid, ',');
                if ($package) {
                    $_sql .= "or `monitor_id` in ($mid)";
                } else {
                    $_sql .= "`monitor_id` in ($mid)";
                }
            }

            if ($_sql) {
                $sql .= " and ($_sql) ";
                $sql2 .= " and ($_sql) ";
                $sql_count .= " and ($_sql) ";
            }
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id` = :game_id ";
            $sql2 .= " and `game_id` = :game_id ";
            $sql_count .= " and `game_id` = :game_id ";
        }
        if ($package_name) {
            $param['package_name'] = $package_name;
            $sql .= " and `package_name` = :package_name ";
            $sql2 .= " and `package_name` = :package_name ";
            $sql_count .= " and `package_name` = :package_name ";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and `channel_id` = :channel_id ";
            $sql2 .= " and `channel_id` = :channel_id ";
            $sql_count .= " and `channel_id` = :channel_id ";
        }
        if ($monitor_id) {
            $param['monitor_id'] = $monitor_id;
            $sql .= " and `monitor_id` = :monitor_id ";
            $sql2 .= " and `monitor_id` = :monitor_id ";
            $sql_count .= " and `monitor_id` = :monitor_id ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and `date` >= :sdate ";
            $sql2 .= " and `date` >= :sdate ";
            $sql_count .= " and `date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and `date` <= :edate ";
            $sql2 .= " and `date` <= :edate ";
            $sql_count .= " and `date` <= :edate ";
        }
        if ($all == 0) {
            $sql .= " and (`click`>0 or `active`>0 or `reg`>0 or `new_pay`>0 or `new_money`>0 or `old_pay`>0 or `old_money`>0) ";
            $sql2 .= " and (`click`>0 or `active`>0 or `reg`>0 or `new_pay`>0 or `new_money`>0 or `old_pay`>0 or `old_money`>0) ";
            $sql_count .= " and (`click`>0 or `active`>0 or `reg`>0 or `new_pay`>0 or `new_money`>0 or `old_pay`>0 or `old_money`>0) ";
        }
        //权限部分
        $authorSql = SrvAuth::getAuthSql('', '`game_id`', '`channel_id`', '');
        $sql .= $authorSql;
        $sql2 .= $authorSql;
        $sql_count .= $authorSql;

        $sql .= " order by `$sort_by` $sort_type {$limit}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();

        return array(
            'lists' => $this->query($sql2, $param),
            'list' => $this->query($sql, $param),
            'total' => $count,
        );
    }

    public function regHour($parent_id = 0, $game_id = 0, $platform = 0, $date = '')
    {
        $param = [];
        $connection = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $connection .= " AND b.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $connection .= " AND a.`game_id` = :game_id";
        }
        if ($platform) {
            $param['platform'] = $platform;
            $connection .= " AND a.`platform` = :platform";
        }
        if ($date) {
            $param['date'] = $date;
            $connection .= " AND DATE_FORMAT(a.`date`, '%Y-%m-%d') = :date";
        }

        //权限
        $connection .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'd.`user_id`');

        $sql = "SELECT DATE_FORMAT(a.`date`, '%Y-%m-%d') `day`, DATE_FORMAT(a.`date`, '%H') `hour`, a.`channel_id`, c.`channel_name`, SUM(a.`reg`) `reg` 
                FROM `" . LibTable::$data_reg_hour . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                    LEFT JOIN `" . LibTable::$channel . "` c ON a.`channel_id` = c.`channel_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` d ON a.`monitor_id` = d.`monitor_id` 
                WHERE 1 {$connection} GROUP BY `day`, `hour`, a.`channel_id` ORDER BY `reg` DESC";
        return $this->query($sql, $param);
    }

    public function regHour2($parent_id = 0, $game_id = 0, $platform = 0, $sdate = '', $edate = '')
    {
        $param = [];
        $connection = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $connection .= " AND b.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $connection .= " AND a.`game_id` = :game_id";
        }
        if ($platform) {
            $param['platform'] = $platform;
            $connection .= " AND a.`platform` = :platform";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $connection .= " AND DATE_FORMAT(a.`date`, '%Y-%m-%d') >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $connection .= " AND DATE_FORMAT(a.`date`, '%Y-%m-%d') <= :edate";
        }

        //权限
        $connection .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', false);

        $sql = "SELECT DATE_FORMAT(a.`date`, '%Y-%m-%d') `day`, DATE_FORMAT(a.`date`, '%H') `hour`, SUM(a.`reg`) `reg` 
                FROM `" . LibTable::$data_reg_hour . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                WHERE 1 {$connection} GROUP BY `day`, `hour` ORDER BY `day` DESC, `reg` DESC";
        return $this->query($sql, $param);
    }

    public function serverCondition($page, $parent_id, $game_id, $server_id, $sdate, $edate, $all, $is_excel = 0)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        if ($is_excel > 0) {
            $limit = '';
        }
        if (!$server_id) {
            $limit = '';
        }
        $sql = "select * from " . LibTable::$data_new_server_overview . " as a 
        left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
        where 1 ";
        $sql_count = "select count(*) as c ,sum(a.`new_role`) as `all_new_role`,sum(a.`dau_role`) as `all_dau_role`,sum(a.`new_pay_role`) as `all_new_pay_role`,sum(a.`new_pay_money_role`) as `all_new_pay_money_role` ,sum(a.`pay_role`) as `all_pay_role`,sum(a.`pay_money_role`) as `all_pay_money_role`,avg(a.`dau_role`) as `avg_dau_role`,avg(a.`pay_role`) as `avg_pay_role` ,avg(a.`new_pay_money_role`) as `avg_new_pay_money_role`,avg(a.`new_pay_role`) as `avg_new_pay_role`,avg(a.`pay_money_role`) as `avg_pay_money_role`,avg(a.`new_role`) as `avg_new_role` 
              from " . LibTable::$data_new_server_overview . " as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` where 1 ";
        $param = array();

        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id`=:parent_id";
            $sql_count .= ' and b.`parent_id`=:parent_id';
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id` = :game_id";
            $sql_count .= " and a.`game_id` = :game_id ";
        }
        if ($server_id) {
            $param['server_id'] = $server_id;
            $sql .= " and a.`server_id` = :server_id ";
            $sql_count .= " and a.`server_id` = :server_id ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and a.`date` >= :sdate ";
            $sql_count .= " and a.`date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and a.`date` <= :edate ";
            $sql_count .= " and a.`date` <= :edate ";
        }
        if ($all == 0) {
            $sql .= " and (a.`new_role`>0 or a.`dau_role`>0 or a.`new_pay_role`>0 or a.`new_pay_money_role`>0 or a.`pay_role`>0 or a.`pay_money_role`>0  ) ";
            $sql_count .= " and (a.`new_role`>0 or a.`dau_role`>0 or a.`new_pay_role`>0 or a.`new_pay_money_role`>0 or a.`pay_role`>0 or a.`pay_money_role`>0  ) ";
        }

        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');
        $sql .= $authorSql;
        $sql_count .= $authorSql;

        $sql .= " order by a.`date` desc {$limit}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count
        );

    }


    public function payHabit($page, $parent_id, $game_id, $device_type, $level_money, $sdate, $edate, $all, $is_channel = 0, $is_server = 0, $is_excel = 0)
    {

        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        if ($is_excel > 0) {
            $limit = '';
        }
        $sql = "select *,sum(order_num) as order_num 
            from `" . LibTable::$data_pay_habits . "` as a 
            left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` ";
        $sql_count = "select count(*) as c  from `" . LibTable::$data_pay_habits . "` as a 
                left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` ";

        if ($is_channel > 0) {

            $group_by = "channel_id";
        } elseif ($is_server > 0) {

            $group_by = "server_id";
        } else {
            $group_by = "date";
        }
        $sql .= ' where 1 ';
        $sql_count .= ' where 1 ';
        $param = array();
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id`=:parent_id";
            $sql_count .= " and b.`parent_id`=:parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id` = :game_id ";
            $sql_count .= " and a.`game_id` = :game_id ";
        }
        if ($level_money) {
            $param['level_money'] = $level_money;
            $sql .= " and a.`level_money` = :level_money ";
            $sql_count .= " and a.`level_money` = :level_money ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and a.`date` >= :sdate ";
            $sql_count .= " and a.`date` >= :sdate ";
        }
        if ($edate) {
            $edate = date('Y-m-d', strtotime($edate) + 3600 * 24 - 1);
            $param['edate'] = $edate;
            $sql .= " and a.`date` <= :edate ";
            $sql_count .= " and a.`date` <= :edate ";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " and a.`device_type` = :device_type";
            $sql_count .= " and a.`device_type` = :device_type";
        }
        if ($all == 0) {
            $sql .= " and (a.`order_num`>0) ";
            $sql_count .= " and (a.`order_num`>0) ";
        }

        //权限
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', '');
        $sql .= $authorSql;
        $sql_count .= $authorSql;

        $sql .= " group by a.`$group_by`,a.`level_money` order by a.`$group_by` asc {$limit}";
        $sql_count .= " group by a.`$group_by`,a.`level_money` ";
        $count = $this->query($sql_count, $param);
        $count['c'] = count($count);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c']
        );
    }


    public function newViewData($game_id, $device_type, $sdate, $edate, $all)
    {
        //$conn = $this->connDb($this->conn);
        //$limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select sum(`reg`) as `reg`,sum(`active_login`) as `active_login`,sum(`payer_num`) as `payer_num`,sum(`new_payer_num`) as `new_payer_num`,sum(`total_deposit_money`) as `total_deposit_money`,sum(`new_deposit_money`) as `new_deposit_money`,sum(`new_equipment`) as `new_equipment`,`date`,`game_id`,`device_type`  from `" . LibTable::$data_others . "` where 1  ";
        $sql_count = "select count(*) as c  from `" . LibTable::$data_others . "` where 1 ";
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id` = :game_id ";
            $sql_count .= " and `game_id` = :game_id ";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " and `device_type` = :device_type ";
            $sql_count .= " and `device_type` = :device_type ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and `date` >= :sdate ";
            $sql_count .= " and `date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and `date` <= :edate ";
            $sql_count .= " and `date` <= :edate ";
        }

        $authorSql = SrvAuth::getAuthSql('', '`game_id`', '', '');
        $sql .= $authorSql;
        $sql_count .= $authorSql;

        $sql .= " group by `date` order by `date` asc ";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count
        );
    }

    public function dateAllOrder($date)
    {
        $allOrder = $this->getOne("select sum(order_num) as allOrder from `" . LibTable::$data_pay_habit . "` where 1 and `date` = '$date'");
        return $allOrder['allOrder'];
    }

    public function channelAllOrder($channel_id, $sdate, $edate)
    {
        $allOrder = $this->getOne("select sum(order_num) as allOrder from `" . LibTable::$data_pay_habit . "` where 1 and `date` >= '$sdate' and `date` <= '$edate' and `channel_id` = $channel_id ");
        return $allOrder['allOrder'];
    }

    public function serverAllOrder($server_id, $sdate, $edate)
    {
        $allOrder = $this->getOne("select sum(order_num) as allOrder from `" . LibTable::$data_pay_habit . "` where 1 and `date` >= '$sdate' and `date` <= '$edate' and `server_id` = $server_id ");
        return $allOrder['allOrder'];
    }

    public function getGameServer($game_id)
    {
        $sql = "select * from `" . LibTable::$data_game_server . "` where 1 ";

        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id` = " . $game_id;
            return $this->query($sql, $param);
        }

        $count = $this->getOne("select count(*) as c from `" . LibTable::$data_game_server . "`");
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count,
        );
    }

    ///批量获取服务器
    public function getGameServerBatch($game_id)
    {
        $sql = "select * from `" . LibTable::$data_game_server . "` where 1 ";

        if ($game_id && is_array($game_id)) {
            $game_id = array_unique(array_filter($game_id));
            $sql .= " AND `game_id` IN(" . join(',', $game_id) . ")";
            return $this->query($sql);
        }

        $count = $this->getOne("select count(*) as c from `" . LibTable::$data_game_server . "`");
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count,
        );
    }

    public function getMoneyLevel($game_id)
    {
        $sql = "select * from `" . LibTable::$data_level . "` where 1 ";

        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id` = :game_id";
            return $this->query($sql, $param);
        }

        $count = $this->getOne("select count(*) as c from `" . LibTable::$data_level . "`");
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count,
        );
    }

    public function overviewHour($page, $game_id, $package_name, $channel_id, $monitor_id, $sdate, $edate, $all)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select * from `" . LibTable::$data_overview_hour . "` where 1 ";
        $sql_count = "select count(*) as c from `" . LibTable::$data_overview_hour . "` where 1 ";
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id` = :game_id ";
            $sql_count .= " and `game_id` = :game_id ";
        }
        if ($package_name) {
            $param['package_name'] = $package_name;
            $sql .= " and `package_name` = :package_name ";
            $sql_count .= " and `package_name` = :package_name ";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and `channel_id` = :channel_id ";
            $sql_count .= " and `channel_id` = :channel_id ";
        }
        if ($monitor_id) {
            $param['monitor_id'] = $monitor_id;
            $sql .= " and `monitor_id` = :monitor_id ";
            $sql_count .= " and `monitor_id` = :monitor_id ";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and date(`date`) >= :sdate ";
            $sql_count .= " and date(`date`) >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and date(`date`) <= :edate ";
            $sql_count .= " and date(`date`) <= :edate ";
        }
        if ($all == 0) {
            $sql .= " and (`click`>0 or `active`>0 or `reg`>0 or `new_pay`>0 or `new_money`>0) ";
            $sql_count .= " and (`click`>0 or `active`>0 or `reg`>0 or `new_pay`>0 or `new_money`>0) ";
        }
        $sql .= " order by `date` desc {$limit}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function get_payer_num($date, $game_id, $package_name)
    {
        $sql = "select sum(`pay`) as `pay` from " . LibTable::$data_pay_monitor . " where `date` = '$date' and `game_id` = $game_id and `package_name` = '$package_name' ";
        $param['game_id'] = $game_id;
        $param['package_name'] = $package_name;
        $param['date'] = $date;
        $payer_num = $this->getOne($sql, $param);
        return $payer_num['pay'];
    }

    public function get_payer_nums($date, $game_id, $device_type)
    {
        $sql = "select count(*) as `pay` from " . LibTable::$data_pay . " where `date` = :date ";
        if ($device_type) {
            $sql .= " and `device_type` = :device_type";
        }
        if ($game_id) {
            $sql .= " and `game_id` = :game_id ";
        }
        $sql .= " group by `uid`";
        $param['game_id'] = $game_id;
        $param['device_type'] = $device_type;
        $param['date'] = $date;
        $payer_num = $this->query($sql, $param);
        $payer_num = count($payer_num);
        return $payer_num;
    }

    public function ltv($day = [], $parent_id = 0, $game_id = 0, $device_type = 0, $sdate = '', $edate = '', $all = 0)
    {
        $param = [];
        $condition1 = $condition2 = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= " AND b.`parent_id` = :parent_id";
            $condition2 .= " AND b.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND a.`game_id` = :game_id";
            $condition2 .= " AND aa.`game_id` = :game_id";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND a.`device_type` = :device_type";
            $condition2 .= " AND aa.`device_type` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $condition1 .= " AND a.`date` >= :sdate";
            $condition2 .= " AND aa.`date` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $condition1 .= " AND a.`date` <= :edate";
            $condition2 .= " AND aa.`date` <= :edate";
        }
        if ($all == 0) {
            $condition1 .= " AND a.`reg` > 0";
        }

        //权限
        $condition1 .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'c.`user_id`');
        $condition2 .= SrvAuth::getAuthSql('b.`parent_id`', 'aa.`game_id`', 'a.`channel_id`', 'c.`user_id`');


        $field1 = "a.`date`, SUM(a.`reg`) AS `reg`, ";
        $field2 = "b.`pay_count`,ROUND(b.`pay_count` / a.`reg` * 100, 2) AS `pay_rate`,";
        foreach ($day as $d) {
            $field1 .= "SUM(a.`money{$d}`) AS `money{$d}`,";
            $field2 .= "ROUND(a.`money{$d}` / 100 / a.`reg`, 2) AS `ltv{$d}`,";
        }

        $sql1 = "SELECT " . rtrim($field1, ',') . " 
                FROM `" . LibTable::$data_ltv . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` c ON a.`monitor_id` = c.`monitor_id` 
                WHERE 1 {$condition1} GROUP BY a.`date`";

        $sql2 = "SELECT `date`,count(*) `pay_count`
            FROM (
                SELECT FROM_UNIXTIME(a.`reg_time`,'%Y-%m-%d') as `date` FROM `" . LibTable::$data_pay . "` as aa
                    INNER JOIN `" . LibTable::$user_ext . "` as a ON aa.`uid`=a.`uid`
                    LEFT JOIN `" . LibTable::$sy_game . "` as b ON aa.`game_id` = b.`game_id`
                    LEFT JOIN `" . LibTable::$ad_project . "` as c ON a.`monitor_id` = c.`monitor_id`
                    WHERE 1 {$condition2} GROUP BY `date`,aa.`uid`
            ) tmp GROUP BY `date`";

        /*$sql2 = "SELECT aa.`date`, COUNT(DISTINCT aa.`uid`) `pay_count`
                FROM `" . LibTable::$data_pay . "` aa 
                    INNER JOIN `" . LibTable::$user_ext . "` a ON aa.`uid` = a.`uid` 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON aa.`game_id` = b.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` c ON a.`monitor_id` = c.`monitor_id` 
                WHERE 1 {$condition2} GROUP BY aa.`date`";*/

        $sql = "SELECT a.*, " . rtrim($field2, ',') . " FROM ({$sql1}) a LEFT JOIN ({$sql2}) b ON a.`date` = b.`date` ORDER BY a.`date` DESC";
        return $this->query($sql, $param);
    }

    public function retain($page, $game_id, $device_type, $sdate, $edate, $all)
    {
        //$conn = $this->connDb($this->conn);
        //$limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select sum(`reg`) as `reg`,sum(`retain1`) as `retain1`,sum(`retain2`) as `retain2`,sum(`retain3`) as `retain3`,sum(`retain4`) as `retain4`,sum(`retain5`) as `retain5`,sum(`retain6`) as `retain6`,sum(`retain7`) as `retain7`,sum(`retain15`) as `retain15`,sum(`retain21`) as `retain21`,sum(`retain30`) as `retain30`,sum(`retain60`) as `retain60`,sum(`retain90`) as `retain90`,`date`,`game_id` from `" . LibTable::$data_retain . "` where 1 ";
        $sql_count = "select count(*) as c,sum(`reg`) as `reg`,sum(`retain1`) as `retain1`,sum(`retain2`) as `retain2`,sum(`retain3`) as `retain3`,sum(`retain4`) as `retain4`,sum(`retain5`) as `retain5`,sum(`retain6`) as `retain6`,sum(`retain7`) as `retain7`,sum(`retain15`) as `retain15`,sum(`retain21`) as `retain21`,sum(`retain30`) as `retain30`,sum(`retain60`) as `retain60`,sum(`retain90`) as `retain90` from `" . LibTable::$data_retain . "` where 1 ";
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id` = :game_id ";
            $sql_count .= " and `game_id` = :game_id ";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " and `device_type` = :device_type ";
            $sql_count .= " and `device_type` = :device_type ";
        }

        if ($sdate) {
            $param['sdate'] = $sdate;
            $sql .= " and `date` >= :sdate ";
            $sql_count .= " and `date` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $sql .= " and `date` <= :edate ";
            $sql_count .= " and `date` <= :edate ";
        }
        if ($all == 0) {
            $sql .= " and `reg` > 0 ";
            $sql_count .= " and `reg` > 0 ";
        }
        $sql .= " group by date order by `date` desc ";//{$limit}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count,
        );
    }

    public function payHall($page = 0, $querParam = array())
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $condition = "WHERE a.`is_pay` = " . PAY_STATUS['已支付'];
        $condition2 = '';
        is_array($querParam['parent_id']) && $querParam['parent_id'] = array_unique(array_filter($querParam['parent_id']));
        if (!empty($querParam['parent_id'])) {
            $condition .= " AND b.`parent_id` IN(" . join(',', $querParam['parent_id']) . ")";
        }
        is_array($querParam['game_id']) && $querParam['game_id'] = array_unique(array_filter($querParam['game_id']));
        if (!empty($querParam['game_id'])) {
            $condition .= " AND a.`game_id` IN(" . join(',', $querParam['game_id']) . ")";
        }
        if ($querParam['server_id'] && $querParam['server_id'] > 0) {
            $param['server_id'] = $querParam['server_id'];
            $condition .= " AND a.`server_id` = :server_id";
        }
        if ($querParam['device_type']) {
            $param['device_type'] = $querParam['device_type'];
            $condition .= " AND a.`device_type` = :device_type";
        }
        if($querParam['psdate']){
            $param['pstime'] = strtotime($querParam['psdate']." 00:00:00");
            $condition .= " AND a.`pay_time` >=:pstime";
        }
        if($querParam['pedate']){
            $param['petime'] = strtotime($querParam['pedate']." 23:59:59");
            $condition .= " AND a.`pay_time` <=:petime";
        }

        if($querParam['s_charge'] && $querParam['s_charge'] > 0){
            $param['s_charge'] = $querParam['s_charge']*100;
            $condition2 .= " AND `money` >= :s_charge";
        }
        if($querParam['e_charge'] && $querParam['e_charge'] >0){
            $param['e_charge'] = $querParam['e_charge']*100;
            $condition2 .= " AND `money` <=:e_charge";
        }
        if($querParam['rsdate']){
            $param['rstime'] = strtotime($querParam['rsdate']." 00:00:00");
            $condition2 .= " AND b.`reg_time` >=:rstime";
        }
        if($querParam['redate']){
            $param['retime'] = strtotime($querParam['redate']." 23:59:59");
            $condition2 .= " AND b.`reg_time` <=:retime";
        }

        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');
        $sql = "SELECT COUNT(*) c FROM (
                  SELECT a.*,b.reg_time FROM(
                    SELECT a.`uid`,SUM(a.`total_fee`) money FROM `" . LibTable::$sy_order . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id 
                    {$condition} {$authorSql} GROUP BY a.uid
                  ) a LEFT JOIN `".LibTable::$user_ext."` b ON a.`uid`=b.`uid` WHERE 1 {$condition2}
             ) tmp";
        $row = $this->getOne($sql, $param);
        $count = $row['c'];
        if (!$count) {
            return array();
        }

        $sql = "SELECT a.uid, c.username, a.money, FROM_UNIXTIME(a.pay_time) last_pay_time, FROM_UNIXTIME(b.reg_time) reg_time, 
                FROM_UNIXTIME(b.last_login_time) last_login_time,c.`phone`
                FROM (
                    SELECT a.`uid`, SUM(a.total_fee) money, MAX(a.pay_time) pay_time 
                    FROM `" . LibTable::$sy_order . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id 
                    {$condition} {$authorSql} GROUP BY a.uid
                ) a 
                LEFT JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
				LEFT JOIN `" . LibTable::$sy_user . "` c ON a.uid = c.uid 
				WHERE 1 {$condition2} 
                ORDER BY a.money DESC, b.reg_time DESC {$limit}";
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count,
        );
    }

    public function avgCost($game_id, $date)
    {
        $sql1 = "select sum(`cost`) as `total_cost` from " . LibTable::$data_upload . " where  `date` = '$date' ";
        $sql2 = "select sum(`new_role`) as `total_new_role` from " . LibTable::$data_new_server_overview . " where `date` = '$date' ";
        if ($game_id) {
            $sql1 .= " and `game_id` = $game_id ";
            $sql2 .= " and `game_id` = $game_id ";
        }
        $total_cost = $this->getOne($sql1);

        $total_new_role = $this->getOne($sql2);
        if ($total_new_role['total_new_role']) {
            return number_format($total_cost['total_cost'] / 100 / $total_new_role['total_new_role'], 6);
        } else {
            return '0.00';
        }


    }

    public function dayCost($game_id, $date, $device_type)
    {
        $sql = "select sum(`cost`) as `total_cost` from " . LibTable::$data_upload . " where  `date` = '$date' ";
        if ($game_id) {
            $sql .= " and `game_id` = $game_id ";
        }
        if ($device_type) {
            $sql .= " and `device_type` = $device_type ";
        }

        $total_cost = $this->getOne($sql);
        return $total_cost['total_cost'] / 100;
    }

    public function totalCost($game_id, $sdate, $edate, $device_type)
    {
        $sql = "select sum(`cost`) as `total_cost` from " . LibTable::$data_upload . " where  `date` >= '$sdate' and `date` <= '$edate' ";
        if ($game_id) {
            $sql .= " and `game_id` = $game_id ";
        }
        if ($device_type) {
            $sql .= " and `device_type` = $device_type ";
        }

        $total_cost = $this->getOne($sql);
        return $total_cost['total_cost'] / 100;
    }

    public function uploadServer($date, $game_id, $server_id, $server_name)
    {
        $insert = $update = array(
            'date' => $date,
            'server_name' => $server_name,
        );
        $insert['server_id'] = $server_id;
        $insert['game_id'] = $game_id;

        $this->insertOrUpdate($insert, $update, LibTable::$data_game_server);

    }

    public function getOpenServer($server_id)
    {
        $sql = "select * from " . LibTable::$data_game_server . " where `server_id` = $server_id  ";
        $server = $this->getOne($sql);
        return $server['date'];
    }

    public function payHallRole($data, $page)
    {
        $limit = '';
        if ($page >= 1) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $having = ' HAVING money >= 0';
        $cond = ' WHERE `is_pay`=' . PAY_STATUS['已支付'] . '';
        $condition = ' WHERE a.`is_pay` = ' . PAY_STATUS['已支付'];
        if (!empty($data['parent_id'])) {
            $condition .= " AND c.`parent_id` IN(" . join(',', $data['parent_id']) . ")";
        }
        if (!empty($data['game_id'])) {
            $condition .= " AND a.`game_id` IN(" . join(',', $data['game_id']) . ")";
        }
        if ($data['server_id'] > 0) {
            $condition .= " AND a.`server_id` = :server_id";
            $param['server_id'] = $data['server_id'];
        }
        if ($data['pay_st']) {
            $cond .= " AND `pay_time`>=:pay_st";
            $param['pay_st'] = $data['pay_st'];
        }
        if ($data['pay_et']) {
            $cond .= " AND `pay_time`<=:pay_et";
            $param['pay_et'] = $data['pay_et'];
        }
        /*if ($data['pay_st'] && $data['pay_et']) {
            $condition .= " AND a.`pay_time` BETWEEN :pay_st AND :pay_et";
            $param['pay_st'] = $data['pay_st'];
            $param['pay_et'] = $data['pay_et'];
        }*/
        if ($data['role_name']) {
            $condition .= " AND a.`role_name` LIKE :role_name";
            $param['role_name'] = "%{$data['role_name']}%";
        }
        if ($data['device_type']) {
            $condition .= " AND a.`device_type`=:device_type";
            $param['device_type'] = (int)$data['device_type'];
        }
        if ($data['s_charge']) {
            $having .= " AND `money`>=:s_charge";
            $param['s_charge'] = $data['s_charge'] * MONEY_CONF;
        }
        if ($data['e_charge']) {
            $having .= " AND `money` <= :e_charge";
            $param['e_charge'] = $data['e_charge'] * MONEY_CONF;
        }
        if ($data['reg_date_start']) {
            $condition .= " AND ue.`reg_time`>=:rstime";
            $param['rstime'] = strtotime($data['reg_date_start'] . " 00:00:00");
        }
        if ($data['reg_date_end']) {
            $condition .= " AND ue.`reg_time`<=:retime";
            $param['retime'] = strtotime($data['reg_date_end'] . " 23:59:59");
        }
        $authorSql = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');
        $sql = "SELECT _FIELD_
                    FROM `" . LibTable::$sy_order . "` a INNER JOIN 
                    (
                        SELECT SUM(`total_fee`) AS `money`,MAX(`pay_time`) AS `pay_time`,`server_id`,`role_id`
                        FROM `" . LibTable::$sy_order . "` FORCE INDEX(`notify`)
                         {$cond} GROUP BY `server_id`,`role_id` {$having}
                    ) AS b ON a.`role_id`=b.`role_id` AND a.`server_id`=b.`server_id` AND a.`pay_time`=b.`pay_time`
                    LEFT JOIN `" . LibTable::$sy_game . "` c USING(`game_id`)
                    LEFT JOIN `" . LibTable::$sy_user . "` as d USING(`uid`)
                    LEFT JOIN `" . LibTable::$user_ext . "` ue USING(`uid`)
                     {$condition} {$authorSql} GROUP BY a.`server_id`,a.`role_id` ORDER BY b.`money` DESC,a.`role_id`";

        $fields = " 1 as c ";
        $row = $this->query(str_replace('_FIELD_', $fields, $sql), $param);
        $count = count($row);
        if (!$count) {
            return array();
        }
        $fields = "a.`server_id` AS `server_id`,a.`role_id` as `role_id`,a.`role_name` as `role_name`,
          MAX(a.`role_level`) AS `role_level`,MAX(`money`) AS `money`,a.`game_id`,a.`uid`,a.`device_type`,c.`parent_id`,
          d.`username`,ue.reg_time";
        $data = $this->query(str_replace('_FIELD_', $fields, $sql . $limit), $param);
        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function dataDay($sdate, $edate, $parent_id, $game_id, $channel_id, $user_id, $create_user)
    {
        $param = [];
        $condition1 = $condition2 = $condition3 = $condition4 = "";
        if ($sdate && $edate) {
            $condition2 .= " AND `date` BETWEEN :sdate AND :edate";
            $condition3 .= " AND a.`date` BETWEEN :sdate AND :edate AND FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') BETWEEN :sdate AND :edate";
            $condition4 .= " AND a.`create_time` BETWEEN :c_sdate AND :c_edate";
            $param['sdate'] = $sdate;
            $param['edate'] = $edate;

            $param['c_sdate'] = strtotime($sdate);
            $param['c_edate'] = strtotime($edate);
        }
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= ' AND sg.`parent_id`=:parent_id';
        }
        if ($game_id > 0) {
            $condition1 .= " AND f.game_id = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $condition1 .= " AND f.channel_id = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($user_id > 0) {
            $condition1 .= " AND f.user_id = :user_id";
            $param['user_id'] = $user_id;
        }
        if ($create_user) {
            $condition1 .= " AND f.create_user = :create_user";
            $param['create_user'] = $create_user;
        }

        //权限模块 parent_id,game_id,channel_id,user_id
        $authorSql1 = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'c.`user_id`');
        $authorSql2 = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'd.`channel_id`', 'd.`user_id`');
        $sql = "SELECT f.game_id, f.channel_id, f.create_user, f.user_id, g.user_name, a.package_name, a.cost, a.display, a.click, b.active, c.reg, c.retain, d.new_role, e.money, e.sum_pay, e.count_pay 
                FROM (
                    SELECT a.package_name, SUM(a.cost) cost, SUM(a.display) display, SUM(a.click) click 
                    FROM `" . LibTable::$data_upload . "` a
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id`=b.`game_id`
                    LEFT JOIN `" . LibTable::$ad_project . "` c ON a.`monitor_id`=c.`monitor_id`
                    WHERE 1 {$condition2} {$authorSql1}  GROUP BY a.package_name
                ) a 
                LEFT JOIN (
                    SELECT a.package_name, SUM(a.active) active 
                        FROM `" . LibTable::$data_overview_day . "` a
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id`=b.`game_id`
                        LEFT JOIN `" . LibTable::$ad_project . "` c ON a.`monitor_id`=c.`monitor_id`
                    WHERE a.active > 0 {$condition2} {$authorSql1} GROUP BY a.package_name
                ) b ON a.package_name = b.package_name
                LEFT JOIN (
                    SELECT a.package_name, SUM(a.reg) reg, SUM(a.retain2) retain 
                        FROM `" . LibTable::$data_retain . "` a
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id`=b.`game_id`
                        LEFT JOIN `" . LibTable::$ad_project . "`c ON a.`monitor_id`=c.`monitor_id`
                    WHERE a.reg > 0 {$condition2} {$authorSql1} GROUP BY a.package_name
                ) c ON a.package_name = c.package_name
                LEFT JOIN(
                    SELECT package_name,sum(c_role) new_role FROM (
                        SELECT count(*) c_role ,b.package_name FROM `" . LibTable::$user_role . "` a
                            INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
                            LEFT JOIN `" . LibTable::$ad_project . "` d ON b.`monitor_id`=d.`monitor_id`
                        WHERE 1 {$condition4} {$authorSql2} group by b.package_name,a.uid
                    ) tmp GROUP BY `package_name` 
                ) d ON a.package_name = d.package_name
                LEFT JOIN (
                    SELECT package_name, SUM(m) money, SUM(c) sum_pay, COUNT(*) count_pay 
                    FROM (
                        SELECT b.package_name, SUM(a.money) m, COUNT(*) c FROM `" . LibTable::$data_pay . "` a 
                        INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
                        LEFT JOIN `" . LibTable::$ad_project . "` d ON b.`monitor_id`=d.`monitor_id`
                        WHERE 1 {$condition3} {$authorSql2} GROUP BY b.package_name, a.uid
                    ) tmp GROUP BY package_name
                ) e ON a.package_name = e.package_name
                LEFT JOIN `" . LibTable::$ad_project . "` f ON a.package_name = f.package_name
                LEFT JOIN `" . LibTable::$channel_user . "` g ON f.user_id = g.user_id
                LEFT JOIN `" . LibTable::$sy_game . "` sg ON sg.`game_id` = f.`game_id`
                WHERE 1 {$condition1} ORDER BY a.cost DESC";
        return array(
            'list' => $this->query($sql, $param)
        );
    }

    public function getPayRetain($page, $parent_id, $game_id, $channel_id, $device_type, $package_name, $sdate, $edate, $has_cost)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }
        $param = [];
        $condition = '';
        if ($parent_id) {
            $condition .= " AND g.`parent_id`= :parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id > 0) {
            $condition .= " AND c.game_id = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $condition .= " AND c.channel_id = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($device_type) {
            $condition .= " AND d.platform = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($package_name) {
            $condition .= " AND a.package_name = :package_name";
            $param['package_name'] = $package_name;
        }
        if ($sdate && $edate) {
            $condition .= " AND a.`date` BETWEEN :sdate AND :edate";
            $param['sdate'] = $sdate;
            $param['edate'] = $edate;
        }
        if ($has_cost) {
            $condition .= " AND b.cost > 0";
        }

        $sql = "SELECT a.*, b.display, b.click, b.cost, c.game_id, c.channel_id 
                FROM `" . LibTable::$data_new_pay_retain . "` a 
                LEFT JOIN `" . LibTable::$data_upload . "` b ON a.package_name = b.package_name AND a.`date` = b.`date`
                LEFT JOIN `" . LibTable::$ad_project . "` c ON a.package_name = c.package_name 
                LEFT JOIN `" . LibTable::$sy_game_package . "` d ON a.package_name = d.package_name
                LEFT JOIN `" . LibTable::$sy_game . "` g ON d.game_id=g.game_id
                WHERE 1 {$condition} ORDER BY a.`date`, a.reg DESC {$limit}";
        $sql_count = "SELECT COUNT(*) `c` FROM `" . LibTable::$data_new_pay_retain . "` a 
                LEFT JOIN `" . LibTable::$data_upload . "` b ON a.package_name = b.package_name AND a.`date` = b.`date`
                LEFT JOIN `" . LibTable::$ad_project . "` c ON a.package_name = c.package_name 
                LEFT JOIN `" . LibTable::$sy_game_package . "` d ON a.package_name = d.package_name 
                LEFT JOIN `" . LibTable::$sy_game . "` g ON d.game_id=g.game_id
                WHERE 1 {$condition}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function channelHour($date = '', $parent_id = 0, $game_id = 0, $channel_id = 0, $package_name = '', $user_id = 0, $create_user = '')
    {
        $param = [];
        $condition = "";

        $param['date'] = $date;
        if ($package_name) {
            $condition .= " AND b.package_name = :package_name";
            $param['package_name'] = $package_name;
        }
        if ($parent_id) {
            $condition .= " AND g.`parent_id`=:parent_id";
            $param['parent_id'] = $condition;
        }
        if ($game_id > 0) {
            $condition .= " AND b.game_id = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $condition .= " AND b.channel_id = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($user_id > 0) {
            $condition .= " AND b.user_id = :user_id";
            $param['user_id'] = $user_id;
        }
        if ($create_user) {
            $condition .= " AND b.create_user = :create_user";
            $param['create_user'] = $create_user;
        }

        $sql = "SELECT b.`name` monitor_name, b.`game_id`, b.`channel_id`, b.`create_user`, b.`user_id`, c.`user_name`, a.`hour`, a.package_name, MAX(a.create_time) create_time, SUM(a.login) login, SUM(a.click) click, SUM(a.active) active, SUM(a.reg) reg, SUM(a.new_role) new_role, SUM(a.new_money) new_money, SUM(a.ney_pay) ney_pay 
                FROM (
                    (
                        SELECT a.`hour`, a.package_name, MAX(a.create_time) create_time, b.login, SUM(a.click) click, SUM(a.active) active, 0 reg, SUM(a.new_role) new_role, 0 new_money, 0 ney_pay 
                        FROM (
                            (SELECT LPAD(`hour`,2,'0') `hour`, package_name, active, 0 click, 0 new_role, create_time FROM `" . LibTable::$data_active_hour . "` WHERE `date` = :date) 
                            UNION ALL
                            (SELECT LPAD(`hour`,2,'0') `hour`, package_name, 0 active, click, 0 new_role, create_time FROM `" . LibTable::$data_click_hour . "` WHERE `date` = :date) 
                            UNION ALL 
                            (SELECT LPAD(`hour`,2,'0') `hour`, package_name, 0 active, 0 click, new_role, create_time FROM `" . LibTable::$data_new_role_hour . "` WHERE `date` = :date)
                        ) a 
                        LEFT JOIN (
                            SELECT LPAD(`hour`,2,'0') `hour`, package_name, login FROM `" . LibTable::$data_login_hour . "` WHERE `date` = :date
                        ) b ON a.`hour` = b.`hour` AND a.package_name = b.package_name 
                        GROUP BY a.`hour`, a.package_name
                    )
                    UNION ALL
                    (
                        SELECT FROM_UNIXTIME(reg_time, '%H') `hour`, package_name, FROM_UNIXTIME(MAX(reg_time)) create_time, 0 login, 0 click, 0 active, COUNT(*) reg, 0 new_role, 0 new_money, 0 ney_pay 
                        FROM `" . LibTable::$user_ext . "` WHERE FROM_UNIXTIME(reg_time, '%Y-%m-%d') = :date 
                        GROUP BY `hour`, package_name
                    )
                    UNION ALL
                    (
                        SELECT `hour`, package_name, FROM_UNIXTIME(MAX(last_apy_time)) create_time, 0 login, 0 click, 0 active, 0 reg, 0 new_role, SUM(m) new_money, COUNT(*) ney_pay 
                        FROM (
                            SELECT FROM_UNIXTIME(a.pay_time, '%H') `hour`, b.package_name, SUM(a.total_fee) m, MAX(a.pay_time) last_apy_time, a.uid 
                            FROM `" . LibTable::$sy_order . "` a 
                            INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                            WHERE a.is_pay = " . PAY_STATUS['已支付'] . " AND FROM_UNIXTIME(a.pay_time, '%Y-%m-%d') = FROM_UNIXTIME(b.reg_time, '%Y-%m-%d') AND FROM_UNIXTIME(a.pay_time, '%Y-%m-%d') = :date 
                            GROUP BY `hour`, b.package_name, a.uid
                        ) tmp GROUP BY `hour`, package_name
                    )
                ) a 
                LEFT JOIN `" . LibTable::$ad_project . "` b ON a.package_name = b.package_name 
                LEFT JOIN `" . LibTable::$channel_user . "` c ON b.user_id = c.user_id 
                LEFT JOIN `" . LibTable::$sy_game_package . "` d ON a.package_name = d.package_name 
                LEFT JOIN `" . LibTable::$sy_game . "` g ON b.`game_id` = g.`game_id`
                WHERE d.platform = " . PLATFORM['android'] . " {$condition} 
                GROUP BY a.`hour`, a.package_name 
                ORDER BY a.`hour` DESC, a.click DESC";
        return $this->query($sql, $param);
    }

    public function channelDay($date = '', $parent_id = 0, $game_id = 0, $channel_id = 0, $package_name = '', $user_id = 0, $create_user = '')
    {
        $param = [];
        $condition = "";

        $param['date'] = $date;
        if ($parent_id > 0) {
            $condition .= " AND e.parent_id = :parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($package_name) {
            $condition .= " AND b.package_name = :package_name";
            $param['package_name'] = $package_name;
        }
        if ($game_id > 0) {
            $condition .= " AND b.game_id = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $condition .= " AND b.channel_id = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($user_id > 0) {
            $condition .= " AND b.user_id = :user_id";
            $param['user_id'] = $user_id;
        }
        if ($create_user) {
            $condition .= " AND b.create_user = :create_user";
            $param['create_user'] = $create_user;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('e.`parent_id`', 'b.`game_id`', 'b.`channel_id`', 'b.`user_id`');

        $sql = "SELECT b.`name` monitor_name, e.`parent_id`, b.`game_id`, b.`channel_id`, b.`create_user`, b.`user_id`, c.`user_name`, a.package_name, MAX(a.create_time) create_time, SUM(a.login) login, SUM(a.click) click, SUM(a.active) active, SUM(a.reg) reg, SUM(a.new_role) new_role, SUM(a.new_money) new_money, SUM(a.ney_pay) ney_pay, SUM(a.old_money) old_money, SUM(a.old_pay) old_pay, SUM(a.interval_money) interval_money, SUM(a.interval_pay) interval_pay 
                FROM (
                    (
                        SELECT a.package_name, MAX(a.create_time) create_time, b.login, SUM(a.click) click, SUM(a.active) active, 0 reg, SUM(a.new_role) new_role, 0 new_money, 0 ney_pay, 0 old_money, 0 old_pay, 0 interval_money, 0 interval_pay 
                        FROM (
                            (SELECT package_name, active, 0 click, 0 new_role, create_time FROM `" . LibTable::$data_active . "` WHERE `date` = :date) 
                            UNION ALL
                            (SELECT package_name, 0 active, click, 0 new_role, create_time FROM `" . LibTable::$data_click . "` WHERE `date` = :date) 
                            UNION ALL 
                            (SELECT package_name, 0 active, 0 click, new_role, create_time FROM `" . LibTable::$data_new_role . "` WHERE `date` = :date)
                        ) a 
                        LEFT JOIN (
                            SELECT package_name, login FROM `" . LibTable::$data_login . "` WHERE `date` = :date
                        ) b ON a.package_name = b.package_name 
                        GROUP BY a.package_name
                    )
                    UNION ALL
                    (
                        SELECT package_name, FROM_UNIXTIME(MAX(reg_time)) create_time, 0 login, 0 click, 0 active, COUNT(*) reg, 0 new_role, 0 new_money, 0 ney_pay, 0 old_money, 0 old_pay, 0 interval_money, 0 interval_pay 
                        FROM `" . LibTable::$user_ext . "` WHERE FROM_UNIXTIME(reg_time, '%Y-%m-%d') = :date 
                        GROUP BY package_name
                    )
                    UNION ALL
                    (
                        SELECT package_name, FROM_UNIXTIME(MAX(last_apy_time)) create_time, 0 login, 0 click, 0 active, 0 reg, 0 new_role, SUM(m) new_money, COUNT(*) ney_pay, 0 old_money, 0 old_pay, 0 interval_money, 0 interval_pay 
                        FROM (
                            SELECT b.package_name, SUM(a.total_fee) m, MAX(a.pay_time) last_apy_time, a.uid 
                            FROM `" . LibTable::$sy_order . "` a 
                            INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                            WHERE a.is_pay = " . PAY_STATUS['已支付'] . " AND FROM_UNIXTIME(a.pay_time, '%Y-%m-%d') = FROM_UNIXTIME(b.reg_time, '%Y-%m-%d') AND FROM_UNIXTIME(a.pay_time, '%Y-%m-%d') = :date 
                            GROUP BY b.package_name, a.uid
                        ) tmp GROUP BY package_name
                    )
                    UNION ALL
                    (
                        SELECT package_name, 0 create_time, 0 login, 0 click, 0 active, 0 reg, 0 new_role, 0 new_money, 0 ney_pay, SUM(m) old_money, COUNT(*) old_pay, 0 interval_money, 0 interval_pay 
                        FROM (
                            SELECT FROM_UNIXTIME(MIN(a.pay_time), '%Y-%m-%d') first_pay_date, b.package_name, SUM(a.total_fee) m, a.uid  
                            FROM sy_order a 
                            INNER JOIN user_ext b ON a.uid = b.uid 
                            WHERE a.is_pay = " . PAY_STATUS['已支付'] . " AND FROM_UNIXTIME(b.reg_time, '%Y-%m-%d') < :date
                            GROUP BY a.uid HAVING first_pay_date = :date
                        ) tmp GROUP BY package_name
                    )
                    UNION ALL
                    (
                        SELECT package_name, FROM_UNIXTIME(MAX(last_time)) create_time, 0 login, 0 click, 0 active, 0 reg, 0 new_role, 0 new_money, 0 ney_pay, 0 old_money, 0 old_pay, SUM(m) interval_money, COUNT(*) interval_pay 
                        FROM (
                            SELECT b.package_name, MAX(a.pay_time) last_time, SUM(a.total_fee) m, a.uid 
                            FROM sy_order a 
                            INNER JOIN user_ext b ON a.uid = b.uid 
                            WHERE a.is_pay = " . PAY_STATUS['已支付'] . " AND FROM_UNIXTIME(a.pay_time, '%Y-%m-%d') = :date AND FROM_UNIXTIME(b.reg_time, '%Y-%m-%d') < :date
                            GROUP BY b.package_name, a.uid
                        ) tmp GROUP BY package_name
                    )
                ) a 
                LEFT JOIN `" . LibTable::$ad_project . "` b ON a.package_name = b.package_name 
                LEFT JOIN `" . LibTable::$channel_user . "` c ON b.user_id = c.user_id 
                LEFT JOIN `" . LibTable::$sy_game_package . "` d ON a.package_name = d.package_name 
                LEFT JOIN `" . LibTable::$sy_game . "` e ON b.`game_id` = e.`game_id` 
                WHERE d.platform = " . PLATFORM['android'] . " {$condition} 
                GROUP BY a.package_name ORDER BY a.package_name, a.click DESC";
        return $this->query($sql, $param);
    }

    /**
     * 获取所有已经充值的用户总额列表
     * @return array|bool|resource|string
     */
    public function getUserPayTotal()
    {
        $sql = "SELECT uid, SUM(total_fee) total_pay_money, COUNT(*) total_pay_num 
                FROM `" . LibTable::$sy_order . "` 
                WHERE is_pay = " . PAY_STATUS['已支付'] . " GROUP BY uid HAVING total_pay_money > 0";
        return $this->query($sql);
    }

    /**
     * 更新用户总充值
     * @param array $data
     * @return bool|resource|string
     */
    public function updateUserPayTotal($data = [])
    {
        //连接主数据库
        $this->conn = 'main';

        $insert = array(
            'uid' => $data['uid'],
            'total_pay_money' => $data['total_pay_money'],
            'total_pay_num' => $data['total_pay_num'],
        );
        $update = array(
            'total_pay_money' => $data['total_pay_money'],
            'total_pay_num' => $data['total_pay_num'],
        );
        return $this->insertOrUpdate($insert, $update, LibTable::$sy_user_config);
    }

    /**
     * LTV（投放）
     * @param array $day
     * @param string $rsdate
     * @param string $redate
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
    public function ltvNew1($day = [], $rsdate = '', $redate = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0, $channel_id = 0, $user_id = 0, $monitor_id = 0, $group_id = 0)
    {
        $param = [];
        $condition = '';
        if ($parent_id) {
            if (is_array($parent_id)) {
                $condition .= " AND c.`parent_id` IN(" . implode(',', (array)$parent_id) . ")";
            } else {
                $condition .= " AND c.`parent_id` = :parent_id";
                $param['parent_id'] = (int)$parent_id;
            }
        }
        if ($children_id) {
            if (is_array($children_id)) {
                $condition .= " AND a.`game_id` IN(" . implode(',', (array)$children_id) . ")";
            } else {
                $condition .= " AND a.`game_id` = :game_id";
                $param['game_id'] = (int)$children_id;
            }
        }
        if ($device_type > 0) {
            $condition .= " AND a.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($channel_id) {
            $condition .= " AND a.`channel_id` IN(" . implode(',', (array)$channel_id) . ")";
        }
        if ($user_id) {
            $condition .= " AND d.`user_id` IN(" . implode(',', (array)$user_id) . ")";
        }
        if ($monitor_id) {
            $condition .= " AND a.`monitor_id` IN(" . implode(',', (array)$monitor_id) . ")";
        }
        if ($group_id) {
            $condition .= " AND e.`group_id` IN(" . implode(',', (array)$group_id) . ")";
        }
        if ($rsdate && $redate) {
            $condition .= " AND FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";
            $param['rsdate'] = $rsdate;
            $param['redate'] = $redate;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'd.`user_id`');

        //LTV数据
        $group = ModAdData::getGroupField(array('a', 'a', 'a', 'd', 'a', 'e', 'FROM_UNIXTIME(a.`reg_time`, "%Y-%m-%d")', 'c','FROM_UNIXTIME(a.`reg_time`,"%Y-%m")','FROM_UNIXTIME(a.`reg_time`,"%Y-%u")'));
        $ltv_field = [];
        foreach ($day as $d) {
            $ltv_field[] = "SUM(IF(DATEDIFF(b.`date`, FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d')) < {$d}, b.`money`, 0)) ltv_money{$d}";
        }
        $ltv_field = implode(', ', $ltv_field);

        $sql = "SELECT {$group[$type]} `group_name`, COUNT(DISTINCT a.uid) `reg`, 0 `cost`, {$ltv_field} 
                FROM `" . LibTable::$user_ext . "` a 
                    LEFT JOIN `" . LibTable::$data_pay . "` b ON a.`uid` = b.`uid` 
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` d ON a.`monitor_id` = d.`monitor_id` 
                    LEFT JOIN `" . LibTable::$channel_user . "` e ON d.`user_id` = e.`user_id` 
                WHERE 1 {$condition} GROUP BY `group_name` ORDER BY `group_name` DESC, `reg` DESC";
        return $this->query($sql, $param);
    }

    /**
     * LTV（运营）
     * @param array $day
     * @param string $rsdate
     * @param string $redate
     * @param int $type
     * @param int $parent_id
     * @param int $children_id
     * @param int $device_type
     * @return array|bool|resource|string
     */
    public function ltvNew2($day = [], $rsdate = '', $redate = '', $type = 0, $parent_id = 0, $children_id = 0, $device_type = 0)
    {
        $param = $sql = [];
        $condition1 = $condition2 = $condition = '';
        if ($parent_id) {
            if (is_array($parent_id)) {
                $condition .= " AND c.`parent_id` IN(" . implode(',', (array)$parent_id) . ")";
            } else {
                $condition .= " AND c.`parent_id` = :parent_id";
                $param['parent_id'] = (int)$parent_id;
            }
        }
        if ($children_id) {
            if (is_array($children_id)) {
                $condition .= " AND a.`game_id` IN(" . implode(',', (array)$children_id) . ")";
            } else {
                $condition .= " AND a.`game_id` = :game_id";
                $param['game_id'] = (int)$children_id;
            }
        }
        if ($device_type > 0) {
            $condition .= " AND a.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');

        if ($rsdate && $redate) {
            $condition1 .= $condition;
            $condition1 .= " AND FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d') BETWEEN :rsdate AND :redate";

            $condition2 .= $condition;
            $condition2 .= " AND a.`date` BETWEEN :rsdate AND :redate";

            $param['rsdate'] = $rsdate;
            $param['redate'] = $redate;
        }

        //LTV数据
        $ltv_field = $ltv_total_field = $ltv_count_field = [];
        foreach ($day as $d) {
            $ltv_field[] = "0 `ltv_money{$d}`";
            $ltv_total_field[] = "SUM(`ltv_money{$d}`) `ltv_money{$d}`";
            $ltv_count_field[] = "SUM(IF(DATEDIFF(b.`date`, FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d')) < {$d}, b.`money`, 0)) ltv_money{$d}";
        }
        $ltv_field = implode(', ', $ltv_field);
        $ltv_total_field = implode(', ', $ltv_total_field);
        $ltv_count_field = implode(', ', $ltv_count_field);

        $group = ModAdData::getGroupField(array('a', 'a', 'a', 'd', 'a', 'e', 'FROM_UNIXTIME(a.`reg_time`, "%Y-%m-%d")', 'c','FROM_UNIXTIME(a.`reg_time`,"%Y-%m")','FROM_UNIXTIME(a.`reg_time`,"%Y-%u")'));
        $sql[] = "SELECT {$group[$type]} `group_name`, COUNT(DISTINCT a.uid) `reg`, 0 `consume`, {$ltv_count_field} 
                FROM `" . LibTable::$user_ext . "` a 
                    LEFT JOIN `" . LibTable::$data_pay . "` b ON a.`uid` = b.`uid` 
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                WHERE 1 {$condition1} GROUP BY `group_name`";

        $group = ModAdData::getGroupField(array('a', 'a', 'a', 'd', 'a', 'd', 'a.`date`', 'c','DATE_FORMAT(a.`date`,"%Y-%m")','DATE_FORMAT(a.`date`,"%Y-%u")'));
        $sql[] = "SELECT {$group[$type]} `group_name`, 0 `reg`, SUM(a.`cost`) `consume`, {$ltv_field} 
                  FROM `" . LibTable::$data_upload . "` a 
                      LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                  WHERE 1 {$condition2} GROUP BY `group_name`";

        $union = '(' . implode(') UNION ALL (', $sql) . ')';

        $_sql = "SELECT `group_name`, SUM(`reg`) `reg`, SUM(`consume`) `cost`, {$ltv_total_field} 
                 FROM ({$union}) tmp GROUP BY `group_name` ORDER BY `group_name` DESC, `reg` DESC";
        return $this->query($_sql, $param);
    }

    public function roi($parent_id, $game_id, $device_type, $sdate, $edate, $day, $type = 7)
    {
        $param = [];
        $condition1 = $condition2 = '';
        if ($parent_id) {
            $condition1 .= " AND c.`parent_id` = :parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id) {
            $condition1 .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($device_type > 0) {
            $condition1 .= " AND a.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($sdate && $edate) {
            $condition2 .= $condition1;
            $condition1 .= " AND FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d') BETWEEN :sdate AND :edate";
            $condition2 .= " AND a.`date` BETWEEN :sdate AND :edate";
            $param['sdate'] = $sdate;
            $param['edate'] = $edate;
        }

        //权限
        $condition = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');
        $condition1 .= $condition;
        $condition2 .= $condition;

        $roi_field = $roi_total_field = [];
        foreach ($day as $d) {
            $roi_field[] = "a.`roi_money{$d}`";
            $roi_total_field[] = "SUM(IF(DATEDIFF(b.`date`, FROM_UNIXTIME(a.`reg_time`, '%Y-%m-%d')) < {$d}, b.`money`, 0)) roi_money{$d}";
        }
        $roi_field = implode(', ', $roi_field);
        $roi_total_field = implode(', ', $roi_total_field);
        $groupType1 = ModAdData::getGroupField(array('a', 'a', '', '', '', '', 'from_unixtime(a.`reg_time`,"%Y-%m-%d")', 'c', 'from_unixtime(a.`reg_time`,"%Y-%m")','from_unixtime(a.`reg_time`,"%Y-%u")'));
        $groupType2 = ModAdData::getGroupField(array('a', 'a', '', '', '', '', 'a.`date`', 'c', 'DATE_FORMAT(a.`date`,"%Y-%m")','DATE_FORMAT(a.`date`,"%Y-%u")'));

        $sql = "SELECT a.`group_name`, a.`reg`,a.`reg_date`, b.`cost`,a.`money`, {$roi_field} FROM
                (
                    SELECT {$groupType1[$type]} `group_name`,MAX(from_unixtime(a.`reg_time`,'%Y-%m-%d')) `reg_date`,
                     COUNT(DISTINCT a.uid) `reg`, 
                    SUM(b.`money`) as money, {$roi_total_field} 
                    FROM `" . LibTable::$user_ext . "` a 
                        LEFT JOIN `" . LibTable::$data_pay . "` b ON a.`uid` = b.`uid` 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                    WHERE 1 {$condition1} GROUP BY `group_name`
                ) a LEFT JOIN (
                    SELECT {$groupType2[$type]} group_name , SUM(a.`cost`) `cost` 
                    FROM `" . LibTable::$data_upload . "` a 
                      LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                    WHERE 1 {$condition2} GROUP BY group_name
                ) b ON a.`group_name` = b.`group_name` 
                ORDER BY a.`group_name` DESC, a.`reg` DESC";
        return $this->query($sql, $param);
    }

    public function payHour($parent_id = 0, $game_id = 0, $device_type = 0, $sdate = '', $edate = '')
    {
        $param = [];
        $connection = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $connection .= " AND b.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $connection .= " AND a.`game_id` = :game_id";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $connection .= " AND a.`device_type` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $connection .= " AND DATE_FORMAT(a.`date`, '%Y-%m-%d') >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $connection .= " AND DATE_FORMAT(a.`date`, '%Y-%m-%d') <= :edate";
        }

        //权限
        $connection .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', false, false);

        $sql = "SELECT DATE_FORMAT(a.`date`, '%Y-%m-%d') `day`, DATE_FORMAT(a.`date`, '%H') `hour`, SUM(a.`money`) `money` 
                FROM `" . LibTable::$data_pay_hour . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                WHERE 1 {$connection} GROUP BY `day`, `hour` ORDER BY `day` DESC, `money` DESC";
        return $this->query($sql, $param);
    }

    public function onlineHour($parent_id = 0, $game_id = 0, $device_type = 0, $interval = 1, $sdate = '', $edate = '')
    {
        $param = [];
        $connection = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $connection .= " AND b.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $connection .= " AND a.`game_id` = :game_id";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $connection .= " AND a.`device_type` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $connection .= " AND a.`date` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $connection .= " AND a.`date` <= :edate";
        }

        //权限
        $connection .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', false, false);

        $sql = "SELECT DATE_FORMAT(CONCAT(a.`date`, ' ', HOUR(a.`minute`), ':', floor(MINUTE(a.`minute`) / {$interval}) * {$interval}), '%Y-%m-%d %H:%i') AS dataStartTime, a.`game_id`, a.`device_type`, MAX(a.`online`) `online` 
                FROM `" . LibTable::$data_online . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                WHERE 1 {$connection} GROUP BY dataStartTime, a.`game_id`, a.`device_type`";
        return $this->query($sql, $param);
    }

    /**
     * 获取当前媒介数据
     * @param $parent_id
     * @param $game_id
     * @param $device_type
     * @return array|bool|resource|string
     */
    public function getDiscountToday($parent_id, $game_id = 0, $device_type = 0)
    {
        $today = date('Y-m-d');
        $param = array(
            'today' => $today
        );
        $condition1 = $condition2 = $condition3 = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= " AND c.`parent_id` = :parent_id";
            $condition2 .= " AND c.`parent_id` = :parent_id";
            $condition3 .= " AND c.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND b.`game_id` = :game_id";
            $condition2 .= " AND a.`game_id` = :game_id";
            $condition3 .= " AND a.`game_id` = :game_id";
        }
        if ($device_type > 0) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND d.`platform` = :device_type";
            $condition2 .= " AND a.`device_type` = :device_type";
            $condition3 .= " AND a.`device_type` = :device_type";
        }

        //权限
        $condition1 .= SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', 'b.`channel_id`', 'b.`user_id`');
        $condition2 .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'b.`user_id`');
        $condition3 .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'u.`channel_id`', 'b.`user_id`');

        $sql = "SELECT a.`date`, a.monitor_id, a.active_device, a.reg_device, a.money, a.pay_sum, b.`name` AS monitor_name 
                FROM (
                    SELECT `date`, monitor_id, SUM(active_device) active_device, SUM(reg_device) reg_device, SUM(money) money, SUM(pay_sum) pay_sum 
                    FROM (
                        (
                        SELECT a.`date`, a.`monitor_id`, active_device, 0 reg_device, 0 money, 0 pay_sum 
                        FROM `" . LibTable::$data_log_day . "` a 
                            LEFT JOIN `" . LibTable::$ad_project . "` b ON a.`monitor_id` = b.`monitor_id` 
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id` = c.`game_id` 
                            LEFT JOIN `" . LibTable::$sy_game_package . "` d ON b.`package_name` = d.`package_name` 
                        WHERE a.`monitor_id` > 0 AND a.`date` = :today {$condition1}
                        ) 
                        UNION ALL 
                        (
                        SELECT FROM_UNIXTIME(a.reg_time,'%Y-%m-%d') `date`, a.`monitor_id`, 0 active_device, COUNT(DISTINCT a.`device_id`) reg_device, 0 money, 0 pay_sum 
                        FROM `" . LibTable::$user_ext . "` a 
                            LEFT JOIN `" . LibTable::$ad_project . "` b ON a.`monitor_id` = b.`monitor_id` 
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                        WHERE a.`monitor_id` > 0 
                            AND a.`game_id` = b.`game_id` 
                            AND a.active_time > 0 
                            AND FROM_UNIXTIME(a.reg_time,'%Y-%m-%d') = FROM_UNIXTIME(a.active_time,'%Y-%m-%d') 
                            AND FROM_UNIXTIME(a.reg_time,'%Y-%m-%d') = :today {$condition2} 
                        GROUP BY `date`, a.`monitor_id`
                        ) 
                        UNION ALL 
                        (
                        SELECT a.`date`, u.monitor_id, 0 active_device, 0 reg_device, SUM(a.money) money, COUNT(*) pay_sum 
                        FROM `" . LibTable::$data_pay . "` a 
                            INNER JOIN `" . LibTable::$user_ext . "` u ON a.uid = u.uid 
                            LEFT JOIN `" . LibTable::$ad_project . "` b ON u.`monitor_id` = b.`monitor_id` 
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = b.`game_id` 
                        WHERE b.`monitor_id` > 0 AND a.`game_id` = b.`game_id` AND a.`date` = :today {$condition3} 
                        GROUP BY a.`date`, u.monitor_id
                        )
                    ) tmp GROUP BY `date`, `monitor_id`
                ) a 
                    LEFT JOIN `" . LibTable::$ad_project . "` b ON a.`monitor_id` = b.`monitor_id` 
                ORDER BY a.`date`, a.`monitor_id`";
        return $this->query($sql, $param);
    }


    public function external($parent_id, $game_id, $device_type, $sdate, $edate)
    {
        $param = [];
        $condition = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition .= " AND c.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition .= " AND b.`game_id` = :game_id";
        }
        if ($device_type > 0) {
            $param['device_type'] = $device_type;
            $condition .= " AND d.`platform` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $condition .= " AND a.`date` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $condition .= " AND a.`date` <= :edate";
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', 'b.`channel_id`', 'b.`user_id`');

        $sql = "SELECT a.*, b.`name` AS monitor_name 
                FROM `" . LibTable::$data_discount . "` a 
                    LEFT JOIN `" . LibTable::$ad_project . "` b ON a.`monitor_id` = b.`monitor_id` 
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id` = c.`game_id` 
                    LEFT JOIN `" . LibTable::$sy_game_package . "` d ON b.`package_name` = d.`package_name` 
                WHERE a.`monitor_id` > 0 {$condition} ORDER BY a.`date`, a.`monitor_id`";
        return $this->query($sql, $param);
    }

    /**
     * ASO联运 获取当前媒介数据
     * @param $parent_id
     * @param $game_id
     * @param $device_type
     * @return array|bool|resource|string
     */
    public function getAsoDiscountToday($parent_id, $game_id = 0, $device_type = 0)
    {
        $today = date('Y-m-d');
        $param = array(
            'today' => $today
        );
        $condition1 = $condition2 = $condition3 = $cond = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= " AND c.`parent_id` = :parent_id";
            $condition2 .= " AND c.`parent_id` = :parent_id";
            $condition3 .= " AND c.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND a.`game_id` = :game_id";
            $condition2 .= " AND a.`game_id` = :game_id";
            $condition3 .= " AND a.`game_id` = :game_id";
        }

        //权限
        $condition1 .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');
        $condition2 .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');
        $condition3 .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');

        $sql = "SELECT a.`date`, a.game_id, a.active_device, a.reg_device, a.money, a.pay_sum, b.`name` AS game_name 
                FROM (
                    SELECT `date`, game_id, SUM(active_device) active_device, SUM(reg_device) reg_device, SUM(money) money, SUM(pay_sum) pay_sum 
                    FROM (
                        (
                        SELECT `active_date` `date`,a.`game_id`,COUNT(DISTINCT a.`device_id`) active_device ,0 reg_device, 0 money, 0 pay_sum 
                        FROM `" . LibTable::$active . "` a 
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id`                    
                        WHERE a.`game_id` > 0 AND a.`active_date` = :today {$condition1}
                            group by `date`,a.`game_id`                                                                                  
                        ) 
                        UNION ALL 
                        (
                        SELECT FROM_UNIXTIME(a.reg_time,'%Y-%m-%d') `date`, a.`game_id`, 0 active_device, COUNT(DISTINCT a.`device_id`) reg_device, 0 money, 0 pay_sum 
                        FROM `" . LibTable::$user_ext . "` a 
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                        WHERE a.`game_id` > 0 
                            AND a.active_time > 0 
                            AND FROM_UNIXTIME(a.reg_time,'%Y-%m-%d') = FROM_UNIXTIME(a.active_time,'%Y-%m-%d') 
                            AND FROM_UNIXTIME(a.reg_time,'%Y-%m-%d') = :today {$condition2} 
                        GROUP BY `date`, a.`game_id`
                        ) 
                        UNION ALL 
                        (
                        SELECT a.`date`, u.game_id, 0 active_device, 0 reg_device, SUM(a.money) money, COUNT(*) pay_sum 
                        FROM `" . LibTable::$data_pay . "` a 
                            INNER JOIN `" . LibTable::$user_ext . "` u ON a.uid = u.uid                             
                            LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = a.`game_id` 
                        WHERE a.`game_id` > 0 
                        AND a.`game_id`=u.`game_id`
                        AND a.`date` = :today {$condition3} 
                        GROUP BY a.`date`, u.game_id
                        )
                    ) tmp GROUP BY `date`, `game_id`
                ) a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                ORDER BY a.`date`, a.`game_id`";
        return $this->query($sql, $param);
    }

    /**
     * ASO联运 获取历史统计数据
     * @param int $parent_id
     * @param int $game_id
     * @param int $device_type
     * @param string $sdate
     * @param string $edate
     * @return  array
     */
    public function externalAso($parent_id, $game_id, $device_type, $sdate, $edate)
    {
        $param = [];
        $condition = $cond = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition .= " AND c.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition .= " AND a.`game_id` = :game_id";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $condition .= " AND a.`date` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $condition .= " AND a.`date` <= :edate";
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');

        $sql = "SELECT a.*, c.`name` AS game_name 
                FROM `" . LibTable::$data_aso_discount . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` c 
                    ON a.`game_id` = c.`game_id` 
                WHERE a.`game_id` > 0 {$condition} ORDER BY a.`date`, a.`game_id`";
        return $this->query($sql, $param);
    }

    /**
     * @param int $start
     * @param int $end
     * @return array
     */
    public function fetchServer($start, $end)
    {
        $condition = '';
        $param = array();
        $row = array();
        if (empty($start) && empty($end)) {

            $sql = "SELECT `server_id` from `" . LibTable::$data_game_server . "` WHERE 1 {$condition}  ORDER BY `server_id` DESC LIMIT 7";

            $row = $this->query($sql, $param);
            if (!empty($row)) {
                $row = array_column($row, null, 'server_id');
            }
        }
        return $row;
    }


    public function fetchServerView($parent_id, $game_id, $device_type, $type, $server_start, $server_end, $sdate, $edate, $page)
    {
        $condition = '';
        $param = array();
        $group = '';

        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        if (!empty($parent_id)) {
            $parent_id = array_unique(array_filter($parent_id));
            $condition .= " AND b.`parent_id` IN('" . join("','", $parent_id) . "')";
        }

        if (!empty($game_id)) {
            $game_id = array_unique(array_filter($game_id));
            $condition .= " AND a.`game_id` IN('" . join("','", $game_id) . "')";
        }

        if ($device_type) {
            $condition .= " AND a.`device_type`=:device_type";
            $param['device_type'] = $device_type;
        }

        if ($server_start) {
            $condition .= " AND a.`server_id` >= :server_start";
            $param['server_start'] = $server_start;
        }

        if ($server_end) {
            $condition .= " AND a.`server_id` <= :server_end";
            $param['server_end'] = $server_end;
        }

        if ($sdate) {
            $condition .= " AND a.`pay_time` >=:sdate";
            $param['sdate'] = strtotime($sdate);
        }
        if ($edate) {
            $condition .= " AND a.`pay_time` <= :edate";
            $param['edate'] = strtotime($edate);
        }

        if ($type === 1) {
            //按天统计
            $group = ',pay_date';
        }
        //权限
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');
        $sql = " select _FIELD_ FROM ( 
            select server_id,user_type,count(distinct uid) pay_num,sum(total_fee) pay_money,pay_date 
		    from (
				select a.`server_id`,IF(c.game_id = a.`game_id`,1,2) user_type,a.uid,total_fee, FROM_UNIXTIME(pay_time,'%Y-%m-%d') pay_date 
				from `" . LibTable::$sy_order . "` a 
				left join `" . LibTable::$sy_game . "` b on a.`game_id`=b.`game_id` 
				left join `" . LibTable::$user_ext . "` c on a.uid=c.uid
		where 1 {$condition} {$authorSql} ) tmp group by server_id,user_type,pay_date order by server_id asc,pay_date desc ) tm ";

        $field = " COUNT(*) AS c ";
        $count = $this->getOne(str_replace('_FIELD_', $field, $sql), $param);
        if (!$count || $count['c'] <= 0) {
            return array();
        }

        $field = " * ";
        $data = $this->query(str_replace('_FIELD_', $field, $sql) . $limit, $param);
        return array(
            'data' => $data,
            'total' => $count['c']
        );
    }

    public function getOverview2ByHour($parent_id, $game_id, $device_type, $sdate, $edate, $hourRetain, $hourLtv)
    {
        $param = array();

        $condition1 = $condition2 = $condition3 = $condition4 = '';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= " AND b.`parent_id` = :parent_id";
            $condition2 .= " AND c.`parent_id` = :parent_id";
            $condition3 .= " AND c.`parent_id` = :parent_id";
            $condition4 .= " AND c.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND a.`game_id` = :game_id";
            $condition2 .= " AND c.`game_id` = :game_id";
            $condition3 .= " AND a.`game_id` = :game_id";
            $condition4 .= " AND b.`game_id` = :game_id";
        }
        if ($device_type > 0) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND g.`platform` = :device_type";
            $condition2 .= " AND b.`platform` = :device_type";
            $condition3 .= " AND a.`device_type` = :device_type";
            $condition4 .= " AND b.`device_type` = :device_type";
        }
        if ($sdate && $edate) {
            $param['sdate'] = $sdate;
            $param['edate'] = $edate;

            $param['sdate_time'] = $sdate . " 00:00:00";
            $param['edate_time'] = $edate . " 23:59:59";

            $condition3 .= " AND DATE_FORMAT(a.`date`,'%Y-%m-%d') = FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') 
            AND a.`date` BETWEEN :sdate_time AND :edate_time 
            AND FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') BETWEEN :sdate AND :edate";

            $condition1 .= " AND a.`date` BETWEEN :sdate_time AND :edate_time";
            $condition2 .= " AND a.`date` BETWEEN :sdate AND :edate";
            $condition4 .= " AND b.`date` BETWEEN :sdate AND :edate";
        }

        $authorSql1 = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', '');
        $authorSql2 = SrvAuth::getAuthSql('c.`parent_id`', 'c.`game_id`', 'b.`channel_id`', '');
        $authorSql3 = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'b.`channel_id`', '');

        $sql = "SELECT a.*,h.login_user,c.new_role,d.new_pay_money,d.new_pay_user,e.active 
                FROM(
                    SELECT DATE_FORMAT(a.`date`,'%Y-%m-%d %k') AS `re_date`,
                    SUM(a.`reg`) reg_user,SUM(a.`new_pay`+a.`old_pay`) pay_user,
                    SUM(a.`new_money`+a.`old_money`) pay_money,SUM(a.`new_pay`) new_charge_user,SUM(a.`new_money`) new_charge_money
                  FROM `" . LibTable::$data_overview_hour . "` a FORCE INDEX(`date`)
                  LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id`=b.`game_id`
                  LEFT JOIN `" . LibTable::$sy_game_package . "` g ON a.`package_name`=g.`package_name`
                  WHERE 1 {$condition1} {$authorSql1} GROUP BY `re_date`
                ) a LEFT JOIN(
                    SELECT CONCAT_WS(' ',a.`date`,a.`hour`) `re_date`,SUM(a.`login`) `login_user`
                        FROM `" . LibTable::$data_login_hour . "` a FORCE INDEX(`date`)
                        LEFT JOIN `" . LibTable::$sy_game_package . "` b ON a.`package_name`=b.`package_name`
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id`=b.`game_id`
                        WHERE 1 {$condition2} {$authorSql2} GROUP BY `re_date`
                ) h ON a.`re_date`=h.`re_date`
                LEFT JOIN(
                    SELECT CONCAT_WS(' ',a.`date`,a.`hour`) `re_date`,SUM(a.`new_role`) new_role
                    FROM `" . LibTable::$data_new_role_hour . "` a FORCE INDEX(`date`)
                    LEFT JOIN `" . LibTable::$sy_game_package . "` b FORCE INDEX(`package_name`) ON a.`package_name`=b.`package_name`
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id`=b.`game_id`
                    WHERE 1 {$condition2} {$authorSql2} GROUP BY `re_date`   
                ) c ON a.`re_date`=c.`re_date`
                LEFT JOIN (
                    SELECT `reg_date`,SUM(`m`) new_pay_money,COUNT(*) new_pay_user
                      FROM(
                          SELECT DATE_FORMAT(a.`date`,'%Y-%m-%d %k') reg_date,SUM(a.`money`) m
                          FROM `" . LibTable::$data_pay_hour . "` a 
                          FORCE INDEX(`uid`) 
                          FORCE INDEX(`date`)
                          INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                          LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id`=a.`game_id`
                          WHERE 1 {$condition3} {$authorSql3} GROUP BY `reg_date`,a.`uid`
                      ) tmp GROUP BY `reg_date`
                ) d ON a.`re_date`=d.`reg_date`
                LEFT JOIN(
                    SELECT DATE_FORMAT(a.`date`,'%Y-%m-%d %k') re_date,SUM(a.`active`) active
                    FROM `" . LibTable::$data_overview_hour . "` a FORCE INDEX(`date`)
                    LEFT JOIN `" . LibTable::$sy_game_package . "` b ON a.`package_name`=b.`package_name`
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id`=a.`game_id`
                    WHERE a.active > 0 AND 1 {$condition2} {$authorSql2}
                    GROUP BY `re_date`  
                ) e ON a.`re_date`=e.`re_date` ORDER BY UNIX_TIMESTAMP(a.`re_date`) DESC";

        //获取日消耗
        $sql_const = " SELECT b.`date`, SUM(cost) cost, SUM(display) display,SUM(click) click 
                    FROM `" . LibTable::$data_upload . "` b 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id` = b.`game_id` 
                    WHERE 1 {$condition4} {$authorSql2}
					GROUP BY b.`date`";

        return array(
            'list' => $this->query($sql, $param),
            'cost' => $this->query($sql_const, $param)
        );
    }


    public static function getGroupField($prefix = [])
    {
        $group = array(
            1 => 'game_id',//按子游戏
            2 => 'device_type',//按手机系统
            8 => 'parent_id',//按母游戏
            7 => 'date',//按时间
            9 => 'month',//按月份
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

    //新增玩家数据
    public function getNewUserData($parent_id = 0, $game_id = 0, $device_type = 0, $sdate = '', $edate = '', $type = 7, $page = 0, $pageNum = 0)
    {
        $param = array();
        $condition = $condition1 = $cond = $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $pageNum);
        }
        if ($parent_id) {
            $condition .= ' and c.`parent_id`=:parent_id';
            $condition1 .= " and c.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id) {
            $condition .= " and b.`game_id`=:game_id";
            $condition1 .= " and a.`game_id`=:game_id";
            $param['game_id'] = $game_id;
        }
        if ($device_type) {
            $condition .= " and b.`device_type`=:device_type";
            $condition1 .= " and b.`device_type`=:device_type";
            $param['device_type'] = $device_type;
        }
        $param['rsdate'] = strtotime($sdate . " 00:00:00");//注册开始时间
        $param['redate'] = strtotime($edate . " 23:59:59");//注册结束时间
        if ($type == 7) {
            //$param['redate'] = strtotime($sdate . " 23:59:59");//注册结束时间
            $dataSdate = strtotime($sdate);
            $dataEdate = time();//直到当前时间
            $condition .= " and a.`date` between :dsdate and :dedate";
            $condition1 .= " and a.`first_login_time` between :dstime and :detime";
            $param['dstime'] = $dataSdate;
            $param['detime'] = $dataEdate;
            $param['dsdate'] = $sdate;
            $param['dedate'] = date('Y-m-d', time());
        } elseif ($type == 9) {
            $dataSdate = date('Y-m-d', strtotime($sdate));
            $dataEdate = date('Y-m-d', time());//直到当前月
            $condition .= " and DATE_FORMAT(a.`date`,'%Y-%m-%d') between :dsdate and :dedate";
            $condition1 .= " and FROM_UNIXTIME(a.`first_login_time`,'%Y-%m-%d') between :dsdate and :dedate";
            $param['dsdate'] = $dataSdate;
            $param['dedate'] = $dataEdate;
        }
        $cond .= " and b.`reg_time` between :rsdate and :redate";

        $authorSql = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'b.`channel_id`', '');
        $authorSql1 = SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', 'b.`channel_id`', '');
        $groupType = ModAdData::getGroupField(array('a', 'a', '', '', '', '', 'a.`date`', 'c', 'DATE_FORMAT(a.`date`,"%Y-%m")','DATE_FORMAT(a.`date`,"%Y-%u")'));
        $groupType1 = ModAdData::getGroupField(array('b', 'b', '', '', '', '', 'a.`date`', 'c', 'DATE_FORMAT(a.`date`,"%Y-%m")','DATE_FORMAT(a.`date`,"%Y-%u")'));
        $sql = [];
        $sql[] = "select {$groupType1[$type]} group_name,count(DISTINCT a.uid) login_user,0 pay_user,
        0 pay_count,0 pay_money,0 total_pay_money
	from `" . LibTable::$data_login_log . "` a 
	inner join `" . LibTable::$user_ext . "` b on a.uid=b.uid 
	left join `" . LibTable::$sy_game . "` c on a.game_id=c.game_id
		where 1 and a.`game_id` >0 and a.uid !=0 {$cond} {$condition1} {$authorSql1}
	group by group_name";

        //充值情况
        $sql[] = "SELECT {$groupType[$type]} `group_name`, 0 `login_user`,COUNT(DISTINCT a.`uid`) pay_user,COUNT(*) `pay_count`
        ,SUM(a.`money`) AS `money`,0 `total_pay_moeny`
            FROM `" . LibTable::$data_pay . "` a 
              INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
              LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
            WHERE a.`game_id` >0 {$cond} {$condition} {$authorSql} GROUP BY `group_name` ";

        $unionSql = '(' . implode(') union all (', $sql) . ')';

        $sqlCount = "select count(*) as c from (select * from ({$unionSql}) tmp group by `group_name`) tmp ";
        $count = $this->getOne($sqlCount, $param);
        if (!$count['c']) {
            return array();
        }
        $sqlTt = "select sum(money) total_pay_money
        from `" . LibTable::$data_pay . "` a force index(`date`) 
        inner join `" . LibTable::$user_ext . "` b on a.`uid`=b.`uid`
        left join `" . LibTable::$sy_game . "` c on a.`game_id`=c.`game_id`
        where 1 and b.`game_id` >0 {$condition} {$cond} {$authorSql}";
        $totalPay = $this->getOne($sqlTt, $param);

        $_sql = "select `group_name`,sum(`login_user`) `login_user`,sum(`pay_user`) `pay_user`,sum(`pay_count`) `pay_count`,sum(`pay_money`) `pay_money`,
        sum(`total_pay_money`) total_pay_money
            from ({$unionSql}) tmp group by `group_name` order by group_name desc {$limit}";
        return array(
            'list' => $this->query($_sql, $param),
            'total_pay' => $totalPay['total_pay_money'],
            'count' => $count['c']
        );
    }

    public function getNewPayDevote($parent_id = 0, $game_id = 0, $device_type = 0, $sdate = '', $edate = '', $day = array(), $type = 7, $pay_type = 1, $page = 0, $pageNum = 0)
    {
        //获取当天或当时的注册
        $param = $sql = [];
        $condition1 = $condition2 = $condition = '';
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $pageNum);
        }
        if ($parent_id) {
            if (is_array($parent_id)) {
                $condition .= " AND c.`parent_id` IN(" . implode(',', (array)$parent_id) . ")";
            } else {
                $condition .= " AND c.`parent_id` = :parent_id";
                $param['parent_id'] = (int)$parent_id;
            }
        }
        if ($game_id) {
            if (is_array($game_id)) {
                $condition .= " AND a.`game_id` IN(" . implode(',', (array)$game_id) . ")";
            } else {
                $condition .= " AND a.`game_id` = :game_id";
                $param['game_id'] = (int)$game_id;
            }
        }
        if ($device_type > 0) {
            $condition .= " AND a.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', '', '');
        if ($sdate && $edate) {
            $condition1 .= $condition;
            $condition2 .= $condition;
            $condition1 .= " AND b.`reg_time` BETWEEN :rstime AND :retime";
            $condition2 .= " AND a.`reg_time` BETWEEN :rstime AND :retime";
            $param['rstime'] = strtotime($sdate . " 00:0:00");
            $param['retime'] = strtotime($edate . " 23:59:59");
        }

        //当天充值数据
        $ltv_count_field = [];
        $ltv_field = [];
        $ltv_field_sum = [];
        foreach ($day as $d) {
            $dayNum = $d - 1;
            $ltv_field[] = "0 `ltv_money{$d}`";
            $ltv_field_sum[] = "SUM(`ltv_money{$d}`) `ltv_money{$d}`";
            $ltv_count_field[] = "SUM(IF( tmp.`pay_day` = {$dayNum}, tmp.`m`, 0)) ltv_money{$d}";
        }
        $ltv_count_field = implode(', ', $ltv_count_field);
        $ltv_field = implode(', ', $ltv_field);
        $ltv_field_sum = implode(', ', $ltv_field_sum);

        $sql = [];
        //获取新增注册
        $group1 = ModAdData::getGroupField(array('a', '', '', '', '', '', 'FROM_UNIXTIME(b.`reg_time`, "%Y-%m-%d")', 'c', 'FROM_UNIXTIME(b.`reg_time`,"%Y-%m")','FROM_UNIXTIME(b.`reg_time`,"%Y-%u")'));
        $group2 = ModAdData::getGroupField(array('a', '', '', '', '', '', 'FROM_UNIXTIME(a.`reg_time`, "%Y-%m-%d")', 'c', 'FROM_UNIXTIME(a.`reg_time`,"%Y-%m")','FROM_UNIXTIME(a.`reg_time`,"%Y-%u")'));

        $sql[] = "SELECT {$group2[$type]} `group_name`,COUNT(DISTINCT a.uid) `reg`,{$ltv_field},0 `consume`
               FROM `" . LibTable::$user_ext . "` a 
               LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
                WHERE 1 {$condition2} GROUP BY `group_name`";

        //获取每日充值
        $sql[] = "SELECT `group_name`,0 `reg`,{$ltv_count_field},SUM(m) consume
                   FROM (
                      SELECT {$group1[$type]} `group_name`,SUM(a.`money`) m,a.uid,
                        DATEDIFF(a.`date`, FROM_UNIXTIME(b.`reg_time`, '%Y-%m-%d')) pay_day
                      FROM `" . LibTable::$data_pay . "` a 
                      INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                      LEFT JOIN `" . LibTable::$sy_game . "` c ON c.`game_id`=a.`game_id`
                      WHERE 1 {$condition1} GROUP BY `group_name`,`uid`,pay_day
                   ) tmp  GROUP BY `group_name` ";

        $unionSql = " ( " . implode(' ) UNION ALL ( ', $sql) . " ) ";

        $sqlCount = "SELECT COUNT(*) c FROM (SELECT `group_name` FROM ({$unionSql}) tmp GROUP BY `group_name` ) tmp ";

        $count = $this->getOne($sqlCount, $param);
        if (!$count['c']) {
            return array();
        }
        $_sql = "SELECT `group_name`,SUM(`reg`) `reg`,{$ltv_field_sum},SUM(`consume`) `consume`
            FROM ({$unionSql}) tmp GROUP BY group_name ORDER BY `group_name` DESC {$limit}";

        return array('list' => $this->query($_sql, $param), 'total' => $count['c']);
    }

    public function getNewPayPermeability($parent_id, $game_id, $device_type, $sdate, $edate, $day, $type, $page, $pageNum)
    {
        $condition1 = $condition2 = $limit = '';
        $param = array();
        /*if($page > 0){
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $pageNum);
        }*/
        if ($parent_id) {
            $condition1 .= " AND c.`parent_id`=:parent_id";
            $condition2 .= " AND c.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id) {
            $condition1 .= " AND b.`game_id`=:game_id";
            $condition2 .= " AND a.`game_id`=:game_id";
            $param['game_id'] = $game_id;
        }
        if ($device_type) {
            $condition1 .= " AND b.`device_type`=:device_type";
            $condition2 .= " AND a.`device_type`=:device_type";
            $param['device_type'] = $device_type;
        }

        if ($sdate && $edate) {
            $condition1 .= " AND b.`reg_time` BETWEEN :sdate AND :edate";
            $condition2 .= " AND a.`reg_time` BETWEEN :sdate AND :edate";
            $param['sdate'] = strtotime($sdate . " 00:00:00");
            $param['edate'] = strtotime($edate . " 23:59:59");
        }
        //LTV数据
        $field = $total_field = $count_field = [];
        foreach ($day as $d) {
            $dayNum = $d - 1;
            $field[] = "0 `day_pay{$d}`";
            $total_field[] = "SUM(`day_pay{$d}`) `day_pay{$d}`";
            $count_field[] = "COUNT(DISTINCT(IF(`pay_day`<={$dayNum},uid,NULL))) day_pay{$d}";
        }
        $field = implode(', ', $field);
        $total_field = implode(', ', $total_field);
        $count_field = implode(', ', $count_field);

        $sql = array();
        //获取每日累计充值人数(付费)
        $groupType1 = ModAdData::getGroupField(array('b', 'b', '', '', '', '', 'FROM_UNIXTIME(b.`reg_time`,"%Y-%m-%d")', 'c', 'FROM_UNIXTIME(b.`reg_time`,"%Y-%m")','FROM_UNIXTIME(b.`reg_time`,"%Y-%u")'));
        $sql[] = "SELECT `group_name`,0 reg,COUNT(DISTINCT `uid`) pay_user,{$count_field} 
             FROM
             (
                SELECT {$groupType1[$type]} `group_name`,a.uid uid,
                DATEDIFF(a.`date`,FROM_UNIXTIME(b.`reg_time`,'%Y-%m-%d')) `pay_day`
                FROM `" . LibTable::$data_pay . "` a
                    INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id`=c.`game_id`
                    WHERE a.`game_id` >0 {$condition1} 
             ) tmp GROUP BY `group_name`";

        //获取注册
        $groupType2 = ModAdData::getGroupField(array('a', 'a', '', '', '', '', 'FROM_UNIXTIME(a.`reg_time`,"%Y-%m-%d")', 'c', 'FROM_UNIXTIME(a.`reg_time`,"%Y-%m")','FROM_UNIXTIME(a.`reg_time`,"%Y-%u")'));
        $sql[] = "SELECT {$groupType2[$type]} group_name,COUNT(uid) reg,0 pay_user,{$field}
        FROM `" . LibTable::$user_ext . "` a LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
        WHERE a.`uid` > 0 {$condition2} GROUP BY `group_name`";


        $unionSql = "(" . implode(") UNION ALL (", $sql) . ")";

        $_sql = "SELECT `group_name`,SUM(reg) reg,SUM(`pay_user`) pay_user,{$total_field} 
                FROM ({$unionSql}) tmp GROUP BY group_name ORDER 
                BY group_name desc,reg desc";

        return array(
            'count' => 0,
            'list' => $this->query($_sql, $param),
        );
    }

    public function getDayChargeData($parent_id = 0, $game_id = 0, $day = array(), $sdate = '', $edate = '', $type = 7, $show_type = 0, $page = 0, $limitNum = DEFAULT_ADMIN_PAGE_NUM)
    {
        $condition1 = $condition2 = $condition3 = $condition4 = '';
        $param = array();
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $limitNum);
        }

        if ($parent_id) {
            $condition1 .= " AND c.`parent_id`=:parent_id";
            $condition2 .= " AND c.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }

        if ($game_id) {
            $condition1 .= " AND a.`game_id`=:game_id";
            $condition2 .= " AND a.`game_id`=:game_id";
            $param['game_id'] = $game_id;
        }
        if ($sdate) {
            $condition1 .= " AND a.`first_login_time`>=:stime";
            $condition2 .= " AND a.`date`>=:sdate";
            $param['stime'] = strtotime($sdate . " 00:00:00");
            $param['sdate'] = $sdate;
        }

        if ($edate) {
            $condition1 .= " AND a.`first_login_time` <=:etime";
            $condition2 .= " AND a.`date` <=:edate";
            $param['etime'] = strtotime($edate . " 23:59:59");
            $param['edate'] = $edate;
        }

        if ($show_type) {
            $condition3 .= " AND b.`device_type`=:show_type";
            $condition4 .= " AND a.`device_type`=:show_type";
            $param['show_type'] = $show_type;
        }

        $dayPayFeild = $dayPayFeildCount = $dayPayFeildSum = array();
        $sql = [];
        foreach ($day as $d) {
            $dayPayFeild[] = "0 `pay_user{$d}`,0 `pay_money{$d}`,0 `pay_count{$d}`";
            $dayPayFeildSum[] = " SUM(`pay_user{$d}`) `pay_user{$d}`,SUM(`pay_money{$d}`) `pay_money{$d}`,SUM(`pay_count{$d}`) `pay_count{$d}`";
            if (preg_match('/^\d+\_/', $d)) {
                $dayL = explode('_', $d);
                if (!empty($dayL[1])) {
                    $sday = $dayL[0] - 1;
                    $eday = $dayL[1] - 1;
                    $dayPayFeildCount[] = "COUNT(DISTINCT(IF(`reg_day` >= {$sday} AND `reg_day` <= {$eday},uid,NULL))) pay_user{$d} ,
                        SUM(IF(`reg_day` >= {$sday} AND `reg_day` <= {$eday},m,0)) pay_money{$d},
                        SUM(IF(`reg_day`>={$sday} AND `reg_day`<= {$eday},`pay_count`,NULL)) pay_count{$d} ";
                } else {
                    $sday = $dayL[0] - 1;
                    $dayPayFeildCount[] = "COUNT(DISTINCT(IF(`reg_day`>={$sday},uid,NULL))) pay_user{$d} ,
                     SUM(IF(`reg_day`>={$sday},m,0)) pay_money{$d}, 
                     SUM(IF(`reg_day` >= {$sday},`pay_count`,NULL)) pay_count{$d} ";
                }
            } else {
                $dayNum = $d - 1;
                $dayPayFeildCount[] = "COUNT(DISTINCT(IF(`reg_day` = {$dayNum},uid,NULL))) pay_user{$d},
                SUM(IF(reg_day = {$dayNum},m,0)) pay_money{$d} ,
                SUM(IF(`reg_day` = {$dayNum},`pay_count`,NULL)) pay_count{$d} ";
            }
        }
        $authorSql = SrvAuth::getAuthSql('c.parent_id', 'a.`game_id`', '', '');
        $dayPayFeild = implode(', ', $dayPayFeild);
        $dayPayFeildCount = implode(', ', $dayPayFeildCount);
        $dayPayFeildSum = implode(', ', $dayPayFeildSum);
        //获取dau

        $group1 = ModAdData::getGroupField(array('a.`game_id`', '', '', '', '', '', 'FROM_UNIXTIME(a.`first_login_time`,"%Y-%m-%d")', 'c', 'DATE_FORMAT(a.`date`,"%Y-%m")', 'DATE_FORMAT(a.`date`,"%Y-%u")'));
        $group2 = ModAdData::getGroupField(array('a.`game_id`', '', '', '', '', '', 'a.`date`', 'c', 'DATE_FORMAT(a.`date`,"%Y-%m")', 'DATE_FORMAT(a.`date`,"%Y-%u")'));

        $sql[] = "SELECT {$group1[$type]} `group_name`,COUNT(DISTINCT a.`uid`) login_user,0 `pay_money`,0 `pay_user`,
                0 `adr_pay_user`,0 `adr_pay_money`,0 `ios_pay_user`,0 `ios_pay_money`,{$dayPayFeild}
                   FROM `" . LibTable::$data_login_log . "` a 
                    INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
                WHERE a.`game_id`>0 {$condition1} {$authorSql} {$condition3} GROUP BY `group_name`";
        //计算总充值情况
        $sql[] = "SELECT {$group2[$type]} group_name,0 login_user,SUM(a.`money`) pay_money,COUNT(DISTINCT a.`uid`) pay_user,
            0 adr_pay_user,0 adr_pay_money,0 ios_pay_user,0 ios_pay_money,{$dayPayFeild}
                FROM `" . LibTable::$data_pay . "` a 
                    INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
                WHERE a.`game_id` > 0 {$condition2} {$authorSql} GROUP BY group_name";

        //计算安卓/IOS充值情况
        $sql[] = "SELECT `group_name`,0 login_user,0 pay_money,0 pay_user,
                COUNT(DISTINCT(IF(a.`device_type`=2,a.`uid`,NULL))) adr_pay_user,
                SUM(IF(a.`device_type`=2,a.`m`,0)) adr_pay_money,
                COUNT(DISTINCT(IF(a.`device_type`=1,a.`uid`,NULL))) ios_pay_user,
                SUM(IF(a.`device_type`=1,a.`m`,0)) ios_pay_money,{$dayPayFeild}
            FROM (
                SELECT {$group2[$type]} group_name,a.`uid`,SUM(a.`money`) m,a.`device_type`
                  FROM `" . LibTable::$data_pay . "` a 
                    INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
                WHERE a.`game_id`>0 {$condition2} {$authorSql}
                GROUP BY `group_name`,a.`uid`,a.`device_type`    
            ) a GROUP BY `group_name`";

        //计算每日充值付费情况
        $sql[] = "SELECT group_name,0 login_user,0 pay_money,0 pay_user,0 adr_pay_user,0 adr_pay_money,
             0 ios_pay_user,0 ios_pay_money,{$dayPayFeildCount}
              FROM (
                SELECT {$group2[$type]} group_name,a.`uid`,SUM(a.`money`) m,COUNT(*) `pay_count`,
                  DATEDIFF(a.`date`,FROM_UNIXTIME(b.`reg_time`,'%Y-%m-%d')) reg_day
                FROM `" . LibTable::$data_pay . "` a 
                INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid`=b.`uid`
                LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id`=c.`game_id`
                WHERE a.`game_id`>0 {$condition2} {$authorSql} {$condition4}
                GROUP BY group_name,uid,reg_day 
    ) tmp GROUP BY group_name";

        $unionSql = "(" . implode(") UNION ALL(", $sql) . ")";

        $countSql = "SELECT COUNT(*) c FROM (SELECT group_name FROM ({$unionSql}) tmp GROUP BY group_name ) tmp ";
        $count = $this->getOne($countSql, $param);
        if (!$count['c']) {
            return array();
        }
        $_sql = "SELECT group_name,SUM(login_user) login_user,SUM(pay_user) pay_user,SUM(`pay_money`) `pay_money`,SUM(adr_pay_user) adr_pay_user,
                SUM(adr_pay_money) adr_pay_money,SUM(ios_pay_user) ios_pay_user,SUM(ios_pay_money) ios_pay_money,
                {$dayPayFeildSum} 
                FROM ({$unionSql}) tmp GROUP BY group_name ORDER BY group_name DESC {$limit}";
        return array(
            'list' => $this->query($_sql, $param),
            'count' => $count['c']
        );
    }
}