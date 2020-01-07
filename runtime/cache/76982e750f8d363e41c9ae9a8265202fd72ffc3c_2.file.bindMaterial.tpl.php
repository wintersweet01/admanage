<?php /* Smarty version 3.1.27, created on 2019-12-05 15:34:22
         compiled from "/home/vagrant/code/admin/web/admin/template/material/bindMaterial.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:826813515de8b2fe34f551_60381026%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76982e750f8d363e41c9ae9a8265202fd72ffc3c' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/material/bindMaterial.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '826813515de8b2fe34f551_60381026',
  'variables' => 
  array (
    'material_id' => 0,
    '_games' => 0,
    'id' => 0,
    'name' => 0,
    '_bindList' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de8b2fe39ce18_32495964',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de8b2fe39ce18_32495964')) {
function content_5de8b2fe39ce18_32495964 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '826813515de8b2fe34f551_60381026';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style type="text/css">
    ul.list-group {
        margin-top: 10px;
    }

    ul.list-group li {
        margin-bottom: 2px;
    }

    ul.list-group li span {
        float: right;
        cursor: pointer;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="material_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['material_id']->value, ENT_QUOTES, 'UTF-8');?>
">

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>关联推广链接</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">* 游戏</label>
                    <div class="col-sm-2">
                        <select id="game_id" class="form-control" style="width: 150px;">
                            <option value="">选择游戏</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_games']->value;
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
                </div>

                <div class="form-group">
                    <label for="device_type" class="col-sm-2 control-label">* 游戏平台</label>
                    <div class="col-sm-2">
                        <select id="device_type" class="form-control" style="width: 150px;">
                            <option value="">游戏平台</option>
                            <option value="1">IOS</option>
                            <option value="2">Android</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="user_id" class="col-sm-2 control-label">* 推广活动</label>
                    <div class="col-sm-4">
                        <select id="monitor_id" class="form-control" style="width: 150px;">
                            <option value="">选择推广活动</option>
                        </select>
                        <ul class="list-group">
                            <?php
$_from = $_smarty_tpl->tpl_vars['_bindList']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                            <li class="list-group-item m<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
">
                                【<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
】【<?php if ($_smarty_tpl->tpl_vars['u']->value['device_type'] == 1) {?>IOS<?php } else { ?>Android<?php }?>】<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_name'], ENT_QUOTES, 'UTF-8');?>

                                <input type="hidden" name="monitor_id[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
">
                                <input type="hidden" name="game_id[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
">
                                <input type="hidden" name="device_type[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['device_type'], ENT_QUOTES, 'UTF-8');?>
">
                                <input type="hidden" name="package_name[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
">
                                <span class="glyphicon glyphicon-remove delMonitor" aria-hidden="true"></span>
                            </li>
                            <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        var getPackage = function () {
            var game_id = $('#game_id option:selected').val();
            var device_type = $('#device_type option:selected').val();
            var _games = <?php echo json_encode($_smarty_tpl->tpl_vars['_games']->value);?>
;

            if (!game_id || !device_type) {
                $('#monitor_id').html('<option value="">选择推广活动</option>');
                return false;
            }

            $.getJSON('?ct=material&ac=getMonitor&game_id=' + game_id + '&device_type=' + device_type, function (re) {
                var html = '<option value="">选择推广活动</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.monitor_id + '" data-gid="' + game_id + '" data-os="' + device_type + '" data-package="' + n.package_name + '">' + n.name + '</option>';
                });
                $('#monitor_id').html(html).off().on('change', function () {
                    var e = $(this);
                    var obj = e.parent().find('ul.list-group');
                    var selected = e.find('option:selected');
                    var monitor_id = e.val();
                    var game_id = selected.data('gid');
                    var device_type = selected.data('os');
                    var package_name = selected.data('package');
                    var text = selected.text();
                    var os = device_type == 1 ? 'IOS' : 'Android';
                    var str = '<li class="list-group-item m' + monitor_id + '">【' + _games[game_id] + '】【' + os + '】' + text +
                        '<input type="hidden" name="monitor_id[]" value="' + monitor_id + '">' +
                        '<input type="hidden" name="game_id[]" value="' + game_id + '">' +
                        '<input type="hidden" name="device_type[]" value="' + device_type + '">' +
                        '<input type="hidden" name="package_name[]" value="' + package_name + '">' +
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' +
                        '</li>';
                    if (!obj.find('.m' + monitor_id).length) {
                        obj.append(str).find('.m' + monitor_id + ' span').on('click', function () {
                            $(this).parent('li').remove();
                        });
                    }
                });
            });
        }

        $('ul.list-group li span').on('click', function () {
            $(this).parent('li').remove();
        });

        $('#device_type,#game_id').on('change', function () {
            getPackage();
        });

        $('#submit').on('click', function () {
            if ($('ul.list-group li').length == 0) {
                layer.tips('请选择推广活动', '#monitor_id',{tips: [1, '#ff0000']});
                return false;
            }

            $.post('?ct=material&ac=bindMaterial', $('form').serializeArray(), function (re) {
                if (re.state == true) {
                    layer.msg(re.msg);
                    setTimeout(function () {
                        location.href = document.referrer
                    }, 1500);
                    return false;
                } else {
                    layer.msg(re.msg);
                    return false;
                }
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>