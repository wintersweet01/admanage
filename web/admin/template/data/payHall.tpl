<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="data"/>
            <input type="hidden" name="ac" value="payHall"/>
            <div class="form-group form-group-sm">
                <{widgets widgets=$widgets}>

                <label>选择服务器</label>
                <select class="form-control" name="server_id" id="server_id">
                    <option value="0">全 部</option>
                    <{foreach from=$data._servers key=id item=name}>
                <option value="<{$id}>" <{if $data.query['server_id']==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>选择平台</label>
                <select class="form-control" name="device_type" style="width: 50px;">
                    <option value="">全 部</option>
                    <option value="1"
                    <{if $data.query['device_type']==1}>selected="selected"<{/if}>> ios </option>
                    <option value="2"
                    <{if $data.query['device_type']==2}>selected="selected"<{/if}>> 安卓 </option>
                </select>

                <label>充值金额</label>
                <input type="number" class="form-control" name="s_charge" style="width:100px" value="<{$data.query['s_charge']}>"/>~
                <input type="number" class="form-control" name="e_charge" style="width: 100px" value="<{$data.query['e_charge']}>"/>

                <div class="form-group form-group-sm" style="margin-top: 5px;">
                    <label>充值日期</label>
                    <input type="text" name="pay_date_start" value="<{$data.query['psdate']}>" class="form-control Wdate"/>
                    ~
                    <input type="text" name="pay_date_end" value="<{$data.query['pedate']}>" class="form-control Wdate">

                    <label>注册日期</label>
                    <input type="text" name="reg_date_start" value="<{$data.query['rsdate']}>" class="form-control Wdate"/>
                    ~
                    <input type="text" name="reg_date_end" value="<{$data.query['redate']}>" class="form-control Wdate">

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="update_pay_total">
                        <i class="fa fa-refresh fa-fw" aria-hidden="true"></i>更新缓存
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" id="down">
                        <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i>导出
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
                        <th>金额</th>
                        <th>UID</th>
                        <th>账号</th>
                        <th>手机号</th>
                        <th>注册时间</th>
                        <th>最后登录时间</th>
                        <th>最后充值时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td><{$u.rank}></td>
                            <td class="text-danger">
                                <a href="?ct=platform&ac=orderList&is_pay=2&uid=<{$u.uid}>&parent_id=<{$data.parent_id}>&game_id=<{$data.game_id}>&server_id=<{$data.server_id}>&device_type=<{$data.device_type}>" target="_blank"><b>¥<{$u.money}></b></a>
                            </td>
                            <td class="show-userinfo" data-keyword="<{$u.uid}>"><{$u.uid}></td>
                            <td class="show-userinfo" data-keyword="<{$u.uid}>"><{$u.username}></td>
                            <td class="show-userinfo" data-keyword="<{$u.uid}>"><{$u.phone}></td>
                            <td><{$u.reg_time}></td>
                            <td><{$u.last_login_time}></td>
                            <td><{$u.last_pay_time}></td>
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

        //更新缓存
        $('#update_pay_total').on('click', function () {
            layer.confirm('确定更新缓存吗？', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                var index = layer.msg('正在更新中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=data&ac=updateUserPayTotal', function (ret) {
                    layer.close(index);
                    layer.alert(ret.msg);
                }, 'json');
            });
        });

        //导出
        $('#down').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=data&ac=payHallDownload',
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