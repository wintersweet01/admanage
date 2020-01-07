<?php /* Smarty version 3.1.27, created on 2019-11-29 11:24:02
         compiled from "/home/vagrant/code/admin/web/admin/template/admin/groupList.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:21416205775de08f528724a0_69439139%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a847b906132019f4f71f11f24ddea06b6870591' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/admin/groupList.tpl',
      1 => 1570788690,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21416205775de08f528724a0_69439139',
  'variables' => 
  array (
    'data' => 0,
    'row' => 0,
    'parent' => 0,
    'children' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08f528bd580_00286538',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08f528bd580_00286538')) {
function content_5de08f528bd580_00286538 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '21416205775de08f528724a0_69439139';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>
<style type="text/css">
    .highlight {
        float: left;
        width: 100%;
    }

    label.checkbox-inline {
        float: left;
        width: 80px;
        margin: 5px 0 !important;
        display: inline;
    }

    h5 {
        clear: both;
        margin: 5px 0;
        font-weight: bold;
    }
</style>
<div class="container" style="margin-top: 15px;">
    <div class="row" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="post" action="" class="form-inline">
            <div class="form-group form-group-sm">
                <label>选择投放组：</label>
                <select class="form-control" id="select-group">
                    <option value="0">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['row']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$foreach_row_Sav = $_smarty_tpl->tpl_vars['row'];
?>
                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id'], ENT_QUOTES, 'UTF-8');?>
"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['text'], ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
                </select>
                <button type="button" class="btn btn-primary btn-sm" id="submit">保存</button>
            </div>
        </form>
        <div id="table-transfer"></div>
    </div>
    <div class="row" style="margin-bottom: 0.8%; overflow: hidden;">
        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['parent'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['parent']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->_loop = true;
$foreach_parent_Sav = $_smarty_tpl->tpl_vars['parent'];
?>
        <div class="col-lg-3 col-sm-9">
            <h5><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['parent']->value['text'], ENT_QUOTES, 'UTF-8');?>
</h5>
            <figure class="highlight">
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
                <label class="checkbox-inline"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['children']->value['text'], ENT_QUOTES, 'UTF-8');?>
</label>
                <?php
$_smarty_tpl->tpl_vars['children'] = $foreach_children_Sav;
}
?>
            </figure>
        </div>
        <?php
$_smarty_tpl->tpl_vars['parent'] = $foreach_parent_Sav;
}
?>
    </div>
</div>
<?php echo '<script'; ?>
>
    layui.config({
        version: '2019032020'
    }).extend({
        transfer: '<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/ext/transfer'
    }).use(['transfer', 'layer', 'form'], function () {
        var data = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['data']->value);?>
');
        var transfer = layui.transfer;
        var layer = layui.layer;
        var tableIns = transfer.render({
            elem: "#table-transfer",
            cols: [
                {type: 'checkbox', fixed: 'left'},
                {field: 'text', title: '账号'}
            ],
            data: [], //[左表数据,右表数据[非必填]]
            tabConfig: {
                'page': false,
                'limit': 0,
                'limits': [10, 50, 100],
                'height': 400
            }
        })

        $('#select-group').on('change', function () {
            var options = transfer.options,
                group_id = $(this).val(),
                group = data.list,
                admin = data.admin,
                data1 = [],
                data2 = [];

            if (group_id > 0) {
                $.each(group[group_id].children, function (k, v) {
                    data2.push(v);
                    $.each(admin, function (i, n) {
                        if (i == v.id) {
                            delete admin[i];
                            return false;
                        }
                    });
                });
                $.each(admin, function (i, n) {
                    data1.push({
                        'id': i,
                        'text': n
                    });
                });
            }

            var arr = [];
            var limit = data1.length + data2.length;
            if (limit) {
                arr = [data1, data2];
            }

            options.data = arr;
            options.tabConfig.limit = limit;
            transfer.render(options);
        });

        $('#submit').on('click', function () {
            var group_id = $('#select-group').val();
            var data = transfer.get(tableIns, 'right', 'id');
            var index = layer.load();
            $.post('?ct=admin&ac=groupList', {
                group_id: group_id,
                ids: data
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
                        if (re.state == true) {
                            location.reload();
                        }
                    }
                });
            }, 'json');
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>