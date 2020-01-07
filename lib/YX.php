<?php
header("Content-Type:text/html; charset=utf-8");
//error_reporting(0);

if (!defined('CT')) {
    /**
     * 定义控制器传参的name，默认是ct，如http://www.xxx.com/?ct=user
     */
    define('CT', 'ct');
}

if (!defined('AC')) {
    /**
     * 定义控制器方法传参的name，默认是ac，如http://www.xxx.com/?ct=user&ac=login
     */
    define('AC', 'ac');
}

/**
 * 项目所在的目录
 */
define('ROOT', str_replace("\\", "/", realpath(__DIR__ . '/../')));

/*
 * 运行时产生的配置文件、缓存等文件
 */
define('RUNTIME_DIR', ROOT . '/runtime');

/**
 * lib目录
 */
define('LIB', ROOT . '/lib');

/**
 * 控制器的目录
 */
define('CLT_DIR', 'controller');

/**
 * service层目录
 */
define('SRV_DIR', 'service');

/**
 * 模型的目录
 */
define('MOD_DIR', 'model');

/**
 * 模板目录
 */
define('TPL_DIR', 'template');

/**
 * 缓存目录
 */
define('CACHE_DIR', 'cache');

/**
 * 配置文件目录
 */
define('CONF_DIR', 'config');

//定义时区
if (defined('TIME_ZONE')) {
    date_default_timezone_set(TIME_ZONE);
} else {
    date_default_timezone_set('Asia/Shanghai');
}

/**
 * 核心类
 */
class YX
{
    /**
     * @var string 控制器
     */
    public static $ct = '';

    /**
     * @var string 控制器方法
     */
    public static $ac = '';

    /**
     * @var string include路径列表
     */
    public static $includePaths = array();


    /*
     * 当前app
     */
    public static $thisAppRoot = '';

    /**
     * 初始化入口
     */
    public static function init()
    {
        if (!empty($_SERVER['argv'][1]) && PHP_SAPI == 'cli') {
            parse_str($_SERVER['argv'][1], $_GET);
        }

        //加载通用配置
        require ROOT . '/config/global.php';

        //加载器
        spl_autoload_register('YX::loader');

        //设置语言
        Lang::setLanguage();

        if (Debug::check()) {//开启调试模式
            Debug::start();
            set_error_handler(array(new Debug(), 'error'));
            register_shutdown_function(array(new Debug(), 'shutdown'));
        }

        //PHP结束后执行
        if (method_exists('LibUtil', 'shutdown_function')) {
            register_shutdown_function(array('LibUtil', 'shutdown_function'), null, array(), true);
        }
    }

    public static function run()
    {
        $ct = empty($ct) ? (empty($_GET[CT]) ? 'index' : $_GET[CT]) : $ct;
        $ac = empty($ac) ? (empty($_GET[AC]) ? 'index' : $_GET[AC]) : $ac;

        self::$ct = $ct;
        self::$ac = $ac;


        self::route($ct, $ac);
    }

    /**
     * 根据url找到准确的控制器
     *
     * @param string $ct 控制器
     * @param string $ac 控制器方法
     */
    private static function route($ct = 'index', $ac = 'index')
    {
        if (!preg_match("/^[a-z]+[a-z_0-9]+$/i", $ct)) {
            Debug::log('用户输入非法的ct：' . $ct, 'warn');
            $ct = 'index';
        }
        if (!preg_match("/^[a-z]+[a-z_0-9]+$/i", $ac)) {
            Debug::log('用户输入非法的ac：' . $ac, 'warn');
            $ac = 'index';
        }

        $controller = 'Ctl' . ucfirst($ct);
        $action = $ac;
        $controllerObj = new $controller;
        //判断控制器的方法是否存在
        if (!is_object($controllerObj)) {
            Debug::log("控制器{$controller}无法自动加载", 'error');
            self::send404();
            return;
        }

        //判断控制器的方法是否存在
        if (!method_exists($controllerObj, $action)) {
            Debug::log("控制器{$controller}不存在方法：" . $action, 'error');
            self::send404();
            return;
        }

        $controllerObj->$action();
        $controllerObj->display();
    }

