<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
            	<input type="hidden" name="id" value="<{$data.id}>" />
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加礼包类别</u></li>
                    </ol>
                </div>
                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">* 选择游戏</label>
                    <div class="col-sm-9">
                        <{widgets widgets=$widgets}>
                        <span class="help-block red">如果不选子游戏，母游戏下所有子游戏都共享母游戏礼包。</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">* 礼包类型</label>
                    <div class="col-sm-2">
                        <select name="type" class="form-control">
                            <{foreach from=$_types key=id item=name}>
                            <option value="<{$id}>" <{if $data['type']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="typename" <{if $data['type'] != 0}>style="display: none;"<{/if}>>
                    <label for="name" class="col-sm-2 control-label">* 礼包类型名称</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="name" placeholder="" value="<{$data['name']}>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="explain" class="col-sm-2 control-label">礼包说明</label>
                    <div class="col-sm-3">
                      <textarea name="explain" rows="3" class="form-control" placeholder="如：VIP卡1天*1；英雄50000经验*1；高级迁城卡*1；15分钟加速*20；"><{$data['explain']}></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">* 是否开启</label>
                    <div class="col-sm-3">
                        <input type="radio" name="status" value="1" <{if $data['status'] == 1}>checked="checked"<{/if}>> 开
                        <input type="radio" name="status" value="0" <{if $data['status'] == 0}>checked="checked"<{/if}>> 关
                    </div>
                </div>

                <div class="form-group">
                	<label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                    <button type="button" id="submit" class="btn btn-primary"> 保 存 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('select[name=type]').on('change', function () {
            var type = $(this).find('option:selected').val();
            if (type == 0) {
                $('#typename').show();
            } else {
                $('#typename').hide();
            }
        });

        $('#submit').on('click',function(){
            var data = $('form').serialize();
            var index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=platform&ac=addGiftTypeAction',{data:data},function(re){
				layer.close(index);
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:3000,
                    end:function(){
                        if(re.state == true){
                            location.href = '?ct=platform&ac=packageGift';
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
<{include file="../public/foot.tpl"}>