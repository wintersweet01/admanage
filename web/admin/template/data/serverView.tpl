<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline" id="myForm">
            <input type="hidden" name="ct" value="data4"/>
            <input type="hidden" name="ac" value="serverView"/>
            <div class="form-group">
                <{widgets widgets=$widgets}>

                <label>平台：</label>
                <select name="device_type">
                    <option value="">请选择</option>
                    <option <{if $data.device_type eq 1}>selected="selected"<{/if}> value="1">IOS</option>
                    <option <{if $data.device_type eq 2}>selected="selected"<{/if}> value="2">安卓</option>
                </select>

                <label>区服：</label>
                <input type="number" style="width: 88px" name="server_start" value="<{$data.server_start}>" />
                <input type="number" style="width: 88px" name="server_end" value="<{$data.server_end}>" />

                <label>时间：</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <!--<label>统计方式：</label>
                <select name="type" class="type-select">
                    <option <{if $type eq 1}>selected="selected"<{/if}> value="1">按天统计</option>
                    <option <{if $type eq 2}>selected="selected"<{/if}> value="2">累计统计</option>
                </select>-->
                <label>用户类型：</label>
                <select name="user_type" class="user-type" >
                    <option <{if $user_type eq 1}>selected="selected"<{/if}> value="1">总用户</option>
                    <option <{if $user_type eq 2}>selected="selected"<{/if}> value="2">新老注册</option>
                </select>

                <label><input type="checkbox" class="show-type" name="show_type[]" value="1" style="position: relative;top: 2px;" <{if count($show_type) eq 2 or in_array(1,$show_type)}>checked="checked"<{/if}>"> 充值人数</label>
                &nbsp;
                <label><input type="checkbox" class="show-type" name="show_type[]" value="2" style="position: relative;top: 2px;" <{if count($show_type) eq 2 or in_array(2,$show_type)}>checked="checked"<{/if}>> 充值金额</label>
                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>

            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive" style="text-align: center">
                    <thead>
                    <tr>
                        <th>区服</th>
                        <{foreach from=$data.server_list key=key item=row}>
                        <th colspan="<{if $user_type eq 1}>2<{else}><{if count($show_type) eq 2}>4<{else}>2<{/if}><{/if}>"><{$row}>服</th>
                        <{/foreach}>
                    </tr>
                    <tr>
                        <th>时间</th>
                        <{foreach from=$data.server_list key=key item=row}>
                        <{if $user_type eq 1}>
                        <{if count($show_type) eq 2 or in_array(1,$show_type)}><td>总充值人数</td><{/if}>
                        <{if count($show_type) eq 2 or in_array(2,$show_type)}><td>总充值金额</td><{/if}>
                        <{else}>
                        <{if count($show_type) eq 2 or in_array(1,$show_type)}><td>新充值人数</td><{/if}>
                        <{if count($show_type) eq 2 or in_array(2,$show_type)}><td>新充值金额</td><{/if}>
                        <{if count($show_type) eq 2 or in_array(1,$show_type)}><td>老充值人数</td><{/if}>
                        <{if count($show_type) eq 2 or in_array(2,$show_type)}><td>老充值金额</td><{/if}>
                        <{/if}>
                        <{/foreach}>
                    </tr>
                    <{foreach from=$data.data key=date item=dateRow}>
                        <tr>
                            <td><{$date}></td>
                            <{foreach from=$data.server_list item=ser}>
                            <{if $user_type eq 1}>
                                <{if count($show_type) eq 2 or in_array(1,$show_type)}><td><{$dateRow[$ser][3]['total_pay_num']|default:0}></td><{/if}>
                                <{if count($show_type) eq 2 or in_array(2,$show_type)}><td><{$dateRow[$ser][3]['total_pay_money']|default:0}></td><{/if}>
                             <{else}>
                                <{if count($show_type) eq 2 or in_array(1,$show_type)}><td><{$dateRow[$ser][1]['pay_num']|default:0}></td><{/if}>
                                <{if count($show_type) eq 2 or in_array(2,$show_type)}><td><{$dateRow[$ser][1]['pay_money']|default:0}></td><{/if}>
                                <{if count($show_type) eq 2 or in_array(1,$show_type)}><td><{$dateRow[$ser][2]['pay_num']|default:0}></td><{/if}>
                                <{if count($show_type) eq 2 or in_array(2,$show_type)}><td><{$dateRow[$ser][2]['pay_money']|default:0}></td><{/if}>
                            <{/if}>
                            <{/foreach}>
                        </tr>
                    <{/foreach}>
                    </thead>
                    <tbody>

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
            location.href = '?ct=data&ac=overviewExcel&game_id=' + $('select[name=game_id]').val() + '&device_type=' + $('select[name=device_type]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val();
        });

        $(".show-type").on('click',function(){
            $("#myForm").submit();
        })
        $(".type-select").change(function(){
            $("#myForm").submit();
        })
        $(".user-type").change(function(){
            $("#myForm").submit();
        })
    });
</script>
<{include file="../public/foot.tpl"}>