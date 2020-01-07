/**
 * 公用上传控件
 * @type {{create}}
 */
var cwUpload = (function ($) {
    var uploader;
    var fileMd5; //文件唯一标识
    var GUID = WebUploader.Base.guid(); //页面唯一ID
    var accept = {
        'img': {
            title: '图片格式文件',
            extensions: 'gif,jpg,jpeg,bmp,png,psd,ico',
            mimeTypes: 'image/*'
        },
        'video': {
            title: '视频格式文件',
            extensions: 'avi,wma,rmvb,rm,flash,mp4,mid,3gp,flv,mov',
            mimeTypes: 'video/*'
        },
        'material': {
            title: '图片和视频文件',
            extensions: 'gif,jpg,jpeg,bmp,png,psd,ico,avi,wma,rmvb,rm,flash,mp4,mid,3gp,flv,mov',
            mimeTypes: 'image/*,video/*'
        },
        'file': {
            title: '文件格式文件',
            extensions: 'rar,zip,doc,xls,docx,xlsx,pdf,txt',
            mimeTypes: 'application/*,text/plain'
        }
    };

    var create = function (param, callback) {
        var dom = typeof param.dom === 'undefined' ? '#picker' : param.dom;
        var url = typeof param.url === 'undefined' ? null : param.url;
        var auto = typeof param.auto === 'undefined' ? false : param.auto;
        var list = typeof param.list === 'undefined' ? '#thelist' : param.list;
        var size = typeof param.size === 'undefined' ? null : param.size;
        var thumb = typeof param.thumb === 'undefined' ? null : param.thumb;
        var compress = typeof param.compress === 'undefined' ? null : param.compress;
        var filename = typeof param.filename === 'undefined' ? 'file' : param.filename;
        var thelist = $(list);

        var _accept = null;
        if (typeof param.accept === 'object') {
            _accept = param.accept;
        } else if (typeof param.type === 'string') {
            _accept = accept[param.type];
        }

        WebUploader.Uploader.register({
            "before-send-file": "beforeSendFile",//整个文件上传前
            "before-send": "beforeSend",  //每个分片上传前
            "after-send-file": "afterSendFile",  //分片上传完毕
        }, {
            //时间点1：所有分块进行上传之前调用此函数
            beforeSendFile: function (file) {
                var $li = $('#' + file.id);
                var deferred = WebUploader.Deferred();
                //1、计算文件的唯一标记fileMd5，用于断点续传
                (new WebUploader.Uploader()).md5File(file).progress(function (percentage) {
                    $li.find('p.state').html('正在读取文件信息（<font color="red"><strong>' + parseInt(percentage * 100) + '%</strong></font>）...');
                }).then(function (val) {
                    fileMd5 = val;
                    $li.find('p.state').html("成功获取文件信息");

                    //获取文件信息后进入下一步
                    deferred.resolve();
                });

                return deferred.promise();
            },
            //时间点2：如果有分块上传，则每个分块上传之前调用此函数
            beforeSend: function (block) {
                this.owner.options.formData.chunkSize = block.end - block.start; //当前分块大小
                this.owner.options.formData.fileMd5 = fileMd5;
            },
            //时间点3：所有分块上传成功后调用此函数
            afterSendFile: function () {
                //如果分块上传成功，则通知后台合并分块
            }
        });

        uploader = WebUploader.create({
            swf: 'webuploader/Uploader.swf',
            server: url,
            auto: auto, //不需要手动调用上传，有文件选择即开始上传。
            pick: {
                id: dom, //指定选择文件的按钮容器，不指定则不创建按钮
                multiple: false //是否开起同时选择多个文件能力
            },
            resize: false, //不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传
            chunked: true, //是否要分片处理大文件上传
            chunkSize: 2 * 1024 * 1024, //分片大小，2M
            fileVal: filename, //设置文件上传域的name
            threads: 1, //上传并发数。允许同时最大上传进程数
            formData: {'guid': GUID, 'fileMd5': fileMd5},
            fileNumLimit: 1, //验证文件总数量, 超出则不允许加入队列
            fileSingleSizeLimit: size,
            duplicate: true,
            accept: _accept,
            thumb: thumb,
            compress: compress //压缩图片
        });

        // 当有文件被添加进队列的时候
        uploader.on('fileQueued', function (file) {
            thelist.append('<div id="' + file.id + '" class="item">' +
                '<h4 class="info">' + file.name + '</h4>' +
                '<p class="state">等待上传，请按“<font color="red">开始上传</font>”</p>' +
                '</div>');
        });

        uploader.on('uploadAccept', function (obj, ret) {
            if (!ret.state) {
                var file = obj.file;
                uploader.cancelFile(file);
                $('#' + file.id).find('p.state').html('<font color="red">' + ret.msg + '</font>');
                $('#' + file.id).find('.progress').fadeOut();
            }
        });

        uploader.on('uploadProgress', function (file, percentage) {
            var $li = $('#' + file.id),
                $percent = $li.find('.progress .progress-bar'),
                per = percentage * 100;

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo($li).find('.progress-bar');
            }

            $li.find('p.state').text('上传中...');
            $percent.css('width', per + '%');
            $percent.text(parseInt(per) + '%');
        });

        uploader.on('uploadError', function (file, code) {
            $('#' + file.id).find('p.state').html('<font color="red">上传错误：' + code + '</font>');
        });

        uploader.on('uploadSuccess', function (file, ret) {
            if (ret.state) {
                $('#' + file.id).find('p.state').text('已上传');
            } else {
                $('#' + file.id).find('p.state').html('<font color="red">' + ret.msg + '</font>');
            }

            if (typeof callback === 'function') {
                callback('uploadSuccess', ret);
            }
        });

        uploader.on('uploadComplete', function (file) {
            $('#' + file.id).find('.progress').fadeOut();
        });

        uploader.on('error', function (handler) {
            var msg = '';
            switch (handler) {
                case 'Q_EXCEED_NUM_LIMIT':
                    msg = '单次上传只能上传一个文件';
                    break;
            }
            if (msg) {
                thelist.next('.help-block').html('<font color="red">' + msg + '</font>');
            }
        });

        uploader.on('all', function (type) {
            if (typeof callback === 'function') {
                callback('all', type);
            }
        });

        return uploader;
    };

    return {
        create: create
    }
})(jQuery);