<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <{*<lable>选择时间段</lable>
        <input type="text" name="sdate" value="<{$data.sdate}>" /> -
        <input type="text" name="edate" value="<{$data.edate}>" />*}>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div>
                <h3><{$data.username}></h3>
            </div>
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>日期</td>
                        <td>消费</td>
                        <td>扣返点<i class="fa fa-question-circle" alt="消费/<{(1+($user_rebate.rebate/100))}>"></i></td>
                        <td>累计充值</td>
                        <td>回本差<i class="fa fa-question-circle" alt="扣返点-累计充值"></i></td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$u.date}></td>
                            <td>¥<{$u.cost/100}></td>
                            <td>¥<{($u.cost/100/(1+($user_rebate.rebate/100)))|string_format:"%0.2f"}></td>
                            <td>¥<{($u.total_income+$u.income)/100}></td>
                            <td>¥<{(($u.total_cost+$u.cost)/100/(1+($user_rebate.rebate/100)))|string_format:"%0.2f"}> - ¥<{(($u.total_income+$u.income)/100)|string_format:"%0.2f"}> = ¥<{(($u.total_cost+$u.cost)/100/(1+($user_rebate.rebate/100))-($u.total_income+$u.income)/100)|string_format:"%0.2f"}></td>
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
<{include file="../public/foot.tpl"}>