<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>UID</th>
                        <th nowrap>账号</th>
                        <th nowrap>母游戏</th>
                        <th nowrap>注册游戏</th>
                        <th nowrap>游戏包</th>
                        <th nowrap>所属平台</th>
                        <th nowrap>注册地区</th>
                        <th nowrap>注册IP</th>
                        <th nowrap>注册时间</th>
                        <th nowrap>激活时间</th>
                        <th nowrap>最后登录时间</th>
                        <th nowrap>渠道</th>
                        <th nowrap>来源</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.uid}></td>
                            <td nowrap class="show-full" data-full="<{$u.username}>"><{$u.username|truncate:15}></td>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap>
                                <{if $u.device_type == 1}><span class="icon_ios"></span>
                                <{elseif $u.device_type == 2}><span class="icon_android"></span>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap><{$u.reg_city}></td>
                            <td nowrap><{$u.reg_ip}></td>
                            <td nowrap><{$u.reg_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap><{if $u.active_time}><{$u.active_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.last_login_time}><{$u.last_login_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{if $_channels[$u.channel_id]}><{$_channels[$u.channel_id]}><{else}>未知<{/if}></td>
                            <td nowrap><{if $u.monitor_name}><a href="<{$u.jump_url}>" target="_blank"><{$u.monitor_name}></a><{else}>-<{/if}>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div>
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
        var index;
        $('.show-full').mouseover(function () {
            var val = $(this).data('full');
            index = layer.tips(val, $(this));
        }).mouseout(function () {
            layer.close(index);
        });
    });
</script>
<{include file="../public/foot.tpl"}>