<?php /* Smarty version 3.1.27, created on 2019-11-28 16:35:34
         compiled from "/home/vagrant/code/admin/web/admin/template/admin/roleAdd.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:14269111545ddf86d6c8aff3_72439563%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '486a80c1bba6094f32706da172a966137d1a1d07' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/admin/roleAdd.tpl',
      1 => 1555395412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14269111545ddf86d6c8aff3_72439563',
  'variables' => 
  array (
    'data' => 0,
    'k' => 0,
    'n' => 0,
    'name' => 0,
    'menu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf86d6cca2d3_34741218',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf86d6cca2d3_34741218')) {
function content_5ddf86d6cca2d3_34741218 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '14269111545ddf86d6c8aff3_72439563';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style type="text/css">
    .highlight{
        float: left;
        width: 100%;
    }
    label.checkbox-inline{
        float: left;
        width: 200px;
        margin: 0px !important;
        display: inline;
    }
    h5{
        clear: both;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="role_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['role_id'], ENT_QUOTES, 'UTF-8');?>
" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加角色</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="role_name" class="col-sm-2 control-label">* 角色名称</label>
                    <div class="col-sm-6 input-group">
                        <input type="text" class="form-control" name="role_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['role_name'], ENT_QUOTES, 'UTF-8');?>
" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_fun" class="col-sm-2 control-label">公共权限</label>
                    <div class="col-sm-6 input-group">
                        <figure class="highlight">
                            <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_public_auth'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['n']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['n']->value) {
$_smarty_tpl->tpl_vars['n']->_loop = true;
$foreach_n_Sav = $_smarty_tpl->tpl_vars['n'];
?>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="role_fun[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['k']->value,explode('|',$_smarty_tpl->tpl_vars['data']->value['info']['role_fun']))) {?> checked="checked" <?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['n']->value, ENT_QUOTES, 'UTF-8');?>

                            </label>
                            <?php
$_smarty_tpl->tpl_vars['n'] = $foreach_n_Sav;
}
?>
                        </figure>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_menu" class="col-sm-2 control-label">* 模块权限</label>
                    <div class="col-sm-6 input-group">
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_menu'];
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
                        <h5><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</h5>
                        <figure class="highlight">
                        <?php
$_from = $_smarty_tpl->tpl_vars['menu']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['n']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['n']->value) {
$_smarty_tpl->tpl_vars['n']->_loop = true;
$foreach_n_Sav = $_smarty_tpl->tpl_vars['n'];
?>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="role_menu[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['k']->value,explode('|',$_smarty_tpl->tpl_vars['data']->value['info']['role_menu']))) {?> checked="checked" <?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['n']->value, ENT_QUOTES, 'UTF-8');?>

                            </label>
                        <?php
$_smarty_tpl->tpl_vars['n'] = $foreach_n_Sav;
}
?>
                        </figure>
                        <?php
$_smarty_tpl->tpl_vars['menu'] = $foreach_menu_Sav;
}
?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4 input-group">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function(){
        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=admin&ac=roleAddAction',{data:data},function(re){
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:3000,
                    end:function(){
                        if(re.state == true){
                            location.href = '?ct=admin&ac=roleList';
                        }
                    }
                });
            },'json');
        });

        $('#cancel').on('click',function(){
            history.go(-1);
        });

    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>