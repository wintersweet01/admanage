<?php


class ModCopywriting extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    /**
     * 删除文案
     * @param array $where
     * @return resource|string
     */
    public function deleteCopywriting(array $where)
    {
        return $this->delete($where,1, LibTable::$ad_copywriting);
    }

    /**
     * 通过id获取文案
     * @param int $id
     * @return array|bool|resource|string
     */
    public function getCopywritingById(int $id)
    {
        $sql = "SELECT * FROM " . LibTable::$ad_copywriting . " WHERE `id`=:id";
        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * 获取指定的文案
     * @param array $id
     * @return array|bool|resource|string
     */
    public function getCopywritingByIds(array $id, int $channel)
    {
        $condition = 'where 1 = 1 ';

        if(! empty($id)) {
            $condition .= 'AND `id` in ('.implode(',' ,$id).') ';
        }

        if(is_numeric($channel)) {
            $condition .= 'AND channel = '. $channel . ' ';
        }

        return $this->query("SELECT * FROM `" . LibTable::$ad_copywriting . "` {$condition} ");
    }


    /**
     * 更新文案
     * @param array $data
     * @param array $where
     * @return resource|string
     */
    public function updateCopywriting(array $data, array $where)
    {
        return $this->update($data, $where, LibTable::$ad_copywriting);
    }

    /**
     * 添加文案
     * @param array $data
     * @return resource|string
     */
    public function addCopywriting(array $data)
    {
        return $this->insert($data, true, LibTable::$ad_copywriting);
    }

    /**
     * 文案列表
     * @param array $data
     * @param int $pagSize
     * @return array
     */
    public function adCopywriting(array $data, int $pagSize = DEFAULT_ADMIN_PAGE_NUM)
    {
        $limit = '';
        if (isset($data['page'])) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($data['page'], $pagSize ? $pagSize : DEFAULT_ADMIN_PAGE_NUM);
        }

        $where = [];
        $condition = "WHERE 1";
        if (isset($data['keyword'])) {
            $condition .= " AND (`content` LIKE :keyword OR `tag` LIKE :keyword)";
            $where['keyword'] = "%" . $data['keyword'] . "%";
        }
        if (isset($data['channel'])) {
            $condition .= " AND `channel` = :channel";
            $where['channel'] = $data['channel'];
        }

        $count = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$ad_copywriting . "` {$condition}", $where);
        if (!$count['c']) return array();

        return array(
            'list' => $this->query("SELECT * FROM `" . LibTable::$ad_copywriting . "` {$condition} ORDER BY `id` DESC {$limit}", $where),
            'total' => $count,
        );
    }
}