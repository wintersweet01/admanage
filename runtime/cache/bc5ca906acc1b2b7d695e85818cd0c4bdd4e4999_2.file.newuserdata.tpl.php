<?php /* Smarty version 3.1.27, created on 2019-11-29 20:19:56
         compiled from "/home/vagrant/code/admin/web/admin/template/data/newuserdata.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4748139415de10cec7aa830_96918510%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc5ca906acc1b2b7d695e85818cd0c4bdd4e4999' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/newuserdata.tpl',
      1 => 1570801458,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4748139415de10cec7aa830_96918510',
  'variables' => 
  array (
    'widgets' => 0,
    'limit_num' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10cec7e9240_55971528',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10cec7e9240_55971528')) {
function content_5de10cec7e9240_55971528 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4748139415de10cec7aa830_96918510';
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

                            <label>新增注册日期</label>
                            <input type="text" name="sdate" value="" class="Wdate tm" autocomplete="off" /> -
                            <input type="text" name="edate" value="" class="Wdate tm" autocomplete="off" />

                            <label>归类方式</label>
                            <select name="type">
                                <option value="8">按母游戏</option>
                                <option value="1">按子游戏</option>
                                <option value="7" selected="selected">按日期</option>
                                <option value="9">按月份</option>
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
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-report">
            <div class="layui-btn-container page-close" style="display: block">
                <button class="layui-btn layui-btn-sm" lay-event="page_close">
                    <i class="layui-icon">&#xe60a;</i><span>不分页显示</span></button>
            </div>
            <div class="layui-btn-container page-open" style="display: none">
                <button class="layui-btn layui-btn-sm" lay-event="page_open">
                    <i class="layui-icon">&#xe60a;</i><span>分页显示</span>
                </button>
            </div>
        <?php echo '</script'; ?>
>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
    layui.config({
        version: '2019041216',
    }).use(['table','laypage'], function () {
        var table = layui.table;
        var laypage = layui.laypage;
        var limit = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['limit_num']->value, ENT_QUOTES, 'UTF-8');?>
';
        var cols = [];
        var header2 = [
            {field:'group_name', minWidth:150,width:200, title: '名称', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
            {field:'dau',width:180,title:'DAU',align:'center',sort:true},
            {field:'pay_money',width:100,title:'充值金额',align:'center',sort:true},
            {field:'pay_per_str',width:100,title:'流水占比',align:'center',sort:true,sortRow:'pay_per'},
            {field:'roll_comp_str',minWidth:150,width:158,title:'环比',align:'center',sort:true,sortRow:'roll_comp'},
            {field:'arpu',title:'ARPU',width:100,align:'center',sort:true},
            {field:'arppu',title:'ARPPU',width:100,align:'center',sort:true},
            {field:'pay_count',title:'充值次数',width:100,align:'center',sort:true},
            {field:'pay_rate_str',title:'付费率',algin:'center',sort:true,sortRow:'pay_rate'}
        ];
        var header = [
            {title:'序号', type:'numbers', fixed: 'left'},
            {field:'group_name', minWidth:150,width:200, title: '名称', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
            {field:'dau',width:180,title:'DAU',align:'center',sort:true},
            {field:'pay_money_str',width:100,title:'充值金额',align:'center',sort:true},
            {field:'pay_per_str',width:100,title:'流水占比',align:'center',sort:true,sortRow:'pay_per'},
            {field:'roll_comp_str',minWidth:150,width:158,title:'环比',align:'center',sort:true,sortRow:'roll_comp'},
            {field:'arpu',title:'ARPU',width:100,align:'center',sort:true},
            {field:'arppu',title:'ARPPU',width:100,align:'center',sort:true},
            {field:'pay_user',title:'付费人数',width:100,align:'center',sort:true},
            {field:'pay_count',title:'充值次数',width:100,align:'center',sort:true},
            {field:'pay_rate_str',title:'付费率',algin:'left',sort:true,sortRow:'pay_rate'}
        ];

        cols.push(header);

        var options = {
            elem: '#LAY-table-report',
            title: '新增玩家数据',
            url: '/?ct=data4&ac=newUserData&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            page: true,
            limit:limit,
            limits:[20,50,100,200,500],
            totalRow: true,
            cols: cols,
            toolbar: '#toolbar-report',
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
                page:{
                    curr:1
                },
                limit:limit,
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
        table.on("toolbar(report)",function(obj){
            var event = obj.event;
            var config = obj.config;
            var opt;
            switch (event) {
                case 'page_close':
                    opt = getOption(config,0);
                    table.init('report',opt);
                    break;
                case 'page_open':
                    opt = getOption(config,1);
                    table.init('report',opt);
                    break;
                default:
                    break;
            }
        });
        function getOption(config,page){
            var is_page = page;
            var ret = { };
            if(!config || typeof config !='object'){
                return ret;
            }
            ret = {
                url:config.url,
                cols:cols,
                cellMinWidth: 80,
                height:'full-200',
                where:{
                    data:config.where.data,
                },
                toolbar:'#toolbar-report',
                totalRow:true,
            };
            if(is_page == 1){
                ret.page = true;
                ret.limit = limit;
                ret.limits = [20,50,100,200,500];
            }else{
                ret.page = false;
                ret.limit = Number.MAX_VALUE;
            }

            ret.done = function(res, curr, count){
                if(is_page == 1){
                    $(".page-open").hide();
                    $(".page-close").show();
                }else{
                    $(".page-open").show();
                    $(".page-close").hide();
                }
            };
            return ret;
        }
    });


<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>