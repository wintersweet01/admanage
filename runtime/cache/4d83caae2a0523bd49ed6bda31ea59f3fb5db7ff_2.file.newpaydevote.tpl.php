<?php /* Smarty version 3.1.27, created on 2019-11-29 20:19:58
         compiled from "/home/vagrant/code/admin/web/admin/template/data/newpaydevote.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:18071803565de10cee869fc3_55586254%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d83caae2a0523bd49ed6bda31ea59f3fb5db7ff' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/newpaydevote.tpl',
      1 => 1570801458,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18071803565de10cee869fc3_55586254',
  'variables' => 
  array (
    'widgets' => 0,
    'day' => 0,
    'limit_num' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10cee8a0e27_72639802',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10cee8a0e27_72639802')) {
function content_5de10cee8a0e27_72639802 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '18071803565de10cee869fc3_55586254';
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
    .input-checkbox{
        position: relative;
        top: 2px;
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
                                <option value="7" selected="selected">按注册日期</option>
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
>
    layui.config({
        version: '2019041216',
    }).use(['table'], function () {
        var day = JSON.parse('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['day']->value, ENT_QUOTES, 'UTF-8');?>
');
        var limit = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['limit_num']->value, ENT_QUOTES, 'UTF-8');?>
';
        var table = layui.table;
        var cols = [];
        var header = [
            {title:'序号', type:'numbers', fixed: 'left'},
            {field:'group_name', minWidth:150,width:200,title: '名称', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
            {field:'reg',width:120,title:'新增注册',align:'center',sort:true,fixed:'left'},
            {field:'consume',width:120,title:'累计充值',align:'center',fixed:'left',sort:true},
        ];

        $.each(day, function (i, d) {
            if((d>1 && d<7) || (d>7 && d<14)) {
                header.push({field:'day_pay' + d, width:100, title:d+'日', hide:true, align:'center',  sort:true});
                header.push({field: 'day_pic_str' + d, width: 100, hide:true, title: '充值占比', align: 'center',  sort: true, sortRow:'day_pic' + d});
            }else{
                header.push({field:'day_pay' + d,width:100,title:d+'日', align:'center',  sort:true});
                header.push({field: 'day_pic_str' + d, width: 100, title: '充值占比', align: 'center',sort: true,sortRow:'day_pic' + d});
            }
        });
        var options = {
            elem: '#LAY-table-report',
            title: '新增充值贡献',
            url: '/?ct=data4&ac=newPayDevote&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            page: true,
            limit:limit,
            limits:[20,50,100,200,500],
            totalRow: true,
            cols: cols,
            //defaultToolbar:['exports','print'],
            toolbar:'#toolbar-report',
            done:function(res){
                var query = res.query;
                $('input[name="sdate"]').val(query.sdate);
                $('input[name="edate"]').val(query.edate);
            }

        };
        cols.push(header);
        var tableIdex = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            tableIdex.reload({
                cols: cols,
                page:{
                    curr:1
                },
                where: {
                    data: $('form').serialize()
                }
            });
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
                ret.limit= limit;
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