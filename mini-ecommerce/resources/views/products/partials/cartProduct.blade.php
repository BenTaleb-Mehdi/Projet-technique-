<div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 py-12 lg:py-24 mx-auto">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
    
    @foreach($products as $product)
    <div class="group flex flex-col">
      <div class="relative">
        <div class="aspect-4/4 overflow-hidden rounded-2xl">
          <img class="size-full object-cover rounded-2xl" 
               src="{{ asset($product->image_path ?? 'assets/img/pro/coffee-shop/img1.png') }}" 
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

      <div class="mb-2 mt-4 text-sm">
        <div class="flex flex-col">
          <div class="py-3 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-2">
              <div><span class="font-medium text-black">Tasting Notes:</span></div>
              <div class="text-end">
                <span class="text-black">{{ $product->tasting_notes }}</span>
              </div>
            </div>
          </div>

          <div class="py-3 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-2">
              <div><span class="font-medium text-black">Origin:</span></div>
              <div class="flex justify-end">
                <span class="text-black">{{ $product->origin }}</span>
              </div>
            </div>
          </div>

          <div class="py-3 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-2">
              <div><span class="font-medium text-black">Region:</span></div>
              <div class="text-end">
                <span class="text-black">{{ $product->region }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-auto">
        <a class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 transition" 
           href="{{ route('products.show', $product->id) }}">
          View details
        </a>
      </div>
    </div>
    @endforeach

  </div>
</div>