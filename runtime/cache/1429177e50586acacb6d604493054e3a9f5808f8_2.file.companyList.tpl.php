<?php /* Smarty version 3.1.27, created on 2019-11-29 10:04:03
         compiled from "/home/vagrant/code/admin/web/admin/template/ad/companyList.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2911670355de07c93790f50_26394049%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1429177e50586acacb6d604493054e3a9f5808f8' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/ad/companyList.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2911670355de07c93790f50_26394049',
  'variables' => 
  array (
    'data' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de07c937cf333_34506886',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de07c937cf333_34506886')) {
function content_5de07c937cf333_34506886 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2911670355de07c93790f50_26394049';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="form-group">
            <?php if (SrvAuth::checkPublicAuth('add',false)) {?><a href="?ct=ad&ac=addAdCompany" class="btn btn-primary btn-small" role="button"> + 添加广告资质公司 </a><?php }?>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>公司名</td>
                        <td>备案号</td>
                        
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
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['company_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['record_no'], ENT_QUOTES, 'UTF-8');?>
</td>
                            
                            <td>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=ad&ac=addAdCompany&company_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['company_id'], ENT_QUOTES, 'UTF-8');?>
">编辑</a>&nbsp;&nbsp;<?php }?>
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