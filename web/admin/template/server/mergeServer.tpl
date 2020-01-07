<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>合服操作</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-3 control-label">* 所属游戏</label>
                    <div class="col-sm-5 input-group">

                        <select name="game_id">
                            <option value="">选择游戏</option>
                            <{foreach from=$_games key=id item=name}>
                        <option value="<{$id}>" <{if $data['info']['game_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;

                    </div>
                </div>

                <div class="form-group">
                    <label for="model_name" class="col-sm-3 control-label">* 所需合并区服选择</label>
                    <div class="col-sm-8 input-group">
                        <a href="javascript:" class="all_sel">全选</a> &nbsp;<a href="javascript:" class="diff_sel">反选</a><br>
                        <figure class="highlight">
                            &nbsp;&nbsp;&nbsp;<span id="server_id"></span>
                        </figure>
                    </div>
                </div>

                <div class="form-group">
                    <label for="model_type" class="col-sm-3 control-label">* 合并后的主服</label>
                    <div class="col-sm-5 input-group">
                        <label class="radio-inline">
                            <select name="merge_server_id" id="merge_server_id">
                                <option value="">选择主服</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="model_name" class="col-sm-3 control-label">* 选择日期</label>
                    <div class="col-sm-5 input-group">
                        <input type="text" name="date" value="" class="Wdate">
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="button" id="submit" class="btn btn-primary"> 确 定</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
                </div>
            </form>
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

            $.getJSON('?ct=platform&ac=getGameServers&game_id=' + game_id, function (re) {
                var html = '';
                $.each(re, function (i, n) {
                    html += '<label class="checkbox-inline"><input onclick="checked_server();" name="server_id[]" type="checkbox" value="' + i + '"><span>' + n + '</span></input></label>';
                });
                $('#server_id').html(html);
            });
        });

        $('#submit').on('click', function () {
            var game_id = $('select[name=game_id]').val();
            var server_id = $('input[type=checkbox]:checked').length;
            var date = $('input[name=date]').val();
            if (!game_id) {
                layer.msg('请选择游戏');
                return false;
            }
            if (server_id < 2) {
                layer.msg('请选择两个以上区服');
                return false;
            }
            if (!date) {
                layer.msg('请选择合服日期');
                return false;
            }

            var data = $('form').serialize();
            $.post('?ct=server&ac=mergeServerAct',{data:data}, function (re) {

                if (re.state) {
                    layer.msg(re.msg);
                    setTimeout(function () {
                        location.href = document.referrer
                    }, 2000);
                    return false;
                }
                layer.msg(re.msg);
            }, 'json');
        });
        $('.all_sel').on('click', function () {
            $('input[name="server_id[]"]').prop('checked', true);
            checked_server();
        });

        $('.diff_sel').on('click', function () {
            $('input[name="server_id[]"]').each(function () {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            });
            checked_server();
        });
        $('#cancel').on('click', function () {
            history.go(-1);
        });
    });

    function checked_server() {
        var checked = $('input[type=checkbox]:checked');
        var html = '';
        checked.each(function () {
            html += '<option value=' + $(this).val() + '>' + $(this).next().html() + '</option>'
        })
        $('#merge_server_id').html(html);
    }
</script>
<{include file="../public/foot.tpl"}>
