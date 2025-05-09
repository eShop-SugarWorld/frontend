<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Support\Facades\File;


class AdminController extends Controller
{
    public function account(Request $request)
    {
        if (Auth::check() && session('is_admin') === true) {
            $search = $request->input('search');

            $products = Product::query();

            if ($search) {
                $products->where('name', 'like', '%' . $search . '%');
            }

            $products = $products->get();

            $categories = Category::all();
            $ingredients = Ingredient::all();

            return view('admin-page', compact('products','categories', 'ingredients'));
        }

        return redirect()->route('home')->with('error', 'You do not have access to the admin area.');
    }

    private function createProduct($name, $description, $price, $categoryNames, $ingredients, $imageFilenames)
    {
        $product = Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ]);

        if (!is_array($categoryNames)) {
            $categoryNames = [$categoryNames];
        }
        foreach ($categoryNames as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $product->categories()->attach($category->id);
        }

        foreach ($ingredients as $ingredientName) {
            $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
            $product->ingredients()->attach($ingredient->id);
        }

        foreach ($imageFilenames as $imageFilename) {
            $imagePath = public_path('images/' . $imageFilename);

            if (File::exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $image = new Image([
                    'product_id' => $product->id,
                    'image_data' => base64_encode($imageData),
                ]);
                $image->save();
            }
        }
    }
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'productTitle' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productPrice' => 'required|numeric|min:0',
            'productCategory' => 'required|array',
            'productCategory.*' => 'string',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageFilenames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $imageFilenames[] = $filename;
            }
        }

        $this->createProduct(
            $validated['productTitle'],
            $validated['productDescription'],
            $validated['productPrice'],
            $validated['productCategory'],
            $validated['ingredients'] ?? [],
            $imageFilenames
        );

        return redirect()->back()->with('success', '✅ Продукт успішно додано!');
    }
    public function editProduct($id)
    {
        $product = Product::with('categories', 'ingredients', 'images')->findOrFail($id);
        $categories = Category::all();
        $ingredients = Ingredient::all();

        return view('admin-update-product', compact('product', 'categories', 'ingredients'));
    }
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    $image->delete();
                }
            }
        }

        $product->name = $request->productTitle;
        $product->description = $request->productDescription;
        $product->price = $request->productPrice;

        $product->ingredients()->sync([]);
        $product->categories()->sync([]);

        if ($request->has('ingredients')) {
            $ingredientIds = Ingredient::whereIn('name', $request->ingredients)->pluck('id');
            $product->ingredients()->sync($ingredientIds);
        }

        if ($request->has('productCategory')) {
            $categoryIds = Category::whereIn('name', $request->productCategory)->pluck('id');
            $product->categories()->sync($categoryIds);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
                $product->images()->create([
                    'image_data' => $imageData,
                ]);
            }
        }

        $product->save();

        return redirect()->route('admin')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        foreach ($product->images as $image) {
            $image->delete();
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }



}
