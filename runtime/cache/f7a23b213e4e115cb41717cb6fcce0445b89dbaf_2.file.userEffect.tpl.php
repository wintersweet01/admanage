<?php /* Smarty version 3.1.27, created on 2019-11-29 14:06:26
         compiled from "/home/vagrant/code/admin/web/admin/template/adDataAndorid/userEffect.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7762441225de0b562a8f0c1_08979593%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7a23b213e4e115cb41717cb6fcce0445b89dbaf' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adDataAndorid/userEffect.tpl',
      1 => 1558417907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7762441225de0b562a8f0c1_08979593',
  'variables' => 
  array (
    'widgets' => 0,
    '_user_list' => 0,
    'item' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0b562aed439_16757847',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0b562aed439_16757847')) {
function content_5de0b562aed439_16757847 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '7762441225de0b562a8f0c1_08979593';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adDataAndorid"/>
            <input type="hidden" name="ac" value="userEffect"/>
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择账号</label>
                <select name="user_id" style="width: 150px;">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_user_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['user_id'] == $_smarty_tpl->tpl_vars['item']->value['user_id']) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                </select>

                <label>注册时间</label>
                <input type="text" name="rsdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg_sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="redate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg_edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <label>付款时间</label>
                <input type="text" name="psdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pay_sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="pedate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pay_edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>账号</td>
                        <td nowrap>消耗</td>
                        <td nowrap>展示</td>
                        <td nowrap>点击</td>
                        <td nowrap>注册</td>
                        <td nowrap>注册成本</td>
                        <td nowrap>次日留存数</td>
                        <td nowrap>留存率</td>
                        <td nowrap>留存成本</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>付费率</td>
                        <td nowrap>付款成本</td>
                        <td nowrap>付费金额</td>
                        <td nowrap>ROI</td>
                        <td nowrap>ARPU</td>
                        <td nowrap>ARPPU</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>汇总</td>
                        <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['display'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['retain'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['payer_num'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['all']['ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['channel'], ENT_QUOTES, 'UTF-8');?>
)</td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['display'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['payer_num'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
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
    $(function () {

        $('.all_sel').on('click', function () {
            $('input[name="channel_id[]"]').prop('checked', true);
        });

        $('.diff_sel').on('click', function () {
            $('input[name="channel_id[]"]').each(function () {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            });
        });

        $('#printExcel').click(function () {
            location.href = '?ct=adDataAndorid&ac=userEffectExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + '&user_id=' + $('select[name=user_id]').val() + '&rsdate=' + $('input[name=rsdate]').val() + '&redate=' + $('input[name=redate]').val() + '&psdate=' + $('input[name=psdate]').val() + '&pedate=' + $('input[name=pedate]').val();
        });

        $('select[name=game_id]').on('change', function () {
            $.getJSON('?ct=data&ac=getMoneyLevel&game_id=' + $('select[name=game_id]').val(), function (re) {
                var html = '<option value="">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value=' + i + '>' + n + '</option>';
                });
                $('select[name="level_id"]').html(html);
            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>