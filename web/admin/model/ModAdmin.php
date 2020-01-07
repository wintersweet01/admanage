<?php

class ModAdmin extends Model
{

    public function getAdminList($page = 0)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }
        $sql = "SELECT a.*, b.`role_name` FROM `" . LibTable::$admin_user . "` a LEFT JOIN `" . LibTable::$admin_role . "` b ON a.`role_id` = b.`role_id` ORDER BY a.`admin_id` DESC {$limit}";
        $count = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$admin_user . "`");
        if (!$count['c']) return array();

        return array(
            'list' => $this->query($sql),
            'total' => $count['c'],
        );
    }

    public function getAdminInfo($admin_id)
    {
        $sql = "SELECT * FROM `" . LibTable::$admin_user . "` WHERE `admin_id` = :admin_id";
        return $this->getOne($sql, array('admin_id' => $admin_id));
    }

    public function deleteAdmin($admin_id)
    {
        $this->delete(array('admin_id' => array('=', $admin_id)), 1, LibTable::$admin_user);
        LibUtil::config('change_' . $admin_id, time());
        return $this->affectedRows();
    }

    public function updateAdminAction($admin_id, $data, $user = [])
    {
        $update = array(
            'name' => $data['name'],
            'role_id' => $data['role_id'],
            'auth_parent_id' => implode(',', $data['parent_id']),
            'auth_game_id' => implode(',', $data['game_id']),
            'auth_channel_id' => implode(',', $data['channel_id']),
            'auth_user_id' => implode(',', $data['user_id']),
        );
        if ($data['pwd']) {
            $update['salt'] = LibUtil::getSalt(10);
            $update['pwd'] = SrvAuth::signPwd($user['user'], $data['pwd'], $update['salt']);
        }
        LibUtil::config('change_' . $admin_id, time());
        $where = array(
            'admin_id' => $admin_id,
        );
        $this->update($update, $where, LibTable::$admin_user);
        return $this->affectedRows();
    }

    public function addAdminAction($data)
    {
        $salt = LibUtil::getSalt(10);
        $insert = array(
            'user' => $data['user'],
            'name' => $data['name'],
            'salt' => $salt,
            'pwd' => SrvAuth::signPwd($data['user'], $data['pwd'], $salt),
            'state' => 0,
            'ct' => time(),
            'creator' => SrvAuth::$name,
            'role_id' => $data['role_id'],
            'auth_parent_id' => implode(',', $data['parent_id']),
            'auth_game_id' => implode(',', $data['game_id']),
            'auth_channel_id' => implode(',', $data['channel_id']),
            'auth_user_id' => implode(',', $data['user_id']),
        );
        return $this->insert($insert, true, LibTable::$admin_user);
    }

    public function getRoleList($page = 0)
    {
        $limit = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $count = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$admin_role . "`");
        if (!$count['c']) return array();

        return array(
            'list' => $this->query("SELECT * FROM `" . LibTable::$admin_role . "` ORDER BY `role_id` DESC {$limit}"),
            'total' => $count['c'],
        );
    }

    public function getRoleInfo($role_id)
    {
        $sql = "SELECT * FROM `" . LibTable::$admin_role . "` WHERE `role_id`= :role_id";
        return $this->getOne($sql, array('role_id' => $role_id));
    }

    public function updateRoleAction($role_id, $data)
    {
        $update = array(
            'role_name' => $data['role_name'],
            'role_menu' => implode('|', $data['role_menu']),
            'role_fun' => implode('|', $data['role_fun'])
        );
        $where = array(
            'role_id' => $role_id
        );
        $this->update($update, $where, LibTable::$admin_role);
        return $this->affectedRows();
    }

    public function addRoleAction($data)
    {
        $insert = array(
            'role_name' => $data['role_name'],
            'role_menu' => implode('|', $data['role_menu']),
            'role_fun' => implode('|', $data['role_fun'])
        );
        return $this->insert($insert, true, LibTable::$admin_role);
    }

    public function roleDelete($role_id)
    {
        $this->delete(array('role_id' => array('=', $role_id)), 1, LibTable::$admin_role);
        return $this->affectedRows();
    }

    public function saveAdminLog($data)
    {
        return $this->insert($data, false, LibTable::$admin_log);
    }

    public function getGroupList()
    {
        $sql = "SELECT * FROM `" . LibTable::$channel_group . "` ORDER BY `group_id` DESC";
        return $this->query($sql);
    }
}