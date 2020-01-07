<?php /* Smarty version 3.1.27, created on 2019-11-28 15:10:57
         compiled from "/home/vagrant/code/admin/web/admin/template/index/login.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5372539515ddf730126ff57_28493723%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '450282f64b5c6d69d912ec4986e4448a63373fab' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/index/login.tpl',
      1 => 1549974258,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5372539515ddf730126ff57_28493723',
  'variables' => 
  array (
    'title' => 0,
    'isNeedCaptcha' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf73012f5114_40239045',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf73012f5114_40239045')) {
function content_5ddf73012f5114_40239045 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5372539515ddf730126ff57_28493723';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Expires" content="0"> 
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
<title><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8');?>
</title>
<link href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/css/login.css?v=20180712" type="text/css" rel="stylesheet">
</head>
<body>
<div class="htmleaf-container">
	<div class="wrapper">
		<div class="container">
			<h1>SDK联运后台</h1>
			<form class="form" method="post">
				<input name="username" placeholder="用户名" required type="text">
				<input name="password" placeholder="密码" required type="password">
				<div class="code"<?php if ($_smarty_tpl->tpl_vars['isNeedCaptcha']->value) {?> style="display: block;"<?php }?>>
					<input name="code" placeholder="验证码" type="text"<?php if ($_smarty_tpl->tpl_vars['isNeedCaptcha']->value) {?> required<?php }?>>
					<span><img src="?ct=captcha" id="js-mVcodeImg"/></span>
				</div>
				<div class="keep">
					<input type="checkbox" placeholder="保持登录" name="keep" value="1" /> <label for="keep">保持登录15天</label>
				</div>
				<button type="submit">登录</button>
			</form>
		</div>
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/jquery/jquery-3.3.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/login.js?v=20180712"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
?>