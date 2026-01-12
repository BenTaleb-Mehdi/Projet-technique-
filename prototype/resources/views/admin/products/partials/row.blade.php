<tr>
    <td class="p-1 border border-gray-300">{{ $product->name }}</td>
    <td class="p-1 border border-gray-300"><img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" width="50"></td>
    <td class="p-1 border border-gray-300">${{ number_format($product->price, 2) }}</td>  
    <td class="p-1 border border-gray-300">
        @foreach($product->categories as $category)
            <span style="background: #eee; padding: 2px 5px; border-radius: 3px; font-size: 12px;">
                {{ $category->label }}
            </span>
        @endforeach
    </td>
    <td class="p-1 border border-gray-300">{{ $product->description }}</td>
</tr>

