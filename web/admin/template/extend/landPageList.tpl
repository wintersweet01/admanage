<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="extend"/>
            <input type="hidden" name="ac" value="landPage"/>
            <div class="form-group form-group-sm">
                <lable>选择游戏</lable>
                <select class="form-control" name="game_id">
                    <option value="">全 部</option>
                    <{foreach from=$_games key=id item=name}>
                <option value="<{$id}>" <{if $data.game_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <lable>选择模板</lable>
                <select class="form-control" name="model_id">
                    <option value="">全 部</option>
                    <{foreach from=$_models key=id item=name}>
                <option value="<{$id}>" <{if $data.model_id==$id}>selected="selected"<{/if}>> <{$name.model_name}> </option>
                    <{/foreach}>
                </select>

                <lable>选择公司</lable>
                <select class="form-control" name="company_id">
                    <option value="">全 部</option>
                    <{foreach from=$_companys key=id item=name}>
                <option value="<{$id}>" <{if $data.company_id==$id}>selected="selected"<{/if}>> <{$name}> </option>
                    <{/foreach}>
                </select>

                <lable>名称</lable>
                <input type="text" class="form-control" name="name" value="<{$data.name}>"/>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选
                </button>

                <{if SrvAuth::checkPublicAuth('add',false)}>
                <a href="?ct=extend&ac=addLandPage" class="btn btn-danger btn-sm" role="button">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>添加落地页
                </a>
                <{/if}>
            </div>
        </form>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td nowrap>落地页ID</td>
                        <td nowrap>落地页名称</td>
                        <td nowrap>落地页URL</td>
                        <td nowrap>模板名称</td>
                        <td nowrap>自动跳转</td>
                        <td nowrap>底部开关</td>
                        <td nowrap>所属公司</td>
                        <td nowrap>所属游戏</td>
                        <td nowrap>所属游戏包</td>
                        <td nowrap>状态</td>
                        <td nowrap>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><{$u.page_id}></td>
                            <td nowrap><{$u.page_name}></td>
                            <td nowrap><a target="_blank" href="<{$smarty.const.CDN_URL}><{$u.page_url}>/index.html"><{$smarty.const.CDN_URL}><{$u.page_url}>/index.html</a></td>
                            <td nowrap><{$_models[$u.model_id]['model_name']}></td>
                            <td nowrap><{if $u.auto_jump > 0}><{$u.auto_jump}>秒<{else}>×<{/if}></td>
                            <td nowrap><{if $u.display_foot}>√<{else}>×<{/if}></td>
                            <td nowrap><{$_companys[$u.company_id]}></td>
                            <td nowrap><{$_games[$u.game_id]}></td>
                            <td nowrap><{$u.package_name}></td>
                            <td nowrap>
                                <{if $u.success_time < $u.update_time}>
                                <span class="label label-warning">模板有更新</span><i class="fa fa-question-circle" alt="点击编辑后保存即可重新生成"></i>
                                <{else}>
                                <span class="label label-primary">正常</span>
                                <{/if}>
                            </td>
                            <td nowrap>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=extend&ac=addLandPage&page_id=<{$u.page_id}>">编辑</a>&nbsp;&nbsp;<{/if}>
                                <{if SrvAuth::checkPublicAuth('del',false)}><a href="javascript:;" class="del" data-id="<{$u.page_id}>">删除</a>&nbsp;&nbsp;<{/if}>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div style="float: right;">
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
    $(function(){
        $('.del').on('click',function() {
            var id = $(this).attr('data-id');
            layer.confirm('确定删除?', {
                btn: ['是的','取消']
            }, function(){
                $.getJSON('?ct=extend&ac=delLandPage&page_id='+id,function(re) {
                    if(re.state == true){
                        location.reload();
                    }else{
                        layer.msg(re.msg);
                    }
                });
            }, function(){

            });
        });
    });
</script>

<{include file="../public/foot.tpl"}>