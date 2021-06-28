<?php

namespace App\Http\Controllers;

use App\CategoriesProducts;

class CategoriesProductsController extends Controller
{
    public static function getCategoryById($category_code){
        $categories = CategoriesProducts::where('code', $category_code)->get();
        return $categories;
    }

    public static function getCategories(){
        $categories = CategoriesProducts::where('isshop', 1)->get();
        return $categories;
    }

    public static function getCategoriesByShop(){
        $categories = CategoriesProducts::select('code')->where('isshop', 1)->get();
        $categories_arr = [];
        foreach ($categories as $category) {
            $categories_arr[] = $category->code;
        }
        return $categories_arr;
    }
}
