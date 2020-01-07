<?php

/** 今日头条-巨量引擎 **/
class SrvToutiao implements Base
{
    private $redirect_uri = null;

    public function __construct()
    {
        //配置回调地址
        $this->redirect_uri = $redc = AD_DOMAIN . '?ct=callback&ac=index_pub';
    }

    public function getAccessToken(string $client_id, int $aderId)
    {
        // TODO: Implement getAccessToken() method.
        if (empty($client_id) || empty($aderId)) {
            return array();
        }
        $accountInfo = LibChannel::mediaAccountInfo($aderId);
        if (empty($accountInfo)) {
            return array();
        }
        $setCache = false;
        $refresh = false;
        $redis = LibRedis::getInstance();
        $record = $redis->get(LibRedis::$prefix_sdk_channel_token . $client_id . '_' . $aderId);
        $data = array();
        if (empty($record)) {
            //则在数据库中获取
            if (empty($accountInfo['access_token'])) {
                return array();
            }
            $data['access_token_expires_in'] = $accountInfo['access_token_expires_in'];
            $data['access_token'] = $accountInfo['access_token'];
            $data['refresh_token'] = $accountInfo['refresh_token'];
            $data['time'] = $accountInfo['time'];
            $setCache = true;
        }
        //即将过期
        if (time() > ($data['time'] + $data['access_token_expires_in'] - 2000)) {
            $refresh = true;
        }
        if ($refresh) {
            //刷新access_token
            $mediaMapCnf = LibUtil::config('market_media_map');
            if (!$mediaMapCnf) {
                return array();
            }
            $data = self::refreshToken($client_id,$aderId);
            $data['time'] = time();
            //更新至表
            $srvMarket = new SrvMarket();
            $srvMarket->updateTokenInfoByaId($aderId, $data);
            $setCache = true;
        }

        if (time() > ($data['time'] + $data['access_token_expires_in'])) {
            return array();
        }
        if ($setCache && !empty($data)) {
            LibChannel::setAccessTokenCachePub($client_id, $aderId, $data);
        }
        return $data;
    }

    public function authorize(string $client_id, int $aderId)
    {
        // TODO: Implement authorize() method.
        if (empty($client_id) || empty($aderId)) {
            return false;
        }
        $client_id = trim($client_id);
        $mediaMapCnf = LibUtil::config('market_media_map');
        $config = @$mediaMapCnf[$client_id];
        if (empty($config)) {
            return false;
        }
        $uri = $config['url_authrize'];
        $sign = md5($client_id . $config['market_name'] . $config['key']);
        $state = $client_id . "|" . $config['market_name'] . "|" . $aderId . "|" . $sign;
        $param['app_id'] = $config['client_id'];
        $param['state'] = $state;
        $param['scope'] = '';
        $param['redirect_uri'] = $this->redirect_uri;
        $_href = $uri . "?" . http_build_query($param);
        header("Content-Type:text/html; charset=utf-8");
        header("Location: {$_href}");
    }

    public function authorizeCallback(string $client_id, array $queryData)
    {
        // TODO: Implement authorizeCallback() method.
        $backData = array();
        if (empty($client_id) || empty($queryData)) {
            exit('回调参数缺失');
        }
        if (empty($queryData['state']) || empty($queryData['auth_code'])) {
            exit('透传参数错误');
        }
        $mediaMapCnf = LibUtil::config('market_media_map');
        $config = @$mediaMapCnf[$client_id];
        if (empty($config)) {
            exit('未找到应用配置[' . $client_id . ']');
        }
        list($c_id, $market, $userId, $sign) = explode('|', $queryData['state']);
        if ($client_id != $c_id || empty($userId)) {
            exit('[' . $client_id . '],请求参数无效');
        }
        //获取账户信息
        $mediaAccount = LibChannel::mediaAccountInfo((int)$userId);
        if (empty($mediaAccount) || $mediaAccount['status'] == 1) {
            exit('账号[' . $userId . ']已失效');
        }
        $param = array();
        $param['app_id'] = $config['client_id'];
        $param['secret'] = $config['client_secret'];
        $param['grant_type'] = 'auth_code';
        $param['auth_code'] = $queryData['auth_code'];
        $url = $config['url_token'];
        $jsonHeaderInfo = array(
            'Content-Type: application/json; charset=utf-8',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
        );
        $result = LibUtil::curlRequest($url, http_build_query($param), 'post', $jsonHeaderInfo);
        if (empty($result) && $result['code'] != 200) {
            exit('授权失败[0]');
        }
        $ret = json_decode($result['result'], true);
        if ($ret['code'] != 0) {
            return $backData;
        }
        $row = $ret['data'];
        if (empty($row)) {
            return $backData;
        }
        //构建通用返回
        $backData['access_token'] = $row['access_token'];
        $backData['refresh_token'] = $row['refresh_token'];
        $backData['access_token_expires_in'] = $row['expires_in'];
        $backData['refresh_token_expires_in'] = $row['refresh_token_expires_in'];
        $backData['advertiser_id'] = $row['advertiser_id'];
        $backData['authorizer_info'] = $ret;
        return $backData;
    }

