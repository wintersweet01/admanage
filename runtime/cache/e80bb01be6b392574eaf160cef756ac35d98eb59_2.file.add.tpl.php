<?php /* Smarty version 3.1.27, created on 2019-11-28 16:33:53
         compiled from "/home/vagrant/code/admin/web/admin/template/admin/add.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:9207036845ddf8671ef1b15_70245910%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e80bb01be6b392574eaf160cef756ac35d98eb59' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/admin/add.tpl',
      1 => 1547199349,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9207036845ddf8671ef1b15_70245910',
  'variables' => 
  array (
    'admin_id' => 0,
    'data' => 0,
    '_roles' => 0,
    'id' => 0,
    'name' => 0,
    '_games' => 0,
    'parent' => 0,
    'children' => 0,
    '_channeluser' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf867201be88_43761475',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf867201be88_43761475')) {
function content_5ddf867201be88_43761475 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '9207036845ddf8671ef1b15_70245910';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style type="text/css">
    .highlight, .parent, .children {
        float: left;
        width: 100%;
    }

    .children {
        padding: 5px 40px;
    }

    label.checkbox-inline {
        float: left;
        width: 33%;
        margin: 0px !important;
        display: inline;
        line-height: 22px;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_id']->value, ENT_QUOTES, 'UTF-8');?>
"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加管理员</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="inputUser" class="col-sm-2 control-label">* 账号</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="text" class="form-control" name="inputUser" placeholder="不多于3个字符" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['user'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['admin_id']->value) {?>disabled<?php }?>>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">姓名</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPwd" class="col-sm-2 control-label">* 密码</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="password" class="form-control" name="inputPwd" placeholder="密码不少于6位数，不修改留空">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPwd2" class="col-sm-2 control-label">* 确认密码</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="password" class="form-control" name="inputPwd2">
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_id" class="col-sm-2 control-label">* 选择角色</label>
                    <div class="col-lg-4 col-sm-9">
                        <select name="role_id" class="form-control" style="width: 100px;">
                            <option value="0">选择角色</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_roles']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['role_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">* 游戏权限
                        <i class="fa fa-question-circle" alt="1、不选任何游戏，则有所有游戏的权限（包含后续新增）；<br>2、只选母游戏，则有该母游戏及其所有子游戏的权限（包含后续新增子游戏）；<br>3、只选子游戏，则只有选择的子游戏权限。"></i>
                    </label>
                    <div class="col-lg-6 col-sm-9">
                        <figure class="highlight">
                            <?php
$_from = $_smarty_tpl->tpl_vars['_games']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['parent'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['parent']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->_loop = true;
$foreach_parent_Sav = $_smarty_tpl->tpl_vars['parent'];
?>
                            <div class="parent">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="parent_id[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['parent']->value['id'], ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['parent']->value['id'],explode(',',$_smarty_tpl->tpl_vars['data']->value['auth_parent_id']))) {?>checked<?php }?>><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['parent']->value['text'], ENT_QUOTES, 'UTF-8');?>
</b>
                                </label>
                            </div>
                            <div class="children">
                                <?php
$_from = $_smarty_tpl->tpl_vars['parent']->value['children'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['children'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['children']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['children']->value) {
$_smarty_tpl->tpl_vars['children']->_loop = true;
$foreach_children_Sav = $_smarty_tpl->tpl_vars['children'];
?>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="game_id[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['id'], ENT_QUOTES, 'UTF-8');?>
" item="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['parent']->value['id'], ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['children']->value['id'],explode(',',$_smarty_tpl->tpl_vars['data']->value['auth_game_id']))) {?>checked<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['text'], ENT_QUOTES, 'UTF-8');?>

                                </label>
                                <?php
$_smarty_tpl->tpl_vars['children'] = $foreach_children_Sav;
}
?>
                            </div>
                            <?php
$_smarty_tpl->tpl_vars['parent'] = $foreach_parent_Sav;
}
?>
                        </figure>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">* 渠道权限
                        <i class="fa fa-question-circle" alt="1、不选任何渠道和子账号，则有所有渠道和子账号的权限（包含后续新增）；<br>2、只选渠道，则有该渠道及其所有子账号的权限（包含后续新增子账号）；<br>3、只选子账号，则只有选择的子账号权限。"></i>
                    </label>
                    <div class="col-lg-6 col-sm-9">
                        <figure class="highlight">
                            <?php
$_from = $_smarty_tpl->tpl_vars['_channeluser']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['parent'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['parent']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->_loop = true;
$foreach_parent_Sav = $_smarty_tpl->tpl_vars['parent'];
?>
                            <div class="parent">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="channel_id[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['parent']->value['id'], ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['parent']->value['id'],explode(',',$_smarty_tpl->tpl_vars['data']->value['auth_channel_id']))) {?>checked<?php }?>><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['parent']->value['text'], ENT_QUOTES, 'UTF-8');?>
</b>
                                </label>
                            </div>
                            <div class="children">
                                <?php
$_from = $_smarty_tpl->tpl_vars['parent']->value['children'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['children'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['children']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['children']->value) {
$_smarty_tpl->tpl_vars['children']->_loop = true;
$foreach_children_Sav = $_smarty_tpl->tpl_vars['children'];
?>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="user_id[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['id'], ENT_QUOTES, 'UTF-8');?>
" item="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['parent']->value['id'], ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['children']->value['id'],explode(',',$_smarty_tpl->tpl_vars['data']->value['auth_user_id']))) {?>checked<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['text'], ENT_QUOTES, 'UTF-8');?>

                                </label>
                                <?php
$_smarty_tpl->tpl_vars['children'] = $foreach_children_Sav;
}
?>
                            </div>
                            <?php
$_smarty_tpl->tpl_vars['parent'] = $foreach_parent_Sav;
}
?>
                        </figure>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-lg-4 col-sm-9">
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
        $('input[name="parent_id[]"],input[name="channel_id[]"]').on('click', function () {
            var id = $(this).val();
            $(this).parents('.parent').next('.children').find('input[item="' + id + '"]').prop("checked", function (i, val) {
                return !val;
            });
        });

        $('#submit').on('click', function () {
            $.post('?ct=admin&ac=addAdminAction', $('form').serializeArray(), function (re) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=admin&ac=adminList';
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });

    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>