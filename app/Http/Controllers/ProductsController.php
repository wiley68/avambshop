<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Controllers\FirmsController;
use App\Http\Controllers\CategoriesProductsController;

class ProductsController extends Controller
{
    public static function getAllProducts(){
		$firms_id = FirmsController::getFirmsByIsshop();
		$category_id = CategoriesProductsController::getCategoriesByShop();
		$products = Product::whereIn('firm_id', $firms_id)->whereIn('category_id', $category_id)->where('isshop', '>', 0)->get();
		return $products;
	}

    public static function getProducts(){
		$firms_id = FirmsController::getFirmsByIsshop();
		$category_id = CategoriesProductsController::getCategoriesByShop();
		$products = Product::whereIn('firm_id', $firms_id)->whereIn('category_id', $category_id)->where('isshop', '>', 0)->orderBy('name')->paginate(9);
		return $products;
	}

	public static function getProductsByFirm($firm_id){
		$firms_id = FirmsController::getFirmsByIsshop();
		$category_id = CategoriesProductsController::getCategoriesByShop();
		$products = Product::whereIn('firm_id', $firms_id)->whereIn('category_id', $category_id)->where('firm_id', $firm_id)->where('isshop', '>', 0)->paginate(9);
		return $products;
    }
    
    public static function getProductsByCategory($category_id){
		$products = Product::where('category_id', $category_id)->where('isshop', '>', 0)->paginate(9);
		return $products;
	}

	public static function getProductsByTermin($termin){
		$firms_id = FirmsController::getFirmsByIsshop();
		$category_id = CategoriesProductsController::getCategoriesByShop();
		$products = Product::whereIn('firm_id', $firms_id)->whereIn('category_id', $category_id)
			->where('name', 'like', '%'.$termin.'%')
			->orWhere('code', 'like', '%'.$termin.'%')
			->where('isshop', '>', 0)
			->paginate(9);
		return $products;
	}

	public static function getProductsByTerminId($termin, $id){
		$category_id = CategoriesProductsController::getCategoriesByShop();
		$products = Product::where([['name', 'like', '%'.$termin.'%'],['firm_id','=', $id]])
			->orWhere([['code','like', '%'.$termin.'%'],['firm_id','=', $id]])
			->where('isshop', '>', 0)->whereIn('category_id', $category_id)
			->paginate(9);

		return $products;
	}

	public static function getProductsRandom($nomber){
		$firms_id = FirmsController::getFirmsByIsshop();
		$category_id = CategoriesProductsController::getCategoriesByShop();
		$product_count = Product::whereIn('firm_id', $firms_id)->whereIn('category_id', $category_id)->where('isshop', '>', 0)->count();
		if ($product_count > $nomber){
			$product_count = $nomber;
		}
		$products = Product::whereIn('firm_id', $firms_id)->whereIn('category_id', $category_id)->where('isshop', '>', 0)->get()->random($product_count);
		return $products;
	}

	public static function getProductsByFirmRandom($firm_id, $code, $nomber){
		$firms_id = FirmsController::getFirmsByIsshop();
		$category_id = CategoriesProductsController::getCategoriesByShop();
		$products = Product::whereIn('firm_id', $firms_id)->whereIn('category_id', $category_id)->where([['firm_id', '=', $firm_id],['code', '<>', $code],['isshop', '>', 0],])->inRandomOrder()->limit($nomber)->get();
		return $products;
	}

	public static function getProductById($pid){
		$product = Product::where('code', $pid)->first();
		return $product;
	}

}
