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
                            <label>搜索内容</label>
                            <input type="text" class="form-control" name="keyword" value="" placeholder="推广链ID/点击IP/设备号" style="min-width: 300px;"/>

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
            <span class="btn btn-info btn-xs" lay-event="active"><i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i>激活上报</span>
            <span class="btn btn-success btn-xs" lay-event="reg"><i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i>注册上报</span>
            <span class="btn btn-warning btn-xs" lay-event="pay"><i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i>充值上报</span>
        </script>
    </div>
</div>
<link rel="stylesheet" href="<{$_cdn_static_url_}>lib/layui/css/layui.css">
<script src="<{$_cdn_static_url_}>lib/layui/layui.js"></script>
<script>
    layui.config({
        version: '2019101121',
    }).use('table', function () {
        var table = layui.table;

        var cols = [[
            {field:'monitor_id', width: 80, title: 'ID', align: 'center'},
            {field:'monitor_name', width: 200, title: '推广名称'},
            {field:'package_name', width: 220, title: '游戏包', align: 'center'},
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
            {field:'device_id', width:250, title: '设备号', align: 'center', event: 'copy', style:'cursor: pointer;'},
            {field:'click_ip', width:150, title: '点击IP'},
            {field:'area', width:220, title: '点击地区'},
            {field:'click_time', width: 180, title: '点击时间', align: 'center', templet: function (d) {return d.click_time > 0 ? layui.util.toDateString(d.click_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
            {minWidth:280, title: '操作', align: 'center', toolbar: '#toolbar-report'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '用户管理',
            url: '/?ct=extend&ac=clickAd&json=1',
            cellMinWidth: 80,
            height: 'full-150',
            page: true,
            limit: 18,
            limits: [18, 50, 100, 200, 500],
            cols: cols,
            done: function (res, curr, count) {

            }
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            tableIns.reload({
                where: {
                    keyword: $('input[name="keyword"]').val()
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
                case 'active': //激活上报
                case 'reg': //注册上报
                case 'pay': //上报
                    let arr = {
                        'active': '激活',
                        'reg': '注册',
                        'pay': '充值'
                    };

                    layer.confirm('确定手动' + arr[layEvent] + '上报吗？<br><br><span class="red">手动上报的数据为【模拟数据】</span>', function () {
                        let index = layer.msg('正在上报中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                        $.post('/?ct=extend&ac=clickAdUpload', {
                            type: layEvent,
                            id: data.id
                        }, function (re) {
                            layer.close(index);
                            if (re.state) {
                                layer.alert('上报成功，回调结果：<br>' + re.data.result);
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