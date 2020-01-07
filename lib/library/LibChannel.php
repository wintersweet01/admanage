<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/12/18
 * Time: 19:50
 */

class LibChannel
{
    private static $debug = false; //调试
    private static $redirect_uri = AD_DOMAIN . '?ct=callback';

    /**
     * 获取渠道账号授权URL
     *
     * @param int $user_id
     * @param string $channel
     * @return bool|string
     */
    public static function getAuthorizeUrl($user_id = 0, $channel = '')
    {
        if (!$user_id || !$channel) {
            return false;
        }

        //获取配置信息
        $c = LibUtil::config('channel_auth_map');
        $client_id = $c[$channel];
        if (empty($client_id)) {
            return false;
        }

        $config = LibUtil::config('channel_auth');
        $cnf = $config[$client_id];
        if (empty($cnf)) {
            return false;
        }

        $url = '';
        switch ($channel) {
            case 'gdt': //广点通
                $key = $cnf['key'];
                $client_id = $cnf['client_id'];
                $sign = md5($client_id . $key);
                $state = $user_id . '|' . $client_id . '|' . $sign;
                $data = array(
                    'client_id' => $client_id,
                    'redirect_uri' => self::$redirect_uri,
                    'state' => $state,
                    'scope' => 'user_actions' //权限
                );
                $url = $cnf['url_authorize'] . '?' . http_build_query($data);
                break;
            case 'jrtt': // 今日头条
                $key = $cnf['key'];
                $client_id = $cnf['client_id'];
                $sign = md5($client_id . $key);
                $state = $user_id . '|' . $client_id . '|' . $sign;
                $data = array(
                    'app_id' => $client_id,
                    'redirect_uri' => self::$redirect_uri,
                    'state' => $state,
                    // 'scope' => [],  TODO:: 授权范围不传时代表当前应用拥有的所有权限，待确定是否需要确定具体的权限
                );
                $url = $cnf['url_authorize'] . '?' . http_build_query($data);
                break;
        }

        return $url;
    }

    /**
     * 获取授权信息
     *
     * @param int $client_id
     * @param int $account_id
     * @param bool $refresh
     * @return bool|string
     */
    public static function getAccessToken($client_id = 0, $account_id = 0, $refresh = false)
    {
        if (!$client_id || !$account_id) {
            Debug::log('getAccessToken error: no client_id or account_id', 'error');

            return false;
        }

        $setCache = false;
        $redis = LibRedis::getInstance();
        $data = $redis->get(LibRedis::$prefix_sdk_channel_token . $client_id . '_' . $account_id);

        if (empty($data)) {
            //$srvAd = new SrvAd();
            //$data = $srvAd->getChannelUserAuthInfoByCid($client_id, $account_id);

            $data = YX::call('/admin/ad/getChannelUserAuthInfoByCid', $client_id, $account_id);
            if (empty($data)) {
                Debug::log('getAccessToken error: get data error', 'error');

                return false;
            }

            $data['authorizer_info'] = json_decode($data['authorizer_info'], true);
            unset($data['channel_short']);

            $setCache = true;
        }

        //准备过期刷新
        if (time() > ($data['time'] + $data['access_token_expires_in'] - 2000)) {
            $refresh = true;
        }

        if ($refresh) {
            //获取配置信息
            $config = LibUtil::config('channel_auth');
            $cnf = $config[$client_id];
            if (empty($cnf)) {
                Debug::log('getAccessToken error: config error', 'error');

                return false;
            }

            $param = array(
                'client_id' => $client_id,
                'client_secret' => $cnf['client_secret'],
                'refresh_token' => $data['refresh_token']
            );
            $ret = self::oauthRequest($cnf['url_token'], $param);
            if ($ret) {
                $data['access_token'] = $ret['access_token'];
                $data['refresh_token'] = $ret['refresh_token'];
                $data['access_token_expires_in'] = (int)$ret['access_token_expires_in'];
                $data['time'] = time();

                //$srvAd = new SrvAd();
                //$data['update'] = $srvAd->channelUpdateUserAuth($data['user_id'], $data);

                $data['update'] = YX::call('/admin/ad/channelUpdateUserAuth', $data['user_id'], $data);

                $setCache = true;

                Debug::log("{$data['user_id']}，{$account_id}，update: " . $data['update'], 'test', RUNTIME_DIR . '/logs/test.log');
            }
        }

        if (time() > ($data['time'] + $data['access_token_expires_in'])) {
            Debug::log('getAccessToken error: expire', 'error');

            return false;
        }

        if ($setCache) {
            self::setAccessTokenCache($client_id, $account_id, $data);
        }

        return $data;
    }