    public function refreshToken(string $client_id, int $aderId)
    {
        // TODO: Implement refreshToken() method.
        $backData = array();
        if (empty($client_id) || empty($aderId)) {
            return false;
        }
        $mediaCnfMap = LibUtil::config('market_media_map');
        $config = @$mediaCnfMap[$client_id];
        if (empty($config)) {
            //无法获取到配置
            return array();
        }
        $mediaAccount = LibChannel::mediaAccountInfo((int)$aderId);
        if (empty($mediaAccount['refresh_token']) || $mediaAccount['status'] == 1) {
            //无法获取到refresh_token或账号已失效
            return array();
        }
        $uri = $config['url_refresh_token'];
        $param['app_id'] = $config['client_id'];
        $param['secret'] = $config['client_secret'];
        $param['refresh_token'] = $mediaAccount['refresh_token'];
        $param['grant_type'] = 'refresh_token';
        $jsonHeaderInfo = array(
            'Content-Type: application/json; charset=utf-8',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
        );
        $result = LibUtil::curlRequest($uri, json_encode($param), 'post', $jsonHeaderInfo);
        if (empty($result)) {
            return array();
        }
        $ret = json_decode($result['result'], true);
        if ($ret['code'] != 0) {
            return array();
        }
        $row = $ret['data'];
        if (empty($row)) {
            return array();
        }
        //注意 构建通用返回 获取新的access_token和refresh_token
        $backData['access_token'] = $row['access_token'];
        $backData['refresh_token'] = $row['refresh_token'];
        $backData['access_token_expires_in'] = $row['expires_in'];
        $backData['refresh_token_expires_in'] = $row['refresh_token_expires_in'];
        $backData['authorizer_info'] = $ret;
        return $backData;
    }

    public function httpRequestByToken(string $client_id, string $accessToken, int $aderId, string $uri, string $data, string $method, bool $header)
    {
        // TODO: Implement httpRequestByToken() method.
        if (empty($uri) || empty($client_id) || empty($aderId) || empty($accessToken)) {
            return false;
        }
        try {
            $jsonHeaderInfo = array(
                'Content-Type: application/json; charset=utf-8',
                'Cache-Control: no-cache',
                'Pragma: no-cache',
                'Access-Token: ' . $accessToken
            );
            $ret = LibUtil::curlRequest($uri, $data, $method, $jsonHeaderInfo);
            if (!empty($ret) && $ret['code'] == 200) {
                $retData = json_decode($ret['result'], true, JSON_UNESCAPED_UNICODE);
                $code = $retData['code'];
                switch ($code) {
                    case 0:
                        return LibUtil::retData(true, ['data' => $retData], 'success');
                        break;
                    default:
                        return LibUtil::retData(false, ['data' => $retData], 'fail');
                        break;
                }
            } else {
                die($ret);
            }
        } catch (Exception $e) {
            return LibUtil::retData('EXCEPTION_CODE:' . $e->getCode(), [], $e->getMessage());
        } finally {
            #todo 写入log
            $log = array();
            $log['APPID'] = $client_id;
            $log['ACCOUNT'] = $aderId;
            $log['way'] = LibUtil::requestUri();
            $log['date_time'] = date('Y-m-d H:i:s', time());
            $log = json_encode($log, JSON_UNESCAPED_UNICODE);
            error_log('执行日志==' . $log . "\n", 3, '/tmp/uri_token.log');
        }
    }
}

?>