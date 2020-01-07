<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="dataDay"/>
            <div class="form-group form-group-sm">
                <label>游戏</label>
                <{widgets widgets=$widgets}>

                <label>渠道</label>
                <select class="form-control" name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data['channel_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>投放账户</label>
                <select class="form-control" name="user_id" id="user_id">
                    <option value="">选择账号</option>
                    <{foreach from=$data.users item=name}>
                <option value="<{$name.user_id}>" <{if $data['user_id']==$name.user_id}>selected="selected"<{/if}>><{$name.user_name}></option>
                    <{/foreach}>
                </select>

                <label>负责人</label>
                <select class="form-control" name="create_user">
                    <option value="">选择负责人</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data['create_user']==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>&nbsp;

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>日期</th>
                        <th nowrap>负责人</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>渠道</th>
                        <th nowrap>投放账户</th>
                        <th nowrap>包标识</th>
                        <th nowrap>消耗</th>
                        <th nowrap>展示</th>
                        <th nowrap>点击</th>
                        <th nowrap>点击率<i class="fa fa-question-circle" alt="（点击/展示）"></i></th>
                        <th nowrap>激活数</th>
                        <th nowrap>点击激活率<i class="fa fa-question-circle" alt="（激活数/点击）"></i></th>
                        <th nowrap>激活成本<i class="fa fa-question-circle" alt="（消耗/激活数）"></i></th>
                        <th nowrap>注册</th>
                        <th nowrap>点击注册率<i class="fa fa-question-circle" alt="（注册数/点击）"></i></th>
                        <th nowrap>激活注册率<i class="fa fa-question-circle" alt="（注册数/激活数）"></i></th>
                        <th nowrap>注册成本<i class="fa fa-question-circle" alt="（消耗/注册数）"></i></th>
                        <th nowrap>角色创建数</th>
                        <th nowrap>创建率<i class="fa fa-question-circle" alt="（创角数/注册数）"></i></th>
                        <th nowrap>创角成本<i class="fa fa-question-circle" alt="（消耗/创角数）"></i></th>
                        <th nowrap>新增付费人数</th>
                        <th nowrap>新增付费率<i class="fa fa-question-circle" alt="（新增付费人数/注册数）"></i></th>
                        <th nowrap>新增付费金额</i></th>
                        <th nowrap>新增ROI<i class="fa fa-question-circle" alt="（新增付费金额/消耗）"></i></th>
                        <th nowrap>首日LTV<i class="fa fa-question-circle" alt="（新增付费金额/注册数）"></i></th>
                        <th nowrap>新增付费成本<i class="fa fa-question-circle" alt="（消耗/新增付费人数）"></i></th>
                        <th nowrap>次日留存率<i class="fa fa-question-circle" alt="（次日留存/注册数）"></i></th>
                        <th nowrap>留存成本<i class="fa fa-question-circle" alt="（消耗/次日留存）"></i></th>
                        <th nowrap>eCPM<i class="fa fa-question-circle" alt="（消耗/(展示/1000)）"></i></th>
                        <th nowrap>每CPM激活数<i class="fa fa-question-circle" alt="（激活数/(展示/1000)）"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td nowrap><b>合计</b></td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap>-</td>
                        <td nowrap class="text-danger"><b><{$data.total.cost}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.display}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.click}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.click_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.active}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.active_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.active_cost}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.reg}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.reg_rate}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.active_reg_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.reg_cost}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.new_role}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_role_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.new_role_cost}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.count_pay}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_pay_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_roi_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.new_ltv}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.pay_cost}></b></td>
                        <td nowrap><b class="text-danger"><{$data.total.retain}></b> / <b
                                    class="text-olive"><{$data.total.retain_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.retain_cost}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.ecpm_cost}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.active_cpm}></b></td>
                    </tr>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$_admins[$u.create_user]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$_channels[$u.channel_id]}></td>
                            <td nowrap><{$u.user_name}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap class="text-danger"><b><{$u.cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.display}></b></td>
                            <td nowrap class="text-danger"><b><{$u.click}></b></td>
                            <td nowrap class="text-olive"><b><{$u.click_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.active}></b></td>
                            <td nowrap class="text-olive"><b><{$u.active_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.active_cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.reg}></b></td>
                            <td nowrap class="text-olive"><b><{$u.reg_rate}></b></td>
                            <td nowrap class="text-olive"><b><{$u.active_reg_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.reg_cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.new_role}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_role_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.new_role_cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.count_pay}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_pay_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_roi_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.new_ltv}></b></td>
                            <td nowrap class="text-danger"><b><{$u.pay_cost}></b></td>
                            <td nowrap><b class="text-danger"><{$u.retain}></b> / <b
                                        class="text-olive"><{$u.retain_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.retain_cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.ecpm_cost}></b></td>
                            <td nowrap class="text-danger"><b><{$u.active_cpm}></b></td>
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
            var w = 0;
            var e = trs.children();
            for (var i = 0; i < 5; i++) {
                w += e.eq(i).outerWidth();
            }

            trs.each(function (i) {
                if (left > w) {
                    $(this).children().eq(5).css({
                        "position": "relative",
                        "top": "0px",
                        "left": left - w,
                        "background": "#FFFF00"
                    });
                } else {
                    $(this).children().eq(5).removeAttr('style');
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
    });
</script>
<{include file="../public/foot.tpl"}>