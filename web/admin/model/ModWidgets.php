<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/1/15
 * Time: 15:46
 */

class ModWidgets extends Model
{
    public function __construct()
    {
        $this->conn = 'default';
    }

    /**
     * 获取游戏列表
     * @param bool $auth 是否开启权限检查
     * @param int $page 分页
     * @return array
     */
    public function getGameList($auth = true, $page = 0)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        //权限
        $condition = '';
        if ($auth) {
            $condition = SrvAuth::getAuthSql('parent_id', 'game_id', false, false);
        }

        $count = 0;
        if ($limit) {
            $row = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$sy_game . "` WHERE 1 {$condition}");
            $count = (int)$row['c'];
        }

        $sql = "SELECT * FROM `" . LibTable::$sy_game . "` WHERE 1 {$condition} ORDER BY `game_id` DESC {$limit}";
        return array(
            'list' => $this->query($sql),
            'total' => $count,
        );
    }
}