    /**
     * 设置渠道授权
     *
     * @param int $user_id
     * @param int $client_id
     * @param int $authorization_code
     * @return bool
     */
    public static function setAccessToken($user_id = 0, $client_id = 0, $authorization_code = 0)
    {
        if (!$user_id || !$client_id || !$authorization_code) {
            return false;
        }

        //获取配置信息
        $config = LibUtil::config('channel_auth');
        $cnf = $config[$client_id];
        if (empty($cnf)) {
            return false;
        }

        $param = array(
            'user_id' => $user_id,
            'client_id' => $client_id,
            'client_secret' => $cnf['client_secret'],
            'authorization_code' => $authorization_code,
            'redirect_uri' => self::$redirect_uri,
        );

        return self::oauthRequest($cnf['url_token'], $param);
    }

    /**
     * 设置渠道授权
     * @param string $client_id
     * @param string $market
     * @param array $request
     * @return array
     */
    public static function setAccessTokenPub($client_id = '', $market = '', $request = [])
    {
        if (empty($client_id) || empty($market)) {
            return array();
        }
        try {
            $market = trim($market);
            $row = YX::call('/admin/' . $market . '/authorizeCallback', $client_id, $request);
            if (empty($row)) {
                return array();
            }
            //key字典
            $keyMap = array(
                'access_token',
                'refresh_token',
                'access_token_expires_in',
                'refresh_token_expires_in',
                'advertiser_id',
                'authorizer_info'
            );
            if (!LibUtil::checkKeyMap($keyMap, $row)) {
                return array();
            }
            return $row;
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * 获取媒体账号配置信息
     * @param int $mediaId
     * @return array
     */
    public static function mediaAccountInfo($mediaId)
    {
        if (empty($mediaId)) {
            return array();
        }
        try {
            $row = YX::call('/admin/market/mediaAccountInfo', $mediaId);
            $mediaCnfMap = LibUtil::config('market_media_map');
            if (!empty($row) && !empty($row['media'])) {
                $row['media_config'] = @$mediaCnfMap[$row['media']];
                return $row;
            } else {
                return array();
            }
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * 保存渠道授权信息缓存
     *
     * @param int $client_id
     * @param int $account_id
     * @param array $data
     * @return bool
     */
    public static function setAccessTokenCache($client_id = 0, $account_id = 0, $data = [])
    {
        $data['expires'] = intval($data['access_token_expires_in'] - 2000);
        is_array($data['authorizer_info']) || $data['authorizer_info'] = json_decode($data['authorizer_info'], true);

        $redis = LibRedis::getInstance();
        return $redis->set(LibRedis::$prefix_sdk_channel_token . $client_id . '_' . $account_id, $data);
    }

    public static function setAccessTokenCachePub($client_id = 0, $account_id = 0, $data = [])
    {
        $data['expires'] = intval($data['access_token_expires_in'] - 2000);
        is_array($data['access_token_info']) || $data['access_token_info'] = json_decode($data['access_token_info'], true);
        $redis = LibRedis::getInstance();
        return $redis->set(LibRedis::$prefix_sdk_channel_token . $client_id . '_' . $account_id, $data);
    }

    /**
     * 设置渠道数据源ID缓存
     *
     * @param int $account_id
     * @param int $mobile_app_id
     * @param string $user_action_set_id
     * @return bool
     */
    public static function setUserActionIdCache($account_id = 0, $mobile_app_id = 0, $user_action_set_id = '')
    {
        $redis = LibRedis::getInstance();
        return $redis->set(LibRedis::$prefix_sdk_channel_uid . $account_id . '_' . $mobile_app_id, $user_action_set_id);
    }

    /**
     * 获取渠道数据源ID缓存
     *
     * @param int $account_id
     * @param int $mobile_app_id
     * @return bool|string
     */
    public static function getUserActionId($account_id = 0, $mobile_app_id = 0)
    {
        $redis = LibRedis::getInstance();
        return $redis->get(LibRedis::$prefix_sdk_channel_uid . $account_id . '_' . $mobile_app_id);
    }

    /**
     * 添加数据源
     *
     * @param int $client_id
     * @param array $param
     * @return bool|mixed
     */
    public static function userActionSetsAdd($client_id = 0, $param = [])
    {
        //获取配置信息
        $config = LibUtil::config('channel_auth');
        $cnf = $config[$client_id];
        if (empty($cnf)) {
            return false;
        }

        if (!$param['access_token']) {
            return false;
        }

        //test
        if (self::$debug) {
            $cnf = $config['debug'];
            $param['access_token'] = $cnf['access_token'];
            $param['account_id'] = $cnf['account_id'];
        }

        return self::publicRequest($cnf['url_user'] . 'user_action_sets/add', $param);
    }

    /**
     * 获取数据源列表
     *
     * @param int $client_id
     * @param int $account_id
     * @return bool
     */
    public static function userActionSetsGet($client_id = 0, $account_id = 0)
    {
        //获取配置信息
        $config = LibUtil::config('channel_auth');
        $cnf = $config[$client_id];
        if (empty($cnf)) {
            return false;
        }

        $access_data = self::getAccessToken($client_id, $account_id);

        $param = array(
            'access_token' => $access_data['access_token'],
            'account_id' => $account_id,
        );

        //test
        if (self::$debug) {
            $cnf = $config['debug'];
            $param['access_token'] = $cnf['access_token'];
            $param['account_id'] = $cnf['account_id'];
        }

        return self::publicRequest($cnf['url_user'] . 'user_action_sets/get', $param, 'GET');
    }

    /**
     * 上报行为数据
     *
     * @param array $data
     * @return bool|mixed
     */
    public static function userActionAdd($data = [])
    {
        $client_id = (int)$data['client_id'];
        $account_id = (int)$data['account_id'];
        $mobile_app_id = (int)$data['mobile_app_id'];

        $user_action_set_id = self::getUserActionId($account_id, $mobile_app_id);

        $param = array(
            'account_id' => strval($account_id),
            'user_action_set_id' => strval($user_action_set_id),
            'actions' => array(),
        );

        $list = array(
            'action_time' => time(),
            'user_id' => array(),
            'action_type' => $data['action_type'],
        );

        if ($data['action_time']) {
            $list['action_time'] = $data['action_time'];
        }

        if ($data['sum_device_id']) {
            if ($data['app_type'] == 'ANDROID') {
                $list['user_id']['hash_imei'] = $data['sum_device_id'];
            } elseif ($data['app_type'] == 'IOS') {
                $list['user_id']['hash_idfa'] = $data['sum_device_id'];
            }
        }

        if ($data['action_param']) {
            $list['action_param'] = $data['action_param'];
        }

        if ($data['trace']) {
            $list['trace'] = $data['trace'];
        }

        $access_data = self::getAccessToken($client_id, $account_id);
        $param['access_token'] = $access_data['access_token'];
        $param['actions'][] = $list;

        //获取配置信息
        $config = LibUtil::config('channel_auth');
        $cnf = $config[$client_id];
        if (empty($cnf)) {
            return false;
        }

        //test
        if (self::$debug) {
            $cnf = $config['debug'];
            $param['access_token'] = $cnf['access_token'];
            $param['account_id'] = $cnf['account_id'];
        }

        $url = $cnf['url_user'] . 'user_actions/add';
        $ret = self::publicRequest($url, $param);

        return array(
            'url' => $url,
            'param' => $param,
            'result' => $ret
        );
    }

    /**
     * 获取授权
     *
     * @param string $url
     * @param array $data
     * @return bool
     */
    private static function oauthRequest($url = '', $data = [])
    {
        $param = array(
            'client_id' => $data['client_id'],
            'client_secret' => $data['client_secret']
        );

        if (!empty($data['refresh_token'])) {
            $param['grant_type'] = 'refresh_token';
            $param['refresh_token'] = $data['refresh_token'];
        } else {
            $param['grant_type'] = 'authorization_code';
            $param['authorization_code'] = $data['authorization_code'];
            $param['redirect_uri'] = $data['redirect_uri'];
        }

        $url .= '?' . http_build_query($param);
        $result = self::curlRequest($url);
        if ($result['code'] != 200) {
            return false;
        }

        $ret = json_decode($result['result'], true);
        if ($ret['code'] != 0) {
            return false;
        }

        $row = $ret['data'];
        if (empty($row)) {
            return false;
        }

        return $row;
    }

    /**
     * 公用请求
     *
     * @param $url
     * @param $param
     * @param string $method
     * @return bool|mixed
     */
    private static function publicRequest($url, $param, $method = 'POST')
    {
        $access_token = '';
        if (!empty($param['access_token'])) {
            $access_token = $param['access_token'];
            unset($param['access_token']);
        } else {
            #记录无access_token
            unset($param['access_token']);
        }

        $public_param = array(
            'access_token' => $access_token,
            'timestamp' => time(),
            'nonce' => uniqid(),
        );

        $request_url = $url . '?' . http_build_query($public_param);
        $header = array(
            'Content-Type: application/json; charset=utf-8',
            //'Content-Length: ' . strlen(json_encode($param))
        );

        if (strtoupper($method) == 'GET') {
            $request_url .= "&" . http_build_query($param);
            $ret = self::curlRequest($request_url, '', $header);
        } else {
            $param = json_encode($param);
            $ret = self::curlRequest($request_url, $param, $header);
        }

        $_data = array(
            'url' => $request_url,
            'header' => $header,
            'param' => $param,
            'result' => $ret['result']
        );

        $str = date('Y-m-d H:i:s') . "\n";
        $str .= var_export($_data, true) . "\n\n";
        file_put_contents(__DIR__ . '/../../runtime/logs/gdt_request.log', $str, FILE_APPEND);

        if ($ret['code'] != 200) {
            return false;
        }

        return json_decode($ret['result'], true);
    }

    /**
     * CURL请求
     *
     * @param string $url 请求地址
     * @param string $post post数据(不填则为GET)
     * @param string $header 提交的$header
     * @param string $cookie 提交的$cookies
     * @param bool $returnHeader 是否返回header
     * @return array
     */
    public static function curlRequest($url = '', $post = '', $header = '', $cookie = '', $returnHeader = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_REFERER, self::$redirect_uri);
        if (stripos($url, 'https://') === 0) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ($header) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        if ($post) {
            if (is_array($post)) $post = http_build_query($post);

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnHeader);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $data = [];
        $result = curl_exec($curl);

        $data['header'] = '';
        $data['result'] = $result;
        $data['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($result === false) {
            $data['result'] = curl_error($curl);
            $data['code'] = -curl_errno($curl);
        }

        curl_close($curl);
        if ($returnHeader) {
            list($header, $body) = explode("\r\n\r\n", $result, 2);
            $data['header'] = $header;
            $data['result'] = $body;
        }

        return $data;
    }


    public static function getChannelConfig($app, $client_id)
    {

        if (empty($app) || empty($client_id)) {
            return false;
        }

        $data = YX::call('/admin/adManage/getAppInfo', $app);
        if (empty($data)) {
            Debug::log('get APP info error：can not find the method getAppInfo', 'error');
            return false;
        }
        if ($data['appid'] != $client_id) {
            Debug::log('the data.appid not eq param.client_id', 'error');
            return false;
        }
        return $data;
    }
}