<{include file='../public/header.tpl'}>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <span style="font-weight: 600;">正在查看 <e class="text-danger">《归属人：<{$_admins[$param.kfid]['name']}>》</e> 的 <span
                    class="text-danger"> PGID=<{$param.parent_id}> SDATE=<{$param.sdate}> EDATE=<{$param.edate}></span> 用户联系明细</span>
        <form method="get" action="" class="form-inline" style="margin-bottom: 0.8%">
            <input type="hidden" name="ct" value="kfVip">
            <input type="hidden" name="ac" value="viewUserLink">
            <input type="hidden" name="kfid" value="<{$param.kfid}>">
            <input type="hidden" name="parent_id" value="<{$param.parent_id}>">
            <input type="hidden" name="server_id" value="<{$param.server_id}>">
            <input type="hidden" name="sdate" value="<{$param.sdate}>">
            <input type="hidden" name="edate" value="<{$param.edate}>">
            <label>联系状态</label>
            <select name="status">
                <option value="">全部</option>
                <{foreach from=$_status key=key item=rows}>
            <option <{if $data.status eq $key}>selected="selected"<{/if}> value="<{$key}>">
                <{if $key eq 1}>
                未联系
                <{elseif $key eq 2}>
                已联系
                <{/if}>
                </option>
                <{/foreach}>
            </select>

            <label>用户UID</label>
            <input type="text" name="uid" value="<{$data.uid}>"/>
            <button type="submit" class="btn btn-primary btn-xs">筛选</button>
            <button type="button" class="btn btn-success btn-xs download">导出</button>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff" id="tableDiv">
                <table class="table table-bordered layui-table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>母游戏:平台</th>
                        <th>用户ID</th>
                        <th>角色名:角色ID</th>
                        <th>区服</th>
                        <th>达标时间</th>
                        <th>账号</th>
                        <th>最后登录时间</th>
                        <th>联系状态</th>
                        <th>联系时间</th>
                        <th>录入人</th>
                        <th>累计充值</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.normal key=key item=nrows}>
                        <tr>
                            <td><{$_games[$nrows.parent_id]}>:<{if $nrows.device_type eq 1}>IOS<{elseif $nrows.device_type eq 2}>安卓<{/if}>
                            </td>
                            <td><{$nrows.uid}></td>
                            <td><{$nrows.role_name}>:<{$nrows.role_id}></td>
                            <td><{$nrows.server_id}></td>
                            <td><{$data.reach_time[$key]['reach_time']}></td>
                            <td><{$nrows.account}></td>
                            <td><{$data.login_charge[$key]['login_time']}></td>
                            <td>
                                <{if $nrows.status eq 2 and $nrows.touch_time != '' and $nrows.insr_kefu != ''}>
                                已联系
                                <{else}>
                                未联系
                                <{/if}>
                            </td>
                            <td>
                                <{if $nrows.touch_time}>
                                <{$nrows.touch_time}>
                                <{else}>
                                --
                                <{/if}>
                            </td>
                            <td><{if $nrows.insr_kefu}><{$_admins[$nrows.insr_kefu]['name']}><{else}>--<{/if}></td>

                            <td><{$nrows.t_fee}></td>
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
<{include file="../public/foot.tpl"}>
<script type="text/javascript">
    $(function(){
        //导出
        $('.download').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=kfVip&ac=userLinkDownload',
                type: "POST",
                data: $('form').serializeArray(),
                dataType: "json",
                success: function (ret) {
                    layer.msg(ret.message);
                    if (ret.code == 1) {
                        setTimeout(function () {
                            window.location.href = ret.data.url;
                        }, 1500);
                    }
                },
                error: function (res) {
                    layer.msg('网络繁忙');
                }
            });
        });
    })
</script>