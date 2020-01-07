<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
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
                            <{widgets widgets=$widgets}>

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
        <script type="text/html" id="toolbar-report">
            <div class="layui-btn-container page-close" style="display: block">
                <button class="layui-btn layui-btn-sm" lay-event="page_close">
                    <i class="layui-icon">&#xe60a;</i><span>不分页显示</span></button>
            </div>
            <div class="layui-btn-container page-open" style="display: none">
                <button class="layui-btn layui-btn-sm" lay-event="page_open">
                    <i class="layui-icon">&#xe60a;</i><span>分页显示</span>
                </button>
            </div>
        </script>
    </div>
</div>
<script type="text/javascript">
    layui.config({
        version: '2019041216',
    }).use(['table','laypage'], function () {
        var table = layui.table;
        var laypage = layui.laypage;
        var limit = '<{$limit_num}>';
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


</script>
<{include file="../public/foot.tpl"}>