<?php /* Smarty version 3.1.27, created on 2019-11-29 10:04:04
         compiled from "/home/vagrant/code/admin/web/admin/template/ad/addAdCompany.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:533988655de07c94af73d5_88741827%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef3def7388b7f26c6e02bda7bbfd159b31163165' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/ad/addAdCompany.tpl',
      1 => 1557038485,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '533988655de07c94af73d5_88741827',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de07c94b30205_81224300',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de07c94b30205_81224300')) {
function content_5de07c94b30205_81224300 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '533988655de07c94af73d5_88741827';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="company_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['company_id'], ENT_QUOTES, 'UTF-8');?>
"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加广告资质公司</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="company_name" class="col-sm-2 control-label">* 公司名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="company_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['company_name'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="record_no" class="col-sm-2 control-label">备案号</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="record_no" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['record_no'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="domain" class="col-sm-2 control-label">域名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="domain" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['domain'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="www" class="col-sm-2 control-label">文网文</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="www" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['www'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="icp" class="col-sm-2 control-label">增值电信业务经营许可证</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="icp" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['icp'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="service_tel" class="col-sm-2 control-label">客服电话</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="service_tel" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['service_tel'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="service_tel" class="col-sm-2 control-label">地址</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['address'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-lg-6 col-sm-9">
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
            var data = $('form').serialize();
            $.post('?ct=ad&ac=addAdCompanyAction',{data:data}, function (re) {
                if (re.state == true) {
                    location.href = '?ct=ad&ac=adCompany';
                } else {
                    layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        shadeClose: true,
                        content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                        time: 3000,
                        end: function () {

                        }
                    });
                }

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