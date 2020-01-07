<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data2" />
            <input type="hidden" name="ac" value="channelHourPay" />
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>
                
                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1" <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2" <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>用户类型</label>
                <select name="user_type">
                    <option value="">全 部</option>
                    <option value="1" <{if $data.user_type==1}>selected="selected"<{/if}>> 新用户</option>
                    <option value="2" <{if $data.user_type==2}>selected="selected"<{/if}>> 老用户 </option>
                </select>
                <label>选择渠道</label>
                <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal">点击选择</button>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" /> -
                <input type="text" name="edate" value="<{$data.edate}>" />

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <{if $data.all==1}>checked="checked"<{/if}> />
                    显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <div id="container" style="min-width:400px;height:400px;"></div>

                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>时间</td>
                        <td nowrap></td>
                        <td nowrap>均值</td>
                        <{if $data.channel_id}>
                            <{foreach from=$data.channel_id item=channel}>
                                <td nowrap><{$_channels[$channel]}></td>
                            <{/foreach}>
                        <{else}>
                            <{foreach from=$_channels item=channel}>
                                <td nowrap><{$channel}></td>
                            <{/foreach}>
                        <{/if}>
                    </tr>
                    <tr>
                        <td nowrap>总计</td>
                        <td nowrap class="text-danger">
                            <b>¥<{if $data.user_type eq 1}>
                            <{$data.t.total_new_money.all}>
                            <{elseif $data.user_type eq 2}>
                            <{$data.t.total_old_money.all}>
                            <{else}>
                            <{$data.t.all_money.all}>
                                <{/if}></b></td>
                        <td nowrap></td>
                        <{if $data.channel_id}>
                        <{foreach from=$data.channel_id item=channel}>
                        <td nowrap class="text-danger">
                            <b>¥<{if $data.user_type eq 1}>
                            <{$data.t.total_new_money[$_channels.$channel]}>
                            <{elseif $data.user_type eq 2}>
                            <{$data.t.total_old_money[$_channels.$channel]}>
                            <{else}>
                            <{$data.t.all_money[$_channels.$channel]}>
                            <{/if}></b></td>
                        <{/foreach}>
                        <{else}>
                        <{foreach from=$_channels item=channel}>
                        <td nowrap></td>
                        <{/foreach}>
                        <{/if}>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.lists key=date item=u}>
                        <tr>
                            <td nowrap><{$date}></td>
                            <td nowrap class="text-danger">
                                <b>¥<{if $data.user_type eq 1}>
                                <{$u.total.total_new_money}>
                                <{elseif $data.user_type eq 2}>
                                <{$u.total.total_old_money}>
                                <{else}>
                                <{$u.total.all_money}>
                                    <{/if}></b></td>
                            <td nowrap class="text-danger">
                                <b>¥<{if $data.user_type eq 1}>
                                    <{$u.avg.total_new_money}>
                                    <{elseif $data.user_type eq 2}>
                                    <{$u.avg.total_old_money}>
                                    <{else}>
                                    <{$u.avg.all_money}>
                                    <{/if}></b></td>
                            <{foreach from=$u.data name=channels  item=channels}>

                            <td nowrap class="text-danger">
                                <b>¥
                            <{if $data.user_type eq 1}>
                                <{$channels.new_money}>
                            <{elseif $data.user_type eq 2}>
                                <{$channels.old_money}>
                            <{else}>
                                <{$channels.total_money}>
                                <{/if}>
                                </b>
                            </td>
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
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/highcharts.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/exporting.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/highcharts/highcharts-zh_CN.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>js/grid-light.js"></script>

<script>
    $(function(){

        $('#container').css('width',$('#content-wrapper').width()-20+'px');

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

        $('#myModal').modal({
            keyboard: true,show:false
        });
        $('#printExcel').click(function(){
            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function(){
                channel_ids += 'channel_id[]='+$(this).val()+'&';
            });

            location.href='?ct=data1&ac=regHourExcel&platform='+$('select[name=platform]').val()+channel_ids+'sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });
        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled:false
            },
            title: {
                text: '<{if $data.device_type eq 1}>IOS平台<{else if $data.device_type eq 2}>Andorid平台<{else}>所有平台<{/if}><{$data.sdate}>——<{$data.edate}>每小时新增付费',
                x: -20
            },
            subtitle: {
                    text: '',
                x: -20
            },
            xAxis: {
                categories: [
                <{foreach from=$data.lists key=date name=list item=u}>
                '<{$date}>'
                <{if !$smarty.foreach.list.last}> ,<{/if}>
                <{/foreach}>
                ]
            },
        yAxis: {
            title: {
                text: '付款金额(元)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '元'
        },
        legend: {
            layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
        },
        series: [

        <{foreach from=$data.sheet key=date name=list item=u}>
        {name:'<{$_channels.$date}>',data:[<{foreach from=$u name=channel item=channels}><{if $data.user_type eq 1}>
        <{$channels.new_money}>
        <{elseif $data.user_type eq 2}>
        <{$channels.old_money}>
        <{else}>
        <{$channels.total_money}>
        <{/if}><{if !$smarty.foreach.channel.last}>, <{/if}><{/foreach}>]} <{if !$smarty.foreach.list.last}> ,<{/if}>
    <{/foreach}>

    ]
    });

        $('input[name=sdate],input[name=edate]').on('click focus',function() {
            WdatePicker({el:this, dateFmt:"yyyy-MM-dd HH:mm:ss",});
        });
        $('select[name=game_id],select[name=channel_id]').on('change',function() {
            $.getJSON('?ct=ad&ac=getAllMonitor&game_id='+$('select[name=game_id]').val()+'&channel_id='+$('select[name=channel_id]').val(),function(re){
                var html = '<option value="">全 部</option>';
                $.each(re,function(i,n) {
                    html += '<option value='+i+'>'+n+'</option>';
                });
                $('select[name="monitor_id"]').html(html);
            });
        });
        $('select[name=game_id]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            if(!game_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id,function(re) {
                var html = '<option value="">全部</option>';
                $.each(re,function(i,n){
                    html += '<option value="'+n+'">'+n+'</option>';
                });
                $('#package_id').html(html);
            });
        });
    });

</script>
<{include file="../public/foot.tpl"}>