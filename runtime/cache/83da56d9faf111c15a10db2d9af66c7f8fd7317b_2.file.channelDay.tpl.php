<?php /* Smarty version 3.1.27, created on 2019-11-29 20:17:46
         compiled from "/home/vagrant/code/admin/web/admin/template/data/channelDay.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:12855038785de10c6a18ffa6_24276583%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83da56d9faf111c15a10db2d9af66c7f8fd7317b' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/channelDay.tpl',
      1 => 1553246369,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12855038785de10c6a18ffa6_24276583',
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
  'unifunc' => 'content_5de10c6a209dd3_90249335',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10c6a209dd3_90249335')) {
function content_5de10c6a209dd3_90249335 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '12855038785de10c6a18ffa6_24276583';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data1"/>
            <input type="hidden" name="ac" value="channelDay"/>
            <div class="form-group">
                <label>游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>渠道</label>
                <select name="channel_id">
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

                <label>游戏包</label>
                <select name="package_name" id="package_id" style="width: 150px;">
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['package_name'] == $_smarty_tpl->tpl_vars['name']->value['package_name']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>投放账户</label>
                <select name="user_id" id="user_id">
                    <option value="">全 部</option>
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
                <select name="create_user">
                    <option value="all">全 部</option>
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

                <label>日期</label>
                <input type="text" name="date" readonly value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['date'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>时段</th>
                        <th nowrap>负责人</th>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>渠道</th>
                        <th nowrap>投放账户</th>
                        <th nowrap>推广活动</th>
                        <th nowrap>包标识</th>
                        <th nowrap>DAU</th>
                        <th nowrap>点击量</th>
                        <th nowrap>激活数</th>
                        <th nowrap>点击激活率<i class="fa fa-question-circle" alt="（激活数/点击）"></i></th>
                        <th nowrap>注册量</th>
                        <th nowrap>点击注册率<i class="fa fa-question-circle" alt="（注册数/点击）"></i></th>
                        <th nowrap>激活注册率<i class="fa fa-question-circle" alt="（注册数/激活数）"></i></th>
                        <th nowrap>创建数</th>
                        <th nowrap>创建率<i class="fa fa-question-circle" alt="（创角数/注册数）"></i></th>
                        <th nowrap>新增付费人数</th>
                        <th nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/注册数）"></i></th>
                        <th nowrap>新增付费金额</th>
                        <th nowrap>新增ARPU<i class="fa fa-question-circle" alt="（新增付费金额/注册数）"></i></th>
                        <th nowrap>新增ARPPU<i class="fa fa-question-circle" alt="（新增付费金额/新增付费人数）"></i></th>
                        <th nowrap>老用户新增付费人数<i class="fa fa-question-circle" alt="非查询日期注册，且查询日期首次充值的人数"></i></th>
                        <th nowrap>老用户新增付费金额<i class="fa fa-question-circle" alt="非查询日期注册，且查询日期首次充值的金额"></i></th>
                        <th nowrap>区间付费人数<i class="fa fa-question-circle" alt="非查询日期注册，且查询日期充值的人数 - 老用户新增付费人数"></i></th>
                        <th nowrap>区间付费金额<i class="fa fa-question-circle" alt="非查询日期注册，且查询日期充值的金额 - 老用户新增付费金额"></i></th>
                        <th nowrap>区间付费率<i class="fa fa-question-circle" alt="区间付费人数/(DAU - 注册量)"></i></th>
                        <th nowrap>总充值<i class="fa fa-question-circle" alt="新增付费金额 + 老用户新增付费金额 + 区间付费金额"></i></th>
                        <th nowrap>更新时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>合计</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['login'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['click'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['active_reg_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_role'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_role_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['ney_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_arpu'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['new_arppu'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['old_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['old_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['interval_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['interval_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['interval_pay_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap>-</td>
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
                            <td nowrap><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['date'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_admins']->value[$_smarty_tpl->tpl_vars['u']->value['create_user']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['parent_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['u']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['login'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_reg_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_role'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_role_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['ney_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_pay_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_arpu'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['new_arppu'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['old_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['old_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['interval_pay'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['interval_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['interval_pay_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td nowrap class="text-danger"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['total_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['create_time'], ENT_QUOTES, 'UTF-8');?>
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
            for (var i = 0; i < 6; i++) {
                w += e.eq(i).outerWidth();
            }

            trs.each(function (i) {
                if (left > w) {
                    $(this).children().eq(6).css({
                        "position": "relative",
                        "top": "0px",
                        "left": left - w,
                        "background": "#FFFF00"
                    });
                } else {
                    $(this).children().eq(6).removeAttr('style');
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

        $('select[name=game_id],select[name=channel_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&channel_id=' + channel_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
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