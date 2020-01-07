<?php /* Smarty version 3.1.27, created on 2020-01-03 14:38:59
         compiled from "/home/vagrant/code/admin/web/admin/template/public/header-layui.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:870520965e0ee18369e226_34289689%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '277c7f1350090eaa5673a0fdfbdd0270e52f1561' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/public/header-layui.tpl',
      1 => 1573195702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '870520965e0ee18369e226_34289689',
  'variables' => 
  array (
    '__title__' => 0,
    '_cdn_static_url_' => 0,
    '__domain__' => 0,
    '__html5plus__' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e0ee1836c1f42_74581304',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e0ee1836c1f42_74581304')) {
function content_5e0ee1836c1f42_74581304 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '870520965e0ee18369e226_34289689';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['__title__']->value, ENT_QUOTES, 'UTF-8');?>
</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui-2.5/css/layui.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/css/main.css">
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
lib/layui-2.5/layui.js"><?php echo '</script'; ?>
>
</head>
<body><?php }
}
?>