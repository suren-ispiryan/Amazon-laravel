<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;

use Illuminate\Http\Request;

class AllProductsController extends Controller
{
    public function getAllUsersPosts (Request $request) {
        $allProducts = Product::with('user')->get();
        return response()->json($allProducts);
    }
}
