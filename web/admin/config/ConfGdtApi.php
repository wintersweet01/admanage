<?php
return [
    'domain' => [
        'debug' => 'https://sandbox-api.e.qq.com/v1.1',
        'production' => 'https://api.e.qq.com/v1.1'
    ],
    'api' => [
        'create_group' => '/adgroups/add',
        'create_ad_plan' => '/campaigns/add',
        'create_ad_originality' => '/adcreatives/add',
        'create_ad' => '/ads/add',
        'upload_ad_img' => '/images/add',
        'upload_ad_video'  => '/videos/add'
    ],
    'api_param_rule' => [
        'create_group' => [
            'account_id' => [
                'type' => 'int',
                'required' => true,
                'desc' => '广告主id'
            ],
            'campaign_id' => [
                'type'=> 'int',
                'required' => true,
                'desc' => '推广计划id',
            ],
            'adgroup_name' => [
                'type' => 'string',
                'required' => true,
                'min' => 1,
                'max' => 120
            ],
            'promoted_object_type' => [
                'type' => 'string',
                'required' => true,
                'value' => [
                    'PROMOTED_OBJECT_TYPE_LINK',
                    'PROMOTED_OBJECT_TYPE_LINK_WECHAT',
                    'PROMOTED_OBJECT_TYPE_ECOMMERCE',
                    'PROMOTED_OBJECT_TYPE_APP_ANDROID',
                    'PROMOTED_OBJECT_TYPE_APP_IOS',
                    'PROMOTED_OBJECT_TYPE_APP_ANDROID_MYAPP',
                    'PROMOTED_OBJECT_TYPE_APP_ANDROID_UNION',
                    'PROMOTED_OBJECT_TYPE_QQ_BROWSER_MINI_PROGRAM',
                    'PROMOTED_OBJECT_TYPE_LOCAL_ADS_WECHAT',
                    'PROMOTED_OBJECT_TYPE_QQ_MESSAGE',
                    'PROMOTED_OBJECT_TYPE_LEAD_AD',
                    'PROMOTED_OBJECT_TYPE_MINI_GAME_WECHAT '
                ],
                'desc' => '推广目标类型'
            ],
            'begin_date' => [
                'type' => 'date',
                'required' => true,
                'desc' => '开始投放日期',
                'format' => 'Y-m-d',
            ],
            'end_date' => [
                'type' => 'date',
                'required'=> true,
                'desc' => '结束投放日期'
            ],
            'billing_event' => [
                'type' => 'string',
                'required' => true,
                'value' => [
                    'BILLINGEVENT_CLICK',
                    'BILLINGEVENT_APP_DOWNLOAD',
                    'BILLINGEVENT_IMPRESSION'
                ],
            ],
            'bid_amount' => [
                'type' => 'int',
                'min' => 1,
                'required' => true,
                'desc' => '广告出价'
            ],
            'optimization_goal' => [
                'type' => 'string',
                'required' => true,
                'desc' => '广告优化目标类型',
                'value' => [
                    'OPTIMIZATIONGOAL_BRAND_CONVERSION',
                    'OPTIMIZATIONGOAL_FOLLOW',
                    'OPTIMIZATIONGOAL_CLICK',
                    'OPTIMIZATIONGOAL_IMPRESSION',
                    'OPTIMIZATIONGOAL_APP_DOWNLOAD',
                    'OPTIMIZATIONGOAL_APP_ACTIVATE',
                    'OPTIMIZATIONGOAL_APP_REGISTER',
                    'OPTIMIZATIONGOAL_ONE_DAY_RETENTION',
                    'OPTIMIZATIONGOAL_APP_PURCHASE',
                    'OPTIMIZATIONGOAL_ECOMMERCE_ORDER',
                    'OPTIMIZATIONGOAL_ECOMMERCE_CHECKOUT',
                    'OPTIMIZATIONGOAL_LEADS',
                    'OPTIMIZATIONGOAL_ECOMMERCE_CART',
                    'OPTIMIZATIONGOAL_PROMOTION_CLICK_KEY_PAGE',
                    'OPTIMIZATIONGOAL_VIEW_COMMODITY_PAGE',
                    'OPTIMIZATIONGOAL_ONLINE_CONSULTATION',
                    'OPTIMIZATIONGOAL_TELEPHONE_CONSULTATION',
                    'OPTIMIZATIONGOAL_PAGE_RESERVATION',
                    'OPTIMIZATIONGOAL_DELIVERY',
                    'OPTIMIZATIONGOAL_MESSAGE_AFTER_FOLLOW',
                    'OPTIMIZATIONGOAL_CLICK_MENU_AFTER_FOLLOW',
                    'OPTIMIZATIONGOAL_PAGE_EFFECTIVE_ONLINE_CONSULT',
                    'OPTIMIZATIONGOAL_PAGE_EFFECTIVE_PHONE_CALL'
                ]
            ],
            'time_series' => [
                'type' => 'string',
                'required' => true,
                'desc' => '投放时间段',
            ],
            'automatic_site_enabled' => [
                'type' => 'bool',
                'required' => false,
                'desc' => '是否开启自动版位功能'
            ],
            'site_set' => [
                'type' => 'array',
                'required' => false,
                'value' => [
                    'SITE_SET_QZONE',
                    'SITE_SET_QQCLIENT',
                    'SITE_SET_MUSIC',
                    'SITE_SET_MOBILE_UNION',
                    'SITE_SET_QQCOM',
                    'SITE_SET_WECHAT',
                    'SITE_SET_MOBILE_INNER',
                    'SITE_SET_TENCENT_NEWS',
                    'SITE_SET_TENCENT_VIDEO',
                    'SITE_SET_TENCENT_KUAIBAO',
                    'SITE_SET_MOBILE_MYAPP',
                    'SITE_SET_PCQQ'
                ]
            ]
        ],
        'create_ad_plan' => [
            'account_id' => [
                'type' => 'int',
                'required' => true,
                'desc' => '广告主id'
            ],
            'campaign_name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '计划名称',
                'min' => 1,
                'max' => 120
            ],
            'campaign_type' => [
                'type' => 'string',
                'required' => true,
                'value' => ['CAMPAIGN_TYPE_NORMAL', 'CAMPAIGN_TYPE_WECHAT_MOMENTS '],
                'desc' => '推广计划类型',
            ],
            'promoted_object_type' => [
                'type' => 'string',
                'required' => false,
                'desc' => '推广目标类型',
                'value' => [
                    'PROMOTED_OBJECT_TYPE_LINK',
                    'PROMOTED_OBJECT_TYPE_LINK_WECHAT',
                    'PROMOTED_OBJECT_TYPE_ECOMMERCE',
                    'PROMOTED_OBJECT_TYPE_APP_ANDROI',
                    'PROMOTED_OBJECT_TYPE_APP_IO',
                    'PROMOTED_OBJECT_TYPE_APP_ANDROID_MYAPP',
                    'PROMOTED_OBJECT_TYPE_APP_ANDROID_UNION',
                    'PROMOTED_OBJECT_TYPE_QQ_BROWSER_MINI_PROGRAM',
                    'PROMOTED_OBJECT_TYPE_LOCAL_ADS_WECHAT',
                    'PROMOTED_OBJECT_TYPE_QQ_MESSAGE',
                    'PROMOTED_OBJECT_TYPE_LEAD_AD',
                    'PROMOTED_OBJECT_TYPE_MINI_GAME_WECH'
                ]
            ],
            'daily_budget' => [
                'type' => 'int',
                'required' => false,
                'desc' => '日消耗限额',
                'min' => 0,
            ],
            'configured_status' => [
                'type' => 'string',
                'required' => false,
                'value' => ['AD_STATUS_NORMAL', 'AD_STATUS_SUSPEND'],
                'desc' => '客户设置的状态'
            ],
            'speed_mode' => [
                'type' => 'string',
                'required' => false,
                'value' => ['SPEED_MODE_FAST', 'SPEED_MODE_STANDARD'],
                'desc' => '投放速度模式'
            ]
        ],
        'create_ad_originality' => [
            'account_id' => [
                'type' => 'int',
                'required' => true,
                'desc' => '广告主id'
            ],
            'campaign_id' => [
                'type' => 'int',
                'required' => true,
                'desc' => '推广计划id'
            ],
            'adcreative_name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '推广创意名称',
                'min' => 1,
                'max' => 120,
            ],
            'adcreative_template_id' => [
                'type' => 'int',
                'required' => true,
                'desc' => '创意规格id'
            ],
            'adcreative_elements' => [
                'type' => 'string',
                'required' => false,
                'desc' => '创意元素'
            ],
            'page_type' => [
                'type' => 'string',
                'required' => false,
                'desc' => '落地页类型',
                'value' => [
                    'PAGE_TYPE_DEFAULT',
                    'PAGE_TYPE_TSA_APP',
                    'PAGE_TYPE_TSA_WEB_NONE_ECOMMERCE',
                    'PAGE_TYPE_CANVAS_WECHAT',
                    'PAGE_TYPE_MINI_PROGRAM_WECHAT',
                    'PAGE_TYPE_FENGYE_ECOMMERC',
                    'PAGE_TYPE_MINI_GAME_WECHA',
                ]
            ],

        ],
        'create_ad' => [
            'account_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id'
            ],
            'adgroup_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id'
            ],
            'adcreative_id'  => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id'
            ],
            'ad_name' => [
                'type' => 'string',
                'required' => true,
                'desc' => '广告名称'
            ]
        ],
        'upload_ad_img' => [
            'account_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id'
            ],
            'upload_type' => [
                'type' => 'string',
                'required' => true,
                'desc' => '上传方式',
                'value' => ['UPLOAD_TYPE_FILE', 'UPLOAD_TYPE_BYTES']
            ],
            'signature' => [
                'type' => 'string',
                'required'=> true,
                'desc' => '图片文件签名'
            ]
        ],
        'upload_ad_video' => [
            'account_id' => [
                'type' => 'numeric',
                'required' => true,
                'desc' => '广告主id'
            ],
            'signature' => [
                'type' => 'string',
                'required'=> true,
                'desc' => '视频文件签名'
            ]
        ]
    ]
];