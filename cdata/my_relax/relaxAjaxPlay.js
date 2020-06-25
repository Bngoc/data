$(document).ready(function () {
    $('.call-play').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: $('form#from-play').serialize(),
            success: function (data) {

                $('.top-showInfo').remove();
                $(".w-menu-top").prepend(data['menuTop']);
                $("#msg-Show").html(data['msgAction']);
                $('.result-play').html(data['bet_item']);
                $('.result').html(data['result']);
                $('.result').addClass('pd-top10');
            }
        });
    });

    $('.call-playbaicao').on('click', function (e) {
        // e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'index.php',
            // dataType: "text",
            data: $('form#from-playbaicao').serialize(),
            // beforeSend: function() {
            //     console.log("Bcadfasd");
            // },
            success: function (data) {
                // var data1 = JSON.parse(data);
                $('.top-showInfo').remove();
                $(".w-menu-top").prepend(data['menuTop']);
                $("#msg-Show").html(data['msgAction']);
                $('.result').html(data['result']);
            },
            // error: function (xhr, status, error) {
            //     console.log(status);
            // }
        });
    });

    $('#numberDe').bind('keyup', function () {
        var value = $(this).val();
        if (value.length >= 2) {
            value = value.substring(0, 2);
        }
        $(this).val(value);
    });

    $('#actionDe').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: $('form#from-playDe').serialize(),
            success: function (data) {
                $('.top-showInfo').remove();
                $(".w-menu-top").prepend(data['menuTop']);
                $("#msg-Show").html(data['msgAction']);
                $('.show-history').html(data['show_history']);

                if (data['resetFrom']) {
                    $("#capchaWeb").attr("src", "/captcha.php?page=web&r='+Math.random()");
                    $("#verifyCaptcha").val('');
                    $('.changeNumber').val('');
                }
            }
        });
    });

    $(document).on('click', '.callAjax', function () {
        if (!$(this).hasClass('current')) {
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
                    $('.show-history').html(data['show_history']);
                }
            });
        }
    });
});
