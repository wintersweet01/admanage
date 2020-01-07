<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="material"/>
            <input type="hidden" name="ac" value="materialData"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>搜索上传人</label>
                <select class="form-control" name="upload_user">
                    <option value="">全 部</option>
                    <{foreach from=$_admins key=key item=name}>
                <option value="<{$key}>" <{if $data.upload_user==$key}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>时间</label>
                <input type="text" class="form-control Wdate" name="sdate" value="<{$data.sdate}>" style="width: 100px;"/> -
                <input type="text" class="form-control Wdate" name="edate" value="<{$data.edate}>" style="width: 100px;"/>

                <label>充值时间</label>
                <input type="text" class="form-control Wdate" name="psdate" value="<{$data.psdate}>" style="width: 100px;"/> -
                <input type="text" class="form-control Wdate" name="pedate" value="<{$data.pedate}>" style="width: 100px;"/>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-success btn-sm" id="printExcel"><i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出</button>
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; ">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;" class=table-responsive">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <td nowrap>测试素材名</td>
                        <td nowrap>测试游戏</td>
                        <td nowrap>上传人</td>
                        <td nowrap>测试时间区间</td>
                        <td nowrap>测试关联包名/推广活动</td>
                        <td nowrap>展现</td>
                        <td nowrap>点击</td>
                        <td nowrap>点击率</td>
                        <td nowrap>消耗</td>
                        <td nowrap>注册数</td>
                        <td nowrap>注册率</td>
                        <td nowrap>注册成本</td>
                        <td nowrap>留存数</td>
                        <td nowrap>留存率</td>
                        <td nowrap>留存成本</td>
                        <td nowrap>付费人数</td>
                        <td nowrap>付费率</td>
                        <td nowrap>付费金额</td>
                        <td nowrap>ROI</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><a href="?ct=material&ac=materialBox&material_id=<{$u.material_id}>"><{$u.material_name}></a></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.upload_user}></td>
                            <td nowrap><{$u.time_zone}></td>
                            <td nowrap style="text-align: left;">
                                <{foreach $data['land_list'][$u.material_id] as $v}>
                                <span class="text-danger"><{$v.package_name}></span> / <span
                                    class="text-olive"><{$v.monitor_name}></span><br>
                                <{/foreach}>
                            </td>
                            <td nowrap><{$u.display}></td>
                            <td nowrap><{$u.click}></td>
                            <td nowrap class="text-olive"><b><{$u.click_rate}></b></td>
                            <td nowrap class="text-danger"><b>￥<{$u.cost}></b></td>
                            <td nowrap><{$u.reg}></td>
                            <td nowrap class="text-olive"><b><{$u.reg_rate}></b></td>
                            <td nowrap class="text-danger"><b>￥<{$u.reg_cost}></b></td>
                            <td nowrap><{$u.retain}></td>
                            <td nowrap class="text-olive"><b><{$u.retain_rate}></b></td>
                            <td nowrap class="text-danger"><b>￥<{$u.retain_cost}></b></td>
                            <td nowrap><{$u.count_pay}></td>
                            <td nowrap class="text-olive"><b><{$u.pay_rate}></b></td>
                            <td nowrap class="text-danger"><b>￥<{$u.money}></b></td>
                            <td nowrap class="text-olive"><b><{$u.ROI}></b></td>
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
        $('#printExcel').click(function () {
            location.href = '?ct=material&ac=materialDataExcel&parent_id=' + $('select[name=parent_id]').val() + '&game_id=' + $('select[name=game_id]').val() + '&device_type=' + $('select[name=device_type]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val() + '&sdate=' + $('input[name=psdate]').val() + '&edate=' + $('input[name=pedate]').val();
        });

        $('select[name=game_id],select[name=channel_id]').on('change', function () {
            $.getJSON('?ct=ad&ac=getAllMonitor&game_id=' + $('select[name=game_id]').val() + '&channel_id=' + $('select[name=channel_id]').val(), function (re) {
                var html = '<option value="">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value=' + i + '>' + n + '</option>';
                });
                $('select[name="monitor_id"]').html(html);
            });
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
    });
</script>
<{include file="../public/foot.tpl"}>