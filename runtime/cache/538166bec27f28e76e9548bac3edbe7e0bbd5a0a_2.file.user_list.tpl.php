<?php /* Smarty version 3.1.27, created on 2019-11-29 20:15:37
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/user_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2352776035de10be9283f47_21543658%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '538166bec27f28e76e9548bac3edbe7e0bbd5a0a' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/user_list.tpl',
      1 => 1574673376,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2352776035de10be9283f47_21543658',
  'variables' => 
  array (
    'widgets' => 0,
    '_device_types' => 0,
    'id' => 0,
    'name' => 0,
    '_channels' => 0,
    '_union_channel' => 0,
    'data' => 0,
    'is_admin' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10be92d3ab5_53214745',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10be92d3ab5_53214745')) {
function content_5de10be92d3ab5_53214745 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2352776035de10be9283f47_21543658';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

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
                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

                            </div>

                            <div class="form-group">
                                <label>选择平台</label>
                                <select class="form-control" name="device_type">
                                    <option value="">全 部</option>
                                    <?php
$_from = $_smarty_tpl->tpl_vars['_device_types']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['id']->_loop = false;
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value => $_smarty_tpl->tpl_vars['id']->value) {
$_smarty_tpl->tpl_vars['id']->_loop = true;
$foreach_id_Sav = $_smarty_tpl->tpl_vars['id'];
?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                                    <?php
$_smarty_tpl->tpl_vars['id'] = $foreach_id_Sav;
}
?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>选择渠道</label>
                                <select class="form-control" name="channel_id">
                                    <option value="">全 部</option>
                                    <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>游戏包</label>
                                <select class="form-control" name="package_name" id="package_id" style="min-width: 150px;">
                                    <option value="">全 部</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>用户来源</label>
                                <select class="form-control" name="type" style="width: 50px;">
                                    <option value="">全 部</option>
                                    <?php
$_from = $_smarty_tpl->tpl_vars['_union_channel']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>第三方账号ID</label>
                                <input type="text" name="openid" value="" class="form-control" style="min-width: 200px;"/>
                            </div>

                            <div class="form-group">
                                <label>注册日期</label>
                                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" autocomplete="off" readonly/>
                                至
                                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" autocomplete="off" readonly/>
                            </div>

                            <div class="form-group">
                                <label>搜索</label>
                                <input type="text" name="keyword" value="" class="form-control" placeholder="UID/账号/手机号/设备号/注册IP" style="min-width: 200px;"/>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="has_phone" value="1"/>绑定手机
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="banned" value="1"/>封禁
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
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-report">
            <?php if (SrvAuth::checkPublicAuth('edit',false)) {?>
                <a class="btn btn-default btn-xs" lay-event="unbindPhone"><i class="fa fa-chain-broken fa-fw" aria-hidden="true"></i>解绑手机</a>
                <a class="btn btn-primary btn-xs" lay-event="resetPwd"><i class="fa fa-repeat fa-fw" aria-hidden="true"></i>重置密码</a>
                <a class="btn btn-warning btn-xs" lay-event="kick"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>踢下线</a>
            {{# if(d.status == 1){ }}
                <a class="btn btn-success btn-xs" lay-event="band"><i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封</a>
            {{# } else { }}
                <a class="btn btn-danger btn-xs" lay-event="band"><i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁</a>
            {{# } }}
                <?php }?>
            <a href="/?ct=platform&ac=logList&username={{d.username}}" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-calendar-minus-o fa-fw" aria-hidden="true"></i>日志</a>
            <?php if ($_smarty_tpl->tpl_vars['is_admin']->value == 1) {?>
                <span class="btn btn-danger btn-xs" lay-event="del"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>删除</span>
                <?php }?>
        <?php echo '</script'; ?>
>
    </div>
</div>
<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function () {
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

    layui.config({
        version: '2019021815',
    }).use('table', function () {
        var table = layui.table;
        var cols = [[
            {field:'uid', width:100, title: 'UID', align: 'center', fixed: 'left'},
            {field:'username', width: 120, title: '账号', align: 'center', fixed: 'left', event: 'showUserInfo', style:'cursor: pointer;'},
            {field:'openid', width:200, title: '第三方账号ID', align: 'center', hide: true},
            {field:'phone', width:120, title: '手机号', align: 'center', hide: true},
            {field:'parent_name', width:100, title: '母游戏', align: 'center'},
            {field:'game_name', width:200, title: '注册游戏'},
            {field:'package_name', width:280, title: '游戏包'},
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
            {field:'type_name', width:100, title: '用户来源', align: 'center'},
            {field:'area', width:250, title: '注册地区'},
            {field:'reg_ip', width:150, title: '注册IP'},
            {field:'reg_time', width:180, title: '注册时间', align: 'center'},
            {field:'active_time', width:180, title: '激活时间', align: 'center'},
            {field:'last_login_time', width:180, title: '最后登录时间', align: 'center'},
            {field:'last_pay_time', width:180, title: '最后充值时间', align: 'center'},
            {
                field: 'pay_money',
                width: 100,
                title: '总充值',
                align: 'center',
                templet: function (d) {
                    var str = '-';
                    if (d.pay_money > 0) {
                        str = '<span style="color:#a94442;">' + d.pay_money + '</span>';
                    }
                    return str;
                }
            },
            {field:'device_id', width:150, title: '设备号', align: 'center', event: 'copy', style:'cursor: pointer;'},
            {field:'channel_name', width:100, title: '渠道', align: 'center'},
            {field:'monitor_name', width:350, title: '来源', align: 'center'},
            {minWidth:420, title: '操作', align: 'center', toolbar: '#toolbar-report'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '用户管理',
            url: '/?ct=platform&ac=userList&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            page: true,
            limit: 15,
            limits: [15, 50, 100, 200, 500],
            toolbar: true,
            cols: cols
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            if ($('input[name="has_phone"]').prop("checked")) {
                cols[0][3]['hide'] = false;
            } else {
                cols[0][3]['hide'] = true;
            }

            let type = $('select[name="type"]').val();
            let openid = $('input[name="openid"]').val();
            if (type) {
                cols[0][2]['hide'] = false;
            } else {
                cols[0][2]['hide'] = true;
            }

            if (openid && !type) {
                layer.alert('使用第三方账号查询必须选择对应的用户来源！');
                return false;
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
            var uid = data.uid;

            switch (layEvent) {
                case 'showUserInfo': //查用户信息
                    JsMain.search(data.username);
                    break;
                case 'copy': //复制
                    var input = $('#copy');
                    input.val(data.device_id);
                    input.select();
                    var boolean = document.execCommand("Copy");
                    if (boolean) {
                        layer.tips('复制成功', $this, {
                            tips: [4, '#3595CC'],
                            time: 2000
                        });
                    } else {
                        layer.tips('复制失败', $this, {
                            tips: [4, '#FF0000'],
                            time: 2000
                        });
                    }
                    break;
                case 'unbindPhone'://解绑手机
                    var phone = data.phone;
                    if (!phone) {
                        layer.alert('该用户未绑定手机');
                        return false;
                    }
                    layer.confirm('<span class="red">请先确保核实用户信息后再操作。<br>当前手机号为：' + phone + '</span><br><br>确定为uid【' + uid + '】的用户解绑手机吗？', function () {
                        var index = layer.load();
                        $.post('?ct=platform&ac=unbindPhone', {
                            uid: uid
                        }, function (re) {
                            layer.close(index);
                            if (re.code == 1) {
                                layer.alert('解绑成功!', {
                                    skin: 'layui-layer-molv',
                                    closeBtn: 1
                                }, function () {
                                    layer.closeAll();
                                    tableIns.reload();
                                });
                            } else {
                                layer.msg(re.message);
                            }
                        }, 'json');
                    });
                    break;
                case 'resetPwd': //重置密码
                    layer.confirm('确定重置uid为【' + uid + '】的用户登录密码吗？', function () {
                        var index = layer.load();
                        $.post('?ct=platform&ac=resetPwd', {
                            uid: uid
                        }, function (re) {
                            layer.close(index);
                            if (re.state) {
                                layer.alert('重置成功，新密码为【' + re.data.pwd + '】，请妥善保存!', {
                                    skin: 'layui-layer-molv',
                                    closeBtn: 1
                                });
                            } else {
                                layer.msg(re.msg);
                            }
                        }, 'json');
                    });
                    break;
                case 'kick': //踢下线
                    layer.confirm('确定踢UID为【' + uid + '】的用户下线吗？', function () {
                        var index = layer.load();
                        $.post('?ct=platform&ac=kickUser', {
                            uid: uid
                        }, function (ret) {
                            layer.close(index);
                            if (ret.state) {
                                layer.alert('用户已被踢下线', {
                                    skin: 'layui-layer-molv',
                                    closeBtn: 1
                                });
                            } else {
                                layer.msg(ret.msg);
                            }
                        }, 'json');
                    });
                    break;
                case 'band': //封禁/解封
                    var label = $this.text(),
                        status = parseInt(data.status);

                    layer.prompt({
                        title: '确定<span style="color: red;"><b>' + label + '</b></span>UID为【' + uid + '】的用户吗？',
                        value: status ? ' ' : '',
                        formType: 2
                    }, function (text, index, elem) {
                        var _index = layer.load();
                        $.post("/?ct=platform&ac=bandUser", {
                            uid: uid,
                            status: status,
                            text: text
                        }, function (ret) {
                            layer.close(_index);
                            if (ret.state) {
                                obj.update({
                                    status: status ? 0 : 1
                                });

                                layer.alert(label + '成功！', {
                                    skin: 'layui-layer-molv',
                                    closeBtn: 1
                                }, function () {
                                    layer.closeAll();
                                    if (status) {
                                        $this.html('<i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁');
                                        $this.removeClass('btn-success').addClass('btn-danger');
                                    } else {
                                        $this.html('<i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封');
                                        $this.removeClass('btn-danger').addClass('btn-success');
                                    }
                                });
                            } else {
                                layer.msg(ret.msg);
                            }
                        }, "json");
                    });
                    break;
                case 'del'://删除用户
                    layer.confirm('<span class="red">删除后，该用户所有相关资料一并删除，慎重！慎重！慎重！</span><br><br>确定删除【' + uid + '】' + data.username + '的用户吗？', function () {
                        var index = layer.load();
                        $.post('?ct=platform&ac=delUser', {
                            uid: uid
                        }, function (re) {
                            layer.close(index);
                            if (re.code == 1) {
                                layer.alert('删除成功!', {
                                    skin: 'layui-layer-molv',
                                    closeBtn: 1
                                }, function () {
                                    layer.closeAll();
                                    tableIns.reload();
                                });
                            } else {
                                layer.msg(re.message);
                            }
                        }, 'json');
                    });
                    break;
            }
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>