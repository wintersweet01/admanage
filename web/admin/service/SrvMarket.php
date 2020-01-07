<?php

class SrvMarket
{
    private $mod;
    public static $tokenKey = 'hthy-$#@$';

    public function __construct()
    {
        $this->mod = new ModMarket();
    }

    /**
     * 新增账号
     * @param int $aId
     * @param array $data
     * @return array
     */
    public function addAccount($aId, $data)
    {
        $mediaCnf = LibUtil::config('market_media');
        if (empty($aId) && (empty($data['media']) || empty($mediaCnf[$data['media']]))) {
            return LibUtil::retData(false, [], '配置不存在');
        }
        if (empty($aId) && empty($data['account'])) {
            return LibUtil::retData(false, [], '请填写媒体账号');
        }
        if (empty($aId) && empty($data['account_password'])) {
            return LibUtil::retData(false, [], '请填写媒体账号密码');
        }
        if (!empty($aId)) {
            if (is_numeric($aId)) {
                $accountInfo = $this->mod->getAccountInfo($aId);
                if (empty($accountInfo)) {
                    return LibUtil::retData(false, [], '找不到该记录');
                }
            } else {
                return LibUtil::retData(false, [], '账号[' . $aId . ']错误');
            }
        }
        $data['account_nickname'] = trim($data['account_nickname']);
        $data['account'] = trim($data['account']);
        $data['app_pub'] = !empty($data['app_pub']) ? array_unique(array_filter($data['app_pub'])) : '';
        $data['manager'] = !empty($data['manager']) ? array_unique(array_filter($data['manager'])) : array(SrvAuth::$id);
        $ret = $this->mod->addAccount($aId, $data);
        if ($ret) {
            $key = md5($ret . self::$tokenKey);
            $url = '/?ct=system&ac=mediaAccountManage&aid=' . $ret . '&token=' . $key . '&tm=' . time();
            return LibUtil::retData(true, ['url' => $url], '成功');
        }
        return LibUtil::retData(false, [], '提交失败');
    }

    /**
     * 账号列表
     * @param array $data
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function accountList($data, $page, $limit)
    {
        $page = $page < 1 ? 1 : $page;
        $is_run = $data['is_run'];
        $account = $data['account'];
        $data = $this->mod->accountList($is_run, $account, $page, $limit);
        $channelCnf = LibUtil::config('market_media');
        foreach ($data['list'] as &$row) {
            $row['media_name'] = $channelCnf[$row['media']];
            $row['balance'] = number_format($row['balance'] / 100, 2);
            $row['balance_warn'] = number_format($row['balance_warn'] / 100, 2);
            $row['day_cost'] = number_format($row['cost'] / 100, 2);
            $key = md5($row['account_id'] . self::$tokenKey);
            $row['token_url'] = '/?ct=system&ac=mediaAccountManage&aid=' . $row['account_id'] . '&token=' . $key . '&tm=' . time();
        }
        $query = array();
        $query['is_run'] = $is_run;
        $query['account'] = $account;
        $data['query'] = $query;
        return $data;
    }

    /**
     * 获取账号信息 Libchannel::mediaAccountInfo($id)
     * @param int/array $aderId
     * @return array;
     */
    public function mediaAccountInfo($aderId)
    {
        if (empty($aderId)) {
            return array();
        }
        $data = $this->mod->getaccountinfo($aderId);
        return $data;
    }

    /**
     * 获取账号权限
     * @param int $aid
     * @return array
    */
    public function accountPowerInfo($aid)
    {
        $data = $this->mod->getAccountInfo($aid);
        $admins = SrvAuth::allAuth();
        $apps = $this->getAllApp();
        $data['manager'] = json_decode($data['manager'],true);
        $data['app_pub'] = json_decode($data['app_pub'],true);
        $manager = $app = array();
        foreach ($data['manager'] as $key){
            $manager[$key] = $admins[$key]['name'];
        }
        foreach ($data['app_pub'] as $k){
            $app[$k] = $apps[$k]['app_name'];
        }
        $ret['manager'] = $manager;
        $ret['app'] = $app;
        return LibUtil::retData(true,$ret,'获取成功');
    }

    /**
     * 授权账号
     * @param int $aid
     */
    public function authorize($aid)
    {
        $aid = (int)$aid;
        if (empty($aid)) {
            die('账号不存在');
        }
        $accountInfo = $this->mod->getAccountInfo($aid);
        $mediaCnfMap = LibUtil::config('market_media_map');
        if (!empty($accountInfo) && !empty($accountInfo['media'])) {
            $class = $mediaCnfMap[$accountInfo['media']]['market_name'];
            if (empty($class)) {
                die('媒体未配置或不存在');
            }
            $param['client_id'] = $accountInfo['media'];
            $param['aid'] = $accountInfo['account_id'];
            LibUtil::runIO($class, 'authorize', $param);
        }
    }

