$(document).ready(function () {
    $("input[name$='cars']").click(function () {
        var test = $(this).val();

        $("tr.desc").hide();
        $("#Cars-" + test).show();

        $('#tabActive').val($(this).val());
        console.log($('#tabActive').val());
    });
});
;