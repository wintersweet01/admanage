<{include file="../public/header-bootstrap.tpl"}>
<div class="container-fluid" style="padding: 2rem;">
    <form class="needs-validation" method="post" action="" novalidate>
        <input type="hidden" name="game_id" value="<{$data['game_id']}>"/>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏属性</label>
            <div class="col-sm-10">
                <{if !$data['parent_id']}>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type0" name="type" value="0"
                    <{if $data['type'] == 0}>checked="checked"<{/if}> >
                    <label class="custom-control-label" for="type0">母游戏/目录</label>
                </div>
                <{/if}>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type1" name="type" value="1"
                    <{if $data['type'] == 1}>checked="checked"<{/if}> >
                    <label class="custom-control-label" for="type1">买量投放</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type2" name="type" value="2"
                    <{if $data['type'] == 2}>checked="checked"<{/if}> >
                    <label class="custom-control-label" for="type2">渠道分发</label>
                </div>
            </div>
        </div>

        <div class="form-group row type0"
        <{if $data['type'] == 0}>style="display: none;"<{/if}> >
        <label for="device_type" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏类型</label>
        <div class="col-sm-10">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="device_type1" name="device_type" value="1"
                <{if $data['device_type'] == 1}>checked="checked"<{/if}> >
                <label class="custom-control-label" for="device_type1">ios</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="device_type2" name="device_type" value="2"
                <{if $data['device_type'] == 2}>checked="checked"<{/if}> >
                <label class="custom-control-label" for="device_type2">android</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="device_type3" name="device_type" value="3"
                <{if $data['device_type'] == 3}>checked="checked"<{/if}> >
                <label class="custom-control-label" for="device_type3">html5</label>
            </div>
        </div>
</div>

<div class="form-group row type0" <{if $data['type'] == 0}>style="display: none;"<{/if}> >
<label class="col-sm-2 col-form-label text-md-right text-sm-left">母游戏</label>
<div class="col-sm-10">
    <{widgets widgets=$widgets}>
    <small class="form-text text-danger">如果“选择子游戏”，当前添加的游戏将自动继承该子游戏的对接参数。</small>
</div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label text-md-right text-sm-left">游戏名称</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="由中文、英文字母、数字、下划线和减号组成" value="<{$data['name']}>" required>
    </div>
</div>

<div class="form-group row">
    <label for="alias" class="col-sm-2 col-form-label text-md-right text-sm-left">游戏标识</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="alias" placeholder="由英文字母、数字和减号组成的小写字符串，如：test-88，不能重复" value="<{$data['alias']}>" required>
    </div>
</div>

<fieldset class="form-group type0 inherit" id="h5_login"
<{if $data['device_type'] != 3 || $data['config']['inherit'] || $data['type'] == 0}>style="display: none;"<{/if}>>
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">H5登录地址</legend>
    <div class="col-sm-10">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">正式服：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][main]" placeholder="游戏入口地址[正式服]" value="<{$data['config']['login_url']['main']}>">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">测试服：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][test]" placeholder="游戏入口地址[测试服]" value="<{$data['config']['login_url']['test']}>">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">IOS提审服[内购版]：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][ios]" placeholder="游戏入口地址[内购版]" value="<{$data['config']['login_url']['ios']}>">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">IOS提审服[免费版]：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][noios]" placeholder="游戏入口地址[免费版]" value="<{$data['config']['login_url']['noios']}>">
        </div>
    </div>
</div>
</fieldset>

