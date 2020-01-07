<?php /* Smarty version 3.1.27, created on 2019-11-29 14:11:30
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/addPackage.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:19803708125de0b6928946a8_61856216%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '692a5e5a6eaffe70c33e85f41af2676cb5d78698' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/addPackage.tpl',
      1 => 1570780540,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19803708125de0b6928946a8_61856216',
  'variables' => 
  array (
    'data' => 0,
    'widgets' => 0,
    '_channels' => 0,
    'id' => 0,
    'name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0b6928eeb01_85490029',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0b6928eeb01_85490029')) {
function content_5de0b6928eeb01_85490029 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '19803708125de0b6928946a8_61856216';
echo $_smarty_tpl->getSubTemplate ("../public/header-bootstrap.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="container-fluid" style="padding: 2rem;">
    <form method="post" action="">
        <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['package_id'], ENT_QUOTES, 'UTF-8');?>
"/>
        <div class="form-group">
            <label>游戏</label>
            <div class="form-group">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

            </div>
        </div>
        <div class="form-group">
            <label for="channel_id">渠道</label>
            <select class="form-control" name="channel_id" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']) {?>disabled="disabled"<?php }?>>
            <option value="">选择渠道</option>
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">默认投放账号</label>
            <select class="form-control" name="user_id" id="user_id" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']) {?>disabled="disabled"<?php }?>>
            <option value="">选择账号</option>
            </select>
        </div>
        <div class="form-group">
            <label for="platform">平台</label>
            <div class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="platform1" name="platform" value="1" class="custom-control-input"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['info']) {?>disabled="disabled"<?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['platform'] == 1) {?>checked="checked"<?php }?>>
                    <label class="custom-control-label" for="platform1">IOS</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="platform2" name="platform" value="2" class="custom-control-input"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['info']) {?>disabled="disabled"<?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['platform'] == 2) {?>checked="checked"<?php }?>>
                    <label class="custom-control-label" for="platform2">Android</label>
                </div>
            </div>
        </div>
        <div class="form-group for for-1"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['platform'] == 2 || !$_smarty_tpl->tpl_vars['data']->value['info']['platform']) {?>style="display: none;"<?php }?>>
        <label for="spec_name">bundleID</label>
        <input type="text" class="form-control" name="spec_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['spec_name'], ENT_QUOTES, 'UTF-8');?>
" placeholder="请填写跟SDK技术哥获取bundleID的值"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['info']) {?>disabled="disabled"<?php }?>>
</div>

<div class="form-group for for-1"
<?php if ($_smarty_tpl->tpl_vars['data']->value['info']['platform'] == 2 || !$_smarty_tpl->tpl_vars['data']->value['info']['platform']) {?>style="display: none;"<?php }?>>
<label for="down_url">AppstoreID</label>
<input type="text" class="form-control" name="down_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['down_url'], ENT_QUOTES, 'UTF-8');?>
" placeholder="APP在苹果商店上的访问ID">
</div>

<div class="form-group for for-2" style="display: none;">
    <label for="package_num">分包数量</label>
    <input type="text" class="form-control" name="package_num" value="">
</div>

<div class="form-group">
    <button type="button" id="submit" class="btn btn-danger">保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" id="cancel" class="btn btn-default">取 消</button>
</div>
</form>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
    $(function () {
        $('select[name=channel_id]').on('change', function () {
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!channel_id) {
                return false;
            }
            $.getJSON('?ct=extend&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="">选择账号</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#user_id').html(html);
            });
        });

        $('input[name=platform]').on('click', function () {
            $('.for').hide();
            $('.for-' + $(this).val()).show();
        });

        $('#submit').on('click', function () {
            let index = layer.load();
            $.post('?ct=platform&ac=addPackageAction', {
                data: $('form').serialize()
            }, function (re) {
                layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state) {
                            if ($('input[name=platform]:checked').val() == 2) {
                                parent.location.href = '?ct=platform&ac=refreshProgress&state=1&game_id=' + $('select[name=game_id]').val();
                            }
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            let index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>