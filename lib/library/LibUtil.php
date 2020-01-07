<?php

class LibUtil
{
    private static $allLoadConfig = array();

    /**
     * 防xss
     * @param $string
     * @param bool|False $low
     * @return bool
     */
    public static function clean_xss(&$string, $low = False)
    {
        if (!is_array($string)) {
            $string = trim($string);
            $string = strip_tags($string);
            $string = htmlspecialchars($string);
            if ($low) {
                return True;
            }
            $string = str_replace(array('"', "\\", "'", "/", "..", "../", "./", "//"), '', $string);
            $no = '/%0[0-8bcef]/';
            $string = preg_replace($no, '', $string);
            $no = '/%1[0-9a-f]/';
            $string = preg_replace($no, '', $string);
            $no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
            $string = preg_replace($no, '', $string);
            return True;
        }
        $keys = array_keys($string);
        foreach ($keys as $key) {
            self::clean_xss($string [$key]);
        }
    }

    /*
     * 获得/写入配置
     */
    public static function config($name, $value = null, $isTxt = false, $approot = '')
    {
        if (!$name) {
            return false;
        }
        $file = '';
        if (preg_match('/[.\/\\\]/', $name)) {
            $file = $name;
        }

        $cacheConfig = false;
        if (!$file) {
            if (!preg_match('/^conf/i', $name)) {
                $file = RUNTIME_DIR . '/' . CONF_DIR . '/' . $name . '.php';
                $cacheConfig = true;
            } else {
                $name = preg_replace('/^conf/i', '', $name);
                $configPath = ucfirst($name);

                $appRoot = APP_ROOT;
                if (YX::$thisAppRoot) {
                    $appRoot = YX::$thisAppRoot;
                }
                if ($approot) {
                    $appRoot = $approot;
                }
                $file = $appRoot . '/' . CONF_DIR . '/Conf' . $configPath . '.php';
            }
        }

        //读取
        $re = false;
        if (is_null($value)) {
            if (!empty(self::$allLoadConfig[$name])) {
                return self::$allLoadConfig[$name];
            }
            if (is_file($file)) {
                $re = include $file;
                self::$allLoadConfig[$name] = $re;
            } else {
                Debug::log('配置文件：' . $file . '不存在，返回false', 'warn');
            }
        } else {//写入
            if ($cacheConfig) {
                $dir = dirname($file);
                if (!is_dir($dir)) {
                    if (!mkdir($dir, 0777, true)) {
                        Debug::log('配置文件：' . $dir . '创建目录失败', 'warn');
                    }
                }
                if ($isTxt) {
                    $save = $value;
                } else {
                    $save = var_export($value, true);
                    $save = "<?php\r\n/*本文件由程序自动生成（" . date('Y-m-d H:i:s') . "）*/\r\nreturn {$save};";
                }

                $re = file_put_contents($file, $save);
                if (!$re) {
                    Debug::log('配置文件：' . $file . '写入失败', 'warn');
                }
            } else {
                Debug::log('Conf开头的配置为只读文件，不能写入', 'warn');
            }

        }
        return $re;
    }

