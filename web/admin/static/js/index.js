(function ($) {
    $.httab = {
        requestFullScreen: function () {
            var de = document.documentElement;
            if (de.requestFullscreen) {
                de.requestFullscreen();
            } else if (de.mozRequestFullScreen) {
                de.mozRequestFullScreen();
            } else if (de.webkitRequestFullScreen) {
                de.webkitRequestFullScreen();
            }
        },
        exitFullscreen: function () {
            var de = document;
            if (de.exitFullscreen) {
                de.exitFullscreen();
            } else if (de.mozCancelFullScreen) {
                de.mozCancelFullScreen();
            } else if (de.webkitCancelFullScreen) {
                de.webkitCancelFullScreen();
            }
        },
        refreshTab: function () {
            var currentId = $('.page-tabs-content').find('.active').attr('data-id');
            var target = $('.DAMAI_iframe[data-id="' + currentId + '"]');
            var url = target.attr('src');
            //$.loading(true);
            target.attr('src', url).load(function () {
                //$.loading(false);
            });
        },
        activeTab: function () {
            var currentId = $(this).data('id');
            if (!$(this).hasClass('active')) {
                $('.mainContent .DAMAI_iframe').each(function () {
                    if ($(this).data('id') == currentId) {
                        $(this).show().siblings('.DAMAI_iframe').hide();
                        return false;
                    }
                });
                $(this).addClass('active').siblings('.menuTab').removeClass('active');
                $.httab.scrollToTab(this);
            }
        },
        closeOtherTabs: function () {
            $('.page-tabs-content').children("[data-id]").find('.fa-remove').parents('a').not(".active").each(function () {
                $('.DAMAI_iframe[data-id="' + $(this).data('id') + '"]').remove();
                $(this).remove();
            });
            $('.page-tabs-content').css("margin-left", "0");
        },
        closeTab: function () {
            var closeTabId = $(this).parents('.menuTab').data('id');
            var currentWidth = $(this).parents('.menuTab').width();
            if ($(this).parents('.menuTab').hasClass('active')) {
                if ($(this).parents('.menuTab').next('.menuTab').size()) {
                    var activeId = $(this).parents('.menuTab').next('.menuTab:eq(0)').data('id');
                    $(this).parents('.menuTab').next('.menuTab:eq(0)').addClass('active');

                    $('.mainContent .DAMAI_iframe').each(function () {
                        if ($(this).data('id') == activeId) {
                            $(this).show().siblings('.DAMAI_iframe').hide();
                            return false;
                        }
                    });
                    var marginLeftVal = parseInt($('.page-tabs-content').css('margin-left'));
                    if (marginLeftVal < 0) {
                        $('.page-tabs-content').animate({
                            marginLeft: (marginLeftVal + currentWidth) + 'px'
                        }, "fast");
                    }
                    $(this).parents('.menuTab').remove();
                    $('.mainContent .DAMAI_iframe').each(function () {
                        if ($(this).data('id') == closeTabId) {
                            $(this).remove();
                            return false;
                        }
                    });
                }
                if ($(this).parents('.menuTab').prev('.menuTab').size()) {
                    var activeId = $(this).parents('.menuTab').prev('.menuTab:last').data('id');
                    $(this).parents('.menuTab').prev('.menuTab:last').addClass('active');
                    $('.mainContent .DAMAI_iframe').each(function () {
                        if ($(this).data('id') == activeId) {
                            $(this).show().siblings('.DAMAI_iframe').hide();
                            return false;
                        }
                    });
                    $(this).parents('.menuTab').remove();
                    $('.mainContent .DAMAI_iframe').each(function () {
                        if ($(this).data('id') == closeTabId) {
                            $(this).remove();
                            return false;
                        }
                    });
                }
            } else {
                $(this).parents('.menuTab').remove();
                $('.mainContent .DAMAI_iframe').each(function () {
                    if ($(this).data('id') == closeTabId) {
                        $(this).remove();
                        return false;
                    }
                });
                $.httab.scrollToTab($('.menuTab.active'));
            }
            return false;
        },
        addTab: function () {
            $(".navbar-custom-menu>ul>li.open").removeClass("open");
            var dataId = $(this).attr('data-id');
            if (dataId != "") {
                //top.$.cookie('nfine_currentmoduleid', dataId, { path: "/" });
            }
            var dataUrl = $(this).attr('href');
            var menuName = $.trim($(this).text());
            var flag = true;
            if (dataUrl == undefined || $.trim(dataUrl).length == 0) {
                return false;
            }
            $('.menuTab').each(function () {
                if ($(this).data('id') == dataUrl) {
                    if (!$(this).hasClass('active')) {
                        $(this).addClass('active').siblings('.menuTab').removeClass('active');
                        $.httab.scrollToTab(this);
                        $('.mainContent .DAMAI_iframe').each(function () {
                            if ($(this).data('id') == dataUrl) {
                                $(this).show().siblings('.DAMAI_iframe').hide();
                                return false;
                            }
                        });
                    }
                    $.httab.refreshTab();
                    flag = false;
                    return false;
                }
            });
            if (flag) {
                var str = '<a href="javascript:;" class="active menuTab" data-id="' + dataUrl + '">' + menuName + ' <i class="fa fa-remove"></i></a>';
                $('.menuTab').removeClass('active');
                var str1 = '<iframe class="DAMAI_iframe" id="iframe' + dataId + '" name="iframe' + dataId + '"  width="100%" height="100%" src="' + dataUrl + '" frameborder="0" data-id="' + dataUrl + '" seamless></iframe>';
                $('.mainContent').find('iframe.DAMAI_iframe').hide();
                $('.mainContent').append(str1);
                //$.loading(true);
                $('.mainContent iframe:visible').load(function () {
                    //$.loading(false);
                });
                $('.menuTabs .page-tabs-content').append(str);
                $.httab.scrollToTab($('.menuTab.active'));
            }
            return false;
        },
        scrollTabRight: function () {
            var marginLeftVal = Math.abs(parseInt($('.page-tabs-content').css('margin-left')));
            var tabOuterWidth = $.httab.calSumWidth($(".content-tabs").children().not(".menuTabs"));
            var visibleWidth = $(".content-tabs").outerWidth(true) - tabOuterWidth;
            var scrollVal = 0;
            if ($(".page-tabs-content").width() < visibleWidth) {
                return false;
            } else {
                var tabElement = $(".menuTab:first");
                var offsetVal = 0;
                while ((offsetVal + $(tabElement).outerWidth(true)) <= marginLeftVal) {
                    offsetVal += $(tabElement).outerWidth(true);
                    tabElement = $(tabElement).next();
                }
                offsetVal = 0;
                while ((offsetVal + $(tabElement).outerWidth(true)) < (visibleWidth) && tabElement.length > 0) {
                    offsetVal += $(tabElement).outerWidth(true);
                    tabElement = $(tabElement).next();
                }
                scrollVal = $.httab.calSumWidth($(tabElement).prevAll());
                if (scrollVal > 0) {
                    $('.page-tabs-content').animate({
                        marginLeft: 0 - scrollVal + 'px'
                    }, "fast");
                }
            }
        },
        scrollTabLeft: function () {
            var marginLeftVal = Math.abs(parseInt($('.page-tabs-content').css('margin-left')));
            var tabOuterWidth = $.httab.calSumWidth($(".content-tabs").children().not(".menuTabs"));
            var visibleWidth = $(".content-tabs").outerWidth(true) - tabOuterWidth;
            var scrollVal = 0;
            if ($(".page-tabs-content").width() < visibleWidth) {
                return false;
            } else {
                var tabElement = $(".menuTab:first");
                var offsetVal = 0;
                while ((offsetVal + $(tabElement).outerWidth(true)) <= marginLeftVal) {
                    offsetVal += $(tabElement).outerWidth(true);
                    tabElement = $(tabElement).next();
                }
                offsetVal = 0;
                if ($.httab.calSumWidth($(tabElement).prevAll()) > visibleWidth) {
                    while ((offsetVal + $(tabElement).outerWidth(true)) < (visibleWidth) && tabElement.length > 0) {
                        offsetVal += $(tabElement).outerWidth(true);
                        tabElement = $(tabElement).prev();
                    }
                    scrollVal = $.httab.calSumWidth($(tabElement).prevAll());
                }
            }
            $('.page-tabs-content').animate({
                marginLeft: 0 - scrollVal + 'px'
            }, "fast");
        },
        scrollToTab: function (element) {
            var marginLeftVal = $.httab.calSumWidth($(element).prevAll()),
                marginRightVal = $.httab.calSumWidth($(element).nextAll());
            var tabOuterWidth = $.httab.calSumWidth($(".content-tabs").children().not(".menuTabs"));
            var visibleWidth = $(".content-tabs").outerWidth(true) - tabOuterWidth;
            var scrollVal = 0;
            if ($(".page-tabs-content").outerWidth() < visibleWidth) {
                scrollVal = 0;
            } else if (marginRightVal <= (visibleWidth - $(element).outerWidth(true) - $(element).next().outerWidth(true))) {
                if ((visibleWidth - $(element).next().outerWidth(true)) > marginRightVal) {
                    scrollVal = marginLeftVal;
                    var tabElement = element;
                    while ((scrollVal - $(tabElement).outerWidth()) > ($(".page-tabs-content").outerWidth() - visibleWidth)) {
                        scrollVal -= $(tabElement).prev().outerWidth();
                        tabElement = $(tabElement).prev();
                    }
                }
            } else if (marginLeftVal > (visibleWidth - $(element).outerWidth(true) - $(element).prev().outerWidth(true))) {
                scrollVal = marginLeftVal - $(element).prev().outerWidth(true);
            }
            $('.page-tabs-content').animate({
                marginLeft: 0 - scrollVal + 'px'
            }, "fast");
        },
        calSumWidth: function (element) {
            var width = 0;
            $(element).each(function () {
                width += $(this).outerWidth(true);
            });
            return width;
        },
        setCookie: function (cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString() + "; ";
            document.cookie = cname + "=" + cvalue + "; " + (exdays ? expires : '') + 'path=/';
        },
        getCookie: function (cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
            }
            return "";
        },
        init: function () {
            //$('.menuItem').on('click', $.httab.addTab);
            $('.menuTabs').on('click', '.menuTab i', $.httab.closeTab);
            $('.menuTabs').on('click', '.menuTab', $.httab.activeTab);
            $('.tabLeft').on('click', $.httab.scrollTabLeft);
            $('.tabRight').on('click', $.httab.scrollTabRight);
            $('.tabReload').on('click', $.httab.refreshTab);
            $('.tabCloseCurrent').on('click', function () {
                $('.page-tabs-content').find('.active i').trigger("click");
            });
            $('.tabCloseAll').on('click', function () {
                $('.page-tabs-content').children("[data-id]").find('.fa-remove').each(function () {
                    $('.DAMAI_iframe[data-id="' + $(this).data('id') + '"]').remove();
                    $(this).parents('a').remove();
                });
                $('.page-tabs-content').children("[data-id]:first").each(function () {
                    $('.DAMAI_iframe[data-id="' + $(this).data('id') + '"]').show();
                    $(this).addClass("active");
                });
                $('.page-tabs-content').css("margin-left", "0");
            });
            $('.tabCloseOther').on('click', $.httab.closeOtherTabs);
            $('.fullscreen').on('click', function () {
                if (!$(this).attr('fullscreen')) {
                    $(this).attr('fullscreen', 'true');
                    $.httab.requestFullScreen();
                } else {
                    $(this).removeAttr('fullscreen');
                    $.httab.exitFullscreen();
                }
            });
        }
    };
    $.htindex = {
        load: function () {
            var h = $(window).height();

            //手机APP
            if (html5plus == 0) {
                h = h - 85;
            }

            $("body").removeClass("hold-transition");
            $("#content-wrapper").find('.mainContent').height(h);
            $(window).resize(function (e) {
                $("#content-wrapper").find('.mainContent').height(h);
            });

            if ($('.table-content').length > 0) {
                var table_width = function () {
                    //等待页面渲染完后再获取宽度
                    setTimeout(function () {
                        var width1 = $('.content-wrapper').width() + 20;
                        var width2 = $('.table-content').width() + 20;
                        if (width1 > width2) {
                            //$('.content-iframe').css('width',width1+'px');
                        } else {
                            $('.content-iframe').css('width', width2 + 'px');
                        }
                    }, 300);
                };

                table_width();
            }

            $(".sidebar-toggle").click(function () {
                if (!$("body").hasClass("sidebar-collapse")) {
                    $("body").addClass("sidebar-collapse");
                    //压缩
                    $.httab.setCookie('js_collapse', 1, 15);
                } else {
                    $("body").removeClass("sidebar-collapse");
                    $.httab.setCookie('js_collapse', 0, 15);
                }
                if (table_width) {
                    table_width();
                }
            });

            //移动端
            if (is_mobile) {
                $("body").addClass("sidebar-collapse");
                $.httab.setCookie('js_collapse', 1, 15);
            } else {
                $("body").removeClass("sidebar-collapse");
                $.httab.setCookie('js_collapse', 0, 15);
            }

            //顶部大类菜单点击事件
            $('.first_menu').on('click', function () {
                $('.first_menu').parents('li').removeClass('active');
                $(this).parents('li').addClass('active');
                $('.treeview').hide();
                $('.treeview[data-menu=' + $(this).attr('data-menu') + ']').show();
                $('.sidebar-collapse #bs-navbar-collapse').collapse('hide');
            });

            //页面加载后初始化
            $('.first_menu[data-menu=' + $('.treeview.active').attr('data-menu') + ']').parents('li').addClass('active');
            $('.treeview[data-menu=' + $('.treeview.active').attr('data-menu') + ']').show();

            //移动端下拉菜单事件监听
            $('.sidebar-collapse #bs-navbar-collapse').on('shown.bs.collapse', function () {
                var _h = $(window).height(), header = $('header').outerHeight();
                $(this).css({"height": (_h - header - 16) + 'px'});
            });
        },
        jsonWhere: function (data, action) {
            if (action == null) return;
            var reval = [];
            $(data).each(function (i, v) {
                if (action(v)) {
                    reval.push(v);
                }
            });
            return reval;
        },
        loadMenu: function () {
            $("#sidebar-menu li a").click(function () {
                var d = $(this), e = d.next('.treeview-menu'), _h = $(window).height();
                var num = is_mobile ? 0 : 500;

                if (e.is(":visible")) {
                    e.slideUp(num, function () {
                        e.removeClass("menu-open");
                    }).parent("li").removeClass("active");
                } else {
                    //收起所有菜单
                    var f = d.parents("ul").first();
                    f.find("ul:visible").slideUp(num).removeClass("menu-open");

                    e.slideDown(num, function () {
                        e.addClass("menu-open");
                        f.find("li.active").removeClass("active");
                        d.parent("li").addClass("active");

                        if (is_mobile) {
                            var o = $('.sidebar-mini.sidebar-collapse .sidebar-menu>li.active');
                            var offset = d.find('span').offset(),
                                h1 = d.find('span').outerHeight(),
                                h2 = e.outerHeight(),
                                header = $('header').outerHeight(),
                                h_max = _h - header - h1;

                            o.find(".treeview-menu").css({"max-height": h_max + 'px'});
                            if (h2 > h_max) { //菜单列表高度超出屏幕
                                o.find(".treeview-menu,span:not(.pull-right)").css({"margin-top": -(offset.top - header) + 'px'});
                            } else if ((offset.top + h1 + h2) > _h) { //菜单溢出屏幕
                                o.find(".treeview-menu,span:not(.pull-right)").css({"margin-top": -(offset.top + h1 + h2 - _h + 16) + 'px'});
                            }
                        } else {
                            var _height1 = _h - $("#sidebar-menu >li.active").position().top - 41;
                            var _height2 = $("#sidebar-menu li > ul.menu-open").height() + 10;
                            if (_height2 > _height1) {
                                $("#sidebar-menu >li > ul.menu-open").css({
                                    overflow: "auto",
                                    height: _height1
                                });
                            }
                        }
                    });
                }
            });
        }
    };
    $(function () {
        $.htindex.load();
        $.htindex.loadMenu();
        $.httab.init();
    });
})(jQuery);

