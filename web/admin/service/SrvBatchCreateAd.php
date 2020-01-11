<?php
/**
 * 今日头条批量创建广告操作类
 * Class SrvBatchCreateAd
 * @author dyh
 * @version 2020/01/10
 */

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
     * 创建转化id
     * @param int $monitor_id
     * @param string $app_id
     * @param string $convert_type
     * @param string $deep_external_action
     * @return resource|string
     * @throws Exception
     */
    public function createAdConvert(int $monitor_id, string $app_id, string $convert_type, string $deep_external_action = '')
    {
        if (empty($monitor_id) || empty($app_id) || empty($convert_type))
            throw new Exception('客户端请求参数错误');
        $mod_link = new ModAdProject();
        $link_info = $mod_link->getLinkInfo($monitor_id);
        if (empty($link_info))
            throw new Exception('未找到需操作的推广链信息');

        $link_info = $this->_referralLinkHandle($link_info);
        $param = [
            'advertiser_id' => $link_info['account_id'],
            'name' => "api-{$link_info['game_id']}-{$link_info['monitor_id']}" . date('YmdHis'),
            'convert_type' => $convert_type, // 允许值："AD_CONVERT_TYPE_ACTIVE","AD_CONVERT_TYPE_ACTIVE_REGISTER","AD_CONVERT_TYPE_PAY"
            'download_url' => $link_info['download_url'],
            'action_track_url' => $link_info['monitor_url'],
            'display_track_url' => '',
            'deep_external_action' => $deep_external_action,
            'package_name' => $link_info['package_name'],
        ];
        if ($link_info['platform'] == 1) {
            $param['convert_source_type'] = 'AD_CONVERT_SOURCE_TYPE_APP_DOWNLOAD'; // 转化来源，应用下载api
            $param['app_type'] = 'APP_IOS';
        } else if ($link_info['platform'] == 2) {
            $param['convert_source_type'] = 'AD_CONVERT_SOURCE_TYPE_SDK';
            $param['app_type'] = 'APP_ANDROID';
            $param['app_id'] = $app_id;
        }
        $header = ["Access-Token: {$link_info['access_token']}"];
        $response = $this->srv_jrtt->createAdConvert($param, $header);
        $mod_mon = new ModMonitorConvert();
        $status = ['AD_CONVERT_STATUS_ACTIVE' => 1, 'AD_CONVERT_STATUS_INACTIVE' => 2];
        $opt_status = ['AD_CONVERT_OPT_STATUS_ENABLE' => 1, 'AD_CONVERT_OPT_STATUS_DISABLE' => 2, 'AD_CONVERT_OPT_STATUS_PAUSE' => 3];
        return $mod_mon->addConvertId([
            'monitor_id' => $link_info['monitor_id'],
            'convert_id' => $response['convert_id'],
            'status' => $status[$response['status']],
            'opt_status' => $opt_status[$response['opt_status']],
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * 推广链处理
     * @param $link_info
     * @return mixed
     */
    private function _referralLinkHandle($link_info)
    {
        $srvAd = new SrvAd();
        $link_info['monitor_url'] = $srvAd->getMonitorUrl($link_info['channel_short'], $link_info['monitor_url'], $link_info['device_type']);
        //CDN投放地址，替换自定义投放地址域名
        if ($link_info['jump_url'] && filter_var($link_info['jump_url'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            preg_match('/^http[s]?:\/\/(.*)\/(.*)\/index\.html$/', $link_info['jump_url'], $matches);
            //替换自定义域名
            if ($link_info['domain'] && filter_var($link_info['domain'], FILTER_VALIDATE_URL)) {
                if (substr($link_info['domain'], -1) != '/') {
                    $link_info['domain'] = $link_info['domain'] . '/';
                }
                $link_info['jump_url'] = $link_info['domain'] . $matches[2] . '/index.html';
            }
        } else {
            $link_info['jump_url'] = '';
        }

        //下载地址
        $link_info['download_url'] = '';
        if ($link_info['down_url']) {
            if ($link_info['platform'] == PLATFORM['ios']) {
                $link_info['down_url'] = APPSTORE_URL . $link_info['down_url'];
                $link_info['download_url'] = $link_info['down_url'];
            } else {
                //替换自定义下载地址域名
                if (filter_var($link_info['down_url'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
                    $link_info['download_url'] = $link_info['down_url'];
                    if ($link_info['download_domain'] && filter_var($link_info['download_domain'], FILTER_VALIDATE_URL)) {
                        if (substr($link_info['download_domain'], -1) != '/') {
                            $link_info['download_domain'] = $link_info['download_domain'] . '/';
                        }
                        $link_info['download_url'] = $link_info['download_domain'] . substr(strrchr($link_info['down_url'], "/"), 1);
                    }
                }
            }
        }
        return $link_info;
    }

    /**
     * 批量创建广告
     * @param array $param
     * @return int
     * @throws Exception
     */
    public function createAd(array $param)
    {
        if (empty($param['game_id']) || !is_numeric($param['game_id']))
            throw new Exception('请选择游戏包');
        if (empty($param['image_list']))
            throw new Exception('请选择素材');
        if (empty($param['user_id']))
            throw new Exception('请选择媒体账号');
        if (empty($param['channel_id']) || !is_numeric($param['channel_id']))
            throw new Exception('请选择投放渠道');
        if (empty($param['package_id']) || !is_numeric($param['package_id']))
            throw new Exception('请选择定向包id');

        $param['create_time'] = $param['update_time'] = date('Y-m-d H:i:s');
        $batch_id = $this->mod->createAd($param);
        if ($batch_id) {
            $this->_pushAd2Platform($param, $batch_id);
            return $batch_id;
        }
        throw new Exception('创建广告入库失败');
    }

    /**
     * 推送广告信息
     * @param array $data
     * @param int $batch_id
     * @throws Exception
     */
    private function _pushAd2Platform($data, $batch_id)
    {
        $result = false;
        if ($data['type'] == '1')
            $result = $this->_singleMaterialMoreAccount($data, $batch_id); // 1个素材多个账户
        else if ($data['type'] == '2')
            $result = $this->_moreMaterialSingleAccount($data, $batch_id); // 多个素材一个账户
        else
            throw new Exception('参数错误：请选择正确的投放规则');

        if (!$result)
            throw new Exception('创建广告失败，原因：写入记录表失败');

        $mod_record = new ModJrttAdPushRecord();
        $page = 1;
        $limit = 10;
        do {
            $ads = $mod_record->getAdRecordList(['batch_id' => $batch_id], $page, $limit);
            $this->srv_jrtt->setIsDebug(true);
            foreach ($ads['list'] as $ad) {
                try {
                    // 创建广告组
                    $group_param = json_decode($ad['group_param'], true);
                    $header = ["Access-Token: {$ad['access_token']}"];
                    $group_response = $this->srv_jrtt->createAdGroup($group_param, $header);

                    // 创建定向包
                    $directional_param = json_decode($ad['directional'], true);
                    $dir_response = $this->srv_jrtt->createAudiencePackage($directional_param, $header);

                    // 创建计划
                    $plan_param = json_decode($ad['plan_param'], true);
                    $plan_param['campaign_id'] = strval($group_response['campaign_id']); // 广告组id
                    $plan_param['audience_package_id'] = $dir_response['audience_package_id']; // 定向包id
                    $plan_response = $this->srv_jrtt->createAdPlan($plan_param, $header);

                    // 创建创意
                    $creative_param = json_decode($ad['creative'], true);
                    $creative_param['ad_id'] = $plan_response['ad_id']; // 计划id
                    $creative_param['image_list'] = $this->_getImageList($creative_param['image_list'], $header, $ad['account_id']);
                    $creative_response = $this->srv_jrtt->createAdOriginality($creative_param, $header);

                    // 更新推送状态
                    $mod_record->updateAdRecord([
                        'status' => 2,
                        'update_time' => date('Y-m-d H:i:s')
                    ], ['id' => $ad['id']]);
                } catch (Exception $e) {
                    // 记录日志
                    $mod_record->updateAdRecord([
                        'status' => 3,
                        'error_msg' => $e->getMessage(),
                        'update_time' => date('Y-m-d H:i:s')
                    ], ['id' => $ad['id']]);
                    throw new Exception($e->getMessage());
                }
            }
            $max_page = ceil($ads['total'] / $limit);
            $page++;
        } while ($page < $max_page);

    }

    /**
     * 多个素材一个账号
     * @param $batch_data
     * @param $batch_id
     * @return bool|resource|string
     * @throws Exception
     */
    private function _moreMaterialSingleAccount($batch_data, $batch_id)
    {
        $mod_user = new ModChannelUserAuth();
        $mod_material = new ModAdMaterial();

        $material_ids = json_decode($batch_data['image_list'], true);
        $materials = $mod_material->getByIds($material_ids); // 素材
        if (empty($materials))
            throw new Exception('参数错误：素材不存在');

        $package = $this->_getDirectionalPackage($batch_data['package_id']); // 定向包
        $users = $mod_user->getUserById(json_decode($batch_data['user_id'], true)); // 媒体账户
        if (empty($users))
            throw new Exception('参数错误：媒体账户不存在');

        $user = $users[0];
        $referral_link = $this->_getReferralLink($user['user_id'], $batch_data['channel_id'], $batch_data['game_id']);
        if (empty($referral_link))
            throw new Exception('广告主ID：' . $user['account_id'] . '下没有未使用的推广链接资源');
        $referral_link = $this->_referralLinkHandle($referral_link);
        $store_data = [];
        foreach ($materials as $item) {
            $ad_name = $item['material_name'] . '-' . date('Y-m-d') . '-' . $referral_link['name'] . '-' . uniqid();
            $store_data[] = [
                'group_param' => json_encode($this->_createAdGroup($user['account_id'], $ad_name, $batch_data['operation'])),
                'plan_param' => json_encode($this->_createAdPlan($user['account_id'], $ad_name, $batch_data['operation'], $package, $referral_link)),
                'creative' => json_encode($this->_createCreative($user['account_id'], $package, $batch_data['title_list'], $batch_data['image_list'])),
                'directional' => json_encode($this->_createAudiencePackage($package, $user['account_id'], $referral_link['platform'])),
                'batch_id' => $batch_id,
                'user_id' => $user['user_id'],
                'status' => 1,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s')
            ];
        }
        $mod = new ModJrttAdPushRecord();
        return $mod->addAdRecord($store_data);
    }

    /**
     * 一个素材多个账户
     * @param array $batch_data 批量创建数据信息
     * @param int $batch_id 批量包id
     * @return bool|resource|string
     * @throws Exception
     */
    private function _singleMaterialMoreAccount($batch_data, $batch_id)
    {
        $mod_user = new ModChannelUserAuth();
        $mod_material = new ModAdMaterial();
        $users = $mod_user->getUserById(json_decode($batch_data['user_id'], true)); // 媒体账户
        if (empty($users))
            throw new Exception('参数错误：媒体账户不存在');

        $package = $this->_getDirectionalPackage($batch_data['package_id']); // 定向包

        $material_ids = json_decode($batch_data['image_list'], true);
        $material = $mod_material->getAdmaterialById($material_ids[0]); // 素材
        if (empty($material))
            throw new Exception('参数错误：素材不存在');

        $store_data = [];
        foreach ($users as $key => $user) {
            $referral_link = $this->_getReferralLink($user['user_id'], $batch_data['channel_id'], $batch_data['game_id']);
            if (empty($referral_link))
                throw new Exception('广告主ID：' . $user['account_id'] . '下没有未使用的推广链接资源');
            $referral_link = $this->_referralLinkHandle($referral_link);

            $ad_name = $material['material_name'] . '-' . date('Y-m-d') . '-' . $referral_link['name'] . '-' . uniqid();
            $store_data[] = [
                'group_param' => json_encode($this->_createAdGroup($user['account_id'], $ad_name, $batch_data['operation'])),
                'plan_param' => json_encode($this->_createAdPlan($user['account_id'], $ad_name, $batch_data['operation'], $package, $referral_link)),
                'creative' => json_encode($this->_createCreative($user['account_id'], $package, $batch_data['title_list'], $batch_data['image_list'])),
                'directional' => json_encode($this->_createAudiencePackage($batch_data['package_id'], $batch_data['account_id'], $referral_link['platform'])),
                'batch_id' => $batch_id,
                'user_id' => $user['user_id'],
                'status' => 1,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s')
            ];
        }
        $mod = new ModJrttAdPushRecord();
        return $mod->addAdRecord($store_data);
    }

    /**
     * 封装创意参数
     * @param int $advertiser_id
     * @param array $package
     * @param json $titles
     * @param json $images
     * @return array
     */
    private function _createCreative($advertiser_id, $package, $titles, $images)
    {
        $package = json_decode($package['content'], true);
        $titles = json_decode($titles, true);
        $images = json_decode($images, true);
        // 创意数据
        $param = [
            'advertiser_id' => $advertiser_id,
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
            $param['smart_inventory'] = 1;
        } else if (!empty($package['inventory_type'])) { // 创意投放位置
            $param['inventory_type'] = $package['inventory_type'];
        } else if (!empty($package['scene_inventory'])) { // 场景广告位
            $param['scene_inventory'] = $package['scene_inventory'];
        }

        $package['download_type'] == 'EXTERNAL_URL' && $param['source'] = $package['source'];
        $package['download_type'] == 'DOWNLOAD_URL' && $param['app_name'] = $package['app_name']; // TODO::应用名是拿游戏名称，还是需要自定义
        $param['app_type'] == 'APP_ANDROID' && $param['web_url'] = $advertiser_id; // TODO::需要对接橙子建站获取落地页地址 使用广告主id替代
        $param['title_list'] = $this->_getTitleList($titles, 2); // TODO::需要修改数据格式
        $param['image_list'] = $images;
        return $param;
    }

    /**
     * 封装广告计划参数
     * @param int $advertiser_id 广告主id
     * @param string $ad_name 广告名
     * @param int $operation 是否启用广告计划
     * @param array $package 定型包信息
     * @param array $referral_link 推广链
     * @return array
     */
    private function _createAdPlan($advertiser_id, $ad_name, $operation, $package, $referral_link)
    {
        $package = json_decode($package['content'], true);
        $param = [
            'advertiser_id' => $advertiser_id,
            'campaign_id' => 0, // 用0代替广告组id
            'name' => $ad_name, // 命名规则：素材名称-日期-推广链名称-随机数字后缀（不允许重复）
            'operation' => $operation == 1 ? 'enable' : 'disable',
            'delivery_range' => $package['delivery_range'],  // 投放范围
            'budget_mode' => $package['budget_mode'],
            'budget' => $package['budget'],
            'schedule_type' => $package['schedule_type'],
            'pricing' => $package['pricing'], // CPM ，出价范围（单位元）: 4-100，日预算范围（单位元）：大于100，总预算范围：大于最低日预算乘投放天数
            'flow_control_mode' => $package['flow_control_mode'],
            'convert_id' => $referral_link['convert_id'], // 转化ID
            'hide_if_converted' => $package['hide_if_converted'],
            'smart_bid_type' => $package['smart_bid_type'],
            'audience_package_id' => 0, // 定向包ID 用0代替
            'download_type' => $package['download_type'] ?: 'DOWNLOAD_URL',
        ];

        $param['delivery_range'] == 'UNION' && $param['union_video_type'] = $package['union_video_type'];
        if ($param['schedule_type'] == 'SCHEDULE_START_END') {
            $param['start_time'] = $package['start_time'];
            $param['end_time'] = $package['end_time'];
        }
        empty($package['schedule_time']) || $param['schedule_time']; // 投放时段
        in_array($package['pricing'], ['PRICING_CPC', 'PRICING_CPM', 'PRICING_CPV']) && $param['bid'] = $package['bid']; // 广告出价
        in_array($package['pricing'], ['PRICING_OCPM', 'PRICING_OCPC', 'PRICING_CPA']) && $param['cpa_bid'] = $package['cpa_bid'];
        $param['unique_fk'] = md5('ht_plan_api_' . $ad_name);
        if ($param['download_type'] == 'DOWNLOAD_URL') {
            $param['download_url'] = $referral_link['download_url']; // 下载链接
            $param['app_type'] = $referral_link['platform'] == 1 ? 'APP_IOS' : 'APP_ANDROID';
            $param['package'] = $referral_link['package_name'];
        }
        $param['download_type'] == 'EXTERNAL_URL' && $param['download_url'] = $referral_link['external_url'];
        return $param;
    }

    /**
     * 创建广告组参数
     * @param int $advertiser_id
     * @param string $ad_name
     * @param int $operation
     * @return array
     */
    private function _createAdGroup($advertiser_id, $ad_name, $operation)
    {
        return [
            'advertiser_id' => $advertiser_id,
            'campaign_name' => $ad_name,
            'operation' => $operation == 1 ? 'enable' : 'disable',
            'budget_mode' => 'BUDGET_MODE_INFINITE', // 广告组预算类型，默认不限 允许值:"BUDGET_MODE_INFINITE","BUDGET_MODE_DAY"
            'landing_type' => 'APP', // 推广目的默认为app
            'unique_fk' => md5('ht_group_api_' . $ad_name),
        ];
    }

    /**
     * 封装定向包参数
     * @param array $package 定向包id
     * @param int $advertiser_id 广告主id
     * @param int $platform 平台
     * @param array $retargeting_tags 定向人群包列表，内容为人群包id
     * @param array $retargeting_tags_exclude 排除人群包列表，内容为人群包id
     * @return array
     */
    private function _createAudiencePackage($package, $advertiser_id, $platform, $retargeting_tags = [], $retargeting_tags_exclude = [])
    {
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
            'platform' => $platform == '1' ? ['IOS'] : ['ANDROID'],
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
    private function _getImageList($ids, $header, $advertiser_id)
    {
        // 获取素材
        $mod = new ModAdMaterial();
        $materials = $mod->getByIds($ids);
        if (empty($materials))
            throw new Exception("未选中任何素材");

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

                if (isset($img_data[$item['material_type']])) {
                    array_push($img_data[$item['material_type']]['image_ids'], $image_response['id']);
                } else {
                    $img_data[$item['material_type']] = [
                        'image_mode' => $item['material_type'],
                        'image_ids' => [$image_response['id']],
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

                array_push($video_data, [
                    'image_mode' => $item['material_type'],
                    'image_id' => $thumb_response['id'],
                    'video_id' => $video_response['video_id']
                ]);
            }
        }
        return array_merge($video_data, array_values($img_data));
    }

    /**
     *
     * @param array $ids
     * @param int $channel
     * @return array
     */
    private function _getTitleList($ids, $channel)
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
    private function _getDirectionalPackage($id)
    {
        $mod = new ModDirectionalPackage();
        return $mod->getPackageById($id);
    }

    /**
     * 创建人群包
     * @param array $data
     * @return resource|string
     * @throws Exception
     */
    public function createCustomAudience(array $data)
    {
        if (empty($data['user_id']) || empty($data['file_path']))
            throw new Exception('客户端请求参数错误');
        if (empty($data['data_source_name']) || strlen($data['data_source_name']) > 30)
            throw new Exception('请输入人群包名称并不大于30个字符');
        if (empty($data['description']) || strlen($data['description']) > 256)
            throw new Exception('请输入人群包名称并不大于256个字符');
        if (empty($data['data_source_type']))
            throw new Exception('请选择数据源类型');
        $mod_user = new ModChannelUserAuth();
        $user = $mod_user->getUserById([$data['user_id']]);
        if (empty($user))
            throw new Exception('该媒体账号不存在或已被删除');
        $header = ["Access-Token: {$user['access_token']}"];
        $up_response = $this->_uploadDataSource($user['account_id'], $data['file_path'], $header);
        $source_response = $this->_createDataSource($user['account_id'], $header, $data['data_source_name'], $up_response['data']['file_path'], $data['data_source_type']);
        // 记录数据源, 计划任务处理发布、推送
        $mod_audience = new ModJrttCustomAudience();
        return $mod_audience->insertAudience([
            'user_id' => $user['user_id'],
            'name' => $data['data_source_name'],
            'data_source_id' => $source_response['data_source_id'],
            'create_time' => time(),
            'update_time' => time()
        ]);
    }

    /**
     * 上传人群包数据源文件
     * @param int $advertiser_id
     * @param string $file_path
     * @param array $header
     * @return mixed
     * @throws Exception
     */
    private function _uploadDataSource(int $advertiser_id, string $file_path, array $header)
    {
        if (!file_exists($file_path))
            throw new Exception('数据源文件不存在,请先上传。');
        $param = [
            'advertiser_id' => $advertiser_id,
            'file_signature' => md5_file($file_path),
        ];
        $files = [
            'file' => ['path' => $file_path, 'type' => mime_content_type($file_path), 'name' => basename($file_path)]
        ];

        return $this->srv_jrtt->uploadDataSource($param, $header, $files);
    }

    /**
     * 人群包创建数据源
     * @param $advertiser_id
     * @param $header
     * @param $data_source_name
     * @param $description
     * @param $file_paths
     * @param string $data_source_type
     * @param int $data_format
     * @param int $file_storage_type
     * @return mixed
     * @throws Exception
     */
    private function _createDataSource($advertiser_id, $header, $data_source_name, $description, $file_paths, $data_source_type = 'UID', $data_format = 0, $file_storage_type = 0)
    {
        if (empty($file_paths) || !is_array($file_paths))
            throw new Exception('数据源文件路径不存在');

        $param = [
            'advertiser_id' => $advertiser_id,
            'data_source_name' => $data_source_name,
            'description' => $description,
            'data_format' => $data_format,
            'file_storage_type' => $file_storage_type,
            'file_paths' => $file_paths,
            'data_source_type' => $data_source_type,
        ];
        return $this->srv_jrtt->createDataSource($param, $header);
    }

    /**
     * 获取数据源详细信息
     * @param int $advertiser_id
     * @param array $header
     * @param array $data_source_id_list
     * @return mixed
     * @throws Exception
     */
    public function dataSourceRead(int $advertiser_id, array $header, array $data_source_id_list)
    {
        $param = [
            'advertiser_id' => $advertiser_id,
            'data_source_id_list' => $data_source_id_list
        ];
        return $this->srv_jrtt->dataSourceRead($param, $header);
    }

    /**
     * 发布人群包
     * @param $advertiser_id
     * @param $custom_audience_id
     * @param $header
     * @return array
     * @throws Exception
     */
    public function customAudiencePublish($advertiser_id, $custom_audience_id, $header)
    {
        if(empty($advertiser_id) || empty($custom_audience_id) || empty($header))
            throw new Exception('发布人群参数错误');

        return $this->srv_jrtt->customAudiencePublish([
            'advertiser_id' => $advertiser_id,
            'custom_audience_id' => $custom_audience_id,
        ], $header);
    }

    /**
     * 推送同主体人群包
     * @param $advertiser_id
     * @param array $header
     * @param array $target_advertiser_ids
     * @param array $custom_audience_id
     * @return mixed
     * @throws Exception
     */
    public function customAudiencePush($advertiser_id, array $header, array $target_advertiser_ids, array $custom_audience_id)
    {
        if (empty($target_advertiser_ids))
            throw new Exception('目标广告主列表不能为空');
        if (count($target_advertiser_ids) > 100)
            throw new Exception('目标广告主列表不能超过100条');

        $param = [
            'advertiser_id' => $advertiser_id,
            'custom_audience_id' => $custom_audience_id,
            'target_advertiser_ids' => $target_advertiser_ids,
        ];

        return $this->srv_jrtt->customAudiencePush($param, $header);
    }

}