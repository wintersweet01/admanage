<?php
return array(
    //key 对应market_media.php
    '1643626315262990' => array(
        'market_name' => 'toutiao',//媒体标识，对应接口类，SrvToutiao.php
        'client_id' => 1643626315262990,//媒体APPID
        'client_secret' => '123456',//媒体密钥
        'key' => '123456',//媒体加密密钥，随机生成
        'url_token' => 'https://ad.toutiao.com/open_api/oauth2/access_token/',//获取access_token接口地址
        'url_refresh_token' => 'https://ad.toutiao.com/open_api/oauth2/refresh_token/',//刷新access_token接口地址
        'url_authrize' => 'https://ad.oceanengine.com/openapi/audit/oauth.html',//OAuth 授权接口地址
    ),
);