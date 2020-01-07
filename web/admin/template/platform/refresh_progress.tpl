<{include file="../public/header.tpl"}>
<style type="text/css">
    .progress {
        margin-top: 5px !important;
        margin-bottom: 0px !important;
    }

    .col-md-4, .col-md-8 {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    @media (max-width: 991px) {
        .progress {
            margin-top: 5px !important;
        }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <form class="form-inline">
                <div class="form-group form-group-sm">
                    <label>状态</label>
                    <select id="state" class="form-control input-sm" name="state">
                        <option value="0">全部</option>
                        <option value="1">等待中</option>
                        <option value="2">进行中</option>
                        <option value="3">已成功</option>
                        <option value="4">已失败</option>
                    </select>
                    <label>搜索</label>
                    <input type="text" class="form-control input-sm" name="package_name" id="package_name" value="" placeholder="包名" style="width: 200px;"/>
                    <span id="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>搜索</span>
                </div>
            </form>
        </div>
        <div class="col-md-8" id="header-tips">
            <span class="label label-default">分包总数：<i data="total">0</i></span>
            <span class="label label-success">分包成功数：<i data="success">0</i></span>
            <span class="label label-danger">分包失败数：<i data="error">0</i></span>
            <span class="label label-primary">分包中：<i data="ing">0</i></span>
            <span class="label label-info">等待中：<i data="wait">0</i></span>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-success active" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                    0%
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <table id="LAY-table-report" lay-filter="report"></table>
    </div>
</div>
<script type="text/html" id="toolbar-report">
    {{# if(d.state != '0'){ }}
    <span class="layui-btn layui-btn-danger layui-btn-xs" lay-event="repeat">
        <i class="fa fa-repeat fa-fw" aria-hidden="true"></i>重新分包
    </span>
    {{# } }}
</script>
<link rel="stylesheet" href="<{$_cdn_static_url_}>lib/layui-2.5/css/layui.css">
<script src="<{$_cdn_static_url_}>lib/layui-2.5/layui.js"></script>
<script type="text/javascript">
    layui.config({
        version: '2019093020'
    }).use('table', function () {
        var table = layui.table,
            games = JSON.parse('<{$_games|@json_encode nofilter}>'),
            game_id = '<{$game_id}>',
            state = '<{$state}>',
            package_name = '<{$package_name}>';

        var cols = [[
            {
                field: 'parent_name',
                width: 100,
                title: '母游戏',
                align: 'center',
                templet: function (d) {
                    return games[d.parent_id];
                }
            },
            {field:'game_name', width: 160, title: '子游戏', align: 'center'},
            {field:'package_name', width:250, title: '游戏包', align: 'center'},
            {field:'channel_name', width:100, title: '渠道', align: 'center'},
            {
                field: 'is_new',
                width: 80,
                title: '类型',
                align: 'center',
                templet: function (item) {
                    return item.is_new === '1' ? '<span class="layui-badge">新包</span>' : '<span class="layui-badge layui-bg-green">更新包</span>';
                }
            },
            {
                field: 'sdk_version',
                width: 100,
                title: 'SDK版本',
                align: 'center',
                templet: function (d) {
                    return d.sdk_version ? '<span class="layui-badge">' + d.sdk_version + '</span>' : '-';
                }
            },
            {
                field: 'submit_time',
                width: 180,
                title: '提交时间',
                align: 'center',
                templet: function (d) {
                    return d.submit_time > 0 ? layui.util.toDateString(d.submit_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';
                }
            },
            {
                field: 'fix_time',
                width: 180,
                title: '结束时间',
                align: 'center',
                templet: function (d) {
                    return d.fix_time > 0 ? layui.util.toDateString(d.fix_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';
                }
            },
            {
                field: 'total_time',
                width: 100,
                title: '分包用时',
                align: 'center',
                templet: function (d) {
                    var str = '-',
                        t = 0;
                    if (d.fix_time > 0 && d.start_time > 0) {
                        t = d.fix_time - d.start_time;
                        if (t >= 86400) {
                            str = Math.floor(t / 86400) + "天" + Math.ceil(((t % 86400) / 3600)) + "小时";
                        } else if (t >= 3600 && t < 86400) {
                            str = Math.floor(t / 3600) + "小时" + Math.ceil(((t % 3600) / 60)) + "分";
                        } else if (t >= 60 && t < 3600) {
                            let s = t % 60;
                            str = Math.floor(t / 60) + "分" + (s > 0 ? s + '秒' : '');
                        } else {
                            str = t + "秒";
                        }
                    }
                    return t > 300 ? '<span class="red">' + str + '</span>' : str;
                }
            },
            {
                field: 'state',
                width: 60,
                title: '状态',
                align: 'center',
                templet: function (d) {
                    var str = '';
                    if (d.state === '1') {
                        str = '<i class="fa fa-cog fa-spin fa-lg" aria-hidden="true" title="分包中"></i>';
                    } else if (d.state === '2') {
                        str = '<i class="fa fa-check-circle text-success fa-lg" aria-hidden="true" title="分包成功"></i>';
                    } else if (d.state === '3') {
                        str = '<i class="fa fa-exclamation-triangle text-danger fa-lg" aria-hidden="true" title="分包失败"></i>';
                    } else {
                        str = '<i class="fa fa-clock-o fa-spin fa-lg" aria-hidden="true" title="等待分包"></i>';
                    }
                    return str;
                }
            },
            {field:'error', width:100, title: '备注', align: 'center'},
            {field:'admin_name', width:100, title: '操作者', align: 'center'},
            {minWidth: 120,title: '操作', align: 'center', toolbar: '#toolbar-report'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '游戏分包进度',
            url: '/?ct=platform&ac=refreshProgress&json=1&state=' + state + '&package_name=' + package_name,
            where: {
                game_id: game_id
            },
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

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        //监听工具条
        table.on('tool(report)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;

            switch (layEvent) {
                case 'repeat':
                    layer.confirm('确定重新分包吗？', {
                        btn: ['确定', '取消'],
                        icon: 7,
                        title: '分包提示'
                    }, function () {
                        var index = layer.load();
                        $.post('/?ct=platform&ac=refreshRepeat', {
                            id: data.id
                        }, function (ret) {
                            layer.close(index);
                            console.log(ret);
                            if (ret.code === 1) {
                                layer.alert('已经提交分包请求', function (index) {
                                    layer.close(index);
                                    tableIns.reload();
                                });
                            } else {
                                layer.alert(ret.message);
                            }
                        }, 'json');
                    });
                    break;
            }
        });

        //搜索
        $('#submit').on('click', function () {
            tableIns.reload({
                where: {
                    state: $('#state').val(),
                    package_name: $('#package_name').val()
                },
                page: {
                    curr: 1
                }
            });
        });

        var total = 0,
            now = 0,
            ratio = '100%',
            inter = setInterval(getStatus, 3000);

        getStatus();

        function getStatus() {
            $.getJSON('/?ct=platform&ac=refreshStatus&game_id=' + game_id, function (ret) {
                $.each(ret, function (i, n) {
                    $('#header-tips i[data="' + i + '"]').text(n);
                });

                now = parseInt(ret.ing) + parseInt(ret.wait);
                if (total === 0) {
                    total = now;
                }

                if (total !== 0) {
                    ratio = Math.round((total - now) / total * 100 * 100) / 100 + '%';
                }

                $('.progress-bar').css('width', ratio);
                $('.progress-bar').text(ratio);

                if (ret.ing == 0 && ret.wait == 0) {
                    clearInterval(inter);
                }
            });
        }
    });
</script>
<{include file="../public/foot.tpl"}>
