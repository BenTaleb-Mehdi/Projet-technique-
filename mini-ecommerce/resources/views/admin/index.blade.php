@extends('layouts.admin')
@section('content')
    <main id="content" 
        role="main" 
        class="w-full px-4 sm:px-6 md:px-8" 
        data-url="{{ route('admin.index') }}"
        x-data="{
        currentUserId: {{ auth()->id() }}, 
    isAdmin: {{ auth()->user()->hasRole('admin') ? 'true' : 'false' }},
            ...productManager({ categories: {{ $categories->toJson() }} }),
         
        }">   
    @include('admin.partials.alert')
    @include('admin.partials.header')
    @include('admin.partials.table')
    @include('admin.partials.form')
    @include('admin.partials.delete-modal')

    </main>
@endsection