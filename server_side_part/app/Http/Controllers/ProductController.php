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

    public function searchResults(Request $request)
    {
        $query = Product::with('images');

        if ($request->filled('query')) {
            $search = strtolower($request->input('query'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
            });
        }


    

        if ($request->filled('sortPrice')) {
            $sort = $request->input('sortPrice') === 'desc' ? 'desc' : 'asc';
            $query->orderBy('price', $sort);
        }

        if ($request->filled('sweet_type')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('name', $request->input('sweet_type'));
            });
        }
        if ($request->filled('event_type')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('name', $request->input('event_type'));
            });
        }
        if ($request->filled('minPrice') && $request->filled('maxPrice')) {
            $query->whereBetween('price', [$request->minPrice, $request->maxPrice]);
        }

        $products = $query->paginate(6)->appends($request->all());

        return view('search-results', compact('products'));

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

        return redirect()->route('detail-of-product', $productId)
                         ->with('success', 'Product added to cart successfully!');
    }
}
