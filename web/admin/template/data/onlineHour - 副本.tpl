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
                        <input type="hidden" name="ct" value="data4"/>
                        <input type="hidden" name="ac" value="onlineHour"/>

                        <div class="form-group">
                            <label>选择游戏</label>
                            <{widgets widgets=$widgets}>

                            <label>选择平台</label>
                            <select name="device_type">
                                <option value="">全 部</option>
                                <option value="1"
                                <{if $query.device_type == 1}> selected><{/if}>>IOS</option>
                                <option value="2"
                                <{if $query.device_type == 2}> selected><{/if}>>Andorid</option>
                            </select>

                            <lable>注册日期</lable>
                            <input type="text" name="sdate" value="<{$query.sdate}>" class="Wdate"/> -
                            <input type="text" name="edate" value="<{$query.edate}>" class="Wdate"/>
                            <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
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
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/highcharts.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/exporting.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/highcharts-zh_CN.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/grid-light.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#container').css("height", $(document.body).height() - 150);

        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });

        Highcharts.chart('container', {
            chart: {
                type: 'spline',
                animation: Highcharts.svg
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            title: {
                text: '[<{$query.sdate}> - <{$query.edate}>]游戏实时在线'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: '在线设备数'
                }
            },
            tooltip: {
                shared: true,
                crosshairs: true
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: JSON.parse('<{$series nofilter}>')
        });
    });
</script>
<{include file="../public/foot.tpl"}>