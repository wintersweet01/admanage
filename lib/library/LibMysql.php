<?php


class LibMysql
{
    /**
     * @var string 当前执行的SQL语句
     */
    public $sql;

    /**
     * @var string 当前使用数据库ID
     */
    private $name = '';
    /**
     * @var string 数据库的index
     */
    private $dbIndex = 0;
    /**
     * @var array 所有的数据库连接
     */
    private $links = array();
    /**
     * @var string 当前使用的数据库连接
     */
    private $link = '';
    /**
     * @var array 数据库配置
     */
    private $dbConf = array();
    /**
     * @var string 当前返回的资源
     */
    private $resource = '';

    /**
     * @var bool 是否使用mysqli
     */

    private $useMysqli = true;

    /**
     * @param string $db 指定数据库ID
     */
    public function __construct($db = '')
    {
        $this->useDb($db);
    }

    /**
     * 选择数据库ID
     *
     * @param string $name 数据库ID
     * @param int $dbIndex 数据库index
     */
    public function useDb($name, $dbIndex = 0)
    {
        $this->name = $name;
        $this->dbIndex = $dbIndex;
    }

    /**
     * 执行sql返回资源或者处理结果
     *
     * @param string $sql 执行的sql
     * @param array $parameter sql内的数据
     * @param bool $force 强制重连
     * @return resource|string
     */
    public function execute($sql, $parameter = array(), $force = false)
    {
        if (Debug::check()) {
            $sTime = microtime(true);
        }

        $this->resource = '';
        $this->link = '';
        if (!$this->name) {
            Debug::log('还没有选择数据库', 'error');
            return false;
        }
        $confFile = ROOT . '/' . CONF_DIR . '/db.php';
        if (empty($this->dbConf)) {
            $this->dbConf = include $confFile;
        }
        if (empty($this->dbConf) || empty($this->dbConf[$this->name])) {
            Debug::log('数据库[' . $this->name . ']的配置不存在，请在' . $confFile . '配置', 'error');
            return false;
        }

        $dbConf = $this->dbConf[$this->name];
        if (empty($dbConf['db']) || !is_array($dbConf['server'])) {
            Debug::log('数据库配置不正确：' . var_export($dbConf, true), 'error');
            return false;
        }

        if (empty($dbConf['server'][0]) || !is_array($dbConf['server'][0])) {
            $dbConf['server'] = array(0 => $dbConf['server']);
        }

        $sql = trim($sql);
        $isMaster = false;
        $serverStr = 'S';
        if (strtolower(substr($sql, 0, 1)) !== 's' || count($dbConf['server']) == 1) {
            $isMaster = true;
            $serverStr = 'M';
        }
        if ($force || empty($this->links[$this->name]) || (!is_resource($this->links[$this->name][$serverStr]) && !is_object($this->links[$this->name][$serverStr]))) {
            if ($isMaster) {
                $serverConf = $dbConf['server'][0];
            } else {
                array_shift($serverConf);
                $serverConf = $serverConf[array_rand($serverConf)];
            }
            if (empty($serverConf['host'])) {
                $serverConf['host'] = '127.0.0.1';
            }
            if (empty($serverConf['user'])) {
                $serverConf['user'] = '';
            }
            if (empty($serverConf['password'])) {
                $serverConf['password'] = '';
            }

            if (!$this->useMysqli) {
                $link = mysql_connect($serverConf['host'], $serverConf['user'], $serverConf['password'], $force);
            } else {
                $link = mysqli_connect($serverConf['host'], $serverConf['user'], $serverConf['password']);
            }


            if (!$link) {
                Debug::log('连数据库失败：' . $this->getMysqlError(), 'error');
                Debug::log($serverConf, 'error');
                return false;
            }
            $this->links[$this->name][$serverStr] = $link;
        }
        $link = $this->links[$this->name][$serverStr];

        //兼容多库的情况
        if (strpos($dbConf['db'], '{index}') !== false) {
            $dbConf['db'] = str_replace('{index}', $this->dbIndex, $dbConf['db']);
        }
        if (!$this->useMysqli) {
            $re = mysql_select_db($dbConf['db'], $link);
        } else {
            $re = mysqli_select_db($link, $dbConf['db']);
        }
        $this->link = $link;

        if (!$re) {
            $error = strtolower($this->getMysqlError());
            Debug::log('---------<><><>' . $error);
            if (strpos($error, 'mysql server has gone away') !== false || strpos($error, 'malformed packet') !== false) {
                sleep(1);
                return $this->execute($sql, $parameter, true);
            }
            Debug::log('无法使用数据库[' . $dbConf['db'] . ']：' . $error, 'error');
            return false;
        }
        //拿到真正的sql
        $sql = $this->bindParameter($sql, $parameter);
        //LibUtil::pr($sql);
        if (!$this->useMysqli) {
            mysql_set_charset('utf8', $link);
            $result = mysql_query($sql, $link);
        } else {
            mysqli_set_charset($link, 'utf8');
            $result = mysqli_query($link, $sql);
        }

        $sqlType = $this->getSqlType($sql);
        $isError = false;
        if (in_array($sqlType, array('select', 'show', 'explain', 'describe'))) {
            if (!is_resource($result) && !is_object($result)) {
                $isError = true;
            }
        } else {
            if (!$result) {
                $isError = true;
            }
        }

        $this->resource = $result;
        $this->sql = $sql;

        if ($isError) {
            Debug::log("SQL: {$sql}(error：" . $this->getMysqlError() . ")", 'error');
            return false;
        }

        //不记录定时任务的SQL
        if (Debug::check() && strpos($this->sql, 'data_') === false) {
            //$eTime = microtime(true);
            //$t = round($eTime - $sTime, 3);
            //Debug::log("SQL: {$this->sql}(OK:{$t})", 'info');
        }

        return $this->resource;
    }

