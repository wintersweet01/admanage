<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="page_id" value="<{$data.page_id}>" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改落地页</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="model_id" class="col-sm-3 control-label">* 落地页模板</label>
                    <div class="col-sm-5 input-group">
                        <select name="model_id">
                            <option value="">选择落地页模板</option>
                            <{foreach from=$_models key=id item=name}>
                            <option value="<{$id}>" data-game="<{$name.game_id}>" <{if $data['info']['model_id']==$id}>selected="selected"<{/if}>><{$name.model_name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-3 control-label">* 选择游戏</label>
                    <div class="col-sm-5 input-group">
                        <select name="game_id">
                            <option value="">选择游戏</option>
                            <{foreach from=$_games key=id item=name}>
                        <option value="<{$id}>" <{if $data['info']['game_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="package_name" class="col-sm-3 control-label">* 选择游戏包</label>
                    <div class="col-sm-5 input-group">
                        <select name="package_name" id="package_name" >
                            <option value="">选择游戏包</option>
                            <{foreach from=$data['_packages'] key=id item=name}>
                        <option value="<{$id}>" <{if $data['info']['package_name']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_id" class="col-sm-3 control-label">* 选择公司</label>
                    <div class="col-sm-5 input-group">
                        <select name="company_id">
                            <option value="">选择公司</option>
                            <{foreach from=$_companys key=id item=name}>
                        <option value="<{$id}>" <{if $data['info']['company_id']==$id}>selected="selected"<{/if}>> <{$name}> </option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="page_name" class="col-sm-3 control-label">* 落地页名称</label>
                    <div class="col-sm-3 input-group">
                        <input type="text" class="form-control" name="page_name" value="<{$data['info']['page_name']}>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="auto_jump" class="col-sm-3 control-label">* 自动跳转</label>
                    <div class="col-sm-3 input-group">
                        <input type="text" class="form-control" name="auto_jump" value="<{$data['info']['auto_jump']}>">
                        <div class="input-group-addon">秒，填0为关闭</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="click_body" class="col-sm-3 control-label">* 点击任意位置下载</label>
                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="click_body" value="1" <{if $data['info']['click_body'] == 1}>checked="checked"<{/if}>> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="click_body" value="0" <{if $data['info']['click_body'] == 0}>checked="checked"<{/if}>> 开启
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="display_foot" class="col-sm-3 control-label">* 底部开关</label>
                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="display_foot" value="0" <{if $data['info']['display_foot'] == 0}>checked="checked"<{/if}>> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="display_foot" value="1" <{if $data['info']['display_foot'] == 1}>checked="checked"<{/if}>> 开启
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="auto_header" class="col-sm-3 control-label">* 显示头部</label>
                    <div class="col-sm-5 input-group">
                        <label class="radio-inline">
                            <input type="radio" name="auto_header" value="0" <{if $data['info']['auto_header'] == 0}>checked="checked"<{/if}>> 不显示
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="auto_header" value="1" <{if $data['info']['auto_header'] == 1}>checked="checked"<{/if}>> 显示
                        </label>
                    </div>
                </div>

                <nav class="navbar navbar-default auto_header col-sm-12" <{if $data['info']['auto_header']!=1}>style="display:none;"<{/if}>>
                    <br />
                    <div class="form-group auto_header" <{if $data['info']['auto_header']!=1}>style="display:none;"<{/if}>>
                        <label for="header_title" class="col-sm-3 control-label">* 头部标题</label>
                        <div class="col-sm-8 input-group">
                            <input type="text" name="header_title" value="<{$data['info']['header_info']['header_title']}>">
                        </div>
                    </div>

                    <div class="form-group auto_header" <{if $data['info']['auto_header']!=1}>style="display:none;"<{/if}>>
                        <label for="header_sub_title" class="col-sm-3 control-label">* 头部副标题</label>
                        <div class="col-sm-8 input-group">
                            <input type="text" style="width:420px;" name="header_sub_title" value="<{$data['info']['header_info']['header_sub_title']}>">
                        </div>
                    </div>

                    <div class="form-group auto_header" <{if $data['info']['auto_header']!=1}>style="display:none;"<{/if}>>
                        <label for="file" class="col-sm-3 control-label">* 头部按钮</label>
                        <div class="col-sm-5 input-group">
                            <input type="file" name="file3" value="选择图片">
                            <input type="hidden" name="header_button" value="<{$data['info']['header_info']['header_button']}>" />
                        </div>
                    </div>
                 </nav>

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

        $('input[name=auto_header]').on('click',function() {
            if($(this).val()==1){
                $('.auto_header').show();
            }else{
                $('.auto_header').hide();
            }
        });

        $('input[name="file3"]').on('change',function(){
            var parent = $(this).parents('div');
            var index = layer.load(1, {
                shade: [0.6,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                url: '?ct=upload&ac=upload&file_name=file3',  //server script to process data
                type: 'POST',
                success: function(re){
                    layer.close(index);
                    re = JSON.parse(re);
                    if(re.state){
                        parent.find('input[name=header_button]').val(re.url);
                    }else{
                        layer.msg(re.msg);
                    }
                },
                error: function(error){
                    layer.msg(error);
                },
                // Form数据
                data: new FormData($('form')[0]),
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=extend&ac=addLandPageAction',{data:data},function(re){
                if(re.state == true){
                    location.href = '?ct=extend&ac=landPage';
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

    <{if !$data['_packages']}>
        $('select[name=game_id]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            if(!game_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id,function(re) {
                var html = '<option value="">选择游戏包</option>';
                $.each(re,function(i,n){
                    html += '<option value="'+n+'">'+n+'</option>';
                });
                $('#package_name').html(html);
            });
        });

        <{/if}>


        $('#cancel').on('click',function(){
            history.go(-1);
        });

    });
</script>
<{include file="../public/foot.tpl"}>
