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
                    <form class="form-inline navbar-form navbar-left" method="get" action="">
                        <div class="form-group">
                            <label>选择游戏</label>
                            <{widgets widgets=$widgets}>

                            <label>选择平台</label>
                            <select name="platform">
                                <option value="">全 部</option>
                                <option value="1">IOS</option>
                                <option value="2">Andorid</option>
                            </select>

                            <lable>注册日期</lable>
                            <input type="text" name="sdate" value="" class="Wdate"/> -
                            <input type="text" name="edate" value="" class="Wdate"/>
                            <button type="button" class="btn btn-primary btn-xs" id="submit"> 筛 选</button>
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
                {field:'date', width:100, title: '日期', align: 'center', fixed: 'left', totalRowText: '合计'},
                {field:'total', width: 100, title: '汇总', align: 'center', fixed: 'left', style:'font-weight: bold;color: #a94442;'}
            ];
        $.each(day, function (i, hour) {
            _cols.push({field: hour, title: hour + '时', align: 'center'});
        });
        cols.push(_cols);

        var tableIns = table.render({
            elem: '#LAY-table-report',
            title: '按天每小时充值',
            cellMinWidth: 80,
            height: 'full-500',
            totalRow: true,
            toolbar: true,
            page: false,
            size: 'sm',
            cols: cols,
            data: []
        });

        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled: false
            },
            title: {
                text: '每小时充值金额'
            },
            xAxis: {},
            yAxis: {
                title: {
                    text: '元'
                }
            },
            tooltip: {
                valueSuffix: '元'
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
            $.getJSON("/?ct=data4&ac=payHour&json=1", {
                data: data
            }, function (json) {
                if (json.data.length) {
                    tableIns.reload({
                        data: json.data,
                        totalData: json.total,
                        limit: json.data.length
                    });
                } else {
                    tableIns.reload({
                        data: [],
                        totalData: [],
                        limit: 0
                    });
                }

                chart.setTitle({
                    text: json.sdate + ' - ' + json.edate + '每小时充值金额'
                });
                chart.update({
                    xAxis: {
                        categories: day
                    }
                });

                while (chart.series.length > 0) {
                    chart.series[0].remove(false);
                }
                for (var i = 0; i < json.series.length; i++) {
                    chart.addSeries(json.series[i], false);
                }
                chart.redraw();

                $('input[name="sdate"]').val(json.sdate);
                $('input[name="edate"]').val(json.edate);
                layer.close(index);
            });
        }
    });
</script>
<{include file="../public/foot.tpl"}>