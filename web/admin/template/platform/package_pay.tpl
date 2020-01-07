<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form method="post" action="">
        <input type="hidden" name="game_id" value="<{$game_id}>"/>
        <input type="hidden" name="package_name" value="<{$package_name}>"/>

        <div class="form-group">
            <label for="status">游戏状态</label>
            <div class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status0" name="status" value="0" class="custom-control-input"
                    <{if $data['status'] == 0}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="status0">随母包</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status1" name="status" value="1" class="custom-control-input"
                    <{if $data['status'] == 1}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="status1">正常</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status2" name="status" value="2" class="custom-control-input"
                    <{if $data['status'] == 2}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="status2">测试</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status3" name="status" value="3" class="custom-control-input"
                    <{if $data['status'] == 3}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="status3">提审[内购版]</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status4" name="status" value="4" class="custom-control-input"
                    <{if $data['status'] == 4}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="status4">提审[免费版]</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="status">实名认证</label>
            <div class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="is_adult0" name="config[is_adult]" value="0" class="custom-control-input"
                    <{if $data['config']['is_adult'] == 0}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="is_adult0">随母包</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="is_adult1" name="config[is_adult]" value="1" class="custom-control-input"
                    <{if $data['config']['is_adult'] == 1}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="is_adult1">关</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="is_adult2" name="config[is_adult]" value="2" class="custom-control-input"
                    <{if $data['config']['is_adult'] == 2}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="is_adult2">开</label>
                </div>
            </div>
        </div>

        <div class="form-group" style="display: none;">
            <label for="pay">支付设置</label>
            <{if $platform == 1}>
            <div class="form-group">
                <input type="text" class="form-control" name="alias" placeholder="填写APP版本号（app_version）" value="<{$data['info']['alias']}>">
                <{foreach from=$_pay_types key=k item=v}>
                <label class="checkbox-inline"><input type="checkbox" name="pay_type[<{$version}>][]" value="<{$k}>"
                    <{if $k|in_array:$data['pay_type'][$version]}>checked="checked"<{/if}>> <{$v}></label>
                <{/foreach}>
                <small class="form-text text-muted">如果填写app_version，则对应当前（游戏）包切换为appstore支付</small>
            </div>
            <{else}>
            <div class="form-group">版本号(app_version)：
                <input type="text" class="form-control" name="alias" placeholder="填写APP版本号（app_version）" value="<{$data['info']['alias']}>" style="width: 150px;display: inline-block;">
                <{foreach from=$_pay_types key=k item=v}>
                <label class="checkbox-inline"><input type="checkbox" name="pay_type[<{$version}>][]" value="<{$k}>"
                    <{if $k|in_array:$data['pay_type'][$version]}>checked="checked"<{/if}>> <{$v}></label>
                <{/foreach}>
                <small class="form-text text-muted">可为每个版本设置独立的支付方式</small>
            </div>
            <{/if}>
        </div>

        <div class="form-group">
            <button type="button" id="submit" class="btn btn-danger">保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" id="cancel" class="btn btn-default">取 消</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('#submit').on('click', function () {
            let index = layer.load();
            $.post('?ct=platform&ac=packagePayAction', {
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
