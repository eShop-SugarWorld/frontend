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
            $products = Product::all();
            $categories = Category::all();
            $ingredients = Ingredient::all();

            return view('admin-page', compact('products','categories', 'ingredients'));
//            return view('admin-page');
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

        // Категорії
        if (!is_array($categoryNames)) {
            $categoryNames = [$categoryNames];
        }
        foreach ($categoryNames as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $product->categories()->attach($category->id);
        }

        // Інгредієнти
        foreach ($ingredients as $ingredientName) {
            $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
            $product->ingredients()->attach($ingredient->id);
        }

        // Зображення
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

        // Завантаження зображень
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

}
