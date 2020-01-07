<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="operateReceipt"/>
            <input type="hidden" name="ac" value="operateReceiptGame"/>
            <div class="form-group">
                <{widgets widgets=$widgets}>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>游戏</th>
                        <{foreach $data.channel as $val}>
                        <th><{$val}></th>
                        <{/foreach}>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach $data.list as $key => $item}>
                        <tr <{if $item@first}>style="font-weight: bold;background-color: #fff3cd;"<{/if}>>
                            <td nowrap><{$key}></td>
                            <{foreach $data.channel as $v}>
                            <td class="text-danger"><b><{$item[$v]}></b></td>
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
        $('#printExcel').click(function () {
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function () {
                channel_ids += 'channel_id[]=' + $(this).val() + '&';
            });
            location.href = '?ct=adData&ac=dayChannelEffectExcel&&game_id=' + $('select[name=game_id]').val() + channel_ids + 'sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val() + '&psdate=' + $('input[name=psdate]').val() + '&pedate=' + $('input[name=pedate]').val();
        });
    });
</script>
<{include file="../public/foot.tpl"}>