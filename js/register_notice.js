$(document).ready(function (){
    $('.form_message').on('click', function(){
        $('.message').toggle(200);
    });
    $(document).on('click', function(e){
        if ($(e.target).closest('.form_message').length == 0 && $(e.target).attr('class') != '.form_message') {
            $('.message').hide();
        }
    });
});

