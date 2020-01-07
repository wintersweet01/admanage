<?php

require_once LIB . '/library/GatewayClient/Gateway.php';

use GatewayClient\Gateway;

class SrvUser
{
    private $mod;

    public function __construct()
    {
        $this->mod = new ModUser();
    }

    /**
     * 指定用户的关联IP/设备号列表
     * @param string $type
     * @param int $uid
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getUserRelateList($type = '', $uid = 0, $page = 1, $limit = 10)
    {
        $group = array(
            'ip' => 'login_ip',
            'device' => 'device_id',
        );
        $group_name = $group[$type];
        $ip = new LibIp();

        $i = 0;
        $info = $this->mod->getUserRelateList($type, $uid, $group_name, $page, $limit);
        foreach ($info['list'] as &$row) {
            $row['index'] = $i;
            if ($type == 'ip' && $row['group_name']) {
                $r = $ip->getlocation($row['group_name']);
                $row['area'] = $r['country'] . ' ' . $r['isp'];
            }

            $i++;
        }

        return $info;
    }

    /**
     * 查询对应IP/设备号的关联账号
     * @param string $type
     * @param string $content
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getUserRelateInfo($type = '', $content = '', $page = 1, $limit = 10)
    {
        $i = 0;
        $ip = new LibIp();
        $group = array(
            'ip' => 'login_ip',
            'device' => 'device_id',
        );
        $group_name = $group[$type];

        $info = $this->mod->getUserRelateInfo($content, $group_name, $page, $limit);
        foreach ($info['list'] as &$row) {
            $row['index'] = $i;

            if ($row['reg_ip']) {
                $r = $ip->getlocation($row['reg_ip']);
                $row['reg_country'] = $r['country'];
                $row['reg_area'] = $r['country'] . ' ' . $r['isp'];
            }

            if ($row['last_login_ip']) {
                $r = $ip->getlocation($row['last_login_ip']);
                $row['last_login_country'] = $r['country'];
                $row['last_login_area'] = $r['country'] . ' ' . $r['isp'];
            }

            $i++;
        }

        return $info;
    }

    /**
     * 封禁/解封操作
     * @param string $type
     * @param string $handle
     * @param string $content
     * @param int $uid
     * @param string $text
     * @return array
     */
    public function banHandle($type = '', $handle = '', $content = '', $uid = 0, $text = '')
    {
        $_type = array(
            'ip' => 1,
            'device' => 2,
            'user' => 3
        );

        $group = array(
            'ip' => 'login_ip',
            'device' => 'device_id',
            'user' => 'uid',
        );
        $group_name = $group[$type];

        $time = time();
        $ban = array();
        switch ($handle) {
            case 'ban':
                $info = $this->mod->getDataInfo(LibTable::$forbidden_white, array('type' => $_type[$type], 'content' => $content));
                if (!empty($info)) {
                    return LibUtil::responseData('该记录已标记为正常，不能封禁');
                }

                $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                if ($info['handle'] == 'all') {
                    return LibUtil::responseData('该记录已封禁过');
                }

                $ban[] = array(
                    'type' => $_type[$type],
                    'content' => $content,
                    'notes' => $text,
                    'handle' => 'all',
                    'time' => $time,
                    'admin' => SrvAuth::$name,
                );
                break;
            case 'unban':
                $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                if (empty($info)) {
                    return LibUtil::responseData('记录不存在');
                }

                $ban[] = array(
                    'type' => $_type[$type],
                    'content' => $content,
                    'handle' => '',
                );
                break;
            case 'login_ban':
                if ($content == 'all') {
                    $info = $this->mod->getUserRelateList($type, $uid, $group_name, 0);
                    foreach ($info['list'] as $row) {
                        //已经封禁或者存在白名单的，跳过
                        if ($row['content'] || in_array($row['handle'], array('all', 'login'))) {
                            continue;
                        }

                        $ban[] = array(
                            'type' => $_type[$type],
                            'content' => $row['group_name'],
                            'notes' => $text,
                            'handle' => $row['handle'] == 'reg' ? 'all' : 'login',
                            'time' => $time,
                            'admin' => SrvAuth::$name,
                        );
                    }
                } else {
                    $info = $this->mod->getDataInfo(LibTable::$forbidden_white, array('type' => $_type[$type], 'content' => $content));
                    if (!empty($info)) {
                        return LibUtil::responseData('该记录已标记为正常，不能封禁');
                    }

                    $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                    if (in_array($info['handle'], array('all', 'login'))) {
                        return LibUtil::responseData('该记录已封禁过');
                    }

                    $ban[] = array(
                        'type' => $_type[$type],
                        'content' => $content,
                        'notes' => $text,
                        'handle' => $info['handle'] == 'reg' ? 'all' : 'login',
                        'time' => $time,
                        'admin' => SrvAuth::$name,
                    );
                }
                break;
            case 'reg_ban':
                if ($content == 'all') {
                    $info = $this->mod->getUserRelateList($type, $uid, $group_name, 0);
                    foreach ($info['list'] as $row) {
                        //已经封禁或者存在白名单的，跳过
                        if ($row['content'] || in_array($row['handle'], array('all', 'reg'))) {
                            continue;
                        }

                        $ban[] = array(
                            'type' => $_type[$type],
                            'content' => $row['group_name'],
                            'notes' => $text,
                            'handle' => $row['handle'] == 'login' ? 'all' : 'reg',
                            'time' => $time,
                            'admin' => SrvAuth::$name,
                        );
                    }
                } else {
                    $info = $this->mod->getDataInfo(LibTable::$forbidden_white, array('type' => $_type[$type], 'content' => $content));
                    if (!empty($info)) {
                        return LibUtil::responseData('该记录已标记为正常，不能封禁');
                    }

                    $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                    if (in_array($info['handle'], array('all', 'reg'))) {
                        return LibUtil::responseData('该记录已封禁过');
                    }

                    $ban[] = array(
                        'type' => $_type[$type],
                        'content' => $content,
                        'notes' => $text,
                        'handle' => $info['handle'] == 'login' ? 'all' : 'reg',
                        'time' => $time,
                        'admin' => SrvAuth::$name,
                    );
                }
                break;
            case 'login_unban':
                if ($content == 'all') {
                    $info = $this->mod->getUserRelateList($type, $uid, $group_name, 0);
                    foreach ($info['list'] as $row) {
                        //没有封禁过，或者只封禁注册的，跳过
                        if (!$row['handle'] || $row['handle'] == 'reg') {
                            continue;
                        }

                        $ban[] = array(
                            'type' => $_type[$type],
                            'content' => $row['group_name'],
                            'handle' => $row['handle'] == 'all' ? 'reg' : '',
                        );
                    }
                } else {
                    $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                    if (empty($info) || $info['handle'] == 'reg') {
                        return LibUtil::responseData('记录不存在或者没有封禁登录');
                    }

                    $ban[] = array(
                        'type' => $_type[$type],
                        'content' => $content,
                        'handle' => $info['handle'] == 'all' ? 'reg' : '',
                    );
                }
                break;
            case 'reg_unban':
                if ($content == 'all') {
                    $info = $this->mod->getUserRelateList($type, $uid, $group_name, 0);
                    foreach ($info['list'] as $row) {
                        //没有封禁过，或者只封禁注册的，跳过
                        if (!$row['handle'] || $row['handle'] == 'login') {
                            continue;
                        }

                        $ban[] = array(
                            'type' => $_type[$type],
                            'content' => $row['group_name'],
                            'handle' => $row['handle'] == 'all' ? 'login' : '',
                        );
                    }
                } else {
                    $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                    if (empty($info) || $info['handle'] == 'login') {
                        return LibUtil::responseData('记录不存在或者没有封禁登录');
                    }

                    $ban[] = array(
                        'type' => $_type[$type],
                        'content' => $content,
                        'handle' => $info['handle'] == 'all' ? 'login' : '',
                    );
                }
                break;
            case 'user_ban_all':
                $info = $this->mod->getUserRelateInfo($content, $group_name, 0);
                foreach ($info['list'] as $row) {
                    //已经封禁或者存在白名单的，跳过
                    if ($row['content'] || $row['status']) {
                        continue;
                    }

                    $ban[] = array(
                        'type' => $_type['user'],
                        'content' => $row['uid'],
                        'notes' => $text,
                        'handle' => 'all',
                        'time' => $time,
                        'admin' => SrvAuth::$name,
                    );

                    //踢下线
                    $this->kickUser($row['uid'], '由于您有违规嫌疑，已账号被封禁，有疑问请联系客服');
                }
                break;
            case 'user_unban_all':
                $info = $this->mod->getUserRelateInfo($content, $group_name, 0);
                foreach ($info['list'] as $row) {
                    //没有封禁过的，跳过
                    if (!$row['status']) {
                        continue;
                    }

                    $ban[] = array(
                        'type' => $_type['user'],
                        'content' => $row['uid'],
                        'handle' => '',
                    );
                }
                break;
            case 'user_ban':
                $info = $this->mod->getDataInfo(LibTable::$forbidden_white, array('type' => $_type[$type], 'content' => $content));
                if (!empty($info)) {
                    return LibUtil::responseData('该记录已标记为正常，不能封禁');
                }

                $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                if (!empty($info)) {
                    return LibUtil::responseData('该记录已封禁过');
                }

                $ban[] = array(
                    'type' => $_type[$type],
                    'content' => $content,
                    'notes' => $text,
                    'handle' => 'all',
                    'time' => $time,
                    'admin' => SrvAuth::$name,
                );

                //踢下线
                $this->kickUser($content, '由于您有违规嫌疑，已账号被封禁，有疑问请联系客服');
                break;
            case 'user_unban':
                $info = $this->mod->getDataInfo(LibTable::$forbidden, array('type' => $_type[$type], 'content' => $content));
                if (empty($info)) {
                    return LibUtil::responseData('记录不存在');
                }

                $ban[] = array(
                    'type' => $_type[$type],
                    'content' => $content,
                    'handle' => '',
                );
                break;
        }

        if (empty($ban)) {
            return LibUtil::responseData('没有可封禁/解封的数据');
        }

        $ret = $this->mod->banHandle($ban);
        if (!empty($ret)) {
            return LibUtil::responseData("<br>有部分数据没有操作成功<br>" . var_export($ret, true), 1);
        } else {
            return LibUtil::responseData('', 1);
        }
    }

