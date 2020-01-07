<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form method="post" action="">
        <div class="form-group">
            <label for="password">原密码</label>
            <input type="password" class="form-control" name="password" value="">
        </div>
        <div class="form-group">
            <label for="password1">新密码</label>
            <input type="password" class="form-control" name="password1" value="">
        </div>
        <div class="form-group">
            <label for="password2">确认密码</label>
            <input type="password" class="form-control" name="password2" value="">
        </div>
        <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" name="name" value="<{$user['name']}>">
        </div>
        <div class="form-group">
            <button type="button" id="submit" class="btn btn-primary"> 修 改</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('#submit').on('click', function () {
            var data = $('form').serialize();
            var index = parent.layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=base&ac=modifyAdminInfo',{data:data}, function (re) {
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
                            top.location.href = '?ct=index&ac=logout';
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
<{include file="../public/footer.tpl"}>