    /**
     * 从资源中获取一行数据
     *
     * @param resource $result 提交查询后获得的资源，如果不传表示使用最近一次查询返回的资源
     * @return array|bool
     */
    public function fetch($result = null)
    {
        if (is_null($result)) {
            $result = $this->resource;
        }
        if (!is_resource($result) && !is_object($result)) {
            return false;
        }
        if (!$this->useMysqli) {
            return mysql_fetch_array($result, MYSQL_ASSOC);
        } else {
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }

    }

    /**
     * 执行查询，如果是select语句则返回数组，请用在sql中使用:xx代替直接赋值，将参数通过k-v数组传入
     *
     * @param string $sql SQL
     * @param array $parameter 参数
     * @return array|resource|string
     */
    public function query($sql, $parameter = array())
    {
        $sql = trim($sql);
        if ($this->getSqlType($sql) == 'select') {
            $result = $this->execute($sql, $parameter);
            $rows = array();
            while ($row = $this->fetch($result)) {
                $rows[] = $row;
            }
            if (is_resource($result) || is_object($result)) {
                if (!$this->useMysqli) {
                    mysql_free_result($result);
                } else {
                    mysqli_free_result($result);
                }
            }
            return $rows;
        } else {
            return $this->execute($sql, $parameter);
        }
    }

    /**
     * 返回分页limit
     *
     * @param int $page 分数
     * @param int $num 每页数量
     * @return string
     */
    public function getLimit($page = 1, $num = 1)
    {
        $page = intval($page);
        if ($page < 1) $page = 1;
        $num = intval($num);
        if ($num < 1) {
            $num = 10;
        }
        $offset = ($page - 1) * $num;
        $limit = " limit {$offset}, {$num}";
        return $limit;
    }

