<?php

class LibMemcache
{
    protected static $instance, $drive;

    public static function getInstance($name = 'default')
    {
        if (empty(self::$instance[$name])) {
            $config = include ROOT . '/' . CONF_DIR . '/memcache.php';
            if (empty($config[$name])) {
                Debug::log('memcache[' . $name . ']配置不存在', 'error');
                return false;
            }
            $_config = $config[$name];

            //优先使用Memcached扩展
            if (extension_loaded('memcached')) {
                $_instance = new Memcached();
                self::$drive = 'Memcached';
            } elseif (extension_loaded('memcache')) {
                $_instance = new Memcache();
                self::$drive = 'Memcache';
            }

            if (is_string($_config)) {
                $_config = array($_config);
            }
            foreach ($_config as $conf) {
                $conf = explode(':', $conf);
                if (empty($conf[1])) {
                    $conf[1] = 11211;
                }

                $_instance->addServer($conf[0], $conf[1]);
            }

            self::$instance[$name] = $_instance;
        } else {
            $_instance = self::$instance[$name];
        }
        return $_instance;
    }

    public static function set($key, $value, $time = 864000, $name = 'default')
    {
        if (!self::$instance[$name]) {
            self::getInstance($name);
        }
        $_instance = self::$instance[$name];
        if (self::$drive == 'Memcache') {
            $ret = $_instance->set(MC_PREFIX . $key, $value, MEMCACHE_COMPRESSED, $time);
        } else {
            $ret = $_instance->set(MC_PREFIX . $key, $value, $time);
        }
        return $ret;
    }

    public static function get($key, $name = 'default')
    {
        if (!self::$instance[$name]) {
            self::getInstance($name);
        }
        $_instance = self::$instance[$name];
        return $_instance->get(MC_PREFIX . $key);
    }

    public static function delete($key, $name = 'default')
    {
        if (!self::$instance[$name]) {
            self::getInstance($name);
        }
        $_instance = self::$instance[$name];
        return $_instance->delete(MC_PREFIX . $key);
    }
}