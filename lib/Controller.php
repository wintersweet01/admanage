<?php

class Controller
{
    public $smarty, $out, $tpl = '', $outType = 'json';

    /**
     * REQUEST值
     *
     * @param mixed $name 支持字符串或者数组，如果是数据，需要递归检查，默认什么都不过滤
     * @param string $type 1) int integer 整形；2) float 浮点型；3) json传过来的数据为json数据；4) /.../需要符合正则；
     * @param string $default 如果取不到，默认值
     * @return string
     */
    protected function R($name, $type = '', $default = '')
    {
        return $this->getValue($name, $_REQUEST, $type, $default);
    }

    /**
     * GET值
     *
     * @param mixed $name 支持字符串或者数组，如果是数据，需要递归检查，默认什么都不过滤
     * @param string $type 1) int integer 整形；2) float 浮点型；3) json传过来的数据为json数据；4) /.../需要符合正则；
     * @param string $default 如果取不到，默认值
     * @return string
     */
    protected function get($name, $type = '', $default = '')
    {
        return $this->getValue($name, $_GET, $type, $default);
    }

    /**
     * POST值
     *
     * @param mixed $name 支持字符串或者数组，如果是数据，需要递归检查，默认什么都不过滤
     * @param string $type 1) int integer 整形；2) float 浮点型；3) json传过来的数据为json数据；4) /.../需要符合正则；
     * @param string $default 如果取不到，默认值
     * @return string
     */
    protected function post($name, $type = '', $default = '')
    {
        return $this->getValue($name, $_POST, $type, $default);
    }

    /*
     * 获得数据
     */
    /**
     * @param $name
     * @param $data
     * @param $type
     * @param $default
     * @return array|mixed|string
     */
    private function getValue($name, $data, $type, $default)
    {
        if (isset($data[$name])) {
            return $this->_ff($data[$name], $type, $default);
        } else {
            return $default;
        }
    }

    /*
     * 过滤函数
     */
    private function _ff($value, $type = '', $default = '')
    {
        if (is_array($value)) {
            return array_map(array($this, '_ff'), $value);
        } else {
            //系统自动转义的情况下需要将转义的字符串纠正回来
            if (get_magic_quotes_gpc()) {
                $value = stripslashes($value);
            }

            $isReg = preg_match("/^\/.*\/[a-z]*$/", $type) ? true : false;

            if (in_array($type, array('int', 'integer', 'float', 'string'))) {
                settype($value, $type);
                if (!$value) {
                    $value = $default;
                }
            } elseif ($type == 'json') {
                $value = json_decode($value, true);
                if (!$value) {
                    $value = array();
                }
                $value = json_encode($value);
            } elseif ($isReg) {
                if (!preg_match($type, $value)) {
                    $value = $default;
                }
            }
            return $value;
        }
    }


    /**
     * 调用smarty
     *
     * @param string $tpl 模板xxx.tpl或者xxx.html
     * @param bool $return 是否将结果作为一个变量返回
     * @param array $out 变量
     * @param string $tplDir 切换模板目录
     * @return bool|string
     * @throws Exception
     * @throws SmartyException
     */
    protected function view($tpl, $return = false, $out = null, $tplDir = TPL_DIR)
    {
        if (!$return) {
            $this->outType = '';
        }

        $appRoot = APP_ROOT;
        if (YX::$thisAppRoot) {
            $appRoot = YX::$thisAppRoot;
        }

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($appRoot . '/' . $tplDir);
        $this->smarty->setCompileDir(RUNTIME_DIR . '/' . CACHE_DIR);
        $this->smarty->setCacheDir(RUNTIME_DIR . '/' . CACHE_DIR);
        $this->smarty->setLeftDelimiter('<{');
        $this->smarty->setRightDelimiter('}>');
        $this->smarty->setErrorReporting(0);
        $this->smarty->setEscapeHtml(true);
        $this->smarty->setCaching(false);
        $this->smarty->setCompileCheck(true);
        $this->smarty->setCacheLifetime(0);

        //强制每次都编译模板
        if (TEST) {
            $this->smarty->setForceCompile(true);
        }

        $this->out = !is_null($out) ? $out : $this->out;
        if (!is_array($this->out)) {
            $this->out = array();
        }

        if (substr($tpl, -4) !== '.tpl' && substr($tpl, -5) !== '.html') {
            $tpl .= '.tpl';
        }
        if (is_array($out)) {
            $this->out = array_merge($this->out, $out);
        }
        foreach ($this->out as $name => $out) {
            $this->smarty->assign($name, $out);
        }

        //插件3.0 2018-11-30
        $this->smarty->registerPlugin('function', 'widgets', array($this, 'smarty_widgets'));

        if ($return) {
            $re = $this->smarty->fetch($tpl);
        } else {
            $this->smarty->display($tpl);
            $re = true;
        }
        return $re;
    }

    public function widgets($widgets, $type = 'query')
    {
        $this->smarty->assign('LAYOUT', $type);
        $this->smarty->display('widget/widgets.tpl');
    }

    public function smarty_widgets($param, $smarty)
    {
        $this->widgets($param['widgets'], 'query');
    }

    /**
     * 渲染
     */
    public function display()
    {
        if (empty($this->outType) || $this->outType == 'none' || $this->outType == 'string' || $this->outType == 'layout') {
            return;
        } elseif ($this->outType == 'json') {
            $this->json($this->out);
            return;
        } elseif ($this->outType == 'smarty') {
            if (empty($this->tpl)) {
                $ct = strtolower(YX::$ct);
                $ac = strtolower(YX::$ac);
                $this->tpl = "{$ct}/{$ac}.tpl";
            }

            $html5plus = 1;
            if (strpos($_SERVER['HTTP_USER_AGENT'], "Html5Plus") === false || in_array($_GET['ct'], array('index', 'base'))) {
                $html5plus = 0;
            }

            $menu = SrvAuth::getMenu();
            $watermark_url = LibUtil::create_watermark(SrvAuth::$name, SrvAuth::$cname);

            $this->out['__html5plus__'] = $html5plus;
            $this->out['__name__'] = SrvAuth::$name;
            $this->out['__menu__'] = $menu['menu'];
            $this->out['__first_menu__'] = $menu['first_menu'];
            $this->out['__first_menu_conf__'] = $menu['first_menu_conf'];
            $this->out['__watermark_url__'] = $watermark_url;
            $this->out['_cdn_static_dir_'] = CDN_STATIC_DIR;
            $this->out['_cdn_static_url_'] = CDN_STATIC_URL;

            $this->view($this->tpl);
        }
    }

    /**
     * 输出json或者jsonp字符串
     * @param mixed $out 变量
     * @param string $jsonCallback getJSON使用的name
     */
    protected function json($out = null, $jsonCallback = 'jsoncallback')
    {
        $this->outType = '';
        $callback = $this->get($jsonCallback, '/^\w+$/');
        if (!is_null($out)) {
            $value = $out;
        } else {
            $value = $this->out;
        }
        $value = json_encode($value);
        if ($callback) {
            echo "{$callback}({$value})";
        } else {
            echo $value;
        }
    }

    /*
     * 跳转
     */
    protected function Go($url, $type = 'php', $isTop = false)
    {
        if (!$type || $type == 'php') {
            header('Location: ' . $url);
        } else {
            $top = $isTop ? 'top.' : '';
            echo '<script type="text/javascript">' . $top . 'location.href="' . $url . '";</script>';
        }
        exit;
    }
}