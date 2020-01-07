<{include file="../public/header.tpl"}>
<style>
    .active-menu {
        border-bottom: 2px solid green;
    }
</style>

<div id="areascontent">
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
                        <li><a href="/?ct=auxTool&ac=pictureTool&media=<{$media}>" data-type="picture" class="tool_menu">图片</a></li>
                        <li><a href="/?ct=auxTool&ac=videoTool&media=<{$media}>" data-type="video" class="tool_menu">视频</a></li>
                        <li><a href="/?ct=auxTool&ac=designTool&media=<{$media}>" data-type="design" class="tool_menu active-menu">创新形式</a></li>
                    </ul>
                </div>
                <div class="tool-content">

                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){

    })
</script>
<{include file="../public/footer.tpl"}>