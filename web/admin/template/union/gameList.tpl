<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left;">
            <span class="btn btn-primary btn-small add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加游戏</span>
            <span class="btn btn-danger btn-small clear-cache-all"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 更新缓存</span>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="layui-table layui-form" id="game-tree-table"></table>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<script>
    layui.config({
        version: '2019021515'
    }).extend({
        treetable: '<{$smarty.const.CDN_STATIC_URL}>lib/layui/ext/treetable'
    }).use(['treetable', 'layer'], function () {
        var data = JSON.parse('<{$data nofilter}>');
        var treetable = layui.treetable,
            layer = layui.layer,
            device = layui.device();

        treetable.render({
            elem: '#game-tree-table',
            data: data,
            field: 'name',
            is_checkbox: false,
            cols: [
                {
                    field: 'game_id',
                    title: 'ID',
                    width: '4%',
                    align: 'center',
                    template: function (item) {
                        return item.level != 2 ? item.game_id : '-';
                    }
                },
                {
                    field: 'name',
                    title: '游戏名称',
                    width: '18%',
                    template: function (item) {
                        var str = item.name;
                        if (item.level == 0) {
                            str = '<i class="fa fa-folder text-warning" aria-hidden="true"></i>&nbsp;' + str;
                        } else if (item.level == 1) {
                            str = '<i class="fa fa-gamepad text-primary" aria-hidden="true"></i>&nbsp;' + str;
                            if (item.inherit > 0) {
                                str = '<i class="fa fa-clipboard text-danger" aria-hidden="true"></i>&nbsp;<span class="text-danger">' + item.name + '</span>';
                            }
                        } else if (item.level == 2) {
                            str = '<i class="fa fa-briefcase text-success" aria-hidden="true"></i>&nbsp;' + str;
                        }
                        return str;
                    }
                },
                {
                    field: 'alias',
                    title: '游戏别名',
                    width: '10%'
                },
                {
                    title: '兑换比例',
                    width: '4%',
                    align: 'center',
                    template: function (item) {
                        return item.level == 1 ? '1:' + item.ratio : '-';
                    }
                },
                {
                    title: '单位',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        return item.level == 1 ? (item.unit == '1' ? '元' : '分') : '-';
                    }
                },
                {
                    title: '类型',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '';
                        if (item.type == 'html5') {
                            str = '<i class="fa fa-html5 fa-lg text-primary" aria-hidden="true"></i>';
                        } else if (item.type == 'ios') {
                            str = '<i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>';
                        } else {
                            str = '<i class="fa fa-android fa-lg text-success" aria-hidden="true"></i>';
                        }
                        return item.level == 1 ? str : '-';
                    }
                },
                {
                    title: '运营',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>';
                        if (item.lock == '1') {
                            str = '<span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>';
                        }
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '登录',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '<span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>';
                        if (item.is_login == '1') {
                            str = '<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>';
                        }
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '充值',
                    width: '3%',
                    align: 'center',
                    template: function (item) {
                        var str = '<span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>';
                        if (item.is_pay == '1') {
                            str = '<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>';
                        }
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '创建时间',
                    width: '10%',
                    align: 'center',
                    template: function (item) {
                        return item.level > 0 && item.create_time > 0 ? JsMain.date('Y/m/d H:i', item.create_time) : '-';
                    }
                },
                {
                    title: '更新时间',
                    width: '10%',
                    align: 'center',
                    template: function (item) {
                        return item.level > 0 && item.update_time > 0 ? JsMain.date('Y/m/d H:i', item.update_time) : '-';
                    }
                },
                {
                    title: '首服时间',
                    width: '10%',
                    align: 'center',
                    template: function (item) {
                        return item.level == 2 ? item.open_time : '-';
                    }
                },
                {
                    title: '操作',
                    width: 'auto',
                    //align: 'center',
                    template: function (item) {
                        var str = '-',
                            tem = [];

                        if (item.level == 0) {
                            tem.push('<span class="btn btn-primary btn-xs add" data-id="' + item.game_id + '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
                            str = tem.join(' ');
                        } else if (item.level == 1) {
                            tem.push('<span class="btn btn-primary btn-xs add" data-id="' + item.game_id + '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
                            tem.push('<a href="?ct=unionConfig&ac=downloadGameParam&game_id=' + item.game_id + '" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 下载游戏参数</a>');
                            tem.push('<span class="btn btn-danger btn-xs add-platform" data-id="' + item.game_id + '" data-pid="' + item.platform_id + '" data-title="' + item.name + '"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加平台</span>');
                            str = tem.join(' ');
                        } else if (item.level == 2) {
                            tem.push('<span class="btn btn-primary btn-xs add-platform" data-id="' + item.game_id + '" data-pid="' + item.platform_id + '" data-title="' + item.game_name + '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
                            tem.push('<a href="?ct=unionConfig&ac=downloadPlatformGameParam&platform_id=' + item.platform_id + '&game_id=' + item.game_id + '" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 下载平台参数</a>');
                            str = tem.join(' ');
                        }
                        return str;
                    }
                },
            ]
        });

        $('.clear-cache-all').on('click', function () {
            layer.confirm('确定更新缓存吗？', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=unionConfig&ac=setGameCache', function (re) {
                    layer.close(index);
                    if (re.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //添加编辑游戏
        $('.add').on('click', function () {
            var id = $(this).data('id') ? $(this).data('id') : 0;
            layer.open({
                type: 2,
                title: '添加/编辑游戏',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['50%', '80%'],
                content: '/?ct=unionConfig&ac=gameAdd&game_id=' + id
            });
        });

        //添加编辑平台
        $('.add-platform').on('click', function () {
            var title = $(this).data('title');
            var game_id = $(this).data('id');
            var platform_id = $(this).data('pid') ? $(this).data('pid') : 0;
            var type = platform_id > 0 ? 'edit' : 'add';

            layer.open({
                type: 2,
                title: '【' + title + '】添加/编辑平台',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['550px', '580px'],
                content: '/?ct=unionConfig&ac=platformAddGame&type=' + type + '&platform_id=' + platform_id + '&game_id=' + game_id
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>