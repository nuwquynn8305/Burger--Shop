<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $user = auth()->user();
        $cart = session()->get('cart', []);
        
        if (count($cart) === 0) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty!');
        }
        
        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);
        
        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        
        // Clear the cart
        session()->forget('cart');
        
        // If payment method is VNPAY, redirect to payment
        if ($request->payment_method === 'vnpay') {
            return redirect()->route('payment.process', $order->id);
        }
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $order = $user->orders()->with('orderItems.product')->findOrFail($id);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(string $id)
    {
        $user = auth()->user();
        $order = $user->orders()->findOrFail($id);
        
        // Only pending orders can be canceled
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be canceled!');
        }
        
        $order->status = 'canceled';
        $order->save();
        
        return redirect()->back()->with('success', 'Order canceled successfully!');
    }
}
