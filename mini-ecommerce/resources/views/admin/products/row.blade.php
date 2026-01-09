<tr class="hover:bg-gray-50 transition">
  <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
    {{ $product->name }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
      {{ number_format($product->price, 2) }} $
    </span>
  </td>
  <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
    {{ $product->description }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
    <div class="flex justify-end gap-x-3">
      <a class="text-blue-600 hover:text-blue-800 font-semibold" href="{{ route('products.show', $product->id) }}">
        View
      </a>
      <button type="button" class="text-red-600 hover:text-red-800 font-semibold">
        Delete
      </button>
    </div>
  </td>
</tr>
