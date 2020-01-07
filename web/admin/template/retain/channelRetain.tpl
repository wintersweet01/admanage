<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="retainData" />
            <input type="hidden" name="ac" value="channelRetain" />
            <div class="form-group">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select name="platform">
                    <option value="">全 部</option>
                    <option value="1" <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2" <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>
                <label>选择游戏包</label>
                <select name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data.package_name==$name.package_name}>selected="selected"<{/if}>> <{$name.package_name}> </option>
                    <{/foreach}>
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
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate" />

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
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>日期</td>
                        <td nowrap>游戏名称</td>
                        <td nowrap>渠道</td>
                        <td nowrap>游戏包</td>

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
                        <td nowrap></td>
                        <td nowrap></td>

                        <td nowrap><{$data.total.reg}></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain2*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain3*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain4*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain5*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain6*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain7*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain15*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain21*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain30*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain60*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                        <td class="text-olive"><b><{if $data.total.reg}><{($data.total.retain90*100/$data.total.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%</b></td>
                    </tr>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$_channels[$u.channel_id]}></td>
                            <td nowrap><{$u.package_name}></td>

                            <td nowrap><{$u.reg}></td>
                            <td class="text-olive"><b><{if $u.not_now_2}>-<{else}><{if $u.reg}><{($u.retain2*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_3}>-<{else}><{if $u.reg}><{($u.retain3*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_4}>-<{else}><{if $u.reg}><{($u.retain4*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_5}>-<{else}><{if $u.reg}><{($u.retain5*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_6}>-<{else}><{if $u.reg}><{($u.retain6*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_7}>-<{else}><{if $u.reg}><{($u.retain7*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_15}>-<{else}><{if $u.reg}><{($u.retain15*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_21}>-<{else}><{if $u.reg}><{($u.retain21*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_30}>-<{else}><{if $u.reg}><{($u.retain30*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_60}>-<{else}><{if $u.reg}><{($u.retain60*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
                            <td class="text-olive"><b><{if $u.not_now_90}>-<{else}><{if $u.reg}><{($u.retain90*100/$u.reg)|string_format:"%.2f"}><{else}>0.00<{/if}>%<{/if}></b></td>
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

            var channel_ids = '&';
            $('input[type=checkbox]:checked').each(function(){
                channel_ids += 'channel_id[]='+$(this).val()+'&';
            });

            location.href='?ct=retainData&ac=channelRetainExcel&parent_id='+$('select[name=parent_id]').val()+'&game_id='+$('select[name=game_id]').val()+'&platform='+$('select[name=platform]').val()+channel_ids+'&package_name='+$('select[name=package_name]').val()+'&sdate='+$('input[name=sdate]').val()+'&edate='+$('input[name=edate]').val();
        });
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

        $('select[name=game_id],select[name=platform]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            var device_type = $('select[name=platform] option:selected').val();
            if(!game_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id+'&device_type='+device_type,function(re) {
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