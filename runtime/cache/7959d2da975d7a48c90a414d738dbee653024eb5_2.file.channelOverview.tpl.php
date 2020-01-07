<?php /* Smarty version 3.1.27, created on 2019-11-28 20:27:26
         compiled from "/home/vagrant/code/admin/web/admin/template/adData/channelOverview.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11342914095ddfbd2eb26739_77498399%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7959d2da975d7a48c90a414d738dbee653024eb5' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adData/channelOverview.tpl',
      1 => 1571368482,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11342914095ddfbd2eb26739_77498399',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'id' => 0,
    'name' => 0,
    'day' => 0,
    'day_ltv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddfbd2eb844f2_71033784',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddfbd2eb844f2_71033784')) {
function content_5ddfbd2eb844f2_71033784 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11342914095ddfbd2eb26739_77498399';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
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
                                <label>渠道</label>
                                <select class="form-control" name="channel_id[]" id="channel_id" style="width: 50px;" multiple="multiple">
                                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_channels'];
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
" <?php if ((is_array($_smarty_tpl->tpl_vars['data']->value['channel_id']) && in_array($_smarty_tpl->tpl_vars['id']->value,$_smarty_tpl->tpl_vars['data']->value['channel_id'])) || $_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>投放账号</label>
                                <select class="form-control" name="user_id[]" id="user_id" style="width: 150px;" multiple="multiple">
                                </select>
                            </div>

                            <div class="form-group">
                                <label>推广活动</label>
                                <select class="form-control" name="monitor_id[]" id="monitor_id" style="width: 150px;" multiple="multiple">
                                </select>
                            </div>

                            <div class="form-group">
                                <label>投放组</label>
                                <select class="form-control" name="group_id[]" id="group_id" style="width: 40px;" multiple="multiple">
                                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_groups'];
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
" <?php if ((is_array($_smarty_tpl->tpl_vars['data']->value['group_id']) && in_array($_smarty_tpl->tpl_vars['id']->value,$_smarty_tpl->tpl_vars['data']->value['group_id'])) || $_smarty_tpl->tpl_vars['data']->value['group_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>手机系统</label>
                                <select class="form-control" name="device_type" style="width: 50px;">
                                    <option value="">全 部</option>
                                    <option value="1"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>>IOS</option>
                                    <option value="2"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>>Android</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>注册日期</label>
                                <input type="text" name="rsdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['rsdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;" readonly/>
                                -
                                <input type="text" name="redate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['redate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;" readonly/>
                            </div>

                            <div class="form-group">
                                <label>充值日期</label>
                                <input type="text" name="psdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['psdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;" readonly/>
                                -
                                <input type="text" name="pedate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['pedate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" style="width: 100px;" readonly/>
                            </div>

                            <div class="form-group">
                                <label>归类方式</label>
                                <select class="form-control" name="type">
                                    <option value="8"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 8) {?>selected="selected"<?php }?>>按母游戏</option>
                                    <option value="1"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 1) {?>selected="selected"<?php }?>>按子游戏</option>
                                    <option value="2"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 2) {?>selected="selected"<?php }?>>按手机系统</option>
                                    <option value="3"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 3) {?>selected="selected"<?php }?>>按渠道</option>
                                    <option value="4"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 4) {?>selected="selected"<?php }?>>按账号</option>
                                    <option value="5"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 5) {?>selected="selected"<?php }?>>按推广活动</option>
                                    <option value="6"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 6) {?>selected="selected"<?php }?>>按投放组</option>
                                    <option value="7"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 7) {?>selected="selected"<?php }?>>按注册日期</option>
                                    <option value="9"
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 9) {?>selected="selected"<?php }?>>按注册月份</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm" id="submit">
                                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
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
        <?php echo '<script'; ?>
 type="text/html" id="toolbar-report">
            <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="page">
                    <i class="layui-icon">&#xe60a;</i><span>不分页显示</span></button>
                <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="size">
                    <i class="layui-icon">&#xe608;</i><span>小尺寸显示</span></button>
            </div>
        <?php echo '</script'; ?>
>
    </div>
</div>
<?php echo '<script'; ?>
>
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
        var day = JSON.parse('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['day']->value, ENT_QUOTES, 'UTF-8');?>
');
        var day_ltv = JSON.parse('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['day_ltv']->value, ENT_QUOTES, 'UTF-8');?>
');
        var table = layui.table;
        var tr = [];
        var tr1 = [
            {title: '序号', type:'numbers', rowspan: 2, fixed: 'left'},
            {field: 'group_name', minWidth:150, title: '名称', align: 'center', sort: true, rowspan: 2, fixed: 'left', totalRowText: '合计'},
            {title: '转化数据', align: 'center', colspan: 12},
            {title: '首日付费数据', align: 'center', colspan: 6},
            {title: '周期付费数据', align: 'center', colspan: 4},
            {title: '累计付费数据', align: 'center', colspan: 4},
            {title: '活跃付费数据', align: 'center', colspan: 2},
            {title: '运营数据', align: 'center', colspan: 27},
        ];
        var tr2 = [
            {title:'序号', type:'numbers', fixed: 'left'},
            {field:'group_name', minWidth:150, title: '名称', align: 'center', sort: true, fixed: 'left', totalRowText: '合计'},
            {field:'load', width:80, title: '加载数', align: 'center', sort: true},
            {field:'ip', width:80, title: 'IP数', align: 'center', sort: true},
            {field:'click', width:80, title: '点击', align: 'center', sort: true},
            {field:'active', width:80, title: '激活数', align: 'center', sort: true},
            {field:'active_device', width:120, title: '激活设备数', align: 'center', sort: true},
            {field:'click_active_rate', width:120, title: '点击激活率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'reg', width:100, title: '注册数', align: 'center', sort: true, sortRow: 'reg_sort'},
            {field:'new_game_user', width:120,title:'注册数-老用户',align:'center',sort:true},
            {field:'device', width:120, title: '注册设备数', align: 'center', sort: true},
            {field:'click_reg_rate', width:120, title: '点击注册率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'active_reg_rate', width:120, title: '激活注册率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'consume_str', width:120, title: '消耗', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'consume'},
            {field:'reg_cost', width:100, title: '注册单价', align: 'center', sort: true},
            {field:'new_pay_money_str', width:120, title: '新增付费额', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'new_pay_money'},
            {field:'new_game_money_str',width:120,title:'新增付费额-老用户',align:'center',sort:true,style:'color:#a94442',sortRow:'new_game_money'},
            {field:'new_pay_back_rate', width:120, title: '新增回本率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'new_pay_count', width:120, title: '新增付费人数', align: 'center', sort: true, sortRow: 'new_pay_count_sort'},
            {field:'new_game_pay',width:120,title:'新增付费人数-老用户',align:'center',sort:true},
            {field:'new_pay_rate', width:120, title: '新增付费率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'new_pay_arpu', width:120, title: '新增ARPU', align: 'center', sort: true},
            {field:'new_pay_arppu', width:120, title: '新增ARPPU', align: 'center', sort: true},
            {field:'period_pay_money_str', width:120, title: '周期付费额', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'period_pay_money'},
            {field:'period_pay_back_rate', width:120, title: '周期回本率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'period_pay_count', width:120, title: '周期付费人数', align: 'center', sort: true},
            {field:'period_pay_rate', width:120, title: '周期付费率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'total_pay_money_str', width:120, title: '累计付费额', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'total_pay_money'},
            {field:'total_pay_back_rate', width:120, title: '累计回本率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'total_pay_count', width:120, title: '累计付费人数', align: 'center', sort: true, sortRow: 'total_pay_count_sort'},
            {field:'total_pay_rate', width:120, title: '累计付费率', align: 'center', sort: true, style:'color: #3d9970;'},
            {field:'active_pay_count', width:120, title: '活跃付费人数', align: 'center', sort: true, sortRow: 'active_pay_count_sort'},
            {field:'active_pay_money_str', width:120, title: '活跃付费金额', align: 'center', sort: true, style:'color: #a94442;', sortRow: 'active_pay_money'},
        ];

        $.each(day, function (i, d) {
            if (d == 1) return true;
            tr2.push({field: 'retain_rate' + d, width: 100, title: d + '日留存', align: 'center', sort: true, style:'color: #3d9970;'});
        });
        $.each(day, function (i, d) {
            tr2.push({field:'ltv_roi' + d, width:150, title: 'LTV' + d + ' / ROI' + d, align: 'center', sort: true, sortRow: 'ltv_roi_sort' + d});
        });

        //tr.push(tr1);
        tr.push(tr2);

        var options = {
            elem: '#LAY-table-report',
            title: '推广数据总表',
            toolbar: '#toolbar-report',
            data: [],
            cellMinWidth: 80,
            height: 'full-190',
            totalRow: true,
            page: true,
            limit: 15,
            limits: [15, 50, 100, 200, 500],
            cols: tr,
        };

        var tableIns = table.render($.extend(options, getOptions()));

        $('#submit').on('click', function () {
            layer.load();
            $.post('?ct=adData&ac=channelOverview', {
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>