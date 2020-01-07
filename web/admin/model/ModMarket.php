<?php

class ModMarket extends Model
{
    public function addAccount($aId, $data)
    {
        /*$insert = $update = array(
            'account_id' => $aId,
            'account_password' => $data['account_password'],
            'account_nickname' => $data['account_nickname'],
            'status' => (int)$data['status'],
            'app_pub' => json_encode($data['app_pub']),
            'manager' => json_encode($data['manager']),
        );
        $insert['media'] = $data['media'];
        $insert['account'] = $data['account'];
        $res = $this->insertOrUpdate($insert, $update, LibTable::$ad_account);
        return $res;*/
        $insertData = $updateData = array(
            'account_password' => $data['account_password'],
            'account_nickname' => $data['account_nickname'],
            'status' => $data['status'],
            'app_pub' => json_encode($data['app_pub']),
            'manager' => json_encode($data['manager']),
        );
        $insertData['media'] = $data['media'];
        $insertData['account'] = $data['account'];
        $id = null;
        if ($aId) {
            $res = $this->update($updateData, ['account_id' => $aId], LibTable::$ad_account);
            if ($res) {
                $id = $aId;
            }
        } else {
            $id = $this->insert($insertData, true, LibTable::$ad_account);
        }
        return $id;
    }

    //获取账号信息(更改请注意)
    public function getAccountInfo($aId)
    {
        if (empty($aId)) {
            return array();
        }
        $where = " a.`account_id`={$aId}";
        if (is_array($aId)) {
            $where = " a.`account_id` IN ('" . join("','", $aId) . "')";
        }
        $sql = "SELECT a.*,b.`advertiser_id`,
        b.`access_token`,b.`refresh_token`,b.`access_token_expires_in`,
        b.`refresh_token_expires_in` FROM `" . LibTable::$ad_account . "` a 
        LEFT JOIN `" . LibTable::$ad_account_auth . "` b ON a.`account_id`=b.`account_id` WHERE ";
        if (is_array($aId)) {
            $row = $this->query($sql . $where);
        } else {
            $row = $this->getOne($sql . $where);
        }
        return $row;
    }

    //获取所有媒体账号信息（更改请注意）
    public function getAllMediaAccount($is_run)
    {
        $condition = '';
        $param = array();
        if ($is_run) {
            $condition .= " AND a.`status`=:status";
            $param['status'] = 0;
        }
        //显示已授权
        $sql = "SELECT a.`account_id`,a.`media`,a.`account`,a.`account_nickname`,a.`status`,b.`advertiser_id` 
              FROM `" . LibTable::$ad_account . "` a 
              LEFT JOIN `" . LibTable::$ad_account_auth . "` b ON a.`account_id`=b.`account_id`
              WHERE 1 {$condition} 
              ORDER BY b.`time` DESC
               ";
        //$sql = "SELECT a.* FROM `".LibTable::$ad_account."` a WHERE 1 {$condition} ";
        $row = $this->query($sql, $param);
        return $row;
    }

