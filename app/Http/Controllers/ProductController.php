<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Like;
use App\Models\Subcategory;
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
        try {
            $file = $request->picture;
            // add image to laravel folder
            if ($file) {
                $image_name = 'product'.Carbon::now()->timestamp.'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('assets/product_images');
                $file->move($destinationPath,$image_name);
            }

            $product = Product::create([
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'brand' => $request->brand,
                'price' => $request->price,
                'color' => $request->color,
                'size' => $request->size,
                'category' => $request->category,
                'subcategory' => $request->subcategory !== 'undefined'
                              && $request->subcategory !== null
                                 ? $request->subcategory
                                 : $request->category,
                'picture' => $image_name,
                'in_stock' => $request->in_stock,
                'published' => 0
            ]);
            if ($product) {
                $created_product = Product::with('user')
                                          ->with('orders')
                                          ->where('name', $request->name)
                                          ->where('description', $request->description)
                                          ->first();
                return response()->json($created_product);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getAuthUserProducts()
    {
        try {
            $products = Product::with('user')
                               ->with('orders')
                               ->where('user_id', Auth::user()->id)
                               ->get();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function deleteAuthUserProducts ($id)
    {
        $product_image = Product::where('id', $id)->first();
        if ($product_image->picture) {
            $file_path = public_path().'/assets/product_images/'.$product_image->picture;
            unlink($file_path);
        }
        Product::where('id', $id)->delete();
        return response()->json($id);
    }

    public function deleteProductImage($id) {
        $product_image = Product::where("id", $id)->first();
        Product::where("id", $id)->update([
            'picture' => null
        ]);
        $file_path = public_path().'/assets/product_images/'.$product_image->picture;
        unlink($file_path);

        $deleted_product_image = Product::with('user')
                                        ->with('orders')
                                        ->where('id', $id)
                                        ->first();
        return response()->json($deleted_product_image);
    }

    public function updateProductData ($id)
    {
        $updated_product = Product::with('user')
                                  ->where('id', $id)
                                  ->first();
        return response()->json($updated_product);
    }

    public function updateProduct (UpdateProductRequest $request)
    {
        $file = $request->picture;
        if(file_exists($file)){
            // delete old product picture
            $product = Product::with('orders')->where('id', $request->id)->first();
            $f = public_path().'/assets/product_images/'.$product->picture;
            if ($product->picture) {
                unlink($f);
            }
            // add new product picture
            $image_name = 'product'.Carbon::now()->timestamp.'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('assets/product_images');
            $file->move($destinationPath,$image_name);
            Product::where('id', $request->id)
                   ->update([
                       'picture' => $image_name
                   ]);
        } else {
            $product = Product::where('id', $request->id)->first();
            Product::where('id', $request->id)
                   ->update([
                       'picture' => $product->picture
                   ]);
        }

        Product::where('id', $request->id)->update([
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

        $updated_product = Product::with('user')
                                  ->with('orders')
                                  ->where('name', $request->name)
                                  ->where('description', $request->description)
                                  ->first();
        return response()->json($updated_product);
    }

    public function publishProduct ($id)
    {
        $product = Product::with('orders')
                          ->where('id', $id)
                          ->first();
        if ($product->published === 0) {
            $product->update([
                'published' => 1
            ]);
        } else {
            $product->update([
                'published' => 0
            ]);
        }
        return response()->json($product);
    }

    public function getSubcategories ($category_name)
    {
        try {
            $category = Category::where('category', $category_name)->first();
            $categoryId = $category->id;

            $subcategories = Subcategory::where('category_id', $categoryId)->get();
            return response()->json($subcategories);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function likeProduct($id)
    {
        $like = Like::where('user_id', Auth::user()->id)
                    ->where('likeable_id', $id)
                    ->where('likeable_type', Product::class)
                    ->first();

        if (!$like) {
            $like = Like::create([
                'likeable_id' => $id,
                'likeable_type' => Product::class,
                'user_id' => Auth::user()->id,
                'count' => 1
            ]);

            $like->where('likeable_type', Product::class)
                 ->where('likeable_id', $id)
                 ->get();
            return response()->json($like);
        }
        return response()->json('Failure');
    }

    public function unlikeProduct($id)
    {
        $product = Like::where('user_id', Auth::user()->id)
                       ->where('likeable_id', $id)
                       ->where('likeable_type', Product::class)
                       ->first();
        if ($product) {
            $product->delete();
            return response()->json($product);
        }
        return response()->json('Failure');
    }

    public function getProductLike($id)
    {
        $product_likes = Like::where('likeable_type', Product::class)
                             ->where('likeable_id', $id)
                             ->get();
        return response()->json($product_likes);
    }
}

