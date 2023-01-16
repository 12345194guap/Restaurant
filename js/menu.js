// Выгрузка блюд
$(document).ready(function (){
    $.ajax({
		url: "../php/menu_get_products.php",             
		success: function(data) {
			if (data != 1) {
				let z = JSON.parse(data);
				for (let i = 0; i < z.length; i++) {
					var menu_item = $(`<div id=item_${z[i].id} class="menu_item"></div>`)
					menu_item.append(`<div class="menu_add"><svg id="add_${z[i].id}" height="40px" width="40px" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <path d="M365.4,59.628c60.56,0,109.6,49.03,109.6,109.47c0,109.47-109.6,171.8-219.06,281.271    C146.47,340.898,37,278.568,37,169.099c0-60.44,49.04-109.47,109.47-109.47c54.73,0,82.1,27.37,109.47,82.1    C283.3,86.999,310.67,59.628,365.4,59.628z"/></svg></div>`)
					menu_item.append(`<h1 class="menu_title">${z[i].title}</h1>`)
					menu_item.append(`<div class="menu_img"><img src="${z[i].file_path}" alt="img"></div>`)
					menu_item.append(`<div class="menu_footer">\
						<button class="menu_btn" type="button">Описание</button>\
						<p class="menu_price">${z[i].price}р</p>\
					</div>`)
					menu_item.append(`<textarea disabled id="desc_${z[i].id}" class="menu_desc">${z[i].description}</textarea>`)

					$('.block_menu').append(menu_item);
				}
			}
		}
	});
});

// Открытие корзины
$(document).ready(function (){
    $('.header_icon').bind('click', open_cart);
	var first = true;
	function open_cart() {
		if(first) {
			if ($(this).parent().find(".header_cart").find('.cart_item').length)
			{
				$(".header_cart").css('display', 'flex');
				$(".header_icon svg").css('fill', '#7E6BFB');
			}
			else {
				$(".header_cart").css('display', 'flex');
				$(".header_icon svg").css('fill', '#7E6BFB');
				var $li = $('<div>').attr({'class':'text_emty_cart'});
				$('.header_cart').append($li.text('Пусто'));
			}
		}
		else {
			$('.text_emty_cart').remove();
			$('.order_message_wait').remove();
			$('.order_message').remove();
			$(".header_icon svg").css('fill', '');
			$(".header_cart").css('display', 'none');
		}
		first = !first;
	};
});

// Добавление в корзину
$(document).ready(function (){
    $(document).on('click', '.menu_add', add_to_cart);
	let cnt_product = 1;
	var cnt = 1;
	var amount_price = 0;
	function add_to_cart() {
		$('.order_message').remove();
		cnt_product = +$('.header_cnt_product').text() + 1;
		var id = $(this).parent().attr('id').substring(5);
		var title = $(this).parent().find('.menu_title').text();
		var price = +$(this).parent().find('.menu_price').text().substring(0, $(this).parent().find('.menu_price').text().length - 1);
		amount_price = +$('.cart_summary').find('.summary_price').text().substring(0, $('.header_cart').parent().parent().find('.cart_summary').find('.summary_price').text().length - 1) + price;
		if ($(`#cart_item_${id}`).length) {
			$('.header_cart').find('.cart_summary').find('.summary_price').text(`${amount_price}р`);
			cnt = 1 + +$(`#cart_item_${id}`).find('.item_text_block').find('.item_text_cnt').text().slice(1,-1);
			price += +$(`#cart_item_${id}`).find('.item_price').text().substring(0, $(`#cart_item_${id}`).find('.item_price').text().length - 1);
			$(`#cart_item_${id}`).find('.item_text_block').find('.item_text_cnt').text(`(${cnt})`);
			$(`#cart_item_${id}`).find('.item_price').text(`${price}р`);
		}	
		else {
			cnt = 1;
			var item = 
				$(`<div id=cart_item_${id} class="cart_item">
					<div class="item_text_block">
						<p class="item_text">${title}</p>
						<p class="item_text_cnt">(${cnt})</p>
					</div>
					<p class="item_price">${price}р</p>
					<div class="item_delete">
						<svg xmlns="http://www.w3.org/2000/svg"version="1.1" viewBox="0 0 32 32"><circle cx="16" cy="16" r="14"/><g transform="matrix(0.70710678,0.70710678,-0.70710678,0.70710678,16,-6.627417)"><rect style="fill:#ffffff" width="4" height="20" x="-18" y="6" transform="matrix(0,-1,1,0,0,0)"/><rect style="fill:#ffffff" width="4" height="20" x="14" y="6"/></g></svg>
					</div>
				</div>`);
			if ($('.cart_item').length) {
				$('.header_cart').find('.cart_summary').find('.summary_price').text(`${amount_price}р`);
				$('.cart_item').last().after(item);
				$('.header_nav').find('.header_cnt_product').text(`${cnt_product}`);
				cnt_product++;
			}
			else {
				cnt_product = 1;
				$('.header_nav').find('.header_cnt_product').css('opacity', '100');
				$('.header_nav').find('.header_cnt_product').text(`${cnt_product}`);
				cnt_product++;
				$('.text_emty_cart').empty();
				$('.header_cart').append(item);
				var cart_summary = 
					$(`<div class="cart_summary">
						<p class="summary_text">Итого: </p>
						<p class="summary_price">${amount_price}р</p>
					</div>`);
				var cart_buttons = 
					$(`<div class="cart_buttons">
						<button class="btn_clear">Очистить</button>
						<button class="btn_order">Заказать</button>
					</div>`)
				$('.header_cart').append(cart_summary)
				$('.header_cart').append(cart_buttons)
			}
		}
	};
});

