<?php

class ModTest extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    public function getPackageAll()
    {
        $sql = "SELECT game_id, platform FROM `" . LibTable::$sy_game_package . "` GROUP BY game_id, platform";
        return $this->query($sql);
    }

    public function getLoginStat($parent_id = 0, $sdate = '', $edate = '', $ids = array())
    {
        $param = array();
        $condition = '';
        if ($parent_id > 0) {
            $condition .= " AND b.parent_id = :parent_id";
            $param['parent_id'] = $parent_id;
        }
        if ($sdate) {
            $condition .= " AND a.date >= :sdate";
            $param['sdate'] = $sdate;
        }
        if ($edate) {
            $condition .= " AND a.date <= :edate";
            $param['edate'] = $edate;
        }
        if ($ids) {
            $condition .= " AND a.uid IN(:ids)";
            $param['ids'] = $ids;
        }

        $sql = "SELECT a.date, COUNT(DISTINCT a.uid) num, GROUP_CONCAT( DISTINCT a.uid ) ids 
                FROM `" . LibTable::$data_login_log . "` a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON a.game_id = b.game_id 
                WHERE 1 {$condition} 
                GROUP BY a.date ORDER BY a.date";
        return $this->query($sql, $param);
    }
}