<?php
error_reporting(1);
session_start();

define('APP_ROOT', dirname(__FILE__));
define('SYS_STATIC_URL', '/static/');
define('REQUEST_METHOD', strtoupper(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : ''));

require dirname(dirname(APP_ROOT)) . '/lib/YX.php';

$noLogin = array(
    'index',
    'captcha',
);

if (!in_array($_GET['ct'], $noLogin)) {
    if (SrvAuth::checkLogin() === false) {
        header('Location: ?ct=index');
        exit;
    }
}

//管理员操作日志
function _log()
{
    if (REQUEST_METHOD != 'POST') return;

    static $types;
    if ($types === null) {
        $types = LibUtil::config('ConfAdminLog');
    }

    $type = "{$_GET['ct']}=>{$_GET['ac']}";
    if (empty($types[$type])) return;

    $log = array(
        'script' => $type,
        'get' => $_GET,
        'post' => $_POST
    );

    $SrvAdmin = new SrvAdmin();
    $SrvAdmin->saveAdminLog($types[$type], $log);
}

LibUtil::shutdown_function('_log');

YX::run();