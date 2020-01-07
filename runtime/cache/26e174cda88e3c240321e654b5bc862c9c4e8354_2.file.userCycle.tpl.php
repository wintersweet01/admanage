<?php /* Smarty version 3.1.27, created on 2019-11-29 14:06:44
         compiled from "/home/vagrant/code/admin/web/admin/template/adDataAndorid/userCycle.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2156856515de0b574313b02_76248202%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26e174cda88e3c240321e654b5bc862c9c4e8354' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adDataAndorid/userCycle.tpl',
      1 => 1558417907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2156856515de0b574313b02_76248202',
  'variables' => 
  array (
    'widgets' => 0,
    '_user_list' => 0,
    'item' => 0,
    'data' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0b5743b8f29_64523585',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0b5743b8f29_64523585')) {
function content_5de0b5743b8f29_64523585 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2156856515de0b574313b02_76248202';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adDataAndorid"/>
            <input type="hidden" name="ac" value="userCycle"/>
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

                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
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
                        <td nowrap>账号</td>
                        <td nowrap>消耗</td>
                        <td nowrap>展示</td>
                        <td nowrap>点击</td>
                        <td nowrap>点击率</td>
                        <td nowrap>点击均价</td>
                        <td nowrap>点击注册率</td>
                        <td nowrap>注册</td>
                        <td nowrap>注册成本</td>
                        <td nowrap>次日留存数</td>
                        <td nowrap>留存率</td>
                        <td nowrap>留存成本</td>
                        <td nowrap>新增付费人数</td>
                        <td nowrap>新增付费率</td>
                        <td nowrap>新增付款成本</td>
                        <td nowrap>新增付费金额</td>
                        <td nowrap>新增ROI</td>
                        <td nowrap>新增ARPU</td>
                        <td nowrap>新增ARPPU</td>
                        <td nowrap>注册ARPU</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>总充值</td>
                        <td nowrap>ROI</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>汇总</td>
                        <td nowrap></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_display'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_click'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_click_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_avg_cprice'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_click_reg_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_retain'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_cost'], ENT_QUOTES, 'UTF-8');?>
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
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_ARPU'], ENT_QUOTES, 'UTF-8');?>
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
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['v']->value;
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['channel'], ENT_QUOTES, 'UTF-8');?>
)</td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100)), ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['display'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['item']->value['display']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['click']*100/$_smarty_tpl->tpl_vars['item']->value['display'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b></td>
                            <td nowrap class="text-danger"><b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['click']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100/$_smarty_tpl->tpl_vars['item']->value['click'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b></td>
                            <td nowrap class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['item']->value['click']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['reg']*100/$_smarty_tpl->tpl_vars['item']->value['click'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger"><b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain1'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['retain1']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b></td>
                            <td nowrap class="text-danger"><b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['retain1']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100/$_smarty_tpl->tpl_vars['item']->value['retain1'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['new_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay']*100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b></td>
                            <td nowrap class="text-danger"><b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['new_pay']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['cost']/100/$_smarty_tpl->tpl_vars['item']->value['new_pay'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b></td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars(($_smarty_tpl->tpl_vars['item']->value['new_pay_money']/100), ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['item']->value['cost']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay_money']*100/$_smarty_tpl->tpl_vars['item']->value['cost'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b></td>
                            <td nowrap class="text-danger"><b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay_money']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b></td>
                            <td nowrap class="text-danger"><b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['new_pay']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['new_pay_money']/100/$_smarty_tpl->tpl_vars['item']->value['new_pay'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b></td>
                            <td nowrap class="text-danger"><b>¥<?php if ($_smarty_tpl->tpl_vars['item']->value['reg']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['pay_money']/100/$_smarty_tpl->tpl_vars['item']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?></b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars(($_smarty_tpl->tpl_vars['item']->value['pay_money']/100), ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['item']->value['cost']) {
echo htmlspecialchars(sprintf("%0.2f",($_smarty_tpl->tpl_vars['item']->value['pay_money']*100/$_smarty_tpl->tpl_vars['item']->value['cost'])), ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>%</b></td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                    <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
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
        $("#content-wrapper").scroll(function(){
            var left=$("#content-wrapper").scrollLeft()-14;//获取滚动的距离
            var trs=$("#tableDiv table tr");//获取表格的所有tr
            if(left == -14){
                left = 0;
            }
            trs.each(function(i){
                $(this).children().eq(0).css({
                    "position":"relative",
                    "top":"0px",
                    "left":left,
                    "background":"white"
                });
            });
        });
        $('#printExcel').click(function(){
            location.href='?ct=adDataAndorid&ac=userCycleExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&user_id='+$('select[name=user_id]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>