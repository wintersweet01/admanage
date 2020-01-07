<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data2"/>
            <input type="hidden" name="ac" value="payArea"/>
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>"/>

                <label>排序方式</label>
                <select name="sort" id="">
                    <option value="">请选择</option>
                    <option value="pay_money"
                    <{if $data.sort eq 'pay_money'}>selected=selected<{/if}>>按付费金额</option>
                    <option value="pay_rate"
                    <{if $data.sort eq 'pay_rate'}>selected=selected<{/if}>>按付费率</option>
                    <option value="ARPPU"
                    <{if $data.sort eq 'ARPPU'}>selected=selected<{/if}>>按ARPPU</option>
                </select>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <!--<button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>-->
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

        var height = $('#content-main').height();
        $('#container').height(height-50);
        $('#printExcel').click(function(){
            location.href='?ct=data&ac=newViewDataExcel&reg='+$('input[name=reg]').val()+'&new_equipment='+$('input[name=new_equipment]').val()+'&new_players='+$('input[name=new_players]').val()+'&active_login='+$('input[name=active_login]').val()+'&new_active_login='+$('input[name=new_active_login]').val()+'&payer_num='+$('input[name=payer_num]').val()+'&new_payer_num='+$('input[name=new_payer_num]').val()+'&total_deposit_money='+$('input[name=total_deposit_money]').val()+'&new_deposit_money='+$('input[name=new_deposit_money]').val()+'&payrate='+$('input[name=payrate]').val()+'&payARPU='+$('input[name=payARPU]').val()+'&actARPU='+$('input[name=actARPU]').val()+'&newpayARPU='+$('input[name=newpayARPU]').val()+'&newpayrate='+$('input[name=newpayrate]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        })
        $('#container').highcharts({
            credits: {
                enabled:false
            },
            chart: {
                type: 'column'
            },
            title: {
                text: '地区付费数据统计'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                <{foreach from=$data.list name=list item=u}>
                    '<{$u.area}>'
                    <{if !$smarty.foreach.list.last}> ,<{/if}>
                <{/foreach}>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            //tooltip: {
            //    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            //    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            //    '<td style="padding:0"><b>{point.y:.1f} 元</b></td></tr>',
            //    footerFormat: '</table>',
             //   shared: true,
            //    useHTML: true
            //},
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                { name:'充值金额',data:[
            <{foreach from=$data.list key=title name=item item=item}>
               <{$item.pay_money}><{if !$smarty.foreach.item.last}> ,<{/if}>


            <{/foreach}>],tooltip: {
                    valueSuffix: '元'
                },dataLabels:{
                    enabled:true, //是否显示数据标签
                        formatter: function() {
                        return this.y ;
                    }
                },<{if $data.sort && $data.sort neq 'pay_money'}>visible:false<{/if}>
    },
                { name:'付费率',data:[
                <{foreach from=$data.list key=title name=item item=item}>
                <{$item.pay_rate}><{if !$smarty.foreach.item.last}> ,<{/if}>


                <{/foreach}>],tooltip: {
                    valueSuffix: '%'
                },dataLabels:{
                    enabled:true, //是否显示数据标签
                        formatter: function() {
                       return this.y + '%';
                    }
                },<{if $data.sort && $data.sort neq 'pay_rate'}>visible:false<{/if}>
                },
                { name:'ARPPU',data:[
                <{foreach from=$data.list key=title name=item item=item}>
                <{$item.ARPPU}><{if !$smarty.foreach.item.last}> ,<{/if}>


                <{/foreach}>],tooltip: {
                    valueSuffix: '元'
                },dataLabels:{
                    enabled:true, //是否显示数据标签
                        formatter: function() {
                        return this.y ;
                    }
                },<{if $data.sort && $data.sort neq 'ARPPU'}>visible:false<{/if}>
                },

            ]
        });
        $('input[name=sdate],input[name=edate]').on('click focus',function() {
            WdatePicker({el:this, dateFmt:"yyyy-MM"});
        });

    });

</script>
<{include file="../public/foot.tpl"}>