<fieldset class="form-group type0 inherit" <{if $data['config']['inherit'] || $data['type'] == 0}>style="display: none;"<{/if}> >
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">充值地址</legend>
    <div class="col-sm-10">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">正式服：</span>
            </div>
            <input type="text" class="form-control" name="config[pay_url][main]" placeholder="游戏充值回调地址[正式服]" value="<{$data['config']['pay_url']['main']}>">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">测试服：</span>
            </div>
            <input type="text" class="form-control" name="config[pay_url][test]" placeholder="游戏充值回调地址[测试服]" value="<{$data['config']['pay_url']['test']}>">
        </div>
        <div class="input-group mb-1 ios-show"
        <{if $data['device_type'] != 1}>style="display: none;"<{/if}> >
        <div class="input-group-prepend">
            <span class="input-group-text">IOS提审服[内购版]：</span>
        </div>
        <input type="text" class="form-control" name="config[pay_url][ios]" placeholder="游戏充值回调地址[内购版]" value="<{$data['config']['pay_url']['ios']}>">
    </div>
    <div class="input-group mb-1 ios-show"
    <{if $data['device_type'] != 1}>style="display: none;"<{/if}> >
    <div class="input-group-prepend">
        <span class="input-group-text">IOS提审服[免费版]：</span>
    </div>
    <input type="text" class="form-control" name="config[pay_url][noios]" placeholder="游戏充值回调地址[免费版]" value="<{$data['config']['pay_url']['noios']}>">
</div>
</div>
</div>
</fieldset>

