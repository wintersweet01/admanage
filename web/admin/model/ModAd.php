<?php

class ModAd extends Model
{

    public function __construct()
    {
        parent::__construct('default');
    }

    public function coopUser($page)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        $sql = "select `cp_user_id`,`user`,`ct`,`last_lt`,`last_ip` from " . LibTable::$cp_users . " where `state`=0 {$limit}";
        $info = $this->query($sql);
        return $info;
    }

    public function getMonitorList($game_id = 0, $channel_id = 0, $admin = '')
    {
        $condition = '';
        if ($game_id) {
            if (is_array($game_id)) {
                $condition .= " AND a.`game_id` IN(" . implode(',', (array)$game_id) . ")";
            } else {
                $condition .= " AND a.`game_id` = " . (int)$game_id;
            }
        }
        if ($channel_id) {
            if (is_array($channel_id)) {
                $condition .= " AND a.`channel_id` IN(" . implode(',', (array)$channel_id) . ")";
            } else {
                $condition .= " AND a.`channel_id` = " . (int)$channel_id;
            }
        }
        if ($admin) {
            $condition .= " AND a.`create_user` = '{$admin}'";
        }

        $condition .= SrvAuth::getAuthSql('b.parent_id', 'a.game_id', 'a.channel_id', 'a.user_id');

        $sql = "SELECT a.* FROM `" . LibTable::$ad_project . "` a 
                LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                WHERE 1 {$condition} ORDER BY a.`game_id`, a.`channel_id`, a.`monitor_id` DESC";
        return $this->query($sql);
    }

    public function getAdCompanyList($page = 0)
    {
        $sql = "select * from `" . LibTable::$channel_company . "` ";
        $sql_count = "select count(*) as c from `" . LibTable::$channel_company . "` ";
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
            $sql .= " {$limit}";
        }
        $count = $this->getOne($sql_count);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count['c'],
        );
    }

    public function getChannelInfo($channel_id)
    {
        return $this->commonGetOne(LibTable::$channel, 'channel_id', $channel_id);
    }


    public function getAdCompanyInfo($company_id)
    {
        return $this->commonGetOne(LibTable::$channel_company, 'company_id', $company_id);
    }

    public function updateChannelAction($channel_id, $data)
    {
        $where = array(
            'channel_id' => $channel_id,
        );
        $this->update($data, $where, LibTable::$channel);
        return $this->affectedRows();
    }

    public function addChannelAction($data)
    {
        return $this->insert($data, true, LibTable::$channel);
    }

    public function updateAdCompanyAction($company_id, $data)
    {
        $where = array(
            'company_id' => $company_id,
        );
        $this->update($data, $where, LibTable::$channel_company);
        return $this->affectedRows();
    }

    public function addAdCompanyAction($data)
    {
        return $this->insert($data, true, LibTable::$channel_company);
    }


    public function getLandCodeToday($code, $date)
    {
        $sql = "select * from `" . LibTable::$data_land_tj_date_code . "` where `code`=:code and `date`=:date";
        return $this->getOne($sql, array('code' => $code, 'date' => $date));
    }

    public function getLandCodeHour($code, $date, $hour)
    {
        $sql = "select * from `" . LibTable::$data_land_tj_hour_code . "` where `code`=:code and `date`=:date and `hour`=:hour";
        return $this->getOne($sql, array('code' => $code, 'date' => $date, 'hour' => $hour));
    }

    public function getLandCodeTodayAll($ids, $sdate, $edate)
    {
        $code = join("','", $ids);
        $sql = "select sum(`visit`) as `_visit`,sum(`click`) as `_click` from `" . LibTable::$data_land_tj_date_code . "` where `code` in ('{$code}')and `date` >= :sdate and `date` <= :edate";
        return $this->getOne($sql, array('sdate' => $sdate, 'edate' => $edate));
    }


    public function getMonitorByUser($user_id)
    {
        $sql = "select * from `" . LibTable::$ad_project . "` where `user_id`=:user_id and `status`=0 and `ad_id`>0";
        return $this->query($sql, array('user_id' => $user_id));
    }

    public function getDeliveryGroup($page = 0)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $condition = '';
        $auth_group = SrvAuth::getAuthChannelGroup();
        if (!empty($auth_group)) {
            $condition .= ' AND (group_id IN(' . implode(',', $auth_group) . ') OR `group_admin_id` IN(' . SrvAuth::$id . '))';
        }
        $sql = "SELECT * FROM `" . LibTable::$channel_group . "` WHERE 1 {$condition} ORDER BY `group_id` DESC {$limit}";
        $count = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$channel_group . "` WHERE 1 {$condition}");
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count['c'],
        );
    }

    public function getDeliveryGroupInfo($group_id)
    {
        return $this->commonGetOne(LibTable::$channel_group, 'group_id', $group_id);
    }

    public function updateDeliveryGroupAction($group_id, $data)
    {
        $where = array(
            'group_id' => $group_id,
        );
        $this->update($data, $where, LibTable::$channel_group);
        return $this->affectedRows();
    }

    public function addDeliveryGroupAction($data)
    {
        return $this->insert($data, true, LibTable::$channel_group);
    }

    public function getDeliveryUser($page, $channel_id, $user_id, $group_id)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = '';
        if ($group_id) {
            $param['group_id'] = $group_id;
            $connection .= " AND a.`group_id` = :group_id";
        }
        if ($channel_id) {
            $param['channel_id'] = $channel_id;
            $connection .= " AND a.`channel_id` = :channel_id";
        }
        if ($user_id) {
            $param['user_id'] = $user_id;
            $connection .= " AND a.`user_id` = :user_id";
        }

        //权限
        $connection .= SrvAuth::getAuthSql('', '', 'a.`channel_id`', 'a.`user_id`');

        $sql = "SELECT a.*,b.`group_name`, c.`channel_short`, d.`account_id`, d.`client_id`, d.`access_token`,
                d.`refresh_token`, d.`access_token_expires_in`, d.`refresh_token_expires_in`, d.`authorizer_info`, d.`time` 
                FROM `" . LibTable::$channel_user . "` AS a 
                LEFT JOIN `" . LibTable::$channel_group . "` AS b ON a.`group_id`=b.`group_id` 
                LEFT JOIN `" . LibTable::$channel . "` c ON a.`channel_id` = c.`channel_id` 
                LEFT JOIN `" . LibTable::$channel_user_auth . "` d ON a.`user_id` = d.`user_id` 
                WHERE 1 {$connection} ORDER BY a.`channel_id`, a.`group_id`, a.`user_name` {$limit}";
        $sql_count = "SELECT COUNT(*) AS c FROM `" . LibTable::$channel_user . "` a WHERE 1 {$connection}";
        $row = $this->getOne($sql_count, $param);
        if (!$row['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $row['c'],
        );
    }

    public function getDeliveryUserInfo($user_id)
    {
        $sql = "SELECT a.*, b.channel_short FROM `" . LibTable::$channel_user . "` a 
                LEFT JOIN `" . LibTable::$channel . "` b ON a.channel_id = b.channel_id WHERE a.user_id = :user_id";
        return $this->getOne($sql, array('user_id' => $user_id));
    }

    public function updateCpUserAction($user_id, $data)
    {

        if ($data['pwd']) {
            $update['salt'] = LibUtil::getSalt(10);
            $update['pwd'] = SrvAuth::signPwd($data['user'], $data['pwd'], $update['salt']);
        }
        LibUtil::config('change_' . $user_id, time());
        $where = array(
            'user_id' => $user_id,
        );
        $this->update($update, $where, LibTable::$cp_user);
        return $this->affectedRows();
    }

    public function editCpUserAction($data, $cp_id, $password)
    {
        if ($password) {
            $salt = LibUtil::getSalt(10);
            $update = array(
                'salt' => $salt,
                'pwd' => SrvAuth::signPwd($data['user'], $data['pwd'], $salt),
                'state' => 0,
                'game' => $data['game_id'],
                'channel' => $data['channel_id'],
                'package' => $data['gamePackage'],
                'menu' => $data['menu'],
                'item' => $data['items'],
                'creator' => SrvAuth::get_cookie('ht_name'),
            );
            return $this->update($update, array('cp_user_id' => $cp_id), LibTable::$cp_users);
        } else {
            $update = array(
                'state' => 0,
                'game' => $data['game_id'],
                'channel' => $data['channel_id'],
                'package' => $data['gamePackage'],
                'menu' => $data['menu'],
                'item' => $data['items'],
                'creator' => SrvAuth::get_cookie('ht_name'),
            );
            return $this->update($update, array('cp_user_id' => $cp_id), LibTable::$cp_users);
        }
    }

    public function addCpUserAction($data)
    {
        $salt = LibUtil::getSalt(10);
        $insert = array(
            'user' => $data['user'],
            'salt' => $salt,
            'pwd' => SrvAuth::signPwd($data['user'], $data['pwd'], $salt),
            'state' => 0,
            'game' => $data['game_id'],
            'channel' => $data['channel_id'],
            'package' => $data['gamePackage'],
            'menu' => $data['menu'],
            'item' => $data['items'],
            'ct' => time(),
            'creator' => SrvAuth::get_cookie('ht_name'),
        );
        return $this->insert($insert, true, LibTable::$cp_users);
    }


    public function updateDeliveryUserAction($user_id, $data)
    {
        $where = array(
            'user_id' => $user_id,
        );
        $this->update($data, $where, LibTable::$channel_user);
        return $this->affectedRows();
    }

    public function addDeliveryUserAction($data)
    {
        return $this->insert($data, true, LibTable::$channel_user);
    }

    public function getChannelList($page = 0)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }
        $sql = "select * from `" . LibTable::$channel . "` {$limit}";
        $count = $this->getOne("select count(*) as c from `" . LibTable::$channel . "`");
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count['c'],
        );
    }

    public function getGamePackage($game_id, $channel_id)
    {
        $sql = "select `package_name` from " . LibTable::$sy_game_package . " where 1 ";
        if ($game_id) {
            $sql .= " and `game_id` in ($game_id) ";
        }
        if ($channel_id) {
            $sql .= " and `channel_id` in ($channel_id) ";
        }
        return $data = $this->query($sql);

    }

    public function getGamePackages($game_id, $channel_id)
    {
        $sql = "select `package_name` from " . LibTable::$sy_game_package . " where 1  and `package_name` like '%android%'";
        $sql_ios = "select `package_name` from " . LibTable::$sy_game_package . " where 1 and `package_name` like '%ios%' ";
        if ($game_id) {
            $sql .= " and `game_id` in ($game_id) ";
            $sql_ios .= " and `game_id` in ($game_id) ";
        }
        if ($channel_id) {
            $sql .= " and `channel_id` in ($channel_id) ";
        }
        $data = $this->query($sql);

        $data_ios = $this->query($sql_ios);
        $data = array_merge($data, $data_ios);


        return $data;
    }


    public function _getGamePackage($game_id, $channel_id, $android)
    {
        $data = array();
        if ($android) {
            $sql = "select `package_name` from " . LibTable::$sy_game_package . " where 1 and `package_name` like '%android%' ";
            if ($game_id) {
                $sql .= " and `game_id` in ($game_id) ";
            }
            if ($channel_id) {
                $sql .= " and `channel_id` in ($channel_id) ";
            }
            $data['android'] = $this->query($sql);
        }

        $sql = "select `package_name` from " . LibTable::$sy_game_package . " where 1 and `package_name` like '%ios%' ";
        if ($game_id) {
            $sql .= " and `game_id` in ($game_id) ";
        }
//        if($channel_id){
//            $sql .= " and `channel_id` in ($channel_id) ";
//        }
        $data['ios'] = $this->query($sql);
        return $data;

    }


    public function delCoopUser($id)
    {
        $sql = "delete from " . LibTable::$cp_users . " where `cp_user_id` = $id ";
        return $this->query($sql);

    }

    public function checkUser($user)
    {
        $sql = "select count(*) as c from " . LibTable::$cp_users . " where `user` = '$user'";
        $res = $this->getOne($sql);
        return $res;
    }

    public function getCoopUser($id)
    {
        $sql = "select `user`,`game`,`channel`,`package`,`menu`,`item` from " . LibTable::$cp_users . " where `cp_user_id` = $id ";
        $info = $this->getOne($sql);
        return $info;
    }

    /**
     * 获取渠道授权信息
     *
     * @param int $user_id
     * @return array|bool|resource|string
     */
    public function getChannelUserAuthInfo($user_id = 0)
    {
        $sql = "SELECT a.*, c.`channel_short` 
                FROM " . LibTable::$channel_user_auth . " a 
                LEFT JOIN `" . LibTable::$channel_user . "` b ON a.`user_id` = b.`user_id` 
                LEFT JOIN `" . LibTable::$channel . "` c ON c.`channel_id` = b.`channel_id` 
                WHERE a.`user_id` = :user_id";
        return $this->getOne($sql, array('user_id' => $user_id));
    }

    /**
     * 根据应用ID获取渠道授权信息
     *
     * @param int $client_id
     * @param int $account_id
     * @return array|bool|resource|string
     */
    public function getChannelUserAuthInfoByCid($client_id = 0, $account_id = 0)
    {
        $sql = "SELECT a.*, c.`channel_short` 
                FROM " . LibTable::$channel_user_auth . " a 
                LEFT JOIN `" . LibTable::$channel_user . "` b ON a.`user_id` = b.`user_id` 
                LEFT JOIN `" . LibTable::$channel . "` c ON c.`channel_id` = b.`channel_id` 
                WHERE a.`client_id` = :client_id AND a.`account_id` = :account_id";
        return $this->getOne($sql, array('client_id' => $client_id, 'account_id' => $account_id));
    }

    /**
     * 更新渠道授权信息
     *
     * @param int $user_id
     * @param array $data
     * @return mixed
     */
    public function updateChannelUserAuthInfo($user_id = 0, $data = [])
    {
        return $this->update($data, array('user_id' => $user_id), LibTable::$channel_user_auth);
    }

    /**
     * 获取数据源列表
     *
     * @param int $page
     * @param int $account_id
     * @return array
     */
    public function getChannelUserAppList($page = 0, $account_id = 0)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $connection = 'WHERE 1';
        if ($account_id > 0) {
            $connection .= " AND account_id = :account_id";
            $param['account_id'] = $account_id;
        }

        $sql = "SELECT * FROM " . LibTable::$channel_user_app . " {$connection} ORDER BY `create_time` DESC {$limit}";
        $sql_count = "SELECT COUNT(*) AS c FROM " . LibTable::$channel_user_app . " {$connection}";
        $row = $this->getOne($sql_count, $param);
        if (!$row['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => (int)$row['c'],
        );
    }

    /**
     * 添加数据源
     *
     * @param array $data
     * @return resource|string
     */
    public function channelAddUserAppAction($data = [])
    {
        return $this->insert($data, false, LibTable::$channel_user_app, array('replace' => true));
    }

    /**
     * 获取所有投放账号
     * @return array|bool|resource|string
     */
    public function getChannelUserList()
    {
        $sql = "SELECT a.`channel_id`, a.`group_id`, a.`user_id`, a.`user_name`, b.`channel_name` 
                FROM `" . LibTable::$channel_user . "` a 
                    LEFT JOIN `" . LibTable::$channel . "` b ON a.`channel_id` = b.`channel_id` 
                ORDER BY a.`channel_id` ASC, a.`user_id` DESC";
        return $this->query($sql);
    }
}