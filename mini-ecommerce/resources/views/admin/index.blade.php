@extends('layouts.admin')

<script>
    window.adminConfig = {
        indexUrl: '{{ route('admin.index') }}',
        initialProducts: @json($products->items()),
        initialPagination: `{!! $products->links('vendor.pagination.custom') !!}`
    };
</script>

@section('content')
<main id="content" role="main" class="w-full  px-4 sm:px-6 md:px-8" x-data="productManager()">
    
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
        @include('admin.partials._filters')
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
@include('admin.partials.delete-modal')



</main>

@endsection
