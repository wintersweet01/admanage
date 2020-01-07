<!DOCTYPE html>
<html>
<head>
    <title><{$__title__}></title>
    <{include file="../public/head.tpl"}>
    <script>window.UEDITOR_HOME_URL = "<{$_static_url_}>lib/ueditor/";</script>
    <script src="<{$_cdn_static_url_}>lib/ueditor/ueditor.config.js"></script>
    <script src="<{$_cdn_static_url_}>lib/ueditor/ueditor.all.min.js"></script>
    <script src="<{$_cdn_static_url_}>lib/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<div class="container-fluid" style="margin: 2rem;">
    <form method="post" action="">
        <div class="form-group">
            <label for="game_id">所属游戏</label>
            <{widgets widgets=$widgets}>
            <span class="help-block red">1、都不选，所有游戏都显示；2、只选母游戏，其所有子游戏都显示；3、只选子游戏，只在该游戏中显示；</span>
        </div>
        <div class="form-group">
            <label for="title">标题</label>
            <input type="text" class="form-control" name="title" value="">
        </div>
        <div class="form-group">
            <label for="name">内容</label>
            <script id="container" name="content" type="text/plain"></script>
        </div>
        <button type="button" id="submit" class="btn btn-primary"> 发 布</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        var ue = UE.getEditor('container');

        $('#submit').on('click', function () {
            parent.layer.confirm('<font color="red">发布成功后，客户端将即时弹出该消息</font><br><br>确定发布吗?', {
                btn: ['是的', '取消']
            }, function () {
                var data = $('form').serialize();
                var index = parent.layer.load(2, {shade: [0.6,'#fff']});
                $.post('?ct=article&ac=articleNoticeAction',{data:data}, function (re) {
                    parent.layer.close(index);
                    parent.layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        shadeClose: true,
                        content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                        time: 3000,
                        end: function () {
                            if (re.state) {
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                                parent.location.reload();
                            }
                        }
                    });
                }, 'json');
            }, function () {

            });
        });

        $('#cancel').on('click', function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
</script>
</body>
</html>