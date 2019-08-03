<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subdeliverie;

class SubdeliveriesController extends Controller
{
    public static function getSubdeliveriesByDelivery($delivery_id, $total_kg){
		$subdeliveries_bydelivery = Subdeliverie::where([['delivery_id', '=', $delivery_id],['fromkg', '<=', $total_kg],['tokg', '>=', $total_kg],])->get();
		return $subdeliveries_bydelivery;
	}
}
