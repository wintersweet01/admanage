<?php /* Smarty version 3.1.27, created on 2019-11-29 20:20:02
         compiled from "/home/vagrant/code/admin/web/admin/template/data/daychargedata.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13484039625de10cf28f0934_80486817%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '981640322843507a178baa380c2e48784ed5c0c6' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/daychargedata.tpl',
      1 => 1570801460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13484039625de10cf28f0934_80486817',
  'variables' => 
  array (
    'widgets' => 0,
    'day' => 0,
    'limit_num' => 0,
    'show_type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10cf292a8d7_81942864',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10cf292a8d7_81942864')) {
function content_5de10cf292a8d7_81942864 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13484039625de10cf28f0934_80486817';
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


                            <label style="margin-left: 6px">查看数据</label>
                            <select name="show_type" class="view-data">
                                <option value="0" selected="selected">总充值数据</option>
                                <option value="1">IOS充值数据</option>
                                <option value="2">安卓充值数据</option>
                            </select>
                            <label>日期</label>
                            <input type="text" name="sdate" value="" class="Wdate"/> -
                            <input type="text" name="edate" value="" class="Wdate"/>

                            <label>归类方式</label>
                            <select class="chose-type" name="type">
                                <option value="8">按母游戏</option>
                                <option value="1">按子游戏</option>
                                <option value="7" selected="selected">按日期</option>
                                <option value="9">按月份</option>
                                <option value="10">按周</option>
                            </select>

                            <button id="submit" type="button" class="btn btn-primary btn-xs"> 筛 选</button>
                            <button type="button" class="btn btn-success btn-xs" id="printExcel">导出Excel</button>
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
        var day = JSON.parse('<?php echo $_smarty_tpl->tpl_vars['day']->value;?>
');
        var limit = '<?php echo $_smarty_tpl->tpl_vars['limit_num']->value;?>
';
        var show_type = '<?php echo $_smarty_tpl->tpl_vars['show_type']->value;?>
';//default total
        var table = layui.table;
        var cols = getHeader(show_type);
        var options = {
            elem: '#LAY-table-report',
            title: '新增充值贡献',
            url: '/?ct=data4&ac=dayChargeData&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            page: true,
            limit:limit,
            limits:[20,50,100,200,500],
            totalRow: true,
            cols: cols,
            toolbar:'#toolbar-report',
            defaultToolbar:['filter','print'],
            done:function(res){
                var query = res.query;
                $('input[name="sdate"]').val(query.sdate);
                $('input[name="edate"]').val(query.edate);
            }

        };
        var tableIdex = table.render(options);
        //筛选
        $('#submit').on('click', function () {
            var show_type = $("select[name=show_type]").val();
            var coldCheck = getHeader(show_type);
            tableIdex.reload({
                cols: coldCheck,
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
            var show_type = $("select[name=show_type]").val();
            var coldBool = getHeader(show_type);
            switch (event) {
                case 'page_close':
                    var opt = getOption(config,coldBool,0);
                    table.init('report',opt);
                    break;
                case 'page_open':
                    opt = getOption(config,coldBool,1);
                    table.init('report',opt);
                    break;
                default:
                    break;
            }
        });
        function getOption(config,cols,page){
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

        function getHeader(type = 0){
            var header = [];
            var header1 = [];
            var header2 = [];
            header1 = [
                {title:'序号',fixed:'left',rowspan:2,type:'numbers'},
                {field:'group_name',fixed:'left',rowspan:2,title:'名称',align:'center',minWidth:150,align:'center',sort:true,totalRowText:'总计'},
                {field:'login_user',rowspan:2,title:'DAU',align:'center',width:120,sort:true}
            ];
            if(type == 1){
                header1.push({field:'ios_pay_user',rowspan:2,title:'ios付费人数',align:'center',width:120,sort:true});
                header1.push({field:'ios_pay_money_str',rowspan:2,title:'ios充值金额',align:'center',width:120,sort:true,sortRow:'ios_pay_money'});
            }else if(type == 2){
                header1.push({field:'adr_pay_user',rowspan:2,title:'安卓付费人数',align:'center',width:120,sort:true});
                header1.push({field:'adr_pay_money_str',rowspan:2,title:'安卓充值金额',align:'center',width:120,sort:true,sortRow:'adr_pay_money'});
            }else{
                header1.push({field:'pay_user',rowspan:2,title:'总付费人数',align:'center',width:120,sort:true});
                header1.push({field:'pay_money_str',rowspan:2,title:'总充值金额',align:'center',width:120,sort:true,sortRow:'pay_moeny'});
            }

            for (var i in  day){
                var day_name = '';
                if(day[i].match(/^\d+\_$/)){
                    day_name = '大于'+parseInt(day[i]);
                }else{
                    day_name = day[i].replace(/\_/,'-');
                }
                var title_name = '注册'+day_name+'天';
                header1.push({title:title_name,colspan:3,align:'center'});
                header2.push({field:'pay_money_str'+day[i],title:'付费金额',align:'center',sort:true,minWidth:120});
                header2.push({field:'pay_user'+day[i],title:'付费人数',align:'center',sort:true,minWidth:120});
                header2.push({field:'pay_count'+day[i],title:'付费次数',align:'center',sort:true,minWidth:120})
            }
            header.push(header1);
            header.push(header2);
            return header;
        }
    });
    $(function(){
        $('#printExcel').click(function () {
            location.href = '?ct=data4&ac=dayChargeDataExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+
                '&show_type='+$('select[name=show_type]').val()+
                '&sdate='+$('input[name=sdate]').val()+ '&edate='+$('input[name=edate]').val()+ '&type='+$('select[name=type]').val()+'';
        });
    })

<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>