    /**
     * 标记白名单
     * @param string $type
     * @param string $handle
     * @param string $content
     * @return array
     */
    public function whiteHandle($type = '', $handle = '', $content = '')
    {
        $_type = array(
            'ip' => 1,
            'device' => 2,
            'user' => 3
        );

        if ($handle == 'add') {
            $ret = $this->mod->addData(LibTable::$forbidden_white, array('type' => $_type[$type], 'content' => $content, 'time' => time()));
        } else {
            $ret = $this->mod->delData(LibTable::$forbidden_white, array('type' => $_type[$type], 'content' => $content));
        }

        if ($ret === false) {
            return LibUtil::responseData('标记失败');
        } else {
            return LibUtil::responseData('标记成功', 1);
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
            return LibUtil::responseData('uid不能为空');
        }

        if ($ip = LibUtil::getIp() == '127.0.0.1') {
            return LibUtil::responseData('开发环境不能使用');
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
            return LibUtil::responseData('当前用户不在线');
        }

        //通知客户端
        Gateway::sendToUid($uid, $json);

        return LibUtil::responseData('', 1);
    }

    /**
     * 获取封禁列表
     * @param string $type
     * @param string $keyword
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getForbiddenList($type = '', $keyword = '', $page = 1, $limit = 10)
    {
        $ip = new LibIp();
        $info = $this->mod->getForbiddenList($type, $keyword, $page, $limit);
        if ($type == 'ip') {
            foreach ($info['list'] as &$row) {
                $r = $ip->getlocation($row['content']);
                $row['area'] = $r['country'] . ' ' . $r['isp'];
            }
        }
        return $info;
    }

    /**
     * 添加封禁
     * @param string $type
     * @param string $content
     * @param string $notes
     * @param string $handle
     */
    public function forbiddenAdd($type = '', $content = '', $notes = '', $handle = '')
    {
        if (!$content) {
            LibUtil::response('请填写封禁内容');
        }
        if (!$notes) {
            LibUtil::response('请填写封禁原因');
        }

        $_type = array(
            'ip' => 1,
            'device' => 2,
            'user' => 3
        );

        $time = time();
        $ban = $user_ban = array();
        $tmp = explode("\n", $content);
        foreach ($tmp as $val) {
            $val = trim($val);

            if (empty($val)) {
                continue;
            }

            if ($type == 'ip' && !filter_var($val, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                continue;
            }

            if ($type == 'user') {
                $user_ban[$val] = array(
                    'type' => $_type[$type],
                    'content' => '',
                    'notes' => $notes,
                    'handle' => 'all',
                    'time' => $time,
                    'admin' => SrvAuth::$name,
                );
            } else {
                $ban[] = array(
                    'type' => $_type[$type],
                    'content' => $val,
                    'notes' => $notes,
                    'handle' => $handle,
                    'time' => $time,
                    'admin' => SrvAuth::$name,
                );
            }
        }

        if (!empty($user_ban)) {
            $users = $this->mod->getUserUid(array_keys($user_ban));
            foreach ($users as $row) {
                $tmp = $user_ban[$row['username']];
                $tmp['content'] = $row['uid'];

                $ban[] = $tmp;

                //踢下线
                $this->kickUser($row['uid'], '由于您有违规嫌疑，已账号被封禁，有疑问请联系客服');
            }
        }

        if (empty($ban)) {
            LibUtil::response('没有可封禁/解封的数据');
        }

        $ret = $this->mod->banHandle($ban);
        if (!empty($ret)) {
            LibUtil::response("封禁成功<br>有部分数据没有操作成功<br>" . var_export($ret, true), 1);
        } else {
            LibUtil::response('封禁成功', 1);
        }
    }

    /**
     * 导出封禁列表
     * @param string $type
     * @return array
     */
    public function forbiddenExport($type = '')
    {
        $_type = array(
            'ip' => 'IP',
            'device' => '设备号',
            'user' => 'UID'
        );

        $header = array(
            $_type[$type], '封禁时间', '备注', '操作者', '其他'
        );

        if ($type == 'ip') {
            $header[4] = '地区';
        }

        if ($type == 'user') {
            $header[4] = '账号';
        }

        $ip = new LibIp();
        $data = array();
        $info = $this->getForbiddenList($type, '', 0);
        foreach ($info['list'] as $row) {
            $tmp = array(
                $row['content'],
                date('Y-m-d H:i:s', $row['time']),
                $row['notes'],
                $row['admin_name']
            );

            if ($type == 'ip') {
                $r = $ip->getlocation($row['content']);
                $tmp[4] = $r['country'] . ' ' . $r['isp'];
            }

            if ($type == 'user') {
                $tmp[4] = $row['username'];
            }

            $data[] = $tmp;
        }

        return array(
            'header' => $header,
            'data' => $data,
        );
    }

    /**
     * 获取关联账号排行列表
     * @param string $type
     * @param int $num
     * @param int $show_whitelist
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getRelateHotList($type = '', $num = 10, $show_whitelist = 0, $page = 1, $limit = 10)
    {
        $i = 0;
        $ip = new LibIp();
        $info = $this->mod->getRelateHotList($type, $num, $show_whitelist, $page, $limit);
        foreach ($info['list'] as &$row) {
            $row['index'] = $i;
            if ($type == 'ip' && $row['group_name']) {
                $r = $ip->getlocation($row['group_name']);
                $row['area'] = $r['country'] . ' ' . $r['isp'];
            }

            $i++;
        }

        return $info;
    }
}