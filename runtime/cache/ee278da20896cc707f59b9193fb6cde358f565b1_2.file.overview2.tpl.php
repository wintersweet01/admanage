<?php /* Smarty version 3.1.27, created on 2019-11-29 20:18:11
         compiled from "/home/vagrant/code/admin/web/admin/template/data/overview2.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:17101598905de10c83bd6451_96372060%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee278da20896cc707f59b9193fb6cde358f565b1' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/overview2.tpl',
      1 => 1571045442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17101598905de10c83bd6451_96372060',
  'variables' => 
  array (
    'widgets' => 0,
    'day' => 0,
    'ltv_day' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10c83c0f610_63647799',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10c83c0f610_63647799')) {
function content_5de10c83c0f610_63647799 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '17101598905de10c83bd6451_96372060';
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
                        <div class="form-group form-group-sm">
                            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                            <label>平台</label>
                            <select class="form-control" name="device_type" style="width: 50px;">
                                <option value="">全 部</option>
                                <option value="1">ios</option>
                                <option value="2">安卓</option>
                            </select>

                            <label>时间</label>
                            <input type="text" name="sdate" value="" class="form-control Wdate"/> -
                            <input type="text" name="edate" value="" class="form-control Wdate"/>

                            <label>归类方式</label>
                            <select class="form-control" name="type">
                                <option value="8">按母游戏</option>
                                <option value="1">按子游戏</option>
                                <option value="2">按手机系统</option>
                                <option value="7" selected="selected">按注册日期</option>
                                <option value="9">按注册月份</option>
                                <option value="10">按注册周</option>
                            </select>

                            <button type="button" class="btn btn-primary btn-sm" id="submit"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
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
        var ltv_day = JSON.parse('<?php echo $_smarty_tpl->tpl_vars['ltv_day']->value;?>
');
        var table = layui.table;
        var cols = [];
        var header = [
            {title:'序号', type:'numbers', fixed: 'left'},
            {field:'group_name', minWidth:150, title: '名称', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
            {field:'active', width:80, title: '激活数', align: 'center', sort: true},
            {field:'active_device', width:120, title: '激活设备数', align: 'center', sort: true},
            {field:'reg_user', width: 100, title: '当天新增', align: 'center', sort: true},
            {field:'reg_device', width:100, title: '新增设备', align: 'center', sort: true},
            {field:'active_reg_rate', width:120, title: '激活注册率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'new_role', width:100, title: '新增创角', align: 'center', sort: true},
            {field:'new_role_rate', width:120, title: '创建率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'login_user', width:100, title: 'DAU', align: 'center', sort: true},
            {field:'old_user_active', width:120, title: '老用户活跃', align: 'center', sort: true},
            {field:'pay_user', width:100, title: '付费人数', align: 'center', sort: true},
            {field:'pay_rate', width:120, title: '付费率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'pay_money', width:100, title: '总充值', align: 'center', sort: true, style:'color:#a94442;'},
            {field:'arpu', width:100, title: 'ARPU', align: 'center', sort: true},
            {field:'arppu', width:100, title: 'ARPPU', align: 'center', sort: true},
            {field:'new_pay_user', width:120, title: '新增付费人数', align: 'center', sort: true},
            {field:'new_pay_rate', width:120, title: '新增付费率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'new_pay_money', width:120, title: '新增付费金额', align: 'center', sort: true, style:'color:#a94442;'},
            {field:'new_roi', width:100, title: '新增ROI', align: 'center', sort: true},
            {field:'new_arpu', width:120, title: '新增ARPU', align: 'center', sort: true},
            {field:'new_arppu', width:120, title: '新增ARPPU', align: 'center', sort: true},
            {field:'old_pay_user',width:150,title:'老用户付费人数',align:'center',sort:true},
            {field:'old_pay_money',width:120,title:'老用户总充值',align:'center',sort:true},
            {field:'old_pay_rate',width:150,title:'老用户付费率',align:'center',sotr:true},
            {field:'old_arpu',width:150,title:'老用户ARPU',align:'center',sort:true},
            {field:'old_arppu',width:150,title:'老用户ARPPU',align:'center',sort:true}
        ];

        $.each(day, function (i, d) {
            header.push({field:'retain_rate' + d, width:110, title: d + '日留存', align: 'center', sort: true, style:'color: #3d9970;'});
        });
        $.each(ltv_day, function (i,d){
            var land = {field:'ltv'+d,width:110,title:'LTV'+d,align:'center',sort:true,style:'color: #3d9970;'};
            header.push(land)
        });
        cols.push(header);

        var options = {
            elem: '#LAY-table-report',
            title: '基础数据',
            url: '/?ct=data4&ac=overview2&json=1',
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