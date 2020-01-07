<?php /* Smarty version 3.1.27, created on 2019-11-28 18:01:27
         compiled from "/home/vagrant/code/admin/web/admin/template/material/materialBox.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:21095818805ddf9af7e41904_75132771%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '823f4dde08868c1429494c75308229a723e6d757' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/material/materialBox.tpl',
      1 => 1571042744,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21095818805ddf9af7e41904_75132771',
  'variables' => 
  array (
    '_channels' => 0,
    'v' => 0,
    'data' => 0,
    'widgets' => 0,
    '_admins' => 0,
    'id' => 0,
    'name' => 0,
    '_types' => 0,
    '_size' => 0,
    '_tag' => 0,
    'u' => 0,
    '_games' => 0,
    '_channel_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddf9af7ee4a76_98469445',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddf9af7ee4a76_98469445')) {
function content_5ddf9af7ee4a76_98469445 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '21095818805ddf9af7e41904_75132771';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style type="text/css">
    .table .btn,.table .label {
        margin: 2px;
        display: inline-block;;
    }
    .img-thumbnail {
        width: 24px;
        height: 24px;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="material" />
            <input type="hidden" name="ac" value="materialBox" />

            <div class="form-group form-group-sm" style="margin-bottom: 10px;">
                <label>流量平台：</label>
                <?php
$_from = $_smarty_tpl->tpl_vars['_channels']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
                <label class="checkbox-inline">
                    <input type="checkbox" name="channel_id[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['channel_id'], ENT_QUOTES, 'UTF-8');?>
" <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['channel_id'],$_smarty_tpl->tpl_vars['data']->value['channel_id'])) {?>checked="checked"<?php }?>>
                    <img src="<?php if ($_smarty_tpl->tpl_vars['v']->value['logo']) {?>uploads/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['logo'], ENT_QUOTES, 'UTF-8');
} else { ?>static/images/default.png<?php }?>" class="img-thumbnail">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['channel_name'], ENT_QUOTES, 'UTF-8');?>

                </label>
                <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>
            </div>

            <div class="form-group form-group-sm">
                <label>高级筛选：</label>

                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>


                <select name="upload_user">
                    <option value="">选择制作人</option>
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['upload_user'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <select name="material_type">
                    <option value="">素材类型</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_types']->value;
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_type'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <select name="material_source">
                    <option value="">需求来源</option>
                    <option value="-1" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_source'] == '-1') {?>selected="selected"<?php }?>>原创构思</option>
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
" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_source'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <select name="material_wh">
                    <option value="">选择尺寸</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_size']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['material_wh'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_wh'] == $_smarty_tpl->tpl_vars['name']->value['material_wh']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['material_wh'], ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                </select>

                <select name="material_tag">
                    <option value="">选择标签</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['_tag']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['v']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$foreach_v_Sav = $_smarty_tpl->tpl_vars['v'];
?>
                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['tag_name'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['material_tag'] == $_smarty_tpl->tpl_vars['v']->value['tag_name']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['tag_name'], ENT_QUOTES, 'UTF-8');?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['v'] = $foreach_v_Sav;
}
?>
                </select>
            </div>

            <div class="form-group form-group-sm" style="margin-top: 5px;">
                <label style="margin-right: 65px;"></label>

                <input type="text" name="sdate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['sdate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" placeholder="开始时间"/> -
                <input type="text" name="edate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['edate'], ENT_QUOTES, 'UTF-8');?>
" class="form-control Wdate" placeholder="结束时间"/>

                <input type="text" class="form-control" name="material_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['material_name'], ENT_QUOTES, 'UTF-8');?>
" placeholder="搜索素材名">

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="location.href='?ct=material&ac=uploadMaterial'"><i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i>上传素材</button>

                <!--<button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>-->
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap><a href="javascript:;" id="all_select">全选</a></th>
                        <th nowrap>ID</th>
                        <th nowrap>制作日期</th>
                        <th nowrap>制作负责人</th>
                        <th nowrap>所属游戏</th>
                        <th nowrap>所属渠道</th>
                        <th nowrap>素材类型</th>
                        <th nowrap>素材名称</th>
                        <th nowrap>素材尺寸</th>
                        <th nowrap>素材大小</th>
                        <th nowrap>需求来源</th>
                        <th nowrap>上传时间</th>
                        <th nowrap>绑定</th>
                        <th nowrap>素材标签</th>
                        <th nowrap>素材预览图</th>
                        <th nowrap>操作</th>
                        <th nowrap>测试时间</th>
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
                            <td nowrap><input type="checkbox" name="download_all" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
" /></td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['make_date'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_admins']->value[$_smarty_tpl->tpl_vars['u']->value['upload_user']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_channel_list']->value[$_smarty_tpl->tpl_vars['u']->value['channel_id']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_types']->value[$_smarty_tpl->tpl_vars['u']->value['material_type']], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_name'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_wh'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_size'], ENT_QUOTES, 'UTF-8');?>
</td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['material_source'] != '') {
echo htmlspecialchars($_smarty_tpl->tpl_vars['_admins']->value[$_smarty_tpl->tpl_vars['u']->value['material_source']], ENT_QUOTES, 'UTF-8');
} else { ?>原创构思<?php }?></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['create_time']) {
echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['create_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');
} else { ?>-<?php }?></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['material_count'] > 0) {?><span class="glyphicon glyphicon-ok green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove red" aria-hidden="true"></span><?php }?></td>
                            <td nowrap><?php
$_from = $_smarty_tpl->tpl_vars['u']->value['material_tag'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
echo $_smarty_tpl->tpl_vars['name']->value;
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?></td>
                            <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['thumb']) {?><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['thumb'], ENT_QUOTES, 'UTF-8');?>
" data-img="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['thumb'], ENT_QUOTES, 'UTF-8');?>
" class="img-rounded" style="width: 100px;height: auto;"><?php }?></td>
                            <td nowrap class="cursor">
                                <a href="?ct=material&ac=bindMaterial&material_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-info btn-xs">绑定推广</a><br>
                                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=material&ac=editMaterial&material_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs">编辑素材</a><br><?php }?>
                                <?php if (SrvAuth::checkPublicAuth('del',false)) {?><span class="btn btn-danger btn-xs btnDel" data-name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_name'], ENT_QUOTES, 'UTF-8');?>
" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
">删除素材</span><br><?php }?>
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_url'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-success" target="_blank">预览</a>
                                    <span class="btn btn-warning download" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
">下载</span>
                                </div>
                            </td>
                            <td nowrap>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="开始时间" name="test_start" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
" value="<?php if ($_smarty_tpl->tpl_vars['u']->value['test_start']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['test_start'], ENT_QUOTES, 'UTF-8');
}?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btnTime" type="button">确定</button>
                                    </span>
                                </div>

                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="结束时间" name="test_end" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['material_id'], ENT_QUOTES, 'UTF-8');?>
" value="<?php if ($_smarty_tpl->tpl_vars['u']->value['test_end']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['test_end'], ENT_QUOTES, 'UTF-8');
}?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btnTime" type="button">确定</button>
                                    </span>
                                </div>
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
                <button type="button" class="btn btn-primary btn-xs" id="download_all"> 打包下载 </button>
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
        //图片预览
        var index;
        $('.img-rounded').mouseenter(function () {
            index = layer.tips('<img src="' + $(this).data('img') + '" class="tips">', $(this), {
                tips: [4, '#ffffff'],
                maxWidth: '200px',
                time: 0
            });
        }).mouseleave(function () {
            layer.close(index);
        });

        //测试时间
        $('.btnTime').on('click', function () {
            var e = $(this).parent().prev('input');
            var _time = e.val();
            var _name = e.attr('name');
            var material_id = e.data('id');
            $.get('?ct=material&ac=changeTime&material_id=' + material_id + '&type=' + _name + '&time=' + _time, function (re) {
                if (re.state == true) {
                    layer.msg(re.msg);
                    return false;
                } else {
                    layer.msg(re.msg);
                    return false;
                }
            }, 'json');
        });

        //全选
        $('#all_select').on('click', function () {
            $(".table input[type='checkbox']").prop("checked", function (i, val) {
                return !val;
            });
        });

        //下载
        $('.download').on('click', function () {
            var id = $(this).data('id');
            download(id);
        });

        //打包下载
        $('#download_all').on('click', function () {
            var tmp = [];
            $('input[name=download_all]').each(function (index, domEle) {
                if ($(this).is(':checked')) {
                    tmp.push($(this).val())
                }
            });

            var ids = tmp.join();
            if (!ids) {
                layer.alert('请勾选要下载的素材', {icon: 2});
                return false;
            }

            download(ids);
        });

        //删除素材
        $('.btnDel').on('click', function () {
            var material_id = $(this).data('id');
            var title = $(this).data('name');
            layer.confirm('<font color="red">确定删除素材【' + title + '】吗？</font>', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                $.post('?ct=material&ac=delMaterial',{id:material_id}, function (re) {
                    if (re.state) {
                        layer.alert(re.msg, {icon: 1});
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        layer.alert(re.msg, {icon: 2});
                    }
                }, 'json');
            });
        });

        //下载
        function download(ids) {
            layer.msg('正在打包中，请勿刷新...', {icon: 16, shade: 0.6, time: 0});
            $.post('?ct=material&ac=download',{ids:ids}, function (re) {
                if (re.state) {
                    layer.msg(re.msg, {icon: 1, time: 10 * 1000});
                    setTimeout(function () {
                        window.location.href = re.url;
                    }, 1500);
                } else {
                    layer.alert(re.msg, {icon: 2});
                }
            }, 'json');
        }
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>