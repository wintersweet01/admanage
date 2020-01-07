<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/12/4
 * Time: 16:06
 */

class ModLog extends Model
{
    public $conn = 'log';

    /**
     * 激活日志
     * @param int $page
     * @param string $date
     * @param string $device_id
     * @param int $channel_id
     * @param int $game_id
     * @return array
     */
    public function activeLog($page = 1, $date = '', $device_id = '', $channel_id = 0, $game_id = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $table = LibTable::$log_active . '_' . $date;

        $param = [];
        $connection = '';
        if ($channel_id > 0) {
            $connection .= " AND a.`channel_id` = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($device_id) {
            $connection .= " AND a.`device_id` = :device_id";
            $param['device_id'] = $device_id;
        }
        if ($game_id > 0) {
            $connection .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }

        $data = [];
        $sql = "SELECT COUNT(*) AS c FROM `" . $table . "` a WHERE 1 {$connection}";
        $row = $this->getOne($sql, $param);
        $count = (int)$row['c'];
        if ($count) {
            $sql = "SELECT a.*, b.`parent_id` 
                    FROM `" . $table . "` a 
                        LEFT JOIN sdk_data.`" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id`  
                    WHERE 1 {$connection} ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取激活记录
     *
     * @param int $id
     * @param string $date
     * @return array|bool|resource|string
     */
    public function getActiveLogInfo($id = 0, $date = '')
    {
        $table = LibTable::$log_active . '_' . $date;
        return $this->commonGetOne($table, 'id', $id);
    }


    /**
     * 获取玩家日志情况
     */
    public function getPlayerLog($data, $page)
    {
        $limit = '';
        $param = array();
        $condition1 = $condition2 = $condition3 = $cond = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        if ($data['parent_id'] > 0) {
            $condition1 = ' and c.parent_id=:parent_id';
            $condition2 = ' and c.`parent_id`=:parent_id';
            $condition3 = ' and c.`parent_id`=:parent_id';
            $param['parent_id'] = $data['parent_id'];
        }
        if ($data['game_id'] > 0) {
            $condition1 .= " and a.`game_id`=:game_id";
            $condition2 .= " and a.`game_id`=:game_id";
            $condition3 .= " and a.`game_id`=:game_id";
            $param['game_id'] = $data['game_id'];
        }
        if ($data['server_id'] > 0) {
            $condition1 .= " and a.`server_id`=:server_id";
            $param['server_id'] = $data['server_id'];
        }
        if ($data['device_type']) {
            $condition1 .= " and b.device_type=:device_type";
            $condition2 .= " and b.`device_type`=:device_type";
            $condition3 .= " and a.`device_type`=:device_type";
            $param['device_type'] = $data['device_type'];
        }
        if ($data['role_name']) {
            $condition1 .= " and a.`role_name` like :role_name";
            $param['role_name'] = "%" . $data['role_name'] . "%";
        }
        if ($data['account']) {
            $condition1 .= " and d.`username`=:username";
            $condition2 .= " and d.`username`=:username";
            $condition3 .= " and d.`username`=:username";
            $param['username'] = $data['account'];
        }
        if ($data['sdate']) {
            $condition1 .= " and a.`update_time` >=:sdate";
            $condition2 .= " and a.`active_time` >=:sdate";
            $condition3 .= " and a.`login_time`  >=:sdate";
            $param['sdate'] = strtotime($data['sdate']);
        }
        if ($data['edate']) {
            $condition1 .= " and a.`update_time` <=:edate";
            $condition2 .= " and a.`active_time` <=:edate";
            $condition3 .= " and a.`login_time` <=:edate";
            $param['edate'] = strtotime($data['edate']);
        }

        if ($data['channel_id']) {
            $condition1 .= " and b.`channel_id`=:channel_id";
            $condition2 .= " and b.`channel_id`=:channel_id";
            $condition3 .= " and b.`channel_id`=:channel_id";
            $param['channel_id'] = $data['channel_id'];
        }
        if ($data['opp']) {
            $cond .= " and h_type=:h_type";
            $param['h_type'] = $data['opp'];
        }

        if ($data['ip']) {
            $condition3 .= " and a.`login_ip`=:ip";
            $param['ip'] = $data['ip'];
        }
        $date = substr($data['sdate'], 0, 10);
        $tableDate = str_replace('-', '', $date);
        $logRoleTable = LibTable::$log_role . "_" . $tableDate;
        $logActiveTable = LibTable::$log_active . "_" . $tableDate;
        $logLoginTable = LibTable::$log_login . "_" . $tableDate;

        $resRole = $this->query("SHOW TABLES LIKE '%" . $logRoleTable . "%'");
        $resActive = $this->query("SHOW TABLES LIKE '%" . $logActiveTable . "%'");
        $resLogin = $this->query("SHOW TABLES LIKE '%" . $logLoginTable . "%'");
        $sql = [];

        if (Model::$db->fetch($resRole)) {
           /* //玩家角色日志
            $sql[] = "select a.`uid`,a.`game_id`,c.`parent_id`,a.`server_id`,a.`role_name`,a.`role_level`,a.`type` h_type,a.`update_time` h_time,
				'' device_id,'' device_name,'' device_version,d.`username`,'' login_game,'' reg_game,'' ip
		    from `" . $logRoleTable . "` a 
		    left join sdk_data." . LibTable::$user_ext . " b on a.`uid`=b.`uid`
		    left join sdk_data." . LibTable::$sy_game . " c on a.`game_id`=c.`game_id`
		    left join sdk_data." . LibTable::$sy_user . " d on a.`uid`=d.`uid`
		      where 1 {$condition1}";*/
        }

        if (Model::$db->fetch($resActive)) {
            /*//玩家激活日志
            $activeId = array('00000000-0000-0000-0000-000000000000', 'undefined', '000000000000000', 'null', '37a6259cc0c1dae299a7866489dff0bd');
            $sql[] = "select b.`uid`,a.`game_id`,c.`parent_id`,'' server_id,'' role_name,'' role_level,if(a.`active_time` != 0,999,null) h_type,
				if(a.`active_time` != 0,a.active_time,0) h_time,a.`device_id`,a.`device_name`,a.`device_version`,d.`username`,
				'' login_game,'' reg_game,'' ip
	        from sdk_data.`" . LibTable::$active . "` a force index(`device_id`)
	        left join sdk_data." . LibTable::$user_ext . " b force index(`game_id`) on a.`device_id`=b.`device_id`
	        left join sdk_data." . LibTable::$sy_game . " c on a.`game_id`=c.`game_id`	
	        left join sdk_data." . LibTable::$sy_user . " d on b.`uid`=d.`uid`
	          where b.`game_id`>0 {$condition2} and a.`device_id` NOT IN('" . join("','", $activeId) . "') and a.`device_id` != '' ";*/

        }
        if (Model::$db->fetch($resLogin)) {
            //玩家登录日志
            $sql[] = "select b.`uid`,a.`game_id`,c.`parent_id`,'' server_id,'' role_name,'' role_level,996 h_type,a.`login_time` h_time,
                '' device_id,'' device_name,'' device_version,d.username,a.`game_id` login_game,b.game_id reg_game,a.login_ip ip
                from `" . $logLoginTable . "` a 
                left join sdk_data.`" . LibTable::$user_ext . "` b on a.uid=b.uid
                left join sdk_data.`" . LibTable::$sy_game . "` c on a.`game_id`=c.`game_id`
                left join sdk_data." . LibTable::$sy_user . " d on a.`uid`=d.`uid`
                where 1 {$condition3}";
        }

        if (!empty($sql)) {
            $_sql = implode(" UNION ALL ", $sql);
            $_sqlQue = "select _FIELD_ FROM( " . $_sql . ") tmp where 1 {$cond} order by h_time desc ,uid asc";
            $field = " count(*) as c ";
            $count = $this->getOne(str_replace('_FIELD_', $field, $_sqlQue), $param);
            if (!$count['c']) {
                return array();
            }
            $field = ' * ';
            return array(
                'list' => $this->query(str_replace('_FIELD_', $field, $_sqlQue . $limit), $param),
                'total' => $count['c']
            );
        }
        return array();
    }
}