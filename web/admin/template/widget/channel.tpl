<{if $FIELD.label}><label><{$FIELD.label}></label><{/if}>
<select id="widgets_channel_id" name="<{if $FIELD.id}><{$FIELD.id}><{else}>channel_id<{/if}>" <{$FIELD.attr nofilter}> <{if $FIELD.disabled}>disabled="disabled"<{/if}>>
<{if $FIELD.default_text}>
    <option value="0" selected="selected"><{$FIELD.default_text}></option>
    <{/if}>
<{foreach from=$FIELD.data item=item}>
<option value="<{$item.id}>" <{if $FIELD.default_value==$item.id}>selected="selected"<{/if}>><{$item.text}></option>
    <{/foreach}>
</select>
<{if $FIELD.channel_user}>
    <label>账号</label>
<select id="widgets_user_id" name="user_id" <{$FIELD.attr nofilter}> <{if $FIELD.disabled}>disabled="disabled"<{/if}>>
    <option value="0" selected="selected">全 部</option>
    </select>
    <script type="text/javascript">
        function widgetsChannelUser(channel_id) {
            if (!channel_id) return false;

            $.getJSON('?ct=adData&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="0">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#widgets_user_id').html(html).trigger('change');
            });
        }
    </script>
    <{/if}>
<{if $FIELD.monitor}>
    <label>推广活动</label>
<select id="widgets_monitor_id" name="monitor_id" <{$FIELD.attr nofilter}> <{if $FIELD.disabled}>disabled="disabled"<{/if}>>
    <option value="0" selected="selected">全 部</option>
    </select>
    <script type="text/javascript">
        var widgets_game_id = 0;

        function widgetsMonitor(game_id, channel_id) {
            if (!game_id && !channel_id) return false;

            $.getJSON('?ct=adData&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="0">全 部</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#widgets_monitor_id').html(html).trigger('change');
            });
        }
    </script>
    <{/if}>

<script type="text/javascript">
    $('#widgets_channel_id').on('change', function () {
        var parent = $('#widgets_game_id').data('parent');


        var channel_id = $('#widgets_game_id').select2("val");
        var channel_id = $(this).select2("val");
        if (!channel_id) {
            return false;
        }

        if (typeof childrenCallback === 'function') {
            childrenCallback(id);
        }

        $.getJSON('?ct=ad&ac=getAllMonitor&game_id=' + game_id + '&channel_id=' + channel_id, function (re) {
            var html = '<option value="">全 部</option>';
            $.each(re, function (i, n) {
                html += '<option value=' + i + '>' + n + '</option>';
            });
            $('select[name="monitor_id"]').html(html);
        });

        if (channel_id > 0) {
            $.getJSON('?ct=adData&ac=getUserByChannel&channel_id=' + channel_id, function (re) {
                var html = '<option value="">选择账号</option>';
                $.each(re, function (i, n) {
                    html += '<option value="' + n.user_id + '">' + n.user_name + '</option>';
                });
                $('#user_id').html(html).trigger('change');
            });
        }
    });
</script>