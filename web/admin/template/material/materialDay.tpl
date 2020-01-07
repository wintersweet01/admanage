<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="material"/>
            <input type="hidden" name="ac" value="materialDay"/>
            <div class="form-group form-group-sm">
                <label>游戏</label>
                <{widgets widgets=$widgets}>

                <label>渠道</label>
                <select class="form-control" name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>制作人</label>
                <select name="upload_user" class="form-control">
                    <option value="">全部制作人</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data.upload_user==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>制作日期</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate" /> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate" />

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
                        <th nowrap rowspan="2" colspan="1">日期</th>
                        <th nowrap rowspan="2" colspan="1">所选游戏</th>
                        <th nowrap rowspan="2" colspan="1">所选渠道</th>
                        <th nowrap rowspan="1" colspan="9">类型统计</th>
                        <th nowrap rowspan="1" colspan="2">需求统计</th>
                        <th nowrap rowspan="1" colspan="2">平均数据反馈</th>
                    </tr>
                    <tr>
                        <{foreach from=$_types key=id item=name}>
                        <th nowrap><{$name}></th>
                        <{/foreach}>
                        <th nowrap>原创构思</th>
                        <th nowrap>需求下单</th>
                        <th nowrap>点击率<i class="fa fa-question-circle" alt="（点击数/曝光数）"></i></th>
                        <th nowrap>点击注册率<i class="fa fa-question-circle" alt="（注册数/点击数）"></i></th>
                    </tr>

                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.make_date}></td>
                            <td nowrap><{if $data.game_id}><{$_games[$data.game_id]}><{else}>全部<{/if}></td>
                            <td nowrap><{if $data.channel_id}><{$_channels[$data.channel_id]}><{else}>全部<{/if}></td>
                            <{foreach $_types as $key => $type}>
                            <td nowrap><{$u["type<{$key}>"]}></td>
                            <{/foreach}>
                            <td nowrap><{$u.source1}></td>
                            <td nowrap><{$u.source2}></td>
                            <td nowrap class="text-olive"><b><{$u.click_rate}>%</b></td>
                            <td nowrap class="text-olive"><b><{$u.reg_rate}>%</b></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<{include file="../public/foot.tpl"}>