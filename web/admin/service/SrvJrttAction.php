<?php
/**
 * 今日头条操作类
 * @author dyh
 * @version 2019/12/03
 */
class SrvJrttAction extends SrvAdPlatformAction
{
    protected $platform = 'jrtt';

    public function __construct()
    {
        $this->config = LibUtil::config('ConfJrttApi');
    }

    /**
     * 刷新授权
     * @param $user_id
     * @return bool
     * @throws Exception
     */
    public function refreshToken($user_id)
    {
        if(! is_numeric($user_id)) {
            throw new Exception('参数错误');
        }
        $mod = new ModAd();
        $user_info = $mod->getChannelUserAuthInfo($user_id);
        if(empty($user_info)) {
            throw new Exception('记录不存在');
        }
        $config = LibUtil::config('channel_auth');
        $cnf = $config[$user_info['client_id']];
        if(empty($cnf)) {
            throw new Exception('渠道未配置');
        }
        $param = [
            'app_id' => $cnf ['client_id'],
            'secret' => $cnf ['client_secret'],
            'grant_type' => 'refresh_token',
            'refresh_token' => $user_info['refresh_token']
        ];
        $url = $this->getRequestUrl('refresh_token');
        $response = $this->send($url, $param, [], 'refresh_token');
        if(! isset($response['data']) || empty($response['data'])) {
            throw new Exception('授权刷新失败[1]');
        }
        $result = $this->saveAccessToken($user_id, $user_info['client_id'], $response);
        if (!$result) {
            throw new Exception('授权刷新失败[2]');
        }
        return true;
    }

    /**
     * 授权回调
     * @param $state
     * @param $auth_code
     * @return bool
     * @throws Exception
     */
    public function authCallback($state, $auth_code)
    {
        if (!$state || !$auth_code) {
            throw new Exception('回调参数缺失');
        }
        list($user_id, $client_id, $sign) = explode('|', $state);

        if (!$user_id || !$client_id || !$sign) {
            throw new Exception('透传参数错误');
        }

        $config = LibUtil::config('channel_auth');
        $cnf = $config[$client_id];
        if (empty($cnf)) {
            throw new Exception("应用未配置[{$client_id}]");
        }

        $dign = md5($client_id . $cnf['key']);
        if ($dign != $sign) {
            throw new Exception('验签失败');
        }

        $ret = $this->getAccessToken($cnf, $auth_code);
        if (empty($ret)) {
            throw new Exception('授权失败[1]');
        }

        $result = $this->saveAccessToken($user_id, $client_id, $ret);
        if (!$result) {
            throw new Exception('授权失败[2]');
        }
        return true;
    }

    /**
     * 获取access_token
     * @param $cnf
     * @param $auth_code
     * @return array
     * @throws Exception
     */
    private function getAccessToken($cnf, $auth_code)
    {
        $param = [
            'app_id' => $cnf ['client_id'],
            'secret' => $cnf ['client_secret'],
            'grant_type' => $cnf ['auth_code'],
            'auth_code' => $auth_code
        ];
        $url = $this->getRequestUrl('get_access_token');
        return $this->send($url, $param, [], 'get_access_token');
    }

    /**
     * 保存access_token
     * @param $user_id
     * @param $client_id
     * @param $result
     * @return bool|resource|string
     */
    public function saveAccessToken($user_id, $client_id, $result)
    {
        if (!$user_id || !$client_id || empty($result)) {
            return false;
        }
        $data = $result['data'];
        if(empty($data) || !is_array($data))
            return false;

        $param = [
            'user_id' => $user_id,
            'account_id' => $data ['advertiser_id'],
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'client_id' => $client_id,
            'access_token_expires_in' => $data['expires_in'],
            'refresh_token_expires_in' => $data['refresh_token_expires_in'],
            'time' => time()
        ];

        $mod = new ModChannelUserAuth();

        $ret = $mod->saveAccessToken($param);
        if ($ret) {
            LibChannel::setAccessTokenCache($client_id, $data ['advertiser_id'], $param);
        }

        return $ret;
    }

    /**
     * 获取行业
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function getIndustry(array $param, array $header)
    {
        $this->checkParams($param, 'get_industry');
        $query = empty($param) ?  '' : '?' . http_build_query($param);
        $url = $this->getRequestUrl('get_industry') . $query;
        return $this->send($url, [], $header, 'get_industry');
    }

    /**
     * 创建广告组
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createAdGroup(array $param, array $header = [])
    {
        $this->checkParams($param, 'create_group');
        $url = $this->getRequestUrl('create_group');
        return $this->_resultHandle($this->send($url, $param, $header, 'create_group'));
    }

    /**
     * api返回结果处理
     * @param $result
     * @return mixed
     * @throws Exception
     */
    private function _resultHandle($result)
    {
        if($result['code'] != 0)
            throw new Exception($result['message']);
        return $result['data'];
    }

