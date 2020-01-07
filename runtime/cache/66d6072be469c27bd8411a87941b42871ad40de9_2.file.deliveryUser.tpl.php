<?php /* Smarty version 3.1.27, created on 2019-11-29 19:04:37
         compiled from "/home/vagrant/code/admin/web/admin/template/ad/deliveryUser.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:8715370745de0fb45387056_70702407%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66d6072be469c27bd8411a87941b42871ad40de9' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/ad/deliveryUser.tpl',
      1 => 1575025474,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8715370745de0fb45387056_70702407',
  'variables' => 
  array (
    '_channels' => 0,
    'id' => 0,
    'data' => 0,
    'name' => 0,
    '_groups' => 0,
    'u' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de0fb453fe0c2_48124862',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de0fb453fe0c2_48124862')) {
function content_5de0fb453fe0c2_48124862 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '8715370745de0fb45387056_70702407';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="ad"/>
            <input type="hidden" name="ac" value="deliveryUser"/>
            <div class="form-group form-group-sm">
                <label>选择渠道</label>
                <select class="form-control" name="channel_id">
                    <option value="0">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['channel_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>投放账号</label>
                <select class="form-control" name="user_id" id="user_id">
                    <option value="0">选择账号</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['users'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['user_id'] == $_smarty_tpl->tpl_vars['name']->value['user_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <!--<label>投放组</label>
                <select name="group_id" id="group_id">
                    <option value="0">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_groups']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['group_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>-->

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>

                <?php if (SrvAuth::checkPublicAuth('add',false)) {?>
                <a href="?ct=ad&ac=addDeliveryUser" class="btn btn-success btn-sm" role="button">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加投放账号
                </a>
                <?php }?>

                <?php if (SrvAuth::checkPublicAuth('audit',false)) {?>
                <span class="btn btn-danger btn-sm clear_cache">
                    <i class="fa fa-repeat fa-fw" aria-hidden="true"></i>更新缓存
                </span>
                <?php }?>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>渠道</th>
                        <th>投放账号</th>
                        <th>投放组</th>
                        <th>应用ID <i class="fa fa-question-circle" alt="腾讯社交广告的应用ID"></i></th>
                        <th>账号ID <i class="fa fa-question-circle" alt="广告主账号ID"></i></th>
                        <th>授权剩余</th>
                        <th>授权刷新剩余</th>
                        <th>最后刷新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['list'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['u']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->_loop = true;
$foreach_u_Sav = $_smarty_tpl->tpl_vars['u'];
?>
                        <tr>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['u']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['group_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['u']->value['client_id']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['client_id'], ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['u']->value['account_id']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['account_id'], ENT_QUOTES, 'UTF-8');?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['account_uin'], ENT_QUOTES, 'UTF-8');?>
)<?php } else { ?>-<?php }?></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['u']->value['account_id']) {
if ($_smarty_tpl->tpl_vars['u']->value['access_token_expires_in'] > 0) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['access_token_expires_in'], ENT_QUOTES, 'UTF-8');?>
分钟<?php } else { ?>0分钟<?php }
} else { ?>-<?php }?></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['u']->value['account_id']) {
if ($_smarty_tpl->tpl_vars['u']->value['refresh_token_expires_in'] > 0) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['refresh_token_expires_in'], ENT_QUOTES, 'UTF-8');?>
天<?php } else { ?>0天<?php }
} else { ?>-<?php }?></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['u']->value['time']) {
echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <td>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?>
                                <a href="?ct=ad&ac=addDeliveryUser&user_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a>
                                
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['auth_url']) {?>
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['auth_url'], ENT_QUOTES, 'UTF-8');?>
" target="_blank" class="btn btn-danger btn-xs auth"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 账号授权</a>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['refresh_token_expires_in'] > 0) {?>
                                <span class="btn btn-success btn-xs refresh" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
                                <?php } else { ?>
                                <span class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['access_token_expires_in'] > 0) {?>
                                <a href="?ct=ad&ac=channelUserAppList&id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['user_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 设置数据源</a>
                                <?php } else { ?>
                                <span class="btn btn-info btn-xs" disabled="disabled"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 设置数据源</span>
                                <?php }?>
                                <?php } else { ?>
                                <span class="btn btn-danger btn-xs" disabled="disabled"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 账号授权</span>
                                <span class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
                                <span class="btn btn-info btn-xs" disabled="disabled"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 设置数据源</span>
                                <?php }?>
                                <a href="javascript:;" data-href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['auth_url'], ENT_QUOTES, 'UTF-8');?>
" data-acc="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['media_account'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-danger btn-xs batch-auth"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 批量授权</a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                </ul>
            </nav>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        //授权
        $('.auth').on('click', function () {
            layer.confirm('是否已经授权成功？', {
                btn: ['是的', '没有']
            }, function () {
                location.reload();
            });
        });

        //刷新授权
        $('.refresh').on('click', function () {
            var user_id = $(this).data('id');
            layer.confirm('确定刷新授权时间吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('?ct=ad&ac=channelRefreshUserAuth', {
                    user_id: user_id
                }, function (re) {
                    if (re.state) {
                        layer.alert('刷新成功', function () {
                            location.reload();
                        });
                    } else {
                        layer.alert(re.msg, {icon: 5});
                    }
                }, 'json');
            });
        });

        //更新缓存
        $('.clear_cache').on('click', function () {
            layer.confirm('确定更新缓存吗？', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=ad&ac=clearCacheChannelUser', function (ret) {
                    layer.close(index);
                    if (ret.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(ret.msg);
                    }
                }, 'json');
            });
        });

        $('select[name=channel_id]').on('change', function () {
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!channel_id) {
                return false;
            }
            $.getJSON('?ct=extend&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="">选择账号</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#user_id').html(html);
            });
        });

        $('.batch-auth').on('click', function(){
            var acc = $(this).attr('data-acc');
            var auth_url = $(this).attr('data-href');
            var con = '<div><p>请确认媒体账号'+acc+'在当前浏览器已经登录今日头条投放后台，然后点击确定前往授权页进行授权</p></div>';
            var baIndex = layer.confirm(con, {
                btn: ['确定','取消'], //按钮
                title: '信息确认'
            }, function(){
                /*
                    TODO::不需要广告主ID,待确认
                    var id = $('#advertiser_id').val();
                    if(! id)
                        return false;
                 */
                window.open(auth_url);
            }, function(){
                layer.close(baIndex);
            });
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>