<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><{$__title__}></title>
    <link rel="stylesheet" href="<{$_cdn_static_url_}>lib/bootstrap/css/bootstrap.min.css">
    <script src="<{$_cdn_static_url_}>js/jquery-3.3.1.min.js"></script>
    <script src="<{$_cdn_static_url_}>lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="<{$_cdn_static_url_}>lib/layer/layer.js"></script>
</head>
<body>
<div class="container-fluid" style="padding: 2rem;">
    <form method="post" action="">
        <div class="form-group">
            <label for="ip">IP</label>
            <input type="text" class="form-control" name="ip" value="">
        </div>
        <div class="form-group">
            <label for="device_id">设备号</label>
            <input type="text" class="form-control" name="device_id" value="">
        </div>
        <div class="form-group">
            <label for="username">账号</label>
            <input type="text" class="form-control" name="username" value="">
        </div>
        <div class="form-group">
            <label for="username">原因</label>
            <input type="text" class="form-control" name="explain" value="">
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" value="all" checked>
                <label class="form-check-label" for="inlineRadio1">全部禁止</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" value="reg">
                <label class="form-check-label" for="inlineRadio1">禁止注册</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" value="login">
                <label class="form-check-label" for="inlineRadio1">禁止登录</label>
            </div>
        </div>
        <div class="form-group">
            <button type="button" id="submit" class="btn btn-danger"> 封 禁</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('#submit').on('click', function () {
            var data = $('form').serialize();
            var index = parent.layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=platform&ac=forbiddenAdd', {
                data: data
            }, function (re) {
                parent.layer.close(index);
                parent.layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.message + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.code == 1) {
                            top.location.reload();
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
</script>
</body>
</html>