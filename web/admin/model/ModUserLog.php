<?php

class ModUserLog extends Model
{
    public $conn = 'user_log';

    public function logList($page = 0, $uid = 0, $type = 0, $sdate = '', $edate = '')
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $condition = '';
        if ($uid > 0) {
            $condition .= " AND `uid` = :uid";
            $param['uid'] = $uid;
        }
        if ($type) {
            $condition .= " AND `type` = :type";
            $param['type'] = $type;
        }
        if ($sdate) {
            $condition .= " AND FROM_UNIXTIME(`time`, '%Y-%m-%d') >= :sdate";
            $param['sdate'] = $sdate;
        }
        if ($edate) {
            $condition .= " AND FROM_UNIXTIME(`time`, '%Y-%m-%d') <= :edate";
            $param['edate'] = $edate;
        }

        $data = [];
        $table = LibTable::$log_user . ($uid % 100);
        $row = $this->getOne("SELECT COUNT(*) AS c FROM `" . $table . "` WHERE 1 {$condition}", $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $data = $this->query("SELECT * FROM `" . $table . "` WHERE 1 {$condition} ORDER BY `type` ASC, `id` DESC {$limit}", $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取用户日志各个类型最新一条
     * @param int $uid
     * @return array|bool|resource|string
     */
    public function getLastLog($uid = 0)
    {
        $table = LibTable::$log_user . ($uid % 100);
        $sql = "SELECT a.* FROM `" . $table . "` a 
                    INNER JOIN (
                        SELECT MAX(`id`) AS id FROM `" . $table . "` WHERE `uid` = :uid GROUP BY `type`
                    ) b ON a.id = b.id 
                WHERE a.`uid` = :uid ORDER BY a.`type` ASC";
        return $this->query($sql, array('uid' => $uid));
    }
}