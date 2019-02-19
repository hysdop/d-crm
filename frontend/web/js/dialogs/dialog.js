var dialog = {};

dialog.id = 0;
dialog.user_1 = 0;
dialog.user_2 = 0;
dialog.currentUserId = 0;
dialog.lastItemId = 0;
dialog.avatar1 = '';
dialog.avatar2 = '';
dialog.name1 = '';
dialog.name2 = '';

//dialog.addedMsgIds = [];

dialog.send = function () {
    var text = $('#send-form input').val();
    text = text.trim();
    if (text.length == 0) {
        return;
    }
    $.ajax({
        url: '/messages/send',
        type: 'post',
        data: {
            text: text,
            _csrf: yii.getCsrfToken(),
            dialog_id: this.id,
            last_item: this.lastItemId
        },
        success: function (data) {
            dialog.addItems(data);
            $('#send-form input').val('');
            dialog.scrollToBottom();
        },
        error: function () {
            alert('error');
        }
    });
};

dialog.addItems = function (arr) {
    var html = '';
    var avatarUrl = '';
    var name = '';
    var addedCount = 0;
    $.each(arr, function( index, obj ) {
        if (obj.id <= dialog.lastItemId) {
            console.log('Already added msg: ' + obj.id);
            return;
        }
        $('#message_tmp .media-body b').html(obj.text);
        if (obj.user_id == dialog.user_1) {
            avatarUrl = dialog.avatar1;
            name = dialog.name1;
        } else {
            avatarUrl = dialog.avatar2;
            name = dialog.name2;
        }
        if (avatarUrl == '') avatarUrl = '/images/user.png';

        $('#message_tmp .comment-item-avatar').attr('src', avatarUrl);
        $('#message_tmp .name').attr('href', '/user/default/view/' + obj.user_id);
        if (obj.user_id == dialog.currentUserId) {
            $('#message_tmp .name').html('Вы');
        } else {
            $('#message_tmp .name').html(name);
        }

        $('#message_tmp .time').html(convertTimestamp(obj.created_at));

        $('#message_tmp .comment-item').addClass('notreaded');

        html = html + $('#message_tmp').html();
        dialog.lastItemId = obj.id;

        // dialog.addedMsgIds.push(obj.id);
        addedCount++;
    });
    $('#messages .messages-items .media-list').append(html);

    return addedCount;
};

dialog.scrollToBottom = function () {
    var elem = document.getElementById('messages-items');
    elem.scrollTop = elem.scrollHeight;
};

dialog.getNewMsgs = function () {
    $.ajax({
        url: '/messages/new-messages',
        type: 'post',
        data: {
            _csrf: yii.getCsrfToken(),
            dialog_id: this.id,
            last_item: this.lastItemId
        },
        success: function (data) {
            if (dialog.addItems(data) > 0) {
                dialog.scrollToBottom();
            }
        },
        error: function () {
            alert('error');
        }
    });
};

dialog.init = function (config) {
    $.extend(this, config);
    $('#send-form button').click(function () {
        dialog.send();
    });
    dialog.scrollToBottom();

    $('#send-form input').bind('keypress', function (e) {
        var code = e.keyCode || e.which;
        if(code == 13) {
            dialog.send();
        }
    });

    window.setInterval(function() {
        dialog.getNewMsgs();
    }, 2000);
};