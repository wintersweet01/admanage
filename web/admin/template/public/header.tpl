<!DOCTYPE html>
<html>
<head>
    <title><{$__title__}></title>
    <{include file="../public/head.tpl"}>
    <style>
        fieldset{margin:0 2px;padding:.35em .625em .75em;border:1px solid silver}
        legend{padding:.5em;width:auto;border:0}
        #content-main table, #container {background: url("<{$__watermark_url__}>") !important;}
    </style>
</head>
<body class="hold-transition skin-blue-light sidebar-mini <{if $smarty.cookies.js_collapse}>sidebar-collapse<{/if}>"
      style="overflow:hidden;">
<div class="wrapper">
    <{if !$__html5plus__}>
    <!--头部信息-->
    <header class="main-header">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand logo" href="?ct=base"><span class="logo-lg"><strong>数据后台</strong></span></a>
                </div>
                <!--<div class="sidebar-toggle"><span class="sr-only">切换</span></div>-->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <{foreach from=$__first_menu_conf__ key=key item=menu}>
                        <{if in_array($key,$__first_menu__) || in_array('*',$__first_menu__)}>
                        <li><a href="javascript:;" class="first_menu" data-menu="<{$key}>"><{$menu}></a></li>
                        <{/if}>
                        <{/foreach}>
                    </ul>

                    <div class="form-inline navbar-form navbar-left">
                        <{if SrvAuth::checkPublicAuth('userInfo',false)}>
                        <div class="input-group" style="min-width: 300px;">
                            <input type="text" id="nav-keyword" class="form-control" placeholder="UID/账号/手机号/设备号/角色名">
                            <span class="input-group-btn"><button type="button" id="nav-search" class="btn btn-default">搜索</button></span>
                        </div>
                        <{/if}>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false"><{$__name__}> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li id="modify-userinfo"><a href="#"><span class="glyphicon glyphicon-edit"
                                                                           aria-hidden="true"></span>修改密码</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="?ct=index&ac=logout" style="color: red;"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>
<!--左边导航-->
    <div class="main-sidebar" style="height: 100%">
        <div class="sidebar" style="height: 100%;background: #ffffff;">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<{$smarty.const.SYS_STATIC_URL}>/img/logo.png" class="img-circle" alt="User Image">
                </div>
            </div>
            <ul class="sidebar-menu" id="sidebar-menu">
                <{foreach from=$__menu__ item=menu key=name}>
                <li class="treeview <{if $name == $__on_menu__}>active<{/if}>" style="display: none"
                    data-menu="<{$menu.first_menu}>"><a href="#"><i class="fa fa-<{$menu.icon}>"></i><span
                                style="font-size:13px;"><{$menu.name}></span><i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu"
                    <{if $name == $__on_menu__}>style="display: block;"<{/if}>>
                    <{foreach from=$menu.menu item=n key=ac}>
                <li>
                    <a class="menuItem" <{if $ac==$__on_sub_menu__}>style="font-weight: bolder;color: #447ed9;"<{/if}>
                    href="?ct=<{$name}>&ac=<{$ac}>" data-id="<{$n}>"><i class="fa fa-tags"></i><{$n}></a>
                </li>
                <{/foreach}>
            </ul>
            </li>
            <{/foreach}>
            </ul>
        </div>
    </div>
    <{/if}>
    <!--中间内容-->
    <div id="content-wrapper" class="content-wrapper <{if $__html5plus__}>html5plus<{/if}>" style="overflow: auto;">
        <div class="content-iframe">
            <div class="mainContent" id="content-main" style="margin: 10px; padding: 0;">