    /**
     * 获得其中一条数据
     * @param string $sql SQL语句
     * @param array $parameter 变量
     * @return array|bool|resource|string
     */
    public function getOne($sql, $parameter = array())
    {
        $sql = trim($sql);
        if ($this->getSqlType($sql) == 'select') {
            if (strpos($sql, 'limit') === false) {
                $sql .= ' limit 1';
            } else {
                $sql = preg_replace('/\s+limit\s+\d+,\d+/i', ' limit 1', $sql);
            }

            $result = $this->execute($sql, $parameter);

            $row = $this->fetch($result);
            if (is_resource($result) || is_object($result)) {
                if (!$this->useMysqli) {
                    mysql_free_result($result);
                } else {
                    mysqli_free_result($result);
                }

            }

            return !empty($row) ? $row : array();
        } else {
            return $this->execute($sql, $parameter);
        }
    }

    /**
     * 插入数据
     *
     * @param string $table 当前操作的表
     * @param array $data 需要插入的数据
     * @param array $option 配置
     * @return resource|string
     */
    public function insert($table, $data, $option = [])
    {
        if (empty($data) || empty($table)) {
            return false;
        }

        $fields = array();
        $values = array();
        $parameter = array();
        $i = 0;
        foreach ($data as $field => $value) {
            $fields[] = $this->getPoint($field);
            $parameter['v' . $i] = $value;
            $values[] = ':v' . $i;
            $i++;
        }

        $table = $this->getPoint($table);
        $sql = "INSERT INTO ";
        if ($option['replace']) {
            $sql = "REPLACE INTO ";
        }
        $sql .= "{$table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
        return $this->execute($sql, $parameter);
    }

    /**
     * 批量插入数据
     * @param $table
     * @param $data
     * @param array $option
     * @return bool|resource|string
     */
    public function multiInsert($table, $data, $option = [])
    {
        if (empty($data) || empty($table)) {
            return false;
        }

        $fieldsP = array();
        $ins_val = array();
        $parameter = array();
        $i = 0;

        $fields = array_keys($data[0]);
        foreach ($fields as $key) {
            $fieldsP[] = $this->getPoint($key);
        }

        foreach ($data as $value) {
            $tmp = "(";
            foreach ($fields as $val) {
                $parameter['v' . $i] = $value[$val];
                $tmp .= ":v" . $i . ",";
                $i++;
            }

            $tmp = rtrim($tmp, ',');
            $tmp .= ")";

            $ins_val[] = $tmp;

        }

        $table = $this->getPoint($table);
        $sql = "INSERT INTO ";
        if ($option['replace']) {
            $sql = "REPLACE INTO ";
        }
        $sql .= "{$table} (" . implode(', ', $fieldsP) . ") values " . implode(',', $ins_val);

        return $this->execute($sql, $parameter);
    }

    /**
     * 更新数据
     *
     * @param string $table 表
     * @param array $data 需要修改的数据
     * @param array|string $where where条件
     * @param int $limit 限制条数 0为不限制
     * @return resource|string
     */
    public function update($table, $data, $where, $limit = 0)
    {
        if (empty($data) || empty($table)) {
            return false;
        }

        $parameter = array();

        if (is_numeric($where)) {
            $parameter['where'] = $where;
            $where = "id=:where";
        } elseif (is_array($where)) {

            $_w = array();
            $i = 0;
            foreach ($where as $name => $value) {
                if (is_array($value)) {
                    $_w[] = $this->getPoint($name) . " in (:w{$i})";
                    $parameter['w' . $i] = $value;
                } else {
                    $_w[] = $this->getPoint($name) . " = :w{$i}";
                    $parameter['w' . $i] = $value;
                }
                $i++;
            }
            $where = implode(' and ', $_w);
        }

        $table = $this->getPoint($table);
        $sql = 'update ' . $table . ' set ';
        $fields = array();
        $i = 0;
        foreach ($data as $field => $value) {
            $field = $this->getPoint($field);
            if (is_array($value)) {
                $fields[] = "{$field}={$field} {$value[0]} {$value[1]}";
            } else {
                $fields[] = "{$field}=:v{$i}";
                $parameter['v' . $i] = $value;
            }
            $i++;
        }
        $sql .= implode(', ', $fields) . " where {$where}";
        $limit = (int)$limit;
        if ($limit && $limit > 0 && is_int($limit)) {
            $sql .= ' limit ' . $limit;
        }
        return $this->execute($sql, $parameter);
    }

