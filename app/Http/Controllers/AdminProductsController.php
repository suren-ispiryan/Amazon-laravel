<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductsController extends Controller
{
    public function getAllUserData () {
        $allUserProducts = Product::with('user')
                                  ->with('carts.order')
                                  ->get();
        return response()->json($allUserProducts);
    }
}
