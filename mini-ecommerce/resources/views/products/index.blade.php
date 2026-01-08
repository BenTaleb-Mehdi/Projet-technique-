@extends('layouts.app')

@section('content')
<div class="min-w-full px-4 sm:px-6 lg:px-8 py-12 lg:py-24 mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
        
        @foreach($products as $product)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 lg:gap-12">            <div class="relative">
                <div class="aspect-4/4 overflow-hidden rounded-2xl">
                    <img class="size-full object-cover rounded-2xl transition-transform duration-500 group-hover:scale-105" 
                         src="{{ asset($product->image_path) }}" 
                         alt="{{ $product->name }}">
                </div>

                <div class="pt-4">
                    <h3 class="font-medium md:text-lg text-black">
                        {{ $product->name }}
                    </h3>

                    <p class="mt-2 font-semibold text-black">
                        ${{ number_format($product->price, 2) }}
                    </p>
                </div>

                <a class="after:absolute after:inset-0 after:z-1" href="{{ route('products.show', $product->id) }}"></a>
            </div>

          
       <div class="mt-auto">
        <a class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none" href="{{ route('products.show', $product->id) }}">
          Show
        </a>
      </div>
        </div>
        @endforeach

    </div>
    </div>
@endsection