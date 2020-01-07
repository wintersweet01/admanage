<?php

require_once LIB . '/library/GatewayClient/Gateway.php';

use GatewayClient\Gateway;

class SrvPlatform
{

    private $mod;

    public function __construct()
    {
        $this->mod = new ModPlatform();
    }

    public function delApiConf($id)
    {
        $res = $this->mod->delApiConf($id);
        if ($res) {
            return array(
                'state' => true, 'msg' => '删除成功！'
            );
        } else {
            return array(
                'state' => false, 'msg' => '删除失败！'
            );
        }
    }

    public function apiConfigs($id)
    {
        $data['list'] = $this->mod->apiConfigs($id);
        return $data;
    }

    public function apiConfList($page, $game_id)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->apiConfList($page, $game_id);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['game_id'] = $game_id;
        return $info;
    }

    public function serverPlanList($page, $game_id)
    {
        $page = $page < 1 ? 1 : $page;

        $info = $this->mod->serverPlanList($page, $game_id);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['game_id'] = $game_id;
        return $info;
    }

    public function mergeServerList($page, $game_id, $merge_server_id)
    {
        $page = $page < 1 ? 1 : $page;

        $info = $this->mod->mergeServerList($page, $game_id, $merge_server_id);


        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['game_id'] = $game_id;
        $info['merge_server_id'] = $merge_server_id;

        return $info;
    }

    public function mergeServerAct($data)
    {
        foreach ($data['server_id'] as $key => $val) {

            $is_exist = $this->mod->checkMergeExist($data, $val);

            $insert = array();
            if (!$is_exist['c']) {
                $insert['game_id'] = $data['game_id'];
                $insert['merge_server_id'] = $data['merge_server_id'];
                $insert['server_id'] = $val;
                $insert['merge_date'] = $data['date'];

                $this->mod->insertMergeServer($insert);
            }
        }
        return array('state' => true, 'msg' => '操作成功');

    }

    /**
     * 获取游戏列表 分页版本
     * @param int $page
     * @param int $limit
     * @param array $param
     * @return array
     */
    public function getGameList_page($page = 1, $limit = 15, $param = array())
    {
        $ip = LibUtil::getIp();
        $client_game = [];
        $page = $page < 1 ? 1 : $page;

        //连接socket
        if ($ip != '127.0.0.1') {
            Gateway::$registerAddress = '127.0.0.1:1238';
            $client = Gateway::getAllClientSessions();
            foreach ($client as $row) {
                $session = $row['data'];
                $gid = (int)$session['game_id'];
                if ($gid > 0) {
                    $client_game[$gid] += 1;
                }
            }
        }

        $data = $client_parent = $games = [];
        $info = $this->mod->getGameList_page($page, $limit, $param);
        foreach ($info['list'] as $i) {
            $config = unserialize($i['config']);
            unset($i['config']);

            $i['id'] = &$i['game_id'];
            $i['pid'] = &$i['parent_id'];
            $i['inherit'] = (int)$config['inherit'];
            $i['device_status'] = $i['device_type'] == 1 ? $config['status']['ios'] : $config['status']['android'];
            $i['is_upload'] = false;
            $i['online'] = '-';

            if ($i['pid'] > 0) {
                $games[] = $i['id'];
            }

            $file = APK_MODEL_DIR . $i['game_id'] . '_' . $i['package_version'] . '/model.apk';
            if (is_file($file)) {
                $i['is_upload'] = true;
            }

            //客户端在线人数
            if ($client_game[$i['game_id']]) {
                $i['online'] = $client_game[$i['game_id']];

                if ($i['pid']) {
                    $client_parent[$i['pid']] += $i['online'];
                }
            }

            $data[$i['id']] = $i;
        }

        //母游戏总在线
        foreach ($client_parent as $pid => $online) {
            $data[$pid]['online'] = $online;
        }

        //获取分包状态
        if (!empty($games)) {
            $tmp = $this->mod->getRefreshPackageCount($games);
            foreach ($tmp as $row) {
                $data[$row['game_id']]['refresh'] = (int)$row['total'];
            }
        }

        /* 联运平台
        if ($page > 0 && !empty($games)) {
            $platform_game = $this->mod->getPlatformGameList(0, $games, 0);
        } else {
            $platform_game = $this->mod->getPlatformGameList();
        }

        foreach ($platform_game['list'] as $row) {
            $id = 100 . $row['game_id'] . $row['platform_id'];
            $tmp = array(
                'id' => $id,
                'pid' => (int)$row['game_id'],
                'name' => &$row['platform_name'],
                'alias' => &$row['platform_alias'],
                'status' => &$row['lock'],
                'is_login' => &$row['is_login'],
                'is_pay' => &$row['is_pay'],
                'open_time' => &$row['open_time'],
                'create_time' => &$row['create_time'],
                'update_time' => &$row['update_time'],
                'platform_id' => &$row['platform_id'],
                'game_id' => &$row['game_id'],
                'game_name' => &$row['game_name'],
                'platform_name' => &$row['platform_name'],
                'online' => '-'
            );

            $data[$id] = $tmp;
        }
        */

        krsort($data);

        return array(
            'data' => array_values($data),
            'count' => (int)$info['total']
        );
    }

    public function getGameList($page = 0, $type = '', $key_word = '')
    {
        $ip = LibUtil::getIp();
        $page = 0;
        $client_game = [];

        //权限
        $auth_parent_id = SrvAuth::$auth_parent_id ? explode(',', SrvAuth::$auth_parent_id) : [];
        $auth_game_id = SrvAuth::$auth_game_id ? explode(',', SrvAuth::$auth_game_id) : [];

        //连接创玩SDK注册端口
        if ($ip != '127.0.0.1') {
            Gateway::$registerAddress = '127.0.0.1:1238';
            $client = Gateway::getAllClientSessions();
            foreach ($client as $row) {
                $session = $row['data'];
                $gid = (int)$session['game_id'];
                if ($gid > 0) {
                    $client_game[$gid] += 1;
                }

            }
        }
        $data = $client_parent = [];
        $info = $this->mod->getGameList($page);
        foreach ($info['list'] as &$i) {
            $i['id'] = &$i['game_id'];
            $i['pid'] = &$i['parent_id'];
            $i['config'] = unserialize($i['config']);
            $i['refresh'] = $this->mod->getRefreshPackage($i['game_id']);
            $i['is_upload'] = false;
            $i['online'] = '-';

            $file = APK_MODEL_DIR . $i['game_id'] . '_' . $i['package_version'] . '/model.apk';
            if (is_file($file)) {
                $i['is_upload'] = true;
            }

            //客户端在线人数
            if ($client_game[$i['game_id']]) {
                $i['online'] = $client_game[$i['game_id']];

                if ($i['pid']) {
                    $client_parent[$i['pid']] += $i['online'];
                }
            }

            $data[$i['id']] = $i;
        }

        foreach ($client_parent as $pid => $online) {
            $data[$pid]['online'] = $online;
        }

        //权限检查，排除超级管理员、母游戏和子游戏都为空
        $tmp = [];
        if (SrvAuth::$id == 1 || (empty($auth_parent_id) && empty($auth_game_id))) {
            $tmp = &$data;
        } else {
            foreach ($data as $row) {
                if (!empty($auth_parent_id) && in_array($row['pid'], $auth_parent_id)) {
                    $tmp[$row['id']] = $row;
                } elseif (!empty($auth_game_id) && in_array($row['id'], $auth_game_id)) {
                    $tmp[$row['id']] = $row;
                    $tmp[$row['pid']] = $data[$row['pid']];
                }
            }
            foreach ($auth_parent_id as $pid) {
                $tmp[$pid] = $data[$pid];
            }
            unset($data);
        }

        krsort($tmp);

        return json_encode(array_values($tmp));
    }

    public function getAllServer()
    {
        $info = $this->mod->getAllServer();

        $data = array();
        if ($info) {
            foreach ($info as $v) {
                $data[$v['game_id']][$v['server_id']] = $v['server_name'];
            }
        }

        return $data;
    }

    /**
     * 获取游戏列表
     * @param int $new 新方式
     * @param bool $auth 是否开启权限验证
     * @param null $type 获取的游戏类型
     * @param array $exclude_game 排除的游戏
     * @return array
     */
    public function getAllGame($new = 0, $auth = true, $type = null, $exclude_game = array())
    {
        $auth_parent_id = SrvAuth::$auth_parent_id ? explode(',', SrvAuth::$auth_parent_id) : [];
        $auth_game_id = SrvAuth::$auth_game_id ? explode(',', SrvAuth::$auth_game_id) : [];

        $info = $this->mod->getGameList();
        $games = array();
        while (true) {
            if (!$info['total']) {
                break;
            }

            $tmp = $data = $list = [];
            foreach ($info['list'] as &$v) {
                //排除游戏
                if (!empty($exclude_game) && in_array($v['game_id'], $exclude_game)) {
                    continue;
                }

                $v['config'] = unserialize($v['config']);
                $tmp[$v['game_id']] = array(
                    'pid' => (int)$v['parent_id'],
                    'id' => (int)$v['game_id'],
                    'text' => $v['name'],
                    'inherit' => (int)$v['config']['inherit'],
                    'alias' => $v['alias'],
                    'status' => $v['status'],
                    'type' => (int)$v['type']
                );

                $list[$v['game_id']] = $v['name'];
            }

            if (!$new) {
                $games = &$list;
                break;
            }

            if ($new === 2) {
                $games = &$tmp;
                break;
            }

            //只获取type一致的游戏
            if (is_numeric($type)) {
                $_parent = $_tmp = array();
                foreach ($tmp as $key => $val) {
                    if ($val['type'] == $type) {
                        $_tmp[$key] = $val;
                        if ($val['pid'] > 0) {
                            $_parent[$val['pid']] = $tmp[$val['pid']];
                        }
                    }
                }
                $tmp = array_merge($_tmp, $_parent);
            }

            //权限检查，排除超级管理员、不验证权限、母游戏和子游戏都为空
            if (SrvAuth::$id == 1 || !$auth || (empty($auth_parent_id) && empty($auth_game_id))) {
                $data = &$tmp;
            } else {
                foreach ($tmp as $row) {
                    if (!empty($auth_parent_id) && in_array($row['pid'], $auth_parent_id)) {
                        $data[$row['id']] = $row;
                    } elseif (!empty($auth_game_id) && in_array($row['id'], $auth_game_id)) {
                        $data[$row['id']] = $row;
                        $data[$row['pid']] = $tmp[$row['pid']];
                    }
                }
                foreach ($auth_parent_id as $pid) {
                    $data[$pid] = $tmp[$pid];
                }
                unset($tmp);
            }

            krsort($data);

            $games = array(
                'parent' => LibUtil::build_tree($data, 0),
                'list' => $list
            );

            break;
        }

        return $games;
    }

    public function getGameInfo($game_id)
    {
        return $this->mod->getGameInfo($game_id);
    }

    public function addGameAction($game_id, $data)
    {
        if (!$data['name'] || !$data['alias']) {
            return array('state' => false, 'msg' => '请填写游戏名称和别名');
        }

        if (!preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]+$/u', $data['name'])) {
            return array('state' => false, 'msg' => '游戏名称只能由中文、字母、数字和减号组成的字符串');
        }

        if (!preg_match('/^[a-z0-9-]+$/', $data['alias'])) {
            return array('state' => false, 'msg' => '游戏别名只能由字母、数字和减号组成的小写字符串');
        }

        $games = LibUtil::config('games');
        if (!$games) $games = array();

        $parent_id = (int)$data['parent_id'];
        if ($parent_id > 0 && isset($games[$parent_id['type']]) && $games[$parent_id['type']] != $data['type']) {
            return array('state' => false, 'msg' => '您选择的母游戏属性和当前属性不一致');
        }

        //继承父游戏
        if ((int)$data['children_id'] > 0) {
            $data['config']['inherit'] = (int)$data['children_id'];
        }

        $data['type'] = (int)$data['type'];
        $data['device_type'] = (int)$data['device_type'];
        $data['ratio'] = (int)$data['ratio'];
        $data['unit'] = (int)$data['unit'];
        $data['status'] = isset($data['status']) ? (int)$data['status'] : 1;
        $data['is_login'] = (int)$data['is_login'];
        $data['is_reg'] = (int)$data['is_reg'];
        $data['is_pay'] = (int)$data['is_pay'];

        unset($data['game_id'], $data['children_id']);

        $time = time();
        if ((int)$data['status'] == 1) {
            $data['close_time'] = $time;
        } else {
            $data['close_time'] = 0;
        }

        if ($game_id) {
            $arr = $this->getGameInfo($game_id);
            $arr['config'] = unserialize($arr['config']);
            if ($arr['config']['signature']) {
                $data['config']['signature'] = $arr['config']['signature'];
            }

            $data['update_time'] = $time;
            $result = $this->mod->updateGameAction($game_id, $data);
            if ($result) {
                //母游戏操作
                if ($data['type'] === 0) {
                    $gids = array();
                    $info = $this->mod->getGamesListByPid($game_id);
                    if ($info) {
                        foreach ($info as $row) {
                            $row['status'] = $data['status'];

                            $games[$row['game_id']] = $row;
                            $gids[] = $row['game_id'];
                        }
                    }

                    //更改对应所有子游戏的状态
                    if ($gids) {
                        $this->mod->updateData(LibTable::$sy_game, array('status' => $data['status']), array('game_id' => $gids));
                    }
                }
            }
        } else {
            $data['sdk_key'] = LibUtil::token('sdk');
            $data['server_key'] = LibUtil::token('cp');
            $data['create_time'] = $time;
            $data['package_version'] = 1;
            $result = $this->mod->addGameAction($data);
            $game_id = &$result;

            if ($game_id) {
                if ((int)$data['parent_id'] > 0) {
                    //增加子游戏权限
                    SrvAuth::addAuth(0, $game_id);
                } else {
                    //增加母游戏
                    SrvAuth::addAuth($game_id);
                }
            }
        }

        if ($result) {
            $data = $this->mod->getGameInfo($game_id);
            $games[$game_id] = $data;
            LibUtil::config('games', $games);

            if (LibUtil::getIp() == '127.0.0.1') {
                self::sync('config', array('file' => 'games', 'content' => $games));
            }

            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    /**
     * 删除游戏分包
     * @param $id
     * @return array
     */
    public function delPackage($id)
    {
        $info = $this->mod->getPackageInfo($id);
        if ($info['package_name']) {
            $arr = $this->mod->getLinkByPackage($info['package_name']);
            if (!empty($arr)) {
                return array('state' => false, 'msg' => '该包还在使用中，不能删除');
            }
        }

        $result = $this->mod->delPackage($id);
        if ($result) {
            if ($info['down_url']) {
                preg_match('/^http[s]?:\/\/(.*)\/(.*)\.apk$/', $info['down_url'], $matches);
                $file = APK_DIR . $matches[2] . '.apk';
                if (!empty($matches[2]) && is_file($file)) {
                    //从CDN上删除
                    unlink($file);
                }
            }

            if ($info['package_name']) {
                $this->mod->delPackageRefresh($info['package_name']);
            }

            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    /**
     * 删除全部已经关闭游戏的分包
     * @return array
     */
    public function delPackageAll()
    {
        $ids = $packages = array();
        $info = $this->mod->getAbandonPackageList();
        foreach ($info as $row) {
            $ids[] = (int)$row['id'];
            $packages[] = $row['package_name'];

            if ($row['down_url']) {
                preg_match('/^http[s]?:\/\/(.*)\/(.*)\.apk$/', $row['down_url'], $matches);
                $file = APK_DIR . $matches[2] . '.apk';
                if (!empty($matches[2]) && is_file($file)) {
                    //从CDN上删除
                    unlink($file);
                }
            }
        }

        $error = 0;
        if (!empty($ids)) {
            $ret = $this->mod->delPackage($ids);
            if (!$ret) {
                $error += 1;
            }
        }

        if (!empty($packages)) {
            $this->mod->delPackageRefresh($packages);
        }

        return array('state' => true, 'msg' => '删除成功<br><br><span class="red">共删除：' . count($ids) . '条，失败：' . $error . '</span>');
    }

    private static function sync($function, $data, $return = false)
    {
        $url = COMMUNITY_DOMAIN . '?ac=' . $function;
        $string = LibCrypt::encode(json_encode($data), COMMUNITY_KEY);
        $param = array(
            'data' => $string
        );
        $result = LibUtil::request($url, $param);
        $json = json_decode($result['result'], true);
        if ($result['code'] == 200 && $json['state'] == 1) {
            return $return ? $json : true;
        } else {
            Debug::log($result, 'error');
        }
        return $return ? $json : false;
    }

    public function getPackageList($param, $page = 1, $limit = 10)
    {
        $games = LibUtil::config('games');
        $info = $this->mod->getPackageList($param, $page, $limit);
        foreach ($info['list'] as &$row) {
            $row['parent_name'] = $games[$row['parent_id']]['name'];
            $row['game_name'] = $games[$row['game_id']]['name'];
            $row['device_type'] = &$row['platform'];

            if ($row['platform'] == PLATFORM['ios']) {
                $row['down_url'] = APPSTORE_URL . $row['down_url'];
            }
        }

        return $info;
    }

    public function getPackageInfo($package_id)
    {
        return $this->mod->getPackageInfo($package_id);
    }

    public function getPackageInfoByPackageName($package_name = '')
    {
        return $this->mod->getPackageInfoByPackageName($package_name);
    }

    public function addPackageAction($package_id, $data)
    {
        if ($data['platform'] == PLATFORM['ios'] && !$data['down_url']) {
            return array('state' => false, 'msg' => 'appstore_id不能为空');
        }

        $package_num = $data['package_num'];
        unset($data['package_num']);

        $data['administrator'] = SrvAuth::get_cookie('ht_name', true);
        if ($package_id) {
            unset($data['game_id']);
            unset($data['platform']);
            unset($data['channel_id']);
            unset($data['spec_name']);
            $data['update_time'] = time();
            $result = $this->mod->updatePackageAction($package_id, $data);
        } else {
            if (!$data['game_id']) {
                return array('state' => false, 'msg' => '请选择游戏');
            }

            if (!in_array($data['platform'], array(PLATFORM['ios'], PLATFORM['android'], 3))) {
                return array('state' => false, 'msg' => '请选择平台');
            }

            if ($data['platform'] == PLATFORM['ios'] && !$data['spec_name']) {
                return array('state' => false, 'msg' => 'bundleID不能为空');
            }

            if ($data['platform'] == PLATFORM['ios'] && !preg_match('/^[a-z0-9-]+$/', $data['spec_name'])) {
                return array('state' => false, 'msg' => 'bundleID只能由字母、数字和减号组成的小写字符串');
            }

            if ($data['platform'] == PLATFORM['android'] && !$package_num) {
                return array('state' => false, 'msg' => '请填写分包数量');
            }

            //检查是否有进行中的任务
            $ing = $this->mod->subingPackage($data['game_id'], $data['channel_id']);
            if ($ing > 0) {
                return array('state' => false, 'msg' => '该渠道有任务正在进行，请等待完成后再分包');
            }

            $data['create_time'] = time();

            $modAd = new ModAd();
            $game_info = $this->mod->getGameInfo($data['game_id']);
            $channel_info = $modAd->getChannelInfo($data['channel_id']);
            $data['package_version'] = $game_info['package_version'];
            $data['sdk_version'] = $game_info['sdk_version'];

            $package_count = $this->mod->countGamePackage($game_info['game_id'], $channel_info['channel_id']) + 1;

            if ($data['platform'] == PLATFORM['ios']) {
                //$data['package_name'] = $this->getNewPackageName($game_info, $data['platform'], $channel_info, $package_count);
                $data['package_name'] = $data['spec_name'] . '_ios_' . $channel_info['channel_short'] . '_' . $package_count;
                $data['package_number'] = $package_count;
                $result = $this->mod->addPackageAction($data);
            } elseif ($data['platform'] == PLATFORM['android']) {
                //检查母包
                $modelApk = APK_MODEL_DIR . self::modelApkName($game_info['game_id'], $game_info['package_version']);
                if (!is_file($modelApk)) {
                    return array('state' => false, 'msg' => '母包不存在，请先上传母包');
                }

                $game_config = unserialize($game_info['config']);
                if (empty($game_config) || !$game_config['signature']) {
                    return array('state' => false, 'msg' => '游戏未选择签名文件');
                }

                $signature = SIGNATURE_APK[$game_config['signature']];
                if (empty($signature)) {
                    return array('state' => false, 'msg' => '签名配置不存在');
                }

                $insert = array();
                for ($i = 0; $i < $package_num; $i++) {
                    $insert[] = array(
                        'game_id' => $data['game_id'],
                        'package_version' => $data['package_version'],
                        'sdk_version' => $data['sdk_version'],
                        'package_name' => $this->getNewPackageName($game_info, $data['platform'], $channel_info, $package_count + $i),
                        'submit_time' => time(),
                        'is_new' => 1,
                        'channel_id' => $data['channel_id'],
                        'user_id' => $data['user_id'],
                        'administrator' => SrvAuth::$name,
                    );
                }
                $result = $this->mod->subNewPackage($insert);
                if ($result) {
                    //直接调起分包处理函数
                    //YX::call('/sub_package/sub/package');
                }
            } else {
                $data['platform'] = PLATFORM['android'];
                $data['package_name'] = $this->getNewPackageName($game_info, $data['platform'], $channel_info, $package_count);
                $data['package_number'] = $package_count;
                $result = $this->mod->addPackageAction($data);
            }
        }
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    private static function preSubApk($modelApk)
    {
        $path = pathinfo($modelApk);
        Debug::log("解压中：cd {$path['dirname']} && unzip -fo {$path['basename']}");
        exec("cd {$path['dirname']} && unzip {$path['basename']}", $out, $code);
        //Debug::log($out);
        if ($code !== 0) {
            //Debug::log('解压失败');
            //return false;
        }
        Debug::log("删除签名文件中：cd {$path['dirname']} && rm -rf META-INF/");
        exec("cd {$path['dirname']} && rm -rf META-INF", $out, $code);
        Debug::log($out);
        if ($code !== 0) {
            Debug::log('删除签名文件失败');
            return false;
        }
        return true;
    }

    private static function subApk($modelApk, $package_name, $channel_id)
    {
        $path = pathinfo($modelApk);
        $json = json_encode(array(
            'channel_id' => $channel_id,
            'package_name' => $package_name,
        ));
        $result = file_put_contents($path['dirname'] . '/assets/package.json', $json);
        if (!$result) {
            Debug::log('修改package.json文件失败');
            return false;
        }

        $unsignApk = $package_name . 'unsign.apk';
        Debug::log("压缩中：cd {$path['dirname']} && zip -r {$unsignApk} ./* -x model.apk");
        exec("cd {$path['dirname']} && zip -r {$unsignApk} ./* -x model.apk", $out, $code);

        Debug::log($out);
        if ($code !== 0) {
            Debug::log('压缩失败');
            return false;
        }
        Debug::log("签名中：cd {$path['dirname']} && jarsigner -verbose -digestalg SHA1 -sigalg MD5withRSA -keystore *** -storepass *** -signedjar " . APK_DIR . "{$package_name}.apk {$unsignApk} ***");
        exec("cd {$path['dirname']} && jarsigner -verbose -digestalg SHA1 -sigalg MD5withRSA -keystore " . APK_MODEL_DIR . "key.jks -storepass " . 'password' . " -signedjar " . APK_DIR . "{$package_name}.apk {$unsignApk} " . "shortname", $out, $code);
        //Debug::log($out);
        if ($code !== 0) {
            //Debug::log('签名失败');
            //return false;
        }

        Debug::log("删除未签名文件中：cd {$path['dirname']} && rm -rf {$unsignApk}");
        exec("cd {$path['dirname']} && rm -rf {$unsignApk}", $out, $code);
        Debug::log($out);
        if ($code !== 0) {
            Debug::log('删除未签名文件失败');
        }

        return APK_CDN_URL . $package_name . '.apk';
    }

    private function getNewPackageName($game_info, $platform, $channel_info, $package_count)
    {
        return $game_info['alias'] . '_' . ($platform == PLATFORM['ios'] ? 'ios' : 'android') . '_' . $channel_info['channel_short'] . '_' . $package_count;
    }

    /**
     * 获取用户信息列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getUserList($param = [], $page = 1, $limit = 15)
    {
        $pay_channel = LibUtil::config('ConfUnionChannel');
        $games = LibUtil::config('games');

        $data = [];
        $page = $page < 1 ? 1 : $page;
        $ip = new LibIp();
        $info = $this->mod->getUserList($param, $page, $limit);
        foreach ($info['list'] as $v) {
            $v['pay_money'] = 0;
            $v['last_pay_time'] = 0;
            $v['parent_name'] = $games[$v['parent_id']]['name'];
            $v['pay_money'] = '-';
            $v['last_pay_time'] = '-';
            $v['type_name'] = $pay_channel[$v['type']];
            $v['active_time'] = $v['active_time'] > 0 ? date('Y-m-d H:i:s', $v['active_time']) : '-';
            $v['reg_time'] = $v['reg_time'] > 0 ? date('Y-m-d H:i:s', $v['reg_time']) : '-';
            $v['last_login_time'] = $v['last_login_time'] > 0 ? date('Y-m-d H:i:s', $v['last_login_time']) : '-';

            $v['area'] = '';
            if ($v['reg_ip']) {
                $r = $ip->getlocation($v['reg_ip']);
                $v['area'] = $r['country'] . ' ' . $r['isp'];
            }

            $data[$v['uid']] = $v;
        }

        if (!empty($data)) {
            $pay = $this->mod->getUserPayList(implode(',', array_keys($data)));
            foreach ($pay as $row) {
                $data[$row['uid']]['pay_money'] = round($row['pay_money'] / 100, 2);
                $data[$row['uid']]['last_pay_time'] = $row['last_pay_time'] ? date('Y-m-d H:i:s', $row['last_pay_time']) : '-';
            }
        }

        $info['list'] = array_values($data);

        return $info;
    }

    /**
     * 获取订单列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getOrderList($param = [], $page = 1, $limit = 15)
    {
        $games = LibUtil::config('games');
        $pay_types = LibUtil::config('ConfPayType');
        $pay_channel = LibUtil::config('ConfUnionChannel');
        $page = $page < 1 ? 1 : $page;
        $ip = new LibIp();

        $info = $this->mod->getOrderList($param, $page, $limit);
        foreach ($info['list'] as &$v) {
            $v['notify_diff'] = $v['notify_time'] > 0 ? $v['notify_time'] - $v['pay_time'] : 0;
            $v['money'] = round($v['total_fee'] / 100, 2);
            $v['money_discount'] = $v['discount'] > 0 ? round($v['total_fee'] * $v['discount'] / 100 / 100, 2) : '';
            $v['parent_name'] = $games[$v['parent_id']]['name'];
            $v['reg_game_name'] = $games[$v['reg_game_id']]['name'];
            $v['pay_type_name'] = $v['pay_type'] > 0 ? $pay_types[$v['pay_type']] : ($pay_channel[$v['union_channel']] ? $pay_channel[$v['union_channel']] : '-');
            $v['create_time'] = $v['create_time'] > 0 ? date('Y-m-d H:i:s', $v['create_time']) : '';
            $v['pay_time'] = $v['pay_time'] > 0 ? date('Y-m-d H:i:s', $v['pay_time']) : '';
            $v['notify_time'] = $v['notify_time'] > 0 ? date('Y-m-d H:i:s', $v['notify_time']) : '';
            $v['direct_time'] = $v['direct_time'] > 0 ? date('Y-m-d H:i:s', $v['direct_time']) : '';

            $v['area'] = '';
            if ($v['pay_ip']) {
                $r = $ip->getlocation($v['pay_ip']);
                $v['area'] = $r['country'] . ' ' . $r['isp'];
            }
        }

        //只有核心数据查看权限才可以看
        $query = array();
        if (SrvAuth::checkPublicAuth('coreData', false)) {
            $query = array(
                'pay_num' => number_format($info['total']['total']),
                'pay_count' => number_format($info['total']['c']),
                'total_fee' => '¥' . number_format($info['total']['total_fee'] / 100, 2),
                'total_discount' => '¥' . number_format(($info['total']['total_fee'] - $info['total']['discount']) / 100, 2),
            );
        }

        return array(
            'count' => (int)$info['total']['c'],
            'data' => $info['list'],
            'query' => $query
        );
    }

    public function getOrderListExcel($sdate, $edate, $game_id, $server_id, $level1, $level2, $package_name, $username, $uid, $role_name, $pay_type, $pay_channel, $order_num, $is_pay, $is_notify, $device_type, $channel_id)
    {
        $is_notify = $is_notify - 1;
        $info = $this->mod->getOrderListExcel($sdate, $edate, $game_id, $server_id, $level1, $level2, $package_name, $username, $uid, $role_name, $pay_type, $pay_channel, $order_num, $is_pay, $is_notify, $device_type, $channel_id);

        $header = array(
            '账号', '注册时间', '创建时间', '支付时间', '订单号', '第三方交易单号', '订单金额（元）', '支付方式', '支付状态', '所属平台', '游戏包', '游戏名称', '区服ID', '游戏角色', '充值时等级', '支付状态', '渠道', '来源'
        );

        $pay_types = LibUtil::config('ConfPayType');
        $data = array();
        foreach ($info as $v) {
            $data[] = array(
                "\t" . $v['username'],
                $v['reg_time'] ? date('Y-m-d H:i:s', $v['reg_time']) : '-',
                $v['create_time'] ? date('Y-m-d H:i:s', $v['create_time']) : '-',
                $v['pay_time'] ? date('Y-m-d H:i:s', $v['pay_time']) : '-',
                "\t" . $v['pt_order_num'],
                "\t" . $v['third_trade_no'],
                bcdiv($v['money'], 100),
                $pay_types[$v['pay_type']],
                $v['device_type'] == 1 ? 'ios' : 'android',
                $v['package_name'],
                $v['game_name'],
                $v['server_id'],
                $v['role_name'],
                $v['role_level'],
                $v['is_pay'] > 1 ? '已支付' : '未支付',
                $v['channel_name'],
                $v['monitor_name']
            );
        }
        return array(
            'header' => $header,
            'data' => $data,
        );
    }

    public function getOrderDownloadUrl($sdate, $edate, $game_id, $server_id, $level1, $level2, $package_name, $username, $uid, $role_name, $pay_type, $pay_channel, $order_num, $is_pay, $is_notify, $device_type, $channel_id)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $is_notify = $is_notify - 1;
        $info = $this->mod->getOrderListExcel($sdate, $edate, $game_id, $server_id, $level1, $level2, $package_name, $username, $uid, $role_name, $pay_type, $pay_channel, $order_num, $is_pay, $is_notify, $device_type, $channel_id);

        $data = array();
        $data[] = array(
            'UID', '账号', '注册时间', '创建时间', '支付时间', '订单号', '第三方交易单号', '订单金额（元）', '支付方式', '支付状态', '所属平台', '游戏包', '游戏名称', '区服ID', '游戏角色', '充值时等级', '渠道', '来源'
        );

        $pay_types = LibUtil::config('ConfPayType');
        foreach ($info as $v) {
            $data[] = array(
                $v['uid'],
                "\t" . $v['username'],
                $v['reg_time'] ? date('Y-m-d H:i:s', $v['reg_time']) : '-',
                $v['create_time'] ? date('Y-m-d H:i:s', $v['create_time']) : '-',
                $v['pay_time'] ? date('Y-m-d H:i:s', $v['pay_time']) : '-',
                "\t" . $v['pt_order_num'],
                "\t" . $v['third_trade_no'],
                bcdiv($v['money'], 100),
                $pay_types[$v['pay_type']],
                $v['is_pay'] > 1 ? '已支付' : '未支付',
                $v['device_type'] == 1 ? 'ios' : 'android',
                $v['package_name'],
                $v['game_name'],
                $v['server_id'],
                $v['role_name'],
                $v['role_level'],
                $v['channel_name'],
                $v['monitor_name']
            );
        }

        $file_path = '/uploads/' . date("ym") . '/download/' . LibUtil::token('download') . '/order_' . date('Ymd') . '.csv';
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
     * 获取角色信息列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getRoleList($param = array(), $page = 1, $limit = 15)
    {
        $username = trim($param['username']);
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $channel_id = (int)$param['channel_id'];
        $device_type = (int)$param['device_type'];
        $package_name = $param['package_name'];
        $server_id = (int)$param['server_id'];
        $role_name = trim($param['role_name']);
        $has_pay = (int)$param['has_pay'];
        $has_phone = (int)$param['has_phone'];
        $sdate = trim($param['sdate']);
        $edate = trim($param['edate']);

        $page = $page < 1 ? 1 : $page;
        return $this->mod->getRoleList($page, $limit, $parent_id, $game_id, $channel_id, $device_type, $package_name, $server_id, $role_name, $username, $sdate, $edate, $has_pay, $has_phone);
    }

    /**
     * 角色信息列表导出
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
     */
    public function getRoleDownloadUrl($parent_id = 0, $game_id = 0, $channel_id = 0, $device_type = 0, $package_name = '', $server_id = 0, $role_name = '', $username = '', $sdate = '', $edate = '', $has_pay = 0, $has_phone = 0)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $srvAd = new SrvAd();
        $info = $this->mod->getRoleList(0, 0, $parent_id, $game_id, $channel_id, $device_type, $package_name, $server_id, $role_name, $username, $sdate, $edate, $has_pay, $has_phone);
        $games = $this->getAllGame();
        $channels = $srvAd->getAllChannel();

        $data = array();
        $data[] = array(
            '账号', '手机号', '游戏名称', '区服', '角色', '等级', '游戏包', '所属平台', '注册地区', '注册IP', '注册时间', '创建时间', '最后充值时间', '总充值', '渠道', '来源'
        );

        foreach ($info['list'] as $v) {
            $data[] = array(
                "\t" . $v['username'],
                "\t" . $v['phone'],
                $games[$v['game_id']],
                $v['server_id'],
                $v['role_name'],
                $v['role_level'],
                $v['package_name'],
                $v['device_type'] == 1 ? 'ios' : 'android',
                $v['reg_city'],
                $v['reg_ip'],
                $v['reg_time'] ? date('Y-m-d H:i:s', $v['reg_time']) : '-',
                $v['create_time'] ? date('Y-m-d H:i:s', $v['create_time']) : '-',
                $v['pay_time'] ? date('Y-m-d H:i:s', $v['pay_time']) : '-',
                bcdiv($v['pays'], 100),
                $channels[$v['channel_id']],
                $v['monitor_name'] ? $v['monitor_name'] : '-'
            );
        }

        $file_path = '/uploads/' . date("ym") . '/download/' . LibUtil::token('download') . '/role_' . date('Ymd') . '.csv';
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

    public function logList($page, $username, $type, $sdate, $edate)
    {
        $page = $page < 1 ? 1 : $page;
        if (!$username) return array('total' => 0);

        $all_type = LibUtil::config('user_log_type');
        $types = array();
        foreach ($all_type as $b) {
            $types[$b['id']] = $b['name'];
        }

        $user_info = $this->mod->getUserInfo($username);
        if ($user_info['uid']) {
            $modUserLog = new ModUserLog();
            $info = $modUserLog->logList($page, $user_info['uid'], $type, $sdate, $edate);
        } else {
            $info['total'] = 0;
        }

        $info['_logs'] = $all_type;
        $info['logs'] = $types;

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($username);
        $info['username'] = $username;

        LibUtil::clean_xss($type);
        $info['type'] = $type;

        LibUtil::clean_xss($sdate);
        $info['sdate'] = $sdate;

        LibUtil::clean_xss($edate);
        $info['edate'] = $edate;

        return $info;
    }

    public function handSendNotify($order_num = '')
    {
        $result = self::sync('handSendNotify', array('pt_order_num' => $order_num), true);
        if ($result['state'] == 1) {
            return array('state' => true, 'msg' => '发放成功');
        } else {
            return array('state' => false, 'msg' => '发放失败[' . $result['msg'] . ']');
        }
    }

    public function getPackageByGame($game_id, $channel_id = 0, $device_type = 0)
    {
        $result = $this->mod->getPackageByGame($game_id, $channel_id, $device_type);
        $ios_result = $this->mod->getPackageByGame($game_id, 0, 1);
        $result = array_merge($result, $ios_result);
        $package = array();
        foreach ($result as $r) {
            $package[$r['package_name']] = $r['package_name'];
        }
        return $package;
    }

    public function getMonitorByGame($game_id)
    {
        $result = $this->mod->getMonitorByGame($game_id);

        foreach ($result as $r) {
            $monitor[$r['monitor_id']] = $r['name'];
        }

        return $monitor;
    }

    public function getMonitorByGamePlat($game_id, $device_type)
    {
        $result = $this->mod->getMonitorByGamePlat($game_id, $device_type);

        foreach ($result as $r) {
            $monitor[$r['monitor_id']] = $r['name'];
        }
        return $monitor;
    }

    /**
     * 重置密码
     * @param $uid
     * @return array
     */
    public function resetPwd($uid)
    {
        if (!$uid) {
            return LibUtil::retData(false, array(), 'uid不能为空');
        }

        $chars = 'abcdefghjkmnpqrstuvwxyz0123456789';
        $password = '';
        for ($i = 0; $i < 8; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        $salt = LibUtil::getSalt(20);
        $pwd = LibUtil::makePwd($salt, $password);
        $result = $this->mod->updatePwd($uid, $salt, $pwd);
        if ($result) {
            return LibUtil::retData(true, array('pwd' => $password));
        } else {
            return LibUtil::retData(false, array(), '重置密码失败');
        }
    }

    /**
     * 解封禁用户
     * @param $uid
     * @param $status
     * @param string $text
     * @return array
     */
    public function bandUser($uid, $status, $text = '')
    {
        if (!$uid) {
            return LibUtil::retData(false, array(), 'uid不能为空');
        }

        $result = $this->mod->updateUserInfo($uid, array('status' => $status ? 0 : 1));
        if ($result) {
            $this->mod->conn = 'default';
            if ($status) {//解禁
                $this->mod->delData(LibTable::$forbidden, array('type' => 3, 'content' => $uid));
            } else {
                $this->mod->addData(LibTable::$forbidden, array(
                    'type' => 3,
                    'content' => $uid,
                    'notes' => trim($text),
                    'time' => time(),
                    'admin' => SrvAuth::$name
                ), false);
            }

            if (!$status) {
                //踢下线
                $this->kickUser($uid, '由于您有违规嫌疑，已账号被封禁，有疑问请联系客服');
            }

            return LibUtil::retData(true);
        } else {
            return LibUtil::retData(false, array(), '操作失败');
        }
    }

    /**
     * 踢用户下线
     * @param int $uid
     * @param string $msg
     * @return array
     */
    public function kickUser($uid = 0, $msg = '您已被管理员踢下线，有疑问请联系客服')
    {
        if (!$uid) {
            return LibUtil::retData(false, array(), 'uid不能为空');
        }

        if ($ip = LibUtil::getIp() == '127.0.0.1') {
            return LibUtil::retData(false, array(), '开发环境不能使用');
        }

        $json = json_encode(array(
            'type' => 'kick',
            'code' => 1,
            'message' => $msg,
            'data' => array(
                'uid' => $uid,
            )
        ));

        //连接socket服务
        Gateway::$registerAddress = '127.0.0.1:1238';

        if (!Gateway::isUidOnline($uid)) {
            return LibUtil::retData(false, array(), '当前用户不在线');
        }

        //通知客户端
        Gateway::sendToUid($uid, $json);

        return LibUtil::retData(true);
    }

    public function delUser($uid = 0)
    {
        if (!$uid) {
            LibUtil::response('参数错误');
        }

        if (SrvAuth::$id != 1) {
            LibUtil::response('只有超级管理员能删除');
        }

        $ret = $this->mod->delUser($uid);
        if ($ret) {
            LibUtil::response('删除成功', 1);
        } else {
            LibUtil::response('删除失败');
        }
    }

    public function getPackageIcon($package_name)
    {
        $info = $this->mod->getPackageInfoByPackageName($package_name);
        return LibUtil::retData(true, array('icon' => $info['icon']));
    }

    public function packagePay($game_id, $package_name)
    {
        $config = LibUtil::config($game_id);
        return $config[$package_name];
    }

    public function packagePayAction($game_id, $package_name, $status, $pay_type, $config = '')
    {
        if (!$game_id || !$package_name) {
            return LibUtil::retData(false, array(), '参数不足');
        }

        $_config = serialize($config);
        $arr = array(
            'status' => $status,
            'config' => $_config
        );
        $this->mod->updatePackageByPackageName($package_name, $arr);

        $data = array(
            'status' => (int)$status,
            'pay_type' => $pay_type,
            'config' => $_config
        );

        $config_cache = LibUtil::config($game_id);
        $config_cache[$package_name] = $data;
        $result = LibUtil::config($game_id, $config_cache);
        if ($result) {
            return LibUtil::retData(true, array(), '保存成功');
        } else {
            return LibUtil::retData(false, array(), '保存失败');
        }
    }

    /**
     * 下载对接参数
     *
     * @param $game_id
     */
    public function gameParams($game_id = 0)
    {
        $info = $this->mod->getGameInfo($game_id);
        $config = unserialize($info['config']);
        $inherit = (int)$config['inherit'];
        $pay_url = $config['pay_url'];
        $login_url = $config['login_url'];
        $ratio = $info['ratio'];
        $html5 = $info['device_type'] == 3;
        $channel = LibUtil::config('ConfUnionChannel');

        $parent = array();
        if ($inherit > 0) { //继承子游戏服务端参数
            $parent = $this->mod->getGameInfo($inherit);
            $parent_config = unserialize($parent['config']);
            $pay_url = $parent_config['pay_url'];
            $login_url = $parent_config['login_url'];
            $ratio = $parent['ratio'];
            $html5 = $parent['device_type'] == 3;
        }

        echo "-----------------以下内容发给【胡桃SDK客户端】-----------------\r\n\r\n";
        echo "SDK客户端对接参数：\r\n\r\n";
        echo "  游戏名称：【{$info['name']}】\r\n";
        echo "  游戏ID：game_id = {$game_id}\r\n";
        echo "  客户端密钥：KEY = {$info['sdk_key']}\r\n\r\n";

        if ($info['type'] == 2) {
            echo "  安卓固定参数：\r\n";
            echo "      channel_id = 27\r\n";
            echo "      package_name = {$info['alias']}_android_union\r\n";
            echo "  IOS固定参数：\r\n";
            echo "      channel_id = 27\r\n";
            echo "      package_name = {$info['alias']}_ios_union\r\n";
        } else {
            echo "  安卓初始（测试）参数：\r\n";
            echo "      channel_id = 10\r\n";
            echo "      package_name = {$info['alias']}_android_test\r\n";
            echo "  IOS初始（测试）参数：\r\n";
            echo "      channel_id = 14\r\n";
            echo "      package_name = {$info['alias']}_ios_test\r\n";
        }

        if ($this->getSupport($game_id)) {
            echo "\r\n";
            echo "  IOS技术支持地址：" . CDN_STATIC_URL . 'article/support/' . $game_id . ".html\r\n";
        }

        echo "\r\n";
        echo "--------------------以下内容发给【CP服务端】--------------------\r\n\r\n";
        echo "CP服务端对接参数：\r\n\r\n";
        echo "  游戏名称：【{$info['name']}】\r\n";

        if (!empty($parent)) {
            echo "  继承以下参数：\r\n";
            echo "      游戏名称：【{$parent['name']}】\r\n";
            echo "      游戏ID：game_id = {$parent['game_id']}\r\n";
            echo "      服务端密钥（仅保存在服务端）：KEY = {$parent['server_key']}\r\n";
        } else {
            echo "  游戏ID：game_id = {$game_id}\r\n";
            echo "  服务端密钥（仅保存在服务端）：KEY = {$info['server_key']}\r\n";
        }

        if ($html5) {
            echo "\r\n";
            echo "  H5游戏调试地址：" . API_SDK_URL . "/game/{$game_id}/\r\n";
        }

        if ($info['type'] == 2 && $config['platform_alias']) {
            echo "\r\n";
            echo "--------------------以下内容发给【联运渠道】---------------------\r\n\r\n";
            echo "联运平台对接参数：\r\n\r\n";
            echo "  平台名称：{$channel[$config['platform_alias']]}\r\n";
            echo "  平台标识：{$config['platform_alias']}\r\n";
            echo "  游戏名称：{$info['name']}\r\n";
            echo "  元宝兑换比例：1:{$ratio}\r\n\r\n";
            echo "  充值回调地址：\r\n";

            if ($pay_url['main']) {
                echo "  正式服：" . API_PAY_URL . "/notify/{$config['platform_alias']}/{$game_id}\r\n";
            }
            if ($pay_url['test']) {
                echo "  测试服：" . API_PAY_URL . "/notify/{$config['platform_alias']}/{$game_id}/test\r\n";
            }
            if ($pay_url['ios']) {
                echo "  IOS提审服[内购版]：" . API_PAY_URL . "/notify/{$config['platform_alias']}/{$game_id}/ios\r\n";
            }
            if ($pay_url['noios']) {
                echo "  IOS提审服[免费版]：" . API_PAY_URL . "/notify/{$config['platform_alias']}/{$game_id}/noios\r\n";
            }

            if ($info['device_type'] == 3) {
                echo "\r\n  H5游戏登录地址：\r\n";

                if ($login_url['main']) {
                    $url = API_SDK_URL;
                    if (stripos($login_url['main'], 'http://') === 0) {
                        $url = str_ireplace('https://', 'http://', $url);
                    }
                    echo "  正式服：" . $url . "/html5/{$config['platform_alias']}/{$game_id}\r\n";
                }
                if ($login_url['test']) {
                    $url = API_SDK_URL;
                    if (stripos($login_url['test'], 'http://') === 0) {
                        $url = str_ireplace('https://', 'http://', $url);
                    }
                    echo "  测试服：" . $url . "/html5/{$config['platform_alias']}/{$game_id}/test\r\n";
                }
                if ($login_url['ios']) {
                    $url = API_SDK_URL;
                    if (stripos($login_url['ios'], 'http://') === 0) {
                        $url = str_ireplace('https://', 'http://', $url);
                    }
                    echo "  IOS提审服[内购版]：" . $url . "/html5/{$config['platform_alias']}/{$game_id}/ios\r\n";
                }
                if ($login_url['noios']) {
                    $url = API_SDK_URL;
                    if (stripos($login_url['ios'], 'http://') === 0) {
                        $url = str_ireplace('https://', 'http://', $url);
                    }
                    echo "  IOS提审服[免费版]：" . $url . "/html5/{$config['platform_alias']}/{$game_id}/noios\r\n";
                }
            }
        }

        echo "\r\n\r\n------------------------------END---------------------------------\r\n";
        echo "\r\n下载时间：" . date('Y-m-d H:i:s') . "\r\n";

        header("Content-type:  application/octet-stream ");
        header("Accept-Ranges:  bytes ");
        header("Content-Disposition:  attachment;  filename= {$info['name']}.txt");
        exit();
    }

    public function gameLevel($game_id)
    {
        $result = $this->mod->gameLevel($game_id);
        if ($result) {
            return LibUtil::retData(true);
        } else {
            return LibUtil::retData(false);
        }
    }

    private static function modelApkName($game_id, $version, $ext = true)
    {
        $name = $game_id . '_' . $version . '/';
        if ($ext) {
            $name .= 'model.apk';
        }
        return $name;
    }

    /**
     * 获取APK包的配置信息
     * @param null $zip
     * @param null $tmp_path
     * @return array|bool|string
     */
    private static function getApkInfo($zip = null, $tmp_path = null)
    {
        if (!is_dir($tmp_path)) {
            mkdir($tmp_path, 0755, true);
        }

        $entries = 'assets/gameInfo.json';
        $ret = LibUtil::unzip($zip, $tmp_path, $entries);
        if ($ret !== true) {
            return $ret;
        }

        $file = $tmp_path . '/' . $entries;
        if (!is_file($file)) {
            return '获取母包配置信息失败';
        }
        $str = file_get_contents($file);
        $arr = json_decode($str, true);
        LibUtil::delDir($tmp_path);

        return array('sdk_version' => $arr['sdk_version'], 'package_version' => $arr['package_version'], 'game_id' => $arr['game_id']);
    }

    /**
     * 上传母包
     * @param string $fileMd5
     * @param int $total
     * @param int $now
     * @param int $size
     * @param int $nowSize
     * @param string $guid
     * @param string $name
     * @return array
     */
    public function uploadApk($fileMd5 = '', $total = 0, $now = 0, $size = 0, $nowSize = 0, $guid = '', $name = '')
    {
        $upload = new SrvUpload();
        $upload->setRootPath(RUNTIME_DIR . '/tmp');
        $upload->setExt(array('.apk'));
        $data = $upload->upload($fileMd5, $total, $now, $size, $nowSize, $guid, $name);
        return $data;
    }

    public function orderLog($pt_order_num = '')
    {
        $info = $this->mod->getOrderLog($pt_order_num);

        //$log = self::sync('orderLog', array('pt_order_num' => $pt_order_num), true);
        //$content = $log['data']['log'];

        return str_replace("\n", '<br>', $info['logs']);
    }

    public function orderCheck($pt_order_num = '')
    {
        $result = self::sync('orderCheck', array('pt_order_num' => $pt_order_num), true);
        if ($result['state'] == 1) {
            return array('state' => true);
        } else {
            return array('state' => false, 'msg' => $result['msg']);
        }
    }

    public function subApkAction($key)
    {
        $result = LibMemcache::get(LibMemcacheName::$subApk . $key);
        return array('data' => $result);
    }

    public function refreshPackage($game_id, $package_name = '')
    {
        $package = [];
        if ($package_name) {
            if ($this->mod->getRefreshPackageByPackageName($package_name) > 0) {
                return LibUtil::retData(false, array(), '请等待现有的更新完成后再次提交');
            }
            $info = $this->mod->getPackageInfoByPackageName($package_name);
            if (empty($info)) {
                return LibUtil::retData(false, array(), '没有找到存在的分包');
            }
            $package[] = $info;
        } else {
            if ($this->mod->getRefreshPackage($game_id) > 0) {
                return LibUtil::retData(false, array(), '请等待现有的更新完成后再次提交');
            };
            $package = $this->mod->getPackageByGame($game_id);
            if (empty($package)) {
                return LibUtil::retData(false, array(), '没有找到存在的分包');
            }
        }

        $tmp = [];
        $game_info = $this->getGameInfo($game_id);
        foreach ($package as $row) {
            if ($game_info['sdk_version'] == $row['sdk_version']) {
                continue;
            }
            $tmp[] = $row;
        }
        if (empty($tmp)) {
            return LibUtil::retData(false, array(), '当前所有分包已经是最新了');
        }

        $result = $this->mod->refreshPackage($game_info, $tmp);
        if ($result) {
            return LibUtil::retData(true);
        } else {
            return LibUtil::retData(false, array(), '操作失败');
        }
    }

    /**
     * 安卓分包进度列表
     * @param int $game_id
     * @param int $state
     * @param string $package_name
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function refreshProgress($game_id = 0, $state = -1, $package_name = '', $page = 1, $limit = 15)
    {
        return $this->mod->refreshProgress($game_id, $state, $package_name, $page, $limit);
    }

    public function refreshStatus($game_id, $package_name = '')
    {
        $info = $this->mod->refreshStatus($game_id, $package_name);
        $out = array(
            'ing' => 0,
            'success' => 0,
            'error' => 0,
            'wait' => 0,
            'total' => 0,
        );
        foreach ($info as $i) {
            switch ($i['state']) {
                case 1:
                    $key = 'ing';
                    break;
                case 2:
                    $key = 'success';
                    break;
                case 3:
                    $key = 'error';
                    break;
                case 0:
                    $key = 'wait';
            }
            $out[$key] = $i['total'];
            $out['total'] += $i['total'];
        }
        return $out;
    }

    /**
     * 对单个包重新分包
     * @param int $id
     * @return array
     */
    public function refreshRepeat($id = 0)
    {
        $data = array(
            'state' => 0,
            'submit_time' => time(),
            'fix_time' => 0,
            'error' => '',
            'administrator' => SrvAuth::$name
        );
        $ret = $this->mod->updateData(LibTable::$sy_game_package_refresh, $data, $id);
        if ($ret) {
            return LibUtil::responseData('提交成功', 1);
        } else {
            return LibUtil::responseData('提交失败');
        }
    }

    /**
     * 获取礼包列表
     * @param int $parent_id
     * @param int $game_id
     * @return array|bool|resource|string
     */
    public function getPackageGift($parent_id = 0, $game_id = 0)
    {
        $giftData = $this->mod->getPackageGift($parent_id, $game_id);
        foreach ($giftData as $key => &$row) {
            $row['data_url'] = API_SDK_URL . '/?&ct=wxoption&ac=gift&type_id=' . $row['id'];
        }
        return $giftData;
    }

    public function getGiftTypeList($parent_id = 0, $game_id = 0)
    {
        if ($parent_id <= 0 && $game_id <= 0) {
            return array();
        }
        return $this->mod->getGiftTypeList($parent_id, $game_id);
    }

    public function getGiftTypeInfo($id)
    {
        if ($id <= 0) {
            return array();
        }
        return $this->mod->getGiftTypeInfo($id);
    }

    public function addGiftTypeAction($id, $data)
    {
        if ($data['parent_id'] <= 0 && $data['game_id'] <= 0) {
            return array('state' => false, 'msg' => '请选择游戏');
        }
        if ($data['type'] == 0 && !$data['name']) {
            return array('state' => false, 'msg' => '请填写礼包类别名称');
        }

        $types = LibUtil::config('ConfGiftType');
        if ($data['type'] != 0) {
            $data['name'] = $types[$data['type']];
        }
        if ($id > 0) {
            unset($data['amount']);
            unset($data['used']);
            $result = $this->mod->updateGiftType($id, $data);
        } else {
            $result = $this->mod->addGiftType($data);
        }

        if ($result) {
            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    public function delGiftType($id)
    {
        $result = $this->mod->delGiftType($id);
        if ($result) {
            return array('state' => true, 'msg' => '删除成功');
        } else {
            return array('state' => false, 'msg' => '删除失败');
        }
    }

    public function importGift($type_id = 0, $upload_file = '')
    {
        $giftTypeInfo = $this->getGiftTypeInfo($type_id);
        if ($type_id <= 0 || !$giftTypeInfo) {
            return array('state' => false, 'msg' => '请选择礼包类型');
        }
        if (!$upload_file) {
            return array('state' => false, 'msg' => '请上传礼包');
        }

        $file_path = RUNTIME_DIR . '/tmp/' . $upload_file;
        if (!is_file($file_path)) {
            return array('state' => false, 'msg' => '上传的礼包已失效，请重新上传');
        }

        $c = 0;
        $t = 0;
        $time = date('Y-m-d H:i:s');
        $arr = array();
        $handle = fopen($file_path, 'r');
        $giftTypeInfo['type'] == 9 && $uid = -1;//微信礼包特异性
        while (!feof($handle)) {
            $code = trim(fgets($handle));
            if (empty($code)) {
                continue;
            }
            $arr[] = array(
                'uid' => isset($uid) ? $uid : 0,
                'code' => $code,
                'type_id' => (int)$type_id,
                'import_time' => $time
            );
            $c++;
            //整
            if ($c % 10000 == 0) {
                $tt = $this->mod->importGift($arr);
                if ($tt > 0) {
                    $t += $tt;
                }

                $c = 0;
                $arr = array();
            }
        }
        fclose($handle);
        ///重新再写入 防止前面的错误
        if (!empty($arr)) {
            $tt = $this->mod->importGift($arr);
            if ($tt > 0) {
                $t += $tt;
            }
        }

        $amount = $this->mod->getGiftCount($type_id);
        $this->mod->updateGiftType($type_id, array('amount' => $amount));

        unlink($file_path);

        return array('state' => true, 'msg' => "导入完成，共导入 {$t} 个激活码");
    }

    public function gameUpdateAction($data = null)
    {
        if ($data['game_id'] <= 0) {
            return array('state' => false, 'msg' => '参数错误');
        }
        if (!$data['upload_file']) {
            return array('state' => false, 'msg' => '请上传母包');
        }
        if (!trim($data['description'])) {
            return array('state' => false, 'msg' => '请填写更新日志');
        }
        if (!$data['type']) {
            return array('state' => false, 'msg' => '请选择更新类型');
        }

        $file_name = RUNTIME_DIR . '/tmp/' . $data['upload_file'];
        if (!is_file($file_name)) {
            return array('state' => false, 'msg' => '上传文件已失效，请重新上传');
        }

        $info = self::getApkInfo($file_name, RUNTIME_DIR . '/tmp/unzip');
        if (is_string($info)) {
            return array('state' => false, 'msg' => $info);
        }
        if ($info['game_id'] != $data['game_id']) {
            return array('state' => false, 'msg' => '上传的母包不是该游戏的，请核对');
        }

        $file_size = LibUtil::formatBytes(filesize($file_name));
        $file_package = APK_MODEL_DIR . self::modelApkName($data['game_id'], $info['package_version']);
        if (!is_dir(dirname($file_package))) {
            mkdir(dirname($file_package), 0755, true);
        }

        unlink($file_package);
        $ret = rename($file_name, $file_package);
        if ($ret) {
            unlink($file_name);
        }

        $this->mod->startWork();
        $update = array(
            'package_version' => $info['package_version'],
            'sdk_version' => $info['sdk_version'],
            'upload_time' => time()
        );
        $ret1 = $this->mod->updateGameAction($data['game_id'], $update);

        $update = array(
            'game_id' => $data['game_id'],
            'type' => $data['type'],
            'description' => $data['description'],
            'package_version' => $info['package_version'],
            'package_size' => $file_size,
            'sdk_version' => $info['sdk_version'],
            'create_time' => time(),
        );
        $ret2 = $this->mod->gameUpdateAction($update);
        if ($ret1 && $ret2) {
            $this->mod->commit();
            return array('state' => true, 'msg' => '保存成功');
        } else {
            $this->mod->rollBack();
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    public function clearCache($parent_id = 0, $game_id = 0, $game_info = array(), $sync = true)
    {
        if ($game_id <= 0) {
            return LibUtil::retData(false, [], '参数错误');
        }

        $games = LibUtil::config('games');
        if (empty($games)) {
            $tmp = $this->clearCacheAll();
            $games = (array)$tmp['data'];
        }

        if ($parent_id == 0) {
            $list = $this->mod->getGamesListByPid($game_id);
            foreach ($list as $r) {
                $games[$r['game_id']] = $r;
                $this->clearCache($r['parent_id'], $r['game_id'], $r, false);
            }

            LibUtil::config('games', $games);
        } else {
            if (empty($game_info)) {
                $game_info = $this->getGameInfo($game_id);
            }

            if (empty($game_info)) {
                return LibUtil::retData(false, [], '获取游戏信息失败');
            }

            if ($sync) {
                $games[$game_id] = $game_info;
                LibUtil::config('games', $games);
            }

            $html5 = $game_info['device_type'] == 3;
            $config = unserialize($game_info['config']);

            //继承父游戏配置（支付回调地址、H5登录地址）
            if ($config['inherit']) {
                $game_inherit = $games[$config['inherit']];
                $html5 = $game_inherit['device_type'] == 3;
                $config_inherit = unserialize($game_inherit['config']);

                $config['login_url']['main'] = &$config_inherit['login_url']['main'];
                $config['login_url']['test'] = &$config_inherit['login_url']['test'];
                $config['login_url']['ios'] = &$config_inherit['login_url']['ios'];
                $config['login_url']['noios'] = &$config_inherit['login_url']['noios'];
            }

            $package = array(
                0 => array(//IOS测试包
                    'id' => 0,
                    'package_name' => strtolower($game_info['alias'] . '_ios_test'),
                    'sdk_version' => $game_info['sdk_version'],
                    'channel_id' => 14,
                    'platform' => 1,
                    'status' => 0
                ),
                1 => array(//android测试包
                    'id' => 0,
                    'package_name' => strtolower($game_info['alias'] . '_android_test'),
                    'sdk_version' => $game_info['sdk_version'],
                    'channel_id' => 10,
                    'platform' => 2,
                    'status' => 0
                ),
                2 => array(//android联运包
                    'id' => 0,
                    'package_name' => strtolower($game_info['alias'] . '_android_union'),
                    'sdk_version' => '',
                    'channel_id' => 27,
                    'platform' => 2,
                    'status' => 0
                ),
            );

            $_package = $this->mod->getPackageByGame($game_id);
            if (!empty($_package)) {
                $package = array_merge($package, $_package);
            }

            foreach ($package as $row) {
                $_config = unserialize($row['config']);
                $cache_key = LibRedis::$prefix_sdk_update . $game_id . '_' . $row['package_name'];
                $update = LibRedis::get($cache_key);
                if (empty($update)) {
                    $update = [];
                }

                //实名认证，分包优先
                $is_adult = (int)$_config['is_adult'];
                if ($is_adult == 0) {
                    $is_adult = (int)$config['is_adult'];
                }

                //游戏状态，优先分包设置
                $status = (int)$row['status'];
                if ($status <= 0) {
                    if ($row['platform'] == PLATFORM['ios']) {
                        $status = (int)$config['status']['ios'];
                    } else {
                        $status = (int)$config['status']['android'];
                    }
                }

                $update['config'] = array(
                    'status' => $status, //游戏状态
                    'close' => (int)$game_info['status'], //游戏开关，0-开，1-关
                    'is_adult' => $is_adult == 2 ? 2 : 1 //实名认证开关，1关，2开
                );

                //H5游戏
                if ($html5) {
                    //H5游戏更换登录链接
                    while (true) {
                        //没有设置
                        if ($status <= 0) {
                            break;
                        }

                        switch ($status) {
                            case 2:
                                $login_url = $config['login_url']['test'];
                                break;
                            case 3:
                                $login_url = $config['login_url']['ios'];
                                break;
                            case 4:
                                $login_url = $config['login_url']['noios'];
                                break;
                            default:
                                $login_url = $config['login_url']['main'];
                                break;
                        }

                        if (!$login_url) {
                            break;
                        }

                        //H5游戏更换登录链接
                        $update['h5'] = array(
                            'new_game_id' => (int)$game_id,
                            'game_url' => $login_url,
                            'update_time' => 0,
                            'android' => $row['platform'] == PLATFORM['android'] ? 2 : 0,
                            'ios' => $row['platform'] == PLATFORM['ios'] ? 2 : 0
                        );

                        //结束
                        break;
                    }
                }

                LibRedis::set($cache_key, $update);
            }
        }

        return LibUtil::retData(true);
    }

    public function clearCacheAll()
    {
        $games = [];
        $info = $this->mod->getGameList();
        foreach ($info['list'] as $row) {
            $games[$row['game_id']] = $row;
        }

        LibUtil::config('games', $games);

        return LibUtil::retData(true, $games);
    }

    public function getUserInfo($keyword = '')
    {
        if (!$keyword) {
            return array();
        }

        $user = [];
        $ip = new LibIp();
        $info = $this->mod->getUserInfoByKey($keyword);
        foreach ($info['user'] as $row) {
            $row['area'] = '';
            if ($row['reg_ip']) {
                $r = $ip->getlocation($row['reg_ip']);
                $row['area'] = $r['country'] . ' ' . $r['isp'];
            }

            $user[$row['uid']] = $row;
        }

        if (!empty($user)) {
            //总充值
            $pay = $this->mod->getUserPayList(implode(',', array_keys($user)));
            foreach ($pay as $row) {
                $user[$row['uid']]['pay_money'] = round($row['pay_money'] / 100, 2);
                $user[$row['uid']]['last_pay_time'] = $row['last_pay_time'];
            }
        }

        return array('user' => $user, 'role' => $info['role']);
    }

    public function getUserInfoByUid($uid = 0)
    {
        if ($uid <= 0) {
            return array();
        }

        return $this->mod->getUserInfo(array('uid' => $uid));
    }

    public function saveUserInfo($uid, $data)
    {
        if ($uid <= 0) {
            LibUtil::response('参数错误');
        }

        if ($data['phone'] && !preg_match('/^1[3-9][0-9]{9}$/', $data['phone'])) {
            LibUtil::response('手机号格式错误');
        }
        if ($data['name'] && !preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $data['name'])) {
            LibUtil::response('姓名必须为中文');
        }
        if ($data['id_number'] && !LibIdCard::validation_filter_id_card($data['id_number'])) {
            LibUtil::response('身份证号码填写错误');
        }

        $ret = $this->mod->saveUserInfo($uid, $data);
        if ($ret) {
            LibUtil::response('保存成功', 1);
        } else {
            LibUtil::response('保存失败');
        }
    }

    /**
     * 激活日志
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function activeLog($param = array(), $page = 1, $limit = 15)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $channel_id = $param['channel_id'];
        $date = $param['date'];
        $device_id = trim($param['device_id']);
        $edate = !empty($param['edate']) ? $param['edate'] : date('Y-m-d');

        $page = $page < 1 ? 1 : $page;
        if (!$date) {
            $date = date('Y-m-d');
        }
        $info = $this->mod->activeLog($page, $limit, $date, $device_id, $channel_id, $game_id, $parent_id, $edate);
        $info['query']['date'] = $date;
        $info['query']['edate'] = $edate;

        return $info;
    }

    /**
     * 手动激活回调测试
     *
     * @param int $id
     * @return array|bool|resource|string
     */
    public function activeCallback($id = 0)
    {
        $info = $this->mod->getActiveLogInfo($id);
        if (empty($info)) {
            return LibUtil::retData(false, [], '记录不存在');
        }

        $ext = json_decode($info['click_info'], true);
        $monitor['ext'] = $ext;
        $monitor['monitor_id'] = $info['monitor_id'];

        $ret = YX::call('/monitor/adUpload/' . $ext['callback'] . 'Upload', $monitor, $info['active_time'], $info['active_ip']);

        return LibUtil::retData(true, array('result' => $ret), '回调成功');
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
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getOrderReplacementList($page, $parent_id, $game_id, $device_type, $package_name, $pay_type, $order_num, $username, $role_name);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $info['game_id'] = $game_id;
        $info['pay_type'] = $pay_type;
        $info['device_type'] = $device_type;
        LibUtil::clean_xss($order_num);
        $info['pt_order_num'] = $order_num;
        LibUtil::clean_xss($username);
        $info['username'] = $username;
        LibUtil::clean_xss($role_name);
        $info['role_name'] = $role_name;
        LibUtil::clean_xss($package_name);
        $info['package_name'] = $package_name;

        if ($info['game_id']) {
            $info['_packages'] = $this->mod->getPackageByGame($info['game_id'], 0, $info['device_type']);
        }

        return $info;
    }

    /**
     * 订单直充
     * @param string $pt_order_num
     * @return array
     */
    public function orderDirect($pt_order_num = '')
    {
        $info = $this->mod->getOrderInfo($pt_order_num);
        if (empty($info)) {
            return array('state' => false, 'msg' => '订单不存在');
        }
        if ($info['is_pay'] != PAY_STATUS['未支付']) {
            return array('state' => false, 'msg' => '该订单已支付');
        }
        //5分钟内的订单不检查
        if (time() - $info['create_time'] < 300) {
            return array('state' => false, 'msg' => '该订单还在处理中');
        }

        $data = array(
            'pt_order_num' => $pt_order_num,
            'administrator' => SrvAuth::$name,
            'notes' => '直充',
            'direct_time' => time()
        );
        $ret = LibUtil::sync('orderDirect', $data);
        if ($ret) {
            return array('state' => true);
        } else {
            return array('state' => false);
        }
    }

    /**
     * 系统配置
     * @return array
     */
    public function config()
    {
        $data = [];
        $info = $this->mod->getConfig('config');
        foreach ($info['list'] as $row) {
            if (in_array($row['key'], array('whitelist_ip', 'whitelist_device'))) {
                $row['value'] && $row['value'] = str_replace(',', "\r\n", $row['value']);
            }
            $data[$row['key']] = $row['value'];
        }

        return $data;
    }

    /**
     * 系统配置
     * @param array $param
     * @return array
     */
    public function configAction($param = [])
    {
        $config = $param['config'];
        if (empty($config)) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $config['whitelist_ip'] && $config['whitelist_ip'] = implode(',', explode("\r\n", $config['whitelist_ip']));
        $config['whitelist_device'] && $config['whitelist_device'] = implode(',', explode("\r\n", $config['whitelist_device']));

        $data = $cache = [];
        foreach ($config as $key => $val) {
            $tmp = array(
                'module' => 'config',
                'key' => $key,
                'value' => $val
            );
            $data[] = $tmp;

            $cache[$key] = $val;
        }

        $ret = $this->mod->multiInsert($data, LibTable::$config, array('replace' => true));
        if ($ret) {
            //缓存
            LibRedis::set(LibRedis::$prefix_config, $cache);

            return array('state' => true);
        } else {
            return array('state' => false);
        }
    }

    /**
     * 获取封禁列表
     * @param int $type
     * @param string $keyword
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getForbidden($type = 1, $keyword = '', $page = 1, $limit = 17)
    {
        $data = [];
        switch ($type) {
            case 1:
            case 2:
                $module = $type == 1 ? 'forbidden_ip' : 'forbidden_device';
                $tmp = [];
                $ip = new LibIp();
                $info = $this->mod->getConfig($module, $keyword, $page, $limit);
                foreach ($info['list'] as $row) {
                    $arr = json_decode($row['value'], true);
                    $area = '';
                    if ($module == 'forbidden_ip' && filter_var($row['key'], FILTER_VALIDATE_IP) !== false) {
                        $r = $ip->getlocation($row['key']);
                        $area = $r['country'];
                    }

                    $is_reg = false;
                    $is_login = false;
                    switch ($arr['value']) {
                        case 'reg':
                            $is_reg = true;
                            break;
                        case 'login':
                            $is_login = true;
                            break;
                        case 'all':
                            $is_reg = true;
                            $is_login = true;
                            break;
                    }

                    $tmp[] = array(
                        'type' => $type,
                        'key' => $row['key'],
                        'area' => $area,
                        'reg' => $is_reg,
                        'login' => $is_login
                    );
                }

                $data = array(
                    'list' => $tmp,
                    'total' => $info['total']
                );
                break;
            case 3:
                $tmp = [];
                $param = array(
                    'keyword' => $keyword,
                    'banned' => true,
                );
                $info = $this->mod->getUserList($param, $page, $limit);
                foreach ($info['list'] as $row) {
                    $tmp[] = array(
                        'type' => $type,
                        'key' => &$row['uid'],
                        'uid' => $row['uid'],
                        'username' => $row['username']
                    );
                }

                $data = array(
                    'list' => $tmp,
                    'total' => $info['total']
                );
                break;
        }

        return $data;
    }

    /**
     * 添加封禁
     * @param array $param
     */
    public function forbiddenAdd($param = [])
    {
        $ip = trim($param['ip']);
        $device_id = trim($param['device_id']);
        $username = trim($param['username']);
        $explain = trim($param['explain']);
        $type = trim($param['type']);

        if (!$ip && !$device_id && !$username) {
            LibUtil::response('请填写封禁内容');
        }
        if (!$explain) {
            LibUtil::response('请填写封禁原因');
        }

        $ret = false;
        $value = json_encode(array(
            'time' => time(),
            'admin' => SrvAuth::$name,
            'value' => $type,
            'explain' => $explain
        ));

        //封禁IP
        if ($ip) {
            $ret = $this->forbiddenUpdateAction(array(
                'module' => 'forbidden_ip',
                'key' => $ip,
                'value' => $value
            ), $type);
        }

        //封禁设备号
        if ($device_id) {
            $ret = $this->forbiddenUpdateAction(array(
                'module' => 'forbidden_device',
                'key' => $device_id,
                'value' => $value
            ), $type);
        }

        //封禁账号
        if ($username) {
            $user = $this->mod->getUserInfo($username);
            if (empty($user)) {
                LibUtil::response('该账号不存在');
            }

            $uid = $user['uid'];
            $ret = $this->mod->updateUserInfo($uid, array('status' => 1));
            if ($ret) {
                //踢下线
                $this->kickUser($uid, '由于您有违规嫌疑，已账号被封禁，有疑问请联系客服');
            }
        }

        if ($ret) {
            LibUtil::response('封禁成功', 1);
        } else {
            LibUtil::response('封禁失败');
        }
    }

    public function forbiddenUpdate($type, $value, $key, $checked)
    {
        $del = false;
        $module = $type == 1 ? 'forbidden_ip' : 'forbidden_device';

        $info = $this->mod->getConfig($module, $key);
        if (empty($info) || !($row = $info['list'][0])) {
            return array('state' => false, 'msg' => '记录不存在');
        }

        $param = json_decode($row['value'], true);
        if ($checked) {//增加封禁
            if ($param['value'] != $value) {
                $param['value'] = 'all';
            }
        } else {
            if ($param['value'] == 'all') {
                $param['value'] = $value == 'reg' ? 'login' : 'reg';
            } else {
                //删除
                $ret = $this->mod->delete(array('module' => $module, 'key' => $key), 0, LibTable::$config);
                if ($ret) {
                    $cache_key = $module == 'forbidden_ip' ? LibRedis::$prefix_forbidden_ip : LibRedis::$prefix_forbidden_device;
                    LibRedis::delete($cache_key . $key);

                    $del = true;
                }
            }
        }

        $ret = true;
        if (!$del) {
            $param['time'] = time();
            $param['admin'] = SrvAuth::$name;

            $ret = $this->forbiddenUpdateAction(array(
                'module' => $module,
                'key' => $key,
                'value' => $param
            ), $param['value']);
        }

        if ($ret) {
            return array('state' => true, 'del' => $del);
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    public function forbiddenDel($type = 0, $key = '')
    {
        $ret = false;
        switch ($type) {
            case 1:
            case 2:
                $module = $type == 1 ? 'forbidden_ip' : 'forbidden_device';
                $ret = $this->mod->delete(array('module' => $module, 'key' => $key), 0, LibTable::$config);
                if ($ret) {
                    $cache_key = $module == 'forbidden_ip' ? LibRedis::$prefix_forbidden_ip : LibRedis::$prefix_forbidden_device;
                    LibRedis::delete($cache_key . $key);
                }
                break;
            case 3:
                $ret = $this->mod->updateUserInfo($key, array('status' => 0));
                break;
        }

        if ($ret) {
            return array('state' => true);
        } else {
            return array('state' => false, 'msg' => '解封失败');
        }
    }

    private function forbiddenUpdateAction($data = [], $type = '')
    {
        is_array($data['value']) && $data['value'] = json_encode($data['value']);

        $ret = $this->mod->insertOrUpdate($data, array('value' => $data['value']), LibTable::$config);
        if ($ret) {
            $cache_key = $data['module'] == 'forbidden_ip' ? LibRedis::$prefix_forbidden_ip : LibRedis::$prefix_forbidden_device;
            LibRedis::set($cache_key . $data['key'], $type);
        }
        return $ret;
    }

    /**
     * 刷新分包升级缓存
     * @return array
     */
    public function clearPackageCacheAll()
    {
        $t = $c = 0;
        $list = $this->mod->getPackageAndroid();
        foreach ($list as $row) {
            //没有母包对应版本
            if (empty($row['sdk_version'])) {
                continue;
            }
            //下载地址不正确
            if (!preg_match('/^http[s]?:\/\/.*\.apk$/i', $row['down_url'])) {
                continue;
            }

            $cache_key = LibRedis::$prefix_sdk_update . $row['game_id'] . '_' . $row['package_name'];
            $update = LibRedis::get($cache_key);
            if (empty($update)) {
                $update = [];
            }

            $update['full'] = array(
                'download' => $row['down_url'],
                'package_md5' => $row['package_md5'],
                'package_size' => $row['package_size'],
                'package_version' => $row['package_version'],
                'sdk_version' => $row['sdk_version'],
                'description' => $row['description'],
                'type' => $row['type'] //更新类型，1-更新，2-强制更新，3-忽略更新
            );

            $t++;
            $ret = LibRedis::set($cache_key, $update);
            if ($ret) {
                $c++;
            }
        }

        return LibUtil::retData(true, array(), "总共刷新{$t}个分包，失败" . ($t - $c) . "个");
    }

    /**
     * 复制继承游戏客服信息
     * @param int $game_id
     * @return array
     */
    public function copyKefuInfo($game_id = 0)
    {
        if ($game_id <= 0) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $games = LibUtil::config('games');
        $game = $games[$game_id];
        if (empty($game)) {
            return array('state' => false, 'msg' => '继承的游戏不存在');
        }

        $config = unserialize($game['config']);

        return array('state' => true, 'msg' => '', 'data' => array('kefu' => $config['kefu'], 'vip' => $config['vip']));
    }

    /**
     * 获取所有平台列表
     * @return array
     */
    public function getAllPlatform()
    {
        $info = $this->mod->getAllPlatform();
        $data = array();
        foreach ($info as $v) {
            $data[$v['platform_id']] = $v['name'];
        }
        krsort($data);
        return $data;
    }

    /**
     * 获取平台列表
     * @param int $page
     * @param int $limit
     * @param array $param
     * @return array
     */
    public function getPlatformList($page = 0, $limit = 15, $param = array())
    {
        $data = $platform = $platform_game = [];
        $info = $this->mod->getDataList($page, LibTable::$platform, 'platform_id');
        foreach ($info['list'] as $i) {
            $i['id'] = &$i['platform_id'];
            $i['pid'] = 0;

            unset($i['config']);

            $data[$i['id']] = $i;
            $platform[] = $i['id'];
        }

        if ($page > 0 && !empty($platform)) {
            $platform_game = $this->mod->getPlatformGameList(0, 0, $platform);
        } else {
            $platform_game = $this->mod->getPlatformGameList();
        }

        foreach ($platform_game['list'] as $row) {
            $id = 10000 . $row['game_id'] . $row['platform_id'];
            $tmp = array(
                'id' => $id,
                'pid' => (int)$row['platform_id'],
                'name' => &$row['game_name'],
                'alias' => &$row['game_alias'],
                'type' => &$row['type'],
                'device_type' => &$row['device_type'],
                'lock' => &$row['lock'],
                'is_login' => &$row['is_login'],
                'is_pay' => &$row['is_pay'],
                'open_time' => &$row['open_time'],
                'create_time' => &$row['create_time'],
                'update_time' => &$row['update_time'],
                'platform_id' => &$row['platform_id'],
                'game_id' => &$row['game_id'],
                'game_name' => &$row['game_name'],
                'platform_name' => &$row['platform_name']
            );

            $data[$id] = $tmp;
        }

        krsort($data);

        return array(
            'data' => array_values($data),
            'count' => (int)$info['total']
        );
    }

    /**
     * 获取平台信息
     * @param $platform_id
     * @return array|bool|resource|string
     */
    public function getPlatformInfo($platform_id)
    {
        return $this->mod->getDataInfo(LibTable::$platform, 'platform_id', $platform_id);
    }

    /**
     * 添加/编辑平台
     * @param $data
     * @return array
     */
    public function platformAdd($data)
    {
        $platform_id = (int)$data['platform_id'];

        if (!$data['name'] || !$data['alias']) {
            return array('state' => false, 'msg' => '请填写游戏名称和别名');
        }

        if (!preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]+$/u', $data['name'])) {
            return array('state' => false, 'msg' => '游戏名称只能由中文、字母、数字和减号组成的字符串');
        }

        if (!preg_match('/^[a-z0-9-]+$/', $data['alias'])) {
            return array('state' => false, 'msg' => '游戏别名只能由字母、数字和减号组成的小写字符串');
        }

        $data['is_login'] = (int)$data['is_login'];
        $data['is_pay'] = (int)$data['is_pay'];
        $data['lock'] = (int)$data['lock'];

        $time = time();
        if ($platform_id) {
            $data['update_time'] = $time;
            $result = $this->mod->updateData(LibTable::$platform, $data, array('platform_id' => $platform_id));
        } else {
            $data['create_time'] = $time;
            $result = $this->mod->addData(LibTable::$platform, $data);
        }

        if ($result) {
            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    /**
     * 获取平台对应游戏信息
     * @param int $platform_id
     * @param int $game_id
     * @return array|bool|resource|string
     */
    public function getPlatformGameInfo($platform_id = 0, $game_id = 0)
    {
        return $this->mod->getPlatformGameInfo($platform_id, $game_id);
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
        $data = array();
        $info = $this->mod->getPlatformGameList($page, $game_id, $platform_id);
        foreach ($info['list'] as $row) {
            $data['game'][$row['game_id']][$row['platform_id']] = $row;
            $data['platform'][$row['platform_id']][$row['game_id']] = $row;
        }
        return $data;
    }

    /**
     * 添加平台对应游戏信息
     * @param $data
     * @return array
     */
    public function platformAddGame($data)
    {
        $platform_id = (int)$data['platform_id'];
        $game_id = (int)$data['game_id'];
        $type = $data['type'];

        $data['is_login'] = (int)$data['is_login'];
        $data['is_pay'] = (int)$data['is_pay'];
        $data['lock'] = (int)$data['lock'];

        unset($data['type']);
        $time = time();
        if ($type == 'edit') {
            unset($data['game_id'], $data['platform_id']);
            $data['update_time'] = $time;
            $result = $this->mod->updateData(LibTable::$platform_game, $data, array('game_id' => $game_id, 'platform_id' => $platform_id));
        } else {
            if (!$game_id) {
                return array('state' => false, 'msg' => '请选择游戏');
            }
            if (!$platform_id) {
                return array('state' => false, 'msg' => '请选择平台');
            }
            if (!$data['open_time']) {
                return array('state' => false, 'msg' => '请填写首服时间');
            }

            $data['create_time'] = $time;
            $result = $this->mod->addData(LibTable::$platform_game, $data);
        }

        if ($result) {
            //更新缓存
            $this->setPlatformGameCache($platform_id, $game_id);

            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    /**
     * 下载平台对应游戏参数
     * @param int $platform_id
     * @param int $game_id
     */
    public function downloadPlatformGameParam($platform_id = 0, $game_id = 0)
    {
        $info = $this->getPlatformGameInfo($platform_id, $game_id);
        $game_config = unserialize($info['game_config']);
        $pay_url = $game_config['pay_url'];
        $login_url = $game_config['login_url'];

        echo "-----------------以下内容发给联运平台-----------------\r\n\r\n";
        echo "联运平台对接参数：\r\n\r\n";
        echo "  平台名称：{$info['platform_name']}\r\n";
        echo "  平台标识：{$info['platform_alias']}\r\n";
        echo "  游戏名称：{$info['game_name']}\r\n";
        echo "  元宝兑换比例：1:{$info['ratio']}\r\n\r\n";
        echo "  充值回调地址：\r\n";

        if ($pay_url['main']) {
            echo "  正式服：" . API_PAY_URL . "/notify/{$info['platform_alias']}\r\n";
        }
        if ($pay_url['test']) {
            echo "  测试服：" . API_PAY_URL . "/notify/{$info['platform_alias']}/test\r\n";
        }
        if ($pay_url['ios']) {
            echo "  IOS提审服[内购版]：" . API_PAY_URL . "/notify/{$info['platform_alias']}/ios\r\n";
        }
        if ($pay_url['noios']) {
            echo "  IOS提审服[免费版]：" . API_PAY_URL . "/notify/{$info['platform_alias']}/noios\r\n";
        }

        if ($info['device_type'] == 3) {
            echo "\r\n  H5游戏登录地址：\r\n";

            if ($login_url['main']) {
                $url = API_SDK_URL;
                if (stripos($login_url['main'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  正式服：" . $url . "/html5/{$info['platform_alias']}\r\n";
            }
            if ($login_url['test']) {
                $url = API_SDK_URL;
                if (stripos($login_url['test'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  测试服：" . $url . "/html5/{$info['platform_alias']}/test\r\n";
            }
            if ($login_url['ios']) {
                $url = API_SDK_URL;
                if (stripos($login_url['ios'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  IOS提审服[内购版]：" . $url . "/html5/{$info['platform_alias']}/ios\r\n";
            }
            if ($login_url['noios']) {
                $url = API_SDK_URL;
                if (stripos($login_url['ios'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  IOS提审服[免费版]：" . $url . "/html5/{$info['platform_alias']}/noios\r\n";
            }
        }

        echo "\r\n\r\n\r\n下载时间：" . date('Y-m-d H:i:s') . "\r\n";

        header("Content-type:  application/octet-stream ");
        header("Accept-Ranges:  bytes ");
        header("Content-Disposition:  attachment;  filename= {$info['game_name']}（{$info['platform_name']}）.txt");
        exit();
    }

    /**
     * 更新所有平台对应游戏缓存
     * @param int $platform_id
     * @param int $game_id
     * @return array
     */
    public function setPlatformGameCache($platform_id = 0, $game_id = 0)
    {
        if ($platform_id > 0 && $game_id > 0) {
            $info = $this->getPlatformGameInfo($platform_id, $game_id);
            $info['config'] = unserialize($info['config']);
            $info['game_config'] = unserialize($info['game_config']);
            $info['platform_config'] = unserialize($info['platform_config']);

            LibRedis::set(LibRedis::$prefix_union . $info['platform_alias'] . '_' . $info['game_id'], $info);
        } else {
            $info = $this->mod->getPlatformGameList();
            foreach ($info['list'] as $row) {
                $row['config'] = unserialize($row['config']);
                $row['game_config'] = unserialize($row['game_config']);
                $row['platform_config'] = unserialize($row['platform_config']);

                LibRedis::set(LibRedis::$prefix_union . $row['platform_alias'] . '_' . $row['game_id'], $row);
            }
        }

        return array('state' => true, 'msg' => '更新成功');
    }

    //玩家日志
    public function getPlayerLog($param = array(), $page = 0, $export = 0)
    {
        if (empty($param['sdate'])) {
            $param['sdate'] = date('Y-m-d H:i:s', time() - 10 * 60);
        }

        if (empty($param['edate'])) {
            $param['edate'] = date('Y-m-d H:i:s', time());
        }

        if ($export) {
            $page = 0;
        } else {
            $page = $page < 1 ? 1 : $page;
        }
        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $logMod = new ModLog();
        $games = $srvPlatform->getAllGame(true);
        $channels = $srvAd->getAllChannel();
        $data = $logMod->getPlayerLog($param, $page);
        foreach ($data['list'] as &$row) {
            $row['h_time'] = date('Y-m-d H:i:s', $row['h_time']);
        }

        $data['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $data['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $data['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $data['parent_id'] = $param['parent_id'];
        $data['game_id'] = $param['game_id'];
        $data['channel_id'] = $param['channel_id'];
        $data['server_id'] = $param['server_id'];
        $data['device_type'] = $param['device_type'];
        $data['role_name'] = $param['role_name'];
        $data['account'] = $param['account'];
        $data['opp'] = $param['opp'];
        $data['ip'] = $param['ip'];
        $data['sdate'] = $param['sdate'];
        $data['edate'] = $param['edate'];
        $data['_channels'] = $channels;
        $data['_games'] = $games;

        if ($export) {
            $header = array(
                '账号', '母游戏', '游戏', '区服', '角色', '当前等级', '登录游戏', '注册游戏', '操作', 'IP', '时间', '设备号', '设备名称', '设备版本'
            );
            $gamesName = $games['list'];
            $h_type = LibUtil::config('ConfLogType');
            $exportData = array();
            foreach ($data['list'] as $row) {
                $exportData[] = array(
                    "\t" . $row['username'],
                    $gamesName[$row['parent_id']],
                    $gamesName[$row['game_id']],
                    $row['server_id'],
                    "\t" . $row['role_name'],
                    $row['role_level'],
                    $gamesName[$row['login_game']],
                    $gamesName[$row['reg_game']],
                    isset($h_type[$row['h_type']]) ? $h_type[$row['h_type']] : '',
                    $row['ip'],
                    $row['h_time'],
                    "\t" . $row['device_id'],
                    $row['device_name'],
                    $row['device_version']
                );
            }
            return array(
                'header' => $header,
                'data' => $exportData,
            );
        }
        return $data;
    }

    /**
     * 测试验收
     * @param string $keyword
     * @return array
     */
    public function acceptTest($keyword = '')
    {
        if (!$keyword) {
            return array();
        }
        return $this->mod->acceptTest($keyword);
    }

    /**
     * 获取游戏扩展信息
     * @param int $game_id
     * @return array|bool|resource|string
     */
    public function getSupport($game_id = 0)
    {
        return $this->mod->getSupport($game_id);
    }

    /**
     * 保存游戏扩展信息
     * @param $game_id
     * @param $name
     * @param $contacts
     * @param $copyright
     * @param $agreement
     * @param $introduction
     * @return array
     */
    public function setSupport($game_id, $name, $contacts, $copyright, $agreement, $introduction)
    {
        $insertData = $updateData = array(
            'name' => $name,
            'contacts' => $contacts,
            'copyright' => $copyright,
            'agreement' => $agreement,
            'introduction' => $introduction
        );
        $insertData['game_id'] = $game_id;

        $ret = $this->mod->insertOrUpdate($insertData, $updateData, LibTable::$sy_game_ext);
        if ($ret) {
            //生成HTML
            $this->supportHtml($game_id);

            return LibUtil::responseData('保存成功', true);
        } else {
            return LibUtil::responseData('保存失败');
        }
    }

    /**
     * 生成游戏技术支持HTML页面
     * @param $game_id
     * @return bool
     */
    public function supportHtml($game_id)
    {
        $template = file_get_contents(TEMPLATE_FILE . 'support.html');
        $info = $this->getSupport($game_id);
        if (empty($info)) {
            return false;
        }

        foreach ($info as $key => $value) {
            $template = str_replace('<{$' . $key . '}>', $value, $template);
        }

        $dir = CDN_STATIC_DIR . '/article/support/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($dir . $game_id . '.html', $template);

        return true;
    }
}