<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="service"/>
            <input type="hidden" name="ac" value="roleList"/>

            <div class="form-group form-group-sm">
                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> ios </option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> 安卓 </option>
                </select>

                <label>角色名称</label>
                <input type="text" class="form-control" name="role_name" value="<{$data.role_name}>" style="width: 120px;"/>

                <label>用户账号</label>
                <input type="text" class="form-control" name="username" value="<{$data.username}>" style="width: 120px;"/>

                <label>注册时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate" style="width: 100px;"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate" style="width: 100px;"/>

                <label class="checkbox-inline">
                    <input type="checkbox" name="has_pay" value="1" <{if $data.has_pay==1}>checked="checked"<{/if}> />
                    只显示充值过的角色
                </label>

                <label class="checkbox-inline">
                    <input type="checkbox" name="has_phone" value="1" <{if $data.has_phone==1}>checked="checked"<{/if}> />
                    只显示绑定手机的玩家
                </label>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>UID</th>
                        <th nowrap>账号</th>
                        <{if $data.has_phone==1}>
                        <th nowrap>手机号</th>
                        <{/if}>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏</th>
                        <th nowrap>区服</th>
                        <th nowrap>角色</th>
                        <th nowrap>创建时间</th>
                        <th nowrap>当前等级</th>
                        <th nowrap>所属平台</th>
                        <th nowrap>注册地区</th>
                        <th nowrap>注册IP</th>
                        <th nowrap>注册时间</th>
                        <{*<th nowrap>最后充值时间</th>*}>
                        <{*<th nowrap>总充值</th>*}>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <{if !$u.uid}><{continue}><{/if}>
                        <tr>
                            <td nowrap><{$u.uid}></td>
                            <td nowrap class="show-userinfo" data-keyword="<{$u.uid}>"><{$u.username|truncate:15}></td>
                            <{if $data.has_phone==1}>
                            <td nowrap><{if $u.phone}><{$u.phone}><{else}>-<{/if}></td>
                            <{/if}>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.server_name}></td>
                            <td nowrap><{$u.role_name}></td>
                            <td nowrap><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap><{$u.role_level}></td>
                            <td nowrap>
                                <{if $u.device_type == 1}><span class="icon_ios"></span>
                                <{elseif $u.device_type == 2}><span class="icon_android"></span>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap><{$u.reg_city}></td>
                            <td nowrap><{$u.reg_ip}></td>
                            <td nowrap><{$u.reg_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <{*<td nowrap><{if $u.pay_time}><{$u.pay_time|date_format:"%Y/%m/%d %H:%M:%S"}> <{else}>-<{/if}></td>*}>
                            <{*<td nowrap class="text-danger">*}
                                {*<{if $u.pays > 0}>*}
                                {*<a href="?ct=service&ac=orderList&username=<{$u.username}>"><b>¥<{$u.pays/100}></b></a>*}
                                {*<{else}>-<{/if}>*}
                            {*</td>*}>
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
<script>
    $(function () {
        $('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }

            $.getJSON('?ct=platform&ac=getGameServers&game_id=' + game_id, function (re) {
                var html = '<option value="">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html);
            });
        });
    });
</script>
<{include file="../public/foot.tpl"}>