<{include file="../public/header.tpl"}>
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
          <input type="hidden" name="sort" value="<{$sort}>" />
          <div class="form-group form-group-sm">
              <button type="button" class="btn btn-info" id="show-toggle" title="切换显示方式">
                  <span class="glyphicon <{if $_show_toggle == 'th'}>glyphicon-th-list<{else}>glyphicon-th<{/if}>" aria-hidden="true"></span>
              </button>
              <a href="?ct=extend&ac=landModel&sort=click" class="btn btn-danger <{if $sort == 'click'}>active<{/if}>" title="按点击数量排序">
                  <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
              </a>
              <a href="?ct=extend&ac=landModel&sort=use" class="btn btn-warning <{if $sort == 'use'}>active<{/if}>" title="按使用数量排序">
                  <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
              </a>
          </div>
          <div class="form-group form-group-sm">
              <{widgets widgets=$widgets}>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>

              <{if SrvAuth::checkPublicAuth('add',false)}>
              <a href="?ct=extend&ac=addLandModel" class="btn btn-danger btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加落地页模板</a>
              <{/if}>
          </div>
      </form>
  </div>
  <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
    <div class="table-content <{if $_show_toggle == 'th'}>show<{else}>hidden<{/if}>" style="float: left;min-width:100%;" id="show-th">
      <div class="row">
          <{foreach from=$data.list item=u}>
        <div class="pic col-lg-2 col-md-4 col-sm-5 col-xs-6 text-center">
          <div class="thumbnail"> <img src="uploads/<{$u.thumb}>" alt="<{$u.model_name}>" style="max-width: 200px; max-height:250px;">
            <div class="caption">
              <h4><{$u.model_name}></h4>
              <p>
                  类型：<{if $u.model_type == 1}>压缩包<{else}>图片<{/if}>，
                  游戏：<{$_games[$u.game_id]}>
              </p>
              <p>
                  <a href="javascript:;" data-url="<{$u.model_url}>" data-title="<{$u.model_name}>" class="preview btn btn-success btn-xs">预览</a>
                  <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=extend&ac=addLandModel&model_id=<{$u.model_id}>" class="btn btn-primary btn-xs">编辑</a><{/if}>
                  <{if $u.model_type==1 && SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=extend&ac=editLandModel&model_id=<{$u.model_id}>" target="_blank" class="btn btn-info btn-xs">自定义</a><{/if}>
                  <{if SrvAuth::checkPublicAuth('del',false)}><a href="javascript:;" data-id="<{$u.model_id}>" class="del btn btn-danger btn-xs">删除</a><{/if}>
                  <a href="javascript:;" data-url="?ct=extend&ac=landHeatMap&model_id=<{$u.model_id}>" data-title="<{$u.model_name}>" class="heat-map btn btn-warning btn-xs">热点图 </a>
              </p>
            </div>
          </div>
        </div>
        <{/foreach}>
      </div>
      <div style="float: left;">
        <nav>
          <ul class="pagination">
            <{$data.page_html nofilter}>
          </ul>
        </nav>
      </div>
    </div>
    <div class="table-content <{if $_show_toggle == 'list'}>show<{else}>hidden<{/if}>" style="float: left;min-width:100%;" id="show-list">
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
          <{foreach from=$data.list item=u}>
          <tr>
            <td nowrap><{$u.model_id}></td>
            <td nowrap><{$u.model_name}></td>
              <td nowrap><{if $u.model_type == 1}>压缩包<{else}>图片<{/if}></td>
            <td nowrap><{$_games[$u.game_id]}></td>
            <td nowrap><{$u.administrator}></td>
              <td nowrap><{$u.update_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
              <td nowrap><{if $u.count > 0}><a href="?ct=extend&ac=landPage&model_id=<{$u.model_id}>" target="_blank"><span class="label label-danger"><{$u.count}></span></a><{/if}></td>
            <td nowrap>
                <a href="javascript:;" data-url="<{$u.model_url}>" data-title="<{$u.model_name}>" class="preview btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 预览</a>
                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=extend&ac=addLandModel&model_id=<{$u.model_id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><{/if}>
                <{if $u.model_type==1 && SrvAuth::checkPublicAuth('edit',false)}>
                <a href="?ct=extend&ac=editLandModel&model_id=<{$u.model_id}>" target="_blank" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 自定义</a>
                <{else}>
                <button type="button" class="btn btn-info btn-xs" disabled="disabled"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 自定义</button>
                <{/if}>
                <{if SrvAuth::checkPublicAuth('del',false)}><a href="javascript:" data-id="<{$u.model_id}>" class="del btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</a><{/if}>
                <a href="javascript:;" data-url="?ct=extend&ac=landHeatMap&model_id=<{$u.model_id}>" data-title="<{$u.model_name}>" class="heat-map btn btn-warning btn-xs"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> 热点图 </a>
                <a href="<{$u.model_zip}>" target="_blank" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 下载模板</a>
            </td>
          </tr>
          <{/foreach}>
            </tbody>
        </table>
      </div>
      <div style="float: left;">
        <nav>
          <ul class="pagination">
            <{$data.page_html nofilter}>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
<script>
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
</script>
<{include file="../public/foot.tpl"}>