    /**
     * 如果存在则更新，不存在则插入（必须存在一个唯一主键）
     *
     * @param string $table 数据表
     * @param array $insertData 插入的数据
     * @param array $updateData 更新的数据，当value为bool true时，以字段为值
     * @return resource|string
     */
    public function insertOrUpdate($table, $insertData, $updateData)
    {
        if (empty($table) || empty($insertData) || empty($updateData)) {
            return false;
        }
        $fields = array();
        $values = array();
        $parameter = array();

        $i = 0;
        foreach ($insertData as $field => $value) {
            $fields[] = $this->getPoint($field);
            $values[] = ":i{$i}";
            $parameter['i' . $i] = $value;
            $i++;
        }
        $fields2 = array();
        $i = 0;
        foreach ($updateData as $field => $value) {
            $field = $this->getPoint($field);
            if ($value === true) {
                $fields2[] = "{$field}={$field}";
            } else {
                if (is_array($value)) {
                    $fields2[] = "{$field}={$field} {$value[0]} {$value[1]}";
                } else {
                    $fields2[] = "{$field}=:u{$i}";
                    $parameter['u' . $i] = $value;
                }
                $i++;
            }
        }

        $table = $this->getPoint($table);
        $sql = "insert into {$table} (" . implode(', ', $fields) . ") values (" . implode(', ', $values) . ") on duplicate key update " . implode(', ', $fields2);
        return $this->execute($sql, $parameter);
    }

    /**
     * 删除数据
     *
     * @param string $table 数据表
     * @param array|string $where 条件
     * @param int $limit 限制操作的条数
     * @return resource|string
     */
    public function delete($table, $where, $limit = 0)
    {
        if (empty($table) || empty($where)) {
            return false;
        }

        $parameter = array();
        if (is_numeric($where)) {
            $parameter['where'] = $where;
            $where = "id=:where";
        } elseif (is_array($where)) {
            $_w = array();
            $i = 0;
            foreach ($where as $name => $value) {
                if (is_array($value)) {
                    $_w[] = $this->getPoint($name) . " in (:w{$i})";
                    $parameter['w' . $i] = $value;
                } else {
                    $_w[] = $this->getPoint($name) . " = :w{$i}";
                    $parameter['w' . $i] = $value;
                }
                $i++;
            }
            $where = implode(' and ', $_w);
        }

        $table = $this->getPoint($table);
        $sql = "delete from {$table} where {$where}";

        $limit = (int)$limit;
        if ($limit) {
            $sql .= ' limit ' . $limit;
        }
        return $this->execute($sql, $parameter);
    }

    /**
     * 根据ID返回数据
     *
     * @param string $table 数据表
     * @param int $id ID
     * @param string $field 需要查询的字段。默认返回全部
     * @param string $idName
     * @return array|bool|resource|string
     */
    public function getById($table, $id, $field = '*', $idName = 'id')
    {
        $idName = $this->getPoint($idName);
        $sql = "select {$field} from {$table} where {$idName} = :id limit 1";
        $parameter['id'] = $id;
        return $this->getOne($sql, $parameter);
    }

    public function getCount($table, $params = array())
    {

        if (!is_array($params)) {
            Debug::log('Attributes应该为一维数组', 'error');
            return false;
        }

        $where = '';
        $parameter = array();

        if (!empty($params)) {
            $_w = array();
            $i = 0;

            foreach ($params as $name => $value) {
                if (is_array($value)) {
                    $_w[] = $this->getPoint($name) . " in (:w{$i})";
                    $parameter['w' . $i] = $value;
                } else {
                    $_w[] = $this->getPoint($name) . " = :w{$i}";
                    $parameter['w' . $i] = $value;
                }
                $i++;
            }

            $where = 'where' . implode(' and ', $_w);
        }

        $table = $this->getPoint($table);

        $sql = "select count(*) num from {$table} " . $where;
        $res = $this->getOne($sql, $parameter);

        return $res['num'];

    }


