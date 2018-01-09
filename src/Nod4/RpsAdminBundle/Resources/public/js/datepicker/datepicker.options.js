/* 
 *
 * @author Shipul Andrey 
 *  @position Nod-4 ivc
 * 
 */
$(document).ready(function () {
   $.datepicker.setDefaults({
        showOtherMonths: true,
        selectOtherMonths: true,
        dayNamesMin: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],

        dateFormat: "yy-mm-dd"

});  
  $("#news_save").prop('disabled', true);   // submit недоступен
  $("#news_images").prop('disabled', true);
  
  
    $("#news_date").datepicker();
    $(".date").datepicker();
    //изначально выбрана дата    
    
    if ($("#news_date").datepicker('getDate') != null ) {        
//        $('input[type="submit"]').prop('disabled', false);
        $("#news_save").prop('disabled', false);
        $("#news_images").prop('disabled', false);
    }
    
    // После изменения даты сабмит доступен , пошло сохранение даты 
    $('#news_date').change(function() {
//        $('input[type="submit"]').prop('disabled', false);
        $("#news_save").prop('disabled', false);
       $("#news_images").prop('disabled', false);
    });


});
