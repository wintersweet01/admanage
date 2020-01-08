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
        $package = json_decode($package['content'], true);
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
//                $store_data['plan_param'] = json_encode($store_data['plan_param']);

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
                $package['download_type'] == 'DOWNLOAD_URL' && $store_data['creative']['app_name'] = $package['app_name']; // TODO::应用名是拿游戏名称，还是需要自定义
                $store_data['plan_param']['app_type'] == 'APP_ANDROID' && $store_data['creative']['web_url'] = $data['web_url']; // TODO::需要对接橙子建站获取落地页地址
                $store_data['creative']['title_list'] = $this->_getTitleList(json_decode($data['title_list'], true), 2); // TODO::需要修改数据格式
                $image_result = $this->_getImageList(json_decode($data['image_list'], true), $store_data['header'], $user['account_id']); // TODO::需要修改数据格式
                if ($image_result['code'] == 'F')
                    return $image_result;
                $store_data['creative']['image_list'] = $image_result['data'];
                $store_data['creative'] = json_encode($store_data['creative']);
                $store_data['directional'] = json_encode($this->_createAudiencePackage($data['package_id'], $user['account_id'], $referral_link['platform']));
            }
            // 创建广告创意
        } else if ($data['type'] == '2') { // 多个素材一个账户

        }

    }

    /**
     * 封装定向包参数
     * @param int $package_id 定向包id
     * @param int $advertiser_id 广告主id
     * @param int $platform 平台
     * @param array $retargeting_tags 定向人群包列表，内容为人群包id
     * @param array $retargeting_tags_exclude 排除人群包列表，内容为人群包id
     * @return array
     */
    private function _createAudiencePackage(int $package_id, int $advertiser_id, int $platform, array $retargeting_tags = [], array $retargeting_tags_exclude = [])
    {
        $package = $this->_getDirectionalPackage($package_id);
        $package_content = json_decode($package['content'], true);
        $param = [
            'advertiser_id' => $advertiser_id,
            'name' => $package['package_name'],
            'description' => $package['description'],
            'landing_type' => $platform == '1' ? 'APP_IOS' : 'APP_ANDROID',
            'retargeting_tags' => $retargeting_tags,
            'retargeting_tags_exclude' => $retargeting_tags_exclude,
            'gender' => $package_content['gender'],
            'age' => $package_content['age'],
            'android_osv' => $package_content['android_osv'] ?? 'NONE',
            'ios_osv' => $package_content['ios_osv'] ?? 'NONE',
            'carrier' => $package_content['carrier'],
            'ac' => $package_content['ac'],
            'device_brand' => $package_content['device_brand'],
            'article_category' => $package_content['article_category'] ?? '',
            'activate_type' => $package_content['activate_type'],
            'platform' => $platform == '1' ? 'IOS' : 'ANDROID',
            'launch_price' => $package_content['launch_price'],
            'interest_action_mode' => $package_content['interest_action_mode'],
            'action_scene' => $package_content['action_scene'],
            'action_days' => $package_content['action_days'],
            'action_categories' => $package_content['action_categories'] ?? [],
            'action_words' => $package_content['action_words'] ?? [],
            'interest_categories' => $package_content['interest_categories'] ?? [],
            'interest_words' => $package_content['interest_words'] ?? [],
            'city' => $package_content['city'] ?? [],
            'business_ids' => $package_content['business_ids'] ?? [],
            'district' => $package_content['district'],
        ];
        !empty($param['city']) && !empty($param['district']) && $param['location_type'] = $package_content['location_type'];
        return $param;
    }

    /**
     * 上传素材
     * @param array $ids
     * @param $header
     * @param $advertiser_id
     * @return array
     * @throws Exception
     */
    private function _getImageList(array $ids, $header, $advertiser_id)
    {
        // 获取素材
        $mod = new ModAdMaterial();
        $materials = $mod->getByIds($ids);
        $img_data = $video_data = [];
        foreach ($materials as $item) {
            $mime_type = mime_content_type($item['file']);
            list($_type, $_extension) = explode('/', $mime_type);
            $file_signature = md5_file($item['file']);
            if ($_type == 'image') {
                $files = [
                    'image_file' => ['path' => $item['file'], 'type' => $mime_type, 'name' => basename($item['file'])]
                ];
                $image_response = $this->srv_jrtt->uploadAdImg([
                    'advertiser_id' => $advertiser_id,
                    'upload_type' => 'UPLOAD_BY_FILE',
                    'image_signature' => $file_signature,
                ], $header, $files);
                if ($image_response['code'] != '200' || $image_response['result']['code'] != '0') {
                    return ['code' => 'F', 'msg' => $image_response['result']['message']];
                }
                if (isset($img_data[$item['material_type']])) {
                    array_push($img_data[$item['material_type']]['image_ids'], $image_response['result']['data']['id']);
                } else {
                    $img_data[$item['material_type']] = [
                        'image_mode' => $item['material_type'],
                        'image_ids' => [$image_response['result']['data']['id']],
                    ];
                }
            } else if ($_type == 'video') {
                $files = [
                    'video_file' => ['path' => $item['file'], 'type' => $mime_type, 'name' => basename($item['file'])]
                ];
                $video_response = $this->srv_jrtt->uploadAdVideo([
                    'advertiser_id' => $advertiser_id,
                    'video_signature' => $file_signature,
                ], $header, $files);
                if ($video_response['code'] != '200' || $video_response['result']['code'] != 0) {
                    return ['code' => 'F', 'msg' => $video_response['result']['message']];
                }
                // 上传封面
                $thumb_files = [
                    'image_file' => ['path' => $item['thumb'], 'type' => $mime_type, 'name' => basename($item['thumb'])]
                ];
                $thumb_signature = md5_file($item['thumb']);
                $thumb_response = $this->srv_jrtt->uploadAdImg([
                    'advertiser_id' => $advertiser_id,
                    'upload_type' => 'UPLOAD_BY_FILE',
                    'image_signature' => $thumb_signature,
                ], $header, $thumb_files);
                if ($thumb_response['code'] != '200' || $thumb_response['result']['code'] != 0) {
                    return ['code' => 'F', 'msg' => $thumb_response['result']['message']];
                }
                array_push($video_data, [
                    'image_mode' => $item['material_type'],
                    'image_id' => $thumb_response['result']['data']['id'],
                    'video_id' => $video_response['result']['data']['video_id']
                ]);
            }
        }
        return ['code' => 'S', 'data' => array_merge($video_data, array_values($img_data))];
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
        return $mod->getPackageById($id);
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