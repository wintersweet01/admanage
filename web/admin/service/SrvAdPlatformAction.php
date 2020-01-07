<?php

/**
 * 广告平台接口类
 * @author dyh
 * @version 2019/12/04
 * class SrvAdPlatformAction
 */
class SrvAdPlatformAction
{
    /**
     * 是否调试模式
     * @var bool
     */
    protected $isDebug = false;

    protected $platform;

    /**
     * api配置数组
     * @var array
     */
    protected $config;

    /**
     * 发送请求
     * @param string $url
     * @param array $param
     * @param array $header
     * @param string $api
     * @return array
     */
    protected function send(string $url, array $param, array $header = array(), string $api)
    {
        $this->writeLog($api, $param, 'request');
        $response = LibUtil::request($url, $param, 30, '', $header);
        $response['result'] = json_decode($response['result'], true);
        $this->writeLog($api, $response, 'response');
        return $response;
    }


    /**
     * 写入请求响应日志
     * @param string $api
     * @param array $data
     * @param string $type
     * @return false|int
     */
    protected function writeLog(string $api, array $data, string $type = 'request')
    {
        $dir = RUNTIME_DIR . '/logs/' . $this->platform . '/' . $api . '/' . date('Ym') . '/';
        if (!file_exists($dir)) {
            @mkdir($dir, 0754, true);
        }
        $filename = date('YmdHis') . '-' . uniqid() . '-' . $type . '.json';
        return @file_put_contents($dir . $filename, json_encode($data));
    }

    /**
     * 自定义格式验证日期
     * @param $date
     * @param string $format
     * @return bool
     */
    protected function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * 获取请求url
     * @param $api
     * @return string
     */
    protected function getRequestUrl(string $api)
    {
        $domain = $this->isDebug ? $this->config['domain']['debug'] : $this->config['domain']['production'];
        return $domain . $this->config['api'][$api];
    }

    /**
     * 设置调试模式
     * @param bool $isDebug
     * @return SrvAdPlatformAction
     */
    public function setIsDebug(bool $isDebug = false)
    {
        $this->isDebug = $isDebug;
        return $this;
    }

    /**
     * 参数检测
     * @param array $param
     * @param string $api
     * @throws Exception
     */
    protected function checkParams(array $param, string $api)
    {
        $rule = $this->config['api_param_rule'][$api];
        if (empty($rule))
            throw new Exception('找不到匹配的参数规则', -1);

        $typeFunc = ['int' => 'is_int', 'numeric' => 'is_numeric', 'string' => 'is_string', 'array' => 'is_array'];
        foreach ($rule as $key => $val) {
            // 判断是否必需参数
            if ($val['required'] && empty($param[$key]))
                throw new Exception('api:' . $api . ' ' . $key . '为必填字段', 0);

            // 判断参数类型
            $typeRes = true;
            !empty($param[$key]) && isset($typeFunc[$val['type']]) && $typeRes = $typeFunc[$val['type']]($param[$key]);
            if (!$typeRes)
                throw new Exception('api:' . $api . ' ' . $key . '字段需为' . $val['type'] . '类型', 0);

            // 验证日期类型
            if (!empty($param[$key]) && $val['type'] == 'date') {
                if (!$this->validateDate($param[$key]))
                    throw new Exception('api:' . $api . ' ' . $key . '字段必需为日期格式:YYYY-MM-DD HH:II:SS');
            }

            // 验证url格式
            if (!empty($param[$key]) && $val['type'] == 'url') {
                if (!filter_var($param[$key], FILTER_VALIDATE_URL))
                    throw new Exception('api:' . $api . ' ' . $key . '字段必需为url格式:http://example.com');
            }

            // 判断参数值范围
            if (isset($val['min']) && !empty($param[$key])) {
                if ($val['type'] == 'string' && mb_strlen($param[$key]) < $val['min'])
                    throw new Exception('api:' . $api . ' ' . $key . '字段不能小于' . $val['min'] . '个字符', 0);
                else if (($val['type'] == 'int' || $val['type'] == 'numeric') && $param[$key] < $val['min'])
                    throw new Exception('api:' . $api . ' ' . $key . '字段不能小于' . $val['min'], 0);
            }
            if (isset($val['max']) && !empty($param[$key])) {
                if ($val['type'] == 'string' && mb_strlen($param[$key]) > $val['max'])
                    throw new Exception('api:' . $api . ' ' . $key . '字段不能大于' . $val['max'] . '个字符', 0);
                else if (($val['type'] == 'int' || $val['type'] == 'numeric') && $param[$key] > $val['max'])
                    throw new Exception('api:' . $api . ' ' . $key . '字段不能大于' . $val['max'], 0);
            }

            // 判断参数枚举值
            if (isset($val['value']) && !empty($param[$key])) {
                if ($val['type'] != 'array' && !in_array($param[$key], $val['value'])) {
                    throw new Exception('api:' . $api . ' ' . '字段' . $key . '值只能为' . implode(',', $val['value']) . '之一', 0);
                } else if ($val['type'] == 'array') {
                    foreach ($param[$key] as $enumk => $enumv) {
                        if (!in_array($enumv, $val['value']))
                            throw new Exception('api:' . $api . ' ' . '字段' . $key . '值只能为' . implode(',', $val['value']) . '之一', 0);
                    }
                }
            }

            // 当某个字段等于特定值时，该字段为必填字段
            if (isset($val['required_if'])) {
                if (is_scalar($val['required_if']['val']) && $param[$val['required_if']['key']] == $val['required_if']['val'] && empty($param[$key]))
                    throw new Exception('api:' . $api . ' ' . $key . '字段在' . $val['required_if']['key'] . '=' . $val['required_if']['val'] . '时为必填字段', 0);
                else if (is_array($val['required_if']['val']) && in_array($param[$val['required_if']['key']], $val['required_if']['val']) && empty($param[$key]))
                    throw new Exception('api:' . $api . ' ' . $key . '字段在' . $val['required_if']['key'] . '等于' . implode(',', $val['required_if']['val']) . '之一时为必填字段', 0);
            }
        }
    }

}