<{include file="../public/header.tpl"}>
<style>
    label {
        /*margin-left: 5px;*/
    }
</style>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <form method="get" action="" id="myForm" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="vipManage"/>

            <div class="form-group">
                <label>选择游戏：</label>
                <{widgets widgets=$widgets}>

                <label>选择归属人：</label>
                <select name="belong_id">
                    <option value="">全部</option>
                    <{foreach from=$_admins key=key item=rows}>
                <option <{if $key eq $data.belong_id}>selected="selected"<{/if}> value="<{$key}>"><{$rows.name}></option>
                    <{/foreach}>
                </select>

                <label>选择录入人：</label>
                <select name="insr_id">
                    <option value="">全部</option>
                    <{foreach from=$_admins key=key item=rows}>
                <option <{if $key eq $data.insr_id}>selected="selected"<{/if}> value="<{$key}>"><{$rows.name}></option>
                    <{/foreach}>
                </select>

                <label>颜色选择</label>
                <select name="list_color" class="list-color">
                    <option value="">全部</option>
                    <option value="1" <{if $data.list_color eq 1}>selected="selected"<{/if}> >绿色</option>
                    <option value="2" <{if $data.list_color eq 2}>selected="selected"<{/if}> >黄色</option>
                    <option value="3" <{if $data.list_color eq 3}>selected="selected"<{/if}> >粉色</option>
                </select>

                <label>账号：</label>
                <input type="text" name="account" value="<{$data.account}>">

                <label>用户ID：</label>
                <input type="text" name="uid" value="<{$data.uid}>">
                <label>日期：</label>
                <input type="text" name="sdate" value="<{$data.sdate}>" class="Wdate"/> ~
                <input type="text" name="edate" value="<{$data.edate}>" class="Wdate"/>

                <button type="submit" class="btn btn-primary btn-xs">筛 选</button>
                <button type="button" class="btn btn-success btn-xs download">导 出</button>
            </div>
        </form>
        <div class="rows" style="margin-bottom: 0.8%">
            <span class="text-success">绿色：5天未充值</span>&nbsp;
            <span class="text-yellow">黄色：10天未充值</span>&nbsp;
            <span style="color: #FF82AB">粉色：30天未充值</span>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;">
        <{if SrvAuth::checkPublicAuth('add',false)}>
        <a href="?ct=kfVip&ac=vipInsr" role="button">
            <span class="btn btn-sm btn-success glyphicon glyphicon-plus">VIP录入</span>
            <{/if}>
        </a>
        <{if SrvAuth::checkPublicAuth('del',false)}>
        <button class="btn btn-sm btn-danger glyphicon glyphicon-trash batch-del">
            批量删除
        </button>
        <{/if}>
        <{if SrvAuth::checkPublicAuth('edit',false)}>
        <button class="btn btn-sm btn-warning glyphicon glyphicon-check batch-pass">
            批量审核
        </button>
        <{/if}>
        <span style="margin-left: 16px;position: relative;top: 2px;">共：<{$data.total}>条</span>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%">
            <div style="background-color: #fff" id="tableDiv">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive"
                       style="min-width: 150px;">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="batch-check" title="全选"/></th>
                        <th>母游戏:平台</th>
                        <th>账号</th>
                        <th>用户ID</th>
                        <th>角色名</th>
                        <th>区服</th>
                        <th>联系时间</th>
                        <th>归属人</th>
                        <th>录入人</th>
                        <th>录入时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list key=key item=row}>
                    <tr
                        <{if $row.status eq 2}>
                        <{if $row.pay_day_ret gte 5 and $row.pay_day_ret lt 10}>
                        style="background-color:#3c763d"
                        <{elseif $row.pay_day_ret gte 10 and $row.pay_day_ret lt 30}>
                        style="background-color:#f39c12"
                        <{elseif $row.pay_day_ret gte 30}>
                        style="background-color:#FF82AB"
                        <{/if}>
                        <{/if}> >
                        <td><input type="checkbox" class="total_check" value="<{$row.id}>"/></td>
                        <td><{$_games[$row.game_id]}>:<{if $row.platform eq 1}>IOS<{else}>安卓<{/if}></td>
                        <td><{$row.account}></td>
                        <td><{$row.uid}></td>
                        <td><{$row.rolename}></td>
                        <td><{$row.server_id}></td>
                        <td><{$row.touch_time}></td>
                        <td>
                            <{$_admins[$row.admin_id]['name']}>
                        </td>
                        <td><{$_admins[$row.insr_kefu]['name']}></td>
                        <td><{$row.insr_time}></td>
                    <td <{if $row.status eq 2}>class=""<{/if}> ><{$status[$row.status]}></td>
                        <td>
                            <a href="?ct=kfVip&ac=vipInsr&game_id=<{$row.game_id}>&model_id=<{$row.id}>"
                               class="btn btn-success btn-xs" data-id="<{$row.id}>">查看</a>
                            |
                            <button class="btn btn-danger btn-xs cancel" data-id="<{$row.id}>">撤销</button>
                        </td>
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
        $('.check-req').on('click', function () {
            var data = {
                'type': $(this).attr('hand_type'),
                'data_id': $(this).attr('data-id')
            };
            $.ajax({
                type: 'post',
                url: '?ct=kfVip&ac=check',
                data: data,
                dataType: 'json',
                success: function (e) {
                    if (e.code == 200) {
                        layer.alert('更新成功', {icon: 6}, function () {
                            window.location.reload();
                        });
                    } else {
                        layer.alert(e.msg, {icon: 5});
                    }
                }
            });
        });

        $(".batch-check").on('click', function () {
            var _this = $(this);
            if (_this.prop('checked')) {
                $(".total_check").prop("checked", true);
            } else {
                $(".total_check").prop("checked", false);
            }
        });

        $(".batch-del").on('click', function () {
            var batch_check = [];
            var _this = $(this);
            $(".total_check").each(function () {
                if ($(this).prop('checked')) {
                    batch_check.push($(this).val())
                }
            });
            if (batch_check.length > 0) {
                layer.confirm('确认删除？', function () {
                    $.ajax({
                        type: 'post',
                        url: '?&ct=kfVip&ac=batch_del',
                        dataType: 'json',
                        data: {
                            'ids': batch_check
                        },
                        beforeSend: function () {
                            _this.attr('disabled', true);
                            _this.addClass('disabled');
                        },
                        success: function (re) {
                            console.log(re);
                            layer.msg(re.msg, {
                                icon: 1,
                                time: 1000
                            });
                            window.location.reload();
                        },
                        complete: function () {
                            _this.attr('disabled', false);
                            _this.removeClass('disabled');
                        }
                    })
                })
            }
        });

        $(".cancel").on('click', function () {
            var _this = $(this);
            layer.confirm('确认删除？', function () {
                $.ajax({
                    type: 'post',
                    url: '?ct=kfVip&ac=cancel',
                    data: {
                        'data_id': _this.attr('data-id')
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        _this.attr('disabled', true);
                        _this.addClass('disabled');
                    },
                    success: function (re) {
                        if (re.state) {
                            layer.alert(re.msg, {icon:6}, function () {
                                window.location.reload();
                            })
                        } else {
                            layer.alert(re.msg, {icon:5})
                        }
                    },
                    complete: function () {
                        _this.attr('disabled', false);
                        _this.addClass('disabled');
                    }
                });
                layer.close(index);
            });
        });

        $(".batch-pass").on('click',function(){
            layer.confirm('确认审核已勾选？',function(){
                layer.closeAll();
                var checkid = [];
                var _this = $(this);
                $(".total_check").each(function () {
                    if ($(this).prop('checked')) {
                        checkid.push($(this).val())
                    }
                });
                $.ajax({
                    type:'post',
                    dateType:'json',
                    url:'?ct=kfVip&ac=batch_pass',
                    data:{
                        'ids':checkid
                    },
                    beforeSend:function(){
                        _this.attr('disabled', true);
                        _this.addClass('disabled');
                    },
                    success:function(e){
                        var re = JSON.parse(e);
                        if(re.state == 1){
                            layer.alert(re.msg, {icon:6}, function () {
                                window.location.reload();
                            })
                        }
                    },
                    complete:function(){
                        _this.attr('disabled', false);
                        _this.addClass('disabled');
                    }
                })
            })
        });

        $(".list-color").change(function(){
            $("#myForm").submit();
        });

        //导出
        $('.download').on('click', function () {
            layer.msg('正在导出中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.ajax({
                url: '?ct=kfVip&ac=vipListDownload',
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
    })
</script>
<{include file="../public/foot.tpl"}>

