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
        <input type="hidden" name="account_ids" value="<{$account_ids}>">
        <div class="form-group">
            <label for="device_id">预警线额度</label>
            <input type="number" class="form-control" name="fee" value="">
        </div>
        <div class="form-group">
            <button type="button" id="submit" class="btn btn-danger"> 确 认</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" id="cancel" class="btn btn-primary"> 取 消</button>
        </div>
        <div class="form-group" style="min-width: 100%">
            <label>批量设置账号列表：</label>
            <table class="table table-hover table-bordered table-condensed table-striped">
                <thead>
                <tr>
                    <th width="15%">账号ID</th>
                    <th >账号名称</th>
                </tr>
                </thead>
                <tbody>
                <{foreach from=$accounts_list key=k item=info}>
                    <tr>
                        <td><{$info.account_id}></td>
                        <td><{$media_conf[$info.media]}>-<{$info.account}>(<{$info.account_nickname}>)</td>
                    </tr>
                <{/foreach}>
                </tbody>
            </table>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('#submit').on('click', function () {
            var data = $('form').serialize();
            var index = parent.layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=system&ac=balanceWarnAddBatch', {
                data: data
            }, function (re) {
                parent.layer.close(index);
                parent.layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 2000,
                    end: function () {
                        if (re.state == 1) {
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