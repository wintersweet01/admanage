<?php

class ModExtend extends Model
{

    public function landHeatMap($model_id)
    {
        $sql = "select * from " . LibTable::$data_land_heat_map . " where model_id = {$model_id}";
        $info['list'] = $this->query($sql);
        $sql_url = "select model_url from " . LibTable::$land_model . " where model_id = {$model_id}";
        $url = $this->getOne($sql_url);
        $info['url'] = LAND_MODEL_URL . $url['model_url'] . '/';
        return $info;
    }

    public function getLinkList($is_excel = 0, $page, $parent_id, $game_id, $package_name, $channel_id, $keyword, $user_id, $create_user, $status = 0, $page_num = 0)
    {
        $limit = '';
        if ($is_excel == 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }
        $param = [];
        $connection = 'WHERE 1';
        if ($status !== '') {
            $connection .= " AND a.`status` = :status";
            $param['status'] = $status;
        }
        if ($parent_id > 0) {
            $connection .= " AND e.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id > 0) {
            $connection .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($package_name) {
            $connection .= " AND a.`package_name` = :package_name";
            $param['package_name'] = $package_name;
        }
        if ($channel_id) {
            $connection .= " AND a.`channel_id` = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($user_id) {
            $connection .= " AND a.`user_id` = :user_id";
            $param['user_id'] = $user_id;
        }
        if ($create_user) {
            $connection .= " AND a.`create_user` = :create_user";
            $param['create_user'] = $create_user;
        }
        if ($keyword) {
            if (is_numeric($keyword)) {
                $connection .= " AND a.`monitor_id` = :keyword";
                $param['keyword'] = $keyword;
            } else {
                $connection .= " AND (a.`name` LIKE :keyword OR a.`package_name` LIKE :keyword)";
                $param['keyword'] = "%{$keyword}%";
            }
        }

        //权限
        $connection .= SrvAuth::getAuthSql('e.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'a.`user_id`');

        $sql = "SELECT _FIELD_ 
                FROM `" . LibTable::$ad_project . "` a 
                LEFT JOIN `" . LibTable::$sy_game_package . "` b ON a.`package_name` = b.`package_name` 
                LEFT JOIN `" . LibTable::$channel_user . "` c ON a.`user_id` = c.`user_id` 
                LEFT JOIN `" . LibTable::$admin_user . "` d ON a.`create_user` = d.`user` 
                LEFT JOIN `" . LibTable::$sy_game . "` e ON a.`game_id` = e.`game_id` 
                {$connection} ";
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        $data = [];
        if ($count > 0) {
            $_sql = str_replace('_FIELD_', 'a.*, b.`platform`, b.`down_url`, c.`domain`, c.`download_domain`, d.`name` AS `administrator`, e.`parent_id`', $sql) . " ORDER BY a.`monitor_id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function getAllLink($monitor_id = 0)
    {
        $param = [];
        $connection = 'WHERE a.`status` = 0';
        if ($monitor_id > 0) {
            $connection .= " AND a.`monitor_id` = :monitor_id";
            $param['monitor_id'] = $monitor_id;
        }

        $sql = "SELECT a.*, b.`page_url`, b.`model_id`, b.`jump_model`, c.`platform` AS `device_type`, c.`down_url`, d.`domain`, d.`download_domain`, e.`channel_name`, e.`channel_short` 
                FROM `" . LibTable::$ad_project . "` a 
                LEFT JOIN `" . LibTable::$land_page . "` b ON a.`page_id` = b.`page_id` 
                LEFT JOIN `" . LibTable::$sy_game_package . "` c ON a.`package_name` = c.`package_name` 
                LEFT JOIN `" . LibTable::$channel_user . "` d ON a.`user_id` = d.`user_id` 
                LEFT JOIN `" . LibTable::$channel . "` e ON a.`channel_id` = e.`channel_id` 
                {$connection} ORDER BY a.`monitor_id` DESC";
        return $this->query($sql, $param);
    }

    /**
     * 推广链回调日志
     * @param int $page
     * @param int $monitor_id
     * @param string $type
     * @param string $sdate
     * @param string $edate
     * @param string $keyword
     * @param int $is_excel
     * @return array
     */
    public function getChannelLog($page = 0, $monitor_id = 0, $type = '', $sdate = '', $edate = '', $keyword = '', $is_excel = 0)
    {
        $limit = '';
        if ($is_excel == 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = array();
        $condition = '';

        if ($monitor_id) {
            $param['monitor_id'] = $monitor_id;
            $condition .= " AND a.`monitor_id` = :monitor_id";
        } elseif ($keyword) {
            if (is_numeric($keyword)) {
                $param['keyword'] = $keyword;
                $condition .= " AND a.`monitor_id` = :keyword";
            } else {
                $param['keyword'] = "%{$keyword}%";
                $condition .= " AND b.`name` LIKE :keyword";
            }
        }

        if ($type) {
            $param['type'] = $type;
            $condition .= " AND a.`upload_type` = :type";
        }
        if ($sdate) {
            $param['sdate'] = strtotime($sdate);
            $condition .= " AND a.`upload_time` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = strtotime($edate) + 86400;
            $condition .= " AND a.`upload_time` < :edate";
        }

        $sql = "SELECT _FIELD_ 
                FROM `" . LibTable::$channel_upload_log . "` a 
                    LEFT JOIN ad_project b ON a.`monitor_id` = b.`monitor_id` 
                WHERE 1 {$condition}";

        $data = [];
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $field = "a.*, b.`name` AS `monitor_name`";
            $_sql = str_replace('_FIELD_', $field, $sql) . " ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function getLandPageInfo($page_id)
    {
        return $this->commonGetOne(LibTable::$land_page, 'page_id', $page_id);
    }

    public function getLandToday($page_id)
    {
        $date = date('Y-m-d');
        $sql = "select * from `" . LibTable::$table_land_tj_date . "` where `page_id`=:page_id and `date`=:date";
        return $this->getOne($sql, array('page_id' => $page_id, 'date' => $date));
    }

    public function getLinkInfo($monitor_id)
    {
        $sql = "SELECT a.*, b.`page_url`, c.`platform` AS device_type, c.`down_url` 
                FROM `" . LibTable::$ad_project . "` a 
                LEFT JOIN `" . LibTable::$land_page . "` b ON a.`page_id` = b.`page_id` 
                LEFT JOIN `" . LibTable::$sy_game_package . "` c ON a.`package_name` = c.`package_name` 
                WHERE a.`monitor_id` = :monitor_id";
        return $this->getOne($sql, array('monitor_id' => $monitor_id));
    }

    public function getLinkInfoBatch($monitor_ids)
    {
        $monitor_ids = array_unique(array_filter($monitor_ids));
        if (empty($monitor_ids)) return array();
        $sql = "SELECT a.*, b.`page_url`, c.`platform` AS device_type, c.`down_url` 
                FROM `" . LibTable::$ad_project . "` a 
                LEFT JOIN `" . LibTable::$land_page . "` b ON a.`page_id` = b.`page_id` 
                LEFT JOIN `" . LibTable::$sy_game_package . "` c ON a.`package_name` = c.`package_name` 
                WHERE a.`monitor_id` IN ('" . join("','", $monitor_ids) . "')";
        return $this->query($sql, $monitor_ids);
    }

    public function getSameName($name, $monitor_id)
    {
        $sql = "select * from `" . LibTable::$ad_project . "` where (`name` = :name or `name` like :name2) ";
        if ($monitor_id) {
            $sql .= " and `monitor_id` != :monitor_id ";
        }
        return $this->getOne($sql, array('name' => $name, 'name2' => $name . '-%', 'monitor_id' => $monitor_id));
    }

    public function getSamePackage($package_name, $monitor_id)
    {
        $sql = "select * from `" . LibTable::$ad_project . "` where `package_name` = :package_name ";
        if ($monitor_id) {
            $sql .= " and `monitor_id` != :monitor_id ";
        }
        return $this->getOne($sql, array('package_name' => $package_name, 'monitor_id' => $monitor_id));
    }

    public function updateLinkAction($monitor_id, $data)
    {
        $where = array(
            'monitor_id' => $monitor_id,
        );
        return $this->update($data, $where, LibTable::$ad_project);
    }

    public function getUserByChannel($channel_id)
    {
        $condition = SrvAuth::getAuthSql(false, false, 'channel_id', 'user_id');
        $sql = "select * from `" . LibTable::$channel_user . "` where `channel_id` = :channel_id {$condition}";
        return $this->query($sql, array('channel_id' => $channel_id));
    }

    public function addLinkAction($data)
    {
        $ids = [];
        foreach ($data as $v) {
            $ids[] = $this->insert($v, true, LibTable::$ad_project);
        }
        return $ids;
    }

    public function delLink($monitor_id)
    {
        $this->delete(array('monitor_id' => array('=', $monitor_id)), 1, LibTable::$ad_project);
        return $this->affectedRows();
    }

    public function getAllPage($company_id = 0)
    {
        $sql = "select a.`page_id`,a.`page_name`,a.`page_url` from `" . LibTable::$land_page . "` as a ";
        if ($company_id) {
            $sql .= " ,`" . LibTable::$land_model . "` as b where a.`model_id`=b.`model_id` and b.`company_id`=:company_id";
            $param = array(
                'company_id' => $company_id,
            );
        }
        return $this->query($sql, $param);
    }

    public function getPages($company_id, $game, $package_name)
    {
        $sql = "select a.`page_id`,a.`page_name`,a.`page_url` from `" . LibTable::$land_page . "` as a ,`" . LibTable::$land_model . "` as b where a.`model_id`=b.`model_id` ";
        $param = array();
        if ($company_id) {
            $sql .= " and b.`company_id`=:company_id ";
            $param['company_id'] = $company_id;
        }
        if ($game) {
            $sql .= " and b.`game_id`=:game_id ";
            $param['game_id'] = $game;
        }
        if ($package_name) {
            $sql .= " and a.`package_name`=:package_name ";
            $param['package_name'] = $package_name;
        }
        return $this->query($sql, $param);
    }

    public function delLandModel($model_id)
    {
        $this->delete(array('model_id' => array('=', $model_id)), 1, LibTable::$land_model);
        return $this->affectedRows();
    }

    public function getLandModelInfo($model_id)
    {
        return $this->commonGetOne(LibTable::$land_model, 'model_id', $model_id);
    }

    public function getUseModelCount($model_id)
    {
        $sql = "select count(*) `total` from `" . LibTable::$land_page . "` where `model_id`=:model_id";
        return $this->getOne($sql, array('model_id' => $model_id));
    }

    public function getLandModelList($game_id = 0, $page = 0, $page_num = 0)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num);
        }

        $param = [];
        $connection = 'WHERE 1';
        if ($game_id > 0) {
            $connection .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }

        $sql = "SELECT a.*, b.`count` FROM `" . LibTable::$land_model . "` a 
                LEFT JOIN (SELECT `model_id`, COUNT(*) `count` FROM `" . LibTable::$land_page . "` a {$connection} GROUP BY `model_id`) b 
                ON a.`model_id` = b.`model_id` {$connection} 
                ORDER BY `model_id` DESC {$limit}";
        $sql_count = "SELECT COUNT(*) AS c FROM `" . LibTable::$land_model . "` a {$connection}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    /**
     * 按模板使用数量排序
     * @param int $game_id
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getLandModelListBySort($game_id = 0, $page = 0, $page_num = 0, $sort = '')
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num);
        }

        $param = [];
        $connection = 'WHERE 1';
        if ($game_id > 0) {
            $connection .= " AND `game_id` = :game_id";
            $param['game_id'] = $game_id;
        }

        if ($sort == 'use') {
            $sql = "SELECT a.*, b.`count` FROM `" . LibTable::$land_model . "` a 
                    LEFT JOIN (SELECT `model_id`, COUNT(*) `count` FROM `" . LibTable::$land_page . "` {$connection} GROUP BY `model_id`) b 
                    ON a.`model_id` = b.`model_id` {$connection} 
                    ORDER BY `count` DESC {$limit}";
        } elseif ($sort == 'click') {
            $sql = "SELECT a.*, b.`count` FROM `" . LibTable::$land_model . "` a 
                    LEFT JOIN (SELECT `model_id`, COUNT(*) `count` FROM `" . LibTable::$data_land_heat_map . "` GROUP BY `model_id`) b 
                    ON a.`model_id` = b.`model_id` {$connection} 
                    ORDER BY `count` DESC {$limit}";
        }

        $row = $this->getOne("SELECT COUNT(*) c FROM `" . LibTable::$land_model . "` {$connection}", $param);
        if (empty($row['c'])) {
            return [];
        }

        return array(
            'list' => $this->query($sql, $param),
            'total' => $row['c'],
        );
    }

    public function delLandPageAction($page_id)
    {
        $this->delete(array('page_id' => array('=', $page_id)), 1, LibTable::$land_page);
        return $this->affectedRows();
    }

    public function updateLandPageAction($page_id, $data)
    {
        $where = array(
            'page_id' => $page_id,
        );
        return $this->update($data, $where, LibTable::$land_page);
    }

    public function addLandPageAction($data)
    {
        return $this->insert($data, true, LibTable::$land_page);
    }

    public function getLinkInfoByCode($code)
    {
        return $this->commonGetOne(LibTable::$ad_project, 'monitor_url', $code);
    }

    public function getLandHourCountList($page, $code)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select * from `" . LibTable::$table_land_tj_hour_code . "` where `code`=:code ";
        $sql_count = "select count(*) as c from `" . LibTable::$table_land_tj_hour_code . "` where `code`=:code ";
        $sql .= " order by `id` desc {$limit}";
        $param = array(
            'code' => $code,
        );
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function getLandCountList($page, $page_id)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select * from `" . LibTable::$table_land_tj_date . "` where `page_id`=:page_id ";
        $sql_count = "select count(*) as c from `" . LibTable::$table_land_tj_date . "` where `page_id`=:page_id ";
        $sql .= " order by `id` desc {$limit}";
        $param = array(
            'page_id' => $page_id,
        );
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function getLandPageList($page, $game_id, $model_id, $company_id, $name)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select * from `" . LibTable::$land_page . "` where 1 ";
        $sql_count = "select count(*) as c from `" . LibTable::$land_page . "` where 1 ";

        $param = array();
        if ($model_id) {
            $param['model_id'] = $model_id;
            $sql .= " and `model_id` = :model_id ";
            $sql_count .= " and `model_id` = :model_id ";
        }

        if ($game_id) {
            $param['game_id'] = $game_id;
            $sql .= " and `game_id` = :game_id ";
            $sql_count .= " and `game_id` = :game_id ";
        }

        if ($company_id) {
            $param['company_id'] = $company_id;
            $sql .= " and `company_id` = :company_id ";
            $sql_count .= " and `company_id` = :company_id ";
        }

        if ($name) {
            $param['name'] = '%' . $name . '%';
            $sql .= " and `page_name` like :name ";
            $sql_count .= " and `page_name` like :name ";
        }

        $sql .= " order by `page_id` desc {$limit}";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c'],
        );
    }

    public function updateLandModel($model_id, $data)
    {
        $where = array(
            'model_id' => $model_id,
        );
        return $this->update($data, $where, LibTable::$land_model);
    }

    public function addLandModel($data)
    {
        return $this->insert($data, true, LibTable::$land_model);
    }

    public function modifyLandPageAllAction($ids, $data)
    {
        if (empty($data)) {
            return false;
        }

        return $this->update($data, array('monitor_id' => $ids), LibTable::$ad_project);
    }

    public function userExcel($i)
    {
        switch ($i) {
            case 0 :
                $where = " and a.`uid` < 40000  ";
                break;
            case 1 :
                $where = " and a.`uid` >= 40000 and a.`uid` <= 80000";
                break;
            case 2 :
                $where = " and a.`uid` > 80000 ";
                break;
        }
        $sql = "select a.uid,b.device_id from `" . LibTable::$sy_user . "` a left join `" . LibTable::$user_ext . "` b on a.`uid`=b.`uid` where 1 and device_type = 2 " . $where;
        $data = LibModDefault::getInstance()->query($sql);

        foreach ($data as $key => $val) {
            $sql = "select sum(`pays`) `pay_money` from `" . LibTable::$user_role . "` where `uid`=:uid";
            $pay_money = LibModDefault::getInstance()->getOne($sql, array('uid' => $val['uid']));
            $data[$key]['pay_money'] = $pay_money['pay_money'];
        }
        $info = array();
        foreach ($data as $key => $val) {
            $info[$val['device_id']]['pay_money'] += $val['pay_money'];
        }
        unset($data);
        $headerArray = array(
            '设备号', '总充值'
        );
        $excel_data = array();

        foreach ($info as $key => $u) {
            $excel_data[] = array(
                ' ' . $key, '￥' . $u['pay_money'] / 100
            );
        }
        $filename = '设备-充值' . '(' . ($i + 1) . ')';
        return array(
            'filename' => $filename,
            'headerArray' => $headerArray,
            'data' => $excel_data
        );
    }

    public function getModelName($page_id)
    {
        $sql = "select m.`model_name` from " . LibTable::$land_page . " as p left join " . LibTable::$land_model . " as m on m.model_id = p.model_id where `page_id`=$page_id ";
        $name = $this->getOne($sql);
        return $name['model_name'];
    }

    public function getLandPageInfoByPageUrl($page_url)
    {
        $result = $this->commonGetOne(LibTable::$land_page, 'page_url', $page_url);
        return $result;
    }

    public function getLandPageInfoByModel($model_id)
    {
        $sql = "select * from `" . LibTable::$land_page . "` where `model_id` = :model_id";
        return $this->query($sql, array('model_id' => $model_id));
    }

    public function costUploadList($page = 0, $page_num = 0, $parent_id, $game_id = 0, $package_name = '', $channel_id = 0, $create_user = '', $date = '')
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = 'WHERE 1';
        if ($parent_id) {
            $connection .= " and b.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id) {
            $connection .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($package_name) {
            $connection .= " AND a.`package_name` = :package_name";
            $param['package_name'] = $package_name;
        }
        if ($channel_id) {
            $connection .= " AND a.`channel_id` = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($create_user) {
            $connection .= " AND d.`create_user` = :create_user";
            $param['create_user'] = $create_user;
        }
        if ($date) {
            $connection .= " AND a.`date` = :date";
            $param['date'] = $date;
        }

        //权限
        $connection .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'd.`user_id`');

        $sql = "SELECT _FIELD_ "
            . "FROM `" . LibTable::$data_upload . "` a "
            . "LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id "
            . "LEFT JOIN `" . LibTable::$channel . "` c ON a.channel_id = c.channel_id "
            . "LEFT JOIN `" . LibTable::$ad_project . "` d ON a.monitor_id = d.monitor_id "
            . "{$connection}";

        $data = [];
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $field = "b.`parent_id`, b.`name` AS game_name, c.`channel_name`, d.`name` AS monitor_name, TRUNCATE(a.`cost` / 100, 2) AS cost_yuan, a.*";
            $_sql = str_replace('_FIELD_', $field, $sql) . " ORDER BY a.`date` DESC, a.`game_id`, a.`package_name` {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function costUploadDel($id = '')
    {
        $this->delete(array('id' => explode(',', $id)), 0, LibTable::$data_upload);
        return $this->affectedRows();
    }

    public function costUploadEdit($field = '', $value = 0, $data = [])
    {
        $insert[$field] = $value;
        $update = $insert;

        $insert['date'] = $data['date'];
        $insert['monitor_id'] = $data['monitor_id'];
        $insert['game_id'] = $data['game_id'];
        $insert['package_name'] = $data['package_name'];
        $insert['device_type'] = $data['device_type'];
        $insert['channel_id'] = $data['channel_id'];
        $this->insertOrUpdate($insert, $update, LibTable::$data_upload);
        return $this->affectedRows();
    }

    /**
     * 根据游戏和渠道获取已使用的包名
     * @param $game_id
     * @param $channel_id
     * @return array|bool|resource|string
     */
    public function getLinkPackageName($game_id, $channel_id)
    {
        $param = [];
        $connection = '';
        if ($game_id > 0) {
            $connection .= " AND game_id = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $connection .= " AND channel_id = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        $sql = "SELECT `package_name`, `game_id`, `channel_id` FROM `" . LibTable::$ad_project . "` ORDER BY `package_name` DESC";
        return $this->query($sql, $param);
    }

    /**
     * 获取推广链扣量信息
     * @param $monitor_id
     * @return array|bool|resource|string
     */
    public function getAdDiscount($monitor_id)
    {
        $sql = "SELECT a.*, b.`name` AS monitor_name 
                FROM `" . LibTable::$ad_discount . "` a 
                    LEFT JOIN `" . LibTable::$ad_project . "` b ON a.monitor_id = b.monitor_id 
                WHERE a.monitor_id = :monitor_id";
        return $this->getOne($sql, array('monitor_id' => $monitor_id));
    }

    public function getAdDiscountList($parent_id, $game_id, $channel_id, $create_user, $keyword, $page = 0, $page_num = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $condition = '';
        if ($parent_id > 0) {
            $condition .= " AND c.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id > 0) {
            $condition .= " AND b.game_id = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $condition .= " AND b.channel_id = :channel_id";
            $param['channel_id'] = $channel_id;
        }
        if ($create_user) {
            $condition .= " AND b.create_user = :create_user";
            $param['create_user'] = $create_user;
        }
        if ($keyword) {
            if (is_numeric($keyword)) {
                $condition .= " AND a.`monitor_id` = :keyword";
                $param['keyword'] = $keyword;
            } else {
                $condition .= " AND (b.`name` LIKE :keyword OR b.`package_name` LIKE :keyword)";
                $param['keyword'] = "%{$keyword}%";
            }
        }

        //权限
        $condition .= SrvAuth::getAuthSql('c.`parent_id`', 'b.`game_id`', 'b.`channel_id`', 'b.`user_id`');

        $sql = "SELECT _FIELD_ 
                FROM `" . LibTable::$ad_discount . "` a 
                    LEFT JOIN `" . LibTable::$ad_project . "` b ON a.monitor_id = b.monitor_id 
                    LEFT JOIN `" . LibTable::$sy_game . "` c ON b.`game_id` = c.`game_id` 
                    LEFT JOIN `" . LibTable::$admin_user . "` d ON b.`create_user` = d.`user` 
                    LEFT JOIN `" . LibTable::$channel . "` e ON b.channel_id = e.channel_id
                WHERE 1 {$condition}";
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        $data = [];
        if ($count > 0) {
            $_sql = str_replace('_FIELD_', 'a.*, b.`name` AS monitor_name, b.`package_name`, b.`game_id`, c.`parent_id`, d.`name` AS `administrator`, e.`channel_name`', $sql) . " ORDER BY a.`monitor_id` DESC {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function linkDiscountDel($id = '')
    {
        $this->delete(array('monitor_id' => explode(',', $id)), 0, LibTable::$ad_discount);
        return $this->affectedRows();
    }

    public function getAdDiscountAll()
    {
        return $this->query("SELECT * FROM `" . LibTable::$ad_discount . "` ORDER BY `monitor_id` ASC");
    }

    public function getAsoDiscountAll()
    {
        return $this->query("SELECT * FROM `" . LibTable::$aso_discount . "` ORDER BY `game_id` ASC");
    }

    public function SplitManageList($parent_id, $game_id, $channel_id, $month, $page, $page_num)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = 'WHERE 1';
        if ($parent_id) {
            $connection .= " and b.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($game_id) {
            $connection .= " AND a.`game_id` = :game_id";
            $param['game_id'] = $game_id;
        }
        if ($channel_id) {
            $connection .= " AND a.`channel_id` = :channel_id";
            $param['channel_id'] = $channel_id;
        }

        if ($month) {
            $connection .= " AND a.`month` = :month";
            $param['month'] = date('Y/m', strtotime($month));
        }
        //权限
        $connection .= SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', 'a.`channel_id`', 'd.`user_id`');

        $sql = "SELECT _FIELD_ "
            . "FROM `" . LibTable::$data_split_upload . "` a "
            . "LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id "
            . "LEFT JOIN `" . LibTable::$channel . "` c ON a.channel_id = c.channel_id "
            . "{$connection}";

        $data = [];
        $row = $this->getOne(str_replace('_FIELD_', 'COUNT(*) AS c', $sql), $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $field = "b.`parent_id`, b.`name` AS game_name, c.`channel_name`, a.*";
            $_sql = str_replace('_FIELD_', $field, $sql) . " ORDER BY a.`month` DESC, a.`game_id`, b.`parent_id` {$limit}";
            $data = $this->query($_sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    public function splitUploadEdit($field = '', $value = 0, $data = [])
    {
        $insert[$field] = $value;
        $update = $insert;

        $insert['parent_id'] = $data['parent_id'];
        $insert['game_id'] = $data['game_id'];
        $insert['channel_id'] = $data['channel_id'];
        $insert['month'] = $data['month'];
        $this->insertOrUpdate($insert, $update, LibTable::$data_split_upload);
        return $this->affectedRows();
    }

    public function splitDel($id)
    {
        if (empty($id)) return false;
        $res = false;
        $where = " `id` in('" . join("','", $id) . "')";
        $hasRow = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$data_split_upload . "` WHERE " . $where);
        if ($hasRow && $hasRow['c'] > 0) {
            $res = $this->delete($where, $hasRow['c'], LibTable::$data_split_upload);
        }
        return $res;
    }

    public function getAsoDiscountList($parent_id, $game_id, $page, $limit)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $condition = '';

        if ($parent_id) {
            $condition .= ' and b.`parent_id`=:parent_id';
            $param['parent_id'] = $parent_id;
        }

        if ($game_id) {
            $condition .= " and a.`game_id`=:game_id";
            $param['game_id'] = $game_id;
        }

        $sql = "SELECT __FIELD__ FROM `" . LibTable::$aso_discount . "` a
                   LEFT JOIN `" . LibTable::$sy_game . "` b ON a.`game_id`=b.`game_id`
                   WHERE 1 {$condition} ORDER BY a.`open_sdate` DESC ";

        $field = ' COUNT(*) AS c ';
        $count = $this->getOne(str_replace('__FIELD__', $field, $sql), $param);
        if (empty($count['c'])) {
            return array();
        }
        $field = ' a.*,b.`parent_id` ';
        return array(
            'list' => $this->query(str_replace('__FIELD__', $field, $sql) . $limit, $param),
            'total' => $count['c']
        );
    }

    public function getAsoDiscountRow($game_id)
    {
        $sql = "SELECT * FROM `" . LibTable::$aso_discount . "` WHERE `game_id`=:game_id";
        $row = $this->getOne($sql, ['game_id' => $game_id]);
        return $row;
    }

    public function asoDiscountDel($id)
    {
        $this->delete(array('game_id' => explode(',', $id)), 0, LibTable::$aso_discount);
        return $this->affectedRows();
    }

    /**
     * 根据推广链ID获取点击广告信息
     * @param string $keyword
     * @param int $page
     * @param int $page_num
     * @return array
     */
    public function getClickAdList($keyword = '', $page = 1, $page_num = 10)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $page_num > 0 ? $page_num : DEFAULT_ADMIN_PAGE_NUM);
        }

        $data = array();
        $param = array();
        $condition = '';
        $length = strlen($keyword);

        if (is_numeric($keyword) && $length < 12) {//推广链ID
            $param['monitor_id'] = $keyword;
            $condition .= " AND a.`monitor_id` = :monitor_id";
        } elseif (filter_var($keyword, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {//IP
            $param['click_ip'] = $keyword;
            $condition .= " AND a.`click_ip` = :click_ip";
        } elseif (in_array($length, array(14, 15, 36))) {//设备号
            $param['device_id'] = $keyword;
            $param['sum_device_id'] = md5($keyword);
            $condition .= " AND (a.`device_id` = :device_id OR a.`sum_device_id` = :sum_device_id)";
        }

        if (empty($param)) {
            return array();
        }

        $sql = "SELECT COUNT(*) AS c FROM `" . LibTable::$ad_click . "` a WHERE 1 {$condition}";
        $row = $this->getOne($sql, $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $sql = "SELECT a.`id`, a.`monitor_id`, a.`platform` AS `device_type`, a.`package_name`, a.`device_id`, 
                a.`sum_device_id`, a.`click_ip`, a.`click_time`, b.`name` AS `monitor_name` 
                FROM `" . LibTable::$ad_click . "` a 
                    LEFT JOIN `" . LibTable::$ad_project . "` b ON a.`monitor_id` = b.`monitor_id` 
                WHERE 1 {$condition} ORDER BY a.`id` DESC {$limit}";
            $data = $this->query($sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count
        );
    }

    /**
     * 获取推广链信息
     * @param $id
     * @return array|bool|resource|string
     */
    public function getClickAdInfo($id)
    {
        return $this->commonGetOne(LibTable::$ad_click, 'id', $id);
    }
}