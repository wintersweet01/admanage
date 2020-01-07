<{include file="../public/header.tpl"}>
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
                        <input type="text" class="form-control Wdate" name="make_date" value="<{$make_date}>" style="width: 150px; height: 34px;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_type" class="col-sm-2 control-label">素材类型</label>
                    <div class="col-sm-3">
                        <select name="material_type" class="form-control" style="width: 100px;">
                            <option value="">请选择类型</option>
                            <{foreach from=$_types key=id item=name}>
                            <option value="<{$id}>"><{$name}></option>
                            <{/foreach}>
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
                            <{foreach from=$_admins key=id item=name}>
                            <option value="<{$id}>"><{$name}></option>
                            <{/foreach}>
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
<link rel="stylesheet" type="text/css" href="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.css">
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/upload.min.js"></script>
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
<script>
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
            $.post('?ct=optimizat&ac=addAdMaterialAction', $('form').serializeArray(), function (re) {
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
                            location.href = '?ct=optimizat&ac=adMaterial';
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });
    });
</script>
<{include file="../public/foot.tpl"}>