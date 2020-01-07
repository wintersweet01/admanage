<?php
/**
 * 渠道授权配置
 *
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/12/14
 * Time: 16:21
 */

return array(
    'debug' => array( //沙箱
        'client_id' => 1105940985,
        'client_secret' => '',
        'account_id' => 1097,
        'access_token' => '123456',
        'key' => '123456',
        'url_authorize' => 'https://developers.e.qq.com/oauth/authorize',
        'url_token' => 'https://api.e.qq.com/oauth/token',
        'url_user' => 'https://sandbox-api.e.qq.com/v1.1/',
    ),

    '1108043224' => array( //腾讯社交广告应用IDl
        'client_id' => 1108043224,
        'client_secret' => '123456',
        'key' => '123456',
        'url_authorize' => 'https://developers.e.qq.com/oauth/authorize',
        'url_token' => 'https://api.e.qq.com/oauth/token',
        'url_user' => 'https://api.e.qq.com/v1.1/', //用户行为数据源地址
    ),

    '1547457457' => array( //今日头条社交广告应用ID1
        'client_id' => 1547457457,
        'client_secret' => 'sdfdsf1154545s4df',
        'url_authorize' => 'http://ad.oceanengine.com/openapi/audit/oauth.html', // 授权链接
        'key' => '9e3826e4efb1fb0aedfd798f27e6819bae383137',
    ),
);