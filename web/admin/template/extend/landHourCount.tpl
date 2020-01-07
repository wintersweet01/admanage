<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>游戏名称</td>
                        <td>游戏包</td>
                        <td>渠道名称</td>
                        <td>推广名称</td>
                        <td>监测地址</td>
                        <td>日期</td>
                        <td>落地页展示量</td>
                        <td>落地页点击量</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$_games[$data.game_id]}></td>
                            <td><{$data.package_name}></td>
                            <td><{$_channels[$data.channel_id]}></td>
                            <td><{$data.name}></td>
                            <td><{$data.monitor_url}></td>
                            <td><{$u.date}> <{$u.hour}>:00</td>
                            <td><{$u.visit}></td>
                            <td><{$u.click}></td>
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