    /**
     * 创建广告计划
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createAdPlan(array $param, array $header)
    {
        $this->checkParams($param, 'create_ad_plan');
        $url = $this->getRequestUrl('create_ad_plan');
        return $this->_resultHandle($this->send($url, $param, $header, 'create_ad_plan'));
    }

    /**
     * 创建广告创意
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createAdOriginality(array $param, array $header)
    {
        $this->checkParams($param, 'create_ad_originality');
        $url = $this->getRequestUrl('create_ad_originality');
        return $this->_resultHandle($this->send($url, $param, $header, 'create_ad_originality'));
    }

    /**
     * 获取第三级行业列表
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function thirdIndustryList(array $param, array $header)
    {
        $url = $this->getRequestUrl('third_industry_list') . '?' . http_build_query($param);
        return $this->send($url, [], $header, 'third_industry_list');
    }

    /**
     * 上传广告图片
     * @param array $param
     * @param array $header
     * @param array $file
     * @return array
     * @throws Exception
     */
    public function uploadAdImg(array $param, array $header, array $file = [])
    {
        $this->checkParams($param, 'upload_ad_img');
        $url = $this->getRequestUrl('upload_ad_img');
        $this->writeLog('upload_ad_img', $param, 'request');
        $response = LibUtil::request($url, $param, 30, '', $header, '', false, $file);
        $response['result'] = json_decode($response['result'], true);
        if ($response['code'] != '200')
            throw new Exception('第三方接口请求失败，curl错误码:' . $response['code'] . '。请求地址：' . $url);
        $this->writeLog('upload_ad_img', $response, 'response');
        return $this->_resultHandle($response['result']);
    }

    /**
     * 上传视频
     * @param array $param
     * @param array $header
     * @param array $file
     * @return array
     * @throws Exception
     */
    public function uploadAdVideo(array $param, array $header, array $file)
    {
        $this->checkParams($param, 'upload_ad_video');
        $url = $this->getRequestUrl('upload_ad_video');
        $this->writeLog('upload_ad_video', $param, 'request');
        $response = LibUtil::request($url, $param, 30, '', $header, '', false, $file);
        $response['result'] = json_decode($response['result'], true);
        if ($response['code'] != '200')
            throw new Exception('第三方接口请求失败，curl错误码:' . $response['code'] . '。请求地址：' . $url);
        $this->writeLog('upload_ad_video', $response, 'response');
        return $this->_resultHandle($response['result']);
    }

    /**
     * 获取商圈数据
     * @param array $param
     * @param array $header
     * @throws Exception
     * @return array
     */
    public function getBusinessTree(array $param, array $header)
    {
        $this->checkParams($param, 'get_business_tree');
        $url = $this->getRequestUrl('get_business_tree') . '?' . http_build_query($param);
        return $this->send($url, [], $header, 'get_business_tree');
    }

    /**
     * 获取行为类目
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function getActionCategory(array $param, array $header)
    {
        $this->checkParams($param, 'get_action_category');
        $url = $this->getRequestUrl('get_action_category');
        return $this->send($url, [], $header, 'get_action_category');
    }

    /**
     * 行为关键词查询
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function getActionKeyword(array $param, array $header)
    {
        $this->checkParams($param, 'get_action_keyword');
        $url = $this->getRequestUrl('get_action_keyword') . '?' . http_build_query($param);
        return $this->send($url, [], $header, 'get_action_keyword');
    }

    /**
     * 兴趣类目查询
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function getInterestCategory(array $param, array $header)
    {
        $this->checkParams($param, 'get_interest_category');
        $url = $this->getRequestUrl('get_interest_category') . '?' . http_build_query($param);
        return $this->send($url, [], $header, 'get_interest_category');
    }

    /**
     * 兴趣关键词查询
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function getInterestKeyword(array $param, array $header)
    {
        $this->checkParams($param, 'get_interest_keyword');
        $url = $this->getRequestUrl('get_interest_keyword') . '?' . http_build_query($param);
        return $this->send($url, [], $header, 'get_interest_keyword');
    }

    /**
     * 兴趣行为类目关键词id转词
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function id2word(array $param, array $header)
    {
        $this->checkParams($param, 'id2word');
        $url = $this->getRequestUrl('id2word') . '?' . http_build_query($param);
        return $this->send($url, [], $header, 'id2word');
    }

    /**
     * 获取行为兴趣推荐关键词
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function keywordSuggest(array $param, array $header)
    {
        $this->checkParams($param, 'keyword_suggest');
        $url = $this->getRequestUrl('keyword_suggest') . '?' . http_build_query($param);
        return $this->send($url, [], $header, 'keyword_suggest');
    }

    /**
     * 创建定向包
     * @param array $param
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createAudiencePackage(array $param, array $header)
    {
        $this->checkParams($param, 'create_audience_package');
        $url = $this->getRequestUrl('create_audience_package');
        return $this->_resultHandle($this->send($url, $param, $header, 'create_audience_package'));
    }
}