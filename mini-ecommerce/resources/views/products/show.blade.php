@extends('layouts.app')

@section('content')
<div class="min-w-full px-4 sm:px-10 lg:px-16 py-12 mx-auto">
  
  <div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-start">
    
    <div class="relative">
      <div class="aspect-square overflow-hidden rounded-3xl bg-gray-100 border border-gray-200">
        <img class="size-full object-cover" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
      </div>

    </div>
    <div class="flex flex-col h-full">


        <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl">
          {{ $product->name }}
        </h1>

        <div class="mt-4 flex items-center gap-x-3">
          <p class="text-2xl font-bold text-gray-800">
            ${{ number_format($product->price, 2) }}
          </p>
   
        </div>

        <div class="mt-6">
          <h2 class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Description</h2>
          <p class="mt-2 text-gray-600 leading-relaxed">
            {{ $product->description }}
          </p>
        </div>

      </div>

    </div>
    </div>
</div>
@endsection