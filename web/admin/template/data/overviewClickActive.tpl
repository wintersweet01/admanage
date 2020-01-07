<{include file="../public/header.tpl"}>
<div id="areascontent">

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div class="alert alert-info" role="alert">阿里汇川平台:只能显示当天的分时段消费数据</div>
            <div class="center-block">
                <{$img = explode(',',$data.delivery.img)}>
                <div><a href="<{$data.ad_info.jump_url}>" target="_blank"><h4><{$data.ad_word}></h4></a></div>
                <a href="<{$data.ad_info.jump_url}>" target="_blank">
                    <{foreach from=$img item=a}>
                        <img src="<{$a}>" style="max-width:200px;max-height: 100px;" >
                    <{/foreach}>
                </a>
            </div>
        </div>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>小时</td>
                        <td>点击数</td>
                        <td>点击率<i class="fa fa-question-circle" alt="（智汇推里的CTR）"></i></td>
                        <td>落地页抵达</td>

                        <td>加载抵达率<i class="fa fa-question-circle" alt="（落地页抵达量/点击量）"></i></td>
                        <td>下载点击量 </td>
                        <td>下载点击率<i class="fa fa-question-circle" alt="（下载点击量/落地页抵达量）"></i></td>
                        <td>激活数(按点击时间)</td>
                        <td>激活数(按激活时间)</td>
                        <td>点击激活率<i class="fa fa-question-circle" alt="（激活量/点击下载量）"></i></td>

                        <td>消耗</td>
                        <td>曝光</td>
                        <td>ECPC</td>
                        <td>激活单价<i class="fa fa-question-circle" alt="消耗/返佣比例/激活(按点击时间)"></i></td>
                        <td>充值人数</td>
                        <td>充值金额</td>

                        <{*<td>成本</td>*}>
                        <td>日期</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.info item=u}>
                        <tr>
                            <td><{$u.hour}></td>
                            <td><{$u.click}></td>
                            <td><{$u._cost.ctr}>%</td>
                            <td><{$u._visit}></td>
                            <td><{($u._visit*100/$u.click)|string_format:"%0.2f"}>%</td>
                            <td><{$u._click}></td>
                            <td><{($u._click*100/$u._visit)|string_format:"%0.2f"}>%</td>

                            <td><{$u.click_active}></td>
                            <td><{$u.active}></td>
                            <td><{($u.active*100/$u._click)|string_format:"%0.2f"}>%</td>

                            <!--消耗金额-->
                            <td>
                                <{if $u._cost.cost}>¥<{($u._cost.cost)/100|string_format:"%0.2f"}><{else}>-<{/if}>
                            </td>
                            <!--曝光量-->
                            <td><{if $u._cost.pv}><{$u._cost.pv}><{else}>-<{/if}></td>
                            <!--ECPC-->
                            <td><{if $u._cost.eCPC}><{$u._cost.eCPC/100}><{else}>-<{/if}></td>

                            <td>¥<{($u._cost.true_cost/($u.click_active*100))|string_format:"%0.2f"}></td>
                            <{*<td><{if $u.cost}>¥<{$u.cost/100}><{else}><a href="javascript:;" class="cost" data-id="<{$u.id}>">录入</a><{/if}></td>*}>
                            <td><{if $u._pay.pay}><{$u._pay.pay}><{else}>0<{/if}></td>
                            <td>¥<{if $u._pay.money}><{$u._pay.money/100}><{else}>0<{/if}></td>
                            <td><{$u.date}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>操作时间</td>
                        <td>操作记录</td>
                        <td>IP</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.log.data.data.list item=u}>
                        <tr>
                            <td><{$u.opt_time}></td>
                            <td><{join('<br>',$u.opt_record) nofilter}></td>
                            <td><{$u.opt_ip}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>操作时间</td>
                        <td>操作记录</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.monitor_log item=u}>
                        <tr>
                            <td><{$u.time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                            <td><{$u.record nofilter}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">自动广告策略日志</h3>
        </div>
        <div class="panel-body">
            <code><{str_replace("\r\n",'</code><br><code>',$data.auto_ad_log) nofilter}>
        </div>
    </div>


</div>
<script>
    $(function(){
       $('.cost').on('click',function() {
           var id = $(this).attr('data-id');
           layer.prompt({title: '填写成本', formType: 2}, function(cost, index){
               $.post('?ct=data&ac=overviewClickActiveAction',{id:id,cost:cost},function(re){
                   if(re.state){
                       location.reload();
                   }else{
                       layer.msg(re.msg);
                   }
               },'json');
           });
       });
    });

</script>
<{include file="../public/foot.tpl"}>