$(function () {
    let checkActKeywords = []; // 选中的关键词
    let checkActNode = [];// 选中的行为类
    let checkInterestNode = []; // 选中的兴趣类
    let checkInterestKeywords = []; // 选中的兴趣关键词
    let actDisabled = false;
    let intDisabled = false;
    let actkeyword = [];
    let intkeyword = [];
    let checkedNode = [];
    const ACT_MAX_NUM = 350;
    let tree = window.tree || {
        zTreeObj: {}
        , stratum: 2
        , makeTree: function (ele, setting, stratum) {
            this.stratum = stratum;
            this.zTreeObj = $.fn.zTree.init(ele, setting, null);
        }
        /**
         * 节点选中处理
         * @param event
         * @param treeId
         * @param treeNode
         */
        , treeOnCheckedAct: function (event, treeId, treeNode) {
            let treeObj = $.fn.zTree.getZTreeObj(treeId);
            let nodes = treeObj.getCheckedNodes(true);
            checkedNode = [];
            $.each(nodes, function (key, item) {
                if (item.level !== 0)
                    return true;
                if (tree.stratum === 3) { // 选择区县
                    $.each(item.children, function (key2, val2) {
                        if (val2.children === undefined || val2.children.length === 0) {
                            if (val2.checked)
                                checkedNode.push(val2);
                            return true;
                        }
                        $.each(val2.children, function (key3, val3) {
                            if (val3.checked)
                                checkedNode.push(val3);
                        });
                    })
                } else { // 选择省市
                    if (item.children === undefined) { // 直辖市直接选中
                        checkedNode.push(item);
                        return true;
                    }
                    let childrens = item.children.filter(val => val.checked === true);
                    if (childrens.length === item.children.length) {
                        checkedNode.push(item);
                        return true;
                    }
                    $.each(item.children, function (index, val) {
                        if (val.children === undefined || val.children.length === 0) {
                            if (val.checked)
                                checkedNode.push(val);
                            return true;
                        }
                        if (val.checked) {
                            checkedNode.push(val);
                        }
                    });
                }
            });
            tree.packageHtml(checkedNode);
        }
        /**
         * 写入节点dom
         * @param nodes
         */
        , packageHtml: function (nodes) {
            let html = '';
            $.each(nodes, function (key, item) {
                html += "<div class=\"city-list\" id='city-" + item.id + "'>" +
                    "         <span class=\"city-name\">" + item.name + "</span>" +
                    "         <i class=\"layui-icon layui-icon-delete city-del\" data-id='" + item.id + "'></i>" +
                    "       </div>";
            });
            $('#checked-citys').html(html);
        }
        /**
         * 初始换处理节点数据
         * @param treeId
         * @param parentNode
         * @param responseData
         * @returns {[]}
         */
        , cityTreeDataFilter: function (treeId, parentNode, responseData) {
            let nodes = [];
            $.each(responseData, function (key, val) {
                if (val.level !== 1)
                    return true;
                if (val.children.length > 0) {
                    let childIds2 = val.children;
                    val.children = [];
                    $.each(childIds2, function (k, v) {
                        if (tree.stratum === 2) { // 只需要省市
                            if (responseData[v].level === 2) {
                                delete responseData[v].children;
                                val.children.push(responseData[v]);
                            } else {
                                delete val.children;
                            }
                            return true;
                        }
                        if (responseData[v].level === 3)
                            delete responseData[v].children; // 删除叶子节点下面的节点字段
                        // 第三级节点
                        if (responseData[v].children !== undefined && responseData[v].children.length > 0) {
                            let childIds3 = responseData[v].children;
                            responseData[v].children = [];
                            $.each(childIds3, function (level3k, level3v) {
                                delete responseData[level3v].children;
                                responseData[v].children.push(responseData[level3v]);
                            });
                        }
                        val.children.push(responseData[v]);
                    });
                } else {
                    delete val.children;
                }
                nodes.push(val);
            });
            return nodes;
        }
        , businessTreeDataFilter: function (treeId, parentNode, responseData) {
            let data = responseData.result.data.list;
            let pdata = data.filter(item => item.parent_id === 0); // 省级
            let cdata = data.filter(item => item.region_level === 'REGION_LEVEL_CITY'); // 市级
            // let codata = data.filter(item => item.region_level === 'REGION_LEVEL_DISTRICT'); // 区县 TODO::目前没有区县
            let bdata = data.filter(item => item.region_level === 'REGION_LEVEL_BUSINESS_DISTRICT'); // 商业区级
            cdata.map((value, index, cdata) => {
                value.children = bdata.filter(item => item.parent_id === value.id);
            });
            pdata.map((value, index, pdata) => {
                value.children = cdata.filter(item => item.parent_id === value.id);
            });
            return pdata;
        }
        , actionTreeDataFilter: function (treeId, parentNode, responseData) {
            return responseData.data;
        }

        /**
         * 删除节点
         */
        , removeNode: function () {
            let nodeId = $(this).attr('data-id');
            let node = tree.zTreeObj.getNodeByParam("id", nodeId, null);
            tree.zTreeObj.checkNode(node, false, true);
            $(this).parents('.city-list').remove();
        }

        /**
         * 添加类目词操作
         * 1. 如果节点是父节点并且子节点全部选中则写入数组
         * 2. 如果节点是子节点并且节点的父节点不存在数组，则写入数组
         * 3. 过滤数组中的父节点，移除低阶的父节点
         * 4. ztree返回选中数据，按选中顺序返回，不需要进行排序
         * 5. 别鸡儿用什么递归....
         * @param event
         * @param treeId
         * @param treeNode
         */
        , actionCheck: function (event, treeId, treeNode) {
            checkActNode.length = 0;// 清空数组
            let treeObj = $.fn.zTree.getZTreeObj(treeId);
            let nodes = treeObj.getCheckedNodes(true);
            $.each(nodes, function (key, item) {
                if (item.isParent) {
                    item.type = 'CATEGORY';
                    if (!item.getCheckStatus().half)
                        checkActNode.push(item);
                } else {
                    if (checkActNode.findIndex(function (val) {
                    }) === -1) {
                        item.type = 'CATEGORY';
                        checkActNode.push(item);
                    }
                }
            });
            checkActNode.forEach(function (item) {
                checkActNode = checkActNode.filter(val => val.parent !== item.id);
            });
            tree.packageActHtml(0, 'action-tree');
        }
        , treeOnCheckedInterest: function (event, treeId, treeNode) {
            checkInterestNode.length = 0;// 清空数组
            let treeObj = $.fn.zTree.getZTreeObj(treeId);
            let nodes = treeObj.getCheckedNodes(true);
            $.each(nodes, function (key, item) {
                if (item.isParent) {
                    item.type = 'CATEGORY';
                    if (!item.getCheckStatus().half)
                        checkInterestNode.push(item);
                } else {
                    if (checkInterestNode.findIndex(function (val) {
                    }) === -1) {
                        item.type = 'CATEGORY';
                        checkInterestNode.push(item);
                    }
                }
            });
            checkInterestNode.forEach(function (item) {
                checkInterestNode = checkInterestNode.filter(val => val.parent !== item.id);
            });
            tree.packageInterestHtml(0, treeId);
        }
        , disabledNodes: function (treeId) {
            $('.add-keywords').addClass('layui-disabled');
            let treeObj = $.fn.zTree.getZTreeObj(treeId);
            let nodes = treeObj.getNodes();
            nodes.forEach(function (node) {
                treeObj.setChkDisabled(node, true, true, true);
            });
            if (treeId === 'action-tree') {
                actDisabled = true;
            } else {
                intDisabled = true;
            }
        }
        , enableNodes: function (treeId) {
            let treeObj = $.fn.zTree.getZTreeObj(treeId);
            let nodes = treeObj.getNodes();
            nodes.forEach(function (node) {
                treeObj.setChkDisabled(node, false, true, true);
            });
            let data = [];
            let keyword = '';
            let type = '';
            if (treeId === 'action-tree') {
                data = actkeyword;
                keyword = $('#act-word').val();
                type = 'ACTION';
                actDisabled = false;
            } else {
                keyword = $('#inter-word').val();
                data = intkeyword;
                type = 'INTEREST';
                intDisabled = false;
            }
            tree.eachKeyword(data, keyword, type);
        }
        /**
         * 遍历关键字列表
         * @param data
         * @param keyword
         * @param type
         */
        , eachKeyword: function (data, keyword, type) {
            let html = '';
            let checkeds = type === 'ACTION' ? checkActKeywords : checkInterestKeywords;
            $.each(data, function (key, item) {
                let isChecked = checkeds.findIndex(function (val) {
                    return val.id === item.id
                }) !== -1;
                let disabled = '';
                let distext = '添加';
                if (isChecked) {
                    disabled = ' layui-disabled';
                    distext = '已加';
                }
                html += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.num}</td>
                        <td><a href="javascript:;" style="color: #2F88FF" id="add-keyword-${item.id}" class="add-keywords${disabled}" data-type="${type}" data-id="${item.id}" data-name="${item.name}" data-num="${item.num}">${distext}</a></td>
                        <td><a href="javascript:;" style="color: #2F88FF" class="sea-keyword" data-id="${item.id}" data-type="KEYWORD" data-targeting="${type}" data-name="${item.name}">查关键词</a></td>
                    </tr>
                `;
            });
            if (type === 'ACTION') {
                actkeyword = data;
                $('#seaword-ing').text(keyword);
                $('#keyword-list').html(html);
                $('#act-word').val(keyword);
            } else if (type === 'INTEREST') {
                intkeyword = data;
                $('#search-inval').text(keyword);
                $('#in-keyword-list').html(html);
                $('#inter-word').val(keyword);
            }
        }
        , packageInterestHtml: function (type = 0, treeId) {
            let html = '';
            let data = [];
            if (type == 0)
                data = checkInterestNode.concat(checkInterestKeywords);
            else if (type == 1)
                data = checkInterestNode;
            else if (type == 2)
                data = checkInterestKeywords;
            let maxlen = checkInterestNode.length + checkInterestKeywords.length;
            let overflow = [];
            let isDisabled = false;
            $.each(data, function (key, val) {
                if (maxlen >= ACT_MAX_NUM && key + 1 >= ACT_MAX_NUM) {
                    isDisabled = true;
                    // tree.disabledNodes(treeId);
                    if (key + 1 > ACT_MAX_NUM) {
                        overflow.push(val);
                        return true;
                    }
                }
                html += '<tr>' +
                    '          <td>' + val.name + '</td>' +
                    '          <td>' +
                    '             <span style="width: 78px;display: inline-block">' + val.num + '</span>' +
                    '             <span style="margin-left: 10px;">' +
                    '                   <a class="layui-btn layui-btn-xs layui-btn-warm del-interest" data-type="' + val.type + '" data-id="' + val.id + '">删除</a>' +
                    '                <a class="layui-btn layui-btn-xs layui-btn-normal sea-keyword" data-id="' + val.id + '" data-name="' + val.name + '" data-type="' + val.type + '" data-targeting="INTEREST">查关键词</a>' +
                    '              </span>' +
                    '          </td>' +
                    '   </tr>';
            });

            if (overflow.length > 0) {
                let treeObj = $.fn.zTree.getZTreeObj(treeId);
                overflow.filter(item => item.type === 'CATEGORY').forEach(function (item) {
                    checkInterestNode = checkInterestNode.filter(val => val.id !== item.id);
                    // 取消节点选中
                    treeObj.checkNode(item, false, true);
                });

                overflow.filter(item => item.type === 'KEYWORD').forEach(function (item) {
                    checkInterestKeywords = checkInterestKeywords.filter(val => val.id !== item.id);
                    $('#add-keyword-' + item.id).text('添加');
                    // $('#add-keyword-' + item.id).removeClass('layui-disabled');
                });
            }

            isDisabled && tree.disabledNodes(treeId);

            $('#interest-list').html(html);
            $('#interest-count').text(ACT_MAX_NUM - checkInterestNode.length - checkInterestKeywords.length); // 行为
            $('#interest-class-count').text(checkInterestNode.length); // 类目词
            $('#interest-keyword-count').text(checkInterestKeywords.length); // 关键词
        }
        /**
         * 遍历选中行为
         * @param nodes
         */
        , packageActHtml: function (type = 0, treeId) {
            let html = '';
            let data = [];
            if (type == 0)
                data = checkActNode.concat(checkActKeywords);
            else if (type == 1)
                data = checkActNode;
            else if (type == 2)
                data = checkActKeywords;

            let maxlen = checkActNode.length + checkActKeywords.length;
            let overflow = [];
            let isDisabled = false;

            $.each(data, function (key, val) {
                if (maxlen >= ACT_MAX_NUM && key + 1 >= ACT_MAX_NUM) {
                    isDisabled = true;
                    // tree.disabledNodes(treeId);
                    if (key + 1 > ACT_MAX_NUM) {
                        overflow.push(val);
                        return true;
                    }
                }
                html += '<tr>' +
                    '          <td>' + val.name + '</td>' +
                    '          <td>' +
                    '             <span style="width: 78px;display: inline-block">' + val.num + '</span>' +
                    '             <span style="margin-left: 10px;">' +
                    '                   <a class="layui-btn layui-btn-xs layui-btn-warm del-act" data-type="' + val.type + '" data-id="' + val.id + '">删除</a>' +
                    '                <a class="layui-btn layui-btn-xs layui-btn-normal sea-keyword" data-id="' + val.id + '" data-name="' + val.name + '" data-type="' + val.type + '" data-targeting="ACTION">查关键词</a>' +
                    '              </span>' +
                    '          </td>' +
                    '   </tr>';
            });
            if (overflow.length > 0) {
                let treeObj = $.fn.zTree.getZTreeObj(treeId);
                overflow.filter(item => item.type === 'CATEGORY').forEach(function (item) {
                    checkActNode = checkActNode.filter(val => val.id !== item.id);
                    // 取消节点选中
                    treeObj.checkNode(item, false, true);
                });

                overflow.filter(item => item.type === 'KEYWORD').forEach(function (item) {
                    checkActKeywords = checkActKeywords.filter(val => val.id !== item.id);
                    $('#add-keyword-' + item.id).text('添加');
                    // $('#add-keyword-' + item.id).removeClass('layui-disabled');
                });
            }

            isDisabled && tree.disabledNodes(treeId);
            $('#act-list').html(html);
            $('#act-count').text(ACT_MAX_NUM - checkActNode.length - checkActKeywords.length); // 行为
            $('#class-count').text(checkActNode.length); // 类目词
            $('#keyword-count').text(checkActKeywords.length); // 关键词
        }
        , interestDataFilter(treeId, parentNode, responseData) {
            return responseData.data;
        }
    };
    let setting = {
        async: {
            enable: true
            , url: $('#static-url').val() + "jrtt/city.json"
            // , dataFilter: tree.cityTreeDataFilter
            , type: 'get'
        }
        , check: {
            enable: true
            , chkStyle: 'checkbox'
            , chkboxType: {"Y": "ps", "N": "ps"}

        }
        , data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent",
                rootPId: 0
            }
        }
        , callback: {
            onCheck: tree.treeOnCheckedAct
        }
    };
    let industry = [];

    // 删除节点
    $('#checked-citys').on('click', '.city-del', tree.removeNode);

    let tip_index = false;
    $('#view-act-type').on('click', function () {
        if (tip_index) {
            layer.close(tip_index);
            tip_index = false;
        } else {
            let html = "<ul class='screen-type'>" +
                "<li class='screen-type-item' data-val='0'>全部</li>" +
                "<li class='screen-type-item' data-val='1'>类目词</li>" +
                "<li class='screen-type-item' data-val='2'>关键词</li>" +
                "</ul>";
            tip_index = layer.tips(html, '#view-act-type', {
                tips: 3
                , time: 0
            });
        }
    });

    $(document).on('click', '.screen-type-item', function () {
        let type = $(this).attr('data-val');
        tree.packageActHtml(type, 'action-tree');
        layer.close(tip_index);
        tip_index = false;
    });

    layui.use('form', function () {
        let form = layui.form;
        form.on('radio(ad_position)', function (data) {
            if (data.value === '2'){
                $('#ad_position_2').show();
                $('#ad_position_3').hide();
                $('#smart_inventory').val(0);
            }else if(data.value === '3') {
                $('#ad_position_3').show();
                $('#ad_position_2').hide();
                $('#smart_inventory').val(0);
            }else if(data.value === '1') {
                $('#ad_position_2, #ad_position_3').hide();
                $('#smart_inventory').val(1);
            }
        });

        form.on('radio(delivery_range)', function (data) {
            if (data.value === 'UNION')
                $('.union_video_type').show('slow');
            else
                $('.union_video_type').hide('slow');
        });

        form.on('radio(schedule_time)', function (data) {
            if (data.value === '1')
                $('#schedule-time-box').show('slow');
            else
                $('#schedule-time-box').hide('slow');
        });

        form.on('radio(smart_bid_type)', function (data) {
            if(data.value === 'SMART_BID_CONSERVATIVE') {
               $('#budget_mode').val('BUDGET_MODE_DAY');
               $('#budget_mode').attr('disabled', 'disabled');
               form.render();
           }else{

                $('#budget_mode').removeAttr('disabled');
                form.render();
            }
        });

        form.on('checkbox(device_brand)', function (data) {
            if (data.value === '')
                $(this).nextAll('input[type=checkbox]').prop('checked', false);
            else
                $('#device-brand-default').prop('checked', false);
            form.render();
        });

        form.on('radio(download_type)', function (data) {
            if (data.value === 'DOWNLOAD_URL') {
                $('#download-url').show('slow');
                $('#external-url').hide('slow');
            } else {
                $('#download-url').hide('slow');
                $('#external-url').show('slow');
            }
        });
        form.on('checkbox(age)', function (data) {
            if (data.value === '')
                $(this).nextAll('input[type=checkbox]').prop('checked', false);
            else
                $('#age-default').prop('checked', false);
            form.render();
        });

        form.on('radio(schedule_type)', function (data) {
            if(data.value === 'SCHEDULE_START_END') {
                $('#schedule_time').show();
            }else{
                $('#schedule_time').hide();
            }
        });

        form.on('radio(interest_action_mode)', function (data) {
            if (data.value === 'CUSTOM') {
                $('#act-interest').show('slow');
            }else {
                $('#act-interest').hide('slow');
            }
        });

        form.on('radio(district)', function (data) {
            switch (data.value) {
                case 'CITY':
                    setting.async.dataFilter = tree.cityTreeDataFilter;
                    setting.async.url = $('#static-url').val() + "jrtt/city.json";
                    tree.makeTree($('#district-tree'), setting, 2);
                    $('#checked-citys').html(''); // 切换后清空所有选择值
                    $('#city-change').show('slow');
                    break;
                case 'NONE':
                    $('#checked-citys').html('');
                    $('#city-change').hide('slow');
                    break;
                case 'COUNTY':
                    setting.async.dataFilter = tree.cityTreeDataFilter;
                    setting.async.url = $('#static-url').val() + "jrtt/city.json";
                    tree.makeTree($('#district-tree'), setting, 3);
                    $('#checked-citys').html('');
                    $('#city-change').show('slow');
                    break;
                case 'BUSINESS_DISTRICT':
                    setting.async.dataFilter = tree.businessTreeDataFilter;
                    setting.async.url = "?ct=optimizat&ac=getBusinessTree";
                    tree.makeTree($('#district-tree'), setting, 3);
                    $('#checked-citys').html('');
                    $('#city-change').show('slow');
                    break;
            }
        });

        /**
         * 获取创业分类行业列表
         */
        $.get('?ct=jrtt&ac=getIndustry', function(data){
            industry = data.result.data.list;
            let industry_1_html = '';
            let industry_2_html = '';
            let industry_3_html = '';
            industry.filter(item => item.level === 1).forEach(function(item, key){
                if(key === 0) {
                    industry.filter(val => val.first_industry_id === item.industry_id && val.level === 2).forEach(function (v2, k2){
                        if(k2 === 0){
                            industry.filter(row => row.second_industry_id === v2.industry_id && row.level === 3).forEach(function (v3, k3){
                                industry_3_html += `<option value="${v3.industry_id}">${v3.industry_name}</option>`;
                            });
                        }
                        industry_2_html  += `<option value="${v2.industry_id}">${v2.industry_name}</option>`;
                    });
                }
                industry_1_html += `<option value="${item.industry_id}">${item.industry_name}</option>`;
            });
            form.on('select(industry_1)', function(data){
                industry_2_html = '';
                industry_3_html = '';
                industry.filter(item => item.first_industry_id == data.value && item.level === 2).forEach(function (v2, k2) {
                    industry_2_html += `<option value="${v2.industry_id}">${v2.industry_name}</option>`;
                    if(k2 === 0){
                        industry.filter(val => val.second_industry_id == v2.industry_id && val.level === 3).forEach(function(v3, k3){
                            industry_3_html += `<option value="${v3.industry_id}">${v3.industry_name}</option>`;
                        });
                    }
                });
                $('#industry_2').html(industry_2_html);
                $('#industry_3').html(industry_3_html);
                form.render('select');
            });
            form.on('select(industry_2)', function(data){
                industry_3_html = '';
                industry.filter(item => item.second_industry_id == data.value && item.level === 3).forEach(function (v3, k3) {
                    industry_3_html += `<option value="${v3.industry_id}">${v3.industry_name}</option>`;
                });
                $('#industry_3').html(industry_3_html);
                form.render('select');
            });
            $('#industry_1').html(industry_1_html);
            $('#industry_2').html(industry_2_html);
            $('#industry_3').html(industry_3_html);
            form.render('select');
        }, 'json');

        //监听提交
        form.on('submit(saveDirectional)', function (data) {
            data.field.city = checkedNode.map( item => {return item.id}); // 城市
            data.field.action_categories = checkActNode.map(item => {return item.id}); // 行为类目
            data.field.action_words = checkActKeywords.map(item => {return item.id});// 行为关键词
            data.field.interest_categories = checkInterestNode.map(item => {return item.id});// 兴趣类目
            data.field.interest_words = checkInterestKeywords.map(item => {return item.id}); // 兴趣关键词
            $.post('?ct=directionalPackage&ac=addDirectionalPackage', data.field, function(data){
                parent.layer.closeAll();
                if(data.state === 0) {
                    layer.msg(data.msg, {icon:2});
                }else {
                    layer.msg(data.msg, {icon: 1});
                    setTimeout(function(){parent.layer.closeAll();}, 2000)
                }
            }, 'json');
            return false;
        });
    });


    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function () {
        let element = layui.element;
        let actSetting = {
            async: {
                enable: true
                , url: $('#static-url').val() + "jrtt/action.json"
                , dataFilter: tree.actionTreeDataFilter
                , type: 'get'
            }
            , check: {
                enable: true
                , chkStyle: 'checkbox'
                , chkboxType: {"Y": "ps", "N": "ps"}

            }
            , data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent",
                    rootPId: 0
                }
            }
            , callback: {
                onCheck: tree.actionCheck
            }
        };

        tree.makeTree($('#action-tree'), actSetting);
        let interestSetting = {
            async: {
                enable: true
                , url: '?ct=jrtt&ac=getInterestCategory'
                , dataFilter: tree.interestDataFilter
                , type: 'get'
            }
            , check: {
                enable: true
                , chkStyle: 'checkbox'
                , chkboxType: {"Y": "ps", "N": "ps"}

            }
            , data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent",
                    rootPId: 0
                }
            }
            , callback: {
                onCheck: tree.treeOnCheckedInterest
            }
        };

        tree.makeTree($('#interest-tree'), interestSetting);
        // 移除兴趣或行为
        $(document).on('click', '.del-interest', function () {
            let id = $(this).attr('data-id');
            let type = $(this).attr('data-type');
            //判断是否被禁用解除禁用
            if (intDisabled && (checkInterestKeywords.length + checkInterestNode.length <= ACT_MAX_NUM)) {
                tree.enableNodes('interest-tree');
            }
            if (type === 'KEYWORD') {
                checkInterestKeywords = checkInterestKeywords.filter(item => item.id !== id);
                $('#add-keyword-' + id).text('添加');
                $('#add-keyword-' + id).removeClass('layui-disabled');
                // $('#add-keyword-' + id).css('color', '#2F88FF');
            } else {
                let treeObj = $.fn.zTree.getZTreeObj('interest-tree');
                let node = treeObj.getNodeByParam("id", id, null);
                treeObj.checkNode(node, false, true);
                checkInterestNode = checkInterestNode.filter(item => item.id !== id);
            }
            $(this).parents('tr').remove();

            $('#interest-count').text(ACT_MAX_NUM - checkInterestNode.length - checkInterestKeywords.length); // 行为
            $('#interest-class-count').text(checkInterestNode.length); // 类目词
            $('#interest-keyword-count').text(checkInterestKeywords.length); // 关键词
        });

        let iBox = false;
        $('#search-interest-word').click(function () {
            let keyword = $('#inter-word').val();
            if (!keyword)
                return false;
            let data = {'query_words': keyword};
            $.get('?ct=jrtt&ac=getInterestKeyword', data, function (data) {
                let html = `<table class="layui-table" lay-skin="row" style="cursor:pointer;margin-top: 0px;border-top: none;">
                            <tbody>`;
                $.each(data.data.key_words, function (key, val) {
                    html += `<tr class="act-keyword" data-id="${val.id}" data-name="${val.name}" data-type="INTEREST" data-num="${val.num}">
                            <td>${val.name}</td>
                            <td>覆盖人数：${val.num}</tdl>
                         </tr>`;
                });
                html += "  </tbody></table>";
                iBox = layer.open({
                    title: keyword,
                    type: 1,
                    skin: 'layui-layer-demo', //样式类名
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shadeClose: true, //开启遮罩关闭
                    area: ['300px', '350px'],
                    content: html
                });
            }, 'json');

        });

        let keyBox = false;
        $('#search-act-word').click(function () {
            let keyword = $('#act-word').val();
            if (!keyword) {
                return false;
            }
            let actionScene = [];
            $('input[name="action_scene"]:checked').each(function () {
                actionScene.push($(this).val());
            });
            let actionDays = $('#action_days').val();
            let data = {'query_words': keyword, 'action_scene': actionScene, 'action_days': actionDays};
            $.get('?ct=jrtt&ac=actionKeyword', data, function (data) {
                let html = `<table class="layui-table" lay-skin="row" style="cursor:pointer;margin-top: 0px;border-top: none;">
                            <tbody>`;
                $.each(data.data.list, function (key, val) {
                    html += `<tr class="act-keyword" data-id="${val.id}" data-name="${val.name}" data-type="ACTION" data-num="${val.num}">
                            <td>${val.name}</td>
                            <td>覆盖人数：${val.num}</tdl>
                         </tr>`;
                });
                html += "  </tbody></table>";
                keyBox = layer.open({
                    title: keyword,
                    type: 1,
                    skin: 'layui-layer-demo', //样式类名
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shadeClose: true, //开启遮罩关闭
                    area: ['300px', '350px'],
                    content: html
                });
            }, 'json');
        });

        $(document).on('click', '.act-keyword', function () {
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');
            let type = $(this).attr('data-type');
            let num = $(this).attr('data-num');
            if (type === 'ACTION') {
                if (checkActKeywords.findIndex(function (val) {
                    return val.id === id
                }) === -1) {
                    checkActKeywords.push({id: id, name: name, num: num, type: 'KEYWORD'});
                    tree.packageActHtml(0, 'action-tree');
                }
            } else {
                if (checkInterestKeywords.findIndex(function (val) {
                    return val.id === id
                }) === -1) {
                    checkInterestKeywords.push({id: id, name: name, num: num, type: 'KEYWORD'});
                    tree.packageInterestHtml(0, 'interest-tree');
                }
            }
            getKeywordSuggest(id, 'KEYWORD', type, function (data) {
                if (type === 'ACTION')
                    layer.close(keyBox);
                else
                    layer.close(iBox);
                tree.eachKeyword(data.data.key_words, name, type);
            });
        });


        $(document).on('click', '.sea-keyword', function () {
            let id = $(this).attr('data-id');
            let type = $(this).attr('data-type');
            let name = $(this).attr('data-name');
            let targeting = $(this).attr('data-targeting');
            if (targeting === 'ACTION')
                element.tabChange('actKeywordTab', 2);
            else
                element.tabChange('interestKeywordTab', 2);
            getKeywordSuggest(id, type, targeting, function (data) {
                tree.eachKeyword(data.data.key_words, name, targeting);
            });
        });

        // 添加关键词
        $(document).on('click', '.add-keywords', function () {
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');
            let num = $(this).attr('data-num');
            let type = $(this).attr('data-type');
            if (type === 'ACTION' && checkActKeywords.findIndex(function (val) {
                return val.id === id
            }) === -1) {
                checkActKeywords.push({id: id, name: name, num: num, type: 'KEYWORD'});
                $(this).addClass('layui-disabled')
                $(this).text('已加');
                tree.packageActHtml(0, 'action-tree');
                /*if(checkActKeywords.length === 20){
                    disabledNodes('action-tree');
                }*/
            }
            if (type === 'INTEREST' && checkInterestKeywords.findIndex(function (val) {
                return val.id === id
            }) === -1) {
                checkInterestKeywords.push({id: id, name: name, num: num, type: 'KEYWORD'});
                $(this).addClass('layui-disabled')
                $(this).text('已加');
                tree.packageInterestHtml(0, 'interest-tree');
                /* if(checkInterestKeywords.length === 20){
                     disabledNodes('interest-tree');
                 }*/
            }
        });
        // 移除关键词或行为
        $('#act-list').on('click', '.del-act', function () {
            let id = $(this).attr('data-id');
            let type = $(this).attr('data-type');
            //判断是否被禁用解除禁用
            if (actDisabled && (checkActNode.length + checkActKeywords.length <= ACT_MAX_NUM)) {
                tree.enableNodes('action-tree');
            }
            if (type === 'KEYWORD') {
                checkActKeywords = checkActKeywords.filter(item => item.id !== id);
                $('#add-keyword-' + id).text('添加');
                $('#add-keyword-' + id).removeClass('layui-disabled');
            } else {
                let treeObj = $.fn.zTree.getZTreeObj('action-tree');
                let node = treeObj.getNodeByParam("id", id, null);
                treeObj.checkNode(node, false, true);
                checkActNode = checkActNode.filter(item => item.id !== id);
            }
            $(this).parents('tr').remove();
            $('#act-count').text(ACT_MAX_NUM - checkActNode.length - checkActKeywords.length); // 行为
            $('#class-count').text(checkActNode.length); // 类目词
            $('#keyword-count').text(checkActKeywords.length); // 关键词
        });

        /**
         * 行为兴趣关键词推荐
         * @param id
         * @param tag_type
         * @param targeting_type
         * @param fun
         */
        function getKeywordSuggest(id, tag_type, targeting_type, fun) {
            let actionScene = [];
            $('input[name="action_scene"]:checked').each(function () {
                actionScene.push($(this).val());
            });
            let actionDays = $('#action_days').val();
            let data = {
                id: id,
                tag_type: tag_type,
                targeting_type: targeting_type,
                action_scene: actionScene,
                action_days: actionDays
            };
            $.get('?ct=jrtt&ac=keywordSuggest', data, fun, 'json');
        }

        // 清空所有行为关键字
        $('#act-del-all').click(function () {
            if(actDisabled){
                tree.enableNodes('action-tree');
            }
            checkActKeywords.length = 0; // 清空选中关键字数组
            checkActNode.length = 0; // 清空选中行为数组
            // 清除所有已选中
            $('.add-keywords').text('添加');
            $('.add-keywords').removeClass('layui-disabled');
            // 去掉行为选中
            let treeObj = $.fn.zTree.getZTreeObj("action-tree");
            treeObj.checkAllNodes(false); // 取消全部行为节点的选中状态
            $('#act-list').html('');
            $('#act-count').text(ACT_MAX_NUM - checkActNode.length - checkActKeywords.length); // 行为
            $('#class-count').text(checkActNode.length); // 类目词
            $('#keyword-count').text(checkActKeywords.length); // 关键词
        });
        $('#inte-del-all').click(function () {
            if(intDisabled){
                tree.enableNodes('interest-tree');
            }
            checkInterestKeywords.length = 0;
            checkInterestNode.length = 0;
            // 清除所有已选中
            $('.add-keywords').text('添加');
            $('.add-keywords').removeClass('layui-disabled');
            let treeObj = $.fn.zTree.getZTreeObj('interest-tree');
            treeObj.checkAllNodes(false);
            $('#interest-list').html('');
            $('#interest-count').text(ACT_MAX_NUM - checkInterestNode.length - checkInterestKeywords.length); // 行为
            $('#interest-class-count').text(checkInterestNode.length); // 类目词
            $('#interest-keyword-count').text(checkInterestKeywords.length); // 关键词
        });
    });

    let time = new Date();
    let day = ("0" + time.getDate()).slice(-2);
    let month = ("0" + (time.getMonth() + 1)).slice(-2);
    let today = time.getFullYear() + "-" + (month) + "-" + (day);
    $('#schedule_start_time').val(today);
    $('#schedule_end_time').val(today);

    /**
     * 添加创意标签
     */
    $('#tag-add').click(function(){
        let tag_html = '';
        let tags = $('#tag-input').val().replace(/(^\s*)|(\s*$)/g, "").split(' ').filter(item => item && item.length <= 10);
        if(tags.length > 10) {
            layer.msg('标签不能超过十个，请确认');
            return false;
        }
        tags.forEach(function(item,key){
            tag_html +=  `
                <div class="tag-list">
                    <input type="hidden" name="ad_keywords[]" value="${item}">
                    <span class="tag-name">${item}</span>
                    <i class="layui-icon layui-icon-delete tag-del"></i>
                </div>
            `;
        });
        $('#select-tags').append(tag_html);
        $('#tag-input').val('');
    });

    /**
     * 删除创意标签
     */
    $(document).on('click', '.tag-del', function(){
        $(this).parents('.tag-list').remove();
    });
});


