$(document).ready(function () {
    $('a.callAjaxRanking').on('click', function () {
        var url = $(this).attr('fhref');
        var sortFilter = $('.sortClass > .bd').attr('sort-filter');
        var dataUrl = url + '&sort=' + sortFilter;

        var callbacks = $.Callbacks("unique memory");
        callbacks.add(ajax_loadRanking);
        callbacks.fire(dataUrl, function () {

        });
    });

    $('span.callAjaxRanking').on('click', function () {
        var currentElement = $(this);
        if (!$(this).hasClass('bd')) {
            var sortClass = $(this).attr('sort-filter');
            var url = $('li[class*="selected"]').children('a').attr('fhref');
            var dataUrl = url + '&sort=' + sortClass;

            ajax_loadRanking(dataUrl, function () {
                $('.callAjaxRanking').removeClass('bd');
                currentElement.addClass('bd');
            });
        }
    });

    $(document).on('click', '.callAjax', function () {
        if (!$(this).hasClass('current')) {
            var dataUrl = $(this).attr('fhref');

            ajax_loadRanking(dataUrl, function () {

            })
        }
    });
});

function ajax_loadRanking(url, callback) {
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            format: 'html'
        },
        success: function (data) {
            $('li[id*="class_"]').removeClass('selected');
            $('#' + data['id-sub']).addClass('selected');

            $('#sub-Content').html(data['result_content']);
            $('#sub-pagination').html(data['result_pagination']);
            callback();
        }
    });
}

