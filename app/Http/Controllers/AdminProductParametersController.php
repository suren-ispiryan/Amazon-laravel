<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Size;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class AdminProductParametersController extends Controller
{
    public  function addCategory(Request $request)
    {
        $category = Category::create([
            'category' => $request->category
        ]);
        return response()->json($category);
    }

    public function getProductCategories()
    {
        try {
            $categories = Category::get();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function removeProductCategories($id)
    {
        $category = Category::where('id', $id)->first();
        Category::where('id', $id)->delete();
        return response()->json($category);
    }

    public  function addSize(Request $request)
    {
        $size = Size::create([
            'size' => $request->size
        ]);
        return response()->json($size);
    }

    public function getProductSizes()
    {
        $size = Size::get();
        return response()->json($size);
    }

    public function removeProductSizes($id)
    {
        $size = Size::where('id', $id)->first();
        Size::where('id', $id)->delete();
        return response()->json($size);
    }

    public function addSubCategory(Request $request)
    {
        $cat = Category::where('category', $request->parentCategory)->first();

        $subcategory = Subcategory::create([
            'category_id' => $cat->id,
            'subcategory' => $request->subCategory
        ]);
        $subcategory = Subcategory::with('category')
                                  ->where('id', $subcategory->id)
                                  ->first();
        return response()->json($subcategory);
    }

    public function getProductSubCategories() {
        $subcategories = Subcategory::with('category')->get();
        return response()->json($subcategories);
    }

    public function removeProductSubCategories($id) {
        $subcategories = Subcategory::with('category')
                                    ->where('id', $id)
                                    ->first();
        Subcategory::where('id', $id)->delete();
        return response()->json($subcategories);
    }
}
