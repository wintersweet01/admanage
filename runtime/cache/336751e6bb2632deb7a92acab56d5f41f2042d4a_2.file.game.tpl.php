<?php /* Smarty version 3.1.27, created on 2019-11-28 17:21:37
         compiled from "/home/vagrant/code/admin/web/admin/template/widget/game.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:19157053235ddf91a165d901_43696127%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '336751e6bb2632deb7a92acab56d5f41f2042d4a' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/widget/game.tpl',
      1 => 1571039912,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19157053235ddf91a165d901_43696127',
  'variables' => 
  array (
    'FIELD' => 0,
    'item' => 0,
    'children' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91a16b32b3_95352000',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91a16b32b3_95352000')) {
function content_5ddf91a16b32b3_95352000 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '19157053235ddf91a165d901_43696127';
if ($_smarty_tpl->tpl_vars['FIELD']->value['label']) {?><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['label'], ENT_QUOTES, 'UTF-8');?>
</label> <?php }?>
<select id="widgets_game_id" name="<?php if ($_smarty_tpl->tpl_vars['FIELD']->value['id']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['id'], ENT_QUOTES, 'UTF-8');
} else { ?>game_id<?php }?>" <?php echo $_smarty_tpl->tpl_vars['FIELD']->value['attr'];?>
 <?php if ($_smarty_tpl->tpl_vars['FIELD']->value['disabled']) {?>disabled="disabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['FIELD']->value['multiple']) {?>multiple="multiple"<?php }?>>
<?php if ($_smarty_tpl->tpl_vars['FIELD']->value['default_text'] && !$_smarty_tpl->tpl_vars['FIELD']->value['multiple']) {?><option value="0" selected="selected"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['default_text'], ENT_QUOTES, 'UTF-8');?>
</option><?php }?>
<?php
$_from = $_smarty_tpl->tpl_vars['FIELD']->value['data']['parent'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
    <?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 0 || $_smarty_tpl->tpl_vars['FIELD']->value['default_value']) {?>
    <?php if (!$_smarty_tpl->tpl_vars['FIELD']->value['parent']) {?>
    <optgroup label="(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['alias'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['text'], ENT_QUOTES, 'UTF-8');?>
">
        <?php
$_from = $_smarty_tpl->tpl_vars['item']->value['children'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['children'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['children']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['children']->value) {
$_smarty_tpl->tpl_vars['children']->_loop = true;
$foreach_children_Sav = $_smarty_tpl->tpl_vars['children'];
?>
        <?php if (($_smarty_tpl->tpl_vars['FIELD']->value['children_inherit'] && $_smarty_tpl->tpl_vars['children']->value['inherit'] > 0) || $_smarty_tpl->tpl_vars['children']->value['status'] == 1) {?>
        <?php continue 1;?>
        <?php }?>
        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['id'], ENT_QUOTES, 'UTF-8');?>
" data-pid="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['pid'], ENT_QUOTES, 'UTF-8');?>
" <?php if ((is_array($_smarty_tpl->tpl_vars['FIELD']->value['default_value']) && in_array($_smarty_tpl->tpl_vars['children']->value['id'],$_smarty_tpl->tpl_vars['FIELD']->value['default_value'])) || $_smarty_tpl->tpl_vars['FIELD']->value['default_value'] == $_smarty_tpl->tpl_vars['children']->value['id']) {?>selected="selected"<?php }?>>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['id'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['text'], ENT_QUOTES, 'UTF-8');?>
</option>
        <?php
$_smarty_tpl->tpl_vars['children'] = $foreach_children_Sav;
}
?>
    </optgroup>
    <?php } else { ?>
    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id'], ENT_QUOTES, 'UTF-8');?>
" data-pid="0" <?php if ((is_array($_smarty_tpl->tpl_vars['FIELD']->value['default_value']) && in_array($_smarty_tpl->tpl_vars['item']->value['id'],$_smarty_tpl->tpl_vars['FIELD']->value['default_value'])) || $_smarty_tpl->tpl_vars['FIELD']->value['default_value'] == $_smarty_tpl->tpl_vars['item']->value['id']) {?>selected="selected"<?php }?>>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['alias'], ENT_QUOTES, 'UTF-8');?>
)<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['text'], ENT_QUOTES, 'UTF-8');?>
</option>
    <?php }?>
    <?php }?>
    <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
</select>
<?php if ($_smarty_tpl->tpl_vars['FIELD']->value['children']) {?>
<?php if ($_smarty_tpl->tpl_vars['FIELD']->value['children_label']) {?><label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['children_label'], ENT_QUOTES, 'UTF-8');?>
</label> <?php }?>
<select id="widgets_children_id" name="<?php if ($_smarty_tpl->tpl_vars['FIELD']->value['children_id']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['children_id'], ENT_QUOTES, 'UTF-8');
} else { ?>children_id<?php }?>" <?php echo $_smarty_tpl->tpl_vars['FIELD']->value['children_attr'];?>
 <?php if ($_smarty_tpl->tpl_vars['FIELD']->value['disabled']) {?>disabled="disabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['FIELD']->value['children_multiple']) {?>multiple="multiple"<?php }?> style="min-width: 120px;">
    <?php if ($_smarty_tpl->tpl_vars['FIELD']->value['children_default_text'] && !$_smarty_tpl->tpl_vars['FIELD']->value['children_multiple']) {?><option value="0" selected="selected"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['children_default_text'], ENT_QUOTES, 'UTF-8');?>
</option><?php }?>
</select>
<?php echo '<script'; ?>
 type="text/javascript">
    $(function () {
        var list = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['FIELD']->value['data']['parent']);?>
');
        var default_pid = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['FIELD']->value['default_value']);?>
');
        var default_cid = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['FIELD']->value['children_default_value']);?>
');
        var children_inherit = parseInt('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['children_inherit'], ENT_QUOTES, 'UTF-8');?>
');
        var children_multiple = parseInt('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['children_multiple'], ENT_QUOTES, 'UTF-8');?>
');
        var children_default_text = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['children_default_text'], ENT_QUOTES, 'UTF-8');?>
';
        var widgets_game_id = $('#widgets_game_id');

        if (default_pid) {
            children_list(list, default_pid, default_cid, 0);
        }

        widgets_game_id.on({
            'select2:select': function (e) {
                var pid = $(e.params.data.element).data('pid');
                var id = e.params.data.id;
                children_list(list, id, 0, pid);
            },
            'select2:unselect': function (e) {
                var id = e.params.data.id;
                var o = $('#widgets_children_id');

                var _old = o.val();
                o.find("option[pid='" + id + "']").remove();
                var _new = o.val();

                if (typeof childrenRemoveCallback === 'function') {
                    if (!_old || !_new) {
                        return false;
                    }
                    childrenRemoveCallback(arrChange(_old, _new));
                }
            }
        });

        //数组相减
        function arrChange(a, b) {
            for (var i = 0; i < b.length; i++) {
                for (var j = 0; j < a.length; j++) {
                    if (a[j] == b[i]) {
                        a.splice(j, 1);
                        j = j - 1;
                    }
                }
            }
            return a;
        }

        function children_list(list, id, default_id, pid) {
            if (!list || !id) {
                return false;
            }

            var children = [];
            $.each(list, function (k, v) {
                if (pid > 0 && v.id == pid) {
                    $.each(v.children, function (i, n) {
                        if ((typeof id == 'object' && $.inArray(n.id, id) != -1) || n.id == id) {
                            children.push.apply(children, n.children);
                        }
                    });
                    return false;
                } else {
                    if ((typeof id == 'object' && $.inArray(v.id, id) != -1) || v.id == id) {
                        children.push.apply(children, v.children);
                    }
                }
            });

            var html = '';
            if (children_default_text && !children_multiple) {
                html = '<option value="0" selected="selected">' + children_default_text + '</option>';
            }
            $.each(children, function (i, n) {
                //过滤继承的游戏 2019-06-25更改#不运营且没有默认值的游戏剔除
                if (children_inherit && n.inherit > 0 || (n.status == '1' && typeof default_id == 'undefined')) {
                    return true;
                }

                var selected = '';
                if ((typeof default_id == 'object' && $.inArray(n.id, default_id) != -1) || n.id == default_id) {
                    selected = ' selected="selected"';
                }
                html += '<option value="' + n.id + '"' + selected + ' pid="' + id + '">(' + n.id + ')' + n.text + '</option>';
            });

            if (children_multiple) {
                $('#widgets_children_id').append(html).trigger('change');
            } else {
                $('#widgets_children_id').html(html).trigger('change');
            }
        }
    });
<?php echo '</script'; ?>
>
<?php }
}
}
?>