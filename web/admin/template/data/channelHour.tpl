<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data1"/>
            <input type="hidden" name="ac" value="channelHour"/>
            <div class="form-group">
                <label>游戏</label>
                <{widgets widgets=$widgets}>

                <label>渠道</label>
                <select name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data['channel_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>游戏包</label>
                <select name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data['package_name']==$name.package_name}>selected="selected"<{/if}>><{$name.package_name}> </option>
                    <{/foreach}>
                </select>

                <label>投放账户</label>
                <select name="user_id" id="user_id">
                    <option value="">全 部</option>
                    <{foreach from=$data.users item=name}>
                <option value="<{$name.user_id}>" <{if $data['user_id']==$name.user_id}>selected="selected"<{/if}>><{$name.user_name}></option>
                    <{/foreach}>
                </select>

                <label>负责人</label>
                <select name="create_user">
                    <option value="all">全 部</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data['create_user']==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>&nbsp;

                <label>日期</label>
                <input type="text" name="date" value="<{$data.date}>" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>时段</th>
                        <th nowrap>负责人</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>渠道</th>
                        <th nowrap>投放账户</th>
                        <th nowrap>推广活动</th>
                        <th nowrap>包标识</th>
                        <th nowrap>DAU</th>
                        <th nowrap>点击量</th>
                        <th nowrap>激活数</th>
                        <th nowrap>点击激活率<i class="fa fa-question-circle" alt="（激活数/点击）"></i></th>
                        <th nowrap>注册量</th>
                        <th nowrap>点击注册率<i class="fa fa-question-circle" alt="（注册数/点击）"></i></th>
                        <th nowrap>激活注册率<i class="fa fa-question-circle" alt="（注册数/激活数）"></i></th>
                        <th nowrap>创建数</th>
                        <th nowrap>创建率<i class="fa fa-question-circle" alt="（创角数/注册数）"></i></th>
                        <th nowrap>新增付费人数</th>
                        <th nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/注册数）"></i></th>
                        <th nowrap>新增付费金额</i></th>
                        <th nowrap>新增ARPU<i class="fa fa-question-circle" alt="（新增付费金额/注册数）"></i></th>
                        <th nowrap>新增ARPPU<i class="fa fa-question-circle" alt="（新增付费金额/新增付费人数）"></i></th>
                        <th nowrap>更新时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap>合计</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap class="text-danger"><b><{$data.total.login}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.click}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.active}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.active_rate}>%</b></td>
                        <td nowrap class="text-danger"><b><{$data.total.reg}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.reg_rate}>%</b></td>
                        <td nowrap class="text-olive"><b><{$data.total.active_reg_rate}>%</b></td>
                        <td nowrap class="text-danger"><b><{$data.total.new_role}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_role_rate}>%</b></td>
                        <td nowrap class="text-danger"><b><{$data.total.ney_pay}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_pay_rate}>%</b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_money}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_arpu}></b></td>
                        <td nowrap class="text-danger"><b>¥<{$data.total.new_arppu}></b></td>
                        <td nowrap>-</td>
                    </tr>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><b><{$u.hour}></b></td>
                            <td nowrap><{$_admins[$u.create_user]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$_channels[$u.channel_id]}></td>
                            <td nowrap><{$u.user_name}></td>
                            <td nowrap><{$u.monitor_name}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap class="text-danger"><b><{$u.login}></b></td>
                            <td nowrap class="text-danger"><b><{$u.click}></b></td>
                            <td nowrap class="text-danger"><b><{$u.active}></b></td>
                            <td nowrap class="text-olive"><b><{$u.active_rate}>%</b></td>
                            <td nowrap class="text-danger"><b><{$u.reg}></b></td>
                            <td nowrap class="text-olive"><b><{$u.reg_rate}>%</b></td>
                            <td nowrap class="text-olive"><b><{$u.active_reg_rate}>%</b></td>
                            <td nowrap class="text-danger"><b><{$u.new_role}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_role_rate}>%</b></td>
                            <td nowrap class="text-danger"><b><{$u.ney_pay}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_pay_rate}>%</b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_money}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_arpu}></b></td>
                            <td nowrap class="text-danger"><b>¥<{$u.new_arppu}></b></td>
                            <td nowrap><b><{$u.create_time}></b></td>
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
        $("#content-wrapper").scroll(function () {
            var left = $("#content-wrapper").scrollLeft() - 14;//获取滚动的距离
            var trs = $("#tableDiv table tr");//获取表格的所有tr
            if (left == -14) {
                left = 0;
            }
            trs.each(function (i) {
                if (left) {
                    $(this).children().eq(0).css({
                        "position": "relative",
                        "top": "0px",
                        "left": left,
                        "background": "#00FFFF"
                    });
                } else {
                    $(this).children().eq(0).removeAttr('style');
                }
            });
        });

        $('select[name=channel_id]').on('change', function () {
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!channel_id) {
                return false;
            }
            $.getJSON('?ct=data&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="">选择账号</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#user_id').html(html);
            });
        });

        $('select[name=game_id],select[name=channel_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&channel_id=' + channel_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n + '">' + n + '</option>';
                });
                $('#package_id').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>