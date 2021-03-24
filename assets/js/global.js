var num = 0; //Global
$(function () {

    $('#btn-dashboard-id').bind('click', function () {
        
        num = num + 1;
        if (num === 1)
            $('.div-dashboard-list').css('height', '98px');

        if (num === 2) {
            $('.div-dashboard-list').css('height', '0.1px');
            num = 0;
        }

    });

});

//Error
$(function () {
    $('.btn-alert').click(function () {
        $('.error').hide();
    });
});

//Change for multiple language
$(function () {

    $('#lang-br').click(function() {

         document.getElementById('changeLangua').value = $(this).val();
         $('#county').submit();
    });
    
    $('#lang-en').click(function() {
          
         document.getElementById('changeLangua').value = $(this).val();
         $('#county').submit();
   });
   
   $('#lang-sp').click(function() {
          
        document.getElementById('changeLangua').value = $(this).val();
        $('#county').submit();
   });

});
