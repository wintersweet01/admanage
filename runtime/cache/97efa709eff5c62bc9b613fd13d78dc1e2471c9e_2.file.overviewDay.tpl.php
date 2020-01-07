<?php /* Smarty version 3.1.27, created on 2019-11-29 20:17:44
         compiled from "/home/vagrant/code/admin/web/admin/template/data/overviewDay.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3761499485de10c68030906_79765612%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97efa709eff5c62bc9b613fd13d78dc1e2471c9e' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/overviewDay.tpl',
      1 => 1552988129,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3761499485de10c68030906_79765612',
  'variables' => 
  array (
    'data' => 0,
    'widgets' => 0,
    '_channels' => 0,
    'id' => 0,
    'name' => 0,
    '_monitors' => 0,
    '_user_list' => 0,
    'item' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10c680e3278_12159270',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10c680e3278_12159270')) {
function content_5de10c680e3278_12159270 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '3761499485de10c68030906_79765612';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data1" />
            <input type="hidden" name="ac" value="overviewDay" />
            <input type="hidden" name="sort_by" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sort_by'], ENT_QUOTES, 'UTF-8');?>
"/>
            <input type="hidden" name="sort_type" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sort_type'], ENT_QUOTES, 'UTF-8');?>
"/>
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择渠道</label>
                <select name="channel_id" style="width: 100px;">
                    <option value="">全 部</option>
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
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>选择游戏包</label>
                <select name="package_name" id="package_id" style="width: 100px;">
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

                <label>选择推广活动</label>
                <select name="monitor_id" style="width: 100px;">
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

                <label>选择账号</label>
                <select name="user_id" style="width: 100px;">
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
" class="Wdate" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" />

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['all'] == 1) {?>checked="checked"<?php }?> />
                    显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap class="order" data-order="date">日期 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'date') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="game_id">游戏名称 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'game_id') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="package_name">游戏包 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'package_name') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="channel_id">渠道名称 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'channel_id') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="monitor_id">推广活动 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'monitor_id') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="click">点击量 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'click') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>

                        <td nowrap class="order" data-order="active">激活量 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'active') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="click_reg">点击注册率 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'click_reg') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?><i class="fa fa-question-circle" alt="（注册量/点击量）"></i></td>
                        <td nowrap class="order" data-order="reg">注册量 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'reg') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="new_reg_device">新增注册设备 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'new_reg_device') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="old_money">区间付费金额 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'old_money') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?><i class="fa fa-question-circle" alt="（非新增充值产生的金额）"></i></td>
                        <td nowrap class="order" data-order="old_pay">区间付费人数 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'old_pay') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="new_money">新增充值金额 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'new_money') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="new_pay">首充人数 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'new_pay') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                        <td nowrap class="order" data-order="update_time">更新时间 <?php if ($_smarty_tpl->tpl_vars['data']->value['sort_by'] == 'update_time') {
if ($_smarty_tpl->tpl_vars['data']->value['sort_type'] == 'asc') {?><i class="fa fa-sort-up"></i><?php } else { ?><i class="fa fa-sort-down"></i><?php }
}?></td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td nowrap>合计</td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['click'], ENT_QUOTES, 'UTF-8');?>
</td>

                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%0.2f",(intval($_smarty_tpl->tpl_vars['data']->value['total']['reg']*10000/$_smarty_tpl->tpl_vars['data']->value['total']['click'])/100)), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_reg_device'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['old_money']/100, ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap></td>
                            <td class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_money']/100, ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap></td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['u']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_monitors']->value[$_smarty_tpl->tpl_vars['u']->value['monitor_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click'], ENT_QUOTES, 'UTF-8');?>
</td>

                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active'], ENT_QUOTES, 'UTF-8');?>
</td>

                            <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click_reg']*sprintf("%0.2f",100), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_reg_device'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger"><a href="?ct=platform&ac=orderList&is_pay=2&is_old=1&_reg_date=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
&game_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
&package_name=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
&channel_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['channel_id'], ENT_QUOTES, 'UTF-8');?>
&monitor_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
&sdate=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
&edate=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['old_money']/100, ENT_QUOTES, 'UTF-8');?>
</b></a></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['old_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger"><a href="?ct=platform&ac=orderList&is_pay=2&is_new=1&_reg_date=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
&game_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
&package_name=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
&channel_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['channel_id'], ENT_QUOTES, 'UTF-8');?>
&monitor_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
&sdate=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
&edate=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_money']/100, ENT_QUOTES, 'UTF-8');?>
</b></a></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['update_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
</td>
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
        $('.order').click(function(){
            var order = $(this).attr('data-order');
            var input = $('input[name=sort_by]').val();
            if(order == input){
                var type = $('input[name=sort_type]').val();
                $('input[name=sort_type]').val(type=='desc' ? 'asc' : 'desc');
            }else{
                $('input[name=sort_by]').val(order);
                $('input[name=sort_type]').val('desc');
            }
            $('form').submit();
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
        $('select[name=channel_id]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            if(!game_id){
                return false;
            }
            var channel_id = $('select[name=channel_id] option:selected').val();
            if(!channel_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id+'&channel_id='+channel_id,function(re) {
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