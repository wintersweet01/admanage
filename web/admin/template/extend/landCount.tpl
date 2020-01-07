<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>日期</td>
                        <td>落地页展示量PV/IP</td>
                        <td>落地页点击量PV/IP</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$u.date}></td>
                            <td><{$u.pv_visit}>/<{$u.visit}></td>
                            <td><{$u.pv_click}>/<{$u.click}></td>
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