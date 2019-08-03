<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subweborder;

class SubwebordersController extends Controller
{
    public static function getSubwebordersByWeborderId($weborder_id){
		$sub_weborders = Subweborder::where('order_id', $weborder_id)->get();
		return $sub_weborders;
	}
}
