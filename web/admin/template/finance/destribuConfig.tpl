<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="is_edit" value="<{$is_edit}>">
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>分成配置列表</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">* 选择游戏</label>
                    <div class="col-sm-5">
                        <{if !$is_edit}>
                        <{widgets widgets=$widgets}>
                        <{else}>
                            <input type="text" class="form-control" value="<{$_games[$data.game_id]}>" readonly>
                            <input type="hidden" name="game_id" value="<{$data.game_id}>" readonly>
                        <{/if}>
                    </div>
                </div>

                <div class="form-group">
                    <label for="open_third" class="col-sm-2 control-label">* 渠道</label>
                    <div class="col-sm-5">
                        <{if !$is_edit}>
                        <select name="channel_id" <{if $data['info']}>disabled="disabled"<{/if}>>
                            <option value="">选择渠道</option>
                            <{foreach from=$_channels key=id item=name}>
                        <option value="<{$name}>" ><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                        <{else}>
                            <input type="text" class="form-control" value="<{$data.channel}>" readonly>
                            <input type="hidden"  name="channel_id" value="<{$data.channel}>" readonly>
                        <{/if}>
                    </div>
                </div>
                <input type="hidden" name="old_money1" value="<{$data.money1}>">
                <input type="hidden" name="old_money2" value="<{$data.money2}>">
                <div class="form-group" class="configArea">
                    <label for="open_third" class="col-sm-2 control-label">* 区间配置</label>
                    <div class="col-sm-5" style="width:50%">
                        <input type="text" style="width:100px;float:left;" class="form-control" placeholder="金额1" value="<{$data.money1}>" name="money1[]">
                        <input type="text" style="width:100px;float:left;margin-left:10px" class="form-control" placeholder="金额2" value="<{$data.money2}>" name="money2[]">
                        <input type="text" style="width:100px;float:left;margin-left:10px" class="form-control" placeholder="比例" value="<{$data.prop}>" name="prop[]">

                    </div>
                </div>
                <{if !$is_edit}>
                <input type="button"  class="btn btn-primary" style="margin:0px 0 20px 193px" onclick="return addConfig(this);" value="增加">
                <{/if}>


                <div class="form-group text-center">
                    <button type="button" id="submit" class="btn btn-primary"> 保 存 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){

        $('input[name="file"]').on('change',function(){
            var parent = $(this).parents('.input-group');
            var index = layer.load(2, {
                shade: [0.6,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                url: '?ct=upload&ac=upload&file_name=file&limit_size=200',  //server script to process data
                type: 'POST',
                success: function(re){
                    layer.close(index);
                    re = JSON.parse(re);
                    if(re.state){
                        parent.find('input[name=spec_icon]').val(re.url);
                        parent.find('.img-thumbnail').attr('src',re.url);
                    }else{
                        layer.msg(re.msg);
                    }
                },
                error: function(error){
                    layer.msg(error);
                },
                data: new FormData($('form')[0]),
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('input[name=platform]').on('click',function(){
            $('.for').hide();
            $('.for-'+$(this).val()).show();
        });

        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=destribuReceipt&ac=destribuConfigAction',{data:data},function(re){
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:1500,
                    end:function(){
                        if(re.state == true){
                            location.href = '?ct=destribuReceipt&ac=destribuConfList';
                        }
                    }
                });
            },'json');
        });

        $('#cancel').on('click',function(){
            history.go(-1);
        });

    });
</script>
<script>
    function addConfig(obj){
        var par = $(obj).prev();
        var content = '<div class="form-group" class="configArea"><label for="open_third" class="col-sm-2 control-label">* 区间配置</label><div class="col-sm-5" style="width:50%"><input type="text" style="width:100px;float:left;" class="form-control" placeholder="金额1" value="" name="money1[]"><input type="text" style="width:100px;float:left;margin-left:10px" class="form-control" placeholder="金额2" value="" name="money2[]"><input type="text" style="width:100px;float:left;margin-left:10px" class="form-control" placeholder="比例" value="" name="prop[]"></div></div>';
        par.after(content);
    }

</script>
<{include file="../public/foot.tpl"}>
