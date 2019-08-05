<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriesProducts;

class CategoriesProductsController extends Controller
{
    public static function getCategoryById($category_id){
        $categories = CategoriesProducts::where('id', $category_id)->get();
        return $categories;
    }

    public static function getCategories(){
        $categories = CategoriesProducts::all();
        return $categories;
    }
}
