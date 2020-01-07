<?php /* Smarty version 3.1.27, created on 2019-11-28 17:22:28
         compiled from "/home/vagrant/code/admin/web/admin/template/data/payHall.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10617264665ddf91d4ca3455_38373789%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '247013357eef1d4c6f6673d51c8a376612b3c4a5' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/data/payHall.tpl',
      1 => 1571044987,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10617264665ddf91d4ca3455_38373789',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'id' => 0,
    'name' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91d4cfcfd5_22165110',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91d4cfcfd5_22165110')) {
function content_5ddf91d4cfcfd5_22165110 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10617264665ddf91d4ca3455_38373789';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="payHall"/>
            <div class="form-group form-group-sm">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择服务器</label>
                <select class="form-control" name="server_id" id="server_id">
                    <option value="0">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_servers'];
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['query']['server_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>选择平台</label>
                <select class="form-control" name="device_type" style="width: 50px;">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['query']['device_type'] == 1) {?>selected="selected"<?php }?>> ios </option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['query']['device_type'] == 2) {?>selected="selected"<?php }?>> 安卓 </option>
                </select>

                <label>充值金额</label>
                <input type="number" class="form-control" name="s_charge" style="width:100px" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['query']['s_charge'], ENT_QUOTES, 'UTF-8');?>
"/>~
                <input type="number" class="form-control" name="e_charge" style="width: 100px" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['query']['e_charge'], ENT_QUOTES, 'UTF-8');?>
"/>

                <div class="form-group form-group-sm" style="margin-top: 5px;">
                    <label>充值日期</label>
                    <input type="text" name="pay_date_start" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['query']['psdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/>
                    ~
                    <input type="text" name="pay_date_end" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['query']['pedate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate">

                    <label>注册日期</label>
                    <input type="text" name="reg_date_start" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['query']['rsdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/>
                    ~
                    <input type="text" name="reg_date_end" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['query']['redate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate">

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="update_pay_total">
                        <i class="fa fa-refresh fa-fw" aria-hidden="true"></i>更新缓存
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" id="down">
                        <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; min-width: 100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>排名</th>
                        <th>金额</th>
                        <th>UID</th>
                        <th>账号</th>
                        <th>手机号</th>
                        <th>注册时间</th>
                        <th>最后登录时间</th>
                        <th>最后充值时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                        <tr>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['rank'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-danger">
                                <a href="?ct=platform&ac=orderList&is_pay=2&uid=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
&parent_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['parent_id'], ENT_QUOTES, 'UTF-8');?>
&game_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
&server_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['server_id'], ENT_QUOTES, 'UTF-8');?>
&device_type=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['device_type'], ENT_QUOTES, 'UTF-8');?>
" target="_blank"><b>¥<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['money'], ENT_QUOTES, 'UTF-8');?>
</b></a>
                            </td>
                            <td class="show-userinfo" data-keyword="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="show-userinfo" data-keyword="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['username'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="show-userinfo" data-keyword="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['uid'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['phone'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['reg_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['last_login_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['last_pay_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
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
        /*$('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=data&ac=getGameServer&game_id=' + game_id, function (re) {
                var html = '<option value="0">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html);
            });
        });*/
        $('#widgets_children_id').on('change', function () {
            var game_id = [];
            $("#widgets_children_id option").each(function(){
                if($(this).prop('selected')){
                    game_id.push($(this).val());
                }
            });
            $.getJSON('?ct=data&ac=getGameServerBatch&game_id='+JSON.stringify(game_id),function(re){
                var html = '<option value="0">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html);
            })
        });

        //更新缓存
        $('#update_pay_total').on('click', function () {
            layer.confirm('确定更新缓存吗？', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=data&ac=updateUserPayTotal', function (ret) {
                    layer.close(index);
                    layer.alert(ret.msg);
                }, 'json');
            });
        });

        //导出
        $('#down').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=data&ac=payHallDownload',
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>