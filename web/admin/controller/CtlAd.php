<?php

class CtlAd extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvAd();
    }

    public function channelList()
    {
        SrvAuth::checkOpen('ad', 'channelList');
        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $this->out['data'] = $this->srv->getChannelList($page);
        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'channelList';
        $this->out['__title__'] = '渠道管理';
        $this->tpl = 'ad/channelList.tpl';
    }

    public function addChannel()
    {
        SrvAuth::checkOpen('ad', 'channelList');
        $this->outType = 'smarty';
        $channel_id = $this->R('channel_id', 'int', 0);
        if ($channel_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        $this->out['data']['info'] = $this->srv->getChannelInfo($channel_id);
        $this->out['data']['channel_id'] = $channel_id;
        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'channelList';
        $this->out['__title__'] = '添加/修改渠道';
        $this->tpl = 'ad/addChannel.tpl';
    }

    public function addChannelAction()
    {
        SrvAuth::checkOpen('ad', 'channelList');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $channel_id = $this->post('channel_id', 'int', 0);

        if ($channel_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $data = array(
            'channel_name' => $this->post('channel_name'),
            'channel_short' => $this->post('channel_short'),
            'logo' => $this->post('logo')
        );
        $this->out = $this->srv->addChannelAction($channel_id, $data);
    }

    public function getAllMonitor()
    {
        $this->outType = 'json';
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $create_user = $this->R('create_user');
        $this->out = $this->srv->getAllMonitor($game_id, $channel_id, $create_user);
    }

    public function adCompany()
    {
        SrvAuth::checkOpen('ad', 'adCompany');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);

        $this->out['data'] = $this->srv->getAdCompanyList($page);

        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'adCompany';
        $this->out['__title__'] = '广告资质公司管理';
        $this->tpl = 'ad/companyList.tpl';
    }

    public function addAdCompany()
    {
        SrvAuth::checkOpen('ad', 'adCompany');

        $this->outType = 'smarty';
        $company_id = $this->R('company_id', 'int', 0);
        if ($company_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $this->out['data']['info'] = $this->srv->getAdCompanyInfo($company_id);
        $this->out['data']['company_id'] = $company_id;

        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'adCompany';
        $this->out['__title__'] = '添加/修改广告资质公司';
        $this->tpl = 'ad/addAdCompany.tpl';
    }

    public function addAdCompanyAction()
    {
        SrvAuth::checkOpen('ad', 'adCompany');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $company_id = $this->post('company_id', 'int', 0);
        if ($company_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        $data = array(
            'company_name' => trim($this->post('company_name')),
            'record_no' => trim($this->post('record_no')),
            'www' => trim($this->post('www')),
            'domain' => trim($this->post('domain')),
            'icp' => trim($this->post('icp')),
            'service_tel' => trim($this->post('service_tel')),
            'address' => trim($this->post('address')),
        );
        $this->out = $this->srv->addAdCompanyAction($company_id, $data);
    }

    public function upload()
    {
        $this->outType = 'json';
        $file = $this->get('name', 'string', 'file');
        $this->out = $this->srv->upload($file);
    }

    public function upload2()
    {
        $this->outType = 'json';
        $this->out = $this->srv->upload('file2', array('.zip'));
    }

    public function deliveryGroup()
    {
        SrvAuth::checkOpen('ad', 'deliveryGroup');
        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $this->out['data'] = $this->srv->getDeliveryGroup($page);
        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'deliveryGroup';
        $this->out['__title__'] = '投放组管理';
        $this->tpl = 'ad/deliveryGroup.tpl';
    }

    public function addDeliveryGroup()
    {
        SrvAuth::checkOpen('ad', 'deliveryGroup');
        $this->outType = 'smarty';
        $group_id = $this->R('group_id', 'int', 0);
        if ($group_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        $this->out['data']['info'] = $this->srv->getDeliveryGroupInfo($group_id);
        $this->out['data']['group_id'] = $group_id;
        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'deliveryGroup';
        $this->out['__title__'] = '添加/修改投放组';
        $this->tpl = 'ad/addDeliveryGroup.tpl';
    }

    public function addDeliveryGroupAction()
    {
        SrvAuth::checkOpen('ad', 'deliveryGroup');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $group_id = $this->post('group_id', 'int', 0);

        if ($group_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $data = array(
            'group_name' => $this->post('group_name'),
        );
        $this->out = $this->srv->addDeliveryGroupAction($group_id, $data);
    }

    public function deliveryUser()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');
        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);

        $channel_id = $this->R('channel_id', 'int', 0);
        $user_id = $this->R('user_id', 'int', 0);
        $group_id = $this->R('group_id', 'int', 0);

        $groups = [];
        $tmp = $this->srv->getAllDeliveryGroup();
        foreach ($tmp as $v) {
            $groups[$v['group_id']] = $v['group_name'];
        }

        $this->out['data'] = $this->srv->getDeliveryUser($page, $channel_id, $user_id, $group_id);
        $this->out['_channels'] = $this->srv->getAllChannel();
        $this->out['_groups'] = $groups;
        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'deliveryUser';
        $this->out['__title__'] = '投放账号管理';
        $this->tpl = 'ad/deliveryUser.tpl';
    }


    public function addDeliveryUser()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');
        $this->outType = 'smarty';
        $user_id = $this->R('user_id', 'int', 0);
        if ($user_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $this->out['_channels'] = $this->srv->getAllChannel();
        $this->out['_groups'] = $this->srv->getAllDeliveryGroup();
        $srvExtend = new SrvExtend();
        $this->out['_companys'] = $srvExtend->getAllCompany();

        $this->out['data']['info'] = $this->srv->getDeliveryUserInfo($user_id);
        $this->out['data']['user_id'] = $user_id;
        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'deliveryUser';
        $this->out['__title__'] = '添加/修改投放账号';
        $this->tpl = 'ad/addDeliveryUser.tpl';
    }

    public function addDeliveryUserAction()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $user_id = $this->post('user_id', 'int', 0);

        if ($user_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $data = array(
            'company_id' => $this->post('company_id', 'int', 0),
            'channel_id' => $this->post('channel_id', 'int', 0),
            'user_name' => trim($this->post('user_name')),
            'sign_key' => trim($this->post('sign_key')),
            'encrypt_key' => trim($this->post('encrypt_key')),
            'group_id' => $this->post('group_id', 'int', 0),
            'domain' => trim($this->post('domain')),
            'download_domain' => trim($this->post('download_domain')),
            'media_account' => trim($this->post('media_account')),
            'media_account_pwd' => trim($this->post('media_account_pwd')),
        );
        $this->out = $this->srv->addDeliveryUserAction($user_id, $data);
    }

    public function getAllPage()
    {
        $this->outType = 'json';
        $srvExtend = new SrvExtend();
        $result = $srvExtend->getAllPage();
        foreach ($result as &$v) {
            $v['page_url'] = CDN_URL . $v['page_url'] . '/';
        }
        $this->out = $result;
    }

    public function getGamePackage()
    {
        $this->outType = 'json';
        $game_id = rtrim($_POST['game_id'], ',');
        $channel_id = rtrim($_POST['channel_id'], ',');

        $this->out = $this->srv->getGamePackage($game_id, $channel_id);
    }

    public function getGamePackages()
    {
        $this->outType = 'json';
        $game_id = rtrim($_POST['game_id'], ',');
        $channel_id = rtrim($_POST['channel_id'], ',');

        $this->out = $this->srv->getGamePackages($game_id, $channel_id);
    }

    /**
     * 刷新渠道授权
     */
    public function channelRefreshUserAuth()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');

        $this->outType = 'json';

        $user_id = $this->R('user_id', 'int', 0);
        $this->out = $this->srv->channelRefreshUserAuth($user_id);
    }

    /**
     * 获取数据源列表
     */
    public function channelUserAppList()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $user_id = $this->R('id', 'int', 0);

        $this->out['data'] = $this->srv->channelUserAppList($page, $user_id);
        $this->out['__on_menu__'] = 'ad';
        $this->out['__on_sub_menu__'] = 'deliveryUser';
        $this->out['__title__'] = '数据源管理';
        $this->tpl = 'ad/channelUserAppList.tpl';
    }

    /**
     * 创建数据源
     */
    public function channelAddUserApp()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');

        $user_id = $this->R('id', 'int', 0);
        $row = $this->srv->getChannelUserAuthInfo($user_id);
        if (empty($row)) {
            exit('获取授权信息失败');
        }

        $client_id = trim($row['client_id']);
        $account_id = trim($row['account_id']);

        if ($_POST) {
            $this->outType = 'json';
            $data = array(
                'client_id' => $client_id,
                'account_id' => $account_id,
                'type' => trim($this->post('type')),
                'mobile_app_id' => trim($this->post('mobile_app_id')),
                'description' => trim($this->post('description')),
            );
            $this->out = $this->srv->channelAddUserAppAction($row, $data);
        } else {
            $this->outType = 'smarty';
            $this->out['id'] = $user_id;
            $this->out['client_id'] = $client_id;
            $this->out['account_id'] = $account_id;
            $this->out['__on_menu__'] = 'ad';
            $this->out['__on_sub_menu__'] = 'deliveryUser';
            $this->out['__title__'] = '创建数据源';
            $this->tpl = 'ad/channelAddUserApp.tpl';
        }
    }

    /**
     * 获取数据源
     */
    public function channelGetUserApp()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');

        $this->outType = 'json';
        $user_id = $this->R('id', 'int', 0);
        $this->out = $this->srv->channelGetUserApp($user_id);
    }

    /**
     * 更新数据源缓存
     */
    public function clearCacheChannelUserApp()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');

        $this->outType = 'json';

        $user_id = $this->R('id', 'int', 0);
        $this->out = $this->srv->clearCacheChannelUserApp($user_id);
    }

    /**
     * 更新投放账号缓存
     */
    public function clearCacheChannelUser()
    {
        SrvAuth::checkOpen('ad', 'deliveryUser');
        $this->outType = 'json';
        $this->out = $this->srv->clearCacheChannelUser();
    }
}