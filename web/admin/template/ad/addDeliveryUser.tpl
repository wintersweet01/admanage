<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="user_id" value="<{$data.user_id}>" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改投放账号</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="width" class="col-sm-2 control-label">* 渠道</label>
                    <div class="col-sm-5">
                        <select name="channel_id">
                            <{foreach from=$_channels key=key item=name}>
                        <option value="<{$key}>" <{if $data['info']['channel_id']==$key}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_id" class="col-sm-2 control-label">* 所属资质公司</label>
                    <div class="col-sm-5">
                        <select name="company_id">
                            <{foreach from=$_companys key=id item=name}>
                        <option value="<{$id}>" <{if $data['info']['company_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="width" class="col-sm-2 control-label">* 所属投放组</label>
                    <div class="col-sm-5">
                        <select name="group_id">
                            <{foreach from=$_groups item=name}>
                        <option value="<{$name.group_id}>" <{if $data['info']['group_id']==$name.group_id}>selected="selected"<{/if}>><{$name.group_name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="media_account" class="col-sm-2 control-label">* 媒体账号</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="media_account" value="<{$data['info']['media_account']}>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="media_account_pwd" class="col-sm-2 control-label">* 媒体账号密码</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="media_account_pwd" value="<{$data['info']['media_account_pwd']}>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_name" class="col-sm-2 control-label">* 账号名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="user_name" value="<{$data['info']['user_name']}>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="sign_key" class="col-sm-2 control-label"> sign key</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="sign_key" value="<{$data['info']['sign_key']}>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="encrypt_key" class="col-sm-2 control-label"> encrypt key</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="encrypt_key" value="<{$data['info']['encrypt_key']}>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="domain" class="col-sm-2 control-label">自定义投放域名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="domain" value="<{$data['info']['domain']}>" >
                        <span class="help-block">格式：http://example.com。留空将使用默认域名，填写前需确保域名已解析。</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="download_domain" class="col-sm-2 control-label">自定义下载域名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="download_domain" value="<{$data['info']['download_domain']}>" >
                        <span class="help-block">格式：http://example.com。留空将使用默认域名，填写前需确保域名已解析。</span>
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
            $.post('?ct=ad&ac=addDeliveryUserAction',{data:data},function(re){
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:3000,
                    end:function(){
                        if(re.state == true){
                            location.href = '?ct=ad&ac=deliveryUser';
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
