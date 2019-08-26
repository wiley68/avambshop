<?php

namespace App\Http\Controllers;

use App\Webdeliverie;

class WebdeliveriesController extends Controller
{
    public static function getDeliveries(){
		$deliveries = Webdeliverie::all();
		return $deliveries;
	}
	
	public static function getDeliveriesByFirm($firm_id){
		$deliveries_byfirm = Webdeliverie::where([['firm_id', '=', $firm_id],['ison', '=', 'Yes'],])->get();
		return $deliveries_byfirm;
	}
	
	public static function getDeliveriesById($delivery_id){
		$delivery_byid = Webdeliverie::where([['id', '=', $delivery_id],])->get();
		return $delivery_byid;
	}

}
