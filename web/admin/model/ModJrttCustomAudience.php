<?php
/**
 * 今日头条自定义人群包模型
 * Class ModJrttCustomAudience
 * @author dyh
 * @version 2020/01/11
 */

class ModJrttCustomAudience extends Model
{

    /**
     * ModJrttCustomAudience constructor.
     */
    public function __construct()
    {
        parent::__construct('default');
    }

    public function insertAudience(array $data)
    {
        return $this->insert($data, true, LibTable::$jrtt_custom_audience);
    }

    public function getAudienceList(array $condition, $page = 1, $limit = DEFAULT_ADMIN_PAGE_NUM)
    {
        $limit_sql = '';
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit_sql = $conn->getLimit($page, $limit);
        }

        $param = [];
        $connection = 'WHERE 1';
        if (isset($condition['status']) && is_numeric($condition['status'])) {
            $connection .= " AND a.`status` = :status";
            $param['status'] = $condition['status'];
        }

        $sql = "SELECT a.`id`, a.data_source_id, b.* FROM " . LibTable::$jrtt_custom_audience . " AS a 
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

    public function updateCustomAudience(int $id, array $update_data)
    {
        return $this->update($update_data, $id, LibTable::$jrtt_custom_audience);
    }

}