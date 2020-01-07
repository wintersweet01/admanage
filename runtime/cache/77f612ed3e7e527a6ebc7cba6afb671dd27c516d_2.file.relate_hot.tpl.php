<?php /* Smarty version 3.1.27, created on 2019-12-19 10:14:22
         compiled from "/home/vagrant/code/admin/web/admin/template/user/relate_hot.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1219801605dfadcfe307218_80221398%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77f612ed3e7e527a6ebc7cba6afb671dd27c516d' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/user/relate_hot.tpl',
      1 => 1571040603,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1219801605dfadcfe307218_80221398',
  'variables' => 
  array (
    '_cdn_static_url_' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5dfadcfe3358e4_59058479',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5dfadcfe3358e4_59058479')) {
function content_5dfadcfe3358e4_59058479 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1219801605dfadcfe307218_80221398';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="layui-fluid">
    <div class="layui-tab layui-tab-brief" lay-filter="relate-hot">
        <ul class="layui-tab-title">
            <li class="layui-this" lay-id="ip">IP关联排行</li>
            <li lay-id="device">设备号关联排行</li>
        </ul>
        <div class="layui-tab-content">
            <div>
                <form class="form-inline">
                    <label>关联数：</label>
                    <input type="text" class="form-control input-sm" name="num" value="10" placeholder="" style="width: 100px;"/>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="whitelist" value="1">显示标记正常
                    </label>
                    <span id="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>搜索</span>
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
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/html" id="toolbar-list">
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
    {{# if(d.content){ }}
    <span class="layui-btn layui-btn-xs" lay-event="white"><i class="fa fa-check fa-fw" aria-hidden="true"></i>正常</span>
    {{# } else { }}
    <span class="layui-btn layui-btn-xs layui-btn-primary" lay-event="white"><i class="fa fa-thumb-tack fa-fw" aria-hidden="true"></i>标记</span>
    {{# } }}
    <span class="layui-btn layui-btn-xs layui-btn-normal" lay-event="ban-user"><i class="fa fa-ban fa-fw" aria-hidden="true"></i>一键解/封禁账号</span>
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/html" id="toolbar-info">
    <span class="layui-btn layui-btn-xs layui-btn-warm" lay-event="kick"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>踢下线</span>
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-xs" lay-event="ban"><i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封</span>
    {{# } else { }}
    <span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="ban"><i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁</span>
    {{# } }}
    {{# if(d.content){ }}
    <span class="layui-btn layui-btn-xs" lay-event="white"><i class="fa fa-check fa-fw" aria-hidden="true"></i>正常</span>
    {{# } else { }}
    <span class="layui-btn layui-btn-xs layui-btn-primary" lay-event="white"><i class="fa fa-thumb-tack fa-fw" aria-hidden="true"></i>标记</span>
    {{# } }}
<?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui-2.5/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui-2.5/layui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
    layui.config({
        version: '2019092312'
    }).extend({
        tableChild: '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui-2.5/ext/tableChild'
    }).use(['element', 'form', 'table', 'tableChild'], function () {
        var $ = layui.jquery,
            element = layui.element,
            table = layui.table,
            tableChild = layui.tableChild,
            _type = {
                'ip': 'IP',
                'device': '设备号'
            };

        $.each(_type, function (type, name) {
            setTableList(type);
        });

        //搜索
        $('#submit').on('click', function () {
            var num = parseInt($('input[name="num"]').val()),
                whitelist = $("input[name='whitelist']").prop("checked") ? 1 : 0;

            if (!num) {
                return false;
            }

            $.each(_type, function (type, name) {
                table.reload('table-report-' + type, {
                    where: {
                        num: num,
                        whitelist: whitelist
                    },
                    page: {
                        curr: 1
                    }
                });
            });
        });

        //列表
        function setTableList(type) {
            var cols = [],
                _cols = [{
                    field: 'group_name',
                    title: _type[type],
                    width: type === 'device' ? 400 : 200,
                    children: function (row) {
                        return setRelateUser(type, row.group_name);
                    },
                }];

            if (type === 'ip') {
                _cols.push({field: 'area',title: '地区',width: 300});
            }

            _cols.push({field: 'count',title: '关联账号数',width: 100,align: 'center'});
            _cols.push({title: '操作',minWidth: 340,toolbar: '#toolbar-list'});

            cols.push(_cols);

            var options = {
                elem: '#table-report-' + type,
                url: '/?ct=user&ac=getRelateHotList',
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
                    var o = $('.layui-tab li[lay-id="' + type + '"]');
                    o.find('span').remove();
                    o.append('<span class="layui-badge layui-bg-gray">' + count + '</span>');

                    tableChild.render(this);
                }
            };

            table.render(options);

            //监听行工具条事件
            table.on('tool(report-' + type + ')', function (obj) {
                var othis = $(this),
                    data = obj.data,
                    tr = obj.tr,
                    childId = 'table-report-' + type + data.index + '0'; //子表ID

                if (obj.event === 'login' || obj.event === 'reg') {
                    var arr = {
                        'login': '登录',
                        'reg': '注册'
                    };

                    if (data.handle === 'all' || data.handle === obj.event) {
                        layer.confirm('是否对该<b>' + _type[type] + '</b>【' + data.group_name + '】的<span style="color: red;"><b>' + arr[obj.event] + '</b></span>进行解封？', {
                            btn: ['解封', '取消'],
                            btnAlign: 'c'
                        }, function (index) {
                            layer.close(index);
                            banHandle(type, obj.event + '_unban', data.group_name, 0, '', function (message) {
                                var handle = '';
                                if (data.handle === 'all') {
                                    handle = obj.event === 'login' ? 'reg' : 'login';
                                }
                                obj.update({
                                    handle: handle
                                });

                                layer.msg('解封成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                    othis.removeClass('layui-btn-danger').addClass('layui-btn-primary');
                                    othis.find('i').removeClass('fa-close').addClass('fa-check');
                                });
                            });
                        });
                    } else {
                        layer.prompt({
                            formType: 2,
                            title: '<span style="color: red;"><b>封禁</b></span><b>' + _type[type] + '</b>【' + data.group_name + '】<span style="color: red;"><b>' + arr[obj.event] + '</b></span>，请填写备注：',
                            btn: ['封禁', '取消'],
                            btnAlign: 'c'
                        }, function (text, index, elem) {
                            banHandle(type, obj.event + '_ban', data.group_name, 0, text, function (message) {
                                layer.msg('封禁成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                    layer.close(index);

                                    obj.update({
                                        handle: data.handle ? 'all' : obj.event
                                    });

                                    othis.removeClass('layui-btn-primary').addClass('layui-btn-danger');
                                    othis.find('i').removeClass('fa-check').addClass('fa-close');
                                });
                            });
                        });
                    }
                } else if (obj.event === 'ban-user') {
                    if (!layui.table.cache[childId]) {
                        layer.alert('请先展开当前子表格后再操作');
                        return false;
                    }

                    layer.confirm('对<b>' + _type[type] + '</b>【' + data.group_name + '】下的所有账号进行封禁/解封。（标记正常除外）', {
                        btn: ['一键封禁', '一键解封', '取消'],
                        btnAlign: 'c'
                    }, function (index1, layero) { //封禁
                        layer.close(index1);
                        layer.prompt({
                            formType: 2,
                            title: '正在<span style="color: red;"><b>封禁</b></span><b>' + _type[type] + '</b>【' + data.group_name + '】下的所有账号，请填写备注：',
                            btn: ['封禁', '取消'],
                            btnAlign: 'c'
                        }, function (text, index2, elem) {
                            banHandle(type, 'user_ban_all', data.group_name, 0, text, function (message) {
                                layer.msg('封禁成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                    layer.close(index2);

                                    //重新加载子表格
                                    table.reload(childId);
                                });
                            });
                        });
                        return false;
                    }, function (index1, layero) { //解封
                        layer.close(index1);
                        banHandle(type, 'user_unban_all', data.group_name, 0, '', function (message) {
                            layer.msg('解封成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                //重新加载子表格
                                table.reload(childId);
                            });
                        });
                        return false;
                    });
                } else if (obj.event === 'white') {
                    var handle = data.content ? 'del' : 'add';
                    whiteHandle(type, handle, data.group_name, function (message) {
                        obj.update({
                            content: data.content ? false : data.group_name
                        });

                        if (data.content) {
                            othis.addClass('layui-btn-primary');
                            othis.html('<i class="fa fa-thumb-tack fa-fw" aria-hidden="true"></i>标记');
                        } else {
                            othis.removeClass('layui-btn-primary');
                            othis.html('<i class="fa fa-check fa-fw" aria-hidden="true"></i>正常');
                        }
                    });
                }
            });
        }

        //关联账号表格
        function setRelateUser(type, content) {
            return [{
                title: '关联账号列表',
                url: '/?ct=user&ac=getUserRelateInfo',
                where: {
                    type: type,
                    content: content,
                },
                cellMinWidth: 80,
                height: 550,
                page: true,
                limit: 15,
                limits: [15, 50, 100, 200, 500],
                cols: [[
                    {field: 'uid',title: 'UID',width: 80},
                    {field: 'username',title: '账号',width: 150,event: 'showUserInfo',style:'cursor: pointer;'},
                    {field: 'total_pay_money',title: '总充值',width: 80,align: 'center',style:'color:#a94442;',templet: function (d) {return d.total_pay_money > 0 ? Math.round(d.total_pay_money/100) : '-';}},
                    {field: 'reg_time',title: '注册时间',width: 160,templet: function (d) {return d.reg_time > 0 ? layui.util.toDateString(d.reg_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
                    {field: 'reg_ip',title: '注册IP',width: 140},
                    {field: 'reg_area',title: '注册地区',width: 220},
                    {field: 'last_login_time',title: '最后登录时间',width: 160,templet: function (d) {return d.last_login_time > 0 ? layui.util.toDateString(d.last_login_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
                    {field: 'last_login_ip',title: '最后登录IP',width: 140},
                    {
                        field: 'last_login_area',
                        title: '最后登录地区',
                        width: 220,
                        templet: function (d) {
                            var str = '';
                            if (d.last_login_area) {
                                str = d.last_login_area;
                                if (d.reg_country !== d.last_login_country) {
                                    str = '<span style="color:red;">' + d.last_login_area + '</span>';
                                }
                            }
                            return str;
                        }
                    },
                    {title: '操作',minWidth: 250,toolbar: '#toolbar-info'}
                ]],
                toolEvent: function (obj, pdata, othis) {
                    var data = obj.data,
                        tr = obj.tr,
                        childId = this.id;

                    switch (obj.event) {
                        case 'showUserInfo': //查用户信息
                            JsMain.search(data.uid);
                            break;
                        case 'kick':
                            layer.confirm('确定踢UID为【' + data.uid + '】的用户下线吗？', function () {
                                var index = layer.load();
                                $.post('?ct=user&ac=kickUser', {
                                    uid: data.uid
                                }, function (ret) {
                                    layer.close(index);
                                    if (ret.code === 1) {
                                        layer.alert('用户已被踢下线', {
                                            skin: 'layui-layer-molv',
                                            closeBtn: 1
                                        });
                                    } else {
                                        layer.msg(ret.message);
                                    }
                                }, 'json');
                            });
                            break;
                        case 'ban':
                            if (data.status === '1') {
                                layer.confirm('确定<span style="color: red;"><b>解封</b></span>UID为【' + data.uid + '】的用户吗？', function () {
                                    banHandle('user', 'user_unban', data.uid, 0, '', function (message) {
                                        layer.msg('解封成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                            obj.update({
                                                status: data.status === '1' ? '0' : '1'
                                            });

                                            othis.html('<i class="fa fa-ban fa-fw" aria-hidden="true"></i>封禁');
                                            othis.addClass('layui-btn-danger');
                                        });
                                    });
                                });
                            } else {
                                layer.prompt({
                                    formType: 2,
                                    title: '确定<span style="color: red;"><b>封禁</b></span>UID为【' + data.uid + '】的用户吗？'
                                }, function (text, index, elem) {
                                    banHandle('user', 'user_ban', data.uid, 0, text, function (message) {
                                        layer.msg('封禁成功' + message,{icon: 6,shade:0.6,shadeClose:true}, function () {
                                            layer.close(index);

                                            obj.update({
                                                status: data.status === '1' ? '0' : '1'
                                            });

                                            othis.html('<i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>解封');
                                            othis.removeClass('layui-btn-danger');
                                        });
                                    });
                                });
                            }
                            break;
                        case 'white':
                            var handle = data.content ? 'del' : 'add';
                            whiteHandle('user', handle, data.uid, function (message) {
                                obj.update({
                                    content: data.content ? false : data.uid
                                });

                                if (data.content) {
                                    othis.addClass('layui-btn-primary');
                                    othis.html('<i class="fa fa-thumb-tack fa-fw" aria-hidden="true"></i>标记');
                                } else {
                                    othis.removeClass('layui-btn-primary');
                                    othis.html('<i class="fa fa-check fa-fw" aria-hidden="true"></i>正常');
                                }
                            });
                            break;
                    }
                },
                done: function () {

                }
            }];
        }

        /**
         * 标记白名单公用方法
         * @param type 类型
         * @param handle 操作
         * @param content 内容
         * @param callback 回调函数
         */
        function whiteHandle(type, handle, content, callback) {
            var _index = layer.load();
            $.post("/?ct=user&ac=whiteHandle", {
                type: type,
                handle: handle,
                content: content
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>