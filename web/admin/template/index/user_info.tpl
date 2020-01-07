<{include file="../public/header-bootstrap.tpl"}>
<style type="text/css">
    .role-list {
        max-width: 54em;
    }

    @media screen and (max-width: 767px) {
        .role-list {
            max-width: 42em;
        }
    }

    @media (max-device-width: 640px) and (orientation: landscape) {
        .role-list {
            max-width: 36em;
        }
    }

</style>
<div class="container-fluid" style="padding: 2rem;">
    <{if !$data.user}>
    <h1 class="text-center">无数据</h1>
    <{else}>
    <div class="row">
        <h3 class="mb-3">匹配用户数：<{$data.user|count}></h3>
        <div id="users" class="card-columns" style="column-count: 1">
            <{foreach $data.user as $u}>
            <div class="card <{if $u@iteration is div by 2}>border-danger<{else}>border-primary<{/if}>">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-3">
                            用户信息
                        </div>
                        <div class="col-9 text-right">
                            <button type="button" class="btn btn-info btn-sm" my-event="relate" data-uid="<{$u.uid}>">
                                <i class="fa fa-link fa-fw" aria-hidden="true"></i>查看关联信息
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" my-event="kick" data-uid="<{$u.uid}>">
                                <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>踢下线
                            </button>
                            <{if $u.status == 1}>
                            <button type="button" class="btn btn-success btn-sm" my-event="band" data-uid="<{$u.uid}>" data-status="<{$u.status}>">
                                <i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封
                            </button>
                            <{else}>
                            <button type="button" class="btn btn-danger btn-sm" my-event="band" data-uid="<{$u.uid}>" data-status="<{$u.status}>">
                                <i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁
                            </button>
                            <{/if}>
                            <{if SrvAuth::checkPublicAuth('userPhoneEdit,userIdNumberEdit',false)}>
                            <button type="button" class="btn btn-primary btn-sm" my-event="save" data-uid="<{$u.uid}>">
                                <i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>保存修改
                            </button>
                            <{/if}>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>UID</label>
                            <input type="text" class="form-control" value="<{$u.uid}>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>账号</label>
                            <input type="text" class="form-control" value="<{$u.username}>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>总充值</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-success">¥</span>
                                </div>
                                <input type="text" class="form-control text-danger" value="<{$u.pay_money}>" readonly>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>最后充值时间</label>
                            <input type="text" class="form-control" value="<{if $u.last_pay_time > 0}><{$u.last_pay_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}>" readonly>
                        </div>
                    </div>

                    <div class="form-row list-group-item-warning">
                        <{if SrvAuth::checkPublicAuth('userPhone',false)}>
                        <div class="form-group col-md-4">
                            <label>手机号</label>
                            <input type="text" name="phone" class="form-control" value="<{$u.phone}>">
                        </div>
                        <{/if}>
                        <{if SrvAuth::checkPublicAuth('userIdNumber',false)}>
                        <div class="form-group col-md-3">
                            <label>真实姓名</label>
                            <input type="text" name="name" class="form-control" value="<{$u.name}>">
                        </div>
                        <div class="form-group col-md-5">
                            <label>身份证号码</label>
                            <input type="text" name="id_number" class="form-control" value="<{$u.id_number}>">
                        </div>
                        <{/if}>
                    </div>

                    <div class="form-row">
                        <{if SrvAuth::checkPublicAuth('channel',false)}>
                        <div class="form-group col-md-2">
                            <label>注册渠道</label>
                            <input type="text" class="form-control" value="<{$_channels[$u.channel_id]}>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>注册来源</label>
                            <input type="text" class="form-control" value="<{$u.monitor_name}>" readonly>
                        </div>
                        <{/if}>
                        <div class="form-group col-md-3">
                            <label>设备号</label>
                            <input type="text" class="form-control" value="<{$u.device_id}>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>UUID</label>
                            <input type="text" class="form-control" value="<{$u.uuid}>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>注册母游戏</label>
                            <input type="text" class="form-control" value="<{$_games[$_games[$u.reg_game_id]['pid']]['text']}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>注册子游戏</label>
                            <input type="text" class="form-control" value="<{$_games[$u.reg_game_id]['text']}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>平台</label>
                            <input type="text" class="form-control" value="<{if $u.device_type == 1}>IOS<{else}>Android<{/if}>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>包标识</label>
                            <input type="text" class="form-control" value="<{$u.package_name}>" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label>包版本</label>
                            <input type="text" class="form-control" value="<{$u.package_version}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>SDK版本</label>
                            <input type="text" class="form-control" value="<{$u.sdk_version}>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>激活时间</label>
                            <input type="text" class="form-control" value="<{if $u.active_time > 0}><{$u.active_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>注册时间</label>
                            <input type="text" class="form-control" value="<{$u.reg_time|date_format:"%Y/%m/%d %H:%M:%S"}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>最后登录时间</label>
                            <input type="text" class="form-control" value="<{$u.last_login_time|date_format:"%Y/%m/%d %H:%M:%S"}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>注册IP</label>
                            <input type="text" class="form-control" value="<{$u.reg_ip}>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>注册地区</label>
                            <input type="text" class="form-control" value="<{$u.area}>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>设备型号</label>
                            <input type="text" class="form-control" value="<{$u.device_name}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>系统版本</label>
                            <input type="text" class="form-control" value="<{$u.device_version}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>系统标识</label>
                            <input type="text" class="form-control" value="<{$u.os_flag}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>分辨率</label>
                            <input type="text" class="form-control" value="<{$u.resolution}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>设备厂商</label>
                            <input type="text" class="form-control" value="<{$u.producer}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>网络运营商</label>
                            <input type="text" class="form-control" value="<{$u.isp}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>网络类型</label>
                            <input type="text" class="form-control" value="<{$u.network_type}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>用户类型</label>
                            <input type="text" class="form-control" value="<{$_pay_channel_types[$u.type]}>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>第三方账号ID</label>
                            <input type="text" class="form-control" value="<{$u.openid}>" readonly>
                        </div>
                    </div>
                </div>
                <div class="card-footer">角色信息</div>
                <div class="card-body">
                    <h5 class="card-title">总共角色：<{$data['role'][$u.uid]|count}></h5>
                    <{if $data['role'][$u.uid]|count > 0}>
                    <div class="role-list">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="white-space: nowrap;">
                                <thead>
                                <tr>
                                    <th class="align-middle" scope="col">母游戏</th>
                                    <th class="align-middle" scope="col">子游戏</th>
                                    <th class="align-middle" scope="col">SID</th>
                                    <th class="align-middle" scope="col">服务器</th>
                                    <th class="align-middle" scope="col">角色ID</th>
                                    <th class="align-middle" scope="col">角色</th>
                                    <th class="align-middle" scope="col">等级</th>
                                    <th class="align-middle" scope="col">创建时间</th>
                                    <th class="align-middle" scope="col">总充值</th>
                                </tr>
                                </thead>
                                <tbody>
                                <{foreach $data['role'][$u.uid] as $role}>
                                    <tr class="<{if $role@iteration is div by 2}>table-secondary<{else}>table-primary<{/if}>">
                                        <td class="align-middle">
                                            <{$_games[$_games[$role.game_id]['pid']]['text']}>
                                        </td>
                                        <td class="align-middle"><{$_games[$role.game_id]['text']}></td>
                                        <td class="align-middle"><{$role.server_id}></td>
                                        <td class="align-middle">
                                            <{if $role.server_name}>
                                            <{$role.server_name}>
                                            <{else}><{$role.server_id}>
                                            <{/if}>
                                        </td>
                                        <td class="align-middle" scope="row"><{$role.role_id}></td>
                                        <td class="align-middle"><{$role.role_name}></td>
                                        <td class="align-middle"><{$role.role_level}></td>
                                        <td class="align-middle">
                                            <{$role.create_time|date_format:"%Y/%m/%d %H:%M:%S"}>
                                        </td>
                                        <td class="align-middle text-danger">
                                            <{if $role.pays > 0}>¥<{$role.pays}><{else}>-<{/if}>
                                        </td>
                                    </tr>
                                    <{/foreach}>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <{/if}>
                </div>
            </div>
            <{/foreach}>
        </div>
    </div>
    <{/if}>
