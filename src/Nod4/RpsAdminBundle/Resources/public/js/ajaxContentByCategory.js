
$(document).on('change', '#sectionForm_category', function () {

    $.ajax({
        url: CONTENTCHANGE_PATH,
        data: 'category='+ $('#sectionForm_category').val(),
        cache: false,
        beforeSend: function () {
        },
        complete: function (data) {
            var content = $.parseJSON(data.responseText);
            var options = '<option value="">Выберите..</option>';
            $(content).each(function () {
                options += '<option value="' + $(this).attr('id') + '">' +  $(this).attr('fname') + '</option>';
            });
            $('#sectionForm_content').html(options);

        }
    });
});



