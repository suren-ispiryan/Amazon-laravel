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
        $allUserProducts = Product::with('user')
                                  ->with('carts.order')
                                  ->get();
        return response()->json($allUserProducts);
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
            $p = Product::where('id', $request->id)->first();
            $f = public_path().'/assets/product_images/'.$p->picture;
            unlink($f);
            // add new product picture
            $image_name = 'product'.Carbon::now()->timestamp.'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('assets/product_images');
            $file->move($destinationPath,$image_name);
            Product::where('id', $request->id)->update(['picture' => $image_name]);
        } else {
            $p = Product::where('id', $request->id)->first();
            Product::where('id', $request->id)->update(['picture' => $p->picture]);
        }
        $p = Product::where('id', $request->id)->update([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'brand' => $request->brand,
            'price' => $request->price,
            'color' => $request->color,
            'size' => $request->size,
            'category' => $request->category,
            'in_stock' => $request->inStock
        ]);
        if ($p) {
            $updatedProduct = Product::with('user')->with('carts.order')
                ->where('name', $request->name)
                ->where('description', $request->description)
                ->first();
            return response()->json($updatedProduct);
        }
    }
}
