<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webhome;

class WebhomesController extends Controller
{
    public static function getWebhome(){
		$pages = Webhome::all()->first();
		return $pages;
	}
}
