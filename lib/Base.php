<?
interface Base
{
    /**
     * @param string $client_id 应用ID
     * @param int $aderId 平台账号ID
    */
    public function getAccessToken(string $client_id, int $aderId);

    /**
     * 请求API接口
     * @param string $client_id 应用ID
     * @param string $accessToken 请求token
     * @param int $aderId 平台账号
     * @param string $uri   接口地址
     * @param string $data 请求参数
     * @param string $method    请求方式
     * @param boolean $header   是否添加头部
    */
    public function httpRequestByToken(string $client_id, string $accessToken, int $aderId, string $uri, string $data, string $method, bool $header);

    /**
     * 刷新token
     * @param string $client_id
     * @param int $aderId
    */
    public function refreshToken(string $client_id, int $aderId);

    /**
     * 获取授权
     * @param string $client_id
     * @param int $aderId
    */
    public function  authorize(string $client_id, int $aderId);

    /**
     * 获取授权后回调接口请求获取AccessToken
     * @param string @client_id
     * @param array @queryData
     * @return array
    */
    public function authorizeCallback(string $client_id,array $queryData);
}

?>