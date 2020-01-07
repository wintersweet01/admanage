<{include file="../public/header.tpl"}>
<style>
    .date-input {
        width: 180px;
        height: 34px;
        display: block;
        border: 1px solid #ccc;
    }

    .warm {
        border: 1px solid #f44542;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%;overflow: hidden">
        <div style="float: left;width: 100%">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="model_id" value="<{$model_id}>">
                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/编辑VIP账号</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-2 control-label"><em class="text-red"> * </em>母游戏：</label>

                    <div class="col-sm-4">
                        <{widgets widgets=$widgets}>
                    </div>
                </div>
                <div class="form-group">
                    <label for="server_id" class="col-sm-2 control-label"><em class="text-red"> * </em> 区服：</label>

                    <div class="col-sm-4">
                        <input type="number" name="server_id" title="区服" class="form-control input-group-sm input-check"
                               value="<{$data.server_id}>" placeholder="请填写区服ID" autocomplete="off"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="account" class="col-sm-2 control-label"><em class="text-red"> * </em>账号：</label>

                    <div class="col-sm-4">
                        <input type="text" data-type="account" title="账号"
                               class="form-control input-group-sm input-check" name="account"
                               value="<{$data.account}>" placeholder="请输入玩家游戏账号" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label for="uid" class="col-sm-2 control-label" title="UID"><em class="text-red">
                            * </em>UID：</label>
                    <div class="col-xs-3">
                        <input type="number" readonly="readonly" title="UID" class="form-control date-input" name="uid"
                               value="<{$data.uid}>" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="col-sm-2 control-label"><em class="text-red"> * </em>角色信息：</label>
                    <button type="button" class="btn btn-primary btn-xs fetch-role" style="margin-left: 15px">获取角色
                    </button>
                    <select name="role_info" class="role_list">
                        <option>请选择角色</option>
                        <{foreach from=$role_list item=row}>
                    <option value="<{$row['id']}>/<{$row['name']}>"
                        <{if $data.role_id|cat:'/'|cat:$data.rolename eq $row['id']|cat:"/"|cat:$row['name']}>
                            selected="selected"
                        <{/if}> ><{$row['name']}></option>
                        <{/foreach}>
                    </select>
                </div>
                <div class="form-group">
                    <label for="platform" class="col-sm-2 control-label"><em class="text-red"> * </em>平台</label>
                    <div class="col-sm-4">
                        <div style="float: left">
                            <spna class="icon_ios"></spna>
                            IOS<input type="radio" name="platform" value="1"
                            <{if $data.platform eq 1}>checked="checked"<{/if}>>
                        </div>
                        <div style="float: left;margin-left: 20px">
                            <spna class="icon_android"></spna>
                            安卓<input type="radio" name="platform" value="2"
                            <{if $data.platform eq 2}>checked="checked"<{/if}>>
                        </div>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label for="uid" class="col-sm-2 control-label"><em class="text-red"> * </em>玩家UID：</label>

                    <div class="col-sm-4">
                        <input type="text" data-type="uid" title="UID" name="uid"
                               class="form-control input-group-sm input-check"
                               value="" placeholder="请填写玩家UID" autocomplete="off"/>
                    </div>
                </div>-->
                <!--<div class="form-group">
                    <label for="uid" class="col-sm-2 control-label"><em class="text-red"> * </em>角色名：</label>

                    <div class="col-sm-4">
                        <input type="text" title="角色名" name="role_name" class="form-control input-group-sm input-check"
                               value="" placeholder="请填写角色名" autocomplete="off"/>
                    </div>
                </div>-->

                <div class="form-group">
                    <label for="touch_time" class="col-sm-2 control-label"><em class="text-red"> * </em>联系时间：</label>

                    <div class="col-sm-4">
                        <input type="text" name="touch_time" value="<{$data.touch_time}>"
                               class="Wdate date-input form-control input-group-sm input-check" autocomplete="off"
                               style="width: 180px"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="real_name" class="col-sm-2 control-label">真实姓名：</label>

                    <div class="col-sm-4">
                        <input type="text" name="real_name" class="form-control input-group-sm"
                               value="<{$data.real_name}>" placeholder="请输入玩家姓名" autocomplete="off"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">手机号：</label>

                    <div class="col-sm-4">
                        <input type="number" name="phone" class="form-control input-group-sm" value="<{$data.phone}>"
                               placeholder="请输入玩家手机号" autocomplete="off"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="birth" class="col-sm-2 control-label">生日：</label>

                    <div class="col-sm-4">
                        <input type="text" name="birth" value="<{$data.birth}>"
                               class="Wdate date-input form-control input-group-sm" style="width: 180px"
                               autocomplete="off"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mail" class="col-sm-2 control-label">email：</label>

                    <div class="col-sm-4">
                        <input type="text" name="mail" class="form-control input-group-sm" value="<{$data.mail}>"
                               placeholder="" autocomplete="off"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="qq_num" class="col-sm-2 control-label">QQ：</label>

                    <div class="col-sm-4">
                        <input type="number" name="qq_num" class="form-control input-group-sm" value="<{$data.qq_num}>"
                               placeholder="" autocomplete="off"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="qq_num" class="col-sm-2 control-label">微信号：</label>

                    <div class="col-sm-4">
                        <input type="text" name="wx_num" class="form-control input-group-sm" value="<{$data.wx_num}>"
                               placeholder="" autocomplete="off"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">截图1：</label>

                    <div class="col-sm-3" style="width: 50%">
                        <div id="picker_img1" class="picker">请选择截图</div>
                        <div id="thelist_img1" class="uploader-list help-block"></div>
                        <div id="thumbnail" class="col-xs-6 col-md-4" style="padding-left: 0px;width: 100%">
                            <span>(上传文件后的图片路径) </span><span
                                    id="img1"><{if !empty($data['img1'])}><{$data['img1']}><{/if}></span>
                        </div>
                        <input type="hidden" name="img[1]" value="<{$data['img1']}>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">截图2：</label>

                    <div class="col-sm-3" style="width: 50%">
                        <div id="picker_img2" class="picker">请选择截图</div>
                        <div id="thelist_img2" class="uploader-list help-block"></div>
                        <div id="thumbnail" class="col-xs-6 col-md-4" style="padding-left: 0px;width: 100%">
                            <span>(上传文件后的图片路径) </span> <span
                                    id="img2"><{if !empty($data['img2'])}><{$data['img2']}><{/if}></span>
                        </div>
                        <input type="hidden" name="img[2]" value="<{$data['img2']}>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">截图3：</label>

                    <div class="col-sm-3" style="width: 50%">
                        <div id="picker_img3" class="picker">请选择截图</div>
                        <div id="thelist_img3" class="uploader-list help-block"></div>
                        <div id="thumbnail" class="col-xs-6 col-md-4" style="padding-left: 0px;width: 100%">
                            <span>(上传文件后的图片路径) </span> <span
                                    id="img3"><{if !empty($data['img3'])}><{$data['img3']}><{/if}></span>
                        </div>
                        <input type="hidden" name="img[3]" value="<{$data['img3']}>"/>
                    </div>
                </div>
                <{if $model_id}>
                <div class="form-group">
                    <label class="col-sm-2 control-label">审核：</label>
                    <fieldset>

                        <div class="col-sm-4">
                            <span>通过：</span><input type="radio" <{if $data.status eq 2}>checked="checked"<{/if}>
                            name="check_btn" value="2"/>
                            <span>不通过：</span><input type="radio" <{if $data.status eq 3}>checked="checked"<{/if}>
                            name="check_btn" value="3"/>
                        </div>
                    </fieldset>
                </div>
                <{/if}>
            </form>
            <div class="form-group">
                <div class="col-sm-4" style="margin-left: 30%">
                    <button class="btn btn-primary" id="submit">确认提交</button>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.css">
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<{$smarty.const.SYS_STATIC_URL}>/js/upload.min.js"></script>
<script>
    $(function () {
        $('input[name=touch_time]').off();
        $('input[name=touch_time]').on('click focus', function () {
            WdatePicker({el:this, dateFmt:"yyyy-MM-dd HH:mm:ss"});
        });
        $('input[name=birth]').off();
        $('input[name=birth]').on('click focus', function () {
            WdatePicker({el:this, dateFmt:"yyyy-MM-dd"});
        });

        $('#submit').on('click', function () {
            var _this = $(this);
            layer.confirm('确认提交？', function () {
                var data = $('form').serialize();
                var warm = [];
                $("input").each(function () {
                    if ($(this).hasClass('warm')) {
                        console.log($(this));
                        warm.push($(this));
                    }
                });
                var game = $("#widgets_game_id").val();
                var account = $("input[name='account']").val();
                var uid = $("input[name='uid']").val();
                var role_info = $("select[name='role_info']").val();
                var server_id = $("input[name='server_id']").val();
                var touch_time = $("input[name='touch_time']").val();
                var platform = $("input[name='platform']").val();
                if (!game || !account || !uid  || !role_info || !server_id || !touch_time || warm.length > 0 || !platform) {
                    layer.open({
                        type: 0,
                        title: '提示',
                        content: '请填写必要参数！',
                        btn: '知道了'
                    });
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: '?ct=kfVip&ac=vipInsr',
                    dataType: 'json',
                    data: data,
                    beforeSend: function () {
                        layer.closeAll();
                        _this.attr('disabled', true);
                        _this.addClass('btn-disabled');
                    },
                    success: function (re) {
                        if (re.err_code == 200) {
                            location.href = '?ct=kfVip&ac=vipManage';
                        } else {
                            layer.open({
                                type: 1,
                                title: false,
                                closeBtn: 0,
                                shadeClose: true,
                                content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                                time: 3000,
                                end: function () {

                                }
                            });
                        }
                    },
                    complete: function () {
                        _this.attr('disabled', false);
                        _this.removeClass('btn-disabled');
                    }
                });
            });
        });
        $("#widgets_game_id").change(function () {
            var _this = $(this);
            if (!_this.val()) {
                _this.addClass('border-danger')
            }
        });

        $('#cancel').on('click', function () {
            history.go(-1);
        });

        $(".input-check").blur(function () {
            var _this = $(this);
            var data_type = _this.attr('data-type');
            var tips = _this.attr('title');
            if (data_type == 'account') {
                $("input[name='uid']").val('');
            }
            if (!_this.val()) {
                _this.addClass('warm')
            } else {
                _this.removeClass('warm');
                if (data_type) {
                    $(".role_list").html('<option value="">请选择角色</option>');
                    $.ajax({
                        type: 'post',
                        url: '?&ct=kfVip&ac=infoCheck',
                        data: {
                            'data': _this.val(),
                            'data_type': data_type
                        },
                        dataType: 'json',
                        success: function (re) {
                            if (!re.state) {
                                layer.msg(tips + ' 不存在', {
                                    icon: 2,
                                    time: 2000
                                });
                                _this.addClass('warm')
                            } else {
                                if (data_type == 'account' && re.data.res) {
                                    $("input[name='uid']").val(re.data.res);
                                }
                                _this.removeClass('warm')
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    })
                }
            }
        });

        $(".fetch-role").on('click', function () {
            var parent_id = parseInt($("select[name='game_id']").val());
            var server_id = parseInt($("input[name='server_id']").val());
            var uid = parseInt($("input[name='uid']").val());
            var _this = $(this);
            if (!parent_id || parent_id == 0) {
                layer.msg('请选择母游戏',{time:1000});
                return false;
            }
            if (!server_id) {
                layer.msg('请填写区服ID',{time:1000});
                return false;
            }
            if (!uid) {
                layer.msg('请获取UID',{time:1000});
                return false;
            }
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '?ct=kfVip&ac=fetch_role',
                data: {
                    'parent_id': parent_id,
                    'server_id': server_id,
                    'uid': uid
                },
                beforeSend: function () {
                    $('.role_list').html('');
                    _this.attr('disabled', true);
                    _this.addClass('btn-disabled');
                },
                success: function (ret) {
                    var str = '<option value="">请选择角色</option>';
                    if (ret.state == 1) {
                        layer.msg('获取成功',{time:1000});
                        var data = ret.list;
                        for (var i in data) {
                            str += '<option value="' + data[i]['id'] +'/'+data[i]['name']+ '" >' + data[i]['name'] + '</option>';
                        }
                        $(".role_list").append(str);
                    } else {
                        layer.msg('获取失败',{time:1000});
                        $(".role_list").html(str);
                    }
                },
                complete: function () {
                    _this.attr('disabled', false);
                    _this.removeClass('btn-disabled')
                }
            })
        });


        var param1 = {
            'dom': '#picker_img1',
            'list': '#thelist_img1',
            'auto': true,
            'type': 'img',
            'size': 102400, //限制大小，单位为字节，100KB
            'url': '/?ct=upload&ac=uploadAdmin'
        };
        cwUpload.create(param1, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = 'uploads/' + result.url;
                    if (result.state) {
                        $("input[name='img[1]']").val(url);
                        $("#img1").html(url);
                    } else {
                        $("input[name='img[1]']").val('');
                    }
                    break;
            }
        });
        var param2 = {
            'dom': '#picker_img2',
            'list': '#thelist_img2',
            'auto': true,
            'type': 'img',
            'size': 102400, //限制大小，单位为字节，100KB
            'url': '/?ct=upload&ac=uploadAdmin'
        };
        cwUpload.create(param2, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = 'uploads/' + result.url;
                    if (result.state) {
                        $("input[name='img[2]']").val(url);
                        $("#img2").html(url);
                    } else {
                        $("input[name='img[2]']").val('');
                    }
                    break;
            }
        });

        var param3 = {
            'dom': '#picker_img3',
            'list': '#thelist_img3',
            'auto': true,
            'type': 'img',
            'size': 102400, //限制大小，单位为字节，100KB
            'url': '/?ct=upload&ac=uploadAdmin'
        };
        cwUpload.create(param3, function (type, result) {
            switch (type) {
                case 'uploadSuccess':
                    var url = 'uploads/' + result.url;
                    if (result.state) {
                        $("input[name='img[3]']").val(url);
                        $("#img3").html(url);
                    } else {
                        $("input[name='img[3]']").val('');
                    }
                    break;
            }
        });
    })
</script>
<{include file="../public/foot.tpl"}>
