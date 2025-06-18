<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Filter by payment method
        if ($request->has('payment') && !empty($request->payment)) {
            $query->where('payment_method', $request->payment);
        }
        
        $orders = $query->paginate(15)->withQueryString();
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not typically needed for orders as they're created by users
        return redirect()->route('admin.orders.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Not typically needed for orders as they're created by users
        return redirect()->route('admin.orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
            return view('admin.orders.show', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error showing order: ' . $e->getMessage());
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            return view('admin.orders.edit', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error editing order: ' . $e->getMessage());
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,paid,processing,completed,cancelled,canceled'
            ]);
            
            $order = Order::findOrFail($id);
            $order->update([
                'status' => $request->status
            ]);
            
            Log::info("Order {$id} status updated to {$request->status} by admin " . auth()->id());
            
            return redirect()->route('admin.orders.show', $id)
                ->with('success', 'Order status updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating order: ' . $e->getMessage());
            return back()->with('error', 'Failed to update order status');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Only allow deletion of cancelled/canceled orders
            if (!in_array($order->status, ['cancelled', 'canceled'])) {
                return back()->with('error', 'Only cancelled orders can be deleted');
            }
            
            $order->delete();
            
            Log::info("Order {$id} deleted by admin " . auth()->id());
            
            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete order');
        }
    }
}
