<?php /* Smarty version 3.1.27, created on 2020-01-03 14:53:44
         compiled from "/home/vagrant/code/admin/web/admin/template/public/head.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:18436339365e0ee4f8ab57f8_80220425%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97c5aa1e61b1eb6bf48ce771a63f6b3d50b1fcb4' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/public/head.tpl',
      1 => 1578034323,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18436339365e0ee4f8ab57f8_80220425',
  'variables' => 
  array (
    '_cdn_static_url_' => 0,
    '__domain__' => 0,
    '__html5plus__' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e0ee4f8acc308_35400271',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e0ee4f8acc308_35400271')) {
function content_5e0ee4f8acc308_35400271 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '18436339365e0ee4f8ab57f8_80220425';
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/css/skins/_all-skins.css">
<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
css/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/css/index.min.css?v=2019111922">
<?php echo '<script'; ?>
>
    <?php if ($_smarty_tpl->tpl_vars['__domain__']->value) {?>
    document.domain = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['__domain__']->value, ENT_QUOTES, 'UTF-8');?>
';
    <?php }?>
    var html5plus = parseInt('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['__html5plus__']->value, ENT_QUOTES, 'UTF-8');?>
');
    var is_mobile = false;
    if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
        is_mobile = true;
    }
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
js/jquery-3.3.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/charts/Chart.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layer/layer.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/date/WdatePicker.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/select2/js/select2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/clipboard.min.js?v=2019021820"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/index.min.js?v=2019101118"><?php echo '</script'; ?>
><?php }
}
?>