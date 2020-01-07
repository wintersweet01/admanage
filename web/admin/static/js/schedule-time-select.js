let initSelectBox = function (selector, selectCallback) {
    function clearBubble(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }

        if (e.preventDefault) {
            e.preventDefault();
        } else {
            e.returnValue = false;
        }
    }

    let $container = $(selector);
    //  框选事件
    $container
        .on('mousedown', function (eventDown) {
            //  设置选择的标识
            let isSelect = $(eventDown.target).hasClass('schedule_time_checked');
            //  创建选框节点
            let $selectBoxDashed = $('<div class="select-box-dashed"></div>');
            $('body').append($selectBoxDashed);
            //  设置选框的初始位置
            let startX = eventDown.x || eventDown.pageX;
            let startY = eventDown.y || eventDown.pageY;
            $selectBoxDashed.css({
                left: startX,
                top: startY
            });
            //  根据鼠标移动，设置选框宽高
            let _x = null;
            let _y = null;
            //  清除事件冒泡、捕获
            clearBubble(eventDown);
            //  监听鼠标移动事件
            $(selector).on('mousemove', function (eventMove) {
                //  设置选框可见
                $selectBoxDashed.css('display', 'block');
                //  根据鼠标移动，设置选框的位置、宽高
                _x = eventMove.pageX;
                _y = eventMove.pageY;
                //  暂存选框的位置及宽高，用于将 select-item 选中
                let _left = Math.min(_x, startX);
                let _top = Math.min(_y, startY);
                let _width = Math.abs(_x - startX);
                let _height = Math.abs(_y - startY);
                $selectBoxDashed.css({
                    left: _left,
                    top: _top,
                    width: _width,
                    height: _height
                });
                //  遍历容器中的选项，进行选中操作
                $(selector).find('.select-item').each(function () {
                    let $item = $(this);
                    let itemX_pos = $item.prop('offsetWidth') + $item.offset().left;
                    let itemY_pos = $item.prop('offsetHeight') + $item.offset().top;
                    //  判断 select-item 是否与选框有交集，添加选中的效果（ temp-selected ，在事件 mouseup 之后将 temp-selected 替换为 selected）
                    let condition1 = itemX_pos > _left;
                    let condition2 = itemY_pos > _top;
                    let condition3 = $item.offset().left < (_left + _width);
                    let condition4 = $item.offset().top < (_top + _height);
                    if (condition1 && condition2 && condition3 && condition4) {
                        isSelect ? $item.addClass('temp-unselected') : $item.addClass('temp-selected');
                    } else {
                        $item.removeClass('temp-selected');
                        $item.removeClass('temp-unselected')
                    }
                });
                //  清除事件冒泡、捕获
                clearBubble(eventMove);
            });

            $(document).on('mouseup', function () {
                $(selector).off('mousemove');
                $(selector)
                    .find('.select-item.temp-selected')
                    .removeClass('temp-selected')
                    .addClass('schedule_time_checked');
                $(selector)
                    .find('.select-item.temp-unselected')
                    .removeClass('temp-unselected')
                    .removeClass('schedule_time_checked');
                $selectBoxDashed.remove();

                if (selectCallback) {
                    selectCallback();
                }
            });
        })
        //  点选切换选中事件
        .on('click', '.select-item', function () {
            if ($(this).hasClass('schedule_time_checked')) {
                $(this).removeClass('schedule_time_checked');
            } else {
                $(this).addClass('schedule_time_checked');
            }
            select_item_act();
        });
    //  点选全选全不选
    $(document).on('click', '#toggle-all-btn',function () {
        if ($(this).attr('data-all')) {
            $(this).removeAttr('data-all');
            $container.find('.select-item').removeClass('schedule_time_checked');
        } else {
            $(this).attr('data-all', 1);
            $container.find('.select-item').addClass('schedule_time_checked');
        }
        select_item_act();
    });
};

function select_item_act() {
    let time = [];
    for (let i = 0; i < 24; i++) {
        let prefix = i <= 9 ? '0' : '';
        time.push([prefix + i + ':00', prefix + i + ':30']);
        i === 9 ?
            time.push([prefix + i + ':30', (i + 1) + ':00'])
            :
            time.push([prefix + i + ':30', prefix + (i + 1) + ':00']);
    }
    let select_time = [];
    let schedule_time = '';
    $('#select-body tr').each(function (key) {
        let $item = $(this);
        select_time[key] = [];
        let min = -1, max = -1;
        $item.find('.select-item').each(function (index) {
            if ($(this).hasClass('schedule_time_checked')) {
                schedule_time += '1';
                if(min === -1) min = index;
                if(max === -1) max = index;
                min = index < min ? index : min;
                max = index > max ? index : max;
                if ($item.find('.select-item').length - 1 === index)
                    select_time[key].push(time[min][0] + '~' + time[max][1]);
            } else {
                schedule_time += '0';
                if(min >= 0 && max >= 0) select_time[key].push(time[min][0] + '~' + time[max][1]);
                min = max = -1;
            }
        });
    });
    select_time.forEach(function(item, index){
        let check_time = '';
        if(item.length !== 0) {
            $.each(item, function(key, val){if(key !== item.length - 1) check_time += val + '、'; else check_time += val});
            $('#select-item-' + index).children().eq(1).html(check_time);
            $('#select-item-' + index).show();
        }else {
            $('#select-item-' + index).hide();
        }
    });
    $('#schedule_time_elem').val(schedule_time);
}
initSelectBox('#select-body', select_item_act);