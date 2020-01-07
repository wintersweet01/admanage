<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline" id="myForm">
            <input type="hidden" name="ct" value="retainData" />
            <input type="hidden" name="ac" value="retain" />
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="platform">
                    <option value="">全 部</option>
                    <option value="1" <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2" <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

                <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox-line" name="all" value="1" <{if $data.all==1}>checked="checked"<{/if}> />
                    显示所有条目
                </label>

                <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox-line group-by-child" name="group_child" value="1" <{if $data.group_child eq 1}>checked="checked"<{/if}>>
                    按子游戏归类
                </label>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>
                <button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>日期</td>
                        <td nowrap>游戏名称</td>

                        <td nowrap>注册量</td>
                        <td nowrap>次日留存</td>
                        <td nowrap>3日留存</td>
                        <td nowrap>4日留存</td>
                        <td nowrap>5日留存</td>
                        <td nowrap>6日留存</td>
                        <td nowrap>7日留存</td>
                        <td nowrap>15日留存</td>
                        <td nowrap>21日留存</td>
                        <td nowrap>30日留存</td>
                        <td nowrap>60日留存</td>
                        <td nowrap>90日留存</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>合计</td>
                        <td nowrap></td>

                        <td nowrap><{$data.total.reg}></td>
                        <td class="text-olive"><b><{($data.total.retain2*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain3*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain4*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain5*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain6*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain7*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain15*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain21*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain30*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain60*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                        <td class="text-olive"><b><{($data.total.retain90*100/$data.total.reg)|string_format:"%.2f"}>%</b></td>
                    </tr>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>

                            <td nowrap><{$u.reg}></td>
                            <td class="text-olive"><b><{if $u.not_now_2}>-<{else}><{($u.retain2*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_3}>-<{else}><{($u.retain3*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_4}>-<{else}><{($u.retain4*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_5}>-<{else}><{($u.retain5*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_6}>-<{else}><{($u.retain6*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_7}>-<{else}><{($u.retain7*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_15}>-<{else}><{($u.retain15*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_21}>-<{else}><{($u.retain21*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_30}>-<{else}><{($u.retain30*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_60}>-<{else}><{($u.retain60*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_90}>-<{else}><{($u.retain90*100/$u.reg)|string_format:"%.2f"}>%<{/if}></b></td>
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
            location.href='?ct=retainData&ac=retainExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&platform='+$('select[name=platform]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val()+'&group_child='+$("input[name='group_child']:checked").val();
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

        $(".group-by-child").on('click',function(){
            $("#myForm").submit();
        })
    });

</script>
<{include file="../public/foot.tpl"}>