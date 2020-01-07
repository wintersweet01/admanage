<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$_cdn_static_url_}>lib/layui/css/layui.css">
<script src="<{$_cdn_static_url_}>lib/layui/layui.js"></script>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="extend"/>
            <input type="hidden" name="ac" value="channelLog"/>
            <input type="hidden" name="monitor_id" value="<{$monitor_id}>"/>
            <div class="form-group form-group-sm">
                <lable>选择类型</lable>
                <select class="form-control" name="type">
                    <option value="">全 部</option>
                    <option value="active"
                    <{if $data.type=='active'}>selected="selected"<{/if}>> 激活 </option>
                    <option value="reg"
                    <{if $data.type=='reg'}>selected="selected"<{/if}>> 注册 </option>
                    <option value="pay"
                    <{if $data.type=='pay'}>selected="selected"<{/if}>> 付款 </option>
                    <option value="login"
                    <{if $data.type=='login'}>selected="selected"<{/if}>> 登录 </option>
                </select>
                <lable>时间</lable>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate"/>

                <label>搜索</label>
                <input type="text" class="form-control" name="keyword" value="<{$data.keyword}>" placeholder="推广链ID/推广名称"/>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel">
                    <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出
                </button>
            </div>
        </form>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <table class="layui-table" lay-size="sm">
            <thead>
            <tr>
                <th>推广链ID</th>
                <th>推广名称</th>
                <th>时间</th>
                <th>类型</th>
                <th>来源</th>
                <th>请求链接</th>
                <th>参数</th>
                <th>结果</th>
            </tr>
            </thead>
            <tbody>
            <{foreach from=$data.list item=u}>
                <tr>
                    <td><{$u.monitor_id}></td>
                    <td style="text-align: left;"><{$u.monitor_name}></td>
                    <td><{$u.upload_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                    <td><{$_type[$u.upload_type]['name']}></td>
                    <td><{$u.source}></td>
                    <td style="text-align: left;">
                        <{$u.url|truncate:50}>
                        <span class="copy btn btn-primary btn-xs" data-clipboard-text="<{$u.url}>">
                            <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> 复制URL
                        </span>
                    </td>
                    <td style="text-align: left;">
                        <{if $u.param}>
                        <span class="copy btn btn-primary btn-xs" data-clipboard-text="<{$u.param}>">
                            <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> 复制参数
                        </span>
                        <{/if}>
                    </td>
                    <td style="word-break:break-all;word-wrap:break-word; text-align: left;"><{$u.result}></td>
                </tr>
                <{/foreach}>
            </tbody>
        </table>
        <div style="float: left;">
            <nav>
                <ul class="pagination">
                    <{$data.page_html nofilter}>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#printExcel').click(function () {
            location.href = '?ct=extend&ac=channelLogExcel' + '&monitor_id=<{$monitor_id}>' + '&type=' + $('select[name=type]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val();
        });
    });
</script>
<{include file="../public/foot.tpl"}>