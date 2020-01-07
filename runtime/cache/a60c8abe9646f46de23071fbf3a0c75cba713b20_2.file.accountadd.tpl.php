<?php /* Smarty version 3.1.27, created on 2019-11-28 18:21:19
         compiled from "/home/vagrant/code/admin/web/admin/template/system/accountadd.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:17904294575ddf9f9f097c66_55394235%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a60c8abe9646f46de23071fbf3a0c75cba713b20' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/system/accountadd.tpl',
      1 => 1568890144,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17904294575ddf9f9f097c66_55394235',
  'variables' => 
  array (
    'account_id' => 0,
    'media_conf' => 0,
    'media_id' => 0,
    'data' => 0,
    'row' => 0,
    'apps' => 0,
    'k' => 0,
    'info' => 0,
    'admins' => 0,
    'mk' => 0,
    'login_admin' => 0,
    'mrow' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf9f9f0e53f4_18861922',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf9f9f0e53f4_18861922')) {
function content_5ddf9f9f0e53f4_18861922 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '17904294575ddf9f9f097c66_55394235';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style>
    .input-show-sm-5{
        width: 40.74%;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;margin-top:50px;">
        <div style="float: left; width: 100%;">
            <form method="post" id="myForm" action="" class="form-horizontal">
                <input type="hidden" name="account_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['account_id']->value, ENT_QUOTES, 'UTF-8');?>
">
                <div class="form-group">
                    <label for="media" class="col-sm-2 control-label"><em class="text-red">*</em>媒体：</label>
                    <div class="col-sm-5">
                        <select id="media" name="media" class="col-sm-4" <?php if ($_smarty_tpl->tpl_vars['account_id']->value != '') {?>disabled="disabled"<?php }?> >
                            <option value="">请选择</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['media_conf']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['row']->_loop = false;
$_smarty_tpl->tpl_vars['media_id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['media_id']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$foreach_row_Sav = $_smarty_tpl->tpl_vars['row'];
?>
                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['media_id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['media'] == $_smarty_tpl->tpl_vars['media_id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="media_account" class="col-sm-2 control-label"><em class="text-red">*</em>媒体账号：</label>
                    <div class="col-sm-5">
                        <input type="text" class="col-sm-5 input-show-sm-5 form-control" name="account" id="media_account" autocomplete="off" <?php if ($_smarty_tpl->tpl_vars['account_id']->value != '') {?>disabled="disabled"<?php }?> value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['account'], ENT_QUOTES, 'UTF-8');?>
" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="media_account_password" class="col-sm-2 control-label"><em class="text-red">*</em>媒体账号密码：</label>
                    <div class="col-sm-5">
                        <input type="password" class="col-sm-5 input-show-sm-5 form-control" name="account_password" id="media_account_password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="media_account_nickname" class="col-sm-2 control-label">媒体账号别名：</label>
                    <div class="col-sm-5">
                        <input type="text" class="col-sm-5 input-show-sm-5 form-control" name="account_nickname" id="media_account_nickname" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['account_nickname'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>
                <div class="form-group">
                    <label for="app_pub" class="col-sm-2 control-label">投放应用：</label>
                    <div class="col-sm-5">
                        <select id="app_pub" name="app_pub[]" class="col-sm-4" multiple="multiple">
                            <?php
$_from = $_smarty_tpl->tpl_vars['apps']->value;
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
" <?php if (in_array($_smarty_tpl->tpl_vars['k']->value,$_smarty_tpl->tpl_vars['data']->value['app_pub'])) {?>selected="selected"<?php }?> ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['info']->value['app_name'], ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['info'] = $foreach_info_Sav;
}
?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="manager" class="col-sm-2 control-label">负责人：</label>
                    <div class="col-sm-5">
                        <select id="manager" name="manager[]" class="col-sm-4" multiple="multiple" >
                            <?php
$_from = $_smarty_tpl->tpl_vars['admins']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['mrow'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['mrow']->_loop = false;
$_smarty_tpl->tpl_vars['mk'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['mk']->value => $_smarty_tpl->tpl_vars['mrow']->value) {
$_smarty_tpl->tpl_vars['mrow']->_loop = true;
$foreach_mrow_Sav = $_smarty_tpl->tpl_vars['mrow'];
?>
                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mk']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['mk']->value,$_smarty_tpl->tpl_vars['data']->value['manager']) || $_smarty_tpl->tpl_vars['mk']->value == $_smarty_tpl->tpl_vars['login_admin']->value) {?>selected="selected"<?php }?> ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mrow']->value['name'], ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['mrow'] = $foreach_mrow_Sav;
}
?>
                        </select>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['account_id']->value) {?>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">状态：</label>
                    <div class="col-sm-5">
                        <label style="margin-right: 20px"><input type="radio" <?php if ($_smarty_tpl->tpl_vars['data']->value['status'] == 0) {?>checked="checked"<?php }?> name="status" value="0">正常</label>
                        <label><input type="radio" <?php if ($_smarty_tpl->tpl_vars['data']->value['status'] == 1) {?>checked="checked"<?php }?> name="status" value="1">失效</label>
                    </div>
                </div>
                <?php }?>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 确 认</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/webuploader/webuploader.css">
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/webuploader/webuploader.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/upload.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function () {
        $("#submit").on('click',function(){
            addInfo();
        });

        $(document).on('keydown',function(event){
            if(event.keyCode == 13){
                addInfo();
            }
        });
        $("#cancel").on('click',function(){
            window.history.back();
        });
        function addInfo() {
            var _this = $("#submit");
            $('.need').each(function(){
                if(!$(this).val()){
                    layer.msg('请填写必要选项',{time:1000});
                    return false;
                }
            });
            var tips = layer.confirm('确认录入',function(){
                $.ajax({
                    type:'post',
                    url:'/?ct=system&ac=mediaAccountAddAction',
                    data:$("#myForm").serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        _this.addClass('layui-btn-disabled');
                        _this.attr('disabled',true);
                    },
                    success:function(ret){
                        layer.msg(ret.msg);
                        if(ret.state == 1){
                            var data = ret.data;
                            setTimeout(function(){
                                window.open(data.url);
                            },1000);
                        }else{
                            return false;
                        }
                    },
                    complete:function(){
                        layer.close(tips);
                        _this.removeClass('layui-btn-disabled');
                        _this.attr('disabled',false);
                    }
                })
            })
        }
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>