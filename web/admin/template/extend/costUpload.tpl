<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;margin-top:50px;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <div class="form-group">
                    <label for="model_id" class="col-sm-2 control-label">* 下载成本表格模板</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <{widgets widgets=$widgets}>
                        </div>

                        <div class="input-group">
                            <label for="channel_id">渠道：</label>
                            <select name="channel_id" style="width: 100px;">
                                <option value="">选择渠道</option>
                                <{foreach from=$_channels key=id item=name}>
                                <option value="<{$id}>"><{$name}></option>
                                <{/foreach}>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="create_user">负责人：</label>
                            <select name="create_user" style="width: 100px;">
                                <option value="">选择负责人</option>
                                <{foreach from=$_admins key=id item=name}>
                            <option value="<{$id}>" <{if $create_user==$id}>selected="selected"<{/if}>><{$name}></option>
                                <{/foreach}>
                            </select>&nbsp;
                        </div>

                        <span class="btn btn-primary btn-small" role="button" id="download"> 下 载 </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="model_id" class="col-sm-2 control-label">* 上传成本表格</label>
                    <div class="col-sm-3">
                        <div id="picker" class="picker">请选择EXCEL文件</div>
                        <div id="thelist" class="uploader-list help-block"></div>
                        <input type="hidden" name="upload_file" id="upload_file" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 录 入</button>&nbsp;&nbsp;&nbsp;&nbsp;
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
<script>
    $(function () {
        var param = {
            'url': '/?ct=Upload&ac=uploadTmp',
            'dom': '#picker',
            'list': '#thelist',
            'auto': true,
            'accept': {
                title: 'EXCEL格式文件',
                extensions: 'xls,xlsx',
                mimeTypes: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            }
        };
        var uploader = cwUpload.create(param, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    if (result.state) {
                        $('#upload_file').val(result.url);
                    } else {
                        $('#upload_file').val('');
                    }
                    break;
            }
        });

        //下载
        $('#download').on('click', function () {
            var game_id = parseInt($('select[name=game_id] option:selected').val());
            //var parent_id = parseInt($("select[name=parent_id] option:selected").val());
            var channel_id = parseInt($('select[name=channel_id] option:selected').val());
            var create_user = $('select[name=create_user] option:selected').val();
            //var url = '?ct=extend&ac=linkCostExcel&parent_id='+parent_id+'&game_id=' + game_id + '&channel_id=' + channel_id + '&create_user=' + create_user;
            var url = '?ct=extend&ac=linkCostExcel&game_id=' + game_id + '&channel_id=' + channel_id + '&create_user=' + create_user;
            window.open(url);
        });

        $('#submit').on('click', function () {
            var stats = uploader.getStats();
            if (stats.cancelNum) {
                return false;
            }

            if (uploader.isInProgress()) {
                layer.msg('正在上传中，请稍等...');
                return false;
            }

            if (!$('#upload_file').val()) {
                var files = uploader.getFiles();
                if (files.length == 0) {
                    layer.tips('请选择EXCEL文件', '#picker',{tips: [1, '#ff0000']});
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

            var index = layer.msg('正在录入中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.post('?ct=extend&ac=costUploadAction', {file:$('#upload_file').val()}, function (re) {
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
                            location.href = '?ct=extend&ac=costUploadList';
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