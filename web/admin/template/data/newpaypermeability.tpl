<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
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
                    <form class="form-inline navbar-form navbar-left" id="myForm" method="get" action="">
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
                            <select class="chose-type" name="type">
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
        <div id="container" style="min-width:400px;height:280px; background-color: #FFFFFF;"></div>
        <table id="LAY-table-report" lay-filter="report"></table>
    </div>
</div>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/highcharts.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/exporting.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/highcharts-zh_CN.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/grid-light.js"></script>
<script>
    layui.config({
        version: '2019031121',
    }).use('table', function () {
        var day = JSON.parse('<{$day nofilter}>');
        var table = layui.table;
        var cols = [],
            _cols = [
                {title:'序号', type:'numbers', fixed: 'left'},
                {field:'group_name', minWidth:150,width:200,title: '名称', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
                {field:'reg',width:120,title:'新增注册',align:'center',sort:true,fixed:'left'},
                {field:'pay_user',width:120,title:'累计付费玩家',align:'center',sort:true},
                {field:'permy_tt_str',width:120,title:'渗透率',align:'center',sort:true,sortRow:'permy_tt'},
            ];
        $.each(day, function (i, d) {
            if((d>1 && d<7) || (d>7 && d<14)) {
                _cols.push({field:'day_pay' + d, width:100, title:d+'日', hide:true, align:'center',  sort:true});
                _cols.push({field: 'pay_permy_str' + d,minWidth:150,width: 120, hide:true, title: '付费渗透率', align: 'center',  sort: true, sortRow:'pay_permy' + d});
            }else{
                _cols.push({field:'day_pay' + d,width:100,title:d+'日', align:'center',  sort:true});
                _cols.push({field: 'pay_permy_str' + d,minWidth:150, width: 120, title: '付费渗透率', align: 'center',sort: true,sortRow:'pay_permy' + d});
            }
        });
        cols.push(_cols);

        var tableIns = table.render({
            elem: '#LAY-table-report',
            title: '按天每小时充值',
            cellMinWidth: 80,
            height: 'full-500',
            totalRow: true,
            toolbar: true,
            page: true,
            limit:5,
            limits:[20,50,100,200,500],
            size: 'sm',
            cols: cols,
            data: []
        });

        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled: false
            },
            title: {
                text: '累计付费玩家'
            },
            yAxis: {
                title: {
                    text: '个'
                }
            },
            tooltip: {
                valueSuffix: '个',
                shared:true
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: []
        });

        setTimeout(function () {
            getData();
        }, 100);

        //筛选
        $('#submit').on('click', function () {
            getData($('form').serialize());
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        function getData(data) {
            var index = layer.load();
            $.getJSON("/?ct=data4&ac=newPayPermeability&json=1", {
                data: data
            }, function (json) {
                var query = json.query;
                if (json.data.length) {
                    tableIns.reload({
                        data: json.data,
                        totalData: json.totalData,
                        //limit: json.data.length
                        limit: 30,
                        limits:[20,50,100,200,500],
                    });
                } else {
                    tableIns.reload({
                        data: [],
                        totalData: [],
                        limit: 0
                    });
                }

                chart.setTitle({
                    text: query.sdate + ' - ' + query.edate + '累计付费玩家'
                });
                chart.update({
                    xAxis: {
                        categories: day,
                        labels:{
                            formatter:function(){
                                return this.value+"日"
                            }
                        }
                    }
                });

                while (chart.series.length > 0) {
                    chart.series[0].remove(false);
                }
                for (var i = 0; i < json.series.length; i++) {
                    chart.addSeries(json.series[i], false);
                }
                chart.redraw();
                $('input[name="sdate"]').val(query.sdate);
                $('input[name="edate"]').val(query.edate);
                layer.close(index);
            });
        }

        $(".chose-type").change(function(){
            getData($('form').serialize());
        })
    });
</script>
<{include file="../public/foot.tpl"}>