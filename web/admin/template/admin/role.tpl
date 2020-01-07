<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=admin&ac=roleAdd" class="btn btn-primary btn-small" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加角色 </a><{/if}>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>角色ID</td>
                        <td nowrap>角色名称</td>
                        <td nowrap>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.role_id}></td>
                            <td nowrap><{$u.role_name}></td>
                            <td nowrap>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=admin&ac=roleAdd&role_id=<{$u.role_id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><{/if}>
                                <{if SrvAuth::checkPublicAuth('del',false)}><span class="delete btn btn-danger btn-xs" data-id="<{$u.role_id}>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</span><{/if}>
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
            layer.confirm('删除后已使用该角色的管理员将无权限<br><br>确定删除吗?', {
                btn: ['是的', '取消']
            }, function () {
                $.getJSON('?ct=admin&ac=roleDelete&id=' + id, function (re) {
                    layer.msg(re.message);
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