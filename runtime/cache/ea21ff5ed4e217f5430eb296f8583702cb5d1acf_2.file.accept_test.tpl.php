<?php /* Smarty version 3.1.27, created on 2019-11-29 20:15:58
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/accept_test.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:20858227365de10bfea577c8_23127132%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea21ff5ed4e217f5430eb296f8583702cb5d1acf' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/accept_test.tpl',
      1 => 1571040491,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20858227365de10bfea577c8_23127132',
  'variables' => 
  array (
    'keyword' => 0,
    'data' => 0,
    '_games' => 0,
    '_channels' => 0,
    '_monitor' => 0,
    '_union' => 0,
    'item' => 0,
    '_payType' => 0,
    '_logType' => 0,
    '_logAlias' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10bfeb0b4d2_03683836',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10bfeb0b4d2_03683836')) {
function content_5de10bfeb0b4d2_03683836 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '20858227365de10bfea577c8_23127132';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
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
                            <input type="text" class="form-control input-sm" name="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['keyword']->value, ENT_QUOTES, 'UTF-8');?>
" placeholder="账号/设备号" style="width: 300px;"/>
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
                        <?php if ($_smarty_tpl->tpl_vars['data']->value['active']) {?>
                            <tr>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['device_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['uuid'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['active_city'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['active_ip'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['active']['active_time']) {?>
                                    <?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['active']['active_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>-<?php }?>
                                </td>
                                <td>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['data']->value['active']['game_id']]['pid'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['data']->value['active']['game_id']]['pid']]['text'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['game_id'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['data']->value['active']['game_id']]['text'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td align="center">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['active']['device_type'] == 1) {?><i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>
                                    <?php } else { ?><i class="fa fa-android fa-lg text-success" aria-hidden="true"></i><?php }?>
                                </td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['sdk_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['device_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['active']['device_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['data']->value['active']['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_monitor']->value[$_smarty_tpl->tpl_vars['data']->value['active']['monitor_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            </tr>
                            <?php }?>
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
                        <?php if ($_smarty_tpl->tpl_vars['data']->value['reg']) {?>
                            <tr>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['uid'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['username'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['data']->value['reg']['type']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_union']->value[$_smarty_tpl->tpl_vars['data']->value['reg']['type']], ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['reg_city'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['reg_ip'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['reg']['reg_time']) {?>
                                    <?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['reg']['reg_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>-<?php }?>
                                </td>
                                <td>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['data']->value['reg']['game_id']]['pid'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['data']->value['reg']['game_id']]['pid']]['text'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['game_id'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['data']->value['reg']['game_id']]['text'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td align="center">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['reg']['device_type'] == 1) {?><i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>
                                    <?php } else { ?><i class="fa fa-android fa-lg text-success" aria-hidden="true"></i><?php }?>
                                </td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['sdk_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['device_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['device_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['device_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg']['uuid'], ENT_QUOTES, 'UTF-8');?>
</td>
                            </tr>
                            <?php }?>
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
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['pay'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                            <tr>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['uid'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['username'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['total_fee']/100, ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['pay_type'] > 0) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_payType']->value[$_smarty_tpl->tpl_vars['item']->value['pay_type']], ENT_QUOTES, 'UTF-8');?>

                                    <?php } else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_union']->value[$_smarty_tpl->tpl_vars['item']->value['union_channel']], ENT_QUOTES, 'UTF-8');?>
 <?php }?>
                                </td>
                                <td align="center">
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['is_pay'] == 2) {?><i class="fa fa-check text-success" aria-hidden="true"></i>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['is_pay'] == 3) {?><i class="fa fa-bug text-danger"></i>
                                    <?php } else { ?><i class="fa fa-times text-danger" aria-hidden="true"></i><?php }?>
                                </td>
                                <td align="center">
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['is_notify'] == 1) {?><i class="fa fa-check text-success" aria-hidden="true"></i>
                                    <?php } else { ?><i class="fa fa-times text-danger" aria-hidden="true"></i><?php }?>
                                </td>
                                <td align="center">
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['device_type'] == 1) {?><i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>
                                    <?php } else { ?><i class="fa fa-android fa-lg text-success" aria-hidden="true"></i><?php }?>
                                </td>
                                <td>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['item']->value['game_id']]['pid'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['item']->value['game_id']]['pid']]['text'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['item']->value['game_id']]['text'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg_game_id'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['item']->value['reg_game_id']]['text'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['server_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['role_level'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['create_time']) {?>
                                    <?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['create_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>-<?php }?>
                                </td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['pay_time']) {?>
                                    <?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['pay_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>-<?php }?>
                                </td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['notify_time']) {?>
                                    <?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['notify_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>-<?php }?>
                                </td>
                                <td>
                                    <span class="btn btn-info btn-xs orderLog" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pt_order_num'], ENT_QUOTES, 'UTF-8');?>
"><i class="fa fa-calendar-minus-o fa-fw"></i>日志</span>
                                </td>
                            </tr>
                            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
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
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['log'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                            <tr>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['uid'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_logType']->value[$_smarty_tpl->tpl_vars['item']->value['type']], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['time']) {?>
                                    <?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>-<?php }?>
                                </td>
                                <td style="word-break:break-all;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['content'], ENT_QUOTES, 'UTF-8');?>
</td>
                            </tr>
                            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
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
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['upload'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                            <tr>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_monitor']->value[$_smarty_tpl->tpl_vars['item']->value['monitor_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['source'], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_logAlias']->value[$_smarty_tpl->tpl_vars['item']->value['upload_type']], ENT_QUOTES, 'UTF-8');?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['upload_time']) {?>
                                    <?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['upload_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>-<?php }?>
                                </td>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['result'], ENT_QUOTES, 'UTF-8');?>
</td>
                            </tr>
                            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                        </tbody>
                    </table>
                </div>
            </li>

        </ul>
    </div>
</div>
<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>