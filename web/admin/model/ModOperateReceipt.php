<?php

class ModOperateReceipt extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    public function operateReceipt($type, $parent_id, $sdate, $edate)
    {
        $param = [];
        $condition = '';
        if ($parent_id > 0) {
            $condition .= ' AND b.parent_id = :parent_id ';
            $param['parent_id'] = $parent_id;
        }
        if ($sdate) {
            $condition .= ' AND a.`date` >= :sdate ';
            $param['sdate'] = $sdate;
        }
        if ($edate) {
            $condition .= ' AND a.`date` <= :edate ';
            $param['edate'] = $edate;
        }
        if ($type == 1) {
            $group = 'a.`date`';
        } else {
            $group = 'b.`parent_id`';
        }

        $sql = "SELECT {$group} AS `group_name`, SUM(a.`income`) AS `income`, a.`channel_name` 
                FROM " . LibTable::$data_finance . " a 
                    LEFT JOIN `" . LibTable::$sy_game . "` b ON b.`game_id` = a.`game_id` 
                where 1 {$condition} 
                GROUP BY `group_name`, a.`channel_name` ORDER BY `group_name` DESC, a.`channel_name` ASC";
        return $this->query($sql, $param);
    }
}