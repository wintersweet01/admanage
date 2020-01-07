<?php /* Smarty version 3.1.27, created on 2019-11-28 17:21:48
         compiled from "/home/vagrant/code/admin/web/admin/template/data/online.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2963820515ddf91ac08b0d0_88373705%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d275ab034e90aff6167fbd24e2fced52d317145' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/online.tpl',
      1 => 1572429072,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2963820515ddf91ac08b0d0_88373705',
  'variables' => 
  array (
    '_cdn_static_url_' => 0,
    '_games' => 0,
    '_channel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91ac0c04d0_45167686',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91ac0c04d0_45167686')) {
function content_5ddf91ac0c04d0_45167686 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2963820515ddf91ac08b0d0_88373705';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="container-fluid">
    <div class="row">
        <div id="container" style="width:100%;min-height:600px;"></div>
        <span id="helpBlock" class="help-block"></span>
    </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/echarts/echarts.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function () {
        var max = 1200;
        var games = JSON.parse('<?php echo $_smarty_tpl->tpl_vars['_games']->value;?>
');
        var channel = JSON.parse('<?php echo $_smarty_tpl->tpl_vars['_channel']->value;?>
');
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>