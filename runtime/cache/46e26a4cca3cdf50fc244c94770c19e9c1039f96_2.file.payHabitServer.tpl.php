<?php /* Smarty version 3.1.27, created on 2019-11-29 20:21:03
         compiled from "/home/vagrant/code/admin/web/admin/template/data/payHabitServer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:15575288855de10d2f797f37_43727069%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46e26a4cca3cdf50fc244c94770c19e9c1039f96' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/payHabitServer.tpl',
      1 => 1558417907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15575288855de10d2f797f37_43727069',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    '_level' => 0,
    'id' => 0,
    'name' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d2f7e74f8_74229511',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d2f7e74f8_74229511')) {
function content_5de10d2f7e74f8_74229511 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '15575288855de10d2f797f37_43727069';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data2"/>
            <input type="hidden" name="ac" value="payHabitServer"/>
            <div class="form-group">
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
                <label>档次</label>
                <select name="level_money">
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['level_money'] || $_smarty_tpl->tpl_vars['data']->value['game_id']) {?>
                    <option value="">全部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_level']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['level_money'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                    <?php } else { ?>
                    <option value="">请先选择游戏</option>
                    <?php }?>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['all'] == 1) {?>checked="checked"<?php }?> />
                    显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; min-width: 100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>区服</td>
                        <td>档次</td>
                        <td>充值总额</td>
                        <td>该档次订单数</td>
                        <td>所有档次总订单数</td>

                    </tr>
                    </thead>
                    <tbody>
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
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['server_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['level_money'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['total_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['order_num'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['all_order_number'], ENT_QUOTES, 'UTF-8');?>
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
    $(function(){
        $('#printExcel').click(function(){
            location.href='?ct=data2&ac=payHabitServerExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&device_type='+$('select[name=device_type]').val()+'&level_money='+$('select[name=level_money]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });

        $('select[name=game_id]').on('change',function() {
            $.getJSON('?ct=data&ac=getMoneyLevel&game_id='+$('select[name=game_id]').val(),function(re){
                var html = '<option value="">全 部</option>';
                $.each(re,function(i,n) {
                    html += '<option value='+i+'>'+n+'</option>';
                });
                $('select[name="level_money"]').html(html);
            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>