    /**
     * 返回最近插入的数据的id
     *
     * @return int
     */
    public function insertId()
    {
        if (is_resource($this->link) || is_object($this->link)) {
            if (!$this->useMysqli) {
                return mysql_insert_id($this->link);
            } else {
                return mysqli_insert_id($this->link);
            }

        } else {
            return false;
        }
    }

    /**
     * 返回影响的条数
     *
     * @return int
     */
    public function affectedRows()
    {
        if (is_resource($this->link) || is_object($this->link)) {
            if (!$this->useMysqli) {
                return mysql_affected_rows($this->link);
            } else {
                return mysqli_affected_rows($this->link);
            }

        } else {
            return false;
        }
    }

    public function getError()
    {
        return $this->getMysqlError();
    }

    /**
     * 获得SQL的类型
     *
     * @param string $sql 字符串
     * @return array|string
     */
    private function getSqlType($sql)
    {
        $sql = str_replace("\n", ' ', $sql);
        $sqlType = explode(' ', $sql);
        $sqlType = strtolower(trim($sqlType[0]));
        return $sqlType;
    }

    /**
     * 给字段或者表打上`
     *
     * @param string $field 字段
     * @return string
     */
    private function getPoint($field)
    {
        $field = str_replace("'", '', $field);
        if (strpos($field, '.')) {
            $fieldArr = explode('.', $field);
            if (count($fieldArr) == 2) {
                $table = $this->getPoint($fieldArr[0]);
                $field = $this->getPoint($fieldArr[1]);
                return $table . '.' . $field;
            }
        }
        if (strpos($field, '`') === false) {
            return "`{$field}`";
        } else {
            return $field;
        }
    }

    /**
     * @param $sql
     * @param $parameter
     * @return mixed
     */
    private function bindParameter($sql, $parameter)
    {
        // 注意替换结果尾部加一个空格
        $sql = preg_replace("/:([a-zA-Z0-9_\-\x7f-\xff][a-zA-Z0-9_\-\x7f-\xff]*)\s*([,\)]?)/", "\x01\x02\x03\\1\x01\x02\x03\\2 ", $sql);
        $find = array();
        $replacement = array();
        foreach ($parameter as $key => $value) {
            $find[] = "\x01\x02\x03$key\x01\x02\x03";

            if (is_array($value)) {
                foreach ($value as &$v) {
                    if (is_resource($this->link) || is_object($this->link)) {
                        $v = "'" . $this->escapeString($v, $this->link) . "'";
                    } else {
                        $v = "'" . $this->escapeString($v) . "'";
                    }
                }
                unset($v);

                $replacement[] = implode(',', $value);
            } else {
                if (is_resource($this->link) || is_object($this->link)) {
                    $replacement[] = "'" . $this->escapeString($value, $this->link) . "'";
                } else {
                    $replacement[] = "'" . $this->escapeString($value) . "'";
                }
            }
        }

        $sql = str_replace($find, $replacement, $sql);
        return $sql;
    }

    private function getMysqlError()
    {
        if (!$this->useMysqli) {
            return mysql_error();
        } else {
            return mysqli_error($this->link);
        }
    }

    private function escapeString($value, $link = '')
    {
        if (!is_resource($link) && !is_object($link)) {
            if (!$this->useMysqli) {
                return mysql_real_escape_string($value);
            } else {
                return mysqli_real_escape_string($link, $value);
            }
        } else {
            if (!$this->useMysqli) {
                return mysql_real_escape_string($value, $link);
            } else {
                return mysqli_real_escape_string($link, $value);
            }
        }
    }
}