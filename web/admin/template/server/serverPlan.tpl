<{include file="../public/header.tpl"}>
<style>
    .btn-file {  /*  上传按钮*/
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity = 0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>
<div id="areascontent">
    <{if $msg}>
    <div id="msg" style="display: none">
        <{$msg}>
    </div>
    <{/if}>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;margin-top:50px;">
        <div style="float: left; width: 100%;">
            <form method="post" action="?ct=server&ac=serverPlanAct" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <label for="model_id" class="col-sm-3 control-label">* 选择游戏</label>
                    <div class="col-sm-5 input-group">
                        <select name="game_id">
                            <option value="-1">请选择游戏</option>
                            <{foreach from=$_games key=id item=name}>
                            <option value="<{$id}>" > <{$name}> </option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="model_id" class="col-sm-3 control-label">* 下载开服计划表格模板</label>
                    <div class="col-sm-5 input-group">
                        <a id="download" href="?ct=server&ac=linkServerExcel" class="btn btn-primary btn-small" role="button"> 下 载 </a>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>



                <div class="form-group">
                    <label for="model_id" class="col-sm-3 control-label">* 上传开服计划表格</label>
                    <div class="col-sm-5 input-group">
                        <span class="btn btn-success btn-file"> 选择文件
                            <span class="glyphicon glyphicon-floppy-open" aria-hidden="true"></span>
                               <input type="file" name="file" value="">
                        </span>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" id="submit" class="btn btn-primary"> 上 传 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        if($('#msg').length > 0){
            layer.alert($('#msg').text(), {
                skin: 'layui-layer-lan'
                ,closeBtn: 0
            });
        }
        $('#download').on('click',function() {
            var game_id = $('select[name=game_id]').val();
            if(game_id<0){
                layer.msg('请选择游戏');return false;
            }else{
                var target_ = $(this).attr('href');
                $(this).attr('href',target_+'&game_id='+game_id);
            }
        })
    });
</script>

<{include file="../public/foot.tpl"}>
