<?php /* Smarty version 3.1.27, created on 2019-11-29 20:17:54
         compiled from "/home/vagrant/code/admin/web/admin/template/data/regHour.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:8975975835de10c725fac81_25231071%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f47a8e1f5838ef80b01f9f263c71f7190def236' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/regHour.tpl',
      1 => 1570801459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8975975835de10c725fac81_25231071',
  'variables' => 
  array (
    'widgets' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10c72635db0_89408674',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10c72635db0_89408674')) {
function content_5de10c72635db0_89408674 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8975975835de10c725fac81_25231071';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
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
                            <label>选择游戏</label>
                            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                            <label>选择平台</label>
                            <select name="platform">
                                <option value="">全 部</option>
                                <option value="1">IOS</option>
                                <option value="2">Andorid</option>
                            </select>

                            <lable>日期</lable>
                            <input type="text" name="date" value="" class="Wdate"/>
                            <button type="button" class="btn btn-primary btn-xs" id="submit"> 筛 选</button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows">
        <div id="container" style="min-width:400px;height:280px; background-color: #FFFFFF;"></div>
        <table id="LAY-table-report" lay-filter="report"></table>
    </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/highcharts/highcharts.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/highcharts/exporting.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/highcharts/highcharts-zh_CN.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/grid-light.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    layui.config({
        version: '2019031121',
    }).use('table', function () {
        var table = layui.table;
        var options = {
            elem: '#LAY-table-report',
            title: '每小时新增注册人数',
            data: [],
            cellMinWidth: 80,
            height: 'full-500',
            totalRow: true,
            toolbar: true,
            page: false,
            size: 'sm',
            cols: []
        };
        var tableIns = table.render(options);

        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled: false
            },
            title: {
                text: '每小时新增注册人数'
            },
            xAxis: {},
            yAxis: {
                title: {
                    text: '注册数'
                }
            },
            tooltip: {
                valueSuffix: '个注册'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: []
        });

        setTimeout(function () {
            getData();
        }, 100);

        //筛选
        $('#submit').on('click', function () {
            getData($('form').serialize());
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        function getData(data) {
            var index = layer.load();
            $.getJSON("/?ct=data1&ac=regHour&json=1", {
                data: data
            }, function (json) {
                var cols = [],
                    _cols = [
                        {field:'hour', width:80, title: '时间', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
                        {field:'total', width: 100, title: '汇总', align: 'center', sort: true, fixed: 'left', totalRow: true, style:'font-weight: bold;color: #a94442;'}
                    ];
                $.each(json.channels, function (field, title) {
                    _cols.push({field:'channel_' + field, title: title, align: 'center', sort: true, totalRow: true});
                });
                cols.push(_cols);

                if (json.data.length) {
                    tableIns.reload({
                        data: json.data,
                        cols: cols,
                        limit: json.data.length
                    });
                } else {
                    tableIns.reload({
                        data: [],
                        cols: [],
                        limit: 0
                    });
                }

                chart.setTitle({
                    text: json.date + '每小时新增注册人数'
                });
                chart.update({
                    xAxis: {
                        categories: json.day
                    }
                });

                while (chart.series.length > 0) {
                    chart.series[0].remove(false);
                }
                for (var i = 0; i < json.series.length; i++) {
                    chart.addSeries(json.series[i], false);
                }
                chart.redraw();

                $('input[name="date"]').val(json.date);
                layer.close(index);
            });
        }
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>