<script type="text/javascript">
    //加载JS文件
    var loadScript = function (id, url, callback) {
        //已经加载
        if (document.getElementById(id)) {
            if (typeof (callback) == "function") {
                callback();
            }
            return true;
        }

        var script = document.createElement("script");
        script.type = "text/javascript";
        script.id = id;
        if (typeof (callback) == "function") {
            if (script.readyState) {
                script.onreadystatechange = function () {
                    if (script.readyState == "loaded" || script.readyState == "complete") {
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else {
                script.onload = function () {
                    callback();
                };
            }
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    };

    //加载CSS文件
    var loadStyle = function (id, url) {
        //已经加载
        if (document.getElementById(id)) {
            return true;
        }

        var link = document.createElement('link');
        link.type = 'text/css';
        link.rel = 'stylesheet';
        link.id = id;
        link.href = url;
        document.getElementsByTagName('head')[0].appendChild(link);
    };

	if (typeof $('select').select2 == "undefined") {
		loadScript('select2-js', '<{$_cdn_static_url_}>lib/select2/js/select2.min.js', function () {
			loadStyle('select2-css', '<{$_cdn_static_url_}>lib/select2/css/select2.min.css');

			//加载select控件
			$('select').each(function (i, elem) {
				if (!$(elem).hasClass("select2-hidden-accessible")) {
					$(elem).select2({
						dropdownAutoWidth: true
					});
				}
			});
		});
	}
</script>
<{foreach from=$widgets key=key item=FIELD}>
	<{include file="widget/<{$FIELD.type}>.tpl"}>
<{/foreach}>