// Удаление блюда из корзины
$(document).ready(function (){
	$(document).on('click', '.item_delete', delete_item);
	function delete_item() {
		let cur_price = +$(this).parent().find('.item_price').text().substring(0, $(this).parent().find('.item_price').text().length - 1);
		var all_price = +$(this).parent().parent().find('.cart_summary').find('.summary_price').text().substring(0, $('.header_cart').parent().parent().find('.cart_summary').find('.summary_price').text().length - 1);
		all_price -= cur_price;
		if (all_price == 0) {
			$('.header_cnt_product').text('0');
			var $li = $('<div>').attr({'class':'text_emty_cart'});
			$('.cart_summary').remove();
			$('.cart_buttons').remove();
			$('.header_cart').append($li.text('Пусто'));
			$('.text_emty_cart').remove();
			$(this).parent().remove();
		}
		else {
			let cnt_product = +$('.header_cnt_product').text();
			$('.header_cnt_product').text(cnt_product - 1);
			$('.header_cnt_product').text();
			$('.cart_summary').find('.summary_price').remove();
			$(this).parent().remove();
			$('.cart_summary').remove();
			var cart_summary = 
				$(`<div class="cart_summary">
					<p class="summary_text">Итого: </p>
					<p class="summary_price"></p>
				</div>`);
			$('.header_cart').find('.cart_item').last().after(cart_summary)
			$('.cart_summary').find('.summary_price').text(`${all_price}р`);
		}
	}
});	


