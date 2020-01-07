<{include file="../public/header.tpl"}>
<style type="text/css">
    .highlight{
        float: left;
        width: 100%;
    }
    label.checkbox-inline{
        float: left;
        width: 200px;
        margin: 0px !important;
        display: inline;
    }
    h5{
        clear: both;
    }
    #char-count{
        float: right;
    }
    #input-char{
        color: green;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="id" value="<{$info['id']}>" id="edit-id">
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/编辑文案</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">* 渠道</label>
                    <div class="col-lg-5 col-sm-9">
                        <select name="channel" id="channel">
                            <option value="1" <{if $info['channel']=='1'}>selected="selected"<{/if}>>广点通</option>
                            <option value="2" <{if $info['channel']=='2'}>selected="selected"<{/if}>>今日头条</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role_name" class="col-sm-2 control-label">* 文案内容</label>
                    <div class="col-sm-6 input-group">
                        <input type="text" class="form-control" name="content" value="<{$info['content']}>" placeholder="请输入描述文案（1-30字）" id="content">
                        <p id="char-count"><span id="input-char">0</span>/<span id="max-char">30</span></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_name" class="col-sm-2 control-label">打标签</label>
                    <div class="col-sm-6 input-group">
                        <input type="text" class="form-control" name="tag" value="<{$info['tag']}>" placeholder="用英文半角逗号分隔标签，如：胡桃,胡桃互娱">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4 input-group">
                        <button type="button" id="submit" class="btn btn-primary"> 保 存 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        let con = $('#content').val();
        let len = Math.ceil(con.replace(/([\u4e00-\u9fa5]+?)/g,'aa').length / 2);
        $('#input-char').text(len);

        $('#submit').on('click',function(){
            let loading = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            let con = $('#content').val();
            let len = Math.ceil(con.replace(/([\u4e00-\u9fa5]+?)/g,'aa').length / 2);
            let max_char = parseInt($('#max-char').text());
            if(len > max_char){
                layer.close(loading);
                layer.msg("文案内容不能超过"+max_char+"个字符", {icon: 2});
                return false;
            }
            if(len <= 0) {
                layer.close(loading);
                layer.msg("请输入文案内容", {icon: 2});
                return false;
            }

            let data = $('form').serialize();
            let edit_id = parseInt($('#edit-id').val());
            let url = ! isNaN(edit_id) || edit_id > 0 ? '?ct=optimizat&ac=editCopywritingAction' : '?ct=optimizat&ac=addCopywritingAction';
            $.post(url, data, function(re){
                layer.open({
                    type: 1,
                    title:false,
                    closeBtn: 0,
                    shadeClose: true,
                    content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                    time:3000,
                    end:function(){
                        layer.close(loading);
                        if(re.code == true){
                            location.href = '?ct=optimizat&ac=adCopywriting';
                        }
                    }
                });
            },'json');
        });

        $('#cancel').on('click',function(){
            history.go(-1);
        });

        $('#content').on('keyup', function(){
            let max_char = parseInt($('#max-char').text());
            let con = $(this).val();
            // 中文占一个字符，两个英文字母占一个字符
            let len = Math.ceil(con.replace(/([\u4e00-\u9fa5]+?)/g,'aa').length / 2);
            $('#input-char').text(len);
            if(len > max_char)
                $('#input-char').css('color', 'red');
            else
                $('#input-char').css('color', 'green');
        });
    });
</script>
<{include file="../public/foot.tpl"}>
