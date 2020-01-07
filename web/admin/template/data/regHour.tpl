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

                            <lable>日期</lable>
                            <input type="text" name="date" value="" class="Wdate"/>
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
        var table = layui.table;
        var options = {
            elem: '#LAY-table-report',
            title: '每小时新增注册人数',
            data: [],
            cellMinWidth: 80,
            height: 'full-500',
            totalRow: true,
            toolbar: true,
            page: false,
            size: 'sm',
            cols: []
        };
        var tableIns = table.render(options);

        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled: false
            },
            title: {
                text: '每小时新增注册人数'
            },
            xAxis: {},
            yAxis: {
                title: {
                    text: '注册数'
                }
            },
            tooltip: {
                valueSuffix: '个注册'
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
            $.getJSON("/?ct=data1&ac=regHour&json=1", {
                data: data
            }, function (json) {
                var cols = [],
                    _cols = [
                        {field:'hour', width:80, title: '时间', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
                        {field:'total', width: 100, title: '汇总', align: 'center', sort: true, fixed: 'left', totalRow: true, style:'font-weight: bold;color: #a94442;'}
                    ];
                $.each(json.channels, function (field, title) {
                    _cols.push({field:'channel_' + field, title: title, align: 'center', sort: true, totalRow: true});
                });
                cols.push(_cols);

                if (json.data.length) {
                    tableIns.reload({
                        data: json.data,
                        cols: cols,
                        limit: json.data.length
                    });
                } else {
                    tableIns.reload({
                        data: [],
                        cols: [],
                        limit: 0
                    });
                }

                chart.setTitle({
                    text: json.date + '每小时新增注册人数'
                });
                chart.update({
                    xAxis: {
                        categories: json.day
                    }
                });

                while (chart.series.length > 0) {
                    chart.series[0].remove(false);
                }
                for (var i = 0; i < json.series.length; i++) {
                    chart.addSeries(json.series[i], false);
                }
                chart.redraw();

                $('input[name="date"]').val(json.date);
                layer.close(index);
            });
        }
    });
</script>
<{include file="../public/foot.tpl"}>