<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <!--<div>
            <ol class="breadcrumb">
                <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                <li class="active"><u>VIP业绩</u></li>
            </ol>
        </div>-->
        <span class="text-blue" style="margin-bottom: 8px">正在查看 <e class="text-red"><{$param.kf_name}></e>的<e
                    class="text-red">《PID=PGID=<{$param.parent_id}> STIME=<{$param.sdate}> ETIME=<{$param.edate}>》
            </e>提成明细</span>

        <form method="get" action="" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="viewlist"/>
            <input type="hidden" name="sdate" value="<{$param.sdate}>"/>
            <input type="hidden" name="edate" value="<{$param.edate}>"/>
            <input type="hidden" name="parent_id" value="<{$param.parent_id}>"/>
            <input type="hidden" name="kf_name" value="<{$param.kf_name}>"/>
            <input type="hidden" name="kfid" value="<{$param.kfid}>"/>

            <div class="form-group">
                <label>子游戏：</label>
                <select name="game_id" style="margin-left: 0.2%">
                    <option value="">全部子游戏</option>
                    <{foreach from=$widg item=rows}>
                    <option <{if $rows.id eq $data.game_id}>selected="selected"<{/if}> value="<{$rows.id}>"><{$rows.text}></option>
                    <{/foreach}>
                </select>
                <label>玩家账号：</label>
                <input type="text" name="account" value="<{$data.account}>"/>
                <label>UID</label>
                <input type="text" name="uid" value="<{$data.uid}>"/>

                <button class="btn btn-primary btn-xs" type="submit">筛 选</button>
            </div>
        </form>
    </div>

    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff" id="tableDiv">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive"
                       style="min-width: 150px">
                    <thead>
                    <tr>
                        <th>游戏</th>
                        <th>角色名</th>
                        <th>用户ID</th>
                        <th>账号</th>
                        <th>区服</th>
                        <th>累计充值</th>
                        <th>累计提成</th>
                        <th>提成金额</th>
                        <th>单笔充值</th>
                        <th>提成金额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--显示内容-->
                    <{foreach from=$data.list key=key item=row}>
                    <tr>
                        <td><{$row.game_name}></td>
                        <td><{$row.rolename}></td>
                        <td><{$row.uid}></td>
                        <td><{$row.account}></td>
                        <td><{$row.server_id}></td>
                        <td><{$row.total_charge}></td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                    </tr>
                    <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div style="float: left;">
                <nav>
                    <ul class="pagination">
                        <{$data.page_html nofilter}>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>