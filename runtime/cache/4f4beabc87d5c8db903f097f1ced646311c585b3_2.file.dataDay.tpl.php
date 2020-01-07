<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:19
         compiled from "/home/vagrant/code/admin/web/admin/template/data/dataDay.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13369190925ddf91cbcf0225_52013550%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f4beabc87d5c8db903f097f1ced646311c585b3' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/dataDay.tpl',
      1 => 1571044528,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13369190925ddf91cbcf0225_52013550',
  'variables' => 
  array (
    'widgets' => 0,
    '_channels' => 0,
    'id' => 0,
    'data' => 0,
    'name' => 0,
    '_admins' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91cbd71863_13572402',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91cbd71863_13572402')) {
function content_5ddf91cbd71863_13572402 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13369190925ddf91cbcf0225_52013550';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="dataDay"/>
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>投放账户</label>
                <select class="form-control" name="user_id" id="user_id">
                    <option value="">选择账号</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['users'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['user_id'] == $_smarty_tpl->tpl_vars['name']->value['user_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>负责人</label>
                <select class="form-control" name="create_user">
                    <option value="">选择负责人</option>
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['create_user'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>&nbsp;

                <label>时间</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/>

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
                        <th nowrap>日期</th>
                        <th nowrap>负责人</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>渠道</th>
                        <th nowrap>投放账户</th>
                        <th nowrap>包标识</th>
                        <th nowrap>消耗</th>
                        <th nowrap>展示</th>
                        <th nowrap>点击</th>
                        <th nowrap>点击率<i class="fa fa-question-circle" alt="（点击/展示）"></i></th>
                        <th nowrap>激活数</th>
                        <th nowrap>点击激活率<i class="fa fa-question-circle" alt="（激活数/点击）"></i></th>
                        <th nowrap>激活成本<i class="fa fa-question-circle" alt="（消耗/激活数）"></i></th>
                        <th nowrap>注册</th>
                        <th nowrap>点击注册率<i class="fa fa-question-circle" alt="（注册数/点击）"></i></th>
                        <th nowrap>激活注册率<i class="fa fa-question-circle" alt="（注册数/激活数）"></i></th>
                        <th nowrap>注册成本<i class="fa fa-question-circle" alt="（消耗/注册数）"></i></th>
                        <th nowrap>角色创建数</th>
                        <th nowrap>创建率<i class="fa fa-question-circle" alt="（创角数/注册数）"></i></th>
                        <th nowrap>创角成本<i class="fa fa-question-circle" alt="（消耗/创角数）"></i></th>
                        <th nowrap>新增付费人数</th>
                        <th nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/注册数）"></i></th>
                        <th nowrap>新增付费金额</i></th>
                        <th nowrap>新增ROI<i class="fa fa-question-circle" alt="（新增付费金额/消耗）"></i></th>
                        <th nowrap>首日LTV<i class="fa fa-question-circle" alt="（新增付费金额/注册数）"></i></th>
                        <th nowrap>新增付费成本<i class="fa fa-question-circle" alt="（消耗/新增付费人数）"></i></th>
                        <th nowrap>次日留存率<i class="fa fa-question-circle" alt="（次日留存/注册数）"></i></th>
                        <th nowrap>留存成本<i class="fa fa-question-circle" alt="（消耗/次日留存）"></i></th>
                        <th nowrap>eCPM<i class="fa fa-question-circle" alt="（消耗/(展示/1000)）"></i></th>
                        <th nowrap>每CPM激活数<i class="fa fa-question-circle" alt="（激活数/(展示/1000)）"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap><b>合计</b></td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['display'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['click'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['click_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active_reg_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_role'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_role_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_role_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['count_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_roi_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_ltv'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><b class="text-danger"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain'], ENT_QUOTES, 'UTF-8');?>
</b> / <b
                                    class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['ecpm_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active_cpm'], ENT_QUOTES, 'UTF-8');?>
</b></td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_admins']->value[$_smarty_tpl->tpl_vars['u']->value['create_user']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['u']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['display'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_reg_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_role'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_role_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_role_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['count_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_roi_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_ltv'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><b class="text-danger"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain'], ENT_QUOTES, 'UTF-8');?>
</b> / <b
                                        class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['ecpm_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_cpm'], ENT_QUOTES, 'UTF-8');?>
</b></td>
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
            var w = 0;
            var e = trs.children();
            for (var i = 0; i < 5; i++) {
                w += e.eq(i).outerWidth();
            }

            trs.each(function (i) {
                if (left > w) {
                    $(this).children().eq(5).css({
                        "position": "relative",
                        "top": "0px",
                        "left": left - w,
                        "background": "#FFFF00"
                    });
                } else {
                    $(this).children().eq(5).removeAttr('style');
                }
            });
        });

        $('select[name=channel_id]').on('change', function () {
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!channel_id) {
                return false;
            }
            $.getJSON('?ct=data&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="">选择账号</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#user_id').html(html);
            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>