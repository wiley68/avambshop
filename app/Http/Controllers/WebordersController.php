<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weborder;
use App\Subweborder;
use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;

class WebordersController extends Controller
{
    public function submit(Request $request){
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
        
        if (isset($cart_session)){
		//generate orders
		$order_number = 0;
		foreach ($cart_session['firms'] as $firm){
			$order = new Weborder;
			$order->dateon = date('Y-m-d H:i:s');
			$order->user_id = $request->input('user_id');
			$order->name = $request->input('name');
			$order->email = $request->input('email');
			$order->phone = $request->input('phone');
			$order->city = $request->input('city');
			$order->postalcod = $request->input('postalcod');
			$order->address = $request->input('address');
			if ($request->input('isfirma') == "Yes"){
				$order->isfirma = "Yes";
			}else{
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
			$order->payment = $request->input('paymentMethods'.$firm['firm_id']);
			//get delivery for this order
			$order->delivery = $request->input('deliverieMethods'.$firm['firm_id']);
			$order->status = "obrabotka";
			//get allprice for this order
			$order->allprice = $request->input('grand_total_price'.$firm['firm_id']);
			$order->firm_id = $firm['firm_id'];
			//save order
			$order->save();
			$last_id = $order->id;			
			$orders[$order_number]['order'] = $order;
			
			//save order details
			if (isset($firm['items'])){
				foreach ($firm['items'] as $item){
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
			$objMail->app_name = env('APP_NAME','AVAMB Logiciel');
			$objMail->order_id = $last_id;
			$objMail->order_date = $order->dateon;
			$objMail->allprice = $order->allprice;
			$objMail->payment = $order->payment;
			$objMail->firm_id = $order->firm_id;
			if (isset($firm['items'])){
				$objMail->items = $firm['items'];
			}else{
				$objMail->items = null;
			}
			$objMail->sender = env('MAIL_USERNAME','AVAMB Logiciel');
            $objMail->receiver = $order->name;
            $objMail->isadmin = 'No';
 
			Mail::to($order->email)->send(new OrderEmail($objMail));

			//to admin
			$objMailAdmin = new \stdClass();
			$objMailAdmin->app_name = env('APP_NAME','AVAMB Logiciel');
			$objMailAdmin->order_id = $last_id;
			$objMailAdmin->order_date = $order->dateon;
			$objMailAdmin->allprice = $order->allprice;
			$objMailAdmin->payment = $order->payment;
			$objMailAdmin->firm_id = $order->firm_id;
			if (isset($firm['items'])){
				$objMailAdmin->items = $firm['items'];
			}else{
				$objMailAdmin->items = null;
			}
			$objMailAdmin->sender = env('MAIL_USERNAME','AVAMB Logiciel');
            $objMailAdmin->receiver = 'Администратор AVAMB Logiciel';
            $objMailAdmin->isadmin = 'Yes';
 
			Mail::to(env('MAIL_USERNAME','home@avalonbg.com'))->send(new OrderEmail($objMailAdmin));
			
			$order_number++;
		}
		//generate orders

		$request->session()->forget('cart_session');
        }
		
		return view('orders/ok', ['orders' => $orders]);
	}
	
}
