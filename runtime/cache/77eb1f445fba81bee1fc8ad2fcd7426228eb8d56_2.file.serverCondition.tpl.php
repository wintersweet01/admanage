<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:22
         compiled from "/home/vagrant/code/admin/web/admin/template/data/serverCondition.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10451983215ddf91ce9c9043_45624464%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77eb1f445fba81bee1fc8ad2fcd7426228eb8d56' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/serverCondition.tpl',
      1 => 1558417907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10451983215ddf91ce9c9043_45624464',
  'variables' => 
  array (
    'widgets' => 0,
    '_game_server' => 0,
    'id' => 0,
    'data' => 0,
    'name' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91cea255c3_16360131',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91cea255c3_16360131')) {
function content_5ddf91cea255c3_16360131 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10451983215ddf91ce9c9043_45624464';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="serverCondition"/>
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择区服</label>
                <select name="server_id">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_game_server']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['server_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
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
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td  nowrap>时间</td>
                        <td  nowrap>游戏创角数</td>
                        <td  nowrap>老用户活跃</td>
                        <td  nowrap>DAR<i class="fa fa-question-circle" alt="角色活跃数"></i></td>
                        <td  nowrap>新增付费角色数</td>
                        <td  nowrap>新增角色付费率<i class="fa fa-question-circle" alt="（新增付费角色数/游戏创角数）"></i></td>
                        <td  nowrap>新增ARPPR<i class="fa fa-question-circle" alt="（新增角色付费/新增付费角色数）"></i></td>
                        <td  nowrap>新增角色付费</td>
                        <td  nowrap>付费角色数</td>
                        <td  nowrap>角色付费率<i class="fa fa-question-circle" alt="（付费角色数/角色DAR）"></i></td>
                        <td  nowrap>ARPR<i class="fa fa-question-circle" alt="（总充值/DAR）"></i></td>
                        <td  nowrap>ARPPR<i class="fa fa-question-circle" alt="（总充值/付费角色数）"></i></td>
                        <td  nowrap>总充值</td>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['list']) {?>
                        <tr>
                            <td  nowrap>合计 <?php if ($_smarty_tpl->tpl_vars['data']->value['sopenDay'] > 0) {?>(<b class="text-danger">已开服<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sopenDay'], ENT_QUOTES, 'UTF-8');?>
天</b>)<?php }?></td>
                            <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_role'], ENT_QUOTES, 'UTF-8');?>
</td>

                            <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_old_user_active'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_dau_role'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_pay_role'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_new_ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_new_pay_money_role'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_pay_role'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['avg_ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['all_pay_money_role'], ENT_QUOTES, 'UTF-8');?>
</b></i></td>

                        </tr>

                        <?php }?>
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
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['new_role'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['old_user_active'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['dau_role'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['new_pay_role'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td  nowrap  class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger" ><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['new_ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['new_pay_money_role'], ENT_QUOTES, 'UTF-8');?>
</b></td>

                            <td  nowrap ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_role'], ENT_QUOTES, 'UTF-8');?>
</td>

                            <td  nowrap  class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ARPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ARPPU'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td  nowrap  class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_money_role'], ENT_QUOTES, 'UTF-8');?>
</b></td>

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
            location.href='?ct=data&ac=serverConditionExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&server_id='+$('select[name=server_id]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });

        $('select[name=game_id]').on('change',function() {
            $.getJSON('?ct=data&ac=getGameServer&game_id='+$('select[name=game_id]').val(),function(re){
                var html = '<option value="">全 部</option>';
                $.each(re,function(i,n) {
                    html += '<option value='+i+'>'+n+'</option>';
                });
                $('select[name="server_id"]').html(html);
            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>