<?php

class CtlBase extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvIndex();
    }

    public function index()
    {
        $this->outType = 'smarty';

        $this->out['__title__'] = '后台';
        $this->out['user'] = SrvAuth::$name;
        $this->out['message'] = $_SERVER['SERVER_ADDR'] == '127.0.0.1' ? '本地环境' : '生产环境';
        $this->out['server_ip'] = $_SERVER['SERVER_ADDR'];
        $this->out['client_ip'] = LibUtil::getIp();
        $this->tpl = 'index/index.tpl';
    }

    /**
     * 修改个人信息
     */
    public function modifyAdminInfo()
    {
        $user = $this->srv->getAdminInfo();
        if ($_POST) {
            $this->outType = 'none';
            $data = $this->post('data');
            parse_str($data, $_POST);
            $data = array(
                'password' => $this->post('password'),
                'password1' => $this->post('password1'),
                'password2' => $this->post('password2'),
                'name' => $this->post('name')
            );
            $this->srv->modifyAdminInfo($user, $data);
            exit();
        }

        $this->outType = 'smarty';
        $this->out['user'] = $user;
        $this->out['__title__'] = '修改密码';
        $this->tpl = 'index/modifyAdminInfo.tpl';
    }


    /**
     * 查询/保存用户详细信息
     */
    public function getUserInfo()
    {
        SrvAuth::checkPublicAuth('userInfo');

        $SrvPlatform = new SrvPlatform();
        if ($_POST) {
            $this->outType = 'none';

            $uid = (int)$this->post('uid', 'int', 0);
            if ($uid <= 0) {
                LibUtil::response('参数错误');
            }

            $user = $SrvPlatform->getUserInfoByUid($uid);
            if (empty($user)) {
                LibUtil::response('记录不存在');
            }

            $phone = trim($this->post('phone'));
            $name = trim($this->post('name'));
            $id_number = trim($this->post('id_number'));

            //有手机号查看权限但无编辑权限
            if (SrvAuth::checkPublicAuth('userPhone', false)) {
                if (!SrvAuth::checkPublicAuth('userPhoneEdit', false) && $user['phone'] !== $phone) {
                    LibUtil::response('您无编辑手机号权限');
                }
            }

            //身份证信息查看权限但无编辑权限
            if (SrvAuth::checkPublicAuth('userIdNumber', false)) {
                if (!SrvAuth::checkPublicAuth('userIdNumberEdit', false) && ($user['name'] !== $name || $user['id_number'] !== $id_number)) {
                    LibUtil::response('您无编辑身份信息权限');
                }
            }

            $data = array(
                'phone' => $phone,
                'name' => $name,
                'id_number' => $id_number
            );
            $SrvPlatform->saveUserInfo($uid, $data);
        } else {
            $this->outType = 'smarty';
            $keyword = trim($this->R('keyword'));

            $srvAd = new SrvAd();
            $this->out['data'] = $SrvPlatform->getUserInfo($keyword);
            $this->out['_games'] = $SrvPlatform->getAllGame(2);
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_pay_channel_types'] = LibUtil::config('ConfUnionChannel');
            $this->out['__title__'] = '用户信息';
            $this->tpl = 'index/user_info.tpl';
        }
    }

    /**
     * 解封禁用户
     */
    public function bandUser()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'json';
        $uid = $this->post('uid', 'int', 0);
        $status = $this->post('status', 'int', 0);
        $text = $this->post('text');

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->bandUser($uid, $status, $text);
    }

    /**
     * 踢用户下线
     */
    public function kickUser()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'json';
        $uid = $this->post('uid');

        $SrvPlatform = new SrvPlatform();
        $this->out = $SrvPlatform->kickUser($uid);
    }
}