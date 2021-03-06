<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weborder;
use App\Subweborder;
use App\Http\Controllers\SubwebordersController;
use App\Http\Controllers\SubdeliveriesController;
use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Firm;
use PDF;
use App\Webpayment;
use App\Webdeliverie;

class WebordersController extends Controller
{
	public function submit(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'address' => 'required',
			'city' => 'required',
			'postalcod' => 'required',
			'phone' => 'required',
			'email' => 'required'
		]);

		$orders = null;

		$cart_session = $request->session()->get('cart_session'); //get current cart info

		if (isset($cart_session)) {
			//generate orders
			$order_number = 0;
			$order_ids = "";
			foreach ($cart_session['firms'] as $firm) {
				$order = new Weborder;
				$order->dateon = date('Y-m-d H:i:s');
				$order->user_id = $request->input('user_id');
				$order->name = $request->input('name');
				$order->email = $request->input('email');
				$order->phone = $request->input('phone');
				$order->city = $request->input('city');
				$order->postalcod = $request->input('postalcod');
				$order->address = $request->input('address');
				if ($request->input('isfirma') == "Yes") {
					$order->isfirma = "Yes";
				} else {
					$order->isfirma = "No";
				}
				$order->eik = $request->input('eik');
				$order->firmname = $request->input('firmname');
				$order->dds_nomer = $request->input('dds_nomer');
				$order->firmcity = $request->input('firmcity');
				$order->firmaddress = $request->input('firmaddress');
				$order->mol = $request->input('mol');
				$order->description = $request->input('description');
				//get payment for this order
				$order->payment = $request->input('paymentMethods' . $firm['firm_id']);
				//get delivery for this order
				$order->delivery = $request->input('deliverieMethods' . $firm['firm_id']);
				$order->status = "obrabotka";
				//get allprice for this order
				$order->allprice = $request->input('grand_total_price' . $firm['firm_id']);
				$order->firm_id = $firm['firm_id'];
				//save order
				$order->save();
				$last_id = $order->id;
				$order_ids .= $order->id . '_';
				$sub_weborders = SubwebordersController::getSubwebordersByWeborderId($order->id);
				$order_kg = 0;
				foreach ($sub_weborders as $sub_weborder) {
					$order_kg += floatval($sub_weborder['kg']);
				}
				$price_deliveries = SubdeliveriesController::getSubdeliveriesByDelivery($order->delivery, $order_kg);
				if (sizeof($price_deliveries) > 0) {
					$price_delivery = floatval($price_deliveries[0]->price);
				} else {
					$price_delivery = 0.00;
				}
				$orders[$order_number]['price_delivery'] = $price_delivery;
				$orders[$order_number]['order'] = $order;

				//save order details
				if (isset($firm['items'])) {
					foreach ($firm['items'] as $item) {
						$suborder = new Subweborder;
						$suborder->order_id = $last_id;
						$suborder->product_code = $item['product_code'];
						$suborder->quantity = $item['product_quantity'];
						$suborder->price = $item['total_price'];
						$suborder->h = $item['product_h'];
						$suborder->l = $item['product_l'];
						$suborder->p = $item['product_p'];
						$suborder->kg = $item['product_real_kg'];
						$suborder->save();
						$orders[$order_number]['suborder'][] = $suborder;
					}
				}

				//send mails
				//to member
				$objMail = new \stdClass();
				$objMail->app_name = env('APP_NAME', 'AVAMB Logiciel');
				$objMail->order_id = $last_id;
				$objMail->order_date = $order->dateon;
				$objMail->allprice = $order->allprice + $price_delivery;
				$objMail->payment = $order->payment;
				$objMail->delivery = $order->delivery;
				$objMail->price_delivery = $price_delivery;
				$objMail->firm_id = $order->firm_id;
				if (isset($firm['items'])) {
					$objMail->items = $firm['items'];
				} else {
					$objMail->items = null;
				}
				$objMail->sender = env('MAIL_USERNAME', 'AVAMB Logiciel');
				$objMail->receiver = $order->name;
				$objMail->isadmin = 'No';
				$objMail->phone = $order->phone;
				$objMail->email = $order->email;

				Mail::to($order->email)->send(new OrderEmail($objMail));

				//to admin
				$objMailAdmin = new \stdClass();
				$objMailAdmin->app_name = env('APP_NAME', 'AVAMB Logiciel');
				$objMailAdmin->order_id = $last_id;
				$objMailAdmin->order_date = $order->dateon;
				$objMailAdmin->allprice = $order->allprice + $price_delivery;
				$objMailAdmin->payment = $order->payment;
				$objMailAdmin->delivery = $order->delivery;
				$objMailAdmin->price_delivery = $price_delivery;
				$objMailAdmin->firm_id = $order->firm_id;
				if (isset($firm['items'])) {
					$objMailAdmin->items = $firm['items'];
				} else {
					$objMailAdmin->items = null;
				}
				$objMailAdmin->sender = env('MAIL_USERNAME', 'AVAMB Logiciel');
				$objMailAdmin->receiver = 'Администратор AVAMB Logiciel';
				$objMailAdmin->isadmin = 'Yes';
				$objMailAdmin->phone = $order->phone;
				$objMailAdmin->email = $order->email;

				//to mail
				$firm_mail = Firm::where(['id' => $order->firm_id])->first()->firm_mail;
				if (filter_var($firm_mail, FILTER_VALIDATE_EMAIL)) {
					Mail::to($firm_mail)->send(new OrderEmail($objMailAdmin));
				} else {
					Mail::to(env('MAIL_USERNAME', 'ilko.iv@gmail.com'))->send(new OrderEmail($objMailAdmin));
				}

				$order_number++;
			}
			//generate orders
			$order_ids = rtrim($order_ids, '_');
			$request->session()->forget('cart_session');
		}

		return redirect()->route('orders-ok', ['orders' => $order_ids]);
	}

	public function ok(Request $request, $orders = null)
	{
		if ($orders != null) {
			return view('/orders/ok')->with([
				'orders' => $orders
			]);
		}
	}

	public function print(Request $request, $id = null)
	{
		if ($id != null) {
			$order = Weborder::where(['id' => $id])->firstOrFail();
			$suborders = Subweborder::where(['order_id' => $id])->get();
			$payment = Webpayment::where(['id' => $order->payment])->firstOrFail();
			$delivery = Webdeliverie::where(['id' => $order->delivery])->firstOrFail();
			//dd($order);
			$firm = Firm::where(['id' => $order->firm_id])->firstOrFail();
			$data = [
				'order' => $order,
				'firm' => $firm,
				'suborders' => $suborders,
				'payment' => $payment,
				'delivery' => $delivery
			];
			$pdf = PDF::loadView('orders.print', $data);
			return $pdf->stream('document.pdf');
		}
	}

	public function deleteOrder(Request $request)
	{
		if ($request->isMethod('post') && $request->input('id') != null) {
			$user = Auth::user();
			if (!empty($user)) {
				Weborder::where(['id' => $request->input('id')])->where(['user_id' => $user->id])->delete();
				$orders = Weborder::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();
				$properties = PropertiesController::getAllProperties()->first();
				return view('orders')->with([
					'orders' => $orders,
					'properties' => $properties
				]);
			}
		}
	}

	public function payOrder(Request $request, $id = null, $paypal_id = null)
	{
		if (($id != null) && ($paypal_id != null)) {
			$user = Auth::user();
			if (!empty($user)) {
				$order = Weborder::where(['id' => $id])->where(['user_id' => $user->id])->first();
			} else {
				$order = Weborder::where(['id' => $id])->where(['user_id' => 0])->first();
			}
			if (!empty($order)) {
				$order->status = "platena";
				$order->paypal_id = $paypal_id;
				$order->save();
				return response()->json(['result' => 'success']);
			} else {
				return response()->json(['result' => 'unsuccess']);
			}
		}
	}
}