</div>
<script type="text/javascript">
    $(function () {
        $('#users').on('click', '*[my-event]', function (e) {
            var othis = $(this),
                event = othis.attr('my-event'),
                uid = othis.data('uid');

            switch (event) {
                case 'kick': //踢下线
                    top.layer.confirm('确定踢UID为【' + uid + '】的用户下线吗？', function () {
                        var index = top.layer.load(2, {shade: [0.6,'#fff']});
                        $.post("/?ct=base&ac=kickUser", {
                            uid: uid
                        }, function (ret) {
                            top.layer.close(index);
                            if (ret.state) {
                                top.layer.msg('用户已被踢下线',{icon: 6,shade:0.6,shadeClose:true});
                            } else {
                                top.layer.msg(ret.msg,{icon: 5,shade:0.6,shadeClose:true});
                            }
                        }, "json");
                    });
                    break;
                case 'band': //封禁/解封
                    var status = othis.data('status'),
                        label = status ? '解封' : '封禁';

                    top.layer.prompt({
                        title: '确定<span style="color: red;"><b>' + label + '</b></span>UID为【' + uid + '】的用户吗？',
                        value: status ? ' ' : '',
                        formType: 2
                    }, function (text, index, elem) {
                        var _index = top.layer.load(2, {shade: [0.6,'#fff']});
                        $.post("/?ct=base&ac=bandUser", {
                            uid: uid,
                            status: status,
                            text: text
                        }, function (ret) {
                            top.layer.close(_index);
                            if (ret.state) {
                                top.layer.msg(label + '成功',{icon: 6,shade:0.6,shadeClose:true}, function () {
                                    top.layer.close(index);
                                });

                                othis.data('status', status ? 0 : 1);
                                if (status) {
                                    othis.html('<i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁');
                                    othis.removeClass('btn-success').addClass('btn-danger');
                                } else {
                                    othis.html('<i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封');
                                    othis.removeClass('btn-danger').addClass('btn-success');
                                }
                            } else {
                                top.layer.msg(ret.msg,{icon: 5,shade:0.6,shadeClose:true});
                            }
                        }, "json");
                    });
                    break;
                case 'save': //保存修改
                    top.layer.confirm('确定修改UID为【' + uid + '】' + '的用户信息？', function () {
                        var cbody = othis.parents('.card-header').next('.card-body');
                        var index = top.layer.load(2, {shade: [0.6,'#fff']});
                        $.post("/?ct=base&ac=getUserInfo", {
                            uid: uid,
                            phone: cbody.find('input[name="phone"]').val(),
                            name: cbody.find('input[name="name"]').val(),
                            id_number: cbody.find('input[name="id_number"]').val()
                        }, function (ret) {
                            top.layer.close(index);
                            if (ret.code === 1) {
                                top.layer.msg(ret.message,{icon: 6,shade:0.6,shadeClose:true});
                            } else {
                                top.layer.msg(ret.message,{icon: 5,shade:0.6,shadeClose:true});
                            }
                        }, "json");
                    });
                    break;
                case 'relate': //关联信息
                    var is_mobile = false;
                    if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
                        is_mobile = true;
                    }

                    top.layer.open({
                        type: 2,
                        title: 'UID为【' + uid + '】的关联信息',
                        shadeClose: false,
                        shade: 0.8,
                        area: is_mobile ? ['100%', '100%'] : ['50%', '80%'],
                        content: '/?ct=user&ac=getUserRelate&uid=' + uid
                    });
                    break;
            }
        });
    });
</script>
<{include file="../public/footer.tpl"}>