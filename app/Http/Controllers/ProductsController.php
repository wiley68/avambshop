<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Controllers\FirmsController;

class ProductsController extends Controller
{
    public static function getAllProducts(){
        $firms_id = FirmsController::getFirmsByIsshop();
		$products = Product::whereIn('firm_id', $firms_id)->where('isshop', '>', 0)->get();
		return $products;
	}

    public static function getProducts(){
        $firms_id = FirmsController::getFirmsByIsshop();
		$products = Product::whereIn('firm_id', $firms_id)->where('isshop', '>', 0)->orderBy('name')->paginate(9);
		return $products;
	}

	public static function getProductsByFirm($firm_id){
        $firms_id = FirmsController::getFirmsByIsshop();
		$products = Product::whereIn('firm_id', $firms_id)->where('firm_id', $firm_id)->where('isshop', '>', 0)->paginate(9);
		return $products;
    }
    
    public static function getProductsByCategory($category_id){
		$products = Product::where('category_id', $category_id)->where('isshop', '>', 0)->paginate(9);
		return $products;
	}

	public static function getProductsByTermin($termin){
		$firms_id = FirmsController::getFirmsByIsshop();
		$products = Product::whereIn('firm_id', $firms_id)
			->where('name', 'like', '%'.$termin.'%')
			->orWhere('code', 'like', '%'.$termin.'%')
			->where('isshop', '>', 0)
			->paginate(9);
		return $products;
	}

	public static function getProductsRandom($nomber){
        $firms_id = FirmsController::getFirmsByIsshop();
		$product_count = Product::whereIn('firm_id', $firms_id)->where('isshop', '>', 0)->count();
		if ($product_count > $nomber){
			$product_count = $nomber;
		}
		$products = Product::whereIn('firm_id', $firms_id)->where('isshop', '>', 0)->get()->random($product_count);
		return $products;
	}

	public static function getProductsByFirmRandom($firm_id, $code, $nomber){
        $firms_id = FirmsController::getFirmsByIsshop();
		$products = Product::whereIn('firm_id', $firms_id)->where([['firm_id', '=', $firm_id],['code', '<>', $code],['isshop', '>', 0],])->inRandomOrder()->limit($nomber)->get();
		return $products;
	}

	public static function getProductById($pid){
		$product = Product::where('code', $pid)->first();
		return $product;
	}

}
