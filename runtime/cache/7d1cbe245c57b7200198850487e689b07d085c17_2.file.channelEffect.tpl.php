<?php /* Smarty version 3.1.27, created on 2019-12-02 20:47:44
         compiled from "/home/vagrant/code/admin/web/admin/template/adData/channelEffect.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:9536976885de507f0338e61_27144552%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d1cbe245c57b7200198850487e689b07d085c17' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adData/channelEffect.tpl',
      1 => 1571043750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9536976885de507f0338e61_27144552',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    '_channels' => 0,
    'item' => 0,
    'id' => 0,
    'name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de507f039c397_38431182',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de507f039c397_38431182')) {
function content_5de507f039c397_38431182 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '9536976885de507f0338e61_27144552';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adData"/>
            <input type="hidden" name="ac" value="channelEffect"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>

                <label>选择渠道</label>
                <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#myModal">点击选择
                </button>
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">渠道选择</h4>
                            </div>
                            <div class="modal-body">
                                <span style="display:inline-block;width:180px;margin-left: 20px;margin-bottom: 5px;">
                                <a href="javascript:" class="all_sel">全选</a>
                                <a href="javascript:" class="diff_sel">反选</a>
                                </span>
                                <br>
                                <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
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
                                <span style="display:inline-block;width:180px;">
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox"
                                           name="channel_id[]" <?php if (!$_smarty_tpl->tpl_vars['data']->value['channel_id']) {?> checked="checked" <?php } else { ?>
                                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['channel_id'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value == $_smarty_tpl->tpl_vars['id']->value) {?>
                                    checked="checked"
                                    <?php }?>
                                    <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                                    <?php }?>
                                    value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
&nbsp;
                                </label>
                                    </span>
                                <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>

                <label>注册时间</label>
                <input type="text" name="rsdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg_sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="redate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg_edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/>

                <label>付款时间</label>
                <input type="text" name="psdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pay_sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="pedate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pay_edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>渠道</td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['channel_name'], ENT_QUOTES, 'UTF-8');?>
</td>
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
            <nav>
                <ul class="pagination">
                    <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                </ul>
            </nav>
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
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function () {
                channel_ids += 'channel_id[]=' + $(this).val() + '&';
            });
            location.href = '?ct=adData&ac=channelEffectExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + channel_ids + 'rsdate=' + $('input[name=rsdate]').val() + '&redate=' + $('input[name=redate]').val() + '&psdate=' + $('input[name=psdate]').val() + '&pedate=' + $('input[name=pedate]').val();
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