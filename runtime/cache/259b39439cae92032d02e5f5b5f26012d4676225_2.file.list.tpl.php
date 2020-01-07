<?php /* Smarty version 3.1.27, created on 2019-11-28 17:21:27
         compiled from "/home/vagrant/code/admin/web/admin/template/admin/list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:17209855865ddf9197332b56_76202601%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '259b39439cae92032d02e5f5b5f26012d4676225' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/admin/list.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17209855865ddf9197332b56_76202601',
  'variables' => 
  array (
    'data' => 0,
    'u' => 0,
    '_userid_' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf919738f3d2_56304613',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf919738f3d2_56304613')) {
function content_5ddf919738f3d2_56304613 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '17209855865ddf9197332b56_76202601';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <?php if (SrvAuth::checkPublicAuth('add',false)) {?><a href="?ct=admin&ac=addAdmin" class="btn btn-primary btn-small" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加管理员 </a><?php }?>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>账号</td>
                        <td nowrap>姓名</td>
                        <td nowrap>角色</td>
                        <td nowrap>添加时间</td>
                        <td nowrap>最后登录时间</td>
                        <td nowrap>最后登录IP</td>
                        <td nowrap>添加人</td>
                        <td nowrap>操作</td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><span class="label label-danger"><?php if ($_smarty_tpl->tpl_vars['u']->value['admin_id'] == 1) {?>超级管理员<?php } else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_name'], ENT_QUOTES, 'UTF-8');
}?></span></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['ct']) {
echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['ct'],"%Y-%m-%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['last_lt']) {
echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['last_lt'],"%Y-%m-%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['last_ip'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['creator'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['admin_id'] != $_smarty_tpl->tpl_vars['_userid_']->value) {?>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=admin&ac=addAdmin&admin_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['admin_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><?php }?>
                                <?php if (SrvAuth::checkPublicAuth('del',false)) {?><span class="delete btn btn-danger btn-xs" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['admin_id'], ENT_QUOTES, 'UTF-8');?>
">删除</span><?php }?>
                                <?php }?>
                            </td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                    </tbody>
                </table>
            </div>
            <div style="float: right;">
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
        $('.delete').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('确定删除吗?', {
                btn: ['是的', '取消']
            }, function () {
                $.getJSON('?ct=admin&ac=deleteAdmin&id=' + id, function (re) {
                    layer.msg(re.message);
                    if (re.code == 1) {
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                });
            }, function () {

            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>