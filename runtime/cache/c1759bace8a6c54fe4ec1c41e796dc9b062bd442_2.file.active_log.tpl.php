<?php /* Smarty version 3.1.27, created on 2019-12-12 20:00:23
         compiled from "/home/vagrant/code/admin/web/admin/template/service/active_log.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7694483635df22bd7e2d548_12183471%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1759bace8a6c54fe4ec1c41e796dc9b062bd442' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/service/active_log.tpl',
      1 => 1571046109,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7694483635df22bd7e2d548_12183471',
  'variables' => 
  array (
    'data' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5df22bd7e965e7_44909779',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5df22bd7e965e7_44909779')) {
function content_5df22bd7e965e7_44909779 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '7694483635df22bd7e2d548_12183471';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="service"/>
            <input type="hidden" name="ac" value="activeLog"/>
            <div class="form-group form-group-sm">
                <label>激活时间</label>
                <input type="text" name="date" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['date'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;"/>
                <label>设备号<i class="fa fa-question-circle" alt="IMEI或者IDFA"></i></label>
                <input type="text" class="form-control" name="device_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['device_id'], ENT_QUOTES, 'UTF-8');?>
" style="width: 250px;"/>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏</th>
                        <th nowrap>平台</th>
                        <th nowrap>包版本</th>
                        <th nowrap>SDK版本</th>
                        <th nowrap>激活地区</th>
                        <th nowrap>激活IP</th>
                        <th nowrap>激活时间</th>
                        <th nowrap>设备名称</th>
                        <th nowrap>设备版本</th>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['parent_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 1) {?><span class="icon_ios"></span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 2) {?><span class="icon_android"></span>
                                <?php } else { ?>-<?php }?>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['sdk_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_city'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['active_ip'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['active_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['device_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['device_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
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
    $(function () {

    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>