<?php


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

        if(is_array($id)) {
            $condition .= 'AND `user_id` in ('.implode(',' ,$id).') ';
        }
        return $this->query("SELECT * FROM `" . LibTable::$channel_user_auth . "` {$condition} ");
    }
}