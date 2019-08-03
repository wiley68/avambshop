<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Web_straniciController extends Controller
{
    public static function getAllWeb_stranici(){
		$stranici = Web_stranic::all();
		return $stranici;
	}
}
