<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Image;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'ingredients' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
        ]);

        $product->categories()->attach($validated['categories']);
        $product->ingredients()->attach($validated['ingredients']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedImage) {
                $imageData = file_get_contents($uploadedImage->getRealPath());

                $image = new Image([
                    'product_id' => $product->id,
                    'image_data' => base64_encode($imageData),
                ]);

                $image->save();
            }
        }

        return redirect()->route('product.show', $product->id)->with('success', 'Product created!');
    }

    public function searchResults()
    {
//        $products = Product::with('images')->get();  // Отримуємо продукти з їх зображеннями
        $products = Product::with('images')->paginate(6);
        return view('search-results', compact('products'));  // Передаємо продукти в view
    }
    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('product.show', compact('product'));
    }

}
