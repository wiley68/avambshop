<?php

namespace App\Http\Controllers;

use App\Firm;
use Illuminate\Http\Request;
use App\Weborder;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PagesController extends Controller
{
	function previous_route()
	{
		$previousRequest = app('request')->create(app('url')->previous());

		try {
			$routeName = app('router')->getRoutes()->match($previousRequest)->getName();
		} catch (NotFoundHttpException $exception) {
			return null;
		}

		return $routeName;
	}

	public function getHome()
	{
		return view('home');
	}

	public function getAbout()
	{
		return view('about');
	}

	public function getContact()
	{
		return view('contact');
	}

	public function getSitemap()
	{
		return view('sitemap');
	}

	public function getProfile()
	{
		return view('profile');
	}

	public function getOrders()
	{
		$user = Auth::user();
		if (!empty($user)) {
			$orders = Weborder::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();
			$properties = PropertiesController::getAllProperties()->first();
			return view('orders')->with([
				'orders' => $orders,
				'properties' => $properties
			]);
		} else {
			return redirect()->route('login');
		}
	}

	public function getUserOrder(Request $request)
	{
		if ($request->isMethod('post') && $request->input('id') != null) {
			$order = Weborder::where(['id' => $request->input('id')])->first();
			$firm = Firm::where(['id' => $order->firm_id])->first();
			$properties = PropertiesController::getAllProperties()->first();
			return view('user_order')->with([
				'order' => $order,
				'properties' => $properties,
				'firm' => $firm
			]);
		}
	}

	public function getUserOrderEmail(Request $request, $id = null)
	{
		if ($request->isMethod('get') && $id != null) {
			$order = Weborder::where(['id' => $id])->first();
			$firm = Firm::where(['id' => $order->firm_id])->first();
			$properties = PropertiesController::getAllProperties()->first();
			return view('user_order')->with([
				'order' => $order,
				'properties' => $properties,
				'firm' => $firm
			]);
		}
	}

	public function getTerms()
	{
		return view('terms');
	}

	public function getPolitika()
	{
		return view('politika');
	}

	public function getDostavka()
	{
		return view('dostavka');
	}

	public function getVrashtane()
	{
		return view('vrashtane');
	}

	public function getProducts()
	{
		$allproducts = ProductsController::getProducts();
		return view('products/products')->with([
			'allproducts' => $allproducts
		]);
	}

	public function requestProduct(Request $request, $id = null)
	{
		$product = ProductsController::getProductById($id);
		return view('request')->with([
			'product_code' => $product->code
		]);
	}

	public function getProductsSearch(Request $request)
	{
		$referrer = $request->headers->get('referer');
		$link_array = explode('/', $referrer);
		if (end($link_array) == "search") {
			$route_name = "";
		} else {
			$route_name = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
		}
		$response = array(
			'termin' => $request->termin
		);
		if ($route_name == "products.by_firm") {
			$previous = app('request')->create(url()->previous());
			$param = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->parameters["id"];
			$allproducts = ProductsController::getProductsByTerminId($response['termin'], $param);
		} else {
			$allproducts = ProductsController::getProductsByTermin($response['termin']);
		}
		return view('products/products')->with([
			'allproducts' => $allproducts,
			'termin' => $response['termin']
		]);
	}

	public function getProductsByFirm(Request $request, $id = null)
	{
		$firm = FirmsController::getFirmById($id)->first();
		return view('products/products-by-firm')->with([
			'firm' => $firm
		]);
	}

	public function getProductsByCategory(Request $request, $id = null)
	{
		$category = CategoriesProductsController::getCategoryById($id)->first();
		return view('products/products-by-category')->with([
			'category' => $category
		]);
	}

	public function getFirms()
	{
		return view('firms/firms');
	}

	public function getProduct()
	{
		return view('product/product');
	}

	public function setSessionData(Request $request)
	{
		$response = array(
			'status' => 'success',
			'total_price' => $request->total_price,
			'product_name' => $request->product_name,
			'product_quantity' => $request->product_quantity,
			'product_typeprice' => $request->product_typeprice,
			'product_description' => $request->product_description,
			'product_currency' => $request->product_currency,
			'product_code' => $request->product_code,
			'product_h' => $request->product_h,
			'product_l' => $request->product_l,
			'product_p' => $request->product_p,
			'product_real_kg' => $request->product_real_kg,
			'product_firm_id' => $request->product_firm_id
		);
		$cart_session = array();

		if (null != $request->session()->get('cart_session')) { //ima nalicna cart
			$cart_session = $request->session()->get('cart_session'); //get current cart info
			$cart_id = $cart_session['cart_id'];
			$product_firm_id = $response['product_firm_id'];
			//add new item
			$item['total_price'] = $response['total_price']; //add new item total_price
			$item['product_name'] = $response['product_name']; //add new item product_name
			$item['product_quantity'] = $response['product_quantity']; //add new item product_quantity
			$item['product_typeprice'] = $response['product_typeprice']; //add new item product_typeprice
			$item['product_description'] = $response['product_description']; //add new item product_description
			$item['product_currency'] = $response['product_currency']; //add new item product_currency
			$item['product_code'] = $response['product_code']; //add new item product_code
			$item['product_h'] = $response['product_h']; //add new item product_h
			$item['product_l'] = $response['product_l']; //add new item product_l
			$item['product_p'] = $response['product_p']; //add new item product_p
			$item['product_real_kg'] = $response['product_real_kg']; //add new item product_real_kg
			//check if firm_id exist
			$current_i = -1;
			for ($i = 0; $i < sizeof($cart_session['firms']); $i++) {
				if ($cart_session['firms'][$i]['firm_id'] == $product_firm_id) {
					$current_i = $i;
					break;
				}
			}
			//add new item
			if ($current_i != -1) {
				$cart_session['firms'][$current_i]['items'][] = $item;
			} else {
				$firms_count = sizeof($cart_session['firms']);
				$cart_session['firms'][$firms_count]['firm_id'] = $product_firm_id;
				$cart_session['firms'][$firms_count]['items'][] = $item;
			}
		} else { // niama nalicna cart
			$cart_id = $request->session()->getId(); //set new cart info
			$cart_session['cart_id'] = $cart_id; //set new cart id
			//set new firm
			$cart_session['firms'][0]['firm_id'] = $response['product_firm_id']; //add new firm
			//set new item
			$item['total_price'] = $response['total_price']; //add new item total_price
			$item['product_name'] = $response['product_name']; //add new item product_name
			$item['product_quantity'] = $response['product_quantity']; //add new item product_quantity
			$item['product_typeprice'] = $response['product_typeprice']; //add new item product_typeprice
			$item['product_description'] = $response['product_description']; //add new item product_description
			$item['product_currency'] = $response['product_currency']; //add new item product_currency
			$item['product_code'] = $response['product_code']; //add new item product_code
			$item['product_h'] = $response['product_h']; //add new item product_h
			$item['product_l'] = $response['product_l']; //add new item product_l
			$item['product_p'] = $response['product_p']; //add new item product_p
			$item['product_real_kg'] = $response['product_real_kg']; //add new item product_real_kg
			$cart_session['firms'][0]['items'][] = $item; //add new item

		}
		$request->session()->put('cart_session', $cart_session);

		return response()->json($response);
	}

	public function changeSessionData(Request $request)
	{
		$response = array(
			'status' => 'success',
			'cart_item_id' => $request->cart_item_id,
			'cart_item_firm_id' => $request->cart_item_firm_id,
			'cart_item_quantity' => $request->cart_item_quantity,
			'cart_item_delete' => $request->cart_item_delete
		);
		$cart_session = array();

		if (null != $request->session()->get('cart_session')) { //ima nalicna cart
			$cart_session = $request->session()->get('cart_session'); //get current cart info
			if ($response['cart_item_delete'] == 'Yes') { //delete item
				array_splice($cart_session['firms'][$response['cart_item_firm_id']]['items'], $response['cart_item_id'], 1);
				//check last item
				if (sizeof($cart_session['firms'][$response['cart_item_firm_id']]['items']) == 0) {
					//delete session cart firms
					array_splice($cart_session['firms'], $response['cart_item_firm_id'], 1);
					//check last firm
					if (sizeof($cart_session['firms']) == 0) {
						$request->session()->forget('cart_session');
					}
				}
			} else { //change item
				$item_quantity_old = intval($cart_session['firms'][$response['cart_item_firm_id']]['items'][$response['cart_item_id']]['product_quantity']);
				$item_total_price_old = floatval($cart_session['firms'][$response['cart_item_firm_id']]['items'][$response['cart_item_id']]['total_price']);
				$item_price = $item_total_price_old / $item_quantity_old;
				$item_quantity_new = intval($response['cart_item_quantity']);
				$item_total_price_new = $item_price * $item_quantity_new;

				$cart_session['firms'][$response['cart_item_firm_id']]['items'][$response['cart_item_id']]['product_quantity'] = $item_quantity_new; //add array items quantity
				$cart_session['firms'][$response['cart_item_firm_id']]['items'][$response['cart_item_id']]['total_price'] = $item_total_price_new; //add array items total_price
			}
		}
		$request->session()->put('cart_session', $cart_session);

		return response()->json($response);
	}

	public function getCart(Request $request)
	{
		return view('cart', ['cart_session' => $request->session()->get('cart_session')]);
	}

	public function getOrder(Request $request)
	{
		return view('order', ['cart_session' => $request->session()->get('cart_session')]);
	}

	public function getEmailsOrder(Request $request)
	{
		return view('emails/order');
	}
}
