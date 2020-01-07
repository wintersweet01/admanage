<{include file="../public/header.tpl"}>
<style type="text/css">
    .highlight{
        float: left;
        width: 100%;
    }
    label.checkbox-inline{
        float: left;
        width: 200px;
        margin: 0px !important;
        display: inline;
    }
    h5{
        clear: both;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="role_id" value="<{$data.role_id}>" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加角色</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="role_name" class="col-sm-2 control-label">* 角色名称</label>
                    <div class="col-sm-6 input-group">
                        <input type="text" class="form-control" name="role_name" value="<{$data['info']['role_name']}>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_fun" class="col-sm-2 control-label">公共权限</label>
                    <div class="col-sm-6 input-group">
                        <figure class="highlight">
                            <{foreach from=$data._public_auth key=k item=n}>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="role_fun[]" value="<{$k}>" <{if in_array($k,explode('|',$data.info['role_fun']))}> checked="checked" <{/if}>> <{$n}>
                            </label>
                            <{/foreach}>
                        </figure>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_menu" class="col-sm-2 control-label">* 模块权限</label>
                    <div class="col-sm-6 input-group">
                        <{foreach from=$data._menu key=name item=menu}>
                        <h5><{$name}></h5>
                        <figure class="highlight">
                        <{foreach from=$menu key=k item=n}>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="role_menu[]" value="<{$k}>" <{if in_array($k,explode('|',$data.info['role_menu']))}> checked="checked" <{/if}>> <{$n}>
                            </label>
                        <{/foreach}>
                        </figure>
                        <{/foreach}>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4 input-group">
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
            $.post('?ct=admin&ac=roleAddAction',{data:data},function(re){
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:3000,
                    end:function(){
                        if(re.state == true){
                            location.href = '?ct=admin&ac=roleList';
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
