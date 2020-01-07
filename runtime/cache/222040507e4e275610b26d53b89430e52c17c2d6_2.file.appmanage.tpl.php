<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:42
         compiled from "/home/vagrant/code/admin/web/admin/template/system/appmanage.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13455546805ddf91e221bb12_53020291%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '222040507e4e275610b26d53b89430e52c17c2d6' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/system/appmanage.tpl',
      1 => 1570801460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13455546805ddf91e221bb12_53020291',
  'variables' => 
  array (
    'limit_num' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91e224ed98_85072766',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91e224ed98_85072766')) {
function content_5ddf91e224ed98_85072766 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13455546805ddf91e221bb12_53020291';
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
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-table-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1">
                    <form class="form-inline navbar-form navbar-left" method="get" action="">
                        <div class="form-group">
                            <label><input type="checkbox" name="is_run" value="1" style="position: relative;top: 1px;">仅有效应用</label>
                            <label>应用名称:</label>
                            <input type="text" name="account" value="">
                            <button type="button" class="btn btn-primary btn-xs" id="submit">筛 选</button>
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
                <a href="/?ct=system&ac=appAdd" class="layui-btn layui-btn-warm layui-btn-sm"> <i
                            class="layui-icon">&#xe61f;</i><span>新增应用</span></a>
            </div>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-view">
            <div class="layui-btn-container">
                <a href="#" class="btn btn-primary btn-xs">查看</a>
            </div>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-menu">
            <div class="layui-btn-container">
                <a href="/?ct=system&ac=appAdd&appid={{d.appid}}" type="button" class="btn btn-success btn-xs">修改</a>
            </div>
        <?php echo '</script'; ?>
>
    </div>
</div>
<?php echo '<script'; ?>
>
    layui.config({
        version:'2019031301',
    }).use('table',function(){
        var table = layui.table;
        var limit = '<?php echo $_smarty_tpl->tpl_vars['limit_num']->value;?>
';
        var cols = [];
        var header = [
            {field:'app_name',title:'应用名称',align:'center'},
            {field:'app_code',title:'应用编码',align:'center'},
            {field:'device_type_name',title:'应用类型',align:'center'},
            {title:'投放媒体账号',align:'center',toolbar:'#toolbar-view'},
            {
                field:'status_info',
                align:'center',
                title:'状态',
                templet:function(e){
                    if(e.status == 0){
                        return '<span class="text-green">'+e.status_info+'</span>';
                    }else{
                        return '<span class="text-red">'+e.status_info+'</span>'
                    }
                }
            },
            {title:'操作',align:'left',toolbar:'#toolbar-menu'}
        ];

        cols.push(header);
        var option = {
            elem:'#LAY-table-report',
            title:'应用列表',
            url:'/?ct=system&ac=appManage&json=1',
            cellMinWidth:80,
            height:'full-200',
            page:true,
            limit:limit,
            totalRow:false,
            defaultToolbar:[],
            cols:cols,
            toolbar:'#toolbar-report',
            done:function(res,curr,count){

            }
        };
        var tableIns = table.render(option);
        $('#submit').on('click',function(){
            queryList(tableIns);
        });
        $("input[name=is_run]").change(function(){
            queryList(tableIns);
        })
    });
    function queryList(tableObj){
        tableObj.reload({
            where:{
                data:$("form").serialize()
            },
            page:{
                curr:1
            }
        })
    }
<?php echo '</script'; ?>
><?php }
}
?>