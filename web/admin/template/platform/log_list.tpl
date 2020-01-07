<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="logList"/>
            <div class="form-group form-group-sm">
                <lable>用户账号<i class="fa fa-question-circle" alt="必须指定用户账号才能查询日志!"></i></lable>
                <input type="text" class="form-control" name="username" value="<{$data.username}>"/>

                <lable>日志时间</lable>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate"/>

                <lable>日志类型</lable>
                <select class="form-control" name="type">
                    <option value="">全 部</option>
                    <{foreach from=$data._logs key=id item=name}>
                <option value="<{$name.id}>" <{if $data.type==$name.id}>selected="selected"<{/if}>> <{$name.name}> </option>
                    <{/foreach}>
                </select>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <td nowrap>日志时间</td>
                        <td nowrap>类型</td>
                        <td nowrap>日志</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap><{$data.logs[$u.type]}></td>
                            <td style="word-break:break-all;word-wrap:break-word;"><{$u.content}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div style="float: right;">
                <nav>
                    <ul class="pagination">
                        <{$data.page_html nofilter}>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

    });
</script>
<{include file="../public/foot.tpl"}>