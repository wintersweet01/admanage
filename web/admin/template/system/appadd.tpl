<{include file="../public/header.tpl"}>
<style>
    .input-width {
        width: 200px;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="appid" value="<{$data.appid}>"/>
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back" class="text-blue">返 回</a></li>
                        <li class="active"><u>添加/修改应用</u></li>
                    </ol>
                </div>
                <div class="form-group">
                    <label for="app_name" class="col-sm-2 control-label"><em class="text-red">*</em> 应用名称</label>
                    <div class="col-sm-5">
                        <input type="text" name="app_name" value="<{$data.app_name}>" class="form-control input-width">
                    </div>
                </div>
                <div class="form-group">
                    <label for="app_code" class="col-sm-2 control-label"><em class="text-red">*</em> 应用编码<i class="fa fa-question-circle"
                                                                                  alt="(每个应用在系统中对应的唯一识别码，由6位数字和字母组成（填写应用名称后，自动生成的）)"></i>：</label>
                    <div class="col-sm-5">
                        <input type="text" name="app_code" value="<{$data.app_code}>" class="form-control input-width"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="device_type" class="col-sm-2 control-label"><em class="text-red">*</em> 平台：</label>
                    <div class="col-sm-5">
                        <select name="device_type">
                            <option value="0" <{if $data.device_type eq 0}>selected="selected"<{/if}> >不限</option>
                            <option value="1" <{if $data.device_type eq 1}>selected="seleted"<{/if}> >IOS</option>
                            <option value="2" <{if $data.device_type eq 2}>selected="seleted"<{/if}> >安卓</option>
                        </select>
                    </div>
                </div>
                <{if $data.appid}>
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
                    <label for="media_account" class="col-sm-2 control-label"><em class="text-red">*</em> 媒体账号：</label>
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
<script src="<{$smarty.const.SYS_STATIC_URL}>/js/ping_uf.js?v=2019021820"></script>
<script>
    $(function () {

        $("input[name=app_name]").blur(function(){
            var name = $(this).val();
            if(name) {
                var code = pinyin.getCamelChars(name);
                code += Math.round(Math.random() * 10);
                $("input[name=app_code]").val(code);
            }
        });

        $('#submit').on('click', function () {
            var tdata = getTransData();
            var data = $('form').serialize();
            if($.isEmptyObject(JSON.parse(tdata))){
                layer.msg('请勾选媒体账号至右表',{time:1000});
                return false;
            }
            $.post('?ct=system&ac=appAddAction',{data:data,tdata:tdata}, function (re) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=system&ac=appManage';
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });

    });
</script>
<{include file="../public/foot.tpl"}>
