$(function () {
//Активный пункт меню
	$('.navbar .nav li a').each(function (){
		var location = window.location.href;
		var link = this.href;
		if(location == link) {
			$(this).addClass('activemi');
		}
	}); 

//Фиксированое меню
	$(window).scroll(function(){
        if ( $(this).scrollTop() > 0 ) {
            $('.header-nav').addClass('navbar-fixed-top');
        } else {
            $('.header-nav').removeClass('navbar-fixed-top');
        }
  });

//hover для мобильного
	var touchHover = function() {
    $('[data-hover]').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var onHover = $this.attr('data-hover');
        var linkHref = $this.attr('href');
        if (linkHref && $this.hasClass(onHover)) {
            location.href = linkHref;
            return false;
        }
        $this.toggleClass(onHover);
    });
}; 	


//Купить в один клик
$('.product-layout > .product-thumb').each(function (e) {

		e +=1;

		var img_url = $(this).find('.img-responsive').attr('src'),
				item_name = $(this).find('h4 a').text(),
				item_price = $(this).find('.price').html(),
				admin = $('#callback [name=admin_email]').val();

		
		$(this).after('\
			<div id="pp-item-' + e + '" class="product-popup">\
				<h2>Купить в один клик</h2>\
				<div class="pp-img-wrap"><img src="' + img_url + '" alt="Купить одежду на Токо"></div>\
				<div class="pp-content">\
					<h3>' + item_name + '</h3>\
					<p>' + item_price + '</p>\
					<form class="ajax-form">\
						<input type="hidden" name="project_name" value="tokoServis">\
						<input type="hidden" name="admin_email" value="' + admin + '">\
						<input type="hidden" name="form_subject" value="Перезвоните мне">\
						<input type="hidden" name="Продукт" value="' + item_name + '">\
						<input class="form-control" type="text" name="Имя" placeholder="Как к Вам обращаться..."><br>\
						<input class="form-control" type="text" name="Телефон" placeholder="Введите Ваш номер телефона..." required>\
						<button class="btn btn-primary">Заказать</button>\
					</form>\
						<div class="success">Спасибо! Ожидайте, мы Вам перезвоним))</div>\
				</div>\
			</div>');		

		$(this).find('.button-group').append('<a class="toclick" href="#pp-item-' + e + '">Купить в один клик</a>');
		$(this).parent().attr({
			'class' : 'product-layout col-lg-4 col-md-4 col-sm-6 col-xs-12'
		});
	});
	
	$('.product-thumb h4').css('height', '').equalHeights();

	$('.toclick, .callback, .mailback').magnificPopup({
		mainClass: 'mfp-zoom-in',
		removalDelay: 500
	});

		//E-mail Ajax Send
	$(".ajax-form").submit(function() { //Change
		var th = $(this);
		$.ajax({
			type: "POST",
			url: "/catalog/view/theme/tokostyle/mail.php", //Change
			data: th.serialize()
		}).done(function() {
			var pp_suc = th.closest('.product-popup').find('.success');
			pp_suc.fadeIn();
			setTimeout(function() {
				// Done Functions
				th.trigger("reset");
				pp_suc.fadeOut();
				$.magnificPopup.close();
			}, 2000);
		});
		return false;
	});

});
