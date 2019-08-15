function changePrice() {
    var code = '6jqnh5qx24y4ibic';
    var productcode = $('#product_code dd:first').text();
    var h = $("#h").val();
    var l = $("#l").val();
    var real_kg = $("#real_kg").val();
    if (h == '') {
        h = 0;
    }
    if (l == '') {
        l = 0;
    }
    if (p == '') {
        p = 0;
    }
    $.ajax({
        type: 'GET',
        url: $("#app_site").val() + "/api/getprice.php",
        async: true,
        cache: false,
        dataType: 'json',
        data: 'code='+code+'&productcode='+productcode+'&h='+h+'&l='+l+'&p='+p ,
        success: function (msg) {
            if (parseFloat(msg) != 0) {
                var product_quantity = $("#product_quantity").val();
                if (product_quantity == '') {
                    product_quantity = 1;
                }
                var all_price = parseFloat(msg['new_price']) * product_quantity;
                $("#real_price").html(all_price.toFixed(2));
            }
            else {
                console.log("Error zerro value");
                return false;
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
}

$("#message_div").hide();
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$("#btn_buy").click(function () {
    $.ajax({
        url: '/product/set_session',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            total_price: $("#real_price").html(),
            product_name: $("#productName").html(),
            product_quantity: $("#product_quantity").val(),
            product_typeprice: $("#product_typeprice").val(),
            product_description: $("#product_description dd:first p").text(),
            product_currency: $("#product_currency em").text(),
            product_code: $("#product_code dd:first").text(),
            product_h: $("#h").val(),
            product_l: $("#l").val(),
            product_p: $("#p").val(),
            product_real_kg: $("#real_kg").val(),
            product_firm_id: $("#firm_id").val()
        },
        dataType: 'JSON',
        success: function (data) {
            if ($("#cart_mini").is(":visible")) {
                var curr_count = parseInt($("#count_cart_items").html());
                curr_count++;
                $("#count_cart_items").html(curr_count.toString());
            } else {
                $("#count_cart_items").html("1");
            }
            window.scrollTo(0, 0);
            $("#message_div").show("slow", function () {
                $("#message_div").html("Успешно добавихте продукта. Можете да продължите с разглеждането на <a href='/' title='Онлайн магазин AVAMB.'>магазина</a> ни, или да закупите продуктите във вашата <a href='/cart' title='Вижте съдържанието на Вашата Количка.'>Количка</a>.");
            });
        }
    });
});

$("#h").keyup(function () {
    changePrice();
});

$("#l").keyup(function () {
    changePrice();
});

$("#p").keyup(function () {
    changePrice();
});

$("#product_quantity").keyup(function () {
    changePrice();
});
