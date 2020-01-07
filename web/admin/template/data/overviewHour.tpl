<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data1" />
            <input type="hidden" name="ac" value="overviewHour" />
            <div class="form-group">
                <lable>选择游戏</lable>
                <select name="game_id">
                    <option value="">全 部</option>
                    <{foreach from=$_games key=id item=name}>
                <option value="<{$id}>" <{if $data.game_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <lable>选择渠道</lable>
                <select name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <lable>选择游戏包</lable>
                <select name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data.package_name==$name.package_name}>selected="selected"<{/if}>> <{$name.package_name}> </option>
                    <{/foreach}>
                </select>



                <lable>选择推广活动</lable>
                <select name="monitor_id">
                    <option value="">全 部</option>
                    <{foreach from=$_monitors key=id item=name}>
                <option value="<{$id}>" <{if $data.monitor_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <lable>时间</lable>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

                <lable class="checkbox-inline">
                    <input type="checkbox" name="all" value="1" <{if $data.all==1}>checked="checked"<{/if}> />
                    显示所有条目
                </lable>

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
                        <td nowrap>时间</td>
                        <td nowrap>游戏名称</td>
                        <td nowrap>游戏包</td>
                        <td nowrap>渠道名称</td>
                        <td nowrap>推广活动</td>
                        <td nowrap>点击量</td>
                        <td nowrap>激活量</td>
                        <td nowrap>注册量</td>
                        <td nowrap>首充人数</td>
                        <td nowrap>新增充值金额<i class="fa fa-question-circle" alt="（新增充值产生的金额）"></i></td>
                        <td nowrap>区间付费人数</td>
                        <td nowrap>区间付费金额<i class="fa fa-question-circle" alt="（非新增充值产生的金额）"></i></td>
                        <td nowrap>更新时间</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap><{$_channels[$u.channel_id]}></td>
                            <td nowrap><{$_monitors[$u.monitor_id]}></td>
                            <td nowrap><{$u.click}></td>
                            <td nowrap><{$u.active}></td>
                            <td nowrap><{$u.reg}></td>
                            <td nowrap><{$u.new_pay}></td>
                            <td class="text-danger"><b>¥<{$u.new_money/100}></b></td>
                            <td nowrap><{$u.old_pay}></td>
                            <td class="text-danger"><b>¥<{$u.old_money/100}></b></td>
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