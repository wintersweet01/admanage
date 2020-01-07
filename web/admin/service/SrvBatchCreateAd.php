<?php


class SrvBatchCreateAd
{
    protected $mod;
    protected $srv_jrtt;

    public function __construct()
    {
        $this->mod = new ModBatchCreateAd();
        $this->srv_jrtt = new SrvJrttAction();
    }

    /**
     * 批量创建广告
     * @param array $param
     * @return array
     */
    public function createAd(array $param)
    {
        if (empty($param['game_id']) || !is_numeric($param['game_id']))
            return ['code' => 'F', 'msg' => '请选择游戏包'];
        if (empty($param['image_list']))
            return ['code' => 'F', 'msg' => '请选择素材'];
        if (empty($param['user_id']))
            return ['code' => 'F', 'msg' => '请选择媒体账号'];
        if (empty($param['channel_id']) || !is_numeric($param['channel_id']))
            return ['code' => 'F', 'msg' => '请选择投放渠道'];
        if (empty($param['package_id']) || !is_numeric($param['package_id']))
            return ['code' => 'F', 'msg' => '请选择定向包id'];

        $param['create_time'] = $param['update_time'] = date('Y-m-d H:i:s');
        $batch_id = $this->mod->createAd($param);
        if ($batch_id) {
            $this->_pushAd2Platform($param, $batch_id);
        }
        return $batch_id ? ['code' => 'S', 'msg' => '创建成功'] : ['code' => 'F', 'msg' => '创建失败'];
    }

    private function _pushAd2Platform(array $data, $batch_id)
    {
        $mod_user = new ModChannelUserAuth();
        $mod_material = new ModAdMaterial();
        // 媒体账户信息
        $users = $mod_user->getUserById(json_decode($data['user_id'], true));
        // 定向包信息
        $package = $this->_getDirectionalPackage($data['package_id']);
        $srv = new SrvJrttAction();
        $store_data = [];
        if ($data['type'] == '1') { // 1个素材多个账户
            // 遍历选中用户
            foreach ($users as $user) {
                $store_data['header'] = ["Access-Token:{$user['access_token']}"];
                $material = $mod_material->getAdmaterialById($data['image_list'][0]);
                // TODO::关联转化包表
                $referral_link = $this->_getReferralLink($user['user_id'], $data['channel_id'], $data['game_id']);
                if (empty($referral_link)) {
                    return ['code' => 'F', 'msg' => '广告主ID：' . $user['account_id'] . '下没有未使用的推广链接资源'];
                }
                $ad_name = $material['name'] . '-' . date('Y-m-d') . '-' . $referral_link['name'] . '-' . uniqid();
                // 广告组参数
                $store_data['group_param'] = json_encode([
                    'advertiser_id' => (int)$user['account_id'],
                    'campaign_name' => $ad_name,
                    'operation' => $data['operation'] == '1' ? 'enable' : 'disable',
                    'budget_mode' => 'BUDGET_MODE_INFINITE', // 广告组预算类型，默认不限 允许值:"BUDGET_MODE_INFINITE","BUDGET_MODE_DAY"
                    'landing_type' => 'APP', // 推广目的默认为app
                    'unique_fk' => md5('ht_group_api_' . $ad_name),
                ]);

                // TODO::计划欠缺参数：pricing, bid
                $store_data['plan_param'] = [
                    'advertiser_id' => $user['account_id'],
                    'campaign_id' => 0, // 用0代替广告组id
                    'name' => $ad_name, // 命名规则：素材名称-日期-推广链名称-随机数字后缀（不允许重复）
                    'operation' => $data['operation'] == '1' ? 'enable' : 'disable',
                    'delivery_range' => $package['delivery_range'],  // 投放范围
                    'budget_mode' => $package['budget_mode'],
                    'budget' => $package['budget'],
                    'schedule_type' => $package['schedule_type'],
                    'pricing' => $package['pricing'], // CPM ，出价范围（单位元）: 4-100，日预算范围（单位元）：大于100，总预算范围：大于最低日预算乘投放天数
                    'flow_control_mode' => $package['flow_control_mode'],
                    'convert_id' => $referral_link['convert_id'], // 转化ID TODO::待关联
                    'hide_if_converted' => $package['hide_if_converted'],
                    'smart_bid_type' => $package['smart_bid_type'],
                    'audience_package_id' => 0, // 定向包ID 用0代替
                    'download_type' => $package['download_type'] ?: 'DOWNLOAD_URL',
                ];
                $store_data['plan_param']['delivery_range'] == 'UNION' && $store_data['plan_param']['union_video_type'] = $package['union_video_type'];
                if ($store_data['plan_param']['schedule_type'] == 'SCHEDULE_START_END') {
                    $store_data['plan_param']['start_time'] = $package['start_time'];
                    $store_data['plan_param']['end_time'] = $package['end_time'];
                }
                empty($package['schedule_time']) || $store_data['plan_param']['schedule_time']; // 投放时段
                in_array($package['pricing'], ['PRICING_CPC', 'PRICING_CPM', 'PRICING_CPV']) && $store_data['plan_param']['bid'] = $package['bid']; // 广告出价
                in_array($package['pricing'], ['PRICING_OCPM', 'PRICING_OCPC', 'PRICING_CPA']) && $store_data['plan_param']['cpa_bid'] = $package['cpa_bid'];
                $store_data['plan_param']['unique_fk'] = md5('ht_plan_api_' . $ad_name);
                if ($store_data['plan_param']['download_type'] == 'DOWNLOAD_URL') {
                    $store_data['plan_param']['download_url'] = $referral_link['download_url']; // 下载链接
                    $store_data['plan_param']['app_type'] = $referral_link['platform'] == 1 ? 'APP_IOS' : 'APP_ANDROID';
                    $store_data['plan_param']['package'] = $referral_link['package_name'];
                }
                $store_data['plan_param']['download_type'] == 'EXTERNAL_URL' && $store_data['plan_param']['download_url'] = $referral_link['external_url']; // 下载链接
                $store_data['plan_param'] = json_encode($store_data['plan_param']);

                // 创意数据
                $store_data['creative'] = [
                    'advertiser_id' => $user['account_id'],
                    'ad_id' => 0, // 计划id,用0代替
                    'inventory_type' => $package['inventory_type'],
                    'ad_keywords' => $package['ad_keywords'],
                    'third_industry_id' => $package['third_industry_id'],
                    'creative_display_mode' => $package['creative_display_mode'],
                    'is_comment_disable' => $package['is_comment_disable'],
                    'generate_derived_ad' => $package['generate_derived_ad'],
                    'is_presented_video' => $package['is_presented_video'],
                    'creative_material_mode' => 'STATIC_ASSEMBLE', // 程序化创意
                ];

                if ($package['smart_inventory'] == '1') { // 优选广告
                    $store_data['creative']['smart_inventory'] = 1;
                } else if (!empty($package['inventory_type'])) { // 创意投放位置
                    $store_data['creative']['inventory_type'] = $package['inventory_type'];
                } else if (!empty($package['scene_inventory'])) { // 场景广告位
                    $store_data['creative']['scene_inventory'] = $package['scene_inventory'];
                }

                $package['download_type'] == 'EXTERNAL_URL' && $store_data['creative']['source'] = $package['source'];
                $store_data['creative']['title_list'] = $this->_getTitleList(json_decode($data['title_list'], true), 2); // TODO::需要修改数据格式
                $store_data['creative']['image_list'] = $this->_getImageList(json_decode($data['image_list'], true)); // TODO::需要修改数据格式
                $store_data['creative'] = json_encode($store_data['creative']);

            }
            // 创建广告创意
        } else if ($data['type'] == '2') { // 多个素材一个账户

        }

    }

