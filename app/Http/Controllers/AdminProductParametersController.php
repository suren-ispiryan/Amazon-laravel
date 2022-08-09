<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class AdminProductParametersController extends Controller
{
    public  function addCategory(Request $request) {
        $category = Category::create([
            'category' => $request->category
        ]);
        return response()->json($category);
    }

    public function getProductCategories() {
        $categories = Category::get();
        return response()->json($categories);
    }

    public function removeProductCategories($id) {
        $category = Category::where('id', $id)->first();
        Category::where('id', $id)->delete();
        return response()->json($category);
    }

    public  function addSize(Request $request) {
        $size = Size::create([
            'size' => $request->size
        ]);
        return response()->json($size);
    }

    public function getProductSizes() {
        $size = Size::get();
        return response()->json($size);
    }

    public function removeProductSizes($id) {
        $size = Size::where('id', $id)->first();
        Size::where('id', $id)->delete();
        return response()->json($size);
    }
}
