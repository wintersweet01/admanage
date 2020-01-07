<?php

class SrvKfVip
{

    private $mod;
    private $vip_mod;

    public function __construct()
    {
        $this->mod = new ModPlatform();
        $this->vip_mod = new ModKfVip();
    }

    /**
     * 获取所有VIP列表
     * @param int $parent_id
     * @param int $game_id
     * @param int $belong_id
     * @param int $insr_id
     * @parma string $account
     * @param int $uid
     * @param int $page
     * @param string $sdate
     * @param string $edate
     * @param int $list_color
     * @return array
     */
    public function getKfVipList($parent_id, $game_id, $belong_id, $insr_id, $account, $uid, $page, $sdate, $edate, $list_color = null)
    {
        $page = $page < 1 ? 1 : $page;
        if ($sdate == '') {
            $sdate = date('Y-m-d');
        }

        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info = $this->vip_mod->vipList($page, $parent_id, $game_id, $belong_id, $insr_id, $account, $uid, $sdate, $edate, $list_color);
        ///将信息解析
        if (!empty($info['list']) && is_array($info['list'])) {
            foreach ($info['list'] as $key => &$value) {
                $value['belong_user'] = $value['game_id'] . "_" . $value['platform'] . "_" . $value['server_id'];
                $value['insr_time'] = date('Y-m-d H:i:s', $value['insr_time']);
                $value['touch_time'] = date('Y-m-d H:i:s', $value['touch_time']);
                //最后登陆时间
                $value['login_day_ret'] = (int)$value['diff_login'];
                //之后支付时间
                $value['pay_day_ret'] = (int)$value['diff_pay'];
            }
            $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
            $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
            LibUtil::clean_xss($sdate);
            LibUtil::clean_xss($edate);
        }

        $info['belong_id'] = $belong_id;
        $info['insr_id'] = $insr_id;
        $info['account'] = $account;
        $info['list_color'] = $list_color;
        $info['uid'] = $uid;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    /**
     * @param array $data
     * @return array
     */
    public function addVipUser($data)
    {
        if (empty($data)) return LibUtil::retData(false, array(), '参数不能为空');

        if (empty($data['game_id']) || empty($data['uid']) || empty($data['platform'])
            || empty($data['role_info']) || empty($data['server_id']) || empty($data['touch_time'])
        ) {
            return LibUtil::retData(false, array(), '必要参数缺失');
        }
        $games = (new SrvPlatform())->getAllGame(false);
        if (!in_array($data['game_id'], array_keys($games))) {
            return LibUtil::retData(false, array(), '找不到该游戏');
        }
        //判断账号是否存在
        /*$userInfo = $this->vip_mod->getGameUserInfo($data['account']);
        if (empty($userInfo) || $userInfo['uid'] != $data['uid']) {
            return LibUtil::retData(false, array(), '账号不存在');
        }
         $roleInfo = $this->vip_mod->getRoleInfo($data['role_name'], $data['game_id'], $data['server_id'], $data['uid'], $data['platform']);
         if (empty($roleInfo)) {
             return LibUtil::retData(false, array(), '角色不存在');
         }*/
        $role_info = explode('/', $data['role_info']);
        $insertData = array(
            'game_id' => intval($data['game_id']),//母游戏ID
            //'account' => trim($data['account']),//账号
            'uid' => intval($data['uid']),//用户唯一ID
            'rolename' => trim($role_info[1]),//角色名称
            'role_id' => $role_info[0],
            'server_id' => intval($data['server_id']),
            'touch_time' => (int)strtotime($data['touch_time']),
            'real_name' => !empty($data['real_name']) ? trim($data['real_name']) : '',
            'phone' => !empty($data['phone']) ? $data['phone'] : 0,
            'birth' => !empty($data['birth']) ? strtotime($data['birth']) : 0,
            'mail' => !empty($data['mail']) ? trim($data['mail']) : '',
            'qq_num' => !empty($data['qq_num']) ? trim($data['qq_num']) : 0,
            'wx_num' => !empty($data['wx_num']) ? trim($data['wx_num']) : '',
            'img1' => !empty($data['img'][1]) ? $data['img'][1] : '',
            'img2' => !empty($data['img'][2]) ? $data['img'][2] : '',
            'img3' => !empty($data['img'][3]) ? $data['img'][3] : '',
            'status' => $data['check_btn'],
            'platform' => $data['platform'],
        );
        if (empty($data['model_id'])) {
            $insertData['insr_time'] = time();
            $insertData['insr_kefu'] = SrvAuth::$id;
        }
        $res = $this->vip_mod->insertVipData($insertData, $data['model_id']);
        if ($res) {
            return LibUtil::retData(true, array('id' => $res), '添加成功');
        }
        return LibUtil::retData(false, array(), '该角色名已被录入');
    }

    /**
     * 更新VIP状态
     * @param string $type
     * @param int $id
     * @return array
     */
    public function check($type, $id)
    {
        $type_id = $type == 'cm' ? 2 : ($type == 'rb' ? 3 : '');
        $res = $this->vip_mod->check($type_id, $id);
        if ($res) {
            return LibUtil::retData(true, array(), '更新成功');
        }
        return LibUtil::retData(false, array(), '更新失败');
    }

    /**
     * 删除当前VIP
     * @param array $ids
     * @return array
     */
    public function delVip($ids)
    {
        if (!array() || empty($ids)) LibUtil::retData(false, array(), '删除失败');
        $res = $this->vip_mod->delVip($ids);
        if ($res) {
            return LibUtil::retData(true, array(), '删除成功');
        } else {
            return LibUtil::retData(false, array(), '删除失败');
        }
    }

    /**
     * 获取客服VIP业绩
     * @parma int $parent_id
     * @param string $sdate
     * @param string $edate
     * @param string $account
     * @param string $kf_name
     * @return array
     */
    public function getVipAchieve($parent_id, $sdate, $edate, $account, $kf_name)
    {
        if ($sdate == '') {
            $sdate = date('Y-m-01');
        }

        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info = $this->vip_mod->getVipAchieve($parent_id, $sdate, $edate, $account, $kf_name);
        $adminUser = SrvAuth::allAuth();
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $gameP = array();
        foreach ($games['parent'] as $game) {
            $gameP[$game['id']] = $game['text'];
        }

        foreach ($info['list'] as $key => &$value) {
            $value['kf_name'] = $adminUser[$value['insr_kefu']]['name'];
            $value['pay_money'] = $value['pay_money'] == 0 ? 0 : number_format($value['pay_money'] / MONEY_CONF, 2);
            $value['parent_game'] = $gameP[$value['parent_id']];
        }
        $info['parent_id'] = $parent_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['account'] = $account;
        $info['kf_name'] = $kf_name;
        return $info;
    }

    /**
     * 获取业绩明细
     * @param int $game_id
     * @param int $parent_id
     * @param string $sdate
     * @param string $edate
     * @param string $account
     * @param int $kfid
     * @param int $uid
     * @param int $page
     * @return array
     */
    public function getViewList($game_id, $parent_id, $sdate, $edate, $account, $kfid, $uid, $page)
    {
        $page = $page < 1 ? 1 : $page;
        if ($sdate == '') {
            $sdate = date('Y-m-01');
        }

        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(false);
        $info = $this->vip_mod->getViewList($game_id, $parent_id, $sdate, $edate, $account, $kfid, $uid, $page);

        foreach ($info['list'] as &$rows) {
            $rows['game_name'] = $games[$rows['game_id']];
            $rows['total_charge'] = $rows['total_charge'] == 0 ? 0 : number_format($rows['total_charge'] / MONEY_CONF, 2);
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['game_id'] = $game_id;
        $info['parent_id'] = $parent_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['account'] = $account;
        $info['uid'] = $uid;
        return $info;
    }

    /**
     * 获取VIP档案
     * @param int $game_id
     * @param int $name
     * @param string $account
     * @param int $uid
     * @param string $sdate
     * @param string $edate
     * @param int $page
     * @param int $parent_id
     * @return array
     */
    public function getVipRecord($game_id, $name, $account, $uid, $sdate, $edate, $page, $parent_id)
    {
        $page = $page < 1 ? 1 : $page;
        if ($sdate == '') {
            $sdate = date('Y-m-01');
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $info = $this->vip_mod->getVipRecord($game_id, $name, $account, $uid, $sdate, $edate, $page, $parent_id);
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(false);
        $admins = SrvAuth::allAuth();
        foreach ($info['list'] as &$val) {
            $val['c_parent_name'] = $games[$val['c_parent_id']];
            $val['game_name'] = $games[$val['game_id']];
            $val['kf_name'] = $admins[$val['insr_kefu']]['name'];
            $val['login_day'] = ceil((time() - $val['login_time']) / (24 * 60 * 60));
            $val['login_time'] = date('Y-m-d H:i:s', $val['login_time']);
            $val['pays'] = $val['pays'] == 0 ? 0 : number_format($val['pays'] / MONEY_CONF, 2);
            $val['insr_time'] = date('Y-m-d H:i:s', $val['insr_time']);
            $val['pay_time'] = date('Y-m-d H:i:s', $val['pay_time']);
            $val['touch_time'] = date('Y-m-d H:i:s', $val['touch_time']);
            $val['total_fee'] = $val['total_fee'] == 0 ? 0 : number_format($val['total_fee'] / MONEY_CONF, 2);
            $val['charge_ext'] = $val['charge_ext'] == 0 ? 0 : number_format($val['charge_ext'] / MONEY_CONF, 2);
            $val['day_charge'] = $val['day_charge'] == 0 ? 0 : number_format($val['day_charge'] / MONEY_CONF, 2);
        }
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);

        $info['game_id'] = $game_id;
        $info['parent_id'] = $parent_id;
        $info['name'] = $name;
        $info['account'] = $account;
        $info['uid'] = $uid;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    /**
     * 获取玩家联系记录
     * @param int $parent_id
     * @param string $linker
     * @param int $server_id
     * @param string $sdate
     * @param string $edate
     * @return array
     */
    public function getUserLink($parent_id, $linker, $server_id, $sdate, $edate)
    {
        if (!$sdate) {
            $sdate = date('Y-m-01', time());
        }
        if (!$edate) {
            $edate = date('Y-m-d', time());
        }
        $info = $this->vip_mod->getUserLink($parent_id, $linker, $server_id, $sdate, $edate);
        $link = array();
        if (is_array($info['link']) && !empty($info['link'])) {
            $linkArr = array();
            foreach ($info['link'] as $row) {
                $linkArr[$row['admin_id']][] = $row['c'];
            }

            foreach ($linkArr as $key => $val) {
                $link[$key] = count($val);
            }
        }
        $info['link'] = $link;
        $info['insr'] = array_column($info['insr'], 'c', 'insr_kefu');
        $info['linker'] = $linker;
        $info['server_id'] = $server_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    /**
     * 获取客服对应游戏权限以及游戏包含区服
     * @param int $authorId
     * @return array
     */
    public function getGameSer($authorId)
    {
        if (empty($authorId)) return array();
        $info = $this->mod->getGameServer($authorId);
        $authParentId = $info['auth_parent_id'];
        $authGameId = $info['auth_game_id'];

        $games = $this->fetchGames($authParentId, $authGameId);
        $gameIdList = $games['game_id'];///所有子游戏
        $res = $this->mod->gameServers($gameIdList);
        $gameServer = array();
        foreach ($res as $rows) {
            $gameServer[$rows['game_id']][] = $rows;
        }
        foreach ($gameServer as $key => &$value) {
            $gameServer[$key] = array_chunk($value, 10);
        }
        return array(
            'game' => $games,
            'server' => $gameServer
        );
    }

    /**
     * 获取客服已经勾选的区服列表
     * @param int $authorId
     * @return array
     */
    public function getAuthorGS($authorId)
    {
        if (empty($authorId)) return array();
        $info = $this->vip_mod->getAuthorChecked($authorId);
        $pgs = array();
        foreach ($info as $row) {
            if (empty($row['pgs'])) continue;
            array_push($pgs, $row['pgs']);
        }
        return $pgs;
    }

    /**
     * 获取母游戏下的所有子游戏的区服(并集)
     * @param int $authorId
     * @param int $parentId
     * @param int $page
     * @param int $platform
     * @return array
     */
    public function getGameParentServer($authorId, $parentId)
    {
        if (empty($parentId)) return array();
        if (empty(($authorId))) return array();
        $info = array();
        try {
            $parentIds = array($parentId);
            $info = $this->vip_mod->gameParentServer($parentIds);
        } catch (Exception $e) {
            //todo save the log
        }
        return $info;
    }

    /**
     * 获取更多子游戏下的区服
     * @param int $more
     * @param int $platform
     * @param int $parentId
     * @param int $authorId
     * @return array;
     */
    public function getMoreGameServer($more, $platform, $parentId, $authorId)
    {
        $data = array();
        $more = $more <= 0 ? $more = 1 : $more;
        $info = $this->vip_mod->MoreGameServer($more, $platform, $parentId);

        if (!empty($info)) {
            $adminSelect = $this->getAdminSelectServer($authorId);//获取用户勾选
            $data['ac'] = $adminSelect;
            $data['list'] = array_chunk($info, ModKfVip::SERVER_GROUP);
            $data['more'] = $more + 1;
            $data['platform'] = $platform;
            $data['parent_id'] = $parentId;
        }
        return $data;
    }


    /**
     * 获取管理员已经勾选的区服2.0版本
     * @param int $authorId
     * @return array
     */
    public function getAdminSelectServer($authorId)
    {
        if (empty($authorId)) return array();
        $info = $this->vip_mod->adminSelectServer($authorId);
        $select = array();
        foreach ($info as $row) {
            if (empty($row['server_id'])) continue;
            $sec = '';
            $sec = $row['parent_id'] . "_" . $row['platform'] . "_" . $row['server_id'];
            array_push($select, $sec);
        }
        return $select;
    }

    /**
     * 获取区服归属情况
     */
    public function getGameServerBelongInfo()
    {
        $authorPowerKey = AUTHOR_POWER_KEY;
        $info = LibRedis::smembers($authorPowerKey);
        if (empty($info)) {
            $info = $this->vip_mod->getBelongInfo();
            $gnData = array();
            LibRedis::delete($authorPowerKey);
            foreach ($info as $row) {
                $gn = $row['admin_id'] . ":" . $row['gs'];
                array_push($gnData, $gn);
            }
            $retData = array_column($info, null, 'gs');
            LibRedis::sadd($authorPowerKey, array_unique(array_filter($gnData)));
        } else {
            $retData = array();
            foreach ($info as $val) {
                $tmp = explode(":", $val);
                $retData[$tmp[1]]['admin_id'] = $tmp[0];
            }
        }
        return $retData;
    }

    /**
     * 客服区服授权2.0版本
     * @param string $data
     * @param int $authorId
     * @param string $parent_id
     * @return  array
     */
    public function addAuthorServerPowerP($data, $authorId, $parent_id)
    {
        if (empty($parent_id) || empty($authorId)) return LibUtil::retData(false, array(), '授权账号为空，修改失败');
        $data = json_decode($data, true);
        $powerData = array();
        foreach ($data as $row) {
            $tmp = explode("_", $row);
            if (in_array(null, $tmp) || in_array('', $tmp)) continue;
            $temp = array();
            $temp['parent_id'] = $tmp[0];
            $temp['platform'] = $tmp[1];
            $temp['server_id'] = $tmp[2];
            $temp['gn_time'] = time();
            $temp['admin_id'] = $authorId;
            array_push($powerData, $temp);
        }
        $res = $this->vip_mod->addAuthorServerPower($powerData, $authorId, $parent_id);
        if ($res) {
            //$this->getGameServerBelongInfo();//redis
            return LibUtil::retData(true, array(), '修改成功');
        }
        return LibUtil::retData(false, array(), '修改失败');
    }

    /**
     * 客服区服授权3.0版本 对界面已有勾选/未勾选进行操作
     * @param string $data
     * @param int $authorId
     * @param int $parent_id
     * @return  array
     */
    public function addAuthorServerPower($data, $authorId, $parent_id)
    {
        if (empty($parent_id) || empty($authorId)) return LibUtil::retData(false, array(), '授权账号为空，修改失败');
        $data = json_decode($data, true);
        $powerData = array();
        foreach ($data as $row) {
            $tmp = explode("_", $row);
            if (in_array(null, $tmp) || in_array('', $tmp)) continue;
            $temp = array();
            $temp['parent_id'] = $tmp[0];
            $temp['platform'] = $tmp[1];
            $temp['server_id'] = $tmp[2];
            $temp['gn_time'] = time();
            $temp['admin_id'] = $authorId;
            $temp['status'] = $tmp[3];//y勾选，n删除
            array_push($powerData, $temp);
        }
        $res = $this->vip_mod->addAuthorServerPowerByStatus($powerData, $authorId, $parent_id);
        if ($res) {
            //$this->getGameServerBelongInfo();
            return LibUtil::retData(true, array(), '修改成功');
        }
        return LibUtil::retData(false, array(), '修改失败');
    }



    /**
     * 客服查看区服权限
     * @param int $authorId
     * @return array
     */
    public function viewAuthorPower($authorId)
    {
        if (empty($authorId)) return array();
        $data = $this->getAuthorGS($authorId);
        $allGS = $this->vip_mod->getAllGS();
        $allGS = array_column($allGS, null, 'gs');
        $gsData = array();
        foreach ($data as $res) {
            $temp = array();
            $gs = explode("_", $res);
            $temp['game_id'] = $gs[1];
            $temp['server_id'] = $gs[2];
            $key = $gs[1] . "_" . $gs[2];
            $gsData[$key] = $temp;
        }
        return array(
            'author_gs' => $gsData,
            'all_gs' => $allGS
        );
    }

    /**
     * 客服查看区服权限
     * @param int $authorId
     * @return array
     */
    public function viewAuthorPowerP($authorId)
    {
        if (empty($authorId)) return array();
        $data = $this->getAuthorGs($authorId);
        $ret = array();
        foreach ($data as $row) {
            $tmp = explode("_", $row);
            $ret[$tmp[0]][$tmp[1]][] = $tmp[2];
        }
        foreach ($ret as &$arr) {
            foreach ($arr as $key => &$arr1) {
                $arr[$key] = array_chunk($arr1, 50);
            }
        }
        return $ret;
    }


    /**
     * 获取单条记录
     * @param int $model_id
     * @return array
     */
    public function getVipRow($model_id)
    {
        if (empty($model_id)) LibUtil::retData(false, array(), '');

        $row = $this->vip_mod->getVipRow($model_id);
        if ($row) {
            $row['touch_time'] = date('Y-m-d H:i:s', $row['touch_time']);
            $row['birth'] = date('Y-m-d', $row['birth']);
            $uid = $row['uid'];
            $userInfo = (new SrvPlatform())->getUserInfo($uid);
            $row['account'] = $userInfo['user'][$uid]['username'];
            return LibUtil::retData(true, $row, '');
        }
        return LibUtil::retData(false, array(), '');
    }

    /**
     * 获取客服联系列表
     * @param int $kfid
     * @param int $parent_id
     * @param int $server_id
     * @param int $status
     * @param string /int $uid
     * @param string $sdate
     * @param string $edate
     * @param int $page
     * @return array
     */
    public function viewLinkInfo($kfid, $parent_id, $server_id, $status, $uid, $sdate, $edate, $page)
    {
        if (empty($kfid)) return array();
        $page = $page < 1 ? 1 : $page;
        if (!$sdate) {
            $sdate = date('Y-m-01', time());
        }
        if ($edate) {
            $edate = date('Y-m-d', time());
        }
        $srvPlatform = new SrvPlatform();
        $info = $this->vip_mod->viewLinkInfo($kfid, $parent_id, $server_id, $status, $uid, $sdate, $edate, $page);
        foreach ($info['normal'] as &$nval) {
            $nval['touch_time'] = !empty($nval['touch_time']) ? date('Y-m-d H:i:s', $nval['touch_time']) : '';
            $nval['t_fee'] = $nval['t_fee'] == 0 ? 0 : number_format($nval['t_fee'] / MONEY_CONF, 2);
            $userInfo = $srvPlatform->getUserInfo($nval['uid']);
            $nval['account'] = isset($userInfo['user'][$nval['uid']]['username']) ? $userInfo['user'][$nval['uid']]['username'] : '';
        }
        foreach ($info['login_charge'] as &$cval) {
            $cval['login_day'] = ceil((time() - $cval['login_time']) / (24 * 60 * 60));
            $cval['login_time'] = !empty($cval['login_time']) ? date('Y-m-d H:i:s', $cval['login_time']) : '';
            $cval['charge_money'] = $cval['charge_money'] == 0 ? 0 : number_format($cval['charge_money'] / MONEY_CONF, 2);
        }

        foreach ($info['reach_time'] as &$rval) {
            $rval['reach_time'] = !empty($rval['reach_time']) ? date('Y-m-d H:i:s', $rval['reach_time']) : '';
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);

        $info['kfid'] = $kfid;
        $info['parent_id'] = $parent_id;
        $info['server_id'] = $server_id;
        $info['uid'] = $uid;
        $info['status'] = $status;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    /**
     * 联系明细导出
     * @param array $param ;
     * @return array
     */
    public function viewLinkInfoDownload($param)
    {
        $info = $this->vip_mod->viewLinkInfo($param['kfid'], $param['parent_id'], $param['server_id'], $param['status'], $param['uid'], $param['sdate'], $param['edate'], 0);
        $login_charge = $info['login_charge'];
        $reach_time = $info['reach_time'];
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(false);
        $users = SrvAuth::allAuth();
        $data = array();
        $data[] = array(
            '母游戏:平台', '用户ID', '角色名:角色ID', '区服', '达标时间', '账号', '最后登录时间', '联系状态', '联系时间', '录入人', '累计充值'
        );

        foreach ($info['normal'] as $key => &$row) {
            $temp = array();
            $key = trim($key);
            $platform = $row['device_type'] == 1 ? 'IOS' : ($row['device_type'] == 2 ? '安卓' : '');
            $temp['game_platform'] = $games[$row['game_id']] . ":" . $platform;
            $temp['uid'] = $row['uid'];
            $temp['role_id'] = $row['role_name'] . ":" . $row['role_id'];
            $temp['server_id'] = $row['server_id'];
            $temp['reach_time'] = isset($reach_time[$key]['reach_time']) ? date('Y-m-d H:i:s', $reach_time[$key]['reach_time']) : '';
            $userInfo = $srvPlatform->getUserInfo($row['uid']);
            $temp['account'] = isset($userInfo['user'][$row['uid']]['username']) ? trim((string)$userInfo['user'][$row['uid']]['username']): '';
            $temp['login_time'] = isset($login_charge[$key]['login_time']) ? date('Y-m-d H:i:s', $login_charge[$key]['login_time']) : '';
            $temp['touch_status'] = $row['status'] == 2 ? '已联系' : '未联系';
            $temp['touch_time'] = isset($row['touch_time']) ? date('Y-m-d H:i:s', $row['touch_time']) : '';
            $temp['insr_man'] = isset($users[$row['insr_kefu']]['name']) ? $users[$row['insr_kefu']]['name'] : '';
            $temp['total_charge'] = isset($row['t_fee']) ? number_format(bcdiv($row['t_fee'], MONEY_CONF, 2), 2) : 0;
            array_push($data, array_values($temp));
        }
        $file_path = '/uploads/' . date("ym") . '/download/' . LibUtil::token('download') . '/客服[' . $users[$param['kfid']]['name'] . ']VIP_用户联系明细表_' . date('Ymd') . '.csv';
        $url = APP_ALL_URL . $file_path;
        $file_dir = dirname(APP_ROOT . $file_path);
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0755, true);
        }

        $ret = LibUtil::write_to_csv(APP_ROOT . $file_path, $data, 'gbk');
        if (!$ret) {
            LibUtil::response('导出数据出错');
        }

        LibUtil::response('导出成功，请下载保存', 1, array('url' => $url));
    }


    /**
     * 撤销
     * @param int $id
     * @return array
     */
    public function cancel($id)
    {
        if (empty($id)) return LibUtil::retData(false, array(), '删除失败');
        $res = $this->vip_mod->cancel($id);
        if ($res) {
            return LibUtil::retData(true, array(), '删除成功');
        }
        return LibUtil::retData(false, array(), '删除失败');
    }

    /**
     * 检查内容
     * @param string /int $data
     * @param string $dataType
     * @return array
     */
    public function infoCheck($data, $dataType)
    {
        if (empty($data) || empty($dataType)) return LibUtil::retData(false, array(), '');
        $res = $this->vip_mod->infoCheck($dataType, $data);
        if ($res['status']) {
            return LibUtil::retData(true, array('res' => $res['info']), '');
        }
        return LibUtil::retData(false, array(), '无法获取到信息');
    }

    /**
     * 从订单表获取玩家所有角色
     * @param int $parent_id
     * @param int $server_id
     * @param int $uid
     * @return array;
     */
    public function fetchRoleList($parent_id, $server_id, $uid)
    {
        if (empty($parent_id) || empty($server_id) || empty($uid)) {
            return LibUtil::retData(false, array(), '参数错误');
        }
        $data = $this->vip_mod->fetchRoleList($parent_id, $server_id, $uid);
        if ($data) {
            return LibUtil::retData(true, array('list' => $data), '获取成功');
        }
        return LibUtil::retData(false, array(), '暂无角色信息');
    }


    /**
     * 获取账号下的游戏列表
     * @param string $parentGame
     * @param string $childGame
     * @return array;
     */
    private function fetchGames($parentGame, $childGame)
    {
        $parentGame = !empty($parentGame) ? explode(",", $parentGame) : array();
        $childGame = !empty($childGame) ? explode(",", $childGame) : array();
        $gameInfo = $this->mod->getGameList();
        $games = array();
        while (true) {
            if (!$gameInfo['total']) break;
            $tmp = $data = $list = $gameLst = $game_parent = array();
            foreach ($gameInfo['list'] as &$val) {
                $tmp[$val['game_id']] = array(
                    'pid' => $val['parent_id'],
                    'id' => $val['game_id'],
                    'name' => $val['name'],
                    'alias' => $val['alias']
                );
                $list[$val['game_id']] = $val['name'];
            }
            if ((empty($parentGame) && empty($childGame))) {
                $data = &$tmp;
            } else {
                foreach ($tmp as $row) {
                    if (!empty($parentGame) && in_array($row['pid'], $parentGame)) {
                        $data[$row['id']] = $row;///母游戏
                    } elseif (!empty($childGame) && in_array($row['id'], $childGame)) {
                        $data[$row['id']] = $row;
                        $data[$row['pid']] = $tmp[$row['pid']];
                    }
                }
                foreach ($parentGame as $pid) {
                    $data[$pid] = $tmp[$pid];
                }
                unset($tmp);
            }
            krsort($data);
            foreach ($data as $i) {
                if ($i['pid'] != 0) array_push($gameLst, $i['id']);
                if ($i['pid'] != 0) array_push($game_parent, $i['pid']);
            }
            $games = array(
                'parent' => LibUtil::build_tree($data, 0),
                'list' => $list,
                'game_id' => array_unique($gameLst),
                'parent_id' => array_unique($game_parent),
            );
            break;
        }
        return $games;
    }

    //测试
    public function getData($game_id, $page)
    {
        $page < 1 && $page = 1;
        $info = $this->vip_mod->vip_list($game_id, $page);
        $data = array();
        $games = (new SrvPlatform())->getAllGame(false);
        if (!empty($info) && is_array($info['list'])) {
            foreach ($info['list'] as $val) {
                $temp = array();
                $temp['id'] = $val['id'];
                $temp['game_id'] = $val['game_id'];
                $temp['game_name'] = $games[$val['game_id']];
                $temp['server_id'] = $val['server_id'];
                $temp['role_id'] = $val['role_id'];
                $temp['role_name'] = $val['rolename'];
                $data[$val['id']] = $temp;
            }
        }
        $info['list'] = array_values($data);
        return $info;
    }

    /**
     * 批量审核
     * @param array $ids
     * @return array
     */
    public function batchCheck($ids)
    {
        if (empty($ids)) {
            return LibUtil::retData(false, array(), '请勾选');
        }

        $ids = array_unique(array_filter($ids));
        $ret = $this->vip_mod->batchCheck($ids);
        if (!empty($ret)) {
            $succIds = !empty($ret['succ']) ? "<span class='text-success'>" . implode(',', $ret['succ']) . "</span>" : '无';
            $failIds = !empty($ret['fail']) ? "<span class='text-red'>" . implode(',', $ret['fail']) . "</span>" : '无';
            return LibUtil::retData(true, $ids, '审核成功:' . $succIds . "，审核失败:" . $failIds);
        }
        return LibUtil::retData(false, $ids, '审核失败');
    }

    /**
     * 批量导出VIP档案表
     * @param array $param
     * @return array
     */
    public function recordDownload($param)
    {
        $page = 0;
        if ($param['sdate'] == '') {
            $param['sdate'] = date('Y-m-01');
        }
        if ($param['edate'] == '') {
            $param['edate'] = date('Y-m-d');
        }

        $info = $this->vip_mod->getVipRecord($param['game_id'], $param['name'], $param['account'],
            $param['uid'], $param['sdate'], $param['edate'], $page, $param['parent_id']);
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(false);
        $admins = SrvAuth::allAuth();

        $data = array();
        $data[] = array(
            '母游戏:平台', '用户ID', '账号', '角色名', '区服', '未登录游戏的天数', '联系时间', '充值总额', '联系后充值金额',
            '当天充值金额', '最后充值金额', '最后登录时间', '录入时间', '姓名'
        );
        $time = time();
        foreach ($info['list'] as &$row) {
            $temp = array();
            $platform = $row['platform'] == 1 ? 'IOS' : ($row['platform'] == 2 ? '安卓' : '');
            $loginDay = ceil(($time - $row['login_time']) / (24 * 60 * 60));
            $temp['game_platform'] = $games[$row['c_parent_id']] . ":" . $platform;
            $temp['uid'] = $row['uid'];
            $temp['account'] = $row['account'];
            $temp['role_name'] = $row['rolename'];
            $temp['server_id'] = $row['server_id'];
            $temp['day'] = $loginDay;
            $temp['touch_time'] = !empty($row['touch_time']) ? date('Y-m-d H:i:s', $row['touch_time']) : '';
            $temp['pays'] = !empty($row['pays']) ? number_format($row['pays'] / 100, 2) : 0;
            $temp['link_pay'] = !empty($row['charge_ext']) ? number_format($row['charge_ext'] / 100, 2) : 0;
            $temp['day_pay'] = !empty($row['day_charge']) ? number_format($row['day_charge'] / 100, 2) : 0;
            $temp['total_fee'] = !empty($row['total_fee']) ? number_format($row['total_fee'] / 100) : 0;
            $temp['login_time'] = date('Y-m-d H:i:s', $row['login_time']);
            $temp['insr_time'] = date('Y-m-d H:i:s', $row['insr_time']);
            $temp['insr_kefu'] = $admins[$row['insr_kefu']]['name'];
            $data[] = array_values($temp);
        }

        $file_path = '/uploads/' . date("ym") . '/download/' . LibUtil::token('download') . '/客服VIP_档案表_' . date('Ymd') . '.csv';
        $url = APP_ALL_URL . $file_path;
        $file_dir = dirname(APP_ROOT . $file_path);
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0755, true);
        }

        $ret = LibUtil::write_to_csv(APP_ROOT . $file_path, $data, 'gbk');
        if (!$ret) {
            LibUtil::response('导出数据出错');
        }

        LibUtil::response('导出成功，请下载保存', 1, array('url' => $url));
    }

    /**
     * @param array $param
     * @return array;
     */
    public function vipListDownload($param)
    {
        $page = 0;
        if (empty($param['sdate'])) {
            $param['sdate'] = date('Y-m-d', time());
        }
        if (empty($param['edate'])) {
            $param['edate'] = date('Y-m-d', time());
        }

        $info = $this->vip_mod->vipList($page, $param['parent_id'], $param['game_id'], $param['belong_id'], $param['insr_id']
            , $param['account'], $param['uid'], $param['sdate'], $param['edate'], $param['list_color']);
        $data = array();
        $data[] = array(
            '母游戏:平台', '账号', '用户ID', '角色名', '区服', '联系时间', '归属人', '录入人', '录入时间', '状态', '真实姓名', '手机号', '生日', 'email', 'QQ', '微信号'
        );
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(false);
        $admins = SrvAuth::allAuth();
        foreach ($info['list'] as $row) {
            $temp = array();
            $platformName = $row['platform'] == 1 ? 'IOS' : ($row['platform'] == 2 ? '安卓' : '');
            $gameName = isset($games[$row['game_id']]) ? trim($games[$row['game_id']]) : '';
            $status = $row['status'] == 2 ? '通过' : ($row['status'] == 1 ? '待审核' : '不通过');
            $temp['pname_plat'] = $gameName . ":" . $platformName;
            $temp['account'] = trim($row['account']);
            $temp['uid'] = (int)$row['uid'];
            $temp['role_name'] = $row['rolename'];
            $temp['server_id'] = $row['server_id'];
            $temp['touch_time'] = date("Y-m-d H:i:s", $row['touch_time']);
            $temp['insr'] = $admins[$row['insr_kefu']]['name'];
            $temp['belong'] = $admins[$row['admin_id']]['name'];
            $temp['insr_time'] = date('Y-m-d H:i:s', $row['insr_time']);
            $temp['status'] = $status;
            $temp['real_name'] = !empty($row['real_name']) ? $row['real_name'] : '';
            $temp['phone'] = !empty($row['phone']) ? trim($row['phone']) : '';
            $temp['birthday'] = !empty($row['birth']) ? date('Y-m-d') : '';
            $temp['email'] = !empty($row['email']) ? trim($row['email']) : '';
            $temp['qq'] = !empty($row['qq']) ? $row['qq'] : '';
            $temp['wechat'] = !empty($row['wx_num']) ? $row['wx_num'] : '';
            array_push($data, array_values($temp));
        }

        $file_path = '/uploads/' . date("ym") . '/download/' . LibUtil::token('download') . '/客服VIP表_' . date('Ymd') . '.csv';
        $url = APP_ALL_URL . $file_path;
        $file_dir = dirname(APP_ROOT . $file_path);
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0755, true);
        }

        $ret = LibUtil::write_to_csv(APP_ROOT . $file_path, $data, 'gbk');
        if (!$ret) {
            LibUtil::response('导出数据出错');
        }

        LibUtil::response('导出成功，请下载保存', 1, array('url' => $url));
    }

}

?>