    public function accountList($is_run, $account, $page, $limitNum)
    {
        $condition = '';
        $param = array();

        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $limitNum);
        }

        if ($is_run) {
            $condition .= " AND `status`=:status";
            $param['status'] = 0;
        }

        if ($account) {
            $condition .= " AND `account` LIKE :account";
            $param['account'] = '%' . $account . '%';
        }

        $sqlCount = "SELECT count(*) c FROM `" . LibTable::$ad_account . "` WHERE 1 {$condition}";
        $count = $this->getOne($sqlCount, $param);
        if (!$count['c']) {
            return array();
        }

        $sql = "SELECT a.*,
                b.advertiser_id,
                b.access_token,
                b.refresh_token,
                b.refresh_token_expires_in,
                b.access_token_expires_in
            FROM `" . LibTable::$ad_account . "` a LEFT JOIN `" . LibTable::$ad_account_auth . "` b 
            ON a.`account_id`=b.`account_id` WHERE 1 {$condition} {$limit}";
        return array(
            'list' => $this->query($sql, $param),
            'count' => $count['c']
        );
    }

    public function refreshToken($aid, $client_id, $data)
    {
        if (empty($aid) || empty($client_id) || empty($data)) {
            return false;
        }
        $ret = $this->update($data, array('account_id' => $aid), LibTable::$ad_account_auth);
        if ($ret) {
            LibChannel::setAccessTokenCachePub($client_id, $aid, $data);
        }
        return $ret;
    }

    public function balanceWarnEdit($field, $value, $aid)
    {
        $update = array();
        $update[$field] = $value;
        if (empty($aid)) {
            return false;
        } else {
            if (is_array($aid)) {
                $where = " account_id IN('" . join("','", $aid) . "')";
            } elseif (is_numeric($aid)) {
                $where = " account_id={$aid}";
            } else {
                return false;
            }
        }
        !empty($where) && $this->update($update, $where, LibTable::$ad_account);
        return $this->affectedRows();
    }

    public function appAddMod($appid, $data, $tdata)
    {
        $insert = $update = array(
            'app_name' => trim($data['app_name']),
            'app_code' => $data['app_code'],
            'device_type' => $data['device_type'],
            'media_account' => serialize($tdata),
            'time' => time()
        );
        $update['appid'] = $appid;
        $update['status'] = $data['status'];
        $ret = $this->insertOrUpdate($insert, $update, LibTable::$ad_app);
        return $ret;
    }

    public function getAppList($is_run, $app_name, $page, $limit_num)
    {
        $condition = '';
        $param = array();

        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $limit_num);
        }

        if ($is_run) {
            $condition .= " AND `status`=:status";
            $param['status'] = 0;
        }
        if ($app_name) {
            $condition .= " AND `app_name` LIKE :nane";
            $param['name'] = "%{$app_name}%";
        }

        $sqlCount = "SELECT COUNT(*) c FROM `" . LibTable::$ad_app . "` WHERE 1 {$condition}";
        $count = $this->getOne($sqlCount, $param);
        if (!$count['c']) {
            return array();
        }
        $sql = "SELECT * FROM `" . LibTable::$ad_app . "` WHERE 1 {$condition} ORDER BY `time` DESC {$limit} ";
        return array(
            'list' => $this->query($sql, $param),
            'count' => $count['c']
        );
    }

    public function AllApp()
    {
        $sql = "SELECT * FROM `" . LibTable::$ad_app . "` ORDER BY `time` DESC";
        return $this->query($sql);
    }

    public function getAppInfo($appid)
    {
        if (empty($appid)) {
            return array();
        }

        $sql = "SELECT * FROM `" . LibTable::$ad_app . "` WHERE `appid`=:appid";
        $row = $this->getOne($sql, ['appid' => $appid]);
        return $row;
    }

    public function addGroupMod($name, $code)
    {
        if (empty($name) || empty($code)) {
            return false;
        }
        $insert = array(
            'group_name' => $name,
            'code' => $code,
            'time' => time(),
        );
        $ret = $this->insert($insert, true, LibTable::$ad_adio_group);
        return $ret;
    }

    public function getAllAdioGroup()
    {
        $sql = "SELECT * FROM `" . LibTable::$ad_adio_group . "`";
        return $this->query($sql);
    }

    public function adioAdd($id, $data, $mediaAccount)
    {
        $insert = $update = array(
            'email' => $data['email'],
            'nickname' => $data['nickname'],
            'role' => $data['adio_role'],
            'group_id' => $data['adio_group'],
            'media_account' => serialize($mediaAccount),
            'time' => time()
        );
        $update['id'] = $id;
        $update['status'] = $data['status'];
        $insert['solt'] = mt_rand(1000, 9999);
        $insert['password'] = md5('123456' . $insert['solt']);
        $ret = $this->insertOrUpdate($insert, $update, LibTable::$ad_adio);
        return $ret;
    }

    public function adioList($page, $limitNum, $is_run, $name)
    {
        $condtion = '';
        $limit = '';
        $param = array();
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, $limitNum);
        }

        if ($is_run) {
            $condtion .= " AND a.`status`=:status";
            $param['status'] = 0;
        }

        if ($name) {
            $condtion .= " AND a.`email` LIKE :name OR a.`nickname` LIKE :name";
            $param['name'] = "%{$name}%";
        }
        $sqlCount = "SELECT COUNT(*) c FROM `" . LibTable::$ad_adio . "` a WHERE 1 {$condtion}";
        $count = $this->getOne($sqlCount, $param);
        if (!$count['c']) {
            return array();
        }

        $sql = "SELECT a.*,b.`group_name`  FROM `" . LibTable::$ad_adio . "` a 
                LEFT JOIN `" . LibTable::$ad_adio_group . "` b ON a.`group_id`=b.`id`
                  WHERE 1 {$condtion} ORDER BY `time` DESC {$limit}";
        return array(
            'count' => $count['c'],
            'list' => $this->query($sql, $param)
        );
    }

    public function getAdioInfo($id)
    {
        if (empty($id)) {
            return array();
        }
        $where = " WHERE `id`={$id}";
        if (is_array($id)) {
            $id = array_filter($id);
            $where = " WHERE `id` IN ('" . join("','", $id) . "')";
        }

        $sql = "SELECT * FROM `" . LibTable::$ad_adio . "` {$where}";
        if (is_array($id)) {
            return $this->query($sql);
        } elseif (is_numeric($id)) {
            return $this->getOne($sql);
        } else {
            return array();
        }
    }

    public function updateTokenInfo($aid,$data)
    {
        $ret = $this->update($data,array('account_id'=>$aid),LibTable::$ad_account_auth);
        return $ret;
    }
}

?>