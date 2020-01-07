<{include file="../public/header.tpl"}>
<style>
    .active-menu {
        border-bottom: 2px solid green;
    }

    .content-main {
        background-color: #f7f8f8;
        width: 35%;
        height: 260px;
        margin: 0 auto;
        margin-top: 0.8%;

    }

    .tool-content {
        width: 95%;
        margin: 0 auto;
        margin-top: 0.8%;
    }
</style>

<div id="areascontent" style="width: 100%;overflow: hidden">
    <div class="row" style="margin-bottom: 0.8%;overflow: hidden">
        <div style="float: left;width: 100%">
            <form method="post" action="" id="myForm" class="form-horizontal">
                <input type="hidden" name="media" value="<{$media}>">
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back" class="text-blue">返 回</a></li>
                        <li class="active"><u>添加素材</u></li>
                    </ol>
                </div>
                <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1"
                     style="border-bottom: 1px solid #c2c2c2">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/?ct=auxTool&ac=hvideoTool&meida=<{$media}>" data-type="hvidoe"
                               class="tool_menu active-menu">横板视频</a>
                        </li>
                        <li>
                            <a href="/?ct=auxTool&ac=svideoTool&media=<{$media}>" data-type="svidoe" class="tool_menu">竖版视频</a>
                        </li>
                        <li>
                            <a href="/?ct=auxTool&ac=hPictureTool&media=<{$media}>" data-type="hpicture"
                               class="tool_menu ">横板大图</a>
                        </li>
                        <li>
                            <a href="/?ct=auxTool&ac=sPictureTool&media=<{$media}>" data-type="spicture"
                               class="tool_menu">竖版大图</a>
                        </li>
                        <li>
                            <a href="/?ct=auxTool&ac=gPictureTool&media=<{$media}>" data-type="gpicture"
                               class="tool_menu">组图</a>
                        </li>
                        <li>
                            <a href="/?ct=auxTool&ac=smPictureTool&media=<{$media}>" data-type="smpicture"
                               class="tool_menu">小图</a>
                        </li>
                    </ul>
                </div>
                <div class="tool-content">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn layui-btn-normal" id="testList">选择多文件</button>
                        <div class="layui-upload-list">
                            <table class="layui-table">
                                <thead>
                                <tr>
                                    <th>文件名</th>
                                    <th>大小</th>
                                    <th>文件MD5标识</th>
                                    <th>视频封面</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody id="demoList"></tbody>
                            </table>
                        </div>
                        <button type="button" class="layui-btn" id="testListAction">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<script type="text/javascript">

    layui.use(['element', 'upload'], function () {
        var element = layui.element;
        var upload = layui.upload;

        //多文件列表示例
        var demoListView = $('#demoList')
            , uploadListIns = upload.render({
            elem: '#testList'
            , url: '/?ct=Upload&ac=uploadTool'
            , accept: 'video'
            , multiple: true
            , auto: false
            , size:50*1014
            , data:{
                'limit_size':50*1014,
                'name':'file',
            }
            , choose: function (obj) {
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function (index, file, result) {
                    console.log(index);
                    var tr = $(['<tr id="upload-' + index + '">'
                        , '<td>' + file.name + '</td>'
                        , '<td>' + (file.size / 1014).toFixed(1) + 'kb</td>'
                        , '<td></td>'
                        , '<td></td>'
                        , '<td>等待上传</td>'
                        , '<td>'
                        , '<button type="button" class="layui-btn layui-btn-xs tool-upload">上传</button>'
                        , '<button type="button" class="layui-btn layui-btn-xs layui-btn-primary demo-view layui-hide">生成封面</button>'
                        , '<button type="button" class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                        , '</td>'
                        , '</tr>'].join(''));

                    //单个重传
                    tr.find('.tool-upload').on('click', function () {
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.demo-delete').on('click', function () {
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });
                    //生成封面
                    tr.find('.demo-view').on('click', function () {
                        var sbl = $(this).parent('td').siblings('td');
                        var key = sbl.eq(2).html();
                        var url_obj = sbl.eq(3);
                        createView(file, key, url_obj);
                    });
                    demoListView.append(tr);
                });
            }
            , done: function (res, index, upload) {
                if (res.code == 0) { //上传成功
                    var tr = demoListView.find('tr#upload-' + index)
                        , tds = tr.children();
                    var data = res.data;
                    tds.eq(4).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(2).html(data.key);
                    tds.eq(5).find('.demo-view').removeClass('layui-hide');//生成封面
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            , error: function (index, upload) {
                var tr = demoListView.find('tr#upload-' + index)
                    , tds = tr.children();
                tds.eq(4).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(5).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });

        function createView(file, key, url_o) {
            if (typeof file != 'object' && key) {
                layer.msg('生成封面失败',{time:1000});
                return false;
            }
            $.ajax({
                type:'post',
                url:'/?ct=auxTool&ac=createView',
                data:{
                    'file':file.name,
                    'key':key
                },
                success:function(e){
                    console.log(e)
                },
            })
        }
    });
    $(function () {
    })
</script>
<{include file="../public/footer.tpl"}>