<?php

class CtlIndex extends Controller
{

    /**
     * 主页面
     */
    public function index()
    {
        $this->outType = 'smarty';
        if (SrvAuth::checkLogin()) {
            $this->Go('?ct=base');
        }

        $this->out['isNeedCaptcha'] = SrvAuth::isNeedCaptcha();
        $this->out['title'] = '后台';
        $this->tpl = 'index/login.tpl';
    }

    /**
     * 登录
     */
    public function login()
    {
        $name = $this->post('username');
        $password = $this->post('password');
        $captcha = $this->post('code');
        $keep = $this->post('keep', 'int', 0);

        $srvAuth = new SrvAuth();
        $result = $srvAuth->login($name, $password, $captcha, $keep);
        if ($result === true) {
            LibUtil::response('登录成功，正在跳转...', 1);
        } else {
            LibUtil::response($result, 0, array('isNeedCaptcha' => SrvAuth::isNeedCaptcha()));
        }
    }

    /**
     * 退出
     */
    public function logout()
    {
        SrvAuth::logout();
        $this->Go('?ct=index');
    }

    /**
     * 后台客户端升级检查
     */
    public function update()
    {
        $appid = $this->get('appid');
        $version = $this->get('version'); //客户端版本号

        $rsp = array('status' => 0);//默认返回值，不需要升级
        if (isset($appid) && isset($version)) {
            if ($appid == "__W2A__ht.sdk.hutao.net") {//校验appid
                if ($version !== "1.0") {
                    $rsp['status'] = 1;
                    $rsp['title'] = "应用更新";
                    $rsp['note'] = "修复bug1；\n修复bug2;";//release notes，支持换行
                    $rsp['url'] = "http://www.example.com/wap2app.apk";//应用升级包下载地址
                }
            }
        }
        exit(json_encode($rsp));
    }
}