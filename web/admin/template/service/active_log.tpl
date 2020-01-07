<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="service"/>
            <input type="hidden" name="ac" value="activeLog"/>
            <div class="form-group form-group-sm">
                <label>激活时间</label>
                <input type="text" name="date" value="<{$data.date}>" class="form-control Wdate" style="width: 100px;"/>
                <label>设备号<i class="fa fa-question-circle" alt="IMEI或者IDFA"></i></label>
                <input type="text" class="form-control" name="device_id" value="<{$data.device_id}>" style="width: 250px;"/>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style=" background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏</th>
                        <th nowrap>平台</th>
                        <th nowrap>包版本</th>
                        <th nowrap>SDK版本</th>
                        <th nowrap>激活地区</th>
                        <th nowrap>激活IP</th>
                        <th nowrap>激活时间</th>
                        <th nowrap>设备名称</th>
                        <th nowrap>设备版本</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap>
                                <{if $u.device_type == 1}><span class="icon_ios"></span>
                                <{elseif $u.device_type == 2}><span class="icon_android"></span>
                                <{else}>-<{/if}>
                            </td>
                            <td nowrap><{$u.package_version}></td>
                            <td nowrap><{$u.sdk_version}></td>
                            <td nowrap><{$u.active_city}></td>
                            <td nowrap><{$u.active_ip}></td>
                            <td nowrap><{$u.active_time|date_format:"%Y/%m/%d %H:%M:%S"}></td>
                            <td nowrap><{$u.device_name}></td>
                            <td nowrap><{$u.device_version}></td>
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

    });
</script>
<{include file="../public/foot.tpl"}>