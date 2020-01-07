<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="game_id" value="<{$data.game_id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>上传母包</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">游戏名称</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><{$data.name}></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">更新日志</label>
                    <div class="col-sm-3">
                        <textarea name="description" id="description" rows="10" class="form-control"
                                  placeholder="更新日志：&#10; 1、修复BUG；&#10; 2、增加悬浮框。"><{$data['description']}></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">上传母包</label>
                    <div class="col-sm-3">
                        <div id="picker" class="picker">请选择母包</div>
                        <button type="button" class="click_upload btn btn-warning">
                            <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 开始上传
                        </button>
                        <div id="thelist" class="uploader-list help-block"></div>
                        <span class="help-block red">只能上传.apk格式文件，大小不限</span>
                        <input type="hidden" name="upload_file" id="upload_file" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">更新类型</label>
                    <div class="col-sm-3">
                        <label class="radio-inline">
                            <input type="radio" name="type" value="1"
                            <{if $data['type'] == 1}>checked="checked"<{/if}>> 正常更新
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="2"
                            <{if $data['type'] == 2}>checked="checked"<{/if}>> 强制更新
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="3"
                            <{if $data['type'] == 3}>checked="checked"<{/if}>> 忽略更新
                        </label>
                        <span class="help-block">正常更新：提示所有玩家可选更新，或不更新；<br>强制更新：所有玩家必须更新才能进游戏，是否退出。<br>忽略更新：老玩家不提示更新，新下载玩家将使用新版本</span>
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
            'url': '/?ct=platform&ac=uploadApk',
            'dom': '#picker',
            'list': '#thelist',
            'auto': false,
            'accept': {
                title: 'Android安装包文件，后缀为.apk',
                extensions: 'apk',
                mimeTypes: 'application/vnd.android.package-archive'
            }
        };
        var uploader = cwUpload.create(param, function (type, result) {
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
                    } else {
                        $('#upload_file').val('');
                    }
                    break;
            }
        });

        $btn.on('click', function () {
            var files = uploader.getFiles();
            if (files.length == 0) {
                layer.tips('请选择母包', '#picker',{tips: [1, '#ff0000']});
                return false;
            }

            if (state === 'uploading') {
                uploader.stop(true);
            } else {
                uploader.upload();
            }
        });

        $('#submit').on('click', function () {
            var stats = uploader.getStats();
            if (stats.cancelNum) {
                return false;
            }

            if (uploader.isInProgress()) {
                layer.msg('正在上传母包中，请稍等...');
                return false;
            }

            var description = $('#description').val().replace(/[\s\n\t]+/g, "");
            if (!description) {
                layer.tips('请填写更新日志后再提交保存', '#description',{tips: [2, '#ff0000']});
                return false;
            }

            if (!$('#upload_file').val()) {
                var files = uploader.getFiles();
                if (files.length == 0) {
                    layer.tips('请选择母包', '#picker',{tips: [1, '#ff0000']});
                    return false;
                }
                var t = setInterval(function () {
                    if ($('#upload_file').val()) {
                        clearInterval(t);
                        $('#submit').click();
                    }
                }, 1000);

                return false;
            }

            var index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=platform&ac=gameUpdateAction', $('form').serializeArray(), function (re) {
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
                            location.href = '?ct=platform&ac=gameList';
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