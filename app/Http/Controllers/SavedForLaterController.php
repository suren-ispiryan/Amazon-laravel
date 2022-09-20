<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedForLaterController extends Controller
{
    public function getSaveForLater()
    {
        $saveForLaterProducts = Auth::user()->product()->with('user')->get();
        return  response()->json($saveForLaterProducts);
    }

    public function saveForLater($id)
    {
        $productId = $id;
        $saveForLaterProducts = Auth::user()
            ->product()
            ->with('users')
            ->where('product_id', $productId)
            ->first();
        if (!$saveForLaterProducts) {
            Auth::user()->product()->with('users')->attach($productId);
            return response()->json($saveForLaterProducts);
        }
        return response()->json(null);
    }

    public function removeSaveForLater($id)
    {
        $productId = $id;
        Auth::user()->product()->with('users')->detach($productId);
        return  response()->json($id);
    }

    public function getGuestSavedForLaterProducts(Request $request)
    {
        $savedProductsIds = $request->savedProducts;
        foreach ($savedProductsIds as $id) {
            $products[] = Product::with('user')->where('id', $id)->first();
        }

        return response()->json($products);
    }
}
