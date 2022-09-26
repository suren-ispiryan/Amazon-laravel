<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;

class AllProductsController extends Controller
{
    public function getAllUsersProducts (Request $request)
    {
        $allProducts = Product::with('user')->get();
        $categories = Category::get();
        return response()->json(['allProducts' => $allProducts, 'categories' => $categories]);
    }

    public function getProductDetails (Request $request)
    {
        $productDetails = Product::with('user')
            ->where('id', $request->id)
            ->first();
        return response()->json($productDetails);
    }

    public function searchProduct (Request $request)
    {
        $searchedKeyword = $request->searchParameter;
        $searchCategory = $request->searchCategory;

        if ($searchedKeyword && $searchCategory) {
            $searchResult = Product::with('user')
                                   ->where('name', 'like', "%{$searchedKeyword}%")
                                   ->orWhere('description', 'like', "%{$searchedKeyword}%")
                                   ->where('category', $searchCategory)
                                   ->get();
        } else if (!$searchedKeyword && $searchCategory === 'all') {
            $searchResult = Product::with('user')->get();
        } else if (!$searchedKeyword && $searchCategory) {
            $searchResult = Product::with('user')
                ->where('category', $searchCategory)
                ->get();
        } else if ($searchedKeyword && !$searchCategory) {
            $searchResult = Product::with('user')
                ->where('name', 'like', "%{$searchedKeyword}%")
                ->orWhere('description', 'like', "%{$searchedKeyword}%")
                ->get();
        }

        return response()->json($searchResult);
    }
}
