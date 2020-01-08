<?php /* Smarty version 3.1.27, created on 2020-01-08 10:23:57
         compiled from "/home/vagrant/code/admin/web/admin/template/adCnter/selectDirectional.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:9431936185e153d3ddec700_46621164%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0bd2330cb219c46f70a4c614ac2868ebac51f988' => 
    array (
      0 => '/home/vagrant/code/admin/web/admin/template/adCnter/selectDirectional.tpl',
      1 => 1578386620,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9431936185e153d3ddec700_46621164',
  'variables' => 
  array (
    '_cdn_static_url_' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5e153d3de1c668_89529679',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5e153d3de1c668_89529679')) {
function content_5e153d3de1c668_89529679 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '9431936185e153d3ddec700_46621164';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>创建定向包</title>
    <!--<link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/css/layui.css">-->
    <link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/layui-v2.5.5/css/layui.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <style>
        .content{margin-top:20px;} .site-title {
            margin: 30px 0 20px;
        }

        .site-title fieldset {
            border: none;
            padding: 0;
            border-top: 1px solid #eee;
        }

        .site-title fieldset legend {
            margin-left: 20px;
            padding: 0 10px;
            font-size: 22px;
            font-weight: 300;
        }

        .city-list:first-child {
            margin-top: 6px;
        }

        #select-tags{
            width: 600px;
        }
        .tag-list{
            width: 150px;
            float: left;
        }
        .city-list, .tag-list {
            margin: 8px 12px;
            padding: 2px 8px;
            background-color: #edf1f5;
            border-radius: 4px;
            position: relative;
            cursor: pointer;
        }

        .city-name, .tag-name {
            margin-right: 14px;
            display: block;
            cursor: pointer;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            line-height: 22px;
            font-size: 14px;
            color: #333;
            font-weight: 400;
        }

        .city-del, .tag-del {
            position: absolute;
            right: 8px;
            top: 13px;
            line-height: 0;
            cursor: pointer;
        }

        .search input {
            margin-right: -3px;
            height: 42px;
            border: none;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            border-radius: 2px 0 0 2px;
        }

        .search-button {
            height: 42px;
            border-radius: 0 2px 2px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        .screen-type {
            width: 100px;
        }

        .screen-type li {
            height: 30px;
            cursor: pointer;
            text-align: center;
            line-height: 30px;
            border-radius: 2px;
        }

        .screen-type li:hover {
            background: #fff;
            color: #000;
        }

        #view-act-type {
            cursor: pointer;
        }

        #schedule_time_table th, #schedule_time_table td{
            text-align: center;
            white-space: nowrap
        }
        #schedule_time_table tbody tr:hover{
            background-color: transparent;
        }

        .schedule_time_checked{
            background: #5FB878;
        }

        .select-box-dashed {
            position: absolute;
            display: none;
            width: 0px;
            height: 0px;
            padding: 0px;
            margin: 0px;
            border: 1px dashed #0099ff;
            background-color: #c3d5ed;
            opacity: 0.5;
            filter: alpha(opacity=50);
            font-size: 0px;
            z-index: 99999;
        }
        .week {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12 content">
            <form  action="" class="layui-form">
                <input type="hidden" id="static-url" value="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
">
                <div class="site-title">
                    <fieldset>
                        <legend><a name="inline">投放范围</a></legend>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">投放范围</label>
                    <div class="layui-input-block">
                        <input type="radio" lay-filter="delivery_range" name="delivery_range" value="DEFAULT" title="默认"
                               checked>
                        <input type="radio" lay-filter="delivery_range" name="delivery_range" value="UNION" title="穿山甲">
                    </div>
                </div>
                <div class="layui-form-item union_video_type" style="display: none">
                    <label class="layui-form-label"> 投放形式</label>
                    <div class="layui-input-block">
                        <input type="radio" lay-filter="union_video_type" name="union_video_type" value="ORIGINAL_VIDEO"
                               title="原生视频" checked>
                        <input type="radio" lay-filter="union_video_type" name="union_video_type" value="REWARDED_VIDEO"
                               title="激励视频">
                    </div>
                </div>
                <!--<div class="site-title">
                    <fieldset><legend><a name="inline">投放目标</a></legend></fieldset>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">投放目标</label>
                    <div class="layui-input-block">
                        <input type="radio" name="launch_target" value="1" title="转化量" checked>
                        <input type="radio" name="launch_target" value="2" title="点击量">
                        <input type="radio" name="launch_target" value="3" title="展示量">
                        <input type="radio" name="launch_target" value="4" title="有效播放量">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 下载方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="download_type" lay-filter ="download_type" value="DOWNLOAD_URL" title="下载链接" checked>
                        <input type="radio" name="download_type" lay-filter="download_type" value="EXTERNAL_URL" title="落地页">
                    </div>
                </div>
                <div class="layui-form-item" id="download-url">
                    <label class="layui-form-label">* 下载链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="download_url" required  lay-verify="required" placeholder="https://download.hutao.net/xxx.apk" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item" id="external-url" style="display: none">
                    <label class="layui-form-label">* 链接地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="external_url" required  lay-verify="required" placeholder="https://download.hutao.net" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 转化目标</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn">选择转化目标</button>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 应用包名</label>
                    <div class="layui-input-block">
                        <input type="text" name="package" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>-->
                <div class="site-title">
                    <fieldset>
                        <legend><a name="inline">用户定向</a></legend>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">地域</label>
                    <div class="layui-input-block">
                        <input type="radio" name="district" lay-filter="district" value="NONE" title="不限" checked>
                        <input type="radio" name="district" lay-filter="district" value="CITY" title="按省市">
                        <input type="radio" name="district" lay-filter="district" value="COUNTY" title="按区县">
                        <input type="radio" name="district" lay-filter="district" value="BUSINESS_DISTRICT" title="按商圈">

                    </div>
                </div>
                <div class="layui-form-item" id="city-change" style="display: none">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="background-color: #F2F2F2;">
                            <div class="layui-row layui-col-space15">
                                <div class="layui-col-md2"></div>
                                <div class="layui-col-md4">
                                    <div class="layui-card">
                                        <div class="layui-card-header">选择省市</div>
                                        <div class="layui-card-body">
                                            <!--<div id="city" style="height: 235px;overflow-y: scroll"></div>-->
                                            <ul id="district-tree" class="ztree" style="height: 235px;overflow-y: scroll"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-md4">
                                    <div class="layui-card">
                                        <div class="layui-card-header">已选择</div>
                                        <div class="layui-card-body">
                                            <div style="height: 245px;overflow-y: scroll" id="checked-citys">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-md2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-block">
                        <input type="radio" name="gender" value="NONE" title="不限" checked>
                        <input type="radio" name="gender" value="GENDER_MALE" title="男">
                        <input type="radio" name="gender" value="GENDER_FEMALE" title="女">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">年龄</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="age[]" lay-filter="age" title="不限" value="" checked
                               id="age-default">
                        <input type="checkbox" name="age[]" lay-filter="age" title="18-23" value="AGE_BETWEEN_18_23">
                        <input type="checkbox" name="age[]" lay-filter="age" title="24-30" value="AGE_BETWEEN_24_30">
                        <input type="checkbox" name="age[]" lay-filter="age" title="31-40" value="AGE_BETWEEN_31_40">
                        <input type="checkbox" name="age[]" lay-filter="age" title="41-49" value="AGE_BETWEEN_41_49">
                        <input type="checkbox" name="age[]" lay-filter="age" title="50+" value="AGE_ABOVE_50">
                    </div>
                </div>
                <!--不能放在定向包里面做，单独拿到账号里面做-->
                <!--<div class="layui-form-item">
                    <label class="layui-form-label">自定义人群</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="switch" lay-skin="switch" lay-text="自定义人群|不限">
                    </div>
                </div>-->

                <div class="layui-form-item">
                    <label class="layui-form-label">行为兴趣</label>
                    <div class="layui-input-block">
                        <input type="radio" name="interest_action_mode" lay-filter="interest_action_mode" title="不限"
                               checked value="UNLIMITED">
                        <input type="radio" name="interest_action_mode" lay-filter="interest_action_mode" title="系统推荐"
                               value="RECOMMEND">
                        <input type="radio" name="interest_action_mode" lay-filter="interest_action_mode" title="自定义"
                               value="CUSTOM">
                    </div>
                </div>
                <div id="act-interest" style="display: none">
                    <div class="layui-form-item">
                        <label class="layui-form-label">行为场景</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="action_scene" lay-filter="action_scene" title="电商互动行为"
                                   value="E-COMMERCE"
                                   checked>
                            <input type="checkbox" name="action_scene" lay-filter="action_scene" title="资讯互动行为"
                                   value="NEWS">
                            <input type="checkbox" name="action_scene" lay-filter="action_scene" title="App推广互动行为"
                                   value="APP">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">行为天数</label>
                        <div class="layui-input-block">
                            <select name="action_days" lay-verify="required" id="action_days">
                                <option value="7">7天</option>
                                <option value="15">15天</option>
                                <option value="30" selected>30天</option>
                                <option value="60">60天</option>
                                <option value=90>90天</option>
                                <option value="180">180天</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                    <label class="layui-form-label">行为</label>
                    <div class="layui-input-block">
                        <div style="background-color: #F2F2F2; ">
                            <div class="layui-row layui-col-space15">
                                <div class="layui-col-md1"></div>
                                <div class="layui-col-md10">
                                    <div class="layui-tab layui-tab-brief" lay-filter="actKeywordTab">
                                        <ul class="layui-tab-title">
                                            <li class="layui-this" lay-id="1">添加类目词</li>
                                            <li lay-id="2">添加关键词</li>
                                        </ul>
                                        <div class="layui-tab-content layui-col-md6">
                                            <div class="layui-tab-item layui-show">
                                                <div class="layui-card">
                                                    <div class="layui-card-header">行为类目词</div>
                                                    <div class="layui-card-body">
                                                        <ul id="action-tree" class="ztree" style="height: 300px;overflow-y: scroll"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="layui-tab-item">
                                                <div class="layui-card">
                                                    <div class="layui-card-header">行为关键词</div>
                                                    <div class="layui-card-body">
                                                        <div style="height: 310px;overflow-y: scroll" id="checked-act-keyword">
                                                            <div>
                                                                <input type="text" id="act-word" placeholder="请输入行为类目词或关键词"  class="layui-input" style="display: inline-block; width:80%">
                                                                <a class="layui-btn layui-btn-normal" style="display: inline-block" id="search-act-word">搜索</a>
                                                            </div>
                                                            <table lay-filter="keyword-list" class="layui-table" lay-skin="row">
                                                                <thead>
                                                                <tr>
                                                                    <th colspan="4" id="seaword-ing"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="keyword-list">
                                                                <tr>
                                                                    <td colspan="2" style="text-align: center">
                                                                        请在上方输入关键词或点击右侧查关键词 :)
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-card layui-col-md6">
                                        <div class="layui-card-header">
                                            <div class="layui-row">
                                                <p class="layui-col-md6">
                                                    还可添加行为：
                                                    <span class="layui-badge layui-bg-orange" id="act-count">350</span>
                                                    个
                                                </p>

                                                <p class="layui-col-md6" style="text-align: right">
                                                    <a class="layui-btn layui-btn-normal  layui-btn-xs" id="act-del-all">清空</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="layui-card-body">
                                            <div style="height: 310px;overflow-y: scroll" id="checked-action">
                                                <p>
                                                    <span>类目词:</span>
                                                    <span id="class-count" class="layui-badge layui-bg-cyan">0</span>&nbsp;&nbsp;
                                                    <span>关键词:</span>
                                                    <span id="keyword-count" class="layui-badge layui-bg-green">0</span>
                                                </p>
                                                <table id="act-checked" lay-filter="action-keyword" class="layui-table"
                                                       lay-skin="row">
                                                    <colgroup>
                                                        <col width="150">
                                                    </colgroup>
                                                    <thead>
                                                    <tr>
                                                        <th id="view-act-type">全部 <i class="layui-icon layui-icon-triangle-d"></i></th>
                                                        <th>覆盖人数</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="act-list">
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">没有数据哦 :)</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-md1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="layui-form-item">
                    <label class="layui-form-label">兴趣</label>
                    <div class="layui-input-block">
                        <div style="background-color: #F2F2F2; ">
                            <div class="layui-row layui-col-space15">
                                <div class="layui-col-md1"></div>
                                <div class="layui-col-md10">
                                    <div class="layui-tab layui-tab-brief" lay-filter="interestKeywordTab">
                                        <ul class="layui-tab-title">
                                            <li class="layui-this" lay-id="1">添加类目词</li>
                                            <li lay-id="2">添加关键词</li>
                                        </ul>
                                        <div class="layui-tab-content layui-col-md6">
                                            <div class="layui-tab-item layui-show">
                                                <div class="layui-card">
                                                    <div class="layui-card-header">兴趣类目词</div>
                                                    <div class="layui-card-body">
                                                        <ul id="interest-tree" class="ztree" style="height: 300px;overflow-y: scroll"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="layui-tab-item">
                                                <div class="layui-card">
                                                    <div class="layui-card-header">兴趣关键词</div>
                                                    <div class="layui-card-body">
                                                        <div style="height: 310px;overflow-y: scroll" id="checked-act-keyword">
                                                            <div>
                                                                <input type="text" id="inter-word" placeholder="请输入兴趣类目词或关键词"  class="layui-input" style="display: inline-block; width:80%">
                                                                <a class="layui-btn layui-btn-normal" style="display: inline-block" id="search-interest-word">搜索</a>
                                                            </div>
                                                            <table lay-filter="interest-keyword-list" class="layui-table" lay-skin="row">
                                                                <thead>
                                                                <tr>
                                                                    <th colspan="4" id="search-inval"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="in-keyword-list">
                                                                <tr>
                                                                    <td colspan="2" style="text-align: center">
                                                                        请在上方输入关键词或点击右侧查关键词 :)
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-card layui-col-md6">
                                        <div class="layui-card-header">
                                            <div class="layui-row">
                                                <p class="layui-col-md6">
                                                    还可添加兴趣：
                                                    <span class="layui-badge layui-bg-orange" id="interest-count">350</span>
                                                    个
                                                </p>

                                                <p class="layui-col-md6" style="text-align: right">
                                                    <a class="layui-btn layui-btn-normal  layui-btn-xs" id="inte-del-all">清空</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="layui-card-body">
                                            <div style="height: 310px;overflow-y: scroll" id="checked-action">
                                                <p>
                                                    <span>类目词:</span>
                                                    <span id="interest-class-count" class="layui-badge layui-bg-cyan">0</span>&nbsp;&nbsp;
                                                    <span>关键词:</span>
                                                    <span id="interest-keyword-count" class="layui-badge layui-bg-green">0</span>
                                                </p>
                                                <table id="interest-checked" lay-filter="action-keyword" class="layui-table" lay-skin="row">
                                                    <colgroup>
                                                        <col width="150">
                                                    </colgroup>
                                                    <thead>
                                                    <tr>
                                                        <th id="view-act-type">全部 <i class="layui-icon layui-icon-triangle-d"></i></th>
                                                        <th>覆盖人数</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="interest-list">
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">没有数据哦 :)</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-md1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!--平台一开始就固定了android或ios-->
                <!--<div class="layui-form-item">
                    <label class="layui-form-label">平台</label>
                    <div class="layui-input-block">
                        <input type="radio" name="sex" title="不限" checked>
                        <input type="radio" name="sex" title="IOS">
                        <input type="radio" name="sex" title="Android">
                        <input type="radio" name="sex" title="PC">
                    </div>
                </div>-->

                <div class="layui-form-item">
                    <label class="layui-form-label">网络</label>
                    <div class="layui-input-block">
                        <input type="radio" name="ac" title="不限" checked>
                        <input type="radio" name="ac" title="WIFI" value="WIFI">
                        <input type="radio" name="ac" title="2G" value="2G">
                        <input type="radio" name="ac" title="3G" value="3G">
                        <input type="radio" name="ac" title="4G" value="4G">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">运营商</label>
                    <div class="layui-input-block">
                        <input type="radio" name="carrier" title="不限" checked>
                        <input type="radio" name="carrier" title="移动" value="MOBILE">
                        <input type="radio" name="carrier" title="联通" value="UNICOM">
                        <input type="radio" name="carrier" title="电信" value="TELCOM">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">新用户</label>
                    <div class="layui-input-block">
                        <input type="radio" name="activate_type" title="不限" checked>
                        <input type="radio" name="activate_type" title="一个月以内" value="WITH_IN_A_MONTH">
                        <input type="radio" name="activate_type" title="一个月到三个月" value="ONE_MONTH_2_THREE_MONTH">
                        <input type="radio" name="activate_type" title="三个月以上" value="THREE_MONTH_EAILIER">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">手机品牌</label>
                    <div class="layui-input-block">
                        <!--<input type="checkbox" name="switch" lay-skin="switch" lay-text="自定义品牌|不限">-->
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="" title="不限" checked id="device-brand-default">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="HONOR" title="荣耀">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="APPLE" title="苹果">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="HUAWEI" title="华为">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="XIAOMI" title="小米">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="SAMSUNG" title="三星">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="OPPO" title="OPPO">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="VIVO" title="VIVO">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="MEIZU" title="魅族">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="GIONEE" title="金立">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="COOLPAD" title="酷派">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="LENOVO" title="联想">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="LETV" title="乐视">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="ZTE" title="中兴">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="CHINAMOBILE" title="中国移动">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="HTC" title="HTC">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="PEPPER" title="小辣椒">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="NUBIA" title="努比亚">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="HISENSE" title="海信">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="QIKU" title="奇酷">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="TCL" title="TCL">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="SONY" title="索尼">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="SMARTISAN" title="锤子手机">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="360" title="360手机">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="LG" title="LG">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="MOTO" title="摩托罗拉">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="NOKIA" title="诺基亚">
                        <input type="checkbox" name="device_brand[]" lay-filter="device_brand" value="GOOGLE" title="谷歌">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">手机价格</label>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="launch_price[]" placeholder="￥" autocomplete="off" class="layui-input" value="0">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="launch_price[]" placeholder="￥"  value="11000" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">元，输入0为不限制手机价格</div>
                    </div>
                </div>
                <div class="site-title">
                    <fieldset>
                        <legend><a name="inline">预算与出价</a></legend>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">出价方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="smart_bid_type" title="手动" lay-filter="smart_bid_type" checked value="SMART_BID_CUSTOM">
                        <input type="radio" name="smart_bid_type" title="自动" lay-filter="smart_bid_type" value="SMART_BID_CONSERVATIVE">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 投放方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="flow_control_mode" title="优先跑量" checked value="FLOW_CONTROL_MODE_FAST">
                        <input type="radio" name="flow_control_mode" title="均衡投放" value="FLOW_CONTROL_MODE_BALANCE">
                        <input type="radio" name="flow_control_mode" title="优先低成本" value="FLOW_CONTROL_MODE_SMOOTH">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">* 预算</label>
                    <div class="layui-input-inline" style="width: 100px;">
                        <select name="budget_mode" id="budget_mode">
                            <option value="BUDGET_MODE_DAY">日预算</option>
                            <option value="BUDGET_MODE_TOTAL">总预算</option>
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width: 400px;">
                        <input type="number" name="budget" placeholder="" autocomplete="off" class="layui-input" style="display: inline-block;width: 93%" min="300" lay-verify="required">
                        <span style="display: inline">元</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">投放时间</label>
                    <div class="layui-input-block">
                        <input type="radio" name="schedule_type" title="从今天起长期投放" checked value="SCHEDULE_FROM_NOW" lay-filter="schedule_type">
                        <input type="radio" name="schedule_type" title="设置开始和结束日期" value="SCHEDULE_START_END" lay-filter="schedule_type">
                    </div>
                </div>
                <div class="layui-form-item" style="display: none" id="schedule_time">
                    <div class="layui-inline">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-inline" style="width: 200px;">
                            <input type="date" name="start_time" autocomplete="off"  class="layui-input" id="schedule_start_time">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 200px;">
                            <input type="date" name="end_time"  autocomplete="off" class="layui-input" id="schedule_end_time">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">投放时段</label>
                    <div class="layui-input-block">
                        <input type="radio" name="schedule_time" lay-filter="schedule_time" title="不限" checked value="0">
                        <input type="radio" name="schedule_time" lay-filter="schedule_time" title="指定时间段" value="1">
                        <input type="hidden" name="schedule_time" id="schedule_time_elem" value="">
                    </div>
                </div>
                <div class="layui-form-item" id="schedule-time-box" style="display: none">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <table class="layui-table" lay-size="sm" id="schedule_time_table">
                            <thead>
                            <tr>
                                <th rowspan="2">星期/时间</th>
                                <th colspan="24">00:00 - 12:00</th>
                                <th colspan="24">12:00 - 24:00</th>
                            </tr>
                            <tr>
                                <th colspan="2">0</th>
                                <th colspan="2">1</th>
                                <th colspan="2">2</th>
                                <th colspan="2">3</th>
                                <th colspan="2">4</th>
                                <th colspan="2">5</th>
                                <th colspan="2">6</th>
                                <th colspan="2">7</th>
                                <th colspan="2">8</th>
                                <th colspan="2">9</th>
                                <th colspan="2">10</th>
                                <th colspan="2">11</th>
                                <th colspan="2">12</th>
                                <th colspan="2">13</th>
                                <th colspan="2">14</th>
                                <th colspan="2">15</th>
                                <th colspan="2">16</th>
                                <th colspan="2">17</th>
                                <th colspan="2">18</th>
                                <th colspan="2">19</th>
                                <th colspan="2">20</th>
                                <th colspan="2">21</th>
                                <th colspan="2">22</th>
                                <th colspan="2">23</th>
                            </tr>
                            </thead>
                            <tbody id="select-body">
                            <tr>
                                <td class="week">星期一</td>
                                <td class="select-item" id="first-select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                            </tr>
                            <tr>
                                <td class="week">星期二</td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                            </tr>
                            <tr>
                                <td class="week">星期三</td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                            </tr>
                            <tr>
                                <td class="week">星期四</td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                            </tr>
                            <tr>
                                <td class="week">星期五</td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                            </tr>
                            <tr>
                                <td class="week">星期六</td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                            </tr>
                            <tr>
                                <td class="week">星期日</td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                                <td class="select-item"></td>
                            </tr>
                            </tbody>
                            <tfoter id="select-week-item">
                                <tr style="height: 47px;border-bottom: none;">
                                    <td colspan="25" style="text-align: left;border-right: none;font-size: 14px;color: #333333;">可拖动鼠标选择时间段</td>
                                    <td colspan="24" style="text-align: right;border-left: none"><a class="layui-btn layui-btn-radius layui-btn-sm" id="toggle-all-btn">全选 / 清空</a></td>
                                </tr>
                                    <tr style="height: 22px; display: none" id="select-item-0">
                                        <td class="week">星期一</td>
                                        <td colspan="48" style="text-align: left;font-size: 14px;color:#333"></td>
                                    </tr>
                                    <tr style="height: 22px; display: none" id="select-item-1">
                                        <td class="week">星期二</td>
                                        <td colspan="48" style="text-align: left;font-size: 14px;color:#333"></td>
                                    </tr>
                                    <tr style="height: 22px; display: none" id="select-item-2">
                                        <td class="week">星期三</td>
                                        <td colspan="48" style="text-align: left;font-size: 14px;color:#333"></td>
                                    </tr>
                                    <tr style="height: 22px; display: none" id="select-item-3">
                                        <td class="week">星期四</td>
                                        <td colspan="48" style="text-align: left;font-size: 14px;color:#333"></td>
                                    </tr>
                                    <tr style="height: 22px; display: none" id="select-item-4">
                                        <td class="week">星期五</td>
                                        <td colspan="48" style="text-align: left;font-size: 14px;color:#333"></td>
                                    </tr>
                                    <tr style="height: 22px; display: none" id="select-item-5">
                                        <td class="week">星期六</td>
                                        <td colspan="48" style="text-align: left;font-size: 14px;color:#333"></td>
                                    </tr>
                                    <tr style="height: 22px; display: none" id="select-item-6">
                                        <td class="week">星期日</td>
                                        <td colspan="48" style="text-align: left;font-size: 14px;color:#333"></td>
                                    </tr>
                            </tfoter>
                        </table>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 目标转换出价</label>
                    <div class="layui-input-inline">
                        <input type="number" name="cpa_bid" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input" min="0">
                    </div>
                    <div class="layui-form-mid layui-word-aux">元</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">过滤已转化用户</label>
                    <div class="layui-input-block">
                        <input type="radio" name="hide_if_converted" title="广告计划" checked value="AD">
                        <input type="radio" name="hide_if_converted" title="广告组" value="CAMPAIGN">
                        <input type="radio" name="hide_if_converted" title="广告账户" value="ADVERTISER">
                        <input type="radio" name="hide_if_converted" title="APP" value="APP">
                        <input type="radio" name="hide_if_converted" title="不过滤" value="NO_EXCLUDE">
                    </div>
                </div>
                <div class="site-title">
                    <fieldset>
                        <legend><a name="inline">设置投放位置</a></legend>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 广告投放位置</label>
                    <div class="layui-input-block">
                        <input type="radio" name="ad_position" lay-filter="ad_position" title="优选广告位" checked value="1">
                        <input type="radio" name="ad_position" lay-filter="ad_position" title="按媒体指定位置" value="2">
                        <input type="radio" name="ad_position" lay-filter="ad_position" title="按场景指定位置" value="3">
                    </div>
                        <input type="hidden" name="smart_inventory" value="1" id="smart_inventory">
                    <div class="layui-input-block" id="ad_position_2" style="background: #f2f2f2;padding: 20px; display: none">
                        <input type="checkbox" name="inventory_type[]" lay-filter="inventory_type" value="INVENTORY_FEED" title="今日头条" checked>
                        <input type="checkbox" name="inventory_type[]" lay-filter="inventory_type" value="INVENTORY_VIDEO_FEED" title="西瓜视频" checked>
                        <input type="checkbox" name="inventory_type[]" lay-filter="inventory_type" value="INVENTORY_HOTSOON_FEED" title="火山小视频" checked>
                        <input type="checkbox" name="inventory_type[]" lay-filter="inventory_type" value="INVENTORY_AWEME_FEED" title="抖音" checked>
                        <input type="checkbox" name="inventory_type[]" lay-filter="inventory_type" value="INVENTORY_UNION_SLOT" title="穿山甲" checked>
                        <input type="checkbox" name="inventory_type[]" lay-filter="inventory_type" value="UNION_BOUTIQUE_GAME" title="穿山甲精选休闲游戏" checked>
                    </div>
                    <div class="layui-input-block" id="ad_position_3" style="background: #f2f2f2;padding: 20px;display: none">
                        <input type="radio" name="scene_inventory" title="沉浸式竖版视频场景"  value="VIDEO_SCENE">
                        <input type="radio" name="scene_inventory" title="信息流场景"  value="FEED_SCENE">
                        <input type="radio" name="scene_inventory" title="视频后贴和尾帧场景" checked value="TAIL_SCENE">
                    </div>
                </div>
                <div class="site-title">
                    <fieldset>
                        <legend><a name="inline">制作创意</a></legend>
                    </fieldset>
                </div>
               <!--<div class="layui-form-item">
                    <label class="layui-form-label">* 应用名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="package" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux"><span id="input-char">0</span>/<span>12</span></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">副标题</label>
                    <div class="layui-input-inline">
                        <input type="text" name="package" required lay-verify="required" placeholder="4-24个字符"
                               autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux"><span id="input-char">0</span>/<span>12，中文占两个字符</span>
                    </div>
                </div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label">* 图片生成视频</label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_presented_video" title="不启用" checked value="0">
                        <input type="radio" name="is_presented_video" title="启用" value="1">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">最优创意衍生计划</label>
                    <div class="layui-input-block">
                        <input type="radio" name="generate_derived_ad" title="不启用" checked value="0">
                        <input type="radio" name="generate_derived_ad" title="启用" value="1">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 广告评论</label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_comment_disable" title="开启" checked value="0">
                        <input type="radio" name="is_comment_disable" title="关闭" value="1">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">创意展现</label>
                    <div class="layui-input-block">
                        <input type="radio" name="creative_display_mode" title="优选模式" checked value="CREATIVE_DISPLAY_MODE_CTR">
                        <input type="radio" name="creative_display_mode" title="轮播模式" value="CREATIVE_DISPLAY_MODE_RANDOM">
                    </div>
                </div>
                <div class="site-title">
                    <fieldset>
                        <legend><a name="inline">创意分类</a></legend>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 创意分类</label>
                    <div class="layui-input-inline">
                        <select id="industry_1" lay-filter="industry_1">
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select id="industry_2" lay-filter="industry_2">
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="third_industry_id" id="industry_3" lay-filter="industry_3">
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">* 创意标签</label>
                        <div class="layui-input-inline" style="width: 500px;">
                            <input type="text" placeholder="最多20个标签，每个不超过10个字。可空格分隔" autocomplete="off" class="layui-input" id="tag-input">
                        </div>
                        <button type="button" class="layui-btn layui-btn-normal" id="tag-add">添　加</button>
                    </div>
                    <div class="layui-input-block" id="select-tags">
                    </div>
                </div>
                <div class="site-title">
                    <fieldset>
                        <legend><a name="inline">定向包属性</a></legend>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">* 定向包名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="package_name" required  lay-verify="required" placeholder="请输入定向包名称" autocomplete="off" class="layui-input" maxlength="200">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="saveDirectional">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div id="keyword-box"></div>

<!--<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('CDN_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
lib/layui/layui.js"><?php echo '</script'; ?>
>-->
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/layui-v2.5.5/layui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_cdn_static_url_']->value, ENT_QUOTES, 'UTF-8');?>
js/jquery-3.3.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
zTree_v3/js/jquery.ztree.core.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
zTree_v3/js/jquery.ztree.exhide.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
zTree_v3/js/fuzzysearch.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/jrtt-form.js?v=1"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
/js/schedule-time-select.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo htmlspecialchars(@constant('SYS_STATIC_URL'), ENT_QUOTES, 'UTF-8');?>
zTree_v3/js/jquery.ztree.excheck.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
?>