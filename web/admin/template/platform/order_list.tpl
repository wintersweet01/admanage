<{include file="../public/header.tpl"}>
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
                        <div class="row form-group-sm">
                            <div class="form-group">
                                <{widgets widgets=$widgets}>
                            </div>

                            <div class="form-group">
                                <label>服务器</label>
                                <select class="form-control" name="server_id" id="server_id">
                                    <option value="">全 部</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>平台</label>
                                <select class="form-control" name="device_type" style="width: 50px;">
                                    <option value="">全 部</option>
                                    <{foreach from=$_device_types key=name item=id}>
                                    <option value="<{$id}>"><{$name}></option>
                                    <{/foreach}>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>渠道</label>
                                <select class="form-control" name="channel_id">
                                    <option value="">全 部</option>
                                    <{foreach from=$_channels key=id item=name}>
                                    <option value="<{$id}>"><{$name}></option>
                                    <{/foreach}>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>游戏包</label>
                                <select class="form-control" name="package_name" id="package_id">
                                    <option value="">全 部</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>支付渠道</label>
                                <select class="form-control" name="pay_channel" style="width: 50px;">
                                    <option value="">全 部</option>
                                    <{foreach from=$_pay_channel_types key=id item=name}>
                                    <option value="<{$id}>"><{$name}></option>
                                    <{/foreach}>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>支付方式</label>
                                <select class="form-control" name="pay_type" style="width: 50px;">
                                    <option value="0">全 部</option>
                                    <{foreach from=$_pay_types key=id item=name}>
                                    <option value="<{$id}>"><{$name}></option>
                                    <{/foreach}>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>支付状态</label>
                                <select class="form-control" name="is_pay" style="width: 50px;">
                                    <option value="0">全 部</option>
                                    <{foreach from=$smarty.const.PAY_STATUS key=name item=id}>
                                    <option value="<{$id}>"><{$name}></option>
                                    <{/foreach}>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>到账状态</label>
                                <select class="form-control" name="is_notify" style="width: 50px;">
                                    <option value="0">全 部</option>
                                    <option value="1">未发放</option>
                                    <option value="2">已发放</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>订单号</label>
                                <input type="text" class="form-control" name="pt_order_num" value="" placeholder="平台订单号/CP订单号/银行订单号" style="min-width: 200px;"/>
                            </div>

                            <div class="form-group">
                                <label>用户账号</label>
                                <input type="text" class="form-control" name="username" value="" placeholder="UID/账号"/>
                            </div>

                            <div class="form-group">
                                <label>角色名称</label>
                                <input type="text" class="form-control" name="role_name" value=""/>
                            </div>

                            <div class="form-group">
                                <label>订单时间</label>
                                <input type="text" name="sdate" value="" class="form-control Wdate" readonly style="width: 100px;"/>
                                -
                                <input type="text" name="edate" value="" class="form-control Wdate" readonly style="width: 100px;"/>
                            </div>

                            <div class="form-group">
                                <label>充值区间</label>
                                <input type="text" class="form-control" name="level1" value="" style="width:50px;"/> -
                                <input type="text" class="form-control" name="level2" value="" style="width:50px;"/>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="direct" value="1"/><span class="red">直充</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm" id="submit">
                                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows">
        <table id="LAY-table-report" lay-filter="report"></table>
        <input type="text" id="copy" value="" style="position: absolute;opacity:0;">
        <script type="text/html" id="toolbar-menu">
            <span class="btn btn-danger btn-xs" lay-event="orderCheck"><i class="fa fa-search fa-fw"></i>检查</span>
            <span class="btn btn-warning btn-xs" lay-event="orderReissue"><i class="fa fa-jpy fa-fw"></i>补单</span>
            <span class="btn btn-info btn-xs" lay-event="orderLog"><i class="fa fa-calendar-minus-o fa-fw"></i>日志</span>
        </script>
        <script type="text/html" id="toolbar-header">
            <div id="header-tips"></div>
        </script>
    </div>
