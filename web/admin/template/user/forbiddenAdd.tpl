<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form method="post" action="">
        <input type="hidden" name="type" value="<{$type}>"/>
        <div class="form-group">
            <label for="content">封禁<span style="color: red;font-weight: bold;"><{$type_name}></span></label>
            <textarea class="form-control" name="content" rows="5" placeholder="输入需要封禁的<{$type_name}>，一行一个" required></textarea>
            <small class="form-text text-muted">支持批量添加，一行一个</small>
        </div>
        <div class="form-group">
            <label for="notes">原因</label>
            <textarea class="form-control" name="notes" rows="3" required></textarea>
        </div>
        <{if $type != 'user'}>
        <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="handle1" name="handle" value="all" class="custom-control-input" checked>
                <label class="custom-control-label" for="handle1">全部禁止</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="handle2" name="handle" value="reg" class="custom-control-input">
                <label class="custom-control-label" for="handle2">禁止注册</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="handle3" name="handle" value="login" class="custom-control-input">
                <label class="custom-control-label" for="handle3">禁止登录</label>
            </div>
        </div>
        <{/if}>
        <div class="form-group">
            <button type="button" id="submit" class="btn btn-danger"> 封 禁</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('#submit').on('click', function () {
            var type = $('input[name="type"]').val(),
                content = $('textarea[name="content"]').val(),
                notes = $('textarea[name="notes"]').val(),
                handle = $('input[name="handle"]:checked').val();

            if (!content) {
                layer.msg('请填写封禁内容');
                $('textarea[name="content"]').focus();
                return false;
            }

            if (!notes) {
                layer.msg('请填写封禁原因');
                $('textarea[name="notes"]').focus();
                return false;
            }

            var index = layer.load();
            $.post('/?ct=user&ac=forbiddenAdd', {
                type: type,
                content: content,
                notes: notes,
                handle: handle
            }, function (ret) {
                layer.close(index);
                if (ret.code === 1) {
                    layer.msg(ret.message, {icon: 6,shadeClose:true}, function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.layui.table.reload('table-report-' + type);
                    });
                } else {
                    layer.msg(ret.message,{icon: 5,shadeClose:true});
                }
            }, 'json');
        });

        $('#cancel').on('click', function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
</script>
<{include file="../public/footer.tpl"}>