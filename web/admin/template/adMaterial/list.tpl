<{include file="../public/header.tpl"}>
<style type="text/css">
    .table .btn,.table .label {
        margin: 2px;
        display: inline-block;;
    }
    .img-thumbnail {
        width: 24px;
        height: 24px;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <form method="get" action="" class="form-inline">
            <input type="hidden" name="ct" value="optimizat" />
            <input type="hidden" name="ac" value="adMaterial" />

            <div class="form-group form-group-sm">
                <label>高级筛选：</label>

                <{widgets widgets=$widgets}>

                <select name="upload_user">
                    <option value="">选择制作人</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data.upload_user==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <select name="material_type">
                    <option value="">素材类型</option>
                    <{foreach from=$_types key=id item=name}>
                <option value="<{$id}>" <{if $data.material_type==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <select name="material_source">
                    <option value="">需求来源</option>
                    <option value="-1" <{if $data.material_source=='-1'}>selected="selected"<{/if}>>原创构思</option>
                    <{foreach from=$_admins key=id item=name}>
                <option value="<{$id}>" <{if $data.material_source==$id}>selected="selected"<{/if}>><{$name}></option>
                    <{/foreach}>
                </select>

                <select name="material_wh">
                    <option value="">选择尺寸</option>
                    <{foreach from=$_size  item=name}>
                <option value="<{$name.material_wh}>" <{if $data.material_wh==$name.material_wh}>selected="selected"<{/if}>><{$name.material_wh}></option>
                    <{/foreach}>
                </select>

                <select name="material_tag">
                    <option value="">选择标签</option>
                    <{foreach $_tag as $v}>
                <option value="<{$v.tag_name}>" <{if $data.material_tag==$v.tag_name}>selected="selected"<{/if}>><{$v.tag_name}></option>
                    <{/foreach}>
                </select>
            </div>

            <div class="form-group form-group-sm" style="margin-top: 5px;">
                <label style="margin-right: 65px;"></label>

                <input type="text" name="sdate" value="<{$data.sdate}>" class="form-control Wdate" placeholder="开始时间"/> -
                <input type="text" name="edate" value="<{$data.edate}>" class="form-control Wdate" placeholder="结束时间"/>

                <input type="text" class="form-control" name="material_name" value="<{$data.material_name}>" placeholder="搜索素材名">

                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search fa-fw" aria-hidden="true"></i>筛 选</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="location.href='?ct=optimizat&ac=addAdMaterial'"><i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i>上传素材</button>

                <!--<button type="button" class="btn btn-primary btn-xs" id="printExcel">导出Excel</button>-->
            </div>
        </form>

    </div>
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div class="table-content" style="float: left;min-width:100%; ">
            <div style="background-color: #fff;">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th nowrap><a href="javascript:;" id="all_select">全选</a></th>
                        <th nowrap>ID</th>
                        <th nowrap>制作日期</th>
                        <th nowrap>制作负责人</th>
                        <th nowrap>素材类型</th>
                        <th nowrap>素材名称</th>
                        <th nowrap>素材尺寸</th>
                        <th nowrap>素材大小</th>
                        <th nowrap>需求来源</th>
                        <th nowrap>上传时间</th>
                        <th nowrap>素材标签</th>
                        <th nowrap>素材预览图</th>
                        <th nowrap>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach from=$data.list item=u}>
                        <tr>
                            <td nowrap><input type="checkbox" name="download_all" value="<{$u.material_id}>" /></td>
                            <td nowrap><{$u.material_id}></td>
                            <td nowrap><{$u.make_date}></td>
                            <td nowrap><{$_admins[$u.upload_user]}></td>
                            <td nowrap><{$_types[$u.material_type]}></td>
                            <td><{$u.material_name}></td>
                            <td nowrap><{$u.material_wh}></td>
                            <td nowrap><{$u.material_size}></td>
                            <td nowrap><{if $u.material_source != ''}><{$_admins[$u.material_source]}><{else}>原创构思<{/if}></td>
                            <td nowrap><{if $u.create_time}><{$u.create_time|date_format:"%Y/%m/%d %H:%M:%S"}><{else}>-<{/if}></td>
                            <td nowrap><{foreach from=$u.material_tag item=name}><{$name nofilter}><{/foreach}></td>
                            <td nowrap><{if $u.thumb}><img src="<{$u.thumb}>" data-img="<{$u.thumb}>" class="img-rounded" style="width: 100px;height: auto;"><{/if}></td>
                            <td nowrap class="cursor">
                                <{if SrvAuth::checkPublicAuth('edit',false)}><a href="?ct=optimizat&ac=editAdMaterial&material_id=<{$u.material_id}>" class="btn btn-primary btn-xs">编辑素材</a><br><{/if}>
                                <{if SrvAuth::checkPublicAuth('del',false)}><span class="btn btn-danger btn-xs btnDel" data-name="<{$u.material_name}>" data-id="<{$u.material_id}>">删除素材</span><br><{/if}>
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="<{$u.material_url}>" class="btn btn-success" target="_blank">预览</a>
                                    <span class="btn btn-warning download" data-id="<{$u.material_id}>">下载</span>
                                </div>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
            <div style="float: left;margin-top: 5px;">
                <button type="button" class="btn btn-primary btn-xs" id="download_all"> 打包下载 </button>
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
    $(function () {
        //图片预览
        var index;
        $('.img-rounded').mouseenter(function () {
            index = layer.tips('<img src="' + $(this).data('img') + '" class="tips">', $(this), {
                tips: [4, '#ffffff'],
                maxWidth: '200px',
                time: 0
            });
        }).mouseleave(function () {
            layer.close(index);
        });

        //测试时间
        $('.btnTime').on('click', function () {
            var e = $(this).parent().prev('input');
            var _time = e.val();
            var _name = e.attr('name');
            var material_id = e.data('id');
            $.get('?ct=material&ac=changeTime&material_id=' + material_id + '&type=' + _name + '&time=' + _time, function (re) {
                if (re.state == true) {
                    layer.msg(re.msg);
                    return false;
                } else {
                    layer.msg(re.msg);
                    return false;
                }
            }, 'json');
        });

        //全选
        $('#all_select').on('click', function () {
            $(".table input[type='checkbox']").prop("checked", function (i, val) {
                return !val;
            });
        });

        //下载
        $('.download').on('click', function () {
            var id = $(this).data('id');
            download(id);
        });

        //打包下载
        $('#download_all').on('click', function () {
            var tmp = [];
            $('input[name=download_all]').each(function (index, domEle) {
                if ($(this).is(':checked')) {
                    tmp.push($(this).val())
                }
            });

            var ids = tmp.join();
            if (!ids) {
                layer.alert('请勾选要下载的素材', {icon: 2});
                return false;
            }

            download(ids);
        });

        //删除素材
        $('.btnDel').on('click', function () {
            var material_id = $(this).data('id');
            var title = $(this).data('name');
            layer.confirm('<font color="red">确定删除素材【' + title + '】吗？</font>', {
                btn: ['确定', '取消'],
                icon: 7,
                title: '提示'
            }, function () {
                $.post('?ct=optimizat&ac=delAdMaterial',{id:material_id}, function (re) {
                    if (re.state) {
                        layer.alert(re.msg, {icon: 1});
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        layer.alert(re.msg, {icon: 2});
                    }
                }, 'json');
            });
        });

        //下载
        function download(ids) {
            layer.msg('正在打包中，请勿刷新...', {icon: 16, shade: 0.6, time: 0});
            $.post('?ct=optimizat&ac=downloadMaterial',{ids:ids}, function (re) {
                if (re.state) {
                    layer.msg(re.msg, {icon: 1, time: 10 * 1000});
                    setTimeout(function () {
                        window.location.href = re.url;
                    }, 1500);
                } else {
                    layer.alert(re.msg, {icon: 2});
                }
            }, 'json');
        }
    });
</script>
<{include file="../public/foot.tpl"}>