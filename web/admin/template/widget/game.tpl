<{if $FIELD.label}><label><{$FIELD.label}></label> <{/if}>
<select id="widgets_game_id" name="<{if $FIELD.id}><{$FIELD.id}><{else}>game_id<{/if}>" <{$FIELD.attr nofilter}> <{if $FIELD.disabled}>disabled="disabled"<{/if}> <{if $FIELD.multiple}>multiple="multiple"<{/if}>>
<{if $FIELD.default_text && !$FIELD.multiple}><option value="0" selected="selected"><{$FIELD.default_text}></option><{/if}>
<{foreach from=$FIELD.data.parent item=item}>
    <{if $item.status eq 0 or $FIELD.default_value}>
    <{if !$FIELD.parent}>
    <optgroup label="(<{$item.alias}>)<{$item.text}>">
        <{foreach from=$item.children item=children}>
        <{if ($FIELD.children_inherit && $children.inherit > 0) || $children.status == 1}>
        <{continue}>
        <{/if}>
        <option value="<{$children.id}>" data-pid="<{$children.pid}>" <{if (is_array($FIELD.default_value) && $children.id|in_array:$FIELD.default_value) || $FIELD.default_value==$children.id}>selected="selected"<{/if}>>(<{$children.id}>)<{$children.text}></option>
        <{/foreach}>
    </optgroup>
    <{else}>
    <option value="<{$item.id}>" data-pid="0" <{if (is_array($FIELD.default_value) && $item.id|in_array:$FIELD.default_value) || $FIELD.default_value==$item.id}>selected="selected"<{/if}>>(<{$item.alias}>)<{$item.text}></option>
    <{/if}>
    <{/if}>
    <{/foreach}>
</select>
<{if $FIELD.children}>
<{if $FIELD.children_label}><label><{$FIELD.children_label}></label> <{/if}>
<select id="widgets_children_id" name="<{if $FIELD.children_id}><{$FIELD.children_id}><{else}>children_id<{/if}>" <{$FIELD.children_attr nofilter}> <{if $FIELD.disabled}>disabled="disabled"<{/if}> <{if $FIELD.children_multiple}>multiple="multiple"<{/if}> style="min-width: 120px;">
    <{if $FIELD.children_default_text && !$FIELD.children_multiple}><option value="0" selected="selected"><{$FIELD.children_default_text}></option><{/if}>
</select>
<script type="text/javascript">
    $(function () {
        var list = JSON.parse('<{$FIELD.data.parent|json_encode nofilter}>');
        var default_pid = JSON.parse('<{$FIELD.default_value|json_encode nofilter}>');
        var default_cid = JSON.parse('<{$FIELD.children_default_value|json_encode nofilter}>');
        var children_inherit = parseInt('<{$FIELD.children_inherit}>');
        var children_multiple = parseInt('<{$FIELD.children_multiple}>');
        var children_default_text = '<{$FIELD.children_default_text}>';
        var widgets_game_id = $('#widgets_game_id');

        if (default_pid) {
            children_list(list, default_pid, default_cid, 0);
        }

        widgets_game_id.on({
            'select2:select': function (e) {
                var pid = $(e.params.data.element).data('pid');
                var id = e.params.data.id;
                children_list(list, id, 0, pid);
            },
            'select2:unselect': function (e) {
                var id = e.params.data.id;
                var o = $('#widgets_children_id');

                var _old = o.val();
                o.find("option[pid='" + id + "']").remove();
                var _new = o.val();

                if (typeof childrenRemoveCallback === 'function') {
                    if (!_old || !_new) {
                        return false;
                    }
                    childrenRemoveCallback(arrChange(_old, _new));
                }
            }
        });

        //数组相减
        function arrChange(a, b) {
            for (var i = 0; i < b.length; i++) {
                for (var j = 0; j < a.length; j++) {
                    if (a[j] == b[i]) {
                        a.splice(j, 1);
                        j = j - 1;
                    }
                }
            }
            return a;
        }

        function children_list(list, id, default_id, pid) {
            if (!list || !id) {
                return false;
            }

            var children = [];
            $.each(list, function (k, v) {
                if (pid > 0 && v.id == pid) {
                    $.each(v.children, function (i, n) {
                        if ((typeof id == 'object' && $.inArray(n.id, id) != -1) || n.id == id) {
                            children.push.apply(children, n.children);
                        }
                    });
                    return false;
                } else {
                    if ((typeof id == 'object' && $.inArray(v.id, id) != -1) || v.id == id) {
                        children.push.apply(children, v.children);
                    }
                }
            });

            var html = '';
            if (children_default_text && !children_multiple) {
                html = '<option value="0" selected="selected">' + children_default_text + '</option>';
            }
            $.each(children, function (i, n) {
                //过滤继承的游戏 2019-06-25更改#不运营且没有默认值的游戏剔除
                if (children_inherit && n.inherit > 0 || (n.status == '1' && typeof default_id == 'undefined')) {
                    return true;
                }

                var selected = '';
                if ((typeof default_id == 'object' && $.inArray(n.id, default_id) != -1) || n.id == default_id) {
                    selected = ' selected="selected"';
                }
                html += '<option value="' + n.id + '"' + selected + ' pid="' + id + '">(' + n.id + ')' + n.text + '</option>';
            });

            if (children_multiple) {
                $('#widgets_children_id').append(html).trigger('change');
            } else {
                $('#widgets_children_id').html(html).trigger('change');
            }
        }
    });
</script>
<{/if}>