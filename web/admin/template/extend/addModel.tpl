<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="model_id" id="model_id" value="<{$model_id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改落地页模板</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">所属游戏</label>
                    <div class="col-sm-3">
                        <{widgets widgets=$widgets}>
                    </div>
                </div>

                <div class="form-group">
                    <label for="model_name" class="col-sm-2 control-label">模板名称</label>
                    <div class="col-sm-3">
                        <input type="text" name="model_name" value="<{$data['model_name']}>" class="form-control">
                        <span class="help-block">如果不填，自动将上传文件名设为模板名称</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">上传模板压缩包</label>
                    <div class="col-sm-3">
                        <div id="picker1" class="picker">请选择压缩包</div>
                        <button type="button" class="click_upload btn btn-warning">开始上传</button>
                        <div id="thelist1" class="uploader-list help-block"></div>
                        <span class="help-block red">
                            只能上传.zip格式压缩包文件，大小不限
                            <{if $data.zip}><br>重新上传将删除之前的包，请慎重<{/if}>
                        </span>
                        <input type="hidden" name="upload_file" id="upload_file" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">上传缩略图</label>
                    <div class="col-sm-3">
                        <div id="picker2" class="picker">请选择缩略图</div>
                        <div id="thelist2" class="uploader-list help-block"></div>
                        <span class="help-block">
                            尺寸：200*250，大小：<500KB
                            <{if $data.thumb}><br>重新上传将删除之前的缩略图<{/if}>
                        </span>
                        <div id="thumbnail2" class="col-xs-6 col-md-4" style="padding-left: 0px;">
                            <{if $data.thumb}>
                            <div class="thumbnail"><img src="uploads/<{$data.thumb}>"/></div>
                            <{/if}>
                        </div>
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
            'url': '/?ct=Upload&ac=uploadTmp',
            'dom': '#picker1',
            'list': '#thelist1',
            'auto': false,
            'accept': {
                title: '.zip格式文件',
                extensions: 'zip',
                mimeTypes: 'application/x-zip-compressed'
            }
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
                        var e = $('form').find('input[name="model_name"]');
                        if (!e.val() && result.name) {
                            e.val(result.name);
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
                layer.tips('请选择压缩包', '#picker1',{tips: [1, '#ff0000']});
                return false;
            }

            if (state === 'uploading') {
                uploader1.stop(true);
            } else {
                uploader1.upload();
            }
        });

        var param = {
            'url': '/?ct=Upload&ac=uploadAdmin',
            'dom': '#picker2',
            'list': '#thelist2',
            'auto': true,
            'type': 'img',
            'size': 512000 //限制大小，单位为字节，500KB
        };
        var uploader2 = cwUpload.create(param, function (type, result) {
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
            var model_id = $('#model_id').val();
            var files = uploader1.getFiles();
            var stats = uploader1.getStats();
            if (stats.cancelNum) {
                return false;
            }

            if (uploader1.isInProgress()) {
                layer.msg('正在上传模板压缩包中，请稍等...');
                return false;
            }

            if ((!model_id || files.length > 0) && !$('#upload_file').val()) {
                $btn.click();

                var t = setInterval(function () {
                    if ($('#upload_file').val()) {
                        clearInterval(t);
                        $('#submit').click();
                    }
                }, 1000);

                return false;
            }

            if (!model_id && !$('#upload_thumb').val()) {
                layer.tips('请上传缩略图', '#picker2',{tips: [1, '#ff0000']});
                return false;
            }

            var index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=extend&ac=addLandModel', $('form').serializeArray(), function (re) {
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
                            location.href = '?ct=extend&ac=landModel';
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