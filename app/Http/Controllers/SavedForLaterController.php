<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedForLaterController extends Controller
{
    public function getSaveForLater()
    {
        $save_for_later_products = Auth::user()->product()
                                               ->with('user')
                                               ->get();
        return  response()->json($save_for_later_products);
    }

    public function saveForLater($id)
    {
        $product_id = $id;
        $save_for_later_products = Auth::user()->product()
                                               ->with('users')
                                               ->where('product_id', $product_id)
                                               ->first();
        if (!$save_for_later_products) {
            Auth::user()->product()
                        ->with('users')
                        ->attach($product_id);
            return response()->json($save_for_later_products);
        }
        return response()->json(null);
    }

    public function removeSaveForLater($id)
    {
        $product_id = $id;
        Auth::user()->product()
                    ->with('users')
                    ->detach($product_id);
        return  response()->json($id);
    }

    public function getGuestSavedForLaterProducts(Request $request)
    {
        $saved_products_ids = $request->savedProducts;
        foreach ($saved_products_ids as $id) {
            $products[] = Product::with('user')
                                 ->where('id', $id)
                                 ->first();
        }

        return response()->json($products);
    }
}
