<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

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
        $chosen = [];
        foreach ($allFromCart as $checked) {
            $fromOrder = Order::where('cart_id', $checked->id)
                              ->where('product_count', $checked->product_count)
                              ->where('customer_id', auth()->user()->id)
                              ->get();
            if (count($fromOrder) === 0) {
                array_push($chosen, $checked);
            }
        }
        return response()->json($chosen);
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
        $cartProducts = Cart::with('product')
                            ->with('user')
                            ->where('user_id', auth()->user()->id)
                            ->get();
        foreach ($cartProducts as $cartProduct) {
            $fromOrder = Order::where('cart_id', $cartProduct->id)
                              ->where('customer_id', auth()->user()->id)
                              ->get();
            if (count($fromOrder) === 0) {
                $order = Order::create([
                    'cart_id' => $cartProduct->id,
                    'owner_id' => $cartProduct->product->user->id,
                    'customer_id' => auth()->user()->id,
                    'product_count' => $cartProduct->product_count,
                    'price' => $cartProduct->product->price,
                    'address'=> $cartProduct->user->addresses->where('default', 1)[0]->id
                ]);
            } else {
                Order::where('cart_id', $cartProduct->id)->update([
                    'product_count' => $cartProduct->product_count
                ]);
            }
        }
        return response()->json(Cart::where('user_id', auth()->user()->id)->get());
    }

    public function getOrderedProducts () {
        $orderedProducts = Order::with('cart')
                                ->with('cart.user')
                                ->with('cart.product')
                                ->with('cart.user.addresses')
                                ->where('owner_id', auth()->user()->id)
                                ->get();
        return response()->json($orderedProducts);
    }
}
