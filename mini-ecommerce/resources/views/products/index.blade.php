@extends('layouts.app')

@section('content')
<div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @foreach($products as $product)
        <div class="group flex flex-col h-full bg-white border border-gray-200 rounded-2xl p-4 transition-all hover:shadow-lg">
            
            <div class="relative aspect-square overflow-hidden rounded-xl">
                <img class="size-full object-cover transition-transform duration-500 group-hover:scale-105" 
                     src="{{ asset('images/' . $product->image_url) }}" 
                     alt="{{ $product->name }}">
            </div>

            <div class="pt-4 flex-grow">
                <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors">
                    {{ $product->name }}
                </h3>
                <p class="mt-1 text-gray-500 text-sm line-clamp-2">
                    {{ $product->description ?? 'No description available.' }}
                </p>
                <p class="mt-3 font-bold text-xl text-black">
                    ${{ number_format($product->price, 2) }}
                </p>
            </div>

            <div class="mt-5">
                <a href="{{ route('products.show', $product->id) }}" 
                   class="py-3 px-4 w-full inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-none focus:bg-yellow-500 transition-colors">
                    View Product
                </a>
            </div>
            
        </div>
        @endforeach

    </div>
</div>
@endsection