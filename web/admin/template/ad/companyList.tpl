<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="form-group">
            <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=ad&ac=addAdCompany" class="btn btn-primary btn-small" role="button"> + 添加广告资质公司 </a><{/if}>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>公司名</td>
                        <td>备案号</td>
                        <{*<td>域名</td>
                        <td>文网文</td>
                        <td>ICP</td>
                        <td>客服电话</td>*}>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$u.company_name}></td>
                            <td><{$u.record_no}></td>
                            <{*<td><{$u.domain}></td>
                            <td><{$u.www}></td>
                            <td><{$u.icp}></td>
                            <td><{$u.service_tel}></td>*}>
                            <td>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=ad&ac=addAdCompany&company_id=<{$u.company_id}>">编辑</a>&nbsp;&nbsp;<{/if}>
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