@foreach($products as $product)
    @include('admin.partials.row', compact('product'))
@endforeach
