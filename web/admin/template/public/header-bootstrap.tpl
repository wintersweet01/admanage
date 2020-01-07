<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><{$__title__}></title>
    <link rel="stylesheet" href="<{$_cdn_static_url_}>lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<{$_cdn_static_url_}>lib/font-awesome/css/font-awesome.min.css">
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
    <script src="<{$_cdn_static_url_}>js/jquery-3.3.1.min.js"></script>
    <script src="<{$_cdn_static_url_}>lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="<{$_cdn_static_url_}>lib/layer/layer.js"></script>
</head>
<body>