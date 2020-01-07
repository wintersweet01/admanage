<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="user_id" value="<{$user_id}>" />
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>创建商家账号</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="inputUser" class="col-sm-2 control-label">* 账号</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" class="form-control" name="inputUser" placeholder="不多于8个字符" value="<{$data['info']['user']}>" <{if $data.admin_id}>readonly<{/if}>>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPwd" class="col-sm-2 control-label">* 密码</label>
                    <div class="col-sm-4 input-group">
                        <input type="password" class="form-control" name="inputPwd" placeholder="不能含有特殊字符,密码同时包含字母数字">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPwd2" class="col-sm-2 control-label">* 确认密码</label>
                    <div class="col-sm-4 input-group">
                        <input type="password" class="form-control" name="inputPwd2" placeholder="不能含有特殊字符,密码同时包含字母数字">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPwd2" class="col-sm-2 control-label">* 是否为CPS</label>
                    <div class="col-sm-4 input-group">
                        <input type="checkbox" name="cps" style="margin-top:8px" ><span>*充值金额要勾选CPS合作才能显示，CPA合作无需显示充值金额</span>
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
            $.post('?ct=ad&ac=addCpUserAction',{data:data},function(re){
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
