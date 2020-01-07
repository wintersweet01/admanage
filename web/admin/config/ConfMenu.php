<?php
return array(
    'platform' => array(
        'name' => '平台管理',
        'icon' => 'home',
        'first_menu' => 'platform',
        'menu' => array(
            'gameList' => '游戏管理',
            'packageList' => '游戏包管理',
            'packageGift' => '礼包管理',
            'platformList' => '渠道管理',
            'userList' => '用户管理',
            'orderList' => '订单管理',
            'orderReplacementList' => '直充补单',
            'roleList' => '角色管理',
            'activeLog' => '激活日志',
            'logList' => '用户日志',
            'config' => '系统配置',
            'playerLog' => '玩家日志',
            'acceptTest' => '测试验收',
        ),
    ),
    'user' => array(
        'name' => '用户管理',
        'icon' => 'file-text',
        'first_menu' => 'platform',
        'menu' => array(
            'forbidden' => '封禁管理',
            'relateHot' => '关联排行'
        ),
    ),
    'article' => array(
        'name' => '文章管理',
        'icon' => 'file-text',
        'first_menu' => 'platform',
        'menu' => array(
            'article' => '文章管理'
        ),
    ),
    'extend' => array(
        'name' => '推广管理',
        'icon' => 'tag',
        'first_menu' => 'ad',
        'menu' => array(
            'landModel' => '落地页模板管理',
            'landPage' => '落地页管理',
            'linkList' => '推广链管理',
            'channelLog' => '推广链回调日志',
            'costUploadList' => '推广成本管理',
            'linkDiscount' => '推广链扣量管理',
            'asoDiscount' => 'ASO联运扣量管理',
            'splitManage' => '分成管理',
            'clickAd' => '广告点击日志',
        ),
    ),
    'data' => array(
        'name' => '数据总览',
        'icon' => 'database',
        'first_menu' => 'data',
        'menu' => array(
            'online' => '游戏实时在线',
            'overview' => '游戏总览',
            'dataDay' => '数据日报',
            'overviewMonth' => '分月游戏总览',
            'serverCondition' => '分服状况',
            'ltv' => 'LTV',
            'roi' => 'ROI',
            'newViewData' => '新增数据查看',
            'payHall' => '充值排行榜',
            'payHallRole' => '充值角色排行榜',
            'putinByDay' => '按日投放效果报表'
        ),
    ),
    'data1' => array(
        'name' => '投放数据表',
        'icon' => 'table',
        'first_menu' => 'data',
        'menu' => array(
            'overviewDay' => '渠道数据日表',
            //'overviewHour' => '渠道数据时表',
            'channelDay' => '渠道数据日表(新)',
            'channelHour' => '渠道数据时表(新)',
            'regHour' => '按渠道每小时新增注册',
            'ltvNew' => 'LTV',
        ),
    ),
    'data4' => array(
        'name' => '运营数据表',
        'icon' => 'table',
        'first_menu' => 'data',
        'menu' => array(
            'overview2' => '基础数据',
            'regHour' => '按天每小时新增注册',
            'payHour' => '按天每小时充值',
            'onlineHour' => '按天实时在线',
            'ltv' => 'LTV',
            'serverView' => '按服充值统计',
            'overview2ByHour' => '基础数据(分时)',
            'newUserData' => '新增玩家数据',
            'newPayDevote' => '新增充值贡献',
            'newPayPermeability' => '新增付费渗透率',
            'dayChargeData' => '每日充值统计',
        ),
    ),
    'retainData' => array(
        'name' => '留存数据',
        'icon' => 'area-chart',
        'first_menu' => 'data',
        'menu' => array(
            'retain' => '账号留存数',
            'retainNew' => '实时留存统计',
            'channelRetain' => '渠道留存数',
            'payRetain' => '付费留存',
        ),
    ),
    'data2' => array(
        'name' => '付费数据统计',
        'icon' => 'bar-chart',
        'first_menu' => 'data',
        'menu' => array(
            'payHabitDate' => '日期付费数据统计',
            'payHabitChannel' => '渠道付费数据统计',
            'payHabitServer' => '区服付费数据统计',
            'payArea' => '地区付费数据统计',
            'channelHourPay' => '每小时新增付费',
        ),
    ),
    'ad' => array(
        'name' => '推广设置',
        'icon' => 'gamepad',
        'first_menu' => 'ad',
        'menu' => array(
            'channelList' => '推广渠道',
            'deliveryGroup' => '投放组管理',
            'adCompany' => '广告资质公司',
            'deliveryUser' => '投放账户',
        ),
    ),
    'material' => array(
        'name' => '素材',
        'icon' => 'file-image-o',
        'first_menu' => 'ad',
        'menu' => array(
            'materialBox' => '素材库',
            'materialData' => '投放反馈表',
            'materialData2' => '素材反馈表',
            'materialTotal' => '素材综合统计',
            'materialDay' => '个人分日统计'
        ),
    ),
    'adData' => array(
        'name' => '推广数据',
        'icon' => 'table',
        'first_menu' => 'ad',
        'menu' => array(
            'channelOverview' => '推广数据总表',
            'userEffect' => '分账号效果表',
            'channelEffect' => '分渠道效果表',
            'dayChannelEffect' => '分日分渠道效果表',
            'channelCycle' => '分渠道回收',
            'channelCycleT' => '分渠道回收周期',
            'channelOverviewSp' => '分成推广数据总表',
            'hourOverview' => '分时推广数据表',
        ),
    ),
    'adDataAndorid' => array(
        'name' => '推广数据（安卓）',
        'icon' => 'android',
        'first_menu' => 'ad',
        'menu' => array(
            'userEffect' => '分账号效果表(安卓)',
            'activityEffect' => '分推广活动效果表(安卓)',
            'hourLand' => '分时段落地页转化表(安卓)',
            'dayUserEffect' => '分日分账号效果表(安卓)',
            'userCycle' => '分账号回收(安卓)',
        ),
    ),
    'adDataIOS' => array(
        'name' => '推广数据（苹果）',
        'icon' => 'apple',
        'first_menu' => 'ad',
        'menu' => array(
            'userEffect' => '分账号效果表(苹果)',
            'activityEffect' => '分推广活动效果表(苹果)',
            'hourLand' => '分时段落地页转化表(苹果)',
            'dayUserEffect' => '分日分账号效果表(苹果)',
            'userCycle' => '分账号回收(苹果)',
        ),
    ),
    'operateReceipt' => array(
        'name' => '营业收入',
        'icon' => 'dollar',
        'first_menu' => 'data',
        'menu' => array(
            'operateReceiptDate' => '按日期',
            'operateReceiptGame' => '按游戏',
        ),
    ),
    'destribuReceipt' => array(
        'name' => '分成后收入',
        'icon' => 'pie-chart',
        'first_menu' => 'data',
        'menu' => array(
            'destribuReceiptDate' => '按日期',
            'destribuReceiptGame' => '按游戏',
            'destribuConfList' => '分成配置列表',
        ),
    ),
    'admin' => array(
        'name' => '系统设置',
        'icon' => 'cogs',
        'first_menu' => 'config',
        'menu' => array(
            'adminList' => '管理员设置',
            'roleList' => '角色管理',
            'groupList' => '投放组管理',
        ),
    ),
    'data3' => array(
        'name' => '产品回收',
        'icon' => 'recycle',
        'first_menu' => 'data',
        'menu' => array(
            'payRetainAll' => '渠道综合',
            'payRetain&type=pay' => '渠道充值',
            'payRetain&type=roi' => '渠道ROI',
            'payRetain&type=ltv' => '渠道LTV',
        ),
    ),
    'service' => array(
        'name' => '客服管理',
        'icon' => 'user',
        'first_menu' => 'service',
        'menu' => array(
            'userList' => '用户管理',
            'orderList' => '订单管理',
            'roleList' => '角色管理',
            'activeLog' => '激活日志',
        ),
    ),
    'kfVip' => array(
        'name' => '客服VIP管理',
        'icon' => 'user',
        'first_menu' => 'service',
        'menu' => array(
            'vipManage' => 'VIP管理',
            'vipAchieve' => 'VIP业绩',
            'vipRecord' => 'VIP档案管理',
            'userLink' => '用户联系',
            'author' => '权限管理'
        ),
    ),
    'data5' => array(
        'name' => '媒介数据',
        'icon' => 'table',
        'first_menu' => 'data',
        'menu' => array(
            'external1' => 'cps',
            'external2' => 'cpa',
            'external3' => 'ASO联运',
        ),
    ),
    'system' => array(
        'name' => '系统管理',
        'icon' => 'cogs',
        'first_menu' => 'market',
        'menu' => array(
            'adioManage' => 'ADIO管理',
            'mediaAccountManage' => '媒体账号管理',
            'appManage' => '应用管理'
        )
    ),

    'optimizat' => array(
        'name' => '优化中心',
        'icon' => 'line-chart',
        'first_menu' => 'market',
        'menu' => array(
            'adCnter' => '新建广告',
            'adMaterial' => '素材管理',
            'adCopywriting' => '文案管理'
        )
    ),

    'auxTool' => array(
        'name' => '辅助工具',
        'icon' => 'wrench',
        'first_menu' => 'market',
        'menu' => array(
            'toolList' => '广告工具箱',
        )
    )

);