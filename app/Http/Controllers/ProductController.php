<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\SearchableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use SearchableTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        // Basic query to get all products
        $query = Product::query();        // Log the count for debugging
        Log::info("Total products in database: " . Product::count());
        Log::info("Available products (true): " . Product::where('available', true)->count());
        Log::info("Available products (1): " . Product::where('available', 1)->count());
          // Check the exact available column value for the first few products
        $productSamples = Product::select('id', 'name', 'available')->take(5)->get();
        foreach ($productSamples as $product) {
            Log::info("Product {$product->id} ({$product->name}) availability: " . var_export($product->available, true));
        }
        
        // Filter for available products - this is working correctly as logs show
        $query->where('available', true);
        
        // Filter by category if specified
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }        // Search by name if specified
        if ($request->has('search') && !empty($request->search)) {
            $this->applySearchToQuery($query, $request->search, ['name', 'description']);
        }

        // Order by price or default to ordering by name
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('price', $request->sort);
        } else {
            $query->orderBy('name');
        }        // Get the products with pagination - increased to 24 per page
        $products = $query->paginate(24)->withQueryString();
        
        // Log the results for debugging
        Log::info("Products returned: " . $products->count() . " of " . $products->total());
        
        return view('products.index', compact('products'));
    }    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.show', compact('product'));
        } catch (\Exception $e) {
            Log::error("Error showing product: " . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'Product not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
