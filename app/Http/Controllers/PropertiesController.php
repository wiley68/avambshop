<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Propertie;

class PropertiesController extends Controller
{
    public static function getAllProperties(){
		$properties = Propertie::all();
		return $properties;
	}
}
