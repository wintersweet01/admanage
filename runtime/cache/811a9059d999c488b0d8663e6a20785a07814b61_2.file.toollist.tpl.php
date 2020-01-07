<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:51
         compiled from "/home/vagrant/code/admin/web/admin/template/tool/toollist.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:8881876265ddf91eb1ce019_33316693%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '811a9059d999c488b0d8663e6a20785a07814b61' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/tool/toollist.tpl',
      1 => 1570801460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8881876265ddf91eb1ce019_33316693',
  'variables' => 
  array (
    'medias' => 0,
    'k' => 0,
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91eb204767_84342176',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91eb204767_84342176')) {
function content_5ddf91eb204767_84342176 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8881876265ddf91eb1ce019_33316693';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
<style type="text/css">
    .table-header .navbar {
        margin-bottom: 0px;
    }

    .table-header .navbar-collapse {
        position: unset !important;
        background-color: unset !important;
        z-index: unset !important;
    }

    .table-header .form-group {
        margin-bottom: 15px;
    }

    .select2-container .select2-selection--multiple {
        min-height: 22px !important;
        margin-bottom: 5px;
    }

    .active-menu {
        border-bottom: 2px solid green;
        color:green;
    }
</style>
<div id="areascontent">
    <div class="rows table-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-table-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="/?ct=auxTool&ac=toolList" class="tool_menu active-menu">素材库</a></li>
                        <li><a href="/?ct=auxTool&ac=toolAim" class="tool_menu">定向库</a></li>
                        <li><a href="/?ct=auxTool&ac=toolText" class="tool_menu">文案库</a></li>
                    </ul>
                    <form id="media_form" class="form-group">
                        <div style="position: relative;float: right;top: 15px;">
                            <label class=''>选择媒体：</label>
                            <select name="media_cnf">
                                <?php
$_from = $_smarty_tpl->tpl_vars['medias']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['info'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['info']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['info']->value) {
$_smarty_tpl->tpl_vars['info']->_loop = true;
$foreach_info_Sav = $_smarty_tpl->tpl_vars['info'];
?>
                                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['info']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                                <?php
$_smarty_tpl->tpl_vars['info'] = $foreach_info_Sav;
}
?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows table-content">
        <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1">
            <form class="form-inline navbar-form navbar-left" method="get" action="">
                <div class="form-group">
                    <label>素材类型：</label>
                    <select>
                        <option value="">请选择</option>
                    </select>

                    <label>时间：</label>
                    <input type="text" name="sdate" value="" class="Wdate"/> -
                    <input type="text" name="edate" value="" class="Wdate"/>

                    <label>素材名称关键词：</label>
                    <input type="text" placeholder="关键词" autocomplete="off" value="">

                    <label><input type="radio" name="view" value="1">素材视图</label>
                    <label><input type="radio" name="view" value="2">文件夹视图</label>

                    <button type="button" class="btn btn-primary btn-xs" id="submit">筛 选</button>
                    <button type="button" class="btn btn-success btn-xs" id="add">添加素材</button>
                </div>
            </form>
        </div>
        <div>
            <!--素材显示列表-->
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
        $("#add").on('click',function(){
            var media = $("select[name=media_cnf]").val();
            if(media){
                window.location.href = '/?ct=auxtool&ac=hvideoTool&media='+media;
            }
        })
    })
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>