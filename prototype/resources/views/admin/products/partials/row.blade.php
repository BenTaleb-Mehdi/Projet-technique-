<tr>
  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $product->name }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${{ number_format($product->price, 2) }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
    @foreach($product->categories as $category)
        <span style="background: #eee; padding: 2px 5px; border-radius: 3px; font-size: 12px; m-2">
            {{ $category->label }}
        </span>
    @endforeach
</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $product->description }}</td>
</tr>
