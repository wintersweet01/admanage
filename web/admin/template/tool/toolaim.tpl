<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<style type="text/css">
    .table-header .navbar {
        margin-bottom: 0px;
    }

    .table-header .navbar-collapse {
        position: unset !important;
        background-color: unset !important;
        z-index: unset !important;
    }

    .table-header .form-group {
        margin-bottom: 15px;
    }

    .select2-container .select2-selection--multiple {
        min-height: 22px !important;
        margin-bottom: 5px;
    }

    .active-menu {
        border-bottom: 2px solid green;
        color:green;
    }
</style>
<div id="areascontent">
    <div class="rows table-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-table-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-table-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="/?ct=auxTool&ac=toolList" class="tool_menu">素材库</a></li>
                        <li><a href="/?ct=auxTool&ac=toolAim" class="tool_menu active-menu">定向库</a></li>
                        <li><a href="/?ct=auxTool&ac=toolText" class="tool_menu">文案库</a></li>
                    </ul>
                    <form id="media_form" class="form-group">
                        <div style="position: relative;float: right;top: 15px;">
                            <label class=''>选择媒体：</label>
                            <select name="media_cnf">
                                <{foreach from=$medias key=k item=info}>
                                <option value="<{$k}>"><{$info}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="rows table-content">

        <div>
            <!--素材显示列表-->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){

    })
</script>
<{include file="../public/footer.tpl"}>