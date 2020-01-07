<?php /* Smarty version 3.1.27, created on 2019-11-29 20:20:23
         compiled from "/home/vagrant/code/admin/web/admin/template/retain/retain_new.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6724006955de10d0786c137_80254849%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a69b785258cae78414abebdfa93b2c43c3a2988e' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/retain/retain_new.tpl',
      1 => 1563156275,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6724006955de10d0786c137_80254849',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'day' => 0,
    'd' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d07983e77_03508854',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d07983e77_03508854')) {
function content_5de10d07983e77_03508854 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6724006955de10d0786c137_80254849';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline" id="myForm">
            <input type="hidden" name="ct" value="retainData" />
            <input type="hidden" name="ac" value="retainNew" />
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
                        <?php
$_from = $_smarty_tpl->tpl_vars['day']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['d']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['d']->value) {
$_smarty_tpl->tpl_vars['d']->_loop = true;
$foreach_d_Sav = $_smarty_tpl->tpl_vars['d'];
?>
                        <?php if ($_smarty_tpl->tpl_vars['d']->value == 2) {?>
                        <td nowrap>次日留存</td>
                        <?php } else { ?>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['d']->value, ENT_QUOTES, 'UTF-8');?>
日留存</td>
                        <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['d'] = $foreach_d_Sav;
}
?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_smarty_tpl->tpl_vars['data']->value['total'])) {?>
                    <tr>
                        <td nowrap>合计</td>
                        <td nowrap></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <?php if (in_array(2,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain2']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(3,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain3']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(4,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain4']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(5,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain5']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(6,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain6']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(7,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain7']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(15,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain15']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(30,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain30']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(45,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain45']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(60,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain60']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(90,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain90']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(120,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain120']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(150,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain150']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                        <?php if (in_array(180,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['data']->value['total']['retain180']*100/$_smarty_tpl->tpl_vars['data']->value['total']['reg'])), ENT_QUOTES, 'UTF-8');?>
%</b></td><?php }?>
                    </tr>
                    <?php }?>
                    <?php if (!empty($_smarty_tpl->tpl_vars['data']->value['list'])) {?>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['re_date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>

                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php if (in_array(2,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_2']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain2']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(3,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_3']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain3']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(4,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_4']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain4']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(5,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_5']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain5']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(6,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_6']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain6']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(7,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_7']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain7']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(15,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_15']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain15']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(30,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_30']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain30']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(45,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_45']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain45']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(60,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_60']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain60']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(90,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_90']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain90']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(120,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_120']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain120']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(150,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_150']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain150']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                            <?php if (in_array(180,$_smarty_tpl->tpl_vars['day']->value)) {?><td class="text-olive"><b><?php if ($_smarty_tpl->tpl_vars['u']->value['not_now_180']) {?>-<?php } else {
echo htmlspecialchars(sprintf("%.2f",($_smarty_tpl->tpl_vars['u']->value['retain180']*100/$_smarty_tpl->tpl_vars['u']->value['reg'])), ENT_QUOTES, 'UTF-8');?>
%<?php }?></b></td><?php }?>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                    <?php }?>
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
            location.href='?ct=retainData&ac=retainNewExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&platform='+$('select[name=platform]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val()+'&group_child='+$("input[name='group_child']:checked").val();
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