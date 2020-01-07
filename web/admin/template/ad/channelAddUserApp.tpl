<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="id" value="<{$id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>创建数据源</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">* 应用ID</label>
                    <div class="col-lg-3 col-sm-9">
                        <input type="text" class="form-control" name="client_id" placeholder="腾讯社交广告的应用ID" value="<{$client_id}>" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="desc" class="col-sm-2 control-label">* 账号ID</label>
                    <div class="col-lg-3 col-sm-9">
                        <input type="text" class="form-control" name="account_id" placeholder="广告主账号ID" value="<{$account_id}>" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label for="open_third" class="col-sm-2 control-label">* 应用类型</label>
                    <div class="col-lg-3 col-sm-9">
                        <select name="type">
                            <option value="ANDROID" selected="selected">ANDROID</option>
                            <option value="IOS">IOS</option>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="desc" class="col-sm-2 control-label">* MOBILE_APP_ID</label>
                    <div class="col-lg-3 col-sm-9">
                        <input type="text" class="form-control" name="mobile_app_id" placeholder="应用id，IOS：App Store id；ANDROID：应用宝id" value="<{$data['info']['desc']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">数据源描述</label>
                    <div class="col-sm-3">
                        <textarea name="description" rows="10" class="form-control" placeholder="最多可以填写40个字"><{$data['description']}></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-lg-3 col-sm-9">
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
            layer.load();
            $.post('?ct=ad&ac=channelAddUserApp', $('form').serializeArray(), function (re) {
                layer.closeAll();
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=ad&ac=channelUserAppList&id=<{$id}>';
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