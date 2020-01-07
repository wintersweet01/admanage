<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form class="needs-validation" method="post" action="" novalidate>
        <input type="hidden" name="game_id" value="<{$data['game_id']}>"/>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right text-sm-left">母游戏</label>
            <div class="col-sm-10">
                <{widgets widgets=$widgets}>
                <small class="form-text text-danger">如果“选择子游戏”，当前添加的游戏将自动继承该子游戏的对接参数。</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-md-right text-sm-left">游戏名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="由中文、英文字母、数字、下划线和减号组成" value="<{$data['name']}>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="alias" class="col-sm-2 col-form-label text-md-right text-sm-left">游戏别名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="alias" placeholder="由英文字母、数字和减号组成的小写字符串，如：test-88，不能重复" value="<{$data['alias']}>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="map_gid" class="col-sm-2 col-form-label text-md-right text-sm-left">映射CP游戏ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="map_gid" placeholder="有就填，否则留空" value="<{$data['map_gid']}>">
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">充值地址</label>
                <div class="col-sm-10">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">正式服：</span>
                        </div>
                        <input type="text" class="form-control" name="config[pay_url][main]" placeholder="游戏充值回调地址[正式服]" value="<{$data['config']['pay_url']['main']}>">
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">测试服：</span>
                        </div>
                        <input type="text" class="form-control" name="config[pay_url][test]" placeholder="游戏充值回调地址[测试服]" value="<{$data['config']['pay_url']['test']}>">
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">IOS提审服[内购版]：</span>
                        </div>
                        <input type="text" class="form-control" name="config[pay_url][ios]" placeholder="游戏充值回调地址[内购版]" value="<{$data['config']['pay_url']['ios']}>">
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">IOS提审服[免费版]：</span>
                        </div>
                        <input type="text" class="form-control" name="config[pay_url][noios]" placeholder="游戏充值回调地址[免费版]" value="<{$data['config']['pay_url']['noios']}>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="ratio" class="col-sm-2 col-form-label text-md-right text-sm-left">元宝兑换比例</label>
            <div class="col-sm-5 col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">1元：</span>
                    </div>
                    <input type="text" class="form-control" name="ratio" value="<{$data['ratio']}>" required>
                    <div class="input-group-append">
                        <span class="input-group-text">元宝</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="unit" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">人民币单位</label>
            <div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="unit1" name="unit" class="custom-control-input" value="0"
                    <{if $data['unit'] == 0}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="unit1">分</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="unit2" name="unit" class="custom-control-input" value="1"
                    <{if $data['unit'] == 1}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="unit2">元</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏类型</label>
            <div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type1" name="type" value="html5"
                    <{if $data['type'] == 'html5'}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="type1">html5</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type2" name="type" value="android"
                    <{if $data['type'] == 'android'}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="type2">android</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type3" name="type" value="ios"
                    <{if $data['type'] == 'ios'}>checked="checked"<{/if}>>
                    <label class="custom-control-label" for="type3">ios</label>
                </div>
            </div>
        </div>

        <div class="form-group" id="h5_login" style="display: none;">
            <div class="row">
                <label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">登录地址</label>
                <div class="col-sm-10">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">正式服：</span>
                        </div>
                        <input type="text" class="form-control" name="config[login_url][main]" placeholder="游戏入口地址[正式服]" value="<{$data['config']['login_url']['main']}>">
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">测试服：</span>
                        </div>
                        <input type="text" class="form-control" name="config[login_url][test]" placeholder="游戏入口地址[测试服]" value="<{$data['config']['login_url']['test']}>">
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">IOS提审服[内购版]：</span>
                        </div>
                        <input type="text" class="form-control" name="config[login_url][ios]" placeholder="游戏入口地址[内购版]" value="<{$data['config']['login_url']['ios']}>">
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">IOS提审服[免费版]：</span>
                        </div>
                        <input type="text" class="form-control" name="config[login_url][noios]" placeholder="游戏入口地址[免费版]" value="<{$data['config']['login_url']['noios']}>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏总开关</label>
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
        var type = '<{$data['type']}>';
        if (type == 'html5') {
            $('#h5_login').show();
        }

        //H5选项
        $('input[name="type"]').click(function () {
            if ($(this).val() == 'html5') {
                $('#h5_login').show();
            } else {
                $('#h5_login').hide();
            }
        });

        //子游戏事件
        $('select[name="children_id"]').on('change', function () {
            var id = $(this).find('option:selected').val();
            if (id > 0) {
                $('.inherit').hide();
            } else {
                $('.inherit').show();
            }
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
                $.post('?ct=unionConfig&ac=gameAdd', {
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