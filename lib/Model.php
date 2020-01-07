<?php

class Model
{
    /**
     * @var mixed db对象
     */
    static $db;

    /**
     * @var mixed 指定当前数据库连接的库
     */
    protected $conn = 'default';

    /**
     * @var string 替换字段
     */
    protected $dbIndex = 0;

    /**
     * @var mixed 指定当前模型所使用的表
     */
    protected $table = '';

    /**
     * 添加初始化方法，以在简单增删改查情况下直接使用此类而不用再新建model类
     * @param string $conn DB的name
     * @param string $table 表名
     */
    public function __construct($conn = '', $table = '')
    {
        if ($conn) {
            $this->conn = $conn;
        }
        if ($table) {
            $this->table = $table;
        }

    }

    /**
     * 连接DB
     * @param string $name DB的name
     * @param int $dbIndex DB的序号，针对多库的情况
     * @return LibMysql
     */
    protected function connDb($name = null, $dbIndex = 0)
    {
        if (empty(self::$db)) {
            $libMysql = new LibMysql();
            self::$db = $libMysql;
        } else {
            $libMysql = self::$db;
        }

        $name = is_null($name) ? $this->conn : $name;
        $libMysql->useDb($name, $dbIndex);
        return $libMysql;
    }

    /**
     * 执行SQL，如果是select语句则返回数组，其他返回结果
     *
     * @param string $sql SQL
     * @param array $parameter 绑定变量
     * @return array|bool|resource|string
     */
    protected function query($sql, $parameter = array())
    {
        if (!$this->conn) {
            Debug::log('模型没有执行数据ID', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->query($sql, $parameter);
    }

    /**
     * 返回一条数据
     *
     * @param string $sql SQL
     * @param array $parameter 绑定变量
     * @return array|bool|resource|string
     */
    protected function getOne($sql, $parameter = array())
    {
        if (!$this->conn) {
            Debug::log('模型没有执行数据ID', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->getOne($sql, $parameter);
    }

    /**
     * 通用获取一条数据方法
     * @param $table
     * @param $field
     * @param $value
     * @return array|bool|resource|string
     */
    protected function commonGetOne($table, $field, $value = '')
    {
        if (!$this->conn) {
            Debug::log('模型没有执行数据ID', 'error');
            return false;
        }

        if (is_array($field)) {
            $sql = "select * from {$table} where 1 ";
            foreach ($field as $k => $v) {
                $sql .= " and `{$k}`=:{$k} ";
            }
            return $this->connDb($this->conn, $this->dbIndex)->getOne($sql, $field);
        } else {
            $sql = "select * from {$table} where `{$field}`=:value ";
            return $this->connDb($this->conn, $this->dbIndex)->getOne($sql, array('value' => $value));
        }
    }

    public function startWork()
    {
        if (!$this->conn) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->execute("START TRANSACTION; ");
    }

    public function rollBack()
    {
        if (!$this->conn) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->execute("rollback;");
    }

    public function commit()
    {
        if (!$this->conn) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->execute("commit;");
    }

    /**
     * 插入数据
     *
     * @param array $data 插入的数据 k-v
     * @param bool $returnId 是否返回ID
     * @param string $table 表名
     * @param array $option 配置
     * @return resource|string
     */
    public function insert($data, $returnId = false, $table = "", $option = [])
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        $re = $this->connDb($this->conn, $this->dbIndex)->insert($this->table, $data, $option);
        if ($returnId && $re) {
            return $this->connDb($this->conn, $this->dbIndex)->insertId();
        }
        return $re;
    }

    /**
     * 批量插入数据
     * @param $data
     * @param string $table
     * @param array $option
     * @return bool|resource|string
     */
    public function multiInsert($data, $table = "", $option = [])
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        $re = $this->connDb($this->conn, $this->dbIndex)->multiInsert($this->table, $data, $option);

        return $re;
    }

    /**
     * 插入或者更新数据
     *
     * @param array $insertData 插入的数据
     * @param array $updateData 更新的数据
     * @param string $table 表名
     * @return resource|string
     */
    public function insertOrUpdate($insertData, $updateData, $table = "")
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        $re = $this->connDb($this->conn, $this->dbIndex)->insertOrUpdate($this->table, $insertData, $updateData);
        return $re;
    }


    /**
     * 修改数据
     *
     * @param array $data 需要修改的数据 k-v
     * @param array|string $where where字句
     * @param string $table 表名
     * @return resource|string
     */
    public function update($data, $where, $table = "")
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->update($this->table, $data, $where);
    }

    public function affectedRows()
    {
        $re = $this->connDb($this->conn, $this->dbIndex)->affectedRows();
        return $re;
    }

    /**
     * 删除数据
     *
     * @param array|string $where where字句
     * @param int $limit 限制影响的条数
     * @param string $table 表名
     * @return resource|string
     */
    public function delete($where, $limit = 0, $table = "")
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->delete($this->table, $where, $limit);
    }

    /**
     * 根据ID返回数据
     *
     * @param int $id ID
     * @param string $field 字段
     * @param string $idName ID的字段名
     * @param string $table 表名
     * @return array
     */
    public function getById($id, $field = '*', $idName = 'id', $table = "")
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->getById($this->table, $id, $field, $idName);
    }

    public function findByAttribute($attri, $table = "")
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->getByAttributes($this->table, $attri, 1);
    }

    public function findAllByAttribute($attri, $limit = false, $page = false, $order = false, $table = "")
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }
        return $this->connDb($this->conn, $this->dbIndex)->getByAttributes($this->table, $attri, $limit, $page, $order);

    }

    public function getCount($attri, $table = "")
    {
        if ($table != "") $this->table = $table;
        if (!$this->conn || !$this->table) {
            Debug::log('模型没有执行数据ID或者需要操作的数据表', 'error');
            return false;
        }

        return $this->connDb($this->conn, $this->dbIndex)->getCount($this->table, $attri);
    }

    public function getError()
    {
        return $this->connDb($this->conn, $this->dbIndex)->getError();
    }
}