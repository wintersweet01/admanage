<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=platform&ac=addGame" class="btn btn-primary btn-small" role="button"> + 添加游戏 </a><{/if}>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>游戏ID</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>游戏别名</th>
                        <th nowrap>游戏类型</th>
                        <th nowrap>包版本</th>
                        <th nowrap>SDK版本</th>
                        <th nowrap>ios</th>
                        <th nowrap>android</th>
                        <th nowrap>实时在线</th>
                        <th nowrap>母包上传</th>
                        <th nowrap>是否运营</th>
                        <th nowrap>上传时间</th>
                        <th nowrap>更新时间</th>
                        <th nowrap>创建时间</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u name=foo}>
                        <tr>
                            <td nowrap><{$u.game_id}></td>
                            <td nowrap><{$u.name}></td>
                            <td nowrap><{$u.alias}></td>
                            <td nowrap><{if $u.config.h5}><span class="icon_html5"></span><{else}><span class="icon_unity"></span><{/if}>
                            </td>
                            <td nowrap><span class="badge"><strong><{$u.package_version}></strong></span></td>
                            <td nowrap><span class="label label-danger"><{$u.sdk_version}></span></td>
                            <td nowrap>
                                <span class="label
                                <{if $u.config.status.ios == 1}>label-success
                                <{elseif $u.config.status.ios == 2}>label-warning
                                <{elseif $u.config.status.ios == 3}>label-danger
                                <{/if}>">
                                    <{$_game_status[$u.config.status.ios]}>
                                </span>
                            </td>
                            <td nowrap>
                                <span class="label
                                <{if $u.config.status.android == 1}>label-success
                                <{elseif $u.config.status.android == 2}>label-warning
                                <{elseif $u.config.status.android == 3}>label-danger
                                <{/if}>">
                                    <{$_game_status[$u.config.status.android]}>
                                </span>
                            </td>
                            <td nowrap><{$u.online}></td>
                            <td nowrap>
                                <{if $u.is_upload}>
                                <span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>
                                <{else}>
                                <span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>
                                <{/if}>
                            </td>
                            <td nowrap>
                                <{if $u.status}>
                                <span class="glyphicon glyphicon-remove red" aria-hidden="true"></span>
                                <{else}>
                                <span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>
                                <{/if}>
                            </td>
                            <td nowrap><{if $u.upload_time}><{$u.upload_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.update_time}><{$u.update_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{if $u.create_time}><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=platform&ac=addGame&game_id=<{$u.game_id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a><{/if}>
                                <a href="?ct=platform&ac=gameParams&game_id=<{$u.game_id}>" class="btn btn-warning btn-xs" title="下载参数"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 下载</a>
                                <a href="?ct=platform&ac=gameUpdate&game_id=<{$u.game_id}>" class="btn btn-success btn-xs" title="上传安卓母包"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 上传</a>
                                <{if $u.refresh > 0}>
                                <a href="?ct=platform&ac=refreshProgress&game_id=<{$u.game_id}>" class="btn btn-warning btn-xs" title="查看发布进度"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> 批量发布中...</a>
                                <{else}>
                                <span data-id="<{$u.game_id}>" data-title="<{$u.name}>" class="refresh btn btn-danger btn-xs" title="批量发布新包"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> 批量发布新包</span>
                                <{/if}>
                                <span data-id="<{$u.game_id}>" data-title="<{$u.name}>" class="clear_cache btn btn-info btn-xs" title="更新配置"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 更新配置</span>
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
        $('.refresh').on('click', function () {
            var game_id = $(this).data('id');
            var title = $(this).data('title');
            layer.confirm('确定批量发布所有新包吗？这将耗费比较长的时间<br><br><font color="red">发布成功后，将自动推送到客户端升级版本</font>', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '【' + title + '】批量发布新包提示'
            }, function () {
                $.post('?ct=platform&ac=refreshPackage',{game_id:game_id}, function (re) {
                    if (re.state) {
                        layer.confirm('提交成功，批量发布中，是否查看进度？', {
                                btn: ['确定', '取消']
                            },
                            function () {
                                location.href = '?ct=platform&ac=refreshProgress&game_id=' + game_id;
                            },
                            function () {
                                location.reload();
                            });
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        $('.level_up').on('click', function () {
            var game_id = $(this).data('id');
            layer.confirm('确定升级版本？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('?ct=platform&ac=gameLevel',{game_id:game_id}, function (re) {
                    if (re.state) {
                        layer.msg('操作成功');
                        location.reload();
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });

        $('.clear_cache').on('click', function () {
            var game_id = $(this).data('id');
            var title = $(this).data('title');
            layer.confirm('确定更新配置吗？<br><br><font color="red">更新后，新的配置即刻生效</font>', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '【' + title + '】更新配置提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=platform&ac=clearCache',{game_id:game_id}, function (re) {
                    layer.close(index);
                    if (re.state) {
                        layer.msg('更新成功');
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>