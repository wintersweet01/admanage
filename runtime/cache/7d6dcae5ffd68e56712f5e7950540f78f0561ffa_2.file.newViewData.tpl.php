<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:27
         compiled from "/home/vagrant/code/admin/web/admin/template/data/newViewData.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11604894805ddf91d3e21404_70251193%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d6dcae5ffd68e56712f5e7950540f78f0561ffa' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/newViewData.tpl',
      1 => 1552987145,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11604894805ddf91d3e21404_70251193',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'u' => 0,
    'title' => 0,
    'item' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91d3e71e46_89033703',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91d3e71e46_89033703')) {
function content_5ddf91d3e71e46_89033703 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11604894805ddf91d3e21404_70251193';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data" />
            <input type="hidden" name="ac" value="newViewData" />
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" />

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
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
        $('#myModal').modal({
            keyboard: true,show:false
        })
        var height = $('#content-main').height();
        $('#container').height(height-50);
        $('#printExcel').click(function(){
            location.href='?ct=data&ac=newViewDataExcel&reg='+$('input[name=reg]').val()+'&new_equipment='+$('input[name=new_equipment]').val()+'&new_players='+$('input[name=new_players]').val()+'&active_login='+$('input[name=active_login]').val()+'&new_active_login='+$('input[name=new_active_login]').val()+'&payer_num='+$('input[name=payer_num]').val()+'&new_payer_num='+$('input[name=new_payer_num]').val()+'&total_deposit_money='+$('input[name=total_deposit_money]').val()+'&new_deposit_money='+$('input[name=new_deposit_money]').val()+'&payrate='+$('input[name=payrate]').val()+'&payARPU='+$('input[name=payARPU]').val()+'&actARPU='+$('input[name=actARPU]').val()+'&newpayARPU='+$('input[name=newpayARPU]').val()+'&newpayrate='+$('input[name=newpayrate]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        })
        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled:false
            },
            title: {
                text: '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
——<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
新增数据查看',
                x: -20
            },
            subtitle: {
                    text: '',
                x: -20
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
                '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
'
                <?php if (!(isset($_smarty_tpl->tpl_vars['__foreach_list']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_list']->value['last'] : null)) {?> ,<?php }?>
                <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                ]
            },
            yAxis: {
                title: {
                    text: ' '
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' '
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [
              <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['lists'];
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
                <?php if ($_smarty_tpl->tpl_vars['title']->value != 'date' && $_smarty_tpl->tpl_vars['title']->value != 'id') {?>
                  {name:'<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['param'][$_smarty_tpl->tpl_vars['title']->value], ENT_QUOTES, 'UTF-8');?>
',data:[<?php
$_from = $_smarty_tpl->tpl_vars['item']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
$_smarty_tpl->tpl_vars['__foreach_datas'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_datas']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_datas']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_datas']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_datas']->value['total'];
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');
if (!(isset($_smarty_tpl->tpl_vars['__foreach_datas']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_datas']->value['last'] : null)) {?>, <?php }
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>]}<?php if (!(isset($_smarty_tpl->tpl_vars['__foreach_item']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_item']->value['last'] : null)) {?> ,<?php }?>
                  <?php }?>

              <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
            ]
        });

        $('select[name=game_id],select[name=channel_id]').on('change',function() {
            $.getJSON('?ct=ad&ac=getAllMonitor&game_id='+$('select[name=game_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&device_type='+$('select[name=device_type]').val()+'&channel_id='+$('select[name=channel_id]').val(),function(re){
                var html = '<option value="">全 部</option>';
                $.each(re,function(i,n) {
                    html += '<option value='+i+'>'+n+'</option>';
                });
                $('select[name="monitor_id"]').html(html);
            });
        });
        $('select[name=game_id]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            if(!game_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id,function(re) {
                var html = '<option value="">全部</option>';
                $.each(re,function(i,n){
                    html += '<option value="'+n+'">'+n+'</option>';
                });
                $('#package_id').html(html);
            });
        });
    });

<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>