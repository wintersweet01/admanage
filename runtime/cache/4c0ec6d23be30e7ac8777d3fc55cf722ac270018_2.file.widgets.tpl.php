<?php /* Smarty version 3.1.27, created on 2019-11-28 17:21:37
         compiled from "/home/vagrant/code/admin/web/admin/template/widget/widgets.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:769382565ddf91a1635cc3_58172371%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c0ec6d23be30e7ac8777d3fc55cf722ac270018' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/widget/widgets.tpl',
      1 => 1564369847,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '769382565ddf91a1635cc3_58172371',
  'variables' => 
  array (
    '_cdn_static_url_' => 0,
    'widgets' => 0,
    'FIELD' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf91a164c551_17154337',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf91a164c551_17154337')) {
function content_5ddf91a164c551_17154337 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '769382565ddf91a1635cc3_58172371';
?>
<?php echo '<script'; ?>
 type="text/javascript">
    //加载JS文件
    var loadScript = function (id, url, callback) {
        //已经加载
        if (document.getElementById(id)) {
            if (typeof (callback) == "function") {
                callback();
            }
            return true;
        }

        var script = document.createElement("script");
        script.type = "text/javascript";
        script.id = id;
        if (typeof (callback) == "function") {
            if (script.readyState) {
                script.onreadystatechange = function () {
                    if (script.readyState == "loaded" || script.readyState == "complete") {
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else {
                script.onload = function () {
                    callback();
                };
            }
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    };

    //加载CSS文件
    var loadStyle = function (id, url) {
        //已经加载
        if (document.getElementById(id)) {
            return true;
        }

        var link = document.createElement('link');
        link.type = 'text/css';
        link.rel = 'stylesheet';
        link.id = id;
        link.href = url;
        document.getElementsByTagName('head')[0].appendChild(link);
    };

	if (typeof $('select').select2 == "undefined") {
		loadScript('select2-js', '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/select2/js/select2.min.js', function () {
			loadStyle('select2-css', '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/select2/css/select2.min.css');

			//加载select控件
			$('select').each(function (i, elem) {
				if (!$(elem).hasClass("select2-hidden-accessible")) {
					$(elem).select2({
						dropdownAutoWidth: true
					});
				}
			});
		});
	}
<?php echo '</script'; ?>
>
<?php
$_from = $_smarty_tpl->tpl_vars['widgets']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['FIELD'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['FIELD']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['FIELD']->value) {
$_smarty_tpl->tpl_vars['FIELD']->_loop = true;
$foreach_FIELD_Sav = $_smarty_tpl->tpl_vars['FIELD'];
?>
	<?php echo $_smarty_tpl->getSubTemplate ("widget/".((string)$_smarty_tpl->tpl_vars['FIELD']->value['type']).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php
$_smarty_tpl->tpl_vars['FIELD'] = $foreach_FIELD_Sav;
}
}
}
?>