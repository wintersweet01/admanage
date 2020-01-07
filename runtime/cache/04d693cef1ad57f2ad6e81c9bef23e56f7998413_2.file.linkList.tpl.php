<?php /* Smarty version 3.1.27, created on 2019-11-29 11:10:40
         compiled from "/home/vagrant/code/admin/web/admin/template/extend/linkList.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11497618905de08c30a5f810_09083455%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04d693cef1ad57f2ad6e81c9bef23e56f7998413' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/extend/linkList.tpl',
      1 => 1574414888,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11497618905de08c30a5f810_09083455',
  'variables' => 
  array (
    'data' => 0,
    'widgets' => 0,
    'name' => 0,
    '_channels' => 0,
    'id' => 0,
    '_admins' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5de08c30af03e3_40415450',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5de08c30af03e3_40415450')) {
function content_5de08c30af03e3_40415450 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '11497618905de08c30a5f810_09083455';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="extend"/>
            <input type="hidden" name="ac" value="linkList"/>
            <input type="hidden" name="status" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['status'], ENT_QUOTES, 'UTF-8');?>
"/>
            <div class="form-group form-group-sm">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <label>游戏包</label>
                <select class="form-control" name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_packages'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['package_name'] == $_smarty_tpl->tpl_vars['name']->value['package_name']) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
 </option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <label>选择渠道</label>
                <select class="form-control" name="channel_id">
                    <option value="">全 部</option>
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
                    <option value="">选择账号</option>
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

                <label>负责人</label>
                <select class="form-control" name="create_user" class="form-control" style="width:60px;">
                    <option value="all">选择负责人</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_admins']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['create_user'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>&nbsp;

                <label>关键字</label>
                <input type="text" class="form-control" name="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['keyword'], ENT_QUOTES, 'UTF-8');?>
" placeholder="推广名称/ID/游戏包"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-primary btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
            <div class="form-group form-group-sm" style="margin-top: 5px;">
                <?php if (SrvAuth::checkPublicAuth('add',false)) {?>
                <a href="?ct=extend&ac=addLink" class="btn btn-primary btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加推广链</a>
                <?php }?>
                <span class="btn btn-danger btn-sm clear_cache"><i class="fa fa-repeat fa-fw" aria-hidden="true"></i>更新配置</span>
                <a href="?ct=extend&ac=linkList&status=1" class="btn btn-warning btn-sm" role="button"><i class="fa fa-ban fa-fw" aria-hidden="true"></i>已停用链接</a>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;overflow-x: auto">
                <table class="table table-bordered table-hover table-condensed text-center">
                    <thead>
                    <tr>
                        <th nowrap><a href="javascript:" id="all_check">全选</a></th>
                        <th nowrap>ID</th>
                        <th nowrap>推广名称</th>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>游戏包</th>
                        <th nowrap>平台</th>
                        <th nowrap>渠道</th>
                        <th nowrap>落地页名称</th>
                        <th nowrap>创建时间</th>
                        <th nowrap>负责人</th>
                        <th nowrap>推广地址(CDN)</th>
                        <th nowrap>操作</th>
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
                        <tr id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
">
                            <td nowrap><input type="checkbox" name="all" id="row_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
"></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['parent_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['package_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['platform'] == 1) {?><span class="icon_ios"></span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['u']->value['platform'] == 2) {?><span class="icon_android"></span>
                                <?php } else { ?>-<?php }?>
                            </td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channels']->value[$_smarty_tpl->tpl_vars['u']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['model_name']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <td nowrap><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['create_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['administrator'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['jump_url']) {?>
                                <span data-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['jump_url'], ENT_QUOTES, 'UTF-8');?>
" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
                                      class="preview btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"
                                                                                   aria-hidden="true"></span> 预览</span>
                                <button type="button" class="copy btn btn-primary btn-xs"
                                        data-clipboard-text="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['jump_url'], ENT_QUOTES, 'UTF-8');?>
">
                                    <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> 复制
                                </button>
                                <?php } else { ?> - <?php }?>
                            </td>
                            <td nowrap>
                                <span class="copy btn btn-danger btn-xs" data-clipboard-text="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['short_url'], ENT_QUOTES, 'UTF-8');?>
"><span
                                            class="glyphicon glyphicon-link" aria-hidden="true"></span> 短链</span>
                                <span class="copy btn btn-primary btn-xs" data-clipboard-text="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_url'], ENT_QUOTES, 'UTF-8');?>
"><span
                                            class="glyphicon glyphicon-copy" aria-hidden="true"></span> 监测地址</span>
                                <span class="copy download_url btn btn-warning btn-xs"
                                      data-clipboard-text="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['download_url'], ENT_QUOTES, 'UTF-8');?>
"><span
                                            class="glyphicon glyphicon-download-alt"
                                            aria-hidden="true"></span> 包地址</span>
                                <?php if ($_smarty_tpl->tpl_vars['u']->value['jump_url']) {?>
                                <span data-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['local_url'], ENT_QUOTES, 'UTF-8');?>
" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
                                      class="preview btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"
                                                                                   aria-hidden="true"></span> 本地预览</span>
                                <?php } else { ?>
                                <span class="btn btn-success btn-xs" disabled="disabled"><span
                                            class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 本地预览</span>
                                <?php }?>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?>
                                <a href="?ct=extend&ac=channelLog&monitor_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
"
                                   class="btn btn-info btn-xs" target="_blank"><span
                                            class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 回调日志</a>
                                <a href="?ct=extend&ac=addLink&monitor_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
"
                                   class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"
                                                                        aria-hidden="true"></span> 编辑</a>
                                <span data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
" class="stop btn btn-warning btn-xs"><span
                                            class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> 停用</span>
                                <?php }?>
                                <?php if (SrvAuth::checkPublicAuth('del',false)) {?>
                                <span data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['monitor_id'], ENT_QUOTES, 'UTF-8');?>
" class="del btn btn-danger btn-xs"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</span>
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
            <div style="float: left;margin-top: 5px;">
                <a href="javascript:" id="all_modify" class="btn btn-primary btn-small" role="button"> 批量修改 </a>
                <a href="javascript:" id="all_stop" class="btn btn-warning btn-small" role="button"> 批量停用 </a>
            </div>
            <div style="float: right;">
                <nav>
                    <ul class="pagination">
                        <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function () {
        $('#printExcel').click(function () {
            location.href = '?ct=extend&ac=linkListExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + '&package_name=' + $('select[name=package_name]').val() + '&channel_id=' + $('select[name=channel_id]').val();
        });
        $('#all_check').on('click', function () {
            $('input[name=all]').each(function () {
                if ($(this).is(':checked')) {
                    this.checked = false;
                } else {
                    this.checked = true;
                }
            });
        });
        $('#all_modify').on('click', function () {
            var monitor = [];
            $('input[name=all]:checked').each(function () {
                monitor.push($(this).val());
            });
            if (monitor.length == 0) {
                layer.msg('请勾选一个以上');
                return false;
            }
            location.href = '?ct=extend&ac=modifyLandPageAll&monitor_id=' + monitor.join(',');
        });
        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html);
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

        $('.preview').click(function () {
            var url = $(this).data('url');
            var title = $(this).data('title');
            layer.open({
                type: 2,
                title: title,
                shadeClose: true,
                shade: 0.8,
                area: ['657px', '100%'],
                content: url
            });
        });

        //删除链接
        $('.del').on('click', function () {
            var e = $(this);
            var id = e.attr('data-id');
            layer.confirm('<span class="red">删除后，该链接将无法访问，请确保该链接没有在投放中，慎重！慎重！慎重！<br><br>该操作将无法恢复，相关报表数据一并删除</span><br><br>是否删除?', {
                icon: 7,
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=extend&ac=delLink', {
                    monitor_id: id
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        layer.msg(re.msg);
                        e.parents('tr').fadeOut("slow");
                    } else {
                        layer.alert(re.msg, {icon: 5});
                    }
                }, 'json');
            }, function () {

            });
        });

        //更新缓存
        $('.clear_cache').on('click', function () {
            layer.confirm('确定更新配置吗？<br><br><span class="red">更新后，新的配置即刻生效</span>', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=extend&ac=clearCacheLink', function (ret) {
                    layer.close(index);
                    if (ret.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(ret.msg);
                    }
                }, 'json');
            });
        });

        //包下载
        $('.download_url').on('click', function () {
            var url = $(this).data('clipboard-text');
            layer.confirm('已经复制，是否还要下载？', {
                btn: ['下载', '不用'],
                icon: 3,
                title: '提示'
            }, function () {
                if (!url) {
                    layer.alert('无下载地址',{icon: 7});
                    return false;
                }

                layer.msg('正在跳转下载中......', {icon: 16, shadeClose: false, time: 3000});
                window.location.href = url;
            });
        });

        //停用链接
        $('.stop').on('click', function () {
            var e = $(this);
            var id = e.attr('data-id');
            layer.confirm('<span class="red">停用后，该链接将无法访问，请确保该链接没有在投放中，慎重！慎重！慎重！<br><br>该操作仅保留链接数据和报表数据</span><br><br>是否停用?', {
                icon: 7,
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在停用...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=extend&ac=stopLink', {
                    monitor_id: id
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        layer.msg(re.msg);
                        e.parents('tr').fadeOut("slow");
                    } else {
                        layer.alert(re.msg, {icon: 5});
                    }
                }, 'json');
            }, function () {

            });
        });

        //停用链接
        $('#all_stop').on('click', function () {
            var _this = $(this);
            var ids = [];
            $("input[name='all']").each(function(){
                if($(this).prop("checked")){
                    ids.push($(this).val())
                }
            });
            if(ids.length <=0){
                return false;
            }
            layer.confirm('<span class="red">停用后，该链接将无法访问，请确保该链接没有在投放中，慎重！慎重！慎重！<br><br>该操作仅保留链接数据和报表数据</span><br><br>是否停用?', {
                icon: 7,
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在停用...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=extend&ac=stopLinkBatch', {
                    monitor_ids: ids
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        layer.msg(re.msg);
                        var data = re.data;
                        for(var i in data){
                            $("#"+data[i]).fadeOut('slow');
                            $("#row_"+data[i]).prop("checked",false);
                        }
                    } else {
                        layer.alert(re.msg, {icon: 5});
                    }
                }, 'json');
            }, function () {

            });
        });
    })
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>