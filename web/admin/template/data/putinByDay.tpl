<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="putinByDay"/>
            <div class="form-group">
                <label>游戏</label>
                <{widgets widgets=$widgets}>

                <label>渠道</label>
                <select name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>注册日期</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <label>付款日期</label>
                <input type="text" name="psdate" value="<{$data.psdate}>" class="Wdate"/> -
                <input type="text" name="pedate" value="<{$data.pedate}>" class="Wdate"/>

                <label>负责人</label>
                <select name="create_user" class="form-control">
                    <option value="">选择负责人</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data.create_user==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>日期</td>
                        <td nowrap>当日新增</td>
                        <td nowrap>新增设备</td>
                        <td nowrap>新增付费人数</td>
                        <td nowrap>新增付费金额</td>
                        <td nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/当日新增）"></i></td>
                        <td nowrap>新增ARPU<i class="fa fa-question-circle" alt="（新增付费金额/当日新增）"></i></td>
                        <td nowrap>新增ARPPU<i class="fa fa-question-circle" alt="（新增付费金额/新增付费人数）"></i></td>
                        <td nowrap>新增ROI<i class="fa fa-question-circle" alt="（新增付费金额/推广消耗）"></i></td>
                        <td nowrap>新增付费成本<i class="fa fa-question-circle" alt="（推广消耗/新增付费人数）"></i></td>
                        <td nowrap>推广消耗</td>
                        <td nowrap>推广成本<i class="fa fa-question-circle" alt="（推广消耗/当日新增）"></i></td>
                        <td nowrap>付费人数</td>
                        <td nowrap>总充值</td>
                        <td nowrap>累计ROI<i class="fa fa-question-circle" alt="（总充值/推广消耗）"></i></td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$u.reg_user}></td>
                            <td nowrap><{$u.reg_device}></td>
                            <td nowrap><{$u.new_pay_user}></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_pay_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_pay_rate}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_arpu}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_arppu}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_roi}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_pay_cost}></b></td>
                            <td nowrap class="text-olive"><b><{$u.consume}></b></td>
                            <td nowrap class="text-olive"><b><{$u.consume_cost}></b></td>
                            <td nowrap><{$u.pay_user}></td>
                            <td nowrap class="text-danger"><b>¥<{$u.pay_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.roi}></b></td>
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
<script>
    $(function () {
        $("#content-wrapper").scroll(function () {
            var left = $("#content-wrapper").scrollLeft() - 14;//获取滚动的距离
            var trs = $("#tableDiv table tr");//获取表格的所有tr
            if (left == -14) {
                left = 0;
            }
            trs.each(function (i) {
                if (left) {
                    $(this).children().eq(0).css({
                        "position": "relative",
                        "top": "0px",
                        "left": left,
                        "background": "#00FFFF"
                    });
                } else {
                    $(this).children().eq(0).removeAttr('style');
                }
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>