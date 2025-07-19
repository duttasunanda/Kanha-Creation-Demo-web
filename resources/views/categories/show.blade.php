@extends('layouts.app')

@section('title', $category->name)
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Category: {{ $category->name }}</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white shadow rounded p-4">
                <a href="{{ route('products.show', $product->slug) }}">
                    <img src="{{ asset('images/products/' . ($product->images->first()->filename ?? 'placeholder.png')) }}" alt="{{ $product->name }}" class="h-40 w-full object-cover rounded mb-2">
                    <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                    <p class="text-blue-600">₹{{ number_format($product->price) }}</p>
                </a>
            </div>
        @empty
            <p class="text-gray-500">No products found in this category.</p>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
