<{include file="../public/header.tpl"}>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <{if SrvAuth::checkPublicAuth('add',false)}><a href="?ct=platform&ac=addAppstore&game_id=<{$game_id}>&package_name=<{$package_name}>" class="btn btn-primary btn-small" role="button"> + 添加商品 </a><{/if}>
        </div>
    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <div style="border: 1px solid #e1e1e1; background-color: #fff;">
                <table class="table table-bordered table-bordered">
                    <thead>
                    <tr>
                        <td>Product ID</td>
                        <td>价格</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data item=u}>
                        <tr>
                            <td><{$u.appstore_name}></td>
                            <td>¥<{$u.goods_price/100|string_format:"%.2f"}></td>
                            <td>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=platform&ac=addAppstore&store_id=<{$u.id}>">编辑</a>&nbsp;&nbsp;<{/if}>
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="javascript:;" data-id="<{$u.id}>" class="del">删除</a>&nbsp;&nbsp;<{/if}>
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
            $.getJSON('?ct=platform&ac=delAppstore&store_id='+id,function(re) {
                if(re.state == true){
                    location.href = '?ct=platform&ac=appstore&game_id=<{$game_id}>&package_name=<{$package_name}>';
                }else{
                    layer.open({
                        type: 1,
                        title:false,
                        closeBtn: 0,
                        shadeClose: true,
                        content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                        time:3000
                    });
                }
            });
        });
    });
</script>

<{include file="../public/foot.tpl"}>
