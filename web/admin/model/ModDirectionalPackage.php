<?php


class ModDirectionalPackage extends Model
{
    public function __construct()
    {
        $this->conn = 'default';
    }

    public function addPackage(array $param)
    {
        return $this->insert($param, true, LibTable::$directional_package);
    }

    /**
     * 获取定向包列表
     * @param $page
     * @return array
     */
    public function getDirectionalPackage($page)
    {
        $limit = $page ? $this->connDb($this->conn)->getLimit($page, DEFAULT_ADMIN_PAGE_NUM) : '';

        $sql = "select * from `" . LibTable::$directional_package . "` {$limit}";
        $count = $this->getOne("select count(*) as c from `" . LibTable::$directional_package . "`");

        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count['c'],
        );
    }

    /**
     * 根据id获取定向包
     * @param int $id
     * @return array|bool|resource|string
     */
    public function getPackageById(int $id)
    {
        $sql = "SELECT * FROM " . LibTable::$directional_package . " WHERE `id`=:id";
        return $this->getOne($sql, ['id' => $id]);
    }

}