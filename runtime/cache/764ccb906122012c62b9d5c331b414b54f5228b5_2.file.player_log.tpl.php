<?php /* Smarty version 3.1.27, created on 2019-11-29 20:15:55
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/player_log.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4973623505de10bfbae8444_30304135%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '764ccb906122012c62b9d5c331b414b54f5228b5' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/player_log.tpl',
      1 => 1571040395,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4973623505de10bfbae8444_30304135',
  'variables' => 
  array (
    'widgets' => 0,
    '_game_server' => 0,
    'id' => 0,
    'data' => 0,
    'name' => 0,
    '_channels' => 0,
    'h_type' => 0,
    'row' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de10bfbb4a136_71851500',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de10bfbb4a136_71851500')) {
function content_5de10bfbb4a136_71851500 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4973623505de10bfbae8444_30304135';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <form method="get" action="" class="form-inline" id="myForm">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="playerLog"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>选择区服</label>
                <select class="form-control" name="server_id">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_game_server']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['server_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>selected="selected"<?php }?>> IOS</option>
                    <option value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>selected="selected"<?php }?>> Andorid </option>
                </select>

                <label>渠道</label>
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>操作</label>
                <select class="form-control" name="opp">
                    <option value="">全部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['h_type']->value;
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
                <option <?php if ($_smarty_tpl->tpl_vars['data']->value['opp'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected<?php }?> value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <div class="form-group form-group-sm" style="margin-top: 5px;">
                    <label>用户账户</label>
                    <input type="text" class="form-control" name="account" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['account'], ENT_QUOTES, 'UTF-8');?>
">

                    <label>角色名</label>
                    <input type="text" class="form-control" name="role_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
">

                    <label>ip</label>
                    <input type="text" class="form-control" name="ip" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['ip'], ENT_QUOTES, 'UTF-8');?>
"/>

                    <label>时间</label>
                    <input type="text" style="width: 150px" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/>~
                    <input type="text" style="width: 150px" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/>

                    <button type="button" class="btn btn-primary btn-sm search-btn">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                    </button>
                    <button id="printExcel" type="button" class="btn btn-success btn-sm download">
                        <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导 出
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content">
            <div class="tableDiv">
                <table class="table table-bordered table-hover table-content table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>账号</th>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏</th>
                        <th nowrap>区服</th>
                        <th nowrap>角色</th>
                        <th nowrap>当前等级</th>
                        <th nowrap>登录游戏</th>
                        <th nowrap>注册游戏</th>
                        <th nowrap>操作</th>
                        <th nowrap>ip</th>
                        <th nowrap>时间</th>
                        <th nowrap>设备号</th>
                        <th nowrap>设备名称</th>
                        <th nowrap>设备版本</th>
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
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$foreach_row_Sav = $_smarty_tpl->tpl_vars['row'];
?>
                        <tr>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['username'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value['list'][$_smarty_tpl->tpl_vars['row']->value['parent_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value['list'][$_smarty_tpl->tpl_vars['row']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['server_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['role_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['role_level'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td
                            <?php if ($_smarty_tpl->tpl_vars['row']->value['login_game'] != $_smarty_tpl->tpl_vars['row']->value['reg_game']) {?> class="text-red"<?php }?>>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value['list'][$_smarty_tpl->tpl_vars['row']->value['login_game']], ENT_QUOTES, 'UTF-8');?>

                            </td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value['list'][$_smarty_tpl->tpl_vars['row']->value['reg_game']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td
                            <?php if ($_smarty_tpl->tpl_vars['row']->value['h_type'] == 999) {?>class="text-red" <?php }?> ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['h_type']->value[$_smarty_tpl->tpl_vars['row']->value['h_type']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['ip'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['h_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['device_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['device_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['device_version'], ENT_QUOTES, 'UTF-8');?>
</td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
                    </tbody>
                </table>
            </div>
            <div style="float: left;">
                <nav>
                    <ul class="pagination">
                        <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo '<script'; ?>
 type="text/javascript">
    $('input[name=sdate]').off();
    $('input[name=sdate]').on('click focus', function () {
        WdatePicker({el:this, dateFmt:"yyyy-MM-dd HH:mm:ss"});
    });

    $('input[name=edate]').off();
    $('input[name=edate]').on('click focus', function () {
        WdatePicker({el:this, dateFmt:"yyyy-MM-dd HH:mm:ss"});
    });
    $('#printExcel').click(function () {
        location.href = '?ct=platform&ac=playerLogExcel&parent_id=' +
            $('select[name=parent_id]').val() + '&game_id=' +
            $('select[name=game_id]').val() + '&server_id=' +
            $('select[name=server_id]').val() + '&channel_id=' +
            $('select[name=channel_id]').val() + '&device_type=' +
            $('select[name=device_type]').val() + '&account=' +
            $('input[name=account]').val() + '&opp=' +
            $('select[name=opp]').val() + '&ip=' +
            $('input[name=ip]').val() + '&role_name=' +
            $('input[name=role_name]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val()
    });
    var chose_server =
    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['server_id'], ENT_QUOTES, 'UTF-8');?>

    $('select[name=game_id]').on('change', function () {
        $.getJSON('?ct=data&ac=getGameServer&game_id=' + $('select[name=game_id]').val(), function (re) {
            var html = '<option value="">全 部</option>';
            $.each(re, function (i, n) {
                var str = '<option value=' + i + '>' + n + '</option>';
                if (i == chose_server) {
                    str = '<option selected="selected" value=' + i + '>' + n + '</option>'
                }
                html += str;
            });
            $('select[name="server_id"]').html(html);
        });
    });
    $(".search-btn").on('click', function () {
        var sdate = $('input[name="sdate"]').val();
        var edate = $('input[name="edate"]').val();
        if (sdate.substr(0, 10) != edate.substr(0, 10)) {
            layer.msg('仅限单天查询!',{time:1000});
            return false;
        }
        $("#myForm").submit();
    })

<?php echo '</script'; ?>
><?php }
}
?>