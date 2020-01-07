<?php

class SrvAd
{

    public $mod;

    public function __construct()
    {
        $this->mod = new ModAd();
    }

    public function coopUser($page)
    {
        $page = $page < 1 ? 1 : $page;
        $info['list'] = $this->mod->coopUser($page);
        foreach ($info['list'] as $key => $val) {
            $info['list'][$key]['ct'] = date('Y-m-d', $val['ct']);
            if ($val['last_lt']) {
                $info['list'][$key]['last_lt'] = date('Y-m-d', $val['last_lt']);
            } else {
                $info['list'][$key]['last_lt'] = '';
            }

        }
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return $info;
    }


    public function getChannelList($page)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getChannelList($page);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        return $info;
    }

    public function getAllMonitor($game_id = 0, $channel_id = 0, $admin = '')
    {
        $info = $this->mod->getMonitorList($game_id, $channel_id, $admin);
        $monitors = array(
            '-1' => '自然量',
        );
        foreach ($info as $v) {
            $monitors[$v['monitor_id']] = $v['name'];
        }
        return $monitors;
    }

    public function getChannelInfo($channel_id)
    {
        return $this->mod->getChannelInfo($channel_id);
    }

    public function addChannelAction($channel_id, $data)
    {
        if ($channel_id) {
            unset($data['channel_short']);
            $result = $this->mod->updateChannelAction($channel_id, $data);
        } else {
            $result = $this->mod->addChannelAction($data);
            if ($result) {
                //增加渠道权限
                SrvAuth::addAuth(0, 0, $result);
            }
        }
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function upload($name, $type = array())
    {
        if (empty($type)) {
            $type = array('.jpg', '.png', '.jpeg');
        }
        $result = LibFile::upload($name, PIC_UPLOAD_DIR, PIC_UPLOAD_URL, 10240, $type);
        if ($result['state']) {
            return array('state' => true, 'url' => $result['url'], 'msg' => '上传成功', 'width' => $result['width'], 'height' => $result['height']);
        }
        return array('state' => false, 'msg' => $result['msg']);
    }

    public function getAllChannel($auth = true)
    {
        $channel = SrvAuth::getAuthChannel();
        $info = $this->mod->getChannelList();
//        $channels = array(
//            '0' => '未知',
//        );
        $channels = [];
        if ($info['total'] > 0) {
            foreach ($info['list'] as $v) {
                if (!$auth || empty($channel) || $channel[$v['channel_id']]) {
                    $channels[$v['channel_id']] = $v['channel_name'];
                }
            }
        }
        return $channels;
    }

    public function getAllDeliveryGroup()
    {
        $info = $this->mod->getDeliveryGroup();
        return $info['list'];
    }

    public function getMonitorUrl($channel_short, $monitor_url, $device_type = 0)
    {
        $config = LibUtil::config('ConfAdParam');
        //$desc = explode('-',$channel_short);
        $back = $config[$channel_short] ? $config[$channel_short] : '';
        return AD_DOMAIN . '?_code=' . $monitor_url . '&_os=' . $device_type . $back;

    }

    public function getAdCompanyList($page)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getAdCompanyList($page);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        return $info;
    }

    public function getAdCompanyInfo($company_id)
    {
        return $this->mod->getAdCompanyInfo($company_id);
    }

    public function addAdCompanyAction($company_id, $data)
    {
        if ($data['company_name'] == '') {
            return array('state' => false, 'msg' => '公司名称不能为空');
        }

        if ($company_id) {
            $result = $this->mod->updateAdCompanyAction($company_id, $data);
        } else {
            $result = $this->mod->addAdCompanyAction($data);
        }
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function getDeliveryGroup($page)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getDeliveryGroup($page);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        return $info;
    }

    public function getDeliveryGroupInfo($group_id)
    {
        return $this->mod->getDeliveryGroupInfo($group_id);
    }

    public function addDeliveryGroupAction($group_id, $data)
    {

        if ($data['group_name'] == '') {
            return array('state' => false, 'msg' => '名称不能为空');
        }

        if ($group_id) {
            $result = $this->mod->updateDeliveryGroupAction($group_id, $data);
        } else {
            //添加组员
            $data['group_admin_id'] = SrvAuth::$id;

            $result = $this->mod->addDeliveryGroupAction($data);
        }
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function getDeliveryUser($page, $channel_id, $user_id, $group_id)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getDeliveryUser($page, $channel_id, $user_id, $group_id);
        foreach ($info['list'] as &$row) {
            $row['authorizer_info'] = json_decode($row['authorizer_info'], true);
            $row['access_token_expires_in'] = $row['access_token_expires_in'] ? ceil(($row['access_token_expires_in'] - (time() - $row['time'])) / 60) : 0; //分钟
            $row['refresh_token_expires_in'] = $row['refresh_token_expires_in'] ? ceil(($row['refresh_token_expires_in'] - (time() - $row['time'])) / 86400) : 0; //天
            $row['account_uin'] = $row['authorizer_info']['account_uin'];

            $url = LibChannel::getAuthorizeUrl($row['user_id'], $row['channel_short']);
            if ($url) {
                $row['auth_url'] = $url;
            }
        }

        if ($channel_id) {
            $SrvExtend = new SrvExtend();
            $info['users'] = $SrvExtend->getUserByChannel($channel_id);
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $info['user_id'] = $user_id;
        $info['group_id'] = $group_id;
        $info['channel_id'] = $channel_id;

        return $info;
    }

    public function editCpUserAction($data, $cp_id)
    {
        $password = 0;
        if ($data['pwd']) {
            if ($data['pwd'] != $data['pwd2']) {
                return array('state' => false, 'msg' => '两次输入密码不一致');
            }
            if (preg_match('/[a-zA-Z]/', $data['pwd']) == 0) {
                return array('state' => false, 'msg' => '密码必须包含字母');
            }
            if (preg_match('/[0-9]/', $data['pwd']) == 0) {
                return array('state' => false, 'msg' => '密码必须包含数字');
            }
            if (strlen($data['pwd']) < 6) {
                return array('state' => false, 'msg' => '密码不能低于6位');
            }
            $password++;
        }

        //game_id
        $game_id = '';
        foreach ($data['game_id'] as $key => $val) {
            $game_id .= $val . '|';
        }
        $data['game_id'] = rtrim($game_id, '|');
        $channel_id = '';
        foreach ($data['channel_id'] as $key => $val) {
            $channel_id .= $val . '|';
        }
        $data['channel_id'] = rtrim($channel_id, '|');
        $gamePackage = '';
        foreach ($data['gamePackage'] as $key => $val) {
            $gamePackage .= $val . '|';
        }
        $data['gamePackage'] = rtrim($gamePackage, '|');
        $menu = '';
        foreach ($data['menu'] as $key => $val) {
            $menu .= $val . '|';
        }
        $data['menu'] = rtrim($menu, '|');
        $items = '';
        foreach ($data['items'] as $key => $val) {
            $items .= $val . '|';
        }
        $data['items'] = rtrim($items, '|');

        $result = $this->mod->editCpUserAction($data, $cp_id, $password);

        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function delCoopUser($id)
    {
        $res = $this->mod->delCoopUser($id);
        if ($res) {
            return array('state' => true, 'msg' => '删除成功');
        } else {
            return array('state' => false, 'msg' => '删除失败');
        }
    }

    public function addCpUserAction($data)
    {
        if ($data['pwd']) {
            if ($data['pwd'] != $data['pwd2']) {
                return array('state' => false, 'msg' => '两次输入密码不一致');
            }
            if (preg_match('/[a-zA-Z]/', $data['pwd']) == 0) {
                return array('state' => false, 'msg' => '密码必须包含字母');
            }
            if (preg_match('/[0-9]/', $data['pwd']) == 0) {
                return array('state' => false, 'msg' => '密码必须包含数字');
            }
            if (strlen($data['pwd']) < 6) {
                return array('state' => false, 'msg' => '密码不能低于6位');
            }
        }
        $res = $this->mod->checkUser($data['user']);
        if ($res['c'] > 0) {
            return array('state' => false, 'msg' => '该用户名已经存在');
        }
        //game_id
        $game_id = '';
        foreach ($data['game_id'] as $key => $val) {
            $game_id .= $val . '|';
        }
        $data['game_id'] = rtrim($game_id, '|');
        $channel_id = '';
        foreach ($data['channel_id'] as $key => $val) {
            $channel_id .= $val . '|';
        }
        $data['channel_id'] = rtrim($channel_id, '|');
        $gamePackage = '';
        foreach ($data['gamePackage'] as $key => $val) {
            $gamePackage .= $val . '|';
        }
        $data['gamePackage'] = rtrim($gamePackage, '|');
        $menu = '';
        foreach ($data['menu'] as $key => $val) {
            $menu .= $val . '|';
        }
        $data['menu'] = rtrim($menu, '|');
        $items = '';
        foreach ($data['items'] as $key => $val) {
            $items .= $val . '|';
        }
        $data['items'] = rtrim($items, '|');

        $result = $this->mod->addCpUserAction($data);

        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function getDeliveryUserInfo($user_id)
    {
        return $this->mod->getDeliveryUserInfo($user_id);
    }

    public function addDeliveryUserAction($user_id, $data)
    {
        if ($data['user_name'] == '') {
            return array('state' => false, 'msg' => '投放账号不能为空');
        }

        if ($user_id) {
            $result = $this->mod->updateDeliveryUserAction($user_id, $data);
        } else {
            $result = $this->mod->addDeliveryUserAction($data);
            if ($result) {
                //增加投放账号权限
                SrvAuth::addAuth(0, 0, 0, $result);
            }
        }
        if ($result) {
            $this->clearCacheChannelUser();

            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function getGamePackage($game_id, $channel_id)
    {
        if (!$game_id) {
            return array(
                'state' => true,
                'msg' => '',
            );
        }
        $data = $this->mod->getGamePackage($game_id, $channel_id);

        return array(
            'state' => true,
            'msg' => $data,
        );
    }

    public function getGamePackages($game_id, $channel_id)
    {
        if (!$game_id) {
            return array(
                'state' => true,
                'msg' => '',
            );
        }
        $data = $this->mod->getGamePackages($game_id, $channel_id);

        return array(
            'state' => true,
            'msg' => $data,
        );
    }

    public function getCoopUser($id)
    {
        $data = $this->mod->getCoopUser($id);

        $game = explode('|', $data['game']);
        $channel = explode('|', $data['channel']);
        $package = explode('|', $data['package']);
        $menu = explode('|', $data['menu']);
        $item = explode('|', $data['item']);

        $pGame = str_replace('|', ',', $data['game']);
        $pChannel = str_replace('|', ',', $data['channel']);
        $data['android'] = 0;
        foreach ($package as $key => $val) {
            if (strstr($val, 'android')) {
                $data['android'] = 1;
                break;
            }
        }

        $_package = $this->_getGamePackage($pGame, $pChannel, $data['android']);

        $_package = $_package['msg'];

        $data['game'] = $game;
        $data['channel'] = $channel;
        $data['package'] = $package;
        $data['_package'] = $_package;
        $data['menu'] = $menu;
        $data['item'] = $item;

        return $data;
    }

    public function _getGamePackage($game_id, $channel_id, $android)
    {
        if (!$game_id) {
            return array(
                'state' => true,
                'msg' => '',
            );
        }
        $data = $this->mod->_getGamePackage($game_id, $channel_id, $android);

        return array(
            'state' => true,
            'msg' => $data,
        );
    }

    /**
     * 获取授权信息
     *
     * @param int $user_id
     * @return array|bool|resource|string
     */
    public function getChannelUserAuthInfo($user_id = 0)
    {
        return $this->mod->getChannelUserAuthInfo($user_id);
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
        return $this->mod->getChannelUserAuthInfoByCid($client_id, $account_id);
    }

    /**
     * 刷新渠道授权时间
     *
     * @param int $user_id
     * @return array
     */
    public function channelRefreshUserAuth($user_id = 0)
    {
        if (!$user_id) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $row = $this->mod->getChannelUserAuthInfo($user_id);
        if (empty($row)) {
            return array('state' => false, 'msg' => '记录不存在');
        }

        //获取配置信息
        $config = LibUtil::config('channel_auth');
        $cnf = $config[$row['client_id']];
        if (empty($cnf)) {
            return array('state' => false, 'msg' => '渠道未配置');
        }

        $ret = LibChannel::getAccessTdeliveryUseroken($row['client_id'], $row['account_id'], true);
        if (empty($ret)) {
            return array('state' => false, 'msg' => '授权刷新失败[1]');
        }

        if (!$ret['update']) {
            return array('state' => false, 'msg' => '授权刷新失败[2]');
        }

        return array('state' => true, 'msg' => '');
    }

    /**
     * 更新渠道授权信息
     *
     * @param int $user_id
     * @param array $param
     * @return mixed
     */
    public function channelUpdateUserAuth($user_id = 0, $param = [])
    {
        $data = array(
            'access_token' => $param['access_token'],
            'refresh_token' => $param['refresh_token'],
            'access_token_expires_in' => (int)$param['access_token_expires_in'],
            'time' => $param['time'],
        );

        return $this->mod->updateChannelUserAuthInfo($user_id, $data);
    }

    /**
     * 获取数据源列表
     *
     * @param int $page
     * @param int $user_id
     * @return array
     */
    public function channelUserAppList($page = 1, $user_id = 0)
    {
        $info = [];
        $page = $page < 1 ? 1 : $page;
        $row = $this->mod->getChannelUserAuthInfo($user_id);
        if (!empty($row) && $row['account_id']) {
            $info = $this->mod->getChannelUserAppList($page, $row['account_id']);
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['user_id'] = $row['user_id'];
        $info['client_id'] = $row['client_id'];

        return $info;
    }

    /**
     * 添加数据源
     *
     * @param array $info
     * @param array $data
     * @return array
     */
    public function channelAddUserAppAction($info = [], $data = [])
    {
        if (!$data['client_id'] || !$data['account_id']) {
            return array('state' => false, 'msg' => '参数错误');
        }
        if (!$data['mobile_app_id']) {
            return array('state' => false, 'msg' => '请填写MOBILE_APP_ID');
        }

        $param = array(
            'access_token' => $info['access_token'],
            'account_id' => $info['account_id'],
            'type' => $data['type'],
            'mobile_app_id' => $data['mobile_app_id'],
            'description' => $data['description']
        );
        $ret = LibChannel::userActionSetsAdd($data['client_id'], $param);
        if (empty($ret)) {
            return array('state' => false, 'msg' => '请求API失败');
        }

        if ($ret['code'] != 0) {
            return array('state' => false, 'msg' => $ret['message']);
        }

        $user_action_set_id = $ret['data']['user_action_set_id'];
        if (empty($user_action_set_id)) {
            return array('state' => false, 'msg' => '创建数据源失败[1]');
        }

        $insertData = array(
            'account_id' => $info['account_id'],
            'type' => $data['type'],
            'mobile_app_id' => $data['mobile_app_id'],
            'description' => $data['description'],
            'user_action_set_id' => $user_action_set_id,
            'create_time' => time()
        );
        $ret = $this->mod->channelAddUserAppAction($insertData);
        if ($ret) {
            LibChannel::setUserActionIdCache($info['account_id'], $data['mobile_app_id'], $user_action_set_id);

            return array('state' => true, 'msg' => '创建成功');
        } else {
            return array('state' => false, 'msg' => '创建数据源失败[2]');
        }
    }

    /**
     * 获取数据源
     *
     * @param int $user_id
     * @return array
     */
    public function channelGetUserApp($user_id = 0)
    {
        if (!$user_id) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $row = $this->mod->getChannelUserAuthInfo($user_id);
        if (empty($row)) {
            return array('state' => false, 'msg' => '获取授权信息失败');
        }

        $ret = LibChannel::userActionSetsGet($row['client_id'], $row['account_id']);
        if (empty($ret)) {
            return array('state' => false, 'msg' => '请求API失败');
        }

        if ($ret['code'] != 0) {
            return array('state' => false, 'msg' => $ret['message']);
        }

        if (empty($ret['data']['list'])) {
            return array('state' => false, 'msg' => '数据源为空，请先创建数据源');
        }

        $time = time();
        foreach ($ret['data']['list'] as $v) {
            if (!$v['user_action_set_id']) {
                continue;
            }

            $data = array(
                'account_id' => $row['account_id'],
                'type' => $v['type'],
                'mobile_app_id' => $v['mobile_app_id'],
                'description' => $v['description'],
                'user_action_set_id' => $v['user_action_set_id'],
                'create_time' => $time
            );
            $result = $this->mod->channelAddUserAppAction($data);
            if ($result) {
                LibChannel::setUserActionIdCache($data['account_id'], $data['mobile_app_id'], $data['user_action_set_id']);
            }
        }

        return array('state' => true, 'msg' => '获取成功');
    }

    /**
     * 更新数据源缓存
     *
     * @param int $user_id
     * @return array
     */
    public function clearCacheChannelUserApp($user_id = 0)
    {
        if (!$user_id) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $row = $this->mod->getChannelUserAuthInfo($user_id);
        if (empty($row)) {
            return array('state' => false, 'msg' => '记录不存在');
        }

        if (!empty($row) && $row['account_id']) {
            $info = $this->mod->getChannelUserAppList(0, $row['account_id']);
            $c = $t = 0;
            foreach ($info['list'] as $v) {
                $c++;
                if ($v['mobile_app_id'] && $v['user_action_set_id']) {
                    $ret = LibChannel::setUserActionIdCache($v['account_id'], $v['mobile_app_id'], $v['user_action_set_id']);
                    $ret && $t++;
                }
            }

            return array('state' => true, 'msg' => "共{$c}条记录，更新成功{$t}条");
        }

        return array('state' => false, 'msg' => '更新失败');
    }

    /**
     * 更新渠道投放账号缓存
     */
    public function clearCacheChannelUser()
    {
        $data = [];
        $info = $this->mod->getChannelUserList();
        foreach ($info as $row) {
            $data[$row['user_id']] = $row;
        }

        LibUtil::config('channel_user', $data);

        return array('state' => true);
    }

    /**
     * 获取所有投放账号列表
     * @return array
     */
    public function getAllChannelUser()
    {
        $data = [];
        $info = $this->mod->getChannelUserList();
        foreach ($info as $row) {
            $data[$row['channel_id']]['id'] = $row['channel_id'];
            $data[$row['channel_id']]['text'] = $row['channel_name'];
            $data[$row['channel_id']]['children'][$row['user_id']]['id'] = $row['user_id'];
            $data[$row['channel_id']]['children'][$row['user_id']]['text'] = $row['user_name'];
        }

        $channel = $this->getAllChannel(false);
        foreach ($channel as $channel_id => $name) {
            if (!isset($data[$channel_id])) {
                $data[$channel_id] = array(
                    'id' => $channel_id,
                    'text' => $name,
                    'children' => []
                );
            }
        }

        return $data;
    }
}