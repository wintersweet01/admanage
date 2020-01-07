<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="ad"/>
            <input type="hidden" name="ac" value="deliveryUser"/>
            <div class="form-group form-group-sm">
                <label>选择渠道</label>
                <select class="form-control" name="channel_id">
                    <option value="0">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>投放账号</label>
                <select class="form-control" name="user_id" id="user_id">
                    <option value="0">选择账号</option>
                    <{foreach from=$data.users item=name}>
                <option value="<{$name.user_id}>" <{if $data.user_id==$name.user_id}>selected="selected"<{/if}>><{$name.user_name}></option>
                    <{/foreach}>
                </select>

                <!--<label>投放组</label>
                <select name="group_id" id="group_id">
                    <option value="0">全 部</option>
                    <{foreach from=$_groups key=id item=name}>
                <option value="<{$id}>" <{if $data.group_id==$id}>selected="selected"<{/if}>><{$name}> </option>
                    <{/foreach}>
                </select>-->

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>

                <{if SrvAuth::checkPublicAuth('add',false)}>
                <a href="?ct=ad&ac=addDeliveryUser" class="btn btn-success btn-sm" role="button">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加投放账号
                </a>
                <{/if}>

                <{if SrvAuth::checkPublicAuth('audit',false)}>
                <span class="btn btn-danger btn-sm clear_cache">
                    <i class="fa fa-repeat fa-fw" aria-hidden="true"></i>更新缓存
                </span>
                <{/if}>
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
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$_channels[$u.channel_id]}></td>
                            <td><{$u.user_name}></td>
                            <td><{$u.group_name}></td>
                            <td><{if $u.client_id}><{$u.client_id}><{else}>-<{/if}></td>
                            <td><{if $u.account_id}><{$u.account_id}> (<{$u.account_uin}>)<{else}>-<{/if}></td>
                            <td><{if $u.account_id}><{if $u.access_token_expires_in > 0}><{$u.access_token_expires_in}>分钟<{else}>0分钟<{/if}><{else}>-<{/if}></td>
                            <td><{if $u.account_id}><{if $u.refresh_token_expires_in > 0}><{$u.refresh_token_expires_in}>天<{else}>0天<{/if}><{else}>-<{/if}></td>
                            <td><{if $u.time}><{$u.time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td>
                                <{if SrvAuth::checkPublicAuth('edit',false)}>
                                <a href="?ct=ad&ac=addDeliveryUser&user_id=<{$u.user_id}>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑</a>
                                <{*<a href="?ct=ad&ac=addCpUser&user_id=<{$u.user_id}>">创建合作商账号</a>*}>
                                <{if $u.auth_url}>
                                <a href="<{$u.auth_url}>" target="_blank" class="btn btn-danger btn-xs auth"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 账号授权</a>
                                <{if $u.refresh_token_expires_in > 0}>
                                <span class="btn btn-success btn-xs refresh" data-id="<{$u.user_id}>"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
                                <{else}>
                                <span class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
                                <{/if}>
                                <{if $u.access_token_expires_in > 0}>
                                <a href="?ct=ad&ac=channelUserAppList&id=<{$u.user_id}>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 设置数据源</a>
                                <{else}>
                                <span class="btn btn-info btn-xs" disabled="disabled"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 设置数据源</span>
                                <{/if}>
                                <{else}>
                                <span class="btn btn-danger btn-xs" disabled="disabled"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 账号授权</span>
                                <span class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 刷新授权</span>
                                <span class="btn btn-info btn-xs" disabled="disabled"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 设置数据源</span>
                                <{/if}>
                                <a href="javascript:;" data-href="<{$u.auth_url}>" data-acc="<{$u.media_account}>" class="btn btn-danger btn-xs batch-auth"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 批量授权</a>
                                <{/if}>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <{$data.page_html nofilter}>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script>
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
</script>
<{include file="../public/foot.tpl"}>