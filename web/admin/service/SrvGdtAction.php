<?php
/**
 * 广点通操作类
 * @author dyh
 * @version 2019/12/04
 * Class SrvGdtAction
 */

class SrvGdtAction extends SrvAdPlatformAction
{
    protected $platform = 'gdt';

    public function __construct()
    {
        $this->config = LibUtil::config('ConfGdtApi');
    }

    /**
     * 创建广告组
     * @param array $param
     * @param string $token
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createGroup(array $param, string $token, array $header = [])
    {
        $this->checkParams($param, 'create_group');
        $url = $this->getRequestUrl('create_group') . '?' . http_build_query($this->getCommonParams($token, $param));
        return $this->send($url, $param, $header, 'create_group');
    }

    /**
     * 创建广告计划
     * @param array $param
     * @param string $token
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createAdPlan(array $param, string $token, array $header = [])
    {
        $this->checkParams($param, 'create_ad_plan');
        $url = $this->getRequestUrl('create_ad_plan') . '?' . http_build_query($this->getCommonParams($token, $param));
        return $this->send($url, $param, $header, 'create_ad_plan');
    }

    /**
     * 创建广告创意
     * @param array $param
     * @param string $token
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createAdOriginality(array $param, string $token, array $header = [])
    {
        $this->checkParams($param, 'create_ad_originality');
        $url = $this->getRequestUrl('create_ad_originality') . '?' . http_build_query($this->getCommonParams($token, $param));
        return $this->send($url, $param, $header, 'create_ad_originality');
    }

    /**
     * 创建广告
     * @param array $param
     * @param string $token
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function createAd(array $param, string $token, array $header = [])
    {
        $this->checkParams($param, 'create_ad');
        $url = $this->getRequestUrl('create_ad') . '?' . http_build_query($this->getCommonParams($token, $param));
        return $this->send($url, $param, $header, 'create_ad');
    }

    /**
     * 上传广告图片
     * @param array $param
     * @param string $token
     * @param array $file
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function uploadAdImg(array $param, string $token, array $file = [], array $header = [])
    {
        $this->checkParams($param, 'upload_ad_img');
        $url = $this->getRequestUrl('upload_ad_img') . '?' . http_build_query($this->getCommonParams($token, $param));
        $this->writeLog('upload_ad_img', $param, 'request');
        $response = LibUtil::request($url, $param, 30, '', $header, '', false, $file);
        $response['result'] = json_decode($response['result'], true);
        $this->writeLog('upload_ad_img', $response, 'response');
        return $response;
    }

    /**
     * 上传视频
     * @param array $param
     * @param string $token
     * @param array $file
     * @param array $header
     * @return array
     * @throws Exception
     */
    public function uploadAdVideo(array $param, string $token, array $file = [], array $header = [])
    {
        $this->checkParams($param, 'upload_ad_video');
        $url = $this->getRequestUrl('upload_ad_video'). '?' . http_build_query($this->getCommonParams($token, $param));
        $this->writeLog('upload_ad_video', $param, 'request');
        $response = LibUtil::request($url, $param, 30, '', $header, '', false, $file);
        $response['result'] = json_decode($response['result'], true);
        $this->writeLog('upload_ad_video', $response, 'response');
        return $response;
    }

    /**
     * 获取通用参数
     * @param string $token
     * @param array $param
     * @return array
     */
    private function getCommonParams(string $token, array $param)
    {
        return [
            'access_token' => $token,
            'timestamp' => time(),
            'nonce' => md5(json_encode($param) . uniqid())
        ];
    }
}