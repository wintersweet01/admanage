<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="user_id" value="<{$data.user_id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改推广链扣量</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">游戏</label>
                    <div class="col-lg-6 col-sm-9">
                        <{widgets widgets=$widgets}>
                    </div>
                </div>

                <div class="form-group">
                    <label for="width" class="col-sm-2 control-label">渠道</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="channel_id">
                            <option value="">选择渠道</option>
                            <{foreach from=$_channels key=key item=name}>
                        <option value="<{$key}>" <{if $data['info']['channel_id']==$key}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_id" class="col-sm-2 control-label">负责人</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="create_user" class="form-control" style="width:60px;">
                            <option value="">选择负责人</option>
                            <{foreach from=$_admins key=id item=name}>
                        <option value="<{$id}>" <{if $data.create_user==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="width" class="col-sm-2 control-label">* 推广活动</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="monitor_id" id="monitor_id">
                            <{if $data.monitor_id}>
                            <option value="<{$data.monitor_id}>" selected><{$data.monitor_name}></option>
                            <{else}>
                            <option value="0">选择推广活动</option>
                            <{/if}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_name" class="col-sm-2 control-label">* 投放日期</label>
                    <div class="col-lg-6 col-sm-9">
                        <input type="text" name="open_sdate" value="<{$data.open_sdate}>" class="Wdate"/> -
                        <input type="text" name="open_edate" value="<{$data.open_edate}>" class="Wdate"/>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" name="is_open" value="0"<{if $data.is_open == 0}> checked<{/if}>>关</label>
                            <label class="radio-inline"><input type="radio" name="is_open" value="1"<{if $data.is_open == 1}> checked<{/if}>>开</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sign_key" class="col-sm-2 control-label">* 折扣</label>
                    <div class="col-lg-6 col-sm-9">
                        <div style="float: left;margin-right: 5px;">
                            充值：
                            <div class="input-group" style="width: 110px;">
                                <input type="text" class="form-control" name="discount_pay" value="<{$data.discount_pay}>">
                                <div class="input-group-addon">%</div>
                            </div>
                        </div>
                        <div>
                            注册：
                            <div class="input-group" style="width: 110px;">
                                <input type="text" class="form-control" name="discount_reg" value="<{$data.discount_reg}>">
                                <div class="input-group-addon">%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_name" class="col-sm-2 control-label">* 折扣日期</label>
                    <div class="col-lg-6 col-sm-9">
                        <input type="text" name="discount_sdate" value="<{$data.discount_sdate}>" class="Wdate"/> -
                        <input type="text" name="discount_edate" value="<{$data.discount_edate}>" class="Wdate"/>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" name="is_discount" value="0"<{if $data.is_discount == 0}> checked<{/if}>>关</label>
                            <label class="radio-inline"><input type="radio" name="is_discount" value="1"<{if $data.is_discount == 1}> checked<{/if}>>开</label>
                        </div>
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
        $('select[name=game_id],select[name=channel_id],select[name=create_user]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            var create_user = $('select[name=create_user] option:selected').val();

            $.getJSON('?ct=ad&ac=getAllMonitor&game_id=' + game_id + '&channel_id=' + channel_id + '&create_user=' + create_user, function (re) {
                var html = '<option value="0">选择推广活动</option>';
                $.each(re, function (i, n) {
                    html += '<option value=' + i + '>' + n + '</option>';
                });
                $('select[name="monitor_id"]').html(html);
            });
        });

        //日期
        $('.Wdate').off('click').on('click', function () {
            WdatePicker({
                el: this,
                dateFmt: "yyyy-MM-dd",
                readOnly: true
            });
        });

        $('#submit').on('click', function () {
            var data = $('form').serialize();
            $.post('?ct=extend&ac=linkDiscountAdd',{data:data}, function (re) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=extend&ac=linkDiscount';
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
