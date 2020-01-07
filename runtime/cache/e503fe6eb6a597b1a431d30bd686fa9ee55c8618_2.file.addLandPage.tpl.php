<?php /* Smarty version 3.1.27, created on 2020-01-06 15:15:28
         compiled from "/home/vagrant/code/admin/web/admin/template/extend/addLandPage.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:19751493285e12de90f362e2_04746288%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e503fe6eb6a597b1a431d30bd686fa9ee55c8618' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/extend/addLandPage.tpl',
      1 => 1568086651,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19751493285e12de90f362e2_04746288',
  'variables' => 
  array (
    'data' => 0,
    '_models' => 0,
    'id' => 0,
    'name' => 0,
    '_games' => 0,
    '_companys' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e12de91096d13_26591431',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e12de91096d13_26591431')) {
function content_5e12de91096d13_26591431 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '19751493285e12de90f362e2_04746288';
echo $_smarty_tpl->getSubTemplate ("../public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div id="areascontent">
    <div class="rows" style="margin-bottom: 0.8%; overflow: hidden;">
        <div style="float: left; width: 100%;">
            <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="page_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['page_id'], ENT_QUOTES, 'UTF-8');?>
" />

                <div>
                    <ol class="breadcrumb">
                        <li><a href="javascript:history.go(-1);" id="back">返 回</a></li>
                        <li class="active"><u>添加/修改落地页</u></li>
                    </ol>
                </div>

                <div class="form-group">
                    <label for="model_id" class="col-sm-3 control-label">* 落地页模板</label>
                    <div class="col-sm-5 input-group">
                        <select name="model_id">
                            <option value="">选择落地页模板</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_models']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" data-game="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['game_id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['model_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value['model_name'], ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="game_id" class="col-sm-3 control-label">* 选择游戏</label>
                    <div class="col-sm-5 input-group">
                        <select name="game_id">
                            <option value="">选择游戏</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_games']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['game_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="package_name" class="col-sm-3 control-label">* 选择游戏包</label>
                    <div class="col-sm-5 input-group">
                        <select name="package_name" id="package_name" >
                            <option value="">选择游戏包</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['data']->value['_packages'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['package_name'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_id" class="col-sm-3 control-label">* 选择公司</label>
                    <div class="col-sm-5 input-group">
                        <select name="company_id">
                            <option value="">选择公司</option>
                            <?php
$_from = $_smarty_tpl->tpl_vars['_companys']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['name']->_loop = false;
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
$foreach_name_Sav = $_smarty_tpl->tpl_vars['name'];
?>
                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['company_id'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected="selected"<?php }?>> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
 </option>
                            <?php
$_smarty_tpl->tpl_vars['name'] = $foreach_name_Sav;
}
?>
                        </select>&nbsp;
                    </div>
                </div>

                <div class="form-group">
                    <label for="page_name" class="col-sm-3 control-label">* 落地页名称</label>
                    <div class="col-sm-3 input-group">
                        <input type="text" class="form-control" name="page_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['page_name'], ENT_QUOTES, 'UTF-8');?>
" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="auto_jump" class="col-sm-3 control-label">* 自动跳转</label>
                    <div class="col-sm-3 input-group">
                        <input type="text" class="form-control" name="auto_jump" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['auto_jump'], ENT_QUOTES, 'UTF-8');?>
">
                        <div class="input-group-addon">秒，填0为关闭</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="click_body" class="col-sm-3 control-label">* 点击任意位置下载</label>
                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="click_body" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['click_body'] == 1) {?>checked="checked"<?php }?>> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="click_body" value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['click_body'] == 0) {?>checked="checked"<?php }?>> 开启
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="display_foot" class="col-sm-3 control-label">* 底部开关</label>
                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="display_foot" value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['display_foot'] == 0) {?>checked="checked"<?php }?>> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="display_foot" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['display_foot'] == 1) {?>checked="checked"<?php }?>> 开启
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="auto_header" class="col-sm-3 control-label">* 显示头部</label>
                    <div class="col-sm-5 input-group">
                        <label class="radio-inline">
                            <input type="radio" name="auto_header" value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['auto_header'] == 0) {?>checked="checked"<?php }?>> 不显示
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="auto_header" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['auto_header'] == 1) {?>checked="checked"<?php }?>> 显示
                        </label>
                    </div>
                </div>

                <nav class="navbar navbar-default auto_header col-sm-12" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['auto_header'] != 1) {?>style="display:none;"<?php }?>>
                    <br />
                    <div class="form-group auto_header" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['auto_header'] != 1) {?>style="display:none;"<?php }?>>
                        <label for="header_title" class="col-sm-3 control-label">* 头部标题</label>
                        <div class="col-sm-8 input-group">
                            <input type="text" name="header_title" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['header_info']['header_title'], ENT_QUOTES, 'UTF-8');?>
">
                        </div>
                    </div>

                    <div class="form-group auto_header" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['auto_header'] != 1) {?>style="display:none;"<?php }?>>
                        <label for="header_sub_title" class="col-sm-3 control-label">* 头部副标题</label>
                        <div class="col-sm-8 input-group">
                            <input type="text" style="width:420px;" name="header_sub_title" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['header_info']['header_sub_title'], ENT_QUOTES, 'UTF-8');?>
">
                        </div>
                    </div>

                    <div class="form-group auto_header" <?php if ($_smarty_tpl->tpl_vars['data']->value['info']['auto_header'] != 1) {?>style="display:none;"<?php }?>>
                        <label for="file" class="col-sm-3 control-label">* 头部按钮</label>
                        <div class="col-sm-5 input-group">
                            <input type="file" name="file3" value="选择图片">
                            <input type="hidden" name="header_button" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['info']['header_info']['header_button'], ENT_QUOTES, 'UTF-8');?>
" />
                        </div>
                    </div>
                 </nav>

                <div class="form-group text-center">
                    <button type="button" id="submit" class="btn btn-primary"> 保 存 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel" class="btn btn-default"> 取 消 </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    $(function(){

        $('input[name=auto_header]').on('click',function() {
            if($(this).val()==1){
                $('.auto_header').show();
            }else{
                $('.auto_header').hide();
            }
        });

        $('input[name="file3"]').on('change',function(){
            var parent = $(this).parents('div');
            var index = layer.load(1, {
                shade: [0.6,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                url: '?ct=upload&ac=upload&file_name=file3',  //server script to process data
                type: 'POST',
                success: function(re){
                    layer.close(index);
                    re = JSON.parse(re);
                    if(re.state){
                        parent.find('input[name=header_button]').val(re.url);
                    }else{
                        layer.msg(re.msg);
                    }
                },
                error: function(error){
                    layer.msg(error);
                },
                // Form数据
                data: new FormData($('form')[0]),
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('#submit').on('click',function(){
            var data = $('form').serialize();
            $.post('?ct=extend&ac=addLandPageAction',{data:data},function(re){
                if(re.state == true){
                    location.href = '?ct=extend&ac=landPage';
                }else{
                    layer.open({
                        type: 1,
                        title:false,
                        closeBtn: 0,
                        shadeClose: true,
                        content:'<p style="margin:15px 30px;">'+re.msg+'</p>',
                        time:3000,
                        end:function(){

                        }
                    });
                }

            },'json');
        });

    <?php if (!$_smarty_tpl->tpl_vars['data']->value['_packages']) {?>
        $('select[name=game_id]').on('change',function(){
            var game_id = $('select[name=game_id] option:selected').val();
            if(!game_id){
                return false;
            }
            $.getJSON('?ct=platform&ac=getPackageByGame&game_id='+game_id,function(re) {
                var html = '<option value="">选择游戏包</option>';
                $.each(re,function(i,n){
                    html += '<option value="'+n+'">'+n+'</option>';
                });
                $('#package_name').html(html);
            });
        });

        <?php }?>


        $('#cancel').on('click',function(){
            history.go(-1);
        });

    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("../public/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>