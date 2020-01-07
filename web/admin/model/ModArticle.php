<?php

/**
 * Created by PhpStorm.
 * User: qinsh
 * Date: 2018/3/26 0026
 * Time: 15:18
 */
class ModArticle extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    /**
     * 获取文章列表
     * @param int $page
     * @param string $title
     * @param int $type
     * @param int $game_id
     * @return array
     */
    public function getArticleList($page = 1, $title = '', $type = 0, $game_id = 0)
    {
        if ($page) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $where = [];
        $condition = "WHERE 1";
        if ($type > 0) {
            $condition .= " AND `type` = :type";
            $where['type'] = $type;
        }
        if ($game_id > 0) {
            $condition .= " AND `game_id` = :game_id";
            $where['game_id'] = $game_id;
        }
        if ($title) {
            $condition .= " AND `title` LIKE :title";
            $where['title'] = "%{$title}%";
        }

        $count = $this->getOne("SELECT COUNT(*) AS c FROM `" . LibTable::$sy_article . "` {$condition}", $where);
        if (!$count['c']) return array();

        return array(
            'list' => $this->query("SELECT * FROM `" . LibTable::$sy_article . "` {$condition} ORDER BY `aid` DESC {$limit}", $where),
            'total' => $count,
        );
    }

    /**
     * 获取文章内容
     * @param $id
     * @return array|bool|resource|string
     */
    public function getArticleInfo($id)
    {
        $sql = "SELECT a.*, b.`content` FROM " . LibTable::$sy_article . " a LEFT JOIN " . LibTable::$sy_article_content . " b ON a.`aid` = b.`aid` WHERE a.`aid` = {$id}";
        return $this->getOne($sql);
    }

    /**
     * 添加文章
     * @param $data
     * @return bool
     */
    public function addArticle($data)
    {
        $content = $data['content'];
        unset($data['content']);

        //连接主数据库
        parent::__construct('main');

        //事务
        $this->startWork();
        $aid = $this->insert($data, true, LibTable::$sy_article);
        if (!$aid) {
            $this->rollBack();
            return false;
        }

        if (!$data['isjump']) {
            $ret = $this->insert(array('aid' => $aid, 'content' => $content), false, LibTable::$sy_article_content);
            if ($ret) {
                $this->commit();
                return $aid;
            } else {
                $this->rollBack();
                return false;
            }
        }

        $this->commit();
        return $aid;
    }

    /**
     * 更新文章
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateArticle($id, $data)
    {
        $content = $data['content'];
        unset($data['content']);

        $where = array('aid' => $id);

        //连接主数据库
        parent::__construct('main');

        //事务
        $this->startWork();
        $ret = $this->update($data, $where, LibTable::$sy_article);
        if (!$ret) {
            $this->rollBack();
            return false;
        }

        if (!$data['isjump'] && $content) {
            $ret = $this->update(array('content' => $content), $where, LibTable::$sy_article_content);
            if ($ret) {
                $this->commit();
                return true;
            } else {
                $this->rollBack();
                return false;
            }
        }

        $this->commit();
        return true;
    }

    public function articleDel($id)
    {
        //连接主数据库
        parent::__construct('main');
        $this->delete(array('aid' => $id), 1, LibTable::$sy_article);
        $this->delete(array('aid' => $id), 1, LibTable::$sy_article_content);
        return $this->affectedRows();
    }
}