    /**
     * 刷新授权
     * @param int $aid
     * @return array
     */
    public function refreshToken($aid)
    {
        if (empty($aid) || !is_numeric($aid)) {
            return LibUtil::retData(false, [], '账号不存在');
        }
        $accountInfo = $this->mod->getAccountInfo($aid);
        if (empty($accountInfo) || empty($accountInfo['media'])) {
            return LibUtil::retData(false, [], '账号未配置');
        }
        if (!$accountInfo['refresh_token']) {
            return LibUtil::retData(false, [], '账号未授权');
        }
        $mediaCnfMap = LibUtil::config('market_media_map');
        $class = $mediaCnfMap[$accountInfo['media']]['market_name'];
        if (empty($class)) {
            return LibUtil::retData(false, [], '媒体未配置或不存在');
        }
        $param = array();
        $param['client_id'] = $accountInfo['media'];
        $param['aid'] = $accountInfo['account_id'];
        $res = LibUtil::runIO($class, 'refreshToken', $param);
        if ($res) {
            $ret = false;
            if (!empty($res['access_token']) && !empty($res['refresh_token'])) {
                $result = $res;
                $result['authorizer_info'] = json_encode($result['authorizer_info']);
                $result['account_id'] = $accountInfo['account_id'];
                $result['time'] = time();
                /**---特殊 start---*/
                $result['advertiser_id'] = $accountInfo['advertiser_id'];
                $result['client_id'] = $accountInfo['media'];
                /**---特殊 end---*/
                $ret = $this->mod->refreshToken($accountInfo['account_id'], $accountInfo['media'], $result);
            }
            if ($ret) {
                return LibUtil::retData(true, $res, '刷新授权成功');
            }
            return LibUtil::retData(false, [], '刷新过快，请稍后重试');
        }
        return LibUtil::retData(false, [], '刷新授权失败，请重新获取授权');
    }

    /**
     * @param string $field ;
     * @param float $value ;
     * @param int/array $aid
     * @return array
     */
    public function balanceWarnEdit($field, $value, $aid)
    {
        $keyMap = array('balance_warn');
        if (!in_array($field, $keyMap)) {
            return LibUtil::retData(false, [], '参数错误');
        }
        if (empty($aid)) {
            return LibUtil::retData(false, [], '记录不存在');
        }
        $value = $value * 100;
        $ret = $this->mod->balanceWarnEdit($field, $value, $aid);
        if ($ret) {
            return LibUtil::retData(true, ['count' => $ret], '更新成功');
        } else {
            return LibUtil::retData(false, [], '更新失败');
        }
    }

    /**
     * 获取所有媒体账号 widgets
     * @param boolean $is_run 仅有效
     * @return array;
     */
    public function getAllMediaAccount($is_run = false)
    {
        $data = $this->mod->getAllMediaAccount($is_run);
        //$mediaCnfMap = LibUtil::config('market_media_map');
        $mediaCnf = LibUtil::config('market_media');
        $backData = array();
        foreach ($data as $row) {
            $temp = array();
            $mediaName = $mediaCnf[$row['media']];
            $mediaAccStr = $mediaName . "-" . $row['account'];
            if ($row['account_nickname']) {
                $mediaAccStr .= "(" . $row['account_nickname'] . ")";
            }
            $temp['value'] = $row['account_id'];
            $temp['title'] = $mediaAccStr;
            array_push($backData, $temp);
        }
        return $backData;
    }

    /**
     * 应用列表
     * @param array $data
     * @param int $page
     * @param int $limitNum
     * @return array
     */
    public function appManageList($data, $page, $limitNum)
    {
        $page = $page < 1 ? 1 : $page;
        $is_run = $data['status'];
        $app_name = $data['app_name'];
        $data = $this->mod->getAppList($is_run, $app_name, $page, $limitNum);
        foreach ($data['list'] as &$row) {
            $row['device_type_name'] = $row['device_type'] == 1 ? 'IOS' : ($row['device_type'] == 2 ? '安卓' : '不限');
            $row['status_info'] = $row['status'] == 1 ? '无效' : '有效';
        }
        $query = array();
        $query['is_run'] = $is_run;
        $query['app_name'] = $app_name;
        $data['query'] = $query;
        return $data;
    }

