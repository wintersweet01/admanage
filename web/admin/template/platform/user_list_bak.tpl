<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="userList"/>
            <div class="form-group">
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> ios </option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> 安卓 </option>
                </select>

                <label>选择渠道</label>
                <select name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>游戏包</label>
                <select name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data.package_name==$name.package_name}>selected="selected"<{/if}>> <{$name.package_name}> </option>
                    <{/foreach}>
                </select>

                <label>搜索</label>
                <input type="text" name="username" value="<{$data.username}>" placeholder="账号/手机号/设备号"/>
                <label>注册IP</label>
                <input type="text" name="reg_ip" value="<{$data.reg_ip}>"/>
                <input type="checkbox" name="has_phone" value="1" <{if $data.has_phone==1}>checked="checked"<{/if}> />只显示绑定手机的玩家
                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
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
                        <th nowrap>游戏包</th>
                        <th nowrap>平台</th>
                        <th nowrap>注册地区</th>
                        <th nowrap>注册IP</th>
                        <th nowrap>注册时间</th>
                        <th nowrap>激活时间</th>
                        <th nowrap>最后登录时间</th>
                        <th nowrap>最后充值时间</th>
                        <th nowrap>总充值</th>
                        <th nowrap>设备号 <i class="fa fa-question-circle" alt="点击内容可复制"></i></th>
                        <th nowrap>渠道</th>
                        <th nowrap>来源</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.uid}></td>
                            <td nowrap class="show-userinfo" data-keyword="<{$u.uid}>" data-full="<{$u.username}>"><{$u.username|truncate:15}></td>
                            <{if $data.has_phone==1}>
                            <td nowrap><{if $u.phone}><{$u.phone}><{else}>-<{/if}></td>
                            <{/if}>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap><{if $u.device_type == 1}><span class="icon_ios"></span><{elseif $u.device_type == 2}><span class="icon_android"></span><{else}>-<{/if}>
                            </td>
                            <td nowrap><{$u.reg_city}></td>
                            <td nowrap><{$u.reg_ip}></td>
                            <td nowrap><{$u.reg_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap><{if $u.active_time}><{$u.active_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.last_login_time}><{$u.last_login_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.last_pay_time}><{$u.last_pay_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap class="text-danger"><{if $u.pay_money > 0}><b>¥<{$u.pay_money}><{else}>-<{/if}>
                            </td>
                            <td nowrap class="show-full copy" data-full="<{$u.device_id}>" data-clipboard-text="<{$u.device_id}>"><{$u.device_id|truncate:15}></td>
                            <td nowrap><{if $_channels[$u.channel_id]}><{$_channels[$u.channel_id]}><{else}>未知<{/if}></td>
                            <td nowrap><{if $u.monitor_name}><a href="<{$u.jump_url}>" target="_blank"><{$u.monitor_name}></a><{else}>-<{/if}>
                            </td>
                            <td nowrap>
                                <{if SrvAuth::checkPublicAuth('edit',false)}>
                                <span class="unbind_phone btn btn-info btn-xs" data-id="<{$u.uid}>" data-phone="<{$u.phone}>"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span> 解绑手机</span>
                                <span class="reset_pwd btn btn-warning btn-xs" data-id="<{$u.uid}>"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 重置密码</span>
                                <span class="kick btn btn-success btn-xs" data-id="<{$u.uid}>"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> 踢下线</span>
                                <span class="band btn btn-xs <{if $u.status==1}>btn-success<{else}>btn-danger<{/if}>" data-id="<{$u.uid}>" data-status="<{$u.status}>"><{if $u.status==1}><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> 解封<{else}><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> 封禁<{/if}></span>
                                <{/if}>
                                <a href="?ct=platform&ac=logList&username=<{$u.username}>" class="btn btn-info btn-xs" target="_blank"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 日志</a>
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
        $('.reset_pwd').on('click', function () {
            var uid = $(this).attr('data-id');
            layer.confirm('确定重置uid为【' + uid + '】的用户登录密码吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('?ct=platform&ac=resetPwd',{uid:uid}, function (re) {
                    if (re.state) {
                        layer.alert('重置成功，新密码为【' + re.data.pwd + '】请妥善保存!', {
                            skin: 'layui-layer-molv' //样式类名
                            , closeBtn: 1
                        });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            }, function () {

            });
        });

        $('.band').on('click', function () {
            var o = $(this);
            var uid = $(this).data('id');
            var text = $(this).text();
            var status = $(this).data('status');

            layer.confirm('确定' + text + 'uid为【' + uid + '】的用户吗？<br><br><font color="red">封禁成功后，同时踢用户下线</font>', {
                btn: ['确定', '取消']
            }, function () {
                $.post('?ct=platform&ac=bandUser',{uid:uid,status:status}, function (re) {
                    if (re.state) {
                        layer.alert(text + '成功！', {
                            skin: 'layui-layer-molv' //样式类名
                            , closeBtn: 1
                        });
                        o.data('status', status ? 0 : 1);
                        if (status) {
                            o.removeClass('btn-success').addClass('btn-danger');
                            o.html('<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> 封禁');
                        } else {
                            o.removeClass('btn-danger').addClass('btn-success');
                            o.html('<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> 解封');
                        }
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            }, function () {

            });
        });

        //踢下线
        $('.kick').on('click', function () {
            var uid = $(this).data('id');
            layer.confirm('确定踢uid为【' + uid + '】的用户下线吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('?ct=platform&ac=kickUser',{uid:uid}, function (re) {
                    if (re.state) {
                        layer.alert('用户已被踢下线', {
                            skin: 'layui-layer-molv',
                            closeBtn: 1
                        });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            }, function () {

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

            layer.confirm('<span class="red">请先确保核实用户信息后再操作。<br>当前手机号为：' + phone + '</span><br><br>确定为uid【' + uid + '】的用户解绑手机吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('?ct=platform&ac=unbindPhone', {
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
            }, function () {

            });
        });

        var index;
        $('.show-full').mouseover(function () {
            var val = $(this).data('full');
            index = layer.tips(val, $(this));
        }).mouseout(function () {
            layer.close(index);
        });

        $('select[name=game_id],select[name=device_type],select[name=channel_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var device_type = $('select[name=device_type] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&device_type=' + device_type + '&channel_id=' + channel_id, function (re) {
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