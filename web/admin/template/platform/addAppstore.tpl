<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="store_id" value="<{$data.store_id}>" />
                <input type="hidden" name="game_id" value="<{$data.game_id}>" />
                <input type="hidden" name="package_name" value="<{$data.package_name}>" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加苹果内商品</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="appstore_name" class="col-sm-2 control-label">* Product ID</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="appstore_name" maxlength="50" value="<{$data['info']['appstore_name']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="open_third" class="col-sm-2 control-label">* 价格</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="goods_price" value="<{($data['info']['goods_price']/100)|string_format:"%.2f"}>">
                    </div>
                </div>

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
        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=platform&ac=addAppstoreAction',{data:data},function(re){
                if(re.state == true){
                    location.href = '?ct=platform&ac=appstore&game_id=<{$data.game_id}>&package_name=<{$data.package_name}>';
                }else{
                    layer.open({
                        type: 1,
                        title:false,
                        closeBtn: 0,
                        shadeClose: true,
                        content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                        time:3000,
                        end:function(){

                        }
                    });
                }

            },'json');
        });

        $('#cancel').on('click',function(){
            history.go(-1);
        });

    });
</script>
<{include file="../public/foot.tpl"}>
