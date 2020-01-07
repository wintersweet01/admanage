<{include file="../public/header.tpl"}>


<link rel="stylesheet" href="<{$smarty.const.SYS_STATIC_URL}>/layui-v2.5.5/css/layui.css">
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
    #account-list{
        cursor: pointer;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="channel_id" value="<{$channelId}>" id="channel_id">
                <input type="hidden" name="id" value="<{$info['id']}>" id="edit-id">
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>创建广告</u></li>
                    </ol>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">* 母游戏</label>
                    <div class="col-sm-4 input-group">
                        <select name="pgame_id" id="pgame_id" class="form-control">
                            <option value="0">请选择母游戏</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">* 子游戏</label>
                    <div class="col-sm-4 input-group">
                        <select name="game_id" id="game_id" class="form-control">
                            <option value="0">请选择子游戏</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="put_in_rule" class="col-sm-2 control-label">* 投放规则</label>
                    <div class="col-sm-6 input-group">
                        <label class="radio-inline">
                            <input type="radio" name="put_in_rule" value="1" checked> 1个素材多个账户
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="put_in_rule" value="2"> 多个素材1个账户
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role_name" class="col-sm-2 control-label">* 选择素材</label>
                    <div class="col-sm-6 input-group">
                        <button type="button" class="btn btn-info select-material">选择素材</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_name" class="col-sm-2 control-label">* 选择账户</label>
                    <div class="col-sm-6 input-group table-responsive">
                        <table class="layui-table account-list">
                            <thead>
                            <tr>
                                <th><input type="checkbox" name="" id="selectAll"></th>
                                <th>投放账号</th>
                                <th>媒体账号</th>
                                <th>媒体账号ID</th>
                                <th>媒体账号主体名称</th>
                                <th>未使用的推广链接数量</th>
                            </tr>
                            </thead>
                            <tbody id="account-list">
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" style="text-align: right">可使用的推广链总数：<span style="font-size: 18px;font-weight: bold" id="links-count">0</span>个</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role_name" class="col-sm-2 control-label">* 选择定向包</label>
                    <div class="col-sm-6 input-group">
                        <table class="layui-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>id</th>
                                    <th>包名</th>
                                    <th>创建时间</th>
                                    <th>更新时间</th>
                                </tr>
                            </thead>
                            <tbody id="package-list">
                                <tr>
                                    <td><input type="radio" value="1"></td>
                                    <td>1</td>
                                    <td>我爱你就想爱自己</td>
                                    <td>2019-06-04 13:15:14</td>
                                    <td>2019-06-04 13:15:14</td>
                                </tr>
                            </tbody>
                            <tfoter>
                                <tr>
                                    <td colspan="5" align="right"><a href="javascript:;" class="layui-btn layui-btn-sm select-directional">创建定向包</a></td>
                                </tr>
                            </tfoter>
                        </table>
                    </div>

                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">* 广告开启状态</label>
                    <div class="col-sm-6 input-group">
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked> 开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> 关闭
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">* 智投规则</label>
                    <div class="col-sm-6 input-group">
                        <button type="button" class="btn btn-info" style="margin-right: 5px;">选用规则</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4 input-group">
                        <button type="button" id="submit" class="btn btn-primary"> 确认并提交 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script src="<{$smarty.const.SYS_STATIC_URL}>/layui-v2.5.5/layui.js"></script>
<script>
    $(function(){
        // 页面加载时清空storage
        sessionStorage.removeItem('material_list');
        sessionStorage.removeItem('copywriting_list');

        let games = [];
        // 获取游戏列表
        $.post('/?ct=optimizat&ac=getGames', function(data){
            let html = '';
            $.each(data.parent, function(key, item){
                html += " <option value='"+item.id+"'>"+item.text+"</option>";
                games[item.id] = item.children;
            });
            $('#pgame_id').append(html);
        }, 'json');

        // 获取定向包列表
        $.get('?ct=jrtt&ac=getDirectionalPackage', function(data){
            console.log(data);
        }, 'json');

        // 获取媒体账号列表
        $('#game_id').change(function(){
            let channel_id = $('#channel_id').val();
            let game_id = $(this).val();
            // 获取媒体账号列表
            $.get('?ct=optimizat&ac=getMediaAcc&channel_id='+channel_id+'&game_id='+game_id, function(data){
                let html = '';
                let sum_links = 0;
                $.each(data, function(key, item){
                    sum_links += parseInt(item.count);
                    html += "<tr>" +
                        "         <td><input type=\"checkbox\" name=\"acct[]\" value='"+item.user_id+"'></td>" +
                        "         <td>"+item.user_name+"</td>" +
                        "         <td>"+item.media_account+"</td>" +
                        "         <td>"+item.account_id+"</td>" +
                        "         <td>"+item.company_name+"</td>" +
                        "         <td>"+item.count+"</td>" +
                        "       </tr>";
                });
                $('#account-list').html(html);
                $('#links-count').text(sum_links);
            }, 'json');
        });
        // 获取子游戏
        $('#pgame_id').change(function(){
            let game = games[parseInt($(this).val())];
            if(!game)
                return false;
            let html = '<option value="0">请选择子游戏</option>';
            $.each(game, function(key, val){
                html += " <option value='"+val.id+"'>"+val.text+"</option>";
            });
            $('#game_id').html(html);
        });

        // 规则切换修改账号列表选择方式
        $('input[type=radio][name=put_in_rule]').change(function(){
            let rule = $(this).val();
            if(rule == 2){
                $('.account-list tr input').attr('type', 'radio');
                $('.account-list tr input').prop('checked', false);
                $('#selectAll').attr('disabled', 'disabled');
            } else{
                $('.account-list tr input').prop('checked', false);
                $('.account-list tr input').attr('type', 'checkbox');
                $('#selectAll').removeAttr('disabled');
            }
        });

        $('#selectAll').on('click', function(){
            $('.account-list tr input[type=checkbox]').prop('checked', $(this).prop('checked'));
        });

        $('#account-list').on('click', 'td', function(){
            let rule = $(this) .val();
            let ele = $(this).parent().children().children();
            ele.prop('checked', !ele.prop('checked'));
        });

        // 打开定向库
        $('.select-directional').click(function(){
            let index = layer.open({
                type:2,
                area:['1300px', '900px'],
                fix:false,
                maxmin: true,
                shade:0.4,
                title: '创建定向库',
                content: '?ct=optimizat&ac=addDirectional'
            });
             layer.full(index); //layer.js 与jquery3.0以上版本冲突，默认150px
        });

        // 打开素材库
        $('.select-material').click(function(){
            let material_list = sessionStorage.getItem('material_list') ? sessionStorage.getItem('material_list') : '';
            let copywriting_list = sessionStorage.getItem('copywriting_list') ? sessionStorage.getItem('copywriting_list') : '';
            let that = $(this);
            let index = layer.open({
                type: 2,
                area: ['800px',  '800px'],
                fix: false,
                maxmin: true,
                shade:0.4,
                title: '选择素材',
                content: '?ct=optimizat&ac=selectMaterial',
                btn: ['朕选好了', '朕再想想'],
                yes:function(){
                    that.removeClass('btn-info');
                    that.addClass('btn-success');
                    that.text('查看所选素材');
                    layer.close(index);
                },
                btn2:function(){
                    sessionStorage.setItem('material_list', material_list);
                    sessionStorage.setItem('copywriting_list', copywriting_list);
                },
                cancel:function(){
                    sessionStorage.setItem('material_list', material_list);
                    sessionStorage.setItem('copywriting_list', copywriting_list);
                }
            });
        });

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
    });
</script>
<{include file="../public/foot.tpl"}>
