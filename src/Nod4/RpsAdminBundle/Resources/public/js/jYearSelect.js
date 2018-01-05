
$(document).on('click', '#years>li>a', function () {

    $.ajax({
        url: YEARCHANGE_PATH,
        data: 'year=' + $(this).text()+'&category='+CATEGORY,
        cache: false,
        beforeSend: function () {
            data = "<div class='col-sm-offset-4'><img src='/web/images/loader.gif'></div>";
            $('#newsCol').html(data);
            $('#years li').removeClass('active');
            $(this).addClass('active');
        },
        complete: function (data) {
            $('#newsCol').html(data.responseText);

        }
    });
});
