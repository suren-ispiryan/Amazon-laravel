<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\AdminUpdateUserProductRequest;

class AdminProductsController extends Controller
{
    public function getAllUserData ()
    {
        $all_user_products = Product::with('user')
                                    ->with('carts.order')
                                    ->get();
        return response()->json($all_user_products);
    }

    public function deleteUserProduct ($id)
    {
        Product::where('id', $id)->delete();
        return response()->json($id);
    }

    public function updateUserProduct (AdminUpdateUserProductRequest $request)
    {
        $file = $request->picture;
        if(file_exists($file)){
            // delete old product picture
            $product = Product::where('id', $request->id)->first();
            $file_path = public_path().'/assets/product_images/'.$product->picture;
            unlink($file_path);
            // add new product picture
            $image_name = 'product'.Carbon::now()->timestamp.'.'.$file->getClientOriginalExtension();
            $destination_path = public_path('assets/product_images');
            $file->move($destination_path,$image_name);
            Product::where('id', $request->id)->update(['picture' => $image_name]);
        } else {
            $product = Product::where('id', $request->id)->first();
            Product::where('id', $request->id)->update(['picture' => $product->picture]);
        }
        $productUpdateData = [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'brand' => $request->brand,
            'price' => $request->price,
            'color' => $request->color,
            'size' => $request->size,
            'category' => $request->category,
            'in_stock' => $request->inStock
        ];
        $product = Product::where('id', $request->id)->update($productUpdateData);
        if ($product) {
            $updated_product = Product::with('user')
                                      ->with('carts.order')
                                      ->where('name', $request->name)
                                      ->where('description', $request->description)
                                      ->first();
            return response()->json($updated_product);
        }
    }
}
