
$(document).on('change', '#sectionForm_typeOutput', function () {

    var content;
    var category;

    content = $('#sectionForm_content');
    category = $('#sectionForm_category');

    switch ( $(this).val() ) {

        // выбрана категория
        case 'full' :
            content.prop("selectedIndex", 0);
            content.prop('required', false);
            content.prop('disabled', true);

            category.prop("selectedIndex", 0);
            category.prop('required', true);
            category.prop('disabled', false);
            break;

        // выбрана информация
        case 'enum' :
            //удаляем все загруженные варианты для загрузки в соотвествии с категорией
            content.html('<option value="">Выберите..</option>');
            content.prop("selectedIndex", 0);
            content.prop('disabled', false);
            content.prop('required', true);

            category.prop("selectedIndex", 0);
            category.prop('disabled', false);
            category.prop('required', true);
            break;

        // выбран элемент Выберите..
        default :
            content.prop("selectedIndex", 0);
            content.prop('disabled', true);
            content.prop('required', false);

            category.prop("selectedIndex", 0);
            category.prop('required', false);
            category.prop('disabled', true);
            break;
    }

});