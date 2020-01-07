<?php

/** 自动推广后台系统管理模块 */
class CtlSystem extends Controller
{
    private $srv = null;

    public function __construct()
    {
        $this->srv = new SrvMarket();
    }

    //媒体账号管理
    public function mediaAccountManage()
    {
        SrvAuth::checkOpen('system', 'mediaAccountManage');
        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';
            $data = $this->R('data');
            parse_str($data, $param);
            $page = $this->R('page', 'int', 0);
            $limit = $this->R('limit', 'int');
            $row = $this->srv->accountList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'msg' => '',
                'data' => $row['list'],
                'query' => $row['query'],
                'count' => $row['count'],
            );
        } else {
            $this->outType = 'smarty';
            $aid = $this->get('aid', 'int', 0);
            $tm = $this->get('tm', 'int');
            $token = $this->get('token', 'string', '');
            $signToken = md5($aid . SrvMarket::$tokenKey);
            if ($aid && $tm && ($token == $signToken)) {
                $this->srv->authorize($aid);
            }
            $this->out['limit_num'] = DEFAULT_ADMIN_PAGE_NUM;
            $this->out['__on_menu__'] = 'system';
            $this->out['__on_sub_menu__'] = 'mediaAccountManage';
            $this->out['__title__'] = '媒体账号管理';
            $this->tpl = 'system/account.tpl';
        }
    }

    //添加媒体账号
    public function mediaAccountAdd()
    {
        SrvAuth::checkOpen('system', 'mediaAccountManage');
        $account_id = $this->R('account_id', 'int', 0);
        $data = [];
        if ($account_id) {
            $data = $this->srv->mediaAccountInfo($account_id);
            $data['app_pub'] = json_decode($data['app_pub'], true);
            $data['manager'] = json_decode($data['manager'], true);
        }
        $mediaConf = LibUtil::config('market_media');
        $allApp = $this->srv->getAllApp();
        $admins = SrvAuth::allAuth(true);
        $this->outType = 'smarty';
        $this->out['login_admin'] = SrvAuth::$id;
        $this->out['account_id'] = $account_id;
        $this->out['media_conf'] = $mediaConf;
        $this->out['apps'] = $allApp;
        $this->out['admins'] = $admins;
        $this->out['__on_menu__'] = 'system';
        $this->out['__on_sub_menu__'] = 'mediaAccountManage';
        $this->out['__title__'] = '添加媒体账号';
        $this->out['data'] = $data;
        $this->tpl = 'system/accountadd.tpl';
    }

    public function mediaAccountAddAction()
    {
        SrvAuth::checkOpen('system', 'mediaAccountManage');
        $account_id = $this->R('account_id', 'int', 0);
        if ($account_id) {
            SrvAuth::checkPublicAuth('edit');
        }
        $this->outType = 'json';
        $paramData = array(
            'media' => $this->post('media', 'string', ''),
            'account' => $this->post('account', 'string', ''),
            'account_password' => $this->post('account_password', 'string', ''),
            'account_nickname' => $this->post('account_nickname', 'string', ''),
            'app_pub' => $this->post('app_pub'),
            'manager' => $this->post('manager'),
            'status' => $this->post('status', 'int', 0),
        );
        $this->out = $this->srv->addAccount($account_id, $paramData);
    }

    //查看账号权限
    public function viewAccountPower()
    {
        SrvAuth::checkOpen('system','mediaAccountManage');
        $data = $this->post('data');
        $this->outType = 'json';
        if(empty($data['account_id'])){
            $this->out = LibUtil::retData(false,[],'获取失败，找不到该记录');
        }
        $this->out = $this->srv->accountPowerInfo($data['account_id']);
    }

    //批量设置账户余额预警线
    public function balanceWarnAddBatch()
    {
        SrvAuth::checkOpen('system', 'meidaAccountManage');
        SrvAuth::checkPublicAuth('edit');
        $accountids = $this->R('account_ids', 'string', '');
        if ($_POST) {
            $this->outType = 'json';
            $data = $this->post('data');
            parse_str($data, $param);
            $accountids = explode(',', $param['account_ids']);
            $func = function ($v) {
                return (int)$v;
            };
            $accountids = array_unique(array_filter(array_map($func, $accountids)));
            $ret = $this->srv->balanceWarnEdit('balance_warn', $param['fee'], $accountids);
            $this->out = $ret;
        } else {
            $mediaCnf = LibUtil::config('market_media');
            $accountidsArr = explode(',', $accountids);
            $accountsInfo = $this->srv->mediaAccountInfo($accountidsArr);
            $this->outType = 'smarty';
            $this->out['account_ids'] = $accountids;
            $this->out['accounts_list'] = $accountsInfo;
            $this->out['media_conf'] = $mediaCnf;
            $this->out['__title__'] = '媒体账号管理';
            $this->out['__on_menu__'] = 'system';
            $this->out['__on_sub_menu__'] = 'mediaAccountManage';
            $this->tpl = 'system/balancewarn.tpl';
        }
    }

    //重新授权
    public function reauthorize()
    {
        SrvAuth::checkOpen('system', 'meidaAccountManage');
        SrvAuth::checkPublicAuth('edit');
        $data = $this->post('data');
        $this->outType = 'json';
        if (!is_array($data) || empty($data) || empty($data['account_id']) || empty($data['advertiser_id'])) {
            $this->out = LibUtil::retData(false, [], '请填写广告主ID');
        }

    }

    //刷新token
    public function refreshToken()
    {
        SrvAuth::checkOpen('system', 'mediaAccountManage');
        SrvAuth::checkPublicAuth('edit');
        $data = $this->post('data');
        $this->outType = 'json';
        if (!is_array($data) || empty($data) || empty($data['account_id'])) {
            $this->out = LibUtil::retData(false, [], '刷新失败，该账号不存在');
        }
        $this->out = $this->srv->refreshToken((int)$data['account_id']);
    }

    //更新账号余额预警线
    public function editBalanceWarn()
    {
        SrvAuth::checkOpen('system', 'mediaAccountManage');
        SrvAuth::checkPublicAuth('edit');
        $this->outType = 'json';
        $field = $this->R('field');
        $value = $this->R('value', 'float', 0);
        $data = $this->R('data');
        $this->out = $this->srv->balanceWarnEdit($field, $value, $data['account_id']);
    }

    //应用管理列表
    public function appManage()
    {
        SrvAuth::checkOpen('system', 'appManage');
        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';
            $data = $this->R('data');
            $page = $this->R('page', 'int', 0);
            $limit = $this->R('limit', 'int', DEFAULT_ADMIN_PAGE_NUM);
            parse_str($data, $param);
            $row = $this->srv->appManageList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'msg' => '',
                'data' => $row['list'],
                'count' => $row['count'],
                'query' => $row['query'],
            );
        } else {
            $this->outType = 'smarty';
            $this->out['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
            $this->out['__title__'] = '应用管理列表';
            $this->out['__on_menu__'] = 'system';
            $this->out['__on_sub_menu__'] = 'appManage';
            $this->tpl = 'system/appmanage.tpl';
        }
    }

    //新增应用
    public function appAdd()
    {
        SrvAuth::checkOpen('system', 'appManage');
        $appid = $this->R('appid', 'int', 0);
        $data = array();
        if ($appid) {
            SrvAuth::checkPublicAuth('edit');
            $data = $this->srv->getAppInfo($appid);
        }
        $allMediaAccount = $this->srv->getAllMediaAccount();
        $widgets = array(
            'media_account' => array(
                'type' => 'media_account',
                'data' => $allMediaAccount,
                'values' => $data['media_account'],
                'show_search' => true,
                'width' => 350,
                'id' => 'account_chan'
            )
        );
        $this->outType = 'smarty';
        $this->out['widgets'] = $widgets;
        $this->out['__title__'] = '新增应用';
        $this->out['__on_menu__'] = 'system';
        $this->out['__on_sub_menu__'] = 'appManage';
        $this->out['data'] = $data;
        $this->out['platform'] = PLATFORM;
        $this->tpl = 'system/appadd.tpl';
    }

    public function appAddAction()
    {
        SrvAuth::checkOpen('system', 'appManage');
        $this->outType = 'json';
        $data = $this->R('data');
        $tdata = $this->R('tdata', 'string', '');
        parse_str($data, $param);
        if (!empty($param['appid'])) {
            SrvAuth::checkPublicAuth('edit');
        }
        $tdata = json_decode($tdata, true);
        $this->out = $this->srv->appAdd($param['appid'], $param, $tdata);
    }

    //ADIO列表
    public function adioManage()
    {
        SrvAuth::checkOpen('system', 'adioManage');
        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';
            $data = $this->R('data');
            $page = $this->R('page', 'int', 0);
            $limit = $this->R('limit', 'int', DEFAULT_ADMIN_PAGE_NUM);
            parse_str($data, $param);
            $row = $this->srv->adioList($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'msg' => '',
                'data' => $row['list'],
                'count' => $row['count'],
                'query' => $row['query']
            );
        } else {
            $this->outType = 'smarty';
            $this->out['__title__'] = 'ADIO管理';
            $this->out['__on_menu__'] = 'system';
            $this->out['__on_sub_menu__'] = 'adioManage';
            $this->tpl = 'system/adiomanage.tpl';
        }
    }

    //新增ADIO账号
    public function adioAdd()
    {
        SrvAuth::checkOpen('system', 'adioManage');
        $id = $this->R('id', 'int', 0);
        $data = array();
        if ($id) {
            SrvAuth::checkPublicAuth('edit');
            $data = $this->srv->getAdioInfo((int)$id);
        }
        $allMediaAccount = $this->srv->getAllMediaAccount();
        $allGroup = $this->srv->getAllAdioGroup();
        $widgets = array(
            'media_account' => array(
                'type' => 'media_account',
                'data' => $allMediaAccount,
                'values' => $data['media_account'],
                'show_search' => true,
                'width' => 350,
                'id' => 'account_chan'
            ),
        );
        $is_admin = SrvAuth::$id == 1 ? true : false;
        $this->outType = 'smarty';
        $this->out['data'] = $data;
        $this->out['id'] = $id;
        $this->out['widgets'] = $widgets;
        $this->out['groups'] = $allGroup;
        $this->out['is_admin'] = $is_admin;
        $this->out['__title__'] = '新增ADIO账号';
        $this->out['__on_menu__'] = 'system';
        $this->out['__on_sub_menu__'] = 'adioManage';
        $this->tpl = 'system/adioadd.tpl';
    }

    public function adioAddAction()
    {
        SrvAuth::checkOpen('system', 'adioManage');
        $data = $this->post('data');
        $tdata = $this->post('tdata');
        parse_str($data, $param);
        $tdata = json_decode($tdata);
        if ($param['id']) {
            SrvAuth::checkPublicAuth('edit');
        }
        $ret = $this->srv->adioAdd($param['id'], $param, $tdata);
        $this->out = $ret;
    }

    //添加组
    public function addGroup()
    {
        SrvAuth::checkOpen('system', 'adioManage');
        $this->outType = 'json';
        if (SrvAuth::$id !== 1) {
            $this->out = LibUtil::retData(false, [], '仅管理员可操作');
        } else {
            $groupName = $this->post('data', 'string', '');
            $groupConde = $this->post('code', 'string', '');
            $this->out = $this->srv->addGroup($groupName, $groupConde);
        }
    }
}

?>