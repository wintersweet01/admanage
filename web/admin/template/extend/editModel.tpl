<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="model_id" value="<{$data.model_id}>" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改落地页模板</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="row">
                            <{foreach from=$data.element.text item=u key=k}>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><{$u}></div>
                                    <div class="panel-body">
                                        <input type="text" name="text_<{$k}>" value="<{$u}>" style="width: 100%">
                                    </div>
                                </div>
                            <{/foreach}>
                        </div>
                        <div class="row" id="waterfall">
                            <{foreach from=$data.element.img item=u key=k}>
                            <div class="water-item" style="width:236px;">
                                <div class="thumbnail" style="border-radius: 0;">
                                    <a target="_blank" href="<{$u.src}>"><img class="lazy" style="height:<{$u.height*236/$u.width}>px;" src="<{$u.src}>" alt=""><input type="hidden" name="img_<{$k}>" value="<{$u.src}>"></a>
                                    <div class="caption" style="background: #fafafa;color:#9e7e6b;">
                                        <div>
                                            <button type="button" class="btn btn-primary" style="position: relative;"><input type="file" name="file" style="opacity: 0;width:100%;height:100%;position: absolute;top:0;left:0;">更换图片</button>                                            尺寸:<{$u.size[0]}>*<{$u.size[1]}>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <{/foreach}>
                        </div>
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
<script src="<{$smarty.const.SYS_STATIC_URL}>/js/jquery.waterfall.min.js"></script>
<script>
    $(function(){

        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=extend&ac=editModelAction',{data:data},function(re){
                if(re.state){
                    location.href = document.referrer;
                }else{
                    layer.msg(re.msg);
                }
            },'json');
        });

        $('input[type="file"]').on('change',function(){
            var parent = $(this).parents('.water-item');
            var index = layer.load(1, {
                shade: [0.6,'#fff'] //0.1透明度的白色背景
            });
            var obj = new FormData();
            var name = $(this).attr('name');
            obj.append('file',$(this)[0].files[0]);
            obj.append('model_id',$('input[name=model_id]').val());
            $.ajax({
                url: '?ct=extend&ac=insertUpload&name=file',  //server script to process data
                type: 'POST',
                success: function(re){
                    layer.close(index);
                    re = JSON.parse(re);
                    if(re.state){
                        parent.find('img').attr('src',re.base64);
                        parent.find('input[type=hidden]').val(re.url);
                    }else{
                        layer.open({
                            type: 1,
                            title:false,
                            closeBtn: 0,
                            shadeClose: true,
                            content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                            time:3000
                        });
                    }
                },
                error: function(error){
                    layer.open({
                        type: 1,
                        title:false,
                        closeBtn: 0,
                        shadeClose: true,
                        content:'<p style="margin:15px 30px;">'+error+'</p>',
                        time:3000
                    });
                },
                // Form数据
                data: obj,
                cache: false,
                contentType: false,
                processData: false
            });
        });

        var fall = function(){
            $('#waterfall').waterfall({
                itemCls:'.water-item',   // 子元素id/class, 可留空
                columnWidth:250,              // 列宽度, 纯数字, 可留空
                isResizable:false
            });
        }

        var t_img; // 定时器
        var isLoad = true; // 控制变量

        isImgLoad(fall);

        function isImgLoad(callback){
            $('.lazy').each(function(){
                if(this.height === 0){
                    isLoad = false;
                    return false;
                }
            });
            if(isLoad){
                clearTimeout(t_img);
                callback();
            }else{
                isLoad = true;
                t_img = setTimeout(function(){
                    isImgLoad(callback);
                },500);
            }
        }

        $('#cancel').on('click',function(){
            history.go(-1);
        });
    });
</script>
<{include file="../public/foot.tpl"}>
