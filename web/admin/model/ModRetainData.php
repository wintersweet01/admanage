<?php

class ModRetainData extends Model
{

    public function __construct()
    {
        $this->conn = 'default';
    }

    public function channelRetain($page, $parent_id, $game_id, $device_type, $channel_id, $package_name, $all, $sdate, $edate, $is_excel = 0)
    {
        if ($is_excel == 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $sql = "select  sum(a.`reg`) as `reg`,sum(a.`retain1`) as `retain1`,sum(a.`retain2`) as `retain2`,sum(a.`retain3`) as `retain3`,sum(a.`retain4`) as `retain4`,sum(a.`retain5`) as `retain5`,sum(a.`retain6`) as `retain6`,sum(a.`retain7`) as `retain7`,sum(a.`retain15`) as `retain15`,sum(a.`retain21`) as `retain21`,sum(a.`retain30`) as `retain30`,sum(a.`retain60`) as `retain60`,sum(a.`retain90`) as `retain90`,a.`game_id`,a.`package_name`,a.`channel_id`,a.`date`
                  from `" . LibTable::$data_retain . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
                    where 1 ";
        $sql_count = "select count(*) as c,sum(a.`reg`) as `reg`,sum(a.`retain1`) as `retain1`,sum(a.`retain2`) as `retain2`,sum(a.`retain3`) as `retain3`,sum(a.`retain4`) as `retain4`,sum(a.`retain5`) as `retain5`,sum(a.`retain6`) as `retain6`,sum(a.`retain7`) as `retain7`,sum(a.`retain15`) as `retain15`,sum(a.`retain21`) as `retain21`,sum(a.`retain30`) as `retain30`,sum(a.`retain60`) as `retain60`,sum(a.`retain90`) as `retain90` 
                  from `" . LibTable::$data_retain . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id` 
                    where 1 ";

        $param = array();
        if ($channel_id) {
            $channel_id = $channel_id;
            $channel_id = implode(',', $channel_id);
            $param['channel_id'] = $channel_id;
            $sql .= " and a.`channel_id` in ( " . $channel_id . " ) ";
            $sql_count .= " and a.`channel_id` in ( " . $channel_id . " ) ";
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
        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " and a.`device_type` = :device_type ";
            $sql_count .= " and a.`device_type` = :device_type ";
        }

        if ($package_name) {
            $param['package_name'] = $package_name;
            $sql .= " and a.`package_name` = :package_name ";
            $sql_count .= " and a.`package_name` = :package_name ";
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
            $sql .= " and (a.`reg`>0  or a.`retain2` or a.`retain3` or a.`retain4` or a.`retain5` or a.`retain6` or a.`retain7` or a.`retain15` or a.`retain21` or a.`retain30` or a.`retain60` or a.`retain90`) ";

            $sql_count .= " and (a.`reg`>0  or a.`retain2` or a.`retain3` or a.`retain4` or a.`retain5` or a.`retain6` or a.`retain7` or a.`retain15` or a.`retain21` or a.`retain30` or a.`retain60` or a.`retain90`) ";
        }

        //权限
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`','a.`game_id`','a.`channel_id`','');
        $sql .= $authorSql;
        $sql_count .= $authorSql;

        $sql .= " group by a.`date`,a.`game_id`,a.`channel_id`,a.`package_name` order by a.`date` desc {$limit}";
        $sql_data = $sql_count;
        $sql_count .= " group by a.`date`,a.`game_id`,a.`channel_id`,a.`package_name` ";
        $count = $this->getOne($sql_data, $param);
        $_count = $this->query($sql_count, $param);
        $count['c'] = count($_count);

        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count,
        );
    }

    public function retain($page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child = 0)
    {
        //$conn = $this->connDb($this->conn);
        //$limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select sum(a.`reg`) as `reg`,sum(a.`retain1`) as `retain1`,sum(a.`retain2`) as `retain2`,sum(a.`retain3`) as `retain3`,sum(a.`retain4`) as `retain4`,
                    sum(a.`retain5`) as `retain5`,sum(a.`retain6`) as `retain6`,sum(a.`retain7`) as `retain7`,sum(a.`retain15`) as `retain15`,
                    sum(a.`retain21`) as `retain21`,sum(a.`retain30`) as `retain30`,sum(a.`retain60`) as `retain60`,sum(a.`retain90`) as `retain90`,
                    a.`date`,__FIELD__ as `game_id`
                  from `" . LibTable::$data_retain . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`= b.`game_id` 
                    where 1 ";
        $sql_count = "select count(*) as c,sum(a.`reg`) as `reg`, sum(a.`retain1`) as `retain1`,sum(a.`retain2`) as `retain2`,sum(a.`retain3`) as `retain3`,
                            sum(a.`retain4`) as `retain4`,sum(a.`retain5`) as `retain5`,sum(a.`retain6`) as `retain6`,sum(a.`retain7`) as `retain7`,
                            sum(a.`retain15`) as `retain15`,sum(a.`retain21`) as `retain21`,sum(a.`retain30`) as `retain30`,sum(a.`retain60`) as `retain60`,sum(a.`retain90`) as `retain90` 
                  from `" . LibTable::$data_retain . "` as a left join `" . LibTable::$sy_game . "` as b on a.`game_id`= b.`game_id`
                    where 1 ";
        $param = array();
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $sql .= " and b.`parent_id` = :parent_id";
            $sql_count .= " and b.`parent_id` = :parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and a.`game_id` = :game_id ";
            $sql_count .= " and a.`game_id` = :game_id ";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " and a.`device_type` = :device_type ";
            $sql_count .= " and a.`device_type` = :device_type ";
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
            $sql .= " and a.`reg` > 0 ";
            $sql_count .= " and a.`reg` > 0 ";
        }
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`');
        $sql .= $authorSql;
        $sql_count .= $authorSql;
        $group = '';
        $order = '';
        if ($group_child == 1) {
            $group = ' group by a.`date`,a.`game_id`';
            $order = ' order by a.`date` desc,a.`game_id` asc';
            $sql = str_replace('__FIELD__', 'a.`game_id`', $sql);
        } else {
            $group = ' group by a.`date`,b.`parent_id`';
            $order = ' order by a.`date` desc,b.`parent_id` asc';
            $sql = str_replace('__FIELD__', 'b.`parent_id`', $sql);
        }
        //$sql .= " group by a.`date`,a.`game_id` order by a.`date` desc,a.`game_id` asc ";//{$limit}";
        $sql .= $group . $order;
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count,
        );
    }

    public function retainNew($day, $page, $parent_id, $game_id, $device_type, $sdate, $edate, $all, $group_child = 0)
    {
        $retainField = array();
        $condition = '';
        $param = array();
        foreach ($day as $d) {
            $field = "SUM(a.`retain" . $d . "`) `retain" . $d . "`";
            array_push($retainField, $field);
        }
        $retainField = implode(',', $retainField);

        if ($parent_id) {
            $condition .= " AND c.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id) {
            $condition .= " AND b.`game_id`=:game_id";
            $param['game_id'] = $game_id;
        }
        if ($device_type) {
            $condition .= " AND b.`device_type`=:device_type";
            $param['device_type'] = $device_type;
        }
        if ($sdate) {
            $condition .= " AND b.`reg_time`>=:sdate";
            $param['sdate'] = strtotime($sdate . " 00:00:00");
        }
        if ($edate) {
            $condition .= " AND b.`reg_time`<=:edate";
            $param['edate'] = strtotime($edate . " 23:59:59");
        }

        $sql = "select FROM_UNIXTIME(b.`reg_time`,'%Y-%m-%d') as re_date,COUNT(*) reg,__FIELD__ AS `game_id`,{$retainField} 
          FROM `" . LibTable::$user_ext . "` b 
            LEFT JOIN `" . LibTable::$sy_user_config . "` a ON a.`uid`=b.`uid`
            LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id`=c.`game_id` 
          WHERE 1 {$condition} __TERMS__";

        //权限
        $authorSql = SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', '', '');
        $sql .= $authorSql;

        if ($all == 0) {
            $sql .= " HAVING reg > 0 ";
        }

        $sql_count = "SELECT COUNT(*) c,COUNT(*) reg,{$retainField} 
          FROM `" . LibTable::$user_ext . "` b 
            LEFT JOIN `" . LibTable::$sy_user_config . "` a ON a.`uid`=b.`uid`
            LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id`=c.`game_id` WHERE 1 {$condition} ";
        $sql_count .= $authorSql;

        if ($group_child == 1) {
            //子游戏分组
            $terms = ' GROUP BY `re_date`,c.`game_id` ';
            $order = ' ORDER BY `re_date` desc,c.`game_id` asc';
            $sql = str_replace('__FIELD__', 'c.`game_id`', $sql);
        } else {
            //母游戏分组
            $terms = ' GROUP BY `re_date`,c.`parent_id` ';
            $order = ' ORDER BY `re_date` desc,c.`parent_id` asc';
            $sql = str_replace('__FIELD__', 'c.`parent_id`', $sql);
        }
        $count = $this->getOne($sql_count, $param);
        $sql = str_replace('__TERMS__', $terms, $sql);//{$limit}
        $sql .= $order;
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count
        );
    }

    public function payRetain($parent_id, $game_id, $device_type, $sdate, $edate, $day)
    {
        $param = [];
        $condition1 = $condition2 = "";
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition1 .= " AND c.`parent_id` = :parent_id";
            $condition2 .= " AND c.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND a.`game_id` = :game_id";
            $condition2 .= " AND b.`game_id` = :game_id";
        }
        if ($device_type > 0) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND a.`device_type` = :device_type";
            $condition2 .= " AND b.`device_type` = :device_type";
        }
        if ($sdate && $edate) {
            $param['sdate'] = $sdate;
            $param['edate'] = $edate;
            $condition1 .= " AND a.`date` BETWEEN :sdate AND :edate";
            $condition2 .= " AND FROM_UNIXTIME(b.reg_time,'%Y-%m-%d') BETWEEN :sdate AND :edate";
        }

        $authorSql1 = SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`', 'a.`channel_id`', '');
        $authorSql2 = SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', 'b.channel_id', '');
        $retain_field = $retain_total_field = [];
        foreach ($day as $d) {
            //留存
            $retain_field[] = "b.retain{$d}";
            $retain_total_field[] = "SUM(a.`retain{$d}`) `retain{$d}`";
        }
        $retain_field = implode(', ', $retain_field);
        $retain_total_field = implode(', ', $retain_total_field);

        $sql = "SELECT a.`date`, a.`reg_count`, b.`pay_count`, {$retain_field} 
                FROM (
                    SELECT a.`date`, SUM(a.`reg`) `reg_count` 
                    FROM `" . LibTable::$data_reg . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                    WHERE 1 {$condition1} {$authorSql1} GROUP BY `date`
                ) a 
                LEFT JOIN (
                    SELECT FROM_UNIXTIME(b.`reg_time`,'%Y-%m-%d') `date`, COUNT(DISTINCT a.`uid`) `pay_count`, {$retain_total_field} 
                    FROM `" . LibTable::$sy_user_config . "` a 
                        INNER JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid 
                        LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id` = c.`game_id` 
                    WHERE a.`total_pay_money` > 0 {$condition2} {$authorSql2} GROUP BY `date`
                ) b ON a.date = b.date ORDER BY a.`date` DESC";
        return $this->query($sql, $param);
    }
}