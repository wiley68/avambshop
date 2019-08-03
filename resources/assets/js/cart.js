var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
function refreshCart(row){
	alert(row);
    //$.ajax({
	//	url: '/cart/change_cart',
    //    type: 'POST',
    //    data: {
	//		_token: CSRF_TOKEN, 
	//		total_price:$("#real_price").html(),
	//		product_name:$("#productName").html(),
	//		product_quantity:$("#product_quantity").val(),
	//		product_typeprice:$("#product_typeprice").text(),
	//		product_description:$("#product_description dd:first p").text(),
	//		product_currency:$("#product_currency em").text()
	//	},
    //    dataType: 'JSON',
    //    success: function (data) { 
	//		$( "#message_div" ).show( "slow", function() {
	//			$("#message_div").append("Успешно добавихте продукта. Можете да продължите с разглеждането на магазина ни, или да закупите продуктите във вашата <a href='/cart' title='Вижте съдържанието на Вашата Кошница.'>Кошница</a>."); 
	//		});
    //    }
//}); 
};			
