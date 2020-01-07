<{include file="../public/header.tpl"}>
<style type="text/css">
    .highlight, .parent, .children {
        float: left;
        width: 100%;
    }

    .children {
        padding: 5px 40px;
    }

    label.checkbox-inline {
        float: left;
        width: 33%;
        margin: 0px !important;
        display: inline;
        line-height: 22px;
    }
</style>
<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="admin_id" value="<{$admin_id}>"/>

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加管理员</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="inputUser" class="col-sm-2 control-label">* 账号</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="text" class="form-control" name="inputUser" placeholder="不多于3个字符" value="<{$data['user']}>" <{if $admin_id}>disabled<{/if}>>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">姓名</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="text" class="form-control" name="name" value="<{$data['name']}>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPwd" class="col-sm-2 control-label">* 密码</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="password" class="form-control" name="inputPwd" placeholder="密码不少于6位数，不修改留空">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPwd2" class="col-sm-2 control-label">* 确认密码</label>
                    <div class="col-lg-4 col-sm-9">
                        <input type="password" class="form-control" name="inputPwd2">
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_id" class="col-sm-2 control-label">* 选择角色</label>
                    <div class="col-lg-4 col-sm-9">
                        <select name="role_id" class="form-control" style="width: 100px;">
                            <option value="0">选择角色</option>
                            <{foreach from=$_roles key=id item=name}>
                        <option value="<{$id}>" <{if $data['role_id']==$id}>selected="selected"<{/if}>><{$name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">* 游戏权限
                        <i class="fa fa-question-circle" alt="1、不选任何游戏，则有所有游戏的权限（包含后续新增）；<br>2、只选母游戏，则有该母游戏及其所有子游戏的权限（包含后续新增子游戏）；<br>3、只选子游戏，则只有选择的子游戏权限。"></i>
                    </label>
                    <div class="col-lg-6 col-sm-9">
                        <figure class="highlight">
                            <{foreach $_games as $parent}>
                            <div class="parent">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="parent_id[]" value="<{$parent.id}>" <{if in_array($parent.id, explode(',', $data['auth_parent_id']))}>checked<{/if}>><b><{$parent.text}></b>
                                </label>
                            </div>
                            <div class="children">
                                <{foreach $parent.children as $children}>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="game_id[]" value="<{$children.id}>" item="<{$parent.id}>" <{if in_array($children.id, explode(',', $data['auth_game_id']))}>checked<{/if}>><{$children.text}>
                                </label>
                                <{/foreach}>
                            </div>
                            <{/foreach}>
                        </figure>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">* 渠道权限
                        <i class="fa fa-question-circle" alt="1、不选任何渠道和子账号，则有所有渠道和子账号的权限（包含后续新增）；<br>2、只选渠道，则有该渠道及其所有子账号的权限（包含后续新增子账号）；<br>3、只选子账号，则只有选择的子账号权限。"></i>
                    </label>
                    <div class="col-lg-6 col-sm-9">
                        <figure class="highlight">
                            <{foreach $_channeluser as $parent}>
                            <div class="parent">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="channel_id[]" value="<{$parent.id}>" <{if in_array($parent.id, explode(',', $data['auth_channel_id']))}>checked<{/if}>><b><{$parent.text}></b>
                                </label>
                            </div>
                            <div class="children">
                                <{foreach $parent.children as $children}>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="user_id[]" value="<{$children.id}>" item="<{$parent.id}>" <{if in_array($children.id, explode(',', $data['auth_user_id']))}>checked<{/if}>><{$children.text}>
                                </label>
                                <{/foreach}>
                            </div>
                            <{/foreach}>
                        </figure>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-lg-4 col-sm-9">
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
        $('input[name="parent_id[]"],input[name="channel_id[]"]').on('click', function () {
            var id = $(this).val();
            $(this).parents('.parent').next('.children').find('input[item="' + id + '"]').prop("checked", function (i, val) {
                return !val;
            });
        });

        $('#submit').on('click', function () {
            $.post('?ct=admin&ac=addAdminAction', $('form').serializeArray(), function (re) {
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<p style="margin:15px 30px;">' + re.msg + '</p>',
                    time: 3000,
                    end: function () {
                        if (re.state == true) {
                            location.href = '?ct=admin&ac=adminList';
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
