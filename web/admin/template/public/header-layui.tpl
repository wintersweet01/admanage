<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><{$__title__}></title>
    <link rel="stylesheet" href="<{$_cdn_static_url_}>lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<{$_cdn_static_url_}>lib/layui-2.5/css/layui.css">
    <link rel="stylesheet" href="<{$smarty.const.SYS_STATIC_URL}>/css/main.css">
    <script>
        <{if $__domain__}>
        document.domain = '<{$__domain__}>';
        <{/if}>
        var html5plus = parseInt('<{$__html5plus__}>');
        var is_mobile = false;
        if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
            is_mobile = true;
        }
    </script>
    <script src="<{$_cdn_static_url_}>lib/layui-2.5/layui.js"></script>
</head>
<body>