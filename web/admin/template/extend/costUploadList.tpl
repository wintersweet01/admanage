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

                            <label>游戏包</label>
                            <select class="form-control" name="package_name" id="package_id" style="width: 150px;">
                                <option value="">全 部</option>
                            </select>

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
                            </select>&nbsp;

                            <label>日期</label>
                            <input type="text" name="date" value="" class="form-control Wdate" style="width: 100px;"/>

                            <button type="button" class="btn btn-primary btn-sm" id="submit">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                            </button>
                            <button type="button" class="btn btn-success btn-sm" id="upload">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 录入成本
                            </button>
                            <a href="?ct=extend&ac=costUpload" class="btn btn-danger btn-sm" role="button">
                                <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 导入成本
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
                    <i class="layui-icon">&#xe640;</i><span>删除所选</span></button>
            </div>
        </script>
    </div>
</div>
<script>
    $(function () {
        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html).trigger('change');
            });
        });
    });

    layui.config({
        version: '2019021310',
    }).use('table', function () {
        var table = layui.table;
        var cols = [[
            {type: 'checkbox'},
            {field:'monitor_id', width:80, title: '推广ID', align: 'center', totalRowText: '合计'},
            {field:'date', width:120, title: '日期', align: 'center'},
            {field:'parent_name', width:100, title: '母游戏', align: 'center'},
            {field:'game_name', width:150, title: '游戏名称', align: 'center'},
            {field:'package_name', width:280, title: '游戏包', align: 'center'},
            {
                field: 'device_type',
                width: 60,
                title: '平台',
                align: 'center',
                templet: function (d) {
                    var str = '-';
                    if (d.device_type == 1) {
                        str = '<span class="icon_ios"></span>';
                    } else if (d.device_type == 2) {
                        str = '<span class="icon_android"></span>';
                    }
                    return str;
                }
            },
            {field:'channel_name', width:100, title: '渠道名称', align: 'center'},
            {field:'monitor_name', minWidth:350, title: '推广名称', align: 'center'},
            {field:'cost_yuan', width:120, title: '成本（元）', align: 'center', sort: true, style:'color: #a94442;', edit: 'text', totalRow: true},
            {field:'display', width:120, title: '展示量', align: 'center', sort: true, edit: 'text', totalRow: true},
            {field:'click', width:120, title: '点击量', align: 'center', sort: true, edit: 'text', totalRow: true}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '广告成本',
            toolbar: '#toolbar-report',
            url: '/?ct=extend&ac=costUploadList&json=1',
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

        //录入成本
        $('#upload').on('click', function () {
            layer.confirm('请筛选录入条件，然后在查询结果的列表中点击单元格输入数据。<br><br>是否已选择好条件？', {
                btn: ['是的', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                layer.closeAll();
                tableIns.reload({
                    where: {
                        data: $('form').serialize(),
                        upload: 1
                    },
                    page: {
                        curr: 1
                    }
                });
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
                        if (n.id == 0) return true;
                        ids.push(n.id);
                    });

                    if (ids.length <= 0) {
                        return false;
                    }

                    layer.confirm('删除后无法恢复，确定删除吗？', {
                        btn: ['是的', '取消']
                    }, function () {
                        var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                        $.post('?ct=extend&ac=costUploadDel', {
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

        //单元格事件
        table.on('edit(report)', function (obj) {
            var val = obj.value,
                field = obj.field;

            if (!$.isNumeric(val)) {
                $(this).val(0);
                return false;
            }

            $.post('?ct=extend&ac=costUploadEdit', {
                field: field,
                value: val,
                data: obj.data
            }, function (re) {
                if (re.state == false) {
                    layer.msg(re.msg);
                }
            }, 'json');
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });
    });
</script>
<{include file="../public/foot.tpl"}>