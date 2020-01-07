<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 10px; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data3"/>
            <input type="hidden" name="ac" value="payRetainAll"/>
            <div class="form-group">
                <label>游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data['device_type']==1}>selected="selected"<{/if}>>IOS</option>
                    <option value="2"
                    <{if $data['device_type']==2}>selected="selected"<{/if}>>Andorid</option>
                </select>

                <label>渠道</label>
                <select name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data['channel_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>游戏包</label>
                <select name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data['package_name']==$name.package_name}>selected="selected"<{/if}>><{$name.package_name}> </option>
                    <{/foreach}>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

                <input type="checkbox" name="has_cost" value="1" <{if $data.has_cost==1}>checked="checked"<{/if}> />只显示有消耗的数据
                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap rowspan="2">日期</th>
                        <th nowrap rowspan="2">游戏名称</th>
                        <th nowrap rowspan="2">渠道</th>
                        <th nowrap rowspan="2">游戏包</th>
                        <th nowrap rowspan="2">消耗金额</th>
                        <th nowrap rowspan="2">注册数</th>
                        <th nowrap rowspan="2">注册成本<i class="fa fa-question-circle" alt="（消耗金额/注册数）"></i></th>
                        <th nowrap rowspan="2">至昨天天数<i class="fa fa-question-circle" alt="注册日期至昨天的天数"></i></th>
                        <th nowrap colspan="3">累计</th>
                        <{foreach $_day as $d}>
                        <th nowrap colspan="3"><{$d}>日</th>
                        <{/foreach}>
                    </tr>
                    <tr>
                        <th nowrap>充值<i class="fa fa-question-circle" alt="注册日至昨天的累计充值金额"></i></th>
                        <th nowrap>ROI<i class="fa fa-question-circle" alt="注册日至昨天的累计充值金额/注册日消耗"></i></th>
                        <th nowrap>LTV<i class="fa fa-question-circle" alt="注册日至昨天的累计充值金额/注册日注册数"></i></th>
                        <{foreach $_day as $d}>
                        <th nowrap>充值</th>
                        <th nowrap>ROI</th>
                        <th nowrap>LTV</th>
                        <{/foreach}>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$_channels[$u.channel_id]}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap class="text-danger"><b><{$u.cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.reg}></b></td>
                            <td nowrap class="text-danger"><b><{$u.reg_cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.num_day}></b></td>
                            <td nowrap class="text-danger"><b><{$u.total_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.total_roi}></b></td>
                            <td nowrap class="text-danger"><b><{$u.total_ltv}></b></td>
                            <{foreach $_day as $d}>
                            <td nowrap class="text-danger"><b><{$u["money<{$d}>"]}></b></td>
                            <td nowrap class="text-olive"><b><{$u["roi<{$d}>"]}></b></td>
                            <td nowrap class="text-danger"><b><{$u["ltv<{$d}>"]}></b></td>
                            <{/foreach}>
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
<script>
    $(function () {
        $("#content-wrapper").scroll(function () {
            var left = $("#content-wrapper").scrollLeft() - 14;//获取滚动的距离
            var trs = $("#tableDiv table tr");//获取表格的所有tr
            var e = trs.children();
            var w0 = e.eq(0).outerWidth();
            var w3 = 0;

            for (var i = 0; i < 3; i++) {
                w3 += e.eq(i).outerWidth();
            }

            trs.each(function (i) {
                if (i == 1) {
                    return true;
                }

                if (left > w0) {
                    $(this).children().eq(0).css({
                        "position": "relative",
                        "top": "0px",
                        "left": left,
                        "background": "#00FFFF"
                    });
                } else {
                    $(this).children().eq(0).removeAttr('style');
                }

                if (left > w3 - w0) {
                    $(this).children().eq(3).css({
                        "position": "relative",
                        "top": "0px",
                        "left": w0 + left - w3,
                        "background": "#FFFF00"
                    });
                } else {
                    $(this).children().eq(3).removeAttr('style');
                }
            });
        });

        $('select[name=game_id],select[name=device_type],select[name=channel_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var device_type = $('select[name=device_type] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&device_type=' + device_type + '&channel_id=' + channel_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>