<?php /* Smarty version 3.1.27, created on 2019-11-28 17:21:37
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/package_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3072355575ddf91a15c5496_09033631%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fbbffe18e6ab50ac812961f0bd03b3ebca8037d9' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/package_list.tpl',
      1 => 1571924670,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3072355575ddf91a15c5496_09033631',
  'variables' => 
  array (
    'widgets' => 0,
    '_channels' => 0,
    'id' => 0,
    'name' => 0,
    '_cdn_static_url_' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91a1612d86_53886431',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91a1612d86_53886431')) {
function content_5ddf91a1612d86_53886431 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3072355575ddf91a15c5496_09033631';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="container-fluid">
    <div class="row">
        <form method="post" action="" class="form-inline">
            <div class="form-group form-group-sm">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

                <label>选择平台</label>
                <select class="form-control" name="platform">
                    <option value="">全 部</option>
                    <option value="1">ios</option>
                    <option value="2">安卓</option>
                </select>
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
                <span id="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛选</span>

                <?php if (SrvAuth::checkPublicAuth('add',false)) {?>
                <span id="add" class="btn btn-info btn-sm"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加游戏包</span>
                <a href="/?ct=platform&ac=refreshProgress" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-clock-o fa-spin fa-fw" aria-hidden="true"></i>查看分包结果</a>
                <?php }?>
                <?php if (SrvAuth::checkPublicAuth('audit',false)) {?>
                <span id="refresh" class="btn btn-success btn-sm"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i>全部刷新配置</span>
                <?php }?>
                <?php if (SrvAuth::checkPublicAuth('del',false)) {?>
                <span id="del" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw" aria-hidden="true"></i>删除已关闭的分包</span>
                <?php }?>
            </div>
        </form>
    </div>
    <div class="row">
        <table id="LAY-table-report" lay-filter="report"></table>
        <input type="text" id="copy" value="" style="position: absolute;opacity:0;">
    </div>
</div>
<?php echo '<script'; ?>
 type="text/html" id="toolbar-report">
    <span class="btn btn-primary btn-xs" lay-event="edit"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>编辑</span>
    <span class="btn btn-info btn-xs" lay-event="config"><i class="fa fa-wrench fa-fw" aria-hidden="true"></i>配置</span>
    <?php if (SrvAuth::checkPublicAuth('del',false)) {?>
        <span class="btn btn-danger btn-xs" lay-event="del"><i class="fa fa-trash fa-fw" aria-hidden="true"></i>删除</span>
        <?php }?>
    {{# if(d.sdk_version != d.game_sdk_version){ }}
    <span class="btn btn-warning btn-xs" lay-event="upgrade"><i class="fa fa-arrow-circle-up fa-fw" aria-hidden="true"></i>升级</span>
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
        //version: '2019093020'
        version: false
    }).use('table', function () {
        var table = layui.table;

        var cols = [[
            {field: 'parent_name', width: 100, title: '母游戏', align: 'center'},
            {field:'game_name', width: 250, title: '子游戏'},
            {field:'package_name', width:250, title: '游戏包'},
            {field:'channel_name', width:100, title: '渠道', align: 'center'},
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
            {
                field: 'sdk_version',
                width: 100,
                title: 'SDK版本',
                align: 'center',
                templet: function (d) {
                    let str = '-';
                    if (d.sdk_version) {
                        str = '<span class="layui-badge layui-bg-gray">' + d.sdk_version + '</span>';
                        if (d.sdk_version !== d.game_sdk_version) {
                            str += '<span class="layui-badge-dot"></span>';
                        }
                    }
                    return str;
                }
            },
            {field:'package_size', width:100, title: '包大小', align: 'center'},
            {field: 'down_url', width: 500, title: '包下载地址', event: 'copy', style:'cursor: pointer;'},
            {
                field: 'create_time',
                width: 180,
                title: '创建时间',
                align: 'center',
                templet: function (d) {
                    return d.create_time > 0 ? layui.util.toDateString(d.create_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';
                }
            },
            {
                field: 'update_time',
                width: 180,
                title: '更新时间',
                align: 'center',
                templet: function (d) {
                    return d.update_time > 0 ? layui.util.toDateString(d.update_time * 1000, 'yyyy-MM-dd HH:mm:ss') : '-';
                }
            },
            {field:'admin_name', width:100, title: '操作者', align: 'center'},
            {minWidth: 250, title: '操作', toolbar: '#toolbar-report'}
        ]];

        var options = {
            elem: '#LAY-table-report',
            title: '游戏分包进度',
            url: '/?ct=platform&ac=packageList&json=1',
            cellMinWidth: 80,
            height: 'full-150',
            page: true,
            limit: 18,
            limits: [18, 50, 100, 200, 500],
            cols: cols,
            done: function (res, curr, count) {

            }
        };

        var tableIns = table.render(options);

        //监听行单击事件（单击事件为：rowDouble）
        table.on('row(report)', function (obj) {
            //标注选中样式
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });

        //监听工具条
        table.on('tool(report)', function (obj) {
            var othis = $(this),
                data = obj.data,
                layEvent = obj.event;

            switch (layEvent) {
                case 'copy': //复制
                    let input = $('#copy');
                    input.val(data.down_url);
                    input.select();
                    let boolean = document.execCommand("Copy");
                    if (boolean) {
                        layer.tips('复制成功', othis, {
                            tips: [4, '#3595CC'],
                            time: 2000
                        });
                    } else {
                        layer.tips('复制失败', othis, {
                            tips: [4, '#FF0000'],
                            time: 2000
                        });
                    }
                    break;
                case 'edit': //编辑
                    addPackage(data.id);
                    break;
                case 'config': //配置
                    layer.open({
                        type: 2,
                        title: '分包配置（仅对当前分包有效）',
                        shadeClose: false,
                        shade: 0.8,
                        area: is_mobile ? ['100%', '100%'] : ['30%', '40%'],
                        content: '/?ct=platform&ac=packagePay&game_id=' + data.game_id + '&package_name=' + data.package_name + '&platform=' + data.platform
                    });
                    break;
                case 'del': //删除
                    layer.confirm('确定删除包【' + data.package_name + '】吗？<br><br><span class="red">请确保该包没有在使用，删除后将无法恢复</span>', function (index) {
                        layer.close(index);
                        let _index = layer.load();
                        $.post('/?ct=platform&ac=delPackage', {
                            id: data.id
                        }, function (re) {
                            layer.close(_index);
                            if (re.state) {
                                obj.del();
                            } else {
                                layer.msg(re.msg);
                            }
                        }, 'json');
                    });
                    break;
                case 'upgrade': //升级
                    layer.confirm('确定升级包【' + data.package_name + '】吗？<br><br><span class="red">升级成功后，将自动推送到客户端升级版本</span>', function (index) {
                        layer.close(index);
                        let _index = layer.load();
                        $.post('/?ct=platform&ac=refreshPackage', {
                            game_id: data.game_id,
                            package_name: data.package_name
                        }, function (re) {
                            layer.close(_index);
                            if (re.state) {
                                layer.confirm('提交成功，正在升级中，是否查看进度？', function () {
                                    window.open('/?ct=platform&ac=refreshProgress&game_id=' + data.game_id + '&package_name=' + data.package_name, '_blank');
                                }, function () {
                                    tableIns.reload();
                                });
                            } else {
                                layer.msg(re.msg);
                            }
                        }, 'json');
                    });
                    break;
            }
        });

        //搜索
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

        //$('select').select2('destroy');

        //添加分包
        $('#add').on('click', function () {
            addPackage(0);
        });

        //全部刷新配置
        $('#refresh').on('click', function () {
            layer.confirm('确定全部刷新配置吗？', function (index) {
                layer.close(index);
                let _index = layer.msg('正在刷新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('/?ct=platform&ac=clearPackageCacheAll', function (re) {
                    layer.close(_index);
                    layer.alert(re.msg);
                }, 'json');
            });
        });

        //删除已关闭的分包
        $('#del').on('click', function () {
            layer.confirm('确定全部删除已经关闭游戏的分包吗？<br><br><span class="red">请确保分包没有在使用，删除后将无法恢复</span>', function (index) {
                layer.close(index);
                let _index = layer.load();
                $.post('/?ct=platform&ac=delPackageAll', function (re) {
                    layer.close(_index);
                    layer.alert(re.msg, function (index2) {
                        layer.close(index2);
                        if (re.state) {
                            tableIns.reload();
                        }
                    });
                }, 'json');
            });
        });

        //添加/编辑分包
        function addPackage(id) {
            layer.open({
                type: 2,
                title: '添加/编辑分包',
                shadeClose: false,
                shade: 0.8,
                area: is_mobile ? ['100%', '100%'] : ['30%', '70%'],
                content: '/?ct=platform&ac=addPackage&package_id=' + id
            });
        }
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>