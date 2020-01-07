<?php /* Smarty version 3.1.27, created on 2019-11-28 16:41:49
         compiled from "/home/vagrant/code/admin/web/admin/template/index/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6060180925ddf884ded6be4_45619492%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01abd8486a4e3f6476ee40daeaf0e6e5db8ff1ba' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/index/index.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6060180925ddf884ded6be4_45619492',
  'variables' => 
  array (
    'message' => 0,
    'client_ip' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf884df05238_73692185',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf884df05238_73692185')) {
function content_5ddf884df05238_73692185 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6060180925ddf884ded6be4_45619492';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="container-fluid">
    <div class="row">
        <h3><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['message']->value, ENT_QUOTES, 'UTF-8');?>
</h3>
        <p>客户端IP：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client_ip']->value, ENT_QUOTES, 'UTF-8');?>
</p>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>