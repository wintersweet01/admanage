<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<style type="text/css">
    .table-header .navbar {
        margin-bottom: 0px;
    }

    .table-header .navbar-collapse {
        position: unset !important;
        background-color: unset !important;
        z-index: unset !important;
    }

    .table-header .form-group {
        margin-bottom: 15px;
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

                            <label>负责人</label>
                            <select name="create_user" class="form-control" style="width:60px;">
                                <option value="all">全 部</option>
                                <{foreach from=$_admins key=id item=name}>
                            <option value="<{$id}>" <{if $create_user==$id}>selected="selected"<{/if}>><{$name}></option>
                                <{/foreach}>
                            </select>

                            <label>关键字</label>
                            <input type="text" class="form-control" name="keyword" value="<{$data.keyword}>" placeholder="推广名称/推广链ID/分包名"/>

                            <button type="button" class="btn btn-primary btn-sm" id="submit">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                            </button>
                            <a href="?ct=extend&ac=linkDiscountAdd" class="btn btn-danger btn-sm" role="button">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加扣量
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows">
        <table id="LAY-table-report" lay-filter="report"></table>
        <script type="text/html" id="toolbar-report">
            <div class="layui-btn-container">
                <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">
                    <i class="layui-icon">&#xe640;</i><span>删除所选</span>
                </button>
            </div>
        </script>
        <script type="text/html" id="toolbar-menu">
            <a href="/?ct=extend&ac=linkDiscountAdd&monitor_id={{d.monitor_id}}" class="layui-btn layui-btn-xs"><i class="fa fa-pencil-square fa-fw"></i>编辑</a>
        </script>
    </div>
</div>
<script>
    layui.config({
        version: '2019021310',
    }).use('table', function () {
        var table = layui.table;
        var cols = [[
            {type: 'checkbox'},
            {field:'monitor_id', width:80, title: '推广ID', align: 'center', totalRowText: '合计'},
            {field:'monitor_name', minWidth:300, title: '推广名称', align: 'center'},
            {field:'parent_name', width:100, title: '母游戏', align: 'center'},
            {field:'game_name', width:150, title: '游戏名称', align: 'center'},
            {field:'package_name', width:250, title: '游戏包', align: 'center'},
            {field:'channel_name', width:100, title: '渠道名称', align: 'center'},
            {
                field: 'is_open',
                width: 60,
                title: '投放',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.is_open == '1') {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    }
                    return str;
                }
            },
            {
                field: 'is_discount',
                width: 60,
                title: '扣量',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.is_discount == '1') {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    }
                    return str;
                }
            },
            {field:'discount_pay', width:90, title: '充值扣量', align: 'center'},
            {field:'discount_reg', width:90, title: '注册扣量', align: 'center'},
            {field:'open_sdate', width:120, title: '投放开始日期', align: 'center'},
            {field:'open_edate', width:120, title: '投放结束日期', align: 'center'},
            {field:'discount_sdate', width:120, title: '折扣开始日期', align: 'center'},
            {field:'discount_edate', width:120, title: '折扣结束日期', align: 'center'},
            {field:'administrator', width:80, title: '负责人', align: 'center'},
            {
                field: 'is_discount',
                width: 60,
                title: '更新',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.update_text) {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    }
                    return str;
                }
            },
            {minWidth:100, title: '操作', align: 'center', fixed: 'right', toolbar: '#toolbar-menu'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '推广链扣量管理',
            toolbar: '#toolbar-report',
            url: '/?ct=extend&ac=linkDiscount&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            totalRow: true,
            page: true,
            limit: 15,
            cols: cols
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            tableIns.reload({
                where: {
                    data: $('form').serialize()
                },
                page: {
                    curr: 1
                }
            });
        });

        //监听头工具栏事件
        table.on('toolbar(report)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'del':
                    var data = checkStatus.data;
                    var ids = [];

                    if (data.length == 0) {
                        layer.msg('请勾选一个以上');
                        return false;
                    }

                    $.each(data, function (i, n) {
                        if (n.monitor_id == 0) return true;
                        ids.push(n.monitor_id);
                    });

                    if (ids.length <= 0) {
                        return false;
                    }

                    layer.confirm('删除后无法恢复，确定删除吗？', {
                        btn: ['是的', '取消']
                    }, function () {
                        var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                        $.post('?ct=extend&ac=linkDiscountDel', {
                            id: ids.join()
                        }, function (re) {
                            layer.close(index);
                            if (re.state == true) {
                                tableIns.reload();
                            } else {
                                layer.msg(re.msg);
                            }
                        }, 'json');
                    });
                    break;
            }
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });
    });
</script>
<{include file="../public/foot.tpl"}>