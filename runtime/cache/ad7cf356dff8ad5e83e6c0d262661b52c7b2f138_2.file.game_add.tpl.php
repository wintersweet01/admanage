<?php /* Smarty version 3.1.27, created on 2019-11-29 13:57:05
         compiled from "/home/vagrant/code/admin/web/admin/template/platform/game_add.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:16463840345de0b331455ab4_35394176%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad7cf356dff8ad5e83e6c0d262661b52c7b2f138' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/platform/game_add.tpl',
      1 => 1573639028,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16463840345de0b331455ab4_35394176',
  'variables' => 
  array (
    'data' => 0,
    'widgets' => 0,
    '_pay_types' => 0,
    'k' => 0,
    'v' => 0,
    '_pay_channel_types' => 0,
    'id' => 0,
    'name' => 0,
    '_signature' => 0,
    '_cdn_static_url_' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0b331569cf8_66828925',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0b331569cf8_66828925')) {
function content_5de0b331569cf8_66828925 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '16463840345de0b331455ab4_35394176';
echo $_smarty_tpl->getSubTemplate ("../public/header-bootstrap.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="container-fluid" style="padding: 2rem;">
    <form class="needs-validation" method="post" action="" novalidate>
        <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
"/>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏属性</label>
            <div class="col-sm-10">
                <?php if (!$_smarty_tpl->tpl_vars['data']->value['parent_id']) {?>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type0" name="type" value="0"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>checked="checked"<?php }?> >
                    <label class="custom-control-label" for="type0">母游戏/目录</label>
                </div>
                <?php }?>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type1" name="type" value="1"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 1) {?>checked="checked"<?php }?> >
                    <label class="custom-control-label" for="type1">买量投放</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="type2" name="type" value="2"
                    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 2) {?>checked="checked"<?php }?> >
                    <label class="custom-control-label" for="type2">渠道分发</label>
                </div>
            </div>
        </div>

        <div class="form-group row type0"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?> >
        <label for="device_type" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏类型</label>
        <div class="col-sm-10">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="device_type1" name="device_type" value="1"
                <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>checked="checked"<?php }?> >
                <label class="custom-control-label" for="device_type1">ios</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="device_type2" name="device_type" value="2"
                <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 2) {?>checked="checked"<?php }?> >
                <label class="custom-control-label" for="device_type2">android</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="device_type3" name="device_type" value="3"
                <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 3) {?>checked="checked"<?php }?> >
                <label class="custom-control-label" for="device_type3">html5</label>
            </div>
        </div>
</div>

<div class="form-group row type0" <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?> >
<label class="col-sm-2 col-form-label text-md-right text-sm-left">母游戏</label>
<div class="col-sm-10">
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

    <small class="form-text text-danger">如果“选择子游戏”，当前添加的游戏将自动继承该子游戏的对接参数。</small>
</div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label text-md-right text-sm-left">游戏名称</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="由中文、英文字母、数字、下划线和减号组成" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['name'], ENT_QUOTES, 'UTF-8');?>
" required>
    </div>
</div>

<div class="form-group row">
    <label for="alias" class="col-sm-2 col-form-label text-md-right text-sm-left">游戏标识</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="alias" placeholder="由英文字母、数字和减号组成的小写字符串，如：test-88，不能重复" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['alias'], ENT_QUOTES, 'UTF-8');?>
" required>
    </div>
</div>

<fieldset class="form-group type0 inherit" id="h5_login"
<?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] != 3 || $_smarty_tpl->tpl_vars['data']->value['config']['inherit'] || $_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?>>
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">H5登录地址</legend>
    <div class="col-sm-10">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">正式服：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][main]" placeholder="游戏入口地址[正式服]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['login_url']['main'], ENT_QUOTES, 'UTF-8');?>
">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">测试服：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][test]" placeholder="游戏入口地址[测试服]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['login_url']['test'], ENT_QUOTES, 'UTF-8');?>
">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">IOS提审服[内购版]：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][ios]" placeholder="游戏入口地址[内购版]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['login_url']['ios'], ENT_QUOTES, 'UTF-8');?>
">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">IOS提审服[免费版]：</span>
            </div>
            <input type="text" class="form-control" name="config[login_url][noios]" placeholder="游戏入口地址[免费版]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['login_url']['noios'], ENT_QUOTES, 'UTF-8');?>
">
        </div>
    </div>
</div>
</fieldset>

<fieldset class="form-group type0 inherit" <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['inherit'] || $_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?> >
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">充值地址</legend>
    <div class="col-sm-10">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">正式服：</span>
            </div>
            <input type="text" class="form-control" name="config[pay_url][main]" placeholder="游戏充值回调地址[正式服]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['pay_url']['main'], ENT_QUOTES, 'UTF-8');?>
">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">测试服：</span>
            </div>
            <input type="text" class="form-control" name="config[pay_url][test]" placeholder="游戏充值回调地址[测试服]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['pay_url']['test'], ENT_QUOTES, 'UTF-8');?>
">
        </div>
        <div class="input-group mb-1 ios-show"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] != 1) {?>style="display: none;"<?php }?> >
        <div class="input-group-prepend">
            <span class="input-group-text">IOS提审服[内购版]：</span>
        </div>
        <input type="text" class="form-control" name="config[pay_url][ios]" placeholder="游戏充值回调地址[内购版]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['pay_url']['ios'], ENT_QUOTES, 'UTF-8');?>
">
    </div>
    <div class="input-group mb-1 ios-show"
    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] != 1) {?>style="display: none;"<?php }?> >
    <div class="input-group-prepend">
        <span class="input-group-text">IOS提审服[免费版]：</span>
    </div>
    <input type="text" class="form-control" name="config[pay_url][noios]" placeholder="游戏充值回调地址[免费版]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['pay_url']['noios'], ENT_QUOTES, 'UTF-8');?>
">
</div>
</div>
</div>
</fieldset>

<fieldset class="form-group type0 type2" <?php if (in_array($_smarty_tpl->tpl_vars['data']->value['type'],array(0,2))) {?>style="display: none;"<?php }?> >
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">客服中心
        <button type="button" class="btn btn-warning btn-sm" id="kefu-copy"
        <?php if (!$_smarty_tpl->tpl_vars['data']->value['config']['inherit']) {?>style="display: none;"<?php }?> >复制继承</button>
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
                        <input type="text" class="form-control" name="config[kefu][qq]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['kefu']['qq'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">QQ群号</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][group]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['kefu']['group'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服邮箱</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][mail]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['kefu']['mail'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服电话</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][phone]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['kefu']['phone'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">微信公众号</span>
                        </div>
                        <input type="text" class="form-control" name="config[kefu][weixin]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['kefu']['weixin'], ENT_QUOTES, 'UTF-8');?>
">
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
                            <input type="text" class="form-control" name="config[vip][money]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['vip']['money'], ENT_QUOTES, 'UTF-8');?>
">
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
                        <input type="text" class="form-control" name="config[vip][qq]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['vip']['qq'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">QQ群号</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][group]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['vip']['group'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服邮箱</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][mail]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['vip']['mail'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">客服电话</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][phone]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['vip']['phone'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                    <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">微信公众号</span>
                        </div>
                        <input type="text" class="form-control" name="config[vip][weixin]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['vip']['weixin'], ENT_QUOTES, 'UTF-8');?>
">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</fieldset>

<fieldset class="form-group type0 type2" <?php if (in_array($_smarty_tpl->tpl_vars['data']->value['type'],array(0,2))) {?>style="display: none;"<?php }?>>
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">支付方式</legend>
    <div class="col-sm-10">
        <div class="form-row" id="pay-mode-ios"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] != 1) {?>style="display: none;"<?php }?>>
        <?php
$_from = $_smarty_tpl->tpl_vars['_pay_types']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
        <div class="col-sm-12 col-md-6">
            <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" name="config[pay_mode][ios][]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
"
                        <?php if (in_array($_smarty_tpl->tpl_vars['k']->value,$_smarty_tpl->tpl_vars['data']->value['config']['pay_mode']['ios'])) {?>
                        checked="checked"
                        <?php }?> >
                    </div>
                    <span class="input-group-text"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');?>
</span>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['k']->value != 1) {?>
            <input type="text" class="form-control" placeholder="折扣" name="config[discount][ios][<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['discount']['ios'][$_smarty_tpl->tpl_vars['k']->value], ENT_QUOTES, 'UTF-8');?>
">
                <div class="input-group-append">
                    <span class="input-group-text">%</span>
                </div>
                <?php }?>
            </div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['k']->value == 1) {?>
        <div id="ios_pay_mode" class="col-sm-12 col-md-12"
        <?php if (!(in_array('1',$_smarty_tpl->tpl_vars['data']->value['config']['pay_mode']['ios']))) {?>style="display: none;"<?php }?>>
        <label class="col-form-label">自动切换为平台：</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend"><span class="input-group-text">次数</span>
            </div>
            <input type="text" class="form-control" name="config[pay_mode][pay_num]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['pay_mode']['pay_num'], ENT_QUOTES, 'UTF-8');?>
">
            <div class="input-group-prepend"><span class="input-group-text">金额</span>
            </div>
            <input type="text" class="form-control" name="config[pay_mode][pay_money]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['pay_mode']['pay_money'], ENT_QUOTES, 'UTF-8');?>
">
            <div class="input-group-append"><span class="input-group-text">元</span>
            </div>
        </div>
        <small class="form-text text-danger">
            “玩家”达到设置值自动切换为平台支付。都不填则为appstore支付；只要一个达到条件即可生效。
        </small>
    </div>
    <?php }?>
    <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>
    <div class="col-sm-12 col-md-12">
        <div class="custom-control custom-switch custom-control-inline on-off">
            <input type="checkbox" id="config_usa" name="config[pay_mode][usa]" class="custom-control-input" value="1"
            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['pay_mode']['usa'] == 1) {?>checked<?php }?>>
            <label class="custom-control-label text-danger" for="config_usa">美国IP固定为苹果支付</label>
        </div>
    </div>
</div>
<div class="form-row" id="pay-mode-android"
<?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>style="display: none;"<?php }?>>
<?php
$_from = $_smarty_tpl->tpl_vars['_pay_types']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
    <?php if ($_smarty_tpl->tpl_vars['k']->value == 1) {?> <?php continue 1;?> <?php }?>
    <div class="col-sm-12 col-md-6">
        <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" name="config[pay_mode][android][]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
"
                    <?php if (in_array($_smarty_tpl->tpl_vars['k']->value,$_smarty_tpl->tpl_vars['data']->value['config']['pay_mode']['android'])) {?>
                    checked="checked"
                    <?php }?> >
                </div>
                <span class="input-group-text"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');?>
</span>
            </div>
            <input type="text" class="form-control" placeholder="折扣" name="config[discount][android][<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['discount']['android'][$_smarty_tpl->tpl_vars['k']->value], ENT_QUOTES, 'UTF-8');?>
">
            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>
        </div>
    </div>
    <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>
</div>
</div>
</div>
</fieldset>

<div class="form-group row type0 type2 combine" <?php if (in_array($_smarty_tpl->tpl_vars['data']->value['type'],array(0,2)) || $_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>style="display: none;"<?php }?>>
<label for="combine" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">第三方切换</label>
<div class="col-sm-10">
    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox" id="combine" name="config[is_combine]" class="custom-control-input" value="1"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['is_combine'] == 1) {?>checked="checked"<?php }?> >
        <label class="custom-control-label" for="combine"></label>
    </div>
</div>
</div>

<fieldset class="form-group type0 type2 combine" id="combine_switch" <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['is_combine'] != 1 || in_array($_smarty_tpl->tpl_vars['data']->value['type'],array(0,2)) || $_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>style="display: none;"<?php }?>>
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
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['combine']['login'] == 1) {?>checked="checked"<?php }?>>
                            <label class="custom-control-label" for="combine_login1">平台</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_login2" name="config[combine][login]" value="0"
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['combine']['login'] == 0) {?>checked="checked"<?php }?>>
                            <label class="custom-control-label" for="combine_login2">第三方</label>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-primary combine_login">
                        <label class="col-form-label">登录切换比例：</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="config[combine][login_ratio]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['combine']['login_ratio'], ENT_QUOTES, 'UTF-8');?>
">
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
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['combine']['pay'] == 1) {?>checked="checked"<?php }?>>
                            <label class="custom-control-label" for="combine_pay1">平台</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_pay2" name="config[combine][pay]" value="0"
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['combine']['pay'] == 0) {?>checked="checked"<?php }?>>
                            <label class="custom-control-label" for="combine_pay2">第三方</label>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-primary combine_pay">
                        <label class="col-form-label">充值附加条件：</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend"><span class="input-group-text">次数</span></div>
                            <input type="text" class="form-control" name="config[combine][pay_num]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['combine']['pay_num'], ENT_QUOTES, 'UTF-8');?>
">
                            <div class="input-group-prepend"><span class="input-group-text">金额</span></div>
                            <input type="text" class="form-control" name="config[combine][pay_money]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['combine']['pay_money'], ENT_QUOTES, 'UTF-8');?>
">
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
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['combine']['ratio'] == 1) {?>checked="checked"<?php }?>>
                            <label class="custom-control-label" for="combine_ratio1">1:1</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_ratio2" name="config[combine][ratio]" value="10"
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['combine']['ratio'] == 10) {?>checked="checked"<?php }?>>
                            <label class="custom-control-label" for="combine_ratio2">1:10</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="combine_ratio3" name="config[combine][ratio]" value="100"
                            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['combine']['ratio'] == 100) {?>checked="checked"<?php }?>>
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

<div class="form-group row type0 type1" <?php if (in_array($_smarty_tpl->tpl_vars['data']->value['type'],array(0,1))) {?>style="display: none;"<?php }?> >
<label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">绑定渠道</label>
<div class="col-sm-10">
    <select name="config[platform_alias]" style="width:150px;">
        <?php
$_from = $_smarty_tpl->tpl_vars['_pay_channel_types']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['platform_alias'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected<?php }?> ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
        <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
    </select>
</div>
</div>

<div class="form-group row type0 type2 signature" <?php if (in_array($_smarty_tpl->tpl_vars['data']->value['type'],array(0,2)) || $_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>style="display: none;"<?php }?> >
<label for="type" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">安卓分包签名</label>
<div class="col-sm-10">
    <select class="form-control" name="config[signature]" style="max-width: 15rem;"
    <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['signature']) {?>disabled<?php }?>>
    <?php
$_from = $_smarty_tpl->tpl_vars['_signature']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['signature'] == $_smarty_tpl->tpl_vars['k']->value) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['name'], ENT_QUOTES, 'UTF-8');?>
</option>
    <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>
    </select>
    <small class="form-text text-danger">谨慎选择，选错将导致安装失败，IOS可忽略</small>
</div>
</div>

<div class="form-group row type0 inherit" <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0 || $_smarty_tpl->tpl_vars['data']->value['config']['inherit']) {?>style="display: none;"<?php }?> >
<label for="ratio" class="col-sm-2 col-form-label text-md-right text-sm-left">元宝兑换比例</label>
<div class="col-sm-5 col-md-4">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">1元：</span>
        </div>
        <input type="text" class="form-control" name="ratio" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['ratio'], ENT_QUOTES, 'UTF-8');?>
" required>
        <div class="input-group-append">
            <span class="input-group-text">元宝</span>
        </div>
    </div>
</div>
</div>

<div class="form-group row type0 inherit" <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0 || $_smarty_tpl->tpl_vars['data']->value['config']['inherit']) {?>style="display: none;"<?php }?> >
<label for="unit" class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">人民币单位</label>
<div class="col-sm-10">
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="unit1" name="unit" class="custom-control-input" value="0"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['unit'] == 0) {?>checked="checked"<?php }?> required>
        <label class="custom-control-label" for="unit1">分</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="unit2" name="unit" class="custom-control-input" value="1"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['unit'] == 1) {?>checked="checked"<?php }?> required>
        <label class="custom-control-label" for="unit2">元</label>
    </div>
</div>
</div>

<fieldset class="form-group type0" <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?> >
<div class="row">
    <legend class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏状态</legend>
    <div class="col-sm-10">
        <div id="status-ios"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] != 1) {?>style="display: none;"<?php }?> >
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios1" name="config[status][ios]" value="1"
            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['status']['ios'] == 1) {?>checked="checked"<?php }?>>
            <label class="custom-control-label" for="status_ios1">正常</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios2" name="config[status][ios]" value="2"
            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['status']['ios'] == 2) {?>checked="checked"<?php }?>>
            <label class="custom-control-label" for="status_ios2">测试</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios3" name="config[status][ios]" value="3"
            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['status']['ios'] == 3) {?>checked="checked"<?php }?>>
            <label class="custom-control-label" for="status_ios3">提审[内购版]</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="status_ios4" name="config[status][ios]" value="4"
            <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['status']['ios'] == 4) {?>checked="checked"<?php }?>>
            <label class="custom-control-label" for="status_ios4">提审[免费版]</label>
        </div>
    </div>
    <div id="status-android"
    <?php if ($_smarty_tpl->tpl_vars['data']->value['device_type'] == 1) {?>style="display: none;"<?php }?> >
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="status_android1" name="config[status][android]" value="1"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['status']['android'] == 1) {?>checked="checked"<?php }?>>
        <label class="custom-control-label" for="status_android1">正常</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="status_android2" name="config[status][android]" value="2"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['config']['status']['android'] == 2) {?>checked="checked"<?php }?>>
        <label class="custom-control-label" for="status_android2">测试</label>
    </div>
</div>
</div>
</div>
</fieldset>

<div class="form-group row type0 type1 type2" id="iso_audit_user" <?php if (!in_array($_smarty_tpl->tpl_vars['data']->value['config']['status']['ios'],array(3,4))) {?>style="display: none;"<?php }?> >
<label for="name" class="col-sm-2 col-form-label text-md-right text-sm-left">指定登录账户</label>
<div class="col-sm-10">
    <input type="text" class="form-control" name="config[iso_audit_user]" placeholder="请填写用户名，多账号使用“,”隔开" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['config']['iso_audit_user'], ENT_QUOTES, 'UTF-8');?>
">
    <small class="form-text text-muted">提审时，将直接使用填写的账号进入游戏，多账号时随机获取其中一个。如果不使用请留空。</small>
</div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right text-sm-left pt-0">游戏总开关</label>
    <div class="col-sm-10">
        <div class="custom-control custom-switch custom-control-inline on-off">
            <input type="checkbox" id="status" name="status" class="custom-control-input" value="0"
            <?php if ($_smarty_tpl->tpl_vars['data']->value['status'] == 0) {?>checked<?php }?>>
            <label class="custom-control-label" for="status">运营</label>
        </div>
        <div class="custom-control custom-switch custom-control-inline on-off type0"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?> >
        <input type="checkbox" id="is_login" name="is_login" class="custom-control-input" value="1"
        <?php if ($_smarty_tpl->tpl_vars['data']->value['is_login'] == 1) {?>checked<?php }?>>
        <label class="custom-control-label" for="is_login">登录</label>
    </div>
    <div class="custom-control custom-switch custom-control-inline on-off type0"
    <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?> >
    <input type="checkbox" id="is_reg" name="is_reg" class="custom-control-input" value="1"
    <?php if ($_smarty_tpl->tpl_vars['data']->value['is_reg'] == 1) {?>checked<?php }?>>
    <label class="custom-control-label" for="is_reg">注册</label>
</div>
<div class="custom-control custom-switch custom-control-inline on-off type0" <?php if ($_smarty_tpl->tpl_vars['data']->value['type'] == 0) {?>style="display: none;"<?php }?> >
<input type="checkbox" id="is_pay" name="is_pay" class="custom-control-input" value="1"
<?php if ($_smarty_tpl->tpl_vars['data']->value['is_pay'] == 1) {?>checked<?php }?>>
<label class="custom-control-label" for="is_pay">充值</label>
</div>
<div class="custom-control custom-switch custom-control-inline on-off type0 type2"
<?php if (in_array($_smarty_tpl->tpl_vars['data']->value['type'],array(0,2))) {?>style="display: none;"<?php }?> >
<input type="checkbox" id="is_adult" name="config[is_adult]" class="custom-control-input" value="2"
<?php if ($_smarty_tpl->tpl_vars['data']->value['config']['is_adult'] == 2) {?>checked<?php }?>>
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

<?php echo '<script'; ?>
 id="select2-js" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/select2/js/select2.min.js"><?php echo '</script'; ?>
>
<link id="select2-css" rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
lib/select2/css/select2.min.css">
<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>