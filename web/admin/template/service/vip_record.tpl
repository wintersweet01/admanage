<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">

        <form method="get" action="" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="vipRecord"/>

            <div class="form-group">

                <label>游戏：</label>
                <{widgets widgets=$widgets}>
                <label>姓名：</label>
                <input type="text" name="name" value="<{$data.name}>"/>
                <label>账号：</label>
                <input type="text" name="account" value="<{$data.account}>">
                <label>UID：</label>
                <input type="text" name="uid" value="<{$data.uid}>"/>
                <label>日期：</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> ~
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <button class="btn btn-primary btn-xs" type="submit">筛 选</button>
                <button class="btn btn-success btn-xs download" type="button">导 出</button>
            </div>
            <br/>
            <span>共：<{$data.total}> 条</span>
        </form>
    </div>

    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff" id="tableDiv">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive"
                       style="min-width: 150px">
                    <thead>
                    <tr>
                        <th>母游戏:平台</th>
                        <th>用户ID</th>
                        <th>账号</th>
                        <th>角色名</th>
                        <th>区服</th>
                        <th>未登录游戏的天数</th>
                        <th>联系时间</th>
                        <th>充值总额</th>
                        <th>联系后充值金额</th>
                        <th>当天充值金额</th>
                        <th>最后充值金额</th>
                        <th>最后登陆时间</th>
                        <th>录入时间</th>
                        <th>姓名</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--显示内容-->
                    <{foreach from=$data.list key=key item=row}>
                    <tr>
                        <td><{$row.c_parent_name}> : <{if $row.platform eq 1}>IOS<{else}>安卓<{/if}> </td>
                        <td><{$row.uid}></td>
                        <td><{$row.account}></td>
                        <td><{$row.rolename}></td>
                        <td><{$row.server_id}></td>
                        <td><{$row.login_day}></td>
                        <td><{$row.touch_time}></td>
                        <td><{$row.pays}></td>
                        <td><{$row.charge_ext}></td>
                        <td><{$row.day_charge}></td>
                        <td><{$row.total_fee}></td>
                        <td><{$row.login_time}></td>
                        <td><{$row.insr_time}></td>
                        <td><{$row.kf_name}></td>
                    </tr>
                    <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div>
                <nav>
                    <ul class="pagination">
                        <{$data.page_html nofilter}>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        //导出
        $('.download').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=kfVip&ac=recordDownload',
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
<{include file="../public/foot.tpl"}>