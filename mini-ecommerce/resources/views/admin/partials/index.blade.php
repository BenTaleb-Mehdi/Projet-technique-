@extends('layouts.admin')

@push('head-scripts')
<script>
    window.translations = {
        product_updated: "{{ __('actions.product_updated') }}",
        product_added: "{{ __('actions.product_added') }}",
        product_deleted: "{{ __('actions.product_deleted') }}",
        confirm_delete: "{{ __('actions.confirm_delete') }}",
        error_occurred: "{{ __('actions.error_occurred') }}",
        validation_error: "{{ __('actions.validation_error') }}",
        server_error: "{{ __('actions.server_error') }}",
        add: "{{ __('actions.add') }}",
        edit: "{{ __('actions.edit') }}",
    };
    
    window.adminConfig = {
        indexUrl: '{{ route('admin.partials.index') }}',
        initialProducts: {{ Js::from($products->items()) }},
        initialPagination: `{!! addslashes($products->links('vendor.pagination.custom')) !!}`
    };
</script>
@endpush

@section('content')
<main id="content" role="main" class="w-full  px-4 sm:px-6 md:px-8">
    
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('views.product_management') }}</h1>
            <p class="text-sm text-gray-600">{{ __('views.manage_inventory') }}</p>
        </div>
        <div class="flex gap-2">
            <button type="button" 
                    @click="openCreateModal()"
                    class="inline-flex items-center gap-x-2 py-2.5 px-4 rounded-lg text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                {{ __('actions.add_product') }}
            </button>
        </div>
    </div>
    <div class="p-4 border-b border-gray-200 bg-white">
            <div class="flex flex-wrap items-left gap-4 justify-end">
                <div class="relative w-full sm:w-100">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400" x-show="!isLoading"></i>
                        <div x-show="isLoading" x-cloak class="animate-spin rounded-full h-4 w-4 border-2 border-blue-500 border-t-transparent"></div>
                    </div>
                    <input id="productSearch" type="text" 
                           x-model.debounce.300ms="search"
                           placeholder="{{ __('views.search_product_placeholder') }}" 
                           class="py-3 pl-10 pr-4 block w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="relative inline-block text-left w-full sm:w-56">
                    <!-- Select -->
                    <select id="categoryFilter" 
                            x-model="category"
                            data-hs-select='{
                        "placeholder": "{{ __('views.select_placeholder') }}",
                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500",
                        "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 shadow-md",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100",
                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                    }' class="hidden">
                        <option value="">{{ __('views.all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->label }}</option>
                        @endforeach
                    </select>
                    <!-- End Select -->
                     <button type="button" 
                            @click="resetFilter()" 
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('models.image') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('models.designation') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('models.price') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('models.category') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('models.description') }}</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('views.actions') }}</th>
                    </tr>
                </thead>
                @include('admin.partials.row')
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end" 
             x-show="paginationHtml" 
             x-html="paginationHtml">
        </div>
    </div>


@include('admin.partials.form')

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto" 
     x-show="isDeleteModalOpen"
     x-cloak>
  
  <!-- Backdrop -->
  <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" 
       x-show="isDeleteModalOpen"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click="isDeleteModalOpen = false"></div>

  <!-- Modal Card -->
  <div class="relative bg-white border border-gray-200 shadow-xl rounded-xl overflow-hidden max-w-md w-full z-10 p-6 text-center"
       x-show="isDeleteModalOpen"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100 scale-100"
       x-transition:leave-end="opacity-0 scale-95">
       
       <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
           <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
       </div>

       <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('actions.confirm_delete') }}</h3>
       <p class="text-sm text-gray-500 mb-6">
           {{ __('views.delete_warning_message') ?? 'Are you sure you want to delete this product? This action cannot be undone.' }}
       </p>

       <div class="flex justify-center gap-3">
           <button type="button" 
                   @click="isDeleteModalOpen = false"
                   class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition-all">
               {{ __('actions.cancel') }}
           </button>
           <button type="button" 
                    @click="deleteProduct()"
                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 transition-all shadow-sm">
                {{ __('actions.delete') }}
            </button>
       </div>
    </div>
</div>
</main>

@endsection
