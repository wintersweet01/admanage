<?php

class LibRedis
{

    private static $redis, $cacheNamespace = 'REDIS_SDK:';
    public static $prefix_sdk_update = 'CACHE_UPDATE_'; //SDK初始化信息缓存
    public static $prefix_sdk_user = 'CACHE_USER_'; //用户信息缓存前缀
    public static $prefix_sdk_channel_token = 'CACHE_CHANNEL_TOKEN_'; //渠道（广点通）授权信息（access_token）
    public static $prefix_sdk_channel_uid = 'CACHE_CHANNEL_UID_'; //渠道（广点通）授权信息（user_action_set_id）
    public static $prefix_config = 'CACHE_CONFIG'; //系统配置信息
    public static $prefix_forbidden_ip = 'CACHE_FORBIDDEN_IP_'; //封禁IP前缀
    public static $prefix_forbidden_device = 'CACHE_FORBIDDEN_DEVICE_'; //封禁设备号前缀
    public static $prefix_spam = 'CACHE_SPAM_'; //注册登录垃圾自动化记录前缀
    public static $prefix_union = 'CACHE_UNION_'; //联运分发平台对应游戏信息列表
    public static $prefix_monitor_code = 'MONITOR_CODE_'; //落地页链接缓存
    public static $prefix_package_name = 'PACKAGE_NAME_'; //游戏包信息

    public static function getInstance($name = 'default')
    {
        if (self::$redis) {
            return self::$redis;
        }

        if (!extension_loaded('redis')) {
            return false;
        }

        $config = include ROOT . '/' . CONF_DIR . '/redis.php';
        $conf = $config[$name];

        self::$redis = new Redis();
        self::$redis->connect($conf['host'], $conf['port']);
        if ($conf['auth']) {
            self::$redis->auth($conf['auth']);
        }

        $opt_serializer = Redis::SERIALIZER_PHP;
        if (PHP_OS == 'Linux' && extension_loaded('igbinary')) {
            $opt_serializer = Redis::SERIALIZER_IGBINARY;
        }

        self::$redis->setOption(Redis::OPT_PREFIX, self::$cacheNamespace);
        self::$redis->setOption(Redis::OPT_SERIALIZER, $opt_serializer);
        return self::$redis;
    }

    /**
     * 写入redis缓存
     * @param $key
     * @param $value
     * @param int $expire
     * @return bool
     */
    public static function set($key, $value, $expire = 0)
    {
        if (!$key) {
            return false;
        }

        self::getInstance();
        $result = self::$redis->set($key, $value);
        if ($expire > 0) {
            self::$redis->expire($key, $expire);
        }
        return $result;
    }

    /**
     * 读取redis缓存
     * @param $key
     * @return bool|mixed
     */
    static public function get($key)
    {
        if (!$key) {
            return false;
        }
        self::getInstance();
        return self::$redis->get($key);
    }

    /**
     * 删除redis缓存
     * @param $key
     * @return bool
     */
    static public function delete($key)
    {
        if (!$key) {
            return false;
        }
        self::getInstance();
        return self::$redis->delete($key);
    }

    /**
     * redis集合操作
     * @param $key
     * @param $value
     * @return int/boolean
     */
    static public function sadd($key, $value)
    {
        if (!$key) {
            return false;
        }
        self::getInstance();
        if (is_array($value)) {
            $num = 0;
            foreach ($value as $val) {
                $ret = self::$redis->sAdd($key, $val);
                if ($ret) $num++;
            }
        } else {
            return self::$redis->sAdd($key, $value);
        }
        return $num;
    }

    /**
     * redis返回集合中的成员信息
     * @param $key
     * @return array
     */
    static public function smembers($key)
    {
        if (!$key) {
            return array();
        }
        self::getInstance();
        return self::$redis->sMembers($key);
    }

    /**
     * 获取键所存储的值的类型
     * @param $key
     * @return string
     */
    static public function type($key)
    {
        if (!$key) {
            return false;
        }
        self::getInstance();
        return self::$redis->type($key);
    }

    /**
     * redis hash 获取key下所有数据
     * @param $key
     * @return array
     */
    static public function hgetall($key)
    {
        if (!$key) {
            return array();
        }
        self::getInstance();
        return self::$redis->hGetAll($key);
    }

    /**
     * redis hash 批量设置hash
     * @param $key
     * @param array $data
     * @return boolean
     */
    static public function hmset($key, $data)
    {
        if (!$key || !is_array($data)) {
            return false;
        }
        self::getInstance();
        return self::hMSet($key, $data);
    }

}