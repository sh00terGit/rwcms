$(document).on('click', '.ajaxDelete', function () {
    
    var link = $(this);
    var newsId = $(this).attr('id');
    console.log(newsId);
    $.ajax({
        type: "GET",
        url: newsRemoveRoute,
        data: "id="+newsId
    })
    .done(function () {
        link.parent().parent().hide('slow');
         	
       $('#flashMessage').show(200, function(){
       $('#flashMessage').html('Операция произведена успешно!');	
      setTimeout(function(){
        $('#flashMessage').hide(500);
      }, 3000);
    });         
        
    });
});

