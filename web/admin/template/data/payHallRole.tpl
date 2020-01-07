<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="payHallRole"/>
            <div class="form-group form-group-sm">
                <{widgets widgets=$widgets}>

                <label>选择服务器</label>
                <select class="form-control" name="server_id" id="server_id">
                    <option value="0">全 部</option>
                    <{foreach from=$query.servers key=id item=name}>
                <option value="<{$id}>" <{if $query.server_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $query.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2"
                    <{if $query.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>金额</label>
                <input type="number" class="form-control" name="s_charge" style="width:100px" value="<{$query.s_charge}>"/>
                ~
                <input type="number" class="form-control" name="e_charge" style="width: 100px" value="<{$query.e_charge}>"/>

                <div class="form-group form-group-sm" style="margin-top: 5px;">
                    <label>充值日期</label>
                    <input type="text" name="pay_date_start" value="<{$query.pay_date_start}>" class="form-control Wdate" style="width: 100px;"/>
                    ~
                    <input type="text" name="pay_date_end" value="<{$query.pay_date_end}>" class="form-control Wdate" style="width: 100px;"/>

                    <label>注册日期</label>
                    <input type="text" name="reg_date_start" value="<{$query.reg_date_start}>" class="form-control Wdate" style="width: 100px;"/>
                    ~
                    <input type="text" name="reg_date_end" value="<{$query.reg_date_end}>" class="form-control Wdate" style="width: 100px;"/>

                    <lable>角色名称</lable>
                    <input type="text" class="form-control" name="role_name" value="<{$query.role_name}>"/>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="down">
                        <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导 出
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; min-width: 100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>排名</th>
                        <th>UID</th>
                        <th>账号</th>
                        <th>注册时间</th>
                        <th>母游戏</th>
                        <th>子游戏</th>
                        <th>平台</th>
                        <th>服务器ID</th>
                        <th>角色名称</th>
                        <th>角色ID</th>
                        <th>角色等级</th>
                        <th>充值金额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$u.rank}></td>
                            <td><{$u.uid}></td>
                            <td><{$u.username}></td>
                            <td><{$u.reg_date}></td>
                            <td><{$_games[$u.parent_id]}></td>
                            <td><{$_games[$u.game_id]}></td>
                            <td><{if $u.device_type eq 1}>IOS<{elseif $u.device_type eq 2}>安卓<{/if}></td>
                            <td><{$u.server_id}></td>
                            <td class="copy" data-clipboard-text="<{$u.role_name}>"><{$u.role_name}></td>
                            <td><{$u.role_id}></td>
                            <td><{$u.role_level}></td>
                            <td class="text-danger">
                                <a href="?ct=platform&ac=orderList&is_pay=2&game_id=<{$query.game_id}>&server_id=<{$u.server_id}>&role_name=<{$u.role_name}>&sdate=<{$query.pay_date}>&edate=<{$query.pay_date}>"><b>¥<{$u.money}></b></a>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
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
<script>
    $(function () {
        /*$('select[name=game_id]').on('change', function () {
            var game_id = $('select[name=game_id] option:selected').val();
            if (!game_id) {
                return false;
            }
            $.getJSON('?ct=data&ac=getGameServer&game_id=' + game_id, function (re) {
                var html = '<option value="0">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html);
            });
        });*/
        $('#widgets_children_id').on('change', function () {
            var game_id = [];
            $("#widgets_children_id option").each(function(){
                if($(this).prop('selected')){
                    game_id.push($(this).val());
                }
            });
            $.getJSON('?ct=data&ac=getGameServerBatch&game_id='+JSON.stringify(game_id),function(re){
                var html = '<option value="0">全部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + i + '">' + n + '</option>';
                });
                $('#server_id').html(html);
            })
        });

        //导出
        $('#down').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=data&ac=payHallRoleDownload',
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
    });
</script>
<{include file="../public/foot.tpl"}>