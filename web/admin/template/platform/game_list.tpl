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
                            <label>类型：</label>
                            <select class="form-control" name="device_type">
                                <option value="">全部</option>
                                <option value="1">ios</option>
                                <option value="2">android</option>
                                <option value="3">html5</option>
                            </select>

                            <label>状态：</label>
                            <select class="form-control" name="status">
                                <option value="0">正常</option>
                                <option value="1">关闭</option>
                            </select>

                            <label>搜索</label>
                            <input type="text" id="keyword" name="keyword" value="" class="form-control" placeholder="ID/别名/名称"/>
                            <button type="button" class="btn btn-primary btn-sm" id="submit">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                            </button>
                            <{if SrvAuth::checkPublicAuth('add',false)}>
                            <span class="btn btn-success btn-sm" id="add-game"><i class="fa fa-plus fa-fw"></i>添加游戏</span>
                            <{/if}>
                            <{if SrvAuth::checkPublicAuth('audit',false)}>
                            <span class="btn btn-danger btn-sm" id="clear-cache-all"><i class="fa fa-refresh fa-fw"></i>更新缓存</span>
                            <{/if}>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <div class="rows">
        <table class="layui-table layui-form" id="game-tree-table"></table>
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
        var url = '/?ct=platform&ac=gameList&json=1';
        var is_edit = '<{SrvAuth::checkPublicAuth('edit',false)}>';
        var treeTable = layui.treeTable,
            layer = layui.layer,
            laypage = layui.laypage,
            form = layui.form,
            device = layui.device();

        var tree = treeTable.render({
            elem: '#game-tree-table',
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
                    key: 'game_id',
                    title: 'ID',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        return item.level != 2 ? item.game_id : '-';
                    }
                },
                {
                    key: 'name',
                    title: '游戏名称',
                    width: '18%',
                    template: function (item) {
                        var str = item.name;
                        if (item.is_end) {
                            str = '<i class="fa fa-file text-light" aria-hidden="true"></i>&nbsp;' + item.name;
                            if (item.inherit > 0) {
                                str = '<i class="fa fa-clipboard text-danger" aria-hidden="true"></i>&nbsp;<span class="text-danger">' + item.name + '</span>';
                            } else if (item.level == 2) {
                                str = '<i class="fa fa-handshake-o text-success" aria-hidden="true"></i>&nbsp;' + item.name;
                            }
                        } else {
                            if (item.inherit > 0) {
                                str = '<span class="text-danger">' + item.name + '</span>';
                            }
                        }
                        return str;
                    }
                },
                {
                    key: 'alias',
                    title: '游戏别名',
                    width: '10%'
                },
                {
                    title: '类型',
                    width: '3%',
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
                        return item.level == 1 ? str : '-';
                    }
                },
                {
                    title: '状态',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '-';
                        switch (item.device_status) {
                            case '1':
                                str = '<i class="fa fa-check text-success" aria-hidden="true" title="正常"></i>';
                                break;
                            case '2':
                                str = '<i class="fa fa-bug text-danger" aria-hidden="true" title="测试"></i>';
                                break;
                            case '3':
                                str = '<i class="fa fa-jpy text-danger" aria-hidden="true" title="提审[内购版]"></i>';
                                break;
                            case '4':
                                str = '<i class="fa fa-minus-square text-muted" aria-hidden="true" title="提审[免费版]"></i>';
                                break;
                        }
                        return item.level == 1 && item.type != '3' ? str : '-';
                    }
                },
                {
                    title: '运营',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        if (item.status == '1') {
                            str = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        }
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '登录',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        if (item.is_login == '1') {
                            str = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '充值',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        if (item.is_pay == '1') {
                            str = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '母包',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        if (item.is_upload) {
                            str = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                        return item.level == 1 && item.type != '3' ? str : '-';
                    }
                },
                {
                    key: 'online',
                    title: '实时在线',
                    width: '4%',
                    align: 'center',
                },
                {
                    title: 'SDK版本',
                    width: '4%',
                    align: 'center',
                    template: function (item) {
                        return item.level == 1 && item.sdk_version ? '<span class="label label-danger">' + item.sdk_version + '</span>' : '-';
                    }
                },
                {
                    title: '上传时间',
                    width: '9%',
                    align: 'center',
                    template: function (item) {
                        return item.level == 1 && item.upload_time > 0 ? JsMain.date('Y/m/d H:i', item.upload_time) : '-';
                    }
                },
                {
                    title: '更新时间',
                    width: '9%',
                    align: 'center',
                    template: function (item) {
                        return item.level > 0 && item.update_time > 0 ? JsMain.date('Y/m/d H:i', item.update_time) : '-';
                    }
                },
                {
                    title: '操作',
                    width: 'auto',
                    template: function (item) {
                        var tem = [];

                        if (item.level == 0) {
                            if (is_edit == '1') {
                                tem.push('<span class="btn btn-primary btn-xs" lay-filter="addGame"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>编辑</span>');
                            }
                            tem.push('<span class="btn btn-info btn-xs" lay-filter="clearCache"><i class="fa fa-repeat fa-fw" aria-hidden="true"></i>全部更新</span>');
                            tem.push('<span class="btn btn-danger btn-xs" lay-filter="addGameByPid"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加游戏</span>');
                        } else if (item.level == 1) {
                            if (is_edit == '1') {
                                tem.push('<span class="btn btn-primary btn-xs" lay-filter="addGame"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>编辑</span>');
                            }
                            tem.push('<span class="btn btn-info btn-xs" lay-filter="clearCache" title="更新配置信息"><i class="fa fa-repeat fa-fw" aria-hidden="true"></i>更新</span>');
                            tem.push('<a href="?ct=platform&ac=gameParams&game_id=' + item.game_id + '" class="btn btn-warning btn-xs" title="下载游戏对接参数"><i class="fa fa-download fa-fw" aria-hidden="true"></i>下载</a>');

                            if (item.type == '3') {
                                tem.push('<span class="btn btn-danger btn-xs" lay-filter="addPlatform"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加平台</span>');
                            } else {
                                if (item.device_type == '1') {
                                    tem.push('<span class="btn btn-success btn-xs" lay-filter="support"><i class="fa fa-phone fa-fw" aria-hidden="true"></i>链接</span>');
                                } else {
                                    tem.push('<a href="?ct=platform&ac=gameUpdate&game_id=' + item.game_id + '" class="btn btn-success btn-xs" title="上传安卓母包"><i class="fa fa-upload fa-fw" aria-hidden="true"></i>母包</a>');
                                    if (item.refresh > 0) {
                                        tem.push('<a href="?ct=platform&ac=refreshProgress&game_id=' + item.game_id + '" class="btn btn-warning btn-xs" title="查看发布进度"><i class="fa fa-send fa-fw" aria-hidden="true"></i>发布中...</a>');
                                    } else {
                                        tem.push('<span class="btn btn-danger btn-xs" lay-filter="refresh" title="批量发布到最新版本"><i class="fa fa-send fa-fw" aria-hidden="true"></i>发布</span>');
                                    }
                                }
                            }
                        } else if (item.level == 2) {
                            tem.push('<span class="btn btn-primary btn-xs" lay-filter="addPlatform"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
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

        //添加编辑游戏
        function addGame(game_id, parent_id) {
            layer.open({
                type: 2,
                title: '添加/编辑游戏',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['50%', '100%'],
                content: '/?ct=platform&ac=addGame&game_id=' + game_id + '&parent_id=' + parent_id
            });
        }

        //提交表单
        $('#submit').on('click', function () {
            load_data(1, 15, $('form').serialize());
        });

        //添加编辑游戏
        treeTable.on('tree(addGame)', function (data) {
            var item = data.item,
                game_id = item.game_id;
            addGame(game_id);
        });

        //从母游戏添加游戏
        treeTable.on('tree(addGameByPid)', function (data) {
            var item = data.item,
                game_id = item.game_id;
            addGame(0, game_id);
        });

        //添加编辑平台
        treeTable.on('tree(addPlatform)', function (data) {
            var item = data.item,
                game_id = item.game_id,
                platform_id = item.platform_id ? item.platform_id : 0,
                title = platform_id ? item.game_name : item.name,
                type = platform_id > 0 ? 'edit' : 'add';
            layer.open({
                type: 2,
                title: '【' + title + '】添加/编辑平台',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['550px', '580px'],
                content: '/?ct=platform&ac=platformAddGame&type=' + type + '&platform_id=' + platform_id + '&game_id=' + game_id
            });
        });

        //更新游戏配置
        treeTable.on('tree(clearCache)', function (data) {
            var item = data.item,
                game_id = item.game_id,
                parent_id = item.parent_id,
                title = item.name;

            var msg = '确定更新配置吗？<br><br><span style="color: red;">更新后，新的配置即刻生效</span>';
            if (parent_id == 0) {
                msg = '确定更新<span style="color: red;">所有子游戏</span>配置吗？<br><br><span style="color: red;">更新后，新的配置即刻生效</span>';
            }

            layer.confirm(msg, {
                btn: ['确定', '取消'],
                icon: 7,
                title: '【' + title + '】更新配置提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=clearCache', {
                    game_id: game_id,
                    parent_id: parent_id
                }, function (re) {
                    layer.close(index);
                    if (re.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //批量更新包
        treeTable.on('tree(refresh)', function (data) {
            var item = data.item,
                game_id = item.game_id,
                title = item.name;

            layer.confirm('确定批量发布所有新包吗？这将耗费比较长的时间<br><br><font color="red">发布成功后，将自动推送到客户端升级版本</font>', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '【' + title + '】批量发布新包提示'
            }, function () {
                $.post('?ct=platform&ac=refreshPackage', {
                    game_id: game_id
                }, function (re) {
                    if (re.state) {
                        layer.confirm('提交成功，批量发布中，是否查看进度？', {
                                btn: ['确定', '取消']
                            },
                            function () {
                                location.href = '?ct=platform&ac=refreshProgress&game_id=' + game_id;
                            },
                            function () {
                                location.reload();
                            });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //升级版本
        treeTable.on('tree(levelUp)', function (data) {
            var item = data.item,
                game_id = item.game_id;

            layer.confirm('确定升级版本？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('?ct=platform&ac=gameLevel', {
                    game_id: game_id
                }, function (re) {
                    if (re.state) {
                        layer.msg('操作成功', function () {
                            location.reload();
                        });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //IOS技术支持
        treeTable.on('tree(support)', function (data) {
            var item = data.item,
                game_id = item.game_id,
                title = item.name;
            layer.open({
                type: 2,
                title: '【' + title + '】技术支持',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['50%', '100%'],
                content: '/?ct=platform&ac=iosSupport&game_id=' + game_id
            });
        });

        //刷新全部缓存
        $('#clear-cache-all').on('click', function () {
            layer.confirm('确定更新缓存吗？', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=clearCacheAll', function (re) {
                    layer.close(index);
                    if (re.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //添加游戏
        $('#add-game').on('click', function () {
            addGame();
        });
    });
</script>
<{include file="../public/foot.tpl"}>