// Добавление заказа
$(document).ready(function (){
	$(document).on('click', '.btn_order', add_order);
	function add_order() {
		var data = {};
		var amont_products = 0;	
		var total_price = $('.cart_summary').find('.summary_price').text().substring(0, $('.cart_summary').find('.summary_price').text().length - 1);
		var item_cnt = 0;
		var title = '';
		var products = [];
		$('.cart_item').each(function(i, elem){
			title = $(elem).find('.item_text').text();
			item_cnt = +$(elem).find('.item_text_cnt').text().substring(1, $(elem).find('.item_text_cnt').text().length - 1);
			amont_products += item_cnt;
			products.push(title)
		});
		data.products = products;
		data.amont_products = amont_products;
		data.total_price = total_price;

		$.ajax({
			url: "../php/menu_add_order.php",
			data: data,
			type: 'post',
			success: function(data) {
				if (data != 0) {
					Array.prototype.slice.call(document.querySelectorAll('[class^="cart_item"]'))
						.forEach(elt => elt.parentNode.removeChild(elt));
					$('.cart_summary').remove();
					$('.cart_buttons').remove();
					$('.text_emty_cart').remove();
					$('.order_message').remove();
					$('.header_nav').find('.header_cnt_product').text(`0`);
					var $li = $('<div>').attr({'class':'order_message'});
					$('.header_cart').append($li.text('Заказ принят!'));
					$(".header_queue_list").remove();
					$.ajax({
						url: "../php/menu_get_queue.php",
						contentType: 'json',          
						success: function(data) {
							var user_num = JSON.parse(data);
							var ul = $('<ul>').attr({'class':'header_queue_list'}).css('display', 'flex');
							$(".header_queue_title").css('color', '#7E6BFB');
							var li;
							$.each(user_num, function (i){
								if (i != user_num.length - 1) {
									li = $('<li>').attr({'class':'header_queue_item', 'id':`user_id_${user_num[i][0][0]}`}).text(i+1);
									ul.append(li);
								}
							});
							var user_position = user_num[user_num.length - 1][0];
							$('.header_queue').append(ul);
							$('.header_queue_list').find(`#user_id_${user_position}`).css('background-color', '#F1F32E').text(`${$('.header_queue_list').find(`#user_id_${user_position}`).text()} (ВЫ)`);
							$('.header_queue_list').find('.header_queue_item').first().css( "background-color", "#60F53B");
						}
					});
				}
				else {
					Array.prototype.slice.call(document.querySelectorAll('[class^="cart_item"]'))
						.forEach(elt => elt.parentNode.removeChild(elt));
					$('.cart_summary').remove();
					$('.cart_buttons').remove();
					$('.text_emty_cart').remove();
					$('.order_message').remove();
					$('.header_nav').find('.header_cnt_product').text(`0`);
					var $div = $('<div>').attr({'class':'order_message_wait'});
					$('.header_cart').append($div.text('Ваш заказ уже готовиться!'));
				}
			}
		});
	}
});

// Открытие очереди
$(document).ready(function (){
    $('.header_queue_title').bind('click', open_queue);
	var first = true;
	function open_queue() {
		if(first) {
			if ($(".header_queue_list").length) {
				$(".header_queue_title").css('color', '');
				$(".header_queue_list").css('display', 'none');
			}
			else {
				$.ajax({
					url: "../php/menu_get_queue.php",
					contentType: 'json',          
					success: function(result) {
						var user_num = JSON.parse(result);
						if (user_num == 0) {
							$(".header_queue_title").css('color', '#7E6BFB');
							var ul = $('<ul>').attr({'class':'header_queue_list'}).css('display', 'flex');
							li = $('<li>').attr({'class':'header_queue_empty'}).text('Cвободно!');
							ul.append(li)
							$('.header_queue').append(ul);
						}
						else {
							$(".header_queue_list").remove();
							var ul = $('<ul>').attr({'class':'header_queue_list'}).css('display', 'flex');
							$(".header_queue_title").css('color', '#7E6BFB');
							var li;
							$.each(user_num, function (i){
								if (i != user_num.length - 1) {
									li = $('<li>').attr({'class':'header_queue_item', 'id':`user_id_${user_num[i][0][0]}`}).text(i+1);
									ul.append(li);
								}
							});
							var user_position = user_num[user_num.length - 1][0];
							$('.header_queue').append(ul);
							$('.header_queue_list').find(`#user_id_${user_position}`).css('background-color', '#F1F32E').text(`${$('.header_queue_list').find(`#user_id_${user_position}`).text()} (ВЫ)`);
							$('.header_queue_list').find('.header_queue_item').first().css( "background-color", "#60F53B");
						}
					}
				});
			}
		}
		else {
			if ($(".header_queue_list").css('display') == 'none') {
				$(".header_queue_title").css('color', '#7E6BFB');
				$(".header_queue_list").css('display', 'flex');
			}
			else {
				$(".header_queue_title").css('color', '');
				$(".header_queue_list").remove();
			}
		}
		first = !first;
	};
});


// Очистка корзины
$(document).ready(function (){
    $(document).on('click', '.btn_clear', clear_all_cart);
	function clear_all_cart() {
		Array.prototype.slice.call(document.querySelectorAll('[class^="cart_item"]'))
    		.forEach(elt => elt.parentNode.removeChild(elt));
		$('.cart_summary').remove();
		$('.cart_buttons').remove();
		$('.text_emty_cart').remove();
		$('.header_nav').find('.header_cnt_product').text(`0`);
		var $div = $('<div>').attr({'class':'text_emty_cart'});
		$('.header_cart').append($div.text('Пусто'));
	}
});

// Открытие описания
$(document).ready(function (){
    $(document).on('click', '.menu_btn', open_desc);
	function open_desc() {
		if ($(this).parent().parent().find(".menu_desc").css('opacity') == "0") {
			$(this).parent().parent().find(".menu_desc").css('opacity', '100');
			$(this).css('background-color', '#4a36bf');
			$(this).css('box-shadow', 'none');
		}
		else {
			$(this).css('background-color', '');
			$(this).css('box-shadow', '');
			$(this).parent().parent().find(".menu_desc").css('opacity', '0');
		}
	};
});