<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webslider;

class WebslidersController extends Controller
{
    public static function getSlide1(){
		$slide = Webslider::where('type', 1)->first();
		return $slide;
	}
    public static function getSlide2(){
		$slide = Webslider::where('type', 2)->first();
		return $slide;
	}
    public static function getSlide3(){
		$slide = Webslider::where('type', 3)->first();
		return $slide;
	}
}
