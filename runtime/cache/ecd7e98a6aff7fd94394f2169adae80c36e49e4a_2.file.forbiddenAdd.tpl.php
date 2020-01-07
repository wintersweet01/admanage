<?php /* Smarty version 3.1.27, created on 2020-01-03 14:45:20
         compiled from "/home/vagrant/code/admin/web/admin/template/user/forbiddenAdd.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13164891165e0ee300880131_99674575%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ecd7e98a6aff7fd94394f2169adae80c36e49e4a' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/user/forbiddenAdd.tpl',
      1 => 1569329929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13164891165e0ee300880131_99674575',
  'variables' => 
  array (
    'type' => 0,
    'type_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e0ee3008af982_02629562',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e0ee3008af982_02629562')) {
function content_5e0ee3008af982_02629562 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13164891165e0ee300880131_99674575';
echo $_smarty_tpl->getSubTemplate ("../public/header-bootstrap.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="container-fluid" style="padding: 2rem;">
    <form method="post" action="">
        <input type="hidden" name="type" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['type']->value, ENT_QUOTES, 'UTF-8');?>
"/>
        <div class="form-group">
            <label for="content">封禁<span style="color: red;font-weight: bold;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['type_name']->value, ENT_QUOTES, 'UTF-8');?>
</span></label>
            <textarea class="form-control" name="content" rows="5" placeholder="输入需要封禁的<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['type_name']->value, ENT_QUOTES, 'UTF-8');?>
，一行一个" required></textarea>
            <small class="form-text text-muted">支持批量添加，一行一个</small>
        </div>
        <div class="form-group">
            <label for="notes">原因</label>
            <textarea class="form-control" name="notes" rows="3" required></textarea>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['type']->value != 'user') {?>
        <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="handle1" name="handle" value="all" class="custom-control-input" checked>
                <label class="custom-control-label" for="handle1">全部禁止</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="handle2" name="handle" value="reg" class="custom-control-input">
                <label class="custom-control-label" for="handle2">禁止注册</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="handle3" name="handle" value="login" class="custom-control-input">
                <label class="custom-control-label" for="handle3">禁止登录</label>
            </div>
        </div>
        <?php }?>
        <div class="form-group">
            <button type="button" id="submit" class="btn btn-danger"> 封 禁</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
        </div>
    </form>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
    $(function () {
        $('#submit').on('click', function () {
            var type = $('input[name="type"]').val(),
                content = $('textarea[name="content"]').val(),
                notes = $('textarea[name="notes"]').val(),
                handle = $('input[name="handle"]:checked').val();

            if (!content) {
                layer.msg('请填写封禁内容');
                $('textarea[name="content"]').focus();
                return false;
            }

            if (!notes) {
                layer.msg('请填写封禁原因');
                $('textarea[name="notes"]').focus();
                return false;
            }

            var index = layer.load();
            $.post('/?ct=user&ac=forbiddenAdd', {
                type: type,
                content: content,
                notes: notes,
                handle: handle
            }, function (ret) {
                layer.close(index);
                if (ret.code === 1) {
                    layer.msg(ret.message, {icon: 6,shadeClose:true}, function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.layui.table.reload('table-report-' + type);
                    });
                } else {
                    layer.msg(ret.message,{icon: 5,shadeClose:true});
                }
            }, 'json');
        });

        $('#cancel').on('click', function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>