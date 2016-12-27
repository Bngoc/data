$(document).ready(function () {
    $('.call-Form-Shop').on('click', function (e) {
        e.preventDefault();

        var itemID = $(this).attr('idItem');
        var infoItem = $('.infoName-' + itemID).text();
        var infoPrice = $('.infoPrice-' + itemID).text();

        var varConfrim = confirm("Bạn có chắc mua vật phẩm "+ infoItem +" không? \n Giá " + infoPrice + " Vpoint");
        if (varConfrim) {
            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: $('form.form-'+ itemID).serialize(),
                success: function (data) {
                    $('.top-showInfo').remove();
                    $(".w-menu-top").prepend(data['menuTop']);
                    $("#msg-Show").html(data['msgAction']);
                }
            });
        }
    });
});