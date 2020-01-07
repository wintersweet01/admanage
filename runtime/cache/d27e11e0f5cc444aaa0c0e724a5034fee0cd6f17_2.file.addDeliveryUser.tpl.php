<?php /* Smarty version 3.1.27, created on 2019-11-29 17:41:10
         compiled from "/home/vagrant/code/admin/web/admin/template/ad/addDeliveryUser.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4171513385de0e7b698c343_22406978%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd27e11e0f5cc444aaa0c0e724a5034fee0cd6f17' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/ad/addDeliveryUser.tpl',
      1 => 1575014473,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4171513385de0e7b698c343_22406978',
  'variables' => 
  array (
    'data' => 0,
    '_channels' => 0,
    'key' => 0,
    'name' => 0,
    '_companys' => 0,
    'id' => 0,
    '_groups' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0e7b69d8ce0_16170137',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0e7b69d8ce0_16170137')) {
function content_5de0e7b69d8ce0_16170137 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4171513385de0e7b698c343_22406978';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改投放账号</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="width" class="col-sm-2 control-label">* 渠道</label>
                    <div class="col-sm-5">
                        <select name="channel_id">
                            <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['channel_id'] == $_smarty_tpl->tpl_vars['key']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_id" class="col-sm-2 control-label">* 所属资质公司</label>
                    <div class="col-sm-5">
                        <select name="company_id">
                            <?php
$_from = $_smarty_tpl->tpl_vars['_companys']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['company_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="width" class="col-sm-2 control-label">* 所属投放组</label>
                    <div class="col-sm-5">
                        <select name="group_id">
                            <?php
$_from = $_smarty_tpl->tpl_vars['_groups']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['group_id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['group_id'] == $_smarty_tpl->tpl_vars['name']->value['group_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['group_name'], ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="media_account" class="col-sm-2 control-label">* 媒体账号</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="media_account" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['media_account'], ENT_QUOTES, 'UTF-8');?>
" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="media_account_pwd" class="col-sm-2 control-label">* 媒体账号密码</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="media_account_pwd" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['media_account_pwd'], ENT_QUOTES, 'UTF-8');?>
" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_name" class="col-sm-2 control-label">* 账号名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="user_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['user_name'], ENT_QUOTES, 'UTF-8');?>
" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="sign_key" class="col-sm-2 control-label"> sign key</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="sign_key" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['sign_key'], ENT_QUOTES, 'UTF-8');?>
" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="encrypt_key" class="col-sm-2 control-label"> encrypt key</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="encrypt_key" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['encrypt_key'], ENT_QUOTES, 'UTF-8');?>
" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="domain" class="col-sm-2 control-label">自定义投放域名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="domain" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['domain'], ENT_QUOTES, 'UTF-8');?>
" >
                        <span class="help-block">格式：http://example.com。留空将使用默认域名，填写前需确保域名已解析。</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="download_domain" class="col-sm-2 control-label">自定义下载域名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="download_domain" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['download_domain'], ENT_QUOTES, 'UTF-8');?>
" >
                        <span class="help-block">格式：http://example.com。留空将使用默认域名，填写前需确保域名已解析。</span>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="button" id="submit" class="btn btn-primary"> 保 存 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
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
            $.post('?ct=ad&ac=addDeliveryUserAction',{data:data},function(re){
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:3000,
                    end:function(){
                        if(re.state == true){
                            location.href = '?ct=ad&ac=deliveryUser';
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