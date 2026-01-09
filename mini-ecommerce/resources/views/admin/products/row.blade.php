<tr class="hover:bg-gray-50 transition" id="row-{{ $product->id }}">
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
      <img src="{{ asset('images/' . $product->image_url) }}" class="h-10 w-10 rounded-full object-cover" alt="">
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
    {{ $product->category_label }}
  </td>
  <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
    {{ $product->description }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
    <div class="flex justify-end gap-x-3">
      <a class="text-blue-600 hover:text-blue-800 font-semibold" href="{{ route('products.show', $product->id) }}">
        View
      </a>
      <button type="button" 
              onclick='editProduct(@json($product))'
              class="text-indigo-600 hover:text-indigo-900 font-semibold"
              data-hs-overlay="#hs-danger-alert">
        Edit
      </button>
      <button type="button" class="text-red-600 hover:text-red-800 font-semibold">
        Delete
      </button>
    </div>
  </td>
</tr>
