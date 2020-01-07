<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="packageGift"/>
            <div class="form-group form-group-sm">
                <{widgets widgets=$widgets}>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>
                <a href="/?ct=platform&ac=importGift" class="btn btn-success btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>批量导入礼包</a>
                <a href="/?ct=platform&ac=addGiftType" class="btn btn-warning btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加礼包类别</a>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>母游戏</th>
                        <th nowrap>子游戏</th>
                        <th nowrap>礼包类别</th>
                        <th nowrap>礼包总数</th>
                        <th nowrap>已领数量</th>
                        <th nowrap>描述</th>
                        <th nowrap>开关</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data item=r}>
                        <tr>
                            <td nowrap><{$_games[$r.parent_id]}></td>
                            <td nowrap><{if $r.game_id}><{$_games[$r.game_id]}><{else}>-<{/if}></td>
                            <td nowrap><{$r.type_name}></td>
                            <td nowrap><{$r.amount}></td>
                            <td nowrap><{$r.used}></td>
                            <td nowrap><{$r.explain}></td>
                            <td nowrap>
                                <{if $r.status == 1}><i class="fa fa-check text-success fa-lg"></i>
                                <{else}><i class="fa fa-close text-danger fa-lg"></i><{/if}>
                            </td>
                            <td>
                                <a href="javascript:;" <{if $r.type neq 9}>style="pointer-events:none;" data-url=''<{else}> data-url = '<{$r.data_url}>'<{/if}> link_id = <{$r.id}> data-method="offset" data-type="auto"
                                class="preview btn btn-success btn-xs layui-btn layui-btn-normal <{if $r.type neq 9}>disabled<{/if}> "><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 查看链接</a>
                                <a href="?ct=platform&ac=importGift&parent_id=<{$r.parent_id}>&game_id=<{$r.game_id}>&type_id=<{$r.id}>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 上传</a>
                                <a href="?ct=platform&ac=addGiftType&id=<{$r.id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a>
                                <a href="javascript:" class="del btn btn-danger btn-xs" data-id="<{$r.id}>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</a>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.del').on('click', function () {
            var id = $(this).data('id');
            layer.confirm('将同步删除已上传的礼包，确定删除?', {
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=delGiftType', {
                    id: id
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        location.reload();
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            }, function () {

            });
        });

        $('.preview').click(function () {
            var url = $(this).attr('data-url');
            var title = $(this).data('title');
            var id = $(this).attr('link_id');
            var type = 'auto';
            if (url) {
                layer.open({
                    type: 1,
                    title: '公众号链接',
                    offset: type,
                    id: 'layerDemo' + type,
                    content: '<input type="text" readonly="readonly" name="gift_url" id = "' + id + '" value="' + url + '" style="margin:0 auto;width:100%" class="form-control">',
                    btn: '复制链接',
                    btnAlign: 'c',
                    area: ['500px', '150px'],
                    shade: 0,
                    yes: function () {
                        //layer.closeAll();
                        var e = document.getElementById(id);
                        e.select();
                        var info = document.execCommand("Copy");
                        if (info) {
                            alert('复制成功');
                        }
                        layer.closeAll();
                    }
                });
            }
        });
    });
</script>
<{include file="../public/foot.tpl"}>