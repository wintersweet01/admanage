<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=ad&ac=addDeliveryGroup" class="btn btn-primary btn-small" role="button"> + 添加投放组 </a><{/if}>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>投放组ID</td>
                        <td>投放组名称</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$u.group_id}></td>
                            <td><{$u.group_name}></td>
                            <td>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=ad&ac=addDeliveryGroup&group_id=<{$u.group_id}>">编辑</a><{/if}>
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