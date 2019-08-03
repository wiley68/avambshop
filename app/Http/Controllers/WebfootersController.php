<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webfooter;

class WebfootersController extends Controller
{
    public static function getWebfooter(){
		$pages = Webfooter::all()->first();
		return $pages;
	}
}
