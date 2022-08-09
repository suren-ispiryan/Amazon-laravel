<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class AllProductsController extends Controller
{
    public function getAllUsersProducts (Request $request)
    {
        $allProducts = Product::with('user')->get();
        return response()->json($allProducts);
    }

    public function getProductDetails (Request $request)
    {
        $productDetails = Product::with('user')->where('id', $request->id)->first();
        return response()->json($productDetails);
    }

    public function searchProduct (Request $request)
    {
        $searchedKeyword = $request->searchParameter;
        $searchResult = Product::with('user')
                               ->where('name', 'like', "%{$searchedKeyword}%")
                               ->orWhere('description', 'like', "%{$searchedKeyword}%")
                               ->get();
        return response()->json($searchResult);
    }
}
