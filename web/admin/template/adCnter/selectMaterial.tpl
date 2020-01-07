<{include file="../public/head.tpl"}>
<style type="text/css">
    tr:hover{
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
</style>
<div id="areascontent" class="container-fluid">
    <div class="row" style="padding: 20px;">
        <div class="panel panel-default" style="margin-top: 20px;">
            <!-- Default panel contents -->
            <div class="panel-heading">素材库</div>
            <div class="panel-body">
                <p class="notice">
                    <span>❶</span>在下列素材中选中需要新增的素材，素材可分页选择。<br>
                    <span>❷</span>鼠标移动到『素材名』列或者点击预览可预览素材。<br>
                    <span>❸</span>点击『朕选好了』回到创建广告表单, 点击『朕再想想』放弃修改<br>
                </p>
            </div>
            <!-- Table -->
            <table class="table table-hover table-condensed">
                <tr>
                    <th><input type="checkbox" name="" id="check-all" disabled></th>
                    <th>ID</th>
                    <th>素材名</th>
                    <th>尺寸</th>
                    <th>大小</th>
                    <th>类型</th>
                    <th>操作</th>
                </tr>
                <tbody id="material-list">

                </tbody>
            </table>
        </div>
        <nav aria-label="...">
            <ul class="pager">
                <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="#">下一页 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    </div>
    <div class="panel panel-default" style="margin-top: 10px;">
        <!-- Default panel contents -->
        <div class="panel-heading">已选择素材</div>
        <table class="table table-hover table-condensed">
            <tr>
                <th>ID</th>
                <th>素材名</th>
                <th>操作</th>
            </tr>
            <tbody id="select-body">
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        let selected = sessionStorage.getItem('material_list');
        if(selected) {
            selected = JSON.parse(selected);
            let row = '';
            $.each(selected, function (k, v) {
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
                '               你似乎没有选中任何素材哟₍₍◡( ╹◡╹ )◡₎₎' +
                '           </td>' +
                '       </tr>';
            $('#select-body').prepend(row);
        }

        let page = 1;
        function get_material()
        {
            let page_size = 8;
            $.post('?ct=optimizat&ac=adMaterial&type=json&page_size='+page_size+'&page=' + page, function(data){
                let html = '';
                let selected = sessionStorage.getItem('material_list');
                let selectedIds = [];
                if(selected){
                    selected = JSON.parse(selected);
                    $.each(selected, function (k, v) {
                        selectedIds.push(v.id);
                    });
                }

                $.each(data.list, function(key, val){
                    let is_checked = '';
                    if(selectedIds.indexOf(val.material_id) !== -1)
                        is_checked = 'checked';


                    html += "<tr data-src="+ val.thumb +">" +
                        "           <td><input type=\"checkbox\" name=\"material_ids[]\" value='"+val.material_id+"' "+ is_checked +"></td>" +
                        "           <td>"+val.material_id+"</td>" +
                        "           <td class=\"img-rounded\">"+val.material_name+"</td>" +
                        "           <td>"+val.material_wh+"</td>" +
                        "           <td>"+val.material_size+"</td>" +
                        "           <td>"+val.material_type+"</td>" +
                        "           <td>" +
                        "               <div class=\"btn-group btn-group-xs\" role=\"group\">" +
                        "                   <span class=\"btn btn-warning copywriting\" data-id='"+val.material_id+"'>选择文案</span>" +
                        "                   <span class=\"btn btn-info preview\" data-src='"+val.material_url+"'>预览</span>" +
                        "               </div>" +
                        "           </td>" +
                        "        </tr>";
                });
                $('#material-list').html(html);
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
        get_material(1);
        $('.previous').click(function(){
            if($(this).hasClass('disabled'))
                return;
            -- page;
            get_material();
        });

        $('.next').click(function(){
            if($(this).hasClass('disabled'))
                return;
            ++ page;
            get_material();
        });

        // var index;
        //图片预览
        // $('tr').on('mouseenter', '.img-rounded', function(){
        //     index = layer.tips('<img src="http://admanage.com/uploads/1912/051459352549_1313f14a4a.png" class="tips">', $(this), {
        //         tips: [4, '#ffffff'],
        //         maxWidth: '200px',
        //         time: 0
        //     });
        // });
        // var index;
        // $('.img-rounded').mouseenter(function () {
        //     index = layer.tips('<img src="http://admanage.com/uploads/1912/051459352549_1313f14a4a.png" class="tips">', $(this), {
        //         tips: [4, '#ffffff'],
        //         maxWidth: '200px',
        //         time: 0
        //     });
        // }).mouseleave(function () {
        //     layer.close(index);
        // });

        $('#material-list').on('click', '.preview', function(){
            layer.photos({
                photos:  {"title": "素材名", "id": 123, "start": 0, "data": [{"alt": "图片名","pid": 1,"src": "http://admanage.com/uploads/1912/051443142067_1ec3bb97f2.jpg","thumb": "http://admanage.com/uploads/1912/051443142067_1ec3bb97f2.jpg" }]}
                ,anim: Math.floor((Math.random()*10)+1) % 6 //0-6的选择，指定弹出图片动画类型，默认随机
            });
            return false;
        });

        $('#material-list').on('click', 'td', function(){
            let ele_input = $(this).parent().children().children();
            let material_id = ele_input.val();
            let status = ele_input.prop('checked');
            ele_input.prop('checked', !status);
            let id = $(this).parent().children().eq(1).text();
            if(!status) {
                /**
                 * storage 存储规则
                 * key:material_ + 素材ID
                 * val: {id:1,content:"文案内容"}
                 */
                let con = $(this).parent().children().eq(2).text();
                let thumb = $(this).parent().attr('data-src');
                let val = sessionStorage.getItem('material_list');
                if(val) {
                    val = JSON.parse(val);
                    val.push({id: id, content:con, thumb:thumb});
                }else{
                    $('#select-body').html('');
                    val = new Array();
                    val[0] = {id: id, content:con, thumb:thumb};
                }
                val = JSON.stringify(val);
                sessionStorage.setItem('material_list', val);
                let row = "<tr>" +
                    "       <td>"+id+"</td>" +
                    "       <td class=\"animated shake\" >"+con+"</td>" +
                    "       <td><i class=\"glyphicon glyphicon glyphicon-trash del-item\" aria-hidden=\"true\"></i></td>" +
                    "      </tr>";
                $('#select-body').prepend(row);
            }else {
                let val = JSON.parse(sessionStorage.getItem('material_list'));
                val = val.filter(item => {
                    return item.id != id
                });
                sessionStorage.setItem('material_list', JSON.stringify(val));
                $('#select-body tr').each(function(i){
                    let r_id = $(this).children().eq(0).text();
                    if(r_id == id)
                        $(this).remove();
                });
            }
        });
        $('#select-body').on('click', '.del-item', function(){
            let id = $(this).parent().parent().children().eq(0).text();
            $('#material-list tr').each(function(){
                let r_id = $(this).children().eq(1).text();
                if(r_id == id)
                    $(this).children().eq(0).children('input').prop('checked', false);
            });
            let selectItem = sessionStorage.getItem('material_list');
            if(selectItem) {
                selectItem = JSON.parse(selectItem);
                selectItem = selectItem.filter(selectItem => {
                    return selectItem.id != id
                });
                sessionStorage.setItem('material_list', JSON.stringify(selectItem));
            }
            $(this).parent().parent().remove();
        });

        $('#check-all').on('click', function(){
            let check_state = $(this).prop('checked');
            $('input[type=checkbox]').prop('checked', check_state);
        });

        $('#material-list').on('click', '.copywriting', function(){
            let material_id = $(this).attr('data-id');
            let copywriting_list = sessionStorage.getItem('copywriting_list');
            let that = $(this);
            let index = window.parent.layer.open({
                type: 2,
                area: ['800px',  '800px'],
                fix: false,
                maxmin: true,
                shade:0.4,
                title: '选择文案',
                content: '?ct=optimizat&ac=selectCopywriting&material_id=' + material_id,
                btn: ['朕选好了', '朕再想想'],
                btn2:function(){
                    that.text('选择文案');
                    that.addClass('btn-warning')
                    that.removeClass('btn-success');
                    sessionStorage.setItem('copywriting_list', copywriting_list); // 还原上一次操作
                },
                yes:function(){
                    that.text('查看文案');
                    that.addClass('btn-success')
                    that.removeClass('btn-warning');
                    if(! that.parents('tr').children().eq(0).children().prop('checked')) {
                        that.parents('tr').children().eq(0).children().prop('checked', true);
                        let id =  that.parents('tr').children().eq(1).text();
                        let con = that.parents('tr').children().eq(2).text();
                        let thumb = that.parents('tr').attr('data-src');
                        let val = sessionStorage.getItem('material_list');
                        if(val) {
                            val = JSON.parse(val);
                            val.push({id: id, content:con, thumb:thumb});
                        }else{
                            $('#select-body').html('');
                            val = new Array();
                            val[0] = {id: id, content:con, thumb:thumb};
                        }
                        val = JSON.stringify(val);
                        sessionStorage.setItem('material_list', val);
                        let row = "<tr>" +
                            "       <td>"+id+"</td>" +
                            "       <td class=\"animated shake\" >"+con+"</td>" +
                            "       <td><i class=\"glyphicon glyphicon glyphicon-trash del-item\" aria-hidden=\"true\"></i></td>" +
                            "      </tr>";
                        $('#select-body').prepend(row);
                    }
                    window.parent.layer.close(index);
                }
            });
            return false;
        });
    });
</script>
<{include file="../public/foot.tpl"}>