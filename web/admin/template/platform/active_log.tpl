<{include file="../public/header.tpl"}>
<style type="text/css">
    .table-header .navbar {
        margin-bottom: 0px;
        min-height: auto;
    }

    .table-header .navbar-collapse {
        position: unset !important;
        background-color: unset !important;
        z-index: unset !important;
    }

    .select2-container .select2-selection--multiple {
        min-height: 22px !important;
        margin-bottom: 5px;
    }
</style>
<div id="areascontent">
    <div class="rows table-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-table-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1">
                    <form class="form-inline navbar-form navbar-left" method="get" action="">
                        <div class="form-group form-group-sm">
                            <{widgets widgets=$widgets}>

                            <label>选择渠道</label>
                            <select class="form-control" name="channel_id">
                                <option value="">全 部</option>
                                <{foreach from=$_channels key=id item=name}>
                                <option value="<{$id}>"><{$name}></option>
                                <{/foreach}>
                            </select>

                            <label>激活时间</label>
                            <input type="text" name="date" value="" class="form-control Wdate"/>
                            <input type="text" name="edate" value="" class="form-control Wdate"/>

                            <label>设备号</label>
                            <input type="text" class="form-control" name="device_id" value="" placeholder="IMEI或者IDFA" style="min-width: 250px;"/>

                            <button type="button" class="btn btn-primary btn-sm" id="submit">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <div class="rows">
        <table id="LAY-table-report" lay-filter="report"></table>
        <input type="text" id="copy" value="" style="position: absolute;opacity:0;">
        <script type="text/html" id="toolbar-report">
            {{# if(d.monitor_id > 0){ }}
            <span class="btn btn-info btn-xs" lay-event="activeCallback"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 激活回调</span>
            {{# } }}
        </script>
    </div>
</div>
<link rel="stylesheet" href="<{$_cdn_static_url_}>lib/layui/css/layui.css">
<script src="<{$_cdn_static_url_}>lib/layui/layui.js"></script>
<script>
    layui.config({
        version: '2019081921',
    }).use('table', function () {
        var table = layui.table;
        var games = JSON.parse('<{$_games|@json_encode nofilter}>');
        var channels = JSON.parse('<{$_channels|@json_encode nofilter}>');
        var cols = [[
            {field:'parent_name', width: 100, title: '母游戏', align: 'center', templet: function (d) {return games[d.parent_id];}},
            {field:'game_name', width: 160, title: '游戏', align: 'center', templet: function (d) {return games[d.game_id];}},
            {field:'package_name', width:250, title: '游戏包', align: 'center'},
            {
                field: 'device_type',
                width: 60,
                title: '平台',
                align: 'center',
                templet: function (d) {
                    let str = '-';
                    if (d.device_type == 3) {
                        str = '<i class="fa fa-html5 fa-lg text-primary" aria-hidden="true"></i>';
                    } else if (d.device_type == 2) {
                        str = '<i class="fa fa-android fa-lg text-success" aria-hidden="true"></i>';
                    } else if (d.device_type == 1) {
                        str = '<i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>';
                    }
                    return str;
                }
            },
            {field:'package_version', width:80, title: '包版本', align: 'center'},
            {field:'sdk_version', width:100, title: 'SDK版本', align: 'center'},
            {field:'active_city', width:100, title: '激活地区', align: 'center'},
            {field:'active_ip', width:150, title: '激活IP', align: 'center'},
            {field:'active_time', width:180, title: '激活时间', align: 'center', templet: function (d) {return d.active_time > 0 ? layui.util.toDateString(d.active_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
            {field:'device_id', width:180, title: '设备号', align: 'center', event: 'copy', style:'cursor: pointer;'},
            {field:'uuid', width:150, title: 'UUID', align: 'center'},
            {field:'click_time', width: 180, title: '点击时间', align: 'center', templet: function (d) {return d.click_time > 0 ? layui.util.toDateString(d.click_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
            {field:'channel_name', width:100, title: '渠道', align: 'center', templet: function (d) {return channels[d.channel_id];}},
            {field:'monitor_name', width:300, title: '来源', align: 'center'},
            {field:'device_name', width:120, title: '设备型号', align: 'center'},
            {field:'device_version', width:100, title: '系统版本', align: 'center'},
            {field:'os_flag', width:100, title: '系统标识', align: 'center'},
            {field:'resolution', width:100, title: '分辨率', align: 'center'},
            {field:'producer', width:100, title: '设备厂商', align: 'center'},
            {field:'isp', width:100, title: '网络运营商', align: 'center'},
            {field:'network_type', width:100, title: '网络类型', align: 'center'},
            {minWidth:120, title: '操作', align: 'center', fixed: 'right', toolbar: '#toolbar-report'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '用户管理',
            url: '/?ct=platform&ac=activeLog&json=1',
            cellMinWidth: 80,
            height: 'full-150',
            page: true,
            limit: 18,
            limits: [20, 50, 100, 200, 500],
            cols: cols,
            done: function (res, curr, count) {
                var query = res.query;
                $('input[name="date"]').val(query.date);
                $('input[name="edate"]').val(query.edate);
            }
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            tableIns.reload({
                cols: cols,
                where: {
                    data: $('form').serialize()
                },
                page: {
                    curr: 1
                }
            });
        });

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

            switch (layEvent) {
                case 'copy': //复制
                    var input = $('#copy');
                    input.val(data.device_id);
                    input.select();
                    var boolean = document.execCommand("Copy");
                    if (boolean) {
                        layer.tips('复制成功', $this, {
                            tips: [4, '#3595CC'],
                            time: 2000
                        });
                    } else {
                        layer.tips('复制失败', $this, {
                            tips: [4, '#FF0000'],
                            time: 2000
                        });
                    }
                    break;
                case 'activeCallback':
                    layer.confirm('确定重新激活回调吗？', {
                        btn: ['确定', '取消'],
                        icon: 7,
                        title: '激活回调提示'
                    }, function () {
                        var index = layer.msg('正在激活中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                        $.post('/?ct=platform&ac=activeCallback', {
                            id: data.id
                        }, function (re) {
                            layer.close(index);
                            if (re.state) {
                                layer.alert('激活回调成功：<br>' + re.data.result);
                            } else {
                                layer.alert(re.msg);
                            }
                        }, 'json');
                    });
                    break;
            }
        });
    });
</script>
<{include file="../public/foot.tpl"}>