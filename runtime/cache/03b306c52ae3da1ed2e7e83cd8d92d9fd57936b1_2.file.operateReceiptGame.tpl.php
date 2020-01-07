<?php /* Smarty version 3.1.27, created on 2019-11-29 20:21:10
         compiled from "/home/vagrant/code/admin/web/admin/template/finance/operateReceiptGame.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11590511785de10d36088637_91813158%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03b306c52ae3da1ed2e7e83cd8d92d9fd57936b1' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/finance/operateReceiptGame.tpl',
      1 => 1550030864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11590511785de10d36088637_91813158',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'val' => 0,
    'key' => 0,
    'v' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d360cfa42_43927991',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d360cfa42_43927991')) {
function content_5de10d360cfa42_43927991 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11590511785de10d36088637_91813158';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="operateReceipt"/>
            <input type="hidden" name="ac" value="operateReceiptGame"/>
            <div class="form-group">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" />

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>游戏</th>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['channel'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['val']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$foreach_val_Sav = $_smarty_tpl->tpl_vars['val'];
?>
                        <th><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['val']->value, ENT_QUOTES, 'UTF-8');?>
</th>
                        <?php
$_smarty_tpl->tpl_vars['val'] = $foreach_val_Sav;
}
?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$_smarty_tpl->tpl_vars['item']->iteration++;
$_smarty_tpl->tpl_vars['item']->first = $_smarty_tpl->tpl_vars['item']->iteration == 1;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                        <tr <?php if ($_smarty_tpl->tpl_vars['item']->first) {?>style="font-weight: bold;background-color: #fff3cd;"<?php }?>>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['channel'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
                            <td class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['v']->value], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
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
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        $('#printExcel').click(function () {
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function () {
                channel_ids += 'channel_id[]=' + $(this).val() + '&';
            });
            location.href = '?ct=adData&ac=dayChannelEffectExcel&&game_id=' + $('select[name=game_id]').val() + channel_ids + 'sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val() + '&psdate=' + $('input[name=psdate]').val() + '&pedate=' + $('input[name=pedate]').val();
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>