@foreach($products as $product)
    @include('admin.partials.row', ['product' => $product])
@endforeach
