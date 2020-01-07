$(function () {
    $('form').find('input[name="username"]').val(getCookie('ht_name'));
    $('form').find('input[name="keep"]').prop('checked', getCookie('ht_keep') == 1 ? true : false);

    $('#js-mVcodeImg').on('click', function () {
        $('#js-mVcodeImg').attr('src', '?ct=captcha&_=' + Math.random());
    });

    $('form').submit(function (e) {
        e.preventDefault(e);
        var obj = $(this);
        var h = $('h1');
        var title = h.text();

        obj.fadeOut(1000, function () {
            h.text('正在登录...');
        });
        $('.wrapper').addClass('form-success');

        $.ajax({
            url: '?ct=index&ac=login',
            type: "POST",
            data: obj.serializeArray(),
            dataType: "json",
            async: false,
            success: function (ret) {
                setTimeout(function () {
                    h.text(ret.message);
                    if (ret.code == 1) {
                        setTimeout("window.location.href = '?ct=base'", 1500);
                    } else {
                        setTimeout(function () {
                            obj.fadeIn(1000);
                            $('.wrapper').removeClass('form-success');
                            h.text(title);
                            if (ret.data.isNeedCaptcha) {
                                $('input[name="code"]').attr('required', true);
                                $('.code').show();
                                $('#js-mVcodeImg').click();
                            }
                        }, 1500);
                    }
                }, 1500);
            },
            error: function (res) {
                h.text('网络繁忙');
                setTimeout(function () {
                    setTimeout(function () {
                        obj.fadeIn(1000);
                        $('.wrapper').removeClass('form-success');
                        h.text(title);
                    }, 1500);
                }, 1500);
            }
        });

        return false;
    });

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
        }
        return "";
    }
});