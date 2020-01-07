<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="destribuReceipt" />
            <input type="hidden" name="ac" value="destribuReceiptDate" />
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
                <!--<button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>-->
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>日期</td>
                        <td>总计</td>
                        <{foreach from=$data.channel item=item}>
                            <td><{$item.channel_name}></td>
                        <{/foreach}>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>总计</td>
                        <td class="text-danger"><b>￥<{$data.all}></b></td>
                        <{foreach from=$data.total item=item}>
                        <td class="text-danger"><b>￥<{$item.income}></b></td>
                        <{/foreach}>

                    </tr>
                    <{foreach from=$data.list key=key item=item}>
                        <tr>
                            <td nowrap><{$key}></td>
                            <{foreach from=$item key=k item=val}>
                            <{if $k eq 'total_income'}>
                            <td class="text-danger"><b>￥<{$item.total_income}></b></td>
                            <{else}>
                            <td class="text-danger"><b>￥<{$val.income}></b></td>
                            <{/if}>
                            <{/foreach}>
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
        $('.all_sel').on('click',function(){
            $('input[name="channel_id[]"]').prop('checked',true);
        });

        $('.diff_sel').on('click',function(){
            $('input[name="channel_id[]"]').each(function(){
                if($(this).is(':checked')){
                    $(this).prop('checked',false);
                }else{
                    $(this).prop('checked',true);
                }
            });
        });

        $('#printExcel').click(function(){
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function(){
                channel_ids += 'channel_id[]='+$(this).val()+'&';
            });
            location.href='?ct=adData&ac=dayChannelEffectExcel&&game_id='+$('select[name=game_id]').val()+channel_ids+'sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val()+'&psdate='+$('input[name=psdate]').val()+'&pedate='+$('input[name=pedate]').val();
        });
    });
</script>
<{include file="../public/foot.tpl"}>