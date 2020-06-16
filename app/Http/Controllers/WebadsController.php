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
    public static function getAd4(){
		$ad = Webad::where('type', 4)->first();
		return $ad;
	}
    public static function getAd5(){
		$ad = Webad::where('type', 5)->first();
		return $ad;
	}
    public static function getAd6(){
		$ad = Webad::where('type', 6)->first();
		return $ad;
	}
    public static function getAd7(){
		$ad = Webad::where('type', 7)->first();
		return $ad;
	}
    public static function getAd8(){
		$ad = Webad::where('type', 8)->first();
		return $ad;
	}
    public static function getAd9(){
		$ad = Webad::where('type', 9)->first();
		return $ad;
	}
    public static function getAd10(){
		$ad = Webad::where('type', 10)->first();
		return $ad;
	}
}
