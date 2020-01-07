<?php /* Smarty version 3.1.27, created on 2019-11-29 11:14:47
         compiled from "/home/vagrant/code/admin/web/admin/template/system/appadd.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:16016638905de08d27565e65_13447791%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec006c0351da4af8d6269cbfb40ccfe8113eab57' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/system/appadd.tpl',
      1 => 1568890144,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16016638905de08d27565e65_13447791',
  'variables' => 
  array (
    'data' => 0,
    'widgets' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08d275aeec7_45626753',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08d275aeec7_45626753')) {
function content_5de08d275aeec7_45626753 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '16016638905de08d27565e65_13447791';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style>
    .input-width {
        width: 200px;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="appid" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['appid'], ENT_QUOTES, 'UTF-8');?>
"/>
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back" class="text-blue">返 回</a></li>
                        <li class="active"><u>添加/修改应用</u></li>
                    </ol>
                </div>
                <div class="form-group">
                    <label for="app_name" class="col-sm-2 control-label"><em class="text-red">*</em> 应用名称</label>
                    <div class="col-sm-5">
                        <input type="text" name="app_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['app_name'], ENT_QUOTES, 'UTF-8');?>
" class="form-control input-width">
                    </div>
                </div>
                <div class="form-group">
                    <label for="app_code" class="col-sm-2 control-label"><em class="text-red">*</em> 应用编码<i class="fa fa-question-circle"
                                                                                  alt="(每个应用在系统中对应的唯一识别码，由6位数字和字母组成（填写应用名称后，自动生成的）)"></i>：</label>
                    <div class="col-sm-5">
                        <input type="text" name="app_code" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['app_code'], ENT_QUOTES, 'UTF-8');?>
" class="form-control input-width"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="device_type" class="col-sm-2 control-label"><em class="text-red">*</em> 平台：</label>
                    <div class="col-sm-5">
                        <select name="device_type">
                            <option value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 0) {?>selected="selected"<?php }?> >不限</option>
                            <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="seleted"<?php }?> >IOS</option>
                            <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="seleted"<?php }?> >安卓</option>
                        </select>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['data']->value['appid']) {?>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label"><em class="text-red">*</em> 状态：</label>
                    <div class="col-sm-5">
                        <label class="control-label" style="margin-right: 30px;">
                            <input class="checkbox-radio" <?php if ($_smarty_tpl->tpl_vars['data']->value['status'] == 0) {?>checked="checked"<?php }?> type="radio" name="status" value="0">有效
                        </label>
                        <label class="control-label" style="margin-right: 30px;">
                            <input class="checkbox-radio" <?php if ($_smarty_tpl->tpl_vars['data']->value['status'] == 1) {?>checked="checked"<?php }?> type="radio" name="status" value="1">无效
                        </label>
                    </div>
                </div>
                <?php }?>

                <div class="form-group">
                    <label for="media_account" class="col-sm-2 control-label"><em class="text-red">*</em> 媒体账号：</label>
                    <div class="col-lg-8">
                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

                    </div>
                </div>

                <div class="form-group text-left" style="width: 30%;margin: 0 auto;margin-left: 25%">
                    <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/ping_uf.js?v=2019021820"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function () {

        $("input[name=app_name]").blur(function(){
            var name = $(this).val();
            if(name) {
                var code = pinyin.getCamelChars(name);
                code += Math.round(Math.random() * 10);
                $("input[name=app_code]").val(code);
            }
        });

        $('#submit').on('click', function () {
            var tdata = getTransData();
            var data = $('form').serialize();
            if($.isEmptyObject(JSON.parse(tdata))){
                layer.msg('请勾选媒体账号至右表',{time:1000});
                return false;
            }
            $.post('?ct=system&ac=appAddAction',{data:data,tdata:tdata}, function (re) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=system&ac=appManage';
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
?>

<?php }
}
?>