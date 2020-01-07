<{include file="../public/header.tpl"}>
<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui/layui.js"></script>
<style type="text/css">
    .highlight {
        float: left;
        width: 100%;
    }

    label.checkbox-inline {
        float: left;
        width: 80px;
        margin: 5px 0 !important;
        display: inline;
    }

    h5 {
        clear: both;
        margin: 5px 0;
        font-weight: bold;
    }
</style>
<div class="container" style="margin-top: 15px;">
    <div class="row" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="post" action="" class="form-inline">
            <div class="form-group form-group-sm">
                <label>选择投放组：</label>
                <select class="form-control" id="select-group">
                    <option value="0">全 部</option>
                    <{foreach $data.list as $row}>
                    <option value="<{$row.id}>"> <{$row.text}></option>
                    <{/foreach}>
                </select>
                <button type="button" class="btn btn-primary btn-sm" id="submit">保存</button>
            </div>
        </form>
        <div id="table-transfer"></div>
    </div>
    <div class="row" style="margin-bottom: 0.8%; overflow: hidden;">
        <{foreach $data.list as $parent}>
        <div class="col-lg-3 col-sm-9">
            <h5><{$parent.text}></h5>
            <figure class="highlight">
                <{foreach $parent.children as $children}>
                <label class="checkbox-inline"><{$children.text}></label>
                <{/foreach}>
            </figure>
        </div>
        <{/foreach}>
    </div>
</div>
<script>
    layui.config({
        version: '2019032020'
    }).extend({
        transfer: '<{$smarty.const.CDN_STATIC_URL}>lib/layui/ext/transfer'
    }).use(['transfer', 'layer', 'form'], function () {
        var data = JSON.parse('<{$data|@json_encode nofilter}>');
        var transfer = layui.transfer;
        var layer = layui.layer;
        var tableIns = transfer.render({
            elem: "#table-transfer",
            cols: [
                {type: 'checkbox', fixed: 'left'},
                {field: 'text', title: '账号'}
            ],
            data: [], //[左表数据,右表数据[非必填]]
            tabConfig: {
                'page': false,
                'limit': 0,
                'limits': [10, 50, 100],
                'height': 400
            }
        })

        $('#select-group').on('change', function () {
            var options = transfer.options,
                group_id = $(this).val(),
                group = data.list,
                admin = data.admin,
                data1 = [],
                data2 = [];

            if (group_id > 0) {
                $.each(group[group_id].children, function (k, v) {
                    data2.push(v);
                    $.each(admin, function (i, n) {
                        if (i == v.id) {
                            delete admin[i];
                            return false;
                        }
                    });
                });
                $.each(admin, function (i, n) {
                    data1.push({
                        'id': i,
                        'text': n
                    });
                });
            }

            var arr = [];
            var limit = data1.length + data2.length;
            if (limit) {
                arr = [data1, data2];
            }

            options.data = arr;
            options.tabConfig.limit = limit;
            transfer.render(options);
        });

        $('#submit').on('click', function () {
            var group_id = $('#select-group').val();
            var data = transfer.get(tableIns, 'right', 'id');
            var index = layer.load();
            $.post('?ct=admin&ac=groupList', {
                group_id: group_id,
                ids: data
            }, function (re) {
                layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.reload();
                        }
                    }
                });
            }, 'json');
        });
    });
</script>
<{include file="../public/foot.tpl"}>
