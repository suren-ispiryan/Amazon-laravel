<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function createProduct (CreateProductRequest $request)
    {
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
            'picture' => $image_name,
            'in_stock' => $request->in_stock,
            'published' => 0
        ]);
        if ($Product) {
            $p = Product::with('user')
                        ->where('name', $request->name)
                        ->where('description', $request->description)
                        ->first();
            return response()->json($p);
        }
    }

    public function getAuthUserProducts()
    {
        $products = Product::with('user')->where('user_id', Auth::user()->id)->get();
        return response()->json($products);
    }

    public function deleteAuthUserProducts ($id)
    {
        $ProductImage = Product::where('id', $id)->first();
        if ($ProductImage->picture) {
            $file_path = public_path().'/assets/product_images/'.$ProductImage->picture;
            unlink($file_path);
        }
        Product::where('id', $id)->delete();
        return response()->json($id);
    }

    public function updateProductData ($id)
    {
        $updatedProduct = Product::with('user')->where('id', $id)->first();
        return response()->json($updatedProduct);
    }

    public function updateProduct (UpdateProductRequest $request)
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
                'in_stock' => $request->in_stock
        ]);
        if ($p) {
            $updatedProduct = Product::with('user')
                ->where('name', $request->name)
                ->where('description', $request->description)
                ->first();
            return response()->json($updatedProduct);
        }
    }

    public function publishProduct ($id) {
        $prod = Product::where('id', $id)->first();
        if ($prod->published === 0) {
            $prod->update([
                'published' => 1
            ]);
        } else {
            $prod->update([
                'published' => 0
            ]);
        }
        return response()->json($prod);
    }
}
