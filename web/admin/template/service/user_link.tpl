<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <form method="get" action="" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="userLink"/>
            <input type="hidden" name="parent_id" value="<{$data.parent_id}>">
            <div class="form-group">

                <label>母游戏：</label>
                <{widgets widgets=$widgets}>

                <label>联系人：</label>
                <select name="linker">
                    <option value="">请选择</option>
                    <{foreach from=$_admins key=key item=rows}>
                    <option <{if $data.linker eq $key}>selected="selected"<{/if}> value="<{$rows.admin_id}>"><{$rows.name}></option>
                    <{/foreach}>
                </select>

                <label>区服：</label>
                <input type="number" name="server_id" value="<{$data.server_id}>">

                <label>日期：</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> ~
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs">筛 选</button>
            </div>
        </form>
    </div>
    <div>
        <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
            <div class="table-content" style="float: left;width: 100%">
                <div style="background-color: #fff" id="tableDiv">
                    <table class="table table-bordered layui-table-hover table-condensed table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>应联系用户数</th>
                            <th>录入玩家数</th>
                            <th>联系率</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!--此处添加数据-->
                            <{foreach from=$data.link key=key item=rows}>
                                <tr>
                                    <td><{$_admins[$key]['name']}></td>
                                    <td><{$rows}></td>
                                    <td><{$data.insr[$key]}></td>
                                    <td><{if $rows neq 0 && $data.insr[$key] neq 0}><{(($data.insr[$key]/$rows)*100)|string_format:"%.2f"}>%<{else}>0<{/if}></td>
                                    <td><a href="?&ct=kfVip&ac=viewUserLink&kfid=<{$key}>&parent_id=<{$parent_id}>&server_id=<{$data.server_id}>&sdate=<{$data.sdate}>&edate=<{$data.edate}>" class="btn btn-default btn-xs">查看明细</a></td>
                                </tr>
                            <{/foreach}>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<{include file="../public/foot.tpl"}>