    /**
     * 添加应用
     * @param int $appid ;
     * @param array $data
     * @param array $tdata // 媒体账号集合
     * @return array
     */
    public function appAdd($appid, $data, $tdata)
    {
        $tdata = array_unique(array_filter($tdata));
        $mediaAccountInfo = $this->mod->getAccountInfo($tdata);
        if (empty($tdata) || empty($mediaAccountInfo)) {
            return LibUtil::retData(false, [], '请勾选媒体账号至右表');
        }
        $mediaAccount = array_keys(array_column($mediaAccountInfo, null, 'account_id'));
        if (!empty($data)) {
            if (empty($data['app_name'])) {
                return LibUtil::retData(false, [], '请填写应用名称');
            }
            if (empty($data['app_code'])) {
                return LibUtil::retData(false, [], '请填写应用编码');
            }
            $ret = $this->mod->appAddMod($appid, $data, $mediaAccount);
            if ($ret) {
                return LibUtil::retData(true, [], '提交成功');
            } else {
                return LibUtil::retData(false, [], '失败');
            }
        } else {
            return LibUtil::retData(false, [], '请填写必要（*）参数');
        }
    }

    /**
     * 获取所有应用列表
     * @return array
     */
    public function getAllApp()
    {
        $row = $this->mod->AllApp();
        $row = array_column($row, null, 'appid');
        return $row;
    }

    /**
     * 获取应用信息
     * @param int $appid
     * @return array
     */
    public function getAppInfo($appid)
    {
        $appid = (int)$appid;
        if (empty($appid)) {
            return array();
        }
        $row = $this->mod->getAppInfo($appid);
        $row['media_account'] = unserialize($row['media_account']);
        return $row;
    }

    /**
     * ADIO列表
     * @param array $data
     * @param int $page
     * @param int $limitNum
     * @return array
     */
    public function adioList($data, $page, $limitNum)
    {
        $page = $page < 1 ? 1 : $page;
        $is_run = $data['is_run'];
        $account_name = $data['account_name'];
        $data = $this->mod->adioList($page, $limitNum, $is_run, $account_name);
        foreach ($data['list'] as &$row) {
            $row['status_info'] = $row['status'] == 0 ? '有效' : '无效';
            $row['media_account'] = unserialize($row['media_account']);
        }
        $query = array();
        $query['is_run'] = $is_run;
        $query['account_name'] = $account_name;
        $data['query'] = $query;
        return $data;
    }

    /**
     * 添加组
     * @param string $name
     * @return array
     */
    public function addGroup($name, $code)
    {
        if (empty($name) || empty($code)) {
            return LibUtil::retData(false, [], '请输入组名称');
        }
        $name = trim($name);
        $ret = $this->mod->addGroupMod($name, $code);
        if ($ret) {
            return LibUtil::retData(true, ['name' => $name, 'code' => $code, 'id' => $ret], '添加成功');
        } else {
            return LibUtil::retData(false, [], '添加失败');
        }
    }

    /**
     * 获取所有组
     * @return array
     */
    public function getAllAdioGroup()
    {
        $row = $this->mod->getAllAdioGroup();
        return $row;
    }

    /**
     * 添加ADIO账号
     * @param int $id
     * @param array $data
     * @param array $mediaAccount
     * @return array
     */
    public function adioAdd($id, $data, $mediaAccount)
    {
        if (empty($data) || empty($mediaAccount)) {
            return LibUtil::retData(false, [], '请填写必要*选项');
        }
        $pathen = '/^[A-Za-z0-9]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';
        $ret = preg_match($pathen, $data['email']);
        if (empty($data['email']) || !$ret) {
            return LibUtil::retData(false, [], '请填写邮箱账号');
        }
        if (empty($data['adio_role'])) {
            return LibUtil::retData(false, [], '请勾选账号角色');
        }
        if (empty($data['adio_group'])) {
            return LibUtil::retData(false, [], '请选择分组');
        }
        $mediaAccountRow = $this->mod->getAccountInfo($mediaAccount);
        if (empty($mediaAccountRow)) {
            return LibUtil::retData(false, [], '请选择媒体账号');
        }
        $mediaAccount = array_keys(array_column($mediaAccountRow, null, 'account_id'));
        $ret = $this->mod->adioAdd($id, $data, $mediaAccount);
        if ($ret) {
            return LibUtil::retData(true, [], '成功');
        }
        return LibUtil::retData(false, [], '失败');
    }

    /**
     * 获取ADIO账号信息
     * @param int $id
     * @return array
     */
    public function getAdioInfo($id)
    {
        if (empty($id)) {
            return array();
        }
        $row = $this->mod->getAdioInfo($id);
        if (!empty($row)) {
            $row['media_account'] = unserialize($row['media_account']);
            return $row;
        }
        return array();
    }

    /**
     * 更新token信息
     * @param int $aid
     * @param array $data
     * @return boolean
    */
    public function updateTokenInfoByaId($aid,$data)
    {
        if(empty($aid)){
            return false;
        }
        $res = $this->mod->updateTokenInfo($aid,$data);
        return $res;
    }
}

?>