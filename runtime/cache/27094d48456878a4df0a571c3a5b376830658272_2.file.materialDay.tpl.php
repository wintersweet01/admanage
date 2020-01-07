<?php /* Smarty version 3.1.27, created on 2019-11-28 20:27:13
         compiled from "/home/vagrant/code/admin/web/admin/template/material/materialDay.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10731714795ddfbd21ebcf35_30904885%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27094d48456878a4df0a571c3a5b376830658272' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/material/materialDay.tpl',
      1 => 1571043402,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10731714795ddfbd21ebcf35_30904885',
  'variables' => 
  array (
    'widgets' => 0,
    '_channels' => 0,
    'id' => 0,
    'data' => 0,
    'name' => 0,
    '_admins' => 0,
    '_types' => 0,
    'u' => 0,
    '_games' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddfbd21f184b8_74378198',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddfbd21f184b8_74378198')) {
function content_5ddfbd21f184b8_74378198 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10731714795ddfbd21ebcf35_30904885';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="material"/>
            <input type="hidden" name="ac" value="materialDay"/>
            <div class="form-group form-group-sm">
                <label>游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>渠道</label>
                <select class="form-control" name="channel_id">
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

                <label>制作人</label>
                <select name="upload_user" class="form-control">
                    <option value="">全部制作人</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_admins']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['upload_user'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>制作日期</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" /> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" />

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap rowspan="2" colspan="1">日期</th>
                        <th nowrap rowspan="2" colspan="1">所选游戏</th>
                        <th nowrap rowspan="2" colspan="1">所选渠道</th>
                        <th nowrap rowspan="1" colspan="9">类型统计</th>
                        <th nowrap rowspan="1" colspan="2">需求统计</th>
                        <th nowrap rowspan="1" colspan="2">平均数据反馈</th>
                    </tr>
                    <tr>
                        <?php
$_from = $_smarty_tpl->tpl_vars['_types']->value;
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
                        <th nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</th>
                        <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        <th nowrap>原创构思</th>
                        <th nowrap>需求下单</th>
                        <th nowrap>点击率<i class="fa fa-question-circle" alt="（点击数/曝光数）"></i></th>
                        <th nowrap>点击注册率<i class="fa fa-question-circle" alt="（注册数/点击数）"></i></th>
                    </tr>

                    </thead>
                    <tbody>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['make_date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['data']->value['game_id']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['data']->value['game_id']], ENT_QUOTES, 'UTF-8');
} else { ?>全部<?php }?></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['data']->value['channel_id']], ENT_QUOTES, 'UTF-8');
} else { ?>全部<?php }?></td>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_types']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['type']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->_loop = true;
$foreach_type_Sav = $_smarty_tpl->tpl_vars['type'];
?>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value["type".((string)$_smarty_tpl->tpl_vars['key']->value)], ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php
$_smarty_tpl->tpl_vars['type'] = $foreach_type_Sav;
}
?>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['source1'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['source2'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>