<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:40
         compiled from "/home/vagrant/code/admin/web/admin/template/system/account.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:12706907365ddf91e0773ae9_23297161%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c69ebfbb1bb610c48f8c5275870f623bbf4e208d' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/system/account.tpl',
      1 => 1570801460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12706907365ddf91e0773ae9_23297161',
  'variables' => 
  array (
    'u' => 0,
    'limit_num' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91e07ab832_55174699',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91e07ab832_55174699')) {
function content_5ddf91e07ab832_55174699 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '12706907365ddf91e0773ae9_23297161';
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
                <a href="/?ct=system&ac=mediaAccountAdd" class="layui-btn layui-btn-warm layui-btn-sm"> <i
                            class="layui-icon">&#xe61f;</i><span>新增媒体账号</span></a>
                <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="balance_warn">
                    <i class="layui-icon">&#xe640;</i><span>设置余额警告</span>
                </button>
            </div>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" lay-filter="menu" id="toolbar-menu">
            {{# if(d.media && d.status == 0){ }}
            {{# if(d.refresh_token_expires_in > 0){ }}
            <span class="btn btn-success btn-xs refresh" lay-event="refresh" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
            {{# }else{ }}
            <span class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
            {{# } }}
            {{# }else{ }}
            <span class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-refresh" aria-hidden="true"><span> 刷新授权</span></span></span>
            {{# } }}
            <a href="/?ct=system&ac=mediaAccountAdd&account_id={{d.account_id}}" class="layui-btn layui-btn-xs"><i class="fa fa-pencil-square fa-fw"></i> 编辑</a>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" lay-filter="view" id="toolbar-view">
            <button class="btn btn-primary btn-xs" lay-event="view_all">查看</button>
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/html" id="view-message">
            <button class="layui-btn layui-btn-danger layui-btn-xs"><i class="fa fa-info" aria-hidden="true"></i>详情</button>
        <?php echo '</script'; ?>
>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="margin-top: 15%">
        <div class="modal-content" style="width: 350px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">信息确认</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="modal_form" class="form-horizontal">
                    <input type="hidden" name="account_id" value="" />
                    <div class="form-group" style="margin: 0 auto">
                        <label for="group_add" style="width: 100%;">请求人媒体账号<span class="account_name"></span>在当前浏览器已经登录<span class="media_name"></span>投放后台，然后点击确认前往授权页面进行授权</label>
                    </div>
                    <div class="">
                        <span>授权广告主ID：</span>
                        <input type="text" name="advertiser_id" value="" class="form-control input-width" autocomplete="off" />
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default commit-cancel" data-dismiss="modal">取 消</button>
                <button type="button" class="btn btn-primary commit-add">确 认</button>
            </div>
        </div>
    </div>
</div>


<?php echo '<script'; ?>
>
    $(function () {
        $('.Wdate').off();
        $('.Wdate').on('click focus', function () {
            WdatePicker({el:this, dateFmt:"yyyy-MM-dd"});
        });
    });
    layui.config({
        version: '2019031310',
    }).use('table', function () {
        var table = layui.table;
        var limit = '<?php echo $_smarty_tpl->tpl_vars['limit_num']->value;?>
';
        var cols = [[
            {type:'checkbox'},
            {field:'media_name',title:'媒体',align:'center',width:120},
            {field:'account',title:'媒体账号',align:'center',width:150},
            {field:'account_nickname',title:'媒体账号别名',align:'center',width:150},
            {
                field:'advertiser_id',
                title:'广告主ID',
                align:'center',
                width:180,
                templet:function(e){
                    if(!e.advertiser_id){
                        return '<span class="text-red">未授权</span>';
                    }else{
                        return e.advertiser_id;
                    }
                }
            },
            {
                field:'balance_warn',
                title:'账户余额告警线',
                align:'center',
                width:150,
                edit:true,
                templet:function(e){
                    if(e.balance_warn != 0) {
                        return '<span class="text-red">' + e.balance_warn + '</span>'
                    }else{
                        return '--';
                    }
                }
            },
            {
                field:'day_cost',
                title:'今日消耗',
                align:'center',
                width:120,
                templet:function(e){
                    if(e.day_cost != 0){
                        return e.day_cost
                    }else{
                        return '--';
                    }
                }
            },
            {title:'权限',align:'center',toolbar:'#toolbar-view',width:80},
            {
                field:'status_info',
                title:'状态',
                align:'center',
                width:120,
                templet:function(e){
                    if(e.status == 0){
                        return '<span class="text-green">正常</span>';
                    }else{
                        return '<span class="text-red">禁用</span>';
                    }
                }
            },
            {title:'操作',align:'left',toolbar:'#toolbar-menu'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '新增玩家数据',
            url: '/?ct=system&ac=mediaAccountManage&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            page: true,
            limit: limit,
            totalRow: false,
            defaultToolbar:[],//'exports','print'
            cols: cols,
            toolbar: '#toolbar-report',
            done: function (res, curr, count) {
                var query = res.query;
                if(query.is_run == 1){
                    $("input[name=is_run]").prop('checked',true);
                }else{
                    $("input[name=is_run]").prop('checked',false);
                }

                $("input[name=account]").val(query.account);
            }
        };

        var tableIns = table.render(options);
        //筛选
        $('#submit').on('click', function () {
            queryList();
        });
        $("input[name=is_run]").change(function(){
            queryList();
        });
        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });
        table.on('toolbar(report)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;
            var event = obj.event;
            var ids = [];
            $.each(data, function (i, m) {
                if(typeof m.account_id != 'undefined') {
                    ids.push(m.account_id);
                }
            });
            switch (event) {
                case 'batch_del':
                    layer.confirm('确认删除？', function () {
                        layer.closeAll();
                        if (ids.length == 0) {
                            layer.msg('请勾选一个以上');
                            return false;
                        }
                        $.post('?ct=adApp&ac=delAdvertiser',{
                            'ids':ids
                        }, function (e) {
                            var et = JSON.parse(e);
                            if (et.state == 1) {
                                layer.msg('删除成功',{time:1000});
                                table.reload('LAY-table-report');
                            } else {
                                layer.msg('删除失败',{time:1000});
                            }
                        })
                    });
                    break;
                case 'balance_warn':
                    if(ids.length == 0 && typeof ids != 'undefined'){
                        layer.msg('请勾选需要设置的列！',{time:1000});
                        return false;
                    }
                    layer.open({
                        type:2,
                        title:'批量修改余额预警线',
                        shadeClose:false,
                        shade:0.8,
                        area:is_mobile?['100%','100%']:['35%','60%'],
                        content:'/?ct=system&ac=balanceWarnAddBatch&account_ids='+ids
                    });
                    break;
                default:
                    break;
            }
        });

        table.on('tool(report)',function(obj){
            var event = obj.event;
            var data = obj.data;

            switch (event) {
                case 'refresh':
                    //刷新授权
                    if(!data){
                        layer.msg('刷新授权失败！',{time:1000});
                        return false;
                    }
                    var tip = layer.confirm('确认刷新授权？',function(){
                        layer.close(tip);
                        $.post('/?ct=system&ac=refreshToken',{data:data},function(re){
                            re = JSON.parse(re);
                            if(re.state == 1){
                                layer.msg('刷新成功',{time:1000});
                                table.reload();
                            }else{
                                layer.msg(re.msg,{time:1000});
                                return false;
                            }
                        });
                    });
                    break;
                case 'reauthorize':
                    $(".account_name").html(data.account);
                    $(".media_name").html(data.media_name);
                    $("input[name=account_id]").val(data.account_id);
                    $("#myModal").modal({backdrop: 'static', keyboard: false});
                    break;
                case 'view_all':
                    if(typeof data != 'object'){
                        layer.msg('获取失败',{time:1000});
                        return false;
                    }
                    $.post('/?ct=system&ac=viewAccountPower',{data:data},function(e){
                        if(e.state == 1){
                            var data = e.data;
                            var apps = '<p><label>投放应用：</label></p>';
                            var mana = '<p><label>负责人：</label></p>';
                            for(var i in data.app){
                                apps += '<p>'+data.app[i]+'</p>';
                            }
                            for(var j in data.manager){
                                mana += '<p>'+data.manager[j]+'</p>'
                            }
                            var content = apps+'<br/>'+mana;
                            layer.open({
                                title:'账号权限信息',
                                content:content
                            })
                        }
                    },'json');
                    break;
            }
        });
        table.on('edit(report)',function(obj){
            var val = obj.value,
                field = obj.field;

            if (!$.isNumeric(val)) {
                $(this).val(0);
                return false;
            }
            $.post('?ct=system&ac=editBalanceWarn', {
                field: field,
                value: val,
                data: obj.data
            }, function (re) {
                if (re.state == false) {
                    layer.msg(re.msg);
                }else{
                    tableIns.reload();
                }
            }, 'json');
        });

        $(".commit-add").on('click',function(){
            var data = $("#modal_form").serialize();
            if(!data){
                return false;
            }
            if(!$("input[name=advertiser_id]").val()){
                layer.msg('请填写广告主ID',{time:1000});
                return false;
            }
            $.post('/?ct=system&ac=reauthorize',{data:data},function(e){
                if(e.state == 1){
                    var res = e.data;
                    window.open(res.url);
                }else{
                    layer.msg('重新授权失败',{time:1000});
                }
            },'json')
        });
        $(".commit-cancel").on('click',function(){
            $("input[name=advertiser_id]").val('');
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });
        function queryList(){
            tableIns.reload({
                where: {
                    data: $('form').serialize()
                },
                page: {
                    curr: 1
                }
            });
        }
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>