    private function _getImageList(array $ids)
    {
        // 获取素材
        $mod = new ModAdMaterial();
        $materials = $mod->getByIds($ids);
        $material_types = LibUtil::config('ConfMaterial');
        var_dump($material_types);
        foreach ($materials as $item) {
            $mime_type = mime_content_type($item['file']);
            list($_type, $_extension) = explode('/', $mime_type);
            var_dump($_type, $_extension);
//            $this->srv_jrtt->uploadAdImg();
        }

    }


    /**
     *
     * @param array $ids
     * @param int $channel
     * @return array
     */
    private function _getTitleList(array $ids, int $channel)
    {
        $mod = new ModCopywriting();
        $result = $mod->getCopywritingByIds($ids, $channel);
        $titles = [];
        foreach ($result as $value) {
            $titles[] = ['title' => $value['content']];
        }
        return $titles;
    }

    /**
     * 获取推广链接
     * @param $user_id
     * @param $channel_id
     * @param $game_id
     * @return array|bool|resource|string
     */
    private function _getReferralLink($user_id, $channel_id, $game_id)
    {
        $mod = new ModAdProject();
        return $mod->getReferralLink($channel_id, $user_id, $game_id);
    }

    /**
     * 获取定向包信息
     * @param int $id
     * @return mixed
     */
    private function _getDirectionalPackage(int $id)
    {
        $mod = new ModDirectionalPackage();
        $result = $mod->getPackageById($id);
        return json_decode($result['content'], true);
    }

    private function _createAdPlan(array $user, int $campaign_id, string $material_name, string $referral_link_name, array $data)
    {
        $plan_param = [
            'advertiser_id' => $user['account_id'],
            'campaign_id' => $campaign_id,
            'name' => $material_name . '-' . date('Y-m-d') . '-' . $referral_link_name . '-' . uniqid(), // 命名规则：素材名称-日期-推广链名称-随机数字后缀（不允许重复）
            'operation' => $data['operation'] == '1' ? 'enable' : 'disable',
            'delivery_range' => '',  // 投放范围
        ];
    }

}