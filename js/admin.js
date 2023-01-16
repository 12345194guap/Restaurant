$('.input-file input[type=file]').on('change', function(){
	let file = this.files[0];
	$(this).closest('.input-file').find('.input-file-text').html(file.name);
});

// Список блюд
$(document).ready(function (){
    $('.choice_food_btn').bind('click', bg);
	var first = true;
	function bg() {
		if(first) {
			$('.choice_food_list').css('opacity', '100');
			$(".choice_food_btn").attr('style', 'background-color: #4432AE; box-shadow: none;');
			$.ajax({
				url: "../php/admin_get_menu.php",             
				success: function(result) {
					if (result != 1) {
						let z = JSON.parse(result);
						for (let i = 0; i < z.length; i++) {
							var $li = $('<li>').attr({'id': 'item_' + z[i].id, 'class':'item'});
							$('.choice_food_list').append($li.text(z[i].id + '. ' + z[i].title));
						}
					}
				}
			});
		}
		else {
			$('.recipe_form').css('opacity', '');
			$('.choice_food_list').empty();
			$(".choice_food_btn").attr('style', 'background-color: ; box-shadow: ;');
			$('.choice_food_list').css('opacity', '0');
		}
		first = !first;
	};
});


// Обработка нажатия на блюдо в списке
$(document).ready(function (){
	document.querySelector('.choice_food_list').onclick = function(e) {
		var index = [].slice.call(this.children).indexOf(e.target);
		if (index == -1) index = 0;
		index++;
		$('.item_active').attr('class', 'item');
		$('.recipe_form').css('opacity', '100');
		$('#item_' + index).attr('class', 'item_active');
	};
});


// Добавление блюда
$(document).ready(function (e){
	$(".supple_form").submit(function (e)
	{
		e.preventDefault();
		let message = $('.msg')
		var formNm = $('.supple_form')[0];
		var formData = new FormData(formNm);

		$.ajax({
			url: '../php/admin_add_dish.php',
			type: "post",
			data: formData,
			cache: false, 
			contentType: false,
            processData: false,
			success: function(data) {
				if (data == 0){
					message.text('Успешно!');
					message.attr('class', 'msg_success')
					$('.supple_form').find('input[type=text], input[type=file], textarea').val('');
					$(".input-file-text").empty();
					setTimeout(delBlock, 1500);
					return false;
				}
				message.text('Произошла ошибка!');
				message.attr('class', 'msg_error')
				setTimeout(delBlock, 1500);
				console.log(data);
			},
			error: function(){
				message.text('Произошла ошибка!');
				message.attr('class', 'msg_error')
				setTimeout(delBlock, 1500);
			}
		});
		function delBlock() {
			message.attr('class', 'msg')
			message.addClass('msg');
			$(message).text("").show()
		}
	});
});

// Редактирование блюда
$(document).ready(function (e){
	$(".recipe_form").submit(function (e)
	{
		e.preventDefault();
		let message = $('.recipe_msg')
		let elId = $('.item_active').attr('id').slice(5);
		var formNm = $('.recipe_form')[0];
		var formData = new FormData(formNm);
		formData.append('id', elId);
		$.ajax({
			url: '../php/edit_dish.php',
			type: "post",
			data: formData,
			cache: false, 
			contentType: false,
            processData: false,
			success: function(data) {
				if (data == 0){
					message.text('Успешно!');
					message.attr('class', 'recipe_msg_success');
					$('.recipe_form').find('input[type=text], input[type=file], textarea').val('');
					$('.recipe_form').find('.input-file-text').empty();
					setTimeout(delBlock, 1500);
					return false;
				}
				message.text('Произошла ошибка!');
				message.attr('class', 'recipe_msg_error');
				setTimeout(delBlock, 1500);
			},
			error: function(){
				message.text('Произошла ошибка!');
				message.attr('class', 'recipe_msg_error')
				setTimeout(delBlock, 1500);
			}
		});
		function delBlock() {
			message.attr('class', 'recipe_msg')
			message.addClass('recipe_msg');
			$(message).text("").show()
		}
	});
});


// Очередь
$(document).ready(function (){
	$.ajax({
		url: "../php/menu_get_queue.php",
		contentType: 'json',          
		success: function(data) {
			var user_num = JSON.parse(data);
			if (user_num != 0)
			{
				var ul = $('<ul>').attr({'class':'order_list'});
				var div;
				var li;
				$.each(user_num, function (i){
					if (i != user_num.length - 1) {
						div = $('<div>').attr({'id':`sector_${user_num[i][0][0]}`, 'class':'order_sector'});
						btn = $('<button>').attr({'class':'order_btn'}).text('Готов');
						li = $('<li>').attr({'class':'order_item', 'id':`user_id_${user_num[i][0][0]}`}).text(i+1);
						div.append(li);
						div.append(btn);
						ul.append(div);
					}
				});
				$('.order_list_div').append(ul);
				$('.order_list_div').css('display', 'block');
			}
		}
	});
});


// Подтверждение выдачи заказа
$(document).ready(function (){
	$(document).on('click', '.order_btn', confirm_order);
	function confirm_order() {
		var user_id = $(this).parent().find('.order_item').attr('id').toString().slice(-1);
		$.ajax({
			url: "../php/admin_confirm_order.php",
			type: 'post',
			data: {user_id: user_id},
			success: function(data) {
				$('.order_list').parent().parent().find(`#sector_${data}`).remove();
				var cnt = $('.order_sector').length;
				if (cnt == 1) {
					$('.order_list').find('.order_sector').find('.order_item').text(1);
				}
				else {
					let i = 1;
					$('.order_sector').each(function(){
						$(this).find('.order_item').text(i);
						i++;
					});
					if (!$('.order_accept').find('.order_list_div').find('.order_sector').length)
						$('.order_list_div').css('display', 'none');
				}
			}
		});
	}
});


// Обновление очереди
$(document).ready(function (){
	$(document).on('click', '.order_accept_svg', update_orders);
	function update_orders() {
		if($(this).find('svg').hasClass("rotate_first"))
		{
			$(this).find('svg').removeClass('rotate_first');
			$(this).find('svg').addClass('rotate_second');
		}
		else {
			$(this).find('svg').removeClass('rotate_second');
			$(this).find('svg').addClass('rotate_first');
		}
		$('.order_list').remove();
		$.ajax({
			url: "../php/menu_get_queue.php",
			contentType: 'json',          
			success: function(data) {
				var user_num = JSON.parse(data);
				if (user_num != 0)
				{
					var ul = $('<ul>').attr({'class':'order_list'});
					var div;
					var li;
					$.each(user_num, function (i){
						if (i != user_num.length - 1) {
							div = $('<div>').attr({'id':`sector_${user_num[i][0][0]}`, 'class':'order_sector'});
							btn = $('<button>').attr({'class':'order_btn'}).text('Готов');
							li = $('<li>').attr({'class':'order_item', 'id':`user_id_${user_num[i][0][0]}`}).text(i+1);
							div.append(li);
							div.append(btn);
							ul.append(div);
						}
					});
					$('.order_list_div').append(ul);
					$('.order_list_div').css('display', 'block');
				}
			}
		});
	}
});