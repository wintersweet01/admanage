<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=admin&ac=addAdmin" class="btn btn-primary btn-small" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加管理员 </a><{/if}>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>账号</td>
                        <td nowrap>姓名</td>
                        <td nowrap>角色</td>
                        <td nowrap>添加时间</td>
                        <td nowrap>最后登录时间</td>
                        <td nowrap>最后登录IP</td>
                        <td nowrap>添加人</td>
                        <td nowrap>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.user}></td>
                            <td nowrap><{$u.name}></td>
                            <td nowrap><span class="label label-danger"><{if $u.admin_id == 1}>超级管理员<{else}><{$u.role_name}><{/if}></span></td>
                            <td nowrap><{if $u.ct}><{$u.ct|date_format:"%Y-%m-%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.last_lt}><{$u.last_lt|date_format:"%Y-%m-%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{$u.last_ip}></td>
                            <td nowrap><{$u.creator}></td>
                            <td nowrap>
                                <{if $u.admin_id != $_userid_}>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=admin&ac=addAdmin&admin_id=<{$u.admin_id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><{/if}>
                                <{if SrvAuth::checkPublicAuth('del',false)}><span class="delete btn btn-danger btn-xs" data-id="<{$u.admin_id}>">删除</span><{/if}>
                                <{/if}>
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
                $.getJSON('?ct=admin&ac=deleteAdmin&id=' + id, function (re) {
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