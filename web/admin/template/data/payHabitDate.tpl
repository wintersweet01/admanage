<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data2"/>
            <input type="hidden" name="ac" value="payHabitDate"/>
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>档次</label>
                <select name="level_money">
                    <{if $data.level_money ||$data.game_id}>
                    <option value="">全部</option>
                    <{foreach from=$_level key=id item=name}>
                <option value="<{$id}>" <{if $data.level_money eq $id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                    <{else}>
                    <option value="">请先选择游戏</option>
                    <{/if}>
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
        <div style="float: left; min-width: 100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>日期</td>
                        <td>档次</td>
                        <td>充值总额</td>
                        <td>该档次订单数</td>
                        <td>所有档次总订单数</td>

                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list key=key item=item}>
                        <tr>
                            <td><{$item.date}></td>
                            <td><{$item.level_money}></td>
                            <td class="text-danger"><b><{$item.total_money}></b></td>
                            <td><{$item.order_num}></td>
                            <td><{$item.all_order_number}></td>

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
            location.href='?ct=data2&ac=payHabitDateExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&device_type='+$('select[name=device_type]').val()+'&level_money='+$('select[name=level_money]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });

        $('select[name=game_id]').on('change',function() {
            $.getJSON('?ct=data&ac=getMoneyLevel&game_id='+$('select[name=game_id]').val(),function(re){
                var html = '<option value="">全 部</option>';
                $.each(re,function(i,n) {
                    html += '<option value='+i+'>'+n+'</option>';
                });
                $('select[name="level_money"]').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>