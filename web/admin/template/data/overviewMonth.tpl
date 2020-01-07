<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="OverviewMonth"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>月份</label>
                <input type="text" class="form-control" name="month" value="<{$data.month}>"/>

                <label class="checkbox-inline">
                    <input type="checkbox" name="plus_" value="1" <{if $data.plus_==1}>checked="checked"<{/if}> />
                    显示后续条目
                </label>

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <{if $data.all==1}>checked="checked"<{/if}> />显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;" id="tableDiv">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>日期</td>
                        <td nowrap>总新增</td>
                        <td nowrap>当天新增</td>
                        <td nowrap>DAU</td>
                        <td nowrap>老用户活跃</td>
                        <td nowrap>新增付费用户成本<i class="fa fa-question-circle" alt="（消耗/每日新增付费用户数）"></i></td>
                        <td nowrap>新增设备</td>
                        <td nowrap>新增付费人数</td>
                        <td nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/当天新增）"></i></td>
                        <td nowrap>新增ARPU<i class="fa fa-question-circle" alt="（新增付费金额/当天新增）"></i></td>
                        <td nowrap>新增ARPPU<i class="fa fa-question-circle" alt="（新增付费金额/新增付费人数）"></i></td>
                        <td nowrap>新增付费金额</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>付费率<i class="fa fa-question-circle" alt="（付费人数/DAU）"></i></td>
                        <td nowrap>ARPU<i class="fa fa-question-circle" alt="（总充值/DAU）"></i></td>
                        <td nowrap>ARPPU<i class="fa fa-question-circle" alt="（总充值/付费人数）"></i></td>
                        <td nowrap>总充值</td>
                        <td nowrap>消耗</td>

                        <td nowrap>新增ROI<i class="fa fa-question-circle" alt="（新增充值/消耗）"></i></td>
                        <td nowrap>ROI<i class="fa fa-question-circle" alt="（总充值/消耗）"></i></td>
                        <td nowrap>日累计ROI<i class="fa fa-question-circle" alt="（单月内的累计充值/单月内的累计消耗）"></i></td>
                        <td nowrap>次日留存<i class="fa fa-question-circle" alt="（次日留存数/当天新增）"></i></td>
                        <td nowrap>3日留存<i class="fa fa-question-circle" alt="（3日留存数/当天新增）"></i></td>
                        <td nowrap>7日留存<i class="fa fa-question-circle" alt="（7日留存数/当天新增）"></i></td>
                        <td nowrap>15日留存<i class="fa fa-question-circle" alt="（15日留存数/当天新增）"></i></td>
                        <td nowrap>30日留存<i class="fa fa-question-circle" alt="（30日留存数/当天新增）"></i></td>
                        <td nowrap>60日留存<i class="fa fa-question-circle" alt="（60日留存数/当天新增）"></i></td>
                        <td nowrap>90日留存<i class="fa fa-question-circle" alt="（90日留存数/当天新增）"></i></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td  nowrap>合计</td>
                        <td  nowrap></td>
                        <td  nowrap><{$data.total.all_reg_user}></td>
                        <td  nowrap><{$data.total.avg_login_user}></td>
                        <td  nowrap><{$data.total.all_old_user_active}></td>
                        <td  nowrap class="text-danger"><b>¥<{$data.total.all_new_pay_cost}></b></td>
                        <td  nowrap><{$data.total.all_reg_device}></td>
                        <td  nowrap><{$data.total.all_new_pay_user}></td>
                        <td  nowrap class="text-olive"><b><{$data.total.all_new_pay_rate}></b></td>
                        <td  nowrap class="text-danger">¥<b><{$data.total.all_new_ARPU}></b></td>
                        <td  nowrap class="text-danger">¥<b><{$data.total.all_new_ARPPU}></b></td>
                        <td  nowrap class="text-danger">¥<b><{$data.total.all_new_pay_money}></b></td>
                        <td  nowrap><{$data.total.all_pay_user}></td>
                        <td  nowrap class="text-olive"><b><{$data.total.all_pay_rate}></b></td>
                        <td  nowrap class="text-danger">¥<b><{$data.total.all_ARPU}></b></td>
                        <td  nowrap class="text-danger">¥<b><{$data.total.all_ARPPU}></b></td>
                        <td  nowrap class="text-danger">¥<b><{$data.total.all_pay_money}></b></td>
                        <td  nowrap class="text-danger">¥<b><{$data.total.total_cost}></b></td>
                        <td  nowrap class="text-olive"><b><{$data.total.all_new_ROI}></b></td>
                        <td  nowrap class="text-olive"><b><{$data.total.all_ROI}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.total_acROI}></b></td>
                        <td  nowrap><{$data.total.avg_retain2}> / <b class="text-olive"><{$data.total.all_2retain_rate}></b></td>
                        <td  nowrap><{$data.total.avg_retain3}> / <b class="text-olive"><{$data.total.all_3retain_rate}></b></td>
                        <td  nowrap><{$data.total.avg_retain7}> / <b class="text-olive"><{$data.total.all_7retain_rate}></b></td>
                        <td  nowrap><{$data.total.avg_retain15}> / <b class="text-olive"><{$data.total.all_15retain_rate}></b></td>
                        <td  nowrap><{$data.total.avg_retain30}> / <b class="text-olive"><{$data.total.all_30retain_rate}></b></td>
                        <td  nowrap><{$data.total.avg_retain60}> / <b class="text-olive"><{$data.total.all_60retain_rate}></b></td>
                        <td  nowrap><{$data.total.avg_retain90}> / <b class="text-olive"><{$data.total.all_90retain_rate}></b></td>

                    </tr>
                    <{foreach from=$data.list item=u}>
                        <tr <{if $u.nothismonth}>class='active'<{/if}>>
                            <td  nowrap ><{$u.date}></td>
                            <td  nowrap ><{$u.total_user}></td>
                            <td  nowrap ><{$u.reg_user}></td>
                            <td  nowrap ><{$u.login_user}></td>
                            <td  nowrap ><{$u.old_user_active}></td>
                            <td  nowrap  class="text-danger"><b>¥<{$u.new_pay_cost}></b></td>
                            <td  nowrap ><{$u.reg_device}></td>
                            <td  nowrap ><{$u.new_pay_user}></td>
                            <td  nowrap  class="text-olive"><b><{$u.new_pay_rate}></b></td>
                            <td  nowrap  class="text-danger"><b><{if $u.new_ARPU neq '-'}>¥<{/if}><{$u.new_ARPU}></b></td>
                            <td  nowrap  class="text-danger"><b><{if $u.new_ARPPU neq '-'}>¥<{/if}><{$u.new_ARPPU}></b></td>
                            <td  nowrap  class="text-danger"><b><{if $u.new_pay_money neq '-'}>¥<{/if}><{$u.new_pay_money}></b></td>
                            <td  nowrap ><{$u.pay_user}></td>
                            <td  nowrap  class="text-olive"><b><{$u.pay_rate}></b></td>
                            <td  nowrap  class="text-danger"><b>¥<{$u.ARPU}></b></td>
                            <td  nowrap  class="text-danger"><b>¥<{$u.ARPPU}></b></td>
                            <td  nowrap  class="text-danger"><b>¥<{$u.pay_money}></b></td>
                            <td  nowrap  class="text-danger"><b><{$u.cost}></b></td>

                            <td  nowrap  class="text-olive"><b><{$u.new_ROI}></b></td>
                            <td  nowrap  class="text-olive"><b><{$u.ROI}></b></td>
                            <td nowarp class="text-olive"><b><{$u.total_acROI}></b></td>
                            <td  nowrap ><{$u.retain2}> / <b class="text-olive" ><{$u.2retain_rate}></b></td>
                            <td  nowrap ><{$u.retain3}> / <b class="text-olive" ><{$u.3retain_rate}></b></td>
                            <td  nowrap ><{$u.retain7}> / <b class="text-olive" ><{$u.7retain_rate}></b></td>
                            <td  nowrap ><{$u.retain15}> / <b class="text-olive" ><{$u.15retain_rate}></b></td>
                            <td  nowrap ><{$u.retain30}> / <b class="text-olive" ><{$u.30retain_rate}></b></td>
                            <td  nowrap ><{$u.retain60}> / <b class="text-olive" ><{$u.60retain_rate}></b></td>
                            <td  nowrap ><{$u.retain90}> / <b class="text-olive" ><{$u.90retain_rate}></b></td>
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
    $(function(){
        $("#content-wrapper").scroll(function(){
            var left=$("#content-wrapper").scrollLeft()-14;//获取滚动的距离
            var trs=$("#tableDiv table tr");//获取表格的所有tr
            if(left == -14){
                left = 0;
            }
            trs.each(function(i){
                $(this).children().eq(0).css({
                    "position":"relative",
                    "top":"0px",
                    "left":left,
                    "background":"white"
                });
            });
        });
        $('#printExcel').click(function(){
            plus_ = $('input[name=plus_]:checked').val();
            if(plus_){
                plus_ = 1;
            }else{
                plus_ = 0;
            }

            location.href='?ct=data&ac=overviewMonthExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&device_type='+$('select[name=device_type]').val()+'&month='+$('input[name=month]').val()+'&plus_='+plus_;
        });
        $('input[name=sdate],input[name=month]').on('click focus',function() {
            WdatePicker({el:this, dateFmt:"yyyy-MM"});
        });

    });
</script>
<{include file="../public/foot.tpl"}>