<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\OrderItem;

class CartController extends Controller
{
    protected $shippingMethods = [
        'standard' => 5.00,
        'express' => 10.00,
        'pickup' => 0.00,
    ];

    public function init(Request $request)
    {
        $cartItems = [];
        $subtotal = 0;
        
        $shippingMethod = $request->session()->get('shipping_method', 'standard');
        $shipping = $this->shippingMethods[$shippingMethod];
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

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'shippingMethod'));
    }

    public function updateQuantity(Request $request, $productId)
    {
        $quantity = max(1, (int)$request->input('quantity'));

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

    public function checkout(Request $request)
    {
        $cartItems = [];
        $subtotal = 0;
        
        // Отримуємо shipping_method із параметра запиту або сесії
        $shippingMethod = $request->query('shipping_method', $request->session()->get('shipping_method', 'standard'));
        
        // Валідація методу доставки
        $validMethods = array_keys($this->shippingMethods);
        if (!in_array($shippingMethod, $validMethods)) {
            $shippingMethod = 'standard';
            \Log::warning('Invalid shipping method in request, defaulting to standard', ['invalid_method' => $shippingMethod]);
        }

        // Оновлюємо сесію
        $request->session()->put('shipping_method', $shippingMethod);

        $shipping = $this->shippingMethods[$shippingMethod];
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

        \Log::info('Cart Items:', ['cartItems' => $cartItems, 'is_collection' => $cartItems instanceof \Illuminate\Database\Eloquent\Collection]);
        \Log::info('Cart Items Count:', ['count' => $cartItems instanceof \Illuminate\Database\Eloquent\Collection ? $cartItems->count() : count($cartItems)]);
        \Log::info('Empty Check:', ['is_empty' => empty($cartItems), 'is_collection_empty' => $cartItems instanceof \Illuminate\Database\Eloquent\Collection ? $cartItems->isEmpty() : empty($cartItems)]);
        $isCartEmpty = $cartItems instanceof \Illuminate\Database\Eloquent\Collection ? $cartItems->isEmpty() : empty($cartItems);
        if ($isCartEmpty) {
            \Log::info('Cart is empty, redirecting to cart page');
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add items to proceed to checkout.');
        }

        $total = $subtotal + $shipping + $tax;
        \Log::info('Shipping', [$shipping, $shippingMethod]);
        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'shippingMethod'));
    }

    public function placeOrder(Request $request)
{

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'shipping_method' => 'required|in:standard,express,pickup',
        'payment_method' => 'required|in:card,cash',
        'country' => 'required_if:shipping_method,standard,express|string|max:255|nullable',
        'street_adr' => 'required_if:shipping_method,standard,express|string|max:255|nullable',
        'city' => 'required_if:shipping_method,standard,express|string|max:255|nullable',
        'region' => 'required_if:shipping_method,standard,express|string|max:255|nullable',
        'postal_code' => 'required_if:shipping_method,standard,express|string|max:20|nullable',
    ]);


    $cartItems = [];
    if (Auth::check()) {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
    } else {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $cartItems[] = (object) [
                'product' => $product,
                'quantity' => $cart[$product->id],
            ];
        }
    }


    $isCartEmpty = $cartItems instanceof \Illuminate\Database\Eloquent\Collection ? $cartItems->isEmpty() : empty($cartItems);
    if ($isCartEmpty) {
        return redirect()->route('cart')->with('error', 'Your cart is empty. Add items to proceed to checkout.');
    }

    $shipAdrId = null;
    if ($request->shipping_method !== 'pickup') {
        $shippingAddress = ShippingAddress::create([
            'country' => $request->country,
            'street_adr' => $request->street_adr,
            'city' => $request->city,
            'region' => $request->region,
            'postal_code' => $request->postal_code,
        ]);
        $shipAdrId = $shippingAddress->id;
    }


    $order = Order::create([
        'user_id' => Auth::id(),
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'promocode_id' => null,
        'ship_adr_id' => $shipAdrId,
        'shipping_method' => $request->shipping_method,
        'payment_method' => $request->payment_method,
        'status' => 'pending',
    ]);

   
    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product->id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);
    }


    if (Auth::check()) {
        Cart::where('user_id', Auth::id())->delete();
    } else {
        session()->forget('cart');
    }

    $request->session()->forget('shipping_method');

    return redirect()->route('cart')->with('success', 'Order placed successfully!');
}

    
}