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
                        <div class="form-group">
                            <label>搜索</label>
                            <input type="text" class="form-control" name="keyword" value=""/>

                            <input type="radio" name="type" value="1" checked/>IP
                            <input type="radio" name="type" value="2"/>设备号
                            <input type="radio" name="type" value="3"/>账号

                            <button type="button" class="btn btn-primary btn-xs" id="submit">筛 选</button>
                            <span id="add" class="btn btn-danger btn-xs" role="button">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加封禁
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows" style="margin-top: 5px;">
        <div class="col-sm-5">
            封禁IP
            <hr class="layui-bg-blue">
            <table id="LAY-table-report1" lay-filter="report"></table>
        </div>
        <div class="col-sm-4">
            封禁设备号
            <hr class="layui-bg-red">
            <table id="LAY-table-report2" lay-filter="report"></table>
        </div>
        <div class="col-sm-3">
            封禁账号
            <hr class="layui-bg-orange">
            <table id="LAY-table-report3" lay-filter="report"></table>
        </div>

        <script type="text/html" id="templet-reg">
            <input type="checkbox" name="reg" value="reg" data-type="{{d.type}}" data-key="{{d.key}}" lay-skin="switch" lay-text="禁|解" lay-filter="forbidden" {{d.reg ? 'checked' : ''}}>
        </script>

        <script type="text/html" id="templet-login">
            <input type="checkbox" name="login" value="login" data-type="{{d.type}}" data-key="{{d.key}}" lay-skin="switch" lay-text="禁|解" lay-filter="forbidden" {{d.login ? 'checked' : ''}}>
        </script>

        <script type="text/html" id="toolbar-handle">
            <span class="layui-btn layui-btn-danger layui-btn-xs" lay-event="handle">解封</span>
        </script>
    </div>
</div>
<script>
    layui.config({
        version: '2019032822',
    }).use(['table', 'form'], function () {
        var table = layui.table,
            form = layui.form,
            obj = [];

        obj['tableIns1'] = table.render({
            elem: '#LAY-table-report1',
            title: '用户管理',
            url: '/?ct=platform&ac=forbidden&type=1&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            limit: 17,
            page: {
                layout: ['prev', 'page', 'next']
            },
            cols: [[
                {field:'key', width:150, title: 'IP', align: 'center'},
                {field:'area', minWidth:100, title: '地区', align: 'center'},
                {field:'reg', width:80, title: '注册', align: 'center', templet: '#templet-reg', unresize: true},
                {field:'login', width:80, title: '登录', align: 'center', templet: '#templet-login', unresize: true},
                {field:'handle', width:80, title: '操作', align: 'center', toolbar: '#toolbar-handle'}
            ]]
        });

        obj['tableIns2'] = table.render({
            elem: '#LAY-table-report2',
            title: '用户管理',
            url: '/?ct=platform&ac=forbidden&type=2&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            limit: 17,
            page: {
                layout: ['prev', 'page', 'next']
            },
            cols: [[
                {field:'key', minWidth:150, title: '设备号', align: 'center'},
                {field:'reg', width:80, title: '注册', align: 'center', templet: '#templet-reg', unresize: true},
                {field:'login', width:80, title: '登录', align: 'center', templet: '#templet-login', unresize: true},
                {field:'handle', width:80, title: '操作', align: 'center', toolbar: '#toolbar-handle'}
            ]]
        });

        obj['tableIns3'] = table.render({
            elem: '#LAY-table-report3',
            title: '用户管理',
            url: '/?ct=platform&ac=forbidden&type=3&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            limit: 17,
            page: {
                layout: ['prev', 'page', 'next']
            },
            cols: [[
                {field:'uid', width:80, title: 'UID', align: 'center'},
                {field:'username', minWidth:120, title: '账号', align: 'center'},
                {field:'handle', width:80, title: '操作', align: 'center', toolbar: '#toolbar-handle'}
            ]]
        });

        //筛选
        $('#submit').on('click', function () {
            var type = $("input[name='type']:checked").val();
            obj['tableIns' + type].reload({
                where: {
                    keyword: $('input[name="keyword"]').val(),
                    type: type
                },
                page: {
                    curr: 1
                }
            });
        });

        //按钮切换
        form.on('switch(forbidden)', function (data) {
            var index = layer.load();
            $.post('?ct=platform&ac=forbiddenUpdate', {
                type: $(data.elem).data('type'),
                key: $(data.elem).data('key'),
                checked: data.elem.checked ? 1 : 0,
                value: data.value
            }, function (re) {
                layer.close(index);
                if (re.state) {
                    if (re.del) {
                        $(data.elem).parents('tr').remove();
                    }
                } else {
                    layer.msg(re.msg);
                }
            }, 'json');
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        //监听工具条
        table.on('tool(report)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;

            //解封
            if (layEvent == 'handle') {
                var index = layer.load();
                $.post('?ct=platform&ac=forbiddenDel', {
                    type: data.type,
                    key: data.key
                }, function (re) {
                    layer.close(index);
                    if (re.state) {
                        obj.del();
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            }
        });

        //添加封禁
        $('#add').click(function () {
            layer.open({
                type: 2,
                title: '添加封禁',
                shadeClose: false,
                shade: 0.8,
                area: is_mobile ? ['100%', '100%'] : ['35%', '60%'],
                content: '?ct=platform&ac=forbiddenAdd'
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>