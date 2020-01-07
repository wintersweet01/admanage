<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="monitor_id" value="<{$monitor_id}>" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>批量修改推广链</u></li>
                    </ol>
                </div>

                <!--
                <div class="form-group">
                    <label for="page_id" class="col-sm-2 control-label">选择落地页</label>
                    <div class="col-sm-2 input-group">
                        <select name="page_id" id="page_id">
                            <option value="">选择落地页</option>
                            <{foreach from=$_pages item=name}>
                            <option value="<{$name.page_id}>" data-url="<{$smarty.const.LAND_PAGE_URL}><{$name.page_url}>/"><{$name.page_name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="jump_url" class="col-sm-2 control-label">下载地址</label>
                    <div class="col-sm-3 input-group">
                        <input type="text" class="form-control" name="jump_url" value="" >
                    </div>
                </div>
                -->

                <div class="form-group">
                    <label for="create_user" class="col-sm-2 control-label">负责人</label>
                    <div class="col-sm-3">
                        <select name="create_user" class="form-control" style="width: 150px;">
                            <option value="">选择负责人</option>
                            <{foreach from=$_admins key=id item=name}>
                            <option value="<{$id}>" <{if $data['info']['create_user']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;
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

        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=extend&ac=modifyLandPageAllAction',{data:data},function(re){
                if(re.state == true){
                    location.href = '?ct=extend&ac=linkList';
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

        $('select[name=page_id]').on('change',function(){
            var url = $('select[name=page_id] option:selected').attr('data-url');
            $('input[name=jump_url]').val(url);
        });

        $('#cancel').on('click',function(){
            history.go(-1);
        });
    });
</script>
<{include file="../public/foot.tpl"}>
