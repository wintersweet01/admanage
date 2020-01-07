<{include file="../public/header.tpl"}>
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
                            <select name="device_type">
                                <option value="">全 部</option>
                                <option value="1">IOS</option>
                                <option value="2">Andorid</option>
                            </select>

                            <label>间隔</label>
                            <select name="interval">
                                <option value="1">1分钟</option>
                                <option value="5">5分钟</option>
                                <option value="30">30分钟</option>
                                <option value="60">60分钟</option>
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
        <div id="container" style="min-width:400px;min-height:600px; background-color: #FFFFFF;"></div>
    </div>
</div>
<script src="<{$_cdn_static_url_}>lib/echarts/echarts.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var chart = echarts.init(document.getElementById("container"));

        submit();

        $('#submit').on('click', function () {
            var sdate = $('input[name="sdate"]').val(),
                edate = $('input[name="edate"]').val();

            if (sdate && edate) {
                var s1 = Date.parse(sdate),
                    s2 = Date.parse(edate);
                var day = parseInt((s2 - s1) / (1000 * 60 * 60 * 24));

                if (day < 0) {
                    layer.alert('开始时间必须小于等于结束时间');
                    return false;
                }

                if (day >= 5) {
                    layer.alert('时间范围不能超过5天，要不然你的浏览器会爆炸的！');
                    return false;
                }
            }

            submit($('form').serialize());
        });

        window.onresize = function () {
            chart.resize({
                height: $(window).height() - $('.main-header').height() - 100
            });
        };

        function submit(param) {
            chart.clear();
            chart.showLoading();

            $.getJSON('/?ct=data4&ac=onlineHour&json=1', {
                data: param
            }, function (data) {
                chart.hideLoading();

                var games = data.games,
                    query = data.query,
                    total = data.total,
                    arr = data.data,
                    sort = data.sort;

                $('input[name="sdate"]').val(query.sdate);
                $('input[name="edate"]').val(query.edate);
                $('select[name="interval"]').val(query.interval).trigger('change');

                var series = [{
                    id: 0,
                    type: 'line',
                    showSymbol: false,
                    label: {
                        show: true
                    },
                    markPoint: {
                        data: [
                            {type: 'max', name: '最大值'},
                            {type: 'min', name: '最小值'}
                        ]
                    },
                    name: '游戏总在线',
                    data: total
                }];

                $.each(sort, function (i, n) {
                    series.push({
                        id: parseInt(n),
                        type: 'line',
                        showSymbol: false,
                        hoverAnimation: false,
                        name: games[n] ? games[n].name : '未知',
                        data: arr[n],
                        xAxisIndex: 1,
                        yAxisIndex: 1,
                        label: {
                            show: true
                        }
                    });
                });

                chart.setOption({
                    title: [{
                        left: 'center',
                        text: '游戏总在线'
                    }, {
                        top: '25%',
                        left: 'center',
                        text: '各游戏在线'
                    }],
                    grid: [{
                        left: 10,
                        right: 150,
                        bottom: '80%',
                        containLabel: true
                    }, {
                        top: '30%',
                        left: 10,
                        right: 150,
                        bottom: '3%',
                        containLabel: true
                    }],
                    tooltip: {
                        trigger: 'axis',
                        confine: true,
                        textStyle: {
                            fontSize: 12
                        }
                    },
                    legend: {
                        type: 'scroll',
                        orient: 'vertical',
                        right: 10,
                        formatter: function (name) {
                            return echarts.format.truncateText(name, 100, '14px Microsoft Yahei', '…');
                        },
                        tooltip: {
                            show: true
                        }
                    },
                    xAxis: [{
                        type: 'time',
                        splitLine: {
                            show: false
                        }
                    }, {
                        type: 'time',
                        splitLine: {
                            show: false
                        },
                        gridIndex: 1
                    }],
                    yAxis: [{
                        type: 'value',
                        name: '设备数',
                        splitLine: {
                            show: false
                        }
                    }, {
                        type: 'value',
                        name: '设备数',
                        splitLine: {
                            show: false
                        },
                        gridIndex: 1
                    }],
                    series: series
                });

                chart.resize({
                    height: $('#content-main').innerHeight() - 70
                });
            });
        }
    });
</script>
<{include file="../public/foot.tpl"}>