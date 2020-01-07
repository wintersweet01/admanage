<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="game_id" value="<{$data.game_id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加游戏</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">母游戏</label>
                    <div class="col-lg-5 col-sm-9">
                        <{widgets widgets=$widgets}>
                        <span class="help-block red">如果“选择子游戏”，当前添加的游戏将自动继承该子游戏的对接参数。</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">平台类型</label>
                    <div class="col-lg-5 col-sm-9">
                        <label class="checkbox-inline">
                            <input type="radio" name="device_type" <{if $device_type eq 1 }>checked="checked"<{/if}> style="position: relative;top: 2px;" value="1"/>IOS
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="device_type" <{if $device_type eq 2 }>checked="checked"<{/if}> style="position: relative;top: 2px;" value="2"/>安卓
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="device_type" <{if $device_type eq 3}>checked="checked"<{/if}> style="position: relative;top: 2px" value="3" />html5
                        </label>
                        <label></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">* 游戏名称</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="name" placeholder="由中文、英文字母、数字、下划线和减号组成" value="<{$data['info']['name']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="alias" class="col-sm-2 control-label">* 游戏别名</label>
                    <div class="col-lg-5 col-sm-9">
                        <input type="text" class="form-control" name="alias" placeholder="由英文字母、数字和减号组成的小写字符串，如：test-88" value="<{$data['info']['alias']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="icon" class="col-sm-2 control-label">游戏图片</label>
                    <div class="col-sm-6">
                        <div style="float: left;margin-right: 10px;">
                            Icon：
                            <div id="picker1">请选择icon</div>
                            <div id="thelist1" class="uploader-list help-block"></div>
                            <span class="help-block">尺寸：32*32，大小：<100KB</span>
                            <div id="thumbnail1" class="col-xs-6 col-md-4" style="padding-left: 0px;">
                                <{if $data.info.icon}>
                                <div class="thumbnai1"><img src="uploads/<{$data.info.icon}>"/></div>
                                <{/if}>
                            </div>
                            <input type="hidden" name="icon" id="icon" value="<{$data.info.icon}>"/>
                        </div>
                        <div style="float: left;">
                            Logo：
                            <div id="picker2">请选择logo</div>
                            <div id="thelist2" class="uploader-list help-block"></div>
                            <span class="help-block">尺寸：100*100，大小：<100KB</span>
                            <div id="thumbnail2" class="col-xs-6 col-md-4" style="padding-left: 0px;">
                                <{if $data.info.logo}>
                                <div class="thumbnai2"><img src="uploads/<{$data.info.logo}>"/></div>
                                <{/if}>
                            </div>
                            <input type="hidden" name="logo" id="logo" value="<{$data.info.logo}>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group inherit"
                <{if $data['info']['config']['inherit']}>style="display: none;"<{/if}>>
                <label for="client_url" class="col-sm-2 control-label">充值地址</label>
                <div class="col-lg-5 col-sm-9">
                    <div class="input-group">
                        <div class="input-group-addon">* 正式服：</div>
                        <input type="text" class="form-control" name="config[pay_url][main]" placeholder="游戏充值回调地址" value="<{$data['info']['config']['pay_url']['main']}>">
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">测试服：</div>
                        <input type="text" class="form-control" name="config[pay_url][test]" placeholder="游戏充值回调地址" value="<{$data['info']['config']['pay_url']['test']}>">
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">IOS提审服[内购版]：</div>
                        <input type="text" class="form-control" name="config[pay_url][ios]" placeholder="游戏充值回调地址[内购版]" value="<{$data['info']['config']['pay_url']['ios']}>">
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">IOS提审服[免费版]：</div>
                        <input type="text" class="form-control" name="config[pay_url][noios]" placeholder="游戏充值回调地址[免费版]" value="<{$data['info']['config']['pay_url']['noios']}>">
                    </div>

                </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-2 control-label">客服中心 <i class="fa fa-question-circle" alt="每个游戏单独设置"></i></label>
            <div class="col-lg-5 col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon">客服QQ：</span>
                    <input type="text" class="form-control" name="config[kefu][qq]" value="<{$data['info']['config']['kefu']['qq']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">QQ群号：</span>
                    <input type="text" class="form-control" name="config[kefu][group]" value="<{$data['info']['config']['kefu']['group']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">客服邮箱：</span>
                    <input type="text" class="form-control" name="config[kefu][mail]" value="<{$data['info']['config']['kefu']['mail']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">客服电话：</span>
                    <input type="text" class="form-control" name="config[kefu][phone]" value="<{$data['info']['config']['kefu']['phone']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">微信公众号：</span>
                    <input type="text" class="form-control" name="config[kefu][weixin]" value="<{$data['info']['config']['kefu']['weixin']}>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-2 control-label">VIP客服
                <i class="fa fa-question-circle" alt="每个游戏单独设置，达到指定金额才显示"></i></label>
            <div class="col-lg-5 col-sm-9">
                <div class="input-group col-lg-8 col-sm-8">
                    <span class="input-group-addon">充值条件：</span>
                    <input type="text" class="form-control" name="config[vip][money]" value="<{$data['info']['config']['vip']['money']}>">
                    <span class="input-group-addon">元</span>
                </div>
                <span class="help-block">玩家累计充值达到该金额后才显示VIP客服</span>
                <div class="input-group">
                    <span class="input-group-addon">客服QQ：</span>
                    <input type="text" class="form-control" name="config[vip][qq]" value="<{$data['info']['config']['vip']['qq']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">QQ群号：</span>
                    <input type="text" class="form-control" name="config[vip][group]" value="<{$data['info']['config']['vip']['group']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">客服邮箱：</span>
                    <input type="text" class="form-control" name="config[vip][mail]" value="<{$data['info']['config']['vip']['mail']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">客服电话：</span>
                    <input type="text" class="form-control" name="config[vip][phone]" value="<{$data['info']['config']['vip']['phone']}>">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">微信公众号：</span>
                    <input type="text" class="form-control" name="config[vip][weixin]" value="<{$data['info']['config']['vip']['weixin']}>">
                </div>
            </div>
        </div>

        <div class="form-group inherit"
        <{if $data['info']['config']['inherit']}>style="display: none;"<{/if}>>
        <label for="status" class="col-sm-2 control-label">是否H5游戏</label>
        <div class="col-lg-5 col-sm-9">
            <div class="checkbox">
                <label><input type="checkbox" name="config[h5]" id="h5" value="1" <{if $data['info']['config']['h5'] == 1}>checked="checked"<{/if}>></label>
            </div>
        </div>
    </div>

    <div class="form-group inherit" id="h5_login"
    <{if $data['info']['config']['h5'] != 1 || $data['info']['config']['inherit']}>style="display: none;"<{/if}>>
    <label for="client_url" class="col-sm-2 control-label">登录地址
        <i class="fa fa-question-circle" alt="仅H5游戏有效"></i></label>
    <div class="col-lg-5 col-sm-9">
        <div class="input-group">
            <div class="input-group-addon">* 正式服：</div>
            <input type="text" class="form-control" name="config[login_url][main]" placeholder="游戏入口地址" value="<{$data['info']['config']['login_url']['main']}>">
        </div>
        <div class="input-group">
            <div class="input-group-addon">测试服：</div>
            <input type="text" class="form-control" name="config[login_url][test]" placeholder="游戏入口地址" value="<{$data['info']['config']['login_url']['test']}>">
        </div>
        <div class="input-group">
            <div class="input-group-addon">IOS提审服[内购版]：</div>
            <input type="text" class="form-control" name="config[login_url][ios]" placeholder="游戏入口地址[内购版]" value="<{$data['info']['config']['login_url']['ios']}>">
        </div>
        <div class="input-group">
            <div class="input-group-addon">IOS提审服[免费版]：</div>
            <input type="text" class="form-control" name="config[login_url][noios]" placeholder="游戏入口地址[免费版]" value="<{$data['info']['config']['login_url']['noios']}>">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="status" class="col-sm-2 control-label">是否聚合SDK
        <i class="fa fa-question-circle" alt="仅Android使用"></i></label>
    <div class="col-lg-5 col-sm-9">
        <div class="checkbox">
            <label><input type="checkbox" name="config[is_combine]" id="combine" value="1" <{if $data['info']['config']['is_combine'] == 1}>checked="checked"<{/if}>></label>
        </div>
    </div>
</div>
<div class="form-group" id="combine_switch" <{if $data['info']['config']['is_combine'] != 1}>style="display: none;"<{/if}>>
<label for="client_url" class="col-sm-2 control-label">切换</label>
<div class="col-lg-5 col-sm-9" style="background-color: #FF9999;">
    <div class="form-group">
        <label class="col-sm-2 control-label">登录：</label>
        <label class="radio-inline"><input type="radio" name="config[combine][login]" value="1" <{if $data['info']['config']['combine']['login'] == 1}>checked="checked"<{/if}>> 平台</label>
        <label class="radio-inline"><input type="radio" name="config[combine][login]" value="0" <{if $data['info']['config']['combine']['login'] == 0}>checked="checked"<{/if}>> 第三方</label>
        <div id="combine_login"
        <{if $data['info']['config']['combine']['login'] == 1}>style="display: none;"<{/if}>>
        <label class="col-sm-4 control-label">登录比例：<i class="fa fa-question-circle" alt="仅大于0时生效，按比例登录第三方，否则全部为第三方登录"></i></label>
        <div class="col-lg-4 col-sm-3">
            <div class="input-group" style="width: 100px;">
                <input type="text" class="form-control" name="config[combine][login_ratio]" value="<{$data['info']['config']['combine']['login_ratio']}>">
                <div class="input-group-addon">%</div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">支付：</label>
    <label class="radio-inline"><input type="radio" name="config[combine][pay]" value="1" <{if $data['info']['config']['combine']['pay'] == 1}>checked="checked"<{/if}>> 平台</label>
    <label class="radio-inline"><input type="radio" name="config[combine][pay]" value="0" <{if $data['info']['config']['combine']['pay'] == 0}>checked="checked"<{/if}>> 第三方</label>
    <div class="combine_pay"
    <{if $data['info']['config']['combine']['pay'] == 1}> style="display: none;"<{/if}> >
    <div style="padding: 15px;">
        <label class="col-sm-4 control-label">游戏币兑换比例：<i class="fa fa-question-circle" alt="该参数为第三方游戏币兑换比例，与第三方后台设定一致。默认：1:10"></i></label>
        <label class="radio-inline"><input type="radio" name="config[combine][ratio]" value="1" <{if $data['info']['config']['combine']['ratio'] == 1}>checked="checked"<{/if}>> 1元=1游戏币</label>
        <label class="radio-inline"><input type="radio" name="config[combine][ratio]" value="10" <{if $data['info']['config']['combine']['ratio'] == 10}>checked="checked"<{/if}>> 1元=10游戏币</label>
        <label class="radio-inline"><input type="radio" name="config[combine][ratio]" value="100" <{if $data['info']['config']['combine']['ratio'] == 100}>checked="checked"<{/if}>> 1元=100游戏币</label>
    </div>
    <div style="padding: 15px;">
        <label class="col-sm-4 control-label">自动切为平台：<i class="fa fa-question-circle" alt="“玩家”达到设置值自动切换为平台支付。都不填则全部为第三方支付；两个都填且同时达到条件才生效。"></i></label>
        <div class="col-sm-3" style="width: 100px;">
            充值次数：<input type="text" class="form-control" name="config[combine][pay_num]" value="<{$data['info']['config']['combine']['pay_num']}>">
        </div>
        <div class="col-sm-3" style="width: 136px;">
            充值总额：
            <div class="input-group">
                <input type="text" class="form-control" name="config[combine][pay_money]" value="<{$data['info']['config']['combine']['pay_money']}>">
                <div class="input-group-addon">元</div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<div class="form-group">
    <label for="status" class="col-sm-2 control-label">* 支付总开关
        <i class="fa fa-question-circle" alt="分包单独设置优先；如果设置自动切换支付条件，至少要选择一个平台支付方式"></i></label>
    <div class="col-lg-5 col-sm-9" style="background-color: #99FFFF;">
        <div class="form-group">
            <div class="col-sm-2">
                <label class="control-label">ios：</label>
            </div>
            <div class="col-sm-10">
                <{foreach from=$_pay_types key=k item=v}>
                <label class="checkbox-inline" style="vertical-align: top;">
                    <input type="checkbox" name="config[pay_mode][ios][]" value="<{$k}>" <{if $k|in_array:$data['info']['config']['pay_mode']['ios']}>checked="checked"<{/if}>> <{$v}>
                    <{if $k != 1}>
                    <div class="input-group" style="width: 100px;">
                        <input type="text" class="form-control" name="config[discount][ios][<{$k}>]" value="<{$data['info']['config']['discount']['ios'][$k]}>" placeholder="折扣">
                        <div class="input-group-addon">%</div>
                    </div>
                    <{/if}>
                </label>
                <{/foreach}>
                <div id="ios_pay_mode"
                <{if !('1'|in_array:$data['info']['config']['pay_mode']['ios'])}>style="display: none;"<{/if}>>
                <label class="col-sm-4 control-label">自动切为平台：<i class="fa fa-question-circle" alt="“玩家”达到设置值自动切换为平台支付。都不填则为appstore支付；两个都填且同时达到条件才生效。"></i></label>
                <div class="col-lg-5 col-sm-3" style="width: 100px;">
                    充值次数：<input type="text" class="form-control" name="config[pay_mode][pay_num]" value="<{$data['info']['config']['pay_mode']['pay_num']}>">
                </div>
                <div class="col-lg-4 col-sm-3">
                    充值总额：
                    <div class="input-group" style="width: 108px;">
                        <input type="text" class="form-control" name="config[pay_mode][pay_money]" value="<{$data['info']['config']['pay_mode']['pay_money']}>">
                        <div class="input-group-addon">元</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2">
            <label class="control-label">android：</label>
        </div>
        <div class="col-sm-10">
            <{foreach from=$_pay_types key=k item=v}>
            <{if $k == 1}>
            <{continue}>
            <{/if}>
            <label class="checkbox-inline">
                <input type="checkbox" name="config[pay_mode][android][]" value="<{$k}>" <{if $k|in_array:$data['info']['config']['pay_mode']['android']}>checked="checked"<{/if}>> <{$v}>
                <div class="input-group" style="width: 100px;">
                    <input type="text" class="form-control" name="config[discount][android][<{$k}>]" value="<{$data['info']['config']['discount']['android'][$k]}>" placeholder="折扣">
                    <div class="input-group-addon">%</div>
                </div>
            </label>
            <{/foreach}>
        </div>
    </div>
</div>
</div>

<div class="form-group">
    <label for="status" class="col-sm-2 control-label">* 当前游戏状态</label>
    <div class="col-lg-5 col-sm-9" style="background-color: #FFFFBB;">
        <div class="form-group">
            <label class="col-sm-2 control-label">ios：</label>
            <label class="radio-inline"><input type="radio" name="config[status][ios]" value="1" <{if $data['info']['config']['status']['ios'] == 1}>checked="checked"<{/if}>> 正常</label>
            <label class="radio-inline"><input type="radio" name="config[status][ios]" value="2" <{if $data['info']['config']['status']['ios'] == 2}>checked="checked"<{/if}>> 测试</label>
            <label class="radio-inline"><input type="radio" name="config[status][ios]" value="3" <{if $data['info']['config']['status']['ios'] == 3}>checked="checked"<{/if}>> 提审[内购版]</label>
            <label class="radio-inline"><input type="radio" name="config[status][ios]" value="4" <{if $data['info']['config']['status']['ios'] == 4}>checked="checked"<{/if}>> 提审[免费版]</label>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">android：</label>
            <label class="radio-inline"><input type="radio" name="config[status][android]" value="1" <{if $data['info']['config']['status']['android'] == 1}>checked="checked"<{/if}>> 正常</label>
            <label class="radio-inline"><input type="radio" name="config[status][android]" value="2" <{if $data['info']['config']['status']['android'] == 2}>checked="checked"<{/if}>> 测试</label>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="status" class="col-sm-2 control-label">* 安卓分包签名</label>
    <div class="col-lg-5 col-sm-9">
        <select name="config[signature]" <{if $data['info']['config']['signature']}>disabled<{/if}>>
        <{foreach $_signature as $k => $v}>
    <option value="<{$k}>" <{if $data['info']['config']['signature'] == $k}>selected<{/if}>><{$v.name}></option>
        <{/foreach}>
        </select>
        <span class="red">谨慎选择，选错将导致安装失败，IOS可忽略</span>
    </div>
</div>

<div class="form-group">
    <label for="status" class="col-sm-2 control-label">* 是否运营</label>
    <div class="col-lg-5 col-sm-9">
        <label class="radio-inline">
            <input type="radio" name="status" value="0" <{if $data['info']['status'] == 0}>checked="checked"<{/if}>> 正常运营
        </label>
        <label class="radio-inline">
            <input type="radio" name="status" value="1" <{if $data['info']['status'] == 1}>checked="checked"<{/if}>> 关闭
        </label>
    </div>
</div>

<div class="form-group">
    <label for="status" class="col-sm-2 control-label">* 实名认证开关</label>
    <div class="col-lg-5 col-sm-9">
        <label class="radio-inline">
            <input type="radio" name="config[is_adult]" value="1" <{if $data['info']['config']['is_adult'] == 1}>checked="checked"<{/if}>> 关
        </label>
        <label class="radio-inline">
            <input type="radio" name="config[is_adult]" value="2" <{if $data['info']['config']['is_adult'] == 2}>checked="checked"<{/if}>> 开
        </label>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-lg-5 col-sm-9">
        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
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
        var param = {
            'url': '/?ct=Upload&ac=uploadAdmin',
            'dom': '#picker1',
            'list': '#thelist1',
            'auto': true,
            'type': 'img',
            'size': 102400 //限制大小，单位为字节，100KB
        };
        var uploader1 = cwUpload.create(param, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = 'uploads/' + result.url;
                    if (result.state) {
                        var img = $('#thumbnail1').find('.thumbnail img');
                        if (!img.length) {
                            img = $('<div class="thumbnail"><img src="' + url + '"></div>').appendTo($('#thumbnail1'));
                        } else {
                            img.attr('src', url);
                        }

                        $('#icon').val(result.url);
                    } else {
                        $('#icon').val('');
                    }
                    break;
            }
        });

        var param = {
            'url': '/?ct=Upload&ac=uploadAdmin',
            'dom': '#picker2',
            'list': '#thelist2',
            'auto': true,
            'type': 'img',
            'size': 102400 //限制大小，单位为字节，100KB
        };
        var uploader2 = cwUpload.create(param, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = 'uploads/' + result.url;
                    if (result.state) {
                        var img = $('#thumbnail2').find('.thumbnail img');
                        if (!img.length) {
                            img = $('<div class="thumbnail"><img src="' + url + '"></div>').appendTo($('#thumbnail2'));
                        } else {
                            img.attr('src', url);
                        }

                        $('#logo').val(result.url);
                    } else {
                        $('#logo').val('');
                    }
                    break;
            }
        });

        $('#h5').click(function () {
            if ($(this).prop("checked")) {
                $('#h5_login').show();
            } else {
                $('#h5_login').hide();
            }
        });

        $('#combine').click(function () {
            if ($(this).prop("checked")) {
                $('#combine_switch').show();
            } else {
                $('#combine_switch').hide();
            }
        });

        //子游戏事件
        $('select[name="children_id"]').on('change', function () {
            var id = $(this).find('option:selected').val();
            if (id > 0) {
                $('.inherit').hide();
            } else {
                $('.inherit').show();
            }
        });

        //第三方登录比例
        $('input[name="config[combine][login]"]').on('click', function () {
            var id = $(this).val();
            if (id > 0) {
                $('#combine_login').hide();
            } else {
                $('#combine_login').show();
            }
        });

        //支付切换条件
        $('input[name="config[combine][pay]"]').on('click', function () {
            var id = $(this).val();
            if (id > 0) {
                $('.combine_pay').hide();
            } else {
                $('.combine_pay').show();
            }
        });

        //IOS支付切换条件
        $('input[name="config[pay_mode][ios][]').on('click', function () {
            var v = $(this).val();
            if (v == 1) {
                $(this).prop("checked", function (i, val) {
                    if (val) {
                        $('#ios_pay_mode').show();
                    } else {
                        $('#ios_pay_mode').hide();
                    }
                });
            }
        });

        $('#submit').on('click', function () {
            var data = $('form').serialize();
            var index = layer.msg('保存中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.post('?ct=platform&ac=addGameAction',{data:data}, function (re) {
                layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=platform&ac=gameList';
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