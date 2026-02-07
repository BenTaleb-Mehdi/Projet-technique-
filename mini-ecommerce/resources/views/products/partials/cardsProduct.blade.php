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
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gary-600 bg-blue-50 px-2 py-0.5 rounded-md">
                   {{ $category->label ?? __('views.general_category') }}
                </span>
                    @endforeach
                </div>

                <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors leading-tight mb-2">
                   <a href="{{ route('products.show', $product->id) }}"> {{ $product->name }}</a>
                </h3>

                <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                    {{ $product->description ?? __('views.no_description') }}
                </p>

                <div class="mt-auto pt-3">
                    <p class="font-bold text-xl text-black">
                        ${{ number_format($product->price, 2) }}
                    </p>
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('products.show', $product->id) }}" class="flex-1 bg-blue-600 text-white text-xs font-bold uppercase tracking-widest py-3 px-4 rounded-md hover:bg-blue-700 transition-colors text-center flex items-center justify-center gap-2">
                {{ __('actions.view_product') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            </div>
            
        </div>
        @endforeach
        

    </div>
     <div class="w-full px-4 sm:px-6 lg:px-8 mx-auto pb-12">
        <div class="mt-8">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>