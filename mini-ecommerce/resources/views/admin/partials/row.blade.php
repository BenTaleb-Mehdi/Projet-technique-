<tr class="hover:bg-gray-50 transition" id="row-{{ $product->id }}">
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
      @if($product->image_url)
        <img src="{{ asset('images/' . $product->image_url) }}" class="h-10 w-10 rounded-full object-cover" alt="{{ $product->name }}">
      @else
        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
            <i data-lucide="image" class="w-5 h-5"></i>
        </div>
      @endif
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
    {{ $product->name }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
      {{ number_format($product->price, 2) }} $
    </span>
  </td>
    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
    @foreach($product->categories as $category)
      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
        {{ $category->label }}
      </span>
    @endforeach
  </td>
  <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
    {{ $product->description }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
    <div class="flex justify-end gap-x-3">

      <button type="button" 
              onclick='editProduct(@json($product))'
              class="text-indigo-600 hover:text-indigo-900 font-semibold"
              data-hs-overlay="#hs-danger-alert">
      <i data-lucide="pencil" class="w-5"></i>  
      </button>
      <button type="button" 
              onclick="deleteProduct({{ $product->id }})"
              class="text-red-600 hover:text-red-800 font-semibold">
      <i data-lucide="octagon-x" class="w-5"></i>  
      </button>
    </div>
  </td>
</tr>
