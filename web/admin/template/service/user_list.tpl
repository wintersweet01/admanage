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
                        <input type="hidden" name="ct" value="service"/>
                        <input type="hidden" name="ac" value="userList"/>
                        <div class="row form-group-sm">
                            <div class="form-group">
                                <label>选择平台</label>
                                <select class="form-control" name="device_type">
                                    <option value="">全 部</option>
                                    <option value="1"
                                    <{if $data.device_type==1}>selected="selected"<{/if}>> ios </option>
                                    <option value="2"
                                    <{if $data.device_type==2}>selected="selected"<{/if}>> 安卓 </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>搜索</label>
                                <input type="text" class="form-control" name="keyword" value="<{$data.keyword}>" placeholder="账号/手机号/设备号/注册IP"/>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="has_phone" value="1"
                                    <{if $data.has_phone==1}>checked="checked"<{/if}>>绑定手机
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="banned" value="1"
                                    <{if $data.banned==1}>checked="checked"<{/if}>>封禁
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
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
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>UID</th>
                        <th nowrap>账号</th>
                        <{if $data.has_phone==1}>
                        <th nowrap>手机号</th>
                        <{/if}>
                        <th nowrap>母游戏</th>
                        <th nowrap>注册游戏</th>
                        <th nowrap>所属平台</th>
                        <th nowrap>用户类型</th>
                        <th nowrap>注册地区</th>
                        <th nowrap>注册IP</th>
                        <th nowrap>注册时间</th>
                        <th nowrap>激活时间</th>
                        <th nowrap>最后登录时间</th>
                        <th nowrap>最后充值时间</th>
                        <th nowrap>总充值</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.uid}></td>
                            <td nowrap class="show-userinfo" data-keyword="<{$u.uid}>" data-full="<{$u.username}>">
                                <{$u.username|truncate:15}>
                            </td>
                            <{if $data.has_phone==1}>
                            <td nowrap><{if $u.phone}><{$u.phone}><{else}>-<{/if}></td>
                            <{/if}>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap>
                                <{if $u.device_type == 1}><span class="icon_ios"></span>
                                <{elseif $u.device_type == 2}><span class="icon_android"></span>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap><{$u.type}></td>
                            <td nowrap><{$u.reg_city}></td>
                            <td nowrap><{$u.reg_ip}></td>
                            <td nowrap><{$u.reg_time}></td>
                            <td nowrap><{if $u.active_time}><{$u.active_time}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.last_login_time}><{$u.last_login_time}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.last_pay_time}><{$u.last_pay_time}><{else}>-<{/if}></td>
                            <td nowrap class="text-danger"><{if $u.pay_money > 0}><b>¥<{$u.pay_money}><{else}>-<{/if}>
                            </td>
                            <td nowrap>
                                <{if SrvAuth::checkPublicAuth('edit',false)}>
                                <span class="unbind_phone btn btn-info btn-xs" data-id="<{$u.uid}>" data-phone="<{$u.phone}>"><i class="fa fa-chain-broken fa-fw" aria-hidden="true"></i>解绑手机</span>
                                <span class="reset_pwd btn btn-primary btn-xs" data-id="<{$u.uid}>"><i class="fa fa-repeat fa-fw" aria-hidden="true"></i>重置密码</span>
                                <span class="kick btn btn-warning btn-xs" data-id="<{$u.uid}>"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>踢下线</span>
                                <span class="band btn btn-xs <{if $u.status==1}>btn-success<{else}>btn-danger<{/if}>" data-id="<{$u.uid}>" data-status="<{$u.status}>">
                                    <{if $u.status==1}><i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封<{else}><i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁<{/if}>
                                </span>
                                <{/if}>
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
        //重置密码
        $('.reset_pwd').on('click', function () {
            var uid = $(this).data('id');
            layer.confirm('确定重置uid为【' + uid + '】的用户登录密码吗？', function () {
                $.post('?ct=service&ac=userResetPwd',{uid:uid}, function (re) {
                    if (re.state) {
                        layer.alert('重置成功，新密码为【' + re.data.pwd + '】请妥善保存!', {
                            skin: 'layui-layer-molv',
                            closeBtn: 1
                        });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //封禁
        $('.band').on('click', function () {
            var o = $(this),
                uid = o.data('id'),
                label = o.text(),
                status = o.data('status');

            layer.prompt({
                title: '确定<span style="color: red;"><b>' + label + '</b></span>UID为【' + uid + '】的用户吗？',
                value: status ? ' ' : '',
                formType: 2
            }, function (text, index, elem) {
                var _index = layer.load();
                $.post("/?ct=service&ac=userBand", {
                    uid: uid,
                    status: status,
                    text: text
                }, function (ret) {
                    layer.close(_index);
                    if (ret.state) {
                        o.data('status', status ? 0 : 1);
                        layer.alert(label + '成功！', {
                            skin: 'layui-layer-molv',
                            closeBtn: 1
                        }, function () {
                            layer.closeAll();
                            if (status) {
                                o.html('<i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁');
                                o.removeClass('btn-success').addClass('btn-danger');
                            } else {
                                o.html('<i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封');
                                o.removeClass('btn-danger').addClass('btn-success');
                            }
                        });
                    } else {
                        layer.msg(ret.msg);
                    }
                }, "json");
            });
        });

        //踢下线
        $('.kick').on('click', function () {
            var uid = $(this).data('id');
            layer.confirm('确定踢uid为【' + uid + '】的用户下线吗？', function () {
                $.post('?ct=service&ac=userKick',{uid:uid}, function (re) {
                    if (re.state) {
                        layer.alert('用户已被踢下线', {
                            skin: 'layui-layer-molv',
                            closeBtn: 1
                        });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        //解绑手机号
        $('.unbind_phone').on('click', function () {
            var uid = $(this).data('id');
            var phone = $(this).data('phone');

            if (!phone) {
                layer.alert('该用户未绑定手机');
                return false;
            }

            layer.confirm('<span class="red">请先确保核实用户信息后再操作。<br>当前手机号为：' + phone + '</span><br><br>确定为uid【' + uid + '】的用户解绑手机吗？', function () {
                $.post('?ct=service&ac=unbindPhone', {
                    uid: uid
                }, function (re) {
                    if (re.code == 1) {
                        layer.alert('解绑成功!', {
                            skin: 'layui-layer-molv',
                            closeBtn: 1
                        }, function () {
                            location.reload();
                        });
                    } else {
                        layer.msg(re.message);
                    }
                }, 'json');
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>