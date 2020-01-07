<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form class="needs-validation" method="post" action="" novalidate>
        <input type="hidden" name="platform_id" value="<{$data['platform_id']}>"/>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-md-right text-sm-left">平台名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="由中文、英文字母、数字、下划线和减号组成" value="<{$data['name']}>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="alias" class="col-sm-2 col-form-label text-md-right text-sm-left">平台别名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="alias" placeholder="由英文字母、数字和减号组成的小写字符串，如：test-88，不能重复" value="<{$data['alias']}>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">平台总开关</label>
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

<script>
    $(function () {
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
                $.post('?ct=unionConfig&ac=platformAdd', {
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