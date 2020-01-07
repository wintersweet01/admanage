<?php

class ModAdMaterial extends Model
{

    public function __construct()
    {
        $this->conn = 'default';
    }

    public function getMediaAcc(int $channelId, int $gameId)
    {
        $sql = "SELECT a.*, b.company_name, c.account_id, (
                SELECT count(*) FROM ".LibTable::$ad_project."
                WHERE user_id = a.user_id AND channel_id = :channelId AND game_id = :gameId AND `status` = 0 AND type = 0 AND is_use = 0) AS count 
                FROM ".LibTable::$channel_user." AS a
                LEFT JOIN ".LibTable::$channel_company." AS b ON a.company_id = b.company_id 
                RIGHT JOIN ".LibTable::$channel_user_auth." AS c ON a.user_id = c.user_id
                WHERE a.channel_id = :channelId ";
        $parameter = ['channelId' => $channelId, 'gameId' => $gameId];
        return $this->query($sql, $parameter);
    }

    public function getDownload($ids)
    {
        $sql = "SELECT material_id, material_name, file FROM `" . LibTable::$ad_material . "` WHERE material_id IN(:material_id) ORDER BY `material_id`";
        return $this->query($sql, array('material_id' => $ids));
    }

    public function delAdMaterial(int $id)
    {
        return $this->query("DELETE FROM " . LibTable::$ad_material . " WHERE `material_id` = $id");
    }

    public function editAdMaterial(array $data, array $where)
    {
        return $this->update($data, $where, LibTable::$ad_material);
    }

    public function getAdmaterialById($id)
    {
        $sql = "SELECT * FROM " . LibTable::$ad_material . " WHERE `material_id`=:id";
        return $this->getOne($sql, ['id' => $id]);
    }

    public function getByIds(array $ids)
    {
        $condition = 'where 1 = 1 ';

        if(! empty($ids)) {
            $condition .= 'AND `material_id` in ('.implode(',' , $ids).') ';
        }
        return $this->query("SELECT * FROM `" . LibTable::$ad_material . "` {$condition} ");
    }

    public function getMaterialSize()
    {
        return $this->query("SELECT `material_wh` FROM " . LibTable::$ad_material . " GROUP BY `material_wh` ORDER BY `material_wh`");
    }

    public function insertMaterial($data)
    {
        return $this->insert($data, true, LibTable::$ad_material);
    }

    public function insertTag($data)
    {
        return $this->insertOrUpdate($data, $data, LibTable::$tag);
    }

    public function adMaterial($param, $pageSize = DEFAULT_ADMIN_PAGE_NUM)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($param['page'], $pageSize ?: DEFAULT_ADMIN_PAGE_NUM);

        $where = [];
        $condition = "";
        if ($param['material_id'] > 0) {
            $condition .= " AND material_id = :material_id";
            $where['material_id'] = $param['material_id'];
        }
        if ($param['sdate']) {
            $condition .= " AND make_date >= :sdate";
            $where['sdate'] = $param['sdate'];
        }
        if ($param['edate']) {
            $condition .= " AND make_date <= :edate";
            $where['edate'] = $param['edate'];
        }
        if ($param['upload_user']) {
            $condition .= " AND upload_user = :upload_user";
            $where['upload_user'] = $param['upload_user'];
        }
        if ($param['material_type']) {
            $condition .= " AND material_type = :material_type";
            $where['material_type'] = $param['material_type'];
        }
        if ($param['material_source']) {
            $param['material_source'] == -1 && $param['material_source'] = '';
            $condition .= " AND material_source = :material_source";
            $where['material_source'] = $param['material_source'];
        }
        if ($param['material_wh']) {
            $condition .= " AND material_wh = :material_wh";
            $where['material_wh'] = $param['material_wh'];
        }
        if ($param['material_name']) {
            $condition .= " AND material_name LIKE :material_name";
            $where['material_name'] = "%{$param['material_name']}%";
        }
        if ($param['material_tag']) {
            $condition .= " AND material_tag LIKE :material_tag";
            $where['material_tag'] = "%{$param['material_tag']}%";
        }

        $sql = "SELECT * FROM " . LibTable::$ad_material . " WHERE 1 {$condition} ORDER BY `material_id` DESC {$limit}";
        $sql_count = "SELECT COUNT(*) AS c FROM " . LibTable::$ad_material ." WHERE 1 {$condition}";
        $count = $this->getOne($sql_count, $where);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $where),
            'total' => $count
        );
    }

}