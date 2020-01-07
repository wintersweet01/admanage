<?php /* Smarty version 3.1.27, created on 2019-11-29 20:20:27
         compiled from "/home/vagrant/code/admin/web/admin/template/retain/payRetain.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6906492815de10d0b030b85_32721811%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c057f2a4ee0124e5c306269a2f77308cbe3151a7' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/retain/payRetain.tpl',
      1 => 1570801460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6906492815de10d0b030b85_32721811',
  'variables' => 
  array (
    'widgets' => 0,
    'day' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10d0b062ba8_90417877',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10d0b062ba8_90417877')) {
function content_5de10d0b062ba8_90417877 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6906492815de10d0b030b85_32721811';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
<style type="text/css">
    .table-header .navbar {
        margin-bottom: 0px;
    }

    .table-header .navbar-collapse {
        position: unset !important;
        background-color: unset !important;
        z-index: unset !important;
    }

    .table-header .form-group {
        margin-bottom: 15px;
    }

    .select2-container .select2-selection--multiple {
        min-height: 22px !important;
        margin-bottom: 5px;
    }
</style>
<div id="areascontent">
    <div class="rows table-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-table-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1">
                    <form class="form-inline navbar-form navbar-left" method="get" action="">
                        <div class="form-group">
                            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                            <label>平台</label>
                            <select name="device_type" style="width: 50px;">
                                <option value="">全 部</option>
                                <option value="1">ios</option>
                                <option value="2">安卓</option>
                            </select>

                            <label>时间</label>
                            <input type="text" name="sdate" value="" class="Wdate"/> -
                            <input type="text" name="edate" value="" class="Wdate"/>

                            <button type="button" class="btn btn-primary btn-xs" id="submit">筛 选</button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows">
        <table id="LAY-table-report" lay-filter="report"></table>
    </div>
</div>
<?php echo '<script'; ?>
>
    layui.config({
        version: '2019041216',
    }).use('table', function () {
        var day = JSON.parse('<?php echo $_smarty_tpl->tpl_vars['day']->value;?>
');
        var table = layui.table;
        var cols = [];
        var header = [
            {field:'date', width:120, title: '日期', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
            {field:'reg_count', width:100, title: '注册数', align: 'center', sort: true},
            {field:'pay_count', width: 100, title: '付费人数', align: 'center', sort: true},
        ];

        $.each(day, function (i, d) {
            header.push({field:'retain_rate' + d, width:110, title: d + '日留存', align: 'center', sort: true, style:'color: #3d9970;'});
        });
        cols.push(header);

        var options = {
            elem: '#LAY-table-report',
            title: '付费留存',
            url: '/?ct=retainData&ac=payRetain&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            page: false,
            totalRow: true,
            toolbar: true,
            cols: cols,
            done: function (res, curr, count) {
                var query = res.query;
                $('input[name="sdate"]').val(query.sdate);
                $('input[name="edate"]').val(query.edate);
            }
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            tableIns.reload({
                cols: cols,
                where: {
                    data: $('form').serialize()
                }
            });
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>