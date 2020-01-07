<?php

class ModPlatform extends Model
{
    public $conn = 'default';

    public function __construct()
    {
        parent::__construct('default');
    }

    /**
     * 公用获取数据记录列表
     * @param int $page
     * @param string $table
     * @param string $sort
     * @param string $field
     * @return array
     */
    public function getDataList($page = 0, $table = '', $sort = '', $field = '*')
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $data = array();
        $row = $this->getOne("SELECT COUNT(*) AS c FROM `{$table}`");
        $count = (int)$row['c'];
        if ($count > 0) {
            $data = $this->query("SELECT {$field} FROM `{$table}` ORDER BY `{$sort}` DESC {$limit}");
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 公用获取数据信息
     * @param string $table
     * @param string $field
     * @param int $id
     * @return array|bool|resource|string
     */
    public function getDataInfo($table = '', $field = '', $id = 0)
    {
        return $this->commonGetOne($table, $field, $id);
    }

    /**
     * 公用更新记录
     * @param string $table
     * @param array $data
     * @param array $where
     * @return resource|string
     */
    public function updateData($table = '', $data = array(), $where = array())
    {
        if ($data['config'] && is_array($data['config'])) {
            $data['config'] = serialize($data['config']);
        }
        return $this->update($data, $where, $table);
    }

    /**
     * 公用添加记录
     * @param string $table
     * @param array $data
     * @param bool $ret
     * @return resource|string
     */
    public function addData($table = '', $data = array(), $ret = true)
    {
        if ($data['config'] && is_array($data['config'])) {
            $data['config'] = serialize($data['config']);
        }
        return $this->insert($data, $ret, $table);
    }

    /**
     * 公用删除记录
     * @param string $table
     * @param array $where
     * @return resource|string
     */
    public function delData($table = '', $where = array())
    {
        return $this->delete($where, 0, $table);
    }

    public function delApiConf($id)
    {
        $sql = "delete from " . LibTable::$union_game . " where `id`=$id ";
        return $this->query($sql);
    }

    public function apiConfigs($id)
    {
        $sql = "select * from " . LibTable::$union_game . " where `id`=$id ";
        $data = $this->getOne($sql);
        return $data;
    }

    public function apiConfList($page, $game_id)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select * from " . LibTable::$union_game . " where 1 ";
        $sql_count = "select count(*) as c from " . LibTable::$union_game . " where 1 ";
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= ' and game_id = :game_id ';
            $sql_count .= ' and game_id = :game_id ';
        }
        $sql .= " order by `game_id` desc {$limit}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function serverPlanList($page = 0, $game_id)
    {
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }
        $sql = "select * from " . LibTable::$data_game_server . " where 1 ";
        $sql_count = "select count(*) as c from " . LibTable::$data_game_server . " where 1 ";
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= ' and game_id = :game_id ';
            $sql_count .= ' and game_id = :game_id ';
        }
        $sql .= " order by `date` desc {$limit}";
        $count = $this->getOne($sql_count, $param);

        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function mergeServerList($page = 0, $game_id, $merge_server_id)
    {
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $sql = "select * from " . LibTable::$sy_game_server_merge . " where 1 ";
        $sql_count = "select count(*) as c from " . LibTable::$sy_game_server_merge . " where 1 ";
        $param = array();
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= ' and game_id = :game_id ';
            $sql_count .= ' and game_id = :game_id ';
        }
        if ($merge_server_id) {
            $param['merge_server_id'] = $merge_server_id;
            $sql .= ' and merge_server_id =:merge_server_id';
            $sql_count .= ' and merge_server_id =:merge_server_id';
        }
        $sql .= " order by `merge_date` desc {$limit}";
        $count = $this->getOne($sql_count, $param);

        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function getGameList_page($page = 1, $page_num = 15, $data = array())
    {
        $device_type = (int)$data['device_type'];
        $status = (int)$data['status'];
        $keyword = trim($data['keyword']);

        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num);
        }

        $param = array();
        $condition = " WHERE `status` = {$status}";

        if ($device_type > 0) {
            $condition .= " AND `device_type` = :device_type";
            $param['device_type'] = $device_type;
        }

        if ($keyword) {
            $condition .= ' AND `name` LIKE :name';
            $param['name'] = "%{$keyword}%";

            //查询ID
            if (is_numeric($keyword) && $keyword < 999999) {
                $condition .= ' OR `game_id` = :game_id';
                $param['game_id'] = $keyword;
            }

            //查询别名
            if (preg_match('/[a-zA-Z\-\_]+/', $keyword)) {
                $condition .= ' OR `alias` LIKE :alias';
                $param['alias'] = "%{$keyword}%";
            }
        } else {
            $condition .= " AND `parent_id` > 0";
        }

        $info = array();
        $sql = "SELECT COUNT(*) c FROM (SELECT `parent_id` FROM `" . LibTable::$sy_game . "` {$condition} GROUP BY `parent_id`) tmp";
        $row = $this->getOne($sql, $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            //查出符合条件所有母游戏ID
            $sql = "SELECT `parent_id`, GROUP_CONCAT(`game_id`) gids FROM `" . LibTable::$sy_game . "` {$condition} GROUP BY `parent_id` ORDER BY `parent_id` DESC {$limit}";
            $_tmp = $this->query($sql, $param);

            $parent = array();
            $parent_ids = array();
            $game_ids = array();
            foreach ($_tmp as $row) {
                if ($row['parent_id'] > 0) {
                    $parent_ids[] = $row['parent_id'];
                    $game_ids[] = $row['gids'];
                } else {
                    $parent[] = $row['gids'];
                }
            }

            if (!empty($parent_ids)) {//所得母游戏的所有子游戏
                $ids = implode(',', $parent_ids) . ',' . implode(',', $game_ids);
                $sql = "SELECT * FROM `" . LibTable::$sy_game . "` WHERE `game_id` IN({$ids}) ORDER BY `game_id` DESC";
                $info = $this->query($sql);
            } elseif (!empty($parent)) {//只有母游戏
                $ids = implode(',', $parent);
                $sql = "SELECT * FROM `" . LibTable::$sy_game . "` WHERE `game_id` IN({$ids}) OR `parent_id` IN({$ids}) ORDER BY `game_id` DESC";
                $info = $this->query($sql);
            }
        }

        return array(
            'list' => $info,
            'total' => $count,
        );
    }

    public function getGameList($page = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $sql = "SELECT * FROM `" . LibTable::$sy_game . "` ORDER BY `game_id` DESC {$limit}";
        $count = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$sy_game . "`");
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count['c'],
        );
    }

    public function getAllServer()
    {
        $sql = "select * from " . LibTable::$data_game_server . " where 1 ";
        return $this->query($sql);
    }

    public function getRefreshPackage($game_id)
    {
        $sql = "select count(*) `total` from `" . LibTable::$sy_game_package_refresh . "` where `game_id`=:game_id and `state`<=1";
        $result = $this->getOne($sql, array(
            'game_id' => $game_id,
        ));
        return $result['total'] ? $result['total'] : 0;
    }

    /**
     * 批量获取分包状态
     * @param array $ids
     * @return array|bool|resource|string
     */
    public function getRefreshPackageCount($ids = array())
    {
        if (empty($ids) || !is_array($ids)) {
            return array();
        }

        $ids = implode(',', $ids);
        $sql = "SELECT `game_id`, COUNT(*) total FROM `" . LibTable::$sy_game_package_refresh . "` WHERE `state` <= 1 AND `game_id` IN({$ids}) GROUP BY `game_id`";
        return $this->query($sql);
    }

    public function getRefreshPackageByPackageName($package_name)
    {
        $sql = "SELECT COUNT(*) `total` FROM `" . LibTable::$sy_game_package_refresh . "` WHERE `package_name` = :package_name AND `state` <= 1";
        $result = $this->getOne($sql, array(
            'package_name' => $package_name,
        ));
        return $result['total'] ? $result['total'] : 0;
    }

    public function getGameInfo($game_id)
    {
        return $this->commonGetOne(LibTable::$sy_game, 'game_id', $game_id);
    }

    public function updateGameAction($game_id, $data)
    {
        is_array($data['config']) && $data['config'] = serialize($data['config']);
        $where = array(
            'game_id' => $game_id,
        );
        $this->update($data, $where, LibTable::$sy_game);
        return $this->affectedRows();
    }

    public function addGameAction($data)
    {
        is_array($data['config']) && $data['config'] = serialize($data['config']);
        return $this->insert($data, true, LibTable::$sy_game);
    }

    /**
     * 获取分包列表
     * @param $param
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getPackageList($param, $page = 1, $page_num = 10)
    {
        $page = $page < 1 ? 1 : $page;
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $platform = (int)$param['platform'];
        $channel_id = (int)$param['channel_id'];
        $page = $page < 1 ? 1 : $page;

        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = array();
        $condition = 'WHERE a.`del` = 0';
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $condition .= " AND b.`parent_id` = :parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $condition .= " AND a.`game_id` = :game_id";
        }
        if ($platform) {
            $param['platform'] = $platform;
            $condition .= " AND a.`platform` = :platform";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $condition .= " AND a.`channel_id` = :channel_id";
        }

        //权限
        $condition .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', '');

        $sql = "SELECT _FIELD_ 
                FROM `" . LibTable::$sy_game_package . "` a 
                LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                LEFT JOIN `" . LibTable::$channel . "` c ON a.`channel_id` = c.`channel_id` 
                LEFT JOIN `" . LibTable::$admin_user . "` d ON a.`administrator` = d.`user` 
                {$condition}";

        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        $data = array();
        if ($count > 0) {
            $field = 'a.*, b.`package_version` AS `game_version`, b.`sdk_version` AS `game_sdk_version`, b.`parent_id`, c.`channel_name`, d.`name` AS `admin_name`';
            $_sql = str_replace('_FIELD_', $field, $sql) . " ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function getPackageInfo($package_id)
    {
        return $this->commonGetOne(LibTable::$sy_game_package, 'id', $package_id);
    }

    public function countGamePackage($game_id, $channel_id)
    {
        $sql = "SELECT MAX(`package_number`) `number` FROM `" . LibTable::$sy_game_package . "` WHERE game_id = :game_id AND channel_id = :channel_id";
        $row = $this->getOne($sql, array('game_id' => $game_id, 'channel_id' => $channel_id));
        return $row['number'];
    }

    public function getPackageInfoByPackageName($package_name)
    {
        return $this->commonGetOne(LibTable::$sy_game_package, 'package_name', $package_name);
    }

    public function updatePackageAction($package_id, $data)
    {
        $where = array(
            'id' => $package_id,
        );
        $this->update($data, $where, LibTable::$sy_game_package);
        return $this->affectedRows();
    }

    public function updatePackageByPackageName($package_name, $data)
    {
        $where = array(
            'package_name' => $package_name,
        );
        $this->update($data, $where, LibTable::$sy_game_package);
        return $this->affectedRows();
    }

    public function addPackageAction($data)
    {
        return $this->insert($data, true, LibTable::$sy_game_package);
    }

    /**
     * 获取用户信息列表
     * @param array $param
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getUserList($param = array(), $page = 0, $page_num = 0)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $package_name = trim($param['package_name']);
        $channel_id = (int)$param['channel_id'];
        $keyword = trim($param['keyword']);
        $device_type = (int)$param['device_type'];
        $has_phone = (int)$param['has_phone'];
        $banned = (int)$param['banned'];
        $sdate = trim($param['sdate']);
        $edate = trim($param['edate']);
        $type = trim($param['type']);
        $openid = trim($param['openid']);

        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = '';
        if ($banned) {
            $connection .= " AND a.`status` = 1";
        }
        if ($has_phone) {
            $connection .= " AND a.`phone` != ''";
        }
        if ($parent_id) {
            $connection .= " AND d.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id) {
            $connection .= " AND b.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($device_type) {
            $connection .= " AND b.`device_type` = :device_type";
            $param['device_type'] = $device_type;
        }
        if ($channel_id) {
            $connection .= " AND b.`channel_id` = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($package_name) {
            $connection .= " AND b.`package_name` = :package_name";
            $param['package_name'] = $package_name;
        }
        if ($type) {
            $param['type'] = $type;
            if ($openid) {
                $connection .= " AND c.`type` = :type AND c.`openid` = :openid";
                $param['openid'] = $openid;
            } else {
                $connection .= " AND b.`type` = :type";
            }
        }
        if ($sdate) {
            $connection .= " AND b.`reg_time` >=:stime";
            $param['stime'] = strtotime($sdate . " 00:00:00");
        }
        if ($edate) {
            $connection .= " AND b.`reg_time` <=:etime";
            $param['etime'] = strtotime($edate . " 23:59:59");
        }
        if ($keyword) {
            $str = 'a.`username` = :keyword';

            //UID
            if (is_numeric($keyword) && strlen($keyword) < 12) {
                $str .= " OR a.`uid` = :keyword";
            }

            //手机号
            if (preg_match('/^1[3456789]\d{9}$/ims', $keyword)) {
                $str .= " OR a.`phone` = :keyword";
            }

            if (filter_var($keyword, FILTER_VALIDATE_IP)) {//IP
                $str .= " OR b.`reg_ip` = :keyword";
            } elseif (in_array(strlen($keyword), array(14, 15, 36))) {//设备号
                $str .= " OR b.`device_id` = :keyword";
            }

            $connection .= " AND ({$str})";
            $param['keyword'] = $keyword;
        }

        $sql = "SELECT _FIELD_ 
                FROM `" . LibTable::$sy_user . "` a 
                    INNER JOIN `" . LibTable::$user_ext . "` b ON a.`uid` = b.`uid` 
                    LEFT JOIN `" . LibTable::$sy_openid . "` c ON c.`uid` = b.`uid` 
                    LEFT JOIN `" . LibTable::$sy_game . "` d ON d.`game_id` = b.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` e ON e.`monitor_id` = b.`monitor_id` 
                    LEFT JOIN `" . LibTable::$channel . "` f ON f.channel_id = b.channel_id 
                WHERE 1 {$connection}";

        $data = [];
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $field = 'a.`username`, a.`phone`, a.`real_auth`, a.`status`, b.*, c.`openid`, d.`parent_id`, d.`name` AS game_name, e.`name` as `monitor_name`, e.`jump_url`, e.`monitor_url`, f.`channel_name`';
            $_sql = str_replace('_FIELD_', $field, $sql) . " ORDER BY a.`uid` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function userPayInfo($uid)
    {
        $sql = "SELECT MAX(`pay_time`) AS `last_pay_time`, SUM(`total_fee`) AS `pay_money` FROM `" . LibTable::$sy_order . "` WHERE `is_pay` = " . PAY_STATUS['已支付'] . " AND `uid` = :uid";
        return $this->getOne($sql, array('uid' => $uid));
    }

    /**
     * 获取用户总充值
     * @param string $uid
     * @return array|bool|resource|string
     */
    public function getUserPayList($uid = '')
    {
        $sql = "SELECT uid, MAX(`pay_time`) AS `last_pay_time`, SUM(`total_fee`) AS `pay_money` 
                FROM `" . LibTable::$sy_order . "` 
                WHERE `is_pay` = " . PAY_STATUS['已支付'] . " AND `uid` IN({$uid}) 
                GROUP BY uid";
        return $this->query($sql);
    }

    /**
     * 获取订单列表
     * @param array $query
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getOrderList($query = [], $page = 1, $page_num = 15)
    {
        $sdate = trim($query['sdate']);
        $edate = trim($query['edate']);
        $parent_id = (int)$query['parent_id'];
        $game_id = (int)$query['game_id'];
        $server_id = trim($query['server_id']);
        $level1 = (int)$query['level1'];
        $level2 = (int)$query['level2'];
        $package_name = trim($query['package_name']);
        $uid = (int)$query['uid'];
        $username = trim($query['username']);
        $role_name = trim($query['role_name']);
        $pay_type = (int)$query['pay_type'];
        $order_num = trim($query['pt_order_num']);
        $is_pay = (int)$query['is_pay'];
        $is_notify = (int)$query['is_notify'] - 1;
        $device_type = (int)$query['device_type'];
        $channel_id = (int)$query['channel_id'];
        $pay_channel = trim($query['pay_channel']);
        $direct = (int)$query['direct'];

        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = '';
        if ($uid) {
            $param['uid'] = $uid;
            $connection .= " AND a.`uid` = :uid";
        }
        if ($is_pay) {
            $param['is_pay'] = $is_pay;
            $connection .= " AND a.`is_pay` = :is_pay";
        }
        if ($is_notify != -1) {
            $param['is_notify'] = $is_notify;
            $connection .= " AND a.`is_notify` = :is_notify";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $connection .= " AND a.`game_id` = :game_id";
        } elseif ($parent_id) {
            $param['parent_id'] = $parent_id;
            $connection .= " AND c.`parent_id` = :parent_id";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $connection .= " AND b.`channel_id` = :channel_id";
        }
        if ($server_id) {
            $param['server_id'] = $server_id;
            $connection .= " AND a.`server_id` = :server_id";
        }
        if ($level1 > 0) {
            $param['level1'] = $level1 * 100;
            $connection .= " AND a.`total_fee` >= :level1";
        }
        if ($level2 > 0) {
            $param['level2'] = $level2 * 100;
            $connection .= " AND a.`total_fee` <= :level2";
        }
        if ($package_name) {
            $param['package_name'] = $package_name;
            $connection .= " AND a.`package_name` = :package_name";
        }
        if ($username) {
            $param['username'] = $username;
            if (is_numeric($username)) {
                $connection .= " AND (b.`username` = :username OR a.`uid` = :username)";
            } else {
                $connection .= " AND b.`username` = :username";
            }
        }
        if ($role_name) {
            $param['role_name'] = $role_name;
            $connection .= " AND a.`role_name` = :role_name";
        }
        if ($pay_type) {
            $param['pay_type'] = $pay_type;
            $connection .= " AND a.`pay_type` = :pay_type";
        }
        if ($pay_channel) {
            if ($pay_channel == 'hutao') {
                $connection .= " AND a.`union_channel` = ''";
            } else {
                $param['pay_channel'] = $pay_channel;
                $connection .= " AND a.`union_channel` = :pay_channel";
            }
        }
        if ($order_num) {
            $param['order_num'] = $order_num;
            $connection .= " AND (a.`pt_order_num` = :order_num OR a.`cp_order_num` = :order_num OR a.`third_trade_no` = :order_num)";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $connection .= " AND a.`device_type` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = strtotime($sdate . ' 00:00:00');
            $connection .= " AND a.`create_time` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = strtotime($edate . ' 23:59:59');
            $connection .= " AND a.`create_time` <= :edate";
        }
        if ($direct) {
            $connection .= " AND a.`administrator` <> ''";
        }

        $sql = "SELECT _FIELD_ 
                FROM `" . LibTable::$sy_order . "` a 
                    LEFT JOIN `" . LibTable::$user_ext . "` b ON a.`uid` = b.`uid` 
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id`";

        $data = [];
        $field = 'COUNT(*) AS c, SUM(a.`total_fee`) AS `total_fee`, SUM(IF(a.`discount` > 0, a.`total_fee` * a.`discount` / 100, a.`total_fee`)) AS `discount`, COUNT(DISTINCT a.`uid`) AS `total`';
        $row = $this->getOne(str_replace('_FIELD_', $field, $sql . " WHERE 1 {$connection}"), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $field = 'a.*, b.`game_id` AS reg_game_id, b.username, c.`parent_id`, c.`name` AS game_name, d.`name` AS admin_name';
            $_sql = str_replace('_FIELD_', $field, $sql) . " LEFT JOIN `" . LibTable::$admin_user . "` d ON a.`administrator` = d.`user` WHERE 1 {$connection} ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }
        return array(
            'list' => $data,
            'total' => $row,
        );
    }

    public function getOrderListExcel($sdate, $edate, $game_id, $server_id, $level1, $level2, $package_name, $username, $uid, $role_name, $pay_type, $pay_channel, $order_num, $is_pay, $is_notify, $device_type, $channel_id)
    {
        $sql = "SELECT a.`uid`, c.`username`, b.`reg_time`, a.`create_time`, a.`pay_time`, a.`pt_order_num`, a.`third_trade_no`, "
            . "d.`name` AS game_name, a.`package_name`, a.`device_type`, a.`server_id`, a.`role_name`, a.`role_level`, "
            . "a.`is_pay`, a.`total_fee` AS money, a.`pay_type`, f.`channel_name`, e.`name` AS monitor_name "
            . "FROM `" . LibTable::$sy_order . "` a "
            . "LEFT JOIN `" . LibTable::$user_ext . "` b ON a.`uid` = b.`uid` "
            . "LEFT JOIN `" . LibTable::$sy_user . "` c ON a.`uid` = c.`uid` "
            . "LEFT JOIN `" . LibTable::$sy_game . "` d ON a.`game_id` = d.`game_id` "
            . "LEFT JOIN `" . LibTable::$ad_project . "` e ON b.`monitor_id` = e.`monitor_id` "
            . "LEFT JOIN `" . LibTable::$channel . "` f ON b.`channel_id` = f.`channel_id` "
            . "WHERE 1";

        $param = array();
        if ($is_pay) {
            $param['is_pay'] = $is_pay;
            $sql .= " AND a.`is_pay` = :is_pay";
        }
        if ($is_notify != -1) {
            $param['is_notify'] = $is_notify;
            $sql .= " AND a.`is_notify` = :is_notify";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " AND a.`game_id` = :game_id";
        }
        if ($server_id) {
            $param['server_id'] = $server_id;
            $sql .= " AND a.`server_id` = :server_id";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $sql .= " and b.`channel_id` = :channel_id ";
        }
        if ($level1 > 0) {
            $param['level1'] = $level1 * 100;
            $sql .= " AND a.`total_fee` >= :level1";
        }
        if ($level2 > 0) {
            $param['level2'] = $level2 * 100;
            $sql .= " AND a.`total_fee` <= :level2";
        }
        if ($package_name) {
            $param['package_name'] = $package_name;
            $sql .= " AND a.`package_name` = :package_name";
        }
        if ($username) {
            $param['username'] = $username;
            $sql .= " AND b.`username` = :username";
        }
        if ($role_name) {
            $param['role_name'] = "%{$role_name}%";
            $sql .= " AND a.`role_name` LIKE :role_name";
        }
        if ($uid) {
            $param['uid'] = $uid;
            $sql .= " AND a.`uid` = :uid";
        }
        if ($pay_type) {
            $param['pay_type'] = $pay_type;
            $sql .= " AND a.`pay_type` = :pay_type";
        }
        if ($pay_channel) {
            $param['pay_channel'] = $pay_channel;
            $sql .= " AND a.`union_channel` = :pay_channel";
        }
        if ($order_num) {
            $param['pt_order_num'] = $order_num;
            $sql .= " AND a.`pt_order_num` = :pt_order_num";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $sql .= " AND a.`device_type` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = strtotime($sdate . ' 00:00:00');
            $sql .= " and a.`create_time` >= :sdate ";
        }
        if ($edate) {
            $param['edate'] = strtotime($edate . ' 23:59:59');
            $sql .= " and a.`create_time` <= :edate ";
        }
        $sql .= " ORDER BY a.`id` DESC";

        return $this->query($sql, $param);
    }

    /**
     * 获取角色列表
     * @param int $page
     * @param int $page_num
     * @param int $parent_id
     * @param int $game_id
     * @param int $channel_id
     * @param int $device_type
     * @param string $package_name
     * @param int $server_id
     * @param string $role_name
     * @param string $username
     * @param string $sdate
     * @param string $edate
     * @param int $has_pay
     * @param int $has_phone
     * @return array
     */
    public function getRoleList($page = 0, $page_num = 0, $parent_id = 0, $game_id = 0, $channel_id = 0, $device_type = 0, $package_name = '', $server_id = 0, $role_name = '', $username = '', $sdate = '', $edate = '', $has_pay = 0, $has_phone = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $data = array();
        $param = array();
        $condition = '';

        if ($game_id) {
            $param['game_id'] = $game_id;
            $condition .= " AND a.`game_id` = :game_id";
        } elseif ($parent_id) {
            $param['parent_id'] = $parent_id;
            $condition .= " AND d.`parent_id` = :parent_id";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $condition .= " AND c.`channel_id` = :channel_id";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $condition .= " AND a.`device_type` = :device_type";
        }
        if ($server_id) {
            $param['server_id'] = $server_id;
            $condition .= " AND a.`server_id` = :server_id";
        }
        if ($has_phone) {
            $condition .= " AND b.`phone` <> ''";
        }
        if ($has_pay) {
            $condition .= " AND a.`pays` > 0";
        }
        if ($package_name) {
            $param['package_name'] = $package_name;
            $condition .= " AND c.`package_name` = :package_name";
        }
        if ($username) {
            $param['username'] = $username;
            $condition .= " AND b.`username` = :username";
        }
        if ($role_name) {
            $param['role_name'] = '%' . $role_name . '%';
            $condition .= " AND a.`role_name` LIKE :role_name";
        }
        if ($sdate) {
            $param['sdate'] = strtotime($sdate . ' 00:00:00');
            $condition .= " AND c.`reg_time` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = strtotime($edate . ' 23:59:59');
            $condition .= " AND c.`reg_time` <= :edate";
        }

        $sql = "SELECT _FIELD_  
                FROM `" . LibTable::$user_role . "` a 
                    LEFT JOIN `" . LibTable::$sy_user . "` b ON a.uid = b.uid 
                    LEFT JOIN `" . LibTable::$user_ext . "` c ON a.uid = c.uid 
                    LEFT JOIN `" . LibTable::$sy_game . "` d ON a.`game_id` = d.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` f ON c.monitor_id = f.monitor_id 
                WHERE 1 {$condition}";
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $_sql = "a.*, b.`username`, b.`phone`, c.`package_name`, c.`channel_id`, c.`reg_time`, c.`reg_ip`, c.`reg_city`, d.`parent_id`, f.`name` as `monitor_name`, f.`jump_url`, f.`monitor_url`";
            $_sql = str_replace('_FIELD_', $_sql, $sql) . " ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function getMonitorRoleList($monitor_id, $sdate, $edate)
    {
        $sql = "select * from `" . LibTable::$user_role . "` where `uid` in (select `uid` from `" . LibTable::$sy_user . "` where `monitor_id`=:monitor_id and `active_time`>=:time1 and `active_time`<:time2)";
        return $this->query($sql, array(
            'monitor_id' => $monitor_id,
            'time1' => strtotime($sdate),
            'time2' => strtotime($edate) + 86400,
        ));
    }

    public function updateRoleLevel($id, $level)
    {
        $this->update(array('role_level' => $level), array('id' => $id), LibTable::$user_role);
    }

    public function getGames($uid)
    {
        $sql = "select a.`game_name` from `" . LibTable::$sy_game . "` as a,`" . LibTable::$user_role . "` as `b` where a.`game_id`=b.`game_id` and b.`uid`=:uid group by b.`game_id`";
        $result = $this->query($sql, array('uid' => $uid));
        $game = '';
        if ($result) {
            foreach ($result as $r) {
                $game .= $r['game_name'] . ',';
            }
        }
        return rtrim($game, ',');
    }

    public function getRoles($uid)
    {
        $sql = "select count(*) `total` from `" . LibTable::$user_role . "` where `uid`=:uid";
        $result = $this->getOne($sql, array('uid' => $uid));
        return $result['total'] ? $result['total'] : 0;
    }

    public function getAllPay($uid)
    {
        $sql = "select sum(`money`) as `money` from `" . LibTable::$data_pay . "` where `uid`=:uid";
        $result = $this->getOne($sql, array('uid' => $uid));
        return $result['money'] ? $result['money'] : 0;
    }

    public function getUserInfo($username)
    {
        $param = [];
        $condition = '';
        if (is_array($username)) {
            $condition .= " AND a.uid = :uid";
            $param['uid'] = $username['uid'];
        } else {
            $condition .= " AND a.username = :username";
            $param['username'] = $username;
        }

        $sql = "SELECT a.*, b.`name`, b.`id_number` 
                FROM `" . LibTable::$sy_user . "` a 
                    LEFT JOIN `" . LibTable::$sy_real_auth . "` b ON a.`uid` = b.`uid` 
                WHERE 1 {$condition}";
        return $this->getOne($sql, $param);
    }

    public function getOrderInfo($order_num)
    {
        return $this->commonGetOne(LibTable::$sy_order, 'pt_order_num', $order_num);
    }

    public function getPackageByGame($game_id, $channel_id = 0, $device_type = 0)
    {

        $sql = "select `id`,`package_name`, `sdk_version`, `channel_id`, `platform`, `status`, `user_id` from `" . LibTable::$sy_game_package . "` where `game_id`=:game_id";
        $param = array(
            'game_id' => $game_id,
        );
        if ($channel_id) {
            $sql .= " and `channel_id` = :channel_id ";
            $param['channel_id'] = $channel_id;
        }
        if ($device_type) {
            $sql .= " and `platform` = $device_type ";
        }
        return $this->query($sql, $param);
    }

    public function gameLevel($game_id)
    {
        $this->update(array(
            'package_version' => array('+', 1),
        ), array(
            'game_id' => $game_id,
        ), LibTable::$sy_game);
        return $this->affectedRows();
    }

    public function refreshPackage($game_info, $package)
    {
        $insert = array();
        foreach ($package as $p) {
            $insert[] = array(
                'game_id' => $game_info['game_id'],
                'package_version' => $game_info['package_version'],
                'sdk_version' => $game_info['sdk_version'],
                'package_name' => $p['package_name'],
                'submit_time' => time(),
                'is_new' => 0,
                'channel_id' => $p['channel_id'],
                'user_id' => $p['user_id'],
                'administrator' => SrvAuth::$name,
            );
        }
        return $this->multiInsert($insert, LibTable::$sy_game_package_refresh);
    }

    /**
     * 安卓分包进度列表
     * @param $game_id
     * @param int $state
     * @param string $package_name
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function refreshProgress($game_id, $state = -1, $package_name = '', $page = 1, $page_num = 10)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = array();
        $condition = 'WHERE 1';
        if ($game_id) {
            $condition .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($state > 0) {
            $condition .= " AND a.`state` = :state";
            $param['state'] = $state - 1;
        }
        if ($package_name) {
            $condition .= " AND a.`package_name` = :package_name";
            $param['package_name'] = trim($package_name);
        }

        $sql = "SELECT _FIELD_ FROM `" . LibTable::$sy_game_package_refresh . "` a";

        $data = array();
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql . ' ' . $condition), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $_sql = str_replace('_FIELD_', "a.* , b.`parent_id`, b.`name` AS game_name, c.`channel_name`, d.`name` AS admin_name", $sql);
            $_sql .= " LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id`";
            $_sql .= " LEFT JOIN `" . LibTable::$channel . "` c ON a.`channel_id` = c.`channel_id`";
            $_sql .= " LEFT JOIN `" . LibTable::$admin_user . "` d ON a.`administrator` = d.`user`";
            $_sql .= " {$condition} ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function refreshStatus($game_id, $package_name)
    {
        $param = [];
        $connection = 'WHERE 1';
        if ($game_id) {
            $connection .= " AND `game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($package_name) {
            $connection .= " AND `package_name` = :package_name";
            $param['package_name'] = $package_name;
        }
        $sql = "SELECT `state`, COUNT(*) AS `total` FROM `" . LibTable::$sy_game_package_refresh . "` {$connection} GROUP BY `state`";
        return $this->query($sql, $param);
    }

    public function subNewPackage($insert)
    {
        return $this->multiInsert($insert, LibTable::$sy_game_package_refresh);
    }

    public function subingPackage($game_id, $channel)
    {
        $sql = "select count(*) total from `" . LibTable::$sy_game_package_refresh . "` where `game_id`=:game_id and `channel_id`=:channel_id and `state`<=1";
        $result = $this->getOne($sql, array(
            'game_id' => $game_id,
            'channel_id' => $channel,
        ));
        return $result['total'] ? $result['total'] : 0;
    }

    public function gameServerMerge($game_id)
    {
        $sql = "select * from `" . LibTable::$sy_game_server_merge . "` where `game_id`=:game_id";
        $result = $this->query($sql, array('game_id' => $game_id));
        $data = array();
        if (!empty($result)) {
            foreach ($result as $v) {
                $data[$v['server_id']] = $v['merge_server_id'];
            }
        }
        return $data;
    }

    //批量获取服务器
    public function gameServerMergeBatch($game_id)
    {
        if (empty($game_id) || !is_array($game_id)) return array();
        $game_id = array_unique(array_filter($game_id));
        $sql = "select * from `" . LibTable::$sy_game_server_merge . "` where `game_id` IN(" . join(',', $game_id) . ")";
        $result = $this->query($sql);
        $data = array();
        if (!empty($result)) {
            foreach ($result as $v) {
                $data[$v['server_id']] = $v['merge_server_id'];
            }
        }
        return $data;
    }

    public function getMonitorByGame($game_id)
    {
        $sql = "select a.`monitor_id`,a.`name` from " . LibTable::$ad_project . " as a left join " . LibTable::$sy_game_package . " as p on p.`package_name`=a.`package_name` where platform = " . PLATFORM['ios'];
        if ($game_id) {
            $sql .= " and a.`game_id`=$game_id ";
        }

        return $this->query($sql);
    }

    public function getMonitorByGamePlat($game_id, $device_type)
    {
        $sql = "select a.`monitor_id`, a.`name` from " . LibTable::$ad_project . " as a left join " . LibTable::$sy_game_package . " as p on p.`package_name`=a.`package_name` where 1 ";
        if ($game_id) {
            $sql .= " and a.`game_id` = $game_id ";
        }
        if ($device_type) {
            $sql .= " and p.`platform` = $device_type ";
        }
        return $this->query($sql);
    }

    public function insertMergeServer($insert)
    {
        return $this->insert($insert, false, LibTable::$sy_game_server_merge);
    }

    public function checkMergeExist($data, $server_id)
    {
        $sql = "select count(*) as c from " . LibTable::$sy_game_server_merge . " where `game_id` = {$data['game_id']} and `merge_server_id` = {$data['merge_server_id']} and `server_id` = {$server_id}";
        return $this->getOne($sql);
    }

    public function apiConfAction($data)
    {
        return $this->insert($data, false, LibTable::$union_game);
    }

    public function getPackageGift($parent_id = 0, $game_id = 0)
    {
        $param = [];
        $connection = '';
        if ($parent_id > 0) {
            $connection .= " AND `parent_id` = :parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id > 0) {
            $connection .= " AND `game_id` = :game_id";
            $param['game_id'] = $game_id;
        }

        $sql = "SELECT `id`, `parent_id`, `game_id`, `name` AS `type_name`, `explain`, `amount`, `used`,`type`, `status` 
                FROM `" . LibTable::$sy_gift_type . "` 
                WHERE 1 {$connection} ORDER BY `parent_id` DESC, `game_id` ASC";
        return $this->query($sql, $param);
    }

    public function getGiftTypeList($parent_id = 0, $game_id = 0)
    {
        $param = [];
        $connection = '';
        if ($parent_id > 0 && $game_id <= 0) {
            $connection .= " AND `parent_id` = :parent_id AND `game_id` = 0";
            $param['parent_id'] = $parent_id;
        } elseif ($game_id > 0) {
            $connection .= " AND `parent_id` = :parent_id AND `game_id` = :game_id";
            $param['parent_id'] = $parent_id;
            $param['game_id'] = $game_id;
        }

        $sql = "SELECT `id`, `name` AS `type_name` FROM `" . LibTable::$sy_gift_type . "` WHERE 1 {$connection} ORDER BY `name`";
        return $this->query($sql, $param);
    }

    public function getGiftTypeInfo($id)
    {
        return $this->commonGetOne(LibTable::$sy_gift_type, 'id', $id);
    }

    public function addGiftType($data)
    {
        //连接主数据库
        parent::__construct('main');
        return $this->insert($data, true, LibTable::$sy_gift_type);
    }

    public function updateGiftType($id, $data)
    {
        $where = array('id' => $id);

        //连接主数据库
        parent::__construct('main');
        return $this->update($data, $where, LibTable::$sy_gift_type);
    }

    public function delGiftType($id)
    {
        //连接主数据库
        parent::__construct('main');
        $this->delete(array('type_id' => $id), 0, LibTable::$sy_gift);
        $this->delete(array('id' => $id), 1, LibTable::$sy_gift_type);
        return $this->affectedRows();
    }

    public function importGift($data)
    {
        //连接主数据库
        parent::__construct('main');
        $this->multiInsert($data, LibTable::$sy_gift);
        return $this->affectedRows();
    }

    /**
     * 获取指定礼包类型的数量
     * @param int $type_id
     * @return bool|mixed
     */
    public function getGiftCount($type_id = 0)
    {
        return $this->getCount(array('type_id' => $type_id), LibTable::$sy_gift);
    }

    public function updatePwd($uid, $salt, $password)
    {
        //连接主数据库
        parent::__construct('main');

        $update = array(
            'salt' => $salt,
            'pwd' => $password,
        );
        $where = array(
            'uid' => $uid,
        );
        return $this->update($update, $where, LibTable::$sy_user);
    }

    public function updateUserInfo($uid, $data)
    {
        //连接主数据库
        $this->conn = 'main';

        if (is_array($uid)) {
            $where = array(
                'username' => $uid['username']
            );
        } else {
            $where = array('uid' => $uid);
        }

        return $this->update($data, $where, LibTable::$sy_user);
    }

    /**
     * 删除分包
     * @param $id
     * @return bool|int
     */
    public function delPackage($id)
    {
        if (!$id) return false;
        if (is_string($id) && !is_numeric($id)) {
            $where = array('package_name' => $id);
        } else {
            $where = array('id' => $id);
        }

        $this->update(array('del' => 1), $where, LibTable::$sy_game_package);
        //$this->delete($where, 1, LibTable::$sy_game_package);
        return $this->affectedRows();
    }

    public function delPackageRefresh($package_name)
    {
        if (!$package_name) return false;

        $this->delete(array('package_name' => $package_name), 1, LibTable::$sy_game_package_refresh);
        return $this->affectedRows();
    }

    public function getLinkByPackage($package_name)
    {
        $sql = "select * from `" . LibTable::$ad_project . "` where `package_name` = :package_name ";
        return $this->query($sql, array('package_name' => $package_name));
    }

    public function gameUpdateAction($data)
    {
        return $this->insertOrUpdate($data, $data, LibTable::$sy_game_update);
    }

    public function getUserInfoByKey($keyword = '')
    {
        $param = $user_role = array();
        $length = strlen($keyword);
        $is_role = true;
        $condition = '';

        //不含有中文
        if (!preg_match('/[\x{4e00}-\x{9fa5}]/u', $keyword)) {
            $param['username'] = $keyword;
            $condition .= " OR a.`username` = :username";
        }

        //UID
        if (is_numeric($keyword) && $length < 12) {
            $param['uid'] = $keyword;
            $condition .= " OR a.`uid` = :uid";
            $is_role = false;
        }

        //手机号
        if (preg_match('/^1[3456789]\d{9}$/ims', $keyword)) {
            $param['phone'] = $keyword;
            $condition .= " OR a.`phone` = :phone";
            $is_role = false;
        }

        //设备号
        if (in_array($length, array(14, 15, 36))) {
            $param['device_id'] = $keyword;
            $condition .= " OR b.`device_id` = :device_id";
            $is_role = false;
        }

        //角色查询
        if ($is_role) {
            $user_role = $this->getUserRole($keyword);

            //符合角色信息的用户
            if (!empty($user_role)) {
                $condition .= ' OR a.`uid` IN(' . implode(',', array_keys($user_role)) . ')';
            }
        }

        $sql = "SELECT a.`uid`, a.`username`, a.`phone`, a.`real_auth`, a.`status`, b.`type`, b.`game_id` AS reg_game_id,
                b.`package_name`, b.`package_version`, b.`sdk_version`, b.`channel_id`, b.`active_time`, b.`reg_time`,
                b.`reg_ip`, b.`reg_city`, b.`reg_province`, b.`device_type`, b.`last_login_time`, b.`device_id`, b.`uuid`,
                b.`device_name`, b.`device_version`, b.`os_flag`, b.`resolution`, b.`producer`, b.`isp`, b.`network_type`,
                c.`name`, c.`id_number`, d.`openid`, e.`name` AS monitor_name 
                FROM `" . LibTable::$sy_user . "` a 
                LEFT JOIN `" . LibTable::$user_ext . "` b ON a.`uid` = b.`uid` 
                LEFT JOIN `" . LibTable::$sy_real_auth . "` c ON a.`uid` = c.`uid` 
                LEFT JOIN `" . LibTable::$sy_openid . "` d ON a.`uid` = d.`uid` 
                LEFT JOIN `" . LibTable::$ad_project . "` e ON b.`monitor_id` = e.`monitor_id` 
                WHERE 0 {$condition} ORDER BY a.`uid` DESC";
        $user = $this->query($sql, $param);

        if (!empty($user)) {
            $tmp = array();
            foreach ($user as $row) {
                $tmp[] = (int)$row['uid'];
            }

            if (!empty($tmp)) {
                $user_role = $this->getUserRole('', implode(',', $tmp));
            }
        }

        return array('user' => $user, 'role' => $user_role);
    }

    /**
     * 根据角色名查询用户角色信息
     * @param string $keyword
     * @param int $uid
     * @return array
     */
    public function getUserRole($keyword = '', $uid = 0)
    {
        $param = array();
        $user_role = array();
        $condition = '';

        if ($keyword) {
            $param['role_name'] = "%{$keyword}%";
            $condition .= " AND `role_name` LIKE :role_name";
        }

        if ($uid) {
            $condition .= " AND `uid` IN({$uid})";
        }

        $sql = "SELECT * FROM `" . LibTable::$user_role . "` WHERE 1 {$condition} ORDER BY `game_id` DESC, `create_time` DESC";
        $result = $this->query($sql, $param);
        foreach ($result as $row) {
            $row['pays'] = round($row['pays'] / 100, 2);
            $user_role[$row['uid']][] = $row;
        }

        return $user_role;
    }

    public function saveUserInfo($uid, $data)
    {
        //连接主数据库
        $this->conn = 'main';

        $real_auth = 1;
        $this->startWork();
        if (!$data['name'] || !$data['id_number']) {
            $real_auth = 0;
            $ret1 = $this->delete(array('uid' => $uid), 1, LibTable::$sy_real_auth);
        } else {
            $update = $insert = array(
                'name' => $data['name'],
                'id_number' => strtoupper($data['id_number']),
            );
            $insert['uid'] = $uid;
            $ret1 = $this->insertOrUpdate($insert, $update, LibTable::$sy_real_auth);
        }

        $user = array(
            'phone' => $data['phone'],
            'real_auth' => $real_auth
        );
        $ret2 = $this->update($user, array('uid' => $uid), LibTable::$sy_user);
        if ($ret1 && $ret2) {
            $this->commit();
            return true;
        } else {
            $this->rollBack();
            return false;
        }
    }

    /**
     * 直充补单列表
     * @param int $page
     * @param int $parent_id
     * @param int $game_id
     * @param int $device_type
     * @param string $package_name
     * @param int $pay_type
     * @param string $order_num
     * @param string $username
     * @param string $role_name
     * @return array
     */
    public function getOrderReplacementList($page = 0, $parent_id = 0, $game_id = 0, $device_type = 0, $package_name = '', $pay_type = 0, $order_num = '', $username = '', $role_name = '')
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = 'WHERE (a.`is_pay` = ' . PAY_STATUS['未支付'] . ' OR a.`is_notify` <> 1)';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $connection .= " AND c.`parent_id` = :parent_id";
        }
        if ($game_id > 0) {
            $param['game_id'] = $game_id;
            $connection .= " AND a.`game_id` = :game_id";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $connection .= " AND a.`device_type` = :device_type";
        }
        if ($package_name) {
            $param['package_name'] = $package_name;
            $connection .= " AND a.`package_name` = :package_name";
        }
        if ($pay_type) {
            $param['pay_type'] = $pay_type;
            $connection .= " AND a.`pay_type` = :pay_type";
        }
        if ($order_num) {
            $param['pt_order_num'] = $order_num;
            $connection .= " AND a.`pt_order_num` = :pt_order_num";
        }
        if ($username) {
            $param['username'] = $username;
            $connection .= " AND b.`username` = :username";
        }
        if ($role_name) {
            $param['role_name'] = $role_name;
            $connection .= " AND a.`role_name` = :role_name";
        }

        //权限
        $connection .= SrvAuth::getAuthSql('c.`parent_id`', 'a.`game_id`');

        $sql = "SELECT _FIELD_ 
                FROM `" . LibTable::$sy_order . "` a 
                LEFT JOIN `" . LibTable::$sy_user . "` b ON a.`uid`= b.`uid` 
                LEFT JOIN `" . LibTable::$sy_game . "` c ON a.`game_id` = c.`game_id` 
                {$connection}";
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        $data = [];
        if ($count > 0) {
            $field = 'a.*, b.`username`, c.`parent_id`';
            $_sql = str_replace('_FIELD_', $field, $sql) . " ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取配置表内容
     * @param string $module
     * @param string $key
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getConfig($module = '', $key = '', $page = 0, $page_num = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = '';
        if ($module) {
            $connection .= " AND `module` = :module";
            $param['module'] = $module;
        }
        if ($key) {
            $connection .= " AND `key` = :key";
            $param['key'] = $key;
        }

        $sql = "SELECT _FIELD_ FROM `" . LibTable::$config . "` a WHERE 1 {$connection}";

        $count = 0;
        $_sql = str_replace('_FIELD_', '*', $sql);

        if ($limit) {
            $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
            $count = (int)$row['c'];

            $_sql .= " ORDER BY id DESC $limit";
        }

        $data = $this->query($_sql, $param);
        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取安卓全部分包信息
     * @return array|bool|resource|string
     */
    public function getPackageAndroid()
    {
        $sql = "SELECT a.`game_id`, a.`package_name`, a.`down_url`, a.`package_md5`, a.`package_size`, b.`package_version`, b.`sdk_version`, b.`description`, b.`type` 
                FROM `" . LibTable::$sy_game_package . "` a 
                    LEFT JOIN `" . LibTable::$sy_game_update . "` b ON a.`game_id` = b.`game_id` AND a.`sdk_version` = b.`sdk_version` 
                WHERE a.platform = 2 ORDER BY a.id";
        return $this->query($sql);
    }

    /**
     * 获取该人员的游戏权限以及游戏对应的区服配置
     * @param int $author_id
     * @return array;
     */
    public function getGameServer($author_id)
    {
        ///获取账号下的游戏信息
        $sql = "select `auth_parent_id`,`auth_game_id` from `" . LibTable::$admin_user . "` where `admin_id`=:admin_id";
        $row = $this->getOne($sql, array('admin_id' => $author_id));
        return $row;
    }

    /**
     * 获取游戏对应的服务器配置
     * @param array $games
     * @return array
     */
    public function gameServers($games = array())
    {
        if (empty($games)) {
            $sql = "select * from `" . LibTable::$data_game_server . "` order by `game_id` asc,`server_id` asc";
        } else {
            $games = array_unique(array_filter($games));
            $sql = "select * from `" . LibTable::$data_game_server . "` where `game_id` in ('" . join("','", $games) . "') order by `game_id` asc,`server_id` asc";
        }
        $row = $this->query($sql);
        return $row;
    }

    /**
     * 删除用户
     * @param int $uid
     * @return bool
     */
    public function delUser($uid = 0)
    {
        $this->conn = 'main'; //主库
        $this->startWork();
        $ret1 = $this->delete(array('uid' => $uid), 1, LibTable::$sy_user); //用户表
        $ret2 = $this->delete(array('uid' => $uid), 1, LibTable::$sy_user_config); //用户扩展表
        $ret3 = $this->delete(array('uid' => $uid), 1, LibTable::$sy_real_auth); //实名认证表
        //$ret4 = $this->delete(array('uid' => $uid), 0, LibTable::$sy_order); //订单表
        $ret5 = $this->delete(array('uid' => $uid), 0, LibTable::$sy_gift); //礼包表
        if ($ret1 && $ret2 && $ret3 && $ret5) {
            $this->commit();

            $this->conn = 'default'; //从库
            $this->delete(array('uid' => $uid), 1, LibTable::$user_ext); //用户详细信息表
            $this->delete(array('uid' => $uid), 0, LibTable::$user_role); //角色表

            return true;
        } else {
            $this->rollBack();
            return false;
        }
    }

    /**
     * 激活日志
     * @param int $page
     * @param int $page_num
     * @param string $date
     * @param string $device_id
     * @param int $channel_id
     * @param int $game_id
     * @param int $parent_id
     * @param string $edate
     * @return array
     */
    public function activeLog($page = 1, $page_num = 0, $date = '', $device_id = '', $channel_id = 0, $game_id = 0, $parent_id = 0, $edate = '')
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $condition = '';
        if ($device_id) {
            $condition .= " AND a.`device_id` = :device_id";
            $param['device_id'] = $device_id;
        }
        if ($game_id > 0) {
            $condition .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($parent_id > 0) {
            $condition .= " AND b.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($channel_id > 0) {
            $condition .= " AND a.`channel_id` = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($date) {
            $condition .= " AND a.`active_date` >= :date";
            $param['date'] = $date;
        }
        if ($edate) {
            $condition .= " AND a.`active_date` <=:edate";
            $param['edate'] = $edate;
        }

        $data = [];
        $sql = "SELECT COUNT(*) AS c FROM `" . LibTable::$active . "` a 
                    LEFT JOIN sdk_data.`" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                WHERE 1 {$condition}";
        $row = $this->getOne($sql, $param);
        $count = (int)$row['c'];
        if ($count) {
            $sql = "SELECT a.*, b.`parent_id`, c.`name` AS monitor_name 
                    FROM `" . LibTable::$active . "` a 
                        LEFT JOIN sdk_data.`" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                        LEFT JOIN sdk_data.`" . LibTable::$ad_project . "` c ON a.`monitor_id` = c.`monitor_id` 
                    WHERE 1 {$condition} ORDER BY a.`id` DESC {$limit}";
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
     * @return array|bool|resource|string
     */
    public function getActiveLogInfo($id = 0)
    {
        return $this->commonGetOne(LibTable::$active, 'id', $id);
    }

    /**
     * 获取订单日志
     * @param string $pt_order_num
     * @return array|bool|resource|string
     */
    public function getOrderLog($pt_order_num = '')
    {
        return $this->commonGetOne(LibTable::$order_log, 'pt_order_num', $pt_order_num);
    }

    /**
     * 根据父ID获取子游戏信息
     * @param int $parent_id
     * @return array|bool|resource|string
     */
    public function getGamesListByPid($parent_id = 0)
    {
        $sql = "SELECT * FROM `" . LibTable::$sy_game . "` WHERE parent_id = :parent_id ORDER BY `game_id` DESC";
        return $this->query($sql, array('parent_id' => $parent_id));
    }

    /**
     * 获取所有平台
     * @return array|bool|resource|string
     */
    public function getAllPlatform()
    {
        return $this->query("SELECT * FROM `" . LibTable::$platform . "` ORDER BY `platform_id` DESC");
    }

    /**
     * 获取平台和游戏关系数据
     * @param int $page
     * @param int $game_id
     * @param int $platform_id
     * @return array
     */
    public function getPlatformGameList($page = 0, $game_id = 0, $platform_id = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $condition = '';
        $param = array();
        if ($game_id > 0) {
            if (is_array($game_id)) {
                $condition .= " AND a.`game_id` IN(" . implode(',', $game_id) . ")";
            } else {
                $condition .= " AND a.`game_id` = :game_id";
                $param['game_id'] = $game_id;
            }
        }
        if ($platform_id > 0) {
            if (is_array($platform_id)) {
                $condition .= " AND a.`platform_id` IN(" . implode(',', $platform_id) . ")";
            } else {
                $condition .= " AND a.`platform_id` = :platform_id";
                $param['platform_id'] = $platform_id;
            }
        }

        $data = array();
        $row = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$platform_game . "` a WHERE 1 {$condition}", $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $sql = "SELECT a.*, b.`parent_id`, b.`name` AS game_name, b.`alias` AS game_alias, b.`type`, b.`device_type`, 
                        b.`ratio`, b.`unit`, b.`status` AS game_lock, b.`is_login` AS ganme_is_login, b.`is_pay` AS game_is_pay, 
                        b.`config` AS game_config, c.`name` AS platform_name, c.`alias` AS platform_alias, c.`lock` AS platform_lock, 
                        c.`is_login` AS platform_is_login, c.`is_pay` AS platform_is_pay, c.`config` AS platform_config 
                    FROM `" . LibTable::$platform_game . "` a 
                        LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id 
                        LEFT JOIN `" . LibTable::$platform . "` c ON a.platform_id = c.platform_id 
                    WHERE 1 {$condition} ORDER BY a.`game_id` DESC, a.`platform_id` DESC {$limit}";
            $data = $this->query($sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取平台对应游戏信息
     * @param int $platform_id
     * @param int $game_id
     * @return array|bool|resource|string
     */
    public function getPlatformGameInfo($platform_id = 0, $game_id = 0)
    {
        $sql = "SELECT a.*, b.`parent_id`, b.`name` AS game_name, b.`alias` AS game_alias, b.`type`, b.`device_type`, 
                    b.`ratio`, b.`unit`, b.`status` AS game_lock, b.`is_login` AS ganme_is_login, b.`is_pay` AS game_is_pay, 
                    b.`config` AS game_config, c.`name` AS platform_name, c.`alias` AS platform_alias, c.`lock` AS platform_lock, 
                    c.`is_login` AS platform_is_login, c.`is_pay` AS platform_is_pay, c.`config` AS platform_config 
                FROM `" . LibTable::$platform_game . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id 
                    LEFT JOIN `" . LibTable::$platform . "` c ON a.platform_id = c.platform_id 
                WHERE a.`game_id` = :game_id AND a.`platform_id` = :platform_id";
        return $this->getOne($sql, array('game_id' => $game_id, 'platform_id' => $platform_id));
    }

    /**
     * 测试验证
     * @param string $keyword
     * @return array
     */
    public function acceptTest($keyword = '')
    {
        $active = $reg = $pay = $log = $upload = array();
        $modUserLog = new ModUserLog();

        if (in_array(strlen($keyword), array(14, 15, 36)) && !in_array($keyword, array('00000000-0000-0000-0000-000000000000', 'undefined', '000000000000000', 'null', '37a6259cc0c1dae299a7866489dff0bd'))) {//按设备号
            //取最新的激活信息
            $sql = "SELECT * FROM `" . LibTable::$active . "` WHERE `device_id` = :device_id ORDER BY `id` DESC";
            $active = $this->getOne($sql, array('device_id' => $keyword));

            if ($active['monitor_id'] > 0) {
                $sql = "SELECT * FROM `" . LibTable::$channel_upload_log . "` WHERE `monitor_id` = :monitor_id AND `upload_type` = 'active' AND (`source` = :source1 OR `source` = :source2) ORDER BY `id` DESC";
                $upload = $this->query($sql, array('monitor_id' => $active['monitor_id'], 'source1' => $active['device_id'], 'source2' => md5($active['device_id'])));
            }

            //根据设备号取最新的注册信息
            $sql = "SELECT * FROM `" . LibTable::$user_ext . "` WHERE `device_id` = :device_id ORDER BY `uid` DESC";
            $reg = $this->getOne($sql, array('device_id' => $keyword));
            $uid = (int)$reg['uid'];
            $monitor_id = (int)$reg['monitor_id'];
        } else {//按账号
            $sql = "SELECT * FROM `" . LibTable::$user_ext . "` WHERE `username` = :username ORDER BY `uid` DESC";
            $reg = $this->getOne($sql, array('username' => $keyword));
            $uid = (int)$reg['uid'];
            $device_id = $reg['device_id'];
            $monitor_id = (int)$reg['monitor_id'];

            if ($device_id && !in_array($device_id, array('00000000-0000-0000-0000-000000000000', 'undefined', '000000000000000', 'null', '37a6259cc0c1dae299a7866489dff0bd'))) {
                $sql = "SELECT * FROM `" . LibTable::$active . "` WHERE `device_id` = :device_id ORDER BY `id` DESC";
                $active = $this->getOne($sql, array('device_id' => $device_id));

                if ($active['monitor_id'] > 0) {
                    $sql = "SELECT * FROM `" . LibTable::$channel_upload_log . "` WHERE `monitor_id` = :monitor_id AND `upload_type` = 'active' AND (`source` = :source1 OR `source` = :source2) ORDER BY `id` DESC";
                    $upload = $this->query($sql, array('monitor_id' => $active['monitor_id'], 'source1' => $active['device_id'], 'source2' => md5($active['device_id'])));
                }
            }
        }

        if ($uid) {
            //根据账号取最新的充值信息
            $sql = "SELECT a.*, b.username, b.game_id AS reg_game_id FROM `" . LibTable::$sy_order . "` a LEFT JOIN `" . LibTable::$user_ext . "` b ON a.uid = b.uid WHERE a.`uid` = :uid ORDER BY a.`id` DESC LIMIT 10";
            $pay = $this->query($sql, array('uid' => $uid));

            $order_id = array();
            foreach ($pay as $row) {
                $order_id[] = $row['pt_order_num'];
            }

            if ($monitor_id > 0) {
                $sql = "SELECT * FROM `" . LibTable::$channel_upload_log . "` WHERE `monitor_id` = :monitor_id AND `upload_type` = 'reg' AND `source` = :source ORDER BY `id` DESC";
                $tmp = $this->query($sql, array('monitor_id' => $monitor_id, 'source' => $uid));
                $upload = array_merge($upload, $tmp);

                if (!empty($order_id)) {
                    $sql = "SELECT * FROM `" . LibTable::$channel_upload_log . "` WHERE `monitor_id` = :monitor_id AND `upload_type` = 'pay' AND `source` IN(:source) ORDER BY `id` DESC";
                    $tmp = $this->query($sql, array('monitor_id' => $monitor_id, 'source' => $order_id));
                    $upload = array_merge($upload, $tmp);
                }
            }

            $map = array(
                'parent_id' => '母游戏ID',
                'game_id' => '游戏ID',
                'channel_id' => '渠道ID',
                'package_name' => '游戏包',
                'package_version' => '包版本',
                'sdk_version' => 'SDK版本',
                'device_type' => '平台标识',
                'device_id' => '设备号',
                'uuid' => 'UUID',
                'ip' => 'IP',
                'ua' => '浏览器标识',
                'device_name' => '设备型号',
                'device_version' => '系统版本',
                'os_flag' => '系统标识',
                'resolution' => '分辨率',
                'producer' => '设备厂商',
                'isp' => '网络运营商',
                'network_type' => '网络类型',
                'time' => '时间戳',
                'uid' => 'UID',
                'openid' => '第三方账号',
                'phone' => '手机号',
                'type' => '类型',
                'username' => '账号',
                'password' => '密码',
                'reg_type' => '注册类型',
                'reg_city' => '注册地区',
                'reg_ip' => '注册IP',
                'reg_time' => '注册时间',
                'server_id' => '服务器ID',
                'server_name' => '服务器名称',
                'role_id' => '角色ID',
                'role_name' => '角色名称',
                'role_level' => '角色等级',
                'update_time' => '更新时间',
                'login_ip' => '登录IP',
                'login_time' => '登录时间',
                'pt_order_num' => '平台订单号',
                'cp_order_num' => 'CP订单号',
                'total_fee' => '金额',
            );

            $info = $modUserLog->getLastLog($uid);
            foreach ($info as &$row) {
                $tmp = json_decode($row['content'], true);
                if (!empty($tmp)) {
                    ksort($tmp);
                    $content = array();
                    foreach ($tmp as $key => $val) {
                        if (isset($map[$key])) {
                            $content[$map[$key]] = $val;
                        } else {
                            $content[$key] = $val;
                        }
                    }
                    $row['content'] = json_encode($content, JSON_UNESCAPED_UNICODE);
                }
            }

            $log = $info;
        }

        return array(
            'active' => $active,
            'reg' => $reg,
            'pay' => $pay,
            'log' => $log,
            'upload' => $upload
        );
    }

    /**
     * 获取没有被使用，且游戏已经关闭的分包列表
     * @return array|bool|resource|string
     */
    public function getAbandonPackageList()
    {
        $sql = "SELECT a.* FROM `" . LibTable::$sy_game_package . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id` = b.`game_id` 
                    LEFT JOIN `" . LibTable::$ad_project . "` c ON a.`package_name` = c.`package_name` 
                WHERE a.`del` = 0 AND b.`status` = 1 AND c.`package_name` IS NULL 
                ORDER BY a.`id` DESC";
        return $this->query($sql);
    }

    /**
     * 获取游戏扩展信息
     * @param $game_id
     * @return array|bool|resource|string
     */
    public function getSupport($game_id)
    {
        $sql = "SELECT a.*, b.`name` AS game_name FROM `" . LibTable::$sy_game_ext . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id 
                WHERE a.game_id = :game_id";
        return $this->getOne($sql, array('game_id' => $game_id));
    }
}