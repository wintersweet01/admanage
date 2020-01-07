<link rel="stylesheet" href="<{$smarty.const.CDN_STATIC_URL}>lib/layui-2.5/css/layui.css">
<script src="<{$smarty.const.CDN_STATIC_URL}>lib/layui-2.5/layui.js"></script>
<div id="media_account" class="demo-transfer"></div>
<script>
    var transfreH;
    var id = '<{$FIELD.id}>';
    layui.use(['transfer', 'layer', 'util'], function () {
        var $ = layui.$
            , transfer = layui.transfer
            , layer = layui.layer
            , util = layui.util;
        var list = JSON.parse('<{$FIELD.data|json_encode nofilter}>');
        var default_value = JSON.parse('<{$FIELD.values|json_encode nofilter}>');
        var show_search = parseInt('<{$FIELD.show_search nofilter}>');
        var width = parseInt('<{$FIELD.width|default:350 nofilter}>');
        var data = makeData(list,default_value);
        var id =
        //显示搜索框
        transfreH = transfer.render({
            elem: '#media_account'
            ,data: data
            ,value:default_value
            ,title: ['全选', '全选']
            ,showSearch: show_search
            ,text:{
                none:'无数据'
            },
            width:width,
            id:id
        });
    });
    function makeData(data,value){
        var back = [];
        for (var j in data){
            var tmp = { };
            if(typeof data[j] != 'undefined') {
                tmp.value = data[j].value;
                tmp.title = data[j].title;
                tmp.disabled = false;
                tmp.checked = false;
                if(typeof value == "object" && $.isArray(value)) {
                    var index = $.inArray(parseInt(data[j].value), value);
                    if (index != '-1' && typeof data[j].value != 'undefined') {
                        tmp.checked = true;
                    }
                }
                back.push(tmp)
            }
        }
        return back;
    }
    function getTransData() {
        var data = [];
        var ret = transfreH.getData(id);
        for(var i in ret){
            if(typeof ret[i].value != 'undefined' && $.isNumeric(ret[i].value)){
                data.push(ret[i].value);
            }
        }
        return JSON.stringify(data);
    }
</script>