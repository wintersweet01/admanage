<?php /* Smarty version 3.1.27, created on 2019-11-28 20:25:53
         compiled from "/home/vagrant/code/admin/web/admin/template/extend/modelList.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6787839325ddfbcd14894e2_03762788%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cd9b09dca8c929d411c22b795a4ec6fc996bf58d' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/extend/modelList.tpl',
      1 => 1571041047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6787839325ddfbcd14894e2_03762788',
  'variables' => 
  array (
    'sort' => 0,
    '_show_toggle' => 0,
    'widgets' => 0,
    'data' => 0,
    'u' => 0,
    '_games' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ddfbcd15013d8_10035085',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ddfbcd15013d8_10035085')) {
function content_5ddfbcd15013d8_10035085 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/vagrant/code/admin/lib/library/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '6787839325ddfbcd14894e2_03762788';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<style type="text/css">
    .pic {
        min-width: 290px;
        min-height: 400px;
    }

    .pic .thumbnail {
        min-width: 260px;
        min-height: 380px;
    }

    .pic h4, .pic p {
        max-width: 232px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
<div id="areascontent">
  <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
      <form method="get" action="" class="form-inline">
          <input type="hidden" name="ct" value="extend" />
          <input type="hidden" name="ac" value="landModel" />
          <input type="hidden" name="sort" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sort']->value, ENT_QUOTES, 'UTF-8');?>
" />
          <div class="form-group form-group-sm">
              <button type="button" class="btn btn-info" id="show-toggle" title="切换显示方式">
                  <span class="glyphicon <?php if ($_smarty_tpl->tpl_vars['_show_toggle']->value == 'th') {?>glyphicon-th-list<?php } else { ?>glyphicon-th<?php }?>" aria-hidden="true"></span>
              </button>
              <a href="?ct=extend&ac=landModel&sort=click" class="btn btn-danger <?php if ($_smarty_tpl->tpl_vars['sort']->value == 'click') {?>active<?php }?>" title="按点击数量排序">
                  <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
              </a>
              <a href="?ct=extend&ac=landModel&sort=use" class="btn btn-warning <?php if ($_smarty_tpl->tpl_vars['sort']->value == 'use') {?>active<?php }?>" title="按使用数量排序">
                  <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
              </a>
          </div>
          <div class="form-group form-group-sm">
              <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widgets'][0][0]->smarty_widgets(array('widgets'=>$_smarty_tpl->tpl_vars['widgets']->value),$_smarty_tpl);?>

              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>

              <?php if (SrvAuth::checkPublicAuth('add',false)) {?>
              <a href="?ct=extend&ac=addLandModel" class="btn btn-danger btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加落地页模板</a>
              <?php }?>
          </div>
      </form>
  </div>
  <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
    <div class="table-content <?php if ($_smarty_tpl->tpl_vars['_show_toggle']->value == 'th') {?>show<?php } else { ?>hidden<?php }?>" style="float: left;min-width:100%;" id="show-th">
      <div class="row">
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
        <div class="pic col-lg-2 col-md-4 col-sm-5 col-xs-6 text-center">
          <div class="thumbnail"> <img src="uploads/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['thumb'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
" style="max-width: 200px; max-height:250px;">
            <div class="caption">
              <h4><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
</h4>
              <p>
                  类型：<?php if ($_smarty_tpl->tpl_vars['u']->value['model_type'] == 1) {?>压缩包<?php } else { ?>图片<?php }?>，
                  游戏：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>

              </p>
              <p>
                  <a href="javascript:;" data-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_url'], ENT_QUOTES, 'UTF-8');?>
" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
" class="preview btn btn-success btn-xs">预览</a>
                  <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=extend&ac=addLandModel&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs">编辑</a><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['u']->value['model_type'] == 1 && SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=extend&ac=editLandModel&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" target="_blank" class="btn btn-info btn-xs">自定义</a><?php }?>
                  <?php if (SrvAuth::checkPublicAuth('del',false)) {?><a href="javascript:;" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" class="del btn btn-danger btn-xs">删除</a><?php }?>
                  <a href="javascript:;" data-url="?ct=extend&ac=landHeatMap&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
" class="heat-map btn btn-warning btn-xs">热点图 </a>
              </p>
            </div>
          </div>
        </div>
        <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
      </div>
      <div style="float: left;">
        <nav>
          <ul class="pagination">
            <?php echo $_smarty_tpl->tpl_vars['data']->value['page_html'];?>

          </ul>
        </nav>
      </div>
    </div>
    <div class="table-content <?php if ($_smarty_tpl->tpl_vars['_show_toggle']->value == 'list') {?>show<?php } else { ?>hidden<?php }?>" style="float: left;min-width:100%;" id="show-list">
      <div style="background-color: #fff;">
        <table class="table table-bordered table-bordered text-center">
          <thead>
            <tr>
              <th nowrap>模板ID</th>
              <th nowrap>模板名称</th>
                <th nowrap>模板类型</th>
              <th nowrap>所属游戏</th>
              <th nowrap>上传者</th>
                <th nowrap>上传时间</th>
                <th nowrap>使用数/点击数</th>
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
          <tr>
            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
</td>
            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
</td>
              <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['model_type'] == 1) {?>压缩包<?php } else { ?>图片<?php }?></td>
            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_games']->value[$_smarty_tpl->tpl_vars['u']->value['game_id']], ENT_QUOTES, 'UTF-8');?>
</td>
            <td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['administrator'], ENT_QUOTES, 'UTF-8');?>
</td>
              <td nowrap><?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['u']->value['update_time'],"%Y/%m/%d %H:%M:%S"), ENT_QUOTES, 'UTF-8');?>
</td>
              <td nowrap><?php if ($_smarty_tpl->tpl_vars['u']->value['count'] > 0) {?><a href="?ct=extend&ac=landPage&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" target="_blank"><span class="label label-danger"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['count'], ENT_QUOTES, 'UTF-8');?>
</span></a><?php }?></td>
            <td nowrap>
                <a href="javascript:;" data-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_url'], ENT_QUOTES, 'UTF-8');?>
" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
" class="preview btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 预览</a>
                <?php if (SrvAuth::checkPublicAuth('edit',false)) {?><a href="?ct=extend&ac=addLandModel&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['u']->value['model_type'] == 1 && SrvAuth::checkPublicAuth('edit',false)) {?>
                <a href="?ct=extend&ac=editLandModel&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" target="_blank" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 自定义</a>
                <?php } else { ?>
                <button type="button" class="btn btn-info btn-xs" disabled="disabled"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 自定义</button>
                <?php }?>
                <?php if (SrvAuth::checkPublicAuth('del',false)) {?><a href="javascript:" data-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" class="del btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</a><?php }?>
                <a href="javascript:;" data-url="?ct=extend&ac=landHeatMap&model_id=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_id'], ENT_QUOTES, 'UTF-8');?>
" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
" class="heat-map btn btn-warning btn-xs"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> 热点图 </a>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['u']->value['model_zip'], ENT_QUOTES, 'UTF-8');?>
" target="_blank" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 下载模板</a>
            </td>
          </tr>
          <?php
$_smarty_tpl->tpl_vars['u'] = $foreach_u_Sav;
}
?>
            </tbody>
        </table>
      </div>
      <div style="float: left;">
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
        $('.del').on('click', function () {
            var id = $(this).attr('data-id');
            layer.confirm('确定删除?', {
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=extend&ac=delLandModel', {
                    model_id: id
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        location.reload();
                    } else {
                        layer.alert(re.msg, {icon: 5});
                    }
                }, 'json');
            }, function () {

            });
        });

        $('#show-toggle').on('click', function () {
            var e = $(this).children('span');
            if (e.hasClass('glyphicon-th-list')) {
                e.removeClass('glyphicon-th-list').addClass('glyphicon-th');
                $.httab.setCookie('show_toggle', 'list', 0);
                $('#show-th').removeClass('show').addClass('hidden');
                $('#show-list').removeClass('hidden').addClass('show');
            } else {
                e.removeClass('glyphicon-th').addClass('glyphicon-th-list');
                $.httab.setCookie('show_toggle', 'th', 0);
                $('#show-th').removeClass('hidden').addClass('show');
                $('#show-list').removeClass('show').addClass('hidden');
            }
        });

        $('.heat-map,.preview').click(function () {
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
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>