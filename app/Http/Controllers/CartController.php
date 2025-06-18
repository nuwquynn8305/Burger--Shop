<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // If cart is empty, we'll show popular products as recommendations
        $popularProducts = [];
        if (count($cart) === 0) {
            $popularProducts = \App\Models\Product::where('available', true)
                ->inRandomOrder()
                ->take(3)
                ->get();
        }
        
        return view('cart.index', compact('cart', 'total', 'popularProducts'));
    }
    
    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Check if the product is available
        if (!$product->available) {
            return redirect()->back()->with('error', 'This product is currently not available.');
        }
        
        $cart = session()->get('cart', []);
        
        // Check if product already exists in the cart
        if (isset($cart[$product->id])) {
            // Update quantity
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            // Add new item
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image_url,
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart!');
    }
    
    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Cart updated!');
    }
    
    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
    
    /**
     * Clear the cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }
    
    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (count($cart) === 0) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.checkout', compact('cart', 'total'));
    }
    
    /**
     * Get the cart item count for AJAX requests.
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'] ?? 1;
        }
        
        return response()->json(['count' => $count]);
    }
}
