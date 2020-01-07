<?php /* Smarty version 3.1.27, created on 2019-11-29 20:21:06
         compiled from "/home/vagrant/code/admin/web/admin/template/data/channelHourPay.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2562569205de10d32bda882_91926873%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3febb0b1c61e454cad5c8a0c730ce8b356f910f' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/channelHourPay.tpl',
      1 => 1552990135,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2562569205de10d32bda882_91926873',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    '_channels' => 0,
    'item' => 0,
    'id' => 0,
    'name' => 0,
    'channel' => 0,
    'date' => 0,
    'u' => 0,
    'channels' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d32c86c65_49230653',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d32c86c65_49230653')) {
function content_5de10d32c86c65_49230653 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2562569205de10d32bda882_91926873';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data2" />
            <input type="hidden" name="ac" value="channelHourPay" />
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

                
                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>

                <label>用户类型</label>
                <select name="user_type">
                    <option value="">全 部</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 1) {?>selected="selected"<?php }?>> 新用户</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 2) {?>selected="selected"<?php }?>> 老用户 </option>
                </select>
                <label>选择渠道</label>
                <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal">点击选择</button>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    <input type="checkbox" name="channel_id[]" <?php if (!$_smarty_tpl->tpl_vars['data']->value['channel_id']) {?> checked="checked" <?php } else { ?>
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

                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" />

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['all'] == 1) {?>checked="checked"<?php }?> />
                    显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <div id="container" style="min-width:400px;height:400px;"></div>

                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>时间</td>
                        <td nowrap></td>
                        <td nowrap>均值</td>
                        <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id']) {?>
                            <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['channel_id'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['channel']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['channel']->value) {
$_smarty_tpl->tpl_vars['channel']->_loop = true;
$foreach_channel_Sav = $_smarty_tpl->tpl_vars['channel'];
?>
                                <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['channel']->value], ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php
$_smarty_tpl->tpl_vars['channel'] = $foreach_channel_Sav;
}
?>
                        <?php } else { ?>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['channel']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['channel']->value) {
$_smarty_tpl->tpl_vars['channel']->_loop = true;
$foreach_channel_Sav = $_smarty_tpl->tpl_vars['channel'];
?>
                                <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['channel']->value, ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php
$_smarty_tpl->tpl_vars['channel'] = $foreach_channel_Sav;
}
?>
                        <?php }?>
                    </tr>
                    <tr>
                        <td nowrap>总计</td>
                        <td nowrap class="text-danger">
                            <b>¥<?php if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 1) {?>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['t']['total_new_money']['all'], ENT_QUOTES, 'UTF-8');?>

                            <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 2) {?>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['t']['total_old_money']['all'], ENT_QUOTES, 'UTF-8');?>

                            <?php } else { ?>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['t']['all_money']['all'], ENT_QUOTES, 'UTF-8');?>

                                <?php }?></b></td>
                        <td nowrap></td>
                        <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id']) {?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['channel_id'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['channel']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['channel']->value) {
$_smarty_tpl->tpl_vars['channel']->_loop = true;
$foreach_channel_Sav = $_smarty_tpl->tpl_vars['channel'];
?>
                        <td nowrap class="text-danger">
                            <b>¥<?php if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 1) {?>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['t']['total_new_money'][$_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['channel']->value]], ENT_QUOTES, 'UTF-8');?>

                            <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 2) {?>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['t']['total_old_money'][$_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['channel']->value]], ENT_QUOTES, 'UTF-8');?>

                            <?php } else { ?>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['t']['all_money'][$_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['channel']->value]], ENT_QUOTES, 'UTF-8');?>

                            <?php }?></b></td>
                        <?php
$_smarty_tpl->tpl_vars['channel'] = $foreach_channel_Sav;
}
?>
                        <?php } else { ?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['channel']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['channel']->value) {
$_smarty_tpl->tpl_vars['channel']->_loop = true;
$foreach_channel_Sav = $_smarty_tpl->tpl_vars['channel'];
?>
                        <td nowrap></td>
                        <?php
$_smarty_tpl->tpl_vars['channel'] = $foreach_channel_Sav;
}
?>
                        <?php }?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['lists'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
$_smarty_tpl->tpl_vars['date'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['date']->value => $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                        <tr>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['date']->value, ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger">
                                <b>¥<?php if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 1) {?>
                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total']['total_new_money'], ENT_QUOTES, 'UTF-8');?>

                                <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 2) {?>
                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total']['total_old_money'], ENT_QUOTES, 'UTF-8');?>

                                <?php } else { ?>
                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total']['all_money'], ENT_QUOTES, 'UTF-8');?>

                                    <?php }?></b></td>
                            <td nowrap class="text-danger">
                                <b>¥<?php if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 1) {?>
                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['avg']['total_new_money'], ENT_QUOTES, 'UTF-8');?>

                                    <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 2) {?>
                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['avg']['total_old_money'], ENT_QUOTES, 'UTF-8');?>

                                    <?php } else { ?>
                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['avg']['all_money'], ENT_QUOTES, 'UTF-8');?>

                                    <?php }?></b></td>
                            <?php
$_from = $_smarty_tpl->tpl_vars['u']->value['data'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['channels'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['channels']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['channels']->value) {
$_smarty_tpl->tpl_vars['channels']->_loop = true;
$foreach_channels_Sav = $_smarty_tpl->tpl_vars['channels'];
?>

                            <td nowrap class="text-danger">
                                <b>¥
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 1) {?>
                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['channels']->value['new_money'], ENT_QUOTES, 'UTF-8');?>

                            <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 2) {?>
                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['channels']->value['old_money'], ENT_QUOTES, 'UTF-8');?>

                            <?php } else { ?>
                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['channels']->value['total_money'], ENT_QUOTES, 'UTF-8');?>

                                <?php }?>
                                </b>
                            </td>
                            <?php
$_smarty_tpl->tpl_vars['channels'] = $foreach_channels_Sav;
}
?>

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

        $('#container').css('width',$('#content-wrapper').width()-20+'px');

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

        $('#myModal').modal({
            keyboard: true,show:false
        });
        $('#printExcel').click(function(){
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function(){
                channel_ids += 'channel_id[]='+$(this).val()+'&';
            });

            location.href='?ct=data1&ac=regHourExcel&platform='+$('select[name=platform]').val()+channel_ids+'sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });
        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled:false
            },
            title: {
                text: '<?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>IOS平台<?php } elseif ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>Andorid平台<?php } else { ?>所有平台<?php }
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
——<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
每小时新增付费',
                x: -20
            },
            subtitle: {
                    text: '',
                x: -20
            },
            xAxis: {
                categories: [
                <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['lists'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
$_smarty_tpl->tpl_vars['date'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['__foreach_list'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['date']->value => $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_list']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_list']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_list']->value['total'];
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['date']->value, ENT_QUOTES, 'UTF-8');?>
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
                text: '付款金额(元)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '元'
        },
        legend: {
            layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
        },
        series: [

        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['sheet'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
$_smarty_tpl->tpl_vars['date'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['__foreach_list'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['date']->value => $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_list']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_list']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_list']->value['total'];
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
        {name:'<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['date']->value], ENT_QUOTES, 'UTF-8');?>
',data:[<?php
$_from = $_smarty_tpl->tpl_vars['u']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['channels'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['channels']->_loop = false;
$_smarty_tpl->tpl_vars['__foreach_channel'] = new Smarty_Variable(array('total' => $_smarty_tpl->_count($_from), 'iteration' => 0));
foreach ($_from as $_smarty_tpl->tpl_vars['channels']->value) {
$_smarty_tpl->tpl_vars['channels']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_channel']->value['iteration']++;
$_smarty_tpl->tpl_vars['__foreach_channel']->value['last'] = $_smarty_tpl->tpl_vars['__foreach_channel']->value['iteration'] == $_smarty_tpl->tpl_vars['__foreach_channel']->value['total'];
$foreach_channels_Sav = $_smarty_tpl->tpl_vars['channels'];
if ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 1) {?>
        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['channels']->value['new_money'], ENT_QUOTES, 'UTF-8');?>

        <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['user_type'] == 2) {?>
        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['channels']->value['old_money'], ENT_QUOTES, 'UTF-8');?>

        <?php } else { ?>
        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['channels']->value['total_money'], ENT_QUOTES, 'UTF-8');?>

        <?php }
if (!(isset($_smarty_tpl->tpl_vars['__foreach_channel']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_channel']->value['last'] : null)) {?>, <?php }
$_smarty_tpl->tpl_vars['channels'] = $foreach_channels_Sav;
}
?>]} <?php if (!(isset($_smarty_tpl->tpl_vars['__foreach_list']->value['last']) ? $_smarty_tpl->tpl_vars['__foreach_list']->value['last'] : null)) {?> ,<?php }?>
    <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>

    ]
    });

        $('input[name=sdate],input[name=edate]').on('click focus',function() {
            WdatePicker({el:this, dateFmt:"yyyy-MM-dd HH:mm:ss",});
        });
        $('select[name=game_id],select[name=channel_id]').on('change',function() {
            $.getJSON('?ct=ad&ac=getAllMonitor&game_id='+$('select[name=game_id]').val()+'&channel_id='+$('select[name=channel_id]').val(),function(re){
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