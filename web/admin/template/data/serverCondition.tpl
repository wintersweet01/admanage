<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="serverCondition"/>
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择区服</label>
                <select name="server_id">
                    <option value="">全 部</option>
                    <{foreach from=$_game_server key=id item=name}>
                <option value="<{$id}>" <{if $data.server_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <{if $data.all==1}>checked="checked"<{/if}> />
                    显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td  nowrap>时间</td>
                        <td  nowrap>游戏创角数</td>
                        <td  nowrap>老用户活跃</td>
                        <td  nowrap>DAR<i class="fa fa-question-circle" alt="角色活跃数"></i></td>
                        <td  nowrap>新增付费角色数</td>
                        <td  nowrap>新增角色付费率<i class="fa fa-question-circle" alt="（新增付费角色数/游戏创角数）"></i></td>
                        <td  nowrap>新增ARPPR<i class="fa fa-question-circle" alt="（新增角色付费/新增付费角色数）"></i></td>
                        <td  nowrap>新增角色付费</td>
                        <td  nowrap>付费角色数</td>
                        <td  nowrap>角色付费率<i class="fa fa-question-circle" alt="（付费角色数/角色DAR）"></i></td>
                        <td  nowrap>ARPR<i class="fa fa-question-circle" alt="（总充值/DAR）"></i></td>
                        <td  nowrap>ARPPR<i class="fa fa-question-circle" alt="（总充值/付费角色数）"></i></td>
                        <td  nowrap>总充值</td>

                    </tr>
                    </thead>
                    <tbody>
                    <{if $data.list}>
                        <tr>
                            <td  nowrap>合计 <{if $data.sopenDay >0}>(<b class="text-danger">已开服<{$data.sopenDay}>天</b>)<{/if}></td>
                            <td  nowrap><{$data.total.all_new_role}></td>

                            <td  nowrap><{$data.total.all_old_user_active}></td>
                            <td  nowrap><{$data.total.avg_dau_role}></td>
                            <td  nowrap><{$data.total.all_new_pay_role}></td>
                            <td  nowrap class="text-olive"><b><{$data.total.avg_new_pay_rate}></b></td>
                            <td  nowrap class="text-danger"><b>¥<{$data.total.avg_new_ARPPU}></b></td>
                            <td  nowrap class="text-danger"><b>¥<{$data.total.all_new_pay_money_role}></b></td>
                            <td  nowrap><{$data.total.all_pay_role}></td>
                            <td  nowrap class="text-olive"><b><{$data.total.avg_pay_rate}></b></td>
                            <td  nowrap class="text-danger"><b>¥<{$data.total.avg_ARPU}></b></td>
                            <td  nowrap class="text-danger"><b>¥<{$data.total.avg_ARPPU}></b></td>
                            <td  nowrap class="text-danger"><b>¥<{$data.total.all_pay_money_role}></b></i></td>

                        </tr>

                        <{/if}>
                    <{foreach from=$data.list key=key item=item}>
                        <tr>
                            <td  nowrap ><{$item.date}></td>
                            <td  nowrap ><{$item.new_role}></td>
                            <td  nowrap ><{$item.old_user_active}></td>
                            <td  nowrap ><{$item.dau_role}></td>
                            <td  nowrap ><{$item.new_pay_role}></td>
                            <td  nowrap  class="text-olive"><b><{$item.new_pay_rate}></b></td>
                            <td  nowrap  class="text-danger" ><b>¥<{$item.new_ARPPU}></b></td>
                            <td  nowrap  class="text-danger"><b>¥<{$item.new_pay_money_role}></b></td>

                            <td  nowrap ><{$item.pay_role}></td>

                            <td  nowrap  class="text-olive"><b><{$item.pay_rate}></b></td>
                            <td  nowrap  class="text-danger"><b>¥<{$item.ARPU}></b></td>
                            <td  nowrap  class="text-danger"><b>¥<{$item.ARPPU}></b></td>
                            <td  nowrap  class="text-danger"><b>¥<{$item.pay_money_role}></b></td>

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
        $('#printExcel').click(function(){
            location.href='?ct=data&ac=serverConditionExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&server_id='+$('select[name=server_id]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });

        $('select[name=game_id]').on('change',function() {
            $.getJSON('?ct=data&ac=getGameServer&game_id='+$('select[name=game_id]').val(),function(re){
                var html = '<option value="">全 部</option>';
                $.each(re,function(i,n) {
                    html += '<option value='+i+'>'+n+'</option>';
                });
                $('select[name="server_id"]').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>