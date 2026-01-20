@extends('layouts.admin')

@section('content')
<main id="content" role="main" class="w-full  px-4 sm:px-6 md:px-8">
    
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Produits</h1>
            <p class="text-sm text-gray-600">Gérez votre inventaire : ajoutez, modifiez ou supprimez vos articles.</p>
        </div>
        <div class="flex gap-2">
            <button type="button" 
                    onclick="openCreateModal()"
                    class="inline-flex items-center gap-x-2 py-2.5 px-4 rounded-lg text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm"
                    aria-haspopup="dialog" 
                    aria-expanded="false" 
                    aria-controls="hs-danger-alert" 
                    data-hs-overlay="#hs-danger-alert">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Ajouter un produit
            </button>
        </div>
    </div>
    <div class="p-4 border-b border-gray-200 bg-white">
            <div class="flex flex-wrap items-left gap-4 justify-end">
                <div class="relative w-full sm:w-100">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                    <input id="productSearch" type="text" placeholder="Rechercher un produit..."  data-url="{{ route('admin.partials.index') }}"
                           class="py-3 pl-10 pr-4 block w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="relative inline-block text-left w-full sm:w-56">
                    <!-- Select -->
                    <select id="categoryFilter" data-url="{{ route('admin.partials.index') }}" data-hs-select='{
                        "placeholder": "Sélectionner...",
                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500",
                        "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 shadow-md",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100",
                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                    }' class="hidden">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->label }}</option>
                        @endforeach
                    </select>
                    <!-- End Select -->
                     <button type="button" 
                            onclick="resetCategoryFilter()" 
                            class="absolute top-1/2 end-8 -translate-y-1/2 text-gray-400 hover:text-red-500 z-20">
                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
        
     

        <div class="overflow-x-auto">
            <table id="productsTable" class="w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Désignation</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prix</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Catégorie</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="product-table-body" class="divide-y divide-gray-200 bg-white">
                    @foreach($products as $product)
                        @include('admin.partials.row', ['product' => $product])
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</main>

@include('admin.partials.form')

@endsection
