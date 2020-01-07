<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=ad&ac=addChannel" class="btn btn-primary btn-small" role="button"> + 添加渠道 </a><{/if}>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <th>渠道ID</th>
                        <th>渠道名称</th>
                        <th>渠道别名</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$u.channel_id}></td>
                            <td><{$u.channel_name}></td>
                            <td><{$u.channel_short}></td>
                            <td>
                                <{if SrvAuth::checkPublicAuth('edit',false)}>
                                <a href="?ct=ad&ac=addChannel&channel_id=<{$u.channel_id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a>
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
<{include file="../public/foot.tpl"}>