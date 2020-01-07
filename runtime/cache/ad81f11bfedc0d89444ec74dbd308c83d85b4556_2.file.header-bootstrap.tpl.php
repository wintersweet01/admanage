<?php /* Smarty version 3.1.27, created on 2019-11-29 13:57:05
         compiled from "/home/vagrant/code/admin/web/admin/template/public/header-bootstrap.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:14043752215de0b331589922_75501843%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad81f11bfedc0d89444ec74dbd308c83d85b4556' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/public/header-bootstrap.tpl',
      1 => 1573195686,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14043752215de0b331589922_75501843',
  'variables' => 
  array (
    '__title__' => 0,
    '_cdn_static_url_' => 0,
    '__domain__' => 0,
    '__html5plus__' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0b3315967c1_71698131',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0b3315967c1_71698131')) {
function content_5de0b3315967c1_71698131 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '14043752215de0b331589922_75501843';
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
lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/font-awesome/css/font-awesome.min.css">
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
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layer/layer.js"><?php echo '</script'; ?>
>
</head>
<body><?php }
}
?>