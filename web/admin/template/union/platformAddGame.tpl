<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form class="needs-validation" method="post" action="" novalidate>
        <input type="hidden" name="platform_id" value="<{$data['platform_id']}>"/>
        <input type="hidden" name="game_id" value="<{$data['game_id']}>"/>
        <input type="hidden" name="type" value="<{$data['type']}>"/>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right text-sm-left">选择游戏/平台</label>
            <div class="col-sm-10">
                <{widgets widgets=$widgets}>
                <select name="platform_id" style="width: 150px;" <{if $data['platform_id'] > 0}>disabled<{/if}>>
                <option value="0">选择平台</option>
                    <{foreach from=$_platform key=id item=name}>
                    <option value="<{$id}>" <{if $data['platform_id'] == $id}>selected<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="map_gid" class="col-sm-2 col-form-label text-md-right text-sm-left">映射平台游戏ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="map_gid" placeholder="有就填，否则留空" value="<{$data['map_gid']}>">
            </div>
        </div>

        <div class="form-group row">
            <label for="open_time" class="col-sm-2 col-form-label text-md-right text-sm-left">首服时间</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" class="form-control" name="open_time" value="<{$data['open_time']}>" required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar fa-lg"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏开关</label>
            <div class="col-sm-10">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" id="lock" name="lock" class="custom-control-input" value="1"
                    <{if $data['lock'] == 1}>checked<{/if}>>
                    <label class="custom-control-label" for="lock">冻结</label>
                </div>
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" id="is_login" name="is_login" class="custom-control-input" value="1"
                    <{if $data['is_login'] == 1}>checked<{/if}>>
                    <label class="custom-control-label" for="is_login">登录</label>
                </div>
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" id="is_pay" name="is_pay" class="custom-control-input" value="1"
                    <{if $data['is_pay'] == 1}>checked<{/if}>>
                    <label class="custom-control-label" for="is_pay">充值</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right text-sm-left"></label>
            <div class="col-sm-10">
                <button type="button" id="submit" class="btn btn-success mr-4">保 存</button>
                <button type="button" id="cancel" class="btn btn-warning">取 消</button>
            </div>
        </div>
    </form>
</div>
<script src="<{$_cdn_static_url_}>lib/My97DatePicker/WdatePicker.js"></script>
<script>
    $(function () {
        //日期
        $('input[name="open_time"]').on('click', function () {
            WdatePicker({
                el: this,
                dateFmt: "yyyy-MM-dd HH:00",
                minDate: '%y-%M-%d',
                readOnly: true
            });
        });

        var validation = Array.prototype.filter.call($('form'), function (elem) {
            var form = $(elem);
            $('#submit').on('click', function (event) {
                if (elem.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.addClass('was-validated');
                    return false;
                }

                var index = parent.layer.msg('保存中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=unionConfig&ac=platformAddGame', {
                    data: form.serialize()
                }, function (re) {
                    parent.layer.close(index);
                    parent.layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        shadeClose: true,
                        content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                        time: 3000,
                        end: function () {
                            if (re.state == true) {
                                top.location.reload();
                            }
                        }
                    });
                }, 'json');
            });

        });

        $('#cancel').on('click', function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
</script>
<{include file="../public/foot.tpl"}>