</div>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<script>
    $(function () {
        $('select[name=game_id],select[name=device_type],select[name=channel_id]').on('change', function () {
            var game_id = parseInt($('select[name=game_id] option:selected').val());
            var device_type = $('select[name=device_type] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=data&ac=getGameServer&game_id=' + game_id, function (re) {
                var html = '<option value="0">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html).trigger('change');
            });
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&device_type=' + device_type + '&channel_id=' + channel_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html).trigger('change');
            });
        });
    });

    layui.config({
        version: '2019101718',
    }).use(['table', 'laytpl'], function () {
        var table = layui.table,
            laytpl = layui.laytpl;

        var cols = [[
            {field:'pt_order_num', width:180, title: '订单号', align: 'center'},
            {field:'cp_order_num', width:200, title: 'CP订单号', align: 'center', hide: true},
            {field:'third_trade_no', width:200, title: '银行订单号', align: 'center', hide: true},
            {field:'username', width: 120, title: '账号', align: 'center', event: 'showUserInfo', style:'cursor: pointer;'},
            {field:'money', width:80, title: '金额', align: 'center', style:'color:#a94442;'},
            {field:'money_discount', width:80, title: '折扣', align: 'center', style:'color:#a94442;'},
            {field:'pay_type_name', width:130, title: '支付渠道', align: 'center'},
            {
                field: 'is_pay',
                width: 60,
                title: '支付',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.is_pay == '2') {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    } else if (d.is_pay == '3') {
                        str = '<i class="fa fa-bug text-danger fa-lg"></i>';
                    }
                    return str;
                }
            },
            {
                field: 'is_notify',
                width: 60,
                title: '到账',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.is_notify == '1') {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    }
                    return str;
                }
            },
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
            {field:'parent_name', width:100, title: '母游戏', align: 'center'},
            {field:'game_name', width:200, title: '充值游戏'},
            {
                field: 'reg_game_name',
                width: 200,
                title: '注册游戏',
                templet: function (d) {
                    var str = d.reg_game_name;
                    if (d.game_id != d.reg_game_id) {
                        str = '<span class="text-danger">' + d.reg_game_name + '</span>';
                    }
                    return str;
                }
            },
            {field:'server_id', width:80, title: '区服', align: 'center'},
            {field:'role_name', width:120, title: '角色', align: 'center'},
            {field:'role_level', width:60, title: '等级', align: 'center'},
            {field:'package_name', width:260, title: '游戏包'},
            {field:'area', width:250, title: '充值地区'},
            {field:'pay_ip', width:150, title: '充值IP'},
            {field:'create_time', width:180, title: '下单时间', align: 'center'},
            {field:'pay_time', width:180, title: '支付时间', align: 'center'},
            {
                field: 'notify_time',
                width: 180,
                title: '到账时间',
                align: 'center',
                templet: function (d) {
                    var str = d.notify_time;
                    if (d.notify_diff > 300) {
                        str = '<span class="text-danger">' + d.notify_time + '</span>';
                    }
                    return str;
                }
            },
            {field:'notes', width:100, title: '备注', align: 'center'},
            {field:'direct_time', width:180, title: '直充时间', align: 'center', hide: true},
            {field:'admin_name', width:100, title: '管理员', align: 'center', hide: true},
            {minWidth:200, title: '操作', align: 'center', fixed: 'right', toolbar: '#toolbar-menu'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '用户管理',
            url: '/?ct=platform&ac=orderList&json=1&data=<{$query}>',
            cellMinWidth: 80,
            height: 'full-190',
            page: true,
            limit: 16,
            limits: [16, 50, 100, 200, 500],
            toolbar: '#toolbar-header',
            cols: cols,
            done: function (res, curr, count) {
                var query = res.query;

                if (query.length !== 0) {
                    var tpl = '<b>总计：</b>' +
                        '充值人数：<span class="text-danger">{{d.pay_num}}</span>，' +
                        '充值次数：<span class="text-danger">{{d.pay_count}}</span>，' +
                        '总金额：<span class="text-danger">{{d.total_fee}}</span>，' +
                        '总折扣：<span class="text-danger">{{d.total_discount}}</span>';
                    laytpl(tpl).render(query, function (html) {
                        $('#header-tips').html(html);
                    });
                }
            }
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            if ($('input[name="pt_order_num"]').val()) {
                cols[0][1]['hide'] = false;
                cols[0][2]['hide'] = false;
            } else {
                cols[0][1]['hide'] = true;
                cols[0][2]['hide'] = true;
            }

            if ($('input[name="direct"]').prop("checked")) {
                cols[0][23]['hide'] = false;
                cols[0][24]['hide'] = false;
            } else {
                cols[0][23]['hide'] = true;
                cols[0][24]['hide'] = true;
            }

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
            var order_num = data.pt_order_num;

            switch (layEvent) {
                case 'showUserInfo': //查用户信息
                    JsMain.search(data.username);
                    break;
                case 'orderCheck': //检查
                    if (data.is_pay != '1') {
                        layer.msg('该订单已支付过了');
                        return false;
                    }
                    var index = layer.msg('正在检查中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                    $.post('?ct=platform&ac=orderNumCheck', {
                        pt_order_num: order_num
                    }, function (re) {
                        layer.close(index);
                        if (re.state) {
                            layer.alert('检查成功!', {
                                skin: 'layui-layer-molv',
                                closeBtn: 1
                            }, function () {
                                layer.closeAll();
                                tableIns.reload();
                            });
                        } else {
                            layer.alert(re.msg);
                            return false;
                        }
                    }, 'json');
                    break;
                case 'orderReissue': //补单
                    if (data.is_pay == 1 || data.is_notify == 1) {
                        layer.msg('该订单已到账，不能重复补单');
                        return false;
                    }
                    var index = layer.msg('正在发放中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                    $.post('?ct=platform&ac=handSendNotify', {
                        order_num: order_num
                    }, function (re) {
                        layer.close(index);
                        if (re.state) {
                            layer.alert('发放成功!', {
                                skin: 'layui-layer-molv',
                                closeBtn: 1
                            }, function () {
                                layer.closeAll();
                                tableIns.reload();
                            });
                        } else {
                            layer.msg(re.msg, {icon: 2});
                        }
                    }, 'json');
                    break;
                case 'orderLog': //日志
                    var index = layer.load();
                    $.post('?ct=platform&ac=orderNumLog', {
                        pt_order_num: order_num
                    }, function (re) {
                        layer.close(index);
                        var width = parseInt($('body').width() * 0.6);
                        var height = parseInt($('body').height() * 0.8);
                        layer.open({
                            type: 1,
                            title: '订单日志',
                            shadeClose: true,
                            shade: false,
                            maxmin: true, //开启最大化最小化按钮
                            area: [width + 'px', height + 'px'],
                            content: '<div style="padding:10px;word-break: break-all;word-wrap: break-word">' + re + '</div>'
                        });
                    });
                    break;
            }
        });
    });
</script>
<{include file="../public/foot.tpl"}>