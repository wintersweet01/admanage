<?php /* Smarty version 3.1.27, created on 2019-11-29 20:20:24
         compiled from "/home/vagrant/code/admin/web/admin/template/retain/channelRetain.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:12642565405de10d083e7144_59963183%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '757ca09f15c7a8e7479f53043eb2cada26c4c3f0' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/retain/channelRetain.tpl',
      1 => 1558417905,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12642565405de10d083e7144_59963183',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'name' => 0,
    '_channels' => 0,
    'item' => 0,
    'id' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d084b52e2_95101776',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d084b52e2_95101776')) {
function content_5de10d084b52e2_95101776 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '12642565405de10d083e7144_59963183';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="retainData" />
            <input type="hidden" name="ac" value="channelRetain" />
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select name="platform">
                    <option value="">全 部</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>
                <label>选择游戏包</label>
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
" class="Wdate" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" />

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
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>日期</td>
                        <td nowrap>游戏名称</td>
                        <td nowrap>渠道</td>
                        <td nowrap>游戏包</td>

                        <td nowrap>注册量</td>
                        <td nowrap>次日留存</td>
                        <td nowrap>3日留存</td>
                        <td nowrap>4日留存</td>
                        <td nowrap>5日留存</td>
                        <td nowrap>6日留存</td>
                        <td nowrap>7日留存</td>
                        <td nowrap>15日留存</td>
                        <td nowrap>21日留存</td>
                        <td nowrap>30日留存</td>
                        <td nowrap>60日留存</td>
                        <td nowrap>90日留存</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>合计</td>
                        <td nowrap></td>
                        <td nowrap></td>
                        <td nowrap></td>

                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain2']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain3']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain4']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain5']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain6']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain7']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain15']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain21']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain30']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain60']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
                        <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['data']->value['total']['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain90']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%</b></td>
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
                        <tr>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['u']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>

                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_2']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain2']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_3']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain3']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_4']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain4']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_5']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain5']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_6']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain6']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_7']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain7']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_15']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain15']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_21']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain21']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_30']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain30']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_60']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain60']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_90']) {?>-<?php } else {
if ($_smarty_tpl->tpl_vars['u']->value['reg']) {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain90']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');
} else { ?>0.00<?php }?>%<?php }?></b></td>
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
        $('#printExcel').click(function(){

            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function(){
                channel_ids += 'channel_id[]='+$(this).val()+'&';
            });

            location.href='?ct=retainData&ac=channelRetainExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&platform='+$('select[name=platform]').val()+channel_ids+'&package_name='+$('select[name=package_name]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });
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

        $('select[name=game_id],select[name=platform]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            var device_type = $('select[name=platform] option:selected').val();
            if(!game_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id+'&device_type='+device_type,function(re) {
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