<?php /* Smarty version 3.1.27, created on 2019-11-29 20:19:51
         compiled from "/home/vagrant/code/admin/web/admin/template/data/serverView.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:17573294175de10ce7477134_17841827%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b76923daa9648a07b14170b81e8efe6e7eefe35' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/serverView.tpl',
      1 => 1564974534,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17573294175de10ce7477134_17841827',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'type' => 0,
    'user_type' => 0,
    'show_type' => 0,
    'row' => 0,
    'date' => 0,
    'ser' => 0,
    'dateRow' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10ce7514e64_05661158',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10ce7514e64_05661158')) {
function content_5de10ce7514e64_05661158 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '17573294175de10ce7477134_17841827';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline" id="myForm">
            <input type="hidden" name="ct" value="data4"/>
            <input type="hidden" name="ac" value="serverView"/>
            <div class="form-group">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>平台：</label>
                <select name="device_type">
                    <option value="">请选择</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?> value="1">IOS</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?> value="2">安卓</option>
                </select>

                <label>区服：</label>
                <input type="number" style="width: 88px" name="server_start" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['server_start'], ENT_QUOTES, 'UTF-8');?>
" />
                <input type="number" style="width: 88px" name="server_end" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['server_end'], ENT_QUOTES, 'UTF-8');?>
" />

                <label>时间：</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <!--<label>统计方式：</label>
                <select name="type" class="type-select">
                    <option <?php if ($_smarty_tpl->tpl_vars['type']->value == 1) {?>selected="selected"<?php }?> value="1">按天统计</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['type']->value == 2) {?>selected="selected"<?php }?> value="2">累计统计</option>
                </select>-->
                <label>用户类型：</label>
                <select name="user_type" class="user-type" >
                    <option <?php if ($_smarty_tpl->tpl_vars['user_type']->value == 1) {?>selected="selected"<?php }?> value="1">总用户</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['user_type']->value == 2) {?>selected="selected"<?php }?> value="2">新老注册</option>
                </select>

                <label><input type="checkbox" class="show-type" name="show_type[]" value="1" style="position: relative;top: 2px;" <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(1,$_smarty_tpl->tpl_vars['show_type']->value)) {?>checked="checked"<?php }?>"> 充值人数</label>
                &nbsp;
                <label><input type="checkbox" class="show-type" name="show_type[]" value="2" style="position: relative;top: 2px;" <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(2,$_smarty_tpl->tpl_vars['show_type']->value)) {?>checked="checked"<?php }?>> 充值金额</label>
                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>

            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive" style="text-align: center">
                    <thead>
                    <tr>
                        <th>区服</th>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['server_list'];
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
                        <th colspan="<?php if ($_smarty_tpl->tpl_vars['user_type']->value == 1) {?>2<?php } else {
if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2) {?>4<?php } else { ?>2<?php }
}?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value, ENT_QUOTES, 'UTF-8');?>
服</th>
                        <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
                    </tr>
                    <tr>
                        <th>时间</th>
                        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['server_list'];
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
                        <?php if ($_smarty_tpl->tpl_vars['user_type']->value == 1) {?>
                        <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(1,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td>总充值人数</td><?php }?>
                        <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(2,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td>总充值金额</td><?php }?>
                        <?php } else { ?>
                        <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(1,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td>新充值人数</td><?php }?>
                        <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(2,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td>新充值金额</td><?php }?>
                        <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(1,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td>老充值人数</td><?php }?>
                        <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(2,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td>老充值金额</td><?php }?>
                        <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
                    </tr>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['data'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['dateRow'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['dateRow']->_loop = false;
$_smarty_tpl->tpl_vars['date'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['date']->value => $_smarty_tpl->tpl_vars['dateRow']->value) {
$_smarty_tpl->tpl_vars['dateRow']->_loop = true;
$foreach_dateRow_Sav = $_smarty_tpl->tpl_vars['dateRow'];
?>
                        <tr>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['date']->value, ENT_QUOTES, 'UTF-8');?>
</td>
                            <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['server_list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['ser'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['ser']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['ser']->value) {
$_smarty_tpl->tpl_vars['ser']->_loop = true;
$foreach_ser_Sav = $_smarty_tpl->tpl_vars['ser'];
?>
                            <?php if ($_smarty_tpl->tpl_vars['user_type']->value == 1) {?>
                                <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(1,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['dateRow']->value[$_smarty_tpl->tpl_vars['ser']->value][3]['total_pay_num'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</td><?php }?>
                                <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(2,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['dateRow']->value[$_smarty_tpl->tpl_vars['ser']->value][3]['total_pay_money'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</td><?php }?>
                             <?php } else { ?>
                                <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(1,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['dateRow']->value[$_smarty_tpl->tpl_vars['ser']->value][1]['pay_num'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</td><?php }?>
                                <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(2,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['dateRow']->value[$_smarty_tpl->tpl_vars['ser']->value][1]['pay_money'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</td><?php }?>
                                <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(1,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['dateRow']->value[$_smarty_tpl->tpl_vars['ser']->value][2]['pay_num'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</td><?php }?>
                                <?php if (count($_smarty_tpl->tpl_vars['show_type']->value) == 2 || in_array(2,$_smarty_tpl->tpl_vars['show_type']->value)) {?><td><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['dateRow']->value[$_smarty_tpl->tpl_vars['ser']->value][2]['pay_money'])===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</td><?php }?>
                            <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['ser'] = $foreach_ser_Sav;
}
?>
                        </tr>
                    <?php
$_smarty_tpl->tpl_vars['dateRow'] = $foreach_dateRow_Sav;
}
?>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div style="float: left;">
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
        $("#content-wrapper").scroll(function () {
            var left = $("#content-wrapper").scrollLeft() - 14;//获取滚动的距离
            var trs = $("#tableDiv table tr");//获取表格的所有tr
            if (left == -14) {
                left = 0;
            }
            trs.each(function (i) {
                if (left) {
                    $(this).children().eq(0).css({
                        "position": "relative",
                        "top": "0px",
                        "left": left,
                        "background": "#00FFFF"
                    });
                } else {
                    $(this).children().eq(0).removeAttr('style');
                }
            });
        });

        $('#printExcel').click(function () {
            location.href = '?ct=data&ac=overviewExcel&game_id=' + $('select[name=game_id]').val() + '&device_type=' + $('select[name=device_type]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val();
        });

        $(".show-type").on('click',function(){
            $("#myForm").submit();
        })
        $(".type-select").change(function(){
            $("#myForm").submit();
        })
        $(".user-type").change(function(){
            $("#myForm").submit();
        })
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>