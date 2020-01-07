<?php /* Smarty version 3.1.27, created on 2019-11-29 20:15:54
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/config.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:19988157715de10bfad4e070_00077372%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4189c871daf2cf2c9ec264d17d71e877a58f5e1' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/config.tpl',
      1 => 1565777729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19988157715de10bfad4e070_00077372',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10bfad85f29_90405469',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10bfad85f29_90405469')) {
function content_5de10bfad85f29_90405469 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '19988157715de10bfad4e070_00077372';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">单IP每天限制注册数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_ip_reg]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max_ip_reg'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单IP每天限制登录数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_ip_login]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max_ip_login'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单设备号每天限制注册数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_device_reg]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max_device_reg'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单设备号每天限制登录数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_device_login]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max_device_login'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单手机每天发短信数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_phone_sms]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max_phone_sms'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">玩家每天登录次数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_user_login]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max_user_login'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">玩家每天登录密码错误次数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_user_login_error]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max_user_login_error'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">绑定手机充值总额</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[pay_bind_phone]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pay_bind_phone'], ENT_QUOTES, 'UTF-8');?>
" placeholder="玩家累计充值多少后提示绑定手机">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">IP白名单</label>
                    <div class="col-lg-5 col-sm-9">
                        <textarea name="config[whitelist_ip]" rows="3" class="form-control" placeholder="多个IP换行"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['whitelist_ip'], ENT_QUOTES, 'UTF-8');?>
</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">设备号白名单</label>
                    <div class="col-lg-5 col-sm-9">
                        <textarea name="config[whitelist_device]" rows="3" class="form-control" placeholder="多个设备号换行"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['whitelist_device'], ENT_QUOTES, 'UTF-8');?>
</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">登录玩家账号统一密码</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[login_password]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['login_password'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-lg-5 col-sm-9">
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
            var index = layer.msg('正在保存中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.post('?ct=platform&ac=config', {
                data: $('form').serialize()
            }, function (re) {
                layer.close(index);
                if (re.state == true) {
                    layer.alert('保存成功', {icon: 6}, function () {
                        location.reload();
                    });
                } else {
                    layer.alert(re.msg, {icon: 5});
                }
            }, 'json');
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>