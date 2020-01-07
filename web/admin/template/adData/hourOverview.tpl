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
        margin-bottom: 5px;
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
                        <div class="form-group form-group-sm">
                            <{widgets widgets=$widgets}>

                            <label>渠道</label>
                            <select name="channel_id[]" id="channel_id" style="width: 50px;" multiple="multiple">
                                <{foreach from=$data._channels key=id item=name}>
                            <option value="<{$id}>" <{if (is_array($data.channel_id) && $id|in_array:$data.channel_id) || $data.channel_id==$id}>selected="selected"<{/if}>><{$name}></option>
                                <{/foreach}>
                            </select>

                            <label>投放账号</label>
                            <select name="user_id[]" id="user_id" style="width: 150px;" multiple="multiple">
                            </select>

                            <label>推广活动</label>
                            <select name="monitor_id[]" id="monitor_id" style="width: 150px;" multiple="multiple">
                            </select>

                            <label>投放组</label>
                            <select name="group_id[]" id="group_id" style="width: 40px;" multiple="multiple">
                                <{foreach from=$data._groups key=id item=name}>
                            <option value="<{$id}>" <{if (is_array($data.group_id) && $id|in_array:$data.group_id) || $data.group_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                                <{/foreach}>
                            </select>

                            <label>手机系统</label>
                            <select name="device_type" style="width: 50px;">
                                <option value="">全 部</option>
                                <option value="1"
                                <{if $data['device_type']==1}>selected="selected"<{/if}>>IOS</option>
                                <option value="2"
                                <{if $data['device_type']==2}>selected="selected"<{/if}>>Android</option>
                            </select>
                        </div>

                        <div class="form-group form-group-sm">
                            <label>注册日期</label>
                            <input type="text" name="rsdate" value="<{$data.rsdate}>" class="form-control Wdate"/>
                            <input type="text" name="redate" value="<{$data.redate}>" class="form-control Wdate"/>

                            <label>充值日期</label>
                            <input type="text" name="psdate" value="<{$data.psdate}>" class="form-control Wdate"/>
                            <input type="text" name="pedate" value="<{$data.pedate}>" class="form-control Wdate"/>
                            <button type="button" class="btn btn-primary btn-sm" id="submit"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows">
        <table id="LAY-table-report" lay-filter="report"></table>
        <script type="text/html" id="toolbar-report">
            <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="page">
                    <i class="layui-icon">&#xe60a;</i><span>不分页显示</span></button>
                <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="size">
                    <i class="layui-icon">&#xe608;</i><span>小尺寸显示</span></button>
            </div>
        </script>
    </div>
</div>
<script>
    var game_id = 0;
    var channel_id = 0;
    $(function () {
        $('#widgets_children_id').on({
            "select2:select": function (e) {
                game_id = e.params.data.id;
                getMonitor(game_id, channel_id);
            },
            "select2:unselect": function (e) {
                var gid = e.params.data.id;
                removeMonitor(gid, 0);
            }
        });

        $('#channel_id').on({
            "select2:select": function (e) {
                channel_id = e.params.data.id;
                $.getJSON('?ct=adData&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                    var html = '';
                    $.each(re, function (i, n) {
                        html += '<option value="' + n.user_id + '" cid="' + channel_id + '">' + n.user_name + '</option>';
                    });
                    $('#user_id').append(html).trigger('change');
                });

                getMonitor(game_id, channel_id);
            },
            "select2:unselect": function (e) {
                var cid = e.params.data.id;
                $('#user_id').find("option[cid='" + cid + "']").remove();

                removeMonitor(0, cid);
            }
        });
    });

    //子游戏删除回调
    function childrenRemoveCallback(data) {
        $.each(data, function (i, n) {
            removeMonitor(n, 0);
        });
    }

    //获取推广活动列表
    function getMonitor(gid, cid) {
        if (!gid && !cid) {
            return false;
        }

        var e = $('#monitor_id');
        $.getJSON('?ct=ad&ac=getAllMonitor&game_id=' + gid + '&channel_id=' + cid, function (re) {
            var html = '';
            $.each(re, function (i, n) {
                var o = e.find("option[value='" + i + "']");
                if (o.length) {
                    o.attr('gid', gid);
                    o.attr('cid', cid);
                    return true;
                }

                html += '<option value="' + i + '" gid="' + gid + '" cid="' + cid + '">' + n + '</option>';
            });
            e.append(html).trigger('change');
        });
    }

    //删除推广活动列表
    function removeMonitor(gid, cid) {
        var e = $('#monitor_id');
        if (gid) {
            e.find("option[gid='" + gid + "']").remove();
        }
        if (cid) {
            e.find("option[cid='" + cid + "']").remove();
        }
    }

    layui.config({
        version: '2019042816',
    }).use('table', function () {
        var day = JSON.parse('<{$day}>');
        var table = layui.table;
        var tr = [];

        var tr2 = [
            {field:'group_name', minWidth:150, title: '小时', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
            {field:'ip', width:80, title: 'IP数', align: 'center', sort: true},
            {field:'click', width:80, title: '点击', align: 'center', sort: true},
            {field:'active', width:80, title: '激活数', align: 'center', sort: true},
            {field:'active_device', width:120, title: '激活设备数', align: 'center', sort: true},
            {field:'click_active_rate', width:120, title: '点击激活率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'reg', width:100, title: '注册数', align: 'center', sort: true, sortRow: 'reg_sort'},
            {field:'device', width:120, title: '注册设备数', align: 'center', sort: true},
            {field:'click_reg_rate', width:120, title: '点击注册率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'active_reg_rate', width:120, title: '激活注册率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'new_pay_money_str', width:150, title: '新增付费额（当天）', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'new_pay_money'},
            {field:'new_pay_count', width:154, title: '新增付费人数（当天）', align: 'center', sort: true, sortRow: 'new_pay_count_sort'},
            {field:'new_pay_rate', width:120, title: '新增付费率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'new_pay_arpu', width:120, title: '新增ARPU', align: 'center', sort: true},
            {field:'new_pay_arppu', width:120, title: '新增ARPPU', align: 'center', sort: true},
            {field:'period_pay_money_str', width:120, title: '周期付费额', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'period_pay_money'},
            {field:'period_pay_count', width:120, title: '周期付费人数', align: 'center', sort: true},
            {field:'total_pay_money_str', width:120, title: '累计付费额', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'total_pay_money'},
            {field:'total_pay_count', width:120, title: '累计付费人数', align: 'center', sort: true, sortRow: 'total_pay_count_sort'},
        ];
        tr.push(tr2);

        var options = {
            elem: '#LAY-table-report',
            title: '推广数据总表',
            toolbar: '#toolbar-report',
            data: [],
            cellMinWidth: 80,
            height: 'full-210',
            totalRow: true,
            page: true,
            cols: tr,
        };

        var tableIns = table.render($.extend(options, getOptions()));

        $('#submit').on('click', function () {
            //layer.load();
            $.post('?ct=adData&ac=hourOverview', {
                data: $('form').serialize()
            }, function (json) {
                layer.closeAll();

                var options = getOptions({
                    data: json.list,
                    totalData: json.total
                });
                tableIns.reload(options);
            }, 'json');
        });

        //监听头工具栏事件
        table.on('toolbar(report)', function (obj) {
            var options,
                toolbar = layui.data('toolbar'),
                config = {
                    data: obj.config.data,
                    totalData: obj.config.totalData,
                };

            switch (obj.event) {
                case 'page':
                    //当前不分页，则切为分页
                    if (toolbar[obj.event] == 1) {
                        options = getOptions(config, 0);
                    } else {
                        options = getOptions(config, 1);
                    }
                    tableIns.reload(options);
                    break;
                case 'size':
                    //当前小尺寸，则切为大尺寸
                    if (toolbar[obj.event] == 1) {
                        options = getOptions(config, null, 0);
                    } else {
                        options = getOptions(config, null, 1);
                    }
                    tableIns.reload(options);
                    break;
            }
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        //表格配置
        function getOptions(json, page, size) {
            var data = json ? json.data : [],
                totalData = json ? json.totalData : [],
                toolbar = layui.data('toolbar'),
                limit = 15,
                is_page = 0,
                is_size = 0,
                ret = {
                    data: data.length ? data : [],
                    totalData: !$.isEmptyObject(totalData) ? totalData : [],
                    limit: limit,
                    page: {
                        curr: 1
                    }
                };

            if (typeof page == 'undefined' || page == null) {
                if (toolbar['page'] == 1) {
                    ret.limit = data.length;
                    ret.page = false;
                    is_page = 1;
                }
            } else {
                if (page == 1) {
                    ret.limit = data.length;
                    ret.page = false;
                    is_page = 1;
                } else {
                    ret.limit = limit;
                    ret.page = {
                        curr: 1
                    };
                    is_page = 0;
                }

                layui.data('toolbar', {
                    key: 'page',
                    value: page
                });
            }

            if (typeof size == 'undefined' || size == null) {
                if (toolbar['size'] == 1) {
                    ret.size = 'sm';
                    is_size = 1;
                }
            } else {
                if (size == 1) {
                    ret.size = 'sm';
                    is_size = 1;
                } else {
                    ret.size = '';
                    is_size = 0;
                }

                layui.data('toolbar', {
                    key: 'size',
                    value: size
                });
            }

            ret.done = function (res, curr, count) {
                if (is_page) {
                    $('button[lay-event="page"] span').text('分页显示');
                } else {
                    $('button[lay-event="page"] span').text('不分页显示');
                }

                if (is_size == 1) {
                    $('button[lay-event="size"] span').text('正常显示');
                } else {
                    $('button[lay-event="size"] span').text('小尺寸显示');
                }
            };

            return ret;
        }
    });
</script>
<{include file="../public/foot.tpl"}>