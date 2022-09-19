<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

class CartController extends Controller
{
    public function addToCart ($id, $count)
    {
        $item = Cart::create([
            'user_id' => auth()->user()->id,
            'product_id' => $id,
            'product_count' => $count,
        ]);

        $fullAddedData = Cart::with('user')
                             ->with('product')
                             ->where('product_id', $id)
                             ->first();
        return response()->json($fullAddedData);
    }

    public function getFromCart ()
    {
        $allFromCart = Cart::with('user')
                           ->with('product')
                           ->where('user_id', auth()->user()->id)
                           ->get();
        $chosen = [];
        foreach ($allFromCart as $checked) {
            $fromOrder = Order::with('cart')
                              ->where('cart_id', $checked->id)
//                              ->where('product_count', $checked->product_count)
                              ->where('customer_id', auth()->user()->id)
                              ->get();
            if (count($fromOrder) === 0) {
                array_push($chosen, $checked);
            }
        }
        return response()->json($chosen);
    }

    public function removeFromCart ($id)
    {
        $removedItem = Cart::with('user')
                           ->with('product')
                           ->where('user_id', auth()->user()->id)
                           ->where('product_id', $id)
                           ->first();
        $removedItem->update([
            'product_count' => 0
        ]);
        $removedItem->delete();

        return response()->json($removedItem);
    }

    public function getGuestCartProducts (Request $request)
    {
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

    public function buyProductsFromCart ()
    {
        // all cart products
        $cartProducts = Cart::with('product')
                            ->with('user')
                            ->where('user_id', auth()->user()->id)
                            ->get();
        foreach ($cartProducts as $cartProduct) {
            // check if cart product exists in orders
            $inOrder = Order::where('cart_id', $cartProduct->id)->get();
            if (count($inOrder) === 0) {
                $order = Order::with('cart')->create([
                    'cart_id' => $cartProduct->id,
                    'owner_id' => $cartProduct->product->user->id,
                    'customer_id' => auth()->user()->id,
                    'product_count' => $cartProduct->product_count,
                    'price' => $cartProduct->product->price,
                    'address' => $cartProduct->user->addresses->where('default', 1)[0]->id,
                    'product_id' => $cartProducts->product->id
                ]);
                // in stock minus
                $p = Product::where('id', $order->cart->product_id)->first();
                Product::where('id', $order->cart->product_id)->update([
                    'in_stock' => $p->in_stock - $cartProduct->product_count
                ]);
            }
        }
        return response()->json(Cart::where('user_id', auth()->user()->id)->get());
    }

    public function getOrderedProducts ()
    {
        $orderedProducts = Order::with('cart')
                                ->with('cart.user')
                                ->with('cart.product')
                                ->with('cart.user.addresses')
                                ->where('customer_id', auth()->user()->id)
                                ->get();
        return response()->json($orderedProducts);
    }

    public function reduceCount ($id)
    {
        $prod = Cart::where('user_id', auth()->user()->id)
                    ->where('product_id', $id)
                    ->first();
        if ($prod->product_count > 1) {
            $prod->decrement('product_count');
        } else {
            $prod->delete();
        }
        return response()->json($prod);
    }

    public function addCount ($id)
    {
        $prod = Cart::where('user_id', auth()
                    ->user()->id)
                    ->where('product_id', $id)
                    ->first();
        $total = Product::where('id', $id)->first();
        if ($prod->product_count < $total->in_stock) {
            $prod->increment('product_count');
        }
        return response()->json($prod);
    }
}
