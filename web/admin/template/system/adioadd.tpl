<{include file="../public/header.tpl"}>
<style>
    .input-width{
        width: 200px;
    }
    .center-vertical{
        position: relative;
        top:50%;
        transform:translateY(-50%);
    }.center-horizontal{
         position: relative;
         left:50%;
         transform:translateX(-50%);
     }
    .checkbox-radio{
        position: relative;
        top: 2px;
    }
</style>
<div id="areascontent">
    <div class="row" style="margin-bottom: 0.8%;overflow: hidden">
        <div style="float: left;width: 100%">
            <form method="post" action="" id="myForm" class="form-horizontal">
                <input type="hidden" name="id" value="<{$id}>" />
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back" class="text-blue">返 回</a></li>
                        <li class="active"><u>添加/修改ADIO信息</u></li>
                    </ol>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label"><em class="text-red">*</em> 邮箱账号：</label>
                    <div class="col-sm-5">
                        <input type="email" name="email" value="<{$data.email}>" class="form-control input-width" placeholder="请填写企业邮箱" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="nickname" class="col-sm-2 control-label">别名：</label>
                    <div class="col-sm-5">
                        <input type="text" name="nickname" value="<{$data.nickname}>" class="form-control input-width" placeholder="请填写员工姓名" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="adio_role" class="col-sm-2 control-label"><em class="text-red">*</em> 账号角色：</label>
                    <div class="col-sm-5">
                        <label class="control-label" style="margin-right: 30px">
                            <input class="checkbox-radio" <{if $data.role eq 1}>checked="checked"<{/if}> type="radio" name="adio_role" value="1" /> 优化师
                        </label>
                        <label class="control-label" style="margin-right: 30px">
                            <input class="checkbox-radio" <{if $data.role eq 2}>checked="checked"<{/if}> type="radio" name="adio_role" value="2" /> 设计师
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="adio_group" class="col-sm-2 control-label"><em class="text-red">*</em> 分组：</label>
                    <div class="col-sm-5">
                        <select name="adio_group" class="adio-group">
                            <{foreach from=$groups key=k item=info}>
                            <option value="<{$info.id}>" <{if $data.group_id eq $info.id}>selected="selected"<{/if}> ><{$info.group_name}></option>
                            <{/foreach}>
                        </select>
                        <{if $is_admin eq true }><button type="button" class="btn btn-default btn-xs add-group-modal"><i class="fa fa-plus" aria-hidden="true"></i> 新增分组</button><{/if}>
                    </div>
                </div>
                <{if $id}>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label"><em class="text-red">*</em> 状态：</label>
                    <div class="col-sm-5">
                        <label class="control-label" style="margin-right: 30px;">
                            <input class="checkbox-radio" <{if $data.status eq 0}>checked="checked"<{/if}> type="radio" name="status" value="0">有效
                        </label>
                        <label class="control-label" style="margin-right: 30px;">
                            <input class="checkbox-radio" <{if $data.status eq 1}>checked="checked"<{/if}> type="radio" name="status" value="1">无效
                        </label>
                    </div>
                </div>
                <{/if}>
                <div class="form-group">
                    <label for="media_account" class="col-sm-2 control-label">
                        <em class="text-red">*</em>
                        媒体账号：
                    </label>
                    <div class="col-lg-8">
                        <{widgets widgets=$widgets}>
                    </div>
                </div>

                <div class="form-group text-left" style="width: 30%;margin: 0 auto;margin-left: 25%">
                    <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document" style="margin-top: 15%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加分组</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="modal_form" class="form-horizontal">
                    <div class="form-group">
                        <label for="group_add" class="col-sm-6">请输入分组名称</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" name="group_add" value="" class="form-control input-width" autocomplete="off" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
                <button type="button" class="btn btn-primary commit-add">确 认</button>
            </div>
        </div>
    </div>
</div>
<script src="<{$smarty.const.SYS_STATIC_URL}>/js/ping_uf.js?v=2019021820"></script>
<script type="text/javascript">
    $(function(){
        $(".add-group-modal").on('click',function(){
            $("#myModal").modal({backdrop: 'static', keyboard: false})
        });

        $(".commit-add").on('click',function () {
            var data = $("input[name=group_add]").val();
            if(!data){
                layer.msg('请输入组名',{time:1000});
                return false;
            }
            var code = pinyin.getCamelChars(data);
            $.post('/?ct=system&ac=addGroup',{
                data:data,
                code:code
            },function(e){
                if(e.state == 1){
                    layer.msg('添加成功',{time:1000});
                    $('#myModal').modal('hide');
                    var data = e.data;
                    var htm = '<option value="'+data.code+'" selected="selected">'+data.name+'</option>';
                    $(".adio-group").append(htm);
                    $("input[name=group_add]").val('');
                }else{
                    layer.msg('添加失败',{time:1000});
                }
            },'json')
        });

        $("#submit").on('click',function(){
            var data = $("#myForm").serialize();
            if(typeof data == 'undefined' || !data){
                layer.msg('提交失败',{time:200});
                return false;
            }
            var tdata = getTransData();
            if($.isEmptyObject(JSON.parse(tdata))){
                layer.msg('请勾选媒体账号至右表',{time:1000});
                return false;
            }
            var que = {
                data:data,
                tdata:tdata
            };
            if(!$("input[name=email]").val()){
                layer.msg('请填写邮箱账号',{time:1000});
                return false;
            }
            if(!$("input[name='adio_role']:checked").val()){
                layer.msg('请勾选账号角色',{time:1000});
                return false;
            }
            var index = parent.layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=system&ac=adioAddAction',que, function (re) {
                parent.layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=system&ac=adioManage';
                        }
                    }
                });
            }, 'json');
        })
    })
</script>
<{include file="../public/footer.tpl"}>