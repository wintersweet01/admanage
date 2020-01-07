<{include file="../public/header.tpl"}>
<div class="layui-fluid">
    <div class="layui-tab layui-tab-brief" lay-filter="forbidden">
        <ul class="layui-tab-title">
            <li class="layui-this" lay-id="ip">封禁IP列表</li>
            <li lay-id="device">封禁设备号列表</li>
            <li lay-id="user">封禁账号列表</li>
        </ul>
        <div class="layui-tab-content">
            <div>
                <form class="form-inline">
                    <input type="text" class="form-control input-sm" name="keyword" id="keyword" value="" placeholder="" style="width: 300px;"/>
                    <span id="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>搜索</span>
                    <span id="add" class="btn btn-danger btn-sm"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加封禁</span>
                    <span id="export" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</span>
                </form>
            </div>
            <div class="layui-tab-item layui-show">
                <div class="rows">
                    <table id="table-report-ip" lay-filter="report-ip"></table>
                </div>
            </div>
            <div class="layui-tab-item">
                <div class="rows">
                    <table id="table-report-device" lay-filter="report-device"></table>
                </div>
            </div>
            <div class="layui-tab-item">
                <div class="rows">
                    <table id="table-report-user" lay-filter="report-user"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="toolbar-list">
    {{# if(d.type == '3'){ }}
    <span class="layui-btn layui-btn-xs" lay-event="unban"><i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封</span>
    {{# } else { }}
    {{# if(d.handle == 'all' || d.handle == 'login'){ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="login"><i class="fa fa-close fa-fw" aria-hidden="true"></i>登录</span>
    {{# } else { }}
    <span class="layui-btn layui-btn-xs layui-btn-primary" lay-event="login"><i class="fa fa-check fa-fw" aria-hidden="true"></i>登录</span>
    {{# } }}
    {{# if(d.handle == 'all' || d.handle == 'reg'){ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="reg"><i class="fa fa-close fa-fw" aria-hidden="true"></i>注册</span>
    {{# } else { }}
    <span class="layui-btn layui-btn-xs layui-btn-primary" lay-event="reg"><i class="fa fa-check fa-fw" aria-hidden="true"></i>注册</span>
    {{# } }}
    <span class="layui-btn layui-btn-xs layui-btn-primary" lay-event="ban"><i class="fa fa-ban fa-fw" aria-hidden="true"></i>一键封禁/解封</span>
    {{# } }}
</script>
<link rel="stylesheet" href="<{$_cdn_static_url_}>lib/layui-2.5/css/layui.css">
<script src="<{$_cdn_static_url_}>lib/layui-2.5/layui.js"></script>
<script type="text/javascript">
    layui.config({
        version: '2019092420'
    }).use(['element', 'form', 'table'], function () {
        var $ = layui.jquery,
            element = layui.element,
            table = layui.table,
            type = 'ip',
            _type = {
                'ip': 'IP',
                'device': '设备号',
                'user': 'UID'
            };

        //默认
        setTableList(type);

        //tab切换事件
        element.on('tab(forbidden)', function (data) {
            type = $(this).attr('lay-id');
            setTableList(type);
        });

        //搜索
        $('#submit').on('click', function () {
            var keyword = $('#keyword').val();

            if (!keyword) {
                return false;
            }

            table.reload('table-report-' + type, {
                where: {
                    keyword: keyword
                },
                page: {
                    curr: 1
                }
            });
        });

        //添加
        $('#add').on('click', function () {
            layer.open({
                type: 2,
                title: '添加封禁',
                shadeClose: false,
                shade: 0.8,
                area: is_mobile ? ['100%', '100%'] : ['30%', '60%'],
                content: '/?ct=user&ac=forbiddenAdd&type=' + type
            });
        });

        //导出
        $('#export').on('click', function () {
            layer.msg('正在导出中，请勿刷新......<br>（点击可以关闭提示）', {icon: 16, shade: 0.8, shadeClose:true, time: 5000});
            window.location.href = '?ct=user&ac=forbiddenExport&type=' + type;
        });

        //关联列表
        function setTableList(type) {
            var cols = [],
                _cols = [{
                    field: 'content',
                    title: _type[type],
                    width: type === 'device' ? 350 : 160
                }];

            if (type === 'ip') {
                _cols.push({field: 'area',title: '地区',width: 250});
            }

            if (type === 'user') {
                _cols.push({field: 'username',title: '账号',width: 250});
            }

            _cols.push({field: 'time',title: '封禁时间',width: 180,align: 'center',templet: function (d) {return d.time > 0 ? layui.util.toDateString(d.time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}});
            _cols.push({field: 'notes',title: '备注',minWidth: 300,align: 'center'});
            _cols.push({field: 'admin_name',title: '操作者',width: 100,align: 'center'});
            _cols.push({title: '操作',minWidth: 280,toolbar: '#toolbar-list'});

            cols.push(_cols);

            var options = {
                elem: '#table-report-' + type,
                url: '/?ct=user&ac=getForbiddenList',
                where: {
                    type: type
                },
                cellMinWidth: 80,
                height: 'full-200',
                page: true,
                limit: 17,
                limits: [17, 50, 100, 200, 500],
                cols: cols,
                done: function (res, curr, count) {
                    $('#keyword').attr('placeholder', _type[type]);
                }
            };

            table.render(options);

            //监听工具条
            table.on('tool(report-' + type + ')', function (obj) {
                var othis = $(this),
                    data = obj.data;

                if (obj.event === 'ban') { //一键封禁/解封
                    layer.confirm('请选择操作对象', {
                        btn: ['一键封禁', '一键解封', '取消'],
                        btnAlign: 'c'
                    }, function (index1, layero) { //封禁
                        layer.close(index1);
                        layer.prompt({
                            formType: 2,
                            title: '正在<span style="color: red;"><b>封禁</b></span>' + _type[type] + '[' + data.content + ']，请填写备注：',
                            btn: ['封禁', '取消'],
                            btnAlign: 'c'
                        }, function (text, index2, elem) {
                            banHandle(type, 'ban', data.content, 0, text, function (message) {
                                layer.msg('封禁成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                    layer.close(index2);
                                    //重新加载表格
                                    table.reload('table-report-' + type);
                                });
                            });
                        });
                    }, function (index1, layero) { //解封
                        layer.close(index1);
                        banHandle(type, 'unban', data.content, 0, '', function (message) {
                            layer.msg('解封成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                obj.del();
                            });
                        });
                    });
                } else if (obj.event === 'unban') { //账号解封
                    layer.confirm('确定<span style="color: red;"><b>解封</b></span>UID为【' + data.content + '】的用户吗？', function () {
                        banHandle('user', 'user_unban', data.content, 0, '', function (message) {
                            layer.msg('解封成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                obj.del();
                            });
                        });
                    });
                } else {
                    var arr = {
                        'login': '登录',
                        'reg': '注册'
                    };

                    if (data.handle === 'all' || data.handle === obj.event) {
                        layer.confirm('是否对该<b>' + _type[type] + '</b>【' + data.content + '】的<span style="color: red;"><b>' + arr[obj.event] + '</b></span>进行解封？', {
                            btn: ['解封', '取消'],
                            btnAlign: 'c'
                        }, function (index) {
                            layer.close(index);
                            banHandle(type, obj.event + '_unban', data.content, 0, '', function (message) {
                                var handle = '';
                                if (data.handle === 'all') {
                                    handle = obj.event === 'login' ? 'reg' : 'login';
                                    obj.update({
                                        handle: handle
                                    });
                                }

                                layer.msg('解封成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                    if (handle === '') {
                                        obj.del();
                                    } else {
                                        othis.removeClass('layui-btn-danger').addClass('layui-btn-primary');
                                        othis.find('i').removeClass('fa-close').addClass('fa-check');
                                    }
                                });
                            });
                        });
                    } else {
                        layer.prompt({
                            formType: 2,
                            title: '<span style="color: red;"><b>封禁</b></span><b>' + _type[type] + '</b>【' + data.content + '】<span style="color: red;"><b>' + arr[obj.event] + '</b></span>，请填写备注：',
                            btn: ['封禁', '取消'],
                            btnAlign: 'c'
                        }, function (text, index, elem) {
                            banHandle(type, obj.event + '_ban', data.content, 0, text, function (message) {
                                layer.msg('封禁成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                    layer.close(index);

                                    obj.update({
                                        handle: data.handle ? 'all' : obj.event,
                                        notes: text
                                    });

                                    othis.removeClass('layui-btn-primary').addClass('layui-btn-danger');
                                    othis.find('i').removeClass('fa-check').addClass('fa-close');
                                });
                            });
                        });
                    }
                }
            });
        }

        /**
         * 封禁/解封公用方法
         * @param type 类型，IP/设备号/账号
         * @param handle 操作，封禁/解封
         * @param content 内容，单个/all
         * @param uid 用户ID
         * @param text 备注
         * @param callback 回调函数
         */
        function banHandle(type, handle, content, uid, text, callback) {
            var _index = layer.load();
            $.post("/?ct=user&ac=banHandle", {
                type: type,
                handle: handle,
                content: content,
                uid: uid,
                text: text
            }, function (ret) {
                layer.close(_index);
                if (ret.code === 1) {
                    if (typeof callback === 'function') {
                        callback(ret.message);
                    }
                } else {
                    layer.msg(ret.message,{icon: 5,shade:0.6,shadeClose:true});
                }
            }, "json");
        }
    });
</script>
<{include file="../public/foot.tpl"}>