<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data1" />
            <input type="hidden" name="ac" value="overviewDay" />
            <input type="hidden" name="sort_by" value="<{$data.sort_by}>"/>
            <input type="hidden" name="sort_type" value="<{$data.sort_type}>"/>
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择渠道</label>
                <select name="channel_id" style="width: 100px;">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>选择游戏包</label>
                <select name="package_name" id="package_id" style="width: 100px;">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data.package_name==$name.package_name}>selected="selected"<{/if}>> <{$name.package_name}> </option>
                    <{/foreach}>
                </select>

                <label>选择推广活动</label>
                <select name="monitor_id" style="width: 100px;">
                    <option value="">全 部</option>
                    <{foreach from=$_monitors key=id item=name}>
                <option value="<{$id}>" <{if $data.monitor_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>选择账号</label>
                <select name="user_id" style="width: 100px;">
                    <option value="">全 部</option>
                    <{foreach from=$_user_list item=item}>
                <option value="<{$item.user_id}>" <{if $data.user_id eq $item.user_id}>selected="selected"<{/if}>> <{$item.user_name}> </option>
                    <{/foreach}>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

                <label class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <{if $data.all==1}>checked="checked"<{/if}> />
                    显示所有条目
                </label>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap class="order" data-order="date">日期 <{if $data.sort_by=='date'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="game_id">游戏名称 <{if $data.sort_by=='game_id'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="package_name">游戏包 <{if $data.sort_by=='package_name'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="channel_id">渠道名称 <{if $data.sort_by=='channel_id'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="monitor_id">推广活动 <{if $data.sort_by=='monitor_id'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="click">点击量 <{if $data.sort_by=='click'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>

                        <td nowrap class="order" data-order="active">激活量 <{if $data.sort_by=='active'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="click_reg">点击注册率 <{if $data.sort_by=='click_reg'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}><i class="fa fa-question-circle" alt="（注册量/点击量）"></i></td>
                        <td nowrap class="order" data-order="reg">注册量 <{if $data.sort_by=='reg'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="new_reg_device">新增注册设备 <{if $data.sort_by=='new_reg_device'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="old_money">区间付费金额 <{if $data.sort_by=='old_money'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}><i class="fa fa-question-circle" alt="（非新增充值产生的金额）"></i></td>
                        <td nowrap class="order" data-order="old_pay">区间付费人数 <{if $data.sort_by=='old_pay'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="new_money">新增充值金额 <{if $data.sort_by=='new_money'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="new_pay">首充人数 <{if $data.sort_by=='new_pay'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                        <td nowrap class="order" data-order="update_time">更新时间 <{if $data.sort_by=='update_time'}><{if $data.sort_type=='asc'}><i class="fa fa-sort-up"></i><{else}><i class="fa fa-sort-down"></i><{/if}><{/if}></td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td nowrap>合计</td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap><{$data.total.click}></td>

                            <td nowrap><{$data.total.active}></td>
                            <td class="text-olive"><b><{(intval($data.total.reg*10000/$data.total.click)/100)|string_format:"%0.2f"}>%</b></td>
                            <td nowrap><{$data.total.reg}></td>
                            <td nowrap><{$data.total.new_reg_device}></td>
                            <td class="text-danger"><b>¥<{$data.total.old_money/100}></b></td>
                            <td nowrap></td>
                            <td class="text-danger"><b>¥<{$data.total.new_money/100}></b></td>
                            <td nowrap><{$data.total.new_pay}></td>
                            <td nowrap></td>
                        </tr>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap><{$_channels[$u.channel_id]}></td>
                            <td nowrap><{$_monitors[$u.monitor_id]}></td>
                            <td nowrap><{$u.click}></td>

                            <td nowrap><{$u.active}></td>

                            <td class="text-olive"><b><{$u.click_reg*100|string_format:"%0.2f"}>%</b></td>
                            <td nowrap><{$u.reg}></td>
                            <td nowrap><{$u.new_reg_device}></td>
                            <td class="text-danger"><a href="?ct=platform&ac=orderList&is_pay=2&is_old=1&_reg_date=<{$u.date}>&game_id=<{$u.game_id}>&package_name=<{$u.package_name}>&channel_id=<{$u.channel_id}>&monitor_id=<{$u.monitor_id}>&sdate=<{$u.date}>&edate=<{$u.date}>"><b>¥<{$u.old_money/100}></b></a></td>
                            <td nowrap><{$u.old_pay}></td>
                            <td class="text-danger"><a href="?ct=platform&ac=orderList&is_pay=2&is_new=1&_reg_date=<{$u.date}>&game_id=<{$u.game_id}>&package_name=<{$u.package_name}>&channel_id=<{$u.channel_id}>&monitor_id=<{$u.monitor_id}>&sdate=<{$u.date}>&edate=<{$u.date}>"><b>¥<{$u.new_money/100}></b></a></td>
                            <td nowrap><{$u.new_pay}></td>
                            <td nowrap><{$u.update_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
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
        $('.order').click(function(){
            var order = $(this).attr('data-order');
            var input = $('input[name=sort_by]').val();
            if(order == input){
                var type = $('input[name=sort_type]').val();
                $('input[name=sort_type]').val(type=='desc' ? 'asc' : 'desc');
            }else{
                $('input[name=sort_by]').val(order);
                $('input[name=sort_type]').val('desc');
            }
            $('form').submit();
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
        $('select[name=channel_id]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            if(!game_id){
                return false;
            }
            var channel_id = $('select[name=channel_id] option:selected').val();
            if(!channel_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id+'&channel_id='+channel_id,function(re) {
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