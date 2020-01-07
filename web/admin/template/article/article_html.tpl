<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit"/>
    <meta content="" name="Keywords">
    <meta content="" name="Description">
    <title><{$data.title}></title>
    <style type="text/css">
        html{width:100%;height:100%;font-size:100px;overflow-x: hidden;box-sizing: border-box;}
        *{box-sizing: border-box;}
        body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, form, input, button, textarea, p, blockquote{margin: 0;padding: 0;}
        ul, li{list-style: none;}
        img, object{max-width: 100%;}
        body{font-family:Helvetica ,Roboto,Noto,"microsoft yahei";color:#666666;width: 100%;font-size:16px;box-sizing: border-box;background: #ffffff;margin:0 auto;overflow-x:hidden ;position: relative;}
        .content{overflow: hidden;width: 94%;margin: 0 auto}
        .contit{color: #333333;font-size: 0.35rem;text-align: center;margin-top: 0.3rem;}
        .coninfor{color:#999;font-size: 0.2rem;text-align: center;margin-top: 0.1rem;}
        .context{font-size: 0.22rem;color: #666;line-height: 0.36rem;margin-top: 0.4rem;}
    </style>
</head>

<body>
<div class="content">
    <h1 class="contit"><span style="color: <{$data.color}>;<{if $data.isstrong}>font-weight: bold;<{/if}>"><{$data.title}></span>
    </h1>
    <div class="coninfor"><{if $data.author}><span>作者：<{$data.author}></span>&nbsp;&nbsp;<{/if}><span>时间：<{$data.addtime}></span></div>
    <div class="context">
        <{$data.content nofilter}>
    </div>
</div>
<script>
    (function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if (clientWidth >= 750) {
                    docEl.style.fontSize = '100px';
                } else {
                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
                }
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
</script>
</body>
</html>