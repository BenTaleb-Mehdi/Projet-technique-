@extends('layouts.app')

@section('content')
<div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-0 mx-auto">
    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-black inline-flex items-center gap-2">
            ← Back to products
        </a>
    </div>

    <div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-start">
        
        <div class="relative">
            <div class="aspect-[4/3] overflow-hidden rounded-3xl bg-gray-50 border border-gray-200 shadow-sm">
                <img class="size-full object-cover" 
                     src="{{ asset('images/' . $product->image_url) }}" 
                     alt="{{ $product->name }}">
            </div>
        </div>

        <div class="flex flex-col">
           <div class="flex flex-wrap gap-2 mb-2">
                    @foreach($product->categories as $category)
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gary-600 bg-blue-50 px-2 py-0.5 rounded-md">
                        {{ $category->label ?? 'General' }}
                    </span>
                    @endforeach
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl tracking-tight">
                {{ $product->name }}
            </h1>

            <div class="mt-4 flex items-center gap-x-3">
                <p class="text-3xl font-bold text-gray-900">
                    ${{ number_format($product->price, 2) }}
                </p>
            </div>

            <div class="mt-8 border-t border-gray-100 pt-8">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Description</h2>
                <p class="mt-4 text-gray-600 leading-relaxed text-lg">
                    {{ $product->description }}
                </p>
            </div>

        </div>

    </div>
</div>
@endsection