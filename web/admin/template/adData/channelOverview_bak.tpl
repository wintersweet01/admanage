<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 10px; overflow: hidden;">
        <form method="get" action="">
            <input type="hidden" name="ct" value="adData"/>
            <input type="hidden" name="ac" value="channelOverview"/>
            <div class="form-group">
                <{widgets widgets=$widgets}>

                <label>手机系统</label>
                <select name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data['device_type']==1}>selected="selected"<{/if}>>IOS</option>
                    <option value="2"
                    <{if $data['device_type']==2}>selected="selected"<{/if}>>Android</option>
                </select>

                <label>渠道</label>
                <select name="channel_id[]" id="channel_id" multiple="multiple">
                    <{foreach from=$data._channels key=id item=name}>
                <option value="<{$id}>" <{if (is_array($data.channel_id) && $id|in_array:$data.channel_id) || $data.channel_id==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>投放账号</label>
                <select name="user_id[]" id="user_id" style="width: 150px;" multiple="multiple">
                    <{foreach from=$data._users key=id item=name}>
                <option value="<{$id}>" <{if (is_array($data.user_id) && $id|in_array:$data.user_id) || $data.user_id==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>推广活动</label>
                <select name="monitor_id[]" id="monitor_id" style="width: 150px;" multiple="multiple">
                    <{foreach from=$data._monitors key=id item=name}>
                <option value="<{$id}>" <{if (is_array($data.monitor_id) && $id|in_array:$data.monitor_id) || $data.monitor_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>投放组</label>
                <select name="group_id[]" id="group_id" multiple="multiple">
                    <{foreach from=$data._groups key=id item=name}>
                <option value="<{$id}>" <{if (is_array($data.group_id) && $id|in_array:$data.group_id) || $data.group_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>
            </div>

            <div class="form-group">
                <label>注册日期</label>
                <input type="text" name="rsdate" value="<{$data.rsdate}>" class="Wdate"/> -
                <input type="text" name="redate" value="<{$data.redate}>" class="Wdate"/>

                <label>充值日期</label>
                <input type="text" name="psdate" value="<{$data.psdate}>" class="Wdate"/> -
                <input type="text" name="pedate" value="<{$data.pedate}>" class="Wdate"/>
            </div>

            <div class="form-group">
                <label>自定义列</label>
                <select name="custom">
                    <option value="">全 部</option>
                </select>

                <label>归类方式</label>
                <select name="type">
                    <option value="8"
                    <{if $data.type==8}>selected="selected"<{/if}>>按母游戏</option>
                    <option value="1"
                    <{if $data.type==1}>selected="selected"<{/if}>>按子游戏</option>
                    <option value="2"
                    <{if $data.type==2}>selected="selected"<{/if}>>按手机系统</option>
                    <option value="3"
                    <{if $data.type==3}>selected="selected"<{/if}>>按渠道</option>
                    <option value="4"
                    <{if $data.type==4}>selected="selected"<{/if}>>按账号</option>
                    <option value="5"
                    <{if $data.type==5}>selected="selected"<{/if}>>按推广活动</option>
                    <option value="6"
                    <{if $data.type==6}>selected="selected"<{/if}>>按投放组</option>
                    <option value="7"
                    <{if $data.type==7}>selected="selected"<{/if}>>按注册日期</option>
                </select>

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
                <button type="button" class="btn btn-primary btn-xs" id="down"> 导出EXCEL</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div id="tableDiv" style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>归类方式</th>
                        <th nowrap colspan="12">转化数据</th>
                        <th nowrap colspan="6">首日付费数据</th>
                        <th nowrap colspan="4">周期付费数据</th>
                        <th nowrap colspan="4">累计付费数据</th>
                        <th nowrap colspan="2">活跃付费数据</th>
                        <th nowrap colspan="27">运营数据</th>
                    </tr>
                    <tr>
                        <th nowrap>名称</th>
                        <th nowrap>加载数 <i class="fa fa-question-circle" alt="落地页加载数"></i></th>
                        <th nowrap>IP数 <i class="fa fa-question-circle" alt="落地页IP数"></i></th>
                        <th nowrap>点击 <i class="fa fa-question-circle" alt="落地页点击数"></i></th>
                        <th nowrap>激活数</th>
                        <th nowrap>激活设备数</th>
                        <th nowrap>点击激活率</th>
                        <th nowrap>注册数</th>
                        <th nowrap>注册设备数</th>
                        <th nowrap>点击注册率</th>
                        <th nowrap>激活注册率</th>
                        <th nowrap>消耗</th>
                        <th nowrap>注册单价</th>
                        <th nowrap>新增付费额</th>
                        <th nowrap>新增回本率</th>
                        <th nowrap>新增付费人数</th>
                        <th nowrap>新增付费率</th>
                        <th nowrap>新增ARPU</th>
                        <th nowrap>新增ARPPU</th>
                        <th nowrap>周期付费额</th>
                        <th nowrap>周期回本率</th>
                        <th nowrap>周期付费人数</th>
                        <th nowrap>周期付费率</th>
                        <th nowrap>累计付费额</th>
                        <th nowrap>累计回本率</th>
                        <th nowrap>累计付费人数</th>
                        <th nowrap>累计付费率</th>
                        <th nowrap>活跃付费人数</th>
                        <th nowrap>活跃付费金额</th>
                        <{foreach $day as $d}>
                        <{if $d == 1}><{continue}><{/if}>
                        <th nowrap><{$d}>日留存</th>
                        <{/foreach}>
                        <{foreach $day as $d}>
                        <th nowrap>LTV<{$d}></th>
                        <{/foreach}>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="font-weight: bold;background-color: #fff3cd;">
                        <td nowrap>合计</td>
                        <td nowrap><{$data.total.load}></td>
                        <td nowrap><{$data.total.ip}></td>
                        <td nowrap><{$data.total.click}></td>
                        <td nowrap><{$data.total.active}></td>
                        <td nowrap><{$data.total.active_device}></td>
                        <td nowrap class="text-olive"><b><{$data.total.click_active_rate}></b></td>
                        <td nowrap>
                            <{if $data.total.reg > 0}>
                            <{$data.total.reg}>
                            <a href="?ct=adData&ac=queryUser&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                            <{/if}>
                        </td>
                        <td nowrap><{$data.total.device}></td>
                        <td nowrap class="text-olive"><b><{$data.total.click_reg_rate}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.active_reg_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.consume}></b></td>
                        <td nowrap><{$data.total.reg_cost}></td>
                        <td nowrap class="text-danger"><b><{$data.total.new_pay_money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.new_pay_back_rate}></b></td>
                        <td nowrap>
                            <{if $data.total.new_pay_count > 0}>
                            <{$data.total.new_pay_count}>
                            <a href="?ct=adData&ac=queryPay&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                            <{/if}>
                        </td>
                        <td nowrap class="text-olive"><b><{$data.total.new_pay_rate}></b></td>
                        <td nowrap><{$data.total.new_pay_arpu}></td>
                        <td nowrap><{$data.total.new_pay_arppu}></td>
                        <td nowrap class="text-danger"><b><{$data.total.period_pay_money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.period_pay_back_rate}></b></td>
                        <td nowrap><{$data.total.period_pay_count}></td>
                        <td nowrap class="text-olive"><b><{$data.total.period_pay_rate}></b></td>
                        <td nowrap class="text-danger"><b><{$data.total.total_pay_money}></b></td>
                        <td nowrap class="text-olive"><b><{$data.total.total_pay_back_rate}></b></td>
                        <td nowrap>
                            <{if $data.total.total_pay_count > 0}>
                            <{$data.total.total_pay_count}>
                            <a href="?ct=adData&ac=queryTotalPay&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                            <{/if}>
                        </td>
                        <td nowrap class="text-olive"><b><{$data.total.total_pay_rate}></b></td>
                        <td nowrap>
                            <{if $data.total.active_pay_count > 0}>
                            <{$data.total.active_pay_count}>
                            <a href="?ct=adData&ac=queryActive&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                            <{/if}>
                        </td>
                        <td nowrap class="text-danger"><b><{$data.total.active_pay_money}></b></td>
                        <{foreach $day as $d}>
                        <{if $d == 1}><{continue}><{/if}>
                        <td nowrap><{$data.total["retain<{$d}>"]}> /
                            <b class="text-olive"><{$data.total["retain_rate<{$d}>"]}></b>
                        </td>
                        <{/foreach}>
                        <{foreach $day as $d}>
                        <td nowrap><{$data.total["ltv<{$d}>"]}></td>
                        <{/foreach}>
                    </tr>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.group_name}></td>
                            <td nowrap><{$u.load}></td>
                            <td nowrap><{$u.ip}></td>
                            <td nowrap><{$u.click}></td>
                            <td nowrap><{$u.active}></td>
                            <td nowrap><{$u.active_device}></td>
                            <td nowrap class="text-olive"><b><{$u.click_active_rate}></b></td>
                            <td nowrap>
                                <{if $u.reg > 0}>
                                <{$u.reg}>
                                <a href="?ct=adData&ac=queryUser&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&field=<{$u.field}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                                <{/if}>
                            </td>
                            <td nowrap><{$u.device}></td>
                            <td nowrap class="text-olive"><b><{$u.click_reg_rate}></b></td>
                            <td nowrap class="text-olive"><b><{$u.active_reg_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.consume}></b></td>
                            <td nowrap><{$u.reg_cost}></td>
                            <td nowrap class="text-danger"><b><{$u.new_pay_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.new_pay_back_rate}></b></td>
                            <td nowrap>
                                <{if $u.new_pay_count > 0}>
                                <{$u.new_pay_count}>
                                <a href="?ct=adData&ac=queryPay&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&field=<{$u.field}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                                <{/if}>
                            </td>
                            <td nowrap class="text-olive"><b><{$u.new_pay_rate}></b></td>
                            <td nowrap><{$u.new_pay_arpu}></td>
                            <td nowrap><{$u.new_pay_arppu}></td>
                            <td nowrap class="text-danger"><b><{$u.period_pay_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.period_pay_back_rate}></b></td>
                            <td nowrap><{$u.period_pay_count}></td>
                            <td nowrap class="text-olive"><b><{$u.period_pay_rate}></b></td>
                            <td nowrap class="text-danger"><b><{$u.total_pay_money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.total_pay_back_rate}></b></td>
                            <td nowrap>
                                <{if $u.total_pay_count > 0}>
                                <{$u.total_pay_count}>
                                <a href="?ct=adData&ac=queryTotalPay&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&field=<{$u.field}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                                <{/if}>
                            </td>
                            <td nowrap class="text-olive"><b><{$u.total_pay_rate}></b></td>
                            <td nowrap>
                                <{if $u.active_pay_count > 0}>
                                <{$u.active_pay_count}>
                                <a href="?ct=adData&ac=queryActive&rsdate=<{$data.rsdate}>&redate=<{$data.redate}>&field=<{$u.field}>&type=<{$data.type}>&device_type=<{$data.device_type}>&parent_id=<{","|implode:$data.parent_id}>&children_id=<{","|implode:$data.children_id}>&channel_id=<{","|implode:$data.channel_id}>&user_id=<{","|implode:$data.user_id}>&monitor_id=<{","|implode:$data.monitor_id}>&group_id=<{","|implode:$data.group_id}>" target="_blank">查</a>
                                <{/if}>
                            </td>
                            <td nowrap class="text-danger"><b><{$u.active_pay_money}></b></td>
                            <{foreach $day as $d}>
                            <{if $d == 1}><{continue}><{/if}>
                            <td nowrap><{$u["retain<{$d}>"]}> / <b class="text-olive"><{$u["retain_rate<{$d}>"]}></b>
                            </td>
                            <{/foreach}>
                            <{foreach $day as $d}>
                            <td nowrap><{$u["ltv<{$d}>"]}></td>
                            <{/foreach}>
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
<script>
    var game_id = 0;
    var channel_id = 0;

    $(function () {
        $("#content-wrapper").scroll(function () {
            var left = $("#content-wrapper").scrollLeft() - 14;//获取滚动的距离
            var trs = $("#tableDiv table tr");//获取表格的所有tr
            var e = trs.children();
            var w0 = e.eq(0).outerWidth();
            var w3 = 0;

            for (var i = 0; i < 3; i++) {
                w3 += e.eq(i).outerWidth();
            }

            trs.each(function (i) {
                if (left > w0) {
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

        $('#widgets_children_id').on({
            "select2:select": function (e) {
                game_id = e.params.data.id;
                getMonitor(game_id, channel_id);
            },
            "select2:unselect": function (e) {
                var gid = e.params.data.id;
                removeMonitor(gid, 0);
            }
        });

        $('#channel_id').on({
            "select2:select": function (e) {
                channel_id = e.params.data.id;
                $.getJSON('?ct=adData&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                    var html = '';
                    $.each(re, function (i, n) {
                        html += '<option value="' + n.user_id + '" cid="' + channel_id + '">' + n.user_name + '</option>';
                    });
                    $('#user_id').append(html).trigger('change');
                });

                getMonitor(game_id, channel_id);
            },
            "select2:unselect": function (e) {
                var cid = e.params.data.id;
                $('#user_id').find("option[cid='" + cid + "']").remove();

                removeMonitor(0, cid);
            }
        });
    });

    //子游戏删除回调
    function childrenRemoveCallback(data) {
        $.each(data, function (i, n) {
            removeMonitor(n, 0);
        });
    }

    //获取推广活动列表
    function getMonitor(gid, cid) {
        if (!gid && !cid) {
            return false;
        }

        var e = $('#monitor_id');
        $.getJSON('?ct=ad&ac=getAllMonitor&game_id=' + gid + '&channel_id=' + cid, function (re) {
            var html = '';
            $.each(re, function (i, n) {
                var o = e.find("option[value='" + i + "']");
                if (o.length) {
                    o.attr('gid', gid);
                    o.attr('cid', cid);
                    return true;
                }

                html += '<option value="' + i + '" gid="' + gid + '" cid="' + cid + '">' + n + '</option>';
            });
            e.append(html).trigger('change');
        });
    }

    //删除推广活动列表
    function removeMonitor(gid, cid) {
        var e = $('#monitor_id');
        if (gid) {
            e.find("option[gid='" + gid + "']").remove();
        }
        if (cid) {
            e.find("option[cid='" + cid + "']").remove();
        }
    }
</script>
<{include file="../public/foot.tpl"}>