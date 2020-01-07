<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="company_id" value="<{$data.company_id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加广告资质公司</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="company_name" class="col-sm-2 control-label">* 公司名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="company_name" value="<{$data['info']['company_name']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="record_no" class="col-sm-2 control-label">备案号</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="record_no" value="<{$data['info']['record_no']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="domain" class="col-sm-2 control-label">域名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="domain" value="<{$data['info']['domain']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="www" class="col-sm-2 control-label">文网文</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="www" value="<{$data['info']['www']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="icp" class="col-sm-2 control-label">增值电信业务经营许可证</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="icp" value="<{$data['info']['icp']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="service_tel" class="col-sm-2 control-label">客服电话</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="service_tel" value="<{$data['info']['service_tel']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="service_tel" class="col-sm-2 control-label">地址</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="address" value="<{$data['info']['address']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-lg-6 col-sm-9">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#submit').on('click', function () {
            var data = $('form').serialize();
            $.post('?ct=ad&ac=addAdCompanyAction',{data:data}, function (re) {
                if (re.state == true) {
                    location.href = '?ct=ad&ac=adCompany';
                } else {
                    layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        shadeClose: true,
                        content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                        time: 3000,
                        end: function () {

                        }
                    });
                }

            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });

    });
</script>
<{include file="../public/foot.tpl"}>
