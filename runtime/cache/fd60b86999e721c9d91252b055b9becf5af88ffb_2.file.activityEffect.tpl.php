<?php /* Smarty version 3.1.27, created on 2019-11-29 14:06:34
         compiled from "/home/vagrant/code/admin/web/admin/template/adDataAndorid/activityEffect.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13875342075de0b56aabd4e7_95100759%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd60b86999e721c9d91252b055b9becf5af88ffb' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adDataAndorid/activityEffect.tpl',
      1 => 1552979302,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13875342075de0b56aabd4e7_95100759',
  'variables' => 
  array (
    'widgets' => 0,
    '_channels' => 0,
    'data' => 0,
    'item' => 0,
    'id' => 0,
    'name' => 0,
    '_admins' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0b56ab44735_23158633',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0b56ab44735_23158633')) {
function content_5de0b56ab44735_23158633 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13875342075de0b56aabd4e7_95100759';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style>
    th.sorted.ascending:after {
        content: "  \2191";
    }

    th.sorted.descending:after {
        content: " \2193";
    }

    table th {
        cursor: pointer;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adDataAndorid"/>
            <input type="hidden" name="ac" value="activityEffect"/>
            <div class="form-group">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择渠道</label>
                <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal">点击选择
                </button>
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
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
$_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$_smarty_tpl->tpl_vars['item']->iteration++;
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
                <label>注册时间</label>
                <input type="text" name="rsdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg_sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="redate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['reg_edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <label>付款时间</label>
                <input type="text" name="psdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pay_sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> -
                <input type="text" name="pedate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pay_edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>
                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th class="no-sort" nowrap>序号</th>
                        <th class="no-sort" nowrap>负责人</th>
                        <th class="no-sort" nowrap>游戏名称</th>
                        <th class="no-sort" nowrap>渠道</th>
                        <th class="no-sort" nowrap>投放账户</th>
                        <th class="no-sort" nowrap>推广活动</th>
                        <th class="no-sort" nowrap>包标识</th>
                        <th nowrap>消耗</th>
                        <th nowrap>展示</th>
                        <th nowrap>点击</th>
                        <th nowrap>注册</th>
                        <th nowrap>注册成本</th>
                        <th nowrap>次日留存数</th>
                        <th nowrap>留存率</th>
                        <th nowrap>留存成本</th>
                        <th nowrap>总充值</th>
                        <th nowrap>付费人数</th>
                        <th nowrap>付费率</th>
                        <th nowrap>付款成本</th>
                        <th nowrap>付费金额</th>
                        <th nowrap>ROI</th>
                        <th nowrap>ARPU</th>
                        <th nowrap>ARPPU</th>
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
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['cost'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['display'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_cost'], ENT_QUOTES, 'UTF-8');?>
">
                            <b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-olive" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate'], ENT_QUOTES, 'UTF-8');?>
">
                            <b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_cost'], ENT_QUOTES, 'UTF-8');?>
">
                            <b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_money'], ENT_QUOTES, 'UTF-8');?>
">
                            <b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['total_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_count'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td class="text-olive" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_rate'], ENT_QUOTES, 'UTF-8');?>
">
                            <b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_cost'], ENT_QUOTES, 'UTF-8');?>
">
                            <b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_money'], ENT_QUOTES, 'UTF-8');?>
">
                            <b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['pay_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-olive" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['roi'], ENT_QUOTES, 'UTF-8');?>
"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['roi'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['arpu'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['arpu'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['arppu'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total']['arppu'], ENT_QUOTES, 'UTF-8');?>
</b>
                        </td>
                    </tr>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$_smarty_tpl->tpl_vars['item']->iteration++;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                        <tr>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->iteration, ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_admins']->value[$_smarty_tpl->tpl_vars['item']->value['create_user']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['item']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['item']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['monitor_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['cost'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['display'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['click'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg_cost'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['reg_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain_rate'], ENT_QUOTES, 'UTF-8');?>
"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain_rate'], ENT_QUOTES, 'UTF-8');?>
%</b>
                            </td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain_cost'], ENT_QUOTES, 'UTF-8');?>
">
                                <b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['retain_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['total_money'], ENT_QUOTES, 'UTF-8');?>
">
                                <b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['total_money'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_count'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-olive" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_rate'], ENT_QUOTES, 'UTF-8');?>
"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_rate'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_cost'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_cost'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_money'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['pay_money'], ENT_QUOTES, 'UTF-8');?>
</b>
                            </td>
                            <td class="text-olive" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['roi'], ENT_QUOTES, 'UTF-8');?>
"><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['roi'], ENT_QUOTES, 'UTF-8');?>
%</b></td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['arpu'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['arpu'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                            <td class="text-danger" data-sort-value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['arppu'], ENT_QUOTES, 'UTF-8');?>
"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['arppu'], ENT_QUOTES, 'UTF-8');?>
</b></td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/jquery/jquery.tablesort.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function () {
        $.tablesort.defaults = {
            asc: 'sorted ascending',		// CSS classes added to `<th>` elements on sort.
            desc: 'sorted descending',
            compare: function (a, b) {
                // Function used to compare values when sorting.
                a = parseFloat(a);
                b = parseFloat(b);
                if (a > b) {
                    return 1;
                } else if (a < b) {
                    return -1;
                } else {
                    return 0;
                }
            }
        };
        $('table').tablesort();

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
            location.href = '?ct=adDataAndorid&ac=activityEffectExcel&game_id=' + $('select[name=game_id]').val() + channel_ids + 'rsdate=' + $('input[name=rsdate]').val() + '&redate=' + $('input[name=redate]').val() + '&psdate=' + $('input[name=psdate]').val() + '&pedate=' + $('input[name=pedate]').val();
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>