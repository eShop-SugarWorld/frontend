<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Cart;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
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

        return redirect()->route('detail-of-product', $product->id)->with('success', 'Product created!');
    }

    public function searchResults()
    {
        //$products = Product::with('images')->get();  // Отримуємо продукти з їх зображеннями
        $products = Product::with('images')->paginate(6);
        return view('search-results', compact('products'));  // Передаємо продукти в view
    }
    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $recommendedProducts = $this->getRandomRecommendedProducts($id); // Передаємо $id, щоб виключити поточний продукт
        return view('detail-of-product', compact('product', 'recommendedProducts'));
    }
    protected function getRandomRecommendedProducts($excludeId = null)
    {
        $query = Product::with('images')->inRandomOrder();
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId); 
        }

        return $query->take(3)->get();
    }
    public function addToCart(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1); 

        if (Auth::check()) {
            $user = Auth::user();
            $cartItem = Cart::where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $cart = session()->get('cart', []); 
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }
}
