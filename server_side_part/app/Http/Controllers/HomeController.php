<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        
        $popularProducts = Product::with('images')
            ->inRandomOrder()
            ->take(8)
            ->get();

        
        $newProducts = Product::with('images')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        $randomProduct = Product::with('images')->inRandomOrder()->first();


        return view('home-page', compact('popularProducts', 'newProducts', 'randomProduct'));

    }
}