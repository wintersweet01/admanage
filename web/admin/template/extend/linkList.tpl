<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="extend"/>
            <input type="hidden" name="ac" value="linkList"/>
            <input type="hidden" name="status" value="<{$data.status}>"/>
            <div class="form-group form-group-sm">
                <{widgets widgets=$widgets}>

                <label>游戏包</label>
                <select class="form-control" name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data.package_name==$name.package_name}>selected="selected"<{/if}>> <{$name.package_name}> </option>
                    <{/foreach}>
                </select>

                <label>选择渠道</label>
                <select class="form-control" name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>投放账号</label>
                <select class="form-control" name="user_id" id="user_id">
                    <option value="">选择账号</option>
                    <{foreach from=$data.users item=name}>
                <option value="<{$name.user_id}>" <{if $data.user_id==$name.user_id}>selected="selected"<{/if}>><{$name.user_name}></option>
                    <{/foreach}>
                </select>

                <label>负责人</label>
                <select class="form-control" name="create_user" class="form-control" style="width:60px;">
                    <option value="all">选择负责人</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data.create_user==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>&nbsp;

                <label>关键字</label>
                <input type="text" class="form-control" name="keyword" value="<{$data.keyword}>" placeholder="推广名称/ID/游戏包"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-primary btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
            <div class="form-group form-group-sm" style="margin-top: 5px;">
                <{if SrvAuth::checkPublicAuth('add',false)}>
                <a href="?ct=extend&ac=addLink" class="btn btn-primary btn-sm" role="button"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加推广链</a>
                <{/if}>
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
                    <{foreach from=$data.list item=u}>
                        <tr id="<{$u.monitor_id}>">
                            <td nowrap><input type="checkbox" name="all" id="row_<{$u.monitor_id}>" value="<{$u.monitor_id}>"></td>
                            <td nowrap><{$u.monitor_id}></td>
                            <td nowrap><{$u.name}></td>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap>
                                <{if $u.platform == 1}><span class="icon_ios"></span>
                                <{elseif $u.platform == 2}><span class="icon_android"></span>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap><{$_channels[$u.channel_id]}></td>
                            <td nowrap><{if $u.model_name}><{$u.model_name}><{else}>-<{/if}></td>
                            <td nowrap><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap><{$u.administrator}></td>
                            <td nowrap>
                                <{if $u.jump_url}>
                                <span data-url="<{$u.jump_url}>" data-title="<{$u.name}>"
                                      class="preview btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"
                                                                                   aria-hidden="true"></span> 预览</span>
                                <button type="button" class="copy btn btn-primary btn-xs"
                                        data-clipboard-text="<{$u.jump_url}>">
                                    <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> 复制
                                </button>
                                <{else}> - <{/if}>
                            </td>
                            <td nowrap>
                                <span class="copy btn btn-danger btn-xs" data-clipboard-text="<{$u.short_url}>"><span
                                            class="glyphicon glyphicon-link" aria-hidden="true"></span> 短链</span>
                                <span class="copy btn btn-primary btn-xs" data-clipboard-text="<{$u.monitor_url}>"><span
                                            class="glyphicon glyphicon-copy" aria-hidden="true"></span> 监测地址</span>
                                <span class="copy download_url btn btn-warning btn-xs"
                                      data-clipboard-text="<{$u.download_url}>"><span
                                            class="glyphicon glyphicon-download-alt"
                                            aria-hidden="true"></span> 包地址</span>
                                <{if $u.jump_url}>
                                <span data-url="<{$u.local_url}>" data-title="<{$u.name}>"
                                      class="preview btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"
                                                                                   aria-hidden="true"></span> 本地预览</span>
                                <{else}>
                                <span class="btn btn-success btn-xs" disabled="disabled"><span
                                            class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 本地预览</span>
                                <{/if}>
                                <{if SrvAuth::checkPublicAuth('edit',false)}>
                                <a href="?ct=extend&ac=channelLog&monitor_id=<{$u.monitor_id}>"
                                   class="btn btn-info btn-xs" target="_blank"><span
                                            class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 回调日志</a>
                                <a href="?ct=extend&ac=addLink&monitor_id=<{$u.monitor_id}>"
                                   class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"
                                                                        aria-hidden="true"></span> 编辑</a>
                                <span data-id="<{$u.monitor_id}>" class="stop btn btn-warning btn-xs"><span
                                            class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> 停用</span>
                                <{/if}>
                                <{if SrvAuth::checkPublicAuth('del',false)}>
                                <span data-id="<{$u.monitor_id}>" class="del btn btn-danger btn-xs"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</span>
                                <{/if}>
                            </td>
                        </tr>
                        <{/foreach}>
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
                        <{$data.page_html nofilter}>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
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
</script>
<{include file="../public/foot.tpl"}>