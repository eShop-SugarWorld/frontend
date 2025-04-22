<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Image;

class ProductController extends Controller
{

    public function searchResults(Request $request)
    {
        $query = Product::with('images');

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
        return view('product.show', compact('product'));
    }

}
