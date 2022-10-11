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
        Cart::create([
            'user_id' => auth()->user()->id,
            'product_id' => $id,
            'product_count' => $count,
        ]);

        $full_added_data = Cart::with('user')
                               ->with('product')
                               ->where('product_id', $id)
                               ->first();
        return response()->json($full_added_data);
    }

    public function getFromCart ()
    {
        try {
            $all_from_cart = Cart::with('user')
                                 ->with('product')
                                 ->where('user_id', auth()->user()->id)
                                 ->get();
            $chosen = [];
            foreach ($all_from_cart as $checked) {
                $from_order = Order::with('cart')
                                   ->where('cart_id', $checked->id)
    //                               ->where('product_count', $checked->product_count)
                                   ->where('customer_id', auth()->user()->id)
                                   ->get();
                if (count($from_order) === 0) {
                    array_push($chosen, $checked);
                }
            }
            return response()->json($chosen);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function removeFromCart ($id)
    {
        $removed_item = Cart::with('user')
                            ->with('product')
                            ->where('user_id', auth()->user()->id)
                            ->where('product_id', $id)
                            ->first();
        $removed_item->update([
            'product_count' => 0
        ]);
        $removed_item->delete();

        return response()->json($removed_item);
    }

    public function getGuestCartProducts (Request $request)
    {
        $ids = $request->guestCartProducts;
        $user_added_products = [];
        foreach ($ids as $id) {
            $data = Product::with('user')
                           ->where('id', $id)
                           ->first();
            array_push($user_added_products, $data);
        }

        return response()->json($user_added_products);
    }

    public function buyProductsFromCart ()
    {
        // all cart products
        $cart_products = Cart::with('product')
                             ->with('user')
                             ->where('user_id', auth()->user()->id)
                             ->get();
        foreach ($cart_products as $cart_product) {
            // check if cart product exists in orders
            $inOrder = Order::where('cart_id', $cart_product->id)->get();
            if (count($inOrder) === 0) {
                $order = Order::with('cart')->create([
                    'cart_id' => $cart_product->id,
                    'owner_id' => $cart_product->product->user->id,
                    'customer_id' => auth()->user()->id,
                    'product_count' => $cart_product->product_count,
                    'price' => $cart_product->product->price,
                    'address' => $cart_product->user->addresses->where('default', 1)[0]->id,
                    'product_id' => $cart_products->product->id
                ]);
                // in stock minus
                $p = Product::where('id', $order->cart->product_id)->first();
                Product::where('id', $order->cart->product_id)->update([
                    'in_stock' => $p->in_stock - $cart_product->product_count
                ]);
            }
        }
        return response()->json(Cart::where('user_id', auth()->user()->id)->get());
    }

    public function getOrderedProducts ()
    {
        $ordered_products = Order::with('cart')
                                 ->with('cart.user')
                                 ->with('cart.product')
                                 ->with('cart.user.addresses')
                                 ->where('customer_id', auth()->user()->id)
                                 ->get();
        return response()->json($ordered_products);
    }

    public function reduceCount ($id)
    {
        $product = Cart::where('user_id', auth()->user()->id)
                       ->where('product_id', $id)
                       ->first();
        if ($product->product_count > 1) {
            $product->decrement('product_count');
        } else {
            $product->delete();
        }
        return response()->json($product);
    }

    public function addCount ($id)
    {
        $product = Cart::where('user_id', auth()->user()->id)
                       ->where('product_id', $id)
                       ->first();
        $total = Product::where('id', $id)->first();
        if ($product->product_count < $total->in_stock) {
            $product->increment('product_count');
        }
        return response()->json($product);
    }
}
