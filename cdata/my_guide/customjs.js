$(document).ready(function () {
    $('a#callAjax').on('click', function () {
        var url = $(this).attr('fhref');
        var idContent = $(this).attr('idContent');

        var callbacks = $.Callbacks("unique memory");
        callbacks.add(ajax_load);
        callbacks.fire(url, idContent);

        if (callbacks) {
            $(this).parent().parent().each(function () {
                $(this).children('li').removeClass('selected');
            });
            $(this).parent().addClass('selected');
        }
    });
});

function ajax_load(url, id) {
    $.ajax({
        url: url,
        data: {
            format: 'html'
        },
        success: function (data) {
            $('#' + id).html(data);
        },
        type: 'POST'
    });
}

