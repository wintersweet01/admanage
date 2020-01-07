<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="id" value="<{$data.aid}>" />
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u><{$__title__}></u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">文章标题</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">正文标题：</div>
                            <input type="text" class="form-control" name="title" placeholder="完整的标题" value="<{$data['title']}>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">简略标题：</div>
                            <input type="text" class="form-control" name="shorttitle" placeholder="简短的标题" value="<{$data['shorttitle']}>">
                        </div>
                        <select class="form-control" name="color" style="width: 60px;">
                            <option value="">字体颜色</option>
                            <option value="#FF0000" data-color="#FFFFFF">#FF0000</option>
                            <option value="#000000" data-color="#FFFFFF">#000000</option>
                            <option value="#FFFFFF" data-color="#000000">#FFFFFF</option>
                            <option value="#000099" data-color="#FFFFFF">#000099</option>
                            <option value="#660066" data-color="#FFFFFF">#660066</option>
                            <option value="#FF6600" data-color="#FFFFFF">#FF6600</option>
                            <option value="#666666" data-color="#FFFFFF">#666666</option>
                            <option value="#009900" data-color="#FFFFFF">#009900</option>
                            <option value="#0066CC" data-color="#FFFFFF">#0066CC</option>
                            <option value="#990000" data-color="#FFFFFF">#990000</option>
                            <option value="#CC9900" data-color="#FFFFFF">#CC9900</option>
                            <option value="#CCCCCC" data-color="#000000">#CCCCCC</option>
                            <option value="#99FF00" data-color="#000000">#99FF00</option>
                            <option value="#0000FF" data-color="#FFFFFF">#0000FF</option>
                            <option value="#9966CC" data-color="#FFFFFF">#9966CC</option>
                            <option value="#FED806" data-color="#000000">#FED806</option>
                            <option value="#FFE56A" data-color="#000000">#FFE56A</option>
                            <option value="#FFFBBF" data-color="#000000">#FFFBBF</option>
                            <option value="#FFBBA9" data-color="#FFFFFF">#FFBBA9</option>
                            <option value="#FF9898" data-color="#FFFFFF">#FF9898</option>
                        </select>
                        <label class="checkbox-inline"><input type="checkbox" name="isjump" value="1" <{if $data['isjump']}>checked="checked"<{/if}>>跳转</label>
                        <label class="checkbox-inline"><input type="checkbox" name="isstrong" value="1" <{if $data['isstrong']}>checked="checked"<{/if}>>加粗</label>
                    </div>
                </div>

                <div class="form-group redirect-show" <{if !$data['isjump']}>style="display: none;"<{/if}>>
                    <label for="name" class="col-sm-2 control-label">跳转地址</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="redirecturl" value="<{$data['redirecturl']}>">
                        <span class="help-block">点击标题将直接跳转到该地址</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">文章属性</label>
                    <div class="col-sm-6">
                        <label class="radio-inline">
                            <input type="radio" name="type" value="1" <{if $data['type'] == 1}>checked="checked"<{/if}>> 公告
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="2" <{if $data['type'] == 2}>checked="checked"<{/if}>> 常见问题
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label"></label>
                    <div class="col-sm-6">
                        <div class="input-group" style="float: left;">
                            <div class="input-group-addon">作者</div>
                            <input type="text" class="form-control" name="author" value="<{$data['author']}>">
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">来源</div>
                            <input type="text" class="form-control" name="source" value="<{$data['source']}>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">所属游戏</label>
                    <div class="col-sm-6">
                        <{widgets widgets=$widgets}>
                        <span class="help-block red">1、都不选，所有游戏都显示；2、只选母游戏，其所有子游戏都显示；3、只选子游戏，只在该游戏中显示；</span>
                    </div>
                </div>

                <div class="form-group redirect-hide">
                    <label for="name" class="col-sm-2 control-label">摘要</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="description" rows="3"><{$data['description']}></textarea>
                    </div>
                </div>

                <div class="form-group redirect-hide">
                    <label for="name" class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-6">
                        <script id="container" name="content" type="text/plain"><{$data['content'] nofilter}></script>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>window.UEDITOR_HOME_URL = "<{$_static_url_}>lib/ueditor/"</script>
<script src="<{$_cdn_static_url_}>lib/ueditor/ueditor.config.js?v=1"></script>
<script src="<{$_cdn_static_url_}>lib/ueditor/ueditor.all.min.js"></script>
<script src="<{$_cdn_static_url_}>lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
    $(function () {
        var ue = UE.getEditor('container');
        var color = '<{$data['color']}>';
        var isjump = parseInt('<{$data['isjump']}>');

        $('select[name=color]').off('select2:select').select2({
            dropdownAutoWidth: true,
            templateResult: formatState,
            templateSelection: formatState
        });

        function formatState(row) {
            var text = row.id;
            if (!text) {
                return '字体颜色';
            }
            return $('<div style="background-color:' + text + ';color:' + $(row.element).data('color') + '">' + text + '</div>');
        }

        if (color) {
            $('select[name=color]').val(color).trigger("change");
        }

        $('input[name=isjump]').click(function () {
            if ($(this).prop("checked")) {
                $('.redirect-show').show();
                $('.redirect-hide').hide();
            } else {
                $('.redirect-show').hide();
                $('.redirect-hide').show();
            }
        });
        if (isjump == 1) {
            $('.redirect-show').show();
            $('.redirect-hide').hide();
        }

        $('#submit').on('click', function () {
            var data = $('form').serialize();
            var index = layer.load(2, {shade: [0.6,'#fff']});
            $.post('?ct=article&ac=articleAddAction',{data:data}, function (re) {
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
                            location.href = '?ct=article&ac=article';
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