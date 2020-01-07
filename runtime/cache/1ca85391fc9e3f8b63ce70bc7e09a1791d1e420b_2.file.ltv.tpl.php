<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:24
         compiled from "/home/vagrant/code/admin/web/admin/template/data/ltv.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:9970005835ddf91d0dcd3a1_55086439%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ca85391fc9e3f8b63ce70bc7e09a1791d1e420b' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/ltv.tpl',
      1 => 1560944814,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9970005835ddf91d0dcd3a1_55086439',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'only_view' => 0,
    'd' => 0,
    'val' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91d0e38fa6_84223448',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91d0e38fa6_84223448')) {
function content_5ddf91d0e38fa6_84223448 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '9970005835ddf91d0dcd3a1_55086439';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline" id="ltv_form">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="ltv"/>
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select name="platform">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>
                <label style="margin-left: 6px">查看数据</label>
                <select name="only_view" class="view-data">
                    <option value="">请选择</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 1) {?>selected="selected"<?php }?> >只看充值</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 2) {?>selected="selected"<?php }?> >只看LTV</option>
                </select>
                <label>日期</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <label class="checkbox-inline">
                    <input type="checkbox" style="position: relative;top: 2px" name="all" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['all'] == 1) {?>checked="checked"<?php }?> />
                    显示所有条目
                </label>
                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;" id="tableDiv">
                <table class="table table-bordered table-bordered" style="min-width:1500px;">
                    <thead>
                    <tr>
                        <th nowrap rowspan="2">日期</th>
                        <th nowrap rowspan="2">注册量</th>
                        <th nowrap rowspan="2">付费率<i class="fa fa-question-circle" alt="（当天新增付费人数/当天注册量）"></i></th>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['day'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['d']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->value) {
$_smarty_tpl->tpl_vars['d']->_loop = true;
$foreach_d_Sav = $_smarty_tpl->tpl_vars['d'];
?>
                            <th nowrap colspan="<?php if ($_smarty_tpl->tpl_vars['only_view']->value != '') {?>1<?php } else { ?>2<?php }?>">第<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['d']->value, ENT_QUOTES, 'UTF-8');?>
天</th>
                        <?php
$_smarty_tpl->tpl_vars['d'] = $foreach_d_Sav;
}
?>
                    </tr>
                    <tr>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['day'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['d']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->value) {
$_smarty_tpl->tpl_vars['d']->_loop = true;
$foreach_d_Sav = $_smarty_tpl->tpl_vars['d'];
?>
                            <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 1 || $_smarty_tpl->tpl_vars['only_view']->value == '') {?>
                                <th nowrap>充值</th>
                            <?php }?>

                            <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 2 || $_smarty_tpl->tpl_vars['only_view']->value == '') {?>
                                <th nowrap>LTV</th>
                            <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['d'] = $foreach_d_Sav;
}
?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #dadada">
                        <td>合计</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_rate'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['day'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['d']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->value) {
$_smarty_tpl->tpl_vars['d']->_loop = true;
$foreach_d_Sav = $_smarty_tpl->tpl_vars['d'];
?>
                            <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 1 || $_smarty_tpl->tpl_vars['only_view']->value == '') {?>
                                <td class="text-danger"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['val']->value, ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total'][('money').($_smarty_tpl->tpl_vars['d']->value)], ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 2 || $_smarty_tpl->tpl_vars['only_view']->value == '') {?>
                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total'][('ltv').($_smarty_tpl->tpl_vars['d']->value)], ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['d'] = $foreach_d_Sav;
}
?>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pay_rate'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['day'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['d']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->value) {
$_smarty_tpl->tpl_vars['d']->_loop = true;
$foreach_d_Sav = $_smarty_tpl->tpl_vars['d'];
?>
                                <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 1 || $_smarty_tpl->tpl_vars['only_view']->value == '') {?>
                                    <td nowrap class="text-danger"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value[('money').($_smarty_tpl->tpl_vars['d']->value)], ENT_QUOTES, 'UTF-8');?>
</td>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['only_view']->value == 2 || $_smarty_tpl->tpl_vars['only_view']->value == '') {?>
                                    <td nowrap><span style="color:#00a65a;font-weight: bolder;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value[('ltv').($_smarty_tpl->tpl_vars['d']->value)], ENT_QUOTES, 'UTF-8');?>
</span></td>
                                <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['d'] = $foreach_d_Sav;
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
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        $("#content-wrapper").scroll(function () {
            var left = $("#content-wrapper").scrollLeft() - 14;//获取滚动的距离
            var trs = $("#tableDiv table tr");//获取表格的所有tr
            if (left == -14) {
                left = 0;
            }
            trs.each(function (i) {
                if (i == 1) return true;
                $(this).children().eq(0).css({
                    "position": "relative",
                    "top": "0px",
                    "left": left,
                    "background": "white"
                });
            });
        });

        $(".view-data").change(function(){
            $("#ltv_form").submit();
        })
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>