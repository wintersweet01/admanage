<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data" />
            <input type="hidden" name="ac" value="newViewData" />
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1" <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2" <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <div id="container" style="min-width:400px;"></div>
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
        $('#myModal').modal({
            keyboard: true,show:false
        })
        var height = $('#content-main').height();
        $('#container').height(height-50);
        $('#printExcel').click(function(){
            location.href='?ct=data&ac=newViewDataExcel&reg='+$('input[name=reg]').val()+'&new_equipment='+$('input[name=new_equipment]').val()+'&new_players='+$('input[name=new_players]').val()+'&active_login='+$('input[name=active_login]').val()+'&new_active_login='+$('input[name=new_active_login]').val()+'&payer_num='+$('input[name=payer_num]').val()+'&new_payer_num='+$('input[name=new_payer_num]').val()+'&total_deposit_money='+$('input[name=total_deposit_money]').val()+'&new_deposit_money='+$('input[name=new_deposit_money]').val()+'&payrate='+$('input[name=payrate]').val()+'&payARPU='+$('input[name=payARPU]').val()+'&actARPU='+$('input[name=actARPU]').val()+'&newpayARPU='+$('input[name=newpayARPU]').val()+'&newpayrate='+$('input[name=newpayrate]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        })
        var chart = new Highcharts.Chart('container', {
            credits: {
                enabled:false
            },
            title: {
                text: '<{$data.sdate}>——<{$data.edate}>新增数据查看',
                x: -20
            },
            subtitle: {
                    text: '',
                x: -20
            },
            xAxis: {
                categories: [
                <{foreach from=$data.list name=list item=u}>
                '<{$u.date}>'
                <{if !$smarty.foreach.list.last}> ,<{/if}>
                <{/foreach}>
                ]
            },
            yAxis: {
                title: {
                    text: ' '
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' '
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [
              <{foreach from=$data.lists key=title name=item item=item}>
                <{if $title neq 'date' and $title neq 'id'}>
                  {name:'<{$data.param[$title]}>',data:[<{foreach from=$item name=datas item=v}><{$v}><{if !$smarty.foreach.datas.last}>, <{/if}><{/foreach}>]}<{if !$smarty.foreach.item.last}> ,<{/if}>
                  <{/if}>

              <{/foreach}>
            ]
        });

        $('select[name=game_id],select[name=channel_id]').on('change',function() {
            $.getJSON('?ct=ad&ac=getAllMonitor&game_id='+$('select[name=game_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&device_type='+$('select[name=device_type]').val()+'&channel_id='+$('select[name=channel_id]').val(),function(re){
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