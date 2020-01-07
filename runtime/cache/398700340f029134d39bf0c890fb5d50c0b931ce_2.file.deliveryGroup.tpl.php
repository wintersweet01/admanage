<?php /* Smarty version 3.1.27, created on 2019-11-29 10:04:29
         compiled from "/home/vagrant/code/admin/web/admin/template/ad/deliveryGroup.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5595100265de07cad530773_29205264%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '398700340f029134d39bf0c890fb5d50c0b931ce' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/ad/deliveryGroup.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5595100265de07cad530773_29205264',
  'variables' => 
  array (
    'data' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de07cad5725c3_44674234',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de07cad5725c3_44674234')) {
function content_5de07cad5725c3_44674234 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5595100265de07cad530773_29205264';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <?php if (SrvAuth::checkPublicAuth('add',false)) {?><a href="?ct=ad&ac=addDeliveryGroup" class="btn btn-primary btn-small" role="button"> + 添加投放组 </a><?php }?>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>投放组ID</td>
                        <td>投放组名称</td>
                        <td>操作</td>
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
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['group_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['group_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=ad&ac=addDeliveryGroup&group_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['group_id'], ENT_QUOTES, 'UTF-8');?>
">编辑</a><?php }?>
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

<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>