$(document).ready(function () {
    $('#actionCard').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: $('form#fromCard').serialize(),
            beforeSend: function () {
                $('.reload').html('<img width="100%" height="3px" src="/images/load.gif" />');
            },
            success: function (data) {
                $('.top-showInfo').remove();
                $(".w-menu-top").prepend(data['menuTop']);
                $("#msg-Show").html(data['msgAction']);
                $('.show_history_card').html(data['show_history']);

                if (data['resetFrom']) {
                    $("#capchaWeb").attr("src", "/captcha.php?page=web&r='+Math.random()");
                    $("#verifyCaptcha").val('');
                    $('.changeNumber').val('');
                }
            },
            complete: function () {
                $('.reload').html('');
            }
        });
    });

    $(document).on('click','.callAjax', function () {
        if(!$(this).hasClass('current')) {
            var dataUrl = $(this).attr('fhref');
            $.ajax({
                url: dataUrl,
                type: 'POST',
                data: {
                    format: 'html'
                },
                success: function (data) {
                    $('.top-showInfo').remove();
                    $(".w-menu-top").prepend(data['menuTop']);
                    $("#msg-Show").html(data['msgAction']);
                    $('.show_history_card').html(data['show_history']);
                }
            });
        }
    });
});