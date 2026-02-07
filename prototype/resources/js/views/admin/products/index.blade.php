@extends('layouts.admin')

@section('content')

    <div class="w-full">
        @include('admin.products.partials.form')
        @include('admin.products.partials.table')
    </div>

@endsection