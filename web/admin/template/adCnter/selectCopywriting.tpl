<{include file="../public/head.tpl"}>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
<style type="text/css">
    tr:hover, .btn-group span{
        cursor: pointer;
    }
    .notice{

        letter-spacing:4px;
        line-height: 15px;
        font-family: "微软雅黑";
        color: #000;
        font-size: 12px;
        margin:0;
    }
    .notice span{
        font-size: 15px;
    }
    .btn-group span{
        display: inline-block;
        margin: 5px;
    }

</style>
<div id="areascontent" class="container-fluid">
    <input type="hidden" value="<{$material_id}>" id="material_id">
    <div class="row" style="padding: 10px;">
        <div class="panel panel-default" style="margin-top: 10px;">
            <!-- Default panel contents -->
            <div class="panel-heading">文案库</div>
            <div class="panel-body">
                <form class="form-inline" style="text-align: center" action="javascript:;" id="search-form">
                    <div class="form-group">
                        <label for="keyword" class="sr-only">关键字</label>
                        <input type="text" class="form-control" id="keyword" placeholder="输入文案或标签关键字检索" name="keyword">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">搜 索</button>
                    </div>
                </form>
                <p class="notice">
                    <span>❶</span>在下列文案中选中需要的文案, 文案可分页选择<br>
                    <span>❷</span>点击『朕选好了』确认选择，或者点击『朕再想想』放弃所选择的文案。<br>
                    <span>❸</span>不修改当前文案请点击右上角关闭按钮
               </p>
            </div>
            <!-- Table -->
            <table class="table table-hover table-condensed">
                <tr>
                    <th><input type="checkbox" name="" id="check-all" disabled></th>
                    <th>ID</th>
                    <th>文案</th>
                </tr>
                <tbody id="copywriting-list">
                </tbody>
            </table>
        </div>
        <nav aria-label="...">
            <ul class="pager">
                <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="#">下一页 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>

    </div>
    <div class="panel panel-default" style="margin-top: 10px;">
        <!-- Default panel contents -->
        <div class="panel-heading">已选择文案</div>
        <table class="table table-hover table-condensed">
            <tr>
                <th>ID</th>
                <th>文案</th>
                <th>操作</th>
            </tr>
            <tbody id="select-body">
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        let material_id = $('#material_id').val();
        // let selected = sessionStorage.getItem('copywriting_' + material_id);
        let selected = sessionStorage.getItem('copywriting_list');
        if(selected) {
            selected = JSON.parse(selected);
            let row = '';
            $.each(selected[material_id], function (k, v) {
                 row += "<tr>" +
                    "       <td>"+v.id+"</td>" +
                    "       <td class=\"animated shake\" >"+v.content+"</td>" +
                    "       <td><i class=\"glyphicon glyphicon glyphicon-trash del-item\" aria-hidden=\"true\"></i></td>" +
                    "      </tr>";
            });
            $('#select-body').prepend(row);
        }else {
            let row = ' <tr>' +
                '           <td colspan="3">' +
                '               你似乎没有选中任何文案哟₍₍◡( ╹◡╹ )◡₎₎' +
                '           </td>' +
                '       </tr>';
            $('#select-body').prepend(row);
        }

        $('#search-form').submit(function(){
                let keyword = $('#keyword').val();
                get_copywriting(keyword);
                return false;
        });
        let page = 1;
        function get_copywriting(keyword = '')
        {
            let keyword_str = '';
            if(keyword) {
                keyword_str = '&keyword=' + keyword;
            }
            let page_size = 8;
            $.post('?ct=optimizat&ac=adCopywriting&type=json&page_size='+page_size+'&page=' + page + keyword_str, function(data){
                let html = '';
                let selected = sessionStorage.getItem('copywriting_list');
                let selectedIds = [];
                if(selected){
                    selected = JSON.parse(selected);
                    $.each(selected[material_id], function (k, v) {
                        selectedIds.push(v.id);
                    });
                }
                $.each(data.list, function(key, val){

                    let is_checked = '';
                    if(selectedIds.indexOf(val.id) !== -1)
                       is_checked = 'checked'
                    html += " <tr>" +
                        "       <td><input type=\"checkbox\" name=\"copywriting[]\" value='"+val.id+"' "+is_checked+"></td>" +
                        "       <td>"+val.id+"</td>" +
                        "       <td>"+val.content+"</td>" +
                        "      </tr>";
                });
                $('#copywriting-list').html(html);

                if(page == 1)
                    $('.previous').addClass('disabled');
                else
                    $('.previous').removeClass('disabled');

                let total = data.total.c;
                if(page * page_size >= total){
                    $('.next').addClass('disabled');
                }else{
                    $('.next').removeClass('disabled');
                }
            }, 'json');
        }
        get_copywriting();

        $('.previous').click(function(){
            if($(this).hasClass('disabled'))
                return;
            -- page;
            get_copywriting();
        });

        $('.next').click(function(){
            if($(this).hasClass('disabled'))
                return;
            ++ page;
            get_copywriting();
        });

        $('#copywriting-list').on('click', 'td', function(){
            let ele_input = $(this).parent().children().children();
            let status = ele_input.prop('checked');
            ele_input.prop('checked', !status);
            let material_id = $('#material_id').val();
            let id = $(this).parent().children().eq(1).text();
            if(!status) {
                /**
                 * storage 存储规则
                 * key:copywriting + 素材ID
                 * val: {id:1,content:"文案内容"}
                 */
                let con = $(this).parent().children().eq(2).text();
                let val = sessionStorage.getItem('copywriting_list');
                if(val) {
                    val = JSON.parse(val);
                    if(val[material_id]){
                        val[material_id].push({id: id, content:con});
                    }else {
                        val[material_id] = [];
                        val[material_id].push({id: id, content:con});
                    }
                }else{
                    $('#select-body').html('');
                    val = new Array();
                    val[material_id] = [];
                    val[material_id].push({id: id, content:con});
                }
                val = JSON.stringify(val);
                sessionStorage.setItem('copywriting_list', val);
                let row = "<tr>" +
                    "       <td>"+id+"</td>" +
                    "       <td class=\"animated shake\" >"+con+"</td>" +
                    "       <td><i class=\"glyphicon glyphicon glyphicon-trash del-item\" aria-hidden=\"true\"></i></td>" +
                    "      </tr>";
                $('#select-body').prepend(row);
            }else {
                let val = JSON.parse(sessionStorage.getItem('copywriting_list'));
                val[material_id] = val[material_id].filter(item => {
                    return item.id != id
                });
                sessionStorage.setItem('copywriting_list', JSON.stringify(val));
                $('#select-body tr').each(function(i){
                    let r_id = $(this).children().eq(0).text();
                    if(r_id == id)
                        $(this).remove();
                });
            }
        });

        $('#select-body').on('click', '.del-item', function(){
            let id = $(this).parent().parent().children().eq(0).text();
            $('#copywriting-list tr').each(function(){
                let r_id = $(this).children().eq(1).text();
                if(r_id == id)
                    $(this).children().eq(0).children('input').prop('checked', false);
            });
            let selectItem = sessionStorage.getItem('copywriting_list');
            if(selectItem) {
                selectItem = JSON.parse(selectItem);
                selectItem[material_id] = selectItem[material_id].filter(selectItem => {
                    return selectItem.id != id
                });
                sessionStorage.setItem('copywriting_list', JSON.stringify(selectItem));
            }
            $(this).parent().parent().remove();
        });

        $('#check-all').on('click', function(){
            let check_state = $(this).prop('checked');
            $('input[type=checkbox]').prop('checked', check_state);
        });

        $('.remove').on('click', function(){
            $(this).remove();
        });

    });
</script>
<{include file="../public/foot.tpl"}>