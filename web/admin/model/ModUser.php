<?php

class ModUser extends Model
{
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

    /**
     * 更新主库用户信息
     * @param $uid
     * @param $data
     * @return resource|string
     */
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
     * 指定用户的关联IP/设备号列表
     * @param string $type
     * @param int $uid
     * @param string $group_name
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getUserRelateList($type = '', $uid = 0, $group_name = '', $page = 1, $page_num = 10)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $_type = array(
            'ip' => 1,
            'device' => 2,
            'user' => 3
        );

        $param = array(
            'uid' => $uid
        );
        $condition = 'WHERE uid = :uid';

        if ($type == 'device') {
            $condition .= " AND `device_id` <> '' AND `device_id` <> '00000000-0000-0000-0000-000000000000' AND `device_id` <> '000000000000000' AND `device_id` <> 'null'";
        }

        $sql = "SELECT `{$group_name}` AS `group_name` FROM `" . LibTable::$login_log . "` {$condition} GROUP BY `group_name`";

        $data = [];
        $row = $this->getOne("SELECT COUNT(*) AS c FROM ({$sql}) tmp ", $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $param['type'] = $_type[$type];

            $_sql = "SELECT a.`group_name`, a.`count`, b.`handle`, c.`content` 
                    FROM (
                        SELECT `{$group_name}` AS `group_name`, COUNT(DISTINCT `uid`) `count` 
                        FROM `" . LibTable::$login_log . "` 
                        WHERE `{$group_name}` IN(SELECT `group_name` FROM ({$sql} {$limit}) tmp) 
                        GROUP BY `group_name`
                    ) a 
                        LEFT JOIN `" . LibTable::$forbidden . "` b ON b.`type` = :type AND a.`group_name` = b.`content` 
                        LEFT JOIN `" . LibTable::$forbidden_white . "` c ON c.`type` = :type AND a.`group_name` = c.`content` 
                    ORDER BY a.`count` DESC, a.`group_name`";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 查询对应IP/设备号的关联账号
     * @param string $content
     * @param string $group_name
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getUserRelateInfo($content = '', $group_name = '', $page = 1, $page_num = 10)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = array(
            'content' => $content
        );
        $sql = "SELECT DISTINCT uid FROM `" . LibTable::$login_log . "` WHERE {$group_name} = :content";

        $data = [];
        $row = $this->getOne("SELECT COUNT(*) AS c FROM ({$sql}) tmp ", $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $_sql = "SELECT a.`uid`, b.`status`, c.`username`, c.`reg_ip`, c.`reg_time`, c.`last_login_ip`, c.`last_login_time`, d.`total_pay_money`, e.`content` 
                    FROM ({$sql} {$limit}) a 
                        LEFT JOIN `" . LibTable::$sy_user . "` b ON a.uid = b.uid 
                        LEFT JOIN `" . LibTable::$user_ext . "` c ON a.uid = c.uid 
                        LEFT JOIN `" . LibTable::$sy_user_config . "` d ON a.uid = d.uid 
                        LEFT JOIN `" . LibTable::$forbidden_white . "` e ON e.`type` = 3 AND a.`uid` = e.`content` 
                    ORDER BY d.total_pay_money DESC, a.uid";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 封禁/解封
     * @param $data
     * @return array|bool
     */
    public function banHandle($data)
    {
        $error = array();
        foreach ($data as $row) {
            $status = $row['handle'] == '' ? 0 : 1;
            if ($row['type'] == 3) {
                $ret = $this->updateUserInfo($row['content'], array('status' => $status));
                if (!$ret) {
                    $error[$row['type']][] = $row['content'];
                    continue;
                }
            }

            //重新指定为从库
            $this->conn = 'default';

            if ($row['handle'] == '') { //删除
                $ret = $this->delData(LibTable::$forbidden, array('type' => $row['type'], 'content' => $row['content']));
                if (!$ret) {
                    $error[$row['type']][] = $row['content'];
                    continue;
                }

                if ($row['type'] != 3) {
                    $cache_key = $row['type'] == 1 ? LibRedis::$prefix_forbidden_ip : LibRedis::$prefix_forbidden_device;
                    LibRedis::delete($cache_key . $row['content']);
                }
            } else {
                $insert = array(
                    'type' => $row['type'],
                    'content' => $row['content'],
                    'notes' => $row['notes'],
                    'handle' => $row['handle'],
                    'time' => $row['time'],
                    'admin' => $row['admin'],
                );

                $update = array(
                    'handle' => $row['handle'],
                );
                $row['notes'] && $update['notes'] = $row['notes'];
                $row['time'] && $update['time'] = $row['time'];

                $ret = $this->insertOrUpdate($insert, $update, LibTable::$forbidden);
                if (!$ret) {
                    $error[$row['type']][] = $row['content'];
                    continue;
                }

                if ($row['type'] != 3) {
                    $cache_key = $row['type'] == 1 ? LibRedis::$prefix_forbidden_ip : LibRedis::$prefix_forbidden_device;
                    LibRedis::set($cache_key . $row['content'], $row['handle']);
                }
            }
        }

        return $error;
    }

    /**
     * 获取封禁列表
     * @param string $type
     * @param string $keyword
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getForbiddenList($type = '', $keyword = '', $page = 1, $page_num = 10)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $_type = array(
            'ip' => 1,
            'device' => 2,
            'user' => 3
        );

        $param = array(
            'type' => $_type[$type]
        );
        $condition = " WHERE a.`type` = :type";

        if ($keyword) {
            $condition .= " AND a.`content` = :content";
            $param['content'] = $keyword;
        }

        $sql = "SELECT _FIELD_ FROM `" . LibTable::$forbidden . "` a";

        $data = [];
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql . $condition), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            if ($type == 'user') {
                $_sql = str_replace('_FIELD_', "a.*, b.`username`, c.`name` AS admin_name", $sql);
                $_sql .= " LEFT JOIN `" . LibTable::$user_ext . "` b ON a.`content` = b.`uid`";
            } else {
                $_sql = str_replace('_FIELD_', "a.*, c.`name` AS admin_name", $sql);
            }

            $_sql .= " LEFT JOIN `" . LibTable::$admin_user . "` c ON a.`admin` = c.`user`";
            $_sql .= $condition . " ORDER BY a.`time` DESC, a.`content` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 查询用户信息
     * @param $username
     * @return array|bool|resource|string
     */
    public function getUserUid($username)
    {
        $condition = '';
        if (is_array($username)) {
            $condition .= " AND username IN(:username)";
            $param['username'] = $username;
        } else {
            $condition .= " AND username = :username";
            $param['username'] = $username;
        }

        $sql = "SELECT `uid`, `username` FROM `" . LibTable::$sy_user . "` WHERE 1 {$condition}";
        return $this->query($sql, $param);
    }

    /**
     * 获取关联账号排行列表
     * @param string $type
     * @param int $num
     * @param int $show_whitelist
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getRelateHotList($type = '', $num = 10, $show_whitelist = 0, $page = 1, $page_num = 10)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $_type = array(
            'ip' => 1,
            'device' => 2,
        );

        $group = array(
            'ip' => 'login_ip',
            'device' => 'device_id',
        );
        $group_name = $group[$type];

        $condition = '';
        if ($type == 'device') {
            $condition = " AND a.`device_id` <> '' AND a.`device_id` <> '00000000-0000-0000-0000-000000000000' AND a.`device_id` <> '000000000000000' AND a.`device_id` <> 'null'";
        }

        if (!$show_whitelist) {
            $condition .= " AND c.`content` IS NULL";
        }

        $sql = "SELECT a.`{$group_name}` AS `group_name`, COUNT(DISTINCT a.`uid`) `count`, b.`handle`, c.`content` 
                FROM `" . LibTable::$login_log . "` a 
                    LEFT JOIN `" . LibTable::$forbidden . "` b ON b.`type` = '{$_type[$type]}' AND a.`{$group_name}` = b.`content` 
                    LEFT JOIN `" . LibTable::$forbidden_white . "` c ON c.`type` = '{$_type[$type]}' AND a.`{$group_name}` = c.`content` 
                WHERE 1 {$condition} GROUP BY `group_name` HAVING `count` >= '{$num}'";

        $data = [];
        $row = $this->getOne("SELECT COUNT(*) AS c FROM ({$sql}) tmp ");
        $count = (int)$row['c'];
        if ($count > 0) {
            $data = $this->query($sql . " ORDER BY `count` DESC {$limit}");
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }
}