<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createProduct (Request $request) {
        $file = $request->picture;
        // add image to laravel folder
        if($file){
            $image_name = 'product'.Carbon::now()->timestamp.'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('assets/product_images');
            $file->move($destinationPath,$image_name);
        }

        $Product = Product::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'brand' => $request->brand,
            'price' => $request->price,
            'color' => $request->color,
            'size' => $request->size,
            'category' => $request->category,
            'picture' => $image_name
        ]);
        if ($Product) {
            return response('product successfully created');
        }
    }

    public function getAuthUserProducts() {
        $products = Product::with('user')->get();
        return response()->json($products);
    }

    public function deleteAuthUserProducts ($id) {
        $ProductImage = Product::where('id', $id)->first();
        $file_path = public_path().'/assets/product_images/'.$ProductImage->picture;
        unlink($file_path);
        Product::where('id', $id)->delete();
        return response('success');
    }

    public function updateProductData ($id) {
        $updatedProduct = Product::with('user')->where('id', $id)->first();
        return response()->json($updatedProduct);
    }

    public function updateProduct (Request $request) {
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
        Product::where('id', $request->id)->update([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'brand' => $request->brand,
            'price' => $request->price,
            'color' => $request->color,
            'size' => $request->size,
            'category' => $request->category
        ]);
        return response()->json('product successfully created');
    }
}
