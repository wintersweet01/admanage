<?php /* Smarty version 3.1.27, created on 2019-11-28 17:23:20
         compiled from "/home/vagrant/code/admin/web/admin/template/widget/media_account.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5804577035ddf92088aaf71_46405258%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99431d60522233e11b373e531af5e680805cb591' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/widget/media_account.tpl',
      1 => 1568890143,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5804577035ddf92088aaf71_46405258',
  'variables' => 
  array (
    'FIELD' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf92088c7837_66042903',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf92088c7837_66042903')) {
function content_5ddf92088c7837_66042903 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5804577035ddf92088aaf71_46405258';
?>
<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui-2.5/css/layui.css">
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui-2.5/layui.js"><?php echo '</script'; ?>
>
<div id="media_account" class="demo-transfer"></div>
<?php echo '<script'; ?>
>
    var transfreH;
    var id = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD']->value['id'], ENT_QUOTES, 'UTF-8');?>
';
    layui.use(['transfer', 'layer', 'util'], function () {
        var $ = layui.$
            , transfer = layui.transfer
            , layer = layui.layer
            , util = layui.util;
        var list = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['FIELD']->value['data']);?>
');
        var default_value = JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['FIELD']->value['values']);?>
');
        var show_search = parseInt('<?php echo $_smarty_tpl->tpl_vars['FIELD']->value['show_search'];?>
');
        var width = parseInt('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['FIELD']->value['width'])===null||$tmp==='' ? 350 : $tmp);?>
');
        var data = makeData(list,default_value);
        var id =
        //显示搜索框
        transfreH = transfer.render({
            elem: '#media_account'
            ,data: data
            ,value:default_value
            ,title: ['全选', '全选']
            ,showSearch: show_search
            ,text:{
                none:'无数据'
            },
            width:width,
            id:id
        });
    });
    function makeData(data,value){
        var back = [];
        for (var j in data){
            var tmp = { };
            if(typeof data[j] != 'undefined') {
                tmp.value = data[j].value;
                tmp.title = data[j].title;
                tmp.disabled = false;
                tmp.checked = false;
                if(typeof value == "object" && $.isArray(value)) {
                    var index = $.inArray(parseInt(data[j].value), value);
                    if (index != '-1' && typeof data[j].value != 'undefined') {
                        tmp.checked = true;
                    }
                }
                back.push(tmp)
            }
        }
        return back;
    }
    function getTransData() {
        var data = [];
        var ret = transfreH.getData(id);
        for(var i in ret){
            if(typeof ret[i].value != 'undefined' && $.isNumeric(ret[i].value)){
                data.push(ret[i].value);
            }
        }
        return JSON.stringify(data);
    }
<?php echo '</script'; ?>
><?php }
}
?>