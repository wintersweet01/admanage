<?php /* Smarty version 3.1.27, created on 2020-01-06 15:25:05
         compiled from "/home/vagrant/code/admin/web/admin/template/extend/landHeatMap.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:642299355e12e0d1bd4132_55547828%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6914f28174ed16b827d56e205107998c0ce04d92' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/extend/landHeatMap.tpl',
      1 => 1551679793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '642299355e12e0d1bd4132_55547828',
  'variables' => 
  array (
    'data' => 0,
    'val' => 0,
    'key' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e12e0d1c08b97_25842416',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e12e0d1c08b97_25842416')) {
function content_5e12e0d1c08b97_25842416 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '642299355e12e0d1bd4132_55547828';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit"/>
    <title>热点图</title>
    <?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/jquery/jQuery-2.2.0.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
js/heatmap.min.js"><?php echo '</script'; ?>
>
    <style type="text/css">
        html, body {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            margin: 0px;
            padding: 0px;
        }

        .rows {
            position: relative;
            margin-bottom: 0.8%;
            overflow: hidden;
        }

        #iframe {
            width: 640px;
            position: absolute;
        }

        #cover {
            width: 640px;
            position: relative;
        }
    </style>
</head>
<body>
<div id="areascontent">
    <div class="rows">
        <iframe src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['url'], ENT_QUOTES, 'UTF-8');?>
" frameborder="0" scrolling="no" id="iframe"></iframe>
        <div class="cover" id="cover"></div>
    </div>
</div>
<?php echo '<script'; ?>
>
    document.domain = '<?php echo htmlspecialchars(@constant('GLOBAL_DOMAIN'), ENT_QUOTES, 'UTF-8');?>
';
    $(function () {
        var heatmap;

        function changeFrameHeight() {
            var height = $('#iframe').contents().height() + 50;
            $('#iframe').css('height', height + 'px');
            $('#cover').css('height', height + 'px');
            $('.heatmap-canvas').remove();
            heatmap = h337.create({
                container: $('#cover')[0]
            });
            <?php if ($_smarty_tpl->tpl_vars['data']->value['click']) {?>
            heatmap.setData({
                max: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['max'], ENT_QUOTES, 'UTF-8');?>
,
                data: [
                <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['click'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['val']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$foreach_val_Sav = $_smarty_tpl->tpl_vars['val'];
?>
                    <?php
$_from = $_smarty_tpl->tpl_vars['val']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
                    { x: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8');?>
, y: parseInt(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
*height/10000), value: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');?>
},
                    <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>
                <?php
$_smarty_tpl->tpl_vars['val'] = $foreach_val_Sav;
}
?>
                ]
            });
        <?php }?>
        }

        $('#iframe').load(function () {
            changeFrameHeight();
        });
        window.onresize = function () {
            //changeFrameHeight();
        };
    });
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
?>