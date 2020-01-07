<?php /* Smarty version 3.1.27, created on 2019-12-10 11:18:38
         compiled from "/home/vagrant/code/admin/web/admin/template/adCnter/list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5124219175def0e8e90cf52_83816816%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f1c8e72fc5c1fa4f41fe16ddffb093265528cd8' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adCnter/list.tpl',
      1 => 1575947915,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5124219175def0e8e90cf52_83816816',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'u' => 0,
    't' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5def0e8e9d5989_93011277',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5def0e8e9d5989_93011277')) {
function content_5def0e8e9d5989_93011277 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5124219175def0e8e90cf52_83816816';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="optimizat" />
            <input type="hidden" name="ac" value="adCopywriting" />

            <div class="form-group form-group-sm">
                <label>高级筛选：</label>

                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <select name="channel">
                    <option value=""  <?php if ($_smarty_tpl->tpl_vars['data']->value['channel'] == '') {?>selected="selected"<?php }?>>选择渠道</option>
                    <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel'] == '1') {?>selected="selected"<?php }?>>广点通</option>
                    <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel'] == '2') {?>selected="selected"<?php }?>>今日头条</option>
                </select>
                <input type="text" class="form-control" name="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['keyword'], ENT_QUOTES, 'UTF-8');?>
" placeholder="请输入文案或标签关键字">

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <?php if (SrvAuth::checkPublicAuth('add',false)) {?><button type="button" class="btn btn-primary btn-sm" onclick="location.href='?ct=optimizat&ac=addJrttAd'"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> 新建广告</button><?php }?>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td nowrap>文案</td>
                        <td nowrap>标签</td>
                        <td nowrap>渠道</td>
                        <td nowrap>添加时间</td>
                        <td nowrap>更新时间</td>
                        <td nowrap>操作</td>
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
                            <td nowrap=""><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['content'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['tag'] != '') {
$_from = explode(',',$_smarty_tpl->tpl_vars['u']->value['tag']);
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['t'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['t']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->_loop = true;
$foreach_t_Sav = $_smarty_tpl->tpl_vars['t'];
?><span class="label label-info" style="margin-right: 3px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value, ENT_QUOTES, 'UTF-8');?>
</span><?php
$_smarty_tpl->tpl_vars['t'] = $foreach_t_Sav;
}
}?></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['channel'] == 1) {?><span class="label label-primary">广点通</span><?php } else { ?><span class="label label-warning">今日头条</span><?php }?></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['create_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['update_time'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=optimizat&ac=addCopywriting&id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><?php }?>
                                <?php if (SrvAuth::checkPublicAuth('del',false)) {?><span class="delete btn btn-danger btn-xs" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['id'], ENT_QUOTES, 'UTF-8');?>
">删除</span><?php }?>
                            </td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                    </tbody>
                </table>
            </div>
            <div style="float: right;">
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
        $('.delete').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('确定删除吗?', {
                btn: ['是的', '取消']
            }, function () {
                $.getJSON('?ct=optimizat&ac=deleteCopywriting&id=' + id, function (re) {
                    layer.msg(re.msg);
                    if (re.code == 1) {
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                });
            }, function () {

            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>