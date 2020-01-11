<?php
/**
 * 今日头条广告推送记录表模型
 * Class ModJrttAdPushRecord
 * @author dyh
 * @version 2020/01/11
 */

class ModJrttAdPushRecord extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    public function addAdRecord(array $data)
    {
        return $this->multiInsert($data,  LibTable::$jrtt_ad_push_record);
    }

    public function getCountRecord(array $condition)
    {
        $where = '1 = 1 ';
        $parameter = [];
        if(isset($condition['batch_id']) && is_numeric($condition['batch_id'])) {
            $parameter['batch_id'] = $condition['batch_id'];
            $where .=  'AND `batch_id` = :batch_id ';
        }
        return $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$jrtt_ad_push_record . "` WHERE {$where}", $parameter);
    }

    public function getAdRecordList($condition, $page, $limit = DEFAULT_ADMIN_PAGE_NUM)
    {
        $limit_sql = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit_sql = $conn->getLimit($page, $limit);
        }

        $param = [];
        $connection = 'WHERE 1';
        if (isset($condition['batch_id']) && is_numeric($condition['batch_id'])) {
            $connection .= " AND a.`batch_id` = :batch_id";
            $param['batch_id'] = $condition['batch_id'];
        }

        $sql = "SELECT * FROM " . LibTable::$jrtt_ad_push_record . " as a 
                LEFT JOIN ". LibTable::$channel_user_auth ." as b ON a.`user_id` = b.`user_id`
                {$connection} ORDER BY `id` {$limit_sql}";
        $sql_count = "SELECT COUNT(*) AS c FROM " . LibTable::$jrtt_ad_push_record . " as a {$connection}";
        $row = $this->getOne($sql_count, $param);
        if (!$row['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => (int)$row['c'],
        );
    }

    public function updateAdRecord($data, $condition)
    {
        return $this->update($data, $condition, LibTable::$jrtt_ad_push_record);
    }
}