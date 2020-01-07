<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">单IP每天限制注册数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_ip_reg]" value="<{$data['max_ip_reg']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单IP每天限制登录数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_ip_login]" value="<{$data['max_ip_login']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单设备号每天限制注册数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_device_reg]" value="<{$data['max_device_reg']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单设备号每天限制登录数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_device_login]" value="<{$data['max_device_login']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">单手机每天发短信数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_phone_sms]" value="<{$data['max_phone_sms']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">玩家每天登录次数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_user_login]" value="<{$data['max_user_login']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">玩家每天登录密码错误次数</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[max_user_login_error]" value="<{$data['max_user_login_error']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">绑定手机充值总额</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[pay_bind_phone]" value="<{$data['pay_bind_phone']}>" placeholder="玩家累计充值多少后提示绑定手机">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">IP白名单</label>
                    <div class="col-lg-5 col-sm-9">
                        <textarea name="config[whitelist_ip]" rows="3" class="form-control" placeholder="多个IP换行"><{$data['whitelist_ip']}></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">设备号白名单</label>
                    <div class="col-lg-5 col-sm-9">
                        <textarea name="config[whitelist_device]" rows="3" class="form-control" placeholder="多个设备号换行"><{$data['whitelist_device']}></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">登录玩家账号统一密码</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="config[login_password]" value="<{$data['login_password']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-lg-5 col-sm-9">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#submit').on('click', function () {
            var index = layer.msg('正在保存中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.post('?ct=platform&ac=config', {
                data: $('form').serialize()
            }, function (re) {
                layer.close(index);
                if (re.state == true) {
                    layer.alert('保存成功', {icon: 6}, function () {
                        location.reload();
                    });
                } else {
                    layer.alert(re.msg, {icon: 5});
                }
            }, 'json');
        });
    });
</script>
<{include file="../public/foot.tpl"}>