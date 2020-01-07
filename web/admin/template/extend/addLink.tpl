<{include file="../public/header.tpl"}>
<style>
    .itemlist .itempic{padding-right: 0;max-width: 80px;max-height: 100px;overflow: hidden;} .itemlist img{max-width: 100%} .itemlist h5 {
        color: #000;
    }

    .itemlist p {
        margin: 0;
        padding: 0;
        font-size: 10px;
    }

    img.tips {
        max-width: 200px;
        max-height: 250px;
    }

    .show_land {
        display: none;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="monitor_id" value="<{$data.monitor_id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改推广链</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">* 推广名称</label>
                    <div class="col-lg-6 col-sm-9">
                        <input type="text" class="form-control" name="name" value="<{$data['info']['name']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label">* 游戏</label>
                    <div class="col-lg-6 col-sm-9">
                        <{widgets widgets=$widgets}>
                    </div>
                </div>

                <div class="form-group">
                    <label for="channel_id" class="col-sm-2 control-label">* 渠道</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="channel_id" class="form-control" style="width: 150px;">
                            <option value="">选择渠道</option>
                            <{foreach from=$_channels key=id item=name}>
                        <option value="<{$id}>" <{if $data['info']['channel_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="package_name" class="col-sm-2 control-label">* 游戏包</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="package_name" class="form-control" style="width: 150px;">
                            <option value="">选择游戏包</option>
                            <{foreach from=$data.info._packages item=name}>
                        <option value="<{$name.package_name}>" <{if $data['info']['package_name']==$name.package_name}>selected="selected"<{/if}>><{$name.package_name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="user_id" class="col-sm-2 control-label">* 投放账号</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="user_id" id="user_id" class="form-control" style="width: 150px;">
                            <option value="">选择账号</option>
                            <{foreach from=$data.info.users item=name}>
                        <option value="<{$name.user_id}>" <{if $data['info']['user_id']==$name.user_id}>selected="selected"<{/if}>><{$name.user_name}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">* 链接类型</label>
                    <div class="col-lg-6 col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="type" value="0" <{if $data['info']['type'] == 0}>checked="checked"<{/if}>> 监测类
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="1" <{if $data['info']['type'] == 1}>checked="checked"<{/if}>> 落地页类
                        </label>
                    </div>
                </div>

                <{*<{if !$data.monitor_id}>
                <div class="form-group">
                    <label for="number" class="col-sm-2 control-label">* 生成链接数量</label>
                    <div class="col-sm-3 input-group">
                        <input type="text" class="form-control" name="number" value="1" >
                    </div>
                </div>
                <{/if}>*}>

                <div class="form-group show_land">
                    <label for="model_id" class="col-sm-2 control-label">* 落地页模板</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="model_id" class="form-control" style="width: 150px;">
                            <option value="">选择落地页模板</option>
                            <{foreach from=$data.info._models key=id item=name}>
                        <option value="<{$id}>" data-game="<{$_games[$name.game_id]}>" data-time="<{$name.update_time}>" data-img="/uploads/<{$name.thumb}>" <{if $data['info']['page_info']['model_id']==$id}>selected="selected"<{/if}>><{$name.model_name}></option>
                            <{/foreach}>
                        </select>
                        <input type="hidden" name="page_id" value="<{$data['info']['page_id']}>"/>
                    </div>
                </div>

                <div class="form-group show_land">
                    <label for="company_id" class="col-sm-2 control-label">* 选择公司</label>
                    <div class="col-lg-6 col-sm-9">
                        <select name="company_id" class="form-control" style="width: 150px;">
                            <option value="">选择公司</option>
                            <{foreach from=$_companys key=id item=name}>
                        <option value="<{$id}>" <{if $data['info']['page_info']['company_id']==$id}>selected="selected"<{/if}>> <{$name}> </option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group show_land">
                    <label for="auto_jump" class="col-sm-2 control-label">* 自动跳转</label>
                    <div class="col-lg-6 col-sm-9">
                        <div class="col-lg-4 col-sm-5 col-xs-3 input-group">
                            <input type="text" class="form-control" name="auto_jump" value="<{$data['info']['page_info']['auto_jump']}>">
                            <div class="input-group-addon">秒</div>
                        </div>
                        <span class="help-block">填0为关闭，大于0则为多少秒后跳转</span>
                    </div>
                </div>

                <div class="form-group show_land">
                    <label for="jump_model" class="col-sm-2 control-label">短链跳转落地页</label>
                    <div class="col-lg-6 col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="jump_model" value="0" <{if $data['info']['page_info']['jump_model'] == 0}>checked="checked"<{/if}>> 否
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="jump_model" value="1" <{if $data['info']['page_info']['jump_model'] == 1}>checked="checked"<{/if}>> 是
                        </label>
                    </div>
                </div>

                <div class="form-group show_land">
                    <label for="click_body" class="col-sm-2 control-label">* 点击任意位置下载</label>
                    <div class="col-lg-6 col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="click_body" value="1" <{if $data['info']['page_info']['click_body'] == 1}>checked="checked"<{/if}>> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="click_body" value="0" <{if $data['info']['page_info']['click_body'] == 0}>checked="checked"<{/if}>> 开启
                        </label>
                    </div>
                </div>

                <div class="form-group show_land">
                    <label for="display_foot" class="col-sm-2 control-label">* 底部开关</label>
                    <div class="col-lg-6 col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="display_foot" value="0" <{if $data['info']['page_info']['display_foot'] == 0}>checked="checked"<{/if}>> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="display_foot" value="1" <{if $data['info']['page_info']['display_foot'] == 1}>checked="checked"<{/if}>> 开启
                        </label>
                    </div>
                </div>

                <div class="form-group show_land">
                    <label for="new_land" class="col-sm-2 control-label">* 新建落地页</label>
                    <div class="col-lg-6 col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="new_land" value="1"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="new_land" value="0" checked="checked"> 否
                        </label>
                        <span class="help-block">如果多个推广链使用了原来的落地页，可以选择“是”选项，不影响原有的落地页</span>
                    </div>
                </div>

                <div class="form-group show_land">
                    <label for="auto_header" class="col-sm-2 control-label">* 显示头部</label>
                    <div class="col-lg-6 col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="auto_header" value="0" <{if $data['info']['page_info']['auto_header'] == 0}>checked="checked"<{/if}>> 不显示
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="auto_header" value="1" <{if $data['info']['page_info']['auto_header'] == 1}>checked="checked"<{/if}>> 显示
                        </label>
                    </div>
                </div>

                <nav class="navbar navbar-default auto_header col-sm-12"
                <{if $data['info']['page_info']['auto_header']!=1}>style="display:none;"<{/if}>>
                <br/>
                <div class="form-group auto_header"
                <{if $data['info']['page_info']['auto_header']!=1}>style="display:none;"<{/if}>>
                <label for="header_title" class="col-sm-2 control-label">* 页面头部标题</label>
                <div class="col-sm-8 input-group">
                    <input type="text" name="header_title" value="<{$data['info']['page_info']['header_info']['header_title']}>">
                </div>
        </div>

        <div class="form-group auto_header"
        <{if $data['info']['page_info']['auto_header']!=1}>style="display:none;"<{/if}>>
        <label for="header_sub_title" class="col-sm-2 control-label">* 页面头部副标题</label>
        <div class="col-sm-8 input-group">
            <input type="text" style="width:420px;" name="header_sub_title" value="<{$data['info']['page_info']['header_info']['header_sub_title']}>">
        </div>
    </div>

    <div class="form-group auto_header"
    <{if $data['info']['page_info']['auto_header']!=1}>style="display:none;"<{/if}>>
    <label for="file" class="col-sm-2 control-label">* 页面头部按钮</label>
    <div class="col-sm-5 input-group">
        <div id="picker">请选择图片</div>
        <div id="thelist" class="uploader-list help-block"></div>
        <span class="help-block"></span>
        <div id="thumbnail" class="col-xs-6 col-md-4" style="padding-left: 0px;">
            <{if $data['info']['page_info']['header_info']['header_button']}>
            <div class="thumbnai2"><img src="<{$data['info']['page_info']['header_info']['header_button']}>"/></div>
            <{/if}>
        </div>
        <input type="hidden" name="header_button" id="header_button" value="<{$data['info']['page_info']['header_info']['header_button']}>"/>
    </div>
</div>
</nav>

<div class="form-group show_land">
    <label for="jump_url" class="col-sm-2 control-label">下载地址</label>
    <div class="col-lg-6 col-sm-9">
        <input type="text" class="form-control" name="jump_url" value="" placeholder="如果不需要落地页请直接填地址，如果需要落地页请留空">
    </div>
</div>

<div class="form-group show_land">
    <label for="jump_url" class="col-sm-2 control-label">JS代码</label>
    <div class="col-lg-6 col-sm-9">
        <textarea class="form-control" name="code" rows="5" placeholder="如：百度统计代码。代码必须包含在<script></script>里面"><{$data['info']['page_info']['code']}></textarea>
    </div>
</div>

<div class="form-group">
    <label for="create_user" class="col-sm-2 control-label">* 负责人</label>
    <div class="col-lg-6 col-sm-9">
        <select name="create_user" class="form-control" style="width: 150px;">
            <option value="">选择负责人</option>
            <{foreach from=$_admins key=id item=name}>
        <option value="<{$id}>" <{if $data['info']['create_user']==$id}>selected="selected"<{/if}>><{$name}></option>
            <{/foreach}>
        </select>&nbsp;
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-lg-6 col-sm-9">
        <button type="button" id="submit" class="btn btn-primary"> 保 存</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" id="cancel" class="btn btn-default"> 取 消</button>
    </div>
</div>
</form>
</div>
</div>
</div>
<link rel="stylesheet" type="text/css" href="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.css">
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/upload.min.js"></script>
<script>
    $(function () {
        var param = {
            'url': '/?ct=Upload&ac=upload',
            'dom': '#picker',
            'list': '#thelist',
            'auto': true,
            'type': 'img',
            'size': 2048 //限制大小，单位为字节，200KB
        };
        var uploader = cwUpload.create(param, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = result.url;
                    if (result.state) {
                        var img = $('#thumbnail').find('.thumbnail img');
                        if (!img.length) {
                            img = $('<div class="thumbnail"><img src="' + url + '"></div>').appendTo($('#thumbnail'));
                        } else {
                            img.attr('src', url);
                        }

                        $('#header_button').val(result.url);
                    } else {
                        $('#header_button').val('');
                    }
                    break;
            }
        });

        $('input[name=auto_header]').on('click', function () {
            if ($(this).val() == 1) {
                $('.auto_header').show();
                //刷新
                uploader.refresh();
            } else {
                $('.auto_header').hide();
            }
        });

        var getPackage = function () {
            var game_id = $('select[name=game_id] option:selected').val();
            var channel_id = $('select[name=channel_id] option:selected').val();
            var obj = $("select[name=package_name]");
            var html = '<option value="">选择游戏包</option>';

            if (game_id <= 0 || channel_id <= 0) {
                obj.html(html).trigger('change');
                return false;
            }

            $.getJSON('?ct=platform&ac=getPackageByGame&game_id=' + game_id + '&channel_id=' + channel_id, function (re) {
                var packags = JSON.parse('<{$_packagename nofilter}>');
                $.each(re, function (i, n) {
                    if (packags[n] == 1) return true;

                    html += '<option value="' + n + '">' + n + '</option>';
                });
                obj.html(html).trigger('change');
            });
        };

        var getLandModel = function (game_id) {
            var games = JSON.parse('<{$_games|@json_encode nofilter}>');
            var obj = $("select[name=model_id]");
            var html = '<option value="">选择落地页模板</option>';

            if (game_id <= 0) {
                obj.html(html).trigger('change');
                return false;
            }

            $.getJSON('?ct=extend&ac=getModelByGame&game_id=' + game_id, function (re) {
                $.each(re, function (i, n) {
                    html += '<option value="' + n.model_id + '" data-game="' + games[n.game_id] + '" data-time="' + n.update_time + '" data-img="/uploads/' + n.thumb + '">' + n.model_name + '</option>';
                });
                obj.html(html).trigger('change');
            });
        };

        $('select[name=game_id]').on('change', function () {
            getPackage();
            getLandModel($(this).val());
        });

        $('#submit').on('click', function () {
            var data = $('form').serialize();
            var index = layer.msg('正在保存中，请勿刷新......', {icon: 16, shade: 0.8, shadeClose: false, time: 0});
            $.post('?ct=extend&ac=addLinkAction',{data:data}, function (re) {
                layer.close(index);
                if (re.state == true) {
                    layer.alert('保存成功', {icon: 6}, function () {
                        location.href = document.referrer;
                    });
                } else {
                    layer.alert(re.msg, {icon: 5});
                }
            }, 'json');
        });

        $('select[name=channel_id]').on('change', function () {
            var channel_id = $('select[name=channel_id] option:selected').val();
            if (!channel_id) {
                return false;
            }
            $.getJSON('?ct=extend&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="">选择账号</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#user_id').html(html);
            });
            getPackage();
        });

        //选择包名事件
        $('select[name=package_name]').on('change', function () {
            var package_name = $('select[name=package_name] option:selected').val();
            if (!package_name) {
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageInfoByPackageName&package_name=' + package_name, function (re) {
                var v = re.user_id > 0 ? re.user_id : '';
                $('#user_id').val(v).trigger('change');
            });
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });

        //落地页模板图片
        $('select[name=model_id]').off('select2:select').select2({
            dropdownAutoWidth: true,
            templateResult: formatState
        }).on('select2:close', function (e) {
            layer.closeAll();
        });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var e = $(state.element);
            var html = '<div class="row itemlist">' +
                '<div class="col-md-2 col-sm-2 col-xs-3 itempic"><img src="' + e.data('img') + '" class="img-rounded"></div>' +
                '<div class="col-md-10 col-sm-10 col-xs-9">' +
                '<h5>' + state.text + '</h5>' +
                '<p>所属游戏：' + e.data('game') + '，上传时间：' + e.data('time') + '</p>' +
                '</div>' +
                '</div>';
            var el = $(html);
            var index;
            el.mouseenter(function () {
                index = layer.tips('<img src="' + e.data('img') + '" class="tips">', $(this), {
                    tips: [4, '#000000'],
                    maxWidth: '200px',
                    time: 0
                });
            }).mouseleave(function () {
                layer.close(index);
            });
            return el;
        }

        //链接类型开关
        var type = parseInt('<{$data['info']['type']}>');
        if (type == 1) {
            $('.show_land').show();
        }

        $('input[name=type]').on('click', function () {
            if ($(this).val() == 1) {
                $('.show_land').show();
            } else {
                $('.show_land').hide();
            }
        });
    });
</script>
<{include file="../public/foot.tpl"}>
