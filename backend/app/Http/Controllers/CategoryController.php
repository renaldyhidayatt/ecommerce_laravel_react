<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    public function showBySlug($slug)
    {
        $category = Category::where('slug_category', $slug)->with('products')->firstOrFail();

        return response()->json($category);
    }

    public function store(CreateCategoryRequest $request)
    {
        $imagePath = $request->file('image')->store('public/upload/category');

        $category = new Category();
        $category->nama_kategori = $request->input('name');
        $category->slug_category = Str::slug($request->input('name'));
        $category->image_category = $imagePath;
        $category->save();

        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        if ($request->hashFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/upload/category');

            if ($category->image_category) {
                Storage::delete($category->image_category);
            }
        }



        $category->nama_kategori = $request->input('name');
        $category->slug_category = Str::slug($request->input('name'));
        $category->image_category = $imagePath;
        $category->save();

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image_category) {
            Storage::delete($category->image_category);
        }

        $category->delete();

        return response()->json(null, 204);
    }
}
