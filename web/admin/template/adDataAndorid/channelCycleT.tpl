<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adDataAndorid" />
            <input type="hidden" name="ac" value="channelCycleT" />
            <div class="form-group">
                <lable>选择游戏</lable>
                <select name="game_id">
                    <option value="">全 部</option>
                    <{foreach from=$_games key=id item=name}>
                <option value="<{$id}>" <{if $data.game_id eq $id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <lable>选择渠道</lable>
                <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal">点击选择</button>
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    渠道选择
                                </h4>
                            </div>
                            <div class="modal-body">
                                <span style="display:inline-block;width:180px;margin-left: 20px;margin-bottom: 5px;">
                                <a href="javascript:" class="all_sel">全选</a>
                                <a href="javascript:" class="diff_sel">反选</a>
                                </span>
                                <br>
                                <{foreach from=$_channels key=id item=name}>
                                <span style="display:inline-block;width:180px;">
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="channel_id[]" <{if !$data.channel_id}> checked="checked" <{else}>
                                    <{foreach from=$data.channel_id item=item}>
                                    <{if $item eq $id}>
                                    checked="checked"
                                    <{/if}>
                                    <{/foreach}>
                                    <{/if}>
                                    value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>><{$name}>&nbsp;
                                </label>
                                    </span>
                                <{/foreach}>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary"
                                        data-dismiss="modal">关闭
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

                <lable>时间</lable>
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
                        <td nowrap>游戏</td>
                        <td nowrap>渠道</td>
                        <td nowrap>开始时间</td>
                        <td nowrap>结束时间</td>
                        <td nowrap>推广天数</td>
                        <td nowrap>推广单价</td>
                        <td nowrap>注册</td>
                        <td nowrap>推广成本</td>
                        <td nowrap>流水</td>
                        <td nowrap>注册ARPU值</td>
                        <td nowrap>回款周期</td>
                        <td nowrap>ROI</td>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>汇总</td>
                        <td nowrap>总渠道</td>
                        <td nowrap><{$data.sdate}></td>
                        <td nowrap><{$data.edate}></td>
                        <td nowrap><{$data.total.daysub}></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.single_price}></b></td>
                        <td nowrap><{$data.total.all_reg}></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.all_cost}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.all_pay_money}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.reg_ARPU}></b></td>
                        <td nowrap><{$data.total.back_time}></td>
                        <td nowrap class="text-olive"><b><{$data.total.ROI}></b></td>

                    </tr>
                    <{foreach from=$data.list key=key item=item}>
                        <tr>
                            <td nowrap><{$_games[$item.game_id]}></td>
                            <td nowrap class="text-danger"><{($item.channel)}></td>
                            <td nowrap><{$item.sdate}></td>
                            <td nowrap><{$item.edate}></td>
                            <td nowrap><{$item.daysub}></td>
                            <td nowrap class="text-danger"><b>¥<{($item.single_price)}></b></td>
                            <td nowrap><{$item.reg}></td>
                            <td nowrap class="text-danger"><b>¥<{$item.cost}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$item.pay_money}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$item.reg_ARPU}></b></td>
                            <td nowrap><{$item.back_time}></td>
                            <td nowrap class="text-olive"><b><{$item.ROI}></b></td>

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
            location.href='?ct=adDataAndorid&ac=dayChannelEffectExcel&&game_id='+$('select[name=game_id]').val()+channel_ids+'sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val()+'&psdate='+$('input[name=psdate]').val()+'&pedate='+$('input[name=pedate]').val();
        });
    });

</script>
<{include file="../public/foot.tpl"}>