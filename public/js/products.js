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
/******/ 	return __webpack_require__(__webpack_require__.s = 49);
/******/ })
/************************************************************************/
/******/ ({

/***/ 49:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(50);


/***/ }),

/***/ 50:
/***/ (function(module, exports) {

$("#message_div").hide();
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$("button[name='btn_buy']").each(function () {
	var ID = $(this).attr("id");
	if ($("#product_type_price_" + ID).val() == "f") {
		var p_h = 1000;
		var p_l = 1000;
		var p_p = 70;
	} else {
		var p_h = 0;
		var p_l = 0;
		var p_p = 0;
	}

	$(this).click(function () {
		$.ajax({
			url: '/product/set_session',
			type: 'POST',
			data: {
				_token: CSRF_TOKEN,
				total_price: $("#real_price_" + ID).html(),
				product_name: $("#product_name_" + ID).html(),
				product_quantity: 1,
				product_typeprice: $("#product_type_price_" + ID).val(),
				product_description: $("#product_description_" + ID).html(),
				product_currency: $("#product_currency_" + ID).val(),
				product_code: ID,
				product_h: p_h,
				product_l: p_l,
				product_p: p_p,
				product_real_kg: $("#real_kg_" + ID).val(),
				product_firm_id: $("#product_firm_id_" + ID).val()
			},
			dataType: 'JSON',
			success: function success(data) {
				window.location.reload();
			}
		});
	});
});

/***/ })

/******/ });