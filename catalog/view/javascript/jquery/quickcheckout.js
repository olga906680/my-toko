//quick checkout start
$(document).delegate('#tmdbuttonorder', 'click', function() {
$('html, body').animate({scrollTop:400}, 'slow');
	if(quicklogged){
	var accounttype = $('#typeaccount input[name="account"]:checked').val();
		$.ajax({
        url: 'index.php?route=extension/payment_address/save',
        type: 'post',
        data: $('#accountcontent input[type=\'text\'], #accountcontent input[type=\'date\'], #accountcontent input[type=\'datetime-local\'], #accountcontent input[type=\'time\'], #accountcontent input[type=\'password\'], #accountcontent input[type=\'checkbox\']:checked, #accountcontent input[type=\'radio\']:checked, #accountcontent input[type=\'hidden\'], #accountcontent textarea, #accountcontent select'),
        dataType: 'json',
        beforeSend: function() {
			$('#tmdbuttonorder').button('loading');	
			$('.loader').removeClass('hide');	
			},
        complete: function() {
			$('#tmdbuttonorder').button('reset');	
			},
        success: function(json) {
			$('.form-group').removeClass('has-error');
            $('#warning .alert, #warning .text-danger').remove();
            
			if (json['redirect']) {
             
            } else if (json['error']) {
				$('.loader').addClass('hide');	
				if (json['error']['warning']) {
						 $('#typeaccount').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

			for(i in json['error']){
				var element = $('#input-payment-' + i.replace('_', '-'));
				if($(element).parent().hasClass('input-group')){
					$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
				}else{
					$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
				}
			}

			// Highlight any found errors
			$('.text-danger').parent().addClass('has-error');
			
			}else{
				if(shipping_required){ 
				$.ajax({
				url: 'index.php?route=extension/shipping_address/save',
				type: 'post',
				data: $('#tmd_delivery_address input[type=\'text\'], #tmd_delivery_address input[type=\'date\'], #tmd_delivery_address input[type=\'datetime-local\'], #tmd_delivery_address input[type=\'time\'], #tmd_delivery_address input[type=\'password\'], #tmd_delivery_address input[type=\'checkbox\']:checked, #tmd_delivery_address input[type=\'radio\']:checked, #tmd_delivery_address textarea, #tmd_delivery_address select'),
				dataType: 'json',
				beforeSend: function() {
				$('#tmdbuttonorder').button('loading');
				},
				complete: function() {
				$('#tmdbuttonorder').button('reset');
				},
				success: function(json){
				$('.form-group').removeClass('has-error');
				$('#warning .alert, #warning .text-danger').remove();

				if (json['redirect']) {
				//location = json['redirect'];
				} else if (json['error']) {
				$('.loader').addClass('hide');
				if (json['error']['warning']) {
				$('#tmd_delivery_address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				for (i in json['error']) {
				var element = $('#input-shipping-' + i.replace('_', '-'));

				if ($(element).parent().hasClass('input-group')) {
				$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
				} else {
				$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
				}
				}
				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
				}else{
				$.ajax({
				url: 'index.php?route=extension/shipping_method/save',
				type: 'post',
				data: $('#tmd_shipping_method input[type=\'radio\']:checked, #tmd_shipping_method textarea'),
				dataType: 'json',
				beforeSend: function() {
				$('#tmdbuttonorder').button('loading');
				},
				complete: function() {
				$('#tmdbuttonorder').button('reset');
				},
				success: function(json){
				$('#warning .alert, #warning .text-danger').remove();
				$('.loader').addClass('hide');
				if (json['redirect']) {
				//location = json['redirect'];
				}else if (json['error']){
				if (json['error']['warning']) {
				$('#warning').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				} else {
				$.ajax({
				url: 'index.php?route=extension/payment_method/save',
				type: 'post',
				data: $('#tmd_payment_method input[type=\'radio\']:checked, #tmd_payment_method input[type=\'checkbox\']:checked, #tmd_payment_method textarea'),
				dataType: 'json',
				beforeSend: function() {
				$('#tmdbuttonorder').button('loading');
				},
				complete: function() {
				$('#tmdbuttonorder').button('reset');
				$('.loader').addClass('hide');
				},
				success: function(json){
				$('#warning .alert, #warning .text-danger').remove();

				if (json['redirect']) {
					//location = json['redirect'];
				} else if (json['error']) {
				$('.loader').addClass('hide');
					if (json['error']['warning']) {
				$('#warning').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
																				}
				}else{
						$('.loader').removeClass('hide');
						$('#final-button').load('index.php?route=extension/confirm');
				}
				},
				error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
				});
							}
				},
					error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
					});
								
					}
					},
					error: function(xhr, ajaxOptions, thrownError){
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});

				} else {
					$.ajax({
					url: 'index.php?route=extension/payment_method/save',
					type: 'post',
					data: $('#tmd_payment_method input[type=\'radio\']:checked, #tmd_payment_method input[type=\'checkbox\']:checked, #tmd_payment_method textarea'),
					dataType: 'json',
					beforeSend: function() {
						$('#tmdbuttonorder').button('loading');
					},
					complete: function() {
						$('#tmdbuttonorder').button('reset');
						
					},
					success: function(json){
						$('.loader').addClass('hide');
						$('#warning .alert, #warning .text-danger').remove();

						if (json['redirect']) {
								//location = json['redirect'];
						} else if (json['error']) {
								$('.loader').addClass('hide');
								if (json['error']['warning']) {
										$('#warning').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
								}
						}else{
								$('.loader').removeClass('hide');
								$('#final-button').load('index.php?route=extension/confirm');
						}
						},
						error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
			}
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
	}else{
		var accounttype = $('#typeaccount input[name="account"]:checked').val();
		$.ajax({
        url: 'index.php?route=extension/'+accounttype+'/save',
        type: 'post',
        data: $('#accountcontent input[type=\'text\'], #accountcontent input[type=\'date\'], #accountcontent input[type=\'datetime-local\'], #accountcontent input[type=\'time\'], #accountcontent input[type=\'password\'], #accountcontent input[type=\'hidden\'], #accountcontent input[type=\'checkbox\']:checked, #accountcontent input[type=\'radio\']:checked, #accountcontent textarea, #accountcontent select, #tmd_delivery_address input[type=\'checkbox\']:checked'),
        dataType: 'json',
				beforeSend: function() {
					$('#tmdbuttonorder').button('loading');
					$('.loader').removeClass('hide');
				},
				complete: function() {
					$('#tmdbuttonorder').button('reset');
				},
        success: function(json) {
						$('.form-group').removeClass('has-error');
            $('#warning .alert, #warning .text-danger').remove();
            
		if (json['redirect']) {
			if(json['logged']) {
				$.ajax({
					url: 'index.php?route=extension/payment_address',
					dataType: 'html',
					beforeSend: function(){
						
					},
					success: function(html){
							$('#typeaccount').html('');
							$('#accountcontent').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}else{
				//location = json['redirect'];
			}
            } else if (json['error']) {
			$('.loader').addClass('hide');
			if (json['error']['warning']) {
					 $('#typeaccount').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			for(i in json['error']){
				var element = $('#input-payment-' + i.replace('_', '-'));
				if($(element).parent().hasClass('input-group')){
					$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
				}else{
					$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
				}
			}

			// Highlight any found errors
			$('.text-danger').parent().addClass('has-error');
            }else{
		if(shipping_required){ 
			var path = '';
			if(accounttype=='register'){
				path  = 'index.php?route=extension/shipping_address/save';
			}else{
				path  = 'index.php?route=extension/guest_shipping/save';
			}
				$.ajax({
						url: path,
						type: 'post',
						data: $('#tmd_delivery_address input[type=\'text\'], #tmd_delivery_address input[type=\'date\'], #tmd_delivery_address input[type=\'datetime-local\'], #tmd_delivery_address input[type=\'time\'], #tmd_delivery_address input[type=\'password\'], #tmd_delivery_address input[type=\'checkbox\']:checked, #tmd_delivery_address input[type=\'radio\']:checked, #tmd_delivery_address textarea, #tmd_delivery_address select'),
						dataType: 'json',
						beforeSend: function() {
							$('#tmdbuttonorder').button('loading');
						},
						complete: function() {
							$('#tmdbuttonorder').button('reset');
						},
						success: function(json){
								$('.form-group').removeClass('has-error');
								$('#warning .alert, #warning .text-danger').remove();

								if (json['redirect']) {
										//location = json['redirect'];
								} else if (json['error']) {
										$('.loader').addClass('hide');	
										if (json['error']['warning']) {
												$('#tmd_delivery_address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
										}

						for (i in json['error']) {
							var element = $('#input-shipping-' + i.replace('_', '-'));

							if ($(element).parent().hasClass('input-group')) {
								$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
							} else {
								$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
							}
						}
						// Highlight any found errors
						$('.text-danger').parent().addClass('has-error');
						}else{
							$(document).ready(function(){
						$.ajax({
							url: 'index.php?route=extension/shipping_method',
							type: 'post',
							data: $('#account select, #account input'),
							success: function(html){
							$('#tmd_shipping_method').html(html);
							setTimeout(function(){ $.ajax({
							url: 'index.php?route=extension/shipping_method/save',
							type: 'post',
							data: $('#tmd_shipping_method input[type=\'radio\']:checked, #tmd_shipping_method textarea'),
							dataType: 'json',
							success: function(json){
							$.ajax({
									url: 'index.php?route=extension/payment_method',
									dataType: 'html',
											success: function(html){
									$('#tmd_payment_method').html(html);
									$('.loader').addClass('hide');		
									 $.ajax({
									url: 'index.php?route=extension/payment_method/save',
									type: 'post',
									data: $('#tmd_payment_method input[type=\'radio\']:checked, #tmd_payment_method textarea'),
									dataType: 'json',
									success: function(json){
									$('.loader').removeClass('hide');
								$('#final-button').load('index.php?route=extension/confirm');
							 }});
											},
									error: function(xhr, ajaxOptions, thrownError){
										alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
									}
								});			
							
					 }}); }, 2000);
							
									},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					});
					
							
				}
				},
				error: function(xhr, ajaxOptions, thrownError){
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
			} else {
			$.ajax({
					url: 'index.php?route=extension/payment_method/save',
					type: 'post',
					data: $('#tmd_payment_method input[type=\'radio\']:checked, #tmd_payment_method input[type=\'checkbox\']:checked, #tmd_payment_method textarea'),
					dataType: 'json',
					beforeSend: function() {
						$('#tmdbuttonorder').button('loading');
					},
					complete: function() {
						$('#tmdbuttonorder').button('reset');
						$('.loader').addClass('hide');
					},
					success: function(json){
					$('#warning .alert, #warning .text-danger').remove();

					if(json['redirect']){
							//location = json['redirect'];
					}else if (json['error']){
					if(json['error']['warning']){
						$('#warning').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
					}else{
						$('.loader').removeClass('hide');
						$('#final-button').load('index.php?route=extension/confirm');
					}
					},
					error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
		}
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
	}
	});

	loadcart();
	function loadcart()
	{
	   $.ajax({
			url: 'index.php?route=extension/tmdcart',
			dataType: 'html',
			success: function(html){
			   $('#tmd_cart').html(html);
					},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		
	});
	}
	if(!quicklogged){ 
	$(document).ready(function(){
		$.ajax({
			url: 'index.php?route=extension/tmdcheckout/accounttype',
			dataType: 'html',
					beforeSend: function() {
						$('.loader').removeClass('hide');
					},
			success: function(html){
			   $('#typeaccount').html(html);
					},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
	} else { 
	$(document).ready(function(){
		$.ajax({
			url: 'index.php?route=extension/payment_address',
			dataType: 'html',
					beforeSend: function(){
						$('.loader').removeClass('hide');
			},
			success: function(html){
							$('#typeaccount').html('');
				$('#accountcontent').html(html);
					},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
			
			if(shipping_required){ 
			$.ajax({
					url: 'index.php?route=extension/shipping_address',
					dataType: 'html',
					success: function(html){
						$('#tmd_delivery_address').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError){
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
			});
			} 
	});
	}
	$(document).delegate('#tmdqclogin', 'click', function(){
		$.ajax({
			url: 'index.php?route=extension/login',
			dataType: 'html',
			beforeSend: function(){
			},
			complete: function() {
					},
			success: function(html){
			  $('#warning .alert, #warning .text-danger').remove();
						$('#tmdlogin').html(html);
						$("#myModal").modal("show");
					},
			error: function(xhr, ajaxOptions, thrownError){
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});

		//Shipping Method
		if(shipping_required){
		$(document).ready(function(){
			$.ajax({
				url: 'index.php?route=extension/shipping_method',
				dataType: 'html',
				success: function(html){
				$('#tmd_shipping_method').html(html);
				$.ajax({
				url: 'index.php?route=extension/shipping_method/save',
				type: 'post',
				data: $('#tmd_shipping_method input[type=\'radio\']:checked, #tmd_shipping_method textarea'),
				dataType: 'json',
				success: function(json){		
				loadcart();
		 }});
						},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		 } 

		//Payment Method
		$(document).ready(function(){
			$.ajax({
				url: 'index.php?route=extension/payment_method',
				dataType: 'html',
						success: function(html){
				$('#tmd_payment_method').html(html);
				$('.loader').addClass('hide');		
				 $.ajax({
				url: 'index.php?route=extension/payment_method/save',
				type: 'post',
				data: $('#tmd_payment_method input[type=\'radio\']:checked, #tmd_payment_method textarea'),
				dataType: 'json',
				success: function(json){
				loadcart();
		 }});
						},
				error: function(xhr, ajaxOptions, thrownError){
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		// Checkout
		$(document).delegate('input[name="account"]', 'click', function() {
			$.ajax({
				url: 'index.php?route=extension/' + $('input[name=\'account\']:checked').val(),
				dataType: 'html',
				beforeSend: function(){
							$('.loader').removeClass('hide');
				},
				complete: function() {
						},
				success: function(html){
				  $('#warning .alert, #warning .text-danger').remove();
							$('#accountcontent').html(html);
							$('.loader').addClass('hide');
						},
				error: function(xhr, ajaxOptions, thrownError){
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
				
				if(shipping_required){ 
				if($('input[name=\'account\']:checked').val()=='register'){
					var url = 'index.php?route=extension/shipping_address';
				}else if($('input[name=\'account\']:checked').val()=='guest'){
					var url =  'index.php?route=extension/guest_shipping';
				}else{
					location = 'index.php?route=extension/tmdcheckout';
				}
				$.ajax({
						url: url,
						dataType: 'html',
						success: function(html){
							$('#tmd_delivery_address').html(html);
						},
						error: function(xhr, ajaxOptions, thrownError){
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
				});
				 } 
		});

		// Login
		$(document).delegate('#button-login', 'click', function(){
			$.ajax({
				url: 'index.php?route=extension/login/save',
				type: 'post',
				data: $('#myModal :input'),
				dataType: 'json',
				beforeSend: function() {
					$('#button-login').button('loading');
						},
				complete: function() {
					$('#button-login').button('reset');
				},
				success: function(json) {
					$('#warning .alert, #warning .text-danger').remove();
					$('.form-group').removeClass('has-error');

					if (json['redirect']){
						location = json['redirect'];
					}else if (json['error']){
					  $('#tmdlogin .modal-body > .row').before().prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						// Highlight any found errors
						$('input[name=\'email\']').parent().addClass('has-error');
						$('input[name=\'password\']').parent().addClass('has-error');
				   }
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$(document).delegate('#guest_shipping_address', 'click', function(){
			var val = $('input[name="shipping_address"]:checked').val();
			if(val==undefined){
				$.ajax({
						url: 'index.php?route=extension/guest_shipping',
						dataType: 'html',
						success: function(html){
					$('#tmd_delivery_address').html(html);
						},
						error: function(xhr, ajaxOptions, thrownError){
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
			});
			}else{
				$('#tmd_delivery_address').html('');
			}
		});


	$( document ).delegate('#tmd_shipping_method input[type="radio"]', 'click', function(){
			  $.ajax({
				url: 'index.php?route=extension/shipping_method/save',
				type: 'post',
				data: $('#tmd_shipping_method input[type=\'radio\']:checked, #tmd_shipping_method textarea'),
				dataType: 'json',
				beforeSend: function(){
					$('.loader').removeClass('hide');
						},
				complete: function(){
							$('.loader').addClass('hide');
				},
				success: function(json){
					$('#warning .alert, #warning .text-danger').remove();
								$('.loader').addClass('hide');
					if (json['redirect']) {
						//location = json['redirect'];
					}else if (json['error']){
						if (json['error']['warning']) {
							$('#warning').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
					} else {
						loadcart();
						if(json['order_id']){
								
						}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$(document).delegate('#tmd_payment_method input[type="radio"]', 'click', function(){
			$.ajax({
				url: 'index.php?route=extension/payment_method/save',
				type: 'post',
				data: $('#tmd_payment_method input[type=\'radio\']:checked, #tmd_payment_method input[type=\'checkbox\']:checked, #tmd_payment_method textarea'),
				dataType: 'json',
				beforeSend: function() {
					$('.loader').removeClass('hide');
						},
				complete: function() {
							$('.loader').addClass('hide');
				},
				success: function(json){
					$('#warning .alert, #warning .text-danger').remove();
								if (json['redirect']) {
						//location = json['redirect'];
					} else if (json['error']) {
										$('.loader').addClass('hide');
						if (json['error']['warning']) {
							$('#warning').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
					}else{
										if(json['order_id']){
											//location = 'index.php?route=extension/tmdcheckout';
										}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});


		$(document).delegate('#button-coupon', 'click', function(){
			$.ajax({
				url: 'index.php?route=extension/total/coupon/coupon',
				type: 'post',
				data: 'coupon=' + encodeURIComponent($('input[name=\'coupon\']').val()),
				dataType: 'json',
				beforeSend: function() {
					$('#button-coupon').button('loading');
				},
				complete: function() {
					$('#button-coupon').button('reset');
				},
				success: function(json) {
					$('.alert').remove();

					if (json['error']) {
						$('.loader').addClass('hide');
						$('.breadcrumb').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('html, body').animate({ scrollTop: 0 }, 'slow');
					}

					if (json['redirect']) {
						$('#tmd_cart').load('index.php?route=extension/tmdcart');
					}
				}
			});
		});

		$(document).delegate('#button-voucher', 'click', function(){
		  $.ajax({
			url: 'index.php?route=extension/total/voucher/voucher',
			type: 'post',
			data: 'voucher=' + encodeURIComponent($('input[name=\'voucher\']').val()),
			dataType: 'json',
			beforeSend: function() {
			  $('#button-voucher').button('loading');
			},
			complete: function() {
			  $('#button-voucher').button('reset');
			},
			success: function(json) {
			  $('.alert').remove();

			  if (json['error']) {
						$('.loader').addClass('hide');
				$('.breadcrumb').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			  }

			  if (json['redirect']) {
						$('#tmd_cart').load('index.php?route=extension/tmdcart');
			  }
			}
		  });
		});

		$(document).delegate('#button-reward', 'click', function(){
			$.ajax({
				url: 'index.php?route=checkout/reward/reward',
				type: 'post',
				data: 'reward=' + encodeURIComponent($('input[name=\'reward\']').val()),
				dataType: 'json',
				beforeSend: function() {
					$('#button-reward').button('loading');
				},
				complete: function() {
					$('#button-reward').button('reset');
				},
				success: function(json) {
					$('.alert').remove();

					if (json['error']) {
						$('.loader').addClass('hide');
						$('.breadcrumb').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('html, body').animate({ scrollTop: 0 }, 'slow');
					}

					if (json['redirect']) {
						$('#tmd_cart').load('index.php?route=extension/tmdcart');
					}
				}
			});
		});

	//////// Load shipping method and payment method
	$(document).delegate('#input-payment-country,#input-payment-zone', 'change', function(){
		//Shipping Method
		if(shipping_required){ 
		$(document).ready(function(){
			$.ajax({
				url: 'index.php?route=extension/shipping_method',
				type: 'post',
				data: $('#account select, #account input'),
				success: function(html){
				$('#tmd_shipping_method').html(html);
				setTimeout(function(){ $.ajax({
				url: 'index.php?route=extension/shipping_method/save',
				type: 'post',
				data: $('#tmd_shipping_method input[type=\'radio\']:checked, #tmd_shipping_method textarea'),
				dataType: 'json',
				success: function(json){		
				
		 }}); }, 2000);
				
						},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		 } 
		
		 $.ajax({
			url: 'index.php?route=extension/payment_method',
			type: 'post',
			data: $('#account select[name=\'zone_id\'], #account select[name=\'country_id\']'),
					success: function(html){
			$('#tmd_payment_method').html(html);
			$('.loader').addClass('hide');	
setTimeout(function(){  $.ajax({
			 
			url: 'index.php?route=extension/payment_method/save',
			type: 'post',
			data: $('#tmd_payment_method input[type=\'radio\']:checked, #tmd_payment_method textarea'),
			dataType: 'json',
			success: function(json){  }}); }, 2000);			
			
					},
			error: function(xhr, ajaxOptions, thrownError){
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
		
		loadcart();

	});

	$(document).delegate('#input-shipping-country,#input-shipping-zone', 'change', function(){
		//Shipping Method
		if(shipping_required){
		$(document).ready(function(){
		$.ajax({
			url: 'index.php?route=extension/shipping_method',
			type: 'post',
			data: $('#tmd_delivery_address select,#tmd_delivery_address input'),
			success: function(html){
			$('#tmd_shipping_method').html(html);
			setTimeout(function(){ $.ajax({
				url: 'index.php?route=extension/shipping_method/save',
				type: 'post',
				data: $('#tmd_shipping_method input[type=\'radio\']:checked, #tmd_shipping_method textarea'),
				dataType: 'json',
				success: function(json){		
				
		 }}); }, 2000);
						},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		} 
		loadcart();

	});
	
$(document).ready(function(){
	var html = '<div id="final-button">';
	html += '<div class="buttons col-sm-12">';
	html += '<div class="pull-right">';
	html += '<a href="'+continuebtn+'" class="btn btn-primary">'+button_shopping+'</a> <input type="button" value="'+button_order+'" id="tmdbuttonorder" class="btn btn-primary" data-loading-text="'+text_loading+'" />';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	$('#tmd_confirmation').html(html);
 });
 //quick checkout end