<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adDataIOS"/>
            <input type="hidden" name="ac" value="userCycle"/>
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择账号</label>
                <select name="user_id" style="width: 150px;">
                    <option value="">全 部</option>
                    <{foreach from=$_user_list  item=item}>
                <option value="<{$item.user_id}>" <{if $data.user_id eq $item.user_id}>selected="selected"<{/if}>> <{$item.user_name}> </option>
                    <{/foreach}>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;" id="tableDiv">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>时间</td>
                        <td nowrap>账号</td>
                        <td nowrap>消耗</td>
                        <td nowrap>展示</td>
                        <td nowrap>点击</td>
                        <td nowrap>点击率</td>
                        <td nowrap>点击均价</td>
                        <td nowrap>点击注册率</td>
                        <td nowrap>注册</td>
                        <td nowrap>注册成本</td>
                        <td nowrap>次日留存数</td>
                        <td nowrap>留存率</td>
                        <td nowrap>留存成本</td>
                        <td nowrap>新增付费人数</td>
                        <td nowrap>新增付费率</td>
                        <td nowrap>新增付款成本</td>
                        <td nowrap>新增付费金额</td>
                        <td nowrap>新增ROI</td>
                        <td nowrap>新增ARPU</td>
                        <td nowrap>新增ARPPU</td>
                        <td nowrap>注册ARPU</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>总充值</td>
                        <td nowrap>ROI</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>汇总</td>
                        <td nowrap></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.total_cost}></b></td>
                        <td nowrap><{$data.total.total_display}></td>
                        <td nowrap><{$data.total.total_click}></td>
                        <td nowrap class="text-olive"><b><{$data.total.total_click_rate}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.total_avg_cprice}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.total_click_reg_rate}></b></td>
                        <td nowrap><{$data.total.total_reg}></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.reg_cost}></b></td>
                        <td nowrap><{$data.total.total_retain}></td>
                        <td nowrap class="text-olive"><b><{$data.total.retain_rate}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.retain_cost}></b></td>
                        <td nowrap><{$data.total.total_new_pay}></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_pay_rate}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_pay_cost}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.total_new_pay_money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_ROI}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_ARPU}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_ARPPU}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.reg_ARPU}></b></td>
                        <td nowrap><{$data.total.total_pay}></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.total_pay_money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.ROI}></b></td>
                    </tr>
                    <{foreach from=$data.list key=k item=v}>
                        <{foreach from=$v key=key item=item}>
                        <tr>
                            <td nowrap><{$item.date}></td>
                            <td nowrap><{$item.user_name}>(<{$item.channel}>)</td>
                            <td nowrap class="text-danger"><b>¥<{($item.cost/100)|string_format:"%0.2f"}></b></td>
                            <td nowrap><{$item.display}></td>
                            <td nowrap><{$item.click}></td>
                            <td nowrap class="text-olive"><b><{if $item.display}><{($item.click*100/$item.display)|string_format:"%0.2f"}><{else}>0<{/if}>%</b></td>
                            <td nowrap class="text-danger"><b>¥<{if $item.click}><{($item.cost/100/$item.click)|string_format:"%0.2f"}><{else}>0<{/if}></b></td>
                            <td nowrap class="text-olive"><b><{if $item.click}><{($item.reg*100/$item.click)|string_format:"%0.2f"}><{else}>0<{/if}>%</b></td>
                            <td nowrap><{$item.reg}></td>
                            <td nowrap class="text-danger"><b>¥<{if $item.reg}><{($item.cost/100/$item.reg)|string_format:"%0.2f"}><{else}>0<{/if}></b></td>
                            <td nowrap><{$item.retain1}></td>
                            <td nowrap class="text-olive"><b><{if $item.reg}><{($item.retain1*100/$item.reg)|string_format:"%0.2f"}><{else}>0<{/if}>%</b></td>
                            <td nowrap class="text-danger"><b>¥<{if $item.retain1}><{($item.cost/100/$item.retain1)|string_format:"%0.2f"}><{else}>0<{/if}></b></td>
                            <td nowrap><{$item.new_pay}></td>
                            <td nowrap class="text-olive"><b><{if $item.reg}><{($item.new_pay*100/$item.reg)|string_format:"%0.2f"}><{else}>0<{/if}>%</b></td>
                            <td nowrap class="text-danger"><b>¥<{if $item.new_pay}><{($item.cost/100/$item.new_pay)|string_format:"%0.2f"}><{else}>0<{/if}></b></td>
                            <td nowrap class="text-danger"><b>¥<{($item.new_pay_money/100)}></b></td>
                            <td nowrap class="text-olive"><b><{if $item.cost}><{($item.new_pay_money*100/$item.cost)|string_format:"%0.2f"}><{else}>0<{/if}>%</b></td>
                            <td nowrap class="text-danger"><b>¥<{if $item.reg}><{($item.new_pay_money/100/$item.reg)|string_format:"%0.2f"}><{else}>0<{/if}></b></td>
                            <td nowrap class="text-danger"><b>¥<{if $item.new_pay}><{($item.new_pay_money/100/$item.new_pay)|string_format:"%0.2f"}><{else}>0<{/if}></b></td>
                            <td nowrap class="text-danger"><b>¥<{if $item.reg}><{($item.pay_money/100/$item.reg)|string_format:"%0.2f"}><{else}>0<{/if}></b></td>
                            <td nowrap><{$item.pay}></td>
                            <td nowrap class="text-danger"><b>¥<{($item.pay_money/100)}></b></td>
                            <td nowrap class="text-olive"><b><{if $item.cost}><{($item.pay_money*100/$item.cost)|string_format:"%0.2f"}><{else}>0<{/if}>%</b></td>
                        </tr>
                        <{/foreach}>
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
            location.href='?ct=adDataIOS&ac=userCycleExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&user_id='+$('select[name=user_id]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });
    });
</script>
<{include file="../public/foot.tpl"}>