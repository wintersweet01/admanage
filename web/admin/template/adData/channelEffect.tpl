<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="adData"/>
            <input type="hidden" name="ac" value="channelEffect"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>选择渠道</label>
                <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#myModal">点击选择
                </button>
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">渠道选择</h4>
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
                                    <input type="checkbox"
                                           name="channel_id[]" <{if !$data.channel_id}> checked="checked" <{else}>
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
                                <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>

                <label>注册时间</label>
                <input type="text" name="rsdate" value="<{$data.reg_sdate}>" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="redate" value="<{$data.reg_edate}>" class="form-control Wdate" style="width: 100px;"/>

                <label>付款时间</label>
                <input type="text" name="psdate" value="<{$data.pay_sdate}>" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="pedate" value="<{$data.pay_edate}>" class="form-control Wdate" style="width: 100px;"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>渠道</td>
                        <td nowrap>消耗</td>
                        <td nowrap>展示</td>
                        <td nowrap>点击</td>
                        <td nowrap>注册</td>
                        <td nowrap>注册成本</td>
                        <td nowrap>次日留存数</td>
                        <td nowrap>留存率</td>
                        <td nowrap>留存成本</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>付费率</td>
                        <td nowrap>付款成本</td>
                        <td nowrap>付费金额</td>
                        <td nowrap>ROI</td>
                        <td nowrap>ARPU</td>
                        <td nowrap>ARPPU</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>汇总</td>
                        <td class="text-danger"><b>¥<{$data.all.cost}></b></td>
                        <td nowrap><{$data.all.display}></td>
                        <td nowrap><{$data.all.click}></td>
                        <td nowrap><{$data.all.reg}></td>
                        <td class="text-danger"><b>¥<{$data.all.reg_cost}></b></td>
                        <td nowrap><{$data.all.retain}></td>
                        <td class="text-olive"><b><{$data.all.retain_rate}></b></td>
                        <td class="text-danger"><b>¥<{$data.all.retain_cost}></b></td>
                        <td nowrap><{$data.all.payer_num}></td>
                        <td class="text-olive"><b><{$data.all.pay_rate}></b></td>
                        <td class="text-danger"><b>¥<{$data.all.pay_cost}></b></td>
                        <td class="text-danger"><b>¥<{$data.all.pay_money}></b></td>
                        <td class="text-olive"><b><{$data.all.ROI}></b></td>
                        <td class="text-danger"><b>¥<{$data.all.ARPU}></b></td>
                        <td class="text-danger"><b>¥<{$data.all.ARPPU}></b></td>
                    </tr>
                    <{foreach from=$data.list key=key item=item}>
                        <tr>
                            <td nowrap><{$item.channel_name}></td>
                            <td class="text-danger"><b>¥<{$item.cost}></b></td>
                            <td nowrap><{$item.display}></td>
                            <td nowrap><{$item.click}></td>
                            <td nowrap><{$item.reg}></td>
                            <td class="text-danger"><b>¥<{$item.reg_cost}></b></td>
                            <td nowrap><{$item.retain}></td>
                            <td class="text-olive"><b><{$item.retain_rate}></b></td>
                            <td class="text-danger"><b>¥<{$item.retain_cost}></b></td>
                            <td nowrap><{$item.payer_num}></td>
                            <td class="text-olive"><b><{$item.pay_rate}></b></td>
                            <td class="text-danger"><b>¥<{$item.pay_cost}></b></td>
                            <td class="text-danger"><b>¥<{$item.pay_money}></b></td>
                            <td class="text-olive"><b><{$item.ROI}></b></td>
                            <td class="text-danger"><b>¥<{$item.ARPU}></b></td>
                            <td class="text-danger"><b>¥<{$item.ARPPU}></b></td>
                        </tr>
                        <{/foreach}>

                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <{$data.page_html nofilter}>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script>
    $(function () {

        $('.all_sel').on('click', function () {
            $('input[name="channel_id[]"]').prop('checked', true);
        });

        $('.diff_sel').on('click', function () {
            $('input[name="channel_id[]"]').each(function () {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            });
        });

        $('#printExcel').click(function () {
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function () {
                channel_ids += 'channel_id[]=' + $(this).val() + '&';
            });
            location.href = '?ct=adData&ac=channelEffectExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + channel_ids + 'rsdate=' + $('input[name=rsdate]').val() + '&redate=' + $('input[name=redate]').val() + '&psdate=' + $('input[name=psdate]').val() + '&pedate=' + $('input[name=pedate]').val();
        });

        $('select[name=game_id]').on('change', function () {
            $.getJSON('?ct=data&ac=getMoneyLevel&game_id=' + $('select[name=game_id]').val(), function (re) {
                var html = '<option value="">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value=' + i + '>' + n + '</option>';
                });
                $('select[name="level_id"]').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>