<fieldset class="form-group type0 type2" <{if $data['type']|in_array:[0,2]}>style="display: none;"<{/if}> >
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">客服中心
        <button type="button" class="btn btn-warning btn-sm" id="kefu-copy"
        <{if !$data['config']['inherit']}>style="display: none;"<{/if}> >复制继承</button>
    </legend>
    <div class="col-sm-10">

        <div class="card-deck">
            <div class="card bg-light">
                <div class="card-header">公共信息

                </div>
                <div class="card-body">
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服QQ</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][qq]" value="<{$data['config']['kefu']['qq']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">QQ群号</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][group]" value="<{$data['config']['kefu']['group']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服邮箱</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][mail]" value="<{$data['config']['kefu']['mail']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服电话</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][phone]" value="<{$data['config']['kefu']['phone']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">微信公众号</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][weixin]" value="<{$data['config']['kefu']['weixin']}>">
                    </div>
                </div>
            </div>
            <div class="card bg-light">
                <div class="card-header">VIP信息</div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">充值条件</span>
                            </div>
                            <input type="text" class="form-control" name="config[vip][money]" value="<{$data['config']['vip']['money']}>">
                            <div class="input-group-append">
                                <span class="input-group-text">元</span>
                            </div>
                        </div>
                        <small class="form-text text-danger">玩家累计充值达到该金额后才显示VIP客服信息</small>
                    </div>

                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服QQ</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][qq]" value="<{$data['config']['vip']['qq']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">QQ群号</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][group]" value="<{$data['config']['vip']['group']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服邮箱</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][mail]" value="<{$data['config']['vip']['mail']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服电话</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][phone]" value="<{$data['config']['vip']['phone']}>">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">微信公众号</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][weixin]" value="<{$data['config']['vip']['weixin']}>">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</fieldset>

<fieldset class="form-group type0 type2" <{if $data['type']|in_array:[0,2]}>style="display: none;"<{/if}>>
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">支付方式</legend>
    <div class="col-sm-10">
        <div class="form-row" id="pay-mode-ios"
        <{if $data['device_type'] != 1}>style="display: none;"<{/if}>>
        <{foreach $_pay_types as $k => $v}>
        <div class="col-sm-12 col-md-6">
            <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" name="config[pay_mode][ios][]" value="<{$k}>"
                        <{if $k|in_array:$data['config']['pay_mode']['ios']}>
                        checked="checked"
                        <{/if}> >
                    </div>
                    <span class="input-group-text"><{$v}></span>
                </div>
                <{if $k != 1}>
            <input type="text" class="form-control" placeholder="折扣" name="config[discount][ios][<{$k}>]" value="<{$data['config']['discount']['ios'][$k]}>">
                <div class="input-group-append">
                    <span class="input-group-text">%</span>
                </div>
                <{/if}>
            </div>
        </div>
        <{if $k == 1}>
        <div id="ios_pay_mode" class="col-sm-12 col-md-12"
        <{if !('1'|in_array:$data['config']['pay_mode']['ios'])}>style="display: none;"<{/if}>>
        <label class="col-form-label">自动切换为平台：</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend"><span class="input-group-text">次数</span>
            </div>
            <input type="text" class="form-control" name="config[pay_mode][pay_num]" value="<{$data['config']['pay_mode']['pay_num']}>">
            <div class="input-group-prepend"><span class="input-group-text">金额</span>
            </div>
            <input type="text" class="form-control" name="config[pay_mode][pay_money]" value="<{$data['config']['pay_mode']['pay_money']}>">
            <div class="input-group-append"><span class="input-group-text">元</span>
            </div>
        </div>
        <small class="form-text text-danger">
            “玩家”达到设置值自动切换为平台支付。都不填则为appstore支付；只要一个达到条件即可生效。
        </small>
    </div>
    <{/if}>
    <{/foreach}>
    <div class="col-sm-12 col-md-12">
        <div class="custom-control custom-switch custom-control-inline on-off">
            <input type="checkbox" id="config_usa" name="config[pay_mode][usa]" class="custom-control-input" value="1"
            <{if $data['config']['pay_mode']['usa'] == 1}>checked<{/if}>>
            <label class="custom-control-label text-danger" for="config_usa">美国IP固定为苹果支付</label>
        </div>
    </div>
</div>
<div class="form-row" id="pay-mode-android"
<{if $data['device_type'] == 1}>style="display: none;"<{/if}>>
<{foreach $_pay_types as $k => $v}>
    <{if $k == 1}> <{continue}> <{/if}>
    <div class="col-sm-12 col-md-6">
        <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" name="config[pay_mode][android][]" value="<{$k}>"
                    <{if $k|in_array:$data['config']['pay_mode']['android']}>
                    checked="checked"
                    <{/if}> >
                </div>
                <span class="input-group-text"><{$v}></span>
            </div>
            <input type="text" class="form-control" placeholder="折扣" name="config[discount][android][<{$k}>]" value="<{$data['config']['discount']['android'][$k]}>">
            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>
        </div>
    </div>
    <{/foreach}>
</div>
</div>
</div>
</fieldset>

<div class="form-group row type0 type2 combine" <{if $data['type']|in_array:[0,2] || $data['device_type'] == 1}>style="display: none;"<{/if}>>
<label for="combine" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">第三方切换</label>
<div class="col-sm-10">
    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox" id="combine" name="config[is_combine]" class="custom-control-input" value="1"
        <{if $data['config']['is_combine'] == 1}>checked="checked"<{/if}> >
        <label class="custom-control-label" for="combine"></label>
    </div>
</div>
</div>

<fieldset class="form-group type0 type2 combine" id="combine_switch" <{if $data['config']['is_combine'] != 1 || $data['type']|in_array:[0,2] || $data['device_type'] == 1}>style="display: none;"<{/if}>>
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0"></legend>
    <div class="col-sm-10">
        <div class="card-deck">
            <div class="card bg-light">
                <div class="card-header">登录</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-danger">
                        <label class="col-form-label">选择切换：</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_login1" name="config[combine][login]" value="1"
                            <{if $data['config']['combine']['login'] == 1}>checked="checked"<{/if}>>
                            <label class="custom-control-label" for="combine_login1">平台</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_login2" name="config[combine][login]" value="0"
                            <{if $data['config']['combine']['login'] == 0}>checked="checked"<{/if}>>
                            <label class="custom-control-label" for="combine_login2">第三方</label>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-primary combine_login">
                        <label class="col-form-label">登录切换比例：</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="config[combine][login_ratio]" value="<{$data['config']['combine']['login_ratio']}>">
                            <div class="input-group-append"><span class="input-group-text">%</span></div>
                        </div>
                        <small class="form-text text-danger">仅大于0时生效，按比例登录第三方，否则全部为第三方登录</small>
                    </li>
                </ul>
            </div>
            <div class="card bg-light">
                <div class="card-header">支付</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-danger">
                        <label class="col-form-label">选择切换：</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_pay1" name="config[combine][pay]" value="1"
                            <{if $data['config']['combine']['pay'] == 1}>checked="checked"<{/if}>>
                            <label class="custom-control-label" for="combine_pay1">平台</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_pay2" name="config[combine][pay]" value="0"
                            <{if $data['config']['combine']['pay'] == 0}>checked="checked"<{/if}>>
                            <label class="custom-control-label" for="combine_pay2">第三方</label>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-primary combine_pay">
                        <label class="col-form-label">充值附加条件：</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend"><span class="input-group-text">次数</span></div>
                            <input type="text" class="form-control" name="config[combine][pay_num]" value="<{$data['config']['combine']['pay_num']}>">
                            <div class="input-group-prepend"><span class="input-group-text">金额</span></div>
                            <input type="text" class="form-control" name="config[combine][pay_money]" value="<{$data['config']['combine']['pay_money']}>">
                            <div class="input-group-append"><span class="input-group-text">元</span></div>
                        </div>
                        <small class="form-text text-danger">
                            “玩家”达到设置值自动切换为平台支付。都不填则全部为第三方支付；两个都填且同时达到条件才生效。
                        </small>
                    </li>
                    <li class="list-group-item list-group-item-warning combine_pay">
                        <label class="col-form-label">兑换比例：</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_ratio1" name="config[combine][ratio]" value="1"
                            <{if $data['config']['combine']['ratio'] == 1}>checked="checked"<{/if}>>
                            <label class="custom-control-label" for="combine_ratio1">1:1</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_ratio2" name="config[combine][ratio]" value="10"
                            <{if $data['config']['combine']['ratio'] == 10}>checked="checked"<{/if}>>
                            <label class="custom-control-label" for="combine_ratio2">1:10</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_ratio3" name="config[combine][ratio]" value="100"
                            <{if $data['config']['combine']['ratio'] == 100}>checked="checked"<{/if}>>
                            <label class="custom-control-label" for="combine_ratio3">1:100</label>
                        </div>
                        <small class="form-text text-danger">该参数为第三方游戏币兑换比例，与第三方后台设定一致。默认：1:10</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</fieldset>

<div class="form-group row type0 type1" <{if $data['type']|in_array:[0,1]}>style="display: none;"<{/if}> >
<label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">绑定渠道</label>
<div class="col-sm-10">
    <select name="config[platform_alias]" style="width:150px;">
        <{foreach from=$_pay_channel_types key=id item=name}>
    <option value="<{$id}>" <{if $data['config']['platform_alias'] == $id}>selected<{/if}> ><{$name}></option>
        <{/foreach}>
    </select>
</div>
</div>

<div class="form-group row type0 type2 signature" <{if $data['type']|in_array:[0,2] || $data['device_type'] == 1}>style="display: none;"<{/if}> >
<label for="type" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">安卓分包签名</label>
<div class="col-sm-10">
    <select class="form-control" name="config[signature]" style="max-width: 15rem;"
    <{if $data['config']['signature']}>disabled<{/if}>>
    <{foreach $_signature as $k => $v}>
<option value="<{$k}>" <{if $data['config']['signature'] == $k}>selected<{/if}>><{$v.name}></option>
    <{/foreach}>
    </select>
    <small class="form-text text-danger">谨慎选择，选错将导致安装失败，IOS可忽略</small>
</div>
</div>

<div class="form-group row type0 inherit" <{if $data['type'] == 0 || $data['config']['inherit']}>style="display: none;"<{/if}> >
<label for="ratio" class="col-sm-2 col-form-label text-md-right text-sm-left">元宝兑换比例</label>
<div class="col-sm-5 col-md-4">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">1元：</span>
        </div>
        <input type="text" class="form-control" name="ratio" value="<{$data['ratio']}>" required>
        <div class="input-group-append">
            <span class="input-group-text">元宝</span>
        </div>
    </div>
</div>
</div>

<div class="form-group row type0 inherit" <{if $data['type'] == 0 || $data['config']['inherit']}>style="display: none;"<{/if}> >
<label for="unit" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">人民币单位</label>
<div class="col-sm-10">
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="unit1" name="unit" class="custom-control-input" value="0"
        <{if $data['unit'] == 0}>checked="checked"<{/if}> required>
        <label class="custom-control-label" for="unit1">分</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="unit2" name="unit" class="custom-control-input" value="1"
        <{if $data['unit'] == 1}>checked="checked"<{/if}> required>
        <label class="custom-control-label" for="unit2">元</label>
    </div>
</div>
</div>

<fieldset class="form-group type0" <{if $data['type'] == 0}>style="display: none;"<{/if}> >
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏状态</legend>
    <div class="col-sm-10">
        <div id="status-ios"
        <{if $data['device_type'] != 1}>style="display: none;"<{/if}> >
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios1" name="config[status][ios]" value="1"
            <{if $data['config']['status']['ios'] == 1}>checked="checked"<{/if}>>
            <label class="custom-control-label" for="status_ios1">正常</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios2" name="config[status][ios]" value="2"
            <{if $data['config']['status']['ios'] == 2}>checked="checked"<{/if}>>
            <label class="custom-control-label" for="status_ios2">测试</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios3" name="config[status][ios]" value="3"
            <{if $data['config']['status']['ios'] == 3}>checked="checked"<{/if}>>
            <label class="custom-control-label" for="status_ios3">提审[内购版]</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios4" name="config[status][ios]" value="4"
            <{if $data['config']['status']['ios'] == 4}>checked="checked"<{/if}>>
            <label class="custom-control-label" for="status_ios4">提审[免费版]</label>
        </div>
    </div>
    <div id="status-android"
    <{if $data['device_type'] == 1}>style="display: none;"<{/if}> >
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="status_android1" name="config[status][android]" value="1"
        <{if $data['config']['status']['android'] == 1}>checked="checked"<{/if}>>
        <label class="custom-control-label" for="status_android1">正常</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="status_android2" name="config[status][android]" value="2"
        <{if $data['config']['status']['android'] == 2}>checked="checked"<{/if}>>
        <label class="custom-control-label" for="status_android2">测试</label>
    </div>
</div>
</div>
</div>
</fieldset>

<div class="form-group row type0 type1 type2" id="iso_audit_user" <{if !$data['config']['status']['ios']|in_array:[3,4]}>style="display: none;"<{/if}> >
<label for="name" class="col-sm-2 col-form-label text-md-right text-sm-left">指定登录账户</label>
<div class="col-sm-10">
    <input type="text" class="form-control" name="config[iso_audit_user]" placeholder="请填写用户名，多账号使用“,”隔开" value="<{$data['config']['iso_audit_user']}>">
    <small class="form-text text-muted">提审时，将直接使用填写的账号进入游戏，多账号时随机获取其中一个。如果不使用请留空。</small>
</div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏总开关</label>
    <div class="col-sm-10">
        <div class="custom-control custom-switch custom-control-inline on-off">
            <input type="checkbox" id="status" name="status" class="custom-control-input" value="0"
            <{if $data['status'] == 0}>checked<{/if}>>
            <label class="custom-control-label" for="status">运营</label>
        </div>
        <div class="custom-control custom-switch custom-control-inline on-off type0"
        <{if $data['type'] == 0}>style="display: none;"<{/if}> >
        <input type="checkbox" id="is_login" name="is_login" class="custom-control-input" value="1"
        <{if $data['is_login'] == 1}>checked<{/if}>>
        <label class="custom-control-label" for="is_login">登录</label>
    </div>
    <div class="custom-control custom-switch custom-control-inline on-off type0"
    <{if $data['type'] == 0}>style="display: none;"<{/if}> >
    <input type="checkbox" id="is_reg" name="is_reg" class="custom-control-input" value="1"
    <{if $data['is_reg'] == 1}>checked<{/if}>>
    <label class="custom-control-label" for="is_reg">注册</label>
</div>
<div class="custom-control custom-switch custom-control-inline on-off type0" <{if $data['type'] == 0}>style="display: none;"<{/if}> >
<input type="checkbox" id="is_pay" name="is_pay" class="custom-control-input" value="1"
<{if $data['is_pay'] == 1}>checked<{/if}>>
<label class="custom-control-label" for="is_pay">充值</label>
</div>
<div class="custom-control custom-switch custom-control-inline on-off type0 type2"
<{if $data['type']|in_array:[0,2]}>style="display: none;"<{/if}> >
<input type="checkbox" id="is_adult" name="config[is_adult]" class="custom-control-input" value="2"
<{if $data['config']['is_adult'] == 2}>checked<{/if}>>
<label class="custom-control-label" for="is_adult">实名认证</label>
</div>
</div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right text-sm-left"></label>
    <div class="col-sm-10">
        <button type="button" id="submit" class="btn btn-success mr-4">保 存</button>
        <button type="button" id="cancel" class="btn btn-warning">取 消</button>
    </div>
</div>
</form>
</div>

<script id="select2-js" src="<{$_cdn_static_url_}>lib/select2/js/select2.min.js"></script>
<link id="select2-css" rel="stylesheet" href="<{$_cdn_static_url_}>lib/select2/css/select2.min.css">
<script>
    $(function () {
        //加载select控件
        $('select').each(function (i, elem) {
            if (!$(elem).hasClass("select2-hidden-accessible")) {
                $(elem).select2({
                    dropdownAutoWidth: true
                });
            }
        });

        //游戏属性事件
        $('input[name="type"]').click(function () {
            var v = $(this).val();
            var d = $('input[name="device_type"]:checked').val();
            var c = parseInt($('select[name="children_id"]').val());

            $('.form-group').show();
            $('.on-off').show();

            if (d != '3') {
                $('#h5_login').hide();
            }

            if (d == '1') {
                $('#status-ios').show();
                $('#status-android').hide();
                $('.signature').hide();
                $('.combine').hide();
                $('#pay-mode-ios').show();
                $('#pay-mode-android').hide();
            } else {
                $('#status-ios').hide();
                $('#status-android').show();
                $('.signature').show();
                $('.combine').show();
                $('#pay-mode-ios').hide();
                $('#pay-mode-android').show();
            }

            //第三方支付
            if (!$('input[name="config[is_combine]"]').prop("checked")) {
                $('#combine_switch').hide();
            }

            //继承游戏
            if (c > 0) {
                $('.inherit').hide();
            }

            $('.type' + v).hide();
        });

        //游戏类型事件
        $('input[name="device_type"]').click(function () {
            var v = $(this).val();
            var type = $('input[name="type"]:checked').val();
            var gid = $('select[name="children_id"]').val();

            //游戏状态
            if (v == '1') {
                $('#status-ios').show();
                $('#status-android').hide();
                $('#pay-mode-ios').show();
                $('#pay-mode-android').hide();
            } else {
                $('#status-ios').hide();
                $('#status-android').show();
                $('#pay-mode-ios').hide();
                $('#pay-mode-android').show();
            }

            //安卓签名、第三方切换
            if (v != '1' && type == '1') {
                $('.signature').show();
                $('.combine').show();

                //第三方支付
                if (!$('input[name="config[is_combine]"]').prop("checked")) {
                    $('#combine_switch').hide();
                }
            } else {
                $('.signature').hide();
                $('.combine').hide();
            }

            //H5登录地址
            if (v == '3' && gid <= 0) {
                $('#h5_login').show();
            } else {
                $('#h5_login').hide();
            }

            if (v == '1') {
                $('.ios-show').show();
            } else {
                $('.ios-show').hide();
            }
        });

        //子游戏事件
        $('select[name="children_id"]').on('change', function () {
            var id = $(this).find('option:selected').val();
            var type = $('input[name="type"]:checked').val();
            var d = $('input[name="device_type"]:checked').val();
            if (id > 0) {
                $('.inherit').hide();
            } else {
                $('.inherit').show();
                if (d != '3') {
                    $('#h5_login').hide();
                }
            }

            //复制客服信息按钮
            if (id > 0 && type == '1') {
                $('#kefu-copy').show();
            } else {
                $('#kefu-copy').hide();
            }
        });

        //IOS支付方式切换条件
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

        //第三方支付事件
        $('#combine').click(function () {
            if ($(this).prop("checked")) {
                $('#combine_switch').show();

                //登录比例
                $('input[name="config[combine][login]"]').off().on('click', function () {
                    var id = $(this).val();
                    if (id > 0) {
                        $('.combine_login').hide();
                    } else {
                        $('.combine_login').show();
                    }
                });

                //支付切换条件
                $('input[name="config[combine][pay]"]').off().on('click', function () {
                    var id = $(this).val();
                    if (id > 0) {
                        $('.combine_pay').hide();
                    } else {
                        $('.combine_pay').show();
                    }
                });
            } else {
                $('#combine_switch').hide();
            }
        });

        //复制客服信息
        var lock = false;
        $('#kefu-copy').on('click', function () {
            var game_id = $('select[name="children_id"]').val();
            if (game_id <= 0 || lock) {
                return false;
            }

            lock = true;
            $.post('?ct=platform&ac=copyKefuInfo', {
                game_id: game_id
            }, function (re) {
                if (re.state == true) {
                    var data = re.data;

                    //公共
                    $.each(data['kefu'], function (i, n) {
                        if (n) {
                            $('input[name="config[kefu][' + i + ']"]').val(n);
                        }
                    });

                    //vip
                    $.each(data['vip'], function (i, n) {
                        if (n) {
                            $('input[name="config[vip][' + i + ']"]').val(n);
                        }
                    });
                } else {
                    layer.msg(re.msg);
                }

                lock = false;
            }, 'json');
        });

        //关闭运营事件
        $('input[name="status"]').on('click', function () {
            let o = $(this),
                game_id = parseInt($('input[name="game_id"]').val()),
                type = parseInt($('input[name="type"]:checked').val()),
                checked = $(this).prop("checked");

            if (!checked && game_id > 0) {
                let msg = type === 0 ? '关闭母游戏，将同时关闭旗下所有子游戏<br><br>' : '';
                msg += '<span style="color: red;">关闭后玩家将无法访问，慎重！慎重！慎重！<br>是否确定关闭？</span>';
                layer.confirm(msg, function (index) {
                    layer.close(index);
                    o.prop("checked", false);
                }, function (index) {
                    o.prop("checked", true);
                });
            }
        });

        //游戏状态事件
        $('input[name="config[status][ios]"]').on('click', function () {
            let v = $(this).val();
            if (v === '3' || v === '4') {
                $('#iso_audit_user').show();
            } else {
                $('#iso_audit_user').hide();
            }
        });

        var validation = Array.prototype.filter.call($('form'), function (elem) {
            var form = $(elem);
            $('#submit').on('click', function (event) {
                if (elem.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.addClass('was-validated');
                    return false;
                }

                var index = parent.layer.msg('保存中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=addGameAction', {
                    data: form.serialize()
                }, function (re) {
                    parent.layer.close(index);
                    parent.layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        shadeClose: true,
                        content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                        time: 3000,
                        end: function () {
                            if (re.state == true) {
                                top.location.reload();
                            }
                        }
                    });
                }, 'json');
            });

        });

        $('#cancel').on('click', function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
    });
</script>
<{include file="../public/foot.tpl"}>