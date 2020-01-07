<{include file="../public/header.tpl"}>
<style type="text/css">
    ul.list-group {
        margin-top: 10px;
    }

    ul.list-group li {
        margin-bottom: 2px;
    }

    ul.list-group li span {
        float: right;
        cursor: pointer;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="material_id" value="<{$material_id}>">

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>关联推广链接</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">* 游戏</label>
                    <div class="col-sm-2">
                        <select id="game_id" class="form-control" style="width: 150px;">
                            <option value="">选择游戏</option>
                            <{foreach from=$_games key=id item=name}>
                            <option value="<{$id}>"><{$name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="device_type" class="col-sm-2 control-label">* 游戏平台</label>
                    <div class="col-sm-2">
                        <select id="device_type" class="form-control" style="width: 150px;">
                            <option value="">游戏平台</option>
                            <option value="1">IOS</option>
                            <option value="2">Android</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="user_id" class="col-sm-2 control-label">* 推广活动</label>
                    <div class="col-sm-4">
                        <select id="monitor_id" class="form-control" style="width: 150px;">
                            <option value="">选择推广活动</option>
                        </select>
                        <ul class="list-group">
                            <{foreach $_bindList as $u}>
                            <li class="list-group-item m<{$u.monitor_id}>">
                                【<{$_games[$u.game_id]}>】【<{if $u.device_type == 1}>IOS<{else}>Android<{/if}>】<{$u.monitor_name}>
                                <input type="hidden" name="monitor_id[]" value="<{$u.monitor_id}>">
                                <input type="hidden" name="game_id[]" value="<{$u.game_id}>">
                                <input type="hidden" name="device_type[]" value="<{$u.device_type}>">
                                <input type="hidden" name="package_name[]" value="<{$u.package_name}>">
                                <span class="glyphicon glyphicon-remove delMonitor" aria-hidden="true"></span>
                            </li>
                            <{/foreach}>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        var getPackage = function () {
            var game_id = $('#game_id option:selected').val();
            var device_type = $('#device_type option:selected').val();
            var _games = <{$_games|@json_encode nofilter}>;

            if (!game_id || !device_type) {
                $('#monitor_id').html('<option value="">选择推广活动</option>');
                return false;
            }

            $.getJSON('?ct=material&ac=getMonitor&game_id=' + game_id + '&device_type=' + device_type, function (re) {
                var html = '<option value="">选择推广活动</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.monitor_id + '" data-gid="' + game_id + '" data-os="' + device_type + '" data-package="' + n.package_name + '">' + n.name + '</option>';
                });
                $('#monitor_id').html(html).off().on('change', function () {
                    var e = $(this);
                    var obj = e.parent().find('ul.list-group');
                    var selected = e.find('option:selected');
                    var monitor_id = e.val();
                    var game_id = selected.data('gid');
                    var device_type = selected.data('os');
                    var package_name = selected.data('package');
                    var text = selected.text();
                    var os = device_type == 1 ? 'IOS' : 'Android';
                    var str = '<li class="list-group-item m' + monitor_id + '">【' + _games[game_id] + '】【' + os + '】' + text +
                        '<input type="hidden" name="monitor_id[]" value="' + monitor_id + '">' +
                        '<input type="hidden" name="game_id[]" value="' + game_id + '">' +
                        '<input type="hidden" name="device_type[]" value="' + device_type + '">' +
                        '<input type="hidden" name="package_name[]" value="' + package_name + '">' +
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' +
                        '</li>';
                    if (!obj.find('.m' + monitor_id).length) {
                        obj.append(str).find('.m' + monitor_id + ' span').on('click', function () {
                            $(this).parent('li').remove();
                        });
                    }
                });
            });
        }

        $('ul.list-group li span').on('click', function () {
            $(this).parent('li').remove();
        });

        $('#device_type,#game_id').on('change', function () {
            getPackage();
        });

        $('#submit').on('click', function () {
            if ($('ul.list-group li').length == 0) {
                layer.tips('请选择推广活动', '#monitor_id',{tips: [1, '#ff0000']});
                return false;
            }

            $.post('?ct=material&ac=bindMaterial', $('form').serializeArray(), function (re) {
                if (re.state == true) {
                    layer.msg(re.msg);
                    setTimeout(function () {
                        location.href = document.referrer
                    }, 1500);
                    return false;
                } else {
                    layer.msg(re.msg);
                    return false;
                }
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });
    });
</script>
<{include file="../public/foot.tpl"}>