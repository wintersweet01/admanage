<{include file='../public/header.tpl'}>
<div id="areascontent">
    <div class="rows">
        <ol class="breadcrumb">
            <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
            <li class="active"><u>添加/编辑VIP账号</u></li>
        </ol>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <input type="hidden" value="<{$author_id}>"/>
        <span style="font-weight: 600;font-size: 12px"><e class="text-danger">《<{$all_admin[$author_id]['name']}>》</e>的游戏区服权限</span>
    </div>
    <div class="rows">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff">
                <table class="table table-bordered layui-table-hover table-responsive ">
                    <thead>
                    <tr>
                        <td width="20%">母游戏</td>
                        <td width="10%">平台</td>
                        <td>区服</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data key=key item=rows}>

                        <{if count($rows) >= 2}>
                        <tr>
                            <td rowspan="<{count($rows)}>"><{$_games[$key]}></td>
                            <td>
                                IOS<span class="icon_ios"></span>
                            </td>
                            <td style="font-size: 14px;text-align: left">
                                <{foreach from=$rows[1] item=servers}>
                                <{foreach from=$servers item=ser}>
                                <e><{$ser}></e>
                                ,
                                <{/foreach}>
                                <{/foreach}>
                            </td>
                        </tr>
                        <tr>
                            <td>安卓<span class="icon_android"></span></td>
                            <td style="font-size: 14px;text-align: left">
                                <{foreach from=$rows[2] item=servers}>
                                <{foreach from=$servers item=ser}>
                                <e><{$ser}></e>
                                ,
                                <{/foreach}>
                                <{/foreach}>
                            </td>
                        </tr>
                        <{else}>
                        <tr>
                            <td rowspan="<{count($rows)}>"><{$_games[$key]}></td>
                            <{if $rows[1]}>
                            <td>
                                IOS<span class="icon_ios"></span>
                            </td>
                            <td style="font-size: 14px;text-align: left">
                                <{foreach from=$rows[1] item=servers}>
                                <{foreach from=$servers item=ser}>
                                <e><{$ser}></e>
                                ,
                                <{/foreach}>
                                <{/foreach}>
                            </td>
                            <{/if}>
                            <{if $rows[2]}>
                            <td>安卓<span class="icon_android"></span></td>
                            <td style="font-size: 14px;text-align: left">
                                <{foreach from=$rows[2] item=servers}>
                                <{foreach from=$servers item=ser}>
                                <e><{$ser}></e>
                                ,
                                <{/foreach}>
                                <{/foreach}>
                            </td>
                            <{/if}>
                        </tr>
                        <{/if}>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<{include file='../public/foot.tpl'}>