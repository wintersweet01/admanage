<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:21
         compiled from "/home/vagrant/code/admin/web/admin/template/data/overviewMonth.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10449883775ddf91cdb1d509_11643784%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'feb5237b63e49fbe68de1ca90d07cec97f95ef4e' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/overviewMonth.tpl',
      1 => 1571044662,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10449883775ddf91cdb1d509_11643784',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91cdb9aca2_23096802',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91cdb9aca2_23096802')) {
function content_5ddf91cdb9aca2_23096802 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10449883775ddf91cdb1d509_11643784';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="OverviewMonth"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>

                <label>月份</label>
                <input type="text" class="form-control" name="month" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['month'], ENT_QUOTES, 'UTF-8');?>
"/>

                <label class="checkbox-inline">
                    <input type="checkbox" name="plus_" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['plus_'] == 1) {?>checked="checked"<?php }?> />
                    显示后续条目
                </label>

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['all'] == 1) {?>checked="checked"<?php }?> />显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;" id="tableDiv">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>日期</td>
                        <td nowrap>总新增</td>
                        <td nowrap>当天新增</td>
                        <td nowrap>DAU</td>
                        <td nowrap>老用户活跃</td>
                        <td nowrap>新增付费用户成本<i class="fa fa-question-circle" alt="（消耗/每日新增付费用户数）"></i></td>
                        <td nowrap>新增设备</td>
                        <td nowrap>新增付费人数</td>
                        <td nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/当天新增）"></i></td>
                        <td nowrap>新增ARPU<i class="fa fa-question-circle" alt="（新增付费金额/当天新增）"></i></td>
                        <td nowrap>新增ARPPU<i class="fa fa-question-circle" alt="（新增付费金额/新增付费人数）"></i></td>
                        <td nowrap>新增付费金额</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>付费率<i class="fa fa-question-circle" alt="（付费人数/DAU）"></i></td>
                        <td nowrap>ARPU<i class="fa fa-question-circle" alt="（总充值/DAU）"></i></td>
                        <td nowrap>ARPPU<i class="fa fa-question-circle" alt="（总充值/付费人数）"></i></td>
                        <td nowrap>总充值</td>
                        <td nowrap>消耗</td>

                        <td nowrap>新增ROI<i class="fa fa-question-circle" alt="（新增充值/消耗）"></i></td>
                        <td nowrap>ROI<i class="fa fa-question-circle" alt="（总充值/消耗）"></i></td>
                        <td nowrap>日累计ROI<i class="fa fa-question-circle" alt="（单月内的累计充值/单月内的累计消耗）"></i></td>
                        <td nowrap>次日留存<i class="fa fa-question-circle" alt="（次日留存数/当天新增）"></i></td>
                        <td nowrap>3日留存<i class="fa fa-question-circle" alt="（3日留存数/当天新增）"></i></td>
                        <td nowrap>7日留存<i class="fa fa-question-circle" alt="（7日留存数/当天新增）"></i></td>
                        <td nowrap>15日留存<i class="fa fa-question-circle" alt="（15日留存数/当天新增）"></i></td>
                        <td nowrap>30日留存<i class="fa fa-question-circle" alt="（30日留存数/当天新增）"></i></td>
                        <td nowrap>60日留存<i class="fa fa-question-circle" alt="（60日留存数/当天新增）"></i></td>
                        <td nowrap>90日留存<i class="fa fa-question-circle" alt="（90日留存数/当天新增）"></i></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td  nowrap>合计</td>
                        <td  nowrap></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_reg_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_login_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_old_user_active'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td  nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_reg_device'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_pay_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td  nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-danger">¥<b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-danger">¥<b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-danger">¥<b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_pay_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td  nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-danger">¥<b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-danger">¥<b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-danger">¥<b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-danger">¥<b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_acROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_retain2'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_2retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_retain3'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_3retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_retain7'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_7retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_retain15'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_15retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_retain30'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_30retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_retain60'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_60retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_retain90'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_90retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>

                    </tr>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                        <tr <?php if ($_smarty_tpl->tpl_vars['u']->value['nothismonth']) {?>class='active'<?php }?>>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['login_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['old_user_active'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_device'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_pay_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap  class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['new_ARPU'] != '-') {?>¥<?php }
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['new_ARPPU'] != '-') {?>¥<?php }
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['new_pay_money'] != '-') {?>¥<?php }
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pay_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap  class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>

                            <td  nowrap  class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowarp class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total_acROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain2'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['2retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain3'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['3retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain7'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['7retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain15'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['15retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain30'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['30retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain60'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['60retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain90'], ENT_QUOTES, 'UTF-8');?>
 / <b class="text-olive" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['90retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
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
            plus_ = $('input[name=plus_]:checked').val();
            if(plus_){
                plus_ = 1;
            }else{
                plus_ = 0;
            }

            location.href='?ct=data&ac=overviewMonthExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&device_type='+$('select[name=device_type]').val()+'&month='+$('input[name=month]').val()+'&plus_='+plus_;
        });
        $('input[name=sdate],input[name=month]').on('click focus',function() {
            WdatePicker({el:this, dateFmt:"yyyy-MM"});
        });

    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>