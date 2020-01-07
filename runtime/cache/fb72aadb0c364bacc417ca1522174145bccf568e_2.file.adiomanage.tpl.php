<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:38
         compiled from "/home/vagrant/code/admin/web/admin/template/system/adiomanage.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:12050993185ddf91de178ac0_67109684%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb72aadb0c364bacc417ca1522174145bccf568e' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/system/adiomanage.tpl',
      1 => 1570801459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12050993185ddf91de178ac0_67109684',
  'variables' => 
  array (
    'limit_num' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91de1b2084_32646079',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91de1b2084_32646079')) {
function content_5ddf91de1b2084_32646079 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '12050993185ddf91de178ac0_67109684';
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
                            <label><input type="checkbox" name="is_run" value="1" style="position: relative;top: 1px;">仅有效媒体账号</label>
                            <label>媒体账号:</label>
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
                <a href="/?ct=system&ac=adioAdd" class="layui-btn layui-btn-warm layui-btn-sm"> <i
                            class="layui-icon">&#xe61f;</i><span>新增ADIO账号</span></a>
            </div>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" lay-filter="menu" id="toolbar-menu">
            <a href="/?ct=system&ac=adioAdd&id={{d.id}}" class="btn btn-success btn-xs">修改</a>
            <button class="btn btn-warning btn-xs">重置密码</button>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-view">
            <button class="btn btn-primary btn-xs" lay-event="view_all">查看</button>
        <?php echo '</script'; ?>
>
    </div>
</div>
<?php echo '<script'; ?>
>
    layui.config({
        version: '2019031310',
    }).use('table', function () {
        var table = layui.table;
        var limit = '<?php echo $_smarty_tpl->tpl_vars['limit_num']->value;?>
';
        var cols = [];
        var header = [
            {field:'email',title:'邮箱账号',align:'center',width:300},
            {field:'nickname',title:'别名',align:'center',width:180},
            {field:'group_name',title:'分组',align:'center',width:180},
            {title:'媒体账号权限',align:'center',toolbar:'#toolbar-view',width:120},
            {
                field:'status_info',
                title:'状态',
                align:'center',
                width:120,
                templet:function(e){
                    if(e.status == 0){
                        return '<span class="text-green">'+e.status_info+'</span>';
                    }else{
                        return '<span class="text-red">'+e.status_info+'</span>';
                    }
                }
            },
            {title:'操作',align:'left',toolbar:'#toolbar-menu'}
        ];
        cols.push(header);
        var options = {
            elem:'#LAY-table-report',
            title:'ADIO数据管理',
            url:'/?ct=system&ac=adioManage&json=1',
            cellMinWidth:80,
            height:'full-200',
            page:true,
            limit:limit,
            totalRow:false,
            defaultToolbar:[],
            cols:cols,
            toolbar:'#toolbar-report',
            done:function(res,curr,count){
                console.log(res);
            }
        };
        var tableIns = table.render(options);

        table.on('tool(report)',function(obj){
            console.log(obj);
        })
    })
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>