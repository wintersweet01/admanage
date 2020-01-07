<?php /* Smarty version 3.1.27, created on 2019-11-28 16:33:54
         compiled from "/home/vagrant/code/admin/web/admin/template/public/header.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:15412653505ddf8672032b01_45938029%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1b73a4a6ecd4f762ded9aca367a717499f9b4ec' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/public/header.tpl',
      1 => 1570801459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15412653505ddf8672032b01_45938029',
  'variables' => 
  array (
    '__title__' => 0,
    '__watermark_url__' => 0,
    '__html5plus__' => 0,
    '__first_menu_conf__' => 0,
    'key' => 0,
    '__first_menu__' => 0,
    'menu' => 0,
    '__name__' => 0,
    '__menu__' => 0,
    'name' => 0,
    '__on_menu__' => 0,
    'ac' => 0,
    '__on_sub_menu__' => 0,
    'n' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf86720578c0_18635417',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf86720578c0_18635417')) {
function content_5ddf86720578c0_18635417 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '15412653505ddf8672032b01_45938029';
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['__title__']->value, ENT_QUOTES, 'UTF-8');?>
</title>
    <?php echo $_smarty_tpl->getSubTemplate ("../public/head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    <style>
        fieldset{margin:0 2px;padding:.35em .625em .75em;border:1px solid silver}
        legend{padding:.5em;width:auto;border:0}
        #content-main table, #container {background: url("<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['__watermark_url__']->value, ENT_QUOTES, 'UTF-8');?>
") !important;}
    </style>
</head>
<body class="hold-transition skin-blue-light sidebar-mini <?php if ($_COOKIE['js_collapse']) {?>sidebar-collapse<?php }?>"
      style="overflow:hidden;">
<div class="wrapper">
    <?php if (!$_smarty_tpl->tpl_vars['__html5plus__']->value) {?>
    <!--头部信息-->
    <header class="main-header">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand logo" href="?ct=base"><span class="logo-lg"><strong>数据后台</strong></span></a>
                </div>
                <!--<div class="sidebar-toggle"><span class="sr-only">切换</span></div>-->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php
$_from = $_smarty_tpl->tpl_vars['__first_menu_conf__']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['menu']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
$foreach_menu_Sav = $_smarty_tpl->tpl_vars['menu'];
?>
                        <?php if (in_array($_smarty_tpl->tpl_vars['key']->value,$_smarty_tpl->tpl_vars['__first_menu__']->value) || in_array('*',$_smarty_tpl->tpl_vars['__first_menu__']->value)) {?>
                        <li><a href="javascript:;" class="first_menu" data-menu="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value, ENT_QUOTES, 'UTF-8');?>
</a></li>
                        <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['menu'] = $foreach_menu_Sav;
}
?>
                    </ul>

                    <div class="form-inline navbar-form navbar-left">
                        <?php if (SrvAuth::checkPublicAuth('userInfo',false)) {?>
                        <div class="input-group" style="min-width: 300px;">
                            <input type="text" id="nav-keyword" class="form-control" placeholder="UID/账号/手机号/设备号/角色名">
                            <span class="input-group-btn"><button type="button" id="nav-search" class="btn btn-default">搜索</button></span>
                        </div>
                        <?php }?>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['__name__']->value, ENT_QUOTES, 'UTF-8');?>
 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li id="modify-userinfo"><a href="#"><span class="glyphicon glyphicon-edit"
                                                                           aria-hidden="true"></span>修改密码</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="?ct=index&ac=logout" style="color: red;"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>
<!--左边导航-->
    <div class="main-sidebar" style="height: 100%">
        <div class="sidebar" style="height: 100%;background: #ffffff;">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/img/logo.png" class="img-circle" alt="User Image">
                </div>
            </div>
            <ul class="sidebar-menu" id="sidebar-menu">
                <?php
$_from = $_smarty_tpl->tpl_vars['__menu__']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['menu']->_loop = false;
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value => $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
$foreach_menu_Sav = $_smarty_tpl->tpl_vars['menu'];
?>
                <li class="treeview <?php if ($_smarty_tpl->tpl_vars['name']->value == $_smarty_tpl->tpl_vars['__on_menu__']->value) {?>active<?php }?>" style="display: none"
                    data-menu="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['first_menu'], ENT_QUOTES, 'UTF-8');?>
"><a href="#"><i class="fa fa-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['icon'], ENT_QUOTES, 'UTF-8');?>
"></i><span
                                style="font-size:13px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['name'], ENT_QUOTES, 'UTF-8');?>
</span><i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu"
                    <?php if ($_smarty_tpl->tpl_vars['name']->value == $_smarty_tpl->tpl_vars['__on_menu__']->value) {?>style="display: block;"<?php }?>>
                    <?php
$_from = $_smarty_tpl->tpl_vars['menu']->value['menu'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['n']->_loop = false;
$_smarty_tpl->tpl_vars['ac'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['ac']->value => $_smarty_tpl->tpl_vars['n']->value) {
$_smarty_tpl->tpl_vars['n']->_loop = true;
$foreach_n_Sav = $_smarty_tpl->tpl_vars['n'];
?>
                <li>
                    <a class="menuItem" <?php if ($_smarty_tpl->tpl_vars['ac']->value == $_smarty_tpl->tpl_vars['__on_sub_menu__']->value) {?>style="font-weight: bolder;color: #447ed9;"<?php }?>
                    href="?ct=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
&ac=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ac']->value, ENT_QUOTES, 'UTF-8');?>
" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['n']->value, ENT_QUOTES, 'UTF-8');?>
"><i class="fa fa-tags"></i><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['n']->value, ENT_QUOTES, 'UTF-8');?>
</a>
                </li>
                <?php
$_smarty_tpl->tpl_vars['n'] = $foreach_n_Sav;
}
?>
            </ul>
            </li>
            <?php
$_smarty_tpl->tpl_vars['menu'] = $foreach_menu_Sav;
}
?>
            </ul>
        </div>
    </div>
    <?php }?>
    <!--中间内容-->
    <div id="content-wrapper" class="content-wrapper <?php if ($_smarty_tpl->tpl_vars['__html5plus__']->value) {?>html5plus<?php }?>" style="overflow: auto;">
        <div class="content-iframe">
            <div class="mainContent" id="content-main" style="margin: 10px; padding: 0;"><?php }
}
?>