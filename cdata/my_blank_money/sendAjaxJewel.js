$(document).ready(function () {
    $('.updateAction').on('click', function (e) {
        e.preventDefault();

        var verifyCaptcha = $('#verify').find('input[name=verifyCaptcha]').val();

        if (verifyCaptcha == '') {
            var date = new Date();
            var timestamp = date.getTime();
            $('#msg_Captcha').html('<div class="cn_error_list"><div class="cn_error_item" id="notify_'+ timestamp +'"> ' +
                '<div><b>' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '</b> Captcah không đúng.</div> </div>' +
                '<script type="text/javascript">notify_auto_hide("notify_'+ timestamp +'", 7500);<\/script></div>');
        }

        if(verifyCaptcha) {
            var isCheckConfirm = false;
            if ($('#verify').find('input[name=confrim]').val()) {
                var strConfirm = $('#verify').find('input[name=confrim]').val();

                var result_confirm = confirm(strConfirm);
                isCheckConfirm = true;
            }

            if (result_confirm && isCheckConfirm || !isCheckConfirm) {
                $.ajax({
                    type: 'POST',
                    url: 'index.php',
                    data: $('form#verify').serialize(),
                    success: function (data) {

                        $('.top-showInfo').remove();
                        $(".w-menu-top").prepend(data['menuTop']);
                        $("#msg-Show").html(data['msgAction']);

                        $('.countItem').html(data['countItem']);
                        $('.result-show').html(data['result']);

                        $("#capchaWeb").attr("src","/captcha.php?page=web&r='+Math.random()");
                        $("#verifyCaptcha").val('');
                    }
                });
            }
        }
    });

    $('#blankJewel').on('click', function (e) {
        e.preventDefault();

        var verifyCaptcha = $('#verify').find('input[name=verifyCaptcha]').val();
        var numberItem = $('#verify').find('input[name=numberItem]').val();

        var date = new Date();
        var timestamp = date.getTime();
        var ischeckNumItem = false;
        if ((numberItem == 0 || numberItem == '') && $('#msg_NumItem').length) {
            ischeckNumItem = true;
            $('#msg_NumItem').html('<div class="cn_error_list"><div class="cn_error_item" id="notify_' + timestamp + '"> ' +
                '<div><b>' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '</b> Chưa chọn số lượng.</div> </div>' +
                '<script type="text/javascript">notify_auto_hide("notify_' + timestamp + '", 7500);<\/script></div>');
        }
        if (verifyCaptcha == '') {
            $('#msg_Captcha').html('<div class="cn_error_list"><div class="cn_error_item" id="notify_' + timestamp + '"> ' +
                '<div><b>' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '</b> Captcah không đúng.</div> </div>' +
                '<script type="text/javascript">notify_auto_hide("notify_' + timestamp + '", 7500);<\/script></div>');
        }

        if (verifyCaptcha && !ischeckNumItem) {
            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: $('form#verify').serialize(),
                success: function (data) {

                    $('.top-showInfo').remove();
                    $(".w-menu-top").prepend(data['menuTop']);
                    $("#msg-Show").html(data['msgAction']);

                    $('.result-show').html(data['result']);
                    $('.countItem').html(data['countItem']);
                    $('.show-NumItem').html(data['htmlOptionNumItem']);

                    $("#capchaWeb").attr("src","/captcha.php?page=web&r='+Math.random()");
                    $("#verifyCaptcha").val('');
                }
            });
        }
    });


});