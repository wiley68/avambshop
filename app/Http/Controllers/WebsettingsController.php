<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Websetting;

class WebsettingsController extends Controller
{
    public static function getAllSettings(){
		$settings = Websetting::all();
		return $settings;
	}
}
