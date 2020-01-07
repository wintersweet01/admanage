<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline" id="ltv_form">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="ltv"/>
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="platform">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>
                <label style="margin-left: 6px">查看数据</label>
                <select name="only_view" class="view-data">
                    <option value="">请选择</option>
                    <option value="1" <{if $only_view eq 1}>selected="selected"<{/if}> >只看充值</option>
                    <option value="2" <{if $only_view eq 2}>selected="selected"<{/if}> >只看LTV</option>
                </select>
                <label>日期</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <label class="checkbox-inline">
                    <input type="checkbox" style="position: relative;top: 2px" name="all" value="1" <{if $data.all==1}>checked="checked"<{/if}> />
                    显示所有条目
                </label>
                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;" id="tableDiv">
                <table class="table table-bordered table-bordered" style="min-width:1500px;">
                    <thead>
                    <tr>
                        <th nowrap rowspan="2">日期</th>
                        <th nowrap rowspan="2">注册量</th>
                        <th nowrap rowspan="2">付费率<i class="fa fa-question-circle" alt="（当天新增付费人数/当天注册量）"></i></th>
                        <{foreach $data.day as $d}>
                            <th nowrap colspan="<{if $only_view neq ''}>1<{else}>2<{/if}>">第<{$d}>天</th>
                        <{/foreach}>
                    </tr>
                    <tr>
                        <{foreach $data.day as $d}>
                            <{if $only_view eq 1 or $only_view eq ''}>
                                <th nowrap>充值</th>
                            <{/if}>

                            <{if $only_view eq 2 or $only_view eq ''}>
                                <th nowrap>LTV</th>
                            <{/if}>
                        <{/foreach}>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #dadada">
                        <td>合计</td>
                        <td><{$data.total.reg}></td>
                        <td><{$data.total.pay_rate}></td>
                        <{foreach $data.day as $d}>
                            <{if $only_view eq 1 or $only_view eq ''}>
                                <td class="text-danger"><{$val}><{$data.total['money'|cat:$d]}></td>
                            <{/if}>
                            <{if $only_view eq 2 or $only_view eq ''}>
                                <td><{$data['total']['ltv'|cat:$d]}></td>
                            <{/if}>
                        <{/foreach}>
                    </tr>
                    <{foreach $data.list as $u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$u.reg}></td>
                            <td nowrap class="text-olive"><{$u.pay_rate}></td>
                            <{foreach $data.day as $d}>
                                <{if $only_view eq 1 or $only_view eq ''}>
                                    <td nowrap class="text-danger"><{$u['money'|cat:$d]}></td>
                                <{/if}>
                                <{if $only_view eq 2 or $only_view eq ''}>
                                    <td nowrap><span style="color:#00a65a;font-weight: bolder;"><{$u['ltv'|cat:$d]}></span></td>
                                <{/if}>
                            <{/foreach}>
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
                if (i == 1) return true;
                $(this).children().eq(0).css({
                    "position": "relative",
                    "top": "0px",
                    "left": left,
                    "background": "white"
                });
            });
        });

        $(".view-data").change(function(){
            $("#ltv_form").submit();
        })
    });
</script>
<{include file="../public/foot.tpl"}>