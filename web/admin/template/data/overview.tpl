<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="overview"/>
            <div class="form-group form-group-sm">
                <{widgets widgets=$widgets}>

                <!--<label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1" <{if $data.param.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2" <{if $data.param.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>-->

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.param.sdate}>" class="form-control Wdate"/> -
                <input type="text" name="edate" value="<{$data.param.edate}>" class="form-control Wdate"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>日期</th>
                        <th nowrap>总新增</th>
                        <th nowrap>消耗</th>
                        <th nowrap>激活数</th>
                        <th nowrap>激活成本<i class="fa fa-question-circle" alt="（消耗/激活数）"></i></th>
                        <th nowrap>当天新增</th>
                        <th nowrap>新增设备</th>
                        <th nowrap>激活注册率<i class="fa fa-question-circle" alt="（注册数/激活数）"></i></th>
                        <th nowrap>注册成本<i class="fa fa-question-circle" alt="（消耗/注册数）"></i></th>
                        <th nowrap>新增付费人数</th>
                        <th nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/当天新增）"></i></th>
                        <th nowrap>新增付费成本<i class="fa fa-question-circle" alt="（消耗/每日新增付费用户数）"></i></th>
                        <th nowrap>新增付费金额</th>
                        <th nowrap>新增ROI<i class="fa fa-question-circle" alt="（新增充值/消耗）"></i></th>
                        <th nowrap>新增ARPU<i class="fa fa-question-circle" alt="（新增付费金额/当天新增）"></i></th>
                        <th nowrap>新增ARPPU<i class="fa fa-question-circle" alt="（新增付费金额/新增付费人数）"></i></th>
                        <th nowrap>付费人数</th>
                        <th nowrap>付费率<i class="fa fa-question-circle" alt="（付费人数/DAU）"></i></th>
                        <th nowrap>总充值</th>
                        <th nowrap>ROI<i class="fa fa-question-circle" alt="（总充值/消耗）"></i></th>
                        <th nowrap>ARPU<i class="fa fa-question-circle" alt="（总充值/DAU）"></i></th>
                        <th nowrap>ARPPU<i class="fa fa-question-circle" alt="（总充值/付费人数）"></i></th>
                        <th nowrap>DAU</th>
                        <th nowrap>老用户活跃</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>合计</td>
                        <td nowrap>-</td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.cost}></b></td>
                        <td nowrap><b><{$data.total.active}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.active_cost}></b></td>
                        <td nowrap><b><{$data.total.reg_user}></b></td>
                        <td nowrap><b><{$data.total.reg_device}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.active_reg_rate}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.reg_cost}></b></td>
                        <td nowrap><b><{$data.total.new_pay_user}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_pay_rate}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_pay_cost}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_pay_money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_roi}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_arpu}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_arppu}></b></td>
                        <td nowrap><b><{$data.total.pay_user}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.pay_rate}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.pay_money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.roi}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.arpu}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.arppu}></b></td>
                        <td nowrap><b><{$data.total.avg_login_user}></b></td>
                        <td nowrap><b><{$data.total.old_user_active}></b></td>
                    </tr>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$u.total_user}></td>
                            <td nowrap class="text-danger"><b>¥<{$u.cost}></b></td>
                            <td nowrap><{$u.active}></td>
                            <td nowrap class="text-danger"><b>¥<{$u.active_cost}></b></td>
                            <td nowrap><{$u.reg_user}></td>
                            <td nowrap><{$u.reg_device}></td>
                            <td nowrap class="text-olive"><b><{$u.active_reg_rate}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.reg_cost}></b></td>
                            <td nowrap><{$u.new_pay_user}></td>
                            <td nowrap class="text-olive"><b><{$u.new_pay_rate}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_pay_cost}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_pay_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_roi}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_arpu}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_arppu}></b></td>
                            <td nowrap><{$u.pay_user}></td>
                            <td nowrap class="text-olive"><b><{$u.pay_rate}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.pay_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.roi}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.arpu}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.arppu}></b></td>
                            <td nowrap><{$u.login_user}></td>
                            <td nowrap><{$u.old_user_active}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
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

        $('#printExcel').click(function () {
            location.href = '?ct=data&ac=overviewExcel&parent_id=' + $('select[name=parent_id]').val() + '&device_type=' + $('select[name=device_type]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val();
        });
    });
</script>
<{include file="../public/foot.tpl"}>