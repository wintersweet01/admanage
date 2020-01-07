<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="service"/>
            <input type="hidden" name="ac" value="orderList"/>

            <div class="form-group form-group-sm">
                <label>选择平台</label>
                <select class="form-control" name="device_type" style="width: 50px;">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> ios </option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> 安卓 </option>
                </select>

                <label>支付渠道</label>
                <select class="form-control" name="pay_channel" style="width: 50px;">
                    <option value="">全 部</option>
                    <{foreach from=$_pay_channel_types key=id item=name}>
                <option value="<{$id}>" <{if $data.pay_channel==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>支付方式</label>
                <select class="form-control" name="pay_type" style="width: 50px;">
                    <option value="0">全 部</option>
                    <{foreach from=$_pay_types key=id item=name}>
                <option value="<{$id}>" <{if $data.pay_type==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>支付状态</label>
                <select class="form-control" name="is_pay" style="width: 50px;">
                    <option value="0">全 部</option>
                    <{foreach from=$smarty.const.PAY_STATUS key=name item=id}>
                <option value="<{$id}>" <{if $data.is_pay==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>到账状态</label>
                <select class="form-control" name="is_notify" style="width: 50px;">
                    <option value="0">全 部</option>
                    <option value="1"
                    <{if $data.is_notify==1}>selected="selected"<{/if}>>未发放</option>
                    <option value="2"
                    <{if $data.is_notify==2}>selected="selected"<{/if}>>已发放</option>
                </select>
            </div>

            <div class="form-group form-group-sm" style="margin-top: 5px;">
                <label>订单时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate" style="width: 100px;"/>

                <label>订单号</label>
                <input type="text" class="form-control" name="pt_order_num" value="<{$data.pt_order_num}>" style="width: 150px;"/>

                <label>用户账号</label>
                <input type="text" class="form-control" name="username" value="<{$data.username}>" style="width: 120px;"/>

                <label>角色名称</label>
                <input type="text" class="form-control" name="role_name" value="<{$data.role_name}>" style="width: 120px;"/>

                <label>充值区间</label>
                <input type="text" class="form-control" name="level1" value="<{$data.level1}>" style="width:40px;"/> -
                <input type="text" class="form-control" name="level2" value="<{$data.level2}>" style="width:40px;"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <{if $data.username}>
            <div class="bg-warning" style="font-weight: bold;">
                <span>
                    玩家：<{$data.username}>，
                    充值次数：<{$data.total.c|default:0}>，
                    总充值金额：<span class="text-red"><{$data.total.total_fee|default:0}></span>
                </span>
            </div>
            <{/if}>
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>订单号</th>
                        <th nowrap>玩家账号</th>
                        <th nowrap>金额</th>
                        <th nowrap>支付渠道</th>
                        <th nowrap>所属平台</th>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>区服</th>
                        <th nowrap>游戏角色</th>
                        <th nowrap>充值时等级</th>
                        <th nowrap>下单时间</th>
                        <th nowrap>支付时间</th>
                        <th nowrap>支付状态</th>
                        <th nowrap>发放状态</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.pt_order_num}></td>
                            <td nowrap class="show-userinfo" data-keyword="<{$u.uid}>" data-full="<{$u.username}>">
                                <{$u.username|truncate:15}>
                            </td>
                            <td class="text-danger"><b>¥<{$u.total_fee/100}></b></td>
                            <td nowrap>
                                <{if $_pay_types[$u.pay_type]}><{$_pay_types[$u.pay_type]}>
                                <{else}><{$_pay_channel_types[$u.union_channel]}><{/if}>
                            </td>
                            <td nowrap>
                                <{if $u.device_type == 1}><span class="icon_ios"></span>
                                <{elseif $u.device_type == 2}><span class="icon_android"></span>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.server_id}></td>
                            <td nowrap><{$u.role_name}></td>
                            <td nowrap><{$u.role_level}></td>
                            <td nowrap><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap>
                                <{if $u.pay_time}><{$u.pay_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap>
                                <{if $u.is_pay == 2}>
                                <span class="label label-primary">已支付</span>
                                <{elseif $u.is_pay == 3}>
                                <span class="label label-warning">已支付（沙盒）</span>
                                <{else}>
                                <span class="label label-default">未支付</span>
                                <{/if}>
                            </td>
                            <td nowrap>
                                <{if $u.is_pay>1 && $u.is_notify==0 && SrvAuth::checkPublicAuth('audit',false)}>
                                <span class="send btn btn-success btn-xs" data-order="<{$u.pt_order_num}>">手动发放</span>
                                <{elseif $u.is_notify==1}>
                                <span class="label label-primary">已发放</span>
                                <{else}> - <{/if}>
                            </td>
                            <td>
                                <span data-id="<{$u.pt_order_num}>" class="<{if $u.is_pay == 1}>order_check<{else}>disabled<{/if}> btn btn-success btn-xs"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 检查</span>
                                <!--<span data-id="<{$u.pt_order_num}>" class="order_log btn btn-info btn-xs"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 日志</span>-->
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div>
                <nav>
                    <ul class="pagination">
                        <{$data.page_html nofilter}>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        //订单日志
        $('.order_log').on('click', function () {
            var order_num = $(this).data('id');
            $.post('?ct=service&ac=orderNumLog', {
                pt_order_num: order_num
            }, function (re) {
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

        //检查
        $('.order_check').on('click', function () {
            var order_num = $(this).data('id');
            var index = layer.msg('正在检查中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.post('?ct=service&ac=orderNumCheck', {
                pt_order_num: order_num
            }, function (re) {
                layer.close(index);
                if (re.state) {
                    location.reload();
                } else {
                    layer.msg('未支付或者此支付方式不支持手动检查');
                    return false;
                }
            }, 'json');
        });

        //手动发放
        $('.send').on('click', function () {
            var order_num = $(this).data('order');
            layer.confirm('确定手动发放？', {
                btn: ['确定', '取消']
            }, function () {
                var index = layer.msg('正在发放中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=service&ac=handSendNotify', {
                    order_num: order_num
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        location.reload();
                    } else {
                        layer.msg(re.msg, {icon: 2});
                    }
                }, 'json');
            }, function () {

            });
        });

        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
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
        });
    });
</script>
<{include file="../public/foot.tpl"}>