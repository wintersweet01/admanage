<{include file='../public/header.tpl'}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">

    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff">
                <table class="table table-bordered layui-table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>状态</th>
                        <th>授权</th>
                        <th>权限列表</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$author key=key item=row}>
                    <tr>
                        <td><{$row.name}></td>
                        <td><{if $row.state eq 0}>
                            <span class="text-success">启用</span>
                            <{elseif $row.state eq 1}>
                            <span class="text-danger">禁用</span>
                            <{/if}>
                        </td>
                        <td><a href="?&ct=kfVip&ac=authorPower&author_id=<{$row.admin_id}>" class="btn btn-default btn-xs">游戏区服授权</a></td>
                        <td><a href="?&ct=kfVip&ac=viewAuthorPower&author_id=<{$row.admin_id}>" class="btn btn-default btn-xs">查看我的权限</a></td>
                    </tr>
                    <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<{include file='../public/foot.tpl'}>