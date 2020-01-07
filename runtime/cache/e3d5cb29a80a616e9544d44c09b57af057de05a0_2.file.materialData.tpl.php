<?php /* Smarty version 3.1.27, created on 2019-11-28 20:27:03
         compiled from "/home/vagrant/code/admin/web/admin/template/material/materialData.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3931008725ddfbd17544f11_58754905%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3d5cb29a80a616e9544d44c09b57af057de05a0' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/material/materialData.tpl',
      1 => 1571043163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3931008725ddfbd17544f11_58754905',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    '_admins' => 0,
    'key' => 0,
    'name' => 0,
    'u' => 0,
    '_games' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddfbd1759ae25_50866831',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddfbd1759ae25_50866831')) {
function content_5ddfbd1759ae25_50866831 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3931008725ddfbd17544f11_58754905';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="material"/>
            <input type="hidden" name="ac" value="materialData"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>

                <label>搜索上传人</label>
                <select class="form-control" name="upload_user">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_admins']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['upload_user'] == $_smarty_tpl->tpl_vars['key']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>时间</label>
                <input type="text" class="form-control Wdate" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" style="width: 100px;"/> -
                <input type="text" class="form-control Wdate" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" style="width: 100px;"/>

                <label>充值时间</label>
                <input type="text" class="form-control Wdate" name="psdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['psdate'], ENT_QUOTES, 'UTF-8');?>
" style="width: 100px;"/> -
                <input type="text" class="form-control Wdate" name="pedate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pedate'], ENT_QUOTES, 'UTF-8');?>
" style="width: 100px;"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; ">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;" class=table-responsive">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <td nowrap>测试素材名</td>
                        <td nowrap>测试游戏</td>
                        <td nowrap>上传人</td>
                        <td nowrap>测试时间区间</td>
                        <td nowrap>测试关联包名/推广活动</td>
                        <td nowrap>展现</td>
                        <td nowrap>点击</td>
                        <td nowrap>点击率</td>
                        <td nowrap>消耗</td>
                        <td nowrap>注册数</td>
                        <td nowrap>注册率</td>
                        <td nowrap>注册成本</td>
                        <td nowrap>留存数</td>
                        <td nowrap>留存率</td>
                        <td nowrap>留存成本</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>付费率</td>
                        <td nowrap>付费金额</td>
                        <td nowrap>ROI</td>
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
                            <td><a href="?ct=material&ac=materialBox&material_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_name'], ENT_QUOTES, 'UTF-8');?>
</a></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['upload_user'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['time_zone'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap style="text-align: left;">
                                <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['land_list'][$_smarty_tpl->tpl_vars['u']->value['material_id']];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
                                <span class="text-danger"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</span> / <span
                                    class="text-olive"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['monitor_name'], ENT_QUOTES, 'UTF-8');?>
</span><br>
                                <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['display'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['click_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['count_pay'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['pay_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-danger"><b>￥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['ROI'], ENT_QUOTES, 'UTF-8');?>
</b></td>
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
    $(function () {
        $('#printExcel').click(function () {
            location.href = '?ct=material&ac=materialDataExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + '&device_type=' + $('select[name=device_type]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val() + '&sdate=' + $('input[name=psdate]').val() + '&edate=' + $('input[name=pedate]').val();
        });

        $('select[name=game_id],select[name=channel_id]').on('change', function () {
            $.getJSON('?ct=ad&ac=getAllMonitor&game_id=' + $('select[name=game_id]').val() + '&channel_id=' + $('select[name=channel_id]').val(), function (re) {
                var html = '<option value="">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value=' + i + '>' + n + '</option>';
                });
                $('select[name="monitor_id"]').html(html);
            });
        });
        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id, function (re) {
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