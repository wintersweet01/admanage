<?php /* Smarty version 3.1.27, created on 2019-11-29 20:21:15
         compiled from "/home/vagrant/code/admin/web/admin/template/finance/destribuConfList.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4874345885de10d3b5b2ea3_18232491%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef9d95c6411020694ccb67708d9122f99918fb00' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/finance/destribuConfList.tpl',
      1 => 1550030863,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4874345885de10d3b5b2ea3_18232491',
  'variables' => 
  array (
    'data' => 0,
    'item' => 0,
    'val' => 0,
    'key' => 0,
    '_games' => 0,
    'k' => 0,
    'kk' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d3b5ef805_85111809',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d3b5ef805_85111809')) {
function content_5de10d3b5ef805_85111809 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4874345885de10d3b5b2ea3_18232491';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="destribuReceipt" />
            <input type="hidden" name="ac" value="destribuConfList" />
            <div class="form-group">
                <?php if (SrvAuth::checkPublicAuth('add',false)) {?><a href="?ct=destribuReceipt&ac=destribuConfig" class="btn btn-primary btn-small" role="button"> + 添加分成配置 </a><?php }?>
                <!--<button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>-->
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>游戏</td>
                        <td nowrap>渠道</td>
                        <td nowrap>金额范围</td>
                        <td nowrap>比例</td>
                        <td nowrap>操作</td>

                    </tr>
                    </thead>
                    <tbody>

                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['item']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['val']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$foreach_val_Sav = $_smarty_tpl->tpl_vars['val'];
?>
                            <?php
$_from = $_smarty_tpl->tpl_vars['val']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['vv']->_loop = false;
$_smarty_tpl->tpl_vars['kk'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['kk']->value => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
$foreach_vv_Sav = $_smarty_tpl->tpl_vars['vv'];
?>
                                <tr>
                                    <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['key']->value], ENT_QUOTES, 'UTF-8');?>
</td>
                                    <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
</td>
                                    <td nowrap class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['kk']->value, ENT_QUOTES, 'UTF-8');?>
</b></td>
                                    <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['vv']->value, ENT_QUOTES, 'UTF-8');?>
</td>
                                    <td nowrap><a href="?ct=destribuReceipt&ac=destribuConfig&game_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
&channel=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
&area=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['kk']->value, ENT_QUOTES, 'UTF-8');?>
&prop=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['vv']->value, ENT_QUOTES, 'UTF-8');?>
&is_edit=1">修改</a></td>
                                </tr>
                            <?php
$_smarty_tpl->tpl_vars['vv'] = $foreach_vv_Sav;
}
?>
                        <?php
$_smarty_tpl->tpl_vars['val'] = $foreach_val_Sav;
}
?>
                    <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>

                    </tbody>
                </table>
            </div>
            <div style="float: right;">
                <nav>
                    <ul class="pagination">
                        <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function(){
        $('.all_sel').on('click',function(){
            $('input[name="channel_id[]"]').prop('checked',true);
        });

        $('.diff_sel').on('click',function(){
            $('input[name="channel_id[]"]').each(function(){
                if($(this).is(':checked')){
                    $(this).prop('checked',false);
                }else{
                    $(this).prop('checked',true);
                }
            });
        });

        $('#printExcel').click(function(){
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function(){
                channel_ids += 'channel_id[]='+$(this).val()+'&';
            });
            location.href='?ct=adData&ac=dayChannelEffectExcel&&game_id='+$('select[name=game_id]').val()+channel_ids+'sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val()+'&psdate='+$('input[name=psdate]').val()+'&pedate='+$('input[name=pedate]').val();
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>