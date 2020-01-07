<?php /* Smarty version 3.1.27, created on 2019-11-29 11:10:39
         compiled from "/home/vagrant/code/admin/web/admin/template/extend/landPageList.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1064872225de08c2fd79fb1_07189923%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f054cb657a9cb7c5aa0b53c1d63903b118f6404d' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/extend/landPageList.tpl',
      1 => 1571041239,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1064872225de08c2fd79fb1_07189923',
  'variables' => 
  array (
    '_games' => 0,
    'id' => 0,
    'data' => 0,
    'name' => 0,
    '_models' => 0,
    '_companys' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08c2fde3fd5_84389769',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08c2fde3fd5_84389769')) {
function content_5de08c2fde3fd5_84389769 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1064872225de08c2fd79fb1_07189923';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="extend"/>
            <input type="hidden" name="ac" value="landPage"/>
            <div class="form-group form-group-sm">
                <lable>选择游戏</lable>
                <select class="form-control" name="game_id">
                    <option value="">全 部</option>
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['game_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <lable>选择模板</lable>
                <select class="form-control" name="model_id">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_models']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['model_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <lable>选择公司</lable>
                <select class="form-control" name="company_id">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_companys']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['company_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <lable>名称</lable>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['name'], ENT_QUOTES, 'UTF-8');?>
"/>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>

                <?php if (SrvAuth::checkPublicAuth('add',false)) {?>
                <a href="?ct=extend&ac=addLandPage" class="btn btn-danger btn-sm" role="button">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加落地页
                </a>
                <?php }?>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>落地页ID</td>
                        <td nowrap>落地页名称</td>
                        <td nowrap>落地页URL</td>
                        <td nowrap>模板名称</td>
                        <td nowrap>自动跳转</td>
                        <td nowrap>底部开关</td>
                        <td nowrap>所属公司</td>
                        <td nowrap>所属游戏</td>
                        <td nowrap>所属游戏包</td>
                        <td nowrap>状态</td>
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
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['page_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['page_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><a target="_blank" href="<?php echo htmlspecialchars(@constant('CDN_URL'), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['page_url'], ENT_QUOTES, 'UTF-8');?>
/index.html"><?php echo htmlspecialchars(@constant('CDN_URL'), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['page_url'], ENT_QUOTES, 'UTF-8');?>
/index.html</a></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_models']->value[$_smarty_tpl->tpl_vars['u']->value['model_id']]['model_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['auto_jump'] > 0) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['auto_jump'], ENT_QUOTES, 'UTF-8');?>
秒<?php } else { ?>×<?php }?></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['display_foot']) {?>√<?php } else { ?>×<?php }?></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_companys']->value[$_smarty_tpl->tpl_vars['u']->value['company_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['success_time'] < $_smarty_tpl->tpl_vars['u']->value['update_time']) {?>
                                <span class="label label-warning">模板有更新</span><i class="fa fa-question-circle" alt="点击编辑后保存即可重新生成"></i>
                                <?php } else { ?>
                                <span class="label label-primary">正常</span>
                                <?php }?>
                            </td>
                            <td nowrap>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=extend&ac=addLandPage&page_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['page_id'], ENT_QUOTES, 'UTF-8');?>
">编辑</a>&nbsp;&nbsp;<?php }?>
                                <?php if (SrvAuth::checkPublicAuth('del',false)) {?><a href="javascript:;" class="del" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['page_id'], ENT_QUOTES, 'UTF-8');?>
">删除</a>&nbsp;&nbsp;<?php }?>
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
    $(function(){
        $('.del').on('click',function() {
            var id = $(this).attr('data-id');
            layer.confirm('确定删除?', {
                btn: ['是的','取消']
            }, function(){
                $.getJSON('?ct=extend&ac=delLandPage&page_id='+id,function(re) {
                    if(re.state == true){
                        location.reload();
                    }else{
                        layer.msg(re.msg);
                    }
                });
            }, function(){

            });
        });
    });
<?php echo '</script'; ?>
>

<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>