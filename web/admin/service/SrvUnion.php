<?php

class SrvUnion
{
    public $mod;

    public function __construct()
    {
        $this->mod = new ModUnion();
    }

    /**
     * 获取游戏列表
     * @param array $exclude_game
     * @return array
     */
    public function getAllGame($exclude_game = array())
    {
        $info = $this->mod->getAllGame();
        $games = array();
        while (true) {
            if (empty($info)) {
                break;
            }

            $tmp = $list = [];
            foreach ($info as &$v) {
                //排除游戏
                if (!empty($exclude_game) && in_array($v['game_id'], $exclude_game)) {
                    continue;
                }

                $v['config'] = unserialize($v['config']);
                $tmp[$v['game_id']] = array(
                    'pid' => $v['parent_id'],
                    'id' => $v['game_id'],
                    'text' => $v['name'],
                    'inherit' => (int)$v['inherit'],
                    'alias' => $v['alias'],
                    'status' => $v['lock']
                );

                $list[$v['game_id']] = $v['name'];
            }

            krsort($list);
            krsort($tmp);
            $games = array(
                'parent' => LibUtil::build_tree($tmp, 0),
                'list' => $list
            );

            break;
        }
        return $games;
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
     * 获取游戏列表
     * @param int $page
     * @return false|string
     */
    public function getGameList($page = 0)
    {
        $data = $games = [];
        $info = $this->mod->getDataList($page, LibTable::$union_game, 'game_id');
        foreach ($info['list'] as $i) {
            $i['id'] = &$i['game_id'];
            $i['pid'] = &$i['parent_id'];

            if ($i['pid'] > 0) {
                $games[] = $i['id'];
            }

            unset($i['map_gid'], $i['config']);

            $data[$i['id']] = $i;
        }

        if ($page > 0 && !empty($games)) {
            $platform_game = $this->mod->getPlatformGameList(0, $games, 0);
        } else {
            $platform_game = $this->mod->getPlatformGameList();
        }

        foreach ($platform_game['list'] as $row) {
            $id = 10000 . $row['game_id'] . $row['platform_id'];
            $tmp = array(
                'id' => $id,
                'pid' => (int)$row['game_id'],
                'name' => &$row['platform_name'],
                'alias' => &$row['platform_alias'],
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

        return json_encode(array_values($data));
    }

    /**
     * 获取游戏信息
     * @param $game_id
     * @return array|bool|resource|string
     */
    public function getGameInfo($game_id)
    {
        return $this->mod->getDataInfo(LibTable::$union_game, 'game_id', $game_id);
    }

    /**
     * 添加/编辑游戏
     * @param $data
     * @return array
     */
    public function gameAdd($data)
    {
        $game_id = (int)$data['game_id'];

        if (!$data['name'] || !$data['alias']) {
            return array('state' => false, 'msg' => '请填写游戏名称和别名');
        }

        if (!preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]+$/u', $data['name'])) {
            return array('state' => false, 'msg' => '游戏名称只能由中文、字母、数字和减号组成的字符串');
        }

        if (!preg_match('/^[a-z0-9-]+$/', $data['alias'])) {
            return array('state' => false, 'msg' => '游戏别名只能由字母、数字和减号组成的小写字符串');
        }

        //继承父游戏
        if ($data['children_id'] > 0) {
            $data['inherit'] = $data['children_id'];
        }

        $data['is_login'] = (int)$data['is_login'];
        $data['is_pay'] = (int)$data['is_pay'];
        $data['lock'] = (int)$data['lock'];

        unset($data['children_id']);
        $time = time();

        if ($game_id) {
            $data['update_time'] = $time;
            $result = $this->mod->updateData(LibTable::$union_game, $data, array('game_id' => $game_id));
        } else {
            $data['config']['key_cp'] = LibUtil::token('cp');
            $data['create_time'] = $time;
            $result = $this->mod->addData(LibTable::$union_game, $data);
            $game_id = &$result;
        }

        if ($result) {
            //更新缓存
            $this->setGameCache($game_id);

            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    /**
     * 下载游戏参数
     * @param int $game_id
     */
    public function downloadGameParam($game_id = 0)
    {
        $info = $this->getGameInfo($game_id);
        $config = unserialize($info['config']);
        $inherit = (int)$config['inherit'];

        if ($inherit > 0) { //继承子游戏服务端参数
            $parent = $this->getGameInfo($inherit);
            $config = unserialize($parent['config']);
        }

        echo "-----------------以下内容发给CP-----------------\r\n\r\n";
        echo "【{$info['name']}】服务端对接参数（仅保存在服务端）：\r\n\r\n";
        echo "  游戏名称：{$info['name']}\r\n";
        echo "  游戏ID[game_id]：{$game_id}\r\n";
        echo "  服务端密钥[KEY]：{$config['key_cp']}\r\n";
        echo "\r\n\r\n\r\n下载时间：" . date('Y-m-d H:i:s') . "\r\n";

        header("Content-type:  application/octet-stream ");
        header("Accept-Ranges:  bytes ");
        header("Content-Disposition:  attachment;  filename= {$info['name']}.txt");
        exit();
    }

    /**
     * 获取平台列表
     * @param int $page
     * @return false|string
     */
    public function getPlatformList($page = 0)
    {
        $data = $platform = $platform_game = [];
        $info = $this->mod->getDataList($page, LibTable::$union_platform, 'platform_id');
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

        return json_encode(array_values($data));
    }

    /**
     * 获取平台信息
     * @param $platform_id
     * @return array|bool|resource|string
     */
    public function getPlatformInfo($platform_id)
    {
        return $this->mod->getDataInfo(LibTable::$union_platform, 'platform_id', $platform_id);
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
            $result = $this->mod->updateData(LibTable::$union_platform, $data, array('platform_id' => $platform_id));
        } else {
            $data['create_time'] = $time;
            $result = $this->mod->addData(LibTable::$union_platform, $data);
            $platform_id = &$result;
        }

        if ($result) {
            //更新缓存
            $this->setPlatformCache($platform_id);

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
            $result = $this->mod->updateData(LibTable::$union_platform_game, $data, array('game_id' => $game_id, 'platform_id' => $platform_id));
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
            $result = $this->mod->addData(LibTable::$union_platform_game, $data);
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
        echo "联运平台【{$info['platform_name']}】对接参数：\r\n\r\n";
        echo "  游戏名称：{$info['game_name']}\r\n";
        echo "  元宝兑换比例：1:{$info['ratio']}\r\n\r\n";
        echo "  充值地址：\r\n";

        if ($pay_url['main']) {
            echo "  正式服：" . API_SDK_URL . "/union/pay/{$info['id']}\r\n";
        }
        if ($pay_url['test']) {
            echo "  测试服：" . API_SDK_URL . "/union/pay/{$info['id']}/test\r\n";
        }
        if ($pay_url['ios']) {
            echo "  IOS提审服[内购版]：" . API_SDK_URL . "/union/pay/{$info['id']}/ios\r\n";
        }
        if ($pay_url['noios']) {
            echo "  IOS提审服[免费版]：" . API_SDK_URL . "/union/pay/{$info['id']}/noios\r\n";
        }

        if ($info['type'] == 'html5') {
            echo "\r\n  H5游戏登录地址：\r\n";

            if ($login_url['main']) {
                $url = API_SDK_URL;
                if (stripos($login_url['main'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  正式服：" . $url . "/union/login/{$info['id']}\r\n";
            }
            if ($login_url['test']) {
                $url = API_SDK_URL;
                if (stripos($login_url['test'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  测试服：" . $url . "/union/login/{$info['id']}/test\r\n";
            }
            if ($login_url['ios']) {
                $url = API_SDK_URL;
                if (stripos($login_url['ios'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  IOS提审服[内购版]：" . $url . "/union/login/{$info['id']}/ios\r\n";
            }
            if ($login_url['noios']) {
                $url = API_SDK_URL;
                if (stripos($login_url['ios'], 'http://') === 0) {
                    $url = str_ireplace('https://', 'http://', $url);
                }
                echo "  IOS提审服[免费版]：" . $url . "/union/login/{$info['id']}/noios\r\n";
            }
        }

        echo "\r\n\r\n\r\n下载时间：" . date('Y-m-d H:i:s') . "\r\n";

        header("Content-type:  application/octet-stream ");
        header("Accept-Ranges:  bytes ");
        header("Content-Disposition:  attachment;  filename= {$info['game_name']}（{$info['platform_name']}）.txt");
        exit();
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
     * 更新所有平台缓存
     * @param int $platform_id
     * @return array
     */
    public function setPlatformCache($platform_id = 0)
    {
        $data = array();
        $key = LibRedis::$prefix_union_platforms;
        if ($platform_id > 0) {
            $info = $this->getPlatformInfo($platform_id);
            $info['config'] = unserialize($info['config']);

            $data = (array)LibRedis::get($key);
            $data[$info['platform_id']] = $info;
        } else {
            $info = $this->mod->getDataList(0, LibTable::$union_platform, 'platform_id');
            foreach ($info['list'] as $row) {
                $row['config'] = unserialize($row['config']);
                $data[$row['platform_id']] = $row;
            }
        }

        $ret = LibRedis::set($key, $data);
        if ($ret) {
            return array('state' => true, 'msg' => '更新成功');
        } else {
            return array('state' => false, 'msg' => '更新失败');
        }
    }

    /**
     * 更新所有游戏缓存
     * @param int $game_id
     * @return array
     */
    public function setGameCache($game_id = 0)
    {
        $data = array();
        $key = LibRedis::$prefix_union_games;
        if ($game_id > 0) {
            $info = $this->getGameInfo($game_id);
            $info['config'] = unserialize($info['config']);

            $data = (array)LibRedis::get($key);
            $data[$info['game_id']] = $info;
        } else {
            $info = $this->mod->getDataList(0, LibTable::$union_game, 'game_id');
            foreach ($info['list'] as $row) {
                $row['config'] = unserialize($row['config']);
                $data[$row['game_id']] = $row;
            }
        }

        $ret = LibRedis::set($key, $data);
        if ($ret) {
            return array('state' => true, 'msg' => '更新成功');
        } else {
            return array('state' => false, 'msg' => '更新失败');
        }
    }

    /**
     * 更新所有平台对应游戏缓存
     * @param int $platform_id
     * @param int $game_id
     * @return bool
     */
    public function setPlatformGameCache($platform_id = 0, $game_id = 0)
    {
        if ($platform_id > 0 && $game_id > 0) {
            $info = $this->getPlatformGameInfo($platform_id, $game_id);
            $info['game_config'] = unserialize($info['game_config']);
            $info['platform_config'] = unserialize($info['platform_config']);

            LibRedis::set(LibRedis::$prefix_union_game_platform . $info['id'], $info);
        } else {
            $info = $this->mod->getPlatformGameList();
            foreach ($info['list'] as $row) {
                $row['game_config'] = unserialize($row['game_config']);
                $row['platform_config'] = unserialize($row['platform_config']);

                LibRedis::set(LibRedis::$prefix_union_game_platform . $row['id'], $row);
            }
        }
        return true;
    }
}