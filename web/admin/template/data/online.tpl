<{include file="../public/header.tpl"}>
<div class="container-fluid">
    <div class="row">
        <div id="container" style="width:100%;min-height:600px;"></div>
        <span id="helpBlock" class="help-block"></span>
    </div>
</div>
<script src="<{$_cdn_static_url_}>lib/echarts/echarts.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var max = 1200;
        var games = JSON.parse('<{$_games nofilter}>');
        var channel = JSON.parse('<{$_channel nofilter}>');
        var chart = echarts.init(document.getElementById("container"));
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
            data: []
        }];

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

        if ("WebSocket" in window) {
            chart.showLoading();

            // 打开一个 web socket
            var ws = new WebSocket("ws://sdk.api.hutao.net:8283");
            var int;

            ws.onopen = function () {
                int = setInterval(function () {
                    var json = {
                        type: "statistics"
                    };
                    ws.send(JSON.stringify(json));
                }, 3000);
            };
            ws.onmessage = function (evt) {
                var json = JSON.parse(evt.data);
                var data = json.data;
                switch (json.type) {
                    case 'ping':
                        var json = {
                            type: "ping"
                        };
                        ws.send(JSON.stringify(json));
                        break;
                    case 'statistics':
                        var _games = data.games;
                        var _channel = data.channel;
                        var t = JsMain.date('Y-m-d H:i:s');

                        //累计数据超过最大值删除前面数据
                        if (series[0]['data'].length > max) {
                            series[0]['data'].shift();
                        }

                        series[0]['data'].push({
                            name: t,
                            value: [t, data.online]
                        });

                        for (var gid in _games) {
                            var is_has = false;
                            for (var i = 0; i < series.length; i++) {
                                if (series[i].id == gid) {
                                    //累计数据超过最大值删除前面数据
                                    if (series[i]['data'].length > max) {
                                        series[i]['data'].shift();
                                    }

                                    series[i]['data'].push({
                                        name: t,
                                        value: [t, _games[gid]]
                                    });

                                    is_has = true;
                                    break;
                                }
                            }

                            if (!is_has) {
                                var _data = [];
                                _data.push({
                                    name: t,
                                    value: [t, _games[gid]]
                                });

                                series.push({
                                    id: parseInt(gid),
                                    type: 'line',
                                    showSymbol: false,
                                    hoverAnimation: false,
                                    name: games[gid],
                                    data: _data,
                                    xAxisIndex: 1,
                                    yAxisIndex: 1,
                                    label: {
                                        show: true
                                    }
                                });
                            }
                        }

                        chart.hideLoading();
                        chart.setOption({
                            series: series
                        });

                        break;
                }
            };
            ws.onclose = function () {
                clearInterval(int);
            };
            ws.onerror = function (event) {

            }
        } else {
            // 浏览器不支持 WebSocket
            alert("您的浏览器不支持 WebSocket!");
        }

        chart.resize({
            height: $('#content-main').innerHeight()
        });

        window.onresize = function () {
            chart.resize({
                height: $(window).height() - $('.main-header').height() - 30
            });
        };
    });
</script>
<{include file="../public/foot.tpl"}>