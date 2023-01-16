$(document).ready(function (e){
    $(".form_main").submit(function (e) {
        e.preventDefault();
        tg_id = $('.form_main').find('.tg_username').val();
        $.ajax({
			url: "../php/change_user_tg.php",
			type: 'post',
			data: {tg_id: tg_id},
			success: function(data) {
                if (data != 0) {
                    $('.form_main').find('.msg').text('Ошибка');
                    $('.form_main').find('.msg').css('color', 'red');
                    $('.form_main').find('.msg').css('display', 'block');
                    setTimeout(delBlock, 1500);
                }
                else {
                    $('.form_main').find('.msg').text('Успешно!');
                    $('.form_main').find('.msg').css('color', 'green');
				    $('.form_main').find('.msg').css('display', 'block');
                    setTimeout(delBlock, 1500);
                }
			}
		});
        function delBlock() {
			$('.form_main').find('.msg').remove();
		}
    });
});
