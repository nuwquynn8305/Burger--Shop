@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Our Products (Debug View)</h1>
    
    <div class="bg-yellow-100 p-4 mb-6 rounded-md">
        <h2 class="font-bold">Debug Info:</h2>
        <p>Total products: {{ $products->total() }}</p>
        <p>Current page: {{ $products->currentPage() }}</p>
        <p>Items per page: {{ $products->perPage() }}</p>
        <p>Items on this page: {{ $products->count() }}</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-2">{{ $product->category }}</p>
                    <p class="text-gray-800 font-bold">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500 text-xl">No products found.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
