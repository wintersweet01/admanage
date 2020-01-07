<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="channel_id" value="<{$data.channel_id}>"/>

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
                               value="<{$data['info']['channel_name']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_short" class="col-sm-2 control-label">* 渠道别名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="channel_short" placeholder="只能填英文字母、数字和下划线，如：test"
                               value="<{$data['info']['channel_short']}>" <{if $data['info']['channel_short']}>disabled="disabled"<{/if}>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">上传logo</label>
                    <div class="col-sm-3">
                        <div id="picker" class="picker">请选择logo</div>
                        <div id="thelist" class="uploader-list help-block"></div>
                        <span class="help-block">尺寸：32*32，大小：<100KB</span>
                        <div id="thumbnail" class="col-xs-6 col-md-4" style="padding-left: 0px;">
                            <{if $data['info']['logo']}>
                            <div class="thumbnail">
                                <img src="uploads/<{$data['info']['logo']}>">
                            </div>
                            <{/if}>
                        </div>
                        <input type="hidden" name="logo" id="logo" value="<{$data['info']['logo']}>" />
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
<script>
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
</script>
<{include file="../public/foot.tpl"}>
