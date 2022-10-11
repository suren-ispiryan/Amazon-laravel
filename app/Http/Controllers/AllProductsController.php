<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;

class AllProductsController extends Controller
{
    public function getAllUsersProducts (Request $request)
    {
        $all_products = Product::with('user')->get();
        $categories = Category::get();
        return response()->json(['allProducts' => $all_products, 'categories' => $categories]);
    }

    public function getProductDetails (Request $request)
    {
        try {
            $product_details = Product::with('user')
                                      ->where('id', $request->id)
                                      ->first();
            return response()->json($product_details);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function searchProduct (Request $request)
    {
        $searched_keyword = $request->searchParameter;
        $search_category = $request->searchCategory;

        if ($searched_keyword && $search_category) {
            $search_result = Product::with('user')
                                    ->where('name', 'like', "%{$searched_keyword}%")
                                    ->orWhere('description', 'like', "%{$searched_keyword}%")
                                    ->where('category', $search_category)
                                    ->get();
        } else if (!$searched_keyword && $search_category === 'all') {
            $search_result = Product::with('user')
                                    ->get();
        } else if (!$searched_keyword && $search_category) {
            $search_result = Product::with('user')
                                    ->where('category', $search_category)
                                    ->get();
        } else if ($searched_keyword && !$search_category) {
            $search_result = Product::with('user')
                                    ->where('name', 'like', "%{$searched_keyword}%")
                                    ->orWhere('description', 'like', "%{$searched_keyword}%")
                                    ->get();
        }

        return response()->json($search_result);
    }
}
