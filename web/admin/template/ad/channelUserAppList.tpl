<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <{if SrvAuth::checkPublicAuth('add',false)}>
            <a href="?ct=ad&ac=channelAddUserApp&id=<{$data.user_id}>" class="btn btn-primary btn-small" role="button"> + 创建数据源</a>
            <{/if}>
            <{*<span data-id="<{$data.user_id}>" class="btn btn-success btn-small channelAddUserApp" role="button"> + 获取数据源</span>*}>
            <span data-id="<{$data.user_id}>" class="btn btn-success btn-small clearCacheChannelUserApp" role="button"> 更新缓存</span>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>应用ID <i class="fa fa-question-circle" alt="腾讯社交广告的应用ID"></i></th>
                        <th nowrap>账号ID <i class="fa fa-question-circle" alt="广告主账号ID"></i></th>
                        <th nowrap>MOBILE_APP_ID
                            <i class="fa fa-question-circle" alt="应用id，IOS：App Store id；ANDROID：应用宝id"></i></th>
                        <th nowrap>用户行为源id</th>
                        <th nowrap>行为源类型</th>
                        <th nowrap>描述</th>
                        <th nowrap>添加时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$data.client_id}></td>
                            <td nowrap><{$u.account_id}></td>
                            <td nowrap><{$u.mobile_app_id}></td>
                            <td nowrap><{$u.user_action_set_id}></td>
                            <td nowrap><{$u.type}></td>
                            <td nowrap><{$u.description}></td>
                            <td nowrap><{if $u.create_time}><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
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
        $('.channelAddUserApp').on('click', function () {
            var user_id = $(this).data('id');
            layer.confirm('确定从广告主账号获取数据源吗？', {
                btn: ['确定', '取消']
            }, function () {
                layer.load();
                $.post('?ct=ad&ac=channelGetUserApp', {
                    id: user_id
                }, function (re) {
                    layer.closeAll();
                    if (re.state == false) {
                        layer.alert(re.msg);
                    } else {
                        layer.open({
                            type: 1,
                            title: false,
                            closeBtn: 0,
                            shadeClose: true,
                            content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                            time: 3000,
                            end: function () {
                                location.href = '?ct=ad&ac=channelUserAppList&id=' + user_id;
                            }
                        });
                    }
                }, 'json');
            });
        });

        //更新缓存
        $('.clearCacheChannelUserApp').on('click', function () {
            var user_id = $(this).data('id');
            layer.load();
            $.post('?ct=ad&ac=clearCacheChannelUserApp', {
                id: user_id
            }, function (re) {
                layer.closeAll();
                layer.alert(re.msg);
            }, 'json');
        });
    });
</script>
<{include file="../public/foot.tpl"}>