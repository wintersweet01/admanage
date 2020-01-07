<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:26
         compiled from "/home/vagrant/code/admin/web/admin/template/data/roi.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11559551395ddf91d2a2fd63_32523431%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95207beb2c35c2c29a5578a9e68b435df455b1b7' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/roi.tpl',
      1 => 1570801459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11559551395ddf91d2a2fd63_32523431',
  'variables' => 
  array (
    'widgets' => 0,
    'day' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91d2a66aa9_08637007',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91d2a66aa9_08637007')) {
function content_5ddf91d2a66aa9_08637007 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11559551395ddf91d2a2fd63_32523431';
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

                            <label>归类方式</label>
                            <select name="type">
                                <option value="8">按母游戏</option>
                                <option value="1">按子游戏</option>
                                <option value="2">按手机系统</option>
                                <option value="7">按注册日期</option>
                                <option value="9">按注册月份</option>
                                <option value="10">按注册周</option>
                            </select>

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
 type="text/html" id="sexTpl">
    {{# if(d){ }}
        {{#  if(d.ky <= 0 ){ }}
        <span class="text-green" ">{{ d.revenue }}</span>
        {{#  } else if(d.revenue) { }}
        <span class="text-red" ">+{{ d.revenue }}</span>
        {{#  } }}
    {{# } }}
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    layui.config({
        version: '2019042618',
    }).use('table', function () {
        var day = JSON.parse('<?php echo $_smarty_tpl->tpl_vars['day']->value;?>
');
        var table = layui.table;
        var cols = [];
        var header = [
            {field: 'group_name', minWidth:150, title: '名称', align: 'center', sort: true, rowspan: 2, fixed: 'left', totalRowText: '合计'},
            {field:'cost', width:120, title: '消耗', align: 'center', sort: true, style:'color:#a94442;'},
            {field:'money', width:120, title: '营收', align: 'center', sort: true},
            {
                field:'revenue',
                width: 120,
                title: '盈亏',
                align: 'center',
                sort: true,
                templet: '#sexTpl',
            },
            {field:'re_roi', width: 120, title: '累计ROI', align: 'center', sort: true},
            {field:'reg', width: 100, title: '注册数', align: 'center', sort: true},
            {field:'reg_cost', width: 120, title: '注册成本', align: 'center', sort: true},

        ];

        $.each(day, function (i, d) {
            header.push({field:'roi' + d, width:110, title: 'ROI' + d, align: 'center', sort: true, style:'color: #3d9970;'});
        });
        cols.push(header);
        var options = {
            elem: '#LAY-table-report',
            title: '基础数据',
            url: '/?ct=data&ac=roi&json=1',
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