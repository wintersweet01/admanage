<?php
/**
 * 用户授权模型类
 * Class ModChannelUserAuth
 * @author dyh
 * @version 2010/01/11
 */

class ModChannelUserAuth extends Model
{
    public function __construct()
    {
        $this->conn = 'default';
    }

    public function saveAccessToken($data = [])
    {
        return $this->insert($data, false, LibTable::$channel_user_auth, array('replace' => true));
    }

    public function getUserById($id)
    {
        $condition = 'where 1 = 1 ';
        $parameter = [];

        if(is_array($id)) {
            $condition .= 'AND `user_id` in ('.implode(',' ,$id).') ';
        }else if(is_numeric($id)){
            $condition .= 'AND `user_id=:user_id`';
            $parameter['user_id'] = $id;
        }

        return $this->query("SELECT * FROM `" . LibTable::$channel_user_auth . "` {$condition} ", $parameter);
    }
}