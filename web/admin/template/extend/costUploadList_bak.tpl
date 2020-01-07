<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">

        <form method="get" action="">
            <input type="hidden" name="ct" value="extend"/>
            <input type="hidden" name="ac" value="costUploadList"/>
            <div class="form-group">
                <{widgets widgets=$widgets}>

                <label>游戏包</label>
                <select name="package_name" id="package_id">
                    <option value="">全 部</option>
                    <{foreach from=$data._packages item=name}>
                <option value="<{$name.package_name}>" <{if $data.package_name==$name.package_name}>selected="selected"<{/if}>> <{$name.package_name}> </option>
                    <{/foreach}>
                </select>

                <label>选择渠道</label>
                <select name="channel_id">
                    <option value="">全 部</option>
                    <{foreach from=$_channels key=id item=name}>
                <option value="<{$id}>" <{if $data.channel_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <label>负责人</label>
                <select name="create_user" class="form-control" style="width:60px;">
                    <option value="all">选择负责人</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data.create_user==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>&nbsp;

                <label>日期</label>
                <input type="text" name="date" value="<{$data.date}>" class="Wdate" />

                <button type="submit" class="btn btn-primary btn-xs"> 筛 选</button>
            </div>
            <div class="form-group">
                <span id="del_all" class="btn btn-danger btn-small"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除所选</span>
                <a href="?ct=extend&ac=costUpload" class="btn btn-primary btn-small" role="button"> + 上传成本 </a>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%;">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap><a href="javascript:" id="all_check">全选</a></th>
                        <th nowrap>日期</th>
                        <th nowrap>母游戏</th>
                        <th nowrap>游戏名称</th>
                        <th nowrap>游戏包</th>
                        <th nowrap>所属平台</th>
                        <th nowrap>渠道名称</th>
                        <th nowrap>推广名称</th>
                        <th nowrap>成本（元）</th>
                        <th nowrap>展示量</th>
                        <th nowrap>点击量</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u name=foo}>
                        <tr>
                            <td nowrap><input type="checkbox" name="all" value="<{$u.id}>"></td>
                            <td nowrap><{$u.date}></td>
                            <td nowrap><{$_games[$u.parent_id]}></td>
                            <td nowrap><{$u.game_name}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap>
                                <{if $u.device_type == 1}><span class="icon_ios"></span>
                                <{elseif $u.device_type == 2}><span class="icon_android"></span>
                                <{else}>-
                                <{/if}>
                            </td>
                            <td nowrap><{$u.channel_name}></td>
                            <td nowrap><{$u.monitor_name}></td>
                            <td nowrap><{$u.cost_yuan}></td>
                            <td nowrap><{$u.display}></td>
                            <td nowrap><{$u.click}></td>
                            <td nowrap>
                                <a href="javascript:" class="del btn btn-danger btn-xs" data-id="<{$u.id}>"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除</a>
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
                $('#package_id').html(html).trigger('change');
            });
        });

        //删除
        $('.del').on('click', function () {
            var id = $(this).data('id');
            del(id);
        });

        //批量删除
        $('#del_all').on('click', function () {
            var ids = [];
            $('input[type="checkbox"]:checked').each(function () {
                ids.push($(this).val());
            });
            if (ids.length == 0) {
                layer.msg('请勾选一个以上');
                return false;
            }
            del(ids.join());
        });

        $('#all_check').on('click', function () {
            $("input[type='checkbox']").prop("checked", function (i, val) {
                return !val;
            });
        });

        //删除
        function del(id) {
            layer.confirm('删除后无法恢复，确定删除吗？', {
                btn: ['是的', '取消']
            }, function () {
                var index = layer.msg('正在删除...', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
                $.post('?ct=extend&ac=costUploadDel', {
                    id: id
                }, function (re) {
                    layer.close(index);
                    if (re.state == true) {
                        location.reload();
                    } else {
                        layer.msg(re.msg);
                    }
                }, 'json');
            });
        }
    });
</script>
<{include file="../public/foot.tpl"}>