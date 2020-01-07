<?php
header("content-type:text/html; charset=utf-8");

define('TIME_ZONE', 'Asia/Shanghai');

define('DEBUG', true);

define('TEST', false);

define('APP_LANG', 'zh_CN');

define('DEFAULT_ADMIN_PAGE_NUM', 18);

define('SET_PWD_KEY', '123456');

define('LAND_PAGE_KEY', '123456');

define('GLOBAL_DOMAIN', 'hutao.net');

define('COMMUNITY_DOMAIN', 'http://bridge.api.hutao.net/');
define('COMMUNITY_KEY', '123456');

define('APP_ALL_URL', 'http://ht.sdk.hutao.net');

//落地页投放统计地址
define('AD_DOMAIN', 'https://tz-t.hutao.net/');
//短链地址
define('AD_DOMAIN_SHORT', 'https://t.hutao.net/');

define('LOG_PATH', ROOT . '/logs/');

define('PIC_UPLOAD_DIR', ROOT . '/web/admin/uploads/');
define('TEMPLATE_FILE', ROOT . '/web/admin/template/html/');

//安卓推广包下载地址
define('APK_CDN_URL', 'https://download.hutao.net/');
define('APK_DIR', '/data2/uploads/package/apk/');
define('APK_MODEL_DIR', '/data2/uploads/package/apk_model/');

define('TG_LOCAL_URL', 'http://preview-t.hutao.net/');
//落地页推广地址
define('CDN_URL', 'https://kk-t.hutao.net/');
define('CDN_DIR', '/data2/uploads/tg/');

define('LAND_MODEL_DIR', '/data2/uploads/tg_model/');
define('LAND_MODEL_URL', 'http://mb-t.hutao.net/');
define('UPLOAD_MODEL_DIR', '/home/vagrant/code/admin/uploads/upload_model/');
define('UPLOAD_MODEL_URL', 'http://mb-d.hutao.net');

define('CDN_UPLOAD_DIR', CDN_DIR . 'static/');
define('CDN_UPLOAD_URL', CDN_URL . 'static/');

//落地页点击统计地址
define('TJ_LAND_URL', 'https://tj-t.hutao.net/v.gif');

define('APPSTORE_URL', 'https://itunes.apple.com/cn/app/id');
define('MC_PREFIX', '');

//静态资源地址
define('CDN_STATIC_DIR', realpath(__DIR__ . '/../../../../static'));
define('CDN_STATIC_URL', 'https://static.hutao.net/');

define('ROOT_DOMAIN', 'hutao.net');

//素材目录
define('MATERIAL_UPLOAD_DIR', '/home/vagrant/code/admin/web/admin/uploads');
define('MATERIAL_UPLOAD_URL', 'http://material.hutao.net');

//服务器下载目录
define('DOWNLOAD_DIR', '/data2/uploads/downloads');
define('DOWNLOAD_URL', 'http://download.internal.hutao.net');

//落地页nginx统计日志目录
define('LAND_NGINX_DIR', '/data2/nginx_logs');
define('LAND_NGINX_FILE', LAND_NGINX_DIR . '/sdk_tj.log');

//SDK API配置
define('API_SDK_URL', 'https://sdk.api.hutao.net');
define('API_PAY_URL', 'https://pay.api.hutao.net');

define('PAY_STATUS', [
    '未支付' => 1,
    '已支付' => 2,
    '已支付(沙盒)' => 3,
]);

define('PLATFORM', [
    'ios' => 1,
    'android' => 2,
    'html5' => 3
]);

//VIP提成配置/元
//业绩达标
define('VIP_ACH', 5000);
//RMB比例
define('MONEY_CONF', 100);
//客服管理员
define('KF_ADMIN', ['hcy', 'czl']);
define('AUTHOR_POWER_KEY', '123456');

//客户端密钥，必须为16位
define('SSL_KEY', '12345612345688');

//安卓打包签名配置
define('SIGNATURE_APK', array(
    'hutao' => array(
        'name' => '胡桃',
        'alias' => 'hutao.keystore',
        'password' => '123456',
        'file' => ROOT . '/' . CONF_DIR . '/signature/hutao.keystore',
    ),
    'xiansa' => array(
        'name' => '仙萨',
        'alias' => 'xiansagame',
        'password' => '123456',
        'file' => ROOT . '/' . CONF_DIR . '/signature/xiansagame.keystore',
    )
));