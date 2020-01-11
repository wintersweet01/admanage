<?php
/**
 * Class ModAdProject
 * @author dyh
 */
class ModAdProject extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    public function getReferralLink($channel_id, $user_id, $game_id)
    {
        $sql = "SELECT a.*, b.`platform`, b.`down_url`, c.`convert_id`, c.`status`, c.`opt_status` d.`domain`, d.`download_domain`,FROM " . LibTable::$ad_project . " as a 
                LEFT JOIN `" . LibTable::$sy_game_package . "` as b ON a.`package_name` = b.`package_name`
                LEFT JOIN `". LibTable::$monitor_convert . "` as c ON a.`monitor_id` = c.`monitor_id`
                 LEFT JOIN `" . LibTable::$channel_user . "` d ON a.`user_id` = d.`user_id` 
                WHERE a.`channel_id` = :channel_id AND a.`game_id` = :game_id AND a.`user_id` = :user_id AND a.`is_use` = :is_use AND c.`status` = 1 AND c.`opt_status` = 1";
        return $this->getOne($sql, ['channel_id' => $channel_id, 'game_id' => $game_id, 'user_id' => $user_id, 'is_use' => 0]);
    }

    public function getLinkInfo($monitor_id)
    {
        $sql = "SELECT a.*, b.`platform` AS device_type, b.`down_url`, c.`domain`, c.`download_domain`, e.`parent_id`, e.`name` as game_name, d.access_token,d.account_id
                FROM `" . LibTable::$ad_project . "` a 
                LEFT JOIN `" . LibTable::$sy_game_package . "` b ON a.`package_name` = b.`package_name` 
                LEFT JOIN `" . LibTable::$channel_user . "` c ON a.`user_id` = c.`user_id` 
                LEFT JOIN `" . LibTable::$channel_user_auth . "` d ON a.`user_id` = d.`user_id` 
                LEFT JOIN `" . LibTable::$sy_game . "` e ON a.`game_id` = e.`game_id` 
                WHERE a.`monitor_id` = :monitor_id";

        return $this->getOne($sql, array('monitor_id' => $monitor_id));
    }

    public function updateIsUse($id, $is_use = 1)
    {
        return $this->update(['is_use' => $is_use], $id, LibTable::$ad_project);
    }
}