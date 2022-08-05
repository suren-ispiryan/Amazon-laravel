<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrdersController extends Controller
{
    public function getAllOrderedProducts () {
        $orders = Order::with('cart.product.user')->get();
        return response()->json($orders);
    }
}
