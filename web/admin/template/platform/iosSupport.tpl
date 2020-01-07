<{include file="../public/header-layui.tpl"}>
<div class="layui-fluid" style="padding: 15px;">
    <div class="layui-row">
        <input type="text" name="name" value="<{$data['name']}>" placeholder="游戏名称" class="layui-input" required>
    </div>
    <div class="layui-tab layui-tab-brief" lay-filter="support">
        <ul class="layui-tab-title">
            <li class="layui-this" lay-id="contacts">联系信息</li>
            <li lay-id="copyright">版权声明</li>
            <li lay-id="agreement">注册服务协议</li>
            <li lay-id="introduction">游戏介绍</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <script id="contacts" name="contacts" type="text/plain"><{$data['contacts'] nofilter}></script>
            </div>
            <div class="layui-tab-item">
                <script id="copyright" name="copyright" type="text/plain"><{$data['copyright'] nofilter}></script>
            </div>
            <div class="layui-tab-item">
                <script id="agreement" name="agreement" type="text/plain"><{$data['agreement'] nofilter}></script>
            </div>
            <div class="layui-tab-item">
                <script id="introduction" name="introduction" type="text/plain"><{$data['introduction'] nofilter}></script>
            </div>
        </div>
    </div>
    <div class="layui-row" align="center">
        <input type="hidden" name="game_id" value="<{$game_id}>"/>
        <button type="button" id="submit" class="layui-btn layui-btn-normal layui-btn-lg">保存</button>
        <button type="button" id="cancel" class="layui-btn layui-btn-primary layui-btn-lg">取消</button>
    </div>

</div>
<script>window.UEDITOR_HOME_URL = "<{$_static_url_}>lib/ueditor/";</script>
<script src="<{$_static_url_}>lib/ueditor/ueditor.config.js?v=1"></script>
<script src="<{$_static_url_}>lib/ueditor/ueditor.all.min.js"></script>
<script src="<{$_static_url_}>lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    layui.config({
        version: '201911052100'
    }).use(['element', 'form'], function () {
        let $ = layui.jquery,
            element = layui.element,
            device = layui.device();

        let ue1 = UE.getEditor('contacts'),
            ue2 = UE.getEditor('copyright'),
            ue3 = UE.getEditor('agreement'),
            ue4 = UE.getEditor('introduction');

        $('#submit').on('click', function () {
            let name = $('input[name="name"]').val();
            if (!name) {
                layer.msg('请输入游戏名称');
                return false;
            }

            if (!ue1.getContentTxt() && !ue2.getContentTxt() && !ue3.getContentTxt() && !ue4.getContentTxt()) {
                layer.msg('请填写内容再提交');
                return false;
            }

            let index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=platform&ac=iosSupport', {
                game_id: $('input[name="game_id"]').val(),
                name: name,
                contacts: ue1.getContent(),
                copyright: ue2.getContent(),
                agreement: ue3.getContent(),
                introduction: ue4.getContent(),
            }, function (ret) {
                layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + ret.message + '</p>',
                    time: 3000,
                    end: function () {
                        if (ret.code) {
                            let index = top.layer.getFrameIndex(window.name);
                            top.layer.close(index);
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            let index = top.layer.getFrameIndex(window.name);
            top.layer.close(index);
        });
    });
</script>
<{include file="../public/footer.tpl"}>