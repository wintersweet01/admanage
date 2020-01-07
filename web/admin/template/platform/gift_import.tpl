<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加游戏</u></li>
                    </ol>
                </div>
                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">* 选择游戏</label>
                    <div class="col-sm-9">
                        <{widgets widgets=$widgets}>
                    </div>
                </div>
                <div class="form-group">
                    <label for="type_id" class="col-sm-2 control-label">* 礼包类型</label>
                    <div class="col-sm-2">
                        <select name="type_id" class="form-control">
                            <option value="">选择礼包类型</option>
                            <{foreach from=$_types item=row}>
                        <option value="<{$row.id}>" <{if $data['type_id']==$row.id}>selected="selected"<{/if}>><{$row.type_name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="file_path" class="col-sm-2 control-label">* 上传礼包</label>
                    <div class="col-sm-3">
                        <div id="picker" class="picker">请选择礼包文件</div>
                        <div id="thelist" class="uploader-list help-block"></div>
                        <span class="help-block red">只能上传.txt格式文件，一个激活码一行</span>
                        <input type="hidden" name="upload_file" id="upload_file" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 导 入</button>&nbsp;&nbsp;&nbsp;&nbsp;
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
                title: 'TXT格式文件',
                extensions: 'txt',
                mimeTypes: 'text/plain'
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
                    layer.tips('请选择TXT文件', '#picker',{tips: [1, '#ff0000']});
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

            var index = layer.msg('正在导入中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.post('?ct=platform&ac=importGift', $('form').serializeArray(), function (re) {
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
                            location.href = '?ct=platform&ac=packageGift';
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });

        $('select[name=parent_id],select[name=game_id]').on('change', function () {
            var parent_id = $('select[name=parent_id] option:selected').val();
            var game_id = $('select[name=game_id] option:selected').val();
            if (!parent_id && !game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getGiftTypeList&parent_id=' + parent_id + '&game_id=' + game_id, function (re) {
                var html = '<option value="">选择礼包类型</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.id + '">' + n.type_name + '</option>';
                });
                $('select[name=type_id]').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>