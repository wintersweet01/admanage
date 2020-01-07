<{include file="../public/header.tpl"}>
<style>
    .active-menu {
        border-bottom: 2px solid green;
    }

    .box {
        width: 150px;
        height: 150px;
        float: left;
        display: block;
        margin: 25px 20px;
        background-color: #FFF;
        border: 1px solid #c3c3c3;
    }

    .content-main {
        background-color: #f7f8f8;
    }

    .content-main div:hover {
        border: 1px solid #2888ff;
    }

    .icon-video {
        width: 80%;
        margin: 0 auto;
    }

    .icon {
        vertical-align: center;
        float: left;
        margin-left: 33%;
        margin-top: 30%;
    }

    .text-tip {
        float: left;
        margin-left: 17%;
        margin-top: 10%;
    }

    .tool-content-mar {
        margin-top: 0.8%
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
                <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="/?ct=auxTool&ac=pictureTool&media=<{$media}>" data-type="picture"
                               class="tool_menu">图片</a></li>
                        <li><a href="/?ct=auxTool&ac=videoTool&media=<{$media}>" data-type="video"
                               class="tool_menu active-menu">视频</a></li>
                        <li><a href="/?ct=auxTool&ac=designTool&media=<{$media}>" data-type="design" class="tool_menu">创新形式</a>
                        </li>
                    </ul>
                </div>
                <div class="tool-content">
                    <div class="content-main">
                        <div class="box info-icons" type="h_16_9">
                            <div class="icon-video">
                                <i class="fa fa-file-video-o fa-3x icon" aria-hidden="true"></i>
                                <label class=" text-tip"><span class="text-black">横版视频 16:9</span></label>
                            </div>
                        </div>

                        <div class="box info-icons" type="s_9_16">
                            <div class="icon-video">
                                <i class="fa fa-file-video-o fa-3x icon" aria-hidden="true"></i>
                                <label class=" text-tip"><span class="text-black">竖版视频 9:16</span></label>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                    </div>

                    <!--内容-->
                    <div class="tool-content-mar">
                        <div id="h_16_9" style="display: none" class="">
                            <!--横板-->
                            <div>
                                <button type="button" class="btn btn-primary btn-sm tool-add-btn">添加素材</button>
                            </div>
                            <div>
                                <div class="layui-tab" lay-allowClose="true">
                                    <ul class="layui-tab-title tool-list">
                                        <!--选项卡列表-->
                                        <li class="layui-this">素材1</li>
                                    </ul>
                                    <div class="layui-tab-content tool-main">
                                        <!--素材列表-->
                                        <div id="tool_main_1" add_grad_num="1" class="layui-tab-item layui-show tool-main-list">
                                            <!--素材1-->
                                            <label class="tool-content-mar tool-title"><span style="font-size: 20px">上传创意1</span></label>
                                            <div style="width: 70%;height: 322px;margin: 0 auto;">
                                                <div style="width: 50%;height: 100%;float: left">
                                                    <div style="width: 100%;height: 80%;background-color: #f7f8f8;border: 1px solid #c3c3c3;border-right: none;border-bottom: none">
                                                        <div style="width: 70%;margin: 0 auto;">
                                                            <div style="width: 80%;text-align: center;margin: 8% auto;">
                                                                <p>1280px x 720px</p>
                                                                <p>(推荐尺寸)</p>
                                                                <p>点击上传</p>
                                                                <p>JPG/PNG，小于140KB</p>
                                                            </div>
                                                            <div class="layui-upload-drag tool-row" style="top: -29px;left: 15%" id="169h_tool_view_1">
                                                                <i class="layui-icon"></i>
                                                                <p>点击上传，或将文件拖拽到此处</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="width: 100%;height: 20%;background-color: snow;border: 1px solid #c3c3c3;text-align: center">
                                                        <label style="padding: 22px 0"><i class="fa fa-print"
                                                                                          aria-hidden="true"></i>
                                                            生成视频封面图</label>
                                                    </div>
                                                </div>
                                                <div style="width: 50%;height:80%;background-color: #f7f8f8;border: 1px solid #c3c3c3;float: left">
                                                    <div style="width: 80%;text-align: center;margin: 8% auto;">
                                                        <p>16:9</p>
                                                        <p>（推荐尺寸 1280x720）</p>
                                                    </div>
                                                    <div class="layui-upload-drag" style="top: -40px;left: 28%" id="169h_tool_video_1">
                                                        <i class="layui-icon"></i>
                                                        <p>点击上传，或将文件拖拽到此处</p>
                                                    </div>
                                                    <div style="width: 100%;text-align: center;position: relative;top: -12%;">
                                                        <span>MP4/MOV.AVI,小于50.00M，时长>=5s,<=60s,必须带有声音</span>
                                                    </div>
                                                </div>
                                                <div style="clear: both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="s_9_16" style="display: none" class="">
                            <!--竖版-->

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>

<link rel="stylesheet" type="text/css" href="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.css">
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/upload.min.js"></script>
<script type="text/javascript">

    layui.use(['element', 'upload'], function () {
        var element = layui.element;
        var upload = layui.upload;
        //执行实例
        /*var uploadInst = upload.render({
            elem: '#test10' //绑定元素
            ,url: '' //上传接口
            ,done: function(res){
                //上传完毕回调
            }
            ,error: function(){
                //请求异常回调
            }
        });*/

    });
    $(function () {
        $(".box").on('click', function () {
            var _this = $(this);
            var type = _this.attr('type');
            if (typeof type != 'undefined') {
                $("#" + type).show().siblings().hide();
            }
        });

        //添加素材
        $(".tool-add-btn").on('click', function () {
            var _main = $(".tool-main").find('div.layui-tab-item').last();
            var add_grad_num = _main.attr('add_grad_num');
            add_grad_num = parseInt(add_grad_num)+1;
            var clone = _main.clone();
            var prex = /(\w+)\_\d+/g;
            var str = "$1_" + add_grad_num + "";
            var s = clone.attr('id').replace(prex, str);

            clone.find('.tool-id').each(function(){
                var _this = $(this);
                var id_name = _this.attr('id');
                var s_name = id_name.replace(prex,str);
                _this.attr('id',s_name);
            });

            clone.attr('id', s);
            clone.attr('add_grad_num', add_grad_num);
            clone.find('.tool-title').children('span').html('上传创意' + add_grad_num);
            $(".tool-list").append('<li>素材' + add_grad_num + '</li>');
            $(".tool-main").append(clone);
            clone.siblings().removeClass('layui-show');
        });
    })
</script>
<{include file="../public/footer.tpl"}>