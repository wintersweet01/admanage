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
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-table-navbar-collapse-1" aria-expanded="false">
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

                            <label>选择渠道</label>
                            <select class="form-control" name="channel_id">
                                <option value="">全 部</option>
                                <{foreach from=$_channels key=id item=name}>
                                <option value="<{$id}>"><{$name}></option>
                                <{/foreach}>
                            </select>

                            <label>日期</label>
                            <input type="text" name="month" value="<{$month}>"
                                   class="Wdate date-input form-control input-group-sm input-check" autocomplete="off"
                                   style="width: 100px"/>
                            <button type="button" class="btn btn-primary btn-sm" id="submit">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                            </button>
                            <!--<button type="button" class="btn btn-success btn-xs" id="upload">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 录入分成
                            </button>-->
                            <a href="?ct=extend&ac=splitUpload" class="btn btn-danger btn-sm" role="button">
                                <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 导入分成
                            </a>
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
                <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">
                    <i class="layui-icon">&#xe640;</i><span>删除所选</span>
                </button>
            </div>
        </script>
    </div>
</div>
<script>
    $(function () {

        $('input[name=month]').off();
        $('input[name=month]').on('click focus', function () {
            WdatePicker({el:this, dateFmt:"yyyy-MM"});
        });

        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html).trigger('change');
            });
        });
    });

    layui.config({
        version: '2019031310',
    }).use('table', function () {
        var table = layui.table;
        var cols = [[
            {type: 'checkbox'},
            {field:'parent_name', width:150, title: '母游戏', align: 'center'},
            {field:'parent_id', width:120, title: '母游戏ID', align: 'center'},
            {field:'game_name', width:150, title: '子游戏', align: 'center'},
            {field:'game_id', width:120, title: '子游戏ID', align: 'center'},
            {field:'channel_name', width:100, title: '渠道', align: 'center'},
            {field:'channel_id', width:120, title: '渠道ID', align: 'center'},
            {field:'cp_split', width:150, title: '研发分成比例', align: 'center',edit: 'text'},
            {field:'channel_split', width:150, title: '渠道分成比例', align: 'center',edit: 'text'},
            {field:'month', width:120, title: '月份', align: 'center',edit: 'text'},
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '分成管理',
            toolbar: '#toolbar-report',
            url: '/?ct=extend&ac=splitManage&json=1',
            cellMinWidth: 80,
            height: 'full-200',
            totalRow: true,
            page: true,
            limit: 15,
            cols: cols
        };

        var tableIns = table.render(options);
        //筛选
        $('#submit').on('click', function () {
            tableIns.reload({
                where: {
                    data: $('form').serialize()
                },
                page: {
                    curr: 1
                }
            });
        });

        //录入成本
        $('#upload').on('click', function () {
            layer.confirm('请筛选录入条件，然后在查询结果的列表中点击单元格输入数据。<br><br>是否已选择好条件？', {
                btn: ['是的', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                layer.closeAll();
                tableIns.reload({
                    where: {
                        data: $('form').serialize(),
                        upload: 1
                    },
                    page: {
                        curr: 1
                    }
                });
            });
        });
        //单元格事件
        table.on('edit(report)', function (obj) {
            var val = obj.value,
                field = obj.field;
            var p_name = obj.data.parent_name;
            var c_name = obj.data.channel_name;
            var g_name = obj.data.game_name;
            var m = obj.data.month;
            if (!$.isNumeric(val)) {
                $(this).val(0);
                return false;
            }
            layer.confirm('确认更改为：' + val, function () {
                $.post('?ct=extend&ac=splitUploadEdit', {
                    field: field,
                    value: val,
                    data: obj.data
                }, function (re) {
                    var rt = JSON.parse(re);
                    if (rt.state == 0) {
                        layer.msg(re.msg);
                    } else {
                        layer.msg('母游戏：' + p_name + ' 子游戏：' + g_name + ' 渠道：' + c_name + ' 月份 ' + m + ' 更改为：' + val);
                    }
                }, 'json');
            });
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });
        table.on('toolbar(report)',function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;
            //console.log(data);
            var event = obj.event;
            switch (event) {
                case 'del':
                    layer.confirm('确认删除？',function(){
                        layer.closeAll();
                        if (data.length == 0) {
                            layer.msg('请勾选一个以上');
                            return false;
                        }
                        var ids = [];
                        $.each(data,function(i,m){
                            ids.push(m.id);
                        });
                        $.post('?ct=extend&ac=splitDel',{id:ids},function(e){
                            var et = JSON.parse(e);
                            if(et.state == 1){
                                layer.msg('删除成功',{time:1000});
                                table.reload('LAY-table-report');
                            }else{
                                layer.msg('删除失败',{time:1000});
                            }
                        })
                    });
                    break;
                default:
                    break;
            }
        })
    });
</script>
<{include file="../public/foot.tpl"}>