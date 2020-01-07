<?php

class ModAuth extends Model
{

    public function __construct()
    {
        $this->conn = 'default';
    }

    /**
     * 获取登录信息
     * @param $user
     * @return array|bool|resource|string
     */
    public function getLoginInfo($user)
    {
        $sql = "SELECT a.*, b.* FROM `" . LibTable::$admin_user . "` a LEFT JOIN `" . LibTable::$admin_role . "` b ON a.`role_id` = b.`role_id` WHERE a.`user` = :user";
        return $this->getOne($sql, array('user' => $user));
    }

    /**
     * 更新登录信息
     * @param $user
     * @return bool
     */
    public function updateLoginInfo($user)
    {
        $this->update(array('last_ip' => LibUtil::getIp(), 'last_lt' => time()), array('user' => $user), LibTable::$admin_user);
        return $this->affectedRows();
    }

    /**
     * 更新管理员信息
     * @param $id
     * @param $data
     * @return int
     */
    public function updateAdminInfo($id, $data)
    {
        $this->update($data, array('admin_id' => $id), LibTable::$admin_user);
        return $this->affectedRows();
    }

    /**
     * 获取所有管理员信息
     * @param int $id
    */
    public function getAll($id = ''){
        $where = '';
        $param = array();
        if($id){
            $param['id'] = $id;
            $where = ' where `admin_id`=:id';
        }
        $sql = "select `admin_id`,`role_id`,`user`,`name`,`state` from `".LibTable::$admin_user."` {$where} ";

        $row = $this->query($sql,$param);
        return $row;
    }
}