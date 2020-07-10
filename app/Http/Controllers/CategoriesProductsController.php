<?php

namespace App\Http\Controllers;

use App\CategoriesProducts;

class CategoriesProductsController extends Controller
{
    public static function getCategoryById($category_id){
        $categories = CategoriesProducts::where('id', $category_id)->get();
        return $categories;
    }

    public static function getCategories(){
        $categories = CategoriesProducts::where('isshop', 1)->get();
        return $categories;
    }

    public static function getCategoriesByShop(){
        $categories = CategoriesProducts::select('id')->where('isshop', 1)->get();
        $categories_arr = [];
        foreach ($categories as $category) {
            $categories_arr[] = $category->id;
        }
        return $categories_arr;
    }
}
