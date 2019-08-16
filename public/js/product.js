/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 46);
/******/ })
/************************************************************************/
/******/ ({

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, exports) {

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
        data: 'code=' + code + '&productcode=' + productcode + '&h=' + h + '&l=' + l + '&p=' + p,
        success: function success(msg) {
            if (parseFloat(msg) != 0) {
                var product_quantity = $("#product_quantity").val();
                if (product_quantity == '') {
                    product_quantity = 1;
                }
                var all_price = parseFloat(msg['new_price']) * product_quantity;
                var dds_purcent = 1.00 + parseFloat($("#dds_purcent").val()) / 100.00;
                if ($("#dds").val() == 'Yes') {
                    $("#real_price").html((all_price * dds_purcent).toFixed(2));
                } else {
                    $("#real_price").html(all_price.toFixed(2));
                }
            } else {
                console.log("Error zerro value");
                return false;
            }
        },
        error: function error(response) {
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
        success: function success(data) {
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

/***/ })

/******/ });