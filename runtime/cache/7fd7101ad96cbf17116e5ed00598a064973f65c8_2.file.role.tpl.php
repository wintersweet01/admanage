<?php /* Smarty version 3.1.27, created on 2019-11-29 11:24:05
         compiled from "/home/vagrant/code/admin/web/admin/template/admin/role.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:14878013045de08f55043a44_61918357%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7fd7101ad96cbf17116e5ed00598a064973f65c8' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/admin/role.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14878013045de08f55043a44_61918357',
  'variables' => 
  array (
    'data' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08f55087b48_96815031',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08f55087b48_96815031')) {
function content_5de08f55087b48_96815031 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '14878013045de08f55043a44_61918357';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <?php if (SrvAuth::checkPublicAuth('add',false)) {?><a href="?ct=admin&ac=roleAdd" class="btn btn-primary btn-small" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加角色 </a><?php }?>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>角色ID</td>
                        <td nowrap>角色名称</td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=admin&ac=roleAdd&role_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><?php }?>
                                <?php if (SrvAuth::checkPublicAuth('del',false)) {?><span class="delete btn btn-danger btn-xs" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['role_id'], ENT_QUOTES, 'UTF-8');?>
"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</span><?php }?>
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
            layer.confirm('删除后已使用该角色的管理员将无权限<br><br>确定删除吗?', {
                btn: ['是的', '取消']
            }, function () {
                $.getJSON('?ct=admin&ac=roleDelete&id=' + id, function (re) {
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