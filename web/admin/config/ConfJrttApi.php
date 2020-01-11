<?php
return [
    'domain' => [
        'debug' => 'https://test-ad.toutiao.com/open_api',
        'production' => 'https://ad.oceanengine.com/open_api'
    ],
    'api' => [
        'get_access_token' => '/oauth2/access_token/',
        'refresh_token' => '/open_api/oauth2/refresh_token/',
        'create_group' => '/2/campaign/create/',
        'create_ad_plan' => '/2/ad/create/',
        'create_ad_originality' => '/2/creative/create_v2/',
        'third_industry_list' => '/2/tools/industry/get/',
        'upload_ad_img' => '/2/file/image/ad/',
        'upload_ad_video' => '/2/file/video/ad/',
        'get_business_tree' => '/2/tools/region/get/',
        'get_action_category' => '/2/tools/interest_action/action/category/',
        'get_action_keyword' => '/2/tools/interest_action/action/keyword/',
        'get_interest_category' => '/2/tools/interest_action/interest/category/',
        'get_interest_keyword' => '/2/tools/interest_action/interest/keyword/',
        'id2word' => '/2/tools/interest_action/id2word/',
        'keyword_suggest' => '/2/tools/interest_action/keyword/suggest/',
        'get_industry' => '/2/tools/industry/get/',
        'create_audience_package' => '/2/audience_package/create/',
        'create_ad_convert' => '/2/tools/ad_convert/create/',
        'upload_data_source' => '/2/dmp/data_source/file/upload/',
        'custom_audience_push' => '/2/dmp/custom_audience/push_v2/',
        'data_source_read' => '/2/dmp/data_source/read/',
        'custom_audience_publish' => '/2/dmp/custom_audience/publish/',
    ],
    'api_param_rule' => [
        'create_group' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'campaign_name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '广告组名称，长度为1-100个字符，其中1个中文字符算2位',
                'min' => 1,
                'max' => 100,
            ],
            'operation' => [
                'type' => 'string',
                'required' => false,
                'desc' => '广告组状态',
                'value' => ['enable', 'disable']
            ],
            'budget_mode' => [
                'type' => 'string',
                'required' => true,
                'desc' => '广告组预算类型',
                'value' => ['BUDGET_MODE_INFINITE', 'BUDGET_MODE_DAY'],
            ],
            'budget' => [
                'type' => 'numeric',
                'required' => false,
                'required_if' => [
                    'key' => 'budget_mode',
                    'val' => 'BUDGET_MODE_DAY'
                ],
                'min' => 0,
                'desc' => '广告组预算',
            ],
            'landing_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['LINK', 'APP', 'DPA', 'GOODS', 'STORE', 'SHOP'],
                'desc' => '广告推广目的'
            ],
            'unique_fk' => [
                'type' => 'string',
                'required' => false,
                'desc' => '第三方唯一键'
            ]
        ],
        'create_ad_plan' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'campaign_id' => [
                'type' => 'string',
                'required' => true,
                'desc' => '广告组id',
            ],
            'name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '广告名称',
                'min' => 1,
                'max' => 100,
            ],
            'operation' => [
                'type' => 'string',
                'value' => ['enable', 'disable'],
                'desc' => '计划状态'
            ],
            'delivery_range' => [
                'type' => 'string',
                'value' => ['DEFAULT', 'UNION'],
                'required' => true,
                'desc' => '投放范围'
            ],
            'union_video_type' => [
                'type' => 'string',
                'value' => ['ORIGINAL_VIDEO', 'REWARDED_VIDEO'],
                'required_if' => [
                    'key' => 'delivery_range',
                    'val' => 'UNION',
                ],
                'required' => false,
                'desc' => '穿山甲视频创意类型'
            ],
            'budget_mode' => [
                'type' => 'string',
                'required' => true,
                'value' => ['BUDGET_MODE_DAY', 'BUDGET_MODE_TOTAL'],
                'desc' => '广告预算类型',
            ],
            'budget' => [
                'type' => 'numeric',
                'required' => true,
                'min' => 1,
                'desc' => '广告预算'
            ],
            'schedule_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['SCHEDULE_FROM_NOW', 'SCHEDULE_START_END'],
                'desc' => '广告投放时间类型'
            ],
            'start_time' => [
                'type' => 'date',
                'required' => false,
                'desc' => '广告投放起始时间',
                'required_if' => [
                    'key' => 'schedule_type',
                    'value' => 'SCHEDULE_START_END'
                ]
            ],
            'end_time' => [
                'type' => 'date',
                'required' => false,
                'desc' => '广告投放结束时间',
                'required_if' => [
                    'key' => 'schedule_type',
                    'value' => 'SCHEDULE_START_END'
                ]
            ],
            'schedule_time' => [
                'type' => 'string',
                'required' => false,
                'desc' => '广告投放时段',
            ],
            'pricing' => [
                'type' => 'string',
                'required' => true,
                'desc' => '计划出价类型',
                'value' => ['PRICING_CPC', 'PRICING_CPM', 'PRICING_OCPM', 'PRICING_CPV', 'PRICING_CPA'],
            ],
            'bid' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => '广告出价',
                'required_if' => [
                    'key' => 'pricing',
                    'val' => ['PRICING_CPC', 'PRICING_CPM', 'PRICING_CPV']
                ],
                'min' => 0,
            ],
            'cpa_bid' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => 'ocpm广告转化出价',
                'required_if' => [
                    'key' => 'pricing',
                    'val' => ['PRICING_OCPM', 'PRICING_CPA']
                ],
                'min' => 0,
                'max' => 10000
            ],
            'flow_control_mode' => [
                'type' => 'string',
                'required' => true,
                'value' => ['FLOW_CONTROL_MODE_FAST', 'FLOW_CONTROL_MODE_SMOOTH', 'FLOW_CONTROL_MODE_BALANCE'],
                'desc' => '广告投放速度类型',
            ],
            'convert_id' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => '转化id',
                'required_if' => [
                    'key' => 'pricing',
                    'val' => ['PRICING_OCPM']
                ]
            ],
            'deep_bid_type' => [
                'type' => 'string',
                'required' => false,
                'desc' => '深度优化方式',
                'value' => ['DEEP_BID_DEFAULT', 'DEEP_BID_PACING', 'DEEP_BID_MIN', 'ROI_COEFFICIENT', 'ROI_PACING'],
            ],
            'deep_cpabid' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => '深度优化出价',
                'required_if' => [
                    'key' => 'deep_bid_type',
                    'val' => 'DEEP_BID_MIN'
                ]
            ],
            'hide_if_converted' => [
                'type' => 'string',
                'required' => false,
                'desc' => '过滤已转化的用户类型',
                'value' => ['NO_EXCLUDE', 'AD', 'CAMPAIGN', 'ADVERTISER', 'APP', 'CUSTOMER']
            ],
            'hide_if_exists' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => '过滤已安装',
                'value' => [0, 1]
            ],
            'roi_goal' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => '深度转化ROI系数',
                'value' => [0, 1, 2, 3, 4, 5]
            ],
            'unique_fk' => [
                'type' => 'string',
                'required' => false,
                'desc' => '第三方唯一键'
            ],
            'smart_bid_type' => [
                'type' => 'string',
                'required' => false,
                'desc' => '自动出价类型',
                'value' => ['SMART_BID_CUSTOM', 'SMART_BID_CONSERVATIVE']
            ],
            'adjust_cpa' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => '是否调整自动出价',
                'value' => [0, 1]
            ],
            'audience_package_id' => [
                'type' => 'numeric',
                'required' => false,
                'desc' => '定向包id',
            ],
            'external_url' => [
                'type' => 'url',
                'required' => false,
                'desc' => '广告落地页链接'
            ],
            'open_url' => [
                'type' => 'url',
                'required' => false,
                'desc' => '应用直达链接'
            ],
            'download_type' => [
                'type' => 'string',
                'value' => ['DOWNLOAD_URL', 'EXTERNAL_URL'],
                'required' => true,
                'desc' => '应用下载方式',
            ],
            'download_url' => [
                'type' => 'url',
                'required' => false,
                'required_if' => [
                    'key' => 'download_type',
                    'val' => 'DOWNLOAD_URL'
                ],
                'desc' => '广告应用下载链接'
            ],
            'app_type' => [
                'type' => 'string',
                'value' => ['APP_ANDROID', 'APP_IOS'],
                'desc' => '广告应用下载类型',
                'required' => false,
                'required_if' => [
                    'key' => 'download_type',
                    'val' => 'DOWNLOAD_URL'
                ]
            ],
            'package' => [
                'type' => 'string',
                'required' => false,
                'required_if' => [
                    'key' => 'download_type',
                    'val' => 'DOWNLOAD_URL'
                ],
                'desc' => '广告应用下载包名'
            ],
            'android_osv' => [
                'type' => 'string',
                'required' => false,
                'desc' => '受众最低android版本'
            ],
            'ios_osv' => [
                'type' => 'string',
                'required' => false,
                'desc' => '	受众最低ios版本'
            ],
            'platform' => [
                'type' => 'array',
                'value' => ['ANDROID', 'PC', 'IOS'],
                'desc' => '受众平台',
                'required' => false,
            ],
            'download_mode' => [
                'type' => 'string',
                'value' => ['APP_STORE_DELIVERY', 'DEFAULT'],
                'desc' => '下载模式',
                'required' => false,
            ]
        ],
        'create_ad_originality' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'ad_id' => [
                'type' => 'string',
                'required' => true,
                'desc' => '广告计划id',
            ],
            'inventory_type' => [
                'type' => 'array',
                'required' => true,
                'desc' => '创意投放位置',
            ],
            'smart_inventory' => [
                'type' => 'numeric',
                'value' => [0, 1],
                'required' => false,
                'desc' => '是否使用优选广告位',
            ],
            'scene_inventory' => [
                'type' => 'string',
                'value' => ['VIDEO_SCENE', 'FEED_SCENE', 'TAIL_SCENE'],
                'desc' => '场景广告位',
                'required' => false,
            ],
            'ad_keywords' => [
                'type' => 'array',
                'desc' => '创意标签',
                'required' => true,
            ],
            'third_industry_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '创意分类'
            ],
            'source' => [
                'type' => 'string',
                'required' => false,
                'desc' => '文章来源'
            ],
            'creative_display_mode' => [
                'type' => 'string',
                'required' => false,
                'desc' => '创意展现方式',
                'value' => ['CREATIVE_DISPLAY_MODE_CTR', 'CREATIVE_DISPLAY_MODE_RANDOM'],
            ],
            'is_presented_video' => [
                'type' => 'numeric',
                'required' => false,
                'value' => [0, 1]
            ],
            'creative_material_mode' => [
                'type' => 'string',
                'value' => ['STATIC_ASSEMBLE'],
                'required' => false,
                'desc' => '创意类型'
            ],
            'procedural_package_id' => [
                'type' => 'int',
                'required' => false,
                'desc' => '程序化创意包Id'
            ],
            'title_list' => [
                'type' => 'array',
                'required' => true,
                'desc' => '标题信息',
            ],
            'image_list' => [
                'type' => 'array',
                'required' => true,
                'desc' => '素材信息'
            ],
            'app_name' => [
                'type' => 'string',
                'required' => false,
                'desc' => '应用名'
            ],
            'web_url' => [
                'type' => 'string',
                'required' => false,
                'desc' => 'Android应用下载详情页'
            ]
        ],
        'upload_ad_img' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'upload_type' => [
                'type' => 'string',
                'required' => false,
                'value' => ['UPLOAD_BY_FILE', 'UPLOAD_BY_URL'],
                'desc' => '图片上传方式'
            ],
            'image_signature' => [
                'type' => 'string',
                'required' => false,
                'required_if' => [
                    'key' => 'upload_type',
                    'val' => 'UPLOAD_BY_FILE'
                ],
                'desc' => '图片的md5值'
            ],
            'image_file' => [
                'type' => 'string',
                'required' => false,
                // 不验证
                /*'required_if' => [
                    'key' => 'upload_type',
                    'val' => 'UPLOAD_BY_FILE'
                ],*/
                'desc' => '图片文件'
            ],
            'image_url' => [
                'type' => 'url',
                'required' => false,
                'required_if' => [
                    'key' => 'upload_type',
                    'val' => 'UPLOAD_BY_URL'
                ],
                'desc' => '图片url地址'
            ]
        ],
        'upload_ad_video' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'video_signature' => [
                'type' => 'string',
                'required' => true,
                'desc' => '视频的md5值'
            ]
        ],
        'get_business_tree' => [
            'region_type' => [
                'type' => 'string',
                'required' => true,
                'desc' => '地域类型',
                'value' => ['BUSINESS_DISTRICT']
            ]
        ],
        'get_action_category' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'action_scene' => [
                'type' => 'array',
                'required' => true,
                'desc' => '行为场景',
                'value' => ['E-COMMERCE', 'NEWS', 'APP']
            ],
            'action_days' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '行为天数',
                'value' => [7, 15, 30, 60, 90, 180, 365]
            ]
        ],
        'get_action_keyword' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'query_words' => [
                'type' => 'string',
                'required' => true,
                'desc' => '关键词',
            ],
            'action_scene' => [
                'type' => 'array',
                'required' => true,
                'desc' => '行为场景',
                'value' => ['E-COMMERCE', 'NEWS', 'APP']
            ],
            'action_days' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '行为天数',
                'value' => [7, 15, 30, 60, 90, 180, 365]
            ]
        ],
        'get_interest_category' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
        ],
        'get_interest_keyword' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'query_words' => [
                'type' => 'string',
                'required' => true,
                'desc' => '关键词',
            ],
        ],
        'id2word' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'ids' => [
                'type' => 'array',
                'required' => true,
                'desc' => '类目或关键词id列表'
            ],
            'tag_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['CATEGORY', 'KEYWORD'],
                'desc' => '查询类型，类目还是关键词'
            ],
            'targeting_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['CATEGORY', 'KEYWORD'],
                'desc' => '查询目标,兴趣还是行为'
            ],
            'action_scene' => [
                'type' => 'array',
                'required' => false,
                'value' => ['E-COMMERC', 'NEWS', 'APP'],
                'desc' => '行为场景'
            ],
            'action_days' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '行为天数',
                'value' => [7, 15, 30, 60, 90, 180, 365]
            ]
        ],
        'keyword_suggest' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '类目或关键词id'
            ],
            'tag_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['CATEGORY', 'KEYWORD'],
                'desc' => '查询类型，类目还是关键词'
            ],
            'targeting_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['CATEGORY', 'KEYWORD'],
                'desc' => '查询目标,兴趣还是行为'
            ],
            'action_scene' => [
                'type' => 'array',
                'required' => false,
                'value' => ['E-COMMERC', 'NEWS', 'APP'],
                'desc' => '行为场景'
            ],
            'action_days' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '行为天数',
                'value' => [7, 15, 30, 60, 90, 180, 365]
            ]
        ],
        'get_industry' => [
            'level' => [
                'type' => 'numeric',
                'value' => [1, 2, 3],
                'desc' => '获取某级别数据'
            ],
            'type' => [
                'type' => 'string',
                'value' => ['ADVERTISER', 'AGENT'],
                'desc' => '数据分类'
            ]
        ],
        'create_audience_package' => [
            'advertiser_id' => [
                'advertiser_id' => [
                    'type' => 'numeric',
                    'required' => true,
                    'desc' => '广告主id',
                ],
                'name' => [
                    'type' => 'string',
                    'required' => true,
                    'desc' => '定向包名称',
                    'min' => 1,
                    'max' => 20
                ],
                'description' => [
                    'type' => 'string',
                    'required' => true,
                    'desc' => '定向包描述',
                    'min' => 1,
                    'max' => 50
                ],
                'landing_type' => [
                    'type' => 'string',
                    'required' => true,
                    'desc' => '定向包类型',
                    'value' => ['EXTERNAL', 'ARTICLE', 'GOODS', 'DPA', 'STORE', 'AWEME', 'SHOP', 'APP_ANDROID', 'APP_IOS'],
                ],
                'retargeting_tags' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '定向人群包列表'
                ],
                'retargeting_tags_exclude' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '排除人群包列表'
                ],
                'gender' => [
                    'type' => 'string',
                    'required' => false,
                    'desc' => '受众性别',
                    'value' => ['GENDER_FEMALE', 'GENDER_MALE', 'NONE']
                ],
                'age' => [
                    'type' => 'array',
                    'required' => false,
                    'value' => ['AGE_BETWEEN_18_23', 'AGE_BETWEEN_24_30', 'AGE_BETWEEN_31_40', 'AGE_BETWEEN_41_49', 'AGE_ABOVE_50'],
                    'desc' => '受众年龄区间'
                ],
                'android_osv' => [
                    'type' => 'string',
                    'required' => false,
                    'value' => ["0.0", "2.0", "2.1", "2.2", "2.3", "3.0", "3.1", "3.2", "4.0", "4.1", "4.2", "4.3", "4.4", "4.5", "5.0", "NONE"],
                    'desc' => '受众最低android版本'
                ],
                'ios_osv' => [
                    'type' => 'string',
                    'required' => false,
                    'value' => ["0.0", "4.0", "4.1", "4.2", "4.3", "5.0", "5.1", "6.0", "7.0", "7.1", "8.0", "8.1", "8.2", "9.0", "NONE"],
                    'desc' => '受众最低ios版本'
                ],
                'carrier' => [
                    'type' => 'string',
                    'required' => false,
                    'value' => ["MOBILE", "UNICOM", "TELCOM"],
                    'desc' => '受众运营商'
                ],
                'ac' => [
                    'type' => 'array',
                    'required' => false,
                    'value' => ['WIFI', '2G', '3G', '4G'],
                    'desc' => '受众网络类型'
                ],
                'device_brand' => [
                    'type' => 'array',
                    'required' => false,
                    'value' => ["HONOR", "APPLE", "HUAWEI", "XIAOMI", "SAMSUNG", "OPPO", "VIVO", "MEIZU", "GIONEE", "COOLPAD", "LENOVO", "LETV", "ZTE", "CHINAMOBILE", "HTC", "PEPPER", "NUBIA", "HISENSE", "QIKU", "TCL", "SONY", "SMARTISAN", "360", "ONEPLUS", "LG", "MOTO", "NOKIA", "GOOGLE"],
                    'desc' => '受众手机品牌'
                ],
                'article_category' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '受众文章分类'
                ],
                'activate_type' => [
                    'type' => 'array',
                    'required' => false,
                    'value' => ['WITH_IN_A_MONTH', 'ONE_MONTH_2_THREE_MONTH', 'THREE_MONTH_EAILIER'],
                    'desc' => '用户首次激活时间',
                ],
                'platform' => [
                    'type' => 'array',
                    'required' => false,
                    'value' => ['ANDROID', 'IOS', 'PC'],
                    'desc' => '受众平台'
                ],
                'auto_extend_enabled' => [
                    'type' => 'numeric',
                    'required' => false,
                    'value' => [0, 1],
                    'desc' => '是否允许智能放量'
                ],
                'auto_extend_targets' => [
                    'type' => 'string',
                    'required' => false,
                    'value' => ["REGION", "GENDER", "AGE", "CUSTOM_AUDIENCE"],
                    'desc' => '智能放量定向'
                ],
                'launch_price' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '手机价格定向'
                ],
                'interest_action_mode' => [
                    'type' => 'string',
                    'required' => false,
                    'value' => ["UNLIMITED", "CUSTOM", "RECOMMEND"],
                    'desc' => '行为兴趣选择',
                ],
                'action_scene' => [
                    'type' => 'array',
                    'required' => false,
                    'value' => ["E-COMMERCE", "NEWS", "APP"],
                    'desc' => '行为场景'
                ],
                'action_days' => [
                    'type' => 'numeric',
                    'required' => false,
                    'value' => [7, 15, 30, 60, 90, 180, 365],
                    'desc' => '行为天数'
                ],
                'action_categories' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '行为类目'
                ],
                'action_words' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '行为关键词'
                ],
                'interest_categories' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '兴趣分类',
                ],
                'interest_words' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '兴趣关键词',
                ],
                'city' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '地域定向城市',
                ],
                'business_ids' => [
                    'type' => 'array',
                    'required' => false,
                    'desc' => '商圈id数组'
                ],
                'district' => [
                    'type' => 'string',
                    'required' => false,
                    'value' => ['CITY', 'COUNTY', 'BUSINESS_DISTRICT', 'NONE']
                ]
            ]
        ],
        'create_ad_convert' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '转化名称',
                'max' => 25,
                'min' => 1
            ],
            'convert_source_type' => [
                'type' => 'string',
                'required' => true,
                'desc' => '转化来源',
                'values' => ['AD_CONVERT_SOURCE_TYPE_APP_DOWNLOAD', 'AD_CONVERT_SOURCE_TYPE_SDK'],
            ],
            'convert_type' => [
                'type' => 'string',
                'required' => true,
                'desc' => '转化类型',
                'value' => ['AD_CONVERT_TYPE_ACTIVE', 'AD_CONVERT_TYPE_ACTIVE_REGISTER', 'AD_CONVERT_TYPE_GAME_ADDICTION', 'AD_CONVERT_TYPE_PAY']
            ],
            'download_url' => [
                'type' => 'url',
                'required' => true,
                'desc' => '下载链接',
            ],
            'action_track_url' => [
                'type' => 'url',
                'required' => true,
                'desc' => '监测链接'
            ],
            'display_track_url' => [
                'type' => 'url',
                'required' => false,
                'desc' => '展示监测链接',
            ],
            'deep_external_action' => [
                'type' => 'string',
                'required' => false,
                'desc' => '深度转化目标',
                'value' => ['AD_CONVERT_TYPE_PAY', 'AD_CONVERT_TYPE_NEXT_DAY_OPEN', 'AD_CONVERT_TYPE_GAME_ADDICTION']
            ],
            'package_name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '包名'
            ],
            'app_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['APP_ANDROID', 'APP_IOS'],
            ],
            'app_id' => [
                'type' => 'string',
                'required' => false,
                'required_if' => [
                    'key' => 'app_type',
                    'val' => 'APP_ANDROID'
                ],
                'desc' => 'APP ID',
            ]
        ],
        'upload_data_source' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'file_signature' => [
                'type' => 'string',
                'required' => false,
                'desc' => '文件md5'
            ]
        ],
        'create_data_source' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'data_source_name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '数据源名称',
                'max' => 30,
            ],
            'description' => [
                'type' => 'string',
                'required' => true,
                'desc' => '数据源描述',
                'max' => 256,
            ],
            'data_format' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '数据格式',
            ],
            'file_storage_type' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '数据存储类型'
            ],
            'file_paths' => [
                'type' => 'array',
                'required' => true,
                'desc' => '数据源文件路径',
            ],
            'data_source_type' => [
                'type' => 'string',
                'required' => false,
                'value' => ['UID', 'DID'],
                'desc' => '数据源类型'
            ]
        ],
        'custom_audience_push' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'custom_audience_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '人群包id'
            ],
            'target_advertiser_ids' => [
                'type' => 'array',
                'required' => true,
                'desc' => '推送广告主id列表'
            ]
        ],
        'data_source_read' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'data_source_id_list' => [
                'type' => 'array',
                'required' => true,
                'desc' => '数据源ID列表'
            ]
        ],
        'custom_audience_publish' => [
            'advertiser_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ],
            'custom_audience_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id',
            ]
        ]
    ],
    'material_type' => [
        'CREATIVE_IMAGE_MODE_SMALL' => [
            'name' => '小图',
            'memory_size' => round(500 / 1024, 2), // 图片大小，m为单位
            'min_size' => '228*150', // 图片最小尺寸
            'max_size' => '1368*900', // 图片最大尺寸
            'recommend_size' => '456*300', // 图片推荐尺寸
        ],
        'CREATIVE_IMAGE_MODE_LARGE' => [
            'name' => '大图横图',
            'memory_size' => round(500 / 1024, 2),
            'min_size' => '690*388',
            'max_size' => '2560*1440',
            'recommend_size' => '1280*720',
        ],
        'CREATIVE_IMAGE_MODE_GROUP' => [
            'name' => '组图',
            'memory_size' => round(500 / 1024, 2),
            'min_size' => '456*300',
        ],
        'CREATIVE_IMAGE_MODE_VIDEO' => [
            'name' => '	横版视频',
            'memory_size' => 1000,
            'cover_min_size' => '690*388', // 封面图大小
            'cover_max_size' => '2560*1440', // 封面图大小
            'allow_mime_type' => 'video/mp4,video/mpeg,video/3gpp,video/x-msvideo'
        ],
        'CREATIVE_IMAGE_MODE_GIF' => [
            'name' => '	GIF图',
            'memory_size' => 2,
        ],
        'CREATIVE_IMAGE_MODE_LARGE_VERTICAL' => [
            'name' => '大图竖图',
            'memory_size' => round(500 / 1024, 2),
            'min_size' => '720*1280',
        ],
        'CREATIVE_IMAGE_MODE_VIDEO_VERTICAL' => [
            'name' => '竖版视频',
            'memory_size' => 100,
            'cover_min_size' => '690*388',
            'cover_max_size' => '2560*1440',
            'allow_mime_type' => 'video/mp4,video/mpeg,video/3gpp,video/x-msvideo'
        ]
    ]
];