var JsMain = (function ($) {
    var init = function () {
        $(function () {
            $('.fa-question-circle').on('mouseover', function () {
                layer.tips($(this).attr('alt'), $(this));
            });

            $('select').select2({
                dropdownAutoWidth: true,
                theme: "bootstrap" //使用bootstrap3模板，可以选bootstrap，bootstrap4
            });

            $('#nav-keyword').on('keyup', function (event) {
                if (event.keyCode == 13) {
                    var keyword = $(this).val();
                    JsMain.search(keyword);
                }
            });

            $('#nav-search').click(function () {
                var keyword = $('#nav-keyword').val();
                JsMain.search(keyword);
            });

            //修改密码
            $('#modify-userinfo').click(function () {
                layer.open({
                    type: 2,
                    title: '修改密码',
                    shadeClose: false,
                    shade: 0.8,
                    area: is_mobile ? ['100%', '100%'] : ['50%', '60%'],
                    content: '?ct=base&ac=modifyAdminInfo'
                });
            });

            //关键字搜索
            $('.show-userinfo').click(function () {
                var keyword = $(this).data('keyword');
                JsMain.search(keyword);
            });

            //复制
            var clipboard = new ClipboardJS('.copy');
            clipboard.on('success', function (e) {
                layer.tips('复制成功', e.trigger, {
                    tips: [4, '#3595CC'],
                    time: 2000
                });
                e.clearSelection();
            });
            clipboard.on('error', function (e) {
                layer.tips('复制失败', e.trigger, {
                    tips: [4, '#FF0000'],
                    time: 2000
                });
                e.clearSelection();
            });

            //日期
            $('.Wdate').on('click', function () {
                WdatePicker({
                    el: this,
                    dateFmt: "yyyy-MM-dd",
                    maxDate: '%y-%M-%d',
                    readOnly: true
                });
            });
        });
    };

    //搜索
    var search = function (keyword) {
        if (!keyword) {
            return false;
        }
        layer.open({
            type: 2,
            title: '用户信息',
            shadeClose: false,
            shade: 0.8,
            area: is_mobile ? ['100%', '100%'] : ['50%', '80%'],
            content: '?ct=base&ac=getUserInfo&keyword=' + encodeURI(keyword)
        });
    };

    /**
     * 时间戳格式化函数
     * @param  {string} format    格式
     * @param  {int}    timestamp 要格式化的时间 默认为当前时间
     * @return {string}           格式化的时间字符串
     */
    var date = function (format, timestamp) {
        var a, jsdate = ((timestamp) ? new Date(timestamp * 1000) : new Date());
        var pad = function (n, c) {
            if ((n = n + "").length < c) {
                return new Array(++c - n.length).join("0") + n;
            } else {
                return n;
            }
        };
        var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var txt_ordin = {1: "st", 2: "nd", 3: "rd", 21: "st", 22: "nd", 23: "rd", 31: "st"};
        var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var f = {
            // Day
            d: function () {
                return pad(f.j(), 2)
            },
            D: function () {
                return f.l().substr(0, 3)
            },
            j: function () {
                return jsdate.getDate()
            },
            l: function () {
                return txt_weekdays[f.w()]
            },
            N: function () {
                return f.w() + 1
            },
            S: function () {
                return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'
            },
            w: function () {
                return jsdate.getDay()
            },
            z: function () {
                return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0
            },

            // Week
            W: function () {
                var a = f.z(), b = 364 + f.L() - a;
                var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;
                if (b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b) {
                    return 1;
                } else {
                    if (a <= 2 && nd >= 4 && a >= (6 - nd)) {
                        nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");
                        return date("W", Math.round(nd2.getTime() / 1000));
                    } else {
                        return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
                    }
                }
            },

            // Month
            F: function () {
                return txt_months[f.n()]
            },
            m: function () {
                return pad(f.n(), 2)
            },
            M: function () {
                return f.F().substr(0, 3)
            },
            n: function () {
                return jsdate.getMonth() + 1
            },
            t: function () {
                var n;
                if ((n = jsdate.getMonth() + 1) == 2) {
                    return 28 + f.L();
                } else {
                    if (n & 1 && n < 8 || !(n & 1) && n > 7) {
                        return 31;
                    } else {
                        return 30;
                    }
                }
            },

            // Year
            L: function () {
                var y = f.Y();
                return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0
            },
            //o not supported yet
            Y: function () {
                return jsdate.getFullYear()
            },
            y: function () {
                return (jsdate.getFullYear() + "").slice(2)
            },

            // Time
            a: function () {
                return jsdate.getHours() > 11 ? "pm" : "am"
            },
            A: function () {
                return f.a().toUpperCase()
            },
            B: function () {
                // peter paul koch:
                var off = (jsdate.getTimezoneOffset() + 60) * 60;
                var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off;
                var beat = Math.floor(theSeconds / 86.4);
                if (beat > 1000) beat -= 1000;
                if (beat < 0) beat += 1000;
                if ((String(beat)).length == 1) beat = "00" + beat;
                if ((String(beat)).length == 2) beat = "0" + beat;
                return beat;
            },
            g: function () {
                return jsdate.getHours() % 12 || 12
            },
            G: function () {
                return jsdate.getHours()
            },
            h: function () {
                return pad(f.g(), 2)
            },
            H: function () {
                return pad(jsdate.getHours(), 2)
            },
            i: function () {
                return pad(jsdate.getMinutes(), 2)
            },
            s: function () {
                return pad(jsdate.getSeconds(), 2)
            },
            //u not supported yet

            // Timezone
            //e not supported yet
            //I not supported yet
            O: function () {
                var t = pad(Math.abs(jsdate.getTimezoneOffset() / 60 * 100), 4);
                if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;
                return t;
            },
            P: function () {
                var O = f.O();
                return (O.substr(0, 3) + ":" + O.substr(3, 2))
            },
            //T not supported yet
            //Z not supported yet

            // Full Date/Time
            c: function () {
                return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()
            },
            //r not supported yet
            U: function () {
                return Math.round(jsdate.getTime() / 1000)
            }
        };

        return format.replace(/[\\]?([a-zA-Z])/g, function (t, s) {
            if (t != s) {
                // escaped
                ret = s;
            } else if (f[s]) {
                // a date function exists
                ret = f[s]();
            } else {
                // nothing special
                ret = s;
            }
            return ret;
        });
    };

    init();
    return {
        search: search,
        date: date
    };
})(jQuery);

