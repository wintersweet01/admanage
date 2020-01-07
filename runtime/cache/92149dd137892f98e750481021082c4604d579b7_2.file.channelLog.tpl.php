<?php /* Smarty version 3.1.27, created on 2019-11-29 11:10:43
         compiled from "/home/vagrant/code/admin/web/admin/template/extend/channelLog.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1165602325de08c331b1d58_09560139%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92149dd137892f98e750481021082c4604d579b7' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/extend/channelLog.tpl',
      1 => 1571041399,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1165602325de08c331b1d58_09560139',
  'variables' => 
  array (
    '_cdn_static_url_' => 0,
    'monitor_id' => 0,
    'data' => 0,
    'u' => 0,
    '_type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08c332182d8_69059985',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08c332182d8_69059985')) {
function content_5de08c332182d8_69059985 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_truncate')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.truncate.php';

$_smarty_tpl->properties['nocache_hash'] = '1165602325de08c331b1d58_09560139';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="extend"/>
            <input type="hidden" name="ac" value="channelLog"/>
            <input type="hidden" name="monitor_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['monitor_id']->value, ENT_QUOTES, 'UTF-8');?>
"/>
            <div class="form-group form-group-sm">
                <lable>选择类型</lable>
                <select class="form-control" name="type">
                    <option value="">全 部</option>
                    <option value="active"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 'active') {?>selected="selected"<?php }?>> 激活 </option>
                    <option value="reg"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 'reg') {?>selected="selected"<?php }?>> 注册 </option>
                    <option value="pay"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 'pay') {?>selected="selected"<?php }?>> 付款 </option>
                    <option value="login"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 'login') {?>selected="selected"<?php }?>> 登录 </option>
                </select>
                <lable>时间</lable>
                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate"/>

                <label>搜索</label>
                <input type="text" class="form-control" name="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['keyword'], ENT_QUOTES, 'UTF-8');?>
" placeholder="推广链ID/推广名称"/>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel">
                    <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出
                </button>
            </div>
        </form>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <table class="layui-table" lay-size="sm">
            <thead>
            <tr>
                <th>推广链ID</th>
                <th>推广名称</th>
                <th>时间</th>
                <th>类型</th>
                <th>来源</th>
                <th>请求链接</th>
                <th>参数</th>
                <th>结果</th>
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
                    <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                    <td style="text-align: left;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['upload_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_type']->value[$_smarty_tpl->tpl_vars['u']->value['upload_type']]['name'], ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['source'], ENT_QUOTES, 'UTF-8');?>
</td>
                    <td style="text-align: left;">
                        <?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['u']->value['url'],50), ENT_QUOTES, 'UTF-8');?>

                        <span class="copy btn btn-primary btn-xs" data-clipboard-text="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['url'], ENT_QUOTES, 'UTF-8');?>
">
                            <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> 复制URL
                        </span>
                    </td>
                    <td style="text-align: left;">
                        <?php if ($_smarty_tpl->tpl_vars['u']->value['param']) {?>
                        <span class="copy btn btn-primary btn-xs" data-clipboard-text="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['param'], ENT_QUOTES, 'UTF-8');?>
">
                            <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> 复制参数
                        </span>
                        <?php }?>
                    </td>
                    <td style="word-break:break-all;word-wrap:break-word; text-align: left;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['result'], ENT_QUOTES, 'UTF-8');?>
</td>
                </tr>
                <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
            </tbody>
        </table>
        <div style="float: left;">
            <nav>
                <ul class="pagination">
                    <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                </ul>
            </nav>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        $('#printExcel').click(function () {
            location.href = '?ct=extend&ac=channelLogExcel' + '&monitor_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['monitor_id']->value, ENT_QUOTES, 'UTF-8');?>
' + '&type=' + $('select[name=type]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val();
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>