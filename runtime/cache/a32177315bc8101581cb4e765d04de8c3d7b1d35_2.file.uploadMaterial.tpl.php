<?php /* Smarty version 3.1.27, created on 2019-11-29 11:10:55
         compiled from "/home/vagrant/code/admin/web/admin/template/material/uploadMaterial.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1312379215de08c3f1a8059_78330939%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a32177315bc8101581cb4e765d04de8c3d7b1d35' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/material/uploadMaterial.tpl',
      1 => 1552967376,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1312379215de08c3f1a8059_78330939',
  'variables' => 
  array (
    'make_date' => 0,
    '_channels' => 0,
    'id' => 0,
    'name' => 0,
    'widgets' => 0,
    '_types' => 0,
    '_admins' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08c3f1ecbd3_73624564',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08c3f1ecbd3_73624564')) {
function content_5de08c3f1ecbd3_73624564 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1312379215de08c3f1a8059_78330939';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>素材库</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="material_name" class="col-sm-2 control-label">素材名称</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="material_name" value="">
                        <span class="help-block">如果不填，自动将上传文件名设为素材名称</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="make_date" class="col-sm-2 control-label">制作时间</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control Wdate" name="make_date" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['make_date']->value, ENT_QUOTES, 'UTF-8');?>
" style="width: 150px; height: 34px;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_id" class="col-sm-2 control-label">所属渠道</label>
                    <div class="col-sm-3">
                        <select name="channel_id" class="form-control" style="width: 100px;">
                            <option value="0">请选择渠道</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
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
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">所属游戏</label>
                    <div class="col-sm-3">
                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

                    </div>
                </div>

                <div class="form-group">
                    <label for="material_type" class="col-sm-2 control-label">素材类型</label>
                    <div class="col-sm-3">
                        <select name="material_type" class="form-control" style="width: 100px;">
                            <option value="">请选择类型</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_types']->value;
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
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">尺寸</label>
                    <div class="col-sm-6">
                        <div class="input-group col-sm-2" style="float: left; margin-right: 5px;">
                            <div class="input-group-addon">长</div>
                            <input type="text" class="form-control" name="material_x" value="">
                        </div>
                        <div class="input-group col-sm-2">
                            <div class="input-group-addon">宽</div>
                            <input type="text" class="form-control" name="material_y" value="">
                        </div>
                        <span class="help-block">如果不填，图片类型可自动计算大小</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_source" class="col-sm-2 control-label">需求来源</label>
                    <div class="col-sm-3">
                        <select name="material_source" class="form-control" style="width: 100px;">
                            <option value="">原创构思</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_admins']->value;
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
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_tag" class="col-sm-2 control-label">素材标签</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="material_tag" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">上传素材</label>
                    <div class="col-sm-3">
                        <div id="picker1" class="picker">请选择素材</div>
                        <button type="button" class="click_upload btn btn-warning">
                            <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 开始上传
                        </button>
                        <div id="thelist1" class="uploader-list help-block"></div>
                        <span class="help-block red">只能上传图片和视频素材，大小不限</span>
                        <input type="hidden" name="upload_file" id="upload_file" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">上传缩略图</label>
                    <div class="col-sm-3">
                        <div id="picker2" class="picker">请选择缩略图</div>
                        <div id="thelist2" class="uploader-list help-block"></div>
                        <span class="help-block">尺寸：200*113</span>
                        <div id="thumbnail2" class="col-xs-6 col-md-4" style="padding-left: 0px;"></div>
                        <input type="hidden" name="upload_thumb" id="upload_thumb" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/webuploader/webuploader.css">
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/webuploader/webuploader.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/upload.min.js"><?php echo '</script'; ?>
>
<style type="text/css">
    .picker {
        display: inline-block;
        vertical-align: middle;
        margin: 0 12px 0 0;
    }

    .click_upload {
        padding: 8px 12px;
        vertical-align: inherit;
    }
</style>
<?php echo '<script'; ?>
>
    $(function () {
        var state = 'pending';
        var $btn = $('.click_upload');
        var param = {
            'dom': '#picker1',
            'list': '#thelist1',
            'auto': false,
            'type': 'material',
            'url': '/?ct=material&ac=uploadAct&ext=material'
        };
        var uploader1 = cwUpload.create(param, function (type, result) {
            switch (type) {
                case 'all':
                    if (result === 'startUpload') {
                        state = 'uploading';
                    } else if (result === 'stopUpload') {
                        state = 'paused';
                    } else if (result === 'uploadFinished') {
                        state = 'done';
                    }

                    if (state === 'uploading') {
                        $btn.text('暂停上传');
                    } else {
                        $btn.text('开始上传');
                    }
                    break;
                case 'uploadSuccess':
                    if (result.state) {
                        $('#upload_file').val(result.url);
                        var e1 = $('form').find('input[name="material_name"]');
                        var e2 = $('form').find('input[name="material_x"]');
                        var e3 = $('form').find('input[name="material_y"]');
                        if (!e1.val() && result.name) {
                            e1.val(result.name);
                        }
                        if (!e2.val() && result.width) {
                            e2.val(result.width);
                        }
                        if (!e3.val() && result.height) {
                            e3.val(result.height);
                        }
                    } else {
                        $('#upload_file').val('');
                    }
                    break;
            }
        });

        $btn.on('click', function () {
            var files = uploader1.getFiles();
            if (files.length == 0) {
                layer.tips('请选择素材', '#picker1',{tips: [1, '#ff0000']});
                return false;
            }

            if (state === 'uploading') {
                uploader1.stop(true);
            } else {
                uploader1.upload();
            }
        });

        var param = {
            'dom': '#picker2',
            'list': '#thelist2',
            'auto': true,
            'type': 'img',
            'size': 2097152, //限制大小，单位为字节，2M
            'url': '/?ct=material&ac=uploadAct&ext=thumb'
        };
        cwUpload.create(param, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = 'uploads/' + result.url;
                    if (result.state) {
                        var img = $('#thumbnail2').find('.thumbnail img');
                        if (!img.length) {
                            img = $('<div class="thumbnail"><img src="' + url + '"></div>').appendTo($('#thumbnail2'));
                        } else {
                            img.attr('src', url);
                        }

                        $('#upload_thumb').val(result.url);
                    } else {
                        $('#upload_thumb').val('');
                    }
                    break;
            }
        });

        $('#submit').on('click', function () {
            var stats = uploader1.getStats();
            if (stats.cancelNum) {
                return false;
            }

            if (uploader1.isInProgress()) {
                layer.msg('正在上传素材中，请稍等...');
                return false;
            }

            if (!$('#upload_file').val()) {
                $btn.click();

                var t = setInterval(function () {
                    if ($('#upload_file').val()) {
                        clearInterval(t);
                        $('#submit').click();
                    }
                }, 1000);

                return false;
            }

            var index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=material&ac=uploadMaterial', $('form').serializeArray(), function (re) {
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
                            location.href = '?ct=material&ac=materialBox';
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>