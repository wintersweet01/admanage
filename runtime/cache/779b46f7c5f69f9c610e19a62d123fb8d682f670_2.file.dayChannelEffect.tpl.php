<?php /* Smarty version 3.1.27, created on 2019-12-02 20:47:43
         compiled from "/home/vagrant/code/admin/web/admin/template/adData/dayChannelEffect.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10205147585de507ef825651_31104897%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '779b46f7c5f69f9c610e19a62d123fb8d682f670' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adData/dayChannelEffect.tpl',
      1 => 1571043877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10205147585de507ef825651_31104897',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'name' => 0,
    '_monitors' => 0,
    'id' => 0,
    '_channels' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de507ef919335_24081802',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de507ef919335_24081802')) {
function content_5de507ef919335_24081802 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10205147585de507ef825651_31104897';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adData"/>
            <input type="hidden" name="ac" value="dayChannelEffect"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <!--<lable>选择游戏包</lable>
                <select name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_packages'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['package_name'] == $_smarty_tpl->tpl_vars['name']->value['package_name']) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>
                   -->
                <label>选择推广活动</label>
                <select class="form-control" name="monitor_id" style="width: 150px;">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_monitors']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['monitor_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
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
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/>

                <label>付款时间</label>
                <input type="text" name="psdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['psdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="pedate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pedate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;" id="tableDiv">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>时间</td>
                        <td nowrap>消耗</td>
                        <td nowrap>展示</td>
                        <td nowrap>点击</td>
                        <td nowrap>注册</td>
                        <td nowrap>注册成本</td>
                        <td nowrap>DAU</td>
                        <td nowrap>次日留存数</td>
                        <td nowrap>3日留存数率</td>
                        <td nowrap>7日留存数率</td>
                        <td nowrap>15日留存数率</td>
                        <td nowrap>30日留存数率</td>
                        <td nowrap>留存率</td>
                        <td nowrap>留存成本</td>
                        <td nowrap>ltv0</td>
                        <td nowrap>ltv7</td>
                        <td nowrap>ltv30</td>
                        <td nowrap>ltv45</td>
                        <td nowrap>ltv60</td>
                        <td nowrap>新增付费人数</td>
                        <td nowrap>新增付费率</td>
                        <td nowrap>新增付款成本</td>
                        <td nowrap>新增付费金额</td>
                        <td nowrap>新增ROI</td>
                        <td nowrap>新增ARPU</td>
                        <td nowrap>新增ARPPU</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>总充值</td>
                        <td nowrap>ROI</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>汇总</td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_display'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_click'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_dau'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_retain'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate3'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate7'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate15'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate30'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_ltv0'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_ltv7'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_ltv30'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_ltv45'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_ltv60'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_new_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_new_pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['ROI'], ENT_QUOTES, 'UTF-8');?>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100)), ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['display'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger">
                                <b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['dau'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain1'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['retain3']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['retain7']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['retain15']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['retain30']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['retain1']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
                            <td nowrap class="text-danger">
                                <b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['retain1']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100/$_smarty_tpl->tpl_vars['item']->value['retain1'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay_money']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['money7']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>

                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['money30']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['money45']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['money60']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['new_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
                            <td nowrap class="text-danger">
                                <b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['new_pay']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100/$_smarty_tpl->tpl_vars['item']->value['new_pay'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars(($_smarty_tpl->tpl_vars['item']->value['new_pay_money']/100), ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['cost']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay_money']*100/$_smarty_tpl->tpl_vars['item']->value['cost'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
                            <td nowrap class="text-danger">
                                <b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay_money']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap class="text-danger">
                                <b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['new_pay']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay_money']/100/$_smarty_tpl->tpl_vars['item']->value['new_pay'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars(($_smarty_tpl->tpl_vars['item']->value['pay_money']/100), ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive">
                                <b><?php if ($_smarty_tpl->tpl_vars['item']->value['cost']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['pay_money']*100/$_smarty_tpl->tpl_vars['item']->value['cost'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b>
                            </td>
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
        $("#content-wrapper").scroll(function () {
            var left = $("#content-wrapper").scrollLeft() - 14;//获取滚动的距离
            var trs = $("#tableDiv table tr");//获取表格的所有tr
            if (left == -14) {
                left = 0;
            }
            trs.each(function (i) {
                $(this).children().eq(0).css({
                    "position": "relative",
                    "top": "0px",
                    "left": left,
                    "background": "white"
                });
            });
        });

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
            location.href = '?ct=adData&ac=dayChannelEffectExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + channel_ids + 'sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val() + '&psdate=' + $('input[name=psdate]').val() + '&pedate=' + $('input[name=pedate]').val();
        });
        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html);
            });
        });
        $('select[name=game_id],select[name=channel_id]').on('change', function () {
            $.getJSON('?ct=ad&ac=getAllMonitor&game_id=' + $('select[name=game_id]').val() + '&channel_id=' + $('select[name=channel_id]').val(), function (re) {
                var html = '<option value="">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value=' + i + '>' + n + '</option>';
                });
                $('select[name="monitor_id"]').html(html);
            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>