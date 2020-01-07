<?php /* Smarty version 3.1.27, created on 2019-11-29 20:21:04
         compiled from "/home/vagrant/code/admin/web/admin/template/data/payArea.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6870201725de10d30a570d2_04868934%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '33a1ba1d4ca0388dab5542c066afbc8d160c5c87' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/payArea.tpl',
      1 => 1552989997,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6870201725de10d30a570d2_04868934',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'u' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d30ab6a77_92211342',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d30ab6a77_92211342')) {
function content_5de10d30ab6a77_92211342 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6870201725de10d30a570d2_04868934';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data2"/>
            <input type="hidden" name="ac" value="payArea"/>
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
"/>

                <label>排序方式</label>
                <select name="sort" id="">
                    <option value="">请选择</option>
                    <option value="pay_money"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['sort'] == 'pay_money') {?>selected=selected<?php }?>>按付费金额</option>
                    <option value="pay_rate"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['sort'] == 'pay_rate') {?>selected=selected<?php }?>>按付费率</option>
                    <option value="ARPPU"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['sort'] == 'ARPPU') {?>selected=selected<?php }?>>按ARPPU</option>
                </select>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <!--<button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>-->
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <div id="container" style="min-width:400px;"></div>
            </div>

        </div>
    </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/highcharts/highcharts.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/highcharts/exporting.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/highcharts/highcharts-zh_CN.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/grid-light.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
    $(function(){

        var height = $('#content-main').height();
        $('#container').height(height-50);
        $('#printExcel').click(function(){
            location.href='?ct=data&ac=newViewDataExcel&reg='+$('input[name=reg]').val()+'&new_equipment='+$('input[name=new_equipment]').val()+'&new_players='+$('input[name=new_players]').val()+'&active_login='+$('input[name=active_login]').val()+'&new_active_login='+$('input[name=new_active_login]').val()+'&payer_num='+$('input[name=payer_num]').val()+'&new_payer_num='+$('input[name=new_payer_num]').val()+'&total_deposit_money='+$('input[name=total_deposit_money]').val()+'&new_deposit_money='+$('input[name=new_deposit_money]').val()+'&payrate='+$('input[name=payrate]').val()+'&payARPU='+$('input[name=payARPU]').val()+'&actARPU='+$('input[name=actARPU]').val()+'&newpayARPU='+$('input[name=newpayARPU]').val()+'&newpayrate='+$('input[name=newpayrate]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        })
        $('#container').highcharts({
            credits: {
                enabled:false
            },
            chart: {
                type: 'column'
            },
            title: {
                text: '地区付费数据统计'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
$_smarty_tpl->tpl_vars['__foreach_list'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_list']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_list']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_list']->value['total'];
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                    '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['area'], ENT_QUOTES, 'UTF-8');?>
'
                    <?php if (!(isset($_smarty_tpl->tpl_vars['__foreach_list']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_list']->value['last'] : null)) {?> ,<?php }?>
                <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            //tooltip: {
            //    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            //    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            //    '<td style="padding:0"><b>{point.y:.1f} 元</b></td></tr>',
            //    footerFormat: '</table>',
             //   shared: true,
            //    useHTML: true
            //},
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                { name:'充值金额',data:[
            <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['title'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['__foreach_item'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['title']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_item']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_item']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_item']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_item']->value['total'];
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
               <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_money'], ENT_QUOTES, 'UTF-8');
if (!(isset($_smarty_tpl->tpl_vars['__foreach_item']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_item']->value['last'] : null)) {?> ,<?php }?>


            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>],tooltip: {
                    valueSuffix: '元'
                },dataLabels:{
                    enabled:true, //是否显示数据标签
                        formatter: function() {
                        return this.y ;
                    }
                },<?php if ($_smarty_tpl->tpl_vars['data']->value['sort'] && $_smarty_tpl->tpl_vars['data']->value['sort'] != 'pay_money') {?>visible:false<?php }?>
    },
                { name:'付费率',data:[
                <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['title'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['__foreach_item'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['title']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_item']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_item']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_item']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_item']->value['total'];
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_rate'], ENT_QUOTES, 'UTF-8');
if (!(isset($_smarty_tpl->tpl_vars['__foreach_item']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_item']->value['last'] : null)) {?> ,<?php }?>


                <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>],tooltip: {
                    valueSuffix: '%'
                },dataLabels:{
                    enabled:true, //是否显示数据标签
                        formatter: function() {
                       return this.y + '%';
                    }
                },<?php if ($_smarty_tpl->tpl_vars['data']->value['sort'] && $_smarty_tpl->tpl_vars['data']->value['sort'] != 'pay_rate') {?>visible:false<?php }?>
                },
                { name:'ARPPU',data:[
                <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['title'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['__foreach_item'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['title']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_item']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_item']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_item']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_item']->value['total'];
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ARPPU'], ENT_QUOTES, 'UTF-8');
if (!(isset($_smarty_tpl->tpl_vars['__foreach_item']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_item']->value['last'] : null)) {?> ,<?php }?>


                <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>],tooltip: {
                    valueSuffix: '元'
                },dataLabels:{
                    enabled:true, //是否显示数据标签
                        formatter: function() {
                        return this.y ;
                    }
                },<?php if ($_smarty_tpl->tpl_vars['data']->value['sort'] && $_smarty_tpl->tpl_vars['data']->value['sort'] != 'ARPPU') {?>visible:false<?php }?>
                },

            ]
        });
        $('input[name=sdate],input[name=edate]').on('click focus',function() {
            WdatePicker({el:this, dateFmt:"yyyy-MM"});
        });

    });

<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>