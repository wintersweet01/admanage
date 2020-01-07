<?php /* Smarty version 3.1.27, created on 2020-01-06 16:27:03
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/orderReplacementList.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13336655555e12ef57a16503_22139323%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f75be36a056c7b414e0228d299b195ecc24383d' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/orderReplacementList.tpl',
      1 => 1570802469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13336655555e12ef57a16503_22139323',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'name' => 0,
    '_pay_types' => 0,
    'id' => 0,
    'u' => 0,
    '_pay_channel_types' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e12ef57a989c6_84590953',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e12ef57a989c6_84590953')) {
function content_5e12ef57a989c6_84590953 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '13336655555e12ef57a16503_22139323';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="orderReplacementList"/>

            <div class="form-group form-group-sm">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select class="form-control" name="device_type" style="width: 50px;">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> ios </option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> 安卓 </option>
                </select>

                <label>游戏包</label>
                <select class="form-control" name="package_name" id="package_id" style="width: 150px;">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_packages'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['package_name'] == $_smarty_tpl->tpl_vars['name']->value['package_name']) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>选择支付方式</label>
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

                <label>订单号</label>
                <input type="text" class="form-control" name="pt_order_num" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
" style="width: 120px;"/>

                <label>用户账号</label>
                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['username'], ENT_QUOTES, 'UTF-8');?>
" style="width: 100px;"/>

                <label>角色名称</label>
                <input type="text" class="form-control" name="role_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
" style="width: 80px;"/>

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
"><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['u']->value['username'],15), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total_fee']/100, ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['_pay_types']->value[$_smarty_tpl->tpl_vars['u']->value['pay_type']]) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_pay_types']->value[$_smarty_tpl->tpl_vars['u']->value['pay_type']], ENT_QUOTES, 'UTF-8');?>

                                <?php } else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_pay_channel_types']->value[$_smarty_tpl->tpl_vars['u']->value['union_channel']], ENT_QUOTES, 'UTF-8');?>

                                <?php }?>
                            </td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 1) {?><span class="icon_ios"></span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 2) {?><span class="icon_android"></span>
                                <?php } else { ?>-<?php }?>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
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
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['pay_time']) {
echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['pay_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?>
                            </td>
                            <td nowrap class="pay">
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['is_pay'] == 2) {?>
                                <span class="label label-primary">已支付</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['is_pay'] == 3) {?>
                                <span class="label label-warning">已支付（沙盒）</span>
                                <?php } else { ?>
                                <span class="label label-default">未支付</span>
                                <?php }?>
                            </td>
                            <td nowrap class="notify">
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['is_notify'] == 1) {?>
                                <span class="label label-primary">已发放</span>
                                <?php } else { ?>
                                <span class="label label-default">未发放</span>
                                <?php }?>
                            </td>
                            <td>
                                <span data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
" data-options='<?php echo json_encode($_smarty_tpl->tpl_vars['u']->value);?>
' class="<?php if ($_smarty_tpl->tpl_vars['u']->value['is_pay'] == 1) {?>order_direct<?php } else { ?>disabled<?php }?> btn btn-danger btn-xs"><span class="glyphicon glyphicon-yen" aria-hidden="true"></span> 直充</span>
                                <span data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
" class="<?php if ($_smarty_tpl->tpl_vars['u']->value['is_pay'] != 1 && $_smarty_tpl->tpl_vars['u']->value['is_notify'] != 1) {?>order_reissue<?php } else { ?>disabled<?php }?> btn btn-success btn-xs"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> 补单</span>
                                <span data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
" class="order_log btn btn-info btn-xs"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 日志</span>
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
            var games = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['_games']->value);?>
');
            var pay_types = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['_pay_types']->value);?>
');
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>