    public static function _request($url, $data = array(), $timeout = 30, $hostIp = '', $userHeader = array(), $proxy = '', $isCookie = false, $files = array())
    {
        $isDebug = Debug::check();
        if ($isDebug) {
            $sTime = microtime(true);
        }

        $url = trim($url);
        if (empty($url)) {
            return array('code' => '0');
        }
        $curl = curl_init();
        $header = array(
            'Accept-Language: zh-cn',
            'Connection: Keep-Alive',
            'Cache-Control: no-cache'
        );

        if (!empty($hostIp)) {
            $urlInfo = parse_url($url);
            $url = str_replace($urlInfo['host'], $hostIp, $url);
            $header[] = "Host: {$urlInfo['host']}";
        }
        if ($userHeader) {
            $header = array_merge($header, $userHeader);
        }

        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        if ($isCookie) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, '/tmp/curl_cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, '/tmp/curl_cookie.txt');
        }


        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'R2Games 1.0.0 (curl) ');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if ($timeout > 0) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        }

        curl_setopt($curl, CURLINFO_HEADER_OUT, true);//header

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//自动跳转


        $isPost = false;
        $isFile = false;
        if (!empty($data)) {
            $isPost = true;
        }
        if (!empty($files)) {
            foreach ($files as $name => $file) {
                $data[$name] = curl_file_create(realpath($file['path']), $file['type'], $file['name']);
            }
            $isPost = false;
            $isFile = true;
        }

        file_put_contents('/tmp/aaaa.log', var_export($isPost, true) . '---' . var_export($data, true), FILE_APPEND);
        if ($isPost) {
            if (is_array($data)) $data = http_build_query($data);
            curl_setopt($curl, CURLOPT_POST, true);//这玩意一定要写在CURLOPT_POSTFIELDS前面
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if ($isFile) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        if ($isDebug) {
            curl_setopt($curl, CURLOPT_HEADER, true);
        }


        $result['result'] = curl_exec($curl);
        $responseHeader = '';

        if ($isDebug) {//调试模式下输出头部
            $contents = explode("\r\n\r\n", $result['result']);

            $_contents = array();
            foreach ($contents as $content) {
                if (strpos($content, 'HTTP/1.1 100') !== 0 && strpos($content, 'HTTP/1.1 302') !== 0 && strpos($content, 'HTTP/1.1 301') !== 0) {
                    $_contents[] = $content;
                }
            }
            $_contents = implode("\r\n\r\n", $_contents);
            list($responseHeader, $result['result']) = explode("\r\n\r\n", $_contents, 2);;
        }

        $result['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($result['result'] === false) {
            $result['result'] = curl_error($curl);
            $result['code'] = -curl_errno($curl);
        }


        if ($isDebug) {
            $tInfo = curl_getinfo($curl);
            $info['request'] = array(
                'url' => $tInfo['url'],
                'header' => $tInfo['request_header'],
            );
            if ($data) {
                $info['request']['post'] = $data;
            }
            $info['response'] = array(
                'header' => $responseHeader,
                'result' => $result['result'],
                'code' => $result['code'],
            );

            $eTime = microtime(true);
            list($file, $line) = Debug::getPosition();
            $t = round($eTime - $sTime, 3);
            Debug::addMsg('info', "CURL: {$url}（{$t}S，code={$result['code']}）", $file, $line);
            //Debug::addMsg('info', $info, $file, $line);
        }

        curl_close($curl);
        return $result;
    }

    public static function request($url, $data = array(), $timeout = 30, $hostIp = '', $userHeader = array(), $proxy = '', $isCookie = false, $files = array())
    {
        $url = trim($url);
        if (empty($url)) {
            return array('code' => '0');
        }
        $curl = curl_init();
        $header = array(
            'Accept-Language: zh-cn',
            'Connection: Keep-Alive',
            'Cache-Control: no-cache'
        );

        if (!empty($hostIp)) {
            $urlInfo = parse_url($url);
            $url = str_replace($urlInfo['host'], $hostIp, $url);
            $header[] = "Host: {$urlInfo['host']}";
        }
        if ($userHeader) {
            $header = array_merge($header, $userHeader);
        }

        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        if ($isCookie) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, '/tmp/curl_cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIE, $isCookie);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if ($timeout > 0) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        }

        curl_setopt($curl, CURLINFO_HEADER_OUT, true);//header

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//自动跳转


        $isPost = false;
        $isFile = false;
        if (!empty($data)) {
            $isPost = true;
        }
        if (!empty($files)) {
            foreach ($files as $name => $file) {
                $data[$name] = curl_file_create(realpath($file['path']), $file['type'], $file['name']);
            }
            $isPost = false;
            $isFile = true;
        }
        if ($isPost) {
            if (is_array($data)) $data = http_build_query($data);
            curl_setopt($curl, CURLOPT_POST, true);//这玩意一定要写在CURLOPT_POSTFIELDS前面
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if ($isFile) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $result['result'] = curl_exec($curl);
        $responseHeader = '';
        $result['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($result['result'] === false) {
            $result['result'] = curl_error($curl);
            $result['code'] = -curl_errno($curl);
        }

        curl_close($curl);
        return $result;
    }

    public static function requestByCookie($url, $data = array(), $timeout = 30, $hostIp = '', $userHeader = array(), $proxy = '', $isCookie = false, $files = array(), $cookie_file)
    {
        $url = trim($url);
        if (empty($url)) {
            return array('code' => '0');
        }
        $curl = curl_init();
        $header = array(
            'Accept-Language: zh-cn',
            'Connection: Keep-Alive',
            'Cache-Control: no-cache'
        );

        if (!empty($hostIp)) {
            $urlInfo = parse_url($url);
            $url = str_replace($urlInfo['host'], $hostIp, $url);
            $header[] = "Host: {$urlInfo['host']}";
        }
        if ($userHeader) {
            $header = array_merge($header, $userHeader);
        }
        Debug::log($header);
        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        if ($isCookie) {
            if ($cookie_file) {
                curl_setopt($curl, CURLOPT_COOKIEFILE, ROOT . '/cookie/' . $cookie_file . '.txt');
                curl_setopt($curl, CURLOPT_COOKIEJAR, ROOT . '/cookie/' . $cookie_file . '.txt');
            }
            curl_setopt($curl, CURLOPT_COOKIE, $isCookie);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

        if ($timeout > 0) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        }

        curl_setopt($curl, CURLINFO_HEADER_OUT, true);//header

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//自动跳转


        /*$isPost = false;
        $isFile = false;
        if (!empty($data)) {
            $isPost = true;
        }*/

        if (!function_exists('curl_file_create')) {
            function curl_file_create($filename, $mimetype = '', $postname = '')
            {
                return "@$filename;filename="
                    . ($postname ?: basename($filename))
                    . ($mimetype ? ";type=$mimetype" : '');
            }
        }

        if (!empty($files)) {
            foreach ($files as $name => $file) {
                $data[$name] = curl_file_create(realpath($file['path']), $file['type'], $file['name']);
            }
            //curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            /*$isPost = false;
            $isFile = true;*/
        }

        if (is_array($data) && !empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);//这玩意一定要写在CURLOPT_POSTFIELDS前面
            if (empty($files)) $data = http_build_query($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        /*if($isFile){
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }*/

        $result['result'] = curl_exec($curl);
        $responseHeader = '';

        $result['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($result['result'] === false) {
            $result['result'] = curl_error($curl);
            $result['code'] = -curl_errno($curl);
        }

        Debug::log($data);
        Debug::log($url);
        curl_close($curl);
        return $result;
    }

    public static function requestJSON($url, $data = array(), $timeout = 30, $hostIp = '', $userHeader = array(), $proxy = '', $isCookie = false, $files = array())
    {
        $url = trim($url);
        if (empty($url)) {
            return array('code' => '0');
        }
        $curl = curl_init();
        $header = array(
            'Accept-Language: zh-cn',
            'Connection: Keep-Alive',
            'Cache-Control: no-cache',
            'Content-Type: application/json',
        );

        if (!empty($hostIp)) {
            $urlInfo = parse_url($url);
            $url = str_replace($urlInfo['host'], $hostIp, $url);
            $header[] = "Host: {$urlInfo['host']}";
        }
        if ($userHeader) {
            $header = array_merge($header, $userHeader);
        }
        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        if ($isCookie) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, '/tmp/curl_cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, '/tmp/curl_cookie.txt');
        }


        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if ($timeout > 0) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        }

        curl_setopt($curl, CURLINFO_HEADER_OUT, true);//header

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//自动跳转


        $isPost = false;
        $isFile = false;
        if (!empty($data)) {
            $isPost = true;
        }
        if (!empty($files)) {
            foreach ($files as $name => $file) {
                $data[$name] = curl_file_create(realpath($file['path']), $file['type'], $file['name']);
            }
            $isPost = false;
            $isFile = true;
        }

        if ($isPost) {
            curl_setopt($curl, CURLOPT_POST, true);//这玩意一定要写在CURLOPT_POSTFIELDS前面
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if ($isFile) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $result['result'] = curl_exec($curl);
        $responseHeader = '';

        $result['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($result['result'] === false) {
            $result['result'] = curl_error($curl);
            $result['code'] = -curl_errno($curl);
        }

        curl_close($curl);
        return $result;
    }

    public static function getIp($type = 0)
    {
        $onlineip = '';
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_REAL_IP') && strcasecmp(getenv('HTTP_X_REAL_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_X_REAL_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ips = getenv('HTTP_X_FORWARDED_FOR');
            $tmp = explode(',', $ips);
            $onlineip = trim($tmp[0]);
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }

        preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $onlineip, $onlineipmatches);
        $onlineip = isset($onlineipmatches[0]) ? $onlineipmatches[0] : 'unknown';
        if ($type == 1)
            $onlineip = ip2long($onlineip);
        return $onlineip;
    }

    public static function tableSplit($id)
    {
        $dbIndex = floor($id / 100000000);
        $tplIndex = floor($id % 100);
        return array($dbIndex, $tplIndex);
    }

    /**
     * 参数替换
     * @param string $format
     * @param array $data
     * @return string
     */
    public static function replaceValue($format, $data)
    {
        $pattern1 = '/<\{\$([^\|\>]*)\|?([^\>]*)?\}>/ei';

        $format = @preg_replace($pattern1, 'self::replaceRun(\'\$$1|$2\',$data)', $format);
        while (substr_count($format, '<{') > 0 && substr_count($format, '}>') > 0) {
            $_m = -1;
            for ($x = strpos($format, '<{'); $x < strlen($format) - 1; $x++) {
                if ($format[$x] . $format[$x + 1] == '<{') {
                    $_m = $x;
                }

                if ($format[$x] . $format[$x + 1] == '}>' && $_m >= 0) {
                    $code = substr($format, $_m + 2, $x - $_m - 2);
                    $format = substr($format, 0, $_m) . self::replaceRun($code) . substr($format, $x + 2);
                    $_m = -1;
                }
            }
            //$format = preg_replace('/<{((.((?<!<{)[^|](?!}>))+.)(\|((.(?!}>))*.))?)}>/ei', '$5(\'$2\')', $format);
        }

        return $format;
    }

    //可以使用的函数
    private static $allowFunction = array(
        'strtolower' => 1,
        'strtoupper' => 1,
        'urlencode' => 1,
        'urldecode' => 1,
        'serialize' => 1,
        'ip2long' => 1,
        'long2ip' => 1,
        'md5' => 1,
        'substr' => 1,
        'json_decode' => 1,
        'json_encode' => 1,
        'stripcslashes' => 1,
        'addcslashes' => 1,
        'htmlspecialchars_decode' => 1,
        'rawurlencode' => 1,
        'base64_encode' => 1,
    );

    private static function replaceRun($code, $data = array())
    {
        if (empty($code)) {
            return '';
        }
        $code = explode('|', $code);
        if ($code[0][0] == '$') {
            $code[0] = !isset($data[substr($code[0], 1)]) ? "" : $data[substr($code[0], 1)];
        }
        if (empty($code[1])) {
            return $code[0];
        } else {
            $code[1] = explode(":", $code[1]);
            if (empty(self::$allowFunction[$code[1][0]])) {
                return "{$code[1][0]}not allow";
            }
            if (!empty($code[1][1])) {
                $code[0] .= "','" . implode("','", explode(',', $code[1][1]));
            }
            $_s = '';
            eval("\$_s = {$code[1][0]}('{$code[0]}');");
            return $_s;
        }
    }

    //  获得唯一的SessionID
    public static function getSid()
    {
        return base_convert(sprintf('%u',
                crc32(self::getIp() . ' ' . (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''))), 10, 36) .
            '-' . base_convert(microtime(true) * 100, 10, 36) .
            '-' . base_convert(mt_rand(0, 38885), 10, 36);
    }

    public static function defaultValue($value, $default)
    {
        return $value ? $value : $default;
    }

    public static function error($code, $msg, $e = null)
    {
        return array("code" => $code, "msg" => $msg);
    }

    public static function isError($error)
    {
        return is_array($error) && isset($error['code']) && $error['code'] >= 1;
    }

    // 根据IP获取地区信息
    public static function getCityInfo($ip = '')
    {
        if (empty ($ip)) {
            $ip = self::getIp();
        }
        require_once(LIB . "/library/ip/geoipcity.inc");

        if (empty($GEOIP_REGION_NAME)) {
            require(LIB . "/library/ip/geoipregionvars.php");
        }
        $gi = geoip_open(LIB . "/library/ip/GeoLiteCity.dat", GEOIP_STANDARD);

        $record = geoip_record_by_addr($gi, $ip);
        $ipinfo = array('ip' => '', 'code' => 'unknown', 'country' => 'unknown', 'state' => 'unknown', 'city' => 'unknown');
        $ipinfo['ip'] = $ip;
        if ($record) {
            $ipinfo['code'] = $record->country_code;
            $ipinfo['country'] = $record->country_name;
            $ipinfo['state'] = $GEOIP_REGION_NAME[$record->country_code][$record->region];
            $ipinfo['city'] = $record->city;
        }
        geoip_close($gi);
        return $ipinfo;
    }

    public static function arrayCopy(&$target, $targetKey, &$source, $sourceKey, $isset = true)
    {
        if (!$isset || isset($source[$sourceKey])) {
            $target[$targetKey] = $source[$sourceKey];
        }
    }

    // 对象转化为数组函数
    public static function objectsIntoArray($arrObjData, $arrSkipIndices = array())
    {
        $arrData = array();
        if (is_object($arrObjData)) {
            $arrObjData = get_object_vars($arrObjData);
        }
        if (is_array($arrObjData)) {
            foreach ($arrObjData as $index => $value) {
                if (is_object($value) || is_array($value)) {
                    $value = self::objectsIntoArray($value, $arrSkipIndices); // recursive
                    // call
                }
                if (in_array($index, $arrSkipIndices)) {
                    continue;
                }
                $arrData [$index] = $value;
            }
        }
        return $arrData;
    }

    public static function multi2SingleArray($array, &$return, $preKey)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $new = $preKey ? $preKey . "-" . $k : $k;
                if (is_array($v)) {

                    $newReturn = self::multi2SingleArray($v, $return, $new);
                    $return = $return + $newReturn;
                } else {
                    $return[$new] = $v;
                }
            }
        }
        return $return;
    }

    public static function toTimeZone($src, $from_tz = 'Etc/GMT+3', $to_tz = 'Asia/Shanghai', $fm = 'Y-m-d H:i:s')
    {
        $datetime = new DateTime($src, new DateTimeZone($from_tz));
        $datetime->setTimezone(new DateTimeZone($to_tz));
        return $datetime->format($fm);
    }

    public static function getPeriodInterval($period)
    {
        switch ($period) {
            case "annually":
                return 86400 * 365;
            case "annual":
                return 86400 * 365;
            case "monthly":
                return 86400 * 30;
            case "quarterly":
                return 86400 * 30 * 3;
            case "semiannually":
                return 86400 * 180;
            default:
                return 0;
        }
    }

    /**
     * 字符串hash成数值
     * @param $secret 字符串
     * @param int $num 最大值
     * @return float hash值
     */
    public static function getHash($secret, $num = 100)
    {
        $count = 0;
        $max = strlen($secret) >= 8 ? 8 : strlen($secret);
        $hashSeeds = str_split(substr($secret, 0, $max), 1);
        if (is_array($hashSeeds)) {
            foreach ($hashSeeds as $char) {
                $count += ord($char);
            }
        }
        return floor($count % $num);
    }

    /**
     * 数值hash成数值
     * @param $secret 原始数值
     * @param int $num 最大值
     * @return float hash值
     */
    public static function getIntHash($int, $num = 100)
    {
        return floor($int % $num);
    }

    public static function getQueryPath()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $pos = strpos($requestUri, "?");
        return substr($requestUri, 0, $pos ? $pos : strlen($requestUri));
    }


    public static function checkUA()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($ua, 'Mobile') === false || stripos($ua, 'iPad') !== false) {
            return 'PC';
        } else {
            if (stripos($ua, 'Android') !== false) {
                return 'Android';
            }
            if (stripos($ua, 'iPhone') !== false) {
                return 'IOS';
            }
            return 'PC';
        }
    }

    public static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return strtolower(trim(com_create_guid(), '{}'));
        }

        return strtolower(sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)));
    }

    public static function isEmail($data)
    {
        $data = trim($data);
        return preg_match("/^\w+([\.-]\w+)*@\w+([\.-]\w+)*\.\w+([-\.]\w+)*$/", $data);
    }


    /**
     * 检查字符串是否是UTF8状态
     * @param $str
     * @return int
     */
    public static function isUtf8($str)
    {
        return preg_match('%^(?:
		 [\x09\x0A\x0D\x20-\x7E]            # ASCII
	   | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
	   |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
	   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
	   |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
	   |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
	   | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
	   |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
        )*$%xs', $str);
    }

    /*
     * 转成UTF8
     */
    public static function forceUtf8($org)
    {
        if (!is_array($org)) {
            return self::isUtf8($org) ? $org : iconv('GBK', 'UTF-8', $org);
        } else {
            foreach ($org as $k => $v) {
                $org[$k] = self::forceUtf8($v);
            }
            return $org;
        }
    }

    /*
     * 追加到文件中
     */
    public static function file_append_contents($filename, $str)
    {
        if (strlen($str) <= 8192) {
            return file_put_contents($filename, $str, FILE_APPEND);
        }

        $fp = fopen($filename, 'a');
        if (!empty($fp)) {
            stream_set_chunk_size($fp, 2147483647);
            fwrite($fp, $str);
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }

    public static function myTrim($data)
    {
        if (is_array($data)) {
            foreach ($data as &$_data) {
                $_data = self::myTrim($_data);
            }
        } elseif (is_string($data)) {
            $data = trim($data);
        }
        return $data;
    }

    public static function getUrl()
    {
        $url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    public static function getSalt($len)
    {
        if ($len > 32) {
            $len = 32;
        }
        return substr(md5(microtime(true) . mt_rand(100000, 999999)), 0, $len);
    }

    public static function makePwd($salt, $password)
    {
        return md5(md5($salt . $password . $salt) . $password . $salt);
    }

    public static function retData($state = true, $data = array(), $msg = '', $extend = array())
    {
        if ($state) {
            $re = array(
                'state' => 1,
                'data' => $data,
                'msg' => $msg,
            );
        } else {
            $re = array(
                'state' => 0,
                'msg' => $msg,
            );
            if ($data) {
                $re['data'] = $data;
            }
        }
        if ($extend) {
            $re = array_merge($extend, $re);
        }

        return $re;
    }

    public static function strSplit($string, $len = 1)
    {
        $start = 0;
        $str_len = mb_strlen($string);
        while ($str_len) {
            $array[] = mb_substr($string, $start, $len, "utf8");
            $string = mb_substr($string, $len, $str_len, "utf8");
            $str_len = mb_strlen($string);
        }
        return $array;
    }

    public static function getRequestUrlNoXss()
    {
        $script = $_SERVER['SCRIPT_NAME'];
        $param = trim($_SERVER['QUERY_STRING']);
        if ($param == '') {
            return $script;
        }
        $params = explode('&', $param);
        foreach ($params as &$p) {
            self::clean_xss($p);
        }
        $param = join('&amp;', $params);
        return $script . '?' . $param;
    }

    public static function makeOrderNum()
    {
        $time = explode('.', microtime(true));
        $time[1] = str_pad(substr($time[1], 0, 3), 3, 0, STR_PAD_RIGHT);
        $order = date('y', $time[0]) * 12 + date('m', $time[0]);
        $order .= date('d', $time[0]);
        $order .= substr($time[0], 5, 5);
        $order .= $time[1];
        return $order;
    }

    public static function getXOR($data, $key, $string = '')
    {
        $len = strlen($data);
        $len2 = strlen($key);
        for ($i = 0; $i < $len; $i++) {
            $j = $i % $len2;
            $string .= ($data[$i]) ^ ($key[$j]);
        }
        return $string;
    }

    /**
     * 列出目录列表
     * @param $dir
     * @return array
     */
    static public function getDir($dir)
    {
        if (substr($dir, -1) != '/') {
            $dir = $dir . '/';
        }

        $dirArray = [];
        if (false != ($handle = opendir($dir))) {
            while (false !== ($file = readdir($handle))) {
                //去掉"“.”、“..”以及带“.xxx”后缀的文件
                if ($file != "." && $file != ".." && is_dir($dir . $file)) {
                    $dirArray[] = $file;
                }
            }
            //关闭句柄
            closedir($handle);
        }
        return $dirArray;
    }

    /**
     * 递归目录下所有文件，并返回带路径的文件名
     * @param $dir
     * @return array
     */
    static public function getDirFile($dir)
    {
        //static的作用：仅在第一次调用函数的时候对变量进行初始化，并且保留变量值
        static $result = array();
        if (is_dir($dir)) {
            if (substr($dir, -1) != '/') {
                $dir = $dir . '/';
            }

            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != "..") {
                        $dirr = $dir . $file;
                        if (is_dir($dirr)) {
                            self::getDirFile($dirr . '/');
                        } else {
                            $result[] = $dirr;
                        }
                    }
                }
                closedir($dh);
            }
        }
        return $result;
    }

    /**
     * 刪除目录
     * @param $dir
     */
    public static function delDir($dir)
    {
        if (file_exists($dir)) {
            $dp = opendir($dir);
            while (false !== ($file = readdir($dp))) {
                if (($file != '.') && ($file != '..')) {
                    $full = $dir . '/' . $file;
                    if (is_dir($full)) {
                        self::delDir($full);
                    } else {
                        unlink($full);
                    }
                }
            }
            closedir($dp);
            rmdir($dir);
        }
    }

    /**
     * JSON格式返回
     * @param string $msg
     * @param int $result
     * @param array $data
     * @param string $format
     * @param bool $end
     * @return array
     */
    public static function response($msg = '', $result = 0, $data = array(), $format = 'json', $end = true)
    {
        $return = array(
            'code' => $result ? 1 : 0,
            'message' => $msg
        );

        if (!empty($data)) {
            $return['data'] = $data;
        }

        if ($format == 'json') {
            $callback = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : '';
            $json = json_encode($return);
            if ($callback) {
                header('Content-Type: text/javascript; charset=utf-8');
                echo $callback . '(' . $json . ');';
            } else {
                echo $json;
            }
        } else {
            return $return;
        }

        if ($end) {
            exit();
        }
    }

    /**
     * 数组格式返回
     * @param string $msg
     * @param int $result
     * @param array $data
     * @param string $format
     * @param bool $end
     * @return array
     */
    public static function responseData($msg = '', $result = 0, $data = array(), $format = 'json', $end = true)
    {
        return self::response($msg, $result, $data, 'return', false);
    }

    /**
     * 解压压缩包
     * @param null $zip
     * @param null $todir
     * @param null $entries
     * @return bool|string
     */
    public static function unzip($file_zip = null, $todir = null, $entries = null)
    {
        if (!is_file($file_zip) || !$todir) {
            return '参数错误';
        }
        if (!extension_loaded('zip')) {
            return 'php未开启zip扩展';
        }

        $zip = new ZipArchive();
        $res = $zip->open($file_zip);
        if ($res !== TRUE) {
            return '解压失败';
        }

        if ($entries) {
            $zip->extractTo($todir, $entries);
        } else {
            $zip->extractTo($todir);
        }
        $zip->close();

        return true;
    }

    /**
     * 生成压缩包
     * @param null $file_zip
     * @param array $data
     * @param bool $rename
     * @return bool|string
     */
    public static function zip($file_zip = null, $data = [], $rename = false)
    {
        if (!$file_zip || empty($data) || !is_array($data)) {
            return '参数错误';
        }
        if (!extension_loaded('zip')) {
            return 'php未开启zip扩展';
        }

        if (!is_dir(dirname($file_zip))) {
            mkdir(dirname($file_zip), 0775, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($file_zip, ZIPARCHIVE::CREATE) !== TRUE) {
            return '打包失败';
        }

        foreach ($data as $key => $val) {
            if ($rename) {
                $name = $key;
            } else {
                $name = basename($val);
            }
            $zip->addFile($val, $name);
        }

        $zip->close();

        return true;
    }

    /**
     * 格式化文件大小
     * @param $size
     * @return string
     */
    public static function formatBytes($size = 0)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
        return round($size, 2) . $units[$i];
    }

    /**
     * 格式化字节
     * @param $size
     * @param null $format
     * @param int $round
     * @return string
     */
    public static function readableSize($size, $format = null, $round = 3)
    {
        $mod = 1024;

        if (is_null($format)) {
            $format = '%.2f%s';
        }

        $units = explode(' ', 'B KB MB GB TB');

        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }

        if (0 === $i) {
            $format = preg_replace('/(%.[\d]+f)/', '%d', $format);
        }

        return sprintf($format, round($size, $round), $units[$i]);
    }

    /**
     * 格式化时间
     * @param $microtime
     * @param null $format
     * @param int $round
     * @return string
     */
    public static function readableElapsedTime($microtime, $format = null, $round = 3)
    {
        if (is_null($format)) {
            $format = '%.3f%s';
        }

        if ($microtime >= 1) {
            $unit = 's';
            $time = round($microtime, $round);
        } else {
            $unit = 'ms';
            $time = round($microtime * 1000);

            $format = preg_replace('/(%.[\d]+f)/', '%d', $format);
        }

        return sprintf($format, $time, $unit);
    }

    /**
     * 截取字符串
     * @param $text
     * @param $length
     * @return string
     */
    public static function subtext($text, $length)
    {
        if (mb_strlen($text, 'utf8') > $length)
            return mb_substr($text, 0, $length, 'utf8') . '...';
        return $text;
    }

    /**
     * 把数组以CSV格式写入文件
     *
     * @param string $filename
     * @param array $data
     * @return boolean
     */
    static public function write_to_csv($filename, $data, $charset = '', $download = false)
    {
        if (!$filename)
            return false;
        if (empty($data) || !is_array($data))
            return false;

        if (is_array(current($data))) {
            foreach ($data as $v) {
                self::write_to_csv($filename, $v, $charset, $download);
            }
        } else {
            $fp = fopen($filename, 'a');
            if ($download || flock($fp, LOCK_EX)) { // 进行排它型锁定
                if ($charset) {
                    $data = self::convert_encode('utf-8', $charset, $data);
                }
                fputcsv($fp, $data);
                flock($fp, LOCK_UN); // 释放锁定
            }
            fclose($fp);
        }
        return true;
    }

    static public function down_csv($data)
    {
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        header('Pragma: no-cache');
        header('Content-type: text/csv');
        header('Content-Encoding: none');
        header('Content-Disposition: attachment; filename=' . $data['file'] . '.csv');
        header('Content-type: csv');

        self::write_to_csv('php://output', $data['head'], 'gbk', true);
        self::write_to_csv('php://output', $data['data'], 'gbk', true);
    }

    static public function convert_encode($from, $to, $data, $check = false)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::convert_encode($from, $to, $v, $check);
            }
        } else {
            if ($check && mb_check_encoding($data, $to)) {
                return $data;
            }
            $data = function_exists('mb_convert_encoding') ? mb_convert_encoding($data, $to, $from) : iconv($from, $to, $data);
        }
        return $data;
    }

    /**
     * 生成TOKEN
     * @param string $prefix
     * @return string
     */
    static public function token($prefix = '')
    {
        return strtolower(md5(uniqid($prefix . rand(100000, 999999), true) . microtime(true)));
    }

    /**
     * 格式化两日期
     * @param $start_day
     * @param $end_day
     * @param bool $timestamp
     * @param int $max
     * @return array
     */
    static public function getDateFormat($start_day, $end_day, $timestamp = false, $max = 0)
    {
        $response = array(
            's' => '',
            'e' => '',
            'd' => 0
        );

        if (!$start_day || !$end_day) {
            return $response;
        }

        $now = date('Y-m-d');
        $n_t = strtotime($now);
        $s_t = strtotime($start_day);
        $e_t = strtotime($end_day);

        if (date('Y-m-d', $s_t) != $start_day || date('Y-m-d', $e_t) != $end_day) {
            return $response;
        }

        //开始时间大于结束时间
        if ($s_t > $e_t) {
            $end_day = $start_day;
            $e_t = $s_t;
        }
        //开始时间大于当前时间
        if ($s_t > $n_t) {
            $start_day = $now;
            $s_t = $n_t;
        }
        //结束时间大于当前时间
        if ($e_t > $n_t) {
            $end_day = $now;
            $e_t = $n_t;
        }

        $date_list_a1 = explode("-", $start_day);
        $date_list_a2 = explode("-", $end_day);
        $d1 = mktime(0, 0, 0, $date_list_a1[1], $date_list_a1[2], $date_list_a1[0]);
        $d2 = mktime(23, 59, 59, $date_list_a2[1], $date_list_a2[2], $date_list_a2[0]);
        $d = round(($d2 - $d1) / 3600 / 24);

        if ($max > 0 && $d > $max) {
            $e_t = strtotime($start_day . " +{$max} day");
            $end_day = date('Y-m-d', $e_t);
            $d = $max;
        }

        //时间戳形式返回
        if ($timestamp) {
            $start_day = $d1;
            $end_day = $d2;
        }

        return array(
            's' => $start_day,
            'e' => $end_day,
            'd' => (int)$d
        );
    }

    /**
     * 将cgi进程提前结束,让余下部分在结束后继续操作,减少用户等待时间
     * @param $func
     * @param array $params
     * @param bool $end
     */
    static public function shutdown_function($func, $params = array(), $end = false)
    {
        static $stack = array();

        if ($func) {
            $stack[] = array(
                'func' => $func,
                'params' => $params
            );
        }

        if ($end) {
            function_exists('fastcgi_finish_request') && fastcgi_finish_request();

            foreach ($stack as $v) {
                call_user_func_array($v['func'], $v['params']);
            }
        }
    }

    /**
     * 递归树结构-获取父结构
     *
     * @param $arr
     * @param int $id
     * @param int $level
     * @return array
     */
    private static function findChild(&$arr, $id = 0, $level = 0)
    {
        $childs = array();
        foreach ($arr as $k => $v) {
            if ($v['pid'] == $id) {
                $v['level'] = $level;

                $childs[] = $v;
            }
        }
        return $childs;
    }

    /**
     * 递归树结构
     *
     * @param $rows
     * @param $root_id
     * @param int $level
     * @return array|null
     */
    public static function build_tree($rows, $root_id, $level = 0)
    {
        $childs = self::findChild($rows, $root_id, $level);
        if (empty($childs)) {
            return null;
        }
        foreach ($childs as $k => $v) {
            $rescurTree = self::build_tree($rows, $v['id'], $level + 1);
            if (null != $rescurTree) {
                $childs[$k]['children'] = $rescurTree;
            }
        }
        return $childs;
    }

    /**
     * 封装print_r函数
     * @param $array
     */
    public static function pr($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    /**
     * 经典概率算法
     * @param $proArr array('a'=>10,'b'=>90)
     * @return int|string
     */
    public static function getRand($proArr)
    {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);             //抽取随机数
            if ($randNum <= $proCur) {
                $result = $key;                         //得出结果
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }

    /**
     * 获取SDK版本号，可用来做比较
     * @param string $v
     * @return int
     */
    public static function getVersion($v = '')
    {
        if (!$v) {
            return 0;
        }
        $tmp = explode('.', substr($v, 1));
        return (int)($tmp[0] . $tmp[1] . sprintf('%03d', $tmp[2]));
    }

    /**
     * 桥接到主库
     * @param $function
     * @param $data
     * @param bool $return
     * @return bool|mixed
     */
    public static function sync($function, $data, $return = false)
    {
        $url = COMMUNITY_DOMAIN . '?ac=' . $function;
        $string = LibCrypt::encode(json_encode($data), COMMUNITY_KEY);
        $param = array(
            'data' => $string
        );
        $result = self::request($url, $param);
        $json = json_decode($result['result'], true);
        if ($result['code'] == 200 && $json['state'] == 1) {
            return $return ? $json : true;
        }
        return $return ? $json : false;
    }

    /**
     * 获取子游戏集合
     * @param array $parentGame
     * @return array
     */
    public static function fetchChildrenGame($parentGame)
    {
        if (empty($parentGame)) {
            return array();
        }
        $gameParent = array();
        foreach ($parentGame as $key => $val) {
            $gameParent = array_merge($val['children'], $gameParent);
        }
        $gameParent = array_column($gameParent, null, 'id');
        ksort($gameParent);
        return $gameParent;
    }

    /**
     * 生成管理员水印
     * @param string $username
     * @param string $name
     * @return string|null
     */
    public static function create_watermark($username = '', $name = '')
    {
        if (!$username) {
            return null;
        }

        $water_file = "/{$username}.jpg";
        $save_dir = APP_ROOT . "/uploads/watermark/admin";
        $url_path = "/uploads/watermark/admin" . $water_file;
        if (!is_file($save_dir . $water_file)) {
            $width = 250;
            $height = 150;
            $name || $name = $username;

            //创建目录
            if (!is_dir($save_dir)) {
                mkdir($save_dir, 0775, true);
            }

            $img = imagecreate($width, $height);
            $bg_color = imagecolorallocate($img, 255, 255, 255);
            //字体要放要目录才行
            $font = LIB . "/font/CHYaHei.ttf";
            //$black = imagecolorallocatealpha($img,0,0,0, 127) ;
            $gray = imagecolorallocate($img, 238, 238, 238);
            imagettftext($img, 20, 30, 90, 90, $gray, $font, $name);
            imagettftext($img, 10, 30, 80, 120, $gray, $font, '上海葫桃科技有限公司');

            ob_start();
            imagejpeg($img);
            $contents = ob_get_clean();
            $sta = file_put_contents($save_dir . $water_file, $contents);
            imagedestroy($img);
        }
        return $url_path;
    }

    //计算某年第几周的周开始日期和周结束日期
    public static function weekStartEnd($year, $week)
    {
        $yearStart = mktime(0, 0, 0, 1, 1, $year);
        $yearEnd = mktime(0, 0, 12, 31, $year);
        //判断第一天是否为第一周
        if (intval(date('W', $yearStart)) === 1) {
            $start = $yearStart;//第一天就是第一周
        } else {
            $week++;
            $start = strtotime('+1 monday', $yearStart);//第一个周一作为开始
        }

        if ($week === 1) {
            $weekDay['start'] = $start;
        } else {
            $weekDay['start'] = strtotime('+' . ($week - 1) . ' monday', $start);
        }
        $weekDay['end'] = strtotime('+1 sunday', $weekDay['start']);//礼拜日6天后
        if (date('Y', $weekDay['end']) != $year) {
            //跨年情况
            $weekDay['end'] = $yearEnd;
        }
        return $weekDay;
    }

    //获取相近日期
    public static function nearDate($type, $typeValue)
    {
        $retDate = date('Y-m-d', time());
        switch ($type) {
            case 7:
                $retDate = $typeValue;
                break;
            case 9:
                $retDate = date('Y-m-01', strtotime($typeValue));
                break;
            case 10:
                $weekInfo = explode('-', $typeValue);
                $weekDate = self::weekStartEnd($weekInfo[0], $weekInfo[1]);
                $retDate = date('Y-m-d', $weekDate['start']);
                break;
            default:
                break;
        }
        return $retDate;
    }

    //获取请求参数
    public static function getParam($name = '', $default = '')
    {
        return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $default);
    }

    //获取当前请求的URL
    static public function requestUri()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ?
            'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    //构造请求参数
    public static function buildQueryData($data, $json = true, $sort = false)
    {
        if (empty($data)) return '';
        $sort && ksort($data);
        if ($json == false) {
            $dataArr = array();
            foreach ($data as $key => &$value) {
                empty($value) && $value = '';
                $value = trim($value);
                $str = $key . "=" . $value;
                array_push($dataArr, $str);
            }
            $dataStr = implode("&", $dataArr);
        } else {
            $dataStr = json_encode($data);
        }
        return $dataStr;
    }

    /**
     * 执行方法
     * @param string $className
     * @param string $methodName
     * @param array $paramData
     * @return unknow
     */
    public static function runIO(string $className, string $methodName, array $paramData = array())
    {
        $ret = null;
        $className = 'Srv' . ucfirst($className);
        try {
            $class = new ReflectionClass($className);//获取类
            $method = $class->getMethod($methodName);//获取类的方法
            if ($method && $class->isInstantiable()) {
                //判断方法是否存在且该类能否被实例化
                $obj = new $className();//实例化类
                $mthodobj = new ReflectionMethod($className, $methodName);//获取方法对象
                if ($mthodobj->isPublic()) {
                    if (!empty($paramData)) {
                        $ret = $mthodobj->invokeArgs($obj, $paramData);//带参数执行
                    } else {
                        $ret = $mthodobj->invoke($obj);//不带参数执行
                    }
                } else {
                    die('method was not a public-mentod');
                }
            } else {
                die('calss can not be new');
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return $ret;
    }

    public static function checkKeyMap($keyMap, $data)
    {
        $keys = array_keys($data);
        if (empty($keys)) return false;
        if (!array_diff($keyMap, $keys) && !array_diff($keys, $keyMap)) {
            return true;
        } else {
            return false;
        }
    }

    public static function curlRequest($url = '', $data = '', $method = 'get', $jsonHeader = [], $connectTimeout = 5, $readTimeout = 5)
    {
        $res = array();
        $method = strtolower($method);
        if ($method == 'get') {
            if (preg_match('/\?+/', $url)) {
                $url = $url . "&" . $data;
            } else {
                $url = $url . "?" . $data;
            }
        }

        if (function_exists('curl_init')) {
            $timeout = $connectTimeout + $readTimeout;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            if ($jsonHeader) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $jsonHeader);
            }
            if ($method == 'post') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else if ($method == 'get') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $result = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($result === false) {
                error_log('c=' . @$_GET['c'] . '&a=' . @$_GET['a'] . '&url=' . @$url . @curl_error($ch) . "\n", 3, 'curl_errors.log');
            }
            curl_close($ch);
            $res['header'] = $jsonHeader;
            $res['code'] = $code;
            $res['result'] = $result;
        } else {
            $res['header'] = $jsonHeader;
            $res['code'] = 500;
            $res['result'] = null;
        }
        return $res;
    }
}
