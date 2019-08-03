<?php

namespace App\Http\Controllers;

use App\Webad;
use Illuminate\Http\Request;

class WebadsController extends Controller
{
    public static function getAd1(){
		$ad = Webad::where('type', 1)->first();
		return $ad;
	}
    public static function getAd2(){
		$ad = Webad::where('type', 2)->first();
		return $ad;
	}
    public static function getAd3(){
		$ad = Webad::where('type', 3)->first();
		return $ad;
	}

}
