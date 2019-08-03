<?php
	
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webpayment;

class WebpaymentsController extends Controller
{
    public static function getPayments(){
		$payments = Webpayment::all();
		return $payments;
	}
	
	public static function getPaymentsByFirm($firm_id){
		$payments_byfirm = Webpayment::where([['firm_id', '=', $firm_id],['ison', '=', 'Yes'],])->get();
		return $payments_byfirm;
	}
	
	public static function getPaymentsById($payment_id){
		$payments_byid = Webpayment::where([['id', '=', $payment_id],])->get();
		return $payments_byid;
	}
}
