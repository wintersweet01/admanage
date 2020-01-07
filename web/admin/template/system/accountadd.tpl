<{include file="../public/header.tpl"}>
<style>
    .input-show-sm-5{
        width: 40.74%;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;margin-top:50px;">
        <div style="float: left; width: 100%;">
            <form method="post" id="myForm" action="" class="form-horizontal">
                <input type="hidden" name="account_id" value="<{$account_id}>">
                <div class="form-group">
                    <label for="media" class="col-sm-2 control-label"><em class="text-red">*</em>媒体：</label>
                    <div class="col-sm-5">
                        <select id="media" name="media" class="col-sm-4" <{if $account_id != ''}>disabled="disabled"<{/if}> >
                            <option value="">请选择</option>
                            <{foreach from=$media_conf key=media_id item=row}>
                            <option value="<{$media_id}>" <{if $data.media eq $media_id}>selected="selected"<{/if}>><{$row}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="media_account" class="col-sm-2 control-label"><em class="text-red">*</em>媒体账号：</label>
                    <div class="col-sm-5">
                        <input type="text" class="col-sm-5 input-show-sm-5 form-control" name="account" id="media_account" autocomplete="off" <{if $account_id neq ''}>disabled="disabled"<{/if}> value="<{$data.account}>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="media_account_password" class="col-sm-2 control-label"><em class="text-red">*</em>媒体账号密码：</label>
                    <div class="col-sm-5">
                        <input type="password" class="col-sm-5 input-show-sm-5 form-control" name="account_password" id="media_account_password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="media_account_nickname" class="col-sm-2 control-label">媒体账号别名：</label>
                    <div class="col-sm-5">
                        <input type="text" class="col-sm-5 input-show-sm-5 form-control" name="account_nickname" id="media_account_nickname" value="<{$data.account_nickname}>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="app_pub" class="col-sm-2 control-label">投放应用：</label>
                    <div class="col-sm-5">
                        <select id="app_pub" name="app_pub[]" class="col-sm-4" multiple="multiple">
                            <{foreach from=$apps key=k item=info}>
                            <option value="<{$k}>" <{if in_array($k,$data.app_pub)}>selected="selected"<{/if}> ><{$info.app_name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="manager" class="col-sm-2 control-label">负责人：</label>
                    <div class="col-sm-5">
                        <select id="manager" name="manager[]" class="col-sm-4" multiple="multiple" >
                            <{foreach from=$admins key=mk item=mrow}>
                            <option value="<{$mk}>" <{if in_array($mk ,$data.manager) or $mk eq $login_admin }>selected="selected"<{/if}> ><{$mrow.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <{if $account_id}>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">状态：</label>
                    <div class="col-sm-5">
                        <label style="margin-right: 20px"><input type="radio" <{if $data.status eq 0}>checked="checked"<{/if}> name="status" value="0">正常</label>
                        <label><input type="radio" <{if $data.status eq 1}>checked="checked"<{/if}> name="status" value="1">失效</label>
                    </div>
                </div>
                <{/if}>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 确 认</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.css">
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/upload.min.js"></script>
<script>
    $(function () {
        $("#submit").on('click',function(){
            addInfo();
        });

        $(document).on('keydown',function(event){
            if(event.keyCode == 13){
                addInfo();
            }
        });
        $("#cancel").on('click',function(){
            window.history.back();
        });
        function addInfo() {
            var _this = $("#submit");
            $('.need').each(function(){
                if(!$(this).val()){
                    layer.msg('请填写必要选项',{time:1000});
                    return false;
                }
            });
            var tips = layer.confirm('确认录入',function(){
                $.ajax({
                    type:'post',
                    url:'/?ct=system&ac=mediaAccountAddAction',
                    data:$("#myForm").serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        _this.addClass('layui-btn-disabled');
                        _this.attr('disabled',true);
                    },
                    success:function(ret){
                        layer.msg(ret.msg);
                        if(ret.state == 1){
                            var data = ret.data;
                            setTimeout(function(){
                                window.open(data.url);
                            },1000);
                        }else{
                            return false;
                        }
                    },
                    complete:function(){
                        layer.close(tips);
                        _this.removeClass('layui-btn-disabled');
                        _this.attr('disabled',false);
                    }
                })
            })
        }
    });
</script>
<{include file="../public/foot.tpl"}>