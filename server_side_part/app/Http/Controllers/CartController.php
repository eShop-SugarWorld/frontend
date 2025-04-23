<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function init()
    {
        $cartItems = [];
        $subtotal = 0;
        $shipping = 5.00; 
        $tax = 3.00; 
        $total = 0;

        if (Auth::check()) {

            $cartItems = Cart::where('user_id', Auth::id())->with('product.images')->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        } else {

            $cart = session()->get('cart', []);
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->with('images')->get();

            foreach ($products as $product) {
                $cartItems[] = (object) [
                    'product' => $product,
                    'quantity' => $cart[$product->id],
                ];
            }

            $subtotal = collect($cartItems)->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        }

        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function updateQuantity(Request $request, $productId)
    {
        $quantity = max(1, (int)$request->input('quantity')); // Не дозволяємо кількість менше 1

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('product_id', $productId)
                            ->first();

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId] = $quantity;
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart')->with('success', 'Quantity updated!');
    }

    public function removeFromCart($productId)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart')->with('success', 'Product removed from cart!');
    }
    public function checkout()
    {
        $cartItems = [];
        $subtotal = 0;
        $shipping = 5.00;
        $tax = 3.00;
        $total = 0;

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product.images')->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        } else {
            $cart = session()->get('cart', []);
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->with('images')->get();

            foreach ($products as $product) {
                $cartItems[] = (object) [
                    'product' => $product,
                    'quantity' => $cart[$product->id],
                ];
            }

            $subtotal = collect($cartItems)->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        }

        $total = $subtotal + $shipping + $tax;

        return view('cart.checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function placeOrder(Request $request)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }

        return redirect()->route('cart.init')->with('success', 'Order placed successfully!');
    }
}