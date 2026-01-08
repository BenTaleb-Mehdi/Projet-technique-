@extends('layouts.admin')

@section('content')
<div class="flex flex-col w-full">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">price</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">description</th>
              <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
            </tr>
          </thead>
        @foreach($products as $product)
          <tbody class="divide-y divide-gray-200">
    

            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $product->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $product->price }} $</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $product->description }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                      <a href="{{ route('public.products.show', $product->id) }}">View</a>
              </td>
            </tr>
          </tbody>
        @endforeach
        </table>
      </div>
    </div>
  </div>
</div>
   

@endsection
