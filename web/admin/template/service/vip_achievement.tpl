<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <form method="get" action="" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="vipAchieve"/>

            <div class="form-group">
                <label>日期：</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/>~
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <label>母游戏：</label>
                <{widgets widgets=$widgets}>

                <!--<label>账号：</label>
                <input type="text" name="account" value="<{$data.account}>">-->

                <label>姓名：</label>
                <input type="text" name="kf_name" value="<{$data.kf_name}>">

                <button type="submit" class="btn btn-primary btn-xs">筛 选</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff" id="tableDiv">
                <table class="layui-table table table-bordered table-hover table-condensed table-striped table-responsive" style="min-width: 150px;">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>母游戏</th>
                        <th>总业绩</th>
                        <th>单笔提成</th>
                        <th>累计充值提成</th>
                        <th>提成用户数</th>
                        <th>总提成金额</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list key=key item=row}>
                    <tr>
                        <td><{$row.kf_name}></td>
                        <td><{$row.parent_game}></td>
                        <td><{$row.pay_money}></td>
                        <td>--</td>
                        <td>--</td>
                        <td><{$row.pay_man}></td>
                        <td>--</td>
                        <td>
                            <a href="?ct=kfVip&ac=viewlist&sdate=<{$data.sdate}>&edate=<{$data.edate}>&parent_id=<{$row.parent_id}>&kf_name=<{$row.kf_name}>&kfid=<{$row.insr_kefu}>" class="btn btn-default btn-xs">查看明细</a>
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

</script>
<{include file="../public/foot.tpl"}>

