<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form method="post" action="">
        <input type="hidden" name="package_id" value="<{$data.package_id}>"/>
        <div class="form-group">
            <label>游戏</label>
            <div class="form-group">
                <{widgets widgets=$widgets}>
            </div>
        </div>
        <div class="form-group">
            <label for="channel_id">渠道</label>
            <select class="form-control" name="channel_id" <{if $data['info']}>disabled="disabled"<{/if}>>
            <option value="">选择渠道</option>
            <{foreach from=$_channels key=id item=name}>
        <option value="<{$id}>" <{if $data['info']['channel_id']==$id}>selected="selected"<{/if}>><{$name}></option>
            <{/foreach}>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">默认投放账号</label>
            <select class="form-control" name="user_id" id="user_id" <{if $data['info']}>disabled="disabled"<{/if}>>
            <option value="">选择账号</option>
            </select>
        </div>
        <div class="form-group">
            <label for="platform">平台</label>
            <div class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="platform1" name="platform" value="1" class="custom-control-input"
                    <{if $data['info']}>disabled="disabled"<{/if}>
                    <{if $data['info']['platform'] == 1}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="platform1">IOS</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="platform2" name="platform" value="2" class="custom-control-input"
                    <{if $data['info']}>disabled="disabled"<{/if}>
                    <{if $data['info']['platform'] == 2}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="platform2">Android</label>
                </div>
            </div>
        </div>
        <div class="form-group for for-1"
        <{if $data['info']['platform']==2 || !$data['info']['platform']}>style="display: none;"<{/if}>>
        <label for="spec_name">bundleID</label>
        <input type="text" class="form-control" name="spec_name" value="<{$data['info']['spec_name']}>" placeholder="请填写跟SDK技术哥获取bundleID的值"
        <{if $data['info']}>disabled="disabled"<{/if}>>
</div>

<div class="form-group for for-1"
<{if $data['info']['platform']==2 || !$data['info']['platform']}>style="display: none;"<{/if}>>
<label for="down_url">AppstoreID</label>
<input type="text" class="form-control" name="down_url" value="<{$data['info']['down_url']}>" placeholder="APP在苹果商店上的访问ID">
</div>

<div class="form-group for for-2" style="display: none;">
    <label for="package_num">分包数量</label>
    <input type="text" class="form-control" name="package_num" value="">
</div>

<div class="form-group">
    <button type="button" id="submit" class="btn btn-danger">保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" id="cancel" class="btn btn-default">取 消</button>
</div>
</form>
</div>
<script type="text/javascript">
    $(function () {
        $('select[name=channel_id]').on('change', function () {
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!channel_id) {
                return false;
            }
            $.getJSON('?ct=extend&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="">选择账号</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#user_id').html(html);
            });
        });

        $('input[name=platform]').on('click', function () {
            $('.for').hide();
            $('.for-' + $(this).val()).show();
        });

        $('#submit').on('click', function () {
            let index = layer.load();
            $.post('?ct=platform&ac=addPackageAction', {
                data: $('form').serialize()
            }, function (re) {
                layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state) {
                            if ($('input[name=platform]:checked').val() == 2) {
                                parent.location.href = '?ct=platform&ac=refreshProgress&state=1&game_id=' + $('select[name=game_id]').val();
                            }
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            let index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
</script>
<{include file="../public/footer.tpl"}>
