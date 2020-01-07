<{include file="../public/header.tpl"}>
<style>
    .comm_check {
        margin: 2px 2px 4px 30px;
        vertical-align: middle;
        margin-top: -3px !important;
        margin-top: 0px;
    }

    ;
</style>
<div id="areascontent">
    <div class="rows" style="overflow: hidden">
        <span>正在给后台人员：<e class="text-red" style="font-weight: 600"><{$_admins[$author_id]['name']}></e> 进行区服授权</span>
        <form method="get" id="game_select" action="" class="form-inline" style="margin-bottom: 10px">
            <input type="hidden" name="ct" value="kfVip"/>
            <input type="hidden" name="ac" value="authorPower">
            <input type="hidden" name="author_id" value="<{$author_id}>">
            <input type="hidden" name="parent_id" value="<{$parent_id}>">
            <div class="form-group">
                <label>母游戏：</label>
                <{widgets widgets=$widgets}>
                <button type="submit" class="btn btn-primary btn-xs">筛选</button>
            </div>
        </form>
    </div>
    <div style="margin-bottom: 0.8%">
        <button class="btn btn-primary btn-sm commit-btn">确认提交</button>
    </div>
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div class="table-content" style="float: left;width: 100%;">
            <div style="background-color: #fff">
                <table class="table table-bordered layui-table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th style="width: 30%">母游戏</th>
                        <th>区服选择</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$parent_server key=pid item=row}>
                        <tr>
                            <td><{$_games['list'][$pid]}><input type="checkbox" style="margin-left: 4px"
                                                                class="comm_check parent_checked" name="parent_id"
                                                                title="全选" value="<{$pid}>" />
                            </td>
                            <td style="text-align: left" class="game_server_box">
                                <{foreach from=$row key=platform item=server_info}>
                                <fieldset>
                                    <legend style="font-size: 15px;font-weight: 400">
                                        <{if $platform eq 1}><span class="icon_ios" style="margin-left: 10px"></span>IOS
                                        <{elseif $platform eq 2}><span class="icon_android"
                                                                       style="margin-left: 10px"></span>安卓
                                        <{/if}>
                                        <input type="checkbox" class="comm_check platform_checked" title="全选" />
                                    </legend>
                                    <{foreach from=$server_info key=k item=server_chunk}>
                                    <div class="server_box">
                                        <{foreach from=$server_chunk key=k2 item=server}>
                                        <span><{$server}></span><input type="checkbox" class="comm_check server_input"
                                                                       style="margin-left: 2px;margin-right: 2%"
                                                                       name="server_id[<{$pid}>][<{$platform}>][]"
                                                                       value="<{$pid|cat:"_"|cat:$platform|cat:"_"|cat:$server}>"
                                        <{if in_array($pid|cat:"_"|cat:$platform|cat:"_"|cat:$server,$admin_select)}>
                                            checked="checked"
                                        <{/if}> />
                                        <{/foreach}>
                                    </div>
                                    <{/foreach}>
                                    <span class="text-blue more-btn" style="cursor: pointer;" data-num="<{$_page}>"
                                          data-plat="<{$platform}>" data-parent="<{$pid}>">----显示更多---</span>
                                </fieldset>
                                <{/foreach}>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("span").on('click', function () {
            var _this = $(this);
            var comm = _this.next('input');
            if (comm) {
                if (comm.prop('checked')) {
                    comm.prop('checked', false)
                } else {
                    comm.prop('checked', true);
                }
            }
        });
        //母游戏下全选
        $(".parent_checked").on('click', function () {
            var _this = $(this);
            var serobj = _this.parent('td').next('td');

            if (_this.prop('checked')) {
                serobj.children('fieldset').each(function () {
                    $(this).children('legend').find('input').prop('checked', true);
                    $(this).children('div .server_box').find('input').prop('checked', true);
                })
            } else {
                serobj.children('fieldset').each(function () {
                    $(this).children('legend').find('input').prop('checked', false);
                    $(this).children('div .server_box').find('input').prop('checked', false);
                })
            }
        });

        //平台选择
        $(".platform_checked").on('click', function () {
            var obj = $(this).parent('legend').siblings('div .server_box');
            console.log(obj);
            if ($(this).prop('checked')) {
                obj.each(function () {
                    $(this).find('input').prop('checked', true);
                })
            } else {
                obj.each(function () {
                    $(this).find('input').prop('checked', false);
                })
            }
        });
        $(".more-btn").on('click', function () {
            var _this = $(this);
            var num = $(this).attr("data-num");
            var plat = $(this).attr('data-plat');
            var parent_id = $(this).attr('data-parent');
            if (!parent_id || !plat) {
                return false;
            }
            var data = {
                'more': num,
                'platform': plat,
                'parent_id': parent_id,
                'author_id': $("input[name='author_id']").val()
            };
            $.get("?&ct=kfVip&ac=more_server", data, function (re) {
                var str = '';
                var data = re.list;
                if (typeof data != 'undefined' && data.length > 0) {
                    for (var i in data) {
                        var span = '';
                        for (var j in data[i]) {
                            var input = '';
                            var index = parent_id + '_' + plat + '_' + data[i][j].server_id;
                            if (in_array(index, re.ac)) {
                                input = '<input type="checkbox" class="comm_check server_input" checked="checked" style="margin-left: 2px;margin-right: 2%" value="' + index + '" name="server_id[' + parent_id + '][' + plat + '][]">'
                            } else {
                                input = '<input type="checkbox" class="comm_check server_input" style="margin-left: 2px;margin-right: 2%" value="' + index + '" name="server_id[' + parent_id + '][' + plat + '][]">'
                            }
                            span += '<span>' + data[i][j].server_id + '</spna>' + input;
                        }
                        str += '<div class="server_box">' + span + '</div>';
                    }

                    _this.attr('data-num', re.more);
                    _this.before(str);
                } else {
                    layer.msg('没有啦！',{time:1000});
                }
            }, 'json')
        });
        //获取勾选
        $(".commit-btn").on('click', function () {
            var _this = $(this);
            layer.confirm('确认提交?', function () {
                var checked = [];
                var checked_info = [];
                $(".server_input").each(function () {
                    var value = $(this).val();
                    if ($(this).prop('checked')) {
                        checked.push(value);
                        checked_info.push(value+"_y")
                    }else{
                        checked_info.push(value+'_n')
                    }

                });
                $.ajax({
                    type: 'post',
                    url: '?&ct=kfVip&ac=authorPower',
                    dataType: 'json',
                    data: {
                        'data': JSON.stringify(checked),
                        'info': JSON.stringify(checked_info),
                        'parent_id': $("input[name='parent_id']").val(),
                        'author_id': $("input[name='author_id']").val()
                    },
                    beforeSend: function () {
                        _this.attr('disabled', true);
                        _this.addClass('layui-btn-disabled')
                    },
                    success: function (re) {
                        if (re.err_code == '200') {
                            window.location.reload();
                        } else {
                            layer.alert(re.msg, {icon: 5});
                        }
                    },
                    complete: function () {
                        _this.attr('disabled', false);
                        _this.addClass('layui-btn-disabled');
                    }
                });
                layer.closeAll();
            })
        })

        $("#widgets_game_id").change(function(){
            $("#game_select").submit();
        })
    });

    function in_array(search, array) {
        for (var i in array) {
            if (array[i] == search) {
                return true;
            }
        }
        return false;
    }
</script>
<{include file="../public/foot.tpl"}>