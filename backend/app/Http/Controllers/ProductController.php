<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function showBySlug($slug)
    {
        $product = Product::where('slug_product', $slug)->firstOrFail();

        return response()->json($product);
    }

    public function store(CreateProductRequest $request)
    {
        $imagePath = $request->file('file')->store('public/upload/product');

        $product = new Product();
        $product->name = $request->input('name');
        $product->slug_product = Str::slug($request->input('name'));
        $product->image_product = $imagePath;
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->countInStock = $request->input('countInStock');
        $product->save();

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $imagePath = $product->image_product;

        if ($request->hasFile('image')) {
            $image = $request->file("image");
            $imagePath = $image->store('public/upload/product');

            if ($product->image_product) {
                Storage::delete($product->image_product);
            }

            $product->image_product = $imagePath;
        }

        $product->name = $request->input('name');
        $product->slug_product = Str::slug($request->input('name'));
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->countInStock = $request->input('countInStock');
        $product->save();

        return response()->json($product);
    }

    public function updateQuantity(Request $request)
    {
        $cart = $request->input('cart');

        if (!$cart || count($cart) === 0) {
            return response()->json('No cart data received', 400);
        }

        foreach ($cart as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];

            $product = Product::findOrFail($productId);
            $currentStock = $product->countInStock;
            $newStock = $currentStock - $quantity;

            $product->countInStock = $newStock;
            $product->save();
        }

        return response()->json('Product quantities updated', 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_product) {
            Storage::delete($product->image_product);
        }
        $product->delete();

        return response()->json(null, 204);
    }
}
