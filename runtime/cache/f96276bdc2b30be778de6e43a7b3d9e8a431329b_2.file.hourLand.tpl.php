<?php /* Smarty version 3.1.27, created on 2019-11-29 14:06:38
         compiled from "/home/vagrant/code/admin/web/admin/template/adDataAndorid/hourLand.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11762557285de0b56e970ca6_17165207%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f96276bdc2b30be778de6e43a7b3d9e8a431329b' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adDataAndorid/hourLand.tpl',
      1 => 1558417907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11762557285de0b56e970ca6_17165207',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'name' => 0,
    '_channels' => 0,
    'item' => 0,
    'id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0b56e9d2844_25692766',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0b56e9d2844_25692766')) {
function content_5de0b56e9d2844_25692766 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11762557285de0b56e970ca6_17165207';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adDataAndorid"/>
            <input type="hidden" name="ac" value="hourLand"/>
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择游戏包</label>
                <select name="package_name" id="package_id">
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['package_name'] == $_smarty_tpl->tpl_vars['name']->value['package_name']) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>选择渠道</label>
                <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal">点击选择</button>
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">渠道选择</h4>
                            </div>
                            <div class="modal-body">
                                <span style="display:inline-block;width:180px;margin-left: 20px;margin-bottom: 5px;">
                                <a href="javascript:" class="all_sel">全选</a>
                                <a href="javascript:" class="diff_sel">反选</a>
                                </span>
                                <br>
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
                                <span style="display:inline-block;width:180px;">
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="channel_id[]" <?php if (!$_smarty_tpl->tpl_vars['data']->value['channel_id']) {?> checked="checked" <?php } else { ?>
                                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['channel_id'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value == $_smarty_tpl->tpl_vars['id']->value) {?>
                                    checked="checked"
                                    <?php }?>
                                    <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                                    <?php }?>
                                    value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
&nbsp;
                                </label>
                                    </span>
                                <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>

                <label>日期</label>
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
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>时间段</td>
                        <td nowrap>包标识</td>
                        <td nowrap>链接</td>
                        <td nowrap>落地页模板</td>
                        <td nowrap>点击数</td>
                        <td nowrap>加载完成数</td>
                        <td nowrap>加载完成率</td>
                        <td nowrap>下载数</td>
                        <td nowrap>下载率</td>
                        <td nowrap>激活数</td>
                        <td nowrap>激活率</td>
                        <td nowrap>注册数</td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <a target="_blank" href="<?php echo htmlspecialchars(@constant('CDN_URL'), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['page_url'], ENT_QUOTES, 'UTF-8');?>
/index.html"><?php echo htmlspecialchars(@constant('CDN_URL'), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['page_url'], ENT_QUOTES, 'UTF-8');?>
/index.html</a>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['page_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['complete_load'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['complete_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['download'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['download_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['active_num'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['active_rate'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg'], ENT_QUOTES, 'UTF-8');?>
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
    $(function () {

        $('.all_sel').on('click', function () {
            $('input[name="channel_id[]"]').prop('checked', true);
        });

        $('.diff_sel').on('click', function () {
            $('input[name="channel_id[]"]').each(function () {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            });
        });
        $('#printExcel').click(function () {
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function () {
                channel_ids += 'channel_id[]=' + $(this).val() + '&';
            });
            location.href = '?ct=adDataAndorid&ac=hourLandExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + channel_ids + '&package_name=' + $('select[name=package_name]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val();
        });

        $('select[name=game_id]').on('change', function () {
            $.getJSON('?ct=data&ac=getMoneyLevel&game_id=' + $('select[name=game_id]').val(), function (re) {
                var html = '<option value="">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value=' + i + '>' + n + '</option>';
                });
                $('select[name="level_id"]').html(html);
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