    /**
     * 自动加载类
     *
     * @param $className string 当前调用的类名
     */
    public static function loader($className)
    {
        if (class_exists($className)) {
            return;
        }
        //如果是smarty，让它自身的autoloader工作
        if (strpos($className, 'Smarty_') === 0 || strpos($className, 'SmartyException') === 0 || strpos($className, 'SmartyCompilerException') === 0) {
            return;
        }

        $appRoot = APP_ROOT;
        if (YX::$thisAppRoot) {
            $appRoot = YX::$thisAppRoot;
        }

        $file = '';
        if (in_array($className, array('Controller', 'Debug', 'Model', 'Service', 'Lang', 'Base'))) {//框架本身
            $file = LIB . '/' . $className . '.php';
        } elseif ($className == 'Smarty') {//smarty
            $file = LIB . '/library/smarty/Smarty.class.php';
        } elseif (substr($className, 0, 3) == 'Ctl') {//加载控制器
            $file = $appRoot . '/' . CLT_DIR . '/' . $className . '.php';
        } elseif (substr($className, 0, 3) == 'Srv') {//加载service
            $file = $appRoot . '/' . SRV_DIR . '/' . $className . '.php';
        } elseif (substr($className, 0, 3) == 'Mod') {//加载模型
            $file = $appRoot . '/' . MOD_DIR . '/' . $className . '.php';
        } elseif (substr($className, 0, 3) == 'Lib') {//加载Lib
            $file = LIB . '/library/' . $className . '.php';
        }

        if ($file && is_file($file)) {
            require $file;
        } else {
            foreach (YX::$includePaths as $path) {
                if (is_file($path . '/' . $className . '.php')) {
                    require $file;
                    return;
                }
            }

            if (!class_exists('Debug')) {
                require LIB . '/Debug.php';
            }

            Debug::log("自动加载{$className}时，文件{$file}不存在", 'error');
            self::send404();
            return;
        }
    }

    /*
     * 专门用于跨app加载service
     * 调用方式为  YX::call('/app/service/method', $arg1, $arg2)
     */
    public static function call($methodPath)
    {
        $methodPath = explode('/', $methodPath);
        $method = array_pop($methodPath);
        $service = array_pop($methodPath);

        YX::$thisAppRoot = ROOT . '/web' . implode('/', $methodPath);

        if (strtolower(substr($service, 0, 3)) !== 'srv') {
            $service = 'Srv' . ucfirst($service);
        } else {
            $service = ucfirst($service);
        }

        $serviceFile = YX::$thisAppRoot . '/' . SRV_DIR . '/' . $service . '.php';
        if (!is_file($serviceFile)) {
            YX::$thisAppRoot = '';
            return null;
        }

        $obj = new $service;

        $args = func_get_args();
        if (count($args) > 1) {
            array_shift($args);
        } else {
            $args = array();
        }

        if (method_exists($obj, $method)) {
            $re = call_user_func_array(array($obj, $method), $args);
        } else {
            $re = null;
        }
        YX::$thisAppRoot = '';
        return $re;
    }

    public static function callByParam($methodPath)
    {
        $methodPath = explode('/', $methodPath);
        $method = array_pop($methodPath);
        $service = array_pop($methodPath);

        YX::$thisAppRoot = ROOT . '/web' . implode('/', $methodPath);

        if (strtolower(substr($service, 0, 3)) !== 'srv') {
            $service = 'Srv' . ucfirst($service);
        } else {
            $service = ucfirst($service);
        }

        $serviceFile = YX::$thisAppRoot . '/' . SRV_DIR . '/' . $service . '.php';
        if (!is_file($serviceFile)) {
            YX::$thisAppRoot = '';
            return null;
        }

        $args = func_get_args();

        $obj = new $service($args[1]);

        if (count($args) > 2) {
            array_shift($args);
            array_shift($args);
        } else {
            $args = array();
        }


        if (method_exists($obj, $method)) {
            $re = call_user_func_array(array($obj, $method), $args);
        } else {
            $re = null;
        }
        YX::$thisAppRoot = '';
        return $re;
    }

    /*
     * 跨APP调用模板
     */
    public static function layout($methodPath)
    {
        $methodPath = explode('/', $methodPath);
        $method = array_pop($methodPath);
        $controller = array_pop($methodPath);

        YX::$thisAppRoot = ROOT . '/web' . implode('/', $methodPath);

        if (strtolower(substr($controller, 0, 3)) !== 'ctl') {
            $controller = 'Ctl' . ucfirst($controller);
        } else {
            $controller = ucfirst($controller);
        }

        $obj = new $controller;

        $args = func_get_args();
        if (count($args) > 1) {
            array_shift($args);
        } else {
            $args = array();
        }

        if (method_exists($obj, $method)) {
            $re = call_user_func_array(array($obj, $method), $args);
        } else {
            $re = null;
        }
        YX::$thisAppRoot = '';
        return $re;
    }

    /**
     * 发送404状态码
     */
    private static function send404()
    {
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        exit;
    }
}

function import($path)
{
    array_unshift(YX::$includePaths, $path);
}

//初始化调用
YX::init();