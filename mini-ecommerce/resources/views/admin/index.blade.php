@extends('layouts.admin')
@section('content')
    <main id="content" 
        role="main" 
        class="w-full px-4 sm:px-6 md:px-8" 
        data-url="{{ route('admin.partials.index') }}"
        x-data="productManager">   
    @include('admin.partials.alert')
    @include('admin.partials.header')
    @include('admin.partials.table')
    @include('admin.partials.form')
    @include('admin.partials.delete-modal')

    </main>
@endsection