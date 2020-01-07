<?php /* Smarty version 3.1.27, created on 2019-12-19 10:14:48
         compiled from "/home/vagrant/code/admin/web/admin/template/service/vip_achievement.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:9929131135dfadd18b49b13_97300874%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8421e29dc22023cba304a8e1b42bc29025b0f8f6' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/service/vip_achievement.tpl',
      1 => 1567689941,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9929131135dfadd18b49b13_97300874',
  'variables' => 
  array (
    'data' => 0,
    'widgets' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5dfadd18ba53a6_94214277',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5dfadd18ba53a6_94214277')) {
function content_5dfadd18ba53a6_94214277 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '9929131135dfadd18b49b13_97300874';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <form method="get" action="" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="vipAchieve"/>

            <div class="form-group">
                <label>日期：</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>~
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <label>母游戏：</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <!--<label>账号：</label>
                <input type="text" name="account" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['account'], ENT_QUOTES, 'UTF-8');?>
">-->

                <label>姓名：</label>
                <input type="text" name="kf_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['kf_name'], ENT_QUOTES, 'UTF-8');?>
">

                <button type="submit" class="btn btn-primary btn-xs">筛 选</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff" id="tableDiv">
                <table class="layui-table table table-bordered table-hover table-condensed table-striped table-responsive" style="min-width: 150px;">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>母游戏</th>
                        <th>总业绩</th>
                        <th>单笔提成</th>
                        <th>累计充值提成</th>
                        <th>提成用户数</th>
                        <th>总提成金额</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['row']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$foreach_row_Sav = $_smarty_tpl->tpl_vars['row'];
?>
                    <tr>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['kf_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['parent_game'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['pay_money'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td>--</td>
                        <td>--</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['pay_man'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td>--</td>
                        <td>
                            <a href="?ct=kfVip&ac=viewlist&sdate=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
&edate=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
&parent_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['parent_id'], ENT_QUOTES, 'UTF-8');?>
&kf_name=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['kf_name'], ENT_QUOTES, 'UTF-8');?>
&kfid=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['insr_kefu'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-default btn-xs">查看明细</a>
                        </td>
                    </tr>
                    <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
                    </tbody>
                </table>
            </div>
            <div>
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

<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php }
}
?>