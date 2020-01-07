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
                            <span class="btn btn-primary btn-sm" id="add"><i class="fa fa-plus fa-fw"></i>添加平台</span>
                            <span class="btn btn-danger btn-sm" id="clear-cache-all"><i class="fa fa-refresh fa-fw"></i>更新缓存</span>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <div class="rows">
        <table class="layui-table layui-form" id="platform-tree-table"></table>
        <div id="page"></div>
    </div>
</div>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<script>
    layui.config({
        version: '2019071512'
    }).extend({
        treeTable: '<{$smarty.const.CDN_STATIC_URL}>lib/layui/ext/treeTable'
    }).use(['treeTable', 'layer', 'laypage', 'form'], function () {
        var url = '/?ct=platform&ac=platformList&json=1';
        var treeTable = layui.treeTable,
            layer = layui.layer,
            laypage = layui.laypage,
            form = layui.form,
            device = layui.device();

        var tree = treeTable.render({
            elem: '#platform-tree-table',
            data: [],
            icon_key: 'name',
            is_checkbox: false,
            icon: {
                open: 'fa fa-folder-open text-warning',
                close: 'fa fa-folder text-warning',
                left: 16,
            },
            end: function (e) {
                form.render();
            },
            cols: [
                {
                    key: 'platform_id',
                    title: 'ID',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        return item.level == 0 ? item.platform_id : '-';
                    }
                },
                {
                    key: 'name',
                    title: '平台名称',
                    width: '18%',
                    template: function (item) {
                        var str = item.name;
                        if (item.is_end) {
                            str = '<i class="fa fa-file text-light" aria-hidden="true"></i>&nbsp;' + item.name;
                            if (item.level > 0) {
                                str = '<i class="fa fa-gamepad text-primary" aria-hidden="true"></i>&nbsp;' + item.name;
                            }
                        }
                        return str;
                    }
                },
                {
                    key: 'alias',
                    title: '平台别名',
                    width: '12%'
                },
                {
                    title: '类型',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        var str = '';
                        if (item.device_type == 3) {
                            str = '<i class="fa fa-html5 fa-lg text-primary" aria-hidden="true"></i>';
                        } else if (item.device_type == 2) {
                            str = '<i class="fa fa-android fa-lg text-success" aria-hidden="true"></i>';
                        } else {
                            str = '<i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>';
                        }
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '运营',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        var str = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        if (item.lock == '1') {
                            str = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        }
                        return str;
                    }
                },
                {
                    title: '登录',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        var str = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        if (item.is_login == '1') {
                            str = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                        return str;
                    }
                },
                {
                    title: '充值',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        var str = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        if (item.is_pay == '1') {
                            str = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                        return str;
                    }
                },
                {
                    title: '创建时间',
                    width: '10%',
                    align: 'center',
                    template: function (item) {
                        return item.create_time > 0 ? JsMain.date('Y/m/d H:i', item.create_time) : '-';
                    }
                },
                {
                    title: '更新时间',
                    width: '10%',
                    align: 'center',
                    template: function (item) {
                        return item.update_time > 0 ? JsMain.date('Y/m/d H:i', item.update_time) : '-';
                    }
                },
                {
                    title: '首服时间',
                    width: '10%',
                    align: 'center',
                    template: function (item) {
                        return item.level > 0 ? item.open_time : '-';
                    }
                },
                {
                    title: '操作',
                    width: 'auto',
                    //align: 'center',
                    template: function (item) {
                        var tem = [];
                        if (item.level == 0) {
                            tem.push('<span class="btn btn-primary btn-xs" lay-filter="add"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
                            tem.push('<span class="btn btn-danger btn-xs" lay-filter="addGame"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加游戏</span>');
                        } else if (item.level == 1) {
                            tem.push('<span class="btn btn-primary btn-xs" lay-filter="addGame"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
                            tem.push('<a href="?ct=platform&ac=downloadPlatformGameParam&platform_id=' + item.platform_id + '&game_id=' + item.game_id + '" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 下载平台参数</a>');
                        }
                        return tem.join(' ');
                    }
                },
            ]
        });

        //初始化
        load_data(1, 15, null);

        //获取数据
        function load_data(page, limit, data) {
            var index = layer.load();
            $.post(url, {
                page: page,
                limit: limit,
                data: data
            }, function (result) {
                layer.close(index);

                tree.data = result.data;
                treeTable.render(tree);

                laypage.render({
                    elem: 'page',
                    count: result.count,
                    limit: limit,
                    curr: page,
                    jump: function (obj, _first) {
                        //首次不执行
                        if (!_first) {
                            load_data(obj.curr, obj.limit, $('form').serialize());
                        }
                    }
                });
            }, 'json');
        }

        //添加编辑平台
        function add(platform_id) {
            layer.open({
                type: 2,
                title: '添加/编辑平台',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['550px', '450px'],
                content: '/?ct=platform&ac=platformAdd&platform_id=' + platform_id
            });
        }

        //添加编辑平台
        treeTable.on('tree(add)', function (data) {
            var item = data.item,
                platform_id = item.platform_id;
            add(platform_id);
        });

        //添加编辑游戏
        treeTable.on('tree(addGame)', function (data) {
            var item = data.item,
                platform_id = item.platform_id,
                game_id = item.game_id ? item.game_id : 0,
                title = game_id ? item.platform_name : item.name,
                type = game_id > 0 ? 'edit' : 'add';
            layer.open({
                type: 2,
                title: '【' + title + '】添加/编辑游戏',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['550px', '580px'],
                content: '/?ct=platform&ac=platformAddGame&type=' + type + '&platform_id=' + platform_id + '&game_id=' + game_id
            });
        });

        //添加平台
        $('#add').on('click', function () {
            add();
        });

        //更新缓存
        $('#clear-cache-all').on('click', function () {
            layer.confirm('确定更新缓存吗？', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=setPlatformGameCache', function (re) {
                    layer.close(index);
                    if (re.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>