<?php /* Smarty version 3.1.27, created on 2019-11-29 10:04:30
         compiled from "/home/vagrant/code/admin/web/admin/template/ad/addDeliveryGroup.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:8399183125de07cae2e7161_41628568%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c43ca46563b8f8399374312083e846a1c8c37f89' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/ad/addDeliveryGroup.tpl',
      1 => 1571041972,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8399183125de07cae2e7161_41628568',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de07cae318066_88531963',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de07cae318066_88531963')) {
function content_5de07cae318066_88531963 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8399183125de07cae2e7161_41628568';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="group_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['group_id'], ENT_QUOTES, 'UTF-8');?>
"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加投放组</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="channel_name" class="col-sm-2 control-label">* 名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="group_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['group_name'], ENT_QUOTES, 'UTF-8');?>
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
    $(function(){
        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=ad&ac=addDeliveryGroupAction',{data:data},function(re){
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:3000,
                    end:function(){
                        if(re.state == true){
                            location.href = '?ct=ad&ac=deliveryGroup';
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