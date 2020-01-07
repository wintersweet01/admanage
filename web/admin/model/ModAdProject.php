<?php

class ModAdProject extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    public function getReferralLink($channel_id, $user_id, $game_id)
    {
        $sql = "SELECT a.*, b.`platform`, b.`down_url` FROM " . LibTable::$ad_project . " as a 
                LEFT JOIN `" . LibTable::$sy_game_package . "` as b ON a.`package_name` = b.`package_name`
                WHERE a.`channel_id` = :channel_id AND a.`game_id` = :game_id AND a.`user_id` = :user_id AND a.`is_use` = :is_use";
        return $this->getOne($sql, ['channel_id' => $channel_id, 'game_id' => $game_id, 'user_id' => $user_id, 'is_use' => 0]);
    }

    public function updateIsUse($id, $is_use = 1)
    {
        return $this->update(['is_use' => $is_use], $id, LibTable::$ad_project);
    }
}