<?php
	
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webpage;

class WebpagesController extends Controller
{
    public static function getAllPages(){
		$pages = Webpage::all();
		return $pages;
	}
	
	public static function getAboutPage(){
		$page = Webpage::where('type', 0)->first();
		return $page;
	}

	public static function getContactPage(){
		$page = Webpage::where('type', 1)->first();
		return $page;
	}
	
	public static function getSitemapPage(){
		$page = Webpage::where('type', 2)->first();
		return $page;
	}
	
	public static function getTermsPage(){
		$page = Webpage::where('type', 3)->first();
		return $page;
	}
	
	public static function getPolitikaPage(){
		$page = Webpage::where('type', 4)->first();
		return $page;
	}
	
	public static function getDostavkaPage(){
		$page = Webpage::where('type', 5)->first();
		return $page;
	}
	
	public static function getVrashtanePage(){
		$page = Webpage::where('type', 6)->first();
		return $page;
	}
}
