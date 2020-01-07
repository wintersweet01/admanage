<?php

/**
 * Created by PhpStorm.
 * User: qinsh
 * Date: 2018/4/17 0017
 * Time: 15:50
 */
class ModIndex extends Model
{
    /**
     * 获取当前管理员信息
     * @return array|bool|resource|string
     */
    public function getAdminInfo()
    {
        $admin_id = SrvAuth::$id;

        $sql = "SELECT * FROM `" . LibTable::$admin_user . "` WHERE `admin_id` = :admin_id";
        return $this->getOne($sql, array('admin_id' => $admin_id));
    }

    /**
     * 修改个人信息
     * @param $data
     * @return int
     */
    public function modifyAdminInfo($data)
    {
        $admin_id = SrvAuth::$id;
        $username = SrvAuth::$name;
        $salt = LibUtil::getSalt(10);
        $update = array(
            'name' => $data['name'],
            'salt' => $salt,
            'pwd' => SrvAuth::signPwd($username, $data['password1'], $salt)
        );
        $where = array(
            'admin_id' => $admin_id,
        );
        $this->update($update, $where, LibTable::$admin_user);
        return $this->affectedRows();
    }
}