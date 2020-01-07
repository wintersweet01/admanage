<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="optimizat" />
            <input type="hidden" name="ac" value="adCopywriting" />

            <div class="form-group form-group-sm">
                <label>高级筛选：</label>

                <{widgets widgets=$widgets}>

                <select name="channel">
                    <option value=""  <{if $data.channel==''}>selected="selected"<{/if}>>选择渠道</option>
                    <option value="1" <{if $data.channel=='1'}>selected="selected"<{/if}>>广点通</option>
                    <option value="2" <{if $data.channel=='2'}>selected="selected"<{/if}>>今日头条</option>
                </select>
                <input type="text" class="form-control" name="keyword" value="<{$data.keyword}>" placeholder="请输入文案或标签关键字">

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <{if SrvAuth::checkPublicAuth('add',false)}><button type="button" class="btn btn-primary btn-sm" onclick="location.href='?ct=optimizat&ac=addJrttAd'"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> 新建广告</button><{/if}>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td nowrap>文案</td>
                        <td nowrap>标签</td>
                        <td nowrap>渠道</td>
                        <td nowrap>添加时间</td>
                        <td nowrap>更新时间</td>
                        <td nowrap>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap=""><{$u.id}></td>
                            <td nowrap><{$u.content}></td>
                            <td nowrap><{if $u.tag != ''}><{foreach from=explode(',',$u.tag) item=t}><span class="label label-info" style="margin-right: 3px;"><{$t}></span><{/foreach}><{/if}></td>
                            <td nowrap><{if $u.channel == 1}><span class="label label-primary">广点通</span><{else}><span class="label label-warning">今日头条</span><{/if}></td>
                            <td nowrap><{$u.create_time}></td>
                            <td nowrap><{$u.update_time}></td>
                            <td nowrap>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=optimizat&ac=addCopywriting&id=<{$u.id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><{/if}>
                                <{if SrvAuth::checkPublicAuth('del',false)}><span class="delete btn btn-danger btn-xs" data-id="<{$u.id}>">删除</span><{/if}>
                            </td>
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
        $('.delete').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('确定删除吗?', {
                btn: ['是的', '取消']
            }, function () {
                $.getJSON('?ct=optimizat&ac=deleteCopywriting&id=' + id, function (re) {
                    layer.msg(re.msg);
                    if (re.code == 1) {
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                });
            }, function () {

            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>