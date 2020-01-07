<?php /* Smarty version 3.1.27, created on 2019-11-28 20:36:15
         compiled from "/home/vagrant/code/admin/web/admin/template/ad/addChannel.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:19782473005ddfbf3fdf4115_20325103%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2144c81f60d834f78c9b1201bf1892282d7dafa' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/ad/addChannel.tpl',
      1 => 1541486488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19782473005ddfbf3fdf4115_20325103',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddfbf3fe34d45_24416533',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddfbf3fe34d45_24416533')) {
function content_5ddfbf3fe34d45_24416533 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '19782473005ddfbf3fdf4115_20325103';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="channel_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['channel_id'], ENT_QUOTES, 'UTF-8');?>
"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加渠道</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="channel_name" class="col-sm-2 control-label">* 渠道名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="channel_name"
                               value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['channel_name'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_short" class="col-sm-2 control-label">* 渠道别名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="channel_short" placeholder="只能填英文字母、数字和下划线，如：test"
                               value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['channel_short'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['channel_short']) {?>disabled="disabled"<?php }?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">上传logo</label>
                    <div class="col-sm-3">
                        <div id="picker" class="picker">请选择logo</div>
                        <div id="thelist" class="uploader-list help-block"></div>
                        <span class="help-block">尺寸：32*32，大小：<100KB</span>
                        <div id="thumbnail" class="col-xs-6 col-md-4" style="padding-left: 0px;">
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['logo']) {?>
                            <div class="thumbnail">
                                <img src="uploads/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['logo'], ENT_QUOTES, 'UTF-8');?>
">
                            </div>
                            <?php }?>
                        </div>
                        <input type="hidden" name="logo" id="logo" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['logo'], ENT_QUOTES, 'UTF-8');?>
" />
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
<?php echo '<script'; ?>
>
    $(function () {
        var param = {
            'dom': '#picker',
            'list': '#thelist',
            'auto': true,
            'type': 'img',
            'size': 102400, //限制大小，单位为字节，100KB
            'url': '/?ct=upload&ac=uploadAdmin'
        };
        cwUpload.create(param, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = 'uploads/' + result.url;
                    if (result.state) {
                        var img = $('#thumbnail').find('.thumbnail img');
                        if (!img.length) {
                            img = $('<div class="thumbnail"><img src="' + url + '"></div>').appendTo($('#thumbnail'));
                        } else {
                            img.attr('src', url);
                        }

                        $('#logo').val(result.url);
                    } else {
                        $('#logo').val('');
                    }
                    break;
            }
        });

        $('#submit').on('click', function () {
            var data = $('form').serialize();
            $.post('?ct=ad&ac=addChannelAction',{data:data}, function (re) {
                if (re.state == true) {
                    location.href = '?ct=ad&ac=channelList';
                } else {
                    layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        shadeClose: true,
                        content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                        time: 3000,
                        end: function () {

                        }
                    });
                }

            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });

    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>