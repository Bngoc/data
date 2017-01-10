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
        e.preventDefault();
         $.ajax({
                type: 'POST',
                url: 'index.php',
                data: $('form#from-playbaicao').serialize(),
                success: function (data) {

                    $('.top-showInfo').remove();
                    $(".w-menu-top").prepend(data['menuTop']);
                    $("#msg-Show").html(data['msgAction']);
                    $('.result').html(data['result']);
                }
            });
    });
});