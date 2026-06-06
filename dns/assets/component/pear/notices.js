function showNotification(msg, type, delay) {
    layui.use(['form', 'notices'], function () {
        var $ = layui.jquery;
        var form = layui.form;
        var notices = layui.notices;
        if (type == 'success') {
            notices.success({
                title: '您有一条新的消息注意查收！',
                message: msg,
                position: 'topCenter',
                animateInside: true,
                balloon: true,
                audio: audio
            });
            if (delay !== undefined && delay !== '') {
                setTimeout(function() {
                    location.reload();
                }, delay);
            }
        } else if (type == 'error') {
            notices.error({
                title: '您有一条新的消息注意查收！',
                message: msg,
                position: 'topCenter',
                animateInside: true,
                balloon: true,
                audio: audio
            });
        } else if (type == 'warning') {
            notices.warning({
                title: '您有一条新的消息注意查收！',
                message: msg,
                position: 'topCenter',
                animateInside: true,
                balloon: true,
                audio: audio
            });
        } else if (type == 'info') {
            notices.info({
                title: '您有一条新的消息注意查收！',
                message: msg,
                position: 'topCenter',
                animateInside: true,
                balloon: true,
                audio: audio
            });
        } else if (type == 'loading') {
            notices.msg(msg, {icon: 4, close: true});
        } else if (type == 'close') {
            notices.destroy();
        } else if (type == '') {
            notices.show({
                title: '您有一条新的消息注意查收！',
                message: msg,
                position: 'topCenter',
                animateInside: true,
                balloon: true,
                audio: audio
            });
        }
    });
}