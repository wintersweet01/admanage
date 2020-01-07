<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="destribuReceipt" />
            <input type="hidden" name="ac" value="destribuConfList" />
            <div class="form-group">
                <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=destribuReceipt&ac=destribuConfig" class="btn btn-primary btn-small" role="button"> + 添加分成配置 </a><{/if}>
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
                        <td nowrap>游戏</td>
                        <td nowrap>渠道</td>
                        <td nowrap>金额范围</td>
                        <td nowrap>比例</td>
                        <td nowrap>操作</td>

                    </tr>
                    </thead>
                    <tbody>

                    <{foreach from=$data key=key item=item}>
                        <{foreach from=$item key=k item=val}>
                            <{foreach from=$val key=kk item=vv}>
                                <tr>
                                    <td nowrap><{$_games[$key]}></td>
                                    <td nowrap><{$k}></td>
                                    <td nowrap class="text-danger"><b>￥<{$kk}></b></td>
                                    <td nowrap><{$vv}></td>
                                    <td nowrap><a href="?ct=destribuReceipt&ac=destribuConfig&game_id=<{$key}>&channel=<{$k}>&area=<{$kk}>&prop=<{$vv}>&is_edit=1">修改</a></td>
                                </tr>
                            <{/foreach}>
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