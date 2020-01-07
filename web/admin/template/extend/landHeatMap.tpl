<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit"/>
    <title>热点图</title>
    <script src="<{$smarty.const.SYS_STATIC_URL}>js/jquery/jQuery-2.2.0.min.js"></script>
    <script src="<{$smarty.const.SYS_STATIC_URL}>js/heatmap.min.js"></script>
    <style type="text/css">
        html, body {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            margin: 0px;
            padding: 0px;
        }

        .rows {
            position: relative;
            margin-bottom: 0.8%;
            overflow: hidden;
        }

        #iframe {
            width: 640px;
            position: absolute;
        }

        #cover {
            width: 640px;
            position: relative;
        }
    </style>
</head>
<body>
<div id="areascontent">
    <div class="rows">
        <iframe src="<{$data.url}>" frameborder="0" scrolling="no" id="iframe"></iframe>
        <div class="cover" id="cover"></div>
    </div>
</div>
<script>
    document.domain = '<{$smarty.const.GLOBAL_DOMAIN}>';
    $(function () {
        var heatmap;

        function changeFrameHeight() {
            var height = $('#iframe').contents().height() + 50;
            $('#iframe').css('height', height + 'px');
            $('#cover').css('height', height + 'px');
            $('.heatmap-canvas').remove();
            heatmap = h337.create({
                container: $('#cover')[0]
            });
            <{if $data.click}>
            heatmap.setData({
                max: <{$data.max}>,
                data: [
                <{foreach from=$data.click key=key name=click item=val}>
                    <{foreach from=$val key=k item=v}>
                    { x: <{$key}>, y: parseInt(<{$k}>*height/10000), value: <{$v}>},
                    <{/foreach}>
                <{/foreach}>
                ]
            });
        <{/if}>
        }

        $('#iframe').load(function () {
            changeFrameHeight();
        });
        window.onresize = function () {
            //changeFrameHeight();
        };
    });
</script>
</body>
</html>