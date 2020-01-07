<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data5"/>
            <input type="hidden" name="ac" value="external2"/>
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

                <label>时间</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate"/>

                <label>归类方式</label>
                <select class="form-control" name="type">
                    <option value="1"
                    <{if $data.type==1}>selected="selected"<{/if}>>按日期</option>
                    <option value="2"
                    <{if $data.type==2}>selected="selected"<{/if}>>按推广链</option>
                </select>

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>名称</th>
                        <th nowrap>激活设备数</th>
                        <th nowrap>注册设备数</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{if $data.total}>
                        <tr style="font-weight: bold;">
                            <td nowrap>合计</td>
                            <td nowrap><{$data.total.active_device}></td>
                            <td nowrap><{$data.total.reg_device}></td>
                        </tr>
                        <{/if}>
                    <{foreach $data.list as $u}>
                        <tr>
                            <td nowrap><{$u.group_name}></td>
                            <td nowrap><{$u.active_device}></td>
                            <td nowrap><{$u.reg_device}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<{include file="../public/foot.tpl"}>