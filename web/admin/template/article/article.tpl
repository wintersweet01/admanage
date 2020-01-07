<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="article"/>
            <input type="hidden" name="ac" value="article"/>
            <div class="form-group form-group-sm">
                <label>选择类别</label>
                <select class="form-control" name="type" style="width: 50px;">
                    <option value="0"
                    <{if $data.type==0}>selected="selected"<{/if}>>全部</option>
                    <option value="1"
                    <{if $data.type==1}>selected="selected"<{/if}>>公告</option>
                    <option value="2"
                    <{if $data.type==2}>selected="selected"<{/if}>>常见问题</option>
                </select>

                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>标题</label>
                <input type="text" class="form-control" name="title" value="<{$data.title}>">

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>

                <a href="?ct=article&ac=articleAdd" class="btn btn-danger btn-sm" role="button">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加文章</a>
                <span class="notice btn btn-warning btn-sm" role="button">
                    <i class="fa fa-send fa-fw" aria-hidden="true"></i>快速发布公告</span>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>ID</th>
                        <th nowrap>文章标题</th>
                        <th nowrap>文章类别</th>
                        <th nowrap>所属游戏</th>
                        <th nowrap>添加时间</th>
                        <th nowrap>发布人</th>
                        <th nowrap>生成HTML</th>
                        <th nowrap>是否已推送</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=r}>
                        <tr>
                            <td nowrap><{$r.aid}></td>
                            <td nowrap style="text-align: left;"><span style="color: <{$r.color}>;<{if $r.isstrong}>font-weight: bold;<{/if}>"><{$r.title}></span> <{$r.postfix nofilter}></td>
                            <td nowrap><{$r.type}></td>
                            <td nowrap><{if $r.game_id}><{$_games[$r.game_id]}><{else}>-<{/if}></td>
                            <td nowrap><{$r.addtime}></td>
                            <td nowrap><{$r.administrator}></td>
                            <td  nowrap><{if $r.htmlurl}><span class="glyphicon glyphicon-ok green" aria-hidden="true"></span><{else}><span class="glyphicon glyphicon-remove red" aria-hidden="true"></span><{/if}></td>
                            <td  nowrap><{if $r.ispush}><span class="glyphicon glyphicon-ok green" aria-hidden="true"></span><{else}><span class="glyphicon glyphicon-remove red" aria-hidden="true"></span><{/if}></td>
                            <td>
                                <span class="preview btn btn-success btn-xs" data-id="<{$r.aid}>" data-title="<{$r.title}>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 预览</span>
                                <a href="?ct=article&ac=articleAdd&id=<{$r.aid}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a>
                                <span class="del btn btn-danger btn-xs" data-id="<{$r.aid}>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</span>
                                <span class="html btn btn-info btn-xs" data-id="<{$r.aid}>"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> 生成HTML</span>
                                <span class="push btn btn-warning btn-xs" data-id="<{$r.aid}>"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> 推送</span>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div style="float: right;">
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
        $('.preview').click(function () {
            var id = $(this).data('id');
            var title = $(this).data('title');
            layer.open({
                type: 2,
                title: title,
                shadeClose: true,
                shade: 0.8,
                area: ['657px', '100%'],
                content: '?ct=article&ac=articlePreview&id=' + id
            });
        });

        $('.del').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('确定删除吗?', {
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=article&ac=articleDel', {
                    id: id
                }, function (re) {
                    layer.close(index);
                    layer.msg(re.message);
                    if (re.code == 1) {
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                }, 'json');
            }, function () {

            });
        });

        $('.html').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('确定生成HTML吗?', {
                btn: ['是的', '取消']
            }, function () {
                $.getJSON('?ct=article&ac=articleHtmlAction&id=' + id, function (re) {
                    layer.msg(re.message);
                    if (re.code == 1) {
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                });
            }, function () {

            });
        });

        //推送
        $('.push').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('<font color="red">推送成功后，客户端将即时弹出该消息</font><br><br>确定推送吗?', {
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在推送...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=article&ac=articlePush', {
                    id: id
                }, function (re) {
                    layer.close(index);
                    layer.msg(re.msg);
                    if (re.state) {
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                }, 'json');
            }, function () {

            });
        });

        //快速发布公告
        $('.notice').click(function () {
            layer.open({
                type: 2,
                title: '快速发布公告',
                shadeClose: false,
                shade: 0.8,
                area: ['800px', '90%'],
                content: '?ct=article&ac=articleNotice'
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>
