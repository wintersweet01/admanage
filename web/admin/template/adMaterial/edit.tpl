<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="material_id" value="<{$data.material_id}>">

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>素材管理</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="material_name" class="col-sm-2 control-label">素材名称</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="material_name" value="<{$data.material_name}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_type" class="col-sm-2 control-label">素材类型</label>
                    <div class="col-sm-3">
                        <select name="material_type" class="form-control" style="width: 100px;">
                            <option value="">请选择类型</option>
                            <{foreach from=$_types key=id item=name}>
                        <option value="<{$id}>" <{if $data.material_type == $id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_source" class="col-sm-2 control-label">需求来源</label>
                    <div class="col-sm-3">
                        <select name="material_source" class="form-control" style="width: 100px;">
                            <option value="" <{if $data.material_source == ''}>selected="selected"<{/if}>>原创构思</option>
                            <{foreach from=$_admins key=id item=name}>
                        <option value="<{$id}>" <{if $data.material_source == $id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="material_tag" class="col-sm-2 control-label">素材标签</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="material_tag" value="<{$data.material_tag}>">
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
        $('#submit').on('click', function () {
            var index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=optimizat&ac=editAdMaterialAction', $('form').serializeArray(), function (re) {
                layer.close(index);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.code == true) {
                            location.href = '?ct=optimizat&ac=adMaterial';
                        }
                    }
                });
            }, 'json');
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });
    });
</script>
<{include file="../public/foot.tpl"}>