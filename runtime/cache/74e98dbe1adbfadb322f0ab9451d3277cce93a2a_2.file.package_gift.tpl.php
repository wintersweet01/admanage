<?php /* Smarty version 3.1.27, created on 2019-11-28 17:21:42
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/package_gift.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11860273405ddf91a6bca4c0_56094535%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74e98dbe1adbfadb322f0ab9451d3277cce93a2a' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/package_gift.tpl',
      1 => 1570802561,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11860273405ddf91a6bca4c0_56094535',
  'variables' => 
  array (
    'widgets' => 0,
    'data' => 0,
    'r' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91a6c1e559_13076442',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91a6c1e559_13076442')) {
function content_5ddf91a6c1e559_13076442 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11860273405ddf91a6bca4c0_56094535';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="packageGift"/>
            <div class="form-group form-group-sm">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>
                <a href="/?ct=platform&ac=importGift" class="btn btn-success btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>批量导入礼包</a>
                <a href="/?ct=platform&ac=addGiftType" class="btn btn-warning btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加礼包类别</a>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>母游戏</th>
                        <th nowrap>子游戏</th>
                        <th nowrap>礼包类别</th>
                        <th nowrap>礼包总数</th>
                        <th nowrap>已领数量</th>
                        <th nowrap>描述</th>
                        <th nowrap>开关</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['r']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
$foreach_r_Sav = $_smarty_tpl->tpl_vars['r'];
?>
                        <tr>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['r']->value['parent_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['r']->value['game_id']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['r']->value['game_id']], ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['type_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['amount'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['used'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['explain'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['r']->value['status'] == 1) {?><i class="fa fa-check text-success fa-lg"></i>
                                <?php } else { ?><i class="fa fa-close text-danger fa-lg"></i><?php }?>
                            </td>
                            <td>
                                <a href="javascript:;" <?php if ($_smarty_tpl->tpl_vars['r']->value['type'] != 9) {?>style="pointer-events:none;" data-url=''<?php } else { ?> data-url = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['data_url'], ENT_QUOTES, 'UTF-8');?>
'<?php }?> link_id = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['id'], ENT_QUOTES, 'UTF-8');?>
 data-method="offset" data-type="auto"
                                class="preview btn btn-success btn-xs layui-btn layui-btn-normal <?php if ($_smarty_tpl->tpl_vars['r']->value['type'] != 9) {?>disabled<?php }?> "><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 查看链接</a>
                                <a href="?ct=platform&ac=importGift&parent_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['parent_id'], ENT_QUOTES, 'UTF-8');?>
&game_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
&type_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 上传</a>
                                <a href="?ct=platform&ac=addGiftType&id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a>
                                <a href="javascript:" class="del btn btn-danger btn-xs" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['id'], ENT_QUOTES, 'UTF-8');?>
"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</a>
                            </td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['r'] = $foreach_r_Sav;
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        $('.del').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('将同步删除已上传的礼包，确定删除?', {
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=delGiftType', {
                    id: id
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        location.reload();
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            }, function () {

            });
        });

        $('.preview').click(function () {
            var url = $(this).attr('data-url');
            var title = $(this).data('title');
            var id = $(this).attr('link_id');
            var type = 'auto';
            if (url) {
                layer.open({
                    type: 1,
                    title: '公众号链接',
                    offset: type,
                    id: 'layerDemo' + type,
                    content: '<input type="text" readonly="readonly" name="gift_url" id = "' + id + '" value="' + url + '" style="margin:0 auto;width:100%" class="form-control">',
                    btn: '复制链接',
                    btnAlign: 'c',
                    area: ['500px', '150px'],
                    shade: 0,
                    yes: function () {
                        //layer.closeAll();
                        var e = document.getElementById(id);
                        e.select();
                        var info = document.execCommand("Copy");
                        if (info) {
                            alert('复制成功');
                        }
                        layer.closeAll();
                    }
                });
            }
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>