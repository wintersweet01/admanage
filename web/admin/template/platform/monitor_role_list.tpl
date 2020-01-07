<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>游戏角色</td>
                        <td>玩家账号</td>
                        <td>游戏名称</td>
                        <td>平台</td>
                        <td>包标识</td>
                        <td>区服</td>
                        <td>创建时间</td>
                        <td>当前等级</td>
                        <td>充值总额</td>
                        <td>最后充值时间</td>
                        <td>最后登录时间</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data item=u}>
                        <tr>
                            <td><{$u.role_name}></td>
                            <td><{$u.username}></td>
                            <td><{$_games[$u.game_id]}></td>
                            <td><{$u.platform}></td>
                            <td><{$u.package_name}></td>
                            <td><{$u.server_id}></td>
                            <td><a href="?ct=platform&ac=logList&type=role&username=<{$u.username}>&sdate=<{$u.reg_time|date_format:"%Y-%m-%d %H:%M:%S"}>"><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}></a></td>
                            <td><{$u.role_level}></td>
                            <td><a href="?ct=platform&ac=orderList&username=<{$u.username}>">¥<{$u.pays/100}></a></td>
                            <td><{if $u.pay_time}><a href="?ct=platform&ac=orderList&username=<{$u.username}>"><{$u.pay_time|date_format:"%Y/%m/%d %H:%M:%S"}></a><{else}>-<{/if}></td>
                            <td><{if $u.logint_time}><{$u.logint_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<{include file="../public/foot.tpl"}>