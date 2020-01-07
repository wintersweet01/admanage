<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<div class="layui-fluid">
    <table class="layui-hide" id="LAY-table-report" lay-filter="report"></table>
</div>
<script>
    layui.config({
        version: '2019030112',
    }).use('table', function () {
        var table = layui.table;
        var cols = [[
            {field:'uid', width:80, title: 'UID', align: 'center', fixed: 'left'},
            {field:'username', width: 120, title: '账号', align: 'center', fixed: 'left', event: 'showUserInfo', style:'cursor: pointer;'},
            {field:'parent_name', width:100, title: '母游戏', align: 'center'},
            {field:'game_name', width:150, title: '注册游戏', align: 'center'},
            {field:'pay_game_name', width:150, title: '充值游戏', align: 'center'},
            {field:'active_pay_money', width:100, title: '充值金额', align: 'center'},
            {field:'active_pay_sum', width:100, title: '充值次数', align: 'center'},
            {field:'arppu', width:100, title: 'ARPPU', align: 'center'},
            {field:'date', width:120, title: '充值日期', align: 'center'},
            {field:'package_name', width:260, title: '游戏包', align: 'center'},
            {
                field: 'device_type',
                width: 60,
                title: '平台',
                align: 'center',
                templet: function (d) {
                    var str = '-';
                    if (d.device_type == 1) {
                        str = '<i class="fa fa-apple fa-lg"></i>';
                    } else if (d.device_type == 2) {
                        str = '<i class="fa fa-android fa-lg"></i>';
                    }
                    return str;
                }
            },
            {field:'reg_maxlevel', width:100, title: '注册最高等级', align: 'center'},
            {field:'maxlevel', width:100, title: '最高等级', align: 'center'},
            {field:'reg_city', width:100, title: '注册地区', align: 'center'},
            {field:'reg_ip', width:150, title: '注册IP', align: 'center'},
            {field:'reg_time', width:180, title: '注册时间', align: 'center'},
            {field:'active_time', width:180, title: '激活时间', align: 'center'},
            {field:'last_login_time', width:180, title: '最后登录时间', align: 'center'},
            {field:'channel_name', width:100, title: '渠道', align: 'center'},
            {field:'monitor_name', minWidth:300, title: '来源', align: 'center'},
            {field:'device_name', width:100, title: '设备型号', align: 'center'},
            {field:'device_version', width:100, title: '系统版本', align: 'center'},
            {field:'os_flag', width:100, title: '系统标识', align: 'center'},
            {field:'resolution', width:100, title: '分辨率', align: 'center'},
            {field:'producer', width:100, title: '设备厂商', align: 'center'},
            {field:'isp', width:100, title: '网络运营商', align: 'center'},
            {field:'network_type', width:100, title: '网络类型', align: 'center'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '注册用户信息列表 - 推广数据总表',
            url: '/?ct=adData&ac=queryActive&json=1&data=<{$query}>',
            cellMinWidth: 80,
            height: 'full-100',
            page: true,
            limit: 18,
            cols: cols
        };

        var tableIns = table.render(options);

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        //监听工具条
        table.on('tool(report)', function (obj) {
            var $this = $(this);
            var data = obj.data;
            var layEvent = obj.event;
            var uid = data.uid;

            switch (layEvent) {
                case 'showUserInfo': //查用户信息
                    JsMain.search(uid);
                    break;
            }
        });
    });
</script>
<{include file="../public/foot.tpl"}>