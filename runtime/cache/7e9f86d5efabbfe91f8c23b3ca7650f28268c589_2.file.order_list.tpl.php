<?php /* Smarty version 3.1.27, created on 2019-12-12 20:00:21
         compiled from "/home/vagrant/code/admin/web/admin/template/service/order_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4974593865df22bd5302d82_77904977%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e9f86d5efabbfe91f8c23b3ca7650f28268c589' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/service/order_list.tpl',
      1 => 1571045931,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4974593865df22bd5302d82_77904977',
  'variables' => 
  array (
    'data' => 0,
    '_pay_channel_types' => 0,
    'id' => 0,
    'name' => 0,
    '_pay_types' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5df22bd53a6924_69979190',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5df22bd53a6924_69979190')) {
function content_5df22bd53a6924_69979190 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '4974593865df22bd5302d82_77904977';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

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
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> ios </option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> 安卓 </option>
                </select>

                <label>支付渠道</label>
                <select class="form-control" name="pay_channel" style="width: 50px;">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_pay_channel_types']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['pay_channel'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>支付方式</label>
                <select class="form-control" name="pay_type" style="width: 50px;">
                    <option value="0">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_pay_types']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['pay_type'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>支付状态</label>
                <select class="form-control" name="is_pay" style="width: 50px;">
                    <option value="0">全 部</option>
                    <?php
$_from = @constant('PAY_STATUS');
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['is_pay'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['id'] = $foreach_id_Sav;
}
?>
                </select>

                <label>到账状态</label>
                <select class="form-control" name="is_notify" style="width: 50px;">
                    <option value="0">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['is_notify'] == 1) {?>selected="selected"<?php }?>>未发放</option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['is_notify'] == 2) {?>selected="selected"<?php }?>>已发放</option>
                </select>
            </div>

            <div class="form-group form-group-sm" style="margin-top: 5px;">
                <label>订单时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/>

                <label>订单号</label>
                <input type="text" class="form-control" name="pt_order_num" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
" style="width: 150px;"/>

                <label>用户账号</label>
                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['username'], ENT_QUOTES, 'UTF-8');?>
" style="width: 120px;"/>

                <label>角色名称</label>
                <input type="text" class="form-control" name="role_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
" style="width: 120px;"/>

                <label>充值区间</label>
                <input type="text" class="form-control" name="level1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['level1'], ENT_QUOTES, 'UTF-8');?>
" style="width:40px;"/> -
                <input type="text" class="form-control" name="level2" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['level2'], ENT_QUOTES, 'UTF-8');?>
" style="width:40px;"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <?php if ($_smarty_tpl->tpl_vars['data']->value['username']) {?>
            <div class="bg-warning" style="font-weight: bold;">
                <span>
                    玩家：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['username'], ENT_QUOTES, 'UTF-8');?>
，
                    充值次数：<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['data']->value['total']['c'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
，
                    总充值金额：<span class="text-red"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['data']->value['total']['total_fee'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</span>
                </span>
            </div>
            <?php }?>
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
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                        <tr>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="show-userinfo" data-keyword="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
" data-full="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['username'], ENT_QUOTES, 'UTF-8');?>
">
                                <?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['u']->value['username'],15), ENT_QUOTES, 'UTF-8');?>

                            </td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total_fee']/100, ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['_pay_types']->value[$_smarty_tpl->tpl_vars['u']->value['pay_type']]) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_pay_types']->value[$_smarty_tpl->tpl_vars['u']->value['pay_type']], ENT_QUOTES, 'UTF-8');?>

                                <?php } else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_pay_channel_types']->value[$_smarty_tpl->tpl_vars['u']->value['union_channel']], ENT_QUOTES, 'UTF-8');
}?>
                            </td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 1) {?><span class="icon_ios"></span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 2) {?><span class="icon_android"></span>
                                <?php } else { ?>-<?php }?>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['parent_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['server_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_level'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['create_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['pay_time']) {
echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['pay_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                <?php } else { ?>-<?php }?>
                            </td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['is_pay'] == 2) {?>
                                <span class="label label-primary">已支付</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['is_pay'] == 3) {?>
                                <span class="label label-warning">已支付（沙盒）</span>
                                <?php } else { ?>
                                <span class="label label-default">未支付</span>
                                <?php }?>
                            </td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['is_pay'] > 1 && $_smarty_tpl->tpl_vars['u']->value['is_notify'] == 0 && SrvAuth::checkPublicAuth('audit',false)) {?>
                                <span class="send btn btn-success btn-xs" data-order="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
">手动发放</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['is_notify'] == 1) {?>
                                <span class="label label-primary">已发放</span>
                                <?php } else { ?> - <?php }?>
                            </td>
                            <td>
                                <span data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
" class="<?php if ($_smarty_tpl->tpl_vars['u']->value['is_pay'] == 1) {?>order_check<?php } else { ?>disabled<?php }?> btn btn-success btn-xs"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 检查</span>
                                <!--<span data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
" class="order_log btn btn-info btn-xs"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 日志</span>-->
                            </td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                    </tbody>
                </table>
            </div>
            <div>
                <nav>
                    <ul class="pagination">
                        <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>