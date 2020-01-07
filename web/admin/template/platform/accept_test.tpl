<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<style type="text/css">
    .table-header {
        margin-bottom: 30px;
    }

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
                        <input type="hidden" name="ct" value="platform"/>
                        <input type="hidden" name="ac" value="acceptTest"/>
                        <div class="form-group form-group-sm">
                            <label>搜索</label>
                            <input type="text" class="form-control input-sm" name="keyword" value="<{$keyword}>" placeholder="账号/设备号" style="width: 300px;"/>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i>查 询
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows">
        <ul class="layui-timeline">
            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
                    <h3 class="layui-timeline-title">激活信息</h3>
                    <table class="layui-table" lay-size="sm">
                        <thead>
                        <tr>
                            <th>设备号</th>
                            <th>UUID</th>
                            <th>激活地区</th>
                            <th>激活IP</th>
                            <th>激活时间</th>
                            <th>母游戏</th>
                            <th>激活游戏</th>
                            <th>游戏包</th>
                            <th align="center">平台</th>
                            <th>SDK版本</th>
                            <th>设备名称</th>
                            <th>设备版本</th>
                            <th>渠道</th>
                            <th>来源</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{if $data.active}>
                            <tr>
                                <td><{$data.active.device_id}></td>
                                <td><{$data.active.uuid}></td>
                                <td><{$data.active.active_city}></td>
                                <td><{$data.active.active_ip}></td>
                                <td>
                                    <{if $data.active.active_time}>
                                    <{$data.active.active_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                    <{else}>-<{/if}>
                                </td>
                                <td>(<{$_games[$data.active.game_id]['pid']}>)<{$_games[$_games[$data.active.game_id]['pid']]['text']}></td>
                                <td>(<{$data.active.game_id}>)<{$_games[$data.active.game_id]['text']}></td>
                                <td><{$data.active.package_name}></td>
                                <td align="center">
                                    <{if $data.active.device_type == 1}><i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>
                                    <{else}><i class="fa fa-android fa-lg text-success" aria-hidden="true"></i><{/if}>
                                </td>
                                <td><{$data.active.sdk_version}></td>
                                <td><{$data.active.device_name}></td>
                                <td><{$data.active.device_version}></td>
                                <td><{$_channels[$data.active.channel_id]}></td>
                                <td><{$_monitor[$data.active.monitor_id]}></td>
                            </tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div>
            </li>
            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
                    <h3 class="layui-timeline-title">注册信息</h3>
                    <table class="layui-table" lay-size="sm">
                        <thead>
                        <tr>
                            <th>UID</th>
                            <th>账号</th>
                            <th>用户类型</th>
                            <th>注册地区</th>
                            <th>注册IP</th>
                            <th>注册时间</th>
                            <th>母游戏</th>
                            <th>注册游戏</th>
                            <th>游戏包</th>
                            <th align="center">平台</th>
                            <th>SDK版本</th>
                            <th>设备号</th>
                            <th>设备名称</th>
                            <th>设备版本</th>
                            <th>UUID</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{if $data.reg}>
                            <tr>
                                <td><{$data.reg.uid}></td>
                                <td><{$data.reg.username}></td>
                                <td><{if $data.reg.type}><{$_union[$data.reg.type]}><{else}>-<{/if}></td>
                                <td><{$data.reg.reg_city}></td>
                                <td><{$data.reg.reg_ip}></td>
                                <td>
                                    <{if $data.reg.reg_time}>
                                    <{$data.reg.reg_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                    <{else}>-<{/if}>
                                </td>
                                <td>(<{$_games[$data.reg.game_id]['pid']}>)<{$_games[$_games[$data.reg.game_id]['pid']]['text']}></td>
                                <td>(<{$data.reg.game_id}>)<{$_games[$data.reg.game_id]['text']}></td>
                                <td><{$data.reg.package_name}></td>
                                <td align="center">
                                    <{if $data.reg.device_type == 1}><i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>
                                    <{else}><i class="fa fa-android fa-lg text-success" aria-hidden="true"></i><{/if}>
                                </td>
                                <td><{$data.reg.sdk_version}></td>
                                <td><{$data.reg.device_id}></td>
                                <td><{$data.reg.device_name}></td>
                                <td><{$data.reg.device_version}></td>
                                <td><{$data.reg.uuid}></td>
                            </tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div>
            </li>

            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
                    <h3 class="layui-timeline-title">充值信息</h3>
                    <table class="layui-table" lay-size="sm">
                        <thead>
                        <tr>
                            <th>订单号</th>
                            <th>UID</th>
                            <th>账号</th>
                            <th>金额</th>
                            <th>支付渠道</th>
                            <th align="center">支付</th>
                            <th align="center">到账</th>
                            <th align="center">平台</th>
                            <th>母游戏</th>
                            <th>充值游戏</th>
                            <th>注册游戏</th>
                            <th>游戏包</th>
                            <th>区服</th>
                            <th>角色</th>
                            <th>等级</th>
                            <th>下单时间</th>
                            <th>支付时间</th>
                            <th>到账时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $data.pay as $item}>
                            <tr>
                                <td><{$item.pt_order_num}></td>
                                <td><{$item.uid}></td>
                                <td><{$item.username}></td>
                                <td><{$item.total_fee / 100}></td>
                                <td>
                                    <{if $item.pay_type > 0}><{$_payType[$item.pay_type]}>
                                    <{else}><{$_union[$item.union_channel]}> <{/if}>
                                </td>
                                <td align="center">
                                    <{if $item.is_pay == 2}><i class="fa fa-check text-success" aria-hidden="true"></i>
                                    <{elseif $item.is_pay == 3}><i class="fa fa-bug text-danger"></i>
                                    <{else}><i class="fa fa-times text-danger" aria-hidden="true"></i><{/if}>
                                </td>
                                <td align="center">
                                    <{if $item.is_notify == 1}><i class="fa fa-check text-success" aria-hidden="true"></i>
                                    <{else}><i class="fa fa-times text-danger" aria-hidden="true"></i><{/if}>
                                </td>
                                <td align="center">
                                    <{if $item.device_type == 1}><i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>
                                    <{else}><i class="fa fa-android fa-lg text-success" aria-hidden="true"></i><{/if}>
                                </td>
                                <td>(<{$_games[$item.game_id]['pid']}>)<{$_games[$_games[$item.game_id]['pid']]['text']}></td>
                                <td>(<{$item.game_id}>)<{$_games[$item.game_id]['text']}></td>
                                <td>(<{$item.reg_game_id}>)<{$_games[$item.reg_game_id]['text']}></td>
                                <td><{$item.package_name}></td>
                                <td><{$item.server_id}></td>
                                <td><{$item.role_name}></td>
                                <td><{$item.role_level}></td>
                                <td>
                                    <{if $item.create_time}>
                                    <{$item.create_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                    <{else}>-<{/if}>
                                </td>
                                <td>
                                    <{if $item.pay_time}>
                                    <{$item.pay_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                    <{else}>-<{/if}>
                                </td>
                                <td>
                                    <{if $item.notify_time}>
                                    <{$item.notify_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                    <{else}>-<{/if}>
                                </td>
                                <td>
                                    <span class="btn btn-info btn-xs orderLog" data-id="<{$item.pt_order_num}>"><i class="fa fa-calendar-minus-o fa-fw"></i>日志</span>
                                </td>
                            </tr>
                            <{/foreach}>
                        </tbody>
                    </table>
                </div>
            </li>

            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
                    <h3 class="layui-timeline-title">用户日志</h3>
                    <table class="layui-table" lay-size="sm">
                        <thead>
                        <tr>
                            <th width="100">UID</th>
                            <th width="80">类型</th>
                            <th width="150">记录时间</th>
                            <th>日志</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $data.log as $item}>
                            <tr>
                                <td><{$item.uid}></td>
                                <td><{$_logType[$item.type]}></td>
                                <td>
                                    <{if $item.time}>
                                    <{$item.time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                    <{else}>-<{/if}>
                                </td>
                                <td style="word-break:break-all;"><{$item.content}></td>
                            </tr>
                            <{/foreach}>
                        </tbody>
                    </table>
                </div>
            </li>

            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
                    <h3 class="layui-timeline-title">渠道上报</h3>
                    <table class="layui-table" lay-size="sm">
                        <thead>
                        <tr>
                            <th>推广ID</th>
                            <th>推广活动</th>
                            <th>来源</th>
                            <th>类型</th>
                            <th>上报时间</th>
                            <th>上报结果</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $data.upload as $item}>
                            <tr>
                                <td><{$item.monitor_id}></td>
                                <td><{$_monitor[$item.monitor_id]}></td>
                                <td><{$item.source}></td>
                                <td><{$_logAlias[$item.upload_type]}></td>
                                <td>
                                    <{if $item.upload_time}>
                                    <{$item.upload_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                    <{else}>-<{/if}>
                                </td>
                                <td><{$item.result}></td>
                            </tr>
                            <{/foreach}>
                        </tbody>
                    </table>
                </div>
            </li>

        </ul>
    </div>
</div>
<script>
    $(function () {
        $('.orderLog').on('click', function () {
            var order_num = $(this).data('id');
            var index = layer.load();
            $.post('/?ct=platform&ac=orderNumLog', {
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
        });
    });
</script>
<{include file="../public/foot.tpl"}>