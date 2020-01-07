<?php /* Smarty version 3.1.27, created on 2020-01-06 16:26:27
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/role_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13375656525e12ef334db7e7_82972089%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9139f43a9dfed909b6757fd5ac4b99c0f01cbaf2' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/role_list.tpl',
      1 => 1571924582,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13375656525e12ef334db7e7_82972089',
  'variables' => 
  array (
    'widgets' => 0,
    '_channels' => 0,
    'id' => 0,
    'name' => 0,
    '_cdn_static_url_' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e12ef335373a1_43192691',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e12ef335373a1_43192691')) {
function content_5e12ef335373a1_43192691 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13375656525e12ef334db7e7_82972089';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

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
                        <div class="row form-group-sm">
                            <div class="form-group">
                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

                            </div>

                            <div class="form-group">
                                <label>选择服务器</label>
                                <select class="form-control" name="server_id" id="server_id">
                                    <option value="">全 部</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>选择平台</label>
                                <select class="form-control" name="device_type">
                                    <option value="">全 部</option>
                                    <option value="1">ios</option>
                                    <option value="2">安卓</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>选择渠道</label>
                                <select class="form-control" name="channel_id">
                                    <option value="">全 部</option>
                                    <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>游戏包</label>
                                <select class="form-control" name="package_name" id="package_id">
                                    <option value="">全 部</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>角色名称</label>
                                <input type="text" class="form-control" name="role_name" value=""/>
                            </div>

                            <div class="form-group">
                                <label>用户账号</label>
                                <input type="text" class="form-control" name="username" value=""/>
                            </div>

                            <div class="form-group">
                                <label>注册时间</label>
                                <input type="text" name="sdate" value="" class="form-control Wdate" readonly/> -
                                <input type="text" name="edate" value="" class="form-control Wdate" readonly/>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="has_pay" value="1"/>只显示充值过的角色
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="has_phone" value="1"/>只显示绑定手机的玩家
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm" id="submit">
                                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                                </button>
                                <button type="button" class="btn btn-success btn-sm" id="down">
                                    <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <div class="rows">
        <table id="LAY-table-report" lay-filter="report"></table>
        <input type="text" id="copy" value="" style="position: absolute;opacity:0;">
    </div>
</div>
<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function () {
        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }

            $.getJSON('?ct=platform&ac=getGameServers&game_id=' + game_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html);
            });
        });

        $('select[name=game_id],select[name=device_type],select[name=channel_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var device_type = $('select[name=device_type] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&device_type=' + device_type + '&channel_id=' + channel_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html);
            });
        });

        $('#down').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=platform&ac=roleDownload',
                type: "POST",
                data: $('form').serializeArray(),
                dataType: "json",
                success: function (ret) {
                    layer.msg(ret.message);
                    if (ret.code == 1) {
                        setTimeout(function () {
                            window.location.href = ret.data.url;
                        }, 1500);
                    }
                },
                error: function (res) {
                    layer.msg('网络繁忙');
                }
            });
        });
    });

    layui.config({
        version: '2019082220',
    }).use('table', function () {
        var table = layui.table;
        var games = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['_games']->value);?>
');
        var channels = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['_channels']->value);?>
');
        var cols = [[
            {field:'uid', width:80, title: 'UID', align: 'center'},
            {field:'username', width:120, title: '账号', align: 'center'},
            {field:'phone', width:120, title: '手机号', align: 'center', hide: true},
            {field:'parent_name', width: 100, title: '母游戏', align: 'center', templet: function (d) {return games[d.parent_id];}},
            {field:'game_name', width: 150, title: '游戏', align: 'center', templet: function (d) {return games[d.game_id];}},
            {field:'package_name', width:250, title: '游戏包', align: 'center'},
            {
                field: 'device_type',
                width: 60,
                title: '平台',
                align: 'center',
                templet: function (d) {
                    let str = '-';
                    if (d.device_type == 3) {
                        str = '<i class="fa fa-html5 fa-lg text-primary" aria-hidden="true"></i>';
                    } else if (d.device_type == 2) {
                        str = '<i class="fa fa-android fa-lg text-success" aria-hidden="true"></i>';
                    } else if (d.device_type == 1) {
                        str = '<i class="fa fa-apple fa-lg text-info" aria-hidden="true"></i>';
                    }
                    return str;
                }
            },
            {field:'server_name', width:120, title: '区服', align: 'center'},
            {field:'role_name', width:120, title: '角色', align: 'center', event: 'copy', style:'cursor: pointer;'},
            {field:'role_level', width:60, title: '等级', align: 'center'},
            {
                field: 'total_time',
                width: 100,
                title: '升级用时',
                align: 'center',
                templet: function (d) {
                    var time = '-';
                    if (d.login_time > 0) {
                        time = d.login_time - d.create_time;
                        if (time >= 86400) {
                            time = Math.floor(time / 86400) + "天" + Math.ceil(((time % 86400) / 3600)) + "小时";
                        } else if (time >= 3600 && time < 86400) {
                            time = Math.floor(time / 3600) + "小时" + Math.ceil(((time % 3600) / 60)) + "分";
                        } else if (time >= 60 && time < 3600) {
                            time = Math.ceil(time / 60) + "分";
                        } else {
                            time = time + "秒";
                        }
                    }
                    return time;
                }
            },
            {field:'create_time', width:160, title: '创建时间', align: 'center', templet: function (d) {return d.create_time > 0 ? layui.util.toDateString(d.create_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
            {field:'pays', width:80, title: '总充值', align: 'center', style:'color:#a94442;', templet: function (d) {return d.pays > 0 ? d.pays / 100 : '-';}},
            {field:'pay_time', width:160, title: '最后充值时间', align: 'center', templet: function (d) {return d.pay_time > 0 ? layui.util.toDateString(d.pay_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
            {field:'reg_city', width:100, title: '注册地区', align: 'center'},
            {field:'reg_ip', width:140, title: '注册IP', align: 'center'},
            {field:'reg_time', width:160, title: '注册时间', align: 'center', templet: function (d) {return d.reg_time > 0 ? layui.util.toDateString(d.reg_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';}},
            {field:'channel_name', width:100, title: '渠道', align: 'center', templet: function (d) {return channels[d.channel_id];}},
            {field:'monitor_name', width:300, title: '来源', align: 'center'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '用户管理',
            url: '/?ct=platform&ac=roleList&json=1',
            cellMinWidth: 80,
            height: 'full-180',
            page: true,
            limit: 17,
            limits: [17, 50, 100, 200, 500],
            cols: cols
        };

        var tableIns = table.render(options);

        //筛选
        $('#submit').on('click', function () {
            if ($('input[name="has_phone"]').prop("checked")) {
                cols[0][2]['hide'] = false;
            } else {
                cols[0][2]['hide'] = true;
            }

            tableIns.reload({
                cols: cols,
                where: {
                    data: $('form').serialize()
                },
                page: {
                    curr: 1
                }
            });
        });

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        //监听工具条
        table.on('tool(report)', function (obj) {
            var $this = $(this);
            var data = obj.data;
            var layEvent = obj.event;

            switch (layEvent) {
                case 'copy': //复制
                    var input = $('#copy');
                    input.val(data.role_name);
                    input.select();
                    var boolean = document.execCommand("Copy");
                    if (boolean) {
                        layer.tips('复制成功', $this, {
                            tips: [4, '#3595CC'],
                            time: 2000
                        });
                    } else {
                        layer.tips('复制失败', $this, {
                            tips: [4, '#FF0000'],
                            time: 2000
                        });
                    }
                    break;
            }
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>