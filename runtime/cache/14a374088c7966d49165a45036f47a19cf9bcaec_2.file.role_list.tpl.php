<?php /* Smarty version 3.1.27, created on 2019-12-12 20:00:22
         compiled from "/home/vagrant/code/admin/web/admin/template/service/role_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:15518060145df22bd6ba2e34_09776271%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14a374088c7966d49165a45036f47a19cf9bcaec' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/service/role_list.tpl',
      1 => 1571046010,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15518060145df22bd6ba2e34_09776271',
  'variables' => 
  array (
    'data' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5df22bd6c111c4_99067573',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5df22bd6c111c4_99067573')) {
function content_5df22bd6c111c4_99067573 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '15518060145df22bd6ba2e34_09776271';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="service"/>
            <input type="hidden" name="ac" value="roleList"/>

            <div class="form-group form-group-sm">
                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> ios </option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> 安卓 </option>
                </select>

                <label>角色名称</label>
                <input type="text" class="form-control" name="role_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
" style="width: 120px;"/>

                <label>用户账号</label>
                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['username'], ENT_QUOTES, 'UTF-8');?>
" style="width: 120px;"/>

                <label>注册时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/>

                <label class="checkbox-inline">
                    <input type="checkbox" name="has_pay" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['has_pay'] == 1) {?>checked="checked"<?php }?> />
                    只显示充值过的角色
                </label>

                <label class="checkbox-inline">
                    <input type="checkbox" name="has_phone" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['has_phone'] == 1) {?>checked="checked"<?php }?> />
                    只显示绑定手机的玩家
                </label>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>UID</th>
                        <th nowrap>账号</th>
                        <?php if ($_smarty_tpl->tpl_vars['data']->value['has_phone'] == 1) {?>
                        <th nowrap>手机号</th>
                        <?php }?>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏</th>
                        <th nowrap>区服</th>
                        <th nowrap>角色</th>
                        <th nowrap>创建时间</th>
                        <th nowrap>当前等级</th>
                        <th nowrap>所属平台</th>
                        <th nowrap>注册地区</th>
                        <th nowrap>注册IP</th>
                        <th nowrap>注册时间</th>
                        
                        
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
                        <?php if (!$_smarty_tpl->tpl_vars['u']->value['uid']) {
continue 1;
}?>
                        <tr>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="show-userinfo" data-keyword="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['u']->value['username'],15), ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['has_phone'] == 1) {?>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['phone']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['phone'], ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <?php }?>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['parent_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['server_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['create_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_level'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 1) {?><span class="icon_ios"></span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 2) {?><span class="icon_android"></span>
                                <?php } else { ?>-<?php }?>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_city'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_ip'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['reg_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
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
        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }

            $.getJSON('?ct=platform&ac=getGameServers&game_id=' + game_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html);
            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>