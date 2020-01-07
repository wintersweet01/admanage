<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left;">
            <span class="btn btn-primary btn-small add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加平台</span>
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
                    field: 'platform_id',
                    title: 'ID',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        return item.level == 0 ? item.platform_id : '-';
                    }
                },
                {
                    field: 'name',
                    title: '平台名称',
                    width: '18%',
                    template: function (item) {
                        var str = item.name;
                        if (item.level > 0) {
                            str = '<i class="fa fa-gamepad text-primary" aria-hidden="true"></i>&nbsp;' + str;
                        }
                        return str;
                    }
                },
                {
                    field: 'alias',
                    title: '平台别名',
                    width: '12%'
                },
                {
                    title: '类型',
                    width: '5%',
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
                        return item.level > 0 ? str : '-';
                    }
                },
                {
                    title: '运营',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        var str = '<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>';
                        if (item.lock == '1') {
                            str = '<span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>';
                        }
                        return str;
                    }
                },
                {
                    title: '登录',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        var str = '<span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>';
                        if (item.is_login == '1') {
                            str = '<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>';
                        }
                        return str;
                    }
                },
                {
                    title: '充值',
                    width: '5%',
                    align: 'center',
                    template: function (item) {
                        var str = '<span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>';
                        if (item.is_pay == '1') {
                            str = '<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>';
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
                            tem.push('<span class="btn btn-primary btn-xs add" data-id="' + item.platform_id + '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
                            tem.push('<span class="btn btn-danger btn-xs add-game" data-id="' + item.platform_id + '" data-gid="' + item.game_id + '" data-title="' + item.name + '"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加游戏</span>');
                        } else if (item.level == 1) {
                            tem.push('<span class="btn btn-primary btn-xs add-game" data-id="' + item.platform_id + '" data-gid="' + item.game_id + '" data-title="' + item.platform_name + '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</span>');
                            tem.push('<a href="?ct=unionConfig&ac=downloadPlatformGameParam&platform_id=' + item.platform_id + '&game_id=' + item.game_id + '" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 下载平台参数</a>');
                        }
                        return tem.join(' ');
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
                $.post('?ct=unionConfig&ac=setPlatformCache', function (re) {
                    layer.close(index);
                    if (re.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //添加编辑平台
        $('.add').on('click', function () {
            var id = $(this).data('id') ? $(this).data('id') : 0;
            layer.open({
                type: 2,
                title: '添加/编辑平台',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['550px', '450px'],
                content: '/?ct=unionConfig&ac=platformAdd&platform_id=' + id
            });
        });

        //添加编辑游戏
        $('.add-game').on('click', function () {
            var title = $(this).data('title');
            var platform_id = $(this).data('id');
            var game_id = $(this).data('gid') ? $(this).data('gid') : 0;
            var type = game_id > 0 ? 'edit' : 'add';

            layer.open({
                type: 2,
                title: '【' + title + '】添加/编辑游戏',
                shadeClose: false,
                shade: 0.8,
                area: (device.android || device.ios) ? ['100%', '100%'] : ['550px', '580px'],
                content: '/?ct=unionConfig&ac=platformAddGame&type=' + type + '&platform_id=' + platform_id + '&game_id=' + game_id
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>