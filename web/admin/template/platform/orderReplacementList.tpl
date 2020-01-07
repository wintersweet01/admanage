<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="orderReplacementList"/>

            <div class="form-group form-group-sm">
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select class="form-control" name="device_type" style="width: 50px;">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> ios </option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> 安卓 </option>
                </select>

                <label>游戏包</label>
                <select class="form-control" name="package_name" id="package_id" style="width: 150px;">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data.package_name==$name.package_name}>selected="selected"<{/if}>> <{$name.package_name}> </option>
                    <{/foreach}>
                </select>

                <label>选择支付方式</label>
                <select class="form-control" name="pay_type" style="width: 50px;">
                    <option value="0">全 部</option>
                    <{foreach from=$_pay_types key=id item=name}>
                <option value="<{$id}>" <{if $data.pay_type==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>订单号</label>
                <input type="text" class="form-control" name="pt_order_num" value="<{$data.pt_order_num}>" style="width: 120px;"/>

                <label>用户账号</label>
                <input type="text" class="form-control" name="username" value="<{$data.username}>" style="width: 100px;"/>

                <label>角色名称</label>
                <input type="text" class="form-control" name="role_name" value="<{$data.role_name}>" style="width: 80px;"/>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>
            </div>
        </form>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>订单号</th>
                        <th nowrap>玩家账号</th>
                        <th nowrap>金额</th>
                        <th nowrap>支付方式</th>
                        <th nowrap>平台</th>
                        <th nowrap>游戏包</th>
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
                            <td nowrap class="show-userinfo" data-keyword="<{$u.uid}>"><{$u.username|truncate:15}></td>
                            <td class="text-danger"><b>¥<{$u.total_fee/100}></b></td>
                            <td nowrap>
                                <{if $_pay_types[$u.pay_type]}><{$_pay_types[$u.pay_type]}>
                                <{else}><{$_pay_channel_types[$u.union_channel]}>
                                <{/if}>
                            </td>
                            <td nowrap>
                                <{if $u.device_type == 1}><span class="icon_ios"></span>
                                <{elseif $u.device_type == 2}><span class="icon_android"></span>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.server_id}></td>
                            <td nowrap><{$u.role_name}></td>
                            <td nowrap><{$u.role_level}></td>
                            <td nowrap><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap><{if $u.pay_time}><{$u.pay_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}>
                            </td>
                            <td nowrap class="pay">
                                <{if $u.is_pay == 2}>
                                <span class="label label-primary">已支付</span>
                                <{elseif $u.is_pay == 3}>
                                <span class="label label-warning">已支付（沙盒）</span>
                                <{else}>
                                <span class="label label-default">未支付</span>
                                <{/if}>
                            </td>
                            <td nowrap class="notify">
                                <{if $u.is_notify==1}>
                                <span class="label label-primary">已发放</span>
                                <{else}>
                                <span class="label label-default">未发放</span>
                                <{/if}>
                            </td>
                            <td>
                                <span data-id="<{$u.pt_order_num}>" data-options='<{$u|json_encode nofilter}>' class="<{if $u.is_pay == 1}>order_direct<{else}>disabled<{/if}> btn btn-danger btn-xs"><span class="glyphicon glyphicon-yen" aria-hidden="true"></span> 直充</span>
                                <span data-id="<{$u.pt_order_num}>" class="<{if $u.is_pay != 1 && $u.is_notify != 1}>order_reissue<{else}>disabled<{/if}> btn btn-success btn-xs"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> 补单</span>
                                <span data-id="<{$u.pt_order_num}>" class="order_log btn btn-info btn-xs"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 日志</span>
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
        //日志
        $('.order_log').on('click', function () {
            var order_num = $(this).data('id');
            $.post('?ct=platform&ac=orderNumLog', {
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

        //直充
        $('.order_direct').on('click', function () {
            var $this = $(this);
            var order_num = $(this).data('id');
            var options = $(this).data('options');
            var games = JSON.parse('<{$_games|json_encode nofilter}>');
            var pay_types = JSON.parse('<{$_pay_types|json_encode nofilter}>');
            var html = '请核对以下订单信息：<br><br><span>';
            html += '金额：<b>' + Math.round(options.total_fee / 100) + '</b><br>';
            html += '订单号：' + options.pt_order_num + '<br>';
            html += '支付方式：' + pay_types[options.pay_type] + '<br>';
            html += 'UID：' + options.uid + '<br>';
            html += '用户名：' + options.username + '<br>';
            html += '母游戏：' + games[options.parent_id] + '<br>';
            html += '子游戏：' + games[options.game_id] + '<br>';
            html += '服务器：' + options.server_id + '<br>';
            html += '角色：' + options.role_name + '<br>';
            html += '</span>';
            html += '<br><span class="red">该操作将不扣款而直接发放元宝，慎重！慎重！慎重！<br><br>是否确定发放？</span>';

            layer.confirm(html, {
                area: '400px',
                title: '信息核对',
                btn: ['确定', '取消']
            }, function () {
                var index = layer.msg('正在直充中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=orderDirect', {
                    pt_order_num: order_num
                }, function (re) {
                    layer.close(index);
                    if (re.state) {
                        layer.alert('直充成功！', {
                            skin: 'layui-layer-molv',
                            closeBtn: 1
                        }, function () {
                            layer.closeAll();
                            $this.off('click');
                            $this.removeClass('order_direct').addClass('disabled');
                            $this.parent('td').prevAll('.pay').html('<span class="label label-primary">已支付</span>');
                            $this.parent('td').prevAll('.notify').html('<span class="label label-primary">已发放</span>');
                        });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            }, function () {

            });
        });

        //补发
        $('.order_reissue').on('click', function () {
            var $this = $(this);
            var order_num = $(this).data('id');
            layer.confirm('确定手动发放？', {
                btn: ['确定', '取消']
            }, function () {
                var index = layer.msg('正在发放中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=handSendNotify', {
                    order_num: order_num
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        layer.alert('发放成功！', {
                            skin: 'layui-layer-molv',
                            closeBtn: 1
                        }, function () {
                            layer.closeAll();
                            $this.off('click');
                            $this.removeClass('order_reissue').addClass('disabled');
                            $this.parent('td').prevAll('.notify').html('<span class="label label-primary">已发放</span>');
                        });
                    } else {
                        layer.msg(re.msg, {icon: 2});
                    }
                }, 'json');
            }, function () {

            });
        });

        $('select[name=game_id],select[name=device_type]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var device_type = $('select[name=device_type] option:selected').val();
            if (!game_id) {
                return false;
            }

            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&device_type=' + device_type, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>