<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="Server" />
            <input type="hidden" name="ac" value="mergeServerList" />
            <div class="form-group">
                <lable>选择游戏</lable>
                <select name="game_id">
                    <option value="">全 部</option>
                    <{foreach from=$_games key=id item=name}>
                <option value="<{$id}>" <{if $data.game_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>
                <lable>选择合服服务器</lable>
                <select name="merge_server_id" id="server_id">
                    <option value="">全 部</option>
                    <{foreach from=$_game_server key=id item=name}>
                <option value="<{$id}>" <{if $data.merge_server_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选 </button>&nbsp;&nbsp;
                <a href="?ct=Server&ac=mergeServer" class="btn btn-primary btn-xs" > 合服操作 </a>
            </div>

        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>游戏名称</td>
                        <td nowrap>合服名称</td>
                        <td nowrap>合服前名称</td>
                        <td nowrap>合服日期</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list key=key item=val}>
                        <tr>
                            <td nowrap><{$_games[$val.game_id]}></td>
                            <td nowrap><{$_server[$val.game_id][$val.merge_server_id]}></td>
                            <td nowrap><{$_server[$val.game_id][$val.server_id]}></td>

                            <td nowrap><{$val.merge_date}></td>
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
    $('select[name=game_id]').on('change',function(){
        var game_id = $('select[name=game_id] option:selected').val();
        if(!game_id){
            return false;
        }
        /*$.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id,function(re) {
         var html = '<option value="">全部</option>';
         $.each(re,function(i,n){
         html += '<option value="'+n+'">'+n+'</option>';
         });
         $('#package_id').html(html);
         });*/
        $.getJSON('?ct=platform&ac=getGameServers&game_id='+game_id,function(re) {
            var html = '<option value="">全部</option>';
            $.each(re,function(i,n){
                html += '<option value="'+i+'">'+n+'</option>';
            });
            $('#server_id').html(html);
        });

    });

</script>
<{include file="../public/foot.tpl"}>
