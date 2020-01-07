<?php /* Smarty version 3.1.27, created on 2019-12-02 21:03:57
         compiled from "/home/vagrant/code/admin/web/admin/template/material/editMaterial.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:8719191515de50bbdc1faf7_42674177%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd001c919684167441532a9dc5e7e84fa1c285333' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/material/editMaterial.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8719191515de50bbdc1faf7_42674177',
  'variables' => 
  array (
    'material_id' => 0,
    'data' => 0,
    '_channels' => 0,
    'id' => 0,
    'name' => 0,
    '_games' => 0,
    '_types' => 0,
    '_admins' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de50bbdc6b8b7_31877380',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de50bbdc6b8b7_31877380')) {
function content_5de50bbdc6b8b7_31877380 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8719191515de50bbdc1faf7_42674177';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="material_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['material_id']->value, ENT_QUOTES, 'UTF-8');?>
">

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>素材库</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="material_name" class="col-sm-2 control-label">素材名称</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="material_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['material_name'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_id" class="col-sm-2 control-label">所属渠道</label>
                    <div class="col-sm-3">
                        <select name="channel_id" class="form-control" style="width: 100px;">
                            <option value="0">请选择渠道</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">所属游戏</label>
                    <div class="col-sm-3">
                        <select name="game_id" class="form-control" style="width: 100px;">
                            <option value="0">请选择游戏</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_games']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['game_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_type" class="col-sm-2 control-label">素材类型</label>
                    <div class="col-sm-3">
                        <select name="material_type" class="form-control" style="width: 100px;">
                            <option value="">请选择类型</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_types']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_type'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_source" class="col-sm-2 control-label">需求来源</label>
                    <div class="col-sm-3">
                        <select name="material_source" class="form-control" style="width: 100px;">
                            <option value="" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_source'] == '') {?>selected="selected"<?php }?>>原创构思</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_admins']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_source'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_tag" class="col-sm-2 control-label">素材标签</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="material_tag" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['material_tag'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        $('#submit').on('click', function () {
            var index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=material&ac=editMaterial', $('form').serializeArray(), function (re) {
                layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=material&ac=materialBox';
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>