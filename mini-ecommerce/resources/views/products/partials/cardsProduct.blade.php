<div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @foreach($products as $product)
        <div class="group flex flex-col h-full bg-white border border-gray-200 rounded-2xl p-4 transition-all hover:shadow-lg">
            
            <div class="relative aspect-[4/3] overflow-hidden rounded-xl">
                <img class="size-full object-cover transition-transform duration-500 group-hover:scale-105" 
                     src="{{ asset('images/' . $product->image_url) }}" 
                     alt="{{ $product->name }}">
            </div>

            <div class="pt-4 flex-grow flex flex-col">
                
                <div class="flex flex-wrap gap-2 mb-2">
                    @foreach($product->categories as $category)
                    <span class="text-[10px] font-bold uppercase tracking-widest text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                        {{ $category->label ?? 'General' }}
                    </span>
                    @endforeach
                </div>

                <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors leading-tight">
                    {{ $product->name }}
                </h3>

                <p class="mt-2 text-gray-500 text-sm line-clamp-2">
                    {{ $product->description ?? 'No description available.' }}
                </p>

                <div class="mt-auto pt-3">
                    <p class="font-bold text-xl text-black">
                        ${{ number_format($product->price, 2) }}
                    </p>
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('products.show', $product->id) }}" 
                   class="py-3 px-4 w-full inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:bg-blue-600 transition-all">
                    View Product
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
            
        </div>
        @endforeach
        

    </div>
     <div class="w-full px-4 sm:px-6 lg:px-8 mx-auto pb-12">
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>