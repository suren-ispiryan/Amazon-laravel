<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart ($id) {
        $item = Cart::where('user_id', auth()->user()->id)
                    ->where('product_id', $id)
                    ->first();
        if ($item) {
            $item->increment('product_count');
        } else {
            $item = Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $id,
                'product_count' => 1,
            ]);
        }
        $fullAddedData = Cart::with('user')
                             ->with('product')
                             ->where('product_id', $id)
                             ->first();
        return response()->json($fullAddedData);
    }

    public function getFromCart () {
        $allFromCart = Cart::with('user')
                           ->with('product')
                           ->where('user_id', auth()->user()->id)
                           ->get();
        return response()->json($allFromCart);
    }

    public function removeFromCart ($id) {
        $removedItem = Cart::with('user')
                           ->with('product')
                           ->where('user_id', auth()->user()->id)
                           ->where('product_id', $id)
                           ->first();
        if ($removedItem->product_count > 1) {
            $removedItem->decrement('product_count');
        } else {
            $removedItem->decrement('product_count');
            $removedItem->delete();
        }
        return response()->json($removedItem);
    }

    public function getGuestCartProducts (Request $request) {
        $ids = $request->guestCartProducts;
        $userAddedProducts = [];
        foreach ($ids as $id) {
            $data = Product::with('user')
                           ->where('id', $id)
                           ->first();
            array_push($userAddedProducts, $data);
        }

        return response()->json($userAddedProducts);
    }

    public function buyProductsFromCart () {


        return response()->json(123);
    }
}
