$( "#message_div" ).hide();
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$("button[name='btn_buy']")
    .each(function() {
		var ID = $(this).attr("id");
		if ($("#product_type_price_"+ID).val() == "f"){
			var p_h = 1000;
			var p_l = 1000;
			var p_p = 70;
		}else{
			var p_h = 0;
			var p_l = 0;
			var p_p = 0;
		}
		
		$(this).click(function(){
			$.ajax({
				url: '/product/set_session',
				type: 'POST',
				data: {
					_token: CSRF_TOKEN, 
					total_price:$("#real_price_"+ID).html(),
					product_name:$("#product_name_"+ID).html(),
					product_quantity:1,
					product_typeprice:$("#product_type_price_"+ID).val(),
					product_description:$("#product_description_"+ID).html(),
					product_currency:$("#product_currency_"+ID).val(),
					product_code:ID,
					product_h:p_h,
					product_l:p_l,
					product_p:p_p,
					product_real_kg:$("#real_kg_"+ID).val(),
					product_firm_id:$("#product_firm_id_"+ID).val()
				},
				dataType: 'JSON',
				success: function (data) {
					window.location.reload();
				}
			}); 
		});	
		
	});
	