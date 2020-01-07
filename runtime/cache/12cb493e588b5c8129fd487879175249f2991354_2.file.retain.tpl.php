<?php /* Smarty version 3.1.27, created on 2019-11-29 20:20:20
         compiled from "/home/vagrant/code/admin/web/admin/template/retain/retain.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2542634765de10d044270e3_04566414%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12cb493e588b5c8129fd487879175249f2991354' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/retain/retain.tpl',
      1 => 1562292807,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2542634765de10d044270e3_04566414',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d044dbda6_51015595',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d044dbda6_51015595')) {
function content_5de10d044dbda6_51015595 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2542634765de10d044270e3_04566414';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline" id="myForm">
            <input type="hidden" name="ct" value="retainData" />
            <input type="hidden" name="ac" value="retain" />
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select name="platform">
                    <option value="">全 部</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate" />

                <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox-line" name="all" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['all'] == 1) {?>checked="checked"<?php }?> />
                    显示所有条目
                </label>

                <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox-line group-by-child" name="group_child" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['group_child'] == 1) {?>checked="checked"<?php }?>>
                    按子游戏归类
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

                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain2']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain3']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain4']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain5']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain6']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain7']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain15']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain21']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain30']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain60']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain90']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td>
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

                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_2']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain2']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_3']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain3']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_4']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain4']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_5']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain5']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_6']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain6']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_7']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain7']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_15']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain15']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_21']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain21']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_30']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain30']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_60']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain60']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
                            <td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_90']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain90']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td>
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
            location.href='?ct=retainData&ac=retainExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&platform='+$('select[name=platform]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val()+'&group_child='+$("input[name='group_child']:checked").val();
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

        $(".group-by-child").on('click',function(){
            $("#myForm").submit();
        })
    });

<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>