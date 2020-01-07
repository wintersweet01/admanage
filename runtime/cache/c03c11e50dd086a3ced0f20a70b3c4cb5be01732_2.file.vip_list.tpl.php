<?php /* Smarty version 3.1.27, created on 2019-11-29 11:24:39
         compiled from "/home/vagrant/code/admin/web/admin/template/service/vip_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13999306195de08f77dafe49_63846863%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c03c11e50dd086a3ced0f20a70b3c4cb5be01732' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/service/vip_list.tpl',
      1 => 1561530714,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13999306195de08f77dafe49_63846863',
  'variables' => 
  array (
    'widgets' => 0,
    '_admins' => 0,
    'key' => 0,
    'data' => 0,
    'rows' => 0,
    'row' => 0,
    '_games' => 0,
    'status' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08f77e1f545_71402034',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08f77e1f545_71402034')) {
function content_5de08f77e1f545_71402034 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13999306195de08f77dafe49_63846863';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style>
    label {
        /*margin-left: 5px;*/
    }
</style>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <form method="get" action="" id="myForm" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="vipManage"/>

            <div class="form-group">
                <label>选择游戏：</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择归属人：</label>
                <select name="belong_id">
                    <option value="">全部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_admins']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['rows'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['rows']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['rows']->value) {
$_smarty_tpl->tpl_vars['rows']->_loop = true;
$foreach_rows_Sav = $_smarty_tpl->tpl_vars['rows'];
?>
                <option <?php if ($_smarty_tpl->tpl_vars['key']->value == $_smarty_tpl->tpl_vars['data']->value['belong_id']) {?>selected="selected"<?php }?> value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['rows']->value['name'], ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['rows'] = $foreach_rows_Sav;
}
?>
                </select>

                <label>选择录入人：</label>
                <select name="insr_id">
                    <option value="">全部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_admins']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['rows'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['rows']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['rows']->value) {
$_smarty_tpl->tpl_vars['rows']->_loop = true;
$foreach_rows_Sav = $_smarty_tpl->tpl_vars['rows'];
?>
                <option <?php if ($_smarty_tpl->tpl_vars['key']->value == $_smarty_tpl->tpl_vars['data']->value['insr_id']) {?>selected="selected"<?php }?> value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['rows']->value['name'], ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['rows'] = $foreach_rows_Sav;
}
?>
                </select>

                <label>颜色选择</label>
                <select name="list_color" class="list-color">
                    <option value="">全部</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['list_color'] == 1) {?>selected="selected"<?php }?> >绿色</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['list_color'] == 2) {?>selected="selected"<?php }?> >黄色</option>
                    <option value="3" <?php if ($_smarty_tpl->tpl_vars['data']->value['list_color'] == 3) {?>selected="selected"<?php }?> >粉色</option>
                </select>

                <label>账号：</label>
                <input type="text" name="account" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['account'], ENT_QUOTES, 'UTF-8');?>
">

                <label>用户ID：</label>
                <input type="text" name="uid" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['uid'], ENT_QUOTES, 'UTF-8');?>
">
                <label>日期：</label>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/> ~
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs">筛 选</button>
                <button type="button" class="btn btn-success btn-xs download">导 出</button>
            </div>
        </form>
        <div class="rows" style="margin-bottom: 0.8%">
            <span class="text-success">绿色：5天未充值</span>&nbsp;
            <span class="text-yellow">黄色：10天未充值</span>&nbsp;
            <span style="color: #FF82AB">粉色：30天未充值</span>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;">
        <?php if (SrvAuth::checkPublicAuth('add',false)) {?>
        <a href="?ct=kfVip&ac=vipInsr" role="button">
            <span class="btn btn-sm btn-success glyphicon glyphicon-plus">VIP录入</span>
            <?php }?>
        </a>
        <?php if (SrvAuth::checkPublicAuth('del',false)) {?>
        <button class="btn btn-sm btn-danger glyphicon glyphicon-trash batch-del">
            批量删除
        </button>
        <?php }?>
        <?php if (SrvAuth::checkPublicAuth('edit',false)) {?>
        <button class="btn btn-sm btn-warning glyphicon glyphicon-check batch-pass">
            批量审核
        </button>
        <?php }?>
        <span style="margin-left: 16px;position: relative;top: 2px;">共：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['total'], ENT_QUOTES, 'UTF-8');?>
条</span>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff" id="tableDiv">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive"
                       style="min-width: 150px;">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="batch-check" title="全选"/></th>
                        <th>母游戏:平台</th>
                        <th>账号</th>
                        <th>用户ID</th>
                        <th>角色名</th>
                        <th>区服</th>
                        <th>联系时间</th>
                        <th>归属人</th>
                        <th>录入人</th>
                        <th>录入时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['row']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$foreach_row_Sav = $_smarty_tpl->tpl_vars['row'];
?>
                    <tr
                        <?php if ($_smarty_tpl->tpl_vars['row']->value['status'] == 2) {?>
                        <?php if ($_smarty_tpl->tpl_vars['row']->value['pay_day_ret'] >= 5 && $_smarty_tpl->tpl_vars['row']->value['pay_day_ret'] < 10) {?>
                        style="background-color:#3c763d"
                        <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['pay_day_ret'] >= 10 && $_smarty_tpl->tpl_vars['row']->value['pay_day_ret'] < 30) {?>
                        style="background-color:#f39c12"
                        <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['pay_day_ret'] >= 30) {?>
                        style="background-color:#FF82AB"
                        <?php }?>
                        <?php }?> >
                        <td><input type="checkbox" class="total_check" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id'], ENT_QUOTES, 'UTF-8');?>
"/></td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['row']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
:<?php if ($_smarty_tpl->tpl_vars['row']->value['platform'] == 1) {?>IOS<?php } else { ?>安卓<?php }?></td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['account'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['uid'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['rolename'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['server_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['touch_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_admins']->value[$_smarty_tpl->tpl_vars['row']->value['admin_id']]['name'], ENT_QUOTES, 'UTF-8');?>

                        </td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_admins']->value[$_smarty_tpl->tpl_vars['row']->value['insr_kefu']]['name'], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['insr_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                    <td <?php if ($_smarty_tpl->tpl_vars['row']->value['status'] == 2) {?>class=""<?php }?> ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['status']->value[$_smarty_tpl->tpl_vars['row']->value['status']], ENT_QUOTES, 'UTF-8');?>
</td>
                        <td>
                            <a href="?ct=kfVip&ac=vipInsr&game_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id'], ENT_QUOTES, 'UTF-8');?>
"
                               class="btn btn-success btn-xs" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id'], ENT_QUOTES, 'UTF-8');?>
">查看</a>
                            |
                            <button class="btn btn-danger btn-xs cancel" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id'], ENT_QUOTES, 'UTF-8');?>
">撤销</button>
                        </td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
                    </tbody>
                </table>
            </div>
            <div>
                <nav>
                    <ul class="pagination">
                        <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        $('.check-req').on('click', function () {
            var data = {
                'type': $(this).attr('hand_type'),
                'data_id': $(this).attr('data-id')
            };
            $.ajax({
                type: 'post',
                url: '?ct=kfVip&ac=check',
                data: data,
                dataType: 'json',
                success: function (e) {
                    if (e.code == 200) {
                        layer.alert('更新成功', {icon: 6}, function () {
                            window.location.reload();
                        });
                    } else {
                        layer.alert(e.msg, {icon: 5});
                    }
                }
            });
        });

        $(".batch-check").on('click', function () {
            var _this = $(this);
            if (_this.prop('checked')) {
                $(".total_check").prop("checked", true);
            } else {
                $(".total_check").prop("checked", false);
            }
        });

        $(".batch-del").on('click', function () {
            var batch_check = [];
            var _this = $(this);
            $(".total_check").each(function () {
                if ($(this).prop('checked')) {
                    batch_check.push($(this).val())
                }
            });
            if (batch_check.length > 0) {
                layer.confirm('确认删除？', function () {
                    $.ajax({
                        type: 'post',
                        url: '?&ct=kfVip&ac=batch_del',
                        dataType: 'json',
                        data: {
                            'ids': batch_check
                        },
                        beforeSend: function () {
                            _this.attr('disabled', true);
                            _this.addClass('disabled');
                        },
                        success: function (re) {
                            console.log(re);
                            layer.msg(re.msg, {
                                icon: 1,
                                time: 1000
                            });
                            window.location.reload();
                        },
                        complete: function () {
                            _this.attr('disabled', false);
                            _this.removeClass('disabled');
                        }
                    })
                })
            }
        });

        $(".cancel").on('click', function () {
            var _this = $(this);
            layer.confirm('确认删除？', function () {
                $.ajax({
                    type: 'post',
                    url: '?ct=kfVip&ac=cancel',
                    data: {
                        'data_id': _this.attr('data-id')
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        _this.attr('disabled', true);
                        _this.addClass('disabled');
                    },
                    success: function (re) {
                        if (re.state) {
                            layer.alert(re.msg, {icon:6}, function () {
                                window.location.reload();
                            })
                        } else {
                            layer.alert(re.msg, {icon:5})
                        }
                    },
                    complete: function () {
                        _this.attr('disabled', false);
                        _this.addClass('disabled');
                    }
                });
                layer.close(index);
            });
        });

        $(".batch-pass").on('click',function(){
            layer.confirm('确认审核已勾选？',function(){
                layer.closeAll();
                var checkid = [];
                var _this = $(this);
                $(".total_check").each(function () {
                    if ($(this).prop('checked')) {
                        checkid.push($(this).val())
                    }
                });
                $.ajax({
                    type:'post',
                    dateType:'json',
                    url:'?ct=kfVip&ac=batch_pass',
                    data:{
                        'ids':checkid
                    },
                    beforeSend:function(){
                        _this.attr('disabled', true);
                        _this.addClass('disabled');
                    },
                    success:function(e){
                        var re = JSON.parse(e);
                        if(re.state == 1){
                            layer.alert(re.msg, {icon:6}, function () {
                                window.location.reload();
                            })
                        }
                    },
                    complete:function(){
                        _this.attr('disabled', false);
                        _this.addClass('disabled');
                    }
                })
            })
        });

        $(".list-color").change(function(){
            $("#myForm").submit();
        });

        //导出
        $('.download').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=kfVip&ac=vipListDownload',
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
    })
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php }
}
?>