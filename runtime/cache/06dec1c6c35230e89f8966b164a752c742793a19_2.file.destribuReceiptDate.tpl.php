<?php /* Smarty version 3.1.27, created on 2019-11-29 20:21:12
         compiled from "/home/vagrant/code/admin/web/admin/template/finance/destribuReceiptDate.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13926840755de10d388be8c0_80958482%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06dec1c6c35230e89f8966b164a752c742793a19' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/finance/destribuReceiptDate.tpl',
      1 => 1552990271,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13926840755de10d388be8c0_80958482',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'item' => 0,
    'key' => 0,
    'k' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d3890b053_99378129',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d3890b053_99378129')) {
function content_5de10d3890b053_99378129 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13926840755de10d388be8c0_80958482';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="destribuReceipt" />
            <input type="hidden" name="ac" value="destribuReceiptDate" />
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" />

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
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
                        <td nowrap>日期</td>
                        <td>总计</td>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['channel'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['channel_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>总计</td>
                        <td class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['total'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                        <td class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['income'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>

                    </tr>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
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
                        <tr>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
</td>
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
                            <?php if ($_smarty_tpl->tpl_vars['k']->value == 'total_income') {?>
                            <td class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['total_income'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <?php } else { ?>
                            <td class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['val']->value['income'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['val'] = $foreach_val_Sav;
}
?>
                        </tr>
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