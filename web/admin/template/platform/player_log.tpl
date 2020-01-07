<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <form method="get" action="" class="form-inline" id="myForm">
            <input type="hidden" name="ct" value="platform"/>
            <input type="hidden" name="ac" value="playerLog"/>
            <div class="form-group form-group-sm">
                <label>选择游戏</label>
                <{widgets widgets=$widgets}>

                <label>选择区服</label>
                <select class="form-control" name="server_id">
                    <option value="">全 部</option>
                    <{foreach from=$_game_server key=id item=name}>
                <option value="<{$id}>" <{if $data.server_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>选择平台</label>
                <select class="form-control" name="device_type">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.device_type==1}>selected="selected"<{/if}>> IOS</option>
                    <option value="2"
                    <{if $data.device_type==2}>selected="selected"<{/if}>> Andorid </option>
                </select>

                <label>渠道</label>
                <select class="form-control" name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data['channel_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <label>操作</label>
                <select class="form-control" name="opp">
                    <option value="">全部</option>
                    <{foreach from=$h_type key=id item=name}>
                <option <{if $data.opp eq $id}>selected<{/if}> value="<{$id}>"><{$name}></option>
                    <{/foreach}>
                </select>

                <div class="form-group form-group-sm" style="margin-top: 5px;">
                    <label>用户账户</label>
                    <input type="text" class="form-control" name="account" value="<{$data.account}>">

                    <label>角色名</label>
                    <input type="text" class="form-control" name="role_name" value="<{$data.role_name}>">

                    <label>ip</label>
                    <input type="text" class="form-control" name="ip" value="<{$data.ip}>"/>

                    <label>时间</label>
                    <input type="text" style="width: 150px" name="sdate" value="<{$data.sdate}>" class="form-control Wdate"/>~
                    <input type="text" style="width: 150px" name="edate" value="<{$data.edate}>" class="form-control Wdate"/>

                    <button type="button" class="btn btn-primary btn-sm search-btn">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                    </button>
                    <button id="printExcel" type="button" class="btn btn-success btn-sm download">
                        <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导 出
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content">
            <div class="tableDiv">
                <table class="table table-bordered table-hover table-content table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap>账号</th>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏</th>
                        <th nowrap>区服</th>
                        <th nowrap>角色</th>
                        <th nowrap>当前等级</th>
                        <th nowrap>登录游戏</th>
                        <th nowrap>注册游戏</th>
                        <th nowrap>操作</th>
                        <th nowrap>ip</th>
                        <th nowrap>时间</th>
                        <th nowrap>设备号</th>
                        <th nowrap>设备名称</th>
                        <th nowrap>设备版本</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list key=k item=row}>
                        <tr>
                            <td><{$row.username}></td>
                            <td><{$_games.list[$row.parent_id]}></td>
                            <td><{$_games.list[$row.game_id]}></td>
                            <td><{$row.server_id}></td>
                            <td><{$row.role_name}></td>
                            <td><{$row.role_level}></td>
                            <td
                            <{if $row.login_game neq $row.reg_game}> class="text-red"<{/if}>>
                            <{$_games.list[$row.login_game]}>
                            </td>
                            <td><{$_games.list[$row.reg_game]}></td>
                            <td
                            <{if $row.h_type eq 999}>class="text-red" <{/if}> ><{$h_type[$row.h_type]}></td>
                            <td><{$row.ip}></td>
                            <td><{$row.h_time}></td>
                            <td><{$row.device_id}></td>
                            <td><{$row.device_name}></td>
                            <td><{$row.device_version}></td>
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
<{include file="../public/foot.tpl"}>
<script type="text/javascript">
    $('input[name=sdate]').off();
    $('input[name=sdate]').on('click focus', function () {
        WdatePicker({el:this, dateFmt:"yyyy-MM-dd HH:mm:ss"});
    });

    $('input[name=edate]').off();
    $('input[name=edate]').on('click focus', function () {
        WdatePicker({el:this, dateFmt:"yyyy-MM-dd HH:mm:ss"});
    });
    $('#printExcel').click(function () {
        location.href = '?ct=platform&ac=playerLogExcel&parent_id=' +
            $('select[name=parent_id]').val() + '&game_id=' +
            $('select[name=game_id]').val() + '&server_id=' +
            $('select[name=server_id]').val() + '&channel_id=' +
            $('select[name=channel_id]').val() + '&device_type=' +
            $('select[name=device_type]').val() + '&account=' +
            $('input[name=account]').val() + '&opp=' +
            $('select[name=opp]').val() + '&ip=' +
            $('input[name=ip]').val() + '&role_name=' +
            $('input[name=role_name]').val() + '&sdate=' + $('input[name=sdate]').val() + '&edate=' + $('input[name=edate]').val()
    });
    var chose_server =
    <{$data.server_id}>
    $('select[name=game_id]').on('change', function () {
        $.getJSON('?ct=data&ac=getGameServer&game_id=' + $('select[name=game_id]').val(), function (re) {
            var html = '<option value="">全 部</option>';
            $.each(re, function (i, n) {
                var str = '<option value=' + i + '>' + n + '</option>';
                if (i == chose_server) {
                    str = '<option selected="selected" value=' + i + '>' + n + '</option>'
                }
                html += str;
            });
            $('select[name="server_id"]').html(html);
        });
    });
    $(".search-btn").on('click', function () {
        var sdate = $('input[name="sdate"]').val();
        var edate = $('input[name="edate"]').val();
        if (sdate.substr(0, 10) != edate.substr(0, 10)) {
            layer.msg('仅限单天查询!',{time:1000});
            return false;
        }
        $("#myForm").submit();
    })

</script>