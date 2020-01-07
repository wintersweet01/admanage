<?php

class ModUnion extends Model
{
    public function __construct()
    {
        parent::__construct('union');
    }

    /**
     * 公用获取数据记录列表
     * @param int $page
     * @param string $table
     * @param string $sort
     * @param string $field
     * @return array
     */
    public function getDataList($page = 0, $table = '', $sort = '', $field = '*')
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $data = array();
        $row = $this->getOne("SELECT COUNT(*) AS c FROM `{$table}`");
        $count = (int)$row['c'];
        if ($count > 0) {
            $data = $this->query("SELECT {$field} FROM `{$table}` ORDER BY `{$sort}` DESC {$limit}");
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 公用获取数据信息
     * @param string $table
     * @param string $field
     * @param int $id
     * @return array|bool|resource|string
     */
    public function getDataInfo($table = '', $field = '', $id = 0)
    {
        return $this->commonGetOne($table, $field, $id);
    }

    /**
     * 公用更新记录
     * @param string $table
     * @param array $data
     * @param array $where
     * @return resource|string
     */
    public function updateData($table = '', $data = array(), $where = array())
    {
        if ($data['config'] && is_array($data['config'])) {
            $data['config'] = serialize($data['config']);
        }
        return $this->update($data, $where, $table);
    }

    /**
     * 公用添加记录
     * @param string $table
     * @param array $data
     * @param bool $ret
     * @return resource|string
     */
    public function addData($table = '', $data = array(), $ret = true)
    {
        if ($data['config'] && is_array($data['config'])) {
            $data['config'] = serialize($data['config']);
        }
        return $this->insert($data, $ret, $table);
    }

    /**
     * 获取所有游戏
     * @return array|bool|resource|string
     */
    public function getAllGame()
    {
        return $this->query("SELECT * FROM `" . LibTable::$union_game . "` ORDER BY `game_id` DESC");
    }

    /**
     * 获取所有平台
     * @return array|bool|resource|string
     */
    public function getAllPlatform()
    {
        return $this->query("SELECT * FROM `" . LibTable::$union_platform . "` ORDER BY `platform_id` DESC");
    }

    /**
     * 获取平台和游戏关系数据
     * @param int $page
     * @param int $game_id
     * @param int $platform_id
     * @return array
     */
    public function getPlatformGameList($page = 0, $game_id = 0, $platform_id = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $condition = '';
        $param = array();
        if ($game_id > 0) {
            if (is_array($game_id)) {
                $condition .= " AND a.`game_id` IN(" . implode(',', $game_id) . ")";
            } else {
                $condition .= " AND a.`game_id` = :game_id";
                $param['game_id'] = $game_id;
            }
        }
        if ($platform_id > 0) {
            if (is_array($platform_id)) {
                $condition .= " AND a.`platform_id` IN(" . implode(',', $platform_id) . ")";
            } else {
                $condition .= " AND a.`platform_id` = :platform_id";
                $param['platform_id'] = $platform_id;
            }
        }

        $data = array();
        $row = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$union_platform_game . "` a WHERE 1 {$condition}", $param);
        $count = (int)$row['c'];
        if ($count > 0) {
            $sql = "SELECT a.*, b.`parent_id`, b.`name` AS game_name, b.`alias` AS game_alias, b.`type`, b.`map_gid` AS game_map_gid, 
                        b.`inherit`, b.`ratio`, b.`unit`, b.`lock` AS game_lock, b.`is_login` AS ganme_is_login, b.`is_pay` AS game_is_pay, 
                        b.`config` AS game_config, c.`name` AS platform_name, c.`alias` AS platform_alias, c.`lock` AS platform_lock, 
                        c.`is_login` AS platform_is_login, c.`is_pay` AS platform_is_pay, c.`config` AS platform_config 
                    FROM `" . LibTable::$union_platform_game . "` a 
                        LEFT JOIN `" . LibTable::$union_game . "` b ON a.game_id = b.game_id 
                        LEFT JOIN `" . LibTable::$union_platform . "` c ON a.platform_id = c.platform_id 
                    WHERE 1 {$condition} ORDER BY a.`game_id` DESC, a.`platform_id` DESC {$limit}";
            $data = $this->query($sql, $param);
        }

        return array(
            'list' => $data,
            'total' => $count,
        );
    }

    /**
     * 获取平台对应游戏信息
     * @param int $platform_id
     * @param int $game_id
     * @return array|bool|resource|string
     */
    public function getPlatformGameInfo($platform_id = 0, $game_id = 0)
    {
        $sql = "SELECT a.*, b.`parent_id`, b.`name` AS game_name, b.`alias` AS game_alias, b.`type`, b.`map_gid` AS game_map_gid, 
                    b.`inherit`, b.`ratio`, b.`unit`, b.`lock` AS game_lock, b.`is_login` AS ganme_is_login, b.`is_pay` AS game_is_pay, 
                    b.`config` AS game_config, c.`name` AS platform_name, c.`alias` AS platform_alias, c.`lock` AS platform_lock, 
                    c.`is_login` AS platform_is_login, c.`is_pay` AS platform_is_pay, c.`config` AS platform_config 
                FROM `" . LibTable::$union_platform_game . "` a 
                    LEFT JOIN `" . LibTable::$union_game . "` b ON a.game_id = b.game_id 
                    LEFT JOIN `" . LibTable::$union_platform . "` c ON a.platform_id = c.platform_id 
                WHERE a.`game_id` = :game_id AND a.`platform_id` = :platform_id";
        return $this->getOne($sql, array('game_id' => $game_id, 'platform_id' => $platform_id));
    }
}