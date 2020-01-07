<?php

class SrvAdmin
{

    private $mod;

    public function __construct()
    {
        $this->mod = new ModAdmin();
    }

    public function getAdminList($page)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getAdminList($page);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        return $info;
    }

    public function getAllAdmin()
    {
        $info = $this->mod->getAdminList();
        $admins = array();
        if ($info['total'] > 0) {
            foreach ($info['list'] as $v) {
                $admins[$v['user']] = $v['name'] ? $v['name'] : $v['user'];
            }
        }
        return $admins;
    }

    public function getMenu()
    {
        $menu = LibUtil::config('confMenu');
        $m = array();
        foreach ($menu as $k => $u) {
            foreach ($u['menu'] as $kk => $vv) {
                $m[$u['name']][$k . '-' . $kk] = $vv;
            }
        }
        return $m;
    }

    public function getPublicAuth()
    {
        $auth = LibUtil::config('confPublicAuth');
        return $auth;
    }

    public function getAdminInfo($admin_id)
    {
        return $this->mod->getAdminInfo($admin_id);
    }

    public function deleteAdmin($admin_id)
    {
        if ($admin_id <= 0) {
            LibUtil::response('参数错误');
        }
        if (SrvAuth::$id == $admin_id) {
            LibUtil::response('不能删除自己');
        }
        if ($admin_id == 1) {
            LibUtil::response('不能删除超级管理员');
        }

        $result = $this->mod->deleteAdmin($admin_id);
        if ($result) {
            LibUtil::response('删除成功', 1);
        } else {
            LibUtil::response('删除失败');
        }
    }

    public function addAdminAction($admin_id, $data)
    {
        if ($data['role_id'] <= 0) {
            return array('state' => false, 'msg' => '请选择角色');
        }

        if ($data['pwd']) {
            if ($data['pwd'] != $data['pwd2']) {
                return array('state' => false, 'msg' => '两次输入密码不一致');
            }
            if (strlen($data['pwd']) < 6) {
                return array('state' => false, 'msg' => '密码不能低于6位');
            }
        }

        if ($admin_id) {
            if (SrvAuth::$id == $admin_id) {
                LibUtil::response('不能编辑自己权限');
            }

            $user = $this->getAdminInfo($admin_id);
            if (empty($user)) {
                LibUtil::response('用户不存在');
            }

            $result = $this->mod->updateAdminAction($admin_id, $data, $user);
        } else {
            if (strlen($data['user']) < 3) {
                return array('state' => false, 'msg' => '账号不能低于3位');
            }
            if (!$data['pwd']) {
                return array('state' => false, 'msg' => '密码不能为空');
            }

            $result = $this->mod->addAdminAction($data);
        }

        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function timeGap($sdate, $edate, $type)
    {

        if ($edate == '') {
            $edate = date('Y-m-d H:i:s');
        }
        if ($sdate == '') {
            $sdate = date('Y-m-d 00:00:00');
        }
        $info = $this->mod->timeGap($sdate, $edate, $type);

        foreach ($info['list'] as $key => $row) {
            $num[$key] = $row ['function_name'];
        }
        array_multisort($num, SORT_ASC, $info['list']);
        foreach ($info['list'] as $key => $val) {
            $info['date'][$val['date']][] = $val;
        }
        foreach ($info['list'] as $key => $val) {
            $info['lists'][$val['function_name']][] = $val;
        }


        $info['_type'] = $this->mod->timeGapType();
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['type'] = $type;
        return $info;
    }

    public function timeDayGap($sdate, $edate, $type, $time_unit)
    {
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        if ($sdate == '') {
            $sdate = date('Y-m-01');
        }
        if ($type == '') {
            $type = 'deviceActiveDay';
        }

        $info = $this->mod->timeDayGap($sdate, $edate, $type, $time_unit);

        foreach ($info['list'] as $key => $row) {
            $num[$key] = $row ['date'];
        }
        array_multisort($num, SORT_ASC, $info['list']);
        foreach ($info['list'] as $key => $val) {
            $info['date'][$val['date']][] = $val;
        }
        foreach ($info['list'] as $key => $val) {
            $info['lists'][$val['function_name']][] = $val;
        }
        $temp = array();
        $i = 0;
        foreach ($info['lists'] as $key => $val) {

            foreach ($val as $k => $v) {
                $temp[$i][] = (strtotime(($v['date'])) + 8 * 3600) * 1000;
                $temp[$i][] = (int)$v['max'];
                $temp[$i][] = (int)$v['max'];
                $temp[$i][] = (int)$v['min'];
                $temp[$i][] = (int)$v['min'];
                $i++;
            }

            // $temp .= ',';

        }
        $info['lists'] = json_encode($temp);

        $info['time_unit'] = $time_unit;
        $info['_type'] = $this->mod->timeGapType();
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['type'] = $type;
        return $info;
    }

    /**
     * 角色列表
     * @param $page
     * @return array
     */
    public function getRoleList($page)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getRoleList($page);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        return $info;
    }

    /**
     * 获取角色信息
     * @param $role_id
     * @return mixed
     */
    public function getRoleInfo($role_id)
    {
        return $this->mod->getRoleInfo($role_id);
    }

    /**
     * 获取所有角色列表
     * @return array
     */
    public function getAllRole()
    {
        $info = $this->mod->getRoleList();
        $data = array();
        if ($info['total'] > 0) {
            foreach ($info['list'] as $v) {
                $data[$v['role_id']] = $v['role_name'];
            }
        }
        return $data;
    }

    public function roleAddAction($role_id, $data)
    {
        if (!$data['role_name']) {
            return array('state' => false, 'msg' => '角色名称不能为空');
        }

        if ($role_id) {
            $result = $this->mod->updateRoleAction($role_id, $data);
        } else {
            $result = $this->mod->addRoleAction($data);
        }
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function roleDelete($role_id)
    {
        if ($role_id <= 0) {
            LibUtil::response('参数错误');
        }

        $result = $this->mod->roleDelete($role_id);
        if ($result) {
            LibUtil::response('删除成功', 1);
        } else {
            LibUtil::response('删除失败');
        }
    }

    /**
     * 保存管理员操作日志
     * @param string $type
     * @param string $msg
     * @return resource|string
     */
    public function saveAdminLog($type = '', $msg = '')
    {
        $data = array(
            'admin_id' => $_SESSION['userid'],
            'username' => $_SESSION['username'],
            'type' => $type,
            'ip' => LibUtil::getIp(),
            'create_time' => time(),
            'msg' => is_array($msg) ? serialize($msg) : $msg
        );
        return $this->mod->saveAdminLog($data);
    }

    /**
     *
     * @return array
     */
    public function getGroupList()
    {
        $admin = [];
        $tmp = $this->mod->getAdminList();
        foreach ($tmp['list'] as $row) {
            $admin[$row['admin_id']] = $row['name'] ? $row['name'] : $row['user'];
        }

        $data = [];
        $info = $this->mod->getGroupList();
        foreach ($info as $row) {
            $data[$row['group_id']]['id'] = $row['group_id'];
            $data[$row['group_id']]['text'] = $row['group_name'];

            $children = [];
            $arr = explode(',', $row['group_admin_id']);
            foreach ($arr as $uid) {
                $children[$uid]['id'] = $uid;
                $children[$uid]['text'] = $admin[$uid];
            }

            $data[$row['group_id']]['children'] = $children;
        }

        return array(
            'list' => $data,
            'admin' => $admin
        );
    }

    /**
     * 投放组管理
     * @param int $group_id
     * @param string $ids
     * @return array
     */
    public function updateChannelGroup($group_id = 0, $ids = '')
    {
        if (!$group_id) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $mod = new ModAd();
        $result = $mod->updateDeliveryGroupAction($group_id, array('group_admin_id' => trim(trim($ids), ',')));
        if ($result) {
            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }
}