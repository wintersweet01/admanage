<?php /* Smarty version 3.1.27, created on 2019-11-29 11:10:46
         compiled from "/home/vagrant/code/admin/web/admin/template/extend/asoDiscount.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13841946975de08c36071084_15562448%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '666c3c3c61e09eaf17dbaf154186022c8b1c2c3b' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/extend/asoDiscount.tpl',
      1 => 1571041782,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13841946975de08c36071084_15562448',
  'variables' => 
  array (
    'widgets' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08c360ab6c9_60414971',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08c360ab6c9_60414971')) {
function content_5de08c360ab6c9_60414971 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13841946975de08c36071084_15562448';
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


                            <button type="button" class="btn btn-primary btn-sm" id="submit">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                            </button>
                            <a href="?ct=extend&ac=asoDiscountAdd" class="btn btn-danger btn-sm" role="button">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加扣量
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows">
        <table id="LAY-table-report" lay-filter="report"></table>
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-report">
            <div class="layui-btn-container">
                <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">
                    <i class="layui-icon">&#xe640;</i><span>删除所选</span>
                </button>
            </div>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-menu">
            <a href="/?ct=extend&ac=asoDiscountAdd&game_id={{d.game_id}}" class="layui-btn layui-btn-xs"><i class="fa fa-pencil-square fa-fw"></i>编辑</a>
        <?php echo '</script'; ?>
>
    </div>
</div>
<?php echo '<script'; ?>
>
    layui.config({
        version: '2019021310',
    }).use('table', function () {
        var table = layui.table;
        var cols = [[
            {type: 'checkbox'},
            {field:'parent_name', width:100, title: '母游戏', align: 'center'},
            {field:'game_name', width:150, title: '游戏名称', align: 'center'},
            {
                field: 'is_open',
                width: 60,
                title: '投放',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.is_open == '1') {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    }
                    return str;
                }
            },
            {
                field: 'is_discount',
                width: 60,
                title: '扣量',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.is_discount == '1') {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    }
                    return str;
                }
            },
            {field:'discount_pay', width:90, title: '充值扣量', align: 'center'},
            {field:'discount_reg', width:90, title: '注册扣量', align: 'center'},
            {field:'open_sdate', width:120, title: '投放开始日期', align: 'center'},
            {field:'open_edate', width:120, title: '投放结束日期', align: 'center'},
            {field:'discount_sdate', width:120, title: '折扣开始日期', align: 'center'},
            {field:'discount_edate', width:120, title: '折扣结束日期', align: 'center'},
            {
                field: 'is_discount',
                width: 60,
                title: '更新',
                align: 'center',
                templet: function (d) {
                    var str = '<i class="fa fa-close text-danger fa-lg"></i>';
                    if (d.update_text) {
                        str = '<i class="fa fa-check text-success fa-lg"></i>';
                    }
                    return str;
                }
            },
            {minWidth:100, title: '操作', align: 'center', fixed: 'right', toolbar: '#toolbar-menu'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '推广链扣量管理',
            toolbar: '#toolbar-report',
            url: '/?ct=extend&ac=asoDiscount&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            totalRow: true,
            page: true,
            limit: 15,
            cols: cols
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            tableIns.reload({
                where: {
                    data: $('form').serialize()
                },
                page: {
                    curr: 1
                }
            });
        });

        //监听头工具栏事件
        table.on('toolbar(report)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'del':
                    var data = checkStatus.data;
                    var ids = [];

                    if (data.length == 0) {
                        layer.msg('请勾选一个以上');
                        return false;
                    }

                    $.each(data, function (i, n) {
                        if (n.game_id == 0) return true;
                        ids.push(n.game_id);
                    });

                    if (ids.length <= 0) {
                        return false;
                    }

                    layer.confirm('删除后无法恢复，确定删除吗？', {
                        btn: ['是的', '取消']
                    }, function () {
                        var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                        $.post('?ct=extend&ac=asoDiscountDel', {
                            id: ids.join()
                        }, function (re) {
                            layer.close(index);
                            if (re.state == true) {
                                tableIns.reload();
                            } else {
                                layer.msg(re.msg);
                            }
                        }